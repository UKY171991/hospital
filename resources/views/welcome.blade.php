<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MediCore - World-class Integrated Healthcare Solution. Manage Hospital, Pathology, and Medical Store with ease and precision.">
    <meta name="keywords" content="hospital management, pathology lab software, medical store management, healthcare ERP, medical software">
    <title>MediCore | Integrated Hospital & Medical Management</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: #0c6dfd; /* Professional Blue */
            --secondary-color: #f8fafc;
            --accent-color: #10b981; /* Success Green */
            --heading-color: #0f172a;
            --text-color: #475569;
            --light-bg: #f1f5f9;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --gradient-primary: linear-gradient(135deg, #0c6dfd 0%, #3b82f6 100%);
            --transition-smooth: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-color);
            background-color: var(--secondary-color);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            color: var(--heading-color);
            font-weight: 700;
        }

        /* Navbar Glassmorphism */
        .navbar {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: var(--glass-bg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            transition: var(--transition-smooth);
            z-index: 1000;
        }

        .navbar.scrolled {
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 0.7rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 600;
            color: var(--heading-color) !important;
            margin: 0 12px;
            transition: var(--transition-smooth);
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            background: radial-gradient(circle at 10% 20%, rgba(13, 110, 253, 0.05) 0%, rgba(255, 255, 255, 0) 90%);
            padding: 160px 0 100px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: var(--primary-color);
            opacity: 0.03;
            border-radius: 50%;
            z-index: -1;
        }

        .hero-title {
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #0f172a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-color);
            max-width: 600px;
            margin-bottom: 2.5rem;
        }

        .btn-custom {
            padding: 14px 35px;
            font-weight: 700;
            border-radius: 12px;
            transition: var(--transition-smooth);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            color: white;
            border: none;
            box-shadow: 0 10px 20px rgba(12, 109, 253, 0.2);
        }

        .btn-primary-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(12, 109, 253, 0.3);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-5px);
        }

        /* Floating Cards */
        .floating-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.03);
            transition: var(--transition-smooth);
        }

        .floating-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(13, 110, 253, 0.1);
        }

        /* Services Grid */
        .section-tag {
            text-transform: uppercase;
            font-weight: 800;
            font-size: 0.75rem;
            color: var(--primary-color);
            letter-spacing: 3px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .service-icon-box {
            width: 80px;
            height: 80px;
            background: rgba(13, 110, 253, 0.08);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            transition: var(--transition-smooth);
        }

        .floating-card:hover .service-icon-box {
            background: var(--primary-color);
            color: white;
            transform: rotate(10deg);
        }

        /* Stats */
        .stat-item {
            padding: 2rem;
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            display: block;
        }

        .stat-label {
            font-weight: 600;
            color: var(--text-color);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 100px 0 50px;
            margin-top: 150px;
        }

        .footer h4 { color: white; }
        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: var(--transition-smooth);
            display: block;
            margin-bottom: 0.8rem;
        }
        .footer-link:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        @media (max-width: 991.98px) {
            .hero-title { font-size: 2.8rem; }
            .hero-section { text-align: center; }
            .hero-subtitle { margin-left: auto; margin-right: auto; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeInLeft" href="#">
                <i class="fas fa-hand-holding-medical me-2"></i>MediCore
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Hospital</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Pathology</a></li>
                    <li class="nav-item"><a class="nav-link" href="#store">Store</a></li>
                    <li class="nav-item ms-lg-4">
                        <a href="/admin" class="btn btn-primary-custom btn-custom px-4 rounded-pill">Admin Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="section-tag animate__animated animate__fadeIn">Comprehensive Health Management</span>
                    <h1 class="hero-title animate__animated animate__fadeInUp">Modern Digital <br> Healthcare ecosystem.</h1>
                    <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                        Empowering healthcare providers with an integrated platform for Hospital workflows, Pathology diagnostics, and Pharmacy operations.
                    </p>
                    <div class="d-flex flex-wrap gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="/admin" class="btn btn-primary-custom btn-custom d-flex align-items-center">
                            <i class="fas fa-play-circle me-2"></i> Get Started Free
                        </a>
                        <a href="#services" class="btn btn-outline-custom btn-custom">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center animate__animated animate__zoomIn">
                    <div class="position-relative d-inline-block">
                        <img src="https://images.unsplash.com/photo-1576091160550-217359f42f8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" 
                             alt="Healthcare Platform" class="img-fluid rounded-4 shadow-2-strong float-animation" style="max-height: 500px; border-radius: 40px !important;">
                        
                        <div class="floating-card position-absolute d-none d-md-block" style="bottom: -30px; left: -50px; width: 220px;">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white p-2 rounded-circle me-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">99.9%</h6>
                                    <small class="text-muted">System Uptime</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stat Showcase -->
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">5k+</span>
                    <span class="stat-label">Daily Patients</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">200+</span>
                    <span class="stat-label">Medical Specialists</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">15+</span>
                    <span class="stat-label">Integrated Labs</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="services" class="py-5 bg-white border-top">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="section-tag">Our Services</span>
                <h2 class="display-5">Specialized Care Modules</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">We Provide the technologies to help people live healthiest lives possible.</p>
            </div>
            
            <div class="row g-4">
                <!-- Hospital -->
                <div class="col-md-4">
                    <div class="floating-card h-100">
                        <div class="service-icon-box">
                            <i class="fas fa-hospital-user"></i>
                        </div>
                        <h3>Hospital ERP</h3>
                        <p class="mb-4">Streamline patient admissions, bed allocations, surgery schedules and discharge workflows efficiently.</p>
                        <a href="/admin" class="text-primary text-decoration-none fw-bold">Explore Module <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                
                <!-- Pathology -->
                <div class="col-md-4">
                    <div class="floating-card h-100">
                        <div class="service-icon-box">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h3>Smart Pathology</h3>
                        <p class="mb-4">Automated test reporting, custom templates, and direct synchronization with patient medical records.</p>
                        <a href="/admin" class="text-primary text-decoration-none fw-bold">Explore Module <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                
                <!-- Pharmacy -->
                <div class="col-md-4">
                    <div class="floating-card h-100">
                        <div class="service-icon-box">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <h3>Pharmacy OS</h3>
                        <p class="mb-4">Advanced inventory management with expiry alerts, intelligent billings, and prescription integrations.</p>
                        <a href="/admin" class="text-primary text-decoration-none fw-bold">Explore Module <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By -->
    <section class="py-5" style="background: var(--light-bg);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h2 class="mb-4">Trusted by Leading Medical Institutions</h2>
                    <p class="text-muted mb-4">Join thousands of healthcare practitioners using MediCore for unified clinical and operational performance.</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> HIPAA Compliant Security</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> 24/7 Priority Support</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Automated Cloud Backups</li>
                    </ul>
                </div>
                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="bg-white p-4 rounded-3 text-center shadow-sm">
                                <h5 class="mb-0 text-muted">MediScan</h5>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-white p-4 rounded-3 text-center shadow-sm">
                                <h5 class="mb-0 text-muted">HealthWay</h5>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-white p-4 rounded-3 text-center shadow-sm">
                                <h5 class="mb-0 text-muted">LifeLine</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="mb-4">MediCore</h4>
                    <p class="mb-4">Building the future of healthcare technology with passion and precision. One patient at a time.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px; text-align: center;"><i class="fab fa-facebook-f text-white-50"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px; text-align: center;"><i class="fab fa-twitter text-white-50"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 40px; text-align: center;"><i class="fab fa-linkedin-in text-white-50"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 offset-lg-2 mb-5 mb-md-0">
                    <h5 class="text-white mb-4">Platform</h5>
                    <a href="/admin" class="footer-link">Dashboard</a>
                    <a href="#services" class="footer-link">Medical ERP</a>
                    <a href="#services" class="footer-link">Lab Tools</a>
                    <a href="#" class="footer-link">Mobile App</a>
                </div>
                <div class="col-md-4 col-lg-2 mb-5 mb-md-0">
                    <h5 class="text-white mb-4">Support</h5>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Security Docs</a>
                    <a href="#" class="footer-link">Contact Us</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                </div>
                <div class="col-md-4 col-lg-2">
                    <h5 class="text-white mb-4">Connect</h5>
                    <p class="small mb-1">Email:</p>
                    <p class="text-white mb-3">contact@medicore.io</p>
                    <p class="small mb-1">Phone:</p>
                    <p class="text-white">+1 (800) 900-MED</p>
                </div>
            </div>
            <hr class="my-5 border-secondary">
            <div class="text-center">
                <p class="small mb-0">&copy; 2026 MediCore Healthcare Systems. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.getElementById('mainNavbar').classList.add('scrolled');
            } else {
                document.getElementById('mainNavbar').classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
