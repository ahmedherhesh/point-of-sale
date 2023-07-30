<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use Milon\Barcode\DNS1D;

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

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, '_login'])->name('_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth.web'], function () {
    view()->composer(['*'], function ($view) {
        $user = session()->get('user');
        $view->with('user', $user);
    });
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/pos', [SaleController::class, 'index'])->name('pos');
    Route::post('items-filter', [SaleController::class, 'itemsFilter']);
});
