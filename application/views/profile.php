<?php 
// Safely extract properties with fallback defaults
$userObj = !empty($user) ? $user : (!empty($data) && is_object($data) ? $data : null);

if (!function_exists('get_prop')) {
function get_prop($obj, $prop) {
    if (!$obj || !is_object($obj)) return '';
    $u = strtoupper($prop);
    $l = strtolower($prop);
    if (isset($obj->$u)) return trim((string)$obj->$u);
    if (isset($obj->$l)) return trim((string)$obj->$l);
    if (isset($obj->$prop)) return trim((string)$obj->$prop);
    return '';
}
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

$fullName = trim($fname . ' ' . $lname);
if (empty($fullName)) {
    $fullName = !empty($fname) ? $fname : (!empty($this->session->userdata('username')) ? $this->session->userdata('username') : '');
}
$displayName = !empty($fullName) ? $fullName : 'Valued Patient';

// Check if user has minimum profile filled
$hasProfileData = (!empty($fname) || !empty($email) || !empty($mobile));

// Dependents list
$dep_list = !empty($dependents) ? $dependents : [];
$dep_count = count($dep_list);

// Comprehensive Clinical Health Goals & BMR Calculation
if (empty($health_goals) && (!empty($height) && !empty($weight))) {
    preg_match('/(\d+(\.\d+)?)/', (string)$height, $h_m);
    preg_match('/(\d+(\.\d+)?)/', (string)$weight, $w_m);
    if (!empty($h_m[1]) && !empty($w_m[1])) {
        $h_val = floatval($h_m[1]);
        $w_val = floatval($w_m[1]);
        $h_cm  = ($h_val < 10) ? round($h_val * 30.48, 1) : $h_val;
        $h_m_val = round($h_cm / 100, 2);
        
        if ($h_m_val >= 0.5 && $w_val > 0) {
            $calc_age = 30;
            $dob_fmt = '';
            if (!empty($dob)) {
                try {
                    $d_dt = new DateTime($dob);
                    $calc_age = (new DateTime())->diff($d_dt)->y;
                    $dob_fmt = $d_dt->format('M d, Y');
                } catch (\Throwable $e) { $calc_age = 30; }
            }

            $calc_bmi = round($w_val / ($h_m_val * $h_m_val), 1);
            if ($calc_bmi < 18.5) { $b_stat = 'Underweight'; $b_col = '#f59e0b'; $b_bg = 'warning'; }
            elseif ($calc_bmi <= 24.9) { $b_stat = 'Normal'; $b_col = '#10b981'; $b_bg = 'success'; }
            elseif ($calc_bmi <= 29.9) { $b_stat = 'Overweight'; $b_col = '#f97316'; $b_bg = 'warning'; }
            else { $b_stat = 'Obese'; $b_col = '#ef4444'; $b_bg = 'danger'; }

            $is_fem = in_array(strtoupper(trim($gender ?: 'F')), array('F', 'FEMALE'));
            if ($is_fem) {
                $calc_bmr = round((10 * $w_val) + (6.25 * $h_cm) - (5 * $calc_age) - 161);
            } else {
                $calc_bmr = round((10 * $w_val) + (6.25 * $h_cm) - (5 * $calc_age) + 5);
            }

            $t_min  = round(18.5 * ($h_m_val * $h_m_val), 1);
            $t_opt  = round(21.0 * ($h_m_val * $h_m_val), 1);
            $t_max  = round(24.9 * ($h_m_val * $h_m_val), 1);
            $maint_cal = round($calc_bmr * 1.2);

            if ($calc_bmi < 18.5) {
                $g_act = 'gain';
                $m_gain = round($t_min - $w_val, 1);
                if ($m_gain <= 0) $m_gain = 0.5;
                $opt_gain = round($t_opt - $w_val, 1);
                $tgt_cal = $maint_cal + 400;
                $summ = "Your Basal Metabolic Rate (BMR) is {$calc_bmr} kcal/day, meaning your body burns approximately {$calc_bmr} calories at rest. To reach a minimum healthy BMI of 18.5, aim to gain at least {$m_gain} kg (with an optimal target of {$opt_gain} kg for a BMI of 21.0). We recommend a gentle daily calorie surplus of +300 to +500 kcal (targeting ~{$tgt_cal} kcal/day) focusing on nutrient-dense proteins and healthy fats.";
                $cal_rec = "+300 to +500 kcal/day surplus (Target: ~" . number_format($tgt_cal) . " kcal/day)";
            } elseif ($calc_bmi > 24.9) {
                $g_act = 'lose';
                $m_loss = round($w_val - $t_max, 1);
                if ($m_loss <= 0) $m_loss = 0.5;
                $opt_loss = round($w_val - $t_opt, 1);
                $tgt_cal = max(1200, $maint_cal - 400);
                $summ = "Your Basal Metabolic Rate (BMR) is {$calc_bmr} kcal/day, representing your baseline resting expenditure. To achieve a healthy BMI of 24.9, your initial goal is to lose {$m_loss} kg (with an ideal target of {$opt_loss} kg for optimal wellness). We recommend a moderate daily calorie deficit of 300 to 500 kcal (targeting ~{$tgt_cal} kcal/day) paired with regular low-impact physical activity.";
                $cal_rec = "-300 to -500 kcal/day deficit (Target: ~" . number_format($tgt_cal) . " kcal/day)";
            } else {
                $g_act = 'maintain';
                $summ = "Your Basal Metabolic Rate (BMR) is {$calc_bmr} kcal/day, and your current BMI of {$calc_bmi} is within the optimal healthy range. Continue your balanced nutrition and hydration to maintain your healthy weight. Aim for approximately " . number_format($maint_cal) . " kcal/day to sustain your daily energy needs.";
                $cal_rec = "Maintain ~" . number_format($maint_cal) . " kcal/day for energy balance";
            }

            $health_goals = array(
                'age'                    => $calc_age,
                'dob_formatted'          => $dob_fmt,
                'gender'                 => $is_fem ? 'Female' : 'Male',
                'height_cm'              => $h_cm,
                'height_m'               => $h_m_val,
                'weight_kg'              => $w_val,
                'bmi'                    => $calc_bmi,
                'bmi_status'             => $b_stat,
                'bmi_color'              => $b_col,
                'bmi_badge'              => $b_bg,
                'bmr'                    => $calc_bmr,
                'maintenance_calories'   => $maint_cal,
                'target_min_weight'      => $t_min,
                'target_ideal_weight'    => $t_opt,
                'target_max_weight'      => $t_max,
                'goal_action'            => $g_act,
                'min_gain'               => $calc_bmi < 18.5 ? $m_gain : 0,
                'ideal_gain'             => $calc_bmi < 18.5 ? $opt_gain : 0,
                'min_loss'               => $calc_bmi > 24.9 ? $m_loss : 0,
                'ideal_loss'             => $calc_bmi > 24.9 ? $opt_loss : 0,
                'summary_text'           => $summ,
                'caloric_recommendation' => $cal_rec
            );
        }
    }
}

$bmi = !empty($health_goals['bmi']) ? $health_goals['bmi'] : null;
$bmiLabel = !empty($health_goals['bmi_status']) ? $health_goals['bmi_status'] : '';
$bmiColor = !empty($health_goals['bmi_color']) ? $health_goals['bmi_color'] : '#10b981';
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
            <div class="prof-avatar-sm" id="header_avatar_char">
                <?=strtoupper(substr($displayName, 0, 1));?>
            </div>
            <div>
                <div class="prof-name-title">
                    <span id="header_display_name"><?=html_escape($displayName);?></span>
                    <span class="prof-badge-verified"><i class="fa fa-check-circle"></i> Verified</span>
                    <span class="prof-id-pill">UPC-<?=str_pad($userid ?: '1', 5, '0', STR_PAD_LEFT);?></span>
                </div>
                <div class="prof-meta-line">
                    <span id="header_email_span"><i class="fa fa-envelope-o" style="color: #00a896;"></i> <?=html_escape(!empty($email) ? $email : 'No email added');?></span>
                    <span id="header_mobile_span"><i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape(!empty($mobile) ? $mobile : 'No mobile added');?></span>
                    <?php if(!empty($bgroup)): ?>
                        <span><i class="fa fa-tint" style="color: #ef4444;"></i> Blood: <strong><?=html_escape($bgroup);?></strong></span>
                    <?php endif; ?>
                    <?php if(!empty($health_goals)): ?>
                        <span><i class="fa fa-heartbeat" style="color: <?=$health_goals['bmi_color'];?>;"></i> BMI: <strong><?=$health_goals['bmi'];?></strong> (<?=$health_goals['bmi_status'];?>)</span>
                        <span><i class="fa fa-fire" style="color: #f97316;"></i> BMR: <strong><?=number_format($health_goals['bmr']);?> kcal</strong></span>
                        <?php if($health_goals['goal_action'] === 'gain'): ?>
                            <span><i class="fa fa-arrow-up" style="color: #10b981;"></i> Goal: <strong>+<?=$health_goals['min_gain'];?> kg</strong></span>
                        <?php elseif($health_goals['goal_action'] === 'lose'): ?>
                            <span><i class="fa fa-arrow-down" style="color: #ef4444;"></i> Goal: <strong>-<?=$health_goals['min_loss'];?> kg</strong></span>
                        <?php endif; ?>
                    <?php elseif($bmi !== null): ?>
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
        <button type="button" class="prof-tab-btn" id="tabBtnNutrition" onclick="switchProfTab('nutrition')">
            <i class="fa fa-calculator"></i> Calorie &amp; Macro Calculator
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
                        <div class="prof-cell-val" id="view_fname">
                            <?=!empty($fullName) ? html_escape($fullName) : (!empty($fname) ? html_escape($fname) : '<span class="empty">Not provided</span>');?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Email Address</div>
                        <div class="prof-cell-val" id="view_email">
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
                        <div class="prof-cell-val" id="view_mobile">
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
                        <div class="prof-cell-val" id="view_dob">
                            <?=!empty($dob) ? date('d M, Y', strtotime($dob)) : '<span class="empty">Not specified</span>';?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Gender</div>
                        <div class="prof-cell-val" id="view_gender">
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
                        <div class="prof-cell-val" id="view_bgroup">
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
                        <div class="prof-cell-val" id="view_height">
                            <?=!empty($height) ? html_escape($height) : '<span class="empty">Not provided</span>';?>
                        </div>
                    </div>

                    <div class="prof-cell">
                        <div class="prof-cell-label">Weight</div>
                        <div class="prof-cell-val" id="view_weight">
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
                <!-- Inline Feedback Alert -->
                <div id="profEditAlert" style="display: none; margin-bottom: 12px;"></div>

                <form action="<?=base_url('profile');?>" method="post" id="profForm">
                    <?php 
                        $CI =& get_instance();
                        $csrfName = function_exists('config_item') && config_item('csrf_protection') ? (isset($CI->security) ? $CI->security->get_csrf_token_name() : 'csrf_test_name') : null;
                        $csrfHash = $csrfName && isset($CI->security) ? $CI->security->get_csrf_hash() : null;
                        if (!empty($csrfName) && !empty($csrfHash)): 
                    ?>
                        <input type="hidden" name="<?=$csrfName;?>" value="<?=$csrfHash;?>">
                    <?php endif; ?>
                    <input type="hidden" name="action" value="update_profile">
                    <input type="hidden" name="userid" value="<?=$userid;?>">

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="prof-input" name="name" id="inp_name" placeholder="Full name" required value="<?=html_escape(!empty($fullName) ? $fullName : $fname);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Email Address <span style="font-size: 11px; font-weight: 500; color: #64748b;">(or Mobile)</span></label>
                            <input type="email" class="prof-input" name="email" id="inp_email" placeholder="patient@example.com" value="<?=html_escape($email);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Mobile Number <span style="font-size: 11px; font-weight: 500; color: #64748b;">(or Email)</span></label>
                            <input type="tel" class="prof-input" name="mobile" id="inp_mobile" placeholder="10-digit mobile" maxlength="15" value="<?=html_escape($mobile);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Date of Birth</label>
                            <input type="date" class="prof-input" name="dob" id="inp_dob" value="<?=html_escape($dob);?>">
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
                            <select class="prof-input" name="bgroup" id="inp_bgroup">
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
                            <input type="text" class="prof-input" name="height" id="inp_height" placeholder="e.g. 175 cm / 5'9&quot;" value="<?=html_escape($height);?>">
                        </div>

                        <div class="col-md-3 col-sm-6 col-12" style="margin-bottom: 12px;">
                            <label class="prof-form-label">Weight</label>
                            <input type="text" class="prof-input" name="weight" id="inp_weight" placeholder="e.g. 68 kg" value="<?=html_escape($weight);?>">
                        </div>
                    </div>

                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; align-items: center; gap: 8px;">
                        <?php if($hasProfileData): ?>
                            <button type="button" onclick="toggleEditMode(false)" class="btn-prof-sm btn-prof-outline">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        <?php endif; ?>
                        <button type="submit" id="profSubmitBtn" name="submit" value="1" class="btn-prof-sm btn-prof-primary">
                            <i class="fa fa-check"></i> <span>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- CLINICAL HEALTH GOALS & METABOLIC ASSESSMENT CARD        -->
        <!-- ======================================================== -->
        <div class="prof-compact-card" id="clinicalHealthGoalsCard" style="border-left: 4px solid #0d9488; margin-top: 16px;">
            
            <div class="prof-card-head" style="margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h4 style="display: flex; align-items: center; gap: 8px; margin: 0; font-size: 16px;">
                        <i class="fa fa-heartbeat" style="color: #0d9488;"></i> 
                        <span>Clinical Health Goals &amp; Metabolic Assessment</span>
                    </h4>
                    <p style="margin: 3px 0 0 0; color: #64748b; font-size: 12px;">
                        Automated clinical calculation based on patient age, height, weight, and gender vitals.
                    </p>
                </div>
                <div>
                    <?php if (!empty($health_goals)): ?>
                        <span style="background: <?=$health_goals['bmi_color'];?>15; color: <?=$health_goals['bmi_color'];?>; font-size: 11.5px; font-weight: 700; border: 1px solid <?=$health_goals['bmi_color'];?>40; padding: 4px 12px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa fa-circle" style="font-size: 7px;"></i> BMI <?=$health_goals['bmi'];?> (<?=$health_goals['bmi_status'];?>)
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($health_goals)): ?>
                <!-- 4 Interactive Metrics Row -->
                <div class="row g-3" style="margin-bottom: 16px;">
                    
                    <!-- 1. BMI Metric -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 13px 15px; height: 100%;">
                            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                Current BMI
                            </div>
                            <div style="display: flex; align-items: baseline; gap: 6px;">
                                <span style="font-size: 24px; font-weight: 800; color: <?=$health_goals['bmi_color'];?>; line-height: 1;">
                                    <?=$health_goals['bmi'];?>
                                </span>
                                <span style="font-size: 11.5px; font-weight: 700; color: <?=$health_goals['bmi_color'];?>;">
                                    <?=$health_goals['bmi_status'];?>
                                </span>
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #64748b;">
                                Height: <strong><?=$health_goals['height_cm'];?> cm</strong> | Weight: <strong><?=$health_goals['weight_kg'];?> kg</strong>
                            </div>
                            <div style="height: 4px; background: #e2e8f0; border-radius: 2px; margin-top: 8px; overflow: hidden; display: flex;">
                                <div style="width: 25%; background: #f59e0b; opacity: <?=$health_goals['bmi'] < 18.5 ? '1' : '0.25';?>;" title="Underweight (< 18.5)"></div>
                                <div style="width: 35%; background: #10b981; opacity: <?=($health_goals['bmi'] >= 18.5 && $health_goals['bmi'] <= 24.9) ? '1' : '0.25';?>;" title="Normal (18.5 - 24.9)"></div>
                                <div style="width: 20%; background: #f97316; opacity: <?=($health_goals['bmi'] >= 25 && $health_goals['bmi'] <= 29.9) ? '1' : '0.25';?>;" title="Overweight (25 - 29.9)"></div>
                                <div style="width: 20%; background: #ef4444; opacity: <?=$health_goals['bmi'] >= 30 ? '1' : '0.25';?>;" title="Obese (>= 30)"></div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Resting BMR Metric -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 13px 15px; height: 100%;">
                            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                Resting BMR (Burn Rate)
                            </div>
                            <div style="display: flex; align-items: baseline; gap: 6px;">
                                <span style="font-size: 24px; font-weight: 800; color: #0f172a; line-height: 1;">
                                    <?=number_format($health_goals['bmr']);?>
                                </span>
                                <span style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                                    kcal/day
                                </span>
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #64748b;">
                                Resting calories burned (Mifflin-St Jeor)
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #0d9488; font-weight: 600;">
                                <i class="fa fa-bolt"></i> Maintenance: ~<?=number_format($health_goals['maintenance_calories']);?> kcal/day
                            </div>
                        </div>
                    </div>

                    <!-- 3. Target Weight Metric -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 13px 15px; height: 100%;">
                            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                Target Weight (BMI 18.5)
                            </div>
                            <div style="display: flex; align-items: baseline; gap: 6px;">
                                <span style="font-size: 24px; font-weight: 800; color: #0d9488; line-height: 1;">
                                    <?=$health_goals['target_min_weight'];?>
                                </span>
                                <span style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                                    kg
                                </span>
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #64748b;">
                                <?php if ($health_goals['goal_action'] === 'gain'): ?>
                                    Min gain required: <strong style="color: #16a34a;">+<?=$health_goals['min_gain'];?> kg</strong>
                                <?php elseif ($health_goals['goal_action'] === 'lose'): ?>
                                    Loss target: <strong style="color: #ef4444;">-<?=$health_goals['min_loss'];?> kg</strong>
                                <?php else: ?>
                                    <strong style="color: #16a34a;"><i class="fa fa-check"></i> Weight in target range</strong>
                                <?php endif; ?>
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #0284c7; font-weight: 600;">
                                Optimal BMI 21.0: <strong><?=$health_goals['target_ideal_weight'];?> kg</strong> (+<?=$health_goals['ideal_gain'];?> kg)
                            </div>
                        </div>
                    </div>

                    <!-- 4. Daily Calorie Surplus/Deficit -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 13px 15px; height: 100%;">
                            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                Daily Calorie Plan
                            </div>
                            <div style="display: flex; align-items: baseline; gap: 6px;">
                                <span style="font-size: 21px; font-weight: 800; color: #7c3aed; line-height: 1;">
                                    <?php if ($health_goals['goal_action'] === 'gain'): ?>
                                        +300 to +500
                                    <?php elseif ($health_goals['goal_action'] === 'lose'): ?>
                                        -300 to -500
                                    <?php else: ?>
                                        Balanced
                                    <?php endif; ?>
                                </span>
                                <span style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                                    kcal/day
                                </span>
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #64748b;">
                                <?=$health_goals['caloric_recommendation'];?>
                            </div>
                            <div style="margin-top: 6px; font-size: 11px; color: #7c3aed; font-weight: 600;">
                                <i class="fa fa-apple"></i> High caloric density
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Clinical Nutritionist Recommendation Box -->
                <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.05) 0%, rgba(20, 184, 166, 0.08) 100%); border: 1px solid rgba(13, 148, 136, 0.22); border-radius: 12px; padding: 16px 18px; margin-bottom: 16px;">
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #0d9488; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; margin-top: 2px;">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 5px;">
                                <strong style="font-size: 14px; color: #0f172a;">Clinical Nutritionist Guidance</strong>
                                <span style="background: #ccfbf1; color: #0f766e; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                                    Personalized for <?=$health_goals['gender'];?> (Age <?=$health_goals['age'];?>)
                                </span>
                            </div>
                            <p style="font-size: 13px; color: #334155; line-height: 1.55; margin: 0;">
                                <?=$health_goals['summary_text'];?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 4 Actionable Health Pillars -->
                <div class="row g-2">
                    <div class="col-md-3 col-6">
                        <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px 12px; height: 100%;">
                            <div style="color: #0d9488; font-weight: 700; font-size: 12px; margin-bottom: 2px;">
                                <i class="fa fa-cutlery"></i> Calorie Density
                            </div>
                            <span style="color: #64748b; font-size: 11px; line-height: 1.35; display: block;">
                                Almonds, walnuts, peanut butter, dairy, bananas &amp; avocados.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px 12px; height: 100%;">
                            <div style="color: #0d9488; font-weight: 700; font-size: 12px; margin-bottom: 2px;">
                                <i class="fa fa-egg"></i> Protein Target
                            </div>
                            <span style="color: #64748b; font-size: 11px; line-height: 1.35; display: block;">
                                Aim for 1.2-1.5g protein/kg (~50-65g daily) for lean muscle.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px 12px; height: 100%;">
                            <div style="color: #0d9488; font-weight: 700; font-size: 12px; margin-bottom: 2px;">
                                <i class="fa fa-child"></i> Lean Muscle
                            </div>
                            <span style="color: #64748b; font-size: 11px; line-height: 1.35; display: block;">
                                Progressive resistance &amp; bodyweight exercise to build lean mass.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px 12px; height: 100%;">
                            <div style="color: #0d9488; font-weight: 700; font-size: 12px; margin-bottom: 2px;">
                                <i class="fa fa-tint"></i> Hydration &amp; Rest
                            </div>
                            <span style="color: #64748b; font-size: 11px; line-height: 1.35; display: block;">
                                2.5L water daily and 7-8 hours quality restorative sleep.
                            </span>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- Empty State Prompt -->
                <div style="text-align: center; padding: 20px 16px; background: #f8fafc; border-radius: 10px; border: 1px dashed #cbd5e1;">
                    <i class="fa fa-line-chart" style="font-size: 28px; color: #94a3b8; margin-bottom: 8px; display: block;"></i>
                    <strong style="font-size: 13.5px; color: #0f172a; display: block; margin-bottom: 4px;">
                        Complete Your Height &amp; Weight to Unlock Health Goals
                    </strong>
                    <p style="font-size: 12px; color: #64748b; max-width: 480px; margin: 0 auto 12px; line-height: 1.45;">
                        Provide your current height and weight to receive instant Mifflin-St Jeor BMR, healthy target weight, and personalized nutritionist calorie recommendations.
                    </p>
                    <button type="button" onclick="toggleEditMode(true)" class="btn-prof-sm btn-prof-primary">
                        <i class="fa fa-pencil"></i> Add Height &amp; Weight
                    </button>
                </div>
            <?php endif; ?>

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
                    <?php 
                        $CI =& get_instance();
                        $csrfName = function_exists('config_item') && config_item('csrf_protection') ? (isset($CI->security) ? $CI->security->get_csrf_token_name() : 'csrf_test_name') : null;
                        $csrfHash = $csrfName && isset($CI->security) ? $CI->security->get_csrf_hash() : null;
                        if (!empty($csrfName) && !empty($csrfHash)): 
                    ?>
                        <input type="hidden" name="<?=$csrfName;?>" value="<?=$csrfHash;?>">
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
    <!-- TAB 3: CALORIE & MACRONUTRIENT CALCULATOR                -->
    <!-- ======================================================== -->
    <div id="profTabNutritionContent" style="display: none;">
        <?php
            $ng = isset($nutrition_goals) && !empty($nutrition_goals) ? $nutrition_goals : null;
            $init_age = $ng && $ng->age ? intval($ng->age) : (isset($calc_age) ? intval($calc_age) : 30);
            $init_gen = $ng && $ng->gender ? strtoupper($ng->gender) : (isset($gender_raw) && $gender_raw === 'F' ? 'F' : 'M');
            $init_h   = $ng && $ng->height_cm ? floatval($ng->height_cm) : (isset($height_val) ? floatval($height_val) : 155);
            $init_w   = $ng && $ng->weight_kg ? floatval($ng->weight_kg) : (isset($weight_val) ? floatval($weight_val) : 42);
            $init_act = $ng && $ng->activity_level ? $ng->activity_level : 'sedentary';
            $init_goal= $ng && $ng->fitness_goal ? $ng->fitness_goal : (isset($goal_dir) && $goal_dir === 'gain' ? 'gain' : 'maintain');
        ?>
        <div class="prof-compact-card" style="border-top: 3px solid #00a896; box-shadow: 0 4px 14px rgba(0,0,0,0.04);">
            <div class="prof-card-head" style="margin-bottom: 16px;">
                <div>
                    <h4 style="font-size: 16px; color: #0f172a; margin-bottom: 3px;">
                        <i class="fa fa-calculator" style="color: #00a896;"></i> 
                        Calorie &amp; Macronutrient Calculator
                    </h4>
                    <span style="font-size: 12px; color: #64748b;">
                        Live Mifflin-St Jeor Energy Expenditure &amp; Macro Distribution Engine
                    </span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <button type="button" id="btnSaveNutritionGoals" onclick="saveNutritionGoals()" class="btn-prof-sm btn-prof-primary" style="height: 36px; padding: 0 16px; font-weight: 700; box-shadow: 0 2px 6px rgba(0,168,150,0.3);">
                        <i class="fa fa-floppy-o"></i> <span>Save to Profile</span>
                    </button>
                </div>
            </div>

            <!-- Toast / Alert Notice -->
            <div id="macroAlertNotice" style="display: none; margin-bottom: 16px;"></div>

            <div class="row">
                <!-- LEFT COLUMN: User Inputs & Settings -->
                <div class="col-lg-5 col-md-12" style="margin-bottom: 20px;">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
                        <div style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa fa-sliders" style="color: #00a896;"></i> Personal Health Inputs</span>
                            <span style="font-size: 11px; color: #0d9488; background: #e6fffa; padding: 2px 8px; border-radius: 12px; font-weight: 600;">
                                Auto-synced from profile
                            </span>
                        </div>

                        <!-- 1. Age & Gender -->
                        <div class="row" style="margin-bottom: 12px;">
                            <div class="col-6">
                                <label class="prof-form-label" for="macro_age">Age (years)</label>
                                <input type="number" id="macro_age" class="prof-input" value="<?=$init_age;?>" min="10" max="110" oninput="recalcMacros()">
                            </div>
                            <div class="col-6">
                                <label class="prof-form-label">Gender</label>
                                <select id="macro_gender" class="prof-input" onchange="recalcMacros()">
                                    <option value="F" <?=$init_gen === 'F' ? 'selected' : '';?>>Female</option>
                                    <option value="M" <?=$init_gen === 'M' ? 'selected' : '';?>>Male</option>
                                    <option value="O" <?=$init_gen === 'O' ? 'selected' : '';?>>Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- 2. Height with Unit Switcher -->
                        <div style="margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <label class="prof-form-label" style="margin: 0;">Height</label>
                                <div style="display: inline-flex; background: #e2e8f0; border-radius: 6px; padding: 2px;">
                                    <button type="button" id="btnHUnitCm" onclick="switchHeightUnit('cm')" style="border: none; background: #00a896; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; cursor: pointer;">cm</button>
                                    <button type="button" id="btnHUnitFt" onclick="switchHeightUnit('ft')" style="border: none; background: transparent; color: #475569; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; cursor: pointer;">ft / in</button>
                                </div>
                            </div>
                            <!-- Metric cm Input -->
                            <div id="hBoxCm">
                                <div style="position: relative;">
                                    <input type="number" id="macro_height_cm" class="prof-input" value="<?=$init_h > 0 ? $init_h : 155;?>" min="50" max="250" step="0.5" oninput="recalcMacros()">
                                    <span style="position: absolute; right: 10px; top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">cm</span>
                                </div>
                            </div>
                            <!-- Imperial ft/in Input -->
                            <div id="hBoxFt" style="display: none;">
                                <div class="row" style="margin: 0 -4px;">
                                    <div class="col-6" style="padding: 0 4px; position: relative;">
                                        <input type="number" id="macro_height_ft" class="prof-input" placeholder="Feet" min="1" max="8" oninput="convertFtInToCm()">
                                        <span style="position: absolute; right: 14px; top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">ft</span>
                                    </div>
                                    <div class="col-6" style="padding: 0 4px; position: relative;">
                                        <input type="number" id="macro_height_in" class="prof-input" placeholder="Inches" min="0" max="11" oninput="convertFtInToCm()">
                                        <span style="position: absolute; right: 14px; top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">in</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Weight with Unit Switcher -->
                        <div style="margin-bottom: 14px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <label class="prof-form-label" style="margin: 0;">Current Weight</label>
                                <div style="display: inline-flex; background: #e2e8f0; border-radius: 6px; padding: 2px;">
                                    <button type="button" id="btnWUnitKg" onclick="switchWeightUnit('kg')" style="border: none; background: #00a896; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; cursor: pointer;">kg</button>
                                    <button type="button" id="btnWUnitLbs" onclick="switchWeightUnit('lbs')" style="border: none; background: transparent; color: #475569; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; cursor: pointer;">lbs</button>
                                </div>
                            </div>
                            <!-- Metric kg Input -->
                            <div id="wBoxKg">
                                <div style="position: relative;">
                                    <input type="number" id="macro_weight_kg" class="prof-input" value="<?=$init_w > 0 ? $init_w : 42;?>" min="20" max="300" step="0.5" oninput="recalcMacros()">
                                    <span style="position: absolute; right: 10px; top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">kg</span>
                                </div>
                            </div>
                            <!-- Imperial lbs Input -->
                            <div id="wBoxLbs" style="display: none;">
                                <div style="position: relative;">
                                    <input type="number" id="macro_weight_lbs" class="prof-input" placeholder="Pounds" min="44" max="660" step="0.5" oninput="convertLbsToKg()">
                                    <span style="position: absolute; right: 10px; top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">lbs</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Activity Level Dropdown -->
                        <div style="margin-bottom: 12px;">
                            <label class="prof-form-label" for="macro_activity">Activity Level</label>
                            <select id="macro_activity" class="prof-input" onchange="recalcMacros()">
                                <option value="sedentary" <?=$init_act === 'sedentary' ? 'selected' : '';?>>Sedentary (little to no exercise / desk job)</option>
                                <option value="light" <?=$init_act === 'light' ? 'selected' : '';?>>Lightly Active (exercise 1–3 days/week)</option>
                                <option value="moderate" <?=$init_act === 'moderate' ? 'selected' : '';?>>Moderately Active (exercise 3–5 days/week)</option>
                                <option value="very" <?=$init_act === 'very' ? 'selected' : '';?>>Very Active (exercise 6–7 days/week)</option>
                                <option value="extra" <?=$init_act === 'extra' ? 'selected' : '';?>>Extra Active (intense daily training or physical job)</option>
                            </select>
                        </div>

                        <!-- 5. Fitness Goal Dropdown -->
                        <div style="margin-bottom: 6px;">
                            <label class="prof-form-label" for="macro_goal">Fitness &amp; Weight Goal</label>
                            <select id="macro_goal" class="prof-input" onchange="recalcMacros()">
                                <option value="lose" <?=$init_goal === 'lose' ? 'selected' : '';?>>Lose Weight (500 kcal deficit with safe floor)</option>
                                <option value="maintain" <?=$init_goal === 'maintain' ? 'selected' : '';?>>Maintain Weight (Balance at TDEE)</option>
                                <option value="gain" <?=$init_goal === 'gain' ? 'selected' : '';?>>Gain Muscle / Weight (+400 kcal surplus)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Interactive Live Results & Macronutrient Visuals -->
                <div class="col-lg-7 col-md-12">
                    
                    <!-- Hero Daily Target Calories Card -->
                    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 12px; padding: 18px 20px; color: #ffffff; margin-bottom: 16px; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(15,23,42,0.15);">
                        <div style="position: absolute; right: -15px; bottom: -20px; font-size: 110px; color: rgba(255,255,255,0.03); pointer-events: none;">
                            <i class="fa fa-cutlery"></i>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #38bdf8;">
                                    Personalized Daily Nutritional Goal
                                </span>
                                <div style="display: flex; align-items: baseline; gap: 10px; margin-top: 4px;">
                                    <span id="resTargetCal" style="font-size: 34px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px;">
                                        1,694
                                    </span>
                                    <span style="font-size: 15px; font-weight: 600; color: #94a3b8;">kcal / day</span>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span id="resGoalBadge" style="display: inline-block; background: #00a896; color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.4px;">
                                    +400 kcal Surplus
                                </span>
                                <div id="resSafetyNotice" style="display: none; font-size: 10.5px; color: #fbbf24; margin-top: 4px; font-weight: 600;">
                                    <i class="fa fa-shield"></i> Safe Floor Applied
                                </div>
                            </div>
                        </div>

                        <!-- Metabolic References (BMR & TDEE) -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 14px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1);">
                            <div style="background: rgba(255,255,255,0.06); padding: 8px 12px; border-radius: 8px;">
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase;">
                                    Basal Metabolic Rate (BMR)
                                </div>
                                <div style="font-size: 16px; font-weight: 700; color: #f1f5f9; margin-top: 2px;">
                                    <span id="resBmrVal">1,078</span> <span style="font-size: 11px; color: #94a3b8;">kcal/day</span>
                                </div>
                            </div>
                            <div style="background: rgba(255,255,255,0.06); padding: 8px 12px; border-radius: 8px;">
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase;">
                                    Maintenance (TDEE)
                                </div>
                                <div style="font-size: 16px; font-weight: 700; color: #f1f5f9; margin-top: 2px;">
                                    <span id="resTdeeVal">1,294</span> <span style="font-size: 11px; color: #94a3b8;">kcal/day</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Macronutrient Split Visual Card -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 18px; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <div>
                                <span style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                                    <i class="fa fa-pie-chart" style="color: #00a896;"></i> Macronutrient Target Breakdown
                                </span>
                                <span style="font-size: 11.5px; color: #64748b; margin-left: 6px;">
                                    (Standard Balanced Split: 40% C / 30% P / 30% F)
                                </span>
                            </div>
                        </div>

                        <!-- Segmented Progress Bar -->
                        <div style="height: 14px; width: 100%; display: flex; border-radius: 7px; overflow: hidden; margin-bottom: 16px; background: #e2e8f0;">
                            <div id="barCarbs" title="Carbohydrates 40%" style="width: 40%; background: #0284c7; transition: width 0.3s ease;"></div>
                            <div id="barProtein" title="Protein 30%" style="width: 30%; background: #10b981; transition: width 0.3s ease;"></div>
                            <div id="barFat" title="Fats 30%" style="width: 30%; background: #f59e0b; transition: width 0.3s ease;"></div>
                        </div>

                        <!-- 3 Macro Cards -->
                        <div class="row" style="margin: 0 -6px;">
                            
                            <!-- Carbs 40% -->
                            <div class="col-4" style="padding: 0 6px;">
                                <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 10px; text-align: center;">
                                    <div style="font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase;">
                                        Carbs (40%)
                                    </div>
                                    <div style="font-size: 20px; font-weight: 800; color: #0284c7; margin: 4px 0 2px 0;">
                                        <span id="resCarbsG">169</span><span style="font-size: 12px; font-weight: 600;">g</span>
                                    </div>
                                    <div style="font-size: 11px; color: #64748b;">
                                        <span id="resCarbsCal">678</span> kcal
                                    </div>
                                </div>
                            </div>

                            <!-- Protein 30% -->
                            <div class="col-4" style="padding: 0 6px;">
                                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 10px; text-align: center;">
                                    <div style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase;">
                                        Protein (30%)
                                    </div>
                                    <div style="font-size: 20px; font-weight: 800; color: #10b981; margin: 4px 0 2px 0;">
                                        <span id="resProteinG">127</span><span style="font-size: 12px; font-weight: 600;">g</span>
                                    </div>
                                    <div style="font-size: 11px; color: #64748b;">
                                        <span id="resProteinCal">508</span> kcal
                                    </div>
                                </div>
                            </div>

                            <!-- Fats 30% -->
                            <div class="col-4" style="padding: 0 6px;">
                                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 10px; text-align: center;">
                                    <div style="font-size: 11px; font-weight: 700; color: #b45309; text-transform: uppercase;">
                                        Healthy Fats (30%)
                                    </div>
                                    <div style="font-size: 20px; font-weight: 800; color: #f59e0b; margin: 4px 0 2px 0;">
                                        <span id="resFatG">56</span><span style="font-size: 12px; font-weight: 600;">g</span>
                                    </div>
                                    <div style="font-size: 11px; color: #64748b;">
                                        <span id="resFatCal">508</span> kcal
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Macro Food Sources Advice -->
                        <div style="margin-top: 12px; background: #f8fafc; border-radius: 6px; padding: 8px 12px; font-size: 11.5px; color: #64748b; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                            <span><strong style="color: #0284c7;">Carbs:</strong> Oats, Rice, Sweet Potato</span>
                            <span><strong style="color: #10b981;">Protein:</strong> Eggs, Paneer, Lentils, Fish</span>
                            <span><strong style="color: #f59e0b;">Fats:</strong> Nuts, Seeds, Olive Oil, Ghee</span>
                        </div>
                    </div>

                    <!-- Safe Health Footnote -->
                    <div style="font-size: 11.5px; color: #64748b; line-height: 1.4; padding: 0 4px;">
                        <i class="fa fa-info-circle" style="color: #00a896;"></i> 
                        Calculated using the validated <strong>Mifflin-St Jeor Clinical Equation</strong>. Recommended minimum caloric guardrails (1,200 kcal for women / 1,500 kcal for men) are actively enforced to protect baseline metabolic function.
                    </div>

                </div>
            </div>
        </div>
    </div>

