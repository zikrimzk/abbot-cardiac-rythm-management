<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\HospitalDoctorController;

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

     //Manage Implant
     Route::get('/manage-implant',[RouteController::class,'manageImplant'])->name('manage-implant-page');
     Route::get('/add-implant',[RouteController::class,'addImplant'])->name('add-implant-page');
 
     //Generate Patient ID Card
     Route::get('/generate-patient-id-card',[RouteController::class,'generatePatientIdCard'])->name('generate-patient-id-card-page');

    //Manage Designation
    Route::get('/manage-designation',[RouteController::class,'manageDesignation'])->name('manage-designation-page');
    Route::post('/add-designation',[StaffController::class,'addDesignation'])->name('add-designation-post');
    Route::post('/update-designation/{id}',[StaffController::class,'updateDesignation'])->name('update-designation-post');
    Route::get('/delete-designation/{id}',[StaffController::class,'deleteDesignation'])->name('delete-designation-get');

    //Manage Staff
    Route::get('/manage-staff',[RouteController::class,'manageStaff'])->name('manage-staff-page');
    Route::post('/add-staff',[StaffController::class,'addStaff'])->name('add-staff-post');
    Route::post('/update-staff/{id}',[StaffController::class,'updateStaff'])->name('update-staff-post');
    Route::get('/delete-staff/{id}',[StaffController::class,'deleteStaff'])->name('delete-staff-get');

    //Manage Hospital
    Route::get('/manage-hospital',[RouteController::class,'manageHospital'])->name('manage-hospital-page');
    Route::post('/add-hospital',[HospitalDoctorController::class,'addHospital'])->name('add-hospital-post');
    Route::post('/update-hospital/{id}',[HospitalDoctorController::class,'updateHospital'])->name('update-hospital-post');
    Route::get('/delete-hospital/{id}',[HospitalDoctorController::class,'deleteHospital'])->name('delete-hospital-get');


    //Manage Doctor
    Route::get('/manage-doctor',[RouteController::class,'manageDoctor'])->name('manage-doctor-page');
    Route::post('/add-doctor',[HospitalDoctorController::class,'addDoctor'])->name('add-doctor-post');
    Route::post('/update-doctor/{id}',[HospitalDoctorController::class,'updateDoctor'])->name('update-doctor-post');
    Route::get('/delete-doctor/{id}',[HospitalDoctorController::class,'deleteDoctor'])->name('delete-doctor-get');

    //Manage Model Category
    Route::get('/manage-model-category',[RouteController::class,'manageModelCategory'])->name('manage-model-category-page');
    Route::post('/add-model-category',[ModelController::class,'addModelCategory'])->name('add-model-category-post');
    Route::post('/update-model-category/{id}',[ModelController::class,'updateModelCategory'])->name('update-model-category-post');
    Route::get('/delete-model-category/{id}',[ModelController::class,'deleteModelCategory'])->name('delete-model-category-get');

    //Manage Model
    Route::get('/manage-model',[RouteController::class,'manageModel'])->name('manage-model-page');
    Route::post('/add-model',[ModelController::class,'addModel'])->name('add-model-post');
    Route::post('/update-model/{id}',[ModelController::class,'updateModel'])->name('update-model-post');
    Route::get('/delete-model/{id}',[ModelController::class,'deleteModel'])->name('delete-model-get');


   



});



