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

//appointment
//Route::resource('/appointment', 'AppointmentController');
Route::get('/appointment', 'AppointmentController@index');
Route::get('/appointment/create', 'AppointmentController@create');
Route::post('/appointment', 'AppointmentController@store');
//staff appointment
Route::get('/appointment/staffindex', 'AppointmentController@staffIndex');
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
// Route::get('/pdf', function(){
//     $pdf = PDF::loadView('appointment.vista');
//     return $pdf->download('archivo.pdf');
// });

//test Login
Route::get('/', 'AppointmentController@login_temp');