<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SaleObserver
{
    public function created(Sale $sale)
    {
        $this->log($sale, 'create', null, $sale->toArray());
    }

    public function updated(Sale $sale)
    {
        $this->log($sale, 'update', $sale->getOriginal(), $sale->getChanges());
    }

    public function deleted(Sale $sale)
    {
        $this->log($sale, 'delete', $sale->toArray(), null);
    }

    private function log(Sale $sale, string $action, $old, $new)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'branch_id'    => $sale->branch_id,
            'action'       => $action,
            'model_type'   => 'Sale',
            'model_id'     => $sale->id,
            'old_values'   => $old ? json_encode($old) : null,
            'new_values'   => $new ? json_encode($new) : null,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::header('User-Agent'),
            'performed_at' => now(),
        ]);
    }
}