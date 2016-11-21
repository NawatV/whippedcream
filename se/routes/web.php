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

//<<<<<<< HEAD
//Before login ========================================
//Before login ========================================

//Landing
Route::get('/', function () {
//    return view('landingPage');
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('regis');
});



//After login ==========================================
//After login ==========================================

//แก้ไขประวัติการสั่งยา
Route::get('/editPrescriptionHistory', 'PrescriptionHistoryController@editPrescriptionHistory');


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


Route::get('/testCurlMessage', 'DiagnosisHistoryController@sendSms');
Route::post('/testEmail', 'DiagnosisHistoryController@sendEmail');


Route::get('/editDiagnosisHistory', 'DiagnosisHistoryController@editDiagnosisHistory');



//ดูประวัติการสั่งยาของแพทย์
Route::get('/viewPrescriptionHistory', 'PrescriptionHistoryController@viewPrescriptionHistory');

//ดูประวัติคำวินิจฉัย
Route::get('/viewDiagnosisHistory', 'DiagnosisHistoryController@viewDiagnosisHistory');






//=======
//Route::get('/', 'TreatmentController@login_temp');
//>>>>>>> 9475d4de8f09ca6b010512f737155b27c2ddfe24

Route::get('/appoint', function () {
    return view('appoint');
});
Route::get('/regis', function () {
    return view('regis');
});
Route::get('/schedule', function () {
    return view('schedule');
});
//<<<<<<< HEAD
Route::get('/dispention', function () {
    return view('dispention');
});

Route::get('/diagnosisnext', function () {
    return view('diagnosisnext');
});
//=======

//>>>>>>> 9475d4de8f09ca6b010512f737155b27c2ddfe24
Route::get('/blank', function () {
    return view('blank');
});


Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');

Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');

Route::get('/dispensation', 'TreatmentController@getDispensationPage');

Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');

Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');

Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');

Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');
//<<<<<<< HEAD

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

Route::get('/createDepartment', 'CreateDepartmentController@create_department_form');
Route::post('/createDepartment', 'CreateDepartmentController@create_department');
/*end-routes for admin*/
//=======
//>>>>>>> 9475d4de8f09ca6b010512f737155b27c2ddfe24
