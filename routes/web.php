<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::redirect('/dashboard', '/orders')->name('dashboard');;

    Route::resource('users', \App\Http\Controllers\UserController::class)->only(['index', 'create', 'edit']);
    Route::resource('orders', \App\Http\Controllers\OrderController::class)->only(['index', 'create', 'show']);
    Route::resource('attribute-groups', \App\Http\Controllers\AttributeGroupController::class)->only(['index', 'create', 'edit']);
    Route::resource('item-types', \App\Http\Controllers\ItemTypeController::class)->only(['index', 'create', 'edit']);
    Route::resource('item-categories', \App\Http\Controllers\ItemCategoryController::class)->only(['index', 'create', 'edit']);
    Route::resource('items', \App\Http\Controllers\ItemController::class)->only(['index', 'create', 'edit']);
    Route::resource('productions', \App\Http\Controllers\ProductionController::class)->only(['index', 'create', 'edit', 'show']);
    Route::resource('production-requests', \App\Http\Controllers\ProductionRequestController::class)->only(['index']);
    Route::resource('shipments', \App\Http\Controllers\ShipmentController::class)->only(['index', 'create', 'edit']);
    Route::resource('transports', \App\Http\Controllers\TransportController::class)->only(['index', 'create', 'edit']);
    Route::get('customers/import', '\App\Http\Controllers\CustomerController@import')->name('customers.import');
    Route::resource('customers', \App\Http\Controllers\CustomerController::class)->only(['index', 'show', 'create']);
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class)->only(['index', 'show', 'create']);
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class)->only(['index']);
    Route::get('payments/statistics', [\App\Http\Controllers\PaymentController::class, 'statistics'])->name('payments.statistics');
    Route::get('payments/cash-statistics', [\App\Http\Controllers\PaymentController::class, 'cashStatistics'])->name('payments.cashStatistics');
    Route::get('payments/cashless-statistics', [\App\Http\Controllers\PaymentController::class, 'cashlessStatistics'])->name('payments.cashlessStatistics');
    Route::get('payments/cashbox-detail', [\App\Http\Controllers\PaymentController::class, 'cashboxDetail'])->name('payments.cashboxDetail');
    Route::resource('payments', \App\Http\Controllers\PaymentController::class)->only(['index']);
    Route::resource('cost-items', \App\Http\Controllers\CostItemController::class)->only(['index', 'show', 'create']);
    Route::resource('refunds', \App\Http\Controllers\RefundController::class)->only(['index']);
    Route::resource('units', \App\Http\Controllers\UnitController::class)->only(['index', 'create', 'edit']);
    Route::resource('leads', \App\Http\Controllers\LeadController::class)->only(['index', 'show', 'create']);
});
