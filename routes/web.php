<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ProfitController;
use App\Http\Controllers\Admin\UserController;
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

    Route::inertia('/', 'Home')->name('home');
    Route::get('/pos', [SaleController::class, 'pos'])->name('pos');
    Route::post('items-filter', [ItemController::class, 'itemsFilter']);
    Route::post('sale', [SaleController::class, 'store'])->name('sale');
    Route::get('change-password', [AuthController::class, 'changePassword']);
    Route::post('change-password', [AuthController::class, '_changePassword']);
    Route::resource('sales', SaleController::class);
    Route::get('invoices/{operation}',[SaleController::class,'invoice']);
    //super-admin,admin
    Route::group(['middleware' => 'roles:super-admin,admin'], function () {
        Route::resource('users', UserController::class);
        Route::resource('items', ItemController::class);
        Route::post('items/{item}', [ItemController::class, 'update'])->name('items-update');
        Route::get('not-in-stock', [ItemController::class, 'notInStock']);
        Route::resource('categories', CategoriesController::class);
        Route::resource('companies', CompaniesController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::get('profits', [ProfitController::class, 'index'])->name('profits');
        Route::post('profits-filter', [ProfitController::class, 'profitsFilter']);
    });
});
