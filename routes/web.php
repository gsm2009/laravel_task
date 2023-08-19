<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/expected_error', function (Request $request) {
    $validation_error = \Illuminate\Validation\ValidationException::withMessages([
        'Validation failed'
    ]);
    $validation_error->statusCode = 401;
    throw $validation_error;
});

Route::get('/unexpected_error', function (Request $request) {
    new john();
    return $request->all();
});

Route::get('/valid_bracket', function (Request $request) {
    $s = $request->get('s');
    return isValidBracket($s);
});