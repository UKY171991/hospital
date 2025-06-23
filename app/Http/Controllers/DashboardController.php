<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Opd;
use App\Models\Ipd;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Room;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\SaleItem;
use App\Models\PurchaseItem;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\Complaint;
use App\Models\Enquiry;
use App\Models\IncomeExpense;
use App\Models\IncomeCategory;
use App\Models\Investigation;
use App\Models\DoctorSchedule;
use App\Models\Attendance;
use App\Models\AssignBed;
use App\Models\PostalDispatch;
use App\Models\PostalReceive;
use App\Models\CallLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $doctorsCount = Doctor::count();
        $patientsCount = Patient::count();
        $employeesCount = Employee::count();
        $usersCount = User::count();
        $hospitalsCount = Hospital::count();
        
        // Department & Infrastructure
        $departmentsCount = Department::count();
        $wardsCount = Ward::count();
        $bedsCount = Bed::count();
        $roomsCount = Room::count();
        $availableBeds = Bed::where('status', 'Available')->count();
        $occupiedBeds = Bed::where('status', 'Occupied')->count();
        
        // Patient Statistics
        $opdCount = Opd::count();
        $ipdCount = Ipd::count();
        $totalInOutPatients = $opdCount + $ipdCount;
        $todayOpdCount = Opd::whereDate('created_at', Carbon::today())->count();
        $todayIpdCount = Ipd::whereDate('created_at', Carbon::today())->count();
          // Inventory Statistics
        $itemsCount = Item::count();
        $suppliersCount = Supplier::count();
        $totalSales = SaleItem::sum('grand_total') ?? 0;
        $totalPurchases = PurchaseItem::sum('grand_total') ?? 0;
        $todaySales = SaleItem::whereDate('date', Carbon::today())->sum('grand_total') ?? 0;
        $todayPurchases = PurchaseItem::whereDate('date', Carbon::today())->sum('grand_total') ?? 0;
          // Financial Statistics
        $totalPayments = Payment::sum('paid_amount') ?? 0;
        $totalReceipts = Receipt::sum('receipt_amount') ?? 0;
        $todayPayments = Payment::whereDate('created_at', Carbon::today())->sum('paid_amount') ?? 0;
        $todayReceipts = Receipt::whereDate('created_at', Carbon::today())->sum('receipt_amount') ?? 0;
          // Income/Expense Statistics
        $totalIncome = IncomeExpense::where('type', 'Income')->sum('amount') ?? 0;
        $totalExpense = IncomeExpense::where('type', 'Expenses')->sum('amount') ?? 0;
        $netIncome = $totalIncome - $totalExpense;
        $monthlyIncome = IncomeExpense::where('type', 'Income')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount') ?? 0;
        $monthlyExpense = IncomeExpense::where('type', 'Expenses')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount') ?? 0;
          // Customer Service Statistics
        $complaintsCount = Complaint::count();
        $enquiriesCount = Enquiry::count();
        $pendingComplaints = Complaint::where('status', 'Pending')->count();
        $resolvedComplaints = Complaint::where('status', 'Resolved')->count();
        
        // Additional Statistics
        $investigationsCount = Investigation::count();
        $incomeCategoriesCount = IncomeCategory::count();
        $doctorSchedulesCount = DoctorSchedule::count();
        $attendanceCount = Attendance::whereDate('date', Carbon::today())->count();
        $assignedBedsCount = AssignBed::count();
        $postalDispatchCount = PostalDispatch::count();
        $postalReceiveCount = PostalReceive::count();
        $callLogsCount = CallLog::count();
          // Weekly Statistics
        $weeklyOpdCount = Opd::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $weeklyIpdCount = Ipd::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $weeklyPayments = Payment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('paid_amount') ?? 0;
        $weeklyReceipts = Receipt::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receipt_amount') ?? 0;
        
        // Monthly Statistics  
        $monthlyOpdCount = Opd::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        $monthlyIpdCount = Ipd::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        $monthlyNewPatients = Patient::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
          // Recent data for charts/lists
        $recentPatients = Patient::latest()->take(5)->get();
        $recentOpdPatients = Opd::with('patient')->latest()->take(5)->get();
        $recentPayments = Payment::latest()->take(5)->get();
        $recentReceipts = Receipt::latest()->take(5)->get();
        $recentComplaints = Complaint::latest()->take(3)->get();
        $recentInvestigations = Investigation::latest()->take(3)->get();

        return view('dashboard', compact(
            'doctorsCount',
            'patientsCount', 
            'employeesCount',
            'usersCount',
            'hospitalsCount',
            'departmentsCount',
            'wardsCount',
            'bedsCount',
            'roomsCount',
            'availableBeds',
            'occupiedBeds',
            'opdCount',
            'ipdCount',
            'totalInOutPatients',
            'todayOpdCount',
            'todayIpdCount',
            'itemsCount',
            'suppliersCount',
            'totalSales',
            'totalPurchases',
            'todaySales',
            'todayPurchases',
            'totalPayments',
            'totalReceipts',
            'todayPayments',
            'todayReceipts',
            'totalIncome',
            'totalExpense',
            'netIncome',
            'monthlyIncome',
            'monthlyExpense',
            'complaintsCount',
            'enquiriesCount',
            'pendingComplaints',
            'resolvedComplaints',
            'investigationsCount',
            'incomeCategoriesCount',
            'doctorSchedulesCount',
            'attendanceCount',
            'assignedBedsCount',
            'postalDispatchCount',
            'postalReceiveCount',
            'callLogsCount',
            'weeklyOpdCount',
            'weeklyIpdCount',
            'weeklyPayments',
            'weeklyReceipts',
            'monthlyOpdCount',
            'monthlyIpdCount',
            'monthlyNewPatients',
            'recentPatients',
            'recentOpdPatients',
            'recentPayments',
            'recentReceipts',
            'recentComplaints',
            'recentInvestigations'
        ));
    }
}
