<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/employee/manage', [EmployeeController::class, 'index'])->name('employee.manage');
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::put('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
