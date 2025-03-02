<?php

use App\Http\Controllers\AuthenticateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StaffController;

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


Route::prefix('auth')->group(function () {
    Route::get('/login',[RouteController::class,'loginpage'])->name('login-page');
    Route::post('/authenticate-staff',[AuthenticateController::class,'staffLogin'])->name('staff-login-post');
});

Route::prefix('staff')->middleware('auth')->group(function () {
    //Homepage
    Route::get('/dashboard',[RouteController::class,'staffDashboard'])->name('staff-dashboard-page');

    //Account Setting
    Route::get('/my-account',[RouteController::class,'staffAccount'])->name('staff-account-page');
    Route::post('/update-account/{id}',[AuthenticateController::class,'staffAccountUpdate'])->name('staff-account-update-post');
    Route::post('/ipdate-password/{id}',[AuthenticateController::class,'staffPasswordUpdate'])->name('staff-password-update-post');
    Route::get('/logout',[AuthenticateController::class,'staffLogout'])->name('staff-logout-get');

    //Manage Department 
    Route::get('/manage-department',[RouteController::class,'manageDepartment'])->name('manage-department-page');
    Route::post('/add-department',[StaffController::class,'addDepartment'])->name('add-department-post');
    Route::post('/update-department/{id}',[StaffController::class,'updateDepartment'])->name('update-department-post');
    Route::get('/delete-department/{id}',[StaffController::class,'deleteDepartment'])->name('delete-department-get');

    //Manage Staff
    Route::get('/manage-staff',[RouteController::class,'manageStaff'])->name('manage-staff-page');
    Route::post('/add-staff',[StaffController::class,'addStaff'])->name('add-staff-post');
    Route::post('/update-staff/{id}',[StaffController::class,'updateStaff'])->name('update-staff-post');
    Route::get('/delete-staff/{id}',[StaffController::class,'deleteStaff'])->name('delete-staff-get');

    //Manage Implant
    Route::get('/manage-implant',[RouteController::class,'manageImplant'])->name('manage-implant-page');
    Route::get('/add-implant',[RouteController::class,'addImplant'])->name('add-implant-page');



});



