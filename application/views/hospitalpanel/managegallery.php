<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.gallery-list-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.gallery-list-header {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.gallery-list-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.gallery-list-header p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-gallery {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-add-gallery:hover {
    background: #008f80;
    transform: translateY(-1px);
}

/* Gallery Grid */
.gallery-grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 22px;
}

.gallery-item-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    transition: all 0.2s ease;
}

.gallery-item-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.gallery-img-wrap {
    height: 180px;
    background: #0f172a;
    overflow: hidden;
    position: relative;
}

.gallery-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item-card:hover .gallery-img-wrap img {
    transform: scale(1.05);
}

.gallery-card-body {
    padding: 16px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.gallery-card-title {
    font-size: 14.5px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 6px 0;
}

.gallery-card-desc {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 14px 0;
    flex: 1;
}

.gallery-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}

.badge-gallery-approved {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 9px;
    border-radius: 12px;
}

.badge-gallery-pending {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 9px;
    border-radius: 12px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="gallery-list-wrap">

        <!-- Page Header -->
        <div class="gallery-list-header">
            <div>
                <h1><i class="fa fa-th-large" style="color: #00a896; margin-right: 8px;"></i> Hospital Gallery Showcase</h1>
                <p>Manage uploaded infrastructure photos and clinical facilities visible to public patients.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/gallery');?>" class="btn-add-gallery">
                    <i class="fa fa-plus-circle"></i> Upload New Photo
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        <?php if(!empty($gallery)): ?>
            <div class="gallery-grid-cards">
                <?php foreach($gallery as $p): ?>
                    <div class="gallery-item-card">
                        <div class="gallery-img-wrap">
                            <img src="<?=base_url('admin1947/public/assets/upload/'.$p['image']);?>" alt="<?=$p['shot_description'];?>">
                        </div>
                        <div class="gallery-card-body">
                            <div>
                                <h3 class="gallery-card-title"><?=!empty($p['shot_description']) ? html_escape($p['shot_description']) : 'Facility Photo';?></h3>
                                <p class="gallery-card-desc"><?=!empty($p['long_description']) ? html_escape($p['long_description']) : 'Hospital facility showcase.';?></p>
                            </div>
                            <div class="gallery-card-footer">
                                <?php if($p['status'] == 'A'): ?>
                                    <span class="badge-gallery-approved"><i class="fa fa-check-circle"></i> Live / Approved</span>
                                <?php else: ?>
                                    <span class="badge-gallery-pending"><i class="fa fa-clock-o"></i> Pending Review</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 64px 20px; background: #ffffff; border-radius: 12px; border: 1px solid var(--upchar-border);">
                <i class="fa fa-picture-o" style="font-size: 44px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                <h3 style="font-size: 16px; font-weight: 700; color: #64748b; margin: 0 0 6px 0;">No Gallery Photos Found</h3>
                <p style="font-size: 13px; color: #94a3b8; margin: 0 0 18px 0;">Upload high-definition photos of your hospital wards, reception, and operation theatres.</p>
                <a href="<?=base_url('hospitalpanel/gallery');?>" class="btn-add-gallery">
                    <i class="fa fa-plus-circle"></i> Add First Photo
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
