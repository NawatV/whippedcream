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









//========================================================================================================
//=========================== เอา Route ทั้งหมด ไว้ข้างบน เท่านั้น !!! =======================================
//========================================================================================================

Route::any('{catchall}', function() {
    return Response::view('errors.404', array(), 404);
})->where('catchall', '.*');