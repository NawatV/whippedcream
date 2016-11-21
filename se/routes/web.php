<?php

/* 	//Flow: No.1-Route
	
	Web Routes : This file is where you may define all of the routes that are handled
   				  by your application. 
   			   :  The order has an effect to the system's flow 
   	Everything is in "https://laravel.com/docs/5.3"                               */

//-------------- Login ----------------------------------------------
Route::get('/', 'UserController@loginForm');
Route::get('/login', 'UserController@loginForm');
Route::post('/login', 'UserController@postLoginForm');

/*It causes (Route(in the group)--must pass-->Middleware-->Function )
	   https://laravel.com/docs/5.3/routing  */
Route::group(['middleware' => 'login'], function (){
	/*
	Route::get('/', function ()    {
        // Uses Auth Middleware
    });
    */
});

//-----Register------
Route::get('/register', 'UserController@registerForm');
Route::post('/register', 'UserController@postRegisterForm');

Route::get('/appoint', function () {
    return view('appoint');
});

//-------------- Schedule -----------------------------------------
Route::get('/schedule', 'ScheduleController@viewSchedule');
Route::post('/schedule', 'ScheduleController@addAbsent');
Route::post('/schedule/staff', 'ScheduleController@viewScheduleStaff');     

/*It causes (Route(in the group)--must pass-->Middleware-->Function )
	   https://laravel.com/docs/5.3/routing  */
Route::group(['middleware' => 'schedule'], function (){
	/*
	Route::get('/', function ()    {
        // Uses Auth Middleware
    });
    */
});

// **************
/*
//ajax
Route::get('/queryDoctorDateTime', 'AppointmentController@queryDoctorDateTime');
Route::get('/queryDoctor', 'AppointmentController@queryDoctor');
Route::get('/queryPeriod', 'AppointmentController@queryPeriod');
*/
//**************

Route::get('/dispention', function () {
    return view('dispention');
});
Route::get('/diagnosisnext', function () {
    return view('diagnosisnext');
});
Route::get('/blank', function () {
    return view('blank');
});

//----vitalSign-----
Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');
Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');
//----diagnosis-----
Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');
Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');


//----- Else case -----
Route::any('{catchall}', function() {
    return Response::view('errors.404', array(), 404);
})->where('catchall', '.*');