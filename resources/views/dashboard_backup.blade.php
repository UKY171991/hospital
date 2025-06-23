@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 fw-bold">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h1>
                <p class="text-muted">Here's an overview of your hospital dashboard - {{ date('F d, Y') }}</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Quick Stats Row -->
    <div class="row g-3 mb-4">
        <!-- Doctors -->
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $doctorsCount }}</h3>
                        <div class="small">Total Doctors</div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('doctor.index') }}" class="btn btn-light btn-sm opacity-75">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Patients -->
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-success h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-injured fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $patientsCount }}</h3>
                        <div class="small">Total Patients</div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('patients.index') }}" class="btn btn-light btn-sm opacity-75">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Employees -->
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-info h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $employeesCount }}</h3>
                        <div class="small">Total Employees</div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm opacity-75">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Revenue -->
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">₹{{ number_format($netIncome, 0) }}</h3>
                        <div class="small">Net Revenue</div>
                    </div>
                    <div class="text-end">
                        <a href="{{ url('/reports/balance-sheet') }}" class="btn btn-light btn-sm opacity-75">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics Row -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-purple h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-calendar-week fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $weeklyOpdCount + $weeklyIpdCount }}</h3>
                        <div class="small">Weekly Patients</div>
                    </div>
                    <div class="text-end">
                        <small class="opacity-75">OPD: {{ $weeklyOpdCount }}<br>IPD: {{ $weeklyIpdCount }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-dark h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-calendar-month fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $monthlyNewPatients }}</h3>
                        <div class="small">New Patients This Month</div>
                    </div>
                    <div class="text-end">
                        <small class="opacity-75">{{ date('F') }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-teal h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-clock fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $attendanceCount }}</h3>
                        <div class="small">Today's Attendance</div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('attendance.index') }}" class="btn btn-light btn-sm opacity-75">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm text-white bg-gradient-orange h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-vials fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $investigationsCount }}</h3>
                        <div class="small">Total Investigations</div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('investigation.index') }}" class="btn btn-light btn-sm opacity-75">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient & Bed Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-procedures text-primary me-2"></i>
                        Patient Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3 border-end">
                                <div class="h4 text-primary mb-1">{{ $opdCount }}</div>
                                <div class="small text-muted">OPD Patients</div>
                                <div class="small text-success">+{{ $todayOpdCount }} today</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border-end">
                                <div class="h4 text-info mb-1">{{ $ipdCount }}</div>
                                <div class="small text-muted">IPD Patients</div>
                                <div class="small text-success">+{{ $todayIpdCount }} today</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border-end">
                                <div class="h4 text-success mb-1">{{ $availableBeds }}</div>
                                <div class="small text-muted">Available Beds</div>
                                <div class="small">{{ $bedsCount }} total beds</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3">
                                <div class="h4 text-danger mb-1">{{ $occupiedBeds }}</div>
                                <div class="small text-muted">Occupied Beds</div>
                                <div class="small">{{ $bedsCount > 0 ? round(($occupiedBeds/$bedsCount)*100, 1) : 0 }}% occupancy</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-building text-warning me-2"></i>
                        Infrastructure
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Departments</span>
                        <strong class="text-primary">{{ $departmentsCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Wards</span>
                        <strong class="text-info">{{ $wardsCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Rooms</span>
                        <strong class="text-success">{{ $roomsCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total Beds</span>
                        <strong class="text-warning">{{ $bedsCount }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line text-success me-2"></i>
                        Financial Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center p-3 border-end">
                                <div class="h5 text-success mb-1">₹{{ number_format($totalIncome, 0) }}</div>
                                <div class="small text-muted">Total Income</div>
                                <div class="small text-info">₹{{ number_format($monthlyIncome, 0) }} this month</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3">
                                <div class="h5 text-danger mb-1">₹{{ number_format($totalExpense, 0) }}</div>
                                <div class="small text-muted">Total Expense</div>
                                <div class="small text-info">₹{{ number_format($monthlyExpense, 0) }} this month</div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="text-center">
                        <div class="h4 {{ $netIncome >= 0 ? 'text-success' : 'text-danger' }} mb-1">
                            ₹{{ number_format($netIncome, 0) }}
                        </div>
                        <div class="small text-muted">Net {{ $netIncome >= 0 ? 'Profit' : 'Loss' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cash-register text-primary me-2"></i>
                        Payment Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center p-3 border-end">
                                <div class="h5 text-primary mb-1">₹{{ number_format($totalPayments, 0) }}</div>
                                <div class="small text-muted">Total Payments</div>
                                <div class="small text-success">₹{{ number_format($todayPayments, 0) }} today</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3">
                                <div class="h5 text-success mb-1">₹{{ number_format($totalReceipts, 0) }}</div>
                                <div class="small text-muted">Total Receipts</div>
                                <div class="small text-success">₹{{ number_format($todayReceipts, 0) }} today</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory & Service Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-boxes text-info me-2"></i>
                        Inventory Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center p-3 border-end">
                                <div class="h5 text-info mb-1">{{ $itemsCount }}</div>
                                <div class="small text-muted">Total Items</div>
                                <div class="small text-secondary">{{ $suppliersCount }} suppliers</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3">
                                <div class="h5 text-success mb-1">₹{{ number_format($totalSales, 0) }}</div>
                                <div class="small text-muted">Total Sales</div>
                                <div class="small text-primary">₹{{ number_format($totalPurchases, 0) }} purchases</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-headset text-warning me-2"></i>
                        Customer Service
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center p-3 border-end">
                                <div class="h5 text-warning mb-1">{{ $complaintsCount }}</div>
                                <div class="small text-muted">Total Complaints</div>
                                <div class="small text-danger">{{ $pendingComplaints }} pending</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3">
                                <div class="h5 text-info mb-1">{{ $enquiriesCount }}</div>
                                <div class="small text-muted">Total Enquiries</div>
                                <div class="small text-success">{{ $resolvedComplaints }} resolved</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Patient Distribution
                    </h5>
                </div>
                <div class="card-body text-center">
                    <canvas id="patientChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Monthly Revenue Trend
                    </h5>
                </div>
                <div class="card-body text-center">
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Communication & Services -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-phone text-success me-2"></i>
                        Communication
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Call Logs</span>
                        <strong class="text-success">{{ $callLogsCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Postal Dispatch</span>
                        <strong class="text-primary">{{ $postalDispatchCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Postal Received</span>
                        <strong class="text-info">{{ $postalReceiveCount }}</strong>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bed text-warning me-2"></i>
                        Bed Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Assigned Beds</span>
                        <strong class="text-warning">{{ $assignedBedsCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Occupancy Rate</span>
                        <strong class="text-{{ $occupiedBeds > $availableBeds ? 'danger' : 'success' }}">
                            {{ $bedsCount > 0 ? round(($occupiedBeds/$bedsCount)*100, 1) : 0 }}%
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Available Rooms</span>
                        <strong class="text-success">{{ $roomsCount }}</strong>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt text-info me-2"></i>
                        Schedules & Categories
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Doctor Schedules</span>
                        <strong class="text-info">{{ $doctorSchedulesCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Income Categories</span>
                        <strong class="text-success">{{ $incomeCategoriesCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Active Users</span>
                        <strong class="text-primary">{{ $usersCount }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus text-primary me-2"></i>
                        Recent Patients
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentPatients->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentPatients as $patient)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <div>
                                    <div class="fw-bold">{{ $patient->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $patient->mobile ?? 'No mobile' }}</small>
                                </div>
                                <small class="text-muted">{{ $patient->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No recent patients</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-receipt text-success me-2"></i>
                        Recent Transactions
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentPayments->count() > 0 || $recentReceipts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentPayments->take(2) as $payment)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <div>
                                    <div class="fw-bold text-danger">Payment</div>
                                    <small class="text-muted">{{ $payment->description ?? 'Payment made' }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-danger">-₹{{ number_format($payment->paid_amount, 0) }}</div>
                                    <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                            @foreach($recentReceipts->take(2) as $receipt)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <div>
                                    <div class="fw-bold text-success">Receipt</div>
                                    <small class="text-muted">{{ $receipt->description ?? 'Payment received' }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">+₹{{ number_format($receipt->receipt_amount, 0) }}</div>
                                    <small class="text-muted">{{ $receipt->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No recent transactions</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Recent Activities
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentComplaints->count() > 0 || $recentInvestigations->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentComplaints->take(2) as $complaint)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <div>
                                    <div class="fw-bold text-warning">Complaint</div>
                                    <small class="text-muted">{{ Str::limit($complaint->description ?? 'New complaint', 30) }}</small>
                                </div>
                                <small class="text-muted">{{ $complaint->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                            @foreach($recentInvestigations->take(2) as $investigation)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <div>
                                    <div class="fw-bold text-info">Investigation</div>
                                    <small class="text-muted">{{ $investigation->name ?? 'New investigation' }}</small>
                                </div>
                                <small class="text-muted">{{ $investigation->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No recent activities</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-card {
        transition: all 0.3s ease;
        border-radius: 12px !important;
    }
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
    }
    .bg-gradient-purple {
        background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%);
    }
    .bg-gradient-dark {
        background: linear-gradient(135deg, #343a40 0%, #23272b 100%);
    }
    .bg-gradient-teal {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
    }
    .bg-gradient-orange {
        background: linear-gradient(135deg, #fd7e14 0%, #dc6415 100%);
    }
    .card {
        border-radius: 12px;
        border: none;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .list-group-item:first-child {
        border-radius: 0;
    }
    .list-group-item:last-child {
        border-radius: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Patient Distribution Pie Chart
    const patientCtx = document.getElementById('patientChart').getContext('2d');
    const patientChart = new Chart(patientCtx, {
        type: 'doughnut',
        data: {
            labels: ['OPD Patients', 'IPD Patients', 'Available Beds'],
            datasets: [{
                data: [{{ $opdCount }}, {{ $ipdCount }}, {{ $availableBeds }}],
                backgroundColor: [
                    '#007bff',
                    '#28a745', 
                    '#ffc107'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Revenue Trend Bar Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Income', 'Expense', 'Net Profit'],
            datasets: [{
                label: 'Amount (₹)',
                data: [{{ $totalIncome }}, {{ $totalExpense }}, {{ $netIncome }}],
                backgroundColor: [
                    '#28a745',
                    '#dc3545',
                    '{{ $netIncome >= 0 ? "#17a2b8" : "#dc3545" }}'
                ],
                borderWidth: 0,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
