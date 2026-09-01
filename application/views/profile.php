<?php 
// Safely extract properties with fallback defaults
$userObj = !empty($data) ? $data : (!empty($user) ? $user : null);
$fname  = isset($userObj->FNAME) ? $userObj->FNAME : '';
$email  = isset($userObj->EMAIL) ? $userObj->EMAIL : '';
$mobile = isset($userObj->MOBILE) ? $userObj->MOBILE : '';
$dob    = isset($userObj->DOB) ? $userObj->DOB : '';
$gender = isset($userObj->GENDER) ? $userObj->GENDER : '';
$bgroup = isset($userObj->BGROUP) ? $userObj->BGROUP : '';
?>

<!-- Patient Topbar Header -->
<div class="patient-topbar">
    <div>
        <h2 class="patient-topbar-title">My Profile &amp; Preferences</h2>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13.5px;">
            Manage your personal patient account information, contact numbers, and family medical details.
        </p>
    </div>
    <div>
        <a href="<?=base_url('change_password');?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; border-radius: 8px; padding: 9px 18px; border: 1px solid #cbd5e1; text-decoration: none; font-size: 13px;">
            <i class="fa fa-key" style="margin-right: 6px; color: #f59e0b;"></i> Change Password
        </a>
    </div>
</div>

<!-- Flash Alert Messages -->
<?php if($this->session->flashdata('flashmsg')): ?>
    <div style="margin-bottom: 20px;">
        <?=$this->session->flashdata('flashmsg');?>
    </div>
<?php endif; ?>

<style>
.profile-card-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    padding: 30px;
    margin-bottom: 30px;
}

.profile-section-heading {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 12px;
}

.profile-field-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.profile-input-control {
    height: 44px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    padding: 10px 14px;
    color: #1e293b;
    background-color: #ffffff;
    transition: all 0.2s ease;
    width: 100%;
}

.profile-input-control:focus {
    border-color: var(--upchar-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
    outline: none;
}

.btn-save-profile {
    background-color: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    padding: 11px 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3);
}

.btn-save-profile:hover {
    background-color: var(--upchar-teal-dark);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.4);
}

/* Inline Add Member Panel */
.inline-add-member-panel {
    display: none;
    background: #f0fdfa;
    border: 1.5px solid #99f6e4;
    border-radius: 14px;
    padding: 22px 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.08);
    animation: fadeInSlideDown 0.3s ease-out;
}

