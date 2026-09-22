<?php 
// Safely extract properties with fallback defaults
$userObj = !empty($user) ? $user : (!empty($data) && is_object($data) ? $data : null);

function get_uprop($obj, $prop) {
    if (!$obj || !is_object($obj)) return '';
    $u = strtoupper($prop);
    $l = strtolower($prop);
    if (isset($obj->$u)) return trim((string)$obj->$u);
    if (isset($obj->$l)) return trim((string)$obj->$l);
    if (isset($obj->$prop)) return trim((string)$obj->$prop);
    return '';
}

$fname   = get_uprop($userObj, 'FNAME');
$lname   = get_uprop($userObj, 'LNAME');
$email   = get_uprop($userObj, 'EMAIL');
$mobile  = get_uprop($userObj, 'MOBILE');
$dob     = get_uprop($userObj, 'DOB');
$gender  = get_uprop($userObj, 'GENDER');
$bgroup  = get_uprop($userObj, 'BGROUP');
$height  = get_uprop($userObj, 'HEIGHT');
$weight  = get_uprop($userObj, 'WEIGHT');
$image   = !empty($src) ? $src : (get_uprop($userObj, 'IMAGE') ?: get_uprop($userObj, 'PROFILEIMG'));
$userid  = get_uprop($userObj, 'USERID') ?: ($this->session->userdata('userid') ?: 0);

$fullName = trim($fname . ' ' . $lname);
if (empty($fullName)) {
    $fullName = !empty($fname) ? $fname : (!empty($this->session->userdata('username')) ? $this->session->userdata('username') : '');
}
$displayName = !empty($fullName) ? $fullName : 'Valued Patient';

// Image URL determination
$img_url = '';
if (!empty($image)) {
    if (preg_match('/^https?:\/\//i', $image)) {
        $img_url = $image;
    } else if (file_exists(FCPATH . 'admin1947/public/assets/upload/' . $image)) {
        $img_url = base_url('admin1947/public/assets/upload/' . html_escape($image));
    }
}
?>

<style>
/* ==========================================================
   UPCHAR PATIENT PROFILE & PHOTO DASHBOARD
   ========================================================== */
.upd-container {
    max-width: 1140px;
    margin: 0 auto;
}

.upd-topbar {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}

.upd-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.upd-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.upd-card-head h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Avatar Preview Circle */
.upd-avatar-box {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 16px auto;
    border: 3px solid #00a896;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.2);
    background: #f0fdfa;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.upd-avatar-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upd-avatar-initial {
    font-size: 48px;
    font-weight: 800;
    color: #00a896;
    text-transform: uppercase;
}

/* Dropzone Picker */
.upd-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 20px 14px;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 16px;
    text-align: center;
}

.upd-dropzone:hover {
    border-color: #00a896;
    background: #f0fdfa;
}

/* Form Controls */
.upd-form-label {
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 4px;
    display: block;
}

.upd-input {
    height: 38px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    padding: 6px 12px;
    color: #0f172a;
    width: 100%;
    background-color: #ffffff;
    transition: border-color 0.15s ease;
}

.upd-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.15);
}

/* Gender Buttons */
.upd-gender-group {
    display: flex;
    gap: 6px;
}

.upd-gender-btn {
    flex: 1;
    position: relative;
}

