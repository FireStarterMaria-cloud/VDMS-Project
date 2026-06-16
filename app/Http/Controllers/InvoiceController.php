<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Invoice::with(['sale', 'branch', 'generatedBy']);

        if (!$user->isHO()) {
            $query->where('branch_id', $user->branch_id);
        }

        $invoices = $query->latest()->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isBranchManager()) abort(403);
        $sales = Sale::with('customer')->get();
        $branches = Branch::all();
        return view('invoices.create', compact('sales', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isBranchManager()) abort(403);

        $validated = $request->validate([
            'sale_id'      => 'required|exists:sales,id',
            'branch_id'    => 'required|exists:branches,id',
            'invoice_no'   => 'required|unique:invoices,invoice_no',
            'subtotal'     => 'required|numeric|min:0',
            'tax'          => 'nullable|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'currency'     => 'nullable|string|max:10',
            'status'       => 'required|in:draft,issued,paid,cancelled',
            'issue_date'   => 'required|date',
            'due_date'     => 'nullable|date',
        ]);

        $validated['generated_by'] = $user->id;
        $validated['currency'] = $validated['currency'] ?? 'PKR';

        Invoice::create($validated);
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully!');
    }

    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        if (!$user->isHO() && $invoice->branch_id !== $user->branch_id) abort(403);
        $invoice->load(['sale.customer', 'branch', 'generatedBy']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isBranchManager()) abort(403);
        $sales = Sale::all();
        $branches = Branch::all();
        return view('invoices.edit', compact('invoice', 'sales', 'branches'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isBranchManager()) abort(403);

        $validated = $request->validate([
            'sale_id'      => 'required|exists:sales,id',
            'branch_id'    => 'required|exists:branches,id',
            'invoice_no'   => 'required|unique:invoices,invoice_no,' . $invoice->id,
            'subtotal'     => 'required|numeric|min:0',
            'tax'          => 'nullable|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status'       => 'required|in:draft,issued,paid,cancelled',
            'issue_date'   => 'required|date',
            'due_date'     => 'nullable|date',
        ]);

        $invoice->update($validated);
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        if (!Auth::user()->isHO()) abort(403);
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }
}