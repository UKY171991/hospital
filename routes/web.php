<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemController; // Add this line
use App\Http\Controllers\SaleController; // Add this line

Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('employee.show');

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
Route::delete('/employee/destroy/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

// Item Routes
Route::resource('items', ItemController::class)->parameters([
    'items' => 'item' // Optional: to use {item} instead of {items} in route parameters if you prefer singular
]);
// Custom route for item manage page if you want a specific URL like /item/manage
Route::get('/item/manage', [ItemController::class, 'index'])->name('item.manage');

// Sale Routes
Route::get('/sale/create', [SaleController::class, 'create'])->name('sale.create');
Route::post('/sale/store', [SaleController::class, 'store'])->name('sale.store');
Route::get('/sale/manage', [SaleController::class, 'index'])->name('sale.manage'); // Added for listing sales
Route::get('/sale/show/{sale}', [SaleController::class, 'show'])->name('sale.show'); // Added for viewing a single sale

// Add route for PurchaseController store method
Route::post('/purchase/store', [PurchaseController::class, 'store'])->name('purchase.store');
