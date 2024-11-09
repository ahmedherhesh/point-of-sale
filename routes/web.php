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
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DamageItemController;
use App\Http\Controllers\DebitController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;

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
    Route::get('/', [SaleController::class, 'create'])->name('pos');
    Route::post('items-filter', [ItemController::class, 'itemsFilter']);
    Route::post('sale', [SaleController::class, 'store'])->name('sale');
    Route::get('change-password', [AuthController::class, 'changePassword']);
    Route::post('change-password', [AuthController::class, '_changePassword']);
    Route::resource('sales', SaleController::class);
    Route::resource('damages', DamageItemController::class);
    Route::get('item/{id}',[DamageItemController::class,'item']);
    Route::resource('extra-profits', ExtraProfitController::class);

    Route::resource('users', UserController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('items', ItemController::class);
    Route::get('barcode', [ItemController::class, 'barcode']);
    Route::post('items/{item}', [ItemController::class, 'update'])->name('items-update');
    Route::get('not-in-stock', [ItemController::class, 'notInStock']);
    Route::resource('categories', CategoriesController::class);
    Route::resource('companies', CompaniesController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('debits', DebitController::class);
    Route::get('debits/{debit}/pay', [DebitController::class, 'payOfTheDebit'])->name('debit.pay');
    Route::post('debits/pay', [DebitController::class, 'payOfTheDebitStore'])->name('debit.pay.store');
    Route::get('profits', [ProfitController::class, 'index'])->name('profits');
    Route::get('settings', [SettingsController::class, 'index']);
    Route::post('settings', [SettingsController::class, 'storeOrUpdate']);
    
});
