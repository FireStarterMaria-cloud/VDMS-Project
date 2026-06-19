<?php

namespace App\Services;

use App\Models\SyncQueue;
use Illuminate\Support\Facades\Log;

class SyncService
{
    public function addToQueue(string $modelType, $modelId, string $operation, array $payload, int $branchId, int $userId)
    {
        return SyncQueue::create([
            'branch_id'   => $branchId,
            'user_id'     => $userId,
            'model_type'  => $modelType,
            'model_id'    => $modelId,
            'operation'   => $operation,
            'payload'     => json_encode($payload),
            'status'      => 'pending',
            'retry_count' => 0,
        ]);
    }

    public function processPendingSyncs()
    {
        $pending = SyncQueue::where('status', 'pending')
                    ->where('retry_count', '<', 5)
                    ->orderBy('created_at')
                    ->get();

        Log::info("Sync Queue: Found " . $pending->count() . " pending records.");

        foreach ($pending as $item) {
            try {
                $this->processSingleSync($item);
                
                $item->update([
                    'status' => 'synced',
                    'synced_at' => now()
                ]);
                
            } catch (\Exception $e) {
                $item->increment('retry_count');
                $item->update([
                    'status' => $item->retry_count >= 4 ? 'failed' : 'pending',
                    'conflict_note' => substr($e->getMessage(), 0, 255)
                ]);
                Log::error("Sync Failed ID {$item->id}: " . $e->getMessage());
            }
        }

        Log::info('Sync Queue Processing Completed.');
    }

    protected function processSingleSync(SyncQueue $sync)
    {
        $payload = json_decode($sync->payload, true);
        $modelClass = $sync->model_type;

        switch ($sync->operation) {
            case 'create':
                $modelClass::create($payload);
                break;

            case 'update':
                $model = $modelClass::findOrFail($sync->model_id);
                $model->update($payload);
                break;

            case 'delete':
                $modelClass::destroy($sync->model_id);
                break;
        }
    }
}