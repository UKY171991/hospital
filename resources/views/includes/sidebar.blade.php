<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">HEALTHCARE HOSPITAL</span>
    </a>

    <div class="sidebar">
        @php
            $hospitalActive = request()->routeIs('department.*') || request()->routeIs('ward.*') || request()->routeIs('bed.*') || request()->is('appointment-slots*');
            $setupActive = request()->is('settings/general*') || request()->is('settings/email*') || request()->is('settings/sms*');
            $patientActive = request()->routeIs('opd.*') || request()->routeIs('ipd.*') || request()->is('emergency*');
            $frontOfficeActive = request()->is('reception*') || request()->routeIs('enquiry.*') || request()->is('visitors-log*');
        @endphp

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('pathology') }}" class="nav-link {{ request()->is('pathology*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>Pathology</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ $hospitalActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $hospitalActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hospital"></i>
                        <p>
                            Hospital
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('department.index') }}" class="nav-link {{ request()->routeIs('department.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ward.index') }}" class="nav-link {{ request()->routeIs('ward.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-procedures"></i>
                                <p>Ward</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bed.index') }}" class="nav-link {{ request()->routeIs('bed.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>Bed</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('appointment-slots') }}" class="nav-link {{ request()->is('appointment-slots*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Appointment Slots</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ $setupActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $setupActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Setup
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('settings/general') }}" class="nav-link {{ request()->is('settings/general*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>General Setting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('settings/email') }}" class="nav-link {{ request()->is('settings/email*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Email Setting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('settings/sms') }}" class="nav-link {{ request()->is('settings/sms*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-sms"></i>
                                <p>SMS Setting</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('doctor.index') }}" class="nav-link {{ request()->routeIs('doctor.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>Doctor</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Attendance</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ $patientActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $patientActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-injured"></i>
                        <p>
                            Patient
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('opd.index') }}" class="nav-link {{ request()->routeIs('opd.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-stethoscope"></i>
                                <p>OPD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ipd.index') }}" class="nav-link {{ request()->routeIs('ipd.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hospital-user"></i>
                                <p>IPD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('emergency') }}" class="nav-link {{ request()->is('emergency*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ambulance"></i>
                                <p>Emergency</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('item_stock.index') }}" class="nav-link {{ request()->routeIs('item_stock.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Inventory</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ $frontOfficeActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $frontOfficeActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-concierge-bell"></i>
                        <p>
                            Front-Office
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('reception') }}" class="nav-link {{ request()->is('reception*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-door-open"></i>
                                <p>Reception</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('enquiry.index') }}" class="nav-link {{ request()->routeIs('enquiry.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>Enquiries</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('visitors-log') }}" class="nav-link {{ request()->is('visitors-log*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Visitors Log</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('income_expense') }}" class="nav-link {{ request()->is('income_expense*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Income/Expenses</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('accounts') }}" class="nav-link {{ request()->is('accounts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Accounts</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('reports') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Reports</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
