<?php

namespace App\Jobs;

use App\Services\SyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSyncQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(SyncService $syncService)
    {
        $syncService->processPendingSyncs();
        
        // Log for monitoring
        \Illuminate\Support\Facades\Log::info('Sync Queue Processed at ' . now());
    }
}