<?php

namespace App\Enums;

enum Role: string
{
    case SUPERADMIN     = 'superadmin';
    case HO_ADMIN       = 'ho_admin';
    case BRANCH_MANAGER = 'branch_manager';
    case SALES_STAFF    = 'sales_staff';
    case ACCOUNTANT     = 'accountant';

    public function label(): string
    {
        return match($this) {
            self::SUPERADMIN     => 'Super Admin',
            self::HO_ADMIN       => 'Head Office Admin',
            self::BRANCH_MANAGER => 'Branch Manager',
            self::SALES_STAFF    => 'Sales Staff',
            self::ACCOUNTANT     => 'Accountant',
        };
    }

    public function isAdmin(): bool
    {
        return in_array($this, [self::SUPERADMIN, self::HO_ADMIN]);
    }
}