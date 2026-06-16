<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Super Admin (Check if already exists)
        if (!User::where('email', 'superadmin@vdms.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@vdms.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'branch_id' => null,
                'phone' => '0300-0000000',
                'is_active' => true,
            ]);
        }

        $branches = Branch::all();

        foreach ($branches as $branch) {
            // Branch Manager
            $managerEmail = strtolower(str_replace(' ', '', $branch->name)) . '.manager@vdms.com';
            if (!User::where('email', $managerEmail)->exists()) {
                User::create([
                    'name' => $branch->name . ' Manager',
                    'email' => $managerEmail,
                    'password' => Hash::make('password'),
                    'role' => 'branch_manager',
                    'branch_id' => $branch->id,
                    'phone' => '0300-1111111',
                    'is_active' => true,
                ]);
            }

            // Sales Staff
            $salesEmail = strtolower(str_replace(' ', '', $branch->name)) . '.sales@vdms.com';
            if (!User::where('email', $salesEmail)->exists()) {
                User::create([
                    'name' => $branch->name . ' Sales',
                    'email' => $salesEmail,
                    'password' => Hash::make('password'),
                    'role' => 'sales_staff',
                    'branch_id' => $branch->id,
                    'phone' => '0300-2222222',
                    'is_active' => true,
                ]);
            }

            // Accountant
            $accountEmail = strtolower(str_replace(' ', '', $branch->name)) . '.account@vdms.com';
            if (!User::where('email', $accountEmail)->exists()) {
                User::create([
                    'name' => $branch->name . ' Accountant',
                    'email' => $accountEmail,
                    'password' => Hash::make('password'),
                    'role' => 'accountant',
                    'branch_id' => $branch->id,
                    'phone' => '0300-3333333',
                    'is_active' => true,
                ]);
            }
        }
    }
}