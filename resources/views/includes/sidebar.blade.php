<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">HEALTHCARE HOSPITAL</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @php
                $setupActive = request()->routeIs('department.*') || request()->routeIs('disease.*') || request()->routeIs('fee_assign.*') || request()->routeIs('investigation.*') || request()->routeIs('ward.*') || request()->routeIs('room.*') || request()->routeIs('bed.*') || request()->routeIs('assign_bed.*');
                $doctorActive = request()->routeIs('doctor.*') || request()->routeIs('schedule.*');
                $patientActive = request()->routeIs('patients.*') || request()->routeIs('opd.*') || request()->routeIs('ipd.*') || request()->routeIs('item_mapping.*');
                $inventoryActive = request()->routeIs('suppliers.*') || request()->routeIs('sale_item.*') || request()->routeIs('purchase_item.*') || request()->routeIs('item_stock.*');
                $frontOfficeActive = request()->routeIs('complaint_type.*') || request()->routeIs('reference.*') || request()->routeIs('enquiry.*') || request()->routeIs('complaint.*') || request()->routeIs('postal_dispatch.*') || request()->routeIs('postal_receive.*') || request()->routeIs('call_log.*');
                $incomeExpenseActive = request()->routeIs('income_category.*') || request()->routeIs('income_item.*') || request()->is('income_expense*');
                $accountsActive = request()->routeIs('payment.*') || request()->routeIs('receipt.*') || request()->routeIs('quick-receipt');
                $reportsActive = request()->is('reports/*');
            @endphp
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hospitals.index') }}" class="nav-link {{ request()->routeIs('hospitals.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hospital-alt"></i>
                        <p>Hospital</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Employee</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('item.index') }}" class="nav-link {{ request()->routeIs('item.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Items</p>
                    </a>
                </li>
                
                <li class="nav-item has-treeview {{ $setupActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $setupActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Setup
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('department.index') }}" class="nav-link {{ request()->routeIs('department.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('disease.index') }}" class="nav-link {{ request()->routeIs('disease.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Disease</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fee_assign.index') }}" class="nav-link {{ request()->routeIs('fee_assign.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fee Assign</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('investigation.index') }}" class="nav-link {{ request()->routeIs('investigation.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Investigations</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ward.index') }}" class="nav-link {{ request()->routeIs('ward.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wards</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('room.index') }}" class="nav-link {{ request()->routeIs('room.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rooms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bed.index') }}" class="nav-link {{ request()->routeIs('bed.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Beds</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assign_bed.index') }}" class="nav-link {{ request()->routeIs('assign_bed.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Assign Beds</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Doctor Menu -->
                <li class="nav-item has-treeview {{ $doctorActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $doctorActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>
                            Doctor
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('doctor.index') }}" class="nav-link {{ request()->routeIs('doctor.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Doctor Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}" class="nav-link {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Doctor Schedule</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Attendance</p>
                    </a>
                </li>

                <!-- Patient Menu -->
                <li class="nav-item has-treeview {{ $patientActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $patientActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-procedures"></i>
                        <p>
                            Patient
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Patient Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('opd.index') }}" class="nav-link {{ request()->routeIs('opd.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Out Patient Dept</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ipd.index') }}" class="nav-link {{ request()->routeIs('ipd.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>In Patient Dept</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item_mapping.index') }}" class="nav-link {{ request()->routeIs('item_mapping.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item Dept</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventory Menu -->
                <li class="nav-item has-treeview {{ $inventoryActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $inventoryActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            Inventory
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sale_item.index') }}" class="nav-link {{ request()->routeIs('sale_item.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sale Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchase_item.index') }}" class="nav-link {{ request()->routeIs('purchase_item.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item_stock.index') }}" class="nav-link {{ request()->routeIs('item_stock.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item Stock</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Front-Office Menu -->
                <li class="nav-item has-treeview {{ $frontOfficeActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $frontOfficeActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-headset"></i>
                        <p>
                            Front-Office
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('complaint_type.index') }}" class="nav-link {{ request()->routeIs('complaint_type.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Complaint Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reference.index') }}" class="nav-link {{ request()->routeIs('reference.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reference</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('enquiry.index') }}" class="nav-link {{ request()->routeIs('enquiry.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Enquiry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('complaint.index') }}" class="nav-link {{ request()->routeIs('complaint.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Complaint</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('postal_dispatch.index') }}" class="nav-link {{ request()->routeIs('postal_dispatch.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Postal Dispatch</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('postal_receive.index') }}" class="nav-link {{ request()->routeIs('postal_receive.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Postal Receive</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('call_log.index') }}" class="nav-link {{ request()->routeIs('call_log.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Call Log</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Income/Expenses Menu -->
                <li class="nav-item has-treeview {{ $incomeExpenseActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $incomeExpenseActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Income/Expenses
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('income_category.index') }}" class="nav-link {{ request()->is('income_category*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income/Expenses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('income_item.index') }}" class="nav-link {{ request()->is('income_item*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income/Expenses Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/income_expense') }}" class="nav-link {{ request()->is('income_expense') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income/Expenses</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Accounts Menu -->
                <li class="nav-item has-treeview {{ $accountsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $accountsActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Accounts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('payment.index') }}" class="nav-link {{ request()->routeIs('payment.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receipt.index') }}" class="nav-link {{ request()->routeIs('receipt.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Receipt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('quick-receipt') }}" class="nav-link {{ request()->routeIs('quick-receipt') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quick Receipt</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reports Menu (AdminLTE 3 style) -->
                <li class="nav-item has-treeview {{ $reportsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $reportsActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/reports/ledger') }}" class="nav-link {{ request()->is('reports/ledger*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ledger</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/reports/patient') }}" class="nav-link {{ request()->is('reports/patient*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Patient Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/reports/balance-sheet') }}" class="nav-link {{ request()->is('reports/balance-sheet*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Balance Sheet</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>