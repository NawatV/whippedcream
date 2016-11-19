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

Route::get('/', 'TreatmentController@login_temp');

Route::get('/appoint', function () {
    return view('appoint');
});
Route::get('/regis', function () {
    return view('regis');
});
Route::get('/schedule', function () {
    return view('schedule');
});

Route::get('/blank', function () {
    return view('blank');
});
Route::get('/login', function () {
    return view('login');
});

Route::get('/dispensation', 'TreatmentController@getDispensationPage');

Route::post('/dispensation', 'TreatmentController@editPrescription');

Route::get('/dispensation/list', 'TreatmentController@getNumberPrescription');

Route::get('/dispensation/{id}', 'TreatmentController@getPrescription');

Route::get('/dispensation/confirm/{id}', 'TreatmentController@confirmPrescription');

Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');

Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');

Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');

Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');
