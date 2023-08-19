<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/get_req', function (Request $request) {
    return $request->all();
});

Route::get('/get_expected_error', 'HomeController@index');

Route::get('/get_unexpected_error', function (Request $request) {
    new john();
    return $request->all();
});