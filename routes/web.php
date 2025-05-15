<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;

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

Route::get('/hospital/manage', [HospitalController::class, 'index'])->name('hospital.manage');
Route::get('/hospital/create', [HospitalController::class, 'create'])->name('hospital.create');
Route::post('/hospital/store', [HospitalController::class, 'store'])->name('hospital.store');
Route::get('/hospital/edit/{id}', [HospitalController::class, 'edit'])->name('hospital.edit');
Route::put('/hospital/update/{id}', [HospitalController::class, 'update'])->name('hospital.update');
