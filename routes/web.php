<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('top');
})->name('top');

Route::get('orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
Route::get('orders/{order}/fail', [OrderController::class, 'fail'])->name('orders.fail');
Route::get('orders/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');