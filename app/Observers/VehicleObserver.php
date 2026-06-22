<?php

namespace App\Observers;

use App\Models\Vehicle;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class VehicleObserver
{
    public function created(Vehicle $vehicle)
    {
        $this->log($vehicle, 'create', null, $vehicle->toArray());
    }

    public function updated(Vehicle $vehicle)
    {
        $this->log($vehicle, 'update', $vehicle->getOriginal(), $vehicle->getChanges());
    }

    public function deleted(Vehicle $vehicle)
    {
        $this->log($vehicle, 'delete', $vehicle->toArray(), null);
    }

    private function log(Vehicle $vehicle, string $action, $old, $new)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'branch_id'    => $vehicle->branch_id,
            'action'       => $action,
            'model_type'   => 'Vehicle',
            'model_id'     => $vehicle->id,
            'old_values'   => $old ? json_encode($old) : null,
            'new_values'   => $new ? json_encode($new) : null,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::header('User-Agent'),
            'performed_at' => now(),
        ]);
    }
}