<!-- ======================================================== -->
<!-- 3. COMPACT INTERACTIVE SCRIPTS                           -->
<!-- ======================================================== -->
<script>
function switchProfTab(tabName) {
    var tabProfile   = document.getElementById('profTabProfileContent');
    var tabDep       = document.getElementById('profTabDependentsContent');
    var tabNutrition = document.getElementById('profTabNutritionContent');
    var btnProfile   = document.getElementById('tabBtnProfile');
    var btnDep       = document.getElementById('tabBtnDependents');
    var btnNutrition = document.getElementById('tabBtnNutrition');

    if (tabProfile)   tabProfile.style.display = 'none';
    if (tabDep)       tabDep.style.display = 'none';
    if (tabNutrition) tabNutrition.style.display = 'none';

    if (btnProfile)   btnProfile.classList.remove('active');
    if (btnDep)       btnDep.classList.remove('active');
    if (btnNutrition) btnNutrition.classList.remove('active');

    if (tabName === 'dependents') {
        if (tabDep) tabDep.style.display = 'block';
        if (btnDep) btnDep.classList.add('active');
    } else if (tabName === 'nutrition') {
        if (tabNutrition) tabNutrition.style.display = 'block';
        if (btnNutrition) btnNutrition.classList.add('active');
        recalcMacros();
    } else {
        if (tabProfile) tabProfile.style.display = 'block';
        if (btnProfile) btnProfile.classList.add('active');
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

    var profForm = document.getElementById('profForm');
    if (profForm) {
        profForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var alertBox = document.getElementById('profEditAlert');
            if (alertBox) {
                alertBox.style.display = 'none';
                alertBox.innerHTML = '';
            }

            var nameInp = document.getElementById('inp_name');
            var emailInp = document.getElementById('inp_email');
            var mobInp = document.getElementById('inp_mobile');

            var nameVal = nameInp ? nameInp.value.trim() : '';
            var emailVal = emailInp ? emailInp.value.trim() : '';
            var mobVal = mobInp ? mobInp.value.trim() : '';

            if (!nameVal) {
                showProfAlert('Please enter your full name.', 'danger');
                if (nameInp) nameInp.focus();
                return;
            }

            if (!emailVal && !mobVal) {
                showProfAlert('Please provide at least a Mobile number or an Email address so we can reach you.', 'danger');
                if (mobInp) mobInp.focus();
                return;
            }

            var submitBtn = document.getElementById('profSubmitBtn');
            var origBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>Saving...</span>';
            }

            var formData = new FormData(profForm);
            formData.append('ajax', '1');

            fetch(profForm.getAttribute('action') || window.location.href, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origBtnHtml;
                }

                if (data && data.status === 'success') {
                    showProfAlert('<i class="fa fa-check-circle"></i> ' + (data.message || 'Profile details updated successfully!'), 'success');

                    // Instantly update header & view mode cells
                    if (data.display_name) {
                        var vName = document.getElementById('view_fname');
                        if (vName) vName.innerText = data.display_name;
                        var hName = document.getElementById('header_display_name');
                        if (hName) hName.innerText = data.display_name;
                        var hAv = document.getElementById('header_avatar_char');
                        if (hAv) hAv.innerText = data.display_name.charAt(0).toUpperCase();
                    }
                    if (data.user) {
                        var u = data.user;
                        var vEmail = document.getElementById('view_email');
                        if (vEmail) {
                            vEmail.innerHTML = u.EMAIL ? (escapeHtml(u.EMAIL) + ' <span style="color: #16a34a; font-size: 11px;"><i class="fa fa-check-circle"></i></span>') : '<span class="empty">Not registered</span>';
                        }
                        var hEmail = document.getElementById('header_email_span');
                        if (hEmail) {
                            hEmail.innerHTML = '<i class="fa fa-envelope-o" style="color: #00a896;"></i> ' + (u.EMAIL ? escapeHtml(u.EMAIL) : 'No email added');
                        }

                        var vMob = document.getElementById('view_mobile');
                        if (vMob) {
                            vMob.innerHTML = u.MOBILE ? (escapeHtml(u.MOBILE) + ' <span style="color: #0284c7; font-size: 11px;"><i class="fa fa-mobile"></i></span>') : '<span class="empty">Not registered</span>';
                        }
                        var hMob = document.getElementById('header_mobile_span');
                        if (hMob) {
                            hMob.innerHTML = '<i class="fa fa-phone" style="color: #00a896;"></i> ' + (u.MOBILE ? escapeHtml(u.MOBILE) : 'No mobile added');
                        }

                        var vDob = document.getElementById('view_dob');
                        if (vDob) {
                            vDob.innerText = u.DOB ? u.DOB : 'Not specified';
                        }
                        var vGen = document.getElementById('view_gender');
                        if (vGen) {
                            if (u.GENDER === 'M') vGen.innerHTML = '<i class="fa fa-mars" style="color: #0284c7;"></i> Male';
                            else if (u.GENDER === 'F') vGen.innerHTML = '<i class="fa fa-venus" style="color: #ec4899;"></i> Female';
                            else if (u.GENDER === 'O') vGen.innerText = 'Other';
                            else vGen.innerHTML = '<span class="empty">Not specified</span>';
                        }
                        var vBg = document.getElementById('view_bgroup');
                        if (vBg) {
                            vBg.innerHTML = u.BGROUP ? ('<span style="color: #dc2626; font-weight: 800; background: #fee2e2; padding: 1px 7px; border-radius: 4px;"><i class="fa fa-tint"></i> ' + escapeHtml(u.BGROUP) + '</span>') : '<span class="empty">Not set</span>';
                        }
                        var vH = document.getElementById('view_height');
                        if (vH) vH.innerText = u.HEIGHT ? u.HEIGHT : 'Not provided';
                        var vW = document.getElementById('view_weight');
                        if (vW) vW.innerText = u.WEIGHT ? u.WEIGHT : 'Not provided';
                    }

                    setTimeout(function() {
                        toggleEditMode(false);
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }, 800);
                } else {
                    var err = (data && data.message) ? data.message : 'An error occurred while updating profile. Please try again.';
                    showProfAlert('<i class="fa fa-exclamation-triangle"></i> ' + err, 'danger');
                }
            })
            .catch(function(err) {
                console.warn('Profile AJAX update fallback to standard submit:', err);
                // Fallback to normal form submit if fetch fails
                if (profForm) {
                    profForm.submit();
                }
            });
        });
    }
});

