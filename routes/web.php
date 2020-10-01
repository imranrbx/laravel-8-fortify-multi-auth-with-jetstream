<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogoutController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix'=>'admin','middleware'=>['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});
Route::post('/admin/logout', [AdminController::class,'destroy'])->name('admin.logout')->middleware('auth:admin');

Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth:web');

Route::middleware(['auth.admin:admin', 'verified'])->get('/admin/dashboard', function () {
    return view('adashboard');
})->name('admin.dashboard');

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
