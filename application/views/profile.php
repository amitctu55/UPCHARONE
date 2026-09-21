<?php 
// Safely extract properties with fallback defaults
$userObj = !empty($user) ? $user : (!empty($data) && is_object($data) ? $data : null);

function get_prop($obj, $prop) {
    if (!$obj || !is_object($obj)) return '';
    $u = strtoupper($prop);
    $l = strtolower($prop);
    if (isset($obj->$u)) return trim((string)$obj->$u);
    if (isset($obj->$l)) return trim((string)$obj->$l);
    if (isset($obj->$prop)) return trim((string)$obj->$prop);
    return '';
}

$fname   = get_prop($userObj, 'FNAME');
$lname   = get_prop($userObj, 'LNAME');
$email   = get_prop($userObj, 'EMAIL');
$mobile  = get_prop($userObj, 'MOBILE');
$dob     = get_prop($userObj, 'DOB');
$gender  = get_prop($userObj, 'GENDER');
$bgroup  = get_prop($userObj, 'BGROUP');
$height  = get_prop($userObj, 'HEIGHT');
$weight  = get_prop($userObj, 'WEIGHT');
$image   = get_prop($userObj, 'IMAGE') ?: get_prop($userObj, 'PROFILEIMG');
$userid  = get_prop($userObj, 'USERID') ?: ($this->session->userdata('userid') ?: 0);

$displayName = !empty($fname) ? $fname : (!empty($this->session->userdata('username')) ? $this->session->userdata('username') : 'Valued Patient');
if (!empty($lname) && stripos($displayName, $lname) === false) {
    $displayName .= ' ' . $lname;
}

// Check if user has minimum profile filled
$hasProfileData = (!empty($fname) || !empty($email) || !empty($mobile));

// Dependents list
$dep_list = !empty($dependents) ? $dependents : [];
$dep_count = count($dep_list);

// BMI calculation
$bmi = null;
$bmiLabel = '';
$bmiColor = '#10b981';
if (!empty($height) && !empty($weight)) {
    preg_match('/(\d+(\.\d+)?)/', $height, $h_m);
    preg_match('/(\d+(\.\d+)?)/', $weight, $w_m);
    if (!empty($h_m[1]) && !empty($w_m[1])) {
        $h_val = floatval($h_m[1]);
        $w_val = floatval($w_m[1]);
        $h_mtr = ($h_val > 50) ? ($h_val / 100) : ($h_val * 0.3048);
        if ($h_mtr > 0.5) {
            $bmi = round($w_val / ($h_mtr * $h_mtr), 1);
            if ($bmi < 18.5) { $bmiLabel = 'Underweight'; $bmiColor = '#f59e0b'; }
            elseif ($bmi <= 24.9) { $bmiLabel = 'Normal'; $bmiColor = '#10b981'; }
            elseif ($bmi <= 29.9) { $bmiLabel = 'Overweight'; $bmiColor = '#f97316'; }
            else { $bmiLabel = 'Obese'; $bmiColor = '#ef4444'; }
        }
    }
}
?>

<style>
/* ==========================================================
   COMPACT FULL-STACK DEVELOPER PATIENT PROFILE DASHBOARD
   Ultra-clean, High-density, Space-efficient
   ========================================================== */
.prof-container {
    max-width: 1140px;
    margin: 0 auto;
}

/* Compact Header Bar */
.prof-compact-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}

.prof-user-strip {
    display: flex;
    align-items: center;
    gap: 14px;
}

.prof-avatar-sm {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #00a896;
    color: #ffffff;
    font-size: 19px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
}

.prof-name-title {
    font-size: 17px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 2px 0;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.prof-badge-verified {
    font-size: 11px;
    font-weight: 700;
    color: #059669;
    background: #ecfdf5;
    padding: 2px 8px;
    border-radius: 6px;
    border: 1px solid #a7f3d0;
}

.prof-id-pill {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    background: #f1f5f9;
    padding: 2px 7px;
    border-radius: 4px;
}

.prof-meta-line {
    font-size: 12.5px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-top: 2px;
}

.prof-meta-line span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Header Buttons */
.prof-header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-prof-sm {
    height: 34px;
    padding: 0 14px;
    font-size: 12.5px;
    font-weight: 600;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.15s ease;
    border: 1px solid transparent;
}

.btn-prof-primary {
    background: #00a896;
    color: #ffffff;
}
.btn-prof-primary:hover {
    background: #028072;
    color: #ffffff;
}

.btn-prof-outline {
    background: #ffffff;
    border-color: #cbd5e1;
    color: #334155;
}
.btn-prof-outline:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #94a3b8;
}

