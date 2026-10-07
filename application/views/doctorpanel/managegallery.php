<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.gallery-manage-wrap {
    padding: 26px 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card-custom {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

/* Modern Drag & Drop Zone */
.upload-dropzone {
    border: 2px dashed #94a3b8;
    border-radius: 12px;
    background: #f8fafc;
    padding: 28px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.upload-dropzone:hover,
.upload-dropzone.dragover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
}

.dropzone-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #ffffff;
    color: var(--upchar-teal);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin: 0 auto 10px auto;
}

.hidden-file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.form-label-bold {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.form-control-modern {
    width: 100%;
    height: 44px;
    border-radius: 9px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-control-modern:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-upload-submit {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 11px 24px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-upload-submit:hover {
    background: var(--upchar-teal-dark);
}

/* Image Card with Delete Overlay */
.photo-item-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--upchar-border);
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    margin-bottom: 20px;
    transition: all 0.2s ease;
}

.photo-item-card:hover {
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
}

.photo-item-img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    display: block;
}

.photo-delete-overlay {
    position: absolute;
    top: 8px;
    right: 8px;
    z-index: 10;
}

.btn-delete-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(220, 38, 38, 0.9);
    color: #ffffff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none !important;
}

.btn-delete-circle:hover {
    background: #b91c1c;
    transform: scale(1.1);
}
</style>

<div class="gallery-manage-wrap">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 22px; gap: 14px;">
                <div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-picture-o text-aqua" style="margin-right: 8px;"></i> Upload &amp; Manage Gallery Photos
                    </h1>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Upload chamber photos, medical equipment, and reception views with instant deletion control.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('doctorpanel/gallery');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-th-large"></i> View Public Showcase
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Left: Drag & Drop Upload Card -->
                <div class="col-md-5 col-12">
                    <div class="card-custom">
                        <div style="padding: 18px 22px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                            <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                                <i class="fa fa-cloud-upload text-aqua"></i> Upload New Chamber Photo
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Add new image to your doctor profile gallery.</p>
                        </div>

                        <div style="padding: 22px;">
                            <form action="<?=base_url('doctorpanel/gallery');?>" method="post" enctype="multipart/form-data" id="galleryUploadForm">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                <input type="hidden" name="submit" value="1">

                                <!-- Drag and Drop Zone -->
                                <div class="upload-dropzone" id="dropzone_box" style="margin-bottom: 18px;">
                                    <input type="file" name="uploadimage" id="file_gallery_input" accept="image/*" class="hidden-file-input" required>
                                    <div class="dropzone-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                    </div>
                                    <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                                        Drag &amp; Drop Photo Here or <span style="color: var(--upchar-teal);">Browse</span>
                                    </div>
                                    <div style="font-size: 11.5px; color: #64748b;">
                                        JPG, PNG, JPEG (Max 2MB per image)
                                    </div>
                                    <div id="selected_file_name" style="font-size: 12px; font-weight: 700; color: #00a896; margin-top: 8px; display: none;"></div>
                                </div>

                                <!-- Short Description -->
                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="form-label-bold">Photo Caption / Short Title *</label>
                                    <input type="text" name="shot" class="form-control-modern" placeholder="e.g. Consultation Chamber &amp; Examination Bed" required>
                                </div>

                                <!-- Long Description -->
                                <div class="form-group" style="margin-bottom: 22px;">
                                    <label class="form-label-bold">Detailed Description (Optional)</label>
                                    <textarea name="long" rows="3" class="form-control" style="border-radius: 9px; font-size: 13px;" placeholder="Add clinical context, operating facilities, or diagnostic equipment details..."></textarea>
                                </div>

                                <button type="submit" class="btn-upload-submit" style="width: 100%; justify-content: center;">
                                    <i class="fa fa-check"></i> Upload to Gallery
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Existing Images Grid with Delete Overlay -->
                <div class="col-md-7 col-12">
                    <div class="card-custom">
                        <div style="padding: 18px 22px; border-bottom: 1px solid #f1f5f9; background: #ffffff; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                                    <i class="fa fa-picture-o text-aqua"></i> Uploaded Photos (<?=count($gallery);?>)
                                </h3>
                                <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Manage and delete your published photos.</p>
                            </div>
                        </div>

                        <div style="padding: 22px;">
                            <?php if(!empty($gallery)): ?>
                            <div class="row">
                                <?php foreach($gallery as $p): 
                                    $img_src = base_url('admin1947/public/assets/upload/' . $p['image']);
                                ?>
                                <div class="col-sm-6 col-12">
                                    <div class="photo-item-card">
                                        <!-- Delete Overlay Button -->
                                        <div class="photo-delete-overlay">
                                            <a href="<?=base_url('doctorpanel/delete_gallery/'.$p['id']);?>" onclick="return confirm('Are you sure you want to permanently delete this photo?');" class="btn-delete-circle" title="Delete Photo">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </div>

                                        <img src="<?=$img_src;?>" class="photo-item-img" alt="Gallery photo" onerror="this.src='<?=base_url('assets/images/user.jpg');?>';">

                                        <div style="padding: 12px 14px;">
                                            <div style="font-weight: 700; color: #0f172a; font-size: 13px; line-height: 1.3; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                                <?=htmlspecialchars($p['shot_description'] ?: 'Clinic Photo');?>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span style="font-size: 11px; font-weight: 700; color: <?=($p['status']=='A'||$p['status']=='1') ? '#15803d' : '#b45309';?>;">
                                                    <i class="fa fa-circle" style="font-size: 8px;"></i> <?=($p['status']=='A'||$p['status']=='1') ? 'Live on Profile' : 'Pending Review';?>
                                                </span>
                                                <a href="<?=$img_src;?>" target="_blank" style="font-size: 11px; color: var(--upchar-teal); font-weight: 600;">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <div style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                <i class="fa fa-picture-o" style="font-size: 44px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                <h4 style="font-weight: 800; color: #334155; margin: 0 0 4px 0;">No Photos Uploaded Yet</h4>
                                <p style="font-size: 13px; color: #64748b; margin: 0;">Use the upload box on the left to add your first clinic chamber photo.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).ready(function() {
    var $input = $('#file_gallery_input');
    var $label = $('#selected_file_name');
    var $box = $('#dropzone_box');

    $input.on('change', function() {
        if (this.files && this.files[0]) {
            $label.text('Selected: ' + this.files[0].name).show();
            $box.css('border-color', '#00a896').css('background', '#f0fdfa');
        }
    });

    $box.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $box.on('dragleave drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
});
</script>
