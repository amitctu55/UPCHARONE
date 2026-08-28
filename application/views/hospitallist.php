<?php include ('includes/header.php'); ?>

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
                        <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" value="<?=@$_GET['keyword'];?>" placeholder="Search Hospitals, Clinics, Treatments, Facilities..." autocomplete="off">
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

<!-- Hospitals Directory Listing -->
<section class="section-wrapper" style="padding: 10px 0 60px;">
    <div class="container">
        <div class="row">
            <!-- Sidebar: Quick Assistance & Filters -->
            <div class="col-md-3 col-sm-4">
                <div class="modern-partner-card" style="text-align: left; padding: 24px 20px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div class="modern-partner-icon" style="margin: 0; width: 48px; height: 48px; font-size: 20px;">
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <div>
                            <h5 style="margin: 0; font-size: 16px; font-weight: 700; color: #0F172A;">24/7 Emergency</h5>
                            <span style="font-size: 12px; color: #64748B;">Immediate Care Support</span>
                        </div>
                    </div>
                    <p style="font-size: 13px; color: #475569; margin-bottom: 16px; line-height: 1.5;">
                        Need urgent medical care or emergency bed allocation? Call our dedicated patient assistance desk.
                    </p>
                    <a href="tel:8448440603" class="btn btn-primary-cta" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-phone-alt"></i> 844-844-0603
                    </a>
                </div>

                <div class="modern-partner-card" style="text-align: left; padding: 24px 20px;">
                    <h5 style="margin: 0 0 12px; font-size: 15px; font-weight: 700; color: #0F172A;">
                        <i class="fas fa-shield-alt" style="color: #00A896; margin-right: 6px;"></i> Upchar Assurance
                    </h5>
                    <ul style="padding-left: 0; list-style: none; margin: 0; font-size: 13px; color: #64748B; display: flex; flex-direction: column; gap: 10px;">
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
                <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0;">
                        Verified Hospitals & Clinics <span style="font-size: 15px; font-weight: 500; color: #64748B;">(<?=count($hospital);?> Facilities Available)</span>
                    </h3>
                </div>

                <?php if (!empty($hospital)) { foreach($hospital as $institution) { 
                    $hImg = ($institution->drimage && file_exists('admin1947/public/assets/upload/'.$institution->drimage)) 
                            ? admin_url().'public/assets/upload/'.$institution->drimage 
                            : admin_url().'public/assets/upload/dummyhospital.jpg';
                    $cityText = ($institution->city) ? getCityName($institution->city) : 'Varanasi';
                    $addressText = (!empty($institution->address)) ? $institution->address : $cityText.', Uttar Pradesh, India';
                ?>
                <!-- Modern Hospital Profile Card -->
                <div class="hospital-card" style="margin-bottom: 24px;">
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

                    <!-- Column 2: Details & Services -->
                    <div class="doc-col-mid">
                        <div class="doc-header">
                            <h3 class="doc-name">
                                <a href="<?=base_url();?>hospital/<?=$institution->id;?>"><?=$institution->name;?></a>
                            </h3>
                            <span class="doc-qualifications" style="color: #00A896; font-weight: 600;">
                                <i class="fas fa-hospital-alt"></i> Multi-Specialty Hospital & Research Center
                            </span>
                        </div>

                        <div class="doc-spec-tags">
                            <span class="spec-pill"><i class="fas fa-ambulance"></i> 24/7 Emergency</span>
                            <span class="spec-pill"><i class="fas fa-procedures"></i> Inpatient / ICU</span>
                            <span class="spec-pill"><i class="fas fa-flask"></i> Diagnostic Pathology</span>
                        </div>

                        <div class="doc-meta-info">
                            <p class="meta-item">
                                <i class="fas fa-clock"></i> <strong>Open 24 Hours</strong> (Mon - Sun)
                            </p>
                            <p class="meta-item">
                                <i class="fas fa-map-marker-alt"></i> <?=$addressText;?>
                            </p>
                        </div>
                    </div>

                    <!-- Column 3: Actions & Phone -->
                    <div class="doc-col-right">
                        <div class="wait-time-badge" style="background: #F0FDF4; color: #16A34A; border-color: #DCFCE7;">
                            <i class="fas fa-check-circle"></i> Verified Network Partner
                        </div>
                        <div class="action-buttons">
                            <a href="<?=base_url();?>hospital/<?=$institution->id;?>" class="btn btn-outline">
                                View Profile
                            </a>
                            <a href="tel:8448440603" class="btn btn-primary-cta">
                                <i class="fas fa-phone-alt"></i> Call Hospital
                            </a>
                        </div>
                    </div>
                </div>
                <?php } } else { ?>
                <div class="doctor-card text-center" style="display: block; padding: 50px 20px;">
                    <i class="fas fa-hospital-alt" style="font-size: 40px; color: #CBD5E1; margin-bottom: 16px;"></i>
                    <h4 style="color: #64748B; margin-bottom: 8px;">No hospitals found matching your criteria.</h4>
                    <p style="color: #94A3B8; margin-bottom: 20px;">Try adjusting your location or specialization filter above.</p>
                    <a href="<?=base_url('hospitals');?>" class="btn btn-secondary" style="display: inline-block; width: auto; padding: 8px 24px;">View All Hospitals</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php include ('includes/footer.php'); ?>
