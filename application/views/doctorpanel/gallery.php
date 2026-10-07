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

.gallery-page-wrap {
    padding: 26px 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Masonry & Grid Card Styles */
.gallery-grid-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
}

.gallery-grid-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0, 168, 150, 0.12);
    border-color: var(--upchar-teal);
}

.gallery-img-container {
    width: 100%;
    height: 210px;
    background: #0f172a;
    position: relative;
    overflow: hidden;
}

.gallery-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-grid-card:hover .gallery-img-container img {
    transform: scale(1.05);
}

.gallery-badge-status {
    position: absolute;
    top: 12px;
    right: 12px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    backdrop-filter: blur(8px);
}

.badge-approved {
    background: rgba(16, 185, 129, 0.9);
    color: #ffffff;
}

.badge-pending {
    background: rgba(245, 158, 11, 0.9);
    color: #ffffff;
}

.gallery-meta-body {
    padding: 16px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.btn-upload-nav {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 10px 20px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.btn-upload-nav:hover {
    background: var(--upchar-teal-dark);
}
</style>

<div class="gallery-page-wrap">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-picture-o text-aqua" style="margin-right: 8px;"></i> Clinic &amp; Practice Gallery Showcase
                    </h1>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        High-resolution chamber, reception, and surgical equipment showcase displayed on your public doctor profile.
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?=base_url('doctorpanel/managegallery');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-cog"></i> Manage Photos &amp; Upload
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Gallery Masonry / Grid Row -->
            <div class="row">
                <?php if(!empty($gallery)): ?>
                    <?php foreach($gallery as $p): 
                        $img_src = base_url('admin1947/public/assets/upload/' . $p['image']);
                        $is_approved = ($p['status'] == 'A' || $p['status'] == '1');
                    ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="gallery-grid-card">
                            <div class="gallery-img-container">
                                <img src="<?=$img_src;?>" alt="Clinic Gallery Photo" onerror="this.src='<?=base_url('assets/images/user.jpg');?>';">
                                <span class="gallery-badge-status <?=$is_approved ? 'badge-approved' : 'badge-pending';?>">
                                    <?=$is_approved ? '<i class="fa fa-check-circle"></i> Live on Profile' : '<i class="fa fa-clock-o"></i> Pending Review';?>
                                </span>
                            </div>
                            
                            <div class="gallery-meta-body">
                                <div>
                                    <h4 style="font-size: 14.5px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
                                        <?=htmlspecialchars($p['shot_description'] ?: 'Practice Chamber Image');?>
                                    </h4>
                                    <?php if(!empty($p['long_description'])): ?>
                                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.45; margin: 0 0 10px 0;">
                                        <?=htmlspecialchars($p['long_description']);?>
                                    </p>
                                    <?php endif; ?>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 6px;">
                                    <span style="font-size: 11px; color: #94a3b8; font-weight: 600;">
                                        <i class="fa fa-camera"></i> Verified Practice Asset
                                    </span>
                                    <a href="<?=$img_src;?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; font-size: 11px; border-radius: 4px;">
                                        <i class="fa fa-expand"></i> View High-Res
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-xs-12" style="text-align: center; padding: 70px 20px; color: #94a3b8;">
                        <i class="fa fa-picture-o" style="font-size: 50px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                        <h4 style="font-weight: 800; color: #334155; margin: 0 0 4px 0;">No Clinic Photos in Gallery</h4>
                        <p style="font-size: 13px; color: #64748b; max-width: 440px; margin: 0 auto 16px auto;">
                            Upload photos of your consulting chamber, patient waiting room, and clinical awards to build trust with visiting patients.
                        </p>
                        <a href="<?=base_url('doctorpanel/managegallery');?>" class="btn-upload-nav">
                            <i class="fa fa-cloud-upload"></i> Upload Chamber Photos
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>