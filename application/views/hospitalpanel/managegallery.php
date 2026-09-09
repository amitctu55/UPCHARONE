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

/* Page Header */
.gallery-list-header {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px 26px;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
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
    display: flex;
    align-items: center;
    gap: 10px;
}

.gallery-list-header p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-gallery {
    background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-add-gallery:hover {
    background: linear-gradient(135deg, #008f80 0%, #00776b 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

/* Summary Stats */
.gallery-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.gallery-stat-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    transition: transform 0.15s ease;
}

.gallery-stat-card:hover {
    transform: translateY(-2px);
}

.gallery-stat-info h3 {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 2px 0;
    line-height: 1.2;
}

.gallery-stat-info p {
    font-size: 12px;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

.gallery-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.gallery-stat-icon.teal { background: #ccfbf1; color: #0d9488; }
.gallery-stat-icon.green { background: #dcfce7; color: #16a34a; }
.gallery-stat-icon.blue { background: #e0f2fe; color: #0284c7; }

/* Filter Bar */
.gallery-filter-bar {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 14px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
}

.gallery-search-wrap {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.gallery-search-wrap i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.gallery-search-input {
    width: 100%;
    height: 40px;
    padding: 8px 14px 8px 38px;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    font-size: 13.5px;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.15s ease;
}

.gallery-search-input:focus {
    background: #ffffff;
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

/* Gallery Grid */
.gallery-grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 22px;
}

.gallery-item-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
    position: relative;
}

.gallery-item-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.09);
    border-color: #cbd5e1;
}

.gallery-img-wrap {
    height: 200px;
    background: #0f172a;
    overflow: hidden;
    position: relative;
    cursor: pointer;
}

.gallery-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.gallery-item-card:hover .gallery-img-wrap img {
    transform: scale(1.06);
}

.gallery-zoom-overlay {
    position: absolute;
    inset: 0;
    background: rgba(4, 61, 91, 0.45);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s ease;
    color: #ffffff;
    font-size: 20px;
}

.gallery-item-card:hover .gallery-zoom-overlay {
    opacity: 1;
}

.gallery-card-body {
    padding: 18px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.gallery-card-title {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 6px 0;
    line-height: 1.4;
}

.gallery-card-desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 16px 0;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.gallery-card-meta {
    font-size: 11.5px;
    color: #94a3b8;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.gallery-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}

.badge-gallery-live {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-gallery-pending {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-delete-card {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none !important;
    transition: all 0.15s ease;
    cursor: pointer;
}

.btn-delete-card:hover {
    background: #dc2626;
    color: #ffffff !important;
}

/* Lightbox Modal */
.gallery-modal {
    display: none;
    position: fixed;
    z-index: 999999;
    inset: 0;
    background: rgba(15, 23, 42, 0.88);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.gallery-modal.show {
    display: flex;
}

.gallery-modal-content {
    background: #ffffff;
    border-radius: 16px;
    max-width: 800px;
    width: 100%;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    animation: modalPop 0.2s ease-out;
}

@keyframes modalPop {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.modal-img-container {
    max-height: 480px;
    background: #0f172a;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.modal-img-container img {
    max-height: 480px;
    width: 100%;
    object-fit: contain;
}

.modal-info-body {
    padding: 20px 24px;
}

.modal-info-body h3 {
    font-size: 18px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 6px 0;
}

.modal-info-body p {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.6;
    margin: 0 0 12px 0;
}

.modal-close-btn {
    background: #f1f5f9;
    border: none;
    color: #475569;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
}

.modal-close-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="gallery-list-wrap">

        <!-- Page Header -->
        <div class="gallery-list-header">
            <div>
                <h1>
                    <i class="fa fa-th-large" style="color: #00a896;"></i>
                    Hospital Gallery Showcase
                </h1>
                <p>Manage high-resolution infrastructure photos, specialized OT units, and wards visible to patients.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/gallery');?>" class="btn-add-gallery">
                    <i class="fa fa-cloud-upload"></i> Upload New Photo
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <?php 
            $totalCount = !empty($gallery) ? count($gallery) : 0;
            $liveCount = 0;
            if(!empty($gallery)) {
                foreach($gallery as $g) {
                    if(isset($g['status']) && ($g['status'] == 'A' || $g['status'] == '1')) {
                        $liveCount++;
                    }
                }
            }
        ?>

        <!-- Metric Stat Cards -->
        <div class="gallery-stats-grid">
            <div class="gallery-stat-card">
                <div class="gallery-stat-info">
                    <h3><?=$totalCount;?></h3>
                    <p>Total Photos</p>
                </div>
                <div class="gallery-stat-icon teal">
                    <i class="fa fa-picture-o"></i>
                </div>
            </div>

            <div class="gallery-stat-card">
                <div class="gallery-stat-info">
                    <h3><?=$liveCount;?></h3>
                    <p>Live on Upchar Portal</p>
                </div>
                <div class="gallery-stat-icon green">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>

            <div class="gallery-stat-card">
                <div class="gallery-stat-info">
                    <h3 style="font-size: 20px; font-weight: 700;">JPG, PNG, WEBP</h3>
                    <p>Supported Formats</p>
                </div>
                <div class="gallery-stat-icon blue">
                    <i class="fa fa-file-image-o"></i>
                </div>
            </div>
        </div>

        <!-- Filter / Search Bar -->
        <?php if(!empty($gallery)): ?>
            <div class="gallery-filter-bar">
                <div class="gallery-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" id="gallerySearchInput" class="gallery-search-input" placeholder="Search by photo caption or description..." onkeyup="filterGalleryCards();">
                </div>
                <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                    Showing <span id="visibleGalleryCount"><?=$totalCount;?></span> of <?=$totalCount;?> photos
                </div>
            </div>
        <?php endif; ?>

        <!-- Gallery Grid -->
        <?php if(!empty($gallery)): ?>
            <div class="gallery-grid-cards" id="galleryCardsGrid">
                <?php foreach($gallery as $p): 
                    $title = !empty($p['shot_description']) ? $p['shot_description'] : 'Hospital Facility Photo';
                    $desc  = !empty($p['long_description']) ? $p['long_description'] : 'Clinical facility and infrastructure showcase.';
                    $imgUrl = base_url('admin1947/public/assets/upload/'.$p['image']);
                    $isLive = (!isset($p['status']) || $p['status'] == 'A' || $p['status'] == '1');
                    $dateFormatted = !empty($p['date']) ? date('M d, Y', strtotime($p['date'])) : '';
                ?>
                    <div class="gallery-item-card" data-title="<?=strtolower(html_escape($title));?>" data-desc="<?=strtolower(html_escape($desc));?>">
                        <div class="gallery-img-wrap" onclick="openLightbox('<?=addslashes($imgUrl);?>', '<?=addslashes(html_escape($title));?>', '<?=addslashes(html_escape($desc));?>', '<?=$dateFormatted;?>');">
                            <img src="<?=$imgUrl;?>" alt="<?=html_escape($title);?>" onerror="this.src='<?=base_url();?>images/default-facility.jpg';">
                            <div class="gallery-zoom-overlay">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>

                        <div class="gallery-card-body">
                            <div>
                                <h3 class="gallery-card-title"><?=html_escape($title);?></h3>
                                <p class="gallery-card-desc"><?=html_escape($desc);?></p>
                            </div>

                            <?php if(!empty($dateFormatted)): ?>
                                <div class="gallery-card-meta">
                                    <i class="fa fa-calendar-o"></i> Uploaded <?=html_escape($dateFormatted);?>
                                </div>
                            <?php endif; ?>

                            <div class="gallery-card-footer">
                                <div>
                                    <?php if($isLive): ?>
                                        <span class="badge-gallery-live"><i class="fa fa-check-circle"></i> Live on Portal</span>
                                    <?php else: ?>
                                        <span class="badge-gallery-pending"><i class="fa fa-clock-o"></i> In Review</span>
                                    <?php endif; ?>
                                </div>
                                <div style="display: flex; gap: 6px;">
                                    <button type="button" class="btn-delete-card" style="background: #e0f2fe; color: #0284c7;" onclick="openLightbox('<?=addslashes($imgUrl);?>', '<?=addslashes(html_escape($title));?>', '<?=addslashes(html_escape($desc));?>', '<?=$dateFormatted;?>');">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                    <a href="<?=base_url('hospitalpanel/delete_gallery/'.$p['id']);?>" onclick="return confirm('Are you sure you want to delete this photo from your gallery?');" class="btn-delete-card">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 64px 20px; background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);">
                <div style="width: 72px; height: 72px; background: #ccfbf1; color: #00a896; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 16px auto;">
                    <i class="fa fa-picture-o"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">No Gallery Photos Uploaded Yet</h3>
                <p style="font-size: 13.5px; color: #64748b; max-width: 500px; margin: 0 auto 22px auto; line-height: 1.5;">
                    High-quality photos of your hospital entrance, ICU, deluxe patient rooms, and diagnostic labs significantly boost patient trust and appointment bookings.
                </p>
                <a href="<?=base_url('hospitalpanel/gallery');?>" class="btn-add-gallery">
                    <i class="fa fa-cloud-upload"></i> Upload First Facility Photo
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Fullscreen Lightbox Modal -->
<div class="gallery-modal" id="galleryLightboxModal" onclick="if(event.target === this) closeLightbox();">
    <div class="gallery-modal-content">
        <div class="modal-img-container">
            <img id="lightboxImg" src="" alt="Full view">
        </div>
        <div class="modal-info-body">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <div>
                    <h3 id="lightboxTitle">Facility Photo</h3>
                    <span id="lightboxDate" style="font-size: 12px; color: #94a3b8; font-weight: 600;"></span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeLightbox();">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
            <p id="lightboxDesc"></p>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function openLightbox(imgUrl, title, desc, date) {
    document.getElementById('lightboxImg').src = imgUrl;
    document.getElementById('lightboxTitle').innerText = title;
    document.getElementById('lightboxDesc').innerText = desc;
    document.getElementById('lightboxDate').innerText = date ? 'Uploaded on ' + date : '';
    document.getElementById('galleryLightboxModal').classList.add('show');
}

function closeLightbox() {
    document.getElementById('galleryLightboxModal').classList.remove('show');
}

// Close on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});

// Client-side search filter
function filterGalleryCards() {
    var filter = document.getElementById('gallerySearchInput').value.toLowerCase().trim();
    var cards = document.querySelectorAll('#galleryCardsGrid .gallery-item-card');
    var visible = 0;

    cards.forEach(function(card) {
        var title = card.getAttribute('data-title') || '';
        var desc = card.getAttribute('data-desc') || '';
        if (title.indexOf(filter) > -1 || desc.indexOf(filter) > -1) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    var countElem = document.getElementById('visibleGalleryCount');
    if (countElem) countElem.innerText = visible;
}
</script>