/* Compact Nav Tabs */
.prof-nav-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 14px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 2px;
}

.prof-tab-btn {
    background: transparent;
    border: none;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.15s ease;
}

.prof-tab-btn:hover {
    color: #0f172a;
    background: #f1f5f9;
}

.prof-tab-btn.active {
    color: #00a896;
    background: #f0fdfa;
    font-weight: 700;
}

.prof-tab-badge {
    background: #e2e8f0;
    color: #475569;
    font-size: 11px;
    padding: 1px 6px;
    border-radius: 10px;
    font-weight: 700;
}

.prof-tab-btn.active .prof-tab-badge {
    background: #00a896;
    color: #ffffff;
}

/* Compact Cards */
.prof-compact-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.prof-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f5f9;
}

.prof-card-head h4 {
    margin: 0;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Compact Info Grid */
.prof-grid-compact {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px 14px;
}

@media (max-width: 991px) {
    .prof-grid-compact { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 575px) {
    .prof-grid-compact { grid-template-columns: 1fr; }
}

.prof-cell {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 8px;
    padding: 10px 12px;
}

.prof-cell-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #64748b;
    margin-bottom: 2px;
}

.prof-cell-val {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 6px;
}

.prof-cell-val.empty {
    color: #94a3b8;
    font-weight: 500;
    font-style: italic;
    font-size: 12.5px;
}

/* Compact Form Controls */
.prof-form-label {
    font-size: 12px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 4px;
    display: block;
}

.prof-input {
    height: 36px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    padding: 6px 10px;
    color: #0f172a;
    width: 100%;
    background-color: #ffffff;
    transition: border-color 0.15s ease;
}

.prof-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.15);
}

/* Compact Gender Selector */
.prof-gender-group {
    display: flex;
    gap: 6px;
}

.prof-gender-btn {
    flex: 1;
    position: relative;
}

.prof-gender-btn input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.prof-gender-btn label {
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background: #f8fafc;
    font-size: 12.5px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    margin: 0;
    transition: all 0.15s ease;
}

.prof-gender-btn input:checked + label {
    background: #f0fdfa;
    border-color: #00a896;
    color: #00a896;
    font-weight: 700;
}

/* Compact Dependents Table */
.prof-table-compact {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.prof-table-compact th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    padding: 8px 12px;
    border-bottom: 1.5px solid #e2e8f0;
    text-align: left;
    font-size: 11.5px;
    text-transform: uppercase;
}

.prof-table-compact td {
    padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    vertical-align: middle;
}

.prof-table-compact tr:hover td {
    background: #f8fafc;
}

/* Compact Inline Panel */
.dep-inline-box {
    display: none;
    background: #f0fdfa;
    border: 1px solid #99f6e4;
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 14px;
}
</style>

