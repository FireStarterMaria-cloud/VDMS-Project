<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Sale;
use App\Traits\ShowroomScoped;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    use ShowroomScoped;

    public function vehiclesPdf(Request $request)
    {
        $vehicles = Vehicle::with(['branch'])
            ->when(!auth()->user()->isChairwoman(), function($q) {
                $q->whereHas('branch', function($b) {
                    $b->where('showroom_id', auth()->user()->showroom_id);
                });
            })
            ->when(auth()->user()->branch_id && !auth()->user()->isHO(), function($q) {
                $q->where('branch_id', auth()->user()->branch_id);
            })
            ->latest()
            ->get();

       $pdf = Pdf::loadView('pdf.vehicles_report', [
            'vehicles' => $vehicles,
            'generatedBy' => auth()->user()->name,
            'generatedAt' => now()->format('d M Y, h:i A'),
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
        ]);

        return $pdf->download('velora-vehicles-' . now()->format('Y-m-d') . '.pdf');
    }

    public function salesPdf(Request $request)
    {
        $sales = Sale::with(['vehicle', 'customer', 'branch'])
            ->when(!auth()->user()->isChairwoman(), function($q) {
                $q->whereHas('branch', function($b) {
                    $b->where('showroom_id', auth()->user()->showroom_id);
                });
            })
            ->when(auth()->user()->branch_id && !auth()->user()->isHO(), function($q) {
                $q->where('branch_id', auth()->user()->branch_id);
            })
            ->latest()
            ->get();

      $pdf = Pdf::loadView('pdf.sales_report', [
            'sales' => $sales,
            'generatedBy' => auth()->user()->name,
            'generatedAt' => now()->format('d M Y, h:i A'),
            'totalRevenue' => $sales->sum('final_price'),
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
        ]);

        return $pdf->download('velora-sales-' . now()->format('Y-m-d') . '.pdf');
    }
}