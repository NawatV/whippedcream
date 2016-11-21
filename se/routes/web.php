<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//-----Login------
Route::get('/', 'UserController@loginForm');
Route::get('/login', 'UserController@loginForm');
Route::post('/login', 'UserController@postLoginForm');

Route::get('/logout', 'OtherController@logout');

//-----Register------
Route::get('/register', 'UserController@registerForm');
Route::post('/register', 'UserController@postRegisterForm');


//Need to login first
Route::group(['middleware' => 'login'], function () {
    Route::get('/homepage', 'OtherController@homepage');

//    ===================================================================================================
//    ===================================================================================================
//    ===================================================================================================

    /*routes for admin*/
    Route::get('/manageAccount', 'ManageAccountController@display_users');
    Route::post('/manageAccount', 'ManageAccountController@edit_user');

    Route::get('/createStaff', 'CreateAccountController@create_staff_form');
    Route::post('/createStaff', 'CreateAccountController@create_staff');

    Route::get('/createDoctor', 'CreateAccountController@create_doctor_form');
    Route::post('/createDoctor', 'CreateAccountController@create_doctor');

    Route::get('/createNurse', 'CreateAccountController@create_nurse_form');
    Route::post('/createNurse', 'CreateAccountController@create_nurse');

    Route::get('/createPharmacist', 'CreateAccountController@create_pharmacist_form');
    Route::post('/createPharmacist', 'CreateAccountController@create_pharmacist');

    Route::get('/createAdmin', 'CreateAccountController@create_admin_form');
    Route::post('/createAdmin', 'CreateAccountController@create_admin');

    Route::get('/manageDepartment', 'ManageDepartmentController@display_all_department');
    Route::post('/manageDepartment', 'ManageDepartmentController@edit_department');



//    ===================================================================================================
//    ===================================================================================================
//    ===================================================================================================



//ดูประวัติผู้ป่วย
    Route::get('/searchPatientInformation', 'UserController@getSearchPatientInformation');
    Route::post('/searchPatientInformation', 'UserController@findPatientFromHnIdName');


//แก้ไขประวัติผู้ป่วย
    Route::post('/editPatientInformation', 'UserController@searchPatientFromHnIdNameForEditProfile');
    Route::post('/showNewProfile', 'UserController@editPatientInformation');


//ดูประวัติผู้ป่วยตัวเอง
    Route::get('/myPatientInformation', 'UserController@myPatientInformation');
//แก้ประวัติผู้ป่วยตัวเอง
    Route::post('/myEditedPatientInformation', 'UserController@editMyPatientInformation');
    Route::post('/seeEditedMyPatientInformation', 'UserController@seeEditedMyPatientInformation');


//แก้ไขประวัติคำวินิจฉัย
//Route::get('/editDiagnosisHistory', 'DiagnosisHistoryController@editDiagnosisHistory');
    Route::post('/findPatientFromHnIdNameForDiagnosis', 'DiagnosisHistoryController@findPatientFromHnIdNameForDiagnosis');
//Route::post('/findPatientFromHnIdName/edit', 'DiagnosisHistoryController@editDiagnosis');
    Route::get('/findPatientFromHnIdNameForDiagnosis/{diagnosis}/edit', 'DiagnosisHistoryController@editDiagnosisHistoryForm');
    Route::post('/editDiagnosisHistory/{diagnosisId}/confirm', 'DiagnosisHistoryController@confirm');
    Route::post('/editDiagnosisHistory/{diagnosisId}/delete', 'DiagnosisHistoryController@delete');


//แก้ไขประวัติอาการทั่วไป
//Route::get('/editDiagnosisHistory', 'DiagnosisHistoryController@editDiagnosisHistory');
    Route::post('/findPatientFromHnIdNameForVitalSign', 'VitalSignHistoryController@findPatientFromHnIdNameForVitalSign');
//Route::post('/findPatientFromHnIdName/edit', 'DiagnosisHistoryController@editDiagnosis');
    Route::post('/seeVitalSignHistory', 'VitalSignHistoryController@seeVitalSignHistory');
    Route::post('/seeEditVitalSignHistory', 'VitalSignHistoryController@seeEditVitalSignHistory');
    Route::post('/editVitalSignHistory', 'VitalSignHistoryController@editVitalSignHistory');


    Route::get('/createDepartment', 'CreateDepartmentController@create_department_form');
    Route::post('/createDepartment', 'CreateDepartmentController@create_department');
    /*end-routes for admin*/

//    ===================================================================================================
//    ===================================================================================================
//    ===================================================================================================

//----vitalSign-----

    Route::get('/dispensation/list', 'TreatmentController@getNumberPrescription');
    Route::get('/dispensation/{id}', 'TreatmentController@getPrescription');
    Route::get('/dispensation/confirm/{id}', 'TreatmentController@confirmPrescription');

    Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');
    Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');

//----diagnosis-----
    Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');
    Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');


//    ===================================================================================================
//    ===================================================================================================
//    ===================================================================================================

    //appointment
//Route::resource('/appointment', 'AppointmentController');
    Route::get('/appointment', 'AppointmentController@index');
    Route::get('/appointment/create', 'AppointmentController@create');
    Route::post('/appointment', 'AppointmentController@store');
//staff appointment
    Route::get('/appointment/staffindex', 'AppointmentController@staffIndex');
    Route::get('/appointment/staffindexall', 'AppointmentController@staffSearchPatient');
    Route::get('/appointment/staffsearchpatientfound', 'AppointmentController@staffSearchPatientFound');

    Route::get('/appointment/staffcreate', 'AppointmentController@staffCreate');
    Route::post('/appointment/staffstore', 'AppointmentController@staffStore');
//walkin appointment
    Route::get('/appointment/walkincreate', 'AppointmentController@walkInCreate');
    Route::post('/appointment/walkinstore', 'AppointmentController@walkInStore');

    Route::get('/appointment/{appointment}/edit', 'AppointmentController@edit');
    Route::post('/appointment/{appointment}', 'AppointmentController@update');
    Route::post('/deleteAppointment/{appointment}', 'AppointmentController@destroy');
//ajax
    Route::get('/queryDoctorDateTime', 'AppointmentController@queryDoctorDateTime');
    Route::get('/queryDoctor', 'AppointmentController@queryDoctor');
    Route::get('/queryDoctorWalkIn', 'AppointmentController@queryDoctorWalkIn');
    Route::get('/queryPeriod', 'AppointmentController@queryPeriod');
    Route::get('/queryPeriodWalkIn', 'AppointmentController@queryPeriodWalkIn');
//pdf
    Route::get('/appointment/{appointment}/appointmentpdf', 'AppointmentController@appointmentPdf');

//    ===================================================================================================
//    ===================================================================================================
//    ===================================================================================================


    //แก้ไขประวัติการสั่งยา
    Route::get('/editPrescriptionHistory', 'PrescriptionHistoryController@editPrescriptionHistory');

    Route::get('/editDiagnosisHistory', 'DiagnosisHistoryController@editDiagnosisHistory');

//ดูประวัติการสั่งยาของแพทย์
    Route::get('/viewPrescriptionHistory', 'PrescriptionHistoryController@viewPrescriptionHistory');

//ดูประวัติคำวินิจฉัย
    Route::get('/viewDiagnosisHistory', 'DiagnosisHistoryController@viewDiagnosisHistory');


    //    ===================================================================================================
//    ===================================================================================================
//    ===================================================================================================


});

//-------------- Schedule -----------------------------------------
Route::get('/schedule', 'ScheduleController@viewSchedule');
Route::post('/schedule', 'ScheduleController@addAbsent');
Route::post('/schedule/staff', 'ScheduleController@viewScheduleStaff');






Route::get('/testCurlMessage/', 'DiagnosisHistoryController@sendSms');


Route::get('/createAdmin2', 'FirstAdminController@create_admin_form');
Route::post('/createAdmin2', 'FirstAdminController@create_admin');
Route::get('/manageAccount2', 'FirstAdminController@display_users');
Route::post('/manageAccount2', 'FirstAdminController@edit_user');


Route::get('/blank', 'OtherController@blankPage');
Route::get('/test', 'OtherController@testPage');

//========================================================================================================
//=========================== เอา Route ทั้งหมด ไว้ข้างบน เท่านั้น !!! =======================================
//========================================================================================================

Route::any('{catchall}', function () {
    return Response::view('errors.404', array(), 404);
})->where('catchall', '.*');