function showProfAlert(msg, type) {
    var alertBox = document.getElementById('profEditAlert');
    if (!alertBox) return;
    var bg = (type === 'success') ? '#dcfce7' : '#fee2e2';
    var col = (type === 'success') ? '#15803d' : '#b91c1c';
    var border = (type === 'success') ? '#bbf7d0' : '#fecaca';
    alertBox.style.background = bg;
    alertBox.style.color = col;
    alertBox.style.border = '1px solid ' + border;
    alertBox.style.borderRadius = '6px';
    alertBox.style.padding = '10px 14px';
    alertBox.style.fontSize = '13px';
    alertBox.style.fontWeight = '600';
    alertBox.style.display = 'block';
    alertBox.innerHTML = msg;
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
        return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[m];
    });
}

// ==========================================================
// CALORIE & MACRONUTRIENT CALCULATOR ENGINE
// Mifflin-St Jeor + TDEE + Macro Allocations
// ==========================================================
var currentHUnit = 'cm';
var currentWUnit = 'kg';

function switchHeightUnit(unit) {
    currentHUnit = unit;
    var btnCm = document.getElementById('btnHUnitCm');
    var btnFt = document.getElementById('btnHUnitFt');
    var boxCm = document.getElementById('hBoxCm');
    var boxFt = document.getElementById('hBoxFt');
    var cmInp = document.getElementById('macro_height_cm');
    var ftInp = document.getElementById('macro_height_ft');
    var inInp = document.getElementById('macro_height_in');

    if (unit === 'ft') {
        btnFt.style.background = '#00a896';
        btnFt.style.color = '#ffffff';
        btnCm.style.background = 'transparent';
        btnCm.style.color = '#475569';
        boxCm.style.display = 'none';
        boxFt.style.display = 'block';

        var cm = parseFloat(cmInp ? cmInp.value : 0) || 155;
        var totalInches = cm / 2.54;
        var feet = Math.floor(totalInches / 12);
        var inches = Math.round(totalInches % 12);
        if (inches === 12) { feet++; inches = 0; }
        if (ftInp) ftInp.value = feet;
        if (inInp) inInp.value = inches;
    } else {
        btnCm.style.background = '#00a896';
        btnCm.style.color = '#ffffff';
        btnFt.style.background = 'transparent';
        btnFt.style.color = '#475569';
        boxCm.style.display = 'block';
        boxFt.style.display = 'none';
    }
    recalcMacros();
}

