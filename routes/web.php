<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExtraProfitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ProfitController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DamageItemController;
use App\Models\Setting;
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

view()->composer(['*'], function ($view) {
    $view->with('setting', Setting::first() ?? []);
});
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, '_login'])->name('_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth.web'], function () {

    // Route::inertia('/', 'Home')->name('home');
    Route::get('/', [SaleController::class, 'pos'])->name('pos');
    Route::post('items-filter', [ItemController::class, 'itemsFilter']);
    Route::post('sale', [SaleController::class, 'store'])->name('sale');
    Route::get('change-password', [AuthController::class, 'changePassword']);
    Route::post('change-password', [AuthController::class, '_changePassword']);
    Route::resource('sales', SaleController::class);
    Route::resource('damages', DamageItemController::class);
    //super-admin,admin
    Route::group(['middleware' => 'roles:super-admin,admin'], function () {
        Route::resource('users', UserController::class);
        Route::resource('items', ItemController::class);
        Route::get('barcode', [ItemController::class, 'barcode']);
        Route::post('items/{item}', [ItemController::class, 'update'])->name('items-update');
        Route::get('not-in-stock', [ItemController::class, 'notInStock']);
        Route::resource('categories', CategoriesController::class);
        Route::resource('companies', CompaniesController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('extra-profits', ExtraProfitController::class);
        Route::get('profits', [ProfitController::class, 'index'])->name('profits');
        Route::get('settings', [SettingsController::class, 'index']);
        Route::post('settings', [SettingsController::class, 'storeOrUpdate']);
    });
});
