<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            [
                'name' => 'Lahore Branch',
                'city' => 'Lahore',
                'state_province' => 'Punjab',
                'country' => 'Pakistan',
                'currency' => 'PKR',
                'exchange_rate' => 1.00,
                'address' => '123 Main Road, Lahore',
                'phone' => '042-12345678',
                'email' => 'lahore@vdms.com',
                'is_active' => true,
            ],
            [
                'name' => 'Islamabad Branch',
                'city' => 'Islamabad',
                'state_province' => 'ICT',
                'country' => 'Pakistan',
                'currency' => 'PKR',
                'exchange_rate' => 1.00,
                'address' => 'Blue Area, Islamabad',
                'phone' => '051-1234567',
                'email' => 'islamabad@vdms.com',
                'is_active' => true,
            ],
            [
                'name' => 'Multan Branch',
                'city' => 'Multan',
                'state_province' => 'Punjab',
                'country' => 'Pakistan',
                'currency' => 'PKR',
                'exchange_rate' => 1.00,
                'address' => 'Boson Road, Multan',
                'phone' => '061-1234567',
                'email' => 'multan@vdms.com',
                'is_active' => true,
            ],
            [
                'name' => 'Karachi Branch',
                'city' => 'Karachi',
                'state_province' => 'Sindh',
                'country' => 'Pakistan',
                'currency' => 'PKR',
                'exchange_rate' => 1.00,
                'address' => 'Clifton, Karachi',
                'phone' => '021-12345678',
                'email' => 'karachi@vdms.com',
                'is_active' => true,
            ],
            [
                'name' => 'Abbottabad Branch',
                'city' => 'Abbottabad',
                'state_province' => 'KPK',
                'country' => 'Pakistan',
                'currency' => 'PKR',
                'exchange_rate' => 1.00,
                'address' => 'Main Bazaar, Abbottabad',
                'phone' => '0992-123456',
                'email' => 'abbottabad@vdms.com',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(
                ['city' => $branch['city']],
                $branch
            );
        }
    }
}