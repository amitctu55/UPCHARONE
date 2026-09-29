<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_logged_in = (bool)($this->session->userdata('userid') ?: $this->session->userdata('USERID') ?: $this->session->userdata('user_id') ?: $this->session->userdata('is_logged_in'));
$currentUserName = $this->session->userdata('username') ?: $this->session->userdata('name') ?: $this->session->userdata('FNAME') ?: 'Patient';
$first_name = explode(' ', trim($currentUserName))[0];
$cart_count = $this->session->userdata('cart_count') ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Video Consultation with Verified Specialists | Upchar Teleconsult</title>
    
    <link rel="icon" href="<?= base_url('images/logo.png'); ?>" type="image/png">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --upchar-blue: #00A8FF;
            --upchar-blue-dark: #0084c7;
            --upchar-navy: #0A192F;
            --upchar-navy-light: #0f274a;
            --upchar-green: #10B981;
            --upchar-surface: #FFFFFF;
            --upchar-bg: #F8FAFC;
            --upchar-border: #E2E8F0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--upchar-bg);
            color: #334155;
            overflow-x: hidden;
        }

        /* Navbar */
        .upchar-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--upchar-border);
            backdrop-filter: blur(12px);
        }
        .nav-link {
            font-size: 14px;
            font-weight: 600;
            color: #475569 !important;
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--upchar-blue) !important;
        }

        /* Hero */
        .teleconsult-hero {
            background: linear-gradient(135deg, var(--upchar-navy) 0%, var(--upchar-navy-light) 65%, #004e92 100%);
            color: #ffffff;
            padding: 50px 0 45px;
            position: relative;
        }

        .filter-search-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 1px solid var(--upchar-border);
        }

        /* Doctor Card */
        .tele-card {
            background: #ffffff;
            border: 1px solid var(--upchar-border);
            border-radius: 18px;
            padding: 24px;
            transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .tele-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(10, 25, 47, 0.1);
            border-color: rgba(0, 168, 255, 0.4);
        }

        .doc-avatar-img {
            width: 86px;
            height: 86px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid rgba(16, 185, 129, 0.35);
        }

        .pulse-beacon {
            width: 12px;
            height: 12px;
            background: #10B981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 1.8s infinite;
        }
        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .specialty-chip {
            background: #ffffff;
            border: 1px solid var(--upchar-border);
            color: #475569;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .specialty-chip:hover, .specialty-chip.active {
            background: var(--upchar-blue);
            color: #ffffff;
            border-color: var(--upchar-blue);
        }

        /* Footer */
        .upchar-footer {
            background: #081426;
            color: #94a3b8;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body>

<!-- Header Navigation -->
<nav class="navbar navbar-expand-lg upchar-navbar sticky-top shadow-sm py-2">
    <div class="container">
        
        <a class="navbar-brand d-flex align-items-center gap-2 py-1" href="<?= base_url(); ?>">
            <img src="<?= base_url('images/Final_logo23.png'); ?>" alt="Upchar" style="height: 46px; width: auto;" onerror="this.onerror=null; this.src='<?= base_url('images/logo.png'); ?>';">
            <span class="d-none d-sm-inline-block fw-bold fs-4 text-dark">Upchar<span class="text-primary">+</span></span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#teleNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="teleNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ps-lg-3">
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>"><i class="fa-solid fa-house-chimney me-1 text-muted"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link active text-primary" href="<?= base_url('teleconsult'); ?>"><i class="fa-solid fa-video me-1 text-success"></i> Video Consult</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('doctors'); ?>"><i class="fa-solid fa-user-doctor me-1 text-muted"></i> Find Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('hospitals'); ?>"><i class="fa-solid fa-hospital me-1 text-muted"></i> Hospitals</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('tests'); ?>"><i class="fa-solid fa-flask-vial me-1 text-muted"></i> Lab Tests</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('medicines'); ?>"><i class="fa-solid fa-pills me-1 text-muted"></i> Medicines</a></li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <?php if ($is_logged_in): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('myappointments'); ?>"><i class="fa-regular fa-calendar-check text-primary me-1"></i> Appointments</a></li>
                    <li class="nav-item">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                            <i class="fa-regular fa-user me-1"></i> <?= html_escape($first_name); ?>
                        </span>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a href="<?= base_url('login'); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1.5 fw-bold">Login</a></li>
                    <li class="nav-item"><a href="<?= base_url('signup'); ?>" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fw-bold text-white shadow-sm">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="teleconsult-hero">
    <div class="container text-center">
        
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-15 mb-3">
            <span class="pulse-beacon"></span>
            <span class="small fw-bold text-white">Live Teleconsultation Network &bull; Ready to Connect</span>
        </div>

        <h1 class="display-6 fw-extrabold mb-2" style="letter-spacing: -0.5px;">
            Consult Top Specialists via <span style="color: #38BDF8;">Instant Video Call</span>
        </h1>
        <p class="text-light text-opacity-75 lead fs-6 max-w-700 mx-auto mb-4" style="max-width: 680px;">
            Skip travel and waiting rooms. Get verified medical advice, digital prescriptions, and clinical follow-ups in 10 minutes from home.
        </p>

        <!-- Search Bar -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <form action="<?= base_url('teleconsult'); ?>" method="GET" class="filter-search-box text-start">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-primary ps-2 pe-1">
                                    <i class="fa-solid fa-stethoscope"></i>
                                </span>
                                <select class="form-select border-0 shadow-none text-secondary fw-semibold" name="specialty">
                                    <option value="">All Specialties</option>
                                    <?php if(!empty($specialization)): foreach($specialization as $spec): ?>
                                        <option value="<?= html_escape($spec->name); ?>" <?= (!empty($active_specialty) && strcasecmp($active_specialty, $spec->name) == 0) ? 'selected' : ''; ?>>
                                            <?= html_escape($spec->name); ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-5 border-start-md">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-muted ps-2 pe-1">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" class="form-control border-0 shadow-none" name="keyword" value="<?= html_escape($active_keyword ?? ''); ?>" placeholder="Doctor name, symptoms or health concern...">
                            </div>
                        </div>

                        <div class="col-12 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-1.5">
                                <span>Search</span>
                                <i class="fa-solid fa-arrow-right small"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

<!-- Filter Chips & Status Bar -->
<section class="py-4 bg-white border-bottom">
    <div class="container">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <span>Available Doctors for Video Consultation</span>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1" style="font-size: 12px;">
                        <i class="fa-solid fa-circle-check"></i> <?= count($doctors); ?> Online Now
                    </span>
                </h5>
                <p class="text-muted small mb-0">Showing only doctors who have enabled online video availability in their practice session.</p>
            </div>

            <!-- Quick Specialty Chips -->
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= base_url('teleconsult'); ?>" class="specialty-chip <?= empty($active_specialty) ? 'active' : ''; ?>">All</a>
                <a href="<?= base_url('teleconsult?specialty=General+Physician'); ?>" class="specialty-chip <?= ($active_specialty == 'General Physician') ? 'active' : ''; ?>">General Physician</a>
                <a href="<?= base_url('teleconsult?specialty=Cardiologist'); ?>" class="specialty-chip <?= ($active_specialty == 'Cardiologist') ? 'active' : ''; ?>">Cardiologist</a>
                <a href="<?= base_url('teleconsult?specialty=Dermatologist'); ?>" class="specialty-chip <?= ($active_specialty == 'Dermatologist') ? 'active' : ''; ?>">Dermatologist</a>
                <a href="<?= base_url('teleconsult?specialty=Pediatrician'); ?>" class="specialty-chip <?= ($active_specialty == 'Pediatrician') ? 'active' : ''; ?>">Pediatrician</a>
            </div>
        </div>

    </div>
</section>

<!-- Main Doctors Grid -->
<section class="py-5">
    <div class="container">
        
        <?php if (!empty($doctors)): ?>
        <div class="row g-4">
            <?php foreach ($doctors as $doc): 
                $drName = trim(($doc->fname ?? '') . ' ' . ($doc->lname ?? ''));
                if (stripos($drName, 'dr') !== 0) $drName = 'Dr. ' . $drName;
                $docImg = !empty($doc->drimage) ? base_url('uploads/doctor/' . $doc->drimage) : 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80';
                $fee = !empty($doc->dr_fee) ? (int)$doc->dr_fee : 500;
                $specialtyName = !empty($doc->specialization_name) ? $doc->specialization_name : 'Specialist Consultant';
                $degree = !empty($doc->degree_name) ? $doc->degree_name : 'MBBS, MD';
                $exp = !empty($doc->exp) ? $doc->exp . ' yrs exp' : '10+ yrs exp';
            ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="tele-card text-center">
                    
                    <!-- Doctor Avatar + Live Video Beacon -->
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img src="<?= $docImg; ?>" alt="<?= html_escape($drName); ?>" class="doc-avatar-img" onerror="this.src='https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80';">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle p-1.5" title="Available for Video Call"></span>
                    </div>

                    <!-- Verified Name -->
                    <h5 class="fw-bold text-dark mb-1 d-flex align-items-center justify-content-center gap-1.5">
                        <span class="text-truncate" style="max-width: 200px;"><?= html_escape($drName); ?></span>
                        <i class="fa-solid fa-circle-check text-primary fs-6" title="Verified Specialist"></i>
                    </h5>

                    <!-- Specialty & Degrees -->
                    <span class="text-primary fw-semibold small mb-1"><?= html_escape($specialtyName); ?></span>
                    <span class="text-muted small mb-2"><?= html_escape($degree); ?> &bull; <?= html_escape($exp); ?></span>

                    <!-- Video Badge Indicator -->
                    <div class="d-inline-flex align-items-center justify-content-center gap-2 py-1.5 px-3 rounded-pill bg-success bg-opacity-10 text-success fw-bold mx-auto mb-3" style="font-size: 11px;">
                        <span class="pulse-beacon"></span>
                        <span>Video Consult Available</span>
                    </div>

                    <hr class="text-muted opacity-15 my-0 mb-3">

                    <!-- Fee & Next Availability -->
                    <div class="d-flex justify-content-between align-items-center mb-3 mt-auto">
                        <div class="text-start">
                            <small class="text-muted d-block" style="font-size: 11px;">Consultation Fee</small>
                            <span class="fw-extrabold text-dark fs-5">₹<?= number_format($fee); ?></span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-secondary border px-2.5 py-1.5 rounded-pill" style="font-size: 11px;">
                                <i class="fa-regular fa-clock text-primary me-1"></i> In 10 Mins
                            </span>
                        </div>
                    </div>

                    <!-- Direct Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('doctor/book/' . $doc->id . '?type=video'); ?>" class="btn btn-success rounded-pill py-2 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-2" style="font-size: 13.5px;">
                            <i class="fa-solid fa-video"></i>
                            <span>Start Video Consult</span>
                        </a>
                        <a href="<?= base_url('hospital/doctor_detail/' . $doc->id); ?>" class="btn btn-outline-secondary btn-sm rounded-pill py-1.5 fw-semibold" style="font-size: 12px;">
                            View Profile &amp; Bio
                        </a>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <!-- Zero Results State -->
        <div class="text-center py-5 bg-white rounded-4 border p-5 max-w-700 mx-auto">
            <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex mb-3">
                <i class="fa-solid fa-video-slash fs-2"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">No Doctors Currently Online for Video Consultation</h4>
            <p class="text-muted small max-w-500 mx-auto mb-4" style="max-width: 480px;">
                No verified specialists are currently active for online video consult in this category. Doctors enable this feature directly from their practice sessions.
            </p>
            <a href="<?= base_url('teleconsult'); ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                Clear Filters &amp; View All
            </a>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- Footer -->
<footer class="upchar-footer pt-5 pb-4 mt-5">
    <div class="container text-center text-md-start">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2 mb-3 mb-md-0">
                <img src="<?= base_url('images/Final_logo23.png'); ?>" alt="Upchar" style="height: 38px; width: auto;" onerror="this.src='<?= base_url('images/logo.png'); ?>';">
                <span class="fw-bold text-white fs-5">Upchar<span class="text-info">+</span> Teleconsult</span>
            </div>
            <p class="small text-muted mb-0">&copy; <?= date('Y'); ?> Upchar Healthcare Network. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>