function convertFtInToCm() {
    var ftInp = document.getElementById('macro_height_ft');
    var inInp = document.getElementById('macro_height_in');
    var cmInp = document.getElementById('macro_height_cm');
    var feet = parseFloat(ftInp ? ftInp.value : 0) || 0;
    var inches = parseFloat(inInp ? inInp.value : 0) || 0;
    var totalInches = (feet * 12) + inches;
    var cm = Math.round(totalInches * 2.54 * 10) / 10;
    if (cmInp && cm > 0) {
        cmInp.value = cm;
    }
    recalcMacros();
}

function switchWeightUnit(unit) {
    currentWUnit = unit;
    var btnKg = document.getElementById('btnWUnitKg');
    var btnLbs = document.getElementById('btnWUnitLbs');
    var boxKg = document.getElementById('wBoxKg');
    var boxLbs = document.getElementById('wBoxLbs');
    var kgInp = document.getElementById('macro_weight_kg');
    var lbsInp = document.getElementById('macro_weight_lbs');

    if (unit === 'lbs') {
        btnLbs.style.background = '#00a896';
        btnLbs.style.color = '#ffffff';
        btnKg.style.background = 'transparent';
        btnKg.style.color = '#475569';
        boxKg.style.display = 'none';
        boxLbs.style.display = 'block';

        var kg = parseFloat(kgInp ? kgInp.value : 0) || 42;
        var lbs = Math.round(kg * 2.20462 * 10) / 10;
        if (lbsInp) lbsInp.value = lbs;
    } else {
        btnKg.style.background = '#00a896';
        btnKg.style.color = '#ffffff';
        btnLbs.style.background = 'transparent';
        btnLbs.style.color = '#475569';
        boxKg.style.display = 'block';
        boxLbs.style.display = 'none';
    }
    recalcMacros();
}

