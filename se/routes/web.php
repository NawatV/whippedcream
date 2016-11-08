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
Route::get('/diagnosis', function () {
    return view('diagnosis');
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

Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');

Route::post('/vitalsign', 'TreatmentController@save');
