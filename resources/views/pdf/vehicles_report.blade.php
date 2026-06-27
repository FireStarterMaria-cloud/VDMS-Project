<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velora VMS — Vehicles Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #2b2c40;
            background: #fff;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #696cff 0%, #9155fd 100%);
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }
        .header-left h1 {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
        }
        .header-left p {
            font-size: 11px;
            color: rgba(255,255,255,0.75);
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .report-badge {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        .header-right p {
            font-size: 10px;
            color: rgba(255,255,255,0.7);
            margin-top: 6px;
        }

        /* META BAR */
        .meta-bar {
            background: #f8f8ff;
            border-bottom: 2px solid #696cff;
            padding: 10px 32px;
            display: flex;
            gap: 32px;
            align-items: center;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        .meta-item .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #999;
            font-weight: 600;
        }
        .meta-item .value {
            font-size: 12px;
            font-weight: 700;
            color: #2b2c40;
            margin-top: 1px;
        }
        .meta-item .value.purple { color: #696cff; }

        /* SUMMARY BOXES */
        .summary-row {
            display: flex;
            gap: 0;
            margin: 20px 32px;
        }
        .summary-box {
            flex: 1;
            background: #f8f8ff;
            border: 1px solid #e8e8ff;
            border-radius: 8px;
            padding: 14px 18px;
            margin-right: 12px;
            text-align: center;
        }
        .summary-box:last-child { margin-right: 0; }
        .summary-box .s-num {
            font-size: 24px;
            font-weight: 800;
            color: #696cff;
            line-height: 1;
        }
        .summary-box .s-label {
            font-size: 10px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 4px;
        }
        .summary-box.green .s-num { color: #71dd37; }
        .summary-box.orange .s-num { color: #ffab00; }
        .summary-box.red .s-num { color: #ff3e1d; }

        /* TABLE */
        .table-wrap {
            margin: 0 32px 24px;
        }
        .table-title {
            font-size: 13px;
            font-weight: 700;
            color: #2b2c40;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #696cff;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .table-title span {
            background: #696cff;
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        thead tr {
            background: #696cff;
        }
        thead th {
            color: #fff;
            padding: 9px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }
        tbody tr:nth-child(even) {
            background: #fafaff;
        }
        tbody tr:hover { background: #f0f0ff; }
        tbody td {
            padding: 8px 10px;
            color: #3a3a5a;
            vertical-align: middle;
        }
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-available { background: rgba(113,221,55,0.15); color: #4caf00; }
        .badge-sold      { background: rgba(255,62,29,0.12);  color: #ff3e1d; }
        .badge-reserved  { background: rgba(255,171,0,0.15);  color: #e09600; }
        .badge-other     { background: rgba(105,108,255,0.12); color: #696cff; }

        /* FOOTER */
        .pdf-footer {
            margin: 0 32px;
            padding: 12px 0;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .pdf-footer p {
            font-size: 9px;
            color: #bbb;
        }
        .pdf-footer .brand {
            font-size: 10px;
            font-weight: 700;
            color: #696cff;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <h1>Velora VMS</h1>
            <p>Vehicle Management System — Official Report</p>
        </div>
        <div class="header-right">
            <div class="report-badge">VEHICLES REPORT</div>
            <p>Generated: {{ $generatedAt }}</p>
            <p>By: {{ $generatedBy }}</p>
        </div>
    </div>

    {{-- META BAR --}}
    <div class="meta-bar">
        <div class="meta-item">
            <span class="label">Report Type</span>
            <span class="value purple">Vehicle Inventory</span>
        </div>
        <div class="meta-item">
            <span class="label">Total Records</span>
            <span class="value">{{ $vehicles->count() }}</span>
        </div>
        <div class="meta-item">
            <span class="label">Date</span>
            <span class="value">{{ now()->format('d M Y') }}</span>
        </div>
        <div class="meta-item">
            <span class="label">System</span>
            <span class="value">Velora VMS v1.0</span>
        </div>
    </div>

    {{-- SUMMARY BOXES --}}
    <div class="summary-row">
        <div class="summary-box">
            <div class="s-num">{{ $vehicles->count() }}</div>
            <div class="s-label">Total Vehicles</div>
        </div>
        <div class="summary-box green">
            <div class="s-num">{{ $vehicles->where('status', 'available')->count() }}</div>
            <div class="s-label">Available</div>
        </div>
        <div class="summary-box orange">
            <div class="s-num">{{ $vehicles->where('status', 'reserved')->count() }}</div>
            <div class="s-label">Reserved</div>
        </div>
        <div class="summary-box red">
            <div class="s-num">{{ $vehicles->where('status', 'sold')->count() }}</div>
            <div class="s-label">Sold</div>
        </div>
        <div class="summary-box">
            <div class="s-num">Rs. {{ number_format($vehicles->sum('selling_price')) }}</div>
            <div class="s-label">Total Fleet Value</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrap">
        <div class="table-title">
            Vehicle Inventory
            <span>{{ $vehicles->count() }} records</span>
        </div>

        @if($vehicles->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reg. Number</th>
                    <th>Make & Model</th>
                    <th>Year</th>
                    <th>Variant</th>
                    <th>Colour</th>
                    <th>Transmission</th>
                    <th>Fuel</th>
                    <th>Mileage</th>
                    <th>Branch</th>
                    <th>Selling Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $i => $v)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $v->registration_number ?? '—' }}</strong></td>
                    <td>{{ $v->make ?? 'Toyota' }} {{ $v->model }}</td>
                    <td>{{ $v->year }}</td>
                    <td>{{ $v->variant ?? '—' }}</td>
                    <td>{{ $v->colour ?? '—' }}</td>
                    <td>{{ ucfirst($v->transmission ?? '—') }}</td>
                    <td>{{ ucfirst($v->fuel_type ?? '—') }}</td>
                    <td>{{ $v->mileage ? number_format($v->mileage) . ' km' : '—' }}</td>
                    <td>{{ $v->branch?->name ?? '—' }}</td>
                    <td><strong>Rs. {{ number_format($v->selling_price ?? 0) }}</strong></td>
                    <td>
                        @if($v->status == 'available')
                            <span class="badge badge-available">Available</span>
                        @elseif($v->status == 'sold')
                            <span class="badge badge-sold">Sold</span>
                        @elseif($v->status == 'reserved')
                            <span class="badge badge-reserved">Reserved</span>
                        @else
                            <span class="badge badge-other">{{ ucfirst($v->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="no-data">No vehicles found for your scope.</div>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="pdf-footer">
        <p>This is a system-generated report from Velora VMS. For internal use only.</p>
        <p class="brand">Velora VMS — Pakistan's Premier Auto Dealer Platform</p>
    </div>

</body>
</html>