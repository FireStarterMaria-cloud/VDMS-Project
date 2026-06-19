<?php

namespace App\Console\Commands;

use App\Services\SyncService;
use Illuminate\Console\Command;

class SyncDataCommand extends Command
{
    protected $signature = 'sync:data {--force}';
    protected $description = 'Process pending offline sync queue';

    public function handle(SyncService $syncService)
    {
        $this->info('Starting Sync Process...');

        $count = \App\Models\SyncQueue::where('status', 'pending')->count();
        $this->info("Found {$count} pending records to sync.");

        $syncService->processPendingSyncs();

        $this->info('✅ Sync completed successfully!');
    }
}