<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\OtherSettingController;
use App\Http\Controllers\HospitalDoctorController;
use App\Http\Controllers\ImplantController;

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
    Route::get('/login', [RouteController::class, 'loginpage'])->name('login-page');
    Route::post('/authenticate-staff', [AuthenticateController::class, 'staffLogin'])->name('staff-login-post');
});

Route::prefix('staff')->middleware('auth')->group(function () {
    //Homepage
    Route::get('/dashboard', [RouteController::class, 'staffDashboard'])->name('staff-dashboard-page');

    //Account Setting
    Route::get('/my-account', [RouteController::class, 'staffAccount'])->name('staff-account-page');
    Route::post('/update-account/{id}', [AuthenticateController::class, 'staffAccountUpdate'])->name('staff-account-update-post');
    Route::post('/ipdate-password/{id}', [AuthenticateController::class, 'staffPasswordUpdate'])->name('staff-password-update-post');
    Route::get('/logout', [AuthenticateController::class, 'staffLogout'])->name('staff-logout-get');

    //Manage Implant
    Route::get('/manage-implant', [RouteController::class, 'manageImplant'])->name('manage-implant-page');
    Route::get('/add-implant', [RouteController::class, 'addImplant'])->name('add-implant-page');
    Route::post('/add-implant', [ImplantController::class, 'addImplant'])->name('add-implant-post');
    Route::get('/update-implant-{id}', [RouteController::class, 'updateImplant'])->name('update-implant-page');
    Route::post('/update-implant/{id}', [ImplantController::class, 'updateImplant'])->name('update-implant-post');
    Route::post('/upload-imbackup-form/{id}', [ImplantController::class, 'uploadBackupForm'])->name('upload-imbackupform-post');
    Route::get('/view-form/{filename}', [RouteController::class, 'viewBackupForm'])->where('filename', '.*')->name('view-imbackupform');
    Route::get('/export-implant-data', [ImplantController::class, 'exportExcelImplantData'])->name('export-implant-data-excel');
    Route::get('/view-implant-registration-form-{id}-{option}', [RouteController::class, 'viewGenerateDownloadIRF'])->name('view-irf-document');
    Route::get('/download-implant-directory/{id}', [ImplantController::class, 'downloadImplantDirectory'])->name('download-implant-directory');
    Route::get('/download-multiple-implant-directory', [ImplantController::class, 'downloadMultipleImplantDirectory'])->name('download-multiple-implant-directory');

    //Generate Patient ID Card
    Route::get('/generate-patient-id-card-{id}', [RouteController::class, 'generatePatientIdCard'])->name('generate-patient-id-card-page');
    Route::get('/view-patient-id-card', [RouteController::class, 'viewPatientIdCard'])->name('view-patient-id-card-page');


    //Manage Designation
    Route::get('/manage-designation', [RouteController::class, 'manageDesignation'])->name('manage-designation-page');
    Route::post('/add-designation', [StaffController::class, 'addDesignation'])->name('add-designation-post');
    Route::post('/update-designation/{id}', [StaffController::class, 'updateDesignation'])->name('update-designation-post');
    Route::get('/delete-designation/{id}', [StaffController::class, 'deleteDesignation'])->name('delete-designation-get');

    //Manage Staff
    Route::get('/manage-staff', [RouteController::class, 'manageStaff'])->name('manage-staff-page');
    Route::post('/add-staff', [StaffController::class, 'addStaff'])->name('add-staff-post');
    Route::post('/update-staff/{id}', [StaffController::class, 'updateStaff'])->name('update-staff-post');
    Route::get('/delete-staff/{id}', [StaffController::class, 'deleteStaff'])->name('delete-staff-get');

    //Manage Hospital
    Route::get('/manage-hospital', [RouteController::class, 'manageHospital'])->name('manage-hospital-page');
    Route::post('/add-hospital', [HospitalDoctorController::class, 'addHospital'])->name('add-hospital-post');
    Route::post('/update-hospital/{id}', [HospitalDoctorController::class, 'updateHospital'])->name('update-hospital-post');
    Route::get('/delete-hospital/{id}', [HospitalDoctorController::class, 'deleteHospital'])->name('delete-hospital-get');

    //Manage Doctor
    Route::get('/manage-doctor', [RouteController::class, 'manageDoctor'])->name('manage-doctor-page');
    Route::post('/add-doctor', [HospitalDoctorController::class, 'addDoctor'])->name('add-doctor-post');
    Route::post('/update-doctor/{id}', [HospitalDoctorController::class, 'updateDoctor'])->name('update-doctor-post');
    Route::get('/delete-doctor/{id}', [HospitalDoctorController::class, 'deleteDoctor'])->name('delete-doctor-get');

    //Manage Model Category
    Route::get('/manage-model-category', [RouteController::class, 'manageModelCategory'])->name('manage-model-category-page');
    Route::post('/add-model-category', [ModelController::class, 'addModelCategory'])->name('add-model-category-post');
    Route::post('/update-model-category/{id}', [ModelController::class, 'updateModelCategory'])->name('update-model-category-post');
    Route::get('/delete-model-category/{id}', [ModelController::class, 'deleteModelCategory'])->name('delete-model-category-get');

    //Manage Model
    Route::get('/manage-model', [RouteController::class, 'manageModel'])->name('manage-model-page');
    Route::post('/add-model', [ModelController::class, 'addModel'])->name('add-model-post');
    Route::post('/update-model/{id}', [ModelController::class, 'updateModel'])->name('update-model-post');
    Route::get('/delete-model/{id}', [ModelController::class, 'deleteModel'])->name('delete-model-get');

    //Manage Generator
    Route::get('/manage-generator', [RouteController::class, 'manageGenerator'])->name('manage-generator-page');
    Route::post('/add-generator', [ModelController::class, 'addGenerator'])->name('add-generator-post');
    Route::post('/update-generator/{id}', [ModelController::class, 'updateGenerator'])->name('update-generator-post');
    Route::get('/delete-generator/{id}', [ModelController::class, 'deleteGenerator'])->name('delete-generator-get');

    //Manage Region
    Route::get('/manage-region', [RouteController::class, 'manageRegion'])->name('manage-region-page');
    Route::post('/add-region', [OtherSettingController::class, 'addRegion'])->name('add-region-post');
    Route::post('/update-region/{id}', [OtherSettingController::class, 'updateRegion'])->name('update-region-post');
    Route::get('/delete-region/{id}', [OtherSettingController::class, 'deleteRegion'])->name('delete-region-get');

    //Manage Product Group
    Route::get('/manage-product-group', [RouteController::class, 'manageProductGroup'])->name('manage-product-group-page');
    Route::post('/add-product-group', [OtherSettingController::class, 'addProductGroup'])->name('add-product-group-post');
    Route::post('/update-product-group/{id}', [OtherSettingController::class, 'updateProductGroup'])->name('update-product-group-post');
    Route::get('/delete-product-group/{id}', [OtherSettingController::class, 'deleteProductGroup'])->name('delete-product-group-get');

    //Manage Stock Location
    Route::get('/manage-stock-location', [RouteController::class, 'manageStockLocation'])->name('manage-stock-location-page');
    Route::post('/add-stock-location', [OtherSettingController::class, 'addStockLocation'])->name('add-stock-location-post');
    Route::post('/update-stock-location/{id}', [OtherSettingController::class, 'updateStockLocation'])->name('update-stock-location-post');
    Route::get('/delete-stock-location/{id}', [OtherSettingController::class, 'deleteStockLocation'])->name('delete-stock-location-get');
});