<div class="prof-container">

    <!-- Flash Alert -->
    <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 12px;">
            <?=$this->session->flashdata('flashmsg');?>
        </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 1. COMPACT USER STRIP & ACTION HEADER                   -->
    <!-- ======================================================== -->
    <div class="prof-compact-header">
        
        <div class="prof-user-strip">
            <div class="prof-avatar-sm">
                <?=strtoupper(substr($displayName, 0, 1));?>
            </div>
            <div>
                <div class="prof-name-title">
                    <span><?=html_escape($displayName);?></span>
                    <span class="prof-badge-verified"><i class="fa fa-check-circle"></i> Verified</span>
                    <span class="prof-id-pill">UPC-<?=str_pad($userid ?: '1', 5, '0', STR_PAD_LEFT);?></span>
                </div>
                <div class="prof-meta-line">
                    <span><i class="fa fa-envelope-o" style="color: #00a896;"></i> <?=html_escape(!empty($email) ? $email : 'No email added');?></span>
                    <span><i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape(!empty($mobile) ? $mobile : 'No mobile added');?></span>
                    <?php if(!empty($bgroup)): ?>
                        <span><i class="fa fa-tint" style="color: #ef4444;"></i> Blood: <strong><?=html_escape($bgroup);?></strong></span>
                    <?php endif; ?>
                    <?php if($bmi !== null): ?>
                        <span><i class="fa fa-heartbeat" style="color: <?=$bmiColor;?>;"></i> BMI: <strong><?=$bmi;?></strong> (<?=$bmiLabel;?>)</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="prof-header-actions">
            <button type="button" id="profTopEditBtn" onclick="toggleEditMode(true)" class="btn-prof-sm btn-prof-primary">
                <i class="fa fa-pencil"></i> Edit Profile
            </button>
            <a href="<?=base_url('updateprofile');?>" class="btn-prof-sm btn-prof-outline" title="Update Profile Picture">
                <i class="fa fa-camera"></i> Photo
            </a>
            <a href="<?=base_url('change_password');?>" class="btn-prof-sm btn-prof-outline" title="Change Login Password">
                <i class="fa fa-lock"></i> Password
            </a>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 2. COMPACT NAVIGATION TABS                               -->
    <!-- ======================================================== -->
    <div class="prof-nav-tabs">
        <button type="button" class="prof-tab-btn active" id="tabBtnProfile" onclick="switchProfTab('profile')">
            <i class="fa fa-user-circle-o"></i> Personal &amp; Medical Info
        </button>
        <button type="button" class="prof-tab-btn" id="tabBtnDependents" onclick="switchProfTab('dependents')">
            <i class="fa fa-users"></i> Family Dependents
            <span class="prof-tab-badge"><?=$dep_count;?></span>
        </button>
    </div>

    <!-- ======================================================== -->
    <!-- TAB 1: PERSONAL & MEDICAL DETAILS                        -->
    <!-- ======================================================== -->
    <div id="profTabProfileContent">
        
        <div class="prof-compact-card">
            
            <div class="prof-card-head">
                <h4>
                    <i class="fa fa-id-card-o" style="color: #00a896;"></i> 
                    <span id="profCardTitle">Patient Information</span>
                </h4>
                <div>
                    <button type="button" id="profInlineEditBtn" onclick="toggleEditMode(true)" class="btn-prof-sm btn-prof-outline">
                        <i class="fa fa-pencil" style="color: #00a896;"></i> Edit Details
                    </button>
                    <span id="profEditingBadge" style="display: none; background: #fef3c7; color: #b45309; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 4px; border: 1px solid #fde68a;">
                        <i class="fa fa-pencil"></i> Editing Mode Active
                    </span>
                </div>
            </div>

            <!-- VIEW MODE (Compact Grid) -->
            <div id="profViewBox" style="<?=!$hasProfileData ? 'display: none;' : '';?>">
                <div class="prof-grid-compact">
                    
                    <div class="prof-cell">
                        <div class="prof-cell-label">Full Name</div>
                        <div class="prof-cell-val">
                            <?=!empty($fname) ? html_escape($fname) : '<span class="empty">Not provided</span>';?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Email Address</div>
                        <div class="prof-cell-val">
                            <?php if(!empty($email)): ?>
                                <?=html_escape($email);?>
                                <span style="color: #16a34a; font-size: 11px;"><i class="fa fa-check-circle"></i></span>
                            <?php else: ?>
                                <span class="empty">Not registered</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Mobile Number</div>
                        <div class="prof-cell-val">
                            <?php if(!empty($mobile)): ?>
                                <?=html_escape($mobile);?>
                                <span style="color: #0284c7; font-size: 11px;"><i class="fa fa-mobile"></i></span>
                            <?php else: ?>
                                <span class="empty">Not registered</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Date of Birth</div>
                        <div class="prof-cell-val">
                            <?=!empty($dob) ? date('d M, Y', strtotime($dob)) : '<span class="empty">Not specified</span>';?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Gender</div>
                        <div class="prof-cell-val">
                            <?php 
                                if ($gender === 'M' || $gender === 'Male') echo '<i class="fa fa-mars" style="color: #0284c7;"></i> Male';
                                elseif ($gender === 'F' || $gender === 'Female') echo '<i class="fa fa-venus" style="color: #ec4899;"></i> Female';
                                elseif (!empty($gender)) echo html_escape($gender);
                                else echo '<span class="empty">Not specified</span>';
                            ?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Blood Group</div>
                        <div class="prof-cell-val">
                            <?php if(!empty($bgroup)): ?>
                                <span style="color: #dc2626; font-weight: 800; background: #fee2e2; padding: 1px 7px; border-radius: 4px;">
                                    <i class="fa fa-tint"></i> <?=html_escape($bgroup);?>
                                </span>
                            <?php else: ?>
                                <span class="empty">Not set</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Height</div>
                        <div class="prof-cell-val">
                            <?=!empty($height) ? html_escape($height) : '<span class="empty">Not provided</span>';?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Weight</div>
                        <div class="prof-cell-val">
                            <?=!empty($weight) ? html_escape($weight) : '<span class="empty">Not provided</span>';?>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 14px; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <span style="font-size: 12px; color: #64748b;">
                        <i class="fa fa-shield" style="color: #00a896;"></i> Data encrypted &amp; shared only with your treating doctors.
                    </span>
                    <button type="button" onclick="toggleEditMode(true)" class="btn-prof-sm btn-prof-primary">
                        <i class="fa fa-pencil"></i> Edit Details
                    </button>
                </div>
            </div>

            <!-- EDIT MODE (Compact Form) -->
            <div id="profEditBox" style="<?=$hasProfileData ? 'display: none;' : '';?>">
                <form action="<?=base_url('profile');?>" method="post" id="profForm">
                    <?php if ($this->config->item('csrf_protection')): ?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <?php endif; ?>
                    <input type="hidden" name="action" value="update_profile">

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="prof-input" name="name" placeholder="Full name" required value="<?=html_escape($fname);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Email Address <span style="color: #ef4444;">*</span></label>
                            <input type="email" class="prof-input" name="email" placeholder="patient@example.com" required value="<?=html_escape($email);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Mobile Number <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="prof-input" name="mobile" placeholder="10-digit mobile" required value="<?=html_escape($mobile);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Date of Birth</label>
                            <input type="date" class="prof-input" name="dob" value="<?=html_escape($dob);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Gender</label>
                            <div class="prof-gender-group">
                                <div class="prof-gender-btn">
                                    <input type="radio" name="gender" id="g_m" value="M" <?=($gender == 'M' || $gender == 'Male') ? 'checked' : '';?>>
                                    <label for="g_m"><i class="fa fa-mars"></i> Male</label>
                                </div>
                                <div class="prof-gender-btn">
                                    <input type="radio" name="gender" id="g_f" value="F" <?=($gender == 'F' || $gender == 'Female') ? 'checked' : '';?>>
                                    <label for="g_f"><i class="fa fa-venus"></i> Female</label>
                                </div>
                                <div class="prof-gender-btn">
                                    <input type="radio" name="gender" id="g_o" value="O" <?=($gender == 'O' || $gender == 'Other') ? 'checked' : '';?>>
                                    <label for="g_o">Other</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Blood Group</label>
                            <select class="prof-input" name="bgroup">
                                <option value="">-- Select --</option>
                                <?php 
                                    $bg_items = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                    foreach ($bg_items as $bg):
                                ?>
                                    <option value="<?=$bg;?>" <?=(strtoupper(trim($bgroup)) === $bg) ? 'selected' : '';?>><?=$bg;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Height</label>
                            <input type="text" class="prof-input" name="height" placeholder="e.g. 175 cm / 5'9&quot;" value="<?=html_escape($height);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Weight</label>
                            <input type="text" class="prof-input" name="weight" placeholder="e.g. 68 kg" value="<?=html_escape($weight);?>">
                        </div>
                    </div>

                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; align-items: center; gap: 8px;">
                        <?php if($hasProfileData): ?>
                            <button type="button" onclick="toggleEditMode(false)" class="btn-prof-sm btn-prof-outline">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        <?php endif; ?>
                        <button type="submit" name="submit" value="1" class="btn-prof-sm btn-prof-primary">
                            <i class="fa fa-check"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- TAB 2: FAMILY DEPENDENTS                                 -->
    <!-- ======================================================== -->
    <div id="profTabDependentsContent" style="display: none;">
        
        <div class="prof-compact-card">
            <div class="prof-card-head">
                <h4>
                    <i class="fa fa-users" style="color: #00a896;"></i> 
                    Family Members &amp; Dependents
                </h4>
                <button type="button" id="depAddTriggerBtn" onclick="toggleDepAddForm()" class="btn-prof-sm btn-prof-primary">
                    <i class="fa fa-plus" id="depAddIcon"></i> <span id="depAddText">Add Member</span>
                </button>
            </div>

            <!-- Inline Add Dependent Form -->
            <div class="dep-inline-box" id="depAddBox">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <strong style="font-size: 13.5px; color: #0f172a;"><i class="fa fa-user-plus" style="color: #00a896;"></i> New Family Dependent</strong>
                    <button type="button" onclick="toggleDepAddForm()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
                </div>

                <form action="<?=base_url('profile');?>" method="post">
                    <?php if ($this->config->item('csrf_protection')): ?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <?php endif; ?>
                    <input type="hidden" name="action" value="add_dependent">

                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 10px;">
                            <label class="prof-form-label">Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="prof-input" name="dep_name" placeholder="Member's name" required>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 10px;">
                            <label class="prof-form-label">Relationship <span style="color: #ef4444;">*</span></label>
                            <select class="prof-input" name="dep_rel" required>
                                <option value="SPOUSE">Spouse</option>
                                <option value="CHILD">Child</option>
                                <option value="PARENT">Parent</option>
                                <option value="SIBLING">Sibling</option>
                                <option value="OTHER">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 10px;">
                            <label class="prof-form-label">Gender</label>
                            <select class="prof-input" name="dep_gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 10px;">
                            <label class="prof-form-label">Date of Birth</label>
                            <input type="date" class="prof-input" name="dep_dob">
                        </div>
                        <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 10px;">
                            <label class="prof-form-label">Blood Group</label>
                            <input type="text" class="prof-input" name="dep_bgroup" placeholder="e.g. B+, O+">
                        </div>
                        <div class="col-md-4 col-sm-6 col-12" style="margin-bottom: 10px;">
                            <label class="prof-form-label">Medical Notes / Allergies</label>
                            <input type="text" class="prof-input" name="dep_history" placeholder="e.g. Asthma, Penicillin allergy">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 6px;">
                        <button type="button" onclick="toggleDepAddForm()" class="btn-prof-sm btn-prof-outline">Cancel</button>
                        <button type="submit" class="btn-prof-sm btn-prof-primary"><i class="fa fa-check"></i> Save Member</button>
                    </div>
                </form>
            </div>

            <!-- Dependents Table or Empty State -->
            <?php if (!empty($dep_list)): ?>
                <div style="overflow-x: auto;">
                    <table class="prof-table-compact">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Relation</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Blood</th>
                                <th>Medical Notes</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dep_list as $dep): ?>
                            <tr>
                                <td>
                                    <strong><?=html_escape($dep->name);?></strong>
                                </td>
                                <td>
                                    <span style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                                        <?=html_escape($dep->relationship);?>
                                    </span>
                                </td>
                                <td><?=($dep->gender == 'F') ? 'Female' : 'Male';?></td>
                                <td><?=!empty($dep->dob) ? date('d M, Y', strtotime($dep->dob)) : '-';?></td>
                                <td>
                                    <?=!empty($dep->blood_group) ? '<strong style="color: #dc2626;">'.html_escape($dep->blood_group).'</strong>' : '-';?>
                                </td>
                                <td>
                                    <?=!empty($dep->medical_history) ? html_escape($dep->medical_history) : '<span style="color: #94a3b8;">None</span>';?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="<?=base_url('profile?del_dep='.$dep->id);?>" onclick="return confirm('Remove this dependent?');" class="btn-prof-sm" style="background: #fee2e2; color: #ef4444; padding: 4px 8px; height: 28px;" title="Remove">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 24px; color: #64748b; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px;">
                    <i class="fa fa-users" style="font-size: 24px; color: #94a3b8; margin-bottom: 6px; display: block;"></i>
                    <span style="font-size: 13px;">No family dependents linked yet.</span>
                    <div style="margin-top: 8px;">
                        <button type="button" onclick="toggleDepAddForm()" class="btn-prof-sm btn-prof-primary">
                            <i class="fa fa-plus"></i> Add Your First Family Member
                        </button>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

