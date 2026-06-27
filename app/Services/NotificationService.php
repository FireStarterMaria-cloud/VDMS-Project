<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Branch;
use App\Enums\Role;

class NotificationService
{
    // Vehicle sold notification
    public static function vehicleSold($vehicle)
    {
        // Notify HO admins + showroom superadmin
        $users = User::where(function($q) use ($vehicle) {
            $q->whereIn('role', ['chairwoman', 'ho_admin'])
              ->orWhere(function($q2) use ($vehicle) {
                  $q2->where('role', 'superadmin')
                     ->where('showroom_id', $vehicle->branch->showroom_id ?? null);
              });
        })->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Vehicle Sold',
                'message' => "{$vehicle->make} {$vehicle->model} ({$vehicle->registration_number}) has been sold from {$vehicle->branch->city} branch.",
                'type'    => 'sold',
                'url'     => "/vehicles/{$vehicle->id}",
                'is_read' => false,
            ]);
        }
    }

    // Low stock notification
    public static function checkLowStock($branchId)
    {
        $branch = Branch::withCount(['vehicles as available_count' => function($q) {
            $q->where('status', 'available');
        }])->find($branchId);

        if (!$branch || $branch->available_count > 3) return;

        $users = User::where(function($q) use ($branch) {
            $q->whereIn('role', ['chairwoman', 'ho_admin'])
              ->orWhere(function($q2) use ($branch) {
                  $q2->where('role', 'superadmin')
                     ->where('showroom_id', $branch->showroom_id ?? null);
              })
              ->orWhere(function($q3) use ($branch) {
                  $q3->where('role', 'branch_manager')
                     ->where('branch_id', $branch->id);
              });
        })->get();

        foreach ($users as $user) {
            // Avoid duplicate notifications
            $exists = Notification::where('user_id', $user->id)
                ->where('type', 'low_stock')
                ->where('message', 'like', "%{$branch->city}%")
                ->where('is_read', false)
                ->exists();

            if (!$exists) {
                Notification::create([
                    'user_id' => $user->id,
                    'title'   => 'Low Stock Alert',
                    'message' => "{$branch->city} branch has only {$branch->available_count} vehicle(s) available. Please restock soon.",
                    'type'    => 'low_stock',
                    'url'     => "/vehicles?branch_id={$branch->id}&status=available",
                    'is_read' => false,
                ]);
            }
        }
    }
}