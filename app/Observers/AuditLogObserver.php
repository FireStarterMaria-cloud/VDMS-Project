<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogObserver
{
    public function created($model)
    {
        $this->logActivity($model, 'created');
    }

    public function updated($model)
    {
        $this->logActivity($model, 'updated');
    }

    public function deleted($model)
    {
        $this->logActivity($model, 'deleted');
    }

    private function logActivity($model, string $action)
    {
        try {
            $user = Auth::user();

            AuditLog::create([
                'user_id'     => $user?->id,
                'branch_id'   => $user?->branch_id,
                'model_type'  => get_class($model),
                'model_id'    => $model->id,
                'action'      => $action,
                'new_values'  => $action !== 'deleted' ? $model->toArray() : null,
                'ip_address'  => request()->ip() ?? '127.0.0.1',
                'user_agent'  => request()->userAgent() ?? 'System',
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Audit Log Error: " . $e->getMessage());
        }
    }
}