<?php

namespace Database\Seeders;

use App\Models\BranchTransfer;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;

class BranchTransferSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Vehicle::take(4)->get();
        $branches = Branch::all();
        $user = User::first();
        $statuses = ['pending', 'approved', 'rejected', 'pending'];

        foreach ($vehicles as $index => $vehicle) {
            $fromBranch = $branches[$index % $branches->count()];
            $toBranch   = $branches[($index + 1) % $branches->count()];

            BranchTransfer::create([
                'vehicle_id'     => $vehicle->id,
                'from_branch_id' => $fromBranch->id,
                'to_branch_id'   => $toBranch->id,
                'requested_by'   => $user->id,
                'approved_by'    => $statuses[$index] == 'approved' ? $user->id : null,
                'status'         => $statuses[$index],
                'reason'         => 'Transfer needed for branch demand - ' . $toBranch->city,
                'requested_date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'approved_date'  => $statuses[$index] == 'approved' ? now()->subDays(rand(1, 10))->format('Y-m-d') : null,
            ]);
        }
    }
}