<?php include ("includes/header.php"); ?>

<!-- 1. PREMIER HERO & INTELLECTUAL SEARCH PILL SECTION -->
<section class="hero-search-section-modern">
    <div class="container">
        <?php if (!empty($isUserLoggedIn)): ?>
        <!-- Logged-In Patient Welcome & Quick Access Dashboard Bar -->
        <div class="patient-dashboard-bar-modern">
            <div class="patient-welcome-text">
                <h4>Welcome back, <?=html_escape($currentUserName ?? 'Patient');?> 👋</h4>
                <p>Access your health records, scheduled consultations, and trusted medical services.</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Hero Title & Subtitle with Clean Breathing Room -->
        <div class="text-center" style="max-width: 860px; margin: 0 auto 28px;">
            <div class="hero-trust-pill-modern">
                <span class="hero-trust-dot"></span>
                <span>ABDM Integrated &bull; India's Trusted Healthcare Network</span>
            </div>
            <h1 class="hero-main-title-modern">
                Your Home For <span>Health &amp; Doctor</span> Consultations
            </h1>
            <p class="hero-main-desc-modern">
                Find and book verified in-clinic doctor appointments, instant 24/7 video consultations, certified diagnostic lab tests, and advanced hospital care with zero booking fees.
            </p>
        </div>

        <!-- Elevated Hero Search Box Card -->
        <div class="hero-search-widget-container">
            <form action="<?=base_url('search');?>" method="GET" id="mainHomeSearchForm" class="search-card-form">
                <div class="search-fields-row">
                    <!-- Location Picker -->
                    <div class="search-field-group field-location">
                        <label for="searchCitySelect" class="search-field-label">
                            <i class="fas fa-map-marker-alt field-icon" aria-hidden="true"></i>
                            <span>Location</span>
                        </label>
                        <select class="search-field-select" name="location" id="searchCitySelect" title="Select Location / City">
                            <option value="">All Locations / Cities</option>
                            <?php if (!empty($cities)) { foreach($cities as $c){ 
                                $is_sel = (isset($_GET['location']) && ($_GET['location'] == $c->id || strcasecmp($_GET['location'], $c->name) == 0)) || (isset($_GET['city']) && ($_GET['city'] == $c->id || strcasecmp($_GET['city'], $c->name) == 0));
                            ?>
                            <option value='<?=$c->name;?>' <?=$is_sel ? 'selected' : '';?>><?=$c->name;?></option>
                            <?php } } else { ?>
                            <option value="Varanasi" selected>Varanasi</option>
                            <option value="Lucknow">Lucknow</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Prayagraj">Prayagraj</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="search-field-divider" aria-hidden="true"></div>

                    <!-- Specialization Dropdown -->
                    <div class="search-field-group field-specialty">
                        <label for="searchSpecSelect" class="search-field-label">
                            <i class="fas fa-stethoscope field-icon" aria-hidden="true"></i>
                            <span>Specialty</span>
                        </label>
                        <select class="search-field-select" name="speciality" id="searchSpecSelect" title="Select Medical Specialization">
                            <option value="">All Specialties</option>
                            <?php if (!empty($specialization)) { foreach($specialization as $s){ 
                                $is_spec_sel = (isset($_GET['speciality']) && ($_GET['speciality'] == $s->id || strcasecmp($_GET['speciality'], $s->name) == 0)) || (isset($_GET['spl']) && ($_GET['spl'] == $s->id || strcasecmp($_GET['spl'], $s->name) == 0));
                            ?>
                            <option value='<?=$s->name;?>' <?=$is_spec_sel ? 'selected' : '';?>><?=$s->name;?></option>
                            <?php } } ?>                   
                        </select>
                    </div>

                    <div class="search-field-divider" aria-hidden="true"></div>

                    <!-- Keyword / Doctor / Clinic / Symptoms Search -->
                    <div class="search-field-group field-keyword">
                        <label for="hint" class="search-field-label">
                            <i class="fas fa-search field-icon" aria-hidden="true"></i>
                            <span>Doctor, Clinic or Symptom</span>
                        </label>
                        <input type="text" id="hint" class="search-field-input ui-autocomplete-input" name="keyword" value="<?=@htmlspecialchars($_GET['keyword'] ?? '');?>" placeholder="e.g. Cardiologist, Fever, Apollo..." autocomplete="off">
                    </div>

                    <!-- Primary Search CTA Button -->
                    <div class="search-btn-wrapper">
                        <button type="submit" class="search-submit-btn" title="Search Healthcare Providers" aria-label="Search Healthcare Providers">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <span>Find Care</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Popular Quick Search Tags & Dedicated Emergency Hotline -->
        <div class="search-quick-tags-modern" style="margin-top: 22px;">
            <span style="font-weight: 600; color: #475569; font-size: 13px;"><i class="fas fa-bolt text-warning" style="margin-right: 4px;" aria-hidden="true"></i> Quick Search:</span>
            <a href="<?=base_url('search?keyword=General+Physician');?>" class="quick-tag-chip-modern">General Physician</a>
            <a href="<?=base_url('search?keyword=Pediatrician');?>" class="quick-tag-chip-modern">Pediatrician</a>
            <a href="<?=base_url('search?keyword=Gynecologist');?>" class="quick-tag-chip-modern">Gynecologist</a>
            <a href="<?=base_url('search?keyword=Dermatologist');?>" class="quick-tag-chip-modern">Dermatologist</a>
            <a href="tel:108" onclick="triggerEmergencyCall(); return false;" class="quick-tag-emergency" title="Emergency Ambulance 108" aria-label="Emergency Ambulance Call 108">
                <i class="fas fa-ambulance" aria-hidden="true"></i> <span>24/7 Ambulance (108)</span>
            </a>
        </div>
    </div>
</section>

<!-- 2. CORE HEALTHCARE SERVICES (Fix Issue 9: Standardized badge positioning and color coding) -->
<section class="core-services-section-modern">
    <div class="container">
        <!-- Semantic Section H2 (Accessible outline) -->
        <h2 class="sr-only">Our Core Healthcare Services</h2>

        <div class="core-services-grid-modern">
            <!-- 1: In-Clinic Appointments -->
            <a href="<?=base_url('doctors');?>" class="core-service-card-modern">
                <span class="service-card-badge-modern badge-service-standard">Confirmed Slot</span>
                <div class="service-icon-box-modern icon-box-teal">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3 class="service-card-title-modern">In-Clinic Consult</h3>
                <p class="service-card-desc-modern">Book verified doctor appointments with zero wait time.</p>
            </a>

            <!-- 2: Instant Video Consult -->
            <a href="<?=base_url('search');?>" class="core-service-card-modern">
                <span class="service-card-badge-modern badge-service-standard">Instant 24/7</span>
                <div class="service-icon-box-modern icon-box-blue">
                    <i class="fas fa-video"></i>
                </div>
                <h3 class="service-card-title-modern">Video Consult</h3>
                <p class="service-card-desc-modern">Connect 24/7 with top specialists from home.</p>
            </a>

            <!-- 3: Medicines & Pharmacy Delivery -->
            <a href="javascript:void(0);" onclick="openMedicineCompareModal()" class="core-service-card-modern">
                <span class="service-card-badge-modern badge-service-standard">Certified Chemists</span>
                <div class="service-icon-box-modern icon-box-emerald">
                    <i class="fas fa-pills"></i>
                </div>
                <h3 class="service-card-title-modern">Order Medicines</h3>
                <p class="service-card-desc-modern">Doorstep delivery from certified local chemists.</p>
            </a>

            <!-- 4: Lab Tests & Diagnostics -->
            <a href="#pathology-tests" class="core-service-card-modern">
                <span class="service-card-badge-modern badge-service-standard">Home Pickup</span>
                <div class="service-icon-box-modern icon-box-purple">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="service-card-title-modern">Lab Tests &amp; Scans</h3>
                <p class="service-card-desc-modern">100% certified labs with free home sample collection.</p>
            </a>

            <!-- 5: Surgeries & Hospitals -->
            <a href="<?=base_url('hospitals');?>" class="core-service-card-modern">
                <span class="service-card-badge-modern badge-service-standard">NABH Accredited</span>
                <div class="service-icon-box-modern icon-box-amber">
                    <i class="fas fa-hospital"></i>
                </div>
                <h3 class="service-card-title-modern">Hospitals &amp; Surgeries</h3>
                <p class="service-card-desc-modern">Seamless admissions, cashless insurance &amp; daycare care.</p>
            </a>

            <!-- 6: Emergency Ambulance -->
            <a href="tel:108" class="core-service-card-modern">
                <span class="service-card-badge-modern badge-service-emergency">24/7 SOS</span>
                <div class="service-icon-box-modern icon-box-rose">
                    <i class="fas fa-ambulance"></i>
                </div>
                <h3 class="service-card-title-modern">24/7 Ambulance</h3>
                <p class="service-card-desc-modern">Rapid GPS-tracked emergency response across India.</p>
            </a>
        </div>
    </div>
</section>

<!-- 3. TOP MEDICAL SPECIALTIES & SYMPTOMS (Fix Issues 6, 7, 11, 22) -->
<section class="section-wrapper" style="background: #FFFFFF; padding: 50px 0 60px;">
    <div class="container">
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 28px;">
            <span class="section-badge" style="background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: none;">Top Specialties</span>
            <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 8px 0;">Consult Top Doctors by Specialization</h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748B; max-width: 640px; margin: 0 auto;">Get expert medical consultation for any health concern with India's most experienced verified doctors.</p>
        </div>

        <div class="specialization-category-grid-modern">
            <?php 
            // Curated clinical specialty mapping with symptoms & icons (Fix Issue 22: replaces repetitive subtext with concise condition tags)
            $specialtyIcons = [
                'General Physician' => ['icon' => 'fa-stethoscope', 'bg' => '#E8F0FE', 'color' => '#1A73E8', 'symptoms' => 'Fever, Cough, Flu, Cold'],
                'General Medicine'  => ['icon' => 'fa-stethoscope', 'bg' => '#E8F0FE', 'color' => '#1A73E8', 'symptoms' => 'Fever, Cough, Flu, Fatigue'],
                'Gynecologist'      => ['icon' => 'fa-female', 'bg' => '#FCE7F3', 'color' => '#EC4899', 'symptoms' => "Periods, Pregnancy & PCOD"],
                'Gynecology'        => ['icon' => 'fa-female', 'bg' => '#FCE7F3', 'color' => '#EC4899', 'symptoms' => "Women's Health & Maternity"],
                'Dermatologist'     => ['icon' => 'fa-allergies', 'bg' => '#FEF3C7', 'color' => '#D97706', 'symptoms' => 'Acne, Hairfall & Skin Rashes'],
                'Dermatology'       => ['icon' => 'fa-allergies', 'bg' => '#FEF3C7', 'color' => '#D97706', 'symptoms' => 'Skin Care, Glow & Allergies'],
                'Pediatrician'      => ['icon' => 'fa-baby', 'bg' => '#CFFAFE', 'color' => '#0891B2', 'symptoms' => 'Child Health, Fever & Growth'],
                'Pediatrics'        => ['icon' => 'fa-baby', 'bg' => '#CFFAFE', 'color' => '#0891B2', 'symptoms' => 'Child Care & Vaccinations'],
                'Orthopedic'        => ['icon' => 'fa-bone', 'bg' => '#EDE9FE', 'color' => '#7C3AED', 'symptoms' => 'Joint Pain, Fracture & Spine'],
                'Orthopedics'       => ['icon' => 'fa-bone', 'bg' => '#EDE9FE', 'color' => '#7C3AED', 'symptoms' => 'Knee Pain & Arthritis Care'],
                'Dentist'           => ['icon' => 'fa-tooth', 'bg' => '#E6F4EA', 'color' => '#16A34A', 'symptoms' => 'Toothache, Cavities & Braces'],
                'Dentistry'         => ['icon' => 'fa-tooth', 'bg' => '#E6F4EA', 'color' => '#16A34A', 'symptoms' => 'Root Canal & Cleaning'],
                'Cardiologist'      => ['icon' => 'fa-heartbeat', 'bg' => '#FFE4E6', 'color' => '#E11D48', 'symptoms' => 'Chest Pain, BP & Heart Care'],
                'Cardiology'        => ['icon' => 'fa-heartbeat', 'bg' => '#FFE4E6', 'color' => '#E11D48', 'symptoms' => 'Hypertension & Cholesterol'],
                'ENT Specialist'    => ['icon' => 'fa-deaf', 'bg' => '#FEF9C3', 'color' => '#CA8A04', 'symptoms' => 'Ear Pain, Sinus & Tonsils'],
                'ENT'               => ['icon' => 'fa-deaf', 'bg' => '#FEF9C3', 'color' => '#CA8A04', 'symptoms' => 'Throat Infection & Sinus'],
                'Neurologist'       => ['icon' => 'fa-brain', 'bg' => '#F3E8FF', 'color' => '#9333EA', 'symptoms' => 'Migraine, Stroke & Nerve Issues'],
                'Neurology'         => ['icon' => 'fa-brain', 'bg' => '#F3E8FF', 'color' => '#9333EA', 'symptoms' => 'Headache & Nerve Care'],
                'Gastroenterologist'=> ['icon' => 'fa-utensils', 'bg' => '#FFEDD5', 'color' => '#EA580C', 'symptoms' => 'Acidity, Gas & Digestion'],
                'Psychiatrist'      => ['icon' => 'fa-smile', 'bg' => '#DCFCE7', 'color' => '#15803D', 'symptoms' => 'Anxiety, Stress & Sleep Health'],
                'Ophthalmologist'   => ['icon' => 'fa-eye', 'bg' => '#E0F2FE', 'color' => '#0284C7', 'symptoms' => 'Eye Strain, Blurry Vision']
            ];

            if (!empty($specialization)) {
                foreach($specialization as $index => $s) {
                    $sName = trim($s->name);
                    $iconData = $specialtyIcons[$sName] ?? [
                        'icon' => 'fa-user-md',
                        'bg' => '#F1F5F9',
                        'color' => '#00a896',
                        'symptoms' => 'Clinical Diagnosis & Care'
                    ];
                    $extraClass = ($index >= 8) ? 'specialty-hidden-item specialty-card-toggle' : '';
            ?>
            <!-- Fix Issue 11: Semantic H3 tag for specialty title; Fix Issue 6: 12.5px font-size -->
            <a href="<?=base_url();?>search?spl=<?=$s->id;?>" class="spec-category-card-modern <?=$extraClass;?>">
                <div class="spec-category-icon-modern" style="background: <?=$iconData['bg'];?>; color: <?=$iconData['color'];?>;">
                    <i class="fas <?=$iconData['icon'];?>"></i>
                </div>
                <h3 style="font-size: 14.5px; font-weight: 700; color: #0F172A; margin: 0 0 4px; line-height: 1.3;"><?=htmlspecialchars($sName);?></h3>
                <p class="spec-symptom-modern" style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;"><?=$iconData['symptoms'];?></p>
            </a>
            <?php 
                } 
            } else {
                $index = 0;
                foreach($specialtyIcons as $sName => $iconData) {
                    $extraClass = ($index >= 8) ? 'specialty-hidden-item specialty-card-toggle' : '';
                    $index++;
            ?>
            <a href="<?=base_url();?>search?keyword=<?=urlencode($sName);?>" class="spec-category-card-modern <?=$extraClass;?>">
                <div class="spec-category-icon-modern" style="background: <?=$iconData['bg'];?>; color: <?=$iconData['color'];?>;">
                    <i class="fas <?=$iconData['icon'];?>"></i>
                </div>
                <h3 style="font-size: 14.5px; font-weight: 700; color: #0F172A; margin: 0 0 4px; line-height: 1.3;"><?=$sName;?></h3>
                <p class="spec-symptom-modern" style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;"><?=$iconData['symptoms'];?></p>
            </a>
            <?php } } ?>
        </div>

        <div class="text-center" style="margin-top: 28px; display: flex; justify-content: center; align-items: center; gap: 16px; flex-wrap: wrap;">
            <button type="button" id="toggleSpecialties" class="btn-modern-outline" style="cursor: pointer; background: #FFFFFF; font-weight: 600;">
                <span>View All Specializations</span> <i class="fas fa-arrow-right" style="margin-left: 6px;"></i>
            </button>
            <a href="<?=base_url('doctors');?>" style="font-size: 13.5px; color: #00A896; text-decoration: none; font-weight: 600;">
                <i class="fas fa-user-md" style="margin-right: 4px;"></i> Browse Doctor Directory &rarr;
            </a>
        </div>
    </div>
</section>

<!-- 4. FEATURED SPECIALISTS SLIDER (Fix Issues 7, 12, 19, 20) -->
<section class="section-wrapper" style="padding: 55px 0 65px; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
    <div class="container">                    
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
            <div>
                <!-- Fix Issue 7: Removed all-caps transform -->
                <span class="section-badge" style="background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: none;">Verified Consultants</span>
                <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 6px 0 4px;">Book Our Leading Medical Specialists</h2>
                <p class="section-sub-heading" style="font-size: 14px; color: #64748B; margin: 0;">Verified for medical qualifications, clinic infrastructure, patient reviews, and prompt care.</p>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn btn-default" id="specPrevBtn" style="border-radius: 50%; width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06); background: #fff;" aria-label="Previous Specialists">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-default" id="specNextBtn" style="border-radius: 50%; width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06); background: #fff;" aria-label="Next Specialists">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Fix Issue 20: Slider track and constrained 270px card width prevents 1140px full-width stretching -->
        <div class="specialists-slider-container-modern">
            <div class="specialists-track-modern" id="specialistsTrack">
                <?php if (!empty($doctor_slid)) { foreach($doctor_slid as $ds){ 
                    $quastring = '';
                    $qu = $this->db->get_where('dr_qualifications', array('user_id' => $ds->id));
                    if ($qu && $qu->num_rows() > 0) {
                        foreach($qu->result() as $q) {
                            $quastring .= getQualificationName($q->qualification_id).', ';
                        }
                        $quastring = rtrim($quastring, ', ');
                    }
                    // Fix Issue 19: Clean SVG default doctor avatar replacing watermarked cartoon
                    $cleanDefaultAvatar = base_url('images/doctor-avatar-default.svg');
                    $isDummy = empty($ds->drimage) || (strpos($ds->drimage, 'dummy') !== false);
                    $drImg = (!$isDummy && file_exists('admin1947/public/assets/upload/'.$ds->drimage)) 
                             ? admin_url().'public/assets/upload/'.$ds->drimage 
                             : $cleanDefaultAvatar;
                    $drPrefix = (strcasecmp(substr($ds->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
                ?>
                <div class="specialist-card-modern">
                    <div>
                        <!-- Fix Issue 19: Clean unwatermarked vector doctor fallback -->
                        <div class="specialist-avatar-wrap-modern">
                            <img loading="lazy" src="<?=$drImg;?>" alt="<?=$ds->fname;?>" class="specialist-avatar-modern" onerror="this.src='<?=$cleanDefaultAvatar;?>'">
                            <span class="specialist-verified-icon" title="ABDM &amp; Medical Council Verified"><i class="fas fa-check"></i></span>
                        </div>
                        <!-- Fix Issue 12: Semantic H3 tag for doctor name -->
                        <h3 class="specialist-name-modern">
                            <a href="<?=base_url();?>doctor/<?=$ds->id;?>"><?=$drPrefix.htmlspecialchars($ds->fname.' '.$ds->lname);?></a>
                        </h3>
                        <span class="specialist-spec-badge">
                            <?=htmlspecialchars($ds->speciality_name ?? 'Senior Consultant');?>
                        </span>
                        <div class="specialist-qual-text" title="<?=$quastring;?>">
                            <?=htmlspecialchars($quastring ?: 'MBBS, Certified Specialist');?>
                        </div>
                        <div style="font-size: 12px; color: #10b981; font-weight: 600; margin-bottom: 14px;">
                            <i class="far fa-clock"></i> Available Today &bull; Min. Wait
                        </div>
                    </div>

                    <a href="<?=base_url();?>doctor/<?=$ds->id;?>" class="specialist-book-btn">
                        <i class="far fa-calendar-check"></i> Book Appointment
                    </a>
                </div>
                <?php } } else { ?>
                <div class="text-center text-muted" style="padding: 40px; width: 100%;">
                    <p style="font-size: 14px;">No specialist records found at the moment.</p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- 5. POPULAR PATHOLOGY TESTS & DIAGNOSTIC PACKAGES (Fix Issues 8, 13) -->
<section class="section-wrapper" id="pathology-tests" style="background: #FFFFFF; padding: 55px 0 65px;">
    <div class="container">
        <!-- Fix Issue 8: Prominent, high-contrast View All Tests CTA with proper proximity and hierarchy -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
            <div>
                <span class="section-badge" style="background: #E0F2FE; color: #0284C7; border: 1px solid #BAE6FD; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: none;">Diagnostic Health Checkups</span>
                <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 6px 0 4px;">Popular Pathology Tests &amp; Diagnostic Packages</h2>
                <p class="section-sub-heading" style="font-size: 14px; color: #64748B; margin: 0;">Certified diagnostic labs with doorstep sample pickup, 24-hr digital reports, and transparent pricing.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="<?=base_url('mytest');?>" class="btn-view-all-prominent" aria-label="View all pathology tests and health packages">
                    View All Tests <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-default testsPrevBtn" style="border-radius: 50%; width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06); background: #fff;" aria-label="Previous Diagnostic Tests">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-default testsNextBtn" style="border-radius: 50%; width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06); background: #fff;" aria-label="Next Diagnostic Tests">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Swiper Container for Diagnostic Tests -->
        <div class="swiper testsSwiper">
            <div class="swiper-wrapper">
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
                <div class="swiper-slide">
                    <div class="card h-100 shadow-sm border-0 rounded-4" style="background: #FFFFFF; border-radius: 14px; border: 1px solid #E2E8F0; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%; width: 100%; transition: all 0.25s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.03); position: relative;">
                        <div style="position: absolute; top: 12px; right: 12px; background: #DCFCE7; color: #15803D; font-size: 12px; font-weight: 700; padding: 2px 8px; border-radius: 20px;">
                            <i class="fas fa-home"></i> Home Pickup
                        </div>
                        <div>
                            <div style="display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 42px; border-radius: 10px; background: #EFF6FF; color: #2563EB; font-size: 18px; margin-bottom: 12px;">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <!-- Fix Issue 13: Semantic H3 tag for diagnostic package -->
                            <h3 style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0 0 6px 0; line-height: 1.35; padding-right: 65px;">
                                <?=htmlspecialchars($tName);?>
                            </h3>
                            <p style="font-size: 12px; color: #64748B; margin: 0 0 12px 0;">
                                <i class="fas fa-vial" style="color: #00a896; margin-right: 4px;"></i> <?=htmlspecialchars($tParams);?> &bull; <?=htmlspecialchars($tMethod);?>
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px;">
                                <span style="font-size: 12px; font-weight: 600; background: #F8FAFC; color: #475569; padding: 3px 8px; border-radius: 6px; border: 1px solid #E2E8F0;">
                                    <i class="far fa-clock"></i> Reports in 24 hrs
                                </span>
                                <!-- Fix Issue 8: Raised badge font size from 11px to 12px -->
                                <span style="font-size: 12px; font-weight: 600; background: #FEF3C7; color: #92400E; padding: 3px 8px; border-radius: 6px; border: 1px solid #FDE68A;">
                                    <?=htmlspecialchars($tFasting);?>
                                </span>
                            </div>
                        </div>

                        <!-- Fix Issue 6: Grouped price and Book Test CTA with tight visual association, eliminating dead gap -->
                        <div class="test-card-footer-modern mt-auto" style="margin-top: auto;">
                            <div class="test-pricing-group">
                                <span class="test-mrp-val">₹<?=$tMrp;?></span>
                                <span class="test-price-val">₹<?=$tPrice;?></span>
                            </div>
                            <a href="<?=base_url('pathlab-login');?>" class="test-book-btn-modern" aria-label="Book <?=htmlspecialchars($tName);?>">
                                Book Test <i class="fas fa-arrow-right" aria-hidden="true" style="font-size: 11px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- Swiper Navigation Arrows & Pagination -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- 6. SPONSORED HEALTHCARE DEALS & PARTNER SHOWCASE -->
<?php if (!empty($sponsored_ads)): ?>
<section class="section-wrapper" id="sponsoredShowcaseSection" style="background: linear-gradient(180deg, #F8FAFC 0%, #F0FDFA 100%); padding: 55px 0; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
    <div class="container">
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 28px;">
            <span class="section-badge" style="background: rgba(0, 168, 150, 0.12); color: #008f80; border: 1px solid rgba(0, 168, 150, 0.3); font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: none;">
                <i class="fas fa-bullhorn"></i> Verified Partner Offers
            </span>
            <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 10px 0 6px;">
                Featured Medicine Offers, Medical Stores, Hospitals &amp; Labs
            </h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748B; max-width: 680px; margin: 0 auto;">
                Exclusive discounts on genuine medicines, NABH hospital consultations, doorstep diagnostic packages, and verified medical devices.
            </p>
        </div>

        <!-- Ad Category Filter Tabs -->
        <div style="display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; margin-bottom: 24px;">
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
                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #2DD4BF; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(45, 212, 191, 0.4);">
                        <i class="fas fa-certificate"></i> <?=html_escape($ad->sponsor_badge ?: 'Sponsored Partner');?>
                    </span>
                    <span style="position: absolute; bottom: 10px; right: 12px; background: rgba(0, 0, 0, 0.6); color: #FFFFFF; font-size: 12px; font-weight: 600; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
                        <?=str_replace('_', ' ', $cat);?>
                    </span>
                </div>

                <div style="padding: 18px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="font-size: 15.5px; font-weight: 800; color: #0F172A; margin: 0 0 6px; line-height: 1.35;">
                            <?=html_escape($ad->title ?: $ad->short_description);?>
                        </h3>
                        <p style="font-size: 13px; color: #64748B; margin: 0 0 12px; line-height: 1.45;">
                            <?=html_escape($ad->short_description);?>
                        </p>
                    </div>

                    <div style="border-top: 1px solid #F1F5F9; padding-top: 12px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 12px; color: #0284C7; font-weight: 600;">
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

<!-- 7. HIGH-TRUST STATS BAR -->
<div class="container">
    <div class="trust-stats-bar">
        <div class="trust-stats-grid">
            <div class="trust-stat-item">
                <div class="trust-stat-number" style="color: #2DD4BF; font-size: 32px; font-weight: 800;">50,000+</div>
                <p class="trust-stat-label" style="font-size: 13px; margin: 4px 0 0;">Happy Patients Consulted</p>
            </div>
            <div class="trust-stat-item">
                <div class="trust-stat-number" style="color: #38BDF8; font-size: 32px; font-weight: 800;">1,400+</div>
                <p class="trust-stat-label" style="font-size: 13px; margin: 4px 0 0;">Verified Medical Specialists</p>
            </div>
            <div class="trust-stat-item">
                <div class="trust-stat-number" style="color: #FBBF24; font-size: 32px; font-weight: 800;">98.6%</div>
                <p class="trust-stat-label" style="font-size: 13px; margin: 4px 0 0;">Positive Patient Reviews</p>
            </div>
            <div class="trust-stat-item">
                <div class="trust-stat-number" style="color: #A78BFA; font-size: 32px; font-weight: 800;">24/7</div>
                <p class="trust-stat-label" style="font-size: 13px; margin: 4px 0 0;">Emergency Patient Helpline</p>
            </div>
        </div>
    </div>
</div>


<!-- 9. SAFETY & ASSURANCE PILLARS (Fix Issue 15: Semantic H3 tag for safety pillar titles) -->
<section class="section-wrapper" style="padding: 55px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
    <div class="container">
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 28px;">
            <span class="section-badge" style="background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: none;">Safety First</span>
            <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 6px 0 4px;">Healthcare Built on Trust, Quality &amp; Privacy</h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748B; margin: 0;">Every doctor, clinic, hospital, and lab on Upchar is rigorously screened to deliver the highest clinical standards.</p>
        </div>

        <div class="safety-pillars-grid">
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon" style="color: #00a896;"><i class="fas fa-user-check"></i></div>
                <!-- Fix Issue 15: Semantic H3 tag for pillar title -->
                <h3 class="safety-pillar-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">100% Verified Doctors</h3>
                <p class="safety-pillar-desc" style="font-size: 13px; color: #64748B; margin: 0;">Medical degrees, council licenses, and qualifications verified.</p>
            </div>
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon" style="color: #0284c7;"><i class="fas fa-shield-alt"></i></div>
                <!-- Fix Issue 15: Semantic H3 tag for pillar title -->
                <h3 class="safety-pillar-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">Data Privacy &amp; Security</h3>
                <p class="safety-pillar-desc" style="font-size: 13px; color: #64748B; margin: 0;">Your clinical records and consultations are 100% confidential.</p>
            </div>
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon" style="color: #10b981;"><i class="fas fa-tag"></i></div>
                <!-- Fix Issue 15: Semantic H3 tag for pillar title -->
                <h3 class="safety-pillar-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">Zero Booking Charges</h3>
                <p class="safety-pillar-desc" style="font-size: 13px; color: #64748B; margin: 0;">Transparent consultation fees with zero hidden platform charges.</p>
            </div>
            <div class="safety-pillar-card">
                <div class="safety-pillar-icon" style="color: #e11d48;"><i class="fas fa-headset"></i></div>
                <!-- Fix Issue 15: Semantic H3 tag for pillar title -->
                <h3 class="safety-pillar-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">24/7 Patient Helpline</h3>
                <p class="safety-pillar-desc" style="font-size: 13px; color: #64748B; margin: 0;">Call 844-844-0603 anytime for instant care assistance.</p>
            </div>
        </div>
    </div>
</section>


<!-- 11. OUR HEALTHCARE PARTNER PORTALS (Fix Issue 17: Semantic H3 tag for partner titles) -->
<section class="section-wrapper" style="padding: 55px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0;">
    <div class="container">
        <div class="section-title-wrap" style="text-align: center; margin-bottom: 28px;">
            <span class="section-badge" style="background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 20px; text-transform: none;">Partnership</span>
            <h2 class="section-main-heading" style="font-size: 26px; font-weight: 800; color: #0F172A; margin: 6px 0 4px;">Join Our Healthcare Network</h2>
            <p class="section-sub-heading" style="font-size: 14px; color: #64748B; margin: 0;">Partner with Upchar to grow your medical practice, clinic, hospital, diagnostic lab, or pharmacy.</p>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                <div class="modern-partner-card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 230px;">
                    <div>
                        <div class="modern-partner-icon" style="color: #0284c7;"><i class="fas fa-hospital"></i></div>
                        <!-- Fix Issue 17: Semantic H3 tag for partner title -->
                        <h3 class="modern-partner-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">Hospitals &amp; Clinics</h3>
                        <p style="font-size: 13px; color: #64748B; margin: 0 0 14px;">Verified institutions offering comprehensive inpatient &amp; outpatient clinical care.</p>
                    </div>
                    <div class="partner-card-footer-modern">
                        <div class="partner-card-actions">
                            <a href="<?=base_url('hospital-login');?>" class="btn-partner-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> <span>Login</span></a>
                            <a href="<?=base_url('hospital-signup');?>" class="btn-partner-join btn-partner-hospital"><i class="fas fa-plus" aria-hidden="true"></i> <span>Join</span></a>
                        </div>
                        <a href="<?=base_url('hospitals');?>" class="partner-list-link" style="color: #0284c7;">
                            <span>Hospital List</span> <i class="fas fa-arrow-right" style="font-size: 10px;" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                <div class="modern-partner-card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 230px;">
                    <div>
                        <div class="modern-partner-icon" style="color: #00a896;"><i class="fas fa-user-md"></i></div>
                        <!-- Fix Issue 17: Semantic H3 tag for partner title -->
                        <h3 class="modern-partner-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">Specialist Doctors</h3>
                        <p style="font-size: 13px; color: #64748B; margin: 0 0 14px;">Experienced consultants and surgeons across all major clinical fields.</p>
                    </div>
                    <div class="partner-card-footer-modern">
                        <div class="partner-card-actions">
                            <a href="<?=base_url('doctor-login');?>" class="btn-partner-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> <span>Login</span></a>
                            <a href="<?=base_url('doctor-signup');?>" class="btn-partner-join"><i class="fas fa-plus" aria-hidden="true"></i> <span>Join</span></a>
                        </div>
                        <a href="<?=base_url('doctors');?>" class="partner-list-link" style="color: #00a896;">
                            <span>Doctor List</span> <i class="fas fa-arrow-right" style="font-size: 10px;" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                <div class="modern-partner-card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 230px;">
                    <div>
                        <div class="modern-partner-icon" style="color: #7c3aed;"><i class="fas fa-flask"></i></div>
                        <!-- Fix Issue 17: Semantic H3 tag for partner title -->
                        <h3 class="modern-partner-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">Pathology Labs</h3>
                        <p style="font-size: 13px; color: #64748B; margin: 0 0 14px;">Accredited diagnostic centers providing rapid, certified doorstep testing.</p>
                    </div>
                    <div class="partner-card-footer-modern">
                        <div class="partner-card-actions">
                            <a href="<?=base_url('pathlab-login');?>" class="btn-partner-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> <span>Login</span></a>
                            <a href="<?=base_url('pathlab-signup');?>" class="btn-partner-join btn-partner-lab"><i class="fas fa-plus" aria-hidden="true"></i> <span>Join</span></a>
                        </div>
                        <a href="<?=base_url('mytest');?>" class="partner-list-link" style="color: #7c3aed;">
                            <span>Diagnostic Labs</span> <i class="fas fa-arrow-right" style="font-size: 10px;" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                <div class="modern-partner-card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 230px;">
                    <div>
                        <div class="modern-partner-icon" style="color: #10b981;"><i class="fas fa-pills"></i></div>
                        <!-- Fix Issue 17: Semantic H3 tag for partner title -->
                        <h3 class="modern-partner-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">Pharmacy Services</h3>
                        <p style="font-size: 13px; color: #64748B; margin: 0 0 14px;">Fast, reliable doorstep delivery of genuine prescription medicines.</p>
                    </div>
                    <div class="partner-card-footer-modern">
                        <div class="partner-card-actions">
                            <a href="<?=base_url('medical-login');?>" class="btn-partner-login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> <span>Login</span></a>
                            <a href="<?=base_url('medical-signup');?>" class="btn-partner-join btn-partner-pharmacy"><i class="fas fa-plus" aria-hidden="true"></i> <span>Join</span></a>
                        </div>
                        <a href="<?=base_url('medical');?>" class="partner-list-link" style="color: #10b981;">
                            <span>Pharmacy List</span> <i class="fas fa-arrow-right" style="font-size: 10px;" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php $this->load->view('modals/medicine_order_modals.php'); ?>
<?php $this->load->view('includes/footer.php'); ?>

<!-- Swiper 10 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Interactive Sliders & UI Helpers Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper Sliders (Diagnostic Tests, Testimonials, Health News)
    if (typeof Swiper !== 'undefined') {
        var testsSwiper = new Swiper(".testsSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            grabCursor: true,
            navigation: {
                nextEl: ".testsNextBtn, .testsSwiper .swiper-button-next",
                prevEl: ".testsPrevBtn, .testsSwiper .swiper-button-prev",
            },
            pagination: {
                el: ".testsSwiper .swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                600: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                }
            }
        });
    }
    var track = document.getElementById('specialistsTrack');
    var prevBtn = document.getElementById('specPrevBtn');
    var nextBtn = document.getElementById('specNextBtn');
    
    if (track && prevBtn && nextBtn) {
        var scrollAmount = 290;
        
        prevBtn.addEventListener('click', function() {
            track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });
        
        nextBtn.addEventListener('click', function() {
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }

    // Toggle Specialties Grid (View All Specializations / Show Less)
    var toggleSpecBtn = document.getElementById('toggleSpecialties');
    if (toggleSpecBtn) {
        var isSpecialtiesExpanded = false;
        toggleSpecBtn.addEventListener('click', function(e) {
            e.preventDefault();
            isSpecialtiesExpanded = !isSpecialtiesExpanded;
            var hiddenItems = document.querySelectorAll('.specialty-card-toggle');
            hiddenItems.forEach(function(item) {
                if (isSpecialtiesExpanded) {
                    item.classList.remove('specialty-hidden-item');
                } else {
                    item.classList.add('specialty-hidden-item');
                }
            });

            if (isSpecialtiesExpanded) {
                this.innerHTML = '<span>Show Less</span> <i class="fas fa-arrow-up" style="margin-left: 6px;"></i>';
            } else {
                this.innerHTML = '<span>View All Specializations</span> <i class="fas fa-arrow-right" style="margin-left: 6px;"></i>';
            }
        });
    }
});

function switchSearchService(type, btn) {
    $('.search-tab-pill, .tab-btn-modern').removeClass('active');
    $(btn).addClass('active');
    $(btn).closest('li').addClass('active').siblings().removeClass('active');
    if (type === 'doctors') {
        $('#mainHomeSearchForm').attr('action', '<?=base_url("search");?>');
        $('#hint').attr('placeholder', 'e.g. Cardiologist, Fever, Apollo...');
    }
}

function scrollToSection(id) {
    var el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
}

function triggerEmergencyCall() {
    if (confirm('Initiate 24/7 UPCHAR Emergency Ambulance Helpline (108 / +91 8448440603)?')) {
        window.location.href = 'tel:108';
    }
}
</script>