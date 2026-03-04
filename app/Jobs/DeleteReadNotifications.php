<?php

namespace App\Jobs;

use App\Models\AdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteReadNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Nombre de tentatives max si le job échoue.
     */
    public int $tries = 3;

    /**
     * Timeout en secondes.
     */
    public int $timeout = 30;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        // Supprimer les notifications marquées comme lues
        // depuis au moins 1 minute
        $deleted = AdminNotification::where('is_read', true)
            ->where('read_at', '<=', now()->subMinute())
            ->delete();

        if ($deleted > 0) {
            Log::info("[DeleteReadNotifications] {$deleted} notification(s) supprimée(s).");
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error('[DeleteReadNotifications] Job échoué : ' . $e->getMessage());
    }
}