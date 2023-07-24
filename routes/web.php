<?php

use App\Http\Controllers\AuthController;
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

Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, '_login'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);
