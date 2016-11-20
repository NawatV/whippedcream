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
    return view('login');
//    return abort(404);
});
Route::get('/appoint', function () {
    return view('appoint');
});
// Route::get('/login', function () {
//     return view('login');
// });
//Route::get('/regis', function () {
//    return view('regis');
//});
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

//----- register ------
Route::get('/regis', 'RegisterController@getRegisterForm');
Route::post('/regis', 'RegisterController@postRegisterForm');
//-----login------
Route::get('/login', 'LoginController@getLoginForm');
Route::post('/login', 'LoginController@postLoginForm');

//----vitalSign-----
Route::get('/vitalsign', 'TreatmentController@getVitalSignForm');
Route::post('/vitalsign', 'TreatmentController@saveVitalSignForm');
//----diagnosis-----
Route::get('/diagnosis', 'TreatmentController@getDiagnosisForm');
Route::post('/diagnosis', 'TreatmentController@saveDiagnosisForm');



Route::any('{catchall}', function() {
    return Response::view('errors.404', array(), 404);
})->where('catchall', '.*');