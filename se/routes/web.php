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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/appoint', function () {
    return view('appoint');
});
Route::get('/regis', function () {
    return view('regis');
});
Route::get('/schedule', function () {
    return view('schedule');
});
Route::get('/dispention', function () {
    return view('dispention');
});

Route::get('/diagnosisnext', function () {
    return view('diagnosisnext');
});
Route::get('/blank', function () {
    return view('blank');
});
Route::get('/login', function () {
    return view('login');
});

Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');

Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');

Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');

Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');

Route::resource('/appointment', 'AppointmentController');
Route::get('/queryDoctor', 'AppointmentController@queryDoctor');
Route::get('/test1', function () { return "hello i am ton"; });
Route::get('/appointment/test', function () { return view('appointment.test'); });
//Route::get('/appointment', 'AppointmentController@index');
//Route::get('/appointment/create', 'AppointmentController@create');
//Route::post('/queryDoctor', 'AppointmentController@store');
