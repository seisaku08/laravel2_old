<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/helo', function () {
    return view('helo', ['message' => 'verified']);
});

Route::post('/helo', function () {
    return view('helo', ['message' => '
    ']);
});


Route::post('/helo2', function () {
    return view('helo2');
});

Route::middleware('auth')->group(function () {
    Route::match(['get','post'],'/pctool', 'pctoolController@view')->name('pctool.retry');
    // Route::post('/pctool', 'pctoolController@view');
    Route::get('/pctool_error', 'pctoolController@error')->name('pctool.error');
    Route::match(['get','post'],'/sendto', 'SendtoController@view')->name('sendto');
    Route::post('/confirm', 'ConfirmController@post')->name('confirm');

    Route::get('/pctool/{id}', 'pctoolController@detail');
    
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart', 'CartController@view')->name('cart');
    Route::post('/addCart', 'CartController@addCart')->name('addCart');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/Mypage', ['uses'=>'MypageController@index'])->name('Mypage');
    Route::get('/dashboard', ['uses'=>'DashboardController@index'])->name('dashboard');
    });
Route::get('/adminlte', function () {
    return view('adminlte');
})->middleware(['auth', 'verified'])->name('adminlte');
require __DIR__.'/auth.php';
