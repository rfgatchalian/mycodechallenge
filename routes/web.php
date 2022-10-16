<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/register/{invite_code?}',[App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::get('/referral', [App\Http\Controllers\HomeController::class, 'index'])->name('referral');
Route::post('/send-invite', [App\Http\Controllers\HomeController::class, 'sendInvite'])->name('sendInvite');

