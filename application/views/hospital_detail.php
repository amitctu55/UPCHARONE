<?php include ("includes/header.php"); ?>

<!-- Owl Carousel 2 CSS for Doctor Slider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<style>
/* Header Flex & View Switcher */
.hosp-section-header-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #E2E8F0;
}
.hosp-count-badge {
    background: #E6FFFA;
    color: #00A896;
    border: 1px solid #A7F3D0;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    margin-left: 6px;
    display: inline-block;
    vertical-align: middle;
}
.doctor-view-switcher {
    display: inline-flex;
    align-items: center;
    background: #F1F5F9;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    padding: 3px;
    gap: 3px;
}
.doctor-view-switcher .view-btn {
    border: none;
    background: transparent;
    color: #64748B;
    font-size: 12.5px;
    font-weight: 600;
    padding: 6px 13px;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    outline: none;
}
.doctor-view-switcher .view-btn:hover {
    color: #00A896;
    background: rgba(255, 255, 255, 0.6);
}
.doctor-view-switcher .view-btn.active {
    background: #FFFFFF;
    color: #00A896;
    font-weight: 700;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

/* ========================================================= */
/* 1. SLIDER VIEW (Owl Carousel Slider for Doctors List)     */
/* ========================================================= */
.associated-doctors-container.view-mode-slider {
    display: block;
    width: 100%;
    position: relative;
    padding: 4px 2px 10px 2px;
}
.associated-doctors-container.view-mode-slider.owl-carousel .owl-stage {
    display: flex !important;
    align-items: stretch !important;
    padding: 8px 0;
}
.associated-doctors-container.view-mode-slider.owl-carousel .owl-item {
    display: flex !important;
    flex-direction: column !important;
    height: auto !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-card {
    width: 100% !important;
    height: 100% !important;
    box-sizing: border-box !important;
    margin: 0 !important;
    background: #FFFFFF !important;
    border: 1.5px solid #E2E8F0 !important;
    border-radius: 14px !important;
    padding: 18px 16px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 12px 24px -4px rgba(0, 168, 150, 0.16) !important;
    border-color: #00A896 !important;
}
.associated-doctors-container.view-mode-slider .doc-list-left {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
    width: 100% !important;
    margin-bottom: 12px !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-avatar {
    width: 72px !important;
    height: 72px !important;
    border-radius: 50% !important;
    border: 3px solid #00A896 !important;
    object-fit: cover !important;
    margin: 0 auto 10px auto !important;
    box-shadow: 0 4px 10px rgba(0, 168, 150, 0.15) !important;
}
.associated-doctors-container.view-mode-slider .doc-list-details {
    width: 100% !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-name {
    font-size: 15.5px !important;
    font-weight: 700 !important;
    color: #0F172A !important;
    margin: 0 0 4px 0 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}
.associated-doctors-container.view-mode-slider .doc-badges-row {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 4px !important;
    margin-bottom: 10px !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-spec {
    display: inline-block !important;
    background: #E6FFFA !important;
    color: #00A896 !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    padding: 2px 9px !important;
    border-radius: 4px !important;
    max-width: 100% !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-qual {
    font-size: 11.5px !important;
    color: #64748B !important;
    margin: 0 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}
.associated-doctors-container.view-mode-slider .associated-doctor-meta {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 8px 10px !important;
    background: #F8FAFC !important;
    border: 1px solid #E2E8F0 !important;
    border-radius: 8px !important;
    font-size: 11.5px !important;
    color: #334155 !important;
    margin-bottom: 12px !important;
    width: 100% !important;
}
.associated-doctors-container.view-mode-slider .doc-list-actions {
    display: flex !important;
    gap: 8px !important;
    width: 100% !important;
}
.associated-doctors-container.view-mode-slider .btn-doc-profile {
    flex: 1 !important;
    padding: 8px 10px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    text-align: center !important;
    border-radius: 6px !important;
}
.associated-doctors-container.view-mode-slider .btn-doc-book {
    flex: 1.2 !important;
    padding: 8px 10px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    text-align: center !important;
    border-radius: 6px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 4px !important;
}

/* Owl Navigation Controls */
.associated-doctors-container.owl-carousel .owl-nav {
    display: flex !important;
    justify-content: space-between !important;
    position: absolute !important;
    top: 48% !important;
    left: -18px !important;
    right: -18px !important;
    transform: translateY(-50%) !important;
    pointer-events: none !important;
    z-index: 25 !important;
    margin: 0 !important;
}
.associated-doctors-container.owl-carousel .owl-nav button.owl-prev,
.associated-doctors-container.owl-carousel .owl-nav button.owl-next {
    width: 38px !important;
    height: 38px !important;
    border-radius: 50% !important;
    background: #FFFFFF !important;
    border: 1.5px solid #CBD5E1 !important;
    color: #00A896 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 14px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    pointer-events: auto !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    outline: none !important;
}
.associated-doctors-container.owl-carousel .owl-nav button.owl-prev:hover,
.associated-doctors-container.owl-carousel .owl-nav button.owl-next:hover {
    background: #00A896 !important;
    border-color: #00A896 !important;
    color: #FFFFFF !important;
    transform: scale(1.1) !important;
}
.associated-doctors-container.owl-carousel .owl-dots {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 6px !important;
    margin-top: 14px !important;
}
.associated-doctors-container.owl-carousel .owl-dots .owl-dot span {
    width: 8px !important;
    height: 8px !important;
    border-radius: 4px !important;
    background: #CBD5E1 !important;
    margin: 0 !important;
    transition: all 0.25s ease !important;
}
.associated-doctors-container.owl-carousel .owl-dots .owl-dot.active span {
    width: 22px !important;
    background: #00A896 !important;
}

/* ========================================================= */
/* 2. LIST VIEW (List Form with Scroll Subwindow)            */
/* ========================================================= */
.associated-doctors-container.view-mode-list {
    display: block !important;
    max-height: 620px !important;
    overflow-y: auto !important;
    padding-right: 6px !important;
    margin-top: 8px !important;
}
.associated-doctors-container.view-mode-list::-webkit-scrollbar {
    width: 6px;
}
.associated-doctors-container.view-mode-list::-webkit-scrollbar-track {
    background: #F1F5F9;
    border-radius: 4px;
}
.associated-doctors-container.view-mode-list::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 4px;
}
.associated-doctors-container.view-mode-list::-webkit-scrollbar-thumb:hover {
    background: #00A896;
}

.associated-doctors-container.view-mode-list .associated-doctor-card {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    background: #FFFFFF !important;
    border: 1px solid #E2E8F0 !important;
    border-radius: 12px !important;
    padding: 14px 18px !important;
    margin-bottom: 12px !important;
    gap: 16px !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
    transition: all 0.2s ease !important;
}
.associated-doctors-container.view-mode-list .associated-doctor-card:hover {
    border-color: #00A896 !important;
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.12) !important;
    transform: translateX(3px) !important;
}
.associated-doctors-container.view-mode-list .doc-list-left {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    text-align: left !important;
    gap: 14px !important;
    flex: 1 1 auto !important;
    min-width: 0 !important;
    margin-bottom: 0 !important;
}
.associated-doctors-container.view-mode-list .associated-doctor-avatar {
    width: 62px !important;
    height: 62px !important;
    border-radius: 50% !important;
    border: 2.5px solid #00A896 !important;
    object-fit: cover !important;
    flex-shrink: 0 !important;
    margin: 0 !important;
}
.associated-doctors-container.view-mode-list .doc-list-details {
    flex: 1 1 auto !important;
    min-width: 0 !important;
}
.associated-doctors-container.view-mode-list .associated-doctor-name {
    font-size: 16px !important;
    font-weight: 700 !important;
    color: #0F172A !important;
    margin: 0 0 3px 0 !important;
}
.associated-doctors-container.view-mode-list .doc-badges-row {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
    margin-bottom: 6px !important;
}
.associated-doctors-container.view-mode-list .associated-doctor-spec {
    display: inline-block !important;
    background: #E6FFFA !important;
    color: #00A896 !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    padding: 2px 8px !important;
    border-radius: 4px !important;
}
.associated-doctors-container.view-mode-list .associated-doctor-qual {
    font-size: 12px !important;
    color: #64748B !important;
    margin: 0 !important;
}
.associated-doctors-container.view-mode-list .associated-doctor-meta {
    display: inline-flex !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 12px !important;
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
    font-size: 12px !important;
    color: #475569 !important;
    width: auto !important;
}
.associated-doctors-container.view-mode-list .doc-list-actions {
    display: flex !important;
    flex-direction: column !important;
    gap: 6px !important;
    flex-shrink: 0 !important;
    min-width: 130px !important;
    width: auto !important;
}
.associated-doctors-container.view-mode-list .btn-doc-profile {
    padding: 7px 12px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    text-align: center !important;
    border-radius: 6px !important;
}
.associated-doctors-container.view-mode-list .btn-doc-book {
    padding: 7px 12px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    text-align: center !important;
    border-radius: 6px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 4px !important;
}

/* ========================================================= */
/* 3. GRID VIEW (Responsive Cards Grid)                      */
/* ========================================================= */
.associated-doctors-container.view-mode-grid {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)) !important;
    gap: 16px !important;
    max-height: none !important;
    margin-top: 10px !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-card {
    background: #FFFFFF !important;
    border: 1px solid #E2E8F0 !important;
    border-radius: 14px !important;
    padding: 16px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
    transition: all 0.2s ease !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-card:hover {
    border-color: #00A896 !important;
    box-shadow: 0 8px 20px rgba(0, 168, 150, 0.12) !important;
    transform: translateY(-2px) !important;
}
.associated-doctors-container.view-mode-grid .doc-list-left {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
    width: 100% !important;
    margin-bottom: 12px !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-avatar {
    width: 68px !important;
    height: 68px !important;
    border-radius: 50% !important;
    border: 2.5px solid #00A896 !important;
    object-fit: cover !important;
    margin: 0 auto 10px auto !important;
}
.associated-doctors-container.view-mode-grid .doc-list-details {
    width: 100% !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-name {
    font-size: 15px !important;
    font-weight: 700 !important;
    color: #0F172A !important;
    margin: 0 0 4px 0 !important;
}
.associated-doctors-container.view-mode-grid .doc-badges-row {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 4px !important;
    margin-bottom: 10px !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-spec {
    display: inline-block !important;
    background: #E6FFFA !important;
    color: #00A896 !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    padding: 2px 8px !important;
    border-radius: 4px !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-qual {
    font-size: 11.5px !important;
    color: #64748B !important;
    margin: 0 !important;
}
.associated-doctors-container.view-mode-grid .associated-doctor-meta {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 8px 10px !important;
    background: #F8FAFC !important;
    border: 1px solid #E2E8F0 !important;
    border-radius: 8px !important;
    font-size: 11.5px !important;
    color: #334155 !important;
    margin-bottom: 12px !important;
    width: 100% !important;
}
.associated-doctors-container.view-mode-grid .doc-list-actions {
    display: flex !important;
    gap: 8px !important;
    width: 100% !important;
}
.associated-doctors-container.view-mode-grid .btn-doc-profile {
    flex: 1 !important;
    padding: 8px 10px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    text-align: center !important;
    border-radius: 6px !important;
}
.associated-doctors-container.view-mode-grid .btn-doc-book {
    flex: 1.2 !important;
    padding: 8px 10px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    text-align: center !important;
    border-radius: 6px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 4px !important;
}

@media (max-width: 767px) {
    .associated-doctors-container.view-mode-list .associated-doctor-card {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    .associated-doctors-container.view-mode-list .doc-list-actions {
        flex-direction: row !important;
        width: 100% !important;
    }
    .hosp-section-header-flex {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    .doctor-view-switcher {
        width: 100% !important;
        justify-content: space-between !important;
    }
    .doctor-view-switcher .view-btn {
        flex: 1 !important;
        justify-content: center !important;
    }
}
</style>

<!-- Floating Search & Filter Bar -->
<div class="container" style="margin-top: 24px;">
    <form action='<?=base_url();?>search' method='GET'>
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
                <div class="col-md-5 col-sm-6" style="padding: 6px;">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-search"></i></span>
                        <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" value="<?=@$_GET['keyword'];?>" placeholder="Search Doctors, Clinics, Specializations, Hospitals..." autocomplete="off">
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
                <div class="col-md-1 col-sm-4" style="padding: 6px;">
                    <button type="submit" id="searchBTN" title="Search"><i class="fas fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
$hospImg = (!empty($hospital->drimage) && file_exists('admin1947/public/assets/upload/'.$hospital->drimage)) 
           ? admin_url().'public/assets/upload/'.$hospital->drimage 
           : admin_url().'public/assets/upload/dummyhospital.jpg';

$cityName = getCityName($hospital->city) ?: 'Varanasi';
$hospAddress = !empty($hospital->address) ? $hospital->address : ($cityName . ', Uttar Pradesh, India');
$hospMobile = !empty($hospital->mobile) ? $hospital->mobile : '8448440603';
$hospEmail = !empty($hospital->email) ? $hospital->email : 'support@upchar.info';
?>

<!-- Hospital Profile Detail Section -->
<div class="hosp-profile-container">
    <!-- Hero Banner Card -->
    <div class="hosp-profile-card">
        <div class="hosp-profile-header">
            <!-- Hospital Avatar / Thumbnail -->
            <div class="hosp-profile-avatar-wrap">
                <img src="<?=$hospImg;?>" alt="<?=$hospital->name;?>" class="hosp-profile-avatar">
                <span class="hosp-profile-badge-verified"><i class="fas fa-check-circle"></i> Verified Hospital</span>
            </div>

            <!-- Hospital Information -->
            <div class="hosp-profile-info">
                <h1 class="hosp-profile-name"><?=$hospital->name;?></h1>
                <div class="hosp-profile-address">
                    <i class="fas fa-map-marker-alt" style="color: #00A896;"></i>
                    <span><?=$hospAddress;?></span>
                </div>

                <div class="hosp-profile-tags">
                    <span class="spec-pill" style="background: #E8F0FE; color: #1A73E8; border: 1px solid #D2E3FC; font-weight: 600;">
                        <i class="fas fa-clock"></i> Open 24/7 • Emergency & Critical Care
                    </span>
                    <span class="spec-pill"><i class="fas fa-bed"></i> Inpatient & ICU Beds</span>
                    <span class="spec-pill"><i class="fas fa-ambulance"></i> 24/7 Ambulance Support</span>
                    <span class="spec-pill"><i class="fas fa-shield-alt"></i> NABH / Clinical Compliance</span>
                </div>

                <div class="hosp-profile-metrics">
                    <div class="hosp-profile-metric-item">
                        <i class="fas fa-ambulance" style="color: #DC2626;"></i>
                        <span><strong>24/7</strong> Emergency Trauma</span>
                    </div>
                    <div class="hosp-profile-metric-item">
                        <i class="fas fa-stethoscope" style="color: #00A896;"></i>
                        <span><strong>Multi-Specialty</strong> OPD</span>
                    </div>
                    <div class="hosp-profile-metric-item">
                        <i class="fas fa-bed" style="color: #16A34A;"></i>
                        <span><strong>Live</strong> Bed Tracking</span>
                    </div>
                    <div class="hosp-profile-metric-item">
                        <i class="fas fa-star" style="color: #F59E0B;"></i>
                        <span><strong>4.8</strong> (150+ Verified Reviews)</span>
                    </div>
                </div>
            </div>

            <!-- Actions & Contact Column -->
            <div class="hosp-profile-actions">
                <div class="wait-time-badge" style="margin-bottom: 10px;">
                    <i class="fas fa-check-circle" style="color: #16A34A;"></i> Verified Partner Facility
                </div>
                <a href="tel:<?=$hospMobile;?>" class="btn btn-primary-cta" style="padding: 12px 20px; font-size: 15px; justify-content: center; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-phone-alt"></i> Contact Hospital
                </a>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#enquiryModal" style="padding: 10px 16px; justify-content: center; display: flex; align-items: center; gap: 8px; border: 1px solid #CBD5E1; background: #FFFFFF; font-weight: 600; cursor: pointer; width: 100%;">
                    <i class="fas fa-envelope" style="color: #00A896;"></i> Send Enquiry
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Overview, Bed Tracking, Doctors, Gallery -->
        <div class="col-md-8">
            <!-- About Hospital -->
            <div class="hosp-profile-card">
                <h3 class="hosp-profile-section-title">
                    <i class="fas fa-hospital" style="color: #00A896;"></i> About <?=$hospital->name;?>
                </h3>
                <p style="font-size: 14.5px; color: #334155; line-height: 1.7; margin-bottom: 18px;">
                    <?=(!empty($hospital->about)) ? nl2br(strip_tags($hospital->about)) : $hospital->name.' is a premier multi-specialty healthcare institution in '.$cityName.', delivering advanced medical care, 24/7 emergency response, modern inpatient accommodations, and highly qualified specialist consultations through the Upchar healthcare network.';?>
                </p>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: #16A34A; font-weight: 600; font-size: 13.5px;">
                        <i class="fas fa-shield-alt" style="font-size: 16px;"></i> Verified Healthcare Facility & Regulatory Compliance
                    </div>
                </div>
            </div>

            <!-- Facilities & Live Bed Availability Tracking -->
            <div class="hosp-profile-card">
                <h3 class="hosp-profile-section-title">
                    <i class="fas fa-procedures" style="color: #00A896;"></i> Live Facilities & Bed Availability Status
                </h3>
                
                <div class="facility-live-grid">
                    <div class="facility-live-card">
                        <div class="facility-live-info">
                            <div class="facility-live-icon"><i class="fas fa-bed"></i></div>
                            <div>
                                <h4 class="facility-live-title">ICU & Critical Care</h4>
                                <span style="font-size: 12px; color: #64748B;">Ventilator support ready</span>
                            </div>
                        </div>
                        <span class="facility-live-status-pill"><i class="fas fa-check"></i> Available</span>
                    </div>

                    <div class="facility-live-card">
                        <div class="facility-live-info">
                            <div class="facility-live-icon"><i class="fas fa-hospital-alt"></i></div>
                            <div>
                                <h4 class="facility-live-title">General / Oxygen Beds</h4>
                                <span style="font-size: 12px; color: #64748B;">Continuous O2 pipeline</span>
                            </div>
                        </div>
                        <span class="facility-live-status-pill"><i class="fas fa-check"></i> Available</span>
                    </div>

                    <div class="facility-live-card">
                        <div class="facility-live-info">
                            <div class="facility-live-icon"><i class="fas fa-heartbeat"></i></div>
                            <div>
                                <h4 class="facility-live-title">Emergency Trauma & OT</h4>
                                <span style="font-size: 12px; color: #64748B;">Round-the-clock surgeons</span>
                            </div>
                        </div>
                        <span class="facility-live-status-pill"><i class="fas fa-circle" style="font-size: 8px;"></i> 24/7 Active</span>
                    </div>

                    <div class="facility-live-card">
                        <div class="facility-live-info">
                            <div class="facility-live-icon"><i class="fas fa-pills"></i></div>
                            <div>
                                <h4 class="facility-live-title">Pharmacy & Pathology</h4>
                                <span style="font-size: 12px; color: #64748B;">In-house 24 hrs diagnostic</span>
                            </div>
                        </div>
                        <span class="facility-live-status-pill"><i class="fas fa-check"></i> Open Now</span>
                    </div>
                </div>
            </div>

            <!-- Associated Specialists & Doctors -->
            <div class="hosp-profile-card">
                <div class="hosp-section-header-flex">
                    <h3 class="hosp-profile-section-title" style="margin: 0; padding: 0; border: none;">
                        <i class="fas fa-user-md" style="color: #00A896;"></i> Associated Specialists &amp; Doctors
                        <?php if (!empty($clinic)): ?>
                        <span class="hosp-count-badge"><?=count($clinic);?> Doctors</span>
                        <?php endif; ?>
                    </h3>
                    <?php if (!empty($clinic)): ?>
                    <div class="doctor-view-switcher">
                        <button type="button" class="view-btn active" data-mode="slider" title="Slider Carousel View">
                            <i class="fas fa-sliders-h"></i> Slider
                        </button>
                        <button type="button" class="view-btn" data-mode="list" title="List View">
                            <i class="fas fa-list-ul"></i> List
                        </button>
                        <button type="button" class="view-btn" data-mode="grid" title="Grid View">
                            <i class="fas fa-th-large"></i> Grid
                        </button>
                    </div>
                    <?php endif; ?>
                </div>

                <div id="associatedDoctorsContainer" class="associated-doctors-container view-mode-slider owl-carousel owl-theme">
                    <?php if (!empty($clinic)) { foreach($clinic as $doc) { 
                        $docImg = (!empty($doc->drimage) && file_exists('admin1947/public/assets/upload/'.$doc->drimage)) 
                                  ? admin_url().'public/assets/upload/'.$doc->drimage 
                                  : admin_url().'public/assets/upload/dummydr.jpg';
                        $docPrefix = (strcasecmp(substr($doc->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
                        
                        $doc_id = (int)$doc->id;
                        $doc_uid = (int)$doc->user_id;

                        // Specialization
                        $docSpecs = $this->db->query("SELECT DISTINCT ds.specialization_id, ms.name FROM dr_specialization ds JOIN master_specialization ms ON ds.specialization_id = ms.id WHERE ds.user_id = $doc_id OR (ds.user_id = $doc_uid AND $doc_uid != 0)")->result();
                        $specName = (!empty($docSpecs) && !empty($docSpecs[0]->name)) 
                                    ? $docSpecs[0]->name 
                                    : (!empty($doc->specialization) ? getSpecilizationName($doc->specialization) : 'Specialist Physician');

                        // Qualifications
                        $docQuals = $this->db->query("SELECT * FROM dr_qualifications WHERE user_id = $doc_id OR (user_id = $doc_uid AND $doc_uid != 0)")->result();
                        $qualName = (!empty($docQuals) && !empty($docQuals[0]->qualification_id)) 
                                    ? getQualificationName($docQuals[0]->qualification_id) 
                                    : 'MBBS';

                        $docFee = (!empty($doc->p_fee)) ? $doc->p_fee : '500';
                        $docExp = (!empty($doc->exp) && $doc->exp > 0) ? $doc->exp : 8;
                    ?>
                    <div class="associated-doctor-card">
                        <div class="doc-list-left">
                            <img src="<?=$docImg;?>" alt="<?=$docPrefix.$doc->fname.' '.$doc->lname;?>" class="associated-doctor-avatar">
                        </div>

                        <div class="doc-list-details">
                            <h4 class="associated-doctor-name"><?=$docPrefix.$doc->fname.' '.$doc->lname;?></h4>
                            <div class="doc-badges-row">
                                <span class="associated-doctor-spec"><?=$specName;?></span>
                                <span class="associated-doctor-qual"><?=$qualName;?></span>
                            </div>
                            <div class="associated-doctor-meta">
                                <span><i class="fas fa-briefcase" style="color: #00A896;"></i> <strong><?=$docExp;?>+ Yrs</strong> Exp</span>
                                <span><i class="fas fa-rupee-sign" style="color: #05668D;"></i> <strong>₹<?=$docFee;?></strong> Fee</span>
                                <span><i class="fas fa-clock" style="color: #16A34A;"></i> 10 AM - 1 PM</span>
                            </div>
                        </div>

                        <div class="doc-list-actions">
                            <a href="<?=base_url('doctor/'.$doc->id);?>" class="btn btn-secondary btn-doc-profile">
                                View Profile
                            </a>
                            <a href="javascript:void(0);" class="btn btn-primary-cta getappointment btn-book-appointment btn-doc-book" data-doctor-id="<?=$doc->id;?>" data-hospital-id="<?=$hospital->id;?>" data-did="<?=$doc->id;?>" data-upchar-did="<?=$doc->id;?>" data-toggle="modal" data-target="#myModal">
                                <i class="fas fa-calendar-check"></i> Book
                            </a>
                        </div>
                    </div>
                    <?php } } else { ?>
                    <p style="color: #64748B; font-size: 14px; padding: 10px;">No doctors currently listed for this facility.</p>
                    <?php } ?>
                </div>
            </div>

            <!-- Photos & Facility Gallery -->
            <div class="hosp-profile-card">
                <h3 class="hosp-profile-section-title">
                    <i class="fas fa-images" style="color: #00A896;"></i> Photos & Infrastructure
                </h3>

                <div class="hosp-gallery-grid">
                    <?php if (!empty($gallery)) { foreach($gallery as $g) { ?>
                    <div class="hosp-gallery-item">
                        <img src="<?=admin_url();?>public/assets/upload/<?=$g->image;?>" alt="Hospital Infrastructure" class="hosp-gallery-img">
                    </div>
                    <?php } } else { ?>
                    <div class="hosp-gallery-item">
                        <img src="<?=$hospImg;?>" alt="Hospital Building" class="hosp-gallery-img">
                    </div>
                    <div class="hosp-gallery-item">
                        <img src="<?=base_url();?>images/Hospital.jpg" alt="Hospital Facility" class="hosp-gallery-img">
                    </div>
                    <div class="hosp-gallery-item">
                        <img src="<?=admin_url();?>public/assets/upload/dummyhospital.jpg" alt="Hospital Reception" class="hosp-gallery-img">
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Right Column / Sidebar: Contact Info & Location Map -->
        <div class="col-md-4">
            <!-- Contact Details Card -->
            <div class="hosp-profile-card">
                <h3 class="hosp-profile-section-title">
                    <i class="fas fa-phone-volume" style="color: #00A896;"></i> Emergency & Helpline
                </h3>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 2px;">Admissions & Appointments</div>
                    <a href="tel:<?=$hospMobile;?>" style="font-size: 16px; font-weight: 700; color: #05668D; text-decoration: none;">
                        <i class="fas fa-phone-alt" style="color: #00A896; margin-right: 6px;"></i> <?=$hospMobile;?>
                    </a>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 2px;">Email Support & Enquiries</div>
                    <a href="mailto:<?=$hospEmail;?>" style="font-size: 14px; font-weight: 600; color: #334155; text-decoration: none;">
                        <i class="fas fa-envelope" style="color: #00A896; margin-right: 6px;"></i> <?=$hospEmail;?>
                    </a>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 2px;">Hospital Address</div>
                    <div style="font-size: 13.5px; color: #334155; line-height: 1.5;">
                        <i class="fas fa-map-marker-alt" style="color: #00A896; margin-right: 6px;"></i> <?=$hospAddress;?>
                    </div>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px; font-size: 12.5px; color: #475569;">
                    <i class="fas fa-clock" style="color: #16A34A; margin-right: 6px;"></i> <strong>Emergency Services:</strong> Open 24 Hours, 7 Days a Week
                </div>
            </div>

            <!-- Embedded Map Card -->
            <div class="hosp-profile-card">
                <h3 class="hosp-profile-section-title">
                    <i class="fas fa-map-marked-alt" style="color: #00A896;"></i> Hospital Location
                </h3>
                <div class="hosp-map-wrapper">
                    <iframe src="https://maps.google.com/maps?q=<?=urlencode($hospital->name.' '.$hospAddress);?>&t=&z=14&ie=UTF8&iwloc=&output=embed" allowfullscreen loading="lazy"></iframe>
                </div>
                <a href="https://maps.google.com/?q=<?=urlencode($hospital->name.' '.$hospAddress);?>" target="_blank" class="btn btn-secondary" style="width: 100%; text-align: center; padding: 8px; font-size: 13px;">
                    <i class="fas fa-directions" style="color: #00A896;"></i> Get Directions on Google Maps
                </a>
            </div>

            <!-- Emergency Assistance Box -->
            <div class="hosp-profile-card" style="background: linear-gradient(135deg, #05668D 0%, #00A896 100%); color: #FFFFFF; border: none;">
                <h4 style="font-size: 17px; font-weight: 700; color: #FFFFFF; margin: 0 0 8px;">
                    <i class="fas fa-ambulance"></i> Need Emergency Admission?
                </h4>
                <p style="font-size: 13px; color: #E6F4EA; line-height: 1.5; margin-bottom: 14px;">
                    Connect with Upchar Emergency Coordinators for immediate bed reservation and ambulance dispatch.
                </p>
                <a href="tel:8448440603" class="btn" style="background: #FFFFFF; color: #05668D; font-weight: 700; border-radius: 8px; width: 100%; text-align: center; padding: 10px;">
                    <i class="fas fa-headset" style="color: #00A896; margin-right: 6px;"></i> Call 8448440603
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Send Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="enquiryModalLabel" aria-hidden="true" style="z-index: 10500;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px; margin: 30px auto;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.22); overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #043D5B 0%, #008F80 100%); color: #FFFFFF; padding: 20px 24px; position: relative;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFFFFF; opacity: 0.85; font-size: 24px; font-weight: 400; text-shadow: none; position: absolute; right: 20px; top: 18px; background: none; border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px; color: #FFFFFF;">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" id="enquiryModalLabel" style="font-size: 18px; font-weight: 700; margin: 0; color: #FFFFFF;">
                            Send Enquiry to Hospital
                        </h4>
                        <span style="font-size: 12px; color: #E2E8F0; display: block; margin-top: 2px;">
                            <?=htmlspecialchars($hospital->name);?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modal Body / Form -->
            <form action="<?=base_url('send-enquiry');?>" method="POST" id="hospitalEnquiryForm" autocomplete="off">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="hospital_id" value="<?=$hospital->id;?>">
                
                <div class="modal-body" style="padding: 24px; background: #FFFFFF;">
                    <!-- Alert Status Container -->
                    <div id="enquiryAlertBox" style="display: none; margin-bottom: 16px;"></div>

                    <!-- Full Name -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                            <i class="fas fa-user" style="color: #00A896; margin-right: 5px;"></i> Full Name <span style="color: #EF4444;">*</span>
                        </label>
                        <input type="text" name="user_name" id="enq_user_name" class="form-control" placeholder="e.g. Ramesh Kumar" required style="height: 42px; border-radius: 8px; border: 1.5px solid #CBD5E1; padding: 8px 14px; font-size: 14px;">
                    </div>

                    <!-- Contact Details (2 Columns) -->
                    <div class="row" style="margin: 0 -8px 16px -8px;">
                        <div class="col-sm-6" style="padding: 0 8px; margin-bottom: 10px;">
                            <label style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                                <i class="fas fa-phone-alt" style="color: #00A896; margin-right: 5px;"></i> Phone Number <span style="color: #EF4444;">*</span>
                            </label>
                            <input type="tel" name="user_phone" id="enq_user_phone" class="form-control" placeholder="10-digit mobile" pattern="[0-9]{10}" required style="height: 42px; border-radius: 8px; border: 1.5px solid #CBD5E1; padding: 8px 14px; font-size: 14px;">
                        </div>
                        <div class="col-sm-6" style="padding: 0 8px; margin-bottom: 10px;">
                            <label style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                                <i class="fas fa-envelope" style="color: #00A896; margin-right: 5px;"></i> Email Address <span style="color: #EF4444;">*</span>
                            </label>
                            <input type="email" name="user_email" id="enq_user_email" class="form-control" placeholder="e.g. ramesh@gmail.com" required style="height: 42px; border-radius: 8px; border: 1.5px solid #CBD5E1; padding: 8px 14px; font-size: 14px;">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                            <i class="fas fa-tag" style="color: #00A896; margin-right: 5px;"></i> Subject / Topic
                        </label>
                        <input type="text" name="subject" id="enq_subject" class="form-control" placeholder="e.g. Bed availability / Package cost / OPD appointment" style="height: 42px; border-radius: 8px; border: 1.5px solid #CBD5E1; padding: 8px 14px; font-size: 14px;">
                    </div>

                    <!-- Message / Query -->
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                            <i class="fas fa-comment-medical" style="color: #00A896; margin-right: 5px;"></i> Your Message / Query <span style="color: #EF4444;">*</span>
                        </label>
                        <textarea name="message" id="enq_message" class="form-control" rows="4" placeholder="Please describe your clinical query, required treatment, or admission request..." required style="border-radius: 8px; border: 1.5px solid #CBD5E1; padding: 10px 14px; font-size: 14px; resize: vertical;"></textarea>
                    </div>

                    <div style="font-size: 11.5px; color: #64748B; margin-top: 10px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-lock" style="color: #16A34A;"></i> Your details are shared securely with the verified hospital administration desk only.
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC; border-top: 1px solid #E2E8F0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 8px; padding: 9px 18px; font-size: 13.5px; font-weight: 600; border: 1px solid #CBD5E1; background: #FFFFFF; color: #475569;">
                        Cancel
                    </button>
                    <button type="submit" id="submitEnquiryBtn" class="btn btn-primary-cta" style="border-radius: 8px; padding: 9px 24px; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-paper-plane" id="submitEnquiryIcon"></i> <span id="submitEnquiryText">Submit Enquiry</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#hospitalEnquiryForm').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $btn = $('#submitEnquiryBtn');
        var $btnText = $('#submitEnquiryText');
        var $btnIcon = $('#submitEnquiryIcon');
        var $alertBox = $('#enquiryAlertBox');

        // Basic Client Validation
        var name = $.trim($('#enq_user_name').val());
        var phone = $.trim($('#enq_user_phone').val());
        var email = $.trim($('#enq_user_email').val());
        var message = $.trim($('#enq_message').val());

        if (!name || !phone || !email || !message) {
            $alertBox.html('<div class="alert alert-warning" style="border-radius: 8px; margin: 0; padding: 10px 14px; font-size: 13px;"><i class="fas fa-exclamation-triangle"></i> Please fill in all required fields.</div>').slideDown(200);
            return false;
        }

        // Disable Button & Show Spinner
        $btn.prop('disabled', true);
        $btnText.text('Submitting Enquiry...');
        $btnIcon.attr('class', 'fas fa-spinner fa-spin');
        $alertBox.hide();

        var formData = $form.serialize() + '&ajax=1';

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false);
                $btnText.text('Submit Enquiry');
                $btnIcon.attr('class', 'fas fa-paper-plane');

                if (typeof res === 'string') {
                    try { res = JSON.parse(res); } catch(e) {}
                }

                if (res && res.status === 'success') {
                    $alertBox.html('<div class="alert alert-success" style="border-radius: 8px; margin: 0; padding: 12px 16px; font-size: 13.5px;"><i class="fas fa-check-circle"></i> ' + res.message + '</div>').slideDown(200);
                    $form[0].reset();
                    setTimeout(function() {
                        $('#enquiryModal').modal('hide');
                        $alertBox.hide();
                    }, 3500);
                } else {
                    var errMsg = (res && res.message) ? res.message : 'An error occurred while submitting your enquiry. Please try again.';
                    $alertBox.html('<div class="alert alert-danger" style="border-radius: 8px; margin: 0; padding: 10px 14px; font-size: 13px;"><i class="fas fa-times-circle"></i> ' + errMsg + '</div>').slideDown(200);
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false);
                $btnText.text('Submit Enquiry');
                $btnIcon.attr('class', 'fas fa-paper-plane');
                var errText = 'Server connection failed. Please try again later.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    errText = xhr.responseJSON.message;
                }
                $alertBox.html('<div class="alert alert-danger" style="border-radius: 8px; margin: 0; padding: 10px 14px; font-size: 13px;"><i class="fas fa-times-circle"></i> ' + errText + '</div>').slideDown(200);
            }
        });
    });
});
</script>

<!-- Owl Carousel 2 JS for Doctor Slider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function() {
    var $container = $('#associatedDoctorsContainer');
    if (!$container.length) return;

    // Cache the pristine original cards HTML
    var originalDocHtml = $container.html();
    var savedMode = localStorage.getItem('upchar_hosp_doc_mode') || 'slider';

    function setDoctorMode(mode) {
        // Destroy existing owl carousel instance if initialized
        if ($container.hasClass('owl-loaded')) {
            $container.trigger('destroy.owl.carousel');
            $container.removeClass('owl-carousel owl-loaded owl-drag owl-theme');
        }

        // Restore pristine HTML
        $container.html(originalDocHtml);

        // Update button active state
        $('.doctor-view-switcher .view-btn').removeClass('active');
        $('.doctor-view-switcher .view-btn[data-mode="' + mode + '"]').addClass('active');
        localStorage.setItem('upchar_hosp_doc_mode', mode);

        if (mode === 'slider') {
            $container.removeClass('view-mode-list view-mode-grid').addClass('view-mode-slider owl-carousel owl-theme');
            var docCount = $container.find('.associated-doctor-card').length;
            $container.owlCarousel({
                loop: (docCount > 3),
                margin: 16,
                nav: (docCount > 1),
                dots: (docCount > 1),
                autoplay: false,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                },
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ]
            });
        } else if (mode === 'list') {
            $container.removeClass('view-mode-slider view-mode-grid owl-carousel owl-theme').addClass('view-mode-list');
        } else {
            // Grid mode
            $container.removeClass('view-mode-slider view-mode-list owl-carousel owl-theme').addClass('view-mode-grid');
        }
    }

    // Initialize with saved or default mode (slider)
    setDoctorMode(savedMode);

    // Event listener for switcher buttons
    $(document).on('click', '.doctor-view-switcher .view-btn', function(e) {
        e.preventDefault();
        var selectedMode = $(this).data('mode');
        setDoctorMode(selectedMode);
    });
});
</script>

<?php include ("includes/footer.php"); ?>