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
                $setupActive = request()->is('departments*') || request()->is('disease*') || request()->is('fee-assign*') || request()->is('investigations*') || request()->is('wards*') || request()->is('rooms*') || request()->is('beds*') || request()->is('assign-beds*');
                $attendanceActive = request()->is('attendance*');
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
                    <a href="{{ route('employee.index') }}" class="nav-link {{ request()->routeIs('employee.*') ? 'active' : '' }}">
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
                @php
                    $doctorActive = request()->is('doctor*') || request()->is('schedule*');
                @endphp
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
                            <a href="{{ url('/doctor') }}" class="nav-link {{ request()->is('doctor*') ? 'active' : '' }}">
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
                @php
                    $patientActive = request()->routeIs('patient.*') || request()->routeIs('opd.*') || request()->routeIs('ipd.*') || request()->routeIs('item_mapping.*');
                @endphp
                <li class="nav-item has-treeview {{ $patientActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $patientActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-procedures"></i>
                        <p>
                            Patient
                            <i class="fas fa-angle-left right"></i>
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
                @php
                    $inventoryActive = request()->is('suppliers*') || request()->is('sale_item*') || request()->is('purchase_item*') || request()->is('item_stock*');
                @endphp
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
                            <a href="{{ url('/suppliers') }}" class="nav-link {{ request()->is('suppliers*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sale_item') }}" class="nav-link {{ request()->is('sale_item*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sale Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/purchase_item') }}" class="nav-link {{ request()->is('purchase_item*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/item_stock') }}" class="nav-link {{ request()->is('item_stock*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item Stock</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Front-Office Menu -->
                @php
                    $frontOfficeActive = request()->is('complaint-type*') || request()->is('reference*') || request()->is('enquiry*') || request()->is('complaint*') || request()->is('postal-dispatch*') || request()->is('postal-receive*') || request()->is('call-log*');
                @endphp
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
                            <a href="{{ url('/postal-dispatch') }}" class="nav-link {{ request()->is('postal-dispatch*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Postal Dispatch</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/postal-receive') }}" class="nav-link {{ request()->is('postal-receive*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Postal Receive</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/call-log') }}" class="nav-link {{ request()->is('call-log*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Call Log</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Income/Expenses Menu -->
                @php
                    $incomeExpenseActive = request()->is('income-expense-category*') || request()->is('income-expense-item*') || request()->is('income-expense*');
                @endphp
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
                @php
                    $accountsActive = request()->is('payment*') || request()->is('receipt*') || request()->is('quick-receipt*');
                @endphp
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
                            <a href="{{ url('/payment') }}" class="nav-link {{ request()->is('payment*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/receipt') }}" class="nav-link {{ request()->is('receipt*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Receipt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/quick-receipt') }}" class="nav-link {{ request()->is('quick-receipt*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>Quick Receipt</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/reports/ledger') }}" class="nav-link">
                                <i class="fas fa-ruble-sign nav-icon"></i>
                                <p>Ledger</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/reports/patient') }}" class="nav-link">
                                <i class="fas fa-money-bill-alt nav-icon"></i>
                                <p>Patient</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/reports/day-book') }}" class="nav-link">
                                <i class="fas fa-money-bill-alt nav-icon"></i>
                                <p>Day Book</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/reports/balance-sheet') }}" class="nav-link">
                                <i class="fas fa-money-bill-alt nav-icon"></i>
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