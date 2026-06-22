<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Access Denied');
        }

        $logs = AuditLog::with(['user', 'branch'])
                    ->latest('id')
                    ->paginate(20);

        return view('audit-logs.index', compact('logs'));
    }
}