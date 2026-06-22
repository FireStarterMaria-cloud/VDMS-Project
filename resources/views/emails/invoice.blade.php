<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f9; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: 0 auto; background: white; }
    .header { background: linear-gradient(135deg, #2b2c40, #3d3e5c); padding: 32px; text-align: center; }
    .header img { height: 50px; margin-bottom: 8px; }
    .header h2 { color: white; margin: 8px 0 0; font-size: 22px; }
    .body { padding: 32px; }
    .greeting { font-size: 16px; color: #2b2c40; margin-bottom: 16px; }
    .invoice-box { background: #f5f5f9; border-radius: 10px; padding: 20px; margin: 20px 0; }
    .invoice-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; color: #566a7f; }
    .invoice-row strong { color: #2b2c40; }
    .total-row { border-top: 2px solid #696cff; margin-top: 10px; padding-top: 14px; font-size: 18px; font-weight: 700; color: #696cff; }
    .btn { display: inline-block; background: #696cff; color: white !important; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 20px; }
    .footer { text-align: center; padding: 24px; color: #a1acb8; font-size: 12px; border-top: 1px solid #eee; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>VELORA</h2>
        <p style="color:rgba(255,255,255,0.6); margin:0; font-size:13px;">Vehicle Management System</p>
    </div>
    <div class="body">
        <p class="greeting">Dear {{ $invoice->sale->customer->name ?? 'Valued Customer' }},</p>
        <p style="color:#566a7f; font-size:14px; line-height:1.7;">
            Thank you for choosing Velora VMS. Please find your invoice details below.
            We truly appreciate your trust and look forward to serving you again.
        </p>

        <div class="invoice-box">
            <div class="invoice-row"><span>Invoice No</span><strong>{{ $invoice->invoice_no }}</strong></div>
            <div class="invoice-row"><span>Vehicle</span><strong>{{ $invoice->sale->vehicle->make ?? '' }} {{ $invoice->sale->vehicle->model ?? '' }}</strong></div>
            <div class="invoice-row"><span>Issue Date</span><strong>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</strong></div>
            <div class="invoice-row"><span>Subtotal</span><strong>Rs. {{ number_format($invoice->subtotal) }}</strong></div>
            <div class="invoice-row"><span>Tax</span><strong>Rs. {{ number_format($invoice->tax ?? 0) }}</strong></div>
            <div class="invoice-row"><span>Discount</span><strong>- Rs. {{ number_format($invoice->discount ?? 0) }}</strong></div>
            <div class="invoice-row total-row"><span>Total Amount</span><span>Rs. {{ number_format($invoice->total_amount) }}</span></div>
        </div>

        <p style="text-align:center;">
            <a href="{{ route('invoices.show', $invoice) }}" class="btn">View / Download Invoice</a>
        </p>

        <p style="color:#566a7f; font-size:13px; margin-top:24px;">
            If you have any questions about this invoice, feel free to contact your branch directly.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Velora VMS — Vehicle Management System. All rights reserved.
    </div>
</div>
</body>
</html>