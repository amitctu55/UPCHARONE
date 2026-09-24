<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pharmacy\MedicalDashboardController;
use App\Http\Controllers\Admin\PharmacySettlementController;

/*
|--------------------------------------------------------------------------
| Web Routes: UPCHAR Pharmacy & Settlements Portal
|--------------------------------------------------------------------------
*/

// MODULE 1: Pharmacy Store Owner Dashboard (/medical-dashboard)
Route::prefix('medical-dashboard')->group(function () {
    Route::get('/', [MedicalDashboardController::class, 'index'])->name('pharmacy.dashboard');
    Route::get('/inventory', [MedicalDashboardController::class, 'inventory'])->name('pharmacy.inventory');
    Route::post('/inventory/inward', [MedicalDashboardController::class, 'inwardStock'])->name('pharmacy.inventory.inward');
    Route::get('/orders', [MedicalDashboardController::class, 'orders'])->name('pharmacy.orders');
    Route::get('/orders/{order_id}/invoice', [MedicalDashboardController::class, 'generateInvoice'])->name('pharmacy.orders.invoice');
    Route::get('/handover', [MedicalDashboardController::class, 'handover'])->name('pharmacy.handover');
    Route::post('/handover/verify', [MedicalDashboardController::class, 'verifyHandover'])->name('pharmacy.handover.verify');
    Route::get('/payouts', [MedicalDashboardController::class, 'payouts'])->name('pharmacy.payouts');
    Route::get('/profile', [MedicalDashboardController::class, 'profile'])->name('pharmacy.profile');
    Route::post('/profile/update', [MedicalDashboardController::class, 'updateProfile'])->name('pharmacy.profile.update');
    Route::get('/reports', [MedicalDashboardController::class, 'reports'])->name('pharmacy.reports');
    Route::get('/reports/gstr1', [MedicalDashboardController::class, 'exportGstr1'])->name('pharmacy.reports.gstr1');
    Route::get('/gallery', [MedicalDashboardController::class, 'gallery'])->name('pharmacy.gallery');
    Route::post('/gallery/upload', [MedicalDashboardController::class, 'uploadGallery'])->name('pharmacy.gallery.upload');
    Route::post('/toggle-status', [MedicalDashboardController::class, 'toggleStoreStatus'])->name('pharmacy.toggle_status');
});

// MODULE 2: Super Admin Pharmacy Fleet & Settlements
Route::prefix('admin/pharmacy')->group(function () {
    Route::get('/settlements', [PharmacySettlementController::class, 'index'])->name('admin.pharmacy.settlements');
    Route::post('/settlements/mark-paid', [PharmacySettlementController::class, 'markPaid'])->name('admin.pharmacy.settlements.mark_paid');
    Route::get('/settlements/export-batch-csv', [PharmacySettlementController::class, 'exportBatchCsv'])->name('admin.pharmacy.settlements.export_csv');
    Route::get('/settlements/{id}/orders', [PharmacySettlementController::class, 'orderBreakdown'])->name('admin.pharmacy.settlements.order_breakdown');
});
