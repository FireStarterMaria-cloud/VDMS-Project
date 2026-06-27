<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showroom;
use App\Models\Branch;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Support\Facades\Hash;

class ShowroomSeeder extends Seeder
{
    public function run(): void
    {
        // Chairwoman
        $chairwoman = User::updateOrCreate(
            ['email' => 'chairwoman@velora.com'],
            [
                'name'     => 'Chairwoman',
                'password' => Hash::make('password'),
                'role' => Role::CHAIRWOMAN,
                'is_active'=> true,
            ]
        );

        // Showroom 1
        $showroom1 = Showroom::create([
            'name'    => 'Toyota Lahore Motors',
            'city'    => 'Lahore',
            'email'   => 'lahore@toyota.com',
            'phone'   => '042-1234567',
            'is_active' => true,
        ]);

        // Superadmin 1
        $admin1 = User::updateOrCreate(
            ['email' => 'superadmin1@velora.com'],
            [
                'name'        => 'Showroom 1 Admin',
                'password'    => Hash::make('password'),
              'role' => Role::SUPERADMIN,
                'showroom_id' => $showroom1->id,
                'is_active'   => true,
            ]
        );

        // Branches for Showroom 1
        Branch::whereIn('city', ['Lahore', 'Islamabad', 'Multan'])
            ->update(['showroom_id' => $showroom1->id]);

        // Showroom 2
        $showroom2 = Showroom::create([
            'name'    => 'Toyota Karachi Motors',
            'city'    => 'Karachi',
            'email'   => 'karachi@toyota.com',
            'phone'   => '021-1234567',
            'is_active' => true,
        ]);

        // Superadmin 2
        $admin2 = User::updateOrCreate(
            ['email' => 'superadmin2@velora.com'],
            [
                'name'        => 'Showroom 2 Admin',
                'password'    => Hash::make('password'),
               'role' => Role::SUPERADMIN,
                'showroom_id' => $showroom2->id,
                'is_active'   => true,
            ]
        );

        // Branches for Showroom 2
        Branch::whereIn('city', ['Karachi', 'Abbottabad'])
            ->update(['showroom_id' => $showroom2->id]);
    }
}