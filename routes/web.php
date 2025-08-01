<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ImplantController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\OtherSettingController;
use App\Http\Controllers\SalesBillingController;
use App\Http\Controllers\HospitalDoctorController;


Route::get('/',function () {
    return redirect()->route('login-page');
});

Route::prefix('auth')->group(function () {
    //Login Page
    Route::get('/login', [RouteController::class, 'loginPage'])->name('login-page');
    Route::post('/authenticate-staff', [AuthenticateController::class, 'staffLogin'])->name('staff-login-post');

    // Forgot Password
    Route::get('/forgot-password', [RouteController::class, 'forgotPasswordPage'])->name('forgot-password-page');
    Route::post('/send-email-password', [AuthenticateController::class, 'sendEmailPassword'])->name('send-email-password-post');

    // Guest Patient ID Card Download
    Route::get('/guest-view-patient-id-card-{id}-{opt}-{type}', [RouteController::class, 'viewDownloadPatientIdCard'])->name('guest-view-patient-id-card-page');

});

Route::prefix('staff')->middleware('auth')->group(function () {
    //Homepage
    Route::get('/dashboard', [RouteController::class, 'staffDashboard'])->name('staff-dashboard-page');

    //Account Setting
    Route::get('/my-account', [RouteController::class, 'staffAccount'])->name('staff-account-page');
    Route::post('/update-account/{id}', [AuthenticateController::class, 'staffAccountUpdate'])->name('staff-account-update-post');
    Route::post('/update-password/{id}', [AuthenticateController::class, 'staffPasswordUpdate'])->name('staff-password-update-post');
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

    // MANAGE IMPLANT > APPROVAL TYPE
    Route::get('/get-approval-type', [ImplantController::class, 'getApprovalType'])->name('get-approval-type-get');
    Route::post('/add-approval-type', [ImplantController::class, 'addApprovalType'])->name('add-approval-type-post');
    Route::post('/delete-approval-type', [ImplantController::class, 'deleteApprovalType'])->name('delete-approval-type-post');

    //Generate Patient ID Card
    Route::get('/generate-patient-id-card-{id}', [RouteController::class, 'generatePatientIdCard'])->name('generate-patient-id-card-page');
    Route::get('/view-patient-id-card-{id}-{opt}-{type}', [RouteController::class, 'viewDownloadPatientIdCard'])->name('view-patient-id-card-page');
    Route::post('/patient-id-card-preview-{id}', [ImplantController::class, 'previewPatientIDCard'])->name('patient-id-card-preview-post');
    Route::post('/send-pt-id-card-email/{id}', [ImplantController::class, 'sendPatientIDCard'])->name('send-pt-id-card-email-post');

    // MANAGE SALES BILLING
    Route::get('/manage-sales-billing', [RouteController::class, 'manageSalesBilling'])->name('manage-sales-billing');
    Route::get('/view-icf-editable-{id}', [RouteController::class, 'viewInventoryConsumptionFormEditable'])->name('view-editable-icf-page');
    Route::post('/confirm-icf-data/{id}', [SalesBillingController::class, 'confirmICFData'])->name('confirm-icf-post');
    Route::get('/icf-document/{id}/{opt}', [SalesBillingController::class, 'generatePreviewDownloadICF'])->name('icf-document-get');
    Route::get('/upload-document-area-{id}', [RouteController::class, 'uploadDocumentArea'])->name('upload-document-area-page');
    Route::post('/upload-document-{id}', [SalesBillingController::class, 'uploadDocument'])->name('upload-document-post');
    Route::post('/delete-uploaded-document', [SalesBillingController::class, 'deleteUploadedFile'])->name('delete-upload-document-post');
    Route::get('/view-document/{path}', [SalesBillingController::class, 'viewUploadedDocument'])->where('path', '.*')->name('view-uploaded-document-get');

    //QUOTATION > MANAGE QUOTATION
    Route::get('/manage-quotation', [RouteController::class, 'manageQuotation'])->name('manage-quotation-page');
    Route::get('/generate-quotation', [RouteController::class, 'generateQuotation'])->name('generate-quotation-page');
    Route::get('/get-model-list-{generatorid}', [QuotationController::class, 'getModelList'])->name('get-model-list');
    Route::get('/quotation-document/{id}/{opt}', [QuotationController::class, 'generatePreviewDownloadQuotation'])->name('quotation-document-get');
    Route::get('/preview-quotation-{id}', [QuotationController::class, 'viewPreviewQuotation'])->name('view-quotation-get');
    Route::post('/add-quotation', [QuotationController::class, 'addQuotation'])->name('add-quotation-post');
    Route::get('/update-quotation-{id}', [RouteController::class, 'updateQuotation'])->name('update-quotation-page');
    Route::post('/update-quotation/{id}', [QuotationController::class, 'updateQuotation'])->name('update-quotation-post');
    Route::get('/delete-quotation/{id}', [QuotationController::class, 'deleteQuotation'])->name('delete-quotation-get');


    //QUOTATION > MANAGE COMPANY
    Route::get('/manage-company', [RouteController::class, 'manageCompany'])->name('manage-company-page');
    Route::post('/add-company', [QuotationController::class, 'addCompany'])->name('add-company-post');
    Route::post('/update-company/{id}', [QuotationController::class, 'updateCompany'])->name('update-company-post');
    Route::get('/delete-company/{id}', [QuotationController::class, 'deleteCompany'])->name('delete-company-get');


    //QUOTATION > ASSIGN GENERATOR AND MODEL
    Route::get('/assign-generator-model', [RouteController::class, 'assignGeneratorModel'])->name('assign-generator-model-page');
    Route::post('/add-assign-generator-model', [QuotationController::class, 'addAssignGeneratorModel'])->name('add-assign-generator-model-post');
    Route::post('/update-assign-generator-model/{generator_id}', [QuotationController::class, 'updateAssignGeneratorModel'])->name('update-assign-generator-model-post');
    Route::get('/delete-assign-generator-model/{generator_id}', [QuotationController::class, 'deleteAssignGeneratorModel'])->name('delete-assign-generator-model-get');


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
