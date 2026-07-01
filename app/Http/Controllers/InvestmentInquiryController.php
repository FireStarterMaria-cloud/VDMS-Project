<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvestmentInquiry;

class InvestmentInquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'company_name' => 'nullable|string|max:255',
            'investment_range' => 'nullable|string|max:100',
            'custom_amount' => 'nullable|string|max:100',
            'investment_targets' => 'nullable|array',
            'investment_targets.*' => 'string',
            'message' => 'nullable|string|max:2000',
        ]);

       

        InvestmentInquiry::create($validated);

        return back()->with('inquiry_success', 'Thank you. Your inquiry has been received — our investment team will reach out shortly.');
    }

public function index()
{
    if (!auth()->user()->isChairwoman()) abort(403);
    $inquiries = \App\Models\InvestmentInquiry::latest()->get();
    return view('investors.index', compact('inquiries'));
}

}