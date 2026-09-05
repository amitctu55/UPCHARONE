<?php include ("includes/header_new.php"); ?>

<!-- 1. DYNAMIC SPLIT HERO SECTION WITH MULTI-TAB SEARCH -->
<section class="hero-wrapper position-relative overflow-hidden">
    <div class="container py-4">
        <div class="row align-items-center" style="display: flex; align-items: center; flex-wrap: wrap;">
            <!-- Left Hero Content & Dynamic Search Widget -->
            <div class="col-lg-7 col-md-12">
                <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm mb-3" style="border: 1px solid #e2e8f0; display: inline-flex; align-items: center; gap: 8px; border-radius: 50px; padding: 6px 16px; background: #fff; margin-bottom: 16px;">
                    <span class="badge bg-success rounded-circle" style="background-color: #10b981; color: #fff; width: 20px; height: 20px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;">
                        <i class="fas fa-check"></i>
                    </span>
                    <small class="fw-bold text-dark" style="font-weight: 700; color: #1e293b;">India's Trusted Healthcare Network</small>
                </div>

                <h1 class="hero-main-title mb-3">
                    Your Home For Health &amp; <span>Doctor Consultations</span>
                </h1>

                <p class="fs-5 text-muted mb-4 pe-lg-4" style="font-size: 1.15rem; color: #64748b; line-height: 1.6; margin-bottom: 24px;">
                    Book verified in-clinic appointments, instant 24/7 video consultations, certified lab tests, and hospital care seamlessly.
                </p>

                <!-- MULTI-TAB SEARCH CONTAINER -->
                <div class="search-card">
                    <!-- Search Pill Tabs -->
                    <div class="search-tab-group">
                        <button type="button" class="search-tab-btn active" data-type="doctors" data-action="<?=base_url('doctors');?>" data-placeholder="Search doctors, specialties (e.g. Cardiologist, Dentist)...">
                            <i class="fas fa-user-md me-1"></i> Doctors
                        </button>
                        <button type="button" class="search-tab-btn" data-type="lab-tests" data-action="<?=base_url('lab-tests');?>" data-placeholder="Search lab tests &amp; checkups (e.g. CBC, Full Body)...">
                            <i class="fas fa-flask me-1"></i> Lab Tests
                        </button>
                        <button type="button" class="search-tab-btn" data-type="hospitals" data-action="<?=base_url('hospitals');?>" data-placeholder="Search hospitals &amp; clinics by name or department...">
                            <i class="fas fa-hospital me-1"></i> Hospitals
                        </button>
                    </div>

                    <!-- Search Form -->
                    <form id="heroSearchForm" action="<?=base_url('doctors');?>" method="GET" class="row g-2 align-items-center" style="margin: 0;">
                        <div class="col-md-4 col-sm-12" style="padding: 4px;">
                            <div class="input-group" style="width: 100%;">
                                <span class="input-group-addon" style="background: #f8fafc; border: 1px solid #e2e8f0; border-right: none; color: #ef4444;"><i class="fas fa-map-marker-alt"></i></span>
                                <select name="city" id="heroCitySelect" class="form-control" style="border: 1px solid #e2e8f0; border-left: none; background: #f8fafc; font-weight: 600; color: #334155; height: 44px; border-radius: 0 8px 8px 0;">
                                    <option value="">All Locations</option>
                                    <?php if (!empty($cities)) { foreach($cities as $c){ ?>
                                    <option value="<?=$c->name;?>" <?=(isset($_GET['city']) && ($_GET['city'] == $c->id || $_GET['city'] == $c->name)) ? 'selected' : '';?>><?=$c->name;?></option>
                                    <?php } } else { ?>
                                    <option value="Varanasi" selected>Varanasi</option>
                                    <option value="Lucknow">Lucknow</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Mumbai">Mumbai</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12" style="padding: 4px;">
                            <div class="input-group" style="width: 100%;">
                                <span class="input-group-addon" style="background: #f8fafc; border: 1px solid #e2e8f0; border-right: none; color: #64748b;"><i class="fas fa-search"></i></span>
                                <input type="text" id="heroKeywordInput" name="keyword" value="<?=@$_GET['keyword'];?>" class="form-control" placeholder="Search doctors, specialties..." style="border: 1px solid #e2e8f0; border-left: none; background: #f8fafc; height: 44px; border-radius: 0 8px 8px 0;">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12" style="padding: 4px;">
                            <button type="submit" class="btn btn-primary w-100" style="width: 100%; height: 44px; font-weight: 700; border-radius: 8px; background: #2563eb; border: none; color: #fff; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                                Find Care <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Hero Graphic with Floating Live Stat Badges -->
            <div class="col-lg-5 col-md-12 text-center" style="margin-top: 30px;">
                <div class="hero-image-container">
                    <img src="<?=base_url('images/hero-doctor.png');?>" alt="Verified Healthcare Specialists" class="hero-main-graphic img-fluid" onerror="this.src='<?=base_url('images/ladydoctor.jpg');?>'">

                    <!-- Floating Live Stat Badge 1 (Specialists) -->
                    <div class="hero-floating-badge badge-top">
                        <div class="badge-icon-box bg-soft-blue">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div style="text-align: left;">
                            <div style="font-weight: 800; font-size: 16px; color: #0f172a; line-height: 1.2;">1,400+</div>
                            <small style="color: #64748b; font-weight: 600; font-size: 11px;">Verified Specialists</small>
                        </div>
                    </div>

                    <!-- Floating Live Stat Badge 2 (24/7 Care) -->
                    <div class="hero-floating-badge badge-bottom">
                        <div class="badge-icon-box bg-soft-success">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div style="text-align: left;">
                            <div style="font-weight: 800; font-size: 16px; color: #0f172a; line-height: 1.2;">24/7 Care</div>
                            <small style="color: #64748b; font-weight: 600; font-size: 11px;">Instant Video Connect</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. QUICK SERVICE CARDS (4-COLUMN HIGH-TRUST GRID) -->
<section class="py-5" style="background: #ffffff; padding: 50px 0;">
    <div class="container">
        <div class="row g-4" style="display: flex; flex-wrap: wrap; margin: -12px;">
            <!-- 1. Instant Video Consult -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 12px;">
                <a href="<?=base_url('doctors');?>" class="service-card">
                    <div>
                        <div class="service-card-icon-box bg-soft-blue">
                            <i class="fas fa-video"></i>
                        </div>
                        <h4 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">Instant Video Consult</h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">24/7 connectivity in 60s with certified specialist doctors right from home.</p>
                    </div>
                    <div style="font-weight: 700; color: #2563eb; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                        Consult Online <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                    </div>
                </a>
            </div>

            <!-- 2. In-Clinic Appointments -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 12px;">
                <a href="<?=base_url('doctors');?>" class="service-card">
                    <div>
                        <div class="service-card-icon-box bg-soft-emerald">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h4 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">In-Clinic Appointments</h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">Zero wait time &amp; no booking fees. Book verified specialists near you.</p>
                    </div>
                    <div style="font-weight: 700; color: #059669; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                        Find Doctors <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                    </div>
                </a>
            </div>

            <!-- 3. Lab Tests & Checkups -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 12px;">
                <a href="<?=base_url('lab-tests');?>" class="service-card">
                    <div>
                        <div class="service-card-icon-box bg-soft-indigo">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h4 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">Lab Tests &amp; Checkups</h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">100% NABL certified partner labs with free doorstep sample collection.</p>
                    </div>
                    <div style="font-weight: 700; color: #4f46e5; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                        Book Lab Test <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                    </div>
                </a>
            </div>

            <!-- 4. Surgeries & Hospitals -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 12px;">
                <a href="<?=base_url('hospitals');?>" class="service-card">
                    <div>
                        <div class="service-card-icon-box bg-soft-sky">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h4 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">Surgeries &amp; Hospitals</h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">NABH accredited hospitals with seamless admission &amp; insurance support.</p>
                    </div>
                    <div style="font-weight: 700; color: #0284c7; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                        Explore Care <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 3. TOP SPECIALTIES GRID (6-COLUMN RESPONSIVE) -->
<section class="section-wrapper" style="background: #f8fafc; padding: 60px 0; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 40px;">
            <span class="badge bg-soft-primary px-3 py-2 rounded-pill fw-bold text-uppercase fs-8" style="font-size: 11px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; display: inline-block;">Top Specialties</span>
            <h2 class="section-main-heading" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 8px 0;">Consult Top Doctors by Specialization</h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748b; max-width: 620px; margin: 0 auto;">Get expert medical consultation for any health concern with India's most experienced doctors.</p>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap; margin: -10px;">
            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="padding: 10px;">
                <a href="<?=base_url('doctors?spl=General+Medicine');?>" class="specialty-card">
                    <div class="specialty-icon-circle bg-soft-blue">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h5 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">General Medicine</h5>
                    <small style="color: #64748b; font-size: 11px;">Fever, Flu, Fatigue</small>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="padding: 10px;">
                <a href="<?=base_url('doctors?spl=Gynecology');?>" class="specialty-card">
                    <div class="specialty-icon-circle bg-soft-pink">
                        <i class="fas fa-female"></i>
                    </div>
                    <h5 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">Gynecology</h5>
                    <small style="color: #64748b; font-size: 11px;">Women &amp; Maternity</small>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="padding: 10px;">
                <a href="<?=base_url('doctors?spl=Dermatology');?>" class="specialty-card">
                    <div class="specialty-icon-circle bg-soft-amber">
                        <i class="fas fa-allergies"></i>
                    </div>
                    <h5 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">Dermatology</h5>
                    <small style="color: #64748b; font-size: 11px;">Skin, Hair &amp; Acne</small>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="padding: 10px;">
                <a href="<?=base_url('doctors?spl=Pediatrics');?>" class="specialty-card">
                    <div class="specialty-icon-circle bg-soft-cyan">
                        <i class="fas fa-baby"></i>
                    </div>
                    <h5 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">Pediatrics</h5>
                    <small style="color: #64748b; font-size: 11px;">Child Care &amp; Vaccine</small>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="padding: 10px;">
                <a href="<?=base_url('doctors?spl=Orthopedics');?>" class="specialty-card">
                    <div class="specialty-icon-circle bg-soft-purple">
                        <i class="fas fa-bone"></i>
                    </div>
                    <h5 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">Orthopedics</h5>
                    <small style="color: #64748b; font-size: 11px;">Joints, Bones &amp; Spine</small>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="padding: 10px;">
                <a href="<?=base_url('doctors?spl=Dentistry');?>" class="specialty-card">
                    <div class="specialty-icon-circle bg-soft-emerald">
                        <i class="fas fa-tooth"></i>
                    </div>
                    <h5 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 4px;">Dentistry</h5>
                    <small style="color: #64748b; font-size: 11px;">Teeth &amp; Root Canal</small>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 4. FEATURED SPECIALISTS SLIDER -->
<section class="section-wrapper" style="padding: 60px 0; background: #ffffff;">
    <div class="container">                    
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 35px;">
            <span class="badge bg-soft-primary px-3 py-2 rounded-pill fw-bold text-uppercase fs-8" style="font-size: 11px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; display: inline-block;">Verified Consultants</span>
            <h2 class="section-main-heading" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 8px 0;">Book Our Leading Specialists</h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748b; max-width: 620px; margin: 0 auto;">Experienced medical practitioners verified for quality care, high ratings, and patient trust.</p>
        </div>

        <div class="specialists-slider-container">
            <button class="slider-nav-btn slider-nav-prev" id="specPrevBtn" aria-label="Previous Specialists">
                <i class="glyphicon glyphicon-chevron-left"></i>
            </button>

            <div class="specialists-track" id="specialistsTrack">
                <?php if (!empty($doctor_slid)) { foreach($doctor_slid as $ds){ 
                    $quastring = '';
                    $qu = $this->db->get_where('dr_qualifications', array('user_id' => $ds->id));
                    if ($qu && $qu->num_rows() > 0) {
                        foreach($qu->result() as $q) {
                            $quastring .= getQualificationName($q->qualification_id).', ';
                        }
                        $quastring = rtrim($quastring, ', ');
                    }
                    $drImg = ($ds->drimage && file_exists('admin1947/public/assets/upload/'.$ds->drimage)) 
                             ? admin_url().'public/assets/upload/'.$ds->drimage 
                             : admin_url().'public/assets/upload/dummydr.jpg';
                    $drPrefix = (strcasecmp(substr($ds->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
                ?>
                <div class="specialist-card doctor-card">
                    <div class="doctor-avatar-wrap">
                        <img loading="lazy" src="<?=$drImg;?>" alt="<?=$ds->fname;?>" class="doctor-avatar">
                        <span class="doctor-verified-badge"><i class="fas fa-check"></i></span>
                    </div>
                    <h4 class="specialist-name" style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">
                        <a href="<?=base_url();?>doctor/<?=$ds->id;?>" style="color: #0f172a; text-decoration: none;"><?=$drPrefix.$ds->fname.' '.$ds->lname;?></a>
                    </h4>
                    <?php if (!empty($quastring)) { ?>
                    <span class="badge bg-soft-primary text-primary fs-8 px-3 py-1 rounded-pill mb-2" title="<?=$quastring;?>" style="display: inline-block; font-size: 11px; margin-bottom: 12px;"><?=$quastring;?></span>
                    <?php } else { ?>
                    <span class="badge bg-soft-primary text-primary fs-8 px-3 py-1 rounded-pill mb-2" style="display: inline-block; font-size: 11px; margin-bottom: 12px;">Consultant Specialist</span>
                    <?php } ?>
                    <div style="display: flex; gap: 6px; width: 100%; margin-top: auto;">
                        <a href="<?=base_url();?>doctor/<?=$ds->id;?>" class="btn btn-sm btn-outline-primary" style="width: 50%; font-size: 12px; border-radius: 20px; padding: 6px 0; font-weight: 600;">
                            Profile
                        </a>
                        <a href="<?=base_url();?>doctor/<?=$ds->id;?>" class="btn btn-sm btn-primary" style="width: 50%; font-size: 12px; border-radius: 20px; padding: 6px 0; font-weight: 600; background: #2563eb; border-color: #2563eb;">
                            Book Now
                        </a>
                    </div>
                </div>
                <?php } } else { ?>
                <div class="col-md-12 text-center text-muted" style="padding: 30px;">
                    <p>No specialist records found at the moment.</p>
                </div>
                <?php } ?>
            </div>

            <button class="slider-nav-btn slider-nav-next" id="specNextBtn" aria-label="Next Specialists">
                <i class="glyphicon glyphicon-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- 5. POPULAR PATHOLOGY TESTS & DIAGNOSTIC PACKAGES -->
<section class="section-wrapper" id="pathology-tests" style="background: #FFFFFF; padding: 60px 0; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge" style="background: #E0F2FE; color: #0284C7;"><i class="fas fa-flask"></i> Diagnostic Health Checkups</span>
            <h2 class="section-main-heading">Popular Pathology Tests & Diagnostic Packages</h2>
            <p class="section-sub-heading">Certified diagnostic lab testing with doorstep home sample collection, digital reports in 24 hrs, and affordable transparent pricing.</p>
        </div>

        <div class="path-test-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 30px;">
            <?php 
            $defaultTests = array(
                array('name' => 'Complete Blood Count (CBC)', 'code' => 'CBC-01', 'sample' => 'Blood / EDTA', 'fasting' => 'Non-Fasting', 'price' => 299, 'mrp' => 500, 'params' => '24 Parameters', 'method' => 'Automated Cell Counter'),
                array('name' => 'Fasting Blood Sugar (FBS)', 'code' => 'GLU-F', 'sample' => 'Blood / Fluoride', 'fasting' => '10-12 hrs Fasting', 'price' => 99, 'mrp' => 200, 'params' => 'Blood Glucose', 'method' => 'Hexokinase Method'),
                array('name' => 'Lipid Profile Comprehensive', 'code' => 'LIP-01', 'sample' => 'Blood / Serum', 'fasting' => '12 hrs Fasting', 'price' => 599, 'mrp' => 1200, 'params' => '8 Parameters', 'method' => 'Enzymatic Spectrophotometry'),
                array('name' => 'Thyroid Profile Total (T3, T4, TSH)', 'code' => 'THY-T', 'sample' => 'Blood / Serum', 'fasting' => 'Non-Fasting', 'price' => 399, 'mrp' => 800, 'params' => '3 Hormones', 'method' => 'CLIA Technology'),
                array('name' => 'Liver Function Test (LFT)', 'code' => 'LFT-01', 'sample' => 'Blood / Serum', 'fasting' => 'Non-Fasting', 'price' => 499, 'mrp' => 950, 'params' => '11 Parameters', 'method' => 'Colorimetric Kinetic'),
                array('name' => 'Kidney Function Test (KFT / RFT)', 'code' => 'KFT-01', 'sample' => 'Blood / Serum', 'fasting' => 'Non-Fasting', 'price' => 499, 'mrp' => 900, 'params' => '7 Parameters', 'method' => 'Enzymatic UV'),
                array('name' => 'HbA1c Glycated Hemoglobin', 'code' => 'HBA1C', 'sample' => 'Blood / EDTA', 'fasting' => 'Non-Fasting', 'price' => 350, 'mrp' => 600, 'params' => '3-Month Sugar', 'method' => 'HPLC Gold Standard'),
                array('name' => 'Full Body Health Package (60+ Tests)', 'code' => 'FBH-60', 'sample' => 'Blood & Urine', 'fasting' => '10-12 hrs Fasting', 'price' => 999, 'mrp' => 2999, 'params' => '64 Parameters', 'method' => 'Multi-Automated Panels')
            );

            $displayTests = !empty($pathology_tests) ? $pathology_tests : $defaultTests;
            foreach($displayTests as $t):
                $tName = is_object($t) ? $t->test_name : $t['name'];
                $tCode = is_object($t) ? ($t->code ?: $t->short_name) : $t['code'];
                $tPrice = is_object($t) ? (floatval($t->amount) ?: 299) : $t['price'];
                $tMrp = is_object($t) ? round($tPrice * 1.6) : $t['mrp'];
                $tMethod = is_object($t) ? ($t->method ?: 'Standard Automated') : $t['method'];
                $tFasting = is_object($t) ? 'Home Pickup Available' : $t['fasting'];
                $tParams = is_object($t) ? ($t->short_name ?: 'Diagnostic Panel') : $t['params'];
            ?>
            <div class="path-test-card" style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
                <div style="position: absolute; top: 12px; right: 12px; background: #DCFCE7; color: #15803D; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fas fa-home"></i> Home Pickup
                </div>
                <div>
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 42px; border-radius: 10px; background: #EFF6FF; color: #2563EB; font-size: 18px; margin-bottom: 12px;">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0 0 6px 0; line-height: 1.35; padding-right: 60px;">
                        <?=htmlspecialchars($tName);?>
                    </h4>
                    <p style="font-size: 12px; color: #64748B; margin: 0 0 12px 0;">
                        <i class="fas fa-vial" style="color: #00a896; margin-right: 4px;"></i> <?=htmlspecialchars($tParams);?> &bull; <?=htmlspecialchars($tMethod);?>
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px;">
                        <span style="font-size: 11px; background: #F8FAFC; color: #475569; padding: 3px 8px; border-radius: 6px; border: 1px solid #E2E8F0;">
                            <i class="far fa-clock"></i> Reports in 24 hrs
                        </span>
                        <span style="font-size: 11px; background: #FEF3C7; color: #92400E; padding: 3px 8px; border-radius: 6px; border: 1px solid #FDE68A;">
                            <?=htmlspecialchars($tFasting);?>
                        </span>
                    </div>
                </div>

                <div style="border-top: 1px solid #F1F5F9; padding-top: 14px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 11px; color: #94A3B8; text-decoration: line-through;">₹<?=$tMrp;?></div>
                        <div style="font-size: 18px; font-weight: 800; color: #00a896; line-height: 1;">
                            ₹<?=$tPrice;?>
                        </div>
                    </div>
                    <a href="<?=base_url('pathlab-login');?>" class="btn btn-sm" style="background: #00a896; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 8px 16px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
                        Book Test <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 35px;">
            <a href="<?=base_url('pathlab-login');?>" class="btn btn-default" style="background: #F8FAFC; border: 1px solid #CBD5E1; color: #334155; font-weight: 600; padding: 10px 24px; border-radius: 8px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-th-list text-primary"></i> View All Diagnostic Packages & Certified Labs <i class="fas fa-chevron-right" style="font-size: 11px;"></i>
            </a>
        </div>
    </div>
</section>

<!-- 5.5 SPONSORED HEALTHCARE SHOWCASE (MEDICINES, MEDICAL STORES, HOSPITALS, PATHOLOGY LABS) -->
<?php if (!empty($sponsored_ads)): ?>
<section class="section-wrapper" id="sponsoredShowcaseSection" style="background: linear-gradient(180deg, #F8FAFC 0%, #EFF6FF 100%); padding: 50px 0; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
    <div class="container">
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 30px;">
            <span class="section-badge" style="background: rgba(0, 168, 150, 0.12); color: #008f80; border: 1px solid rgba(0, 168, 150, 0.3); font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fas fa-bullhorn"></i> Verified Partner Offers &amp; Sponsored Healthcare
            </span>
            <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 10px 0 6px;">
                Featured Medicine Offers, Medical Stores, Hospitals &amp; Labs
            </h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748B; max-width: 680px; margin: 0 auto;">
                Exclusive partner deals on genuine medicines, NABH hospital consultations, doorstep diagnostic checkups, and verified neighborhood medical stores.
            </p>
        </div>

        <!-- Ad Category Filter Tabs -->
        <div style="display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; margin-bottom: 26px;">
            <button type="button" class="btn btn-sm btn-ad-filter active" data-cat="all" style="font-weight: 700; border-radius: 20px; padding: 6px 16px; font-size: 12px; background: #00a896; color: #fff; border: none;">
                All Offers
            </button>
            <button type="button" class="btn btn-sm btn-ad-filter" data-cat="medicine" style="font-weight: 700; border-radius: 20px; padding: 6px 16px; font-size: 12px; background: #fff; color: #334155; border: 1px solid #CBD5E1;">
                💊 Sponsored Medicines
            </button>
            <button type="button" class="btn btn-sm btn-ad-filter" data-cat="medical_store" style="font-weight: 700; border-radius: 20px; padding: 6px 16px; font-size: 12px; background: #fff; color: #334155; border: 1px solid #CBD5E1;">
                🏪 Medical Stores
            </button>
            <button type="button" class="btn btn-sm btn-ad-filter" data-cat="hospital" style="font-weight: 700; border-radius: 20px; padding: 6px 16px; font-size: 12px; background: #fff; color: #334155; border: 1px solid #CBD5E1;">
                🏥 Featured Hospitals
            </button>
            <button type="button" class="btn btn-sm btn-ad-filter" data-cat="pathology" style="font-weight: 700; border-radius: 20px; padding: 6px 16px; font-size: 12px; background: #fff; color: #334155; border: 1px solid #CBD5E1;">
                🔬 Diagnostic Labs
            </button>
            <button type="button" class="btn btn-sm btn-ad-filter" data-cat="equipment" style="font-weight: 700; border-radius: 20px; padding: 6px 16px; font-size: 12px; background: #fff; color: #334155; border: 1px solid #CBD5E1;">
                🩺 Medical Devices
            </button>
        </div>

        <!-- Ad Cards Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;" id="adShowcaseGrid">
            <?php foreach ($sponsored_ads as $ad): 
                $imgSrc = filter_var($ad->image, FILTER_VALIDATE_URL) ? $ad->image : (base_url('public/assets/upload/' . $ad->image));
                $adUrl  = base_url('home/ad_click/' . $ad->id);
                $cat = $ad->category ?: 'general';
            ?>
            <div class="sponsored-ad-card" data-category="<?=$cat;?>" style="background: #FFFFFF; border-radius: 14px; border: 1px solid #E2E8F0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
                <div style="position: relative; height: 160px; overflow: hidden; background: #0f172a;">
                    <img src="<?=$imgSrc;?>" alt="<?=html_escape($ad->title);?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500';">
                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #2DD4BF; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(45, 212, 191, 0.4);">
                        <i class="fas fa-certificate"></i> <?=html_escape($ad->sponsor_badge ?: 'Sponsored Partner');?>
                    </span>
                    <span style="position: absolute; bottom: 10px; right: 12px; background: rgba(0, 0, 0, 0.6); color: #FFFFFF; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
                        <?=str_replace('_', ' ', $cat);?>
                    </span>
                </div>

                <div style="padding: 18px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px; line-height: 1.35;">
                            <?=html_escape($ad->title ?: $ad->short_description);?>
                        </h4>
                        <p style="font-size: 13px; color: #64748B; margin: 0 0 12px; line-height: 1.45;">
                            <?=html_escape($ad->short_description);?>
                        </p>
                    </div>

                    <div style="border-top: 1px solid #F1F5F9; padding-top: 12px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 11.5px; color: #0284C7; font-weight: 600;">
                            <i class="fas fa-check-circle"></i> Verified Offer
                        </span>
                        <a href="<?=$adUrl;?>" target="_blank" class="btn btn-sm" style="background: #00a896; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 6px 14px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            Explore Offer <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
$('.btn-ad-filter').click(function() {
    $('.btn-ad-filter').css({'background': '#fff', 'color': '#334155', 'border': '1px solid #CBD5E1'}).removeClass('active');
    $(this).css({'background': '#00a896', 'color': '#fff', 'border': 'none'}).addClass('active');

    var cat = $(this).data('cat');
    if (cat === 'all') {
        $('.sponsored-ad-card').fadeIn();
    } else {
        $('.sponsored-ad-card').each(function() {
            if ($(this).data('category') === cat) {
                $(this).fadeIn();
            } else {
                $(this).fadeOut();
            }
        });
    }
});
</script>
<?php endif; ?>

<!-- 6. HIGH-TRUST STATS BAR -->
<div class="container">
    <div class="trust-stats-bar">
        <div class="trust-stats-grid">
            <div class="trust-stat-item">
                <h3 class="trust-stat-number">50,000+</h3>
                <p class="trust-stat-label">Happy Patients Consulted</p>
            </div>
            <div class="trust-stat-item">
                <h3 class="trust-stat-number">1,400+</h3>
                <p class="trust-stat-label">Verified Doctor Specialists</p>
            </div>
            <div class="trust-stat-item">
                <h3 class="trust-stat-number">98.6%</h3>
                <p class="trust-stat-label">Positive Patient Reviews</p>
            </div>
            <div class="trust-stat-item">
                <h3 class="trust-stat-number">24/7</h3>
                <p class="trust-stat-label">Dedicated Patient Helpline</p>
            </div>
        </div>
    </div>
</div>

<!-- 6. PATIENT TESTIMONIALS (3-COLUMN TRUST & REVIEW GRID) -->
<section class="section-wrapper" style="background: #FFFFFF; padding: 60px 0;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Verified Reviews</span>
            <h2 class="section-main-heading">What Our Patients Say About Upchar</h2>
            <p class="section-sub-heading">Real experiences from patients who found prompt care, expert doctors, and smooth appointments.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div>
                    <div class="testimonial-header">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <span class="verified-badge"><i class="fas fa-check-circle"></i> Verified Patient</span>
                    </div>
                    <p class="testimonial-quote">
                        "Booking a specialist doctor was so effortless. I found an experienced pediatrician in Varanasi within minutes and avoided long clinic queues."
                    </p>
                </div>
                <div class="testimonial-user">
                    <img src="<?=base_url('images/dummydr.jpg');?>" alt="Pooja Sharma" class="testimonial-avatar">
                    <div>
                        <h5 class="testimonial-user-name">Pooja Sharma</h5>
                        <p class="testimonial-user-location">Varanasi &bull; Pediatrics Consult</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div>
                    <div class="testimonial-header">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <span class="verified-badge"><i class="fas fa-check-circle"></i> Verified Patient</span>
                    </div>
                    <p class="testimonial-quote">
                        "The instant consultation feature connected me with a senior physician when I had high fever late at night. Clear advice and instant digital prescription!"
                    </p>
                </div>
                <div class="testimonial-user">
                    <img src="<?=base_url('images/dummydr.jpg');?>" alt="Rahul Verma" class="testimonial-avatar">
                    <div>
                        <h5 class="testimonial-user-name">Rahul Verma</h5>
                        <p class="testimonial-user-location">Lucknow &bull; General Medicine</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div>
                    <div class="testimonial-header">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <span class="verified-badge"><i class="fas fa-check-circle"></i> Verified Patient</span>
                    </div>
                    <p class="testimonial-quote">
                        "Highly recommend Upchar for anyone looking for verified hospitals and surgeries. Transparent fee structure and friendly customer care support."
                    </p>
                </div>
                <div class="testimonial-user">
                    <img src="<?=base_url('images/dummydr.jpg');?>" alt="Ananya Mishra" class="testimonial-avatar">
                    <div>
                        <h5 class="testimonial-user-name">Ananya Mishra</h5>
                        <p class="testimonial-user-location">Delhi NCR &bull; Dermatology Care</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. SAFETY & ASSURANCE PILLARS -->
<section class="section-wrapper" style="padding: 60px 0; background: #F8FAFC;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Safety First</span>
            <h2 class="section-main-heading">Healthcare Built on Trust & Privacy</h2>
            <p class="section-sub-heading">Every doctor, clinic, and lab is rigorously screened so you receive the highest quality of healthcare.</p>
        </div>

        <div class="safety-pillars-grid">
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon"><i class="fas fa-user-check"></i></div>
                <h4 class="safety-pillar-title">100% Verified Doctors</h4>
                <p class="safety-pillar-desc">Medical degrees and certifications checked before listing.</p>
            </div>
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon"><i class="fas fa-lock"></i></div>
                <h4 class="safety-pillar-title">Data Privacy & Security</h4>
                <p class="safety-pillar-desc">Your health records and consultations are 100% confidential.</p>
            </div>
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon"><i class="fas fa-tag"></i></div>
                <h4 class="safety-pillar-title">Zero Booking Charges</h4>
                <p class="safety-pillar-desc">Transparent consultation fees with no hidden platform markups.</p>
            </div>
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon"><i class="fas fa-headset"></i></div>
                <h4 class="safety-pillar-title">24/7 Patient Helpline</h4>
                <p class="safety-pillar-desc">Call 844-844-0603 anytime for instant support & booking help.</p>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('includes/footer.php'); ?>

<!-- Interactive Specialist Slider & Multi-Tab Search Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var track = document.getElementById('specialistsTrack');
    var prevBtn = document.getElementById('specPrevBtn');
    var nextBtn = document.getElementById('specNextBtn');
    
    if (track && prevBtn && nextBtn) {
        var scrollAmount = 300;
        
        prevBtn.addEventListener('click', function() {
            track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });
        
        nextBtn.addEventListener('click', function() {
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }

    // Dynamic Multi-Tab Search Switcher
    var searchTabs = document.querySelectorAll('.search-tab-btn');
    var heroForm = document.getElementById('heroSearchForm');
    var heroInput = document.getElementById('heroKeywordInput');

    if (searchTabs.length) {
        searchTabs.forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                searchTabs.forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');

                var targetAction = this.getAttribute('data-action');
                var targetPlaceholder = this.getAttribute('data-placeholder');

                if (heroForm) heroForm.action = targetAction;
                if (heroInput) heroInput.placeholder = targetPlaceholder;
            });
        });
    }

    // Synchronize City dropdown with header selector & localStorage
    var savedCity = localStorage.getItem('upchar_selected_city');
    var heroCity = document.getElementById('heroCitySelect');
    if (savedCity && heroCity) {
        for (var i = 0; i < heroCity.options.length; i++) {
            if (heroCity.options[i].text.toLowerCase() === savedCity.toLowerCase() || heroCity.options[i].value.toLowerCase() === savedCity.toLowerCase()) {
                heroCity.selectedIndex = i;
                break;
            }
        }
    }

    $(document).on('click', '.city-option', function() {
        var c = $(this).data('city');
        if (heroCity && c) {
            for (var i = 0; i < heroCity.options.length; i++) {
                if (heroCity.options[i].text.toLowerCase() === c.toLowerCase() || heroCity.options[i].value.toLowerCase() === c.toLowerCase()) {
                    heroCity.selectedIndex = i;
                    break;
                }
            }
        }
    });
});
</script>

