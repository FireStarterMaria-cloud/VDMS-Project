<?php

namespace App\Traits;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

trait ShowroomScoped
{
    protected function getBranches()
    {
        $user = Auth::user();
        $query = Branch::where('is_active', true);

        if ($user->isChairwoman()) {
            // sab branches
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $query->where('showroom_id', $user->showroom_id);
        } else {
            $query->where('id', $user->branch_id);
        }

        return $query->get();
    }

    protected function applyShowroomScope($query, string $relation = 'branch')
    {
        $user = Auth::user();

        if ($user->isChairwoman()) {
            // sab data
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $query->whereHas($relation, function($q) use ($user) {
                $q->where('showroom_id', $user->showroom_id);
            });
        } else {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    protected function applyBranchScope($query)
    {
        $user = Auth::user();

        if ($user->isChairwoman()) {
            // sab
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $query->whereHas('showroom', function($q) use ($user) {
                $q->where('id', $user->showroom_id);
            })->orWhere('showroom_id', $user->showroom_id);
        } else {
            $query->where('id', $user->branch_id);
        }

        return $query;
    }
}