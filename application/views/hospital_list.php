<?php include ('includes/header.php'); ?>

<style>
/* Hospital View Mode & Header Bar */
.results-header-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  background: #FFFFFF;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  padding: 14px 18px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
  flex-wrap: wrap;
  gap: 12px;
}

.results-header-title {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  background: #F8FAFC;
  border: 1px solid #E2E8F0;
  border-radius: 30px;
  padding: 6px 16px;
  white-space: nowrap;
  max-width: 100%;
}

.results-count-text {
  font-size: 15px;
  font-weight: 700;
  color: #0F172A;
  margin: 0;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
}

.results-count-badge {
  background: #E6FFFA;
  color: #00A896;
  font-size: 12px;
  font-weight: 700;
  padding: 2px 10px;
  border-radius: 20px;
  border: 1px solid #99F6E4;
  white-space: nowrap;
}

.results-divider {
  color: #CBD5E1;
  font-size: 14px;
  font-weight: 300;
  display: inline-block;
  user-select: none;
}

.results-count-sub {
  font-size: 13px;
  color: #64748B;
  margin: 0;
  display: inline-flex;
  align-items: center;
  white-space: nowrap;
}

.results-count-sub strong {
  color: #1E293B;
  font-weight: 600;
}

/* Scrollable Sub-Window Container for Viewport Fit */
.hospitals-subwindow-scroll {
  height: 540px;
  max-height: calc(100vh - 270px);
  min-height: 440px;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 10px 12px 10px 6px;
  background: #f8fafc;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.03);
  margin-bottom: 24px;
  scroll-behavior: smooth;
  scrollbar-width: thin;
  scrollbar-color: #00A896 #edf2f7;
  -webkit-overflow-scrolling: touch;
}
.hospitals-subwindow-scroll::-webkit-scrollbar {
  width: 7px;
}
.hospitals-subwindow-scroll::-webkit-scrollbar-track {
  background: #edf2f7;
  border-radius: 10px;
}
.hospitals-subwindow-scroll::-webkit-scrollbar-thumb {
  background: #00A896;
  border-radius: 10px;
}
.hospitals-subwindow-scroll::-webkit-scrollbar-thumb:hover {
  background: #043D5B;
}

.view-mode-toggle {
  display: inline-flex;
  align-items: center;
  background: #F1F5F9;
  border-radius: 8px;
  padding: 3px;
  border: 1px solid #E2E8F0;
}

.view-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: none;
  background: transparent;
  color: #64748B;
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  line-height: 1;
}

.view-btn:hover {
  color: #0F172A;
}

.view-btn.active {
  background: #FFFFFF;
  color: #00A896;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

/* Hospitals Container */
.hospitals-list-container {
  width: 100%;
  margin: 0 auto;
  transition: all 0.3s ease;
}

.hospitals-list-container.view-mode-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.hospitals-list-container.view-mode-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
  gap: 20px;
}

/* Base Hospital Card */
.hospital-card {
  background-color: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 22px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  display: flex;
  flex-direction: row;
  align-items: stretch;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 0 !important;
}

.hospital-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px -4px rgba(0, 0, 0, 0.08);
  border-color: #cbd5e1;
}

