<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
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



Route::get('/dashboard', function (Request $request) {
    return view('dashboard', [
        'listings' => $request->user()->listings
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::controller(ListingController::class)->group(function () {
    Route::get('/', 'index')->name('listings.index');
    Route::get('/new', 'create')->middleware('auth')->name('listing.create');
    Route::post('/new', 'store')->middleware('auth')->name('listing.store');
    Route::get('/paid', 'returnPay')->middleware('auth')->name('return.pay');
    Route::get('/payment-error', 'paymentError')->middleware('auth')->name('listing.payment.error');
    Route::get('/{listing}', 'show')->name('listing.show');
    Route::get('/{listing}/apply', 'apply')->name('listing.apply');
  
});


