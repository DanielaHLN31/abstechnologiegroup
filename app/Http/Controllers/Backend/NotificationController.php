<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Jobs\DeleteReadNotifications;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Retourne les notifications non lues (pour le badge + dropdown)
     */
    public function index()
    {
        $notifications = AdminNotification::unread()
            ->latest()
            ->take(20)
            ->get()
            ->map(fn($n) => $this->format($n));

        $count = AdminNotification::unread()->count();

        return response()->json([
            'count'         => $count,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Marque une notification comme lue puis dispatch le job de suppression (délai 1 min)
     */
    public function markRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->markAsRead();

        // Suppression en arrière-plan après 1 minute
        DeleteReadNotifications::dispatch()->delay(now()->addMinute());

        return response()->json(['success' => true]);
    }

    /**
     * Marque toutes comme lues puis dispatch le job de suppression (délai 1 min)
     */
    public function markAllRead()
    {
        AdminNotification::unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        // Suppression en arrière-plan après 1 minute
        DeleteReadNotifications::dispatch()->delay(now()->addMinute());

        return response()->json(['success' => true]);
    }

    /**
     * GET /admin/notifications/count
     * Retourne uniquement le nombre (pour le polling léger)
     */
    public function count()
    {
        return response()->json([
            'count' => AdminNotification::unread()->count(),
        ]);
    }

    // ─── Format ───────────────────────────────────────────────────────────────

    private function format(AdminNotification $n): array
    {
        // Déterminer l'URL de redirection selon l'entité
        $url = match($n->entity_type) {
            'order'   => $n->entity_ref
                            ? route('commandes.show', $n->entity_ref)
                            : route('commandes.index'),
            'product' => $n->entity_id
                            ? route('all.products') // ajuster si vous avez une page détail
                            : route('all.products'),
            default   => '#',
        };

        return [
            'id'             => $n->id,
            'type'           => $n->type,
            'title'          => $n->title,
            'message'        => $n->message,
            'icon'           => $n->icon,
            'color'          => $n->color,
            'entity_type'    => $n->entity_type,
            'entity_id'      => $n->entity_id,
            'entity_ref'     => $n->entity_ref,
            'reminder_count' => $n->reminder_count,
            'url'            => $url,
            'time_ago'       => $n->created_at->diffForHumans(),
            'created_at'     => $n->created_at->format('d/m/Y à H:i'),
        ];
    }
}