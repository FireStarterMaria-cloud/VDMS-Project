<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $branches = Branch::all();

        $customers = [
            ['name' => 'Ahmed Ali', 'cnic' => '35201-1234567-1', 'phone' => '0300-1234567', 'email' => 'ahmed@test.com', 'city' => 'Lahore'],
            ['name' => 'Sara Khan', 'cnic' => '35202-2345678-2', 'phone' => '0301-2345678', 'email' => 'sara@test.com', 'city' => 'Islamabad'],
            ['name' => 'Usman Malik', 'cnic' => '35203-3456789-3', 'phone' => '0302-3456789', 'email' => 'usman@test.com', 'city' => 'Multan'],
            ['name' => 'Fatima Riaz', 'cnic' => '35204-4567890-4', 'phone' => '0303-4567890', 'email' => 'fatima@test.com', 'city' => 'Karachi'],
            ['name' => 'Bilal Hassan', 'cnic' => '35205-5678901-5', 'phone' => '0304-5678901', 'email' => 'bilal@test.com', 'city' => 'Abbottabad'],
            ['name' => 'Ayesha Siddiqui', 'cnic' => '35206-6789012-6', 'phone' => '0305-6789012', 'email' => 'ayesha@test.com', 'city' => 'Lahore'],
            ['name' => 'Zain Abbas', 'cnic' => '35207-7890123-7', 'phone' => '0306-7890123', 'email' => 'zain@test.com', 'city' => 'Islamabad'],
            ['name' => 'Nadia Iqbal', 'cnic' => '35208-8901234-8', 'phone' => '0307-8901234', 'email' => 'nadia@test.com', 'city' => 'Multan'],
            ['name' => 'Tariq Mehmood', 'cnic' => '35209-9012345-9', 'phone' => '0308-9012345', 'email' => 'tariq@test.com', 'city' => 'Karachi'],
            ['name' => 'Hina Baig', 'cnic' => '35210-0123456-0', 'phone' => '0309-0123456', 'email' => 'hina@test.com', 'city' => 'Abbottabad'],
        ];

        foreach ($customers as $index => $customer) {
            $branch = $branches[$index % $branches->count()];
            Customer::firstOrCreate(
                ['cnic' => $customer['cnic']],
                array_merge($customer, [
                    'branch_id' => $branch->id,
                    'country'   => 'Pakistan',
                    'address'   => 'House ' . rand(1, 999) . ', ' . $customer['city'],
                ])
            );
        }
    }
}