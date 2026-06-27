<?php

namespace App\Enums;

enum Role: string
{
    case CHAIRWOMAN     = 'chairwoman';
    case SUPERADMIN     = 'superadmin';
    case HO_ADMIN       = 'ho_admin';
    case BRANCH_MANAGER = 'branch_manager';
    case SALES_STAFF    = 'sales_staff';
    case ACCOUNTANT     = 'accountant';

    public function label(): string
    {
        return match($this) {
            Role::CHAIRWOMAN     => 'Chairwoman',
            Role::SUPERADMIN     => 'Super Admin',
            Role::HO_ADMIN       => 'HO Admin',
            Role::BRANCH_MANAGER => 'Branch Manager',
            Role::SALES_STAFF    => 'Sales Staff',
            Role::ACCOUNTANT     => 'Accountant',
        };
    }
}