<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Velora VMS — Sales Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #2b2c40; background: #fff; }
        .header { background: linear-gradient(135deg, #696cff 0%, #9155fd 100%); padding: 24px 32px; display: flex; justify-content: space-between; align-items: center; }
        .header-left h1 { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }
        .header-left p { font-size: 11px; color: rgba(255,255,255,0.75); margin-top: 3px; }
        .header-right { text-align: right; }
        .report-badge { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 10px; font-weight: 600; }
        .header-right p { font-size: 10px; color: rgba(255,255,255,0.7); margin-top: 6px; }
        .meta-bar { background: #f8f8ff; border-bottom: 2px solid #696cff; padding: 10px 32px; display: flex; gap: 32px; }
        .meta-item .label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.1em; color: #999; font-weight: 600; }
        .meta-item .value { font-size: 12px; font-weight: 700; color: #2b2c40; margin-top: 1px; }
        .meta-item .value.purple { color: #696cff; }
        .summary-row { display: flex; gap: 0; margin: 20px 32px; }
        .summary-box { flex: 1; background: #f8f8ff; border: 1px solid #e8e8ff; border-radius: 8px; padding: 14px 18px; margin-right: 12px; text-align: center; }
        .summary-box:last-child { margin-right: 0; }
        .summary-box .s-num { font-size: 20px; font-weight: 800; color: #696cff; line-height: 1; }
        .summary-box .s-label { font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px; }
        .summary-box.green .s-num { color: #71dd37; }
        .table-wrap { margin: 0 32px 24px; }
        .table-title { font-size: 13px; font-weight: 700; color: #2b2c40; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 2px solid #696cff; display: flex; align-items: center; gap: 6px; }
        .table-title span { background: #696cff; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        thead tr { background: #696cff; }
        thead th { color: #fff; padding: 9px 10px; text-align: left; font-weight: 600; font-size: 10px; letter-spacing: 0.04em; text-transform: uppercase; }
        tbody tr { border-bottom: 1px solid #f0f0f0; }
        tbody tr:nth-child(even) { background: #fafaff; }
        tbody td { padding: 8px 10px; color: #3a3a5a; vertical-align: middle; }
        .total-row td { background: #f0f0ff; font-weight: 700; color: #696cff; border-top: 2px solid #696cff; }
        .pdf-footer { margin: 0 32px; padding: 12px 0; border-top: 1px solid #eee; display: flex; justify-content: space-between; }
        .pdf-footer p { font-size: 9px; color: #bbb; }
        .pdf-footer .brand { font-size: 10px; font-weight: 700; color: #696cff; }
        .no-data { text-align: center; padding: 40px; color: #999; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <h1>Velora VMS</h1>
            <p>Vehicle Management System — Official Report</p>
        </div>
        <div class="header-right">
            <div class="report-badge">SALES REPORT</div>
            <p>Generated: {{ $generatedAt }}</p>
            <p>By: {{ $generatedBy }}</p>
        </div>
    </div>

    <div class="meta-bar">
        <div class="meta-item">
            <span class="label">Report Type</span>
            <span class="value purple">Sales Summary</span>
        </div>
        <div class="meta-item">
            <span class="label">Total Records</span>
            <span class="value">{{ $sales->count() }}</span>
        </div>
        <div class="meta-item">
            <span class="label">Total Revenue</span>
            <span class="value purple">Rs. {{ number_format($totalRevenue) }}</span>
        </div>
        <div class="meta-item">
            <span class="label">Date</span>
            <span class="value">{{ now()->format('d M Y') }}</span>
        </div>
    </div>

    <div class="summary-row">
        <div class="summary-box">
            <div class="s-num">{{ $sales->count() }}</div>
            <div class="s-label">Total Sales</div>
        </div>
        <div class="summary-box green">
            <div class="s-num">Rs. {{ number_format($totalRevenue) }}</div>
            <div class="s-label">Total Revenue</div>
        </div>
        <div class="summary-box">
            <div class="s-num">Rs. {{ $sales->count() > 0 ? number_format($totalRevenue / $sales->count()) : 0 }}</div>
            <div class="s-label">Avg Sale Price</div>
        </div>
        <div class="summary-box">
            <div class="s-num">{{ $sales->groupBy('branch_id')->count() }}</div>
            <div class="s-label">Branches</div>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-title">
            Sales Records
            <span>{{ $sales->count() }} records</span>
        </div>

        @if($sales->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sale Date</th>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Year</th>
                    <th>Branch</th>
                    <th>Sale Price</th>
                    <th>Discount</th>
                    <th>Final Price</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->created_at?->format('d M Y') ?? '—' }}</td>
                    <td><strong>{{ $s->customer?->name ?? '—' }}</strong></td>
                    <td>{{ $s->vehicle?->make ?? 'Toyota' }} {{ $s->vehicle?->model ?? '—' }}</td>
                    <td>{{ $s->vehicle?->year ?? '—' }}</td>
                    <td>{{ $s->branch?->name ?? '—' }}</td>
                    <td>Rs. {{ number_format($s->sale_price ?? 0) }}</td>
                    <td>Rs. {{ number_format($s->discount ?? 0) }}</td>
                    <td><strong>Rs. {{ number_format($s->final_price ?? 0) }}</strong></td>
                    <td>{{ ucfirst($s->payment_method ?? '—') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="8" style="text-align:right;">TOTAL REVENUE</td>
                    <td colspan="2"><strong>Rs. {{ number_format($totalRevenue) }}</strong></td>
                </tr>
            </tbody>
        </table>
        @else
            <div class="no-data">No sales found for your scope.</div>
        @endif
    </div>

    <div class="pdf-footer">
        <p>This is a system-generated report from Velora VMS. For internal use only.</p>
        <p class="brand">Velora VMS — Pakistan's Premier Auto Dealer Platform</p>
    </div>

</body>
</html>