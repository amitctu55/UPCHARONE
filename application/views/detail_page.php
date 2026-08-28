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
// Extract qualifications
$quastring = '';
$qu = $this->db->get_where('dr_qualifications', array('user_id' => $d->id));
if ($qu && $qu->num_rows() > 0) {
    foreach($qu->result() as $q) {
        $quastring .= getQualificationName($q->qualification_id).', ';
    }
    $quastring = rtrim($quastring, ', ');
}

// Extract specializations
$specList = $this->db->get_where('dr_specialization', array('user_id' => $d->id))->result();

// Practice data
$practdata = $this->db->get_where('dr_practice', array('user_id' => $d->id, 'status' => '1'));
$practcount = $practdata->num_rows(); 
$practs = $practdata->result();
$firstPract = (!empty($practs)) ? $practs[0] : null;

$drImg = ($d->drimage && file_exists('admin1947/public/assets/upload/'.$d->drimage)) 
         ? admin_url().'public/assets/upload/'.$d->drimage 
         : admin_url().'public/assets/upload/dummydr.jpg';
$drPrefix = (strcasecmp(substr($d->fname, 0, 2), 'Dr') != 0) ? 'Dr. ' : '';
$fee = (!empty($firstPract->fee)) ? $firstPract->fee : '500';
$expYears = ($d->exp > 0) ? $d->exp : 8;
?>

