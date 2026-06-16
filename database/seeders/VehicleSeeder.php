<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $branches = Branch::all();
        $models   = ['Corolla', 'Yaris', 'Fortuner', 'Hilux', 'Camry', 'Land Cruiser', 'Reborn'];
        $colours  = ['White', 'Black', 'Silver', 'Blue', 'Red'];
        $i = 0;

        foreach ($branches as $branch) {
            for ($j = 0; $j < 2; $j++) {
                $modelName = $models[array_rand($models)];

                Vehicle::create([
                    'branch_id'           => $branch->id,
                    'make'                => 'Toyota',
                    'model'               => $modelName,
                    'year'                => rand(2020, 2025),
                    'registration_number' => 'ABC-' . rand(1000, 9999),
                    'vin_number'          => 'VIN' . rand(100000, 999999),
                    'colour'              => $colours[array_rand($colours)],
                    'variant'             => rand(0, 1) ? 'GLi' : 'XLi',
                    'transmission'        => rand(0, 1) ? 'automatic' : 'manual',
                    'fuel_type'           => 'petrol',
                    'engine_capacity'     => '1300cc',
                    'mileage'             => rand(500, 45000),
                    'purchase_price'      => rand(4500000, 8500000),
                    'selling_price'       => rand(4800000, 9200000),
                    'condition'           => rand(0, 1) ? 'new' : 'used',
                    'status'              => rand(0, 1) ? 'available' : 'reserved',
                    'notes'               => 'Well maintained ' . $modelName . ' in excellent condition.',
                ]);

                $i++;
                if ($i >= 10) break 2;
            }
        }
    }
}