<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital, Pathology & Medical Store Management</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #f8f9fa;
            --accent-color: #ff5722;
            --text-color: #333;
            --light-bg: #eef2f5;
        }
        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-color);
            background-color: var(--secondary-color);
        }
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(13,110,253,0.9) 0%, rgba(0,212,255,0.9) 100%), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1453&q=80') center/cover;
            padding: 120px 0;
            color: white;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .hero-title {
            font-weight: 700;
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }
        .btn-custom {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom {
            background-color: white;
            color: var(--primary-color);
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .service-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .service-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(13,110,253,0.15);
            border-color: rgba(13,110,253,0.3);
        }
        .service-icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .service-card:hover .service-icon {
            transform: scale(1.1);
        }
        .section-title {
            font-weight: 700;
            margin-bottom: 50px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }
        .footer {
            background-color: #212529;
            color: white;
            padding: 50px 0 20px;
            margin-top: 80px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-heartbeat me-2"></i>MediCore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="/admin" class="btn btn-primary btn-custom" style="padding: 8px 25px; border-radius: 20px; color: white;">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="hero-title animate__animated animate__fadeInDown">Complete Healthcare Solution</h1>
                    <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">Integrating Hospital, Pathology, and Medical Store Management into one unified, elegant platform.</p>
                    <div class="animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="/admin" class="btn btn-primary-custom btn-custom me-3"><i class="fas fa-sign-in-alt me-2"></i>Access Dashboard</a>
                        <a href="#services" class="btn btn-outline-light btn-custom">Explore Modules</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="container py-5 mt-5">
        <h2 class="section-title">Our Integrated Core Modules</h2>
        <div class="row g-4 mt-2">
            <!-- Hospital Management -->
            <div class="col-md-4">
                <div class="service-card">
                    <i class="fas fa-hospital service-icon"></i>
                    <h4>Hospital Management</h4>
                    <p class="text-muted mt-3">Comprehensive system for managing patients, doctors, departments, and scheduling appointments seamlessly.</p>
                </div>
            </div>
            
            <!-- Pathology Management -->
            <div class="col-md-4">
                <div class="service-card">
                    <i class="fas fa-microscope service-icon"></i>
                    <h4>Pathology Diagnostics</h4>
                    <p class="text-muted mt-3">Track lab tests, record results, and manage patient diagnostics records efficiently with built-in normal range indicators.</p>
                </div>
            </div>
            
            <!-- Pharmacy/Medical Store -->
            <div class="col-md-4">
                <div class="service-card">
                    <i class="fas fa-pills service-icon"></i>
                    <h4>Medical Store</h4>
                    <p class="text-muted mt-3">Full inventory control for medicines, tracking sales, expiry dates, stock quantities, and generating instant bills.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats/Info Section -->
    <section class="container-fluid py-5 mt-5" style="background-color: var(--light-bg);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-4">Why Choose MediCore?</h3>
                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user-md fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Expert Doctor Network</h5>
                            <p class="text-muted mb-0">Manage specialists across multiple departments effortlessly.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-file-medical-alt fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <h5>Unified Electronic Records</h5>
                            <p class="text-muted mb-0">Patient history, pathology, and prescriptions all in one place.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Healthcare Dashboard Overview" class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h4 class="text-primary fw-bold"><i class="fas fa-heartbeat me-2"></i>MediCore</h4>
                    <p class="text-white-50 mt-3">The ultimate management system bringing Hospitals, Pathology labs, and Medical Stores together.</p>
                </div>
                <div class="col-md-6 text-md-end mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled text-white-50 mt-3">
                        <li><a href="/admin" class="text-white-50 text-decoration-none">Admin Login</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 mt-3 text-center text-white-50">
                <p>&copy; 2026 MediCore Hospital Management System. Built with Laravel & Bootstrap 5.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