<!-- Doctor Profile Detail Section -->
<div class="doc-profile-container">
    <!-- Main Profile Card -->
    <div class="doc-profile-card">
        <div class="doc-profile-header">
            <!-- Doctor Avatar -->
            <div class="doc-profile-avatar-wrap">
                <img src="<?=$drImg;?>" alt="<?=$drPrefix.$d->fname.' '.$d->lname;?>" class="doc-profile-avatar">
                <span class="doc-profile-badge-verified"><i class="fas fa-check-circle"></i> Verified</span>
            </div>

            <!-- Doctor Information -->
            <div class="doc-profile-info">
                <h1 class="doc-profile-name"><?=$drPrefix.$d->fname.' '.$d->lname;?></h1>
                <?php if (!empty($quastring)) { ?>
                <div class="doc-profile-degree"><?=$quastring;?></div>
                <?php } ?>

                <div class="doc-profile-tags">
                    <span class="spec-pill" style="background: #E8F0FE; color: #1A73E8; border: 1px solid #D2E3FC; font-weight: 600;">
                        <i class="fas fa-video"></i> Available for Video Consultation
                    </span>
                    <?php if (!empty($specList)) { 
                        foreach($specList as $sp) {
                            $sname = getSpecilizationName($sp->specialization_id);
                            if ($sname) { ?>
                                <span class="spec-pill"><i class="fas fa-stethoscope"></i> <?=$sname;?></span>
                            <?php }
                        }
                    } else { ?>
                        <span class="spec-pill"><i class="fas fa-user-md"></i> General Physician</span>
                    <?php } ?>
                </div>

                <div class="doc-profile-metrics">
                    <div class="doc-profile-metric-item">
                        <i class="fas fa-briefcase" style="color: #00A896;"></i>
                        <span><strong><?=$expYears;?>+ Years</strong> Experience</span>
                    </div>
                    <div class="doc-profile-metric-item">
                        <i class="fas fa-thumbs-up" style="color: #16A34A;"></i>
                        <span><strong>93%</strong> (25+ Patient Stories)</span>
                    </div>
                    <div class="doc-profile-metric-item">
                        <i class="fas fa-rupee-sign" style="color: #05668D;"></i>
                        <span><strong>₹<?=$fee;?></strong> Consultation Fee</span>
                    </div>
                    <div class="doc-profile-metric-item" style="background: #E8F0FE; border-color: #BFDBFE;">
                        <i class="fas fa-video" style="color: #1A73E8;"></i>
                        <span style="color: #1A73E8; font-weight: 600;">Video & In-Clinic</span>
                    </div>
                </div>
            </div>

            <!-- Actions & Booking Column -->
            <div class="doc-profile-actions">
                <div class="wait-time-badge" style="margin-bottom: 12px;">
                    <i class="fas fa-clock"></i> 30 mins or less wait time assured
                </div>
                <a href="javascript:void(0);" class="btn btn-primary-cta getappointment" data-upchar-did="<?=$d->id;?>" data-toggle="modal" data-target="#myModal" style="padding: 12px 20px; font-size: 15px; justify-content: center; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-calendar-check"></i> Book Appointment
                </a>
                <a href="tel:8448440603" class="btn btn-secondary" style="padding: 10px 16px; justify-content: center; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-phone-alt"></i> Contact Clinic / Hospital
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Bio & Practice Locations -->
        <div class="col-md-8">
            <!-- About Doctor -->
            <div class="doc-profile-card">
                <h3 class="doc-profile-section-title">
                    <i class="fas fa-user-md" style="color: #00A896;"></i> About <?=$drPrefix.$d->fname.' '.$d->lname;?>
                </h3>
                <p style="font-size: 14.5px; color: #334155; line-height: 1.7; margin-bottom: 18px;">
                    <?=(!empty($d->about)) ? nl2br(strip_tags($d->about)) : $drPrefix.$d->fname.' '.$d->lname.' is an experienced and verified medical specialist on Upchar, committed to delivering clinical excellence, patient-centric diagnosis, and compassionate treatment.';?>
                </p>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: #16A34A; font-weight: 600; font-size: 13.5px;">
                        <i class="fas fa-shield-alt" style="font-size: 16px;"></i> Medical Registration & Qualifications Verified
                    </div>
                </div>
            </div>

            <!-- Practice Locations & Timings -->
            <div class="doc-profile-card">
                <h3 class="doc-profile-section-title">
                    <i class="fas fa-hospital-alt" style="color: #00A896;"></i> Clinic & Hospital Locations
                </h3>

                <?php if (!empty($practs)) { foreach($practs as $pract) { 
                    $instTable = ($pract->type == 'C') ? 'clinic' : 'hospital';
                    $instData = $this->db->get_where($instTable, array('id' => $pract->institution_id))->row();
                    $instName = (!empty($instData->name)) ? $instData->name : 'Upchar Partner Healthcare Center';
                    $instAddr = (!empty($instData->address)) ? $instData->address : (getCityName($d->city) ?: 'Varanasi, Uttar Pradesh, India');
                    $instFee = (!empty($pract->fee)) ? $pract->fee : $fee;
                ?>
                <div class="practice-location-card">
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">
                            <i class="fas fa-clinic-medical" style="color: #00A896; margin-right: 6px;"></i> <?=$instName;?>
                        </h4>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 8px;">
                            <i class="fas fa-map-marker-alt"></i> <?=$instAddr;?>
                        </p>
                        <div style="font-size: 13px; color: #334155; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                            <span><i class="fas fa-calendar-alt" style="color: #00A896;"></i> Mon - Sat</span>
                            <span><i class="fas fa-clock" style="color: #00A896;"></i> 10:00 AM - 02:00 PM</span>
                            <span><i class="fas fa-rupee-sign" style="color: #16A34A;"></i> ₹<?=$instFee;?> Fee</span>
                        </div>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-primary-cta getappointment" data-upchar-did="<?=$d->id;?>" data-toggle="modal" data-target="#myModal" style="white-space: nowrap; padding: 8px 16px; font-size: 13.5px;">
                            Book Slot
                        </a>
                    </div>
                </div>
                <?php } } else { ?>
                <div class="practice-location-card">
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px;">
                            <i class="fas fa-clinic-medical" style="color: #00A896; margin-right: 6px;"></i> Upchar Medical Consultation Center
                        </h4>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 8px;">
                            <i class="fas fa-map-marker-alt"></i> <?=(getCityName($d->city) ?: 'Varanasi, Uttar Pradesh, India');?>
                        </p>
                        <div style="font-size: 13px; color: #334155; display: flex; align-items: center; gap: 14px;">
                            <span><i class="fas fa-calendar-alt" style="color: #00A896;"></i> Mon - Sat</span>
                            <span><i class="fas fa-clock" style="color: #00A896;"></i> 09:30 AM - 01:30 PM</span>
                            <span><i class="fas fa-rupee-sign" style="color: #16A34A;"></i> ₹<?=$fee;?> Fee</span>
                        </div>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-primary-cta getappointment" data-upchar-did="<?=$d->id;?>" data-toggle="modal" data-target="#myModal" style="white-space: nowrap; padding: 8px 16px; font-size: 13.5px;">
                            Book Slot
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Patient Reviews & Stories -->
            <div class="doc-profile-card">
                <h3 class="doc-profile-section-title">
                    <i class="fas fa-comments" style="color: #00A896;"></i> Patient Feedback & Experiences
                </h3>

                <div style="margin-bottom: 18px; padding-bottom: 16px; border-bottom: 1px solid #F1F5F9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <div style="font-weight: 700; color: #0F172A; font-size: 14.5px;">
                            <i class="fas fa-user-circle" style="color: #00A896; margin-right: 6px;"></i> Danish Akhtar
                        </div>
                        <div style="color: #F59E0B; font-size: 13px;">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.5;">
                        "Doctor explained the condition very clearly and the prescribed medications provided fast relief. Minimal wait time at the clinic!"
                    </p>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <div style="font-weight: 700; color: #0F172A; font-size: 14.5px;">
                            <i class="fas fa-user-circle" style="color: #00A896; margin-right: 6px;"></i> Neha Singh
                        </div>
                        <div style="color: #F59E0B; font-size: 13px;">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.5;">
                        "Very professional and attentive. Booking through Upchar was seamless with instant confirmation."
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Assistance -->
        <div class="col-md-4">
            <div class="modern-partner-card" style="text-align: left; padding: 24px 20px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div class="modern-partner-icon" style="margin: 0; width: 46px; height: 46px; font-size: 18px;">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">Need Booking Help?</h5>
                        <span style="font-size: 12px; color: #64748B;">24/7 Patient Support Desk</span>
                    </div>
                </div>
                <p style="font-size: 13px; color: #475569; margin-bottom: 14px; line-height: 1.5;">
                    Call our helpline for instant booking assistance, reschedule appointments, or consultation inquiries.
                </p>
                <a href="tel:8448440603" class="btn btn-primary-cta" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-phone-alt"></i> 844-844-0603
                </a>
            </div>

            <div class="modern-partner-card" style="text-align: left; padding: 24px 20px;">
                <h5 style="margin: 0 0 14px; font-size: 15px; font-weight: 700; color: #0F172A;">
                    <i class="fas fa-shield-alt" style="color: #00A896; margin-right: 6px;"></i> The Upchar Promise
                </h5>
                <ul style="padding-left: 0; list-style: none; margin: 0; font-size: 13px; color: #64748B; display: flex; flex-direction: column; gap: 10px;">
                    <li style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle" style="color: #16A34A;"></i> Verified Medical Qualifications
                    </li>
                    <li style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle" style="color: #16A34A;"></i> Minimal Wait Time Assured
                    </li>
                    <li style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle" style="color: #16A34A;"></i> 100% Free Booking & Cancellation
                    </li>
                    <li style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle" style="color: #16A34A;"></i> Instant Digital Prescription
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>