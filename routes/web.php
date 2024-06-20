<?php

use App\Http\Controllers\ReceiptDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/items')->name('items.')->group(function () {
        Route::view('/admin', 'items')->name('admin');
        Route::view('/sell', 'sell')->name('sell');
    });

    Route::view('/customer', 'customers')->name('customer');

    Route::prefix('/receipts')->name('receipts.')->group(function () {
        Route::view('/', 'receipts')->name('index');
        Route::get('/detail/{id}', [ReceiptDetailController::class, 'index'])->name('detail');
    });

    Route::view('/payment', 'payments')->name('payment');

});