<!-- ======================================================== -->
<!-- 3. COMPACT INTERACTIVE SCRIPTS                           -->
<!-- ======================================================== -->
<script>
function switchProfTab(tabName) {
    var tabProfile = document.getElementById('profTabProfileContent');
    var tabDep     = document.getElementById('profTabDependentsContent');
    var btnProfile = document.getElementById('tabBtnProfile');
    var btnDep     = document.getElementById('tabBtnDependents');

    if (tabName === 'dependents') {
        tabProfile.style.display = 'none';
        tabDep.style.display     = 'block';
        btnProfile.classList.remove('active');
        btnDep.classList.add('active');
    } else {
        tabProfile.style.display = 'block';
        tabDep.style.display     = 'none';
        btnProfile.classList.add('active');
        btnDep.classList.remove('active');
    }
}

function toggleEditMode(enable) {
    var viewBox   = document.getElementById('profViewBox');
    var editBox   = document.getElementById('profEditBox');
    var badge     = document.getElementById('profEditingBadge');
    var inlineBtn = document.getElementById('profInlineEditBtn');
    var topBtn    = document.getElementById('profTopEditBtn');
    var title     = document.getElementById('profCardTitle');

    // Make sure we are on the profile tab
    switchProfTab('profile');

    if (enable) {
        if (viewBox) viewBox.style.display = 'none';
        if (editBox) editBox.style.display = 'block';
        if (badge) badge.style.display = 'inline-block';
        if (inlineBtn) inlineBtn.style.display = 'none';
        if (title) title.innerText = 'Edit Patient Information';
        if (topBtn) {
            topBtn.innerHTML = '<i class="fa fa-times"></i> Cancel Edit';
            topBtn.onclick = function() { toggleEditMode(false); };
            topBtn.className = 'btn-prof-sm btn-prof-outline';
        }
        var nameInp = editBox.querySelector('input[name="name"]');
        if (nameInp) nameInp.focus();
    } else {
        if (viewBox) viewBox.style.display = 'block';
        if (editBox) editBox.style.display = 'none';
        if (badge) badge.style.display = 'none';
        if (inlineBtn) inlineBtn.style.display = 'inline-flex';
        if (title) title.innerText = 'Patient Information';
        if (topBtn) {
            topBtn.innerHTML = '<i class="fa fa-pencil"></i> Edit Profile';
            topBtn.onclick = function() { toggleEditMode(true); };
            topBtn.className = 'btn-prof-sm btn-prof-primary';
        }
    }
}

function toggleDepAddForm() {
    var box  = document.getElementById('depAddBox');
    var icon = document.getElementById('depAddIcon');
    var text = document.getElementById('depAddText');

    if (box.style.display === 'none' || box.style.display === '') {
        box.style.display = 'block';
        if (icon) icon.className = 'fa fa-times';
        if (text) text.innerText = 'Cancel';
        var inp = box.querySelector('input[name="dep_name"]');
        if (inp) inp.focus();
    } else {
        box.style.display = 'none';
        if (icon) icon.className = 'fa fa-plus';
        if (text) text.innerText = 'Add Member';
    }
}

// Auto open edit mode if URL has ?edit=1
document.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('edit') === '1') {
        toggleEditMode(true);
    } else if (urlParams.get('tab') === 'dependents') {
        switchProfTab('dependents');
    }
});
</script>