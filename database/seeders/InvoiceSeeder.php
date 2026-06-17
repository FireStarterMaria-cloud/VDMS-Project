<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $sales = Sale::all();
        $user = User::first();
        $statuses = ['paid', 'issued', 'draft'];

        foreach ($sales as $index => $sale) {
            $subtotal = $sale->sale_price;
            $tax      = round($subtotal * 0.05);
            $discount = $sale->discount ?? 0;
            $total    = $subtotal + $tax - $discount;

            Invoice::create([
                'sale_id'      => $sale->id,
                'branch_id'    => $sale->branch_id,
                'generated_by' => $user->id,
                'invoice_no'   => 'INV-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'subtotal'     => $subtotal,
                'tax'          => $tax,
                'discount'     => $discount,
                'total_amount' => $total,
                'currency'     => 'PKR',
                'status'       => $statuses[$index % 3],
                'issue_date'   => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'due_date'     => now()->addDays(rand(7, 30))->format('Y-m-d'),
            ]);
        }
    }
}