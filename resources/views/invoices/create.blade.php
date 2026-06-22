@extends('layouts.app')
@section('title', 'Create Invoice')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-file me-2"></i>Create Invoice</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sale <span class="text-danger">*</span></label>
                        <select name="sale_id" id="saleSelect" class="form-select" required>
                            <option value="">Select Sale</option>
                            @foreach($sales as $sale)
                            <option value="{{ $sale->id }}"
                                data-customer-name="{{ $sale->customer->name ?? 'N/A' }}"
                                data-customer-phone="{{ $sale->customer->phone ?? '' }}"
                                data-customer-email="{{ $sale->customer->email ?? '' }}"
                                data-final-price="{{ $sale->final_price }}"
                                {{ old('sale_id') == $sale->id ? 'selected' : '' }}>
                                Sale #{{ $sale->id }} — {{ $sale->customer->name ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch <span class="text-danger">*</span></label>
                        <select name="branch_id" class="form-select" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Customer Info (auto-filled, readonly) --}}
                <div class="card bg-label-primary mb-3" id="customerInfoCard" style="display:none;">
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Customer Name</small>
                                <div class="fw-bold" id="cName">-</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Phone</small>
                                <div class="fw-bold" id="cPhone">-</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Email</small>
                                <div class="fw-bold" id="cEmail">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                        <input type="text" name="invoice_no" class="form-control" value="{{ old('invoice_no', 'INV-' . date('Ymd') . '-' . rand(100,999)) }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft">Draft</option>
                            <option value="issued">Issued</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subtotal <span class="text-danger">*</span></label>
                        <input type="number" name="subtotal" id="subtotal" class="form-control" value="{{ old('subtotal') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tax</label>
                        <input type="number" name="tax" id="tax" class="form-control" value="{{ old('tax', 0) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control" value="{{ old('discount', 0) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                        <input type="number" name="total_amount" id="totalAmount" class="form-control" value="{{ old('total_amount') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Issue Date <span class="text-danger">*</span></label>
                        <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', date('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" />
                    </div>
                </div>

                <hr>
                <h6 class="mb-3"><i class="bx bx-share-alt me-2"></i>After Creating, Also:</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="send_email" id="sendEmail" value="1">
                            <label class="form-check-label" for="sendEmail"><i class="bx bx-envelope me-1"></i>Email to Customer</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="send_whatsapp" id="sendWhatsapp" value="1">
                            <label class="form-check-label" for="sendWhatsapp"><i class="bx bxl-whatsapp me-1"></i>Share via WhatsApp</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="send_to_admin" id="sendToAdmin" value="1">
                            <label class="form-check-label" for="sendToAdmin"><i class="bx bx-shield-quarter me-1"></i>Send for Approval</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="print_invoice" id="printInvoice" value="1">
                            <label class="form-check-label" for="printInvoice"><i class="bx bx-printer me-1"></i>Print After Save</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary me-2">
                    <i class="bx bx-check me-1"></i> Create Invoice
                </button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('saleSelect').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const card = document.getElementById('customerInfoCard');

    if (this.value) {
        document.getElementById('cName').textContent = selected.dataset.customerName || '-';
        document.getElementById('cPhone').textContent = selected.dataset.customerPhone || '-';
        document.getElementById('cEmail').textContent = selected.dataset.customerEmail || '-';
        card.style.display = 'block';

        const price = parseFloat(selected.dataset.finalPrice || 0);
        document.getElementById('subtotal').value = price;
        document.getElementById('totalAmount').value = price;
    } else {
        card.style.display = 'none';
    }
});
</script>
@endsection