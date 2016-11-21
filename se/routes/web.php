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
Route::group(['middleware' => 'login'], function (){
    Route::get('/homepage', 'OtherController@homepage');
});



Route::get('/blank', 'OtherController@blankPage');

//----vitalSign-----
Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');
Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');



//----diagnosis-----
Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');
Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');


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






//========================================================================================================
//=========================== เอา Route ทั้งหมด ไว้ข้างบน เท่านั้น !!! =======================================
//========================================================================================================

Route::any('{catchall}', function() {
    return Response::view('errors.404', array(), 404);
})->where('catchall', '.*');



