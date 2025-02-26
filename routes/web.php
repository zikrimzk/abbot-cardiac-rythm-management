<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;

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


Route::prefix('auth')->group(function () {
    Route::get('/login',[RouteController::class,'loginpage'])->name('login-page');
});

Route::prefix('staff')->group(function () {
    Route::get('/dashboard',[RouteController::class,'staffDashboard'])->name('staff-dashboard-page');
    Route::get('/manage-department',[RouteController::class,'manageDepartment'])->name('manage-department-page');

});



