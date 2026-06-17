<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Vehicle::all();
        $branches = Branch::all();
        $user = User::first();

        $methods = ['cash', 'cheque', 'bank_transfer'];

        foreach ($vehicles->take(8) as $index => $vehicle) {
            $branch = $branches[$index % $branches->count()];
            Purchase::create([
                'vehicle_id'       => $vehicle->id,
                'branch_id'        => $branch->id,
                'purchased_by'     => $user->id,
                'supplier_name'    => 'Supplier ' . ($index + 1),
                'supplier_contact' => '0300-' . rand(1000000, 9999999),
                'purchase_price'   => rand(3000000, 7000000),
                'payment_method'   => $methods[$index % 3],
                'reference_no'     => 'REF-' . rand(1000, 9999),
                'purchase_date'    => now()->subDays(rand(1, 90))->format('Y-m-d'),
                'notes'            => 'Vehicle purchased from dealer ' . ($index + 1),
            ]);
        }
    }
}