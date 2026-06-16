<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BranchAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $vehicle = $request->route('vehicle'); // for resource routes

        if ($vehicle && !$user->canAccessBranch($vehicle->branch_id)) {
            abort(403, 'You cannot access this vehicle from another branch.');
        }

        return $next($request);
    }
}