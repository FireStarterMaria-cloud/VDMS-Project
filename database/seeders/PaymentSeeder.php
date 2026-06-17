<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $sales = Sale::all();
        $user = User::first();
        $methods = ['cash', 'cheque', 'bank_transfer'];
        $statuses = ['completed', 'completed', 'pending'];

        foreach ($sales as $index => $sale) {
            Payment::create([
                'sale_id'        => $sale->id,
                'branch_id'      => $sale->branch_id,
                'received_by'    => $user->id,
                'amount'         => $sale->final_price,
                'currency'       => 'PKR',
                'exchange_rate'  => 1,
                'payment_method' => $methods[$index % 3],
                'reference_no'   => 'PAY-' . rand(1000, 9999),
                'status'         => $statuses[$index % 3],
                'payment_date'   => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'notes'          => 'Payment for sale #' . $sale->id,
            ]);
        }
    }
}