@keyframes fadeInSlideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.btn-toggle-add-dep {
    background: #f0fdfa;
    color: var(--upchar-teal);
    font-weight: 700;
    border: 1.5px solid #99f6e4;
    border-radius: 8px;
    padding: 7px 16px;
    font-size: 13px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-toggle-add-dep:hover, .btn-toggle-add-dep.active {
    background: var(--upchar-teal);
    color: #ffffff;
    border-color: var(--upchar-teal);
}
</style>

<div class="row">
    <div class="col-lg-8 col-md-10 col-12">
        
        <!-- Personal Details Card -->
        <div class="profile-card-box">
            
            <div class="profile-section-heading">
                <i class="fa fa-user-circle" style="color: var(--upchar-teal); font-size: 20px;"></i>
                <span>Personal &amp; Contact Details</span>
            </div>

            <form action="" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="row g-3">
                    
                    <!-- Full Name -->
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 16px;">
                        <label class="profile-field-label">Full Name *</label>
                        <input type="text" class="profile-input-control" placeholder="Enter your full name" name="name" required value="<?=html_escape($fname);?>">
                    </div>

                    <!-- Email Address -->
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 16px;">
                        <label class="profile-field-label">Email Address *</label>
                        <input type="email" class="profile-input-control" placeholder="patient@example.com" name="email" required value="<?=html_escape($email);?>">
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 16px;">
                        <label class="profile-field-label">Mobile Number *</label>
                        <input type="text" class="profile-input-control" placeholder="10-digit mobile" name="mobile" required value="<?=html_escape($mobile);?>">
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 16px;">
                        <label class="profile-field-label">Date of Birth</label>
                        <input type="date" class="profile-input-control" name="dob" value="<?=html_escape($dob);?>">
                    </div>

                    <!-- Gender Radio -->
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 16px;">
                        <label class="profile-field-label">Gender</label>
                        <div style="display: flex; gap: 24px; align-items: center; height: 44px;">
                            <label style="font-size: 13.5px; font-weight: 600; color: #0f172a; cursor: pointer; margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                                <input type="radio" name="gender" value="M" <?=($gender == 'M' || $gender == 'Male') ? 'checked' : '';?> style="accent-color: var(--upchar-teal);"> Male
                            </label>
                            <label style="font-size: 13.5px; font-weight: 600; color: #0f172a; cursor: pointer; margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                                <input type="radio" name="gender" value="F" <?=($gender == 'F' || $gender == 'Female') ? 'checked' : '';?> style="accent-color: var(--upchar-teal);"> Female
                            </label>
                        </div>
                    </div>

                    <!-- Blood Group -->
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 16px;">
                        <label class="profile-field-label">Blood Group</label>
                        <input type="text" class="profile-input-control" placeholder="e.g. O+, A+, B-" name="bgroup" value="<?=html_escape($bgroup);?>">
                    </div>

                </div>

                <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
                    <button type="submit" name="submit" class="btn-save-profile">
                        <i class="fa fa-save" style="margin-right: 6px;"></i> Save Profile Changes
                    </button>
                </div>
            </form>

        </div>

        <!-- Family & Dependent Profiles Card -->
        <div class="profile-card-box">
            <div class="profile-section-heading" style="justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-users" style="color: var(--upchar-teal); font-size: 20px;"></i>
                    <span>Family &amp; Dependent Profiles</span>
                </div>
                <button type="button" class="btn-toggle-add-dep" id="toggleAddMemberBtn" onclick="toggleAddMemberInline()">
                    <i class="fa fa-plus" id="toggleAddMemberIcon"></i> 
                    <span id="toggleAddMemberText">Add Family Member</span>
                </button>
            </div>
            
            <p style="font-size: 13px; color: #64748b; margin-top: -10px; margin-bottom: 18px;">
                Add children, spouse, or elderly parents under your account to easily book consultations and lab tests on their behalf.
            </p>

            <!-- Inline Expandable Form (Opens Directly Below) -->
            <div class="inline-add-member-panel" id="inlineAddMemberSection">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; border-bottom: 1px solid #ccfbf1; padding-bottom: 10px;">
                    <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-user-plus" style="color: var(--upchar-teal);"></i> Enter Family Member Details
                    </h4>
                    <button type="button" onclick="toggleAddMemberInline()" style="background: transparent; border: none; font-size: 18px; color: #64748b; cursor: pointer;">
                        &times;
                    </button>
                </div>

                <form action="<?=base_url('profile');?>" method="post" id="inlineAddMemberForm">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <input type="hidden" name="action" value="add_dependent">
                    
                    <div class="row">
                        <!-- Full Name -->
                        <div class="col-md-6 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Full Name *</label>
                            <input type="text" class="profile-input-control" name="dep_name" placeholder="Member's full name" required>
                        </div>

                        <!-- Relationship -->
                        <div class="col-md-6 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Relationship *</label>
                            <select class="profile-input-control" name="dep_rel" required>
                                <option value="SPOUSE">Spouse</option>
                                <option value="CHILD">Child / Dependent</option>
                                <option value="PARENT">Parent (Father / Mother)</option>
                                <option value="SIBLING">Sibling (Brother / Sister)</option>
                                <option value="OTHER">Other Relative</option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Gender *</label>
                            <select class="profile-input-control" name="dep_gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-4 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Date of Birth</label>
                            <input type="date" class="profile-input-control" name="dep_dob">
                        </div>

                        <!-- Blood Group -->
                        <div class="col-md-4 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Blood Group</label>
                            <input type="text" class="profile-input-control" name="dep_bgroup" placeholder="e.g. O+, B+, A+">
                        </div>

                        <!-- Medical History / Notes -->
                        <div class="col-12 mb-3" style="margin-bottom: 16px;">
                            <label class="profile-field-label">Known Allergies / Chronic Medical Conditions</label>
                            <textarea class="profile-input-control" style="height: 65px; resize: vertical;" name="dep_history" placeholder="e.g. Penicillin allergy, diabetes, hypertension, asthma"></textarea>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #ccfbf1; padding-top: 14px;">
                        <button type="button" class="btn btn-default" onclick="toggleAddMemberInline()" style="border-radius: 8px; font-weight: 600; padding: 8px 18px; font-size: 13px;">
                            Cancel
                        </button>
                        <button type="submit" class="btn-save-profile" style="padding: 8px 22px; font-size: 13px;">
                            <i class="fa fa-check"></i> Save Family Member
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Dependents List -->
            <?php if (!empty($dependents)): ?>
                <div class="row">
                    <?php foreach ($dependents as $dep): ?>
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 14px;">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; transition: all 0.2s;">
                            <div>
                                <div style="font-weight: 700; font-size: 14.5px; color: #0f172a; display: flex; align-items: center; flex-wrap: wrap; gap: 6px;">
                                    <?=html_escape($dep->name);?>
                                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 12px;">
                                        <?=html_escape($dep->relationship);?>
                                    </span>
                                </div>
                                <div style="font-size: 12.5px; color: #64748b; margin-top: 6px; display: flex; flex-wrap: wrap; gap: 10px;">
                                    <span><i class="fa fa-venus-mars" style="color: #0284c7;"></i> <?=($dep->gender == 'F') ? 'Female' : 'Male';?></span>
                                    <?php if (!empty($dep->dob)): ?>
                                        <span><i class="fa fa-birthday-cake" style="color: #f59e0b;"></i> <?=html_escape($dep->dob);?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($dep->blood_group)): ?>
                                        <span style="font-weight: 700; color: #ef4444;"><i class="fa fa-tint"></i> <?=html_escape($dep->blood_group);?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($dep->medical_history)): ?>
                                <div style="font-size: 12px; color: #475569; margin-top: 8px; background: #ffffff; padding: 6px 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                    <strong><i class="fa fa-info-circle" style="color: var(--upchar-teal);"></i> Notes:</strong> <?=html_escape($dep->medical_history);?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <a href="<?=base_url('profile?del_dep='.$dep->id);?>" onclick="return confirm('Are you sure you want to remove this family member?');" class="btn btn-xs" style="color: #ef4444; background: #fee2e2; border-radius: 6px; padding: 6px 9px;" title="Remove Member">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 24px; text-align: center; color: #64748b; font-size: 13.5px;" id="noDependentsBox">
                    <i class="fa fa-users" style="font-size: 28px; color: #94a3b8; margin-bottom: 8px; display: block;"></i>
                    No family members added yet. Click <strong>Add Family Member</strong> above to link your dependents.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Side Summary Card -->
    <div class="col-lg-4 col-md-12 col-12">
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 25px;">
            <div style="text-align: center; margin-bottom: 18px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: #f0fdfa; border: 3px solid var(--upchar-teal); color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; margin: 0 auto 12px auto; box-shadow: 0 4px 12px rgba(0,168,150,0.15);">
                    <?=strtoupper(substr($fname ?: 'P', 0, 1));?>
                </div>
                <h4 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
                    <?=html_escape($fname ?: 'Patient Account');?>
                </h4>
                <span class="badge" style="background: #d1fae5; color: #065f46; font-size: 11.5px; font-weight: 700; padding: 5px 12px; border-radius: 20px;">
                    <i class="fa fa-check-circle"></i> Active Patient Account
                </span>
            </div>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 16px; display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: #475569;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-envelope-o" style="width: 18px; color: var(--upchar-teal); font-size: 15px;"></i>
                    <span><?=html_escape($email ?: 'No email registered');?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-phone" style="width: 18px; color: var(--upchar-teal); font-size: 15px;"></i>
                    <span><?=html_escape($mobile ?: 'No mobile registered');?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-calendar" style="width: 18px; color: var(--upchar-teal); font-size: 15px;"></i>
                    <span>DOB: <?=html_escape($dob ?: 'Not specified');?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-tint" style="width: 18px; color: #ef4444; font-size: 15px;"></i>
                    <span>Blood Group: <strong><?=html_escape($bgroup ?: 'Not set');?></strong></span>
                </div>
            </div>

            <div style="border-top: 1px solid #f1f5f9; margin-top: 18px; padding-top: 16px;">
                <a href="<?=base_url('updateprofile');?>" class="btn btn-block" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; font-size: 13px; border-radius: 8px; width: 100%; text-align: center; display: block; padding: 9px 0; text-decoration: none;">
                    <i class="fa fa-camera" style="margin-right: 6px; color: var(--upchar-teal);"></i> Update Photo
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAddMemberInline() {
    var panel = document.getElementById('inlineAddMemberSection');
    var btn = document.getElementById('toggleAddMemberBtn');
    var icon = document.getElementById('toggleAddMemberIcon');
    var text = document.getElementById('toggleAddMemberText');

    if (panel.style.display === 'none' || panel.style.display === '') {
        panel.style.display = 'block';
        btn.classList.add('active');
        icon.className = 'fa fa-times';
        text.innerText = 'Close Form';
        // Auto focus first input
        setTimeout(function() {
            var input = panel.querySelector('input[name="dep_name"]');
            if (input) input.focus();
        }, 100);
    } else {
        panel.style.display = 'none';
        btn.classList.remove('active');
        icon.className = 'fa fa-plus';
        text.innerText = 'Add Family Member';
    }
}
</script>