.hospital-card .doc-col-left {
  flex: 0 0 110px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.hospital-card .doc-col-mid {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
  border-right: none;
  padding-right: 12px;
  text-align: left;
}

.hospital-card .doc-col-right {
  flex: 0 0 210px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  justify-content: center;
  align-items: stretch;
  text-align: center;
  background: #F8FAFC;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  padding: 14px 16px;
}

/* Grid View Overrides for Hospital Cards */
.hospitals-list-container.view-mode-grid .hospital-card {
  flex-direction: column;
  padding: 20px;
  gap: 16px;
  text-align: center;
}

.hospitals-list-container.view-mode-grid .doc-col-left {
  width: 100%;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.hospitals-list-container.view-mode-grid .trust-badges {
  flex-direction: row;
  justify-content: center;
  gap: 8px;
  width: auto;
}

.hospitals-list-container.view-mode-grid .doc-col-mid {
  border-right: none;
  border-bottom: 1px dashed #e5e7eb;
  padding-right: 0;
  padding-bottom: 14px;
  text-align: center;
}

.hospitals-list-container.view-mode-grid .doc-header {
  justify-content: center;
  text-align: center;
}

.hospitals-list-container.view-mode-grid .doc-name {
  text-align: center;
}

.hospitals-list-container.view-mode-grid .doc-spec-tags {
  justify-content: center;
}

.hospitals-list-container.view-mode-grid .doc-meta-info {
  align-items: center;
  justify-content: center;
  text-align: center;
}

.hospitals-list-container.view-mode-grid .doc-meta-info .meta-item {
  justify-content: center;
}

.hospitals-list-container.view-mode-grid .doc-col-right {
  width: 100%;
}

.hospitals-list-container.view-mode-grid .action-buttons {
  width: 100%;
  flex-direction: column;
}

.hospitals-list-container.view-mode-grid .action-buttons .btn {
  width: 100%;
  justify-content: center;
}

/* Pagination Toolbar */
.pagination-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 14px;
  margin-top: 28px;
  padding: 16px 20px;
  background: #FFFFFF;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}

.pagination-info {
  font-size: 13.5px;
  color: #64748B;
  margin: 0;
}

.pagination-controls {
  display: flex;
  align-items: center;
  gap: 6px;
}

.page-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 36px;
  height: 36px;
  padding: 0 10px;
  border-radius: 8px;
  background: #FFFFFF;
  border: 1px solid #E2E8F0;
  color: #334155;
  font-size: 13.5px;
  font-weight: 600;
  text-decoration: none !important;
  transition: all 0.2s ease;
  cursor: pointer;
  user-select: none;
}

.page-btn:hover:not(.disabled):not(.active) {
  background: #F1F5F9;
  border-color: #CBD5E1;
  color: #00A896;
}

.page-btn.active {
  background: #00A896 !important;
  border-color: #00A896 !important;
  color: #FFFFFF !important;
  box-shadow: 0 2px 6px rgba(0, 168, 150, 0.3);
  cursor: default;
}

.page-btn.disabled {
  opacity: 0.45;
  cursor: not-allowed;
  pointer-events: none;
  background: #F8FAFC;
  color: #94A3B8;
}

.per-page-wrapper {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #64748B;
}

.per-page-select {
  border: 1px solid #CBD5E1;
  border-radius: 8px;
  padding: 6px 12px;
  font-size: 13px;
  font-weight: 600;
  color: #1E293B;
  background: #FFFFFF;
  outline: none;
  cursor: pointer;
  transition: border-color 0.2s ease;
}

.per-page-select:focus {
  border-color: #00A896;
}

@media (max-width: 768px) {
  .results-header-bar, .pagination-toolbar {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  .pagination-controls {
    width: 100%;
    justify-content: center;
  }
  .per-page-wrapper {
    width: 100%;
    justify-content: space-between;
  }
  .view-mode-toggle span {
    display: none;
  }
  .view-btn {
    padding: 6px 10px;
  }
  .hospital-card {
    flex-direction: column !important;
    gap: 16px !important;
    padding: 16px !important;
  }
  .hospital-card .doc-col-left {
    flex-direction: row !important;
    justify-content: flex-start !important;
    gap: 16px !important;
    width: 100% !important;
  }
  .hospital-card .doc-col-mid {
    border-right: none !important;
    border-bottom: 1px dashed #e5e7eb !important;
    padding-right: 0 !important;
    padding-bottom: 16px !important;
    width: 100% !important;
  }
  .hospital-card .doc-col-right {
    width: 100% !important;
  }
}

/* Usability & Typography Scale Overrides (Fix Issues 5, 6, 7, 8, 9, 13) */
.doc-name, .doc-name a {
  font-size: 16.5px !important;
  font-weight: 700 !important;
  color: #0F172A !important;
  text-transform: capitalize !important;
}
.doc-name a:hover {
  color: #00A896 !important;
}

.doc-qualifications {
  font-size: 13px !important;
  color: #00A896 !important;
  font-weight: 600 !important;
  display: block;
  margin-top: 3px;
}

.doc-spec-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-top: 6px;
}

.spec-pill {
  font-size: 12px !important;
  font-weight: 600 !important;
  padding: 4px 10px !important;
  border-radius: 6px !important;
  background: #F1F5F9 !important;
  color: #0F766E !important;
  border: 1px solid #E2E8F0 !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 5px !important;
}

.doc-meta-info {
  margin-top: 8px;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.meta-item {
  font-size: 13px !important;
  color: #475569 !important;
  line-height: 1.5 !important;
  margin: 0 !important;
  display: flex;
  align-items: center;
  gap: 8px;
  text-transform: capitalize;
}

.meta-item i {
  color: #00A896 !important;
  width: 16px;
  text-align: center;
  flex-shrink: 0;
}

.trust-badges .badge-rating,
.trust-badges .badge-fee {
  font-size: 12px !important;
}

/* Standardized 48px Search Bar unit (Fix Issue 13) */
.box-form .input-group {
  box-shadow: none !important;
  background: #FFFFFF !important;
  border: 1.5px solid #CBD5E1 !important;
  border-radius: 10px !important;
  overflow: hidden;
  height: 48px !important;
  display: flex !important;
  align-items: center;
  transition: all 0.2s ease;
}

.box-form .input-group:focus-within {
  border-color: #00A896 !important;
  box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15) !important;
}

.box-form .input-group-addon {
  background: transparent !important;
  border: none !important;
  color: #00A896 !important;
  font-size: 16px !important;
  padding: 10px 14px !important;
}

.box-form .form-control {
  border: none !important;
  background: transparent !important;
  box-shadow: none !important;
  font-size: 14px !important;
  font-weight: 500 !important;
  color: #1E293B !important;
  height: 48px !important;
  line-height: 48px !important;
}

#searchBTN {
  height: 48px !important;
  line-height: 48px !important;
  width: 100% !important;
  background: linear-gradient(135deg, #00A896 0%, #028090 100%) !important;
  border: none !important;
  border-radius: 10px !important;
  color: #FFFFFF !important;
  font-size: 14.5px !important;
  font-weight: 700 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 8px !important;
  cursor: pointer !important;
  box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35) !important;
  transition: all 0.2s ease !important;
}

