<?php include ('includes/header.php'); ?>

<!-- Compact Pathology & Diagnostic Centers Design -->
<style>
:root {
    --primary-color: #00a896;
    --primary-hover: #028090;
    --bg-color: #f8fafc;
    --card-bg: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --radius: 10px;
}

body {
    background-color: var(--bg-color);
    color: var(--text-main);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Compact Search Bar Header */
.hero-section {
    background: linear-gradient(135deg, #028090 0%, #00a896 100%);
    color: white;
    padding: 28px 16px 32px 16px;
    text-align: center;
}

.hero-section h1 {
    font-size: 1.5rem;
    margin-bottom: 4px;
    font-weight: 800;
    color: #ffffff;
}

.hero-section p {
    font-size: 0.9rem;
    opacity: 0.92;
    margin-bottom: 18px;
    color: #f0fdfa;
}

.search-container-compact {
    max-width: 780px;
    margin: 0 auto;
    display: flex;
    gap: 8px;
    background: white;
    padding: 6px 8px;
    border-radius: 30px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    align-items: center;
}

.search-input-compact {
    flex: 1;
    border: none;
    padding: 8px 14px;
    font-size: 0.88rem;
    outline: none;
    color: #1e293b;
    background: transparent;
}

.search-select-compact {
    border: none;
    border-right: 1px solid #e2e8f0;
    padding: 8px 14px;
    font-size: 0.85rem;
    outline: none;
    color: #334155;
    background: transparent;
    max-width: 180px;
}

.search-btn-compact {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 9px 22px;
    border-radius: 24px;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    transition: background 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.search-btn-compact:hover {
    background-color: var(--primary-hover);
    color: white;
}

/* Tab Navigation */
.tab-pills-row {
    display: flex;
    gap: 10px;
    margin: 20px 0 16px 0;
    overflow-x: auto;
    padding-bottom: 6px;
}

.tab-pill-btn {
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.84rem;
    color: #475569;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.tab-pill-btn:hover {
    color: var(--primary-color);
    border-color: var(--primary-color);
    background: #f0fdfa;
}

.tab-pill-btn.active {
    background: var(--primary-color);
    color: #ffffff !important;
    border-color: var(--primary-color);
    box-shadow: 0 3px 10px rgba(0, 168, 150, 0.25);
}

.tab-pill-btn .count-badge {
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
    padding: 1px 7px;
    border-radius: 10px;
    font-size: 0.72rem;
}

.tab-pill-btn.active .count-badge {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

/* Compact Container & Grid */
.compact-main-container {
    max-width: 1180px;
    margin: 20px auto 40px auto;
    padding: 0 16px;
}

.section-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

/* Grid Layout with smaller card sizes */
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 18px;
}

/* Compact Reframed Card */
.compact-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.compact-card:hover {
    border-color: var(--primary-color);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.12);
    transform: translateY(-2px);
}

.card-header-compact {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
}

.center-info h3 {
    font-size: 1rem;
    color: var(--text-main);
    font-weight: 700;
    margin: 0 0 3px 0;
    line-height: 1.35;
}

.center-info span {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 5px;
}

.badge-tag-custom {
    background-color: #e6fffa;
    color: #047857;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 12px;
    white-space: nowrap;
    border: 1px solid #ccfbf1;
}

.test-list-compact {
    list-style: none;
    margin: 10px 0;
    border-top: 1px dotted var(--border-color);
    border-bottom: 1px dotted var(--border-color);
    padding: 8px 0;
}

.test-item-compact {
    font-size: 0.82rem;
    color: var(--text-muted);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
}

.test-item-compact:last-child {
    margin-bottom: 0;
}

.test-item-compact i {
    color: var(--primary-color);
    font-size: 0.75rem;
}

.card-footer-compact {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
    padding-top: 6px;
}

.price-tag-compact {
    display: flex;
    flex-direction: column;
}

.price-compact {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-main);
}

.cashback-compact {
    font-size: 0.72rem;
    color: #059669;
    font-weight: 600;
}

.action-btn-compact {
    background-color: var(--primary-color);
    color: white !important;
    text-decoration: none !important;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    transition: background 0.2s;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.action-btn-compact:hover {
    background-color: var(--primary-hover);
    box-shadow: 0 3px 10px rgba(0, 168, 150, 0.3);
}

@media (max-width: 640px) {
    .search-container-compact {
        flex-direction: column;
        border-radius: 14px;
        padding: 10px;
    }
    .search-select-compact {
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
        max-width: 100%;
        width: 100%;
    }
    .search-input-compact, .search-btn-compact {
        width: 100%;
        border-radius: 8px;
    }
}
</style>

<!-- Header Section -->
<div class="hero-section">
    <h1>Pathology Centers &amp; Diagnostic Packages</h1>
    <p>Book verified lab tests near you with doorstep sample collection</p>
    
    <form class="search-container-compact" action="<?=base_url('pathlabview');?>" method="GET">
        <input type="hidden" name="tab" value="<?=html_escape($active_tab);?>">
        
        <select name="city" class="search-select-compact">
            <option value="">All Cities</option>
            <?php if (!empty($cities)): ?>
                <?php foreach ($cities as $c): ?>
                    <option value="<?=html_escape($c->id);?>" <?=($selected_city == $c->id) ? 'selected' : '';?>>
                        <?=html_escape($c->name);?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <input type="text" name="keyword" class="search-input-compact" placeholder="Search Pathology or Test (CBC, Thyroid, Lipid...)" value="<?=html_escape($keyword);?>">
        
        <button type="submit" class="search-btn-compact">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>

<!-- Compact Cards Section -->
<div class="compact-main-container">
    
    <!-- Tab Filter Switcher -->
    <div class="tab-pills-row">
        <a href="<?=base_url('pathlabview?tab=labs' . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-pill-btn <?=($active_tab == 'labs') ? 'active' : '';?>">
            <i class="fas fa-hospital-alt"></i> Pathology Centers
            <span class="count-badge"><?=$total_labs_count;?></span>
        </a>
        <a href="<?=base_url('pathlabview?tab=tests' . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-pill-btn <?=($active_tab == 'tests') ? 'active' : '';?>">
            <i class="fas fa-flask"></i> Diagnostic Tests
            <span class="count-badge"><?=$total_tests_count;?></span>
        </a>
        <a href="<?=base_url('pathlabview?tab=packages' . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-pill-btn <?=($active_tab == 'packages') ? 'active' : '';?>">
            <i class="fas fa-heartbeat"></i> Health Packages
            <span class="count-badge"><?=$total_packages_count;?></span>
        </a>
    </div>

    <!-- Section Header -->
    <div class="section-header-row">
        <h2 class="section-title">
            <?php if ($active_tab == 'labs'): ?>
                Available Diagnostic Laboratories (<?=$total_labs_count;?>)
            <?php elseif ($active_tab == 'tests'): ?>
                Diagnostic Tests Catalog (<?=$total_tests_count;?>)
            <?php else: ?>
                Preventive Health Checkup Packages (<?=$total_packages_count;?>)
            <?php endif; ?>
        </h2>

        <?php if (!empty($selected_city) || !empty($keyword)): ?>
            <a href="<?=base_url('pathlabview?tab='.$active_tab);?>" style="font-size: 0.8rem; color: #0284c7; font-weight: 700; text-decoration: underline;">
                &times; Clear Filters
            </a>
        <?php endif; ?>
    </div>

    <!-- TAB 1: PATHOLOGY CENTERS -->
    <?php if ($active_tab == 'labs'): ?>
        <div class="grid-container">
            <?php if (!empty($pathologies)): ?>
                <?php foreach ($pathologies as $lab): ?>
                    <div class="compact-card">
                        <div>
                            <div class="card-header-compact">
                                <div class="center-info">
                                    <h3><?=html_escape($lab->name);?></h3>
                                    <span>
                                        <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i> 
                                        <?=html_escape($lab->location ?: ($lab->city_name ?: 'Verified Partner'));?>, 
                                        <strong>(<?=html_escape($lab->city_name ?: 'Varanasi');?>)</strong>
                                    </span>
                                </div>
                                <span class="badge-tag-custom">NABL / Verified</span>
                            </div>

                            <ul class="test-list-compact">
                                <?php if (!empty($lab->tests)): ?>
                                    <?php foreach (array_slice($lab->tests, 0, 3) as $t): ?>
                                        <li class="test-item-compact">
                                            <span><i class="fas fa-check"></i> <?=html_escape($t->short_name ?: $t->test_name);?></span>
                                            <strong style="color: #00a896; font-size: 0.78rem;">₹<?=number_format($t->amount);?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="test-item-compact">
                                        <span><i class="fas fa-check"></i> Complete Hemogram (CBC)</span>
                                    </li>
                                    <li class="test-item-compact">
                                        <span><i class="fas fa-check"></i> Liver &amp; Kidney Function Tests</span>
                                    </li>
                                    <li class="test-item-compact">
                                        <span><i class="fas fa-check"></i> Lipid Profile &amp; Blood Sugar</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="card-footer-compact">
                            <div class="price-tag-compact">
                                <span class="price-compact">Starts @ ₹<?=number_format($lab->starting_price);?></span>
                                <span class="cashback-compact"><i class="fas fa-home"></i> Free Home Pickup</span>
                            </div>
                            <button type="button" class="action-btn-compact btn-open-booking-modal"
                                data-lab-id="<?=$lab->id;?>"
                                data-lab-name="<?=html_escape($lab->name);?>"
                                data-test-id="<?=(!empty($lab->tests) ? $lab->tests[0]->test_id : 101);?>"
                                data-test-name="<?=(!empty($lab->tests) ? html_escape($lab->tests[0]->test_name) : 'Diagnostic Blood Checkup');?>"
                                data-amount="<?=(!empty($lab->tests) ? $lab->tests[0]->amount : 350);?>">
                                Book Test
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border-radius: 10px; border: 1px dashed #cbd5e1;">
                    <i class="fas fa-flask" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px;"></i>
                    <h4 style="color: #64748b;">No laboratories found matching criteria.</h4>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- TAB 2: DIAGNOSTIC TESTS CATALOG -->
    <?php if ($active_tab == 'tests'): ?>
        <div class="grid-container">
            <?php if (!empty($all_tests)): ?>
                <?php foreach ($all_tests as $test): ?>
                    <div class="compact-card">
                        <div>
                            <div class="card-header-compact">
                                <div class="center-info">
                                    <h3><?=html_escape($test->test_name);?></h3>
                                    <span><i class="fas fa-hospital"></i> <?=html_escape($test->lab_name);?> (<?=html_escape($test->city_name ?: 'Partner');?>)</span>
                                </div>
                                <span class="badge-tag-custom"><?=html_escape($test->category_name ?: 'Diagnostic');?></span>
                            </div>

                            <ul class="test-list-compact">
                                <li class="test-item-compact">
                                    <span><i class="fas fa-tint" style="color: #ef4444;"></i> Sample Type:</span>
                                    <strong><?=html_escape($test->test_type ?: 'Blood');?></strong>
                                </li>
                                <li class="test-item-compact">
                                    <span><i class="fas fa-clock" style="color: #0284c7;"></i> Report Delivery:</span>
                                    <strong><?=html_escape($test->report_day ?: 'Same Day');?></strong>
                                </li>
                                <li class="test-item-compact">
                                    <span><i class="fas fa-barcode"></i> Test Code:</span>
                                    <strong><?=html_escape($test->code ?: 'UPC-'.$test->test_id);?></strong>
                                </li>
                            </ul>
                        </div>

                        <div class="card-footer-compact">
                            <div class="price-tag-compact">
                                <span class="price-compact">₹<?=number_format($test->amount);?></span>
                                <span class="cashback-compact"><i class="fas fa-home"></i> Free Home Collection</span>
                            </div>
                            <button type="button" class="action-btn-compact btn-open-booking-modal"
                                data-test-id="<?=$test->test_id;?>"
                                data-test-name="<?=html_escape($test->test_name);?>"
                                data-lab-id="<?=$test->path_id;?>"
                                data-lab-name="<?=html_escape($test->lab_name ?: 'Upchar Diagnostic Lab');?>"
                                data-amount="<?=$test->amount;?>">
                                Book Test
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- TAB 3: HEALTH PACKAGES -->
    <?php if ($active_tab == 'packages'): ?>
        <div class="grid-container">
            <?php if (!empty($packages)): ?>
                <?php foreach ($packages as $pkg): ?>
                    <div class="compact-card" style="border: 2px solid #ccfbf1;">
                        <div>
                            <div class="card-header-compact">
                                <div class="center-info">
                                    <h3><?=html_escape($pkg->test_name);?></h3>
                                    <span><i class="fas fa-hospital"></i> <?=html_escape($pkg->lab_name);?></span>
                                </div>
                                <span class="badge-tag-custom" style="background: #fef08a; color: #854d0e;">Featured</span>
                            </div>

                            <ul class="test-list-compact">
                                <li class="test-item-compact"><i class="fas fa-check"></i> Complete Hemogram (CBC)</li>
                                <li class="test-item-compact"><i class="fas fa-check"></i> Liver &amp; Kidney Screening</li>
                                <li class="test-item-compact"><i class="fas fa-check"></i> Lipid &amp; Fasting Glucose</li>
                            </ul>
                        </div>

                        <div class="card-footer-compact">
                            <div class="price-tag-compact">
                                <span class="price-compact">₹<?=number_format($pkg->amount);?></span>
                                <span class="cashback-compact"><i class="fas fa-home"></i> Free Home Collection</span>
                            </div>
                            <button type="button" class="action-btn-compact btn-open-booking-modal"
                                data-test-id="<?=$pkg->test_id;?>"
                                data-test-name="<?=html_escape($pkg->test_name);?>"
                                data-lab-id="<?=$pkg->path_id;?>"
                                data-lab-name="<?=html_escape($pkg->lab_name ?: 'Upchar Diagnostic Hub');?>"
                                data-amount="<?=$pkg->amount;?>">
                                Book Package
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<!-- Booking Modal -->
<div class="modal fade" id="pathologyBookingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
            
            <div class="modal-header" style="background: linear-gradient(135deg, #028090 0%, #00a896 100%); color: #ffffff; padding: 16px 20px; border: none;">
                <h5 class="modal-title" style="font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px; color: #ffffff; margin: 0;">
                    <i class="fas fa-calendar-check"></i> Schedule Diagnostic Test
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9; font-size: 24px; margin-top: -8px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="pathologyBookingForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" id="csrf_token_input">
                <input type="hidden" name="test_id" id="modalTestId">
                <input type="hidden" name="lab_id" id="modalLabId">

                <div class="modal-body" style="padding: 20px;">
                    
                    <div style="background: #f0fdfa; border: 1.5px solid #ccfbf1; border-radius: 8px; padding: 10px 14px; margin-bottom: 16px;">
                        <div id="modalTestName" style="font-size: 14.5px; font-weight: 800; color: #0f172a; margin: 0 0 2px 0;">
                            Complete Blood Count (CBC)
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #475569;">
                            <span><i class="fas fa-hospital"></i> <span id="modalLabName">Upchar Diagnostic Lab</span></span>
                            <span style="font-size: 14px; font-weight: 800; color: #00a896;">₹<span id="modalAmount">350</span></span>
                        </div>
                    </div>

                    <div id="modalBookingAlert"></div>

                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                            Patient Name <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="patient_name" class="form-control" required placeholder="Full Name" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12 form-group" style="margin-bottom: 12px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                Mobile <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" name="patient_mobile" class="form-control" required maxlength="10" placeholder="10-digit mobile" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;">
                        </div>

                        <div class="col-md-6 col-12 form-group" style="margin-bottom: 12px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                Email Address
                            </label>
                            <input type="email" name="patient_email" class="form-control" placeholder="For PDF report" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                            Collection Address
                        </label>
                        <textarea name="patient_address" rows="2" class="form-control" placeholder="Doorstep sample pickup address" style="border-radius: 6px; border: 1px solid #cbd5e1; font-size: 12.5px;"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12 form-group" style="margin-bottom: 6px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                Preferred Date
                            </label>
                            <input type="date" name="booking_date" class="form-control" value="<?=date('Y-m-d', strtotime('+1 day'));?>" min="<?=date('Y-m-d');?>" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;">
                        </div>

                        <div class="col-md-6 col-12 form-group" style="margin-bottom: 6px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                Time Slot
                            </label>
                            <select name="time_slot" class="form-control" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 12.5px;">
                                <option value="Morning (08:30 AM - 11:30 AM)" selected>Morning (08:30 - 11:30 AM)</option>
                                <option value="Early Morning (06:30 AM - 08:30 AM)">Early Morning (06:30 - 08:30 AM)</option>
                                <option value="Afternoon (12:00 PM - 03:00 PM)">Afternoon (12:00 - 03:00 PM)</option>
                                <option value="Evening (04:00 PM - 07:00 PM)">Evening (04:00 - 07:00 PM)</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 0 0 14px 14px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; font-size: 13px;">Cancel</button>
                    <button type="submit" id="btnSubmitBooking" class="action-btn-compact" style="padding: 8px 20px;">
                        <i class="fas fa-check-circle"></i> Confirm Booking
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', '.btn-open-booking-modal', function(e) {
        e.preventDefault();
        var btn = $(this);
        var testId = btn.data('test-id');
        var testName = btn.data('test-name');
        var labId = btn.data('lab-id');
        var labName = btn.data('lab-name');
        var amount = btn.data('amount');

        $('#modalTestId').val(testId);
        $('#modalLabId').val(labId);
        $('#modalTestName').text(testName);
        $('#modalLabName').text(labName);
        $('#modalAmount').text(Number(amount).toLocaleString());
        $('#modalBookingAlert').html('');

        $('#pathologyBookingModal').modal('show');
    });

    $('#pathologyBookingForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = $('#btnSubmitBooking');
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: '<?=site_url("pathology/quick_book");?>',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(res) {
                submitBtn.prop('disabled', false).html('<i class="fas fa-check-circle"></i> Confirm Booking');
                if (res.status === 'success') {
                    var successHtml = '<div class="alert alert-success" style="border-radius: 6px; margin-bottom: 12px; font-size: 13px;">' +
                        '<strong><i class="fas fa-check-circle"></i> ' + res.message + '</strong>' +
                        '<p style="margin: 3px 0 0 0; font-size: 12px;">Sample pickup scheduled for <strong>' + res.booking_date + '</strong> (' + res.time_slot + ').</p>' +
                        '</div>';
                    $('#modalBookingAlert').html(successHtml);
                    form[0].reset();
                    setTimeout(function() {
                        $('#pathologyBookingModal').modal('hide');
                    }, 3500);
                } else {
                    var errHtml = '<div class="alert alert-danger" style="border-radius: 6px; margin-bottom: 12px; font-size: 13px;">' +
                        '<strong><i class="fas fa-exclamation-triangle"></i> Error:</strong> ' + (res.message || 'Unable to complete booking.') +
                        '</div>';
                    $('#modalBookingAlert').html(errHtml);
                }
            },
            error: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-check-circle"></i> Confirm Booking');
                var errHtml = '<div class="alert alert-danger" style="border-radius: 6px; margin-bottom: 12px; font-size: 13px;">' +
                    '<strong><i class="fas fa-exclamation-triangle"></i> Server Error:</strong> Connection error during booking dispatch.' +
                    '</div>';
                $('#modalBookingAlert').html(errHtml);
            }
        });
    });
});
</script>

<?php include ('includes/footer.php'); ?>
