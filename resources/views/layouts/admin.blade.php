<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Hospital Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar .active > a, .sidebar-menu ul li.active > a {
            background: #c62828 !important;
            color: #fff !important;
        }
        .sidebar-menu ul {
            list-style: none !important;
            padding-left: 0;
            margin: 0;
        }
        .sidebar-menu ul li > a {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 500;
            border-bottom: 1px solid #b71c1c;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
        }
        .sidebar-menu ul li > a:hover {
            background: #ad1818 !important;
            color: #fff !important;
        }
        .sidebar-menu ul li > a i {
            margin-right: 10px;
            width: 22px;
            text-align: center;
        }
        .sidebar-menu ul li.submenu ul.childBar {
            display: none;
            background: #b71c1c;
        }
        .sidebar-menu ul li.submenu.active ul.childBar,
        .sidebar-menu ul li.submenu:hover ul.childBar {
            display: block;
        }
        .sidebar-menu ul li.submenu ul.childBar li a {
            padding-left: 40px;
            font-size: 1rem;
            border-bottom: none;
        }
        .main-content { margin-left: 250px; padding: 2rem; }
        .topbar { background: #e74c3c; color: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .quick-links .card { min-width: 120px; margin: 0.5rem; text-align: center; }
        .summary-card { min-width: 180px; margin: 0.5rem; }
    </style>
    @yield('head')
</head>
<body>
    <div class="sidebar" id="sidebar" style="background: linear-gradient(180deg, #d32f2f 0%, #b71c1c 100%); width: 250px; min-height: 100vh; position: fixed;">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="/admin_dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-wrench"></i> <span>User</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="/user/list"><i class="fa fa-list"></i> User List</a></li>
                            <li><a href="/user/password_pin"><i class="fa fa-key"></i> Password/Passcode</a></li>
                        </ul>
                    </li>
                    <li><a href="/hospital/manage"><i class="fa fa-money-bill"></i> <span>Hospital</span></a></li>
                    <li><a href="#"><i class="fa fa-users"></i> <span>Employee</span></a></li>
                    <li><a href="#"><i class="fa fa-box"></i> <span>Item</span></a></li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-cogs"></i> <span>Setup</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-building"></i> Departments</a></li>
                            <li><a href="#"><i class="fa fa-bug"></i> Disease</a></li>
                            <li><a href="#"><i class="fa fa-rupee-sign"></i> Fee Assign</a></li>
                            <li><a href="#"><i class="fa fa-vials"></i> Investigations</a></li>
                            <li><a href="#"><i class="fa fa-bed"></i> Wards</a></li>
                            <li><a href="#"><i class="fa fa-door-open"></i> Rooms</a></li>
                            <li><a href="#"><i class="fa fa-bed"></i> Beds</a></li>
                            <li><a href="#"><i class="fa fa-user-plus"></i> Assign Beds</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-user-md"></i> <span>Doctor</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-user-plus"></i> Doctor Registration</a></li>
                            <li><a href="#"><i class="fa fa-calendar-check"></i> Doctor Schedule</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-calendar-check"></i> <span>Attendance</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-plus"></i> Create/Duplicate</a></li>
                            <li><a href="#"><i class="fa fa-edit"></i> Update/Delete</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-procedures"></i> <span>Patient</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-user-plus"></i> Patient Registration</a></li>
                            <li><a href="#"><i class="fa fa-hospital"></i> Out Patient Dept</a></li>
                            <li><a href="#"><i class="fa fa-hospital-user"></i> In Patient Dept</a></li>
                            <li><a href="#"><i class="fa fa-th-list"></i> Item Dept</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-warehouse"></i> <span>Inventory</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-id-card"></i> Suppliers</a></li>
                            <li><a href="#"><i class="fa fa-shopping-bag"></i> Sale Item</a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i> Purchase Item</a></li>
                            <li><a href="#"><i class="fa fa-balance-scale"></i> Item Stock</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-concierge-bell"></i> <span>Front-Office</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-question-circle"></i> Complaint Type</a></li>
                            <li><a href="#"><i class="fa fa-user-friends"></i> Reference</a></li>
                            <li><a href="#"><i class="fa fa-comments"></i> Enquiry</a></li>
                            <li><a href="#"><i class="fa fa-exclamation-triangle"></i> Complaint</a></li>
                            <li><a href="#"><i class="fa fa-paper-plane"></i> Postal Dispatch</a></li>
                            <li><a href="#"><i class="fa fa-inbox"></i> Postal Receive</a></li>
                            <li><a href="#"><i class="fa fa-phone"></i> Call Log</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-rupee-sign"></i> <span>Income/Expenses</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-list"></i> Category</a></li>
                            <li><a href="#"><i class="fa fa-list-alt"></i> Item</a></li>
                            <li><a href="#"><i class="fa fa-exchange-alt"></i> Income/Expenses</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-file-invoice-dollar"></i> <span>Accounts</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-credit-card"></i> Payment</a></li>
                            <li><a href="#"><i class="fa fa-receipt"></i> Receipt</a></li>
                            <li><a href="#"><i class="fa fa-money-bill"></i> Quick Receipt</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-chart-bar"></i> <span>Reports</span> <span class="menu-arrow"></span></a>
                        <ul class="childBar">
                            <li><a href="#"><i class="fa fa-fax"></i> Ledger</a></li>
                            <li><a href="#"><i class="fa fa-user-injured"></i> Patient</a></li>
                            <li><a href="#"><i class="fa fa-book"></i> Day Book</a></li>
                            <li><a href="#"><i class="fa fa-history"></i> Balance Sheet</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-headset"></i> <span>Support</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <div class="fs-4 fw-bold">HEALTHCARE HOSPITAL</div>
            <div>Support: +91 7632833972 | <span class="fw-bold">Admin</span></div>
        </div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.sidebar-menu .submenu > a').forEach(function(menu) {
            menu.addEventListener('click', function(e) {
                e.preventDefault();
                var parent = this.parentElement;
                parent.classList.toggle('active');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
