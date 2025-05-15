<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin_dashboard', function () {
    return view('admin_dashboard');
});

Route::get('/user/list', function () {
    return view('user_list');
});

Route::get('/user/password_pin', function () {
    return view('user_password_pin');
});
