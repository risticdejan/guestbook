<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("email/resend", [
    'uses' => "Auth\VerificationController@resend",
    'as' => 'verification.resend'
]);
// Route::get("email/verify", [
//     'uses' => "Auth\VerificationController@show",
//     'as' => 'verification.notice'
// ]);
Route::get("email/verify/{id}", [
    'uses' => "Auth\VerificationController@verify",
    'as' => 'verification.verify'
]);

Route::view('/', 'home');
Route::view('/{params}', 'home');
Route::view('/{params}/{params2}', 'home');
Route::view('/{params}/{params2}/{params3}', 'home');
Route::view('/{params}/{params2}/{params3}/{param4}', 'home');
