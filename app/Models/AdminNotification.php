<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $table = 'admin_notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'icon',
        'color',
        'entity_type',
        'entity_id',
        'entity_ref',
        'is_read',
        'read_at',
        'last_reminded_at',
        'reminder_count',
    ];

    protected $casts = [
        'is_read'          => 'boolean',
        'read_at'          => 'datetime',
        'last_reminded_at' => 'datetime',
    ];

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRecent($query)
    {
        return $query->latest()->take(20);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Vérifier si une notification du même type+entité existe déjà
     * et n'a pas encore été rappelée depuis 24h.
     */
    public static function shouldNotify(string $type, ?string $entityType, ?int $entityId): bool
    {
        $existing = static::where('type', $type)
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('is_read', false)
            ->latest()
            ->first();

        if (!$existing) {
            return true; // pas encore de notification → on crée
        }

        // Si déjà notifié, on vérifie si 24h se sont écoulées depuis le dernier rappel
        $lastRemind = $existing->last_reminded_at ?? $existing->created_at;

        return $lastRemind->diffInHours(now()) >= 24;
    }

    /**
     * Mettre à jour le compteur de rappel sur la notification existante
     * (au lieu d'en créer une nouvelle).
     */
    public static function remind(string $type, ?string $entityType, ?int $entityId): void
    {
        static::where('type', $type)
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('is_read', false)
            ->update([
                'last_reminded_at' => now(),
                'reminder_count'   => \DB::raw('reminder_count + 1'),
            ]);
    }

    /**
     * Marquer comme lue.
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Icônes et couleurs par type.
     */
    public static function typeConfig(string $type): array
    {
        return match($type) {
            'new_order'         => ['icon' => 'ti-shopping-cart',    'color' => 'primary'],
            'processing_order'  => ['icon' => 'ti-clock',            'color' => 'info'],
            'cancelled_paid'    => ['icon' => 'ti-alert-triangle',   'color' => 'danger'],
            'low_stock'         => ['icon' => 'ti-package',          'color' => 'warning'],
            'out_of_stock'      => ['icon' => 'ti-box-off',          'color' => 'danger'],
            'new_review'        => ['icon' => 'ti-star',             'color' => 'success'],
            'revenue_milestone' => ['icon' => 'ti-trending-up',      'color' => 'success'],
            default             => ['icon' => 'ti-bell',             'color' => 'primary'],
        };
    }
}