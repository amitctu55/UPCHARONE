<?php include ("includes/header_new.php"); ?>

<!-- 1. HERO & CENTERED FLOATING SEARCH PILL -->
<section class="hero-search-section">
    <div class="container">
        <div class="hero-search-header">
            <div class="hero-trust-pill">
                <i class="fas fa-user-circle"></i> Welcome Back, <?=@$this->session->userdata('username') ?: 'Valued Patient';?>
            </div>
            <h1 class="hero-main-title">
                Your Home For <span>Health & Doctor</span> Consultations
            </h1>
            <p class="hero-main-desc">
                Find and book verified in-clinic doctor appointments, instant 24/7 video consultations, certified diagnostic lab tests, and advanced hospital care.
            </p>
        </div>

        <!-- Prominent Centered Floating Search Pill UI -->
        <form action="<?=base_url();?>search" method="GET">
            <div class="search-pill-container">
                <!-- Location Picker -->
                <div class="search-pill-sec loc-sec">
                    <i class="fas fa-map-marker-alt search-pill-icon"></i>
                    <select class="search-pill-select" name="city" id="searchCitySelect" title="Select Location">
                        <option value="">All Locations / Cities</option>
                        <?php if (!empty($cities)) { foreach($cities as $c){ ?>
                        <option value='<?=$c->id;?>' <?=(isset($_GET['city']) && $_GET['city'] == $c->id) ? 'selected' : '';?>><?=$c->name;?></option>
                        <?php } } ?>
                    </select>
                </div>

                <div class="search-pill-divider"></div>

                <!-- Keyword Search -->
                <div class="search-pill-sec kw-sec">
                    <i class="fas fa-search search-pill-icon"></i>
                    <input type="text" id="hint" class="search-pill-input ui-autocomplete-input" name="keyword" value="<?=@$_GET['keyword'];?>" placeholder="Search doctors, clinics, hospitals, treatments..." autocomplete="off">
                </div>

                <div class="search-pill-divider"></div>

                <!-- Specialization Dropdown -->
                <div class="search-pill-sec spl-sec">
                    <i class="fas fa-user-md search-pill-icon"></i>
                    <select class="search-pill-select" name="spl" title="Select Specialization">
                        <option value="">All Specialties</option>
                        <?php if (!empty($specialization)) { foreach($specialization as $s){ ?>
                        <option value='<?=$s->id;?>' <?=(isset($_GET['spl']) && $_GET['spl'] == $s->id) ? 'selected' : '';?>><?=$s->name;?></option>
                        <?php } } ?>                   
                    </select>
                </div>

                <!-- Primary Search CTA Button -->
                <button type="submit" class="search-pill-btn" title="Search Doctors & Clinics">
                    <i class="fas fa-search"></i> Find Care
                </button>
            </div>
        </form>
    </div>
</section>

<!-- 2. CORE SERVICE CARDS (4-CARD HIGH-TRUST GRID) -->
<section class="core-services-section">
    <div class="container">
        <div class="core-services-grid">
            <!-- Service 1: Instant Video Consult -->
            <a href="<?=base_url('search');?>" class="core-service-card">
                <div class="service-icon-box service-icon-blue">
                    <i class="fas fa-video"></i>
                </div>
                <h3 class="service-card-title">Instant Video Consult</h3>
                <p class="service-card-desc">Connect within 60 secs with verified medical specialists 24/7 from anywhere.</p>
                <div class="service-card-btn">
                    Consult Online <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Service 2: In-Clinic Appointments -->
            <a href="<?=base_url('doctors');?>" class="core-service-card">
                <div class="service-icon-box service-icon-emerald">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3 class="service-card-title">In-Clinic Appointments</h3>
                <p class="service-card-desc">Confirmed doctor appointments with guaranteed minimal wait times and zero fees.</p>
                <div class="service-card-btn">
                    Find Doctors <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Service 3: Lab Tests & Diagnostics -->
            <a href="<?=base_url('pathlab-login');?>" class="core-service-card">
                <div class="service-icon-box service-icon-indigo">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="service-card-title">Lab Tests & Checkups</h3>
                <p class="service-card-desc">100% certified pathology labs with free doorstep sample pickup & digital reports.</p>
                <div class="service-card-btn">
                    Book Lab Test <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Service 4: Surgeries & Hospital Care -->
            <a href="<?=base_url('hospitals');?>" class="core-service-card">
                <div class="service-icon-box service-icon-sky">
                    <i class="fas fa-hospital"></i>
                </div>
                <h3 class="service-card-title">Surgeries & Hospitals</h3>
                <p class="service-card-desc">Advanced surgical procedures, accredited hospitals, and complete insurance help.</p>
                <div class="service-card-btn">
                    Explore Surgeries <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- 3. SPECIALIZATION CATEGORY GRID -->
