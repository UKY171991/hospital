@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="my-4">Admin Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card summary-card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-user-md fa-2x text-primary"></i>
                    <h4 class="mt-2">4</h4>
                    <p>Doctors</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-user-injured fa-2x text-success"></i>
                    <h4 class="mt-2">22</h4>
                    <p>Patients</p>
                    <a href="#" class="btn btn-outline-success btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-info"></i>
                    <h4 class="mt-2">7</h4>
                    <p>Employees</p>
                    <a href="#" class="btn btn-outline-info btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-heartbeat fa-2x text-warning"></i>
                    <div class="d-flex justify-content-between mt-2">
                        <span class="badge bg-primary">In Patients: 15</span>
                        <span class="badge bg-success">Out Patients: 34</span>
                    </div>
                    <a href="#" class="btn btn-outline-warning btn-sm mt-2">Details</a>
                </div>
            </div>
        </div>
    </div>
    <h5>Quick Links</h5>
    <div class="row quick-links flex-wrap">
        @php
            $quickLinks = [
                ['icon' => 'hospital', 'label' => 'Hospital', 'color' => 'bg-secondary'],
                ['icon' => 'user-md', 'label' => 'Doctor', 'color' => 'bg-primary'],
                ['icon' => 'users', 'label' => 'Employee', 'color' => 'bg-info'],
                ['icon' => 'user-injured', 'label' => 'Patient', 'color' => 'bg-success'],
                ['icon' => 'bed', 'label' => 'Bed', 'color' => 'bg-warning'],
                ['icon' => 'procedures', 'label' => 'Available Beds', 'color' => 'bg-danger'],
                ['icon' => 'stethoscope', 'label' => 'OPD', 'color' => 'bg-primary'],
                ['icon' => 'hospital-user', 'label' => 'IPD', 'color' => 'bg-info'],
                ['icon' => 'th-list', 'label' => 'Map. Items', 'color' => 'bg-secondary'],
                ['icon' => 'sign-out-alt', 'label' => 'Discharge', 'color' => 'bg-success'],
                ['icon' => 'credit-card', 'label' => 'Payment', 'color' => 'bg-warning'],
                ['icon' => 'receipt', 'label' => 'Receipt', 'color' => 'bg-primary'],
                ['icon' => 'calendar-check', 'label' => 'Attendance', 'color' => 'bg-info'],
                ['icon' => 'book', 'label' => 'Ledger', 'color' => 'bg-secondary'],
                ['icon' => 'shopping-cart', 'label' => 'Purchase', 'color' => 'bg-success'],
                ['icon' => 'cash-register', 'label' => 'Sale', 'color' => 'bg-warning'],
                ['icon' => 'balance-scale', 'label' => 'Balance Sheet', 'color' => 'bg-primary'],
                ['icon' => 'book-open', 'label' => 'Day Book', 'color' => 'bg-info'],
                ['icon' => 'chart-line', 'label' => 'Income/Expense', 'color' => 'bg-success'],
                ['icon' => 'box', 'label' => 'Item', 'color' => 'bg-secondary'],
                ['icon' => 'question-circle', 'label' => 'Enquiry', 'color' => 'bg-warning'],
                ['icon' => 'receipt', 'label' => 'Quick Receipt', 'color' => 'bg-primary'],
                ['icon' => 'calendar-alt', 'label' => 'Doctor Schedule', 'color' => 'bg-info'],
                ['icon' => 'exclamation-triangle', 'label' => 'Complaint', 'color' => 'bg-danger'],
                ['icon' => 'headset', 'label' => 'Support', 'color' => 'bg-success'],
                ['icon' => 'phone', 'label' => 'Call Log', 'color' => 'bg-secondary'],
            ];
        @endphp
        @foreach($quickLinks as $link)
            <div class="col-auto mb-2">
                <div class="card shadow-sm {{ $link['color'] }} text-white" style="min-width:110px;">
                    <div class="card-body p-2 text-center">
                        <i class="fas fa-{{ $link['icon'] }} fa-lg mb-1"></i>
                        <div style="font-size:0.95rem">{{ $link['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Income/Expenses</div>
                <div class="card-body">
                    <canvas id="incomeExpenseChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Patients</div>
                <div class="card-body">
                    <canvas id="patientsChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example data for charts
    const ctx1 = document.getElementById('incomeExpenseChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                { label: 'Income', data: [120, 150, 170, 140, 180, 200], borderColor: '#28a745', fill: false },
                { label: 'Expenses', data: [100, 120, 130, 110, 140, 160], borderColor: '#dc3545', fill: false }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });
    const ctx2 = document.getElementById('patientsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['IPD', 'OPD'],
            datasets: [
                { label: 'Patients', data: [10, 25], backgroundColor: ['#007bff', '#ffc107'] }
            ]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
@endsection
