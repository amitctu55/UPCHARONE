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
            Manage your personal patient account information, contact numbers, and medical details.
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
</style>

<div class="row">
    <div class="col-lg-8 col-md-10 col-12">
        <div class="profile-card-box">
            
            <div class="profile-section-heading">
                <i class="fa fa-user-circle" style="color: var(--upchar-teal); font-size: 20px;"></i>
                <span>Personal &amp; Contact Details</span>
            </div>

            <form action="" method="post">
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
                        <input type="text" class="profile-input-control" id="datepicker" placeholder="YYYY-MM-DD" name="dob" value="<?=html_escape($dob);?>">
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
            <div class="profile-section-heading" style="justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-users" style="color: var(--upchar-teal); font-size: 20px;"></i>
                    <span>Family &amp; Dependent Profiles</span>
                </div>
                <button type="button" class="btn btn-sm" onclick="$('#addDependentModal').modal('show');" style="background: #f0fdfa; color: var(--upchar-teal); font-weight: 700; border: 1px solid #99f6e4; border-radius: 6px; padding: 5px 12px; font-size: 12.5px;">
                    <i class="fa fa-plus"></i> Add Family Member
                </button>
            </div>
            <p style="font-size: 13px; color: #64748b; margin-top: -10px; margin-bottom: 16px;">
                Manage appointments, lab reports, and health history for children, spouse, or elderly dependents under your account.
            </p>

            <?php if (!empty($dependents)): ?>
                <div class="row">
                    <?php foreach ($dependents as $dep): ?>
                    <div class="col-md-6 col-12 mb-3" style="margin-bottom: 14px;">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; display: flex; align-items: flex-start; justify-content: space-between; gap: 10px;">
                            <div>
                                <div style="font-weight: 700; font-size: 14px; color: #0f172a;">
                                    <?=html_escape($dep->name);?>
                                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 600; margin-left: 6px; padding: 3px 8px; border-radius: 12px;">
                                        <?=html_escape($dep->relationship);?>
                                    </span>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                    <span><i class="fa fa-venus-mars"></i> <?=($dep->gender == 'F') ? 'Female' : 'Male';?></span>
                                    <?php if (!empty($dep->dob)): ?> | <span><i class="fa fa-birthday-cake"></i> <?=html_escape($dep->dob);?></span><?php endif; ?>
                                    <?php if (!empty($dep->blood_group)): ?> | <span style="font-weight: 600; color: #ef4444;"><i class="fa fa-tint"></i> <?=html_escape($dep->blood_group);?></span><?php endif; ?>
                                </div>
                                <?php if (!empty($dep->medical_history)): ?>
                                <div style="font-size: 11.5px; color: #475569; margin-top: 4px; background: #ffffff; padding: 4px 8px; border-radius: 6px; border: 1px solid #f1f5f9;">
                                    <strong>Notes:</strong> <?=html_escape($dep->medical_history);?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <a href="<?=base_url('profile?del_dep='.$dep->id);?>" onclick="return confirm('Are you sure you want to remove this family member?');" class="btn btn-xs" style="color: #ef4444; background: #fee2e2; border-radius: 6px; padding: 4px 8px;" title="Remove">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 20px; text-align: center; color: #64748b; font-size: 13px;">
                    <i class="fa fa-user-plus" style="font-size: 24px; color: #94a3b8; margin-bottom: 6px; display: block;"></i>
                    No family members added yet. Click <strong>Add Family Member</strong> above to link your dependents.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Side Summary Card -->
    <div class="col-lg-4 col-md-12 col-12">
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);">
            <div style="text-align: center; margin-bottom: 16px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: #f0fdfa; border: 3px solid var(--upchar-teal); color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; margin: 0 auto 12px auto;">
                    <?=strtoupper(substr($fname ?: 'P', 0, 1));?>
                </div>
                <h4 style="font-size: 16.5px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                    <?=html_escape($fname ?: 'Patient');?>
                </h4>
                <span class="badge" style="background: #d1fae5; color: #065f46; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">
                    <i class="fa fa-check-circle"></i> Active Patient Account
                </span>
            </div>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 16px; display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: #475569;">
                <div>
                    <i class="fa fa-envelope-o" style="width: 20px; color: var(--upchar-teal);"></i>
                    <?=html_escape($email ?: 'No email registered');?>
                </div>
                <div>
                    <i class="fa fa-phone" style="width: 20px; color: var(--upchar-teal);"></i>
                    <?=html_escape($mobile ?: 'No mobile registered');?>
                </div>
                <div>
                    <i class="fa fa-calendar" style="width: 20px; color: var(--upchar-teal);"></i>
                    DOB: <?=html_escape($dob ?: 'Not specified');?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Add Family Member / Dependent -->
<div class="modal fade" id="addDependentModal" tabindex="-1" role="dialog" aria-labelledby="addDependentModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: #00a896; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addDependentModalLabel" style="font-size: 16px; font-weight: 700; margin: 0;">
                    <i class="fa fa-user-plus" style="margin-right: 6px;"></i> Add Family Member / Dependent
                </h4>
            </div>
            <form action="<?=base_url('profile');?>" method="post">
                <input type="hidden" name="action" value="add_dependent">
                <div class="modal-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-7 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Full Name *</label>
                            <input type="text" class="profile-input-control" name="dep_name" placeholder="Member's full name" required>
                        </div>
                        <div class="col-md-5 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Relationship *</label>
                            <select class="profile-input-control" name="dep_rel" required>
                                <option value="SPOUSE">Spouse</option>
                                <option value="CHILD">Child</option>
                                <option value="PARENT">Parent</option>
                                <option value="SIBLING">Sibling</option>
                                <option value="OTHER">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Gender</label>
                            <select class="profile-input-control" name="dep_gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Date of Birth</label>
                            <input type="date" class="profile-input-control" name="dep_dob">
                        </div>
                        <div class="col-md-4 col-12 mb-3" style="margin-bottom: 14px;">
                            <label class="profile-field-label">Blood Group</label>
                            <input type="text" class="profile-input-control" name="dep_bgroup" placeholder="e.g. B+">
                        </div>
                        <div class="col-12" style="margin-bottom: 8px;">
                            <label class="profile-field-label">Known Allergies / Medical History</label>
                            <textarea class="profile-input-control" style="height: 70px; resize: vertical;" name="dep_history" placeholder="e.g. Penicillin allergy, diabetic, asthmatic"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn-save-profile" style="padding: 8px 22px; font-size: 13.5px;">Save Family Member</button>
                </div>
            </form>
        </div>
    </div>
</div>