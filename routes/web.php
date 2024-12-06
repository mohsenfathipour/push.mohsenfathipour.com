<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/admin/savepush', 'App\Http\Controllers\PushController@store');

Route::get('/admin', 'App\Http\Controllers\PushController@index');
Route::post('/admin/sendpush/{push}', 'App\Http\Controllers\PushController@send');
