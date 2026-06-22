<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CustomerObserver
{
    public function created(Customer $customer)
    {
        $this->log($customer, 'create', null, $customer->toArray());
    }

    public function updated(Customer $customer)
    {
        $this->log($customer, 'update', $customer->getOriginal(), $customer->getChanges());
    }

    public function deleted(Customer $customer)
    {
        $this->log($customer, 'delete', $customer->toArray(), null);
    }

    private function log(Customer $customer, string $action, $old, $new)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'branch_id'    => $customer->branch_id,
            'action'       => $action,
            'model_type'   => 'Customer',
            'model_id'     => $customer->id,
            'old_values'   => $old ? json_encode($old) : null,
            'new_values'   => $new ? json_encode($new) : null,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::header('User-Agent'),
            'performed_at' => now(),
        ]);
    }
}