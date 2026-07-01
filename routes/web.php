<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchTransferController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/offline', function () {
    return view('offline');
})->name('offline');

Route::post('/invoices/{invoice}/send-email', [InvoiceController::class, 'sendEmail'])->name('invoices.send-email');
Route::post('/invoices/{invoice}/send-approval', [InvoiceController::class, 'sendApproval'])->name('invoices.send-approval');

Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company.index');


// Investor Page
Route::get('/investor', function() {
    $showrooms = App\Models\Showroom::where('is_active', true)->get();
    $branches  = App\Models\Branch::where('is_active', true)->with('showroom')->get();
    return view('investor', compact('showrooms', 'branches'));
})->name('investor');

Route::post('/investor/inquiry', [App\Http\Controllers\InvestmentInquiryController::class, 'store'])->name('investor.inquiry');



// ===================== BREEZE AUTH ROUTES =====================
require __DIR__.'/auth.php';

// ===================== PROTECTED ROUTES =====================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Showrooms (Chairwoman only)
Route::prefix('showrooms')->name('showrooms.')->group(function () {
    Route::get('/', [ShowroomController::class, 'index'])->name('index');
    Route::get('/create', [ShowroomController::class, 'create'])->name('create');
    Route::post('/', [ShowroomController::class, 'store'])->name('store');
    Route::get('/{showroom}', [ShowroomController::class, 'show'])->name('show');
    Route::get('/{showroom}/edit', [ShowroomController::class, 'edit'])->name('edit');
    Route::put('/{showroom}', [ShowroomController::class, 'update'])->name('update');
    Route::delete('/{showroom}', [ShowroomController::class, 'destroy'])->name('destroy');
});

Route::get('/showrooms-overview', [App\Http\Controllers\ShowroomController::class, 'overview'])->name('showrooms.overview');
Route::get('/showrooms/{showroom}/branches', [App\Http\Controllers\ShowroomController::class, 'branches'])->name('showrooms.branches');
Route::get('/investment-inquiries', [App\Http\Controllers\InvestmentInquiryController::class, 'index'])->name('investment-inquiries.index');



    // Vehicles
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('index');
        Route::get('/create', [VehicleController::class, 'create'])->name('create');
        Route::post('/', [VehicleController::class, 'store'])->name('store');
        Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('show');
        Route::get('/{vehicle}/edit', [VehicleController::class, 'edit'])->name('edit');
        Route::put('/{vehicle}', [VehicleController::class, 'update'])->name('update');
        Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy');



    });


    Route::get('/pdf/vehicles', [App\Http\Controllers\PdfController::class, 'vehiclesPdf'])->name('pdf.vehicles');
Route::get('/pdf/sales', [App\Http\Controllers\PdfController::class, 'salesPdf'])->name('pdf.sales');


    Route::post('/vehicle-documents/{document}/verify', [VehicleController::class, 'verifyDocument'])->name('vehicle-documents.verify');
    // Sales
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/', [SalesController::class, 'store'])->name('store');
        Route::get('/{sale}', [SalesController::class, 'show'])->name('show');
        Route::get('/{sale}/edit', [SalesController::class, 'edit'])->name('edit');
        Route::put('/{sale}', [SalesController::class, 'update'])->name('update');
        Route::delete('/{sale}', [SalesController::class, 'destroy'])->name('destroy');
    });

    // Customers
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Purchases
    Route::prefix('purchases')->name('purchases.')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseController::class, 'create'])->name('create');
        Route::post('/', [PurchaseController::class, 'store'])->name('store');
        Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('show');
        Route::get('/{purchase}/edit', [PurchaseController::class, 'edit'])->name('edit');
        Route::put('/{purchase}', [PurchaseController::class, 'update'])->name('update');
        Route::delete('/{purchase}', [PurchaseController::class, 'destroy'])->name('destroy');
    });

    // Payments
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/', [PaymentController::class, 'store'])->name('store');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('edit');
        Route::put('/{payment}', [PaymentController::class, 'update'])->name('update');
        Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
    });

    // Invoices
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
    });

    // Branches
    Route::prefix('branches')->name('branches.')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('index');
        Route::get('/create', [BranchController::class, 'create'])->name('create');
        Route::post('/', [BranchController::class, 'store'])->name('store');
        Route::get('/{branch}', [BranchController::class, 'show'])->name('show');
        Route::get('/{branch}/edit', [BranchController::class, 'edit'])->name('edit');
        Route::put('/{branch}', [BranchController::class, 'update'])->name('update');
        Route::delete('/{branch}', [BranchController::class, 'destroy'])->name('destroy');
    });

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Branch Transfers
Route::prefix('branch-transfers')->name('branch-transfers.')->group(function () {
    Route::get('/', [BranchTransferController::class, 'index'])->name('index');
    Route::get('/create', [BranchTransferController::class, 'create'])->name('create');
    Route::post('/', [BranchTransferController::class, 'store'])->name('store');
    Route::get('/{branchTransfer}', [BranchTransferController::class, 'show'])->name('show');
    Route::post('/{branchTransfer}/approve', [BranchTransferController::class, 'approve'])->name('approve');
    Route::post('/{branchTransfer}/reject', [BranchTransferController::class, 'reject'])->name('reject');
    Route::delete('/{branchTransfer}', [BranchTransferController::class, 'destroy'])->name('destroy');
});

    // Analytics, Audit Logs, Settings
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');


    Route::post('/notifications/read-all', function() {
    \App\Models\Notification::where('user_id', auth()->id())->update(['is_read' => true]);
    return redirect()->back();
})->name('notifications.readAll');

Route::post('/notifications/{notification}/read', function(\App\Models\Notification $notification) {
    $notification->update(['is_read' => true]);
    return response()->json(['success' => true]);
})->name('notifications.read');

});