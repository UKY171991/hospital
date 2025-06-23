<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeAssignController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\AssignBedController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\ItemStockController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PostalDispatchController;
use App\Http\Controllers\PostalReceiveController;
use App\Http\Controllers\CallLogController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\BalanceSheetController;

Route::get('/', function () {
    return view('welcome');
});

// Health check route for testing
Route::get('/test', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'Hospital Management System is working',
        'timestamp' => now(),
        'modules' => [
            'authentication' => 'working',
            'database' => 'connected',
            'routes' => 'loaded'
        ]
    ]);
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/employee', function () {
    return redirect('/employees');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('users/status/{id}', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('hospitals', App\Http\Controllers\HospitalController::class);
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    Route::post('employees/toggle-status/{id}', [App\Http\Controllers\EmployeeController::class, 'toggleStatus']);
    Route::resource('item', App\Http\Controllers\ItemController::class);
    Route::post('item/toggle-status/{id}', [App\Http\Controllers\ItemController::class, 'toggleStatus']);
    Route::resource('department', App\Http\Controllers\DepartmentController::class);
    Route::get('department-test', [App\Http\Controllers\DepartmentController::class, 'testDataTable']);
    Route::get('department-debug', [App\Http\Controllers\DepartmentController::class, 'debug']);
    Route::get('department-test-page', function() { return view('department.test'); });
    Route::get('department-new', function() { return view('department.index_new'); });
    Route::post('department/toggle-status/{id}', [App\Http\Controllers\DepartmentController::class, 'toggleStatus']);
    Route::resource('fee_assign', FeeAssignController::class);
    Route::resource('investigation', InvestigationController::class);
    Route::post('investigation/toggle-status/{id}', [InvestigationController::class, 'toggleStatus']);
    Route::resource('ward', WardController::class);
    Route::post('ward/toggle-status/{id}', [WardController::class, 'toggleStatus']);
    Route::resource('bed', BedController::class);
    Route::resource('assign_bed', AssignBedController::class);
    Route::resource('disease', DiseaseController::class);
    Route::resource('room', RoomController::class);
    Route::resource('doctor', App\Http\Controllers\DoctorController::class);
    Route::post('doctor/toggle-status/{id}', [App\Http\Controllers\DoctorController::class, 'toggleStatus']);
    Route::get('doctor/print/{id}', [App\Http\Controllers\DoctorController::class, 'print'])->name('doctor.print');
    Route::get('doctor/id_card/{id}', [App\Http\Controllers\DoctorController::class, 'idCard'])->name('doctor.id_card');
    Route::get('schedule/doctors', [App\Http\Controllers\DoctorScheduleController::class, 'getDoctors']);
    Route::post('schedule/toggle-status/{id}', [App\Http\Controllers\DoctorScheduleController::class, 'toggleStatus']);
    Route::resource('schedule', App\Http\Controllers\DoctorScheduleController::class);
    Route::get('attendance/employees', [App\Http\Controllers\AttendanceController::class, 'employees']);
    Route::get('attendance/doctors', [App\Http\Controllers\AttendanceController::class, 'doctors']);
    Route::resource('attendance', App\Http\Controllers\AttendanceController::class);
    Route::resource('patients', App\Http\Controllers\PatientController::class);
    Route::resource('opd', App\Http\Controllers\OpdController::class);
    Route::resource('ipd', App\Http\Controllers\IpdController::class);
    Route::resource('item_mapping', App\Http\Controllers\ItemMappingController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('sale_item', SaleItemController::class);
    Route::get('sale_item/print/{id}', [SaleItemController::class, 'print'])->name('sale_item.print');
    Route::resource('purchase_item', PurchaseItemController::class);
    Route::get('purchase_item/print/{id}', [PurchaseItemController::class, 'print'])->name('purchase_item.print');
    Route::get('item_stock', [ItemStockController::class, 'index'])->name('item_stock.index');
    Route::prefix('complaint-type')->group(function () {
        Route::get('/', [ComplaintTypeController::class, 'index'])->name('complaint_type.index');
        Route::get('/manage', [ComplaintTypeController::class, 'index']);
        Route::post('/store', [ComplaintTypeController::class, 'store'])->name('complaint_type.store');
        Route::post('/update/{id}', [ComplaintTypeController::class, 'update'])->name('complaint_type.update');
        Route::delete('/delete/{id}', [ComplaintTypeController::class, 'destroy'])->name('complaint_type.destroy');
        Route::post('/toggle-status/{id}', [ComplaintTypeController::class, 'toggleStatus'])->name('complaint_type.toggle_status');
    });
    Route::prefix('reference')->group(function () {
        Route::get('/', [ReferenceController::class, 'index'])->name('reference.index');
        Route::get('/manage', [ReferenceController::class, 'index']);
        Route::post('/store', [ReferenceController::class, 'store'])->name('reference.store');
        Route::post('/update/{id}', [ReferenceController::class, 'update'])->name('reference.update');
        Route::delete('/delete/{id}', [ReferenceController::class, 'destroy'])->name('reference.destroy');
        Route::post('/toggle-status/{id}', [ReferenceController::class, 'toggleStatus'])->name('reference.toggle_status');
    });
    Route::prefix('enquiry')->group(function () {
        Route::get('/', [EnquiryController::class, 'index'])->name('enquiry.index');
        Route::get('/manage', [EnquiryController::class, 'index']);
        Route::post('/store', [EnquiryController::class, 'store'])->name('enquiry.store');
        Route::post('/update/{id}', [EnquiryController::class, 'update'])->name('enquiry.update');
        Route::delete('/delete/{id}', [EnquiryController::class, 'destroy'])->name('enquiry.destroy');
        Route::post('/toggle-status/{id}', [EnquiryController::class, 'toggleStatus'])->name('enquiry.toggle_status');
    });
    Route::prefix('complaint')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('complaint.index');
        Route::get('/manage', [ComplaintController::class, 'index']);
        Route::post('/store', [ComplaintController::class, 'store'])->name('complaint.store');
        Route::post('/update/{id}', [ComplaintController::class, 'update'])->name('complaint.update');
        Route::delete('/delete/{id}', [ComplaintController::class, 'destroy'])->name('complaint.destroy');
        Route::post('/toggle-status/{id}', [ComplaintController::class, 'toggleStatus'])->name('complaint.toggle_status');
    });
    Route::prefix('postal-dispatch')->group(function () {
        Route::get('/', [PostalDispatchController::class, 'index'])->name('postal_dispatch.index');
        Route::get('/manage', [PostalDispatchController::class, 'index']);
        Route::post('/store', [PostalDispatchController::class, 'store'])->name('postal_dispatch.store');
        Route::post('/update/{id}', [PostalDispatchController::class, 'update'])->name('postal_dispatch.update');
        Route::delete('/delete/{id}', [PostalDispatchController::class, 'destroy'])->name('postal_dispatch.destroy');
        Route::post('/toggle-status/{id}', [PostalDispatchController::class, 'toggleStatus'])->name('postal_dispatch.toggle_status');
    });
    Route::prefix('postal-receive')->group(function () {
        Route::get('/', [PostalReceiveController::class, 'index'])->name('postal_receive.index');
        Route::get('/manage', [PostalReceiveController::class, 'index']);
        Route::post('/store', [PostalReceiveController::class, 'store'])->name('postal_receive.store');
        Route::post('/update/{id}', [PostalReceiveController::class, 'update'])->name('postal_receive.update');
        Route::delete('/delete/{id}', [PostalReceiveController::class, 'destroy'])->name('postal_receive.destroy');
        Route::post('/toggle-status/{id}', [PostalReceiveController::class, 'toggleStatus'])->name('postal_receive.toggle_status');
    });
    Route::prefix('call-log')->group(function () {
        Route::get('/', [CallLogController::class, 'index'])->name('call_log.index');
        Route::get('/manage', [CallLogController::class, 'index']);
        Route::post('/store', [CallLogController::class, 'store'])->name('call_log.store');
        Route::post('/update/{id}', [CallLogController::class, 'update'])->name('call_log.update');
        Route::delete('/delete/{id}', [CallLogController::class, 'destroy'])->name('call_log.destroy');
        Route::post('/toggle-status/{id}', [CallLogController::class, 'toggleStatus'])->name('call_log.toggle_status');
    });
    Route::resource('income_category', IncomeCategoryController::class);
    Route::resource('income_item', App\Http\Controllers\IncomeItemController::class);
    // IncomeExpense routes
    Route::get('income_expense', [App\Http\Controllers\IncomeExpenseController::class, 'index']);
    Route::get('income_expense/{id}', [App\Http\Controllers\IncomeExpenseController::class, 'show']);
    Route::post('income_expense/store', [App\Http\Controllers\IncomeExpenseController::class, 'store']);
    Route::post('income_expense/update/{id}', [App\Http\Controllers\IncomeExpenseController::class, 'update']);
    Route::delete('income_expense/delete/{id}', [App\Http\Controllers\IncomeExpenseController::class, 'destroy']);
    Route::resource('payment', PaymentController::class);
    Route::resource('receipt', ReceiptController::class);
    Route::get('/quick-receipt', [App\Http\Controllers\ReceiptController::class, 'index'])->name('quick-receipt');
    Route::get('/reports/ledger', function() {
        return view('reports.ledger');
    })->name('reports.ledger');
    Route::get('/reports/patient', function() {
        return view('reports.patient');
    })->name('reports.patient');
    Route::get('/reports/balance-sheet', [App\Http\Controllers\BalanceSheetController::class, 'index']);
    Route::resource('ledgers', LedgerController::class);
    Route::resource('balance-sheet', BalanceSheetController::class);
    Route::get('/patients/register', function() {
        return view('patients.register');
    })->name('patients.register');
});

require __DIR__.'/auth.php';
