<!-- Patient Dashboard Topbar -->
<div class="patient-topbar">
    <div>
        <h2 class="patient-topbar-title">Update Display Photo</h2>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13.5px;">
            Upload or change your profile picture displayed on your patient account and appointments.
        </p>
    </div>
    <div>
        <a href="<?=base_url('profile');?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; border-radius: 8px; padding: 9px 18px; border: 1px solid #cbd5e1; text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left" style="margin-right: 6px;"></i> Back to Profile
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
.upload-card-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    padding: 36px;
    margin-bottom: 30px;
    text-align: center;
}

.current-avatar-preview {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 20px auto;
    border: 4px solid var(--upchar-teal);
    box-shadow: 0 6px 15px rgba(0, 168, 150, 0.2);
    background: #f0fdfa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.current-avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.dropzone-file-picker {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 30px 20px;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 24px;
}

.dropzone-file-picker:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
}

.btn-upload-photo {
    background-color: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14.5px;
    padding: 12px 36px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3);
}

.btn-upload-photo:hover {
    background-color: var(--upchar-teal-dark);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.4);
}
</style>

<div class="row">
    <div class="col-lg-6 col-md-8 col-12 mx-auto">
        <div class="upload-card-box">
            
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">
                Your Display Picture
            </h3>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 24px;">
                Supported file formats: JPG, PNG, WEBP (Max 5MB)
            </p>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                
                <!-- Current Profile Image Avatar Preview -->
                <div class="current-avatar-preview">
                    <?php 
                        $img_src = !empty($src) ? base_url('admin1947/public/assets/upload/' . html_escape($src)) : '';
                    ?>
                    <?php if(!empty($src) && file_exists(FCPATH . 'admin1947/public/assets/upload/' . $src)): ?>
                        <img id="avatar-preview-img" src="<?=$img_src;?>" alt="User Profile Image">
                    <?php else: ?>
                        <i id="avatar-fallback-icon" class="fa fa-user" style="font-size: 54px; color: var(--upchar-teal);"></i>
                        <img id="avatar-preview-img" src="" alt="User Profile Image" style="display: none;">
                    <?php endif; ?>
                </div>

                <!-- Styled File Upload Picker -->
                <div class="dropzone-file-picker" onclick="document.getElementById('file').click();">
                    <i class="fa fa-cloud-upload" style="font-size: 36px; color: var(--upchar-teal); margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 14px; font-weight: 700; color: #0f172a; display: block;">
                        Click to select photo or drag file here
                    </span>
                    <span id="selected-file-name" style="font-size: 12px; color: #64748b; margin-top: 4px; display: block;">
                        No file chosen yet
                    </span>

                    <input type="file" name="file" id="file" accept="image/*" style="display: none;" onchange="handleFileSelect(this);">
                </div>

                <div>
                    <button type="submit" name="submit" class="btn-upload-photo">
                        <i class="fa fa-upload" style="margin-right: 8px;"></i> Upload Display Picture
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('selected-file-name').textContent = 'Selected: ' + file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.getElementById('avatar-preview-img');
            const fallbackIcon = document.getElementById('avatar-fallback-icon');
            
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
            if (fallbackIcon) fallbackIcon.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
}
</script>