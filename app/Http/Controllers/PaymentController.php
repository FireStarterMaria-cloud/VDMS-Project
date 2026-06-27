<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class PaymentController extends Controller
{
    use ShowroomScoped;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Payment::with(['sale', 'branch', 'receivedBy']);

        $this->applyShowroomScope($query);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $payments = $query->latest()->paginate(15);
        $branches = $this->getBranches();

        return view('payments.index', compact('payments', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $salesQuery = Sale::with('customer');
        $this->applyShowroomScope($salesQuery);
        $sales = $salesQuery->get();

        $branches = $this->getBranches();
        return view('payments.create', compact('sales', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $validated = $request->validate([
            'sale_id'        => 'required|exists:sales,id',
            'branch_id'      => 'required|exists:branches,id',
            'amount'         => 'required|numeric|min:0',
            'currency'       => 'nullable|string|max:10',
            'exchange_rate'  => 'nullable|numeric',
            'payment_method' => 'required|in:cash,cheque,bank_transfer,jazzcash,stripe',
            'reference_no'   => 'nullable|string|max:100',
            'status'         => 'required|in:pending,completed,failed',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $validated['received_by'] = $user->id;
        $validated['currency'] = $validated['currency'] ?? 'PKR';
        $validated['exchange_rate'] = $validated['exchange_rate'] ?? 1;

        Payment::create($validated);
        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $user = Auth::user();
        if (!$user->isChairwoman() && !$user->canAccessBranch($payment->branch_id)) abort(403);
        $payment->load(['sale', 'branch', 'receivedBy']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);
        if (!$user->isChairwoman() && !$user->canAccessBranch($payment->branch_id)) abort(403);

        $salesQuery = Sale::with('customer');
        $this->applyShowroomScope($salesQuery);
        $sales = $salesQuery->get();

        $branches = $this->getBranches();
        return view('payments.edit', compact('payment', 'sales', 'branches'));
    }

    public function update(Request $request, Payment $payment)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $validated = $request->validate([
            'sale_id'        => 'required|exists:sales,id',
            'branch_id'      => 'required|exists:branches,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,cheque,bank_transfer,jazzcash,stripe',
            'reference_no'   => 'nullable|string|max:100',
            'status'         => 'required|in:pending,completed,failed',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $payment->update($validated);
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully!');
    }
}