.upd-gender-btn input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.upd-gender-btn label {
    height: 38px;
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

.upd-gender-btn input:checked + label {
    background: #f0fdfa;
    border-color: #00a896;
    color: #00a896;
    font-weight: 700;
}

/* Buttons */
.btn-upd-primary {
    background: #00a896;
    color: #ffffff;
    border: none;
    padding: 9px 20px;
    font-size: 13.5px;
    font-weight: 700;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.15s ease;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
}

.btn-upd-primary:hover {
    background: #028072;
    color: #ffffff;
}

.btn-upd-outline {
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.15s ease;
}

.btn-upd-outline:hover {
    color: #0f172a;
    background: #f8fafc;
    text-decoration: none;
}
</style>

<div class="upd-container">

    <!-- Top Action Bar -->
    <div class="upd-topbar">
        <div>
            <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                Update Profile &amp; Photo
            </h2>
            <p style="margin: 2px 0 0 0; color: #64748b; font-size: 12.5px;">
                Manage your patient display photo, contact information, and personal medical details.
            </p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="<?=base_url('profile');?>" class="btn-upd-outline">
                <i class="fa fa-arrow-left"></i> Back to Profile
            </a>
            <a href="<?=base_url('profile?edit=1');?>" class="btn-upd-outline">
                <i class="fa fa-id-card-o"></i> View Card
            </a>
        </div>
    </div>

    <!-- Flash Alert -->
    <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 16px;">
            <?=$this->session->flashdata('flashmsg');?>
        </div>
    <?php endif; ?>

    <div class="row">
        
        <!-- ======================================================== -->
        <!-- LEFT COLUMN: DISPLAY PHOTO UPLOADER                     -->
        <!-- ======================================================== -->
        <div class="col-lg-4 col-md-5 col-12">
            <div class="upd-card" style="text-align: center;">
                
                <div class="upd-card-head" style="justify-content: center;">
                    <h4><i class="fa fa-camera" style="color: #00a896;"></i> Display Picture</h4>
                </div>

                <!-- Live Feedback Alert for Photo -->
                <div id="photoAlertBox" style="display: none; margin-bottom: 12px; font-size: 12.5px; padding: 8px 12px; border-radius: 6px; text-align: left;"></div>

                <!-- Avatar Circle -->
                <div class="upd-avatar-box">
                    <?php if(!empty($img_url)): ?>
                        <img id="avatar-preview-img" src="<?=$img_url;?>" alt="User Profile Image">
                        <span id="avatar-fallback-initial" class="upd-avatar-initial" style="display: none;"><?=strtoupper(substr($displayName, 0, 1));?></span>
                    <?php else: ?>
                        <img id="avatar-preview-img" src="" alt="User Profile Image" style="display: none;">
                        <span id="avatar-fallback-initial" class="upd-avatar-initial"><?=strtoupper(substr($displayName, 0, 1));?></span>
                    <?php endif; ?>
                </div>

                <div style="margin-bottom: 14px;">
                    <strong style="font-size: 15px; color: #0f172a; display: block;" id="cardDisplayName">
                        <?=html_escape($displayName);?>
                    </strong>
                    <span style="font-size: 12px; color: #64748b;">
                        Patient ID: <strong>UPC-<?=str_pad($userid ?: '1', 5, '0', STR_PAD_LEFT);?></strong>
                    </span>
                </div>

                <!-- Photo Form -->
                <form action="<?=base_url('updateprofile');?>" method="post" enctype="multipart/form-data" id="photoUploadForm">
                    <?php if ($this->config->item('csrf_protection')): ?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <?php endif; ?>
                    <input type="hidden" name="upload_photo" value="1">
                    <input type="hidden" name="userid" value="<?=$userid;?>">

                    <div class="upd-dropzone" onclick="document.getElementById('profile_file_inp').click();">
                        <i class="fa fa-cloud-upload" style="font-size: 30px; color: #00a896; margin-bottom: 4px; display: block;"></i>
                        <span style="font-size: 13px; font-weight: 700; color: #0f172a; display: block;">
                            Click to browse photo
                        </span>
                        <span id="selected-file-name" style="font-size: 11.5px; color: #64748b; margin-top: 2px; display: block;">
                            JPG, PNG, or WEBP (Max 5MB)
                        </span>
                        <input type="file" name="file" id="profile_file_inp" accept="image/*" style="display: none;" onchange="previewSelectedPhoto(this);">
                    </div>

                    <button type="submit" id="photoSubmitBtn" class="btn-upd-primary" style="width: 100%; justify-content: center;">
                        <i class="fa fa-upload"></i> <span>Upload New Picture</span>
                    </button>
                </form>

            </div>
        </div>

        <!-- ======================================================== -->
        <!-- RIGHT COLUMN: PERSONAL & MEDICAL INFORMATION            -->
        <!-- ======================================================== -->
        <div class="col-lg-8 col-md-7 col-12">
            <div class="upd-card">
                
                <div class="upd-card-head">
                    <h4><i class="fa fa-user-circle" style="color: #00a896;"></i> Personal &amp; Medical Details</h4>
                    <span style="font-size: 11.5px; color: #64748b;"><i class="fa fa-shield" style="color: #00a896;"></i> Secure &amp; Confidential</span>
                </div>

                <!-- Live Feedback Alert for Profile -->
                <div id="profileDetailsAlert" style="display: none; margin-bottom: 14px; font-size: 13px; padding: 10px 14px; border-radius: 6px;"></div>

                <form action="<?=base_url('updateprofile');?>" method="post" id="profileDetailsForm">
                    <?php if ($this->config->item('csrf_protection')): ?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <?php endif; ?>
                    <input type="hidden" name="action" value="update_profile">
                    <input type="hidden" name="submit_profile" value="1">
                    <input type="hidden" name="userid" value="<?=$userid;?>">

                    <div class="row">
                        
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="upd-input" name="name" id="upd_inp_name" placeholder="Your full name" required value="<?=html_escape(!empty($fullName) ? $fullName : $fname);?>">
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Email Address <span style="font-size: 11px; font-weight: 500; color: #64748b;">(or Mobile)</span></label>
                            <input type="email" class="upd-input" name="email" id="upd_inp_email" placeholder="patient@example.com" value="<?=html_escape($email);?>">
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Mobile Number <span style="font-size: 11px; font-weight: 500; color: #64748b;">(or Email)</span></label>
                            <input type="tel" class="upd-input" name="mobile" id="upd_inp_mobile" placeholder="10-digit mobile" maxlength="15" value="<?=html_escape($mobile);?>">
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Date of Birth</label>
                            <input type="date" class="upd-input" name="dob" id="upd_inp_dob" value="<?=html_escape($dob);?>">
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Gender</label>
                            <div class="upd-gender-group">
                                <div class="upd-gender-btn">
                                    <input type="radio" name="gender" id="upd_g_m" value="M" <?=($gender == 'M' || $gender == 'Male') ? 'checked' : '';?>>
                                    <label for="upd_g_m"><i class="fa fa-mars"></i> Male</label>
                                </div>
                                <div class="upd-gender-btn">
                                    <input type="radio" name="gender" id="upd_g_f" value="F" <?=($gender == 'F' || $gender == 'Female') ? 'checked' : '';?>>
                                    <label for="upd_g_f"><i class="fa fa-venus"></i> Female</label>
                                </div>
                                <div class="upd-gender-btn">
                                    <input type="radio" name="gender" id="upd_g_o" value="O" <?=($gender == 'O' || $gender == 'Other') ? 'checked' : '';?>>
                                    <label for="upd_g_o">Other</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Blood Group</label>
                            <select class="upd-input" name="bgroup" id="upd_inp_bgroup">
                                <option value="">-- Select Blood Group --</option>
                                <?php 
                                    $bg_items = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                    foreach ($bg_items as $bg):
                                ?>
                                    <option value="<?=$bg;?>" <?=(strtoupper(trim($bgroup)) === $bg) ? 'selected' : '';?>><?=$bg;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Height</label>
                            <input type="text" class="upd-input" name="height" id="upd_inp_height" placeholder="e.g. 175 cm / 5'9&quot;" value="<?=html_escape($height);?>">
                        </div>

                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label class="upd-form-label">Weight</label>
                            <input type="text" class="upd-input" name="weight" id="upd_inp_weight" placeholder="e.g. 68 kg" value="<?=html_escape($weight);?>">
                        </div>

                    </div>

                    <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <a href="<?=base_url('profile');?>" class="btn-upd-outline">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" id="profileDetailsSubmitBtn" class="btn-upd-primary">
                            <i class="fa fa-check"></i> <span>Save Profile Details</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

<!-- ======================================================== -->
<!-- INTERACTIVE SCRIPTS                                      -->
<!-- ======================================================== -->
<script>
function previewSelectedPhoto(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var nameSpan = document.getElementById('selected-file-name');
        if (nameSpan) {
            nameSpan.textContent = 'Selected: ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            nameSpan.style.color = '#00a896';
            nameSpan.style.fontWeight = '700';
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            var previewImg = document.getElementById('avatar-preview-img');
            var fallbackInitial = document.getElementById('avatar-fallback-initial');
            if (previewImg) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            }
            if (fallbackInitial) {
                fallbackInitial.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Photo Upload AJAX Handler
    var photoForm = document.getElementById('photoUploadForm');
    if (photoForm) {
        photoForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var fileInp = document.getElementById('profile_file_inp');
            if (!fileInp || !fileInp.files || !fileInp.files[0]) {
                showUpdAlert('photoAlertBox', 'Please select an image file to upload.', 'danger');
                return;
            }

            var btn = document.getElementById('photoSubmitBtn');
            var origHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>Uploading...</span>';
            }

            var fd = new FormData(photoForm);
            fd.append('ajax', '1');

            fetch(photoForm.getAttribute('action') || window.location.href, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = origHtml;
                }
                if (data && data.status === 'success') {
                    showUpdAlert('photoAlertBox', '<i class="fa fa-check-circle"></i> ' + (data.message || 'Profile photo updated successfully!'), 'success');
                    if (data.url) {
                        var previewImg = document.getElementById('avatar-preview-img');
                        var fallbackInitial = document.getElementById('avatar-fallback-initial');
                        if (previewImg) {
                            previewImg.src = data.url;
                            previewImg.style.display = 'block';
                        }
                        if (fallbackInitial) fallbackInitial.style.display = 'none';
                    }
                } else {
                    var err = (data && data.message) ? data.message : 'Photo upload failed. Please try again.';
                    showUpdAlert('photoAlertBox', '<i class="fa fa-exclamation-triangle"></i> ' + err, 'danger');
                }
            })
            .catch(function(err) {
                console.warn('Photo upload fallback to form submit:', err);
                if (photoForm) photoForm.submit();
            });
        });
    }

    // 2. Profile Details AJAX Handler
    var detailsForm = document.getElementById('profileDetailsForm');
    if (detailsForm) {
        detailsForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var nameVal = (document.getElementById('upd_inp_name') ? document.getElementById('upd_inp_name').value : '').trim();
            var emailVal = (document.getElementById('upd_inp_email') ? document.getElementById('upd_inp_email').value : '').trim();
            var mobVal = (document.getElementById('upd_inp_mobile') ? document.getElementById('upd_inp_mobile').value : '').trim();

            if (!nameVal) {
                showUpdAlert('profileDetailsAlert', 'Please enter your full name.', 'danger');
                return;
            }
            if (!emailVal && !mobVal) {
                showUpdAlert('profileDetailsAlert', 'Please provide at least a Mobile number or an Email address.', 'danger');
                return;
            }

            var btn = document.getElementById('profileDetailsSubmitBtn');
            var origHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>Saving...</span>';
            }

            var fd = new FormData(detailsForm);
            fd.append('ajax', '1');

            fetch(detailsForm.getAttribute('action') || window.location.href, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = origHtml;
                }
                if (data && data.status === 'success') {
                    showUpdAlert('profileDetailsAlert', '<i class="fa fa-check-circle"></i> ' + (data.message || 'Profile details updated successfully!'), 'success');
                    if (data.display_name) {
                        var cardName = document.getElementById('cardDisplayName');
                        if (cardName) cardName.innerText = data.display_name;
                    }
                } else {
                    var err = (data && data.message) ? data.message : 'Update failed. Please try again.';
                    showUpdAlert('profileDetailsAlert', '<i class="fa fa-exclamation-triangle"></i> ' + err, 'danger');
                }
            })
            .catch(function(err) {
                console.warn('Profile details fallback to form submit:', err);
                if (detailsForm) detailsForm.submit();
            });
        });
    }

});

function showUpdAlert(elemId, msg, type) {
    var box = document.getElementById(elemId);
    if (!box) return;
    var bg = (type === 'success') ? '#dcfce7' : '#fee2e2';
    var col = (type === 'success') ? '#15803d' : '#b91c1c';
    var border = (type === 'success') ? '#bbf7d0' : '#fecaca';
    box.style.background = bg;
    box.style.color = col;
    box.style.border = '1px solid ' + border;
    box.style.display = 'block';
    box.innerHTML = msg;
}
</script>