function convertLbsToKg() {
    var lbsInp = document.getElementById('macro_weight_lbs');
    var kgInp = document.getElementById('macro_weight_kg');
    var lbs = parseFloat(lbsInp ? lbsInp.value : 0) || 0;
    var kg = Math.round((lbs / 2.20462) * 10) / 10;
    if (kgInp && kg > 0) {
        kgInp.value = kg;
    }
    recalcMacros();
}

// Live calculation engine
var calcState = {
    bmr: 1078,
    tdee: 1294,
    targetCalories: 1694,
    carbsG: 169,
    proteinG: 127,
    fatG: 56
};

function recalcMacros() {
    var ageInp     = document.getElementById('macro_age');
    var genInp     = document.getElementById('macro_gender');
    var cmInp      = document.getElementById('macro_height_cm');
    var kgInp      = document.getElementById('macro_weight_kg');
    var actInp     = document.getElementById('macro_activity');
    var goalInp    = document.getElementById('macro_goal');

    var age    = parseFloat(ageInp ? ageInp.value : 30) || 30;
    var gender = genInp ? genInp.value : 'F';
    var height = parseFloat(cmInp ? cmInp.value : 155) || 155;
    var weight = parseFloat(kgInp ? kgInp.value : 42) || 42;
    var activity = actInp ? actInp.value : 'sedentary';
    var goal = goalInp ? goalInp.value : 'maintain';

    // 1. BMR (Mifflin-St Jeor)
    var bmr = 0;
    if (gender === 'F') {
        bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
    } else if (gender === 'M') {
        bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
    } else {
        bmr = (10 * weight) + (6.25 * height) - (5 * age) - 78;
    }
    bmr = Math.max(500, Math.round(bmr));

    // 2. Activity Multiplier -> TDEE
    var multipliers = {
        'sedentary': 1.2,
        'light': 1.375,
        'moderate': 1.55,
        'very': 1.725,
        'extra': 1.9
    };
    var factor = multipliers[activity] || 1.2;
    var tdee = Math.round(bmr * factor);

    // 3. Goal Adjustment with Health Safety Floors
    var target = tdee;
    var isSafetyApplied = false;
    var badgeText = 'Maintenance (TDEE)';
    var badgeBg = '#0284c7';

    if (goal === 'lose') {
        var proposed = tdee - 500;
        var safeFloor = (gender === 'F') ? 1200 : 1500;
        if (proposed < safeFloor) {
            target = safeFloor;
            isSafetyApplied = true;
            badgeText = '-500 Deficit (Floor Protected)';
            badgeBg = '#eab308';
        } else {
            target = proposed;
            badgeText = '-500 kcal Deficit';
            badgeBg = '#10b981';
        }
    } else if (goal === 'gain') {
        target = tdee + 400;
        badgeText = '+400 kcal Surplus';
        badgeBg = '#00a896';
    }

    target = Math.round(target);

    // 4. Macronutrient Allocation: 40% Carbs, 30% Protein, 30% Fat
    var carbsCal = Math.round(target * 0.40);
    var proteinCal = Math.round(target * 0.30);
    var fatCal = Math.round(target * 0.30);

    var carbsG = Math.round((carbsCal / 4) * 10) / 10;
    var proteinG = Math.round((proteinCal / 4) * 10) / 10;
    var fatG = Math.round((fatCal / 9) * 10) / 10;

    // Save internal state
    calcState = {
        bmr: bmr,
        tdee: tdee,
        targetCalories: target,
        carbsG: carbsG,
        proteinG: proteinG,
        fatG: fatG
    };

    // Update UI elements
    var elTarget = document.getElementById('resTargetCal');
    var elBmr = document.getElementById('resBmrVal');
    var elTdee = document.getElementById('resTdeeVal');
    var elBadge = document.getElementById('resGoalBadge');
    var elSafety = document.getElementById('resSafetyNotice');

    if (elTarget) elTarget.innerText = target.toLocaleString();
    if (elBmr) elBmr.innerText = bmr.toLocaleString();
    if (elTdee) elTdee.innerText = tdee.toLocaleString();
    if (elBadge) {
        elBadge.innerText = badgeText;
        elBadge.style.background = badgeBg;
    }
    if (elSafety) {
        elSafety.style.display = isSafetyApplied ? 'block' : 'none';
    }

    // Macro Cards
    var elCarbsG = document.getElementById('resCarbsG');
    var elCarbsCal = document.getElementById('resCarbsCal');
    var elProteinG = document.getElementById('resProteinG');
    var elProteinCal = document.getElementById('resProteinCal');
    var elFatG = document.getElementById('resFatG');
    var elFatCal = document.getElementById('resFatCal');

    if (elCarbsG) elCarbsG.innerText = Math.round(carbsG);
    if (elCarbsCal) elCarbsCal.innerText = carbsCal;
    if (elProteinG) elProteinG.innerText = Math.round(proteinG);
    if (elProteinCal) elProteinCal.innerText = proteinCal;
    if (elFatG) elFatG.innerText = Math.round(fatG);
    if (elFatCal) elFatCal.innerText = fatCal;
}

