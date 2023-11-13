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

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('password.confirm');

Route::get('/password-confirmed', function () {
    return 'Password Confirmed.';
})->middleware('password.confirm');

Route::view('/home', 'home')->middleware(['auth', 'auth.session', 'verified'])->name('home');
Route::view('/update-profile-information', 'common.account.update-profile-information')->middleware(['auth', 'auth.session'])->name('update-profile-information');
Route::view('/update-password', 'common.account.update-password')->middleware(['auth', 'auth.session', 'verified'])->name('update-password');

Route::view('/security/two-factor', 'common.security.two-factor')->middleware(['auth', 'auth.session', 'verified'])->name('security.two-factor');