#searchBTN:hover {
  background: #008F80 !important;
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(0, 168, 150, 0.45) !important;
}
</style>

<!-- Floating Search & Filter Bar -->
<div class="container" style="margin-top: 24px;">
    <!-- UPCHAR 3-Way Search Directory Toggle (Doctors / Hospitals / Medicines & Pharmacies) -->
    <div class="search-category-toggle-container" style="display: flex; justify-content: center; margin-bottom: 14px;">
        <div class="search-toggle-group" style="display: inline-flex; background: #08364B; padding: 4px; border-radius: 30px; box-shadow: 0 4px 14px rgba(8, 54, 75, 0.18);">
            <a href="<?=base_url('doctors');?>" class="search-toggle-btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 22px; border-radius: 24px; font-size: 13.5px; font-weight: 700; text-decoration: none; transition: all 0.25s; background: transparent; color: #E2E8F0;">
                <i class="fas fa-user-md"></i> Doctors
            </a>
            <a href="<?=base_url('hospitals');?>" class="search-toggle-btn active" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 22px; border-radius: 24px; font-size: 13.5px; font-weight: 700; text-decoration: none; transition: all 0.25s; background: #00A8FF; color: #FFFFFF; box-shadow: 0 2px 6px rgba(0, 168, 255, 0.4);">
                <i class="fas fa-hospital"></i> Hospitals
            </a>
            <a href="javascript:void(0);" onclick="openMedicineCompareModal()" class="search-toggle-btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 22px; border-radius: 24px; font-size: 13.5px; font-weight: 700; text-decoration: none; transition: all 0.25s; background: transparent; color: #9BC03C;">
                <i class="fas fa-pills" style="color: #9BC03C;"></i> Medicines & Pharmacies <span class="badge" style="background: #E63946; color: #FFF; font-size: 10px; margin-left: 2px;">NEW</span>
            </a>
        </div>
    </div>

    <form action='<?=(strpos(current_url(), 'search') !== false) ? base_url('search') : base_url('hospitals');?>' method='GET'>
        <div class="box-form">
            <div class="row" style="margin: 0;">
                <div class="col-md-3 col-sm-6" style="padding: 6px;">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span>
                        <select class="form-control" name="city" id="searchCitySelect" title="Select Location">
                            <option value="">All Locations / Cities</option>
                            <?php if (!empty($cities)) { foreach($cities as $c){ ?>
                            <option value='<?=$c->id;?>' <?=(isset($_GET['city']) && $_GET['city'] == $c->id) ? 'selected' : '';?>><?=$c->name;?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" style="padding: 6px;">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-search"></i></span>
                        <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" value="<?=@$_GET['keyword'];?>" placeholder="Search Hospitals, Treatments, Facilities..." autocomplete="off">
                    </div>       
                </div>
                <div class="col-md-3 col-sm-8" style="padding: 6px;">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-user-md"></i></span>
                        <select class="form-control" name="spl" title="Select Specialization">
                            <option value="">All Specializations</option>
                            <?php if (!empty($specialization)) { foreach($specialization as $s){ ?>
                            <option value='<?=$s->id;?>' <?=(isset($_GET['spl']) && $_GET['spl'] == $s->id) ? 'selected' : '';?>><?=$s->name;?></option>
                            <?php } } ?>                   
                        </select>
                    </div> 
                </div>
                <div class="col-md-2 col-sm-4" style="padding: 6px;">
                    <button type="submit" id="searchBTN" title="Search Hospitals">
                        <i class="fas fa-search" aria-hidden="true"></i> <span>Search</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Hospitals Directory Listing -->
<section class="section-wrapper" style="padding: 10px 0 60px;">
    <div class="container">
        <div class="row">
            <!-- Sidebar: Quick Assistance & Filters -->
            <div class="col-md-3 col-sm-4">
                <div class="modern-partner-card" style="text-align: left; padding: 16px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <div class="modern-partner-icon" style="margin: 0; width: 36px; height: 36px; font-size: 16px; border-radius: 8px;">
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <div>
                            <h5 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">24/7 Emergency</h5>
                            <span style="font-size: 12px; color: #64748B;">Immediate Care Support</span>
                        </div>
                    </div>
                    <p style="font-size: 13px; color: #475569; margin-bottom: 12px; line-height: 1.4;">
                        Need urgent medical care or emergency bed allocation? Call our dedicated patient assistance desk.
                    </p>
                    <a href="tel:8448440603" class="btn btn-primary-cta" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px; padding: 8px 14px; font-size: 13px;">
                        <i class="fas fa-phone-alt"></i> 844-844-0603
                    </a>
                </div>

                <div class="modern-partner-card" style="text-align: left; padding: 16px;">
                    <h5 style="margin: 0 0 10px; font-size: 14px; font-weight: 700; color: #0F172A;">
                        <i class="fas fa-shield-alt" style="color: #00A896; margin-right: 6px;"></i> Upchar Assurance
                    </h5>
                    <ul style="padding-left: 0; list-style: none; margin: 0; font-size: 12.5px; color: #64748B; display: flex; flex-direction: column; gap: 8px;">
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #16A34A;"></i> 100% NABH/Govt Accredited
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #16A34A;"></i> Direct Hospital Admission Desk
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #16A34A;"></i> Cashless Insurance Assistance
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #16A34A;"></i> Zero Booking Charges
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Listing: Hospital Cards -->
            <div class="col-md-9 col-sm-8">
                <?php 
                $curr_city = isset($_GET['city']) ? $_GET['city'] : '';
                $curr_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                $curr_spl = isset($_GET['spl']) ? $_GET['spl'] : '';
                $curr_per_page = isset($per_page_param) ? $per_page_param : '10';
                $c_page = isset($current_page) ? $current_page : 1;
                $t_pages = isset($total_pages) ? $total_pages : 1;
                $t_hosp = isset($total_hospitals) ? $total_hospitals : (isset($hospital) ? count($hospital) : 0);
                $p_size = isset($per_page) ? $per_page : 10;

                if (!function_exists('buildHospPageUrl')) {
                    function buildHospPageUrl($p, $city, $kw, $spl, $pp) {
                        $params = array();
                        if (!empty($city)) $params['city'] = $city;
                        if (!empty($kw)) $params['keyword'] = $kw;
                        if (!empty($spl)) $params['spl'] = $spl;
                        if (!empty($pp) && $pp != '10') $params['per_page'] = $pp;
                        if ($p > 1) $params['page'] = $p;
                        $base = (strpos(current_url(), 'search') !== false) ? base_url('search') : base_url('hospitals');
                        $qs = http_build_query($params);
                        return $base . ($qs ? ('?' . $qs) : '');
                    }
                }
                ?>

                <!-- Results Header Bar with View Mode Switcher (Fix Issue 10: Semantic H1 heading) -->
                <div class="results-header-bar">
                    <div class="results-header-title">
                        <h1 class="results-count-text" style="font-size: 16px; font-weight: 700; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-hospital-alt" style="color: #00A896; margin-right: 4px;"></i> Verified Hospitals &amp; Clinics
                            <span class="results-count-badge"><?=$t_hosp;?> Available</span>
                        </h1>
                        <?php if ($t_hosp > 0) { ?>
                        <span class="results-divider">|</span>
                        <span class="results-count-sub">Showing <strong><?=($c_page - 1) * $p_size + 1;?> - <?=min($c_page * $p_size, $t_hosp);?></strong> of <strong><?=$t_hosp;?></strong> facilities (Page <?=$c_page;?> of <?=$t_pages;?>)</span>
                        <?php } ?>
                    </div>
                    <?php if ($t_hosp > 0) { ?>
                    <div class="results-header-actions" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <!-- List / Grid View Switcher -->
                        <div class="view-mode-toggle" id="hospViewModeToggle">
                            <button type="button" class="view-btn active" data-mode="list" title="Detailed Horizontal List View">
                                <i class="fas fa-bars"></i> <span>List View</span>
                            </button>
                            <button type="button" class="view-btn" data-mode="grid" title="Compact Multi-Column Grid View">
                                <i class="fas fa-th-large"></i> <span>Grid View</span>
                            </button>
                        </div>

                        <div class="per-page-wrapper">
                            <label for="perPageTopSelect" style="margin: 0; font-weight: 500; color: #64748B;">Per Page:</label>
                            <select id="perPageTopSelect" class="per-page-select" onchange="location = this.value;">
                                <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '10');?>" <?=($curr_per_page == '10') ? 'selected' : '';?>>10</option>
                                <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '20');?>" <?=($curr_per_page == '20') ? 'selected' : '';?>>20</option>
                                <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '50');?>" <?=($curr_per_page == '50') ? 'selected' : '';?>>50</option>
                                <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, 'all');?>" <?=($curr_per_page == 'all') ? 'selected' : '';?>>All</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- Scrollable Sub-Window Container to Fit Page in Window Viewport -->
                <div class="hospitals-subwindow-scroll" id="hospitalsSubwindow">
                    <!-- Hospitals Cards Container -->
                    <div class="hospitals-list-container view-mode-list" id="hospitalsListContainer">
                <?php if (!empty($hospital)) { foreach($hospital as $institution) { 
                    $hImg = ($institution->drimage && file_exists('admin1947/public/assets/upload/'.$institution->drimage)) 
                            ? admin_url().'public/assets/upload/'.$institution->drimage 
                            : admin_url().'public/assets/upload/dummyhospital.jpg';
                    $cityText = ($institution->city) ? getCityName($institution->city) : 'Varanasi';
                    $addressText = (!empty($institution->address)) ? $institution->address : $cityText.', Uttar Pradesh, India';
                    $hospPhone = (!empty($institution->mobile)) ? $institution->mobile : '8448440603';
                ?>
                <!-- Modern Hospital Card -->
                <div class="hospital-card">
                    <!-- Column 1: Hospital Thumbnail & Trust Badge -->
                    <div class="doc-col-left">
                        <div class="avatar-wrapper">
                            <img src="<?=$hImg;?>" alt="<?=$institution->name;?>" class="doc-avatar" style="border-radius: 12px; width: 90px; height: 90px;" loading="lazy">
                        </div>
                        <div class="trust-badges">
                            <span class="badge-rating"><i class="fas fa-thumbs-up"></i> 99%</span>
                            <span class="badge-fee">₹500 Entry</span>
                        </div>
                    </div>

                    <!-- Column 2: Details & Services (Fix Issues 8 & 9: Cased typography) -->
                    <div class="doc-col-mid">
                        <div class="doc-header">
                            <h3 class="doc-name" style="text-transform: capitalize;">
                                <a href="<?=base_url();?>hospital/<?=$institution->id;?>"><?=htmlspecialchars(ucwords(strtolower($institution->name)));?></a>
                            </h3>
                            <span class="doc-qualifications" style="color: #00A896; font-weight: 600;">
                                <i class="fas fa-hospital-alt"></i> Multi-Specialty Hospital &amp; Research Center
                            </span>
                        </div>

                        <div class="doc-spec-tags">
                            <span class="spec-pill"><i class="fas fa-ambulance" style="color: #E63946;"></i> 24/7 Ambulance</span>
                            <span class="spec-pill"><i class="fas fa-user-md" style="color: #00A896;"></i> Specialist Doctors</span>
                            <span class="spec-pill"><i class="fas fa-pills" style="color: #10B981;"></i> 24/7 Pharmacy</span>
                            <span class="spec-pill"><i class="fas fa-flask" style="color: #7C3AED;"></i> Pathology Labs</span>
                            <span class="spec-pill"><i class="fas fa-procedures" style="color: #0284C7;"></i> Inpatient / ICU</span>
                        </div>

                        <div class="doc-meta-info">
                            <p class="meta-item">
                                <i class="fas fa-clock"></i> <strong>Open 24 Hours</strong> (Mon - Sun)
                            </p>
                            <p class="meta-item" style="text-transform: capitalize;">
                                <i class="fas fa-map-marker-alt"></i> <?=htmlspecialchars(ucwords(strtolower($addressText)));?>
                            </p>
                        </div>
                    </div>

                    <!-- Column 3: Actions & Phone -->
                    <div class="doc-col-right">
                        <div class="wait-time-badge" style="background: #F0FDF4; color: #16A34A; border-color: #DCFCE7;">
                            <i class="fas fa-check-circle"></i> Verified Network Partner
                        </div>
                        <div class="action-buttons">
                            <a href="<?=base_url();?>hospital/<?=$institution->id;?>" class="btn btn-outline" title="View Full Hospital Profile">
                                View Profile
                            </a>
                            <a href="tel:<?=$hospPhone;?>" class="btn btn-primary-cta" title="Call Hospital Helpline">
                                <i class="fas fa-phone-alt"></i> Call Hospital
                            </a>
                        </div>
                    </div>
                </div>
                <?php } } else { ?>
                <div class="doctor-card text-center" style="display: block; padding: 50px 20px; width: 100%;">
                    <i class="fas fa-hospital-alt" style="font-size: 40px; color: #CBD5E1; margin-bottom: 16px;"></i>
                    <h4 style="color: #64748B; margin-bottom: 8px;">No hospitals found matching your criteria.</h4>
                    <p style="color: #94A3B8; margin-bottom: 20px;">Try adjusting your location or specialization filter above.</p>
                    <a href="<?=base_url('hospitals');?>" class="btn btn-secondary" style="display: inline-block; width: auto; padding: 8px 24px;">View All Hospitals</a>
                </div>
                <?php } ?>
                </div>
                </div>

                <?php if ($t_hosp > 0) { ?>
                <!-- Pagination Toolbar -->
                <div class="pagination-toolbar">
                    <div class="pagination-info">
                        Showing <strong><?=($c_page - 1) * $p_size + 1;?></strong> - <strong><?=min($c_page * $p_size, $t_hosp);?></strong> of <strong><?=$t_hosp;?></strong> verified facilities
                    </div>

                    <?php if ($t_pages > 1) { ?>
                    <div class="pagination-controls">
                        <!-- Previous Page -->
                        <?php if ($c_page > 1): ?>
                        <a href="<?=buildHospPageUrl($c_page - 1, $curr_city, $curr_keyword, $curr_spl, $curr_per_page);?>" class="page-btn" title="Previous Page">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <?php else: ?>
                        <span class="page-btn disabled" title="Previous Page" aria-disabled="true">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php 
                        $start_p = max(1, $c_page - 2);
                        $end_p = min($t_pages, $c_page + 2);
                        if ($start_p > 1) {
                            echo '<a href="'.buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, $curr_per_page).'" class="page-btn">1</a>';
                            if ($start_p > 2) echo '<span class="page-btn disabled">...</span>';
                        }
                        for ($p = $start_p; $p <= $end_p; $p++) {
                            if ($p == $c_page) {
                                echo '<span class="page-btn active">'.$p.'</span>';
                            } else {
                                echo '<a href="'.buildHospPageUrl($p, $curr_city, $curr_keyword, $curr_spl, $curr_per_page).'" class="page-btn">'.$p.'</a>';
                            }
                        }
                        if ($end_p < $t_pages) {
                            if ($end_p < $t_pages - 1) echo '<span class="page-btn disabled">...</span>';
                            echo '<a href="'.buildHospPageUrl($t_pages, $curr_city, $curr_keyword, $curr_spl, $curr_per_page).'" class="page-btn">'.$t_pages.'</a>';
                        }
                        ?>

                        <!-- Next Page -->
                        <?php if ($c_page < $t_pages): ?>
                        <a href="<?=buildHospPageUrl($c_page + 1, $curr_city, $curr_keyword, $curr_spl, $curr_per_page);?>" class="page-btn" title="Next Page">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <?php else: ?>
                        <span class="page-btn disabled" title="Next Page" aria-disabled="true">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php } ?>

                    <div class="per-page-wrapper">
                        <label for="perPageBottomSelect" style="margin: 0; font-weight: 500; color: #64748B;">Per Page:</label>
                        <select id="perPageBottomSelect" class="per-page-select" onchange="location = this.value;">
                            <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '10');?>" <?=($curr_per_page == '10') ? 'selected' : '';?>>10</option>
                            <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '20');?>" <?=($curr_per_page == '20') ? 'selected' : '';?>>20</option>
                            <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, '50');?>" <?=($curr_per_page == '50') ? 'selected' : '';?>>50</option>
                            <option value="<?=buildHospPageUrl(1, $curr_city, $curr_keyword, $curr_spl, 'all');?>" <?=($curr_per_page == 'all') ? 'selected' : '';?>>All</option>
                        </select>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var savedMode = localStorage.getItem('upchar_hospital_view_mode') || 'list';
    var container = document.getElementById('hospitalsListContainer');
    var buttons = document.querySelectorAll('#hospViewModeToggle .view-btn');

    function setHospViewMode(mode) {
        if (!container) return;
        if (mode === 'grid') {
            container.classList.remove('view-mode-list');
            container.classList.add('view-mode-grid');
            buttons.forEach(function(btn) {
                if (btn.getAttribute('data-mode') === 'grid') btn.classList.add('active');
                else btn.classList.remove('active');
            });
            localStorage.setItem('upchar_hospital_view_mode', 'grid');
        } else {
            container.classList.remove('view-mode-grid');
            container.classList.add('view-mode-list');
            buttons.forEach(function(btn) {
                if (btn.getAttribute('data-mode') === 'list') btn.classList.add('active');
                else btn.classList.remove('active');
            });
            localStorage.setItem('upchar_hospital_view_mode', 'list');
        }
    }

    setHospViewMode(savedMode);

    buttons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var mode = this.getAttribute('data-mode');
            setHospViewMode(mode);
        });
    });
});
</script>

<?php include (APPPATH . 'views/modals/medicine_order_modals.php'); ?>
<?php include ('includes/footer.php'); ?>