<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) abort(403);
        $logs = AuditLog::with(['user', 'branch'])->latest()->paginate(20);
        return view('audit-logs.index', compact('logs'));
    }
}