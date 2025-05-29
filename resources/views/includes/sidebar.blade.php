<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold text-white">HEALTHCARE HOSPITAL</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @php
                $setupActive = request()->is('departments*') || request()->is('disease*') || request()->is('fee-assign*') || request()->is('investigations*') || request()->is('wards*') || request()->is('rooms*') || request()->is('beds*') || request()->is('assign-beds*');
                $attendanceActive = request()->is('attendance*');
            @endphp
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hospitals.index') }}" class="nav-link {{ request()->routeIs('hospitals.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hospital"></i>
                        <p>Hospital</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employee.index') }}" class="nav-link {{ request()->routeIs('employee.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Employee</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('item.index') }}" class="nav-link {{ request()->routeIs('item.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Item</p>
                    </a>
                </li>
                
                <li class="nav-item has-treeview {{ $setupActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $setupActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Setup
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ $setupActive ? 'display: block;' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('department.index') }}" class="nav-link {{ request()->routeIs('department.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('disease.index') }}" class="nav-link {{ request()->routeIs('disease.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-virus"></i>
                                <p>Disease</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fee_assign.index') }}" class="nav-link {{ request()->routeIs('fee_assign.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rupee-sign"></i>
                                <p>Fee Assign</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('investigation.index') }}" class="nav-link {{ request()->routeIs('investigation.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-vials"></i>
                                <p>Investigations</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ward.index') }}" class="nav-link {{ request()->routeIs('ward.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-procedures"></i>
                                <p>Wards</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('room.index') }}" class="nav-link {{ request()->routeIs('room.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-door-open"></i>
                                <p>Rooms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bed.index') }}" class="nav-link {{ request()->routeIs('bed.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>Beds</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assign_bed.index') }}" class="nav-link {{ request()->routeIs('assign_bed.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-plus"></i>
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
                        <i class="nav-icon fas fa-user text-primary"></i>
                        <p>
                            Doctor
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ $doctorActive ? 'display: block;' : '' }}">
                        <li class="nav-item">
                            <a href="{{ url('/doctor') }}" class="nav-link {{ request()->is('doctor*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rupee-sign"></i>
                                <p>Doctor Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}" class="nav-link {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Doctor Schedule</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Attendance Menu -->

                <li class="nav-item">
                    <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Attendance</p>
                    </a>
                </li>
                <!-- Patient Menu -->
                @php
                    $patientActive = request()->routeIs('patient.*') || request()->routeIs('opd.*') || request()->routeIs('ipd.*') || request()->routeIs('item_mapping.*');
                @endphp
                <li class="nav-item has-treeview {{ $patientActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $patientActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Patient
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ $patientActive ? 'display: block;' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('patient.index') }}" class="nav-link {{ request()->routeIs('patient.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rupee-sign"></i>
                                <p>Patient Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('opd.index') }}" class="nav-link {{ request()->routeIs('opd.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rupee-sign"></i>
                                <p>Out Patient Dept</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ipd.index') }}" class="nav-link {{ request()->routeIs('ipd.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rupee-sign"></i>
                                <p>In Patient Dept</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item_mapping.index') }}" class="nav-link {{ request()->routeIs('item_mapping.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-rupee-sign"></i>
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
                        <i class="nav-icon fas fa-industry"></i>
                        <p>
                            Inventory
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ $inventoryActive ? 'display: block;' : '' }}">
                        <li class="nav-item">
                            <a href="{{ url('/suppliers') }}" class="nav-link {{ request()->is('suppliers*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sale_item') }}" class="nav-link {{ request()->is('sale_item*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>Sale Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/purchase_item') }}" class="nav-link {{ request()->is('purchase_item*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Purchase Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/item_stock') }}" class="nav-link {{ request()->is('item_stock*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-balance-scale"></i>
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
                    <a href="#" class="nav-link {{ $frontOfficeActive ? 'active' : '' }}" style="background: #e53935; color: #fff;">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p>
                            Front-Office
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ $frontOfficeActive ? 'display: block;' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('complaint_type.index') }}" class="nav-link {{ request()->routeIs('complaint_type.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-bill-alt"></i>
                                <p>Complaint Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reference.index') }}" class="nav-link {{ request()->routeIs('reference.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ruble-sign"></i>
                                <p>Reference</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('enquiry.index') }}" class="nav-link {{ request()->routeIs('enquiry.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ruble-sign"></i>
                                <p>Enquiry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('complaint.index') }}" class="nav-link {{ request()->routeIs('complaint.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ruble-sign"></i>
                                <p>Complaint</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/postal-dispatch') }}" class="nav-link {{ request()->is('postal-dispatch*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ruble-sign"></i>
                                <p>Postal Dispatch</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/postal-receive') }}" class="nav-link {{ request()->is('postal-receive*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ruble-sign"></i>
                                <p>Postal Receive</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/call-log') }}" class="nav-link {{ request()->is('call-log*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ruble-sign"></i>
                                <p>Call Log</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Add more menu sections below in the same pattern -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>