<section class="section-wrapper" style="background: #FFFFFF; padding: 60px 0;">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Top Specialties</span>
            <h2 class="section-main-heading">Consult Top Doctors by Specialization</h2>
            <p class="section-sub-heading">Get expert medical consultation for any health concern with India's most experienced doctors.</p>
        </div>

        <div class="specialization-category-grid">
            <a href="<?=base_url();?>search?spl=1" class="spec-category-card">
                <div class="spec-category-icon" style="background: #E8F0FE; color: #1A73E8;">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <h4 class="spec-category-title">General Medicine</h4>
                <p class="spec-category-subtitle">Fever, Cough, Flu, Fatigue</p>
            </a>

            <a href="<?=base_url();?>search?spl=2" class="spec-category-card">
                <div class="spec-category-icon" style="background: #FCE7F3; color: #EC4899;">
                    <i class="fas fa-female"></i>
                </div>
                <h4 class="spec-category-title">Gynecology</h4>
                <p class="spec-category-subtitle">Women's Health & Maternity</p>
            </a>

            <a href="<?=base_url();?>search?spl=3" class="spec-category-card">
                <div class="spec-category-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-allergies"></i>
                </div>
                <h4 class="spec-category-title">Dermatology</h4>
                <p class="spec-category-subtitle">Skin, Hair & Acne Care</p>
            </a>

            <a href="<?=base_url();?>search?spl=4" class="spec-category-card">
                <div class="spec-category-icon" style="background: #CFFAFE; color: #0891B2;">
                    <i class="fas fa-baby"></i>
                </div>
                <h4 class="spec-category-title">Pediatrics</h4>
                <p class="spec-category-subtitle">Child Health & Vaccines</p>
            </a>

            <a href="<?=base_url();?>search?spl=5" class="spec-category-card">
                <div class="spec-category-icon" style="background: #EDE9FE; color: #7C3AED;">
                    <i class="fas fa-bone"></i>
                </div>
                <h4 class="spec-category-title">Orthopedics</h4>
                <p class="spec-category-subtitle">Joints, Bones & Spine Care</p>
            </a>

            <a href="<?=base_url();?>search?spl=6" class="spec-category-card">
                <div class="spec-category-icon" style="background: #E6F4EA; color: #16A34A;">
                    <i class="fas fa-tooth"></i>
                </div>
                <h4 class="spec-category-title">Dentistry</h4>
                <p class="spec-category-subtitle">Teeth, Gums & Root Canal</p>
            </a>
        </div>
    </div>
</section>

<!-- 4. FEATURED SPECIALISTS SLIDER -->
<section class="section-wrapper" style="padding: 60px 0; background: #F8FAFC;">
    <div class="container">                    
        <div class="section-title-wrap">
            <span class="section-badge">Verified Consultants</span>
            <h2 class="section-main-heading">Book Our Leading Specialists</h2>
            <p class="section-sub-heading">Experienced medical practitioners verified for quality care, high ratings, and patient trust.</p>
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
                <div class="specialist-card">
                    <div class="specialist-avatar-wrap">
                        <img loading="lazy" src="<?=$drImg;?>" alt="<?=$ds->fname;?>" class="specialist-avatar">
                    </div>
                    <h4 class="specialist-name">
                        <a href="<?=base_url();?>doctor/<?=$ds->id;?>"><?=$drPrefix.$ds->fname.' '.$ds->lname;?></a>
                    </h4>
                    <?php if (!empty($quastring)) { ?>
                    <span class="specialist-qualification" title="<?=$quastring;?>"><?=$quastring;?></span>
                    <?php } else { ?>
                    <span class="specialist-qualification">Consultant Specialist</span>
                    <?php } ?>
                    <a href="<?=base_url();?>doctor/<?=$ds->id;?>" class="specialist-btn-view">
                        <i class="fa fa-calendar-check"></i> View Profile & Book
                    </a>
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

<!-- Interactive Specialist Slider Script -->
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
});
</script>
