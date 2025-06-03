<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\ContactController;

use \App\Http\Middleware\Authenticate;

Route::get('/', function () {
    return view('layouts');
});
Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});
Route::middleware(Authenticate::class)->group(function() {
    Route::controller(DashboardController::class)->group(function() {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::post('/logout', 'logout')->name('logout');
    });
    Route::resource('contacts', ContactController::class);
    Route::controller(ContactController::class)->group(function() {
        Route::get('/uploadxml', 'uploadxml')->name('contacts.uploadxml');
        Route::post('/import', 'import')->name('contacts.import');
    });
});