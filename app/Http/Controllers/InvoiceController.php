<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class InvoiceController extends Controller
{
    use ShowroomScoped;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Invoice::with(['sale', 'branch', 'generatedBy']);

        $this->applyShowroomScope($query);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $invoices = $query->latest()->paginate(15);
        $branches = $this->getBranches();

        return view('invoices.index', compact('invoices', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $salesQuery = Sale::with('customer');
        $this->applyShowroomScope($salesQuery);
        $sales = $salesQuery->get();

        $branches = $this->getBranches();
        return view('invoices.create', compact('sales', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

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
        $validated['needs_review'] = $request->has('send_to_admin') ? true : false;

        $invoice = Invoice::create($validated);

        $message = 'Invoice created successfully!';
        if ($validated['needs_review']) {
            $message .= ' Sent to admin for review.';
        }

        return redirect()->route('invoices.show', $invoice)->with('success', $message);
    }

    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        if (!$user->isChairwoman() && !$user->canAccessBranch($invoice->branch_id)) abort(403);
        $invoice->load(['sale.customer', 'sale.vehicle', 'branch', 'generatedBy']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);
        if (!$user->isChairwoman() && !$user->canAccessBranch($invoice->branch_id)) abort(403);

        $salesQuery = Sale::with('customer');
        $this->applyShowroomScope($salesQuery);
        $sales = $salesQuery->get();

        $branches = $this->getBranches();
        return view('invoices.edit', compact('invoice', 'sales', 'branches'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

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
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }

    public function sendEmail(\App\Models\Invoice $invoice)
    {
        $customerEmail = $invoice->sale->customer->email ?? null;

        if (!$customerEmail) {
            return redirect()->back()->with('error', 'Customer does not have an email address.');
        }

        \Illuminate\Support\Facades\Mail::to($customerEmail)
            ->send(new \App\Mail\InvoiceMail($invoice));

        return redirect()->back()->with('success', 'Invoice emailed to ' . $customerEmail . ' successfully!');
    }

    public function sendApproval(\App\Models\Invoice $invoice)
    {
        $invoice->update(['needs_review' => true]);
        return redirect()->back()->with('success', 'Invoice flagged for HO review.');
    }
}