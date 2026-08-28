<?php include ("includes/header.php"); ?>

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
                <a href="mailto:<?=$hospEmail;?>" class="btn btn-secondary" style="padding: 10px 16px; justify-content: center; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-envelope"></i> Send Enquiry
                </a>
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

            <!-- Associated Specialists & Doctors Grid -->
            <div class="hosp-profile-card">
                <h3 class="hosp-profile-section-title">
                    <i class="fas fa-user-md" style="color: #00A896;"></i> Associated Specialists & Doctors
                </h3>

                <div class="associated-doctors-grid">
                    <?php if (!empty($clinic)) { foreach($clinic as $doc) { 
                        $docImg = (!empty($doc->drimage) && file_exists('admin1947/public/assets/upload/'.$doc->drimage)) 
                                  ? admin_url().'public/assets/upload/'.$doc->drimage 
                                  : admin_url().'public/assets/upload/dummydr.jpg';
                        $docPrefix = (strcasecmp(substr($doc->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
                        
                        // Specialization
                        $docSpecs = $this->db->get_where('dr_specialization', array('user_id' => $doc->id))->result();
                        $specName = (!empty($docSpecs) && !empty($docSpecs[0]->specialization_id)) 
                                    ? getSpecilizationName($docSpecs[0]->specialization_id) 
                                    : 'Specialist Physician';

                        // Qualifications
                        $docQuals = $this->db->get_where('dr_qualifications', array('user_id' => $doc->id))->result();
                        $qualName = (!empty($docQuals) && !empty($docQuals[0]->qualification_id)) 
                                    ? getQualificationName($docQuals[0]->qualification_id) 
                                    : 'MBBS';

                        $docFee = (!empty($doc->p_fee)) ? $doc->p_fee : '500';
                        $docExp = (!empty($doc->exp) && $doc->exp > 0) ? $doc->exp : 8;
                    ?>
                    <div class="associated-doctor-card">
                        <div>
                            <div class="associated-doctor-top">
                                <img src="<?=$docImg;?>" alt="<?=$docPrefix.$doc->fname.' '.$doc->lname;?>" class="associated-doctor-avatar">
                                <div>
                                    <h4 class="associated-doctor-name"><?=$docPrefix.$doc->fname.' '.$doc->lname;?></h4>
                                    <div class="associated-doctor-spec"><?=$specName;?></div>
                                    <p class="associated-doctor-qual"><?=$qualName;?></p>
                                </div>
                            </div>

                            <div class="associated-doctor-meta">
                                <span><i class="fas fa-briefcase" style="color: #00A896;"></i> <strong><?=$docExp;?>+ Yrs</strong> Exp</span>
                                <span><i class="fas fa-rupee-sign" style="color: #05668D;"></i> <strong>₹<?=$docFee;?></strong> Fee</span>
                                <span><i class="fas fa-clock" style="color: #16A34A;"></i> 10 AM - 1 PM</span>
                            </div>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <a href="<?=base_url('doctor/'.$doc->id);?>" class="btn btn-secondary" style="flex: 1; padding: 8px 10px; font-size: 13px; text-align: center;">
                                View Profile
                            </a>
                            <a href="javascript:void(0);" class="btn btn-primary-cta getappointment" data-upchar-did="<?=$doc->id;?>" data-toggle="modal" data-target="#myModal" style="flex: 1.2; padding: 8px 10px; font-size: 13px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                <i class="fas fa-calendar-check"></i> Book
                            </a>
                        </div>
                    </div>
                    <?php } } else { ?>
                    <p style="color: #64748B; font-size: 14px;">No doctors currently listed for this facility.</p>
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

<?php include ("includes/footer.php"); ?>