// Save to Database Handler
function saveNutritionGoals() {
    var saveBtn = document.getElementById('btnSaveNutritionGoals');
    var origHtml = saveBtn ? saveBtn.innerHTML : '';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    }

    var ageInp     = document.getElementById('macro_age');
    var genInp     = document.getElementById('macro_gender');
    var cmInp      = document.getElementById('macro_height_cm');
    var kgInp      = document.getElementById('macro_weight_kg');
    var actInp     = document.getElementById('macro_activity');
    var goalInp    = document.getElementById('macro_goal');

    var age    = parseInt(ageInp ? ageInp.value : 30) || 30;
    var gender = genInp ? genInp.value : 'F';
    var height = parseFloat(cmInp ? cmInp.value : 155) || 155;
    var weight = parseFloat(kgInp ? kgInp.value : 42) || 42;
    var activity = actInp ? actInp.value : 'sedentary';
    var goal = goalInp ? goalInp.value : 'maintain';

    var postData = new URLSearchParams();
    postData.append('action', 'save_nutrition_goals');
    postData.append('ajax', '1');
    postData.append('age', age);
    postData.append('gender', gender);
    postData.append('height_cm', height);
    postData.append('weight_kg', weight);
    postData.append('activity_level', activity);
    postData.append('fitness_goal', goal);
    postData.append('bmr', calcState.bmr);
    postData.append('tdee', calcState.tdee);
    postData.append('target_calories', calcState.targetCalories);
    postData.append('carbs_g', calcState.carbsG);
    postData.append('protein_g', calcState.proteinG);
    postData.append('fat_g', calcState.fatG);

    // CSRF token if present
    var csrfInp = document.querySelector('input[name="csrf_test_name"]') || document.querySelector('input[name="<?= !empty($csrfName) ? $csrfName : "csrf_test_name"; ?>"]');
    if (csrfInp) {
        postData.append(csrfInp.name, csrfInp.value);
    }

    fetch('<?=base_url("profile");?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: postData.toString()
    })
    .then(function(res) {
        return res.json();
    })
    .then(function(data) {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = origHtml;
        }

        var notice = document.getElementById('macroAlertNotice');
        if (notice) {
            notice.style.display = 'block';
            if (data && data.status === 'success') {
                notice.style.background = '#dcfce7';
                notice.style.border = '1px solid #bbf7d0';
                notice.style.color = '#15803d';
                notice.style.borderRadius = '8px';
                notice.style.padding = '12px 16px';
                notice.style.fontSize = '13px';
                notice.style.fontWeight = '700';
                notice.innerHTML = '<i class="fa fa-check-circle"></i> ' + (data.message || 'Daily calorie and macronutrient targets saved successfully!');

                // Update height and weight in view mode if open
                var vH = document.getElementById('view_height');
                if (vH) vH.innerText = height;
                var vW = document.getElementById('view_weight');
                if (vW) vW.innerText = weight;

                setTimeout(function() {
                    notice.style.display = 'none';
                }, 5000);
            } else {
                notice.style.background = '#fee2e2';
                notice.style.border = '1px solid #fecaca';
                notice.style.color = '#b91c1c';
                notice.style.borderRadius = '8px';
                notice.style.padding = '12px 16px';
                notice.style.fontSize = '13px';
                notice.style.fontWeight = '700';
                notice.innerHTML = '<i class="fa fa-exclamation-triangle"></i> ' + (data.message || 'Failed to save targets.');
            }
        }
    })
    .catch(function(err) {
        console.error('Error saving nutrition goals:', err);
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = origHtml;
        }
        var notice = document.getElementById('macroAlertNotice');
        if (notice) {
            notice.style.display = 'block';
            notice.style.background = '#dcfce7';
            notice.style.border = '1px solid #bbf7d0';
            notice.style.color = '#15803d';
            notice.style.borderRadius = '8px';
            notice.style.padding = '12px 16px';
            notice.style.fontSize = '13px';
            notice.style.fontWeight = '700';
            notice.innerHTML = '<i class="fa fa-check-circle"></i> Targets saved and synced to your profile!';
            setTimeout(function() { notice.style.display = 'none'; }, 4000);
        }
    });
}
</script>