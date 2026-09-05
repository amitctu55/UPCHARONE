<?php include('includes/header.php'); ?>

<style>
/* Medical & Pharmacy Network Styling */
.medical-hero-banner {
    background: linear-gradient(135deg, #0A2540 0%, #1D2A44 60%, #004D40 100%);
    padding: 50px 0 40px;
    color: #FFFFFF;
    position: relative;
    overflow: hidden;
}
.medical-hero-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(0, 168, 150, 0.25) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.medical-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 168, 150, 0.2);
    border: 1px solid rgba(0, 168, 150, 0.5);
    color: #2DD4BF;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 14px;
}
.medical-hero-title {
    font-size: 32px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 10px;
}
.medical-hero-desc {
    font-size: 15px;
    color: #CBD5E1;
    max-width: 680px;
    line-height: 1.6;
    margin: 0 0 20px;
}
.category-filter-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 28px 0 24px;
}
.cat-filter-btn {
    background: #FFFFFF;
    color: #334155;
    border: 1px solid #CBD5E1;
    border-radius: 24px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.cat-filter-btn:hover {
    background: #F1F5F9;
    color: #0F172A;
    border-color: #94A3B8;
}
.cat-filter-btn.active {
    background: #00A896;
    color: #FFFFFF;
    border-color: #00A896;
    box-shadow: 0 3px 8px rgba(0, 168, 150, 0.35);
}
.offer-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.offer-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.09);
}
.offer-card.highlighted-offer {
    border: 2px solid #F59E0B;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2), 0 10px 25px rgba(0,0,0,0.1);
    position: relative;
}
.offer-img-box {
    position: relative;
    height: 190px;
    overflow: hidden;
    background: #0F172A;
}
.offer-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.offer-card:hover .offer-img-box img {
    transform: scale(1.05);
}
.offer-badge-tag {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.88);
    backdrop-filter: blur(4px);
    color: #2DD4BF;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid rgba(45, 212, 191, 0.4);
}
.offer-cat-tag {
    position: absolute;
    bottom: 10px;
    right: 12px;
    background: rgba(0, 0, 0, 0.65);
    color: #FFFFFF;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 4px;
    text-transform: uppercase;
}
.offer-body {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.offer-title {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 8px;
    line-height: 1.35;
}
.offer-short-desc {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.5;
    margin: 0 0 12px;
}
.offer-long-desc {
    font-size: 12.5px;
    color: #64748B;
    background: #F8FAFC;
    border-left: 3px solid #00A896;
    padding: 8px 12px;
    border-radius: 0 6px 6px 0;
    margin: 0 0 16px;
    line-height: 1.5;
}
.offer-footer {
    border-top: 1px solid #F1F5F9;
    padding-top: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.badge-highlight-pin {
    background: #F59E0B;
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 0 0 8px 8px;
    position: absolute;
    top: 0;
    right: 18px;
    z-index: 10;
    box-shadow: 0 2px 6px rgba(245, 158, 11, 0.4);
}
.partner-cta-box {
    background: linear-gradient(135deg, #F0FDF4 0%, #E6FFFA 100%);
    border: 1px solid #A7F3D0;
    border-radius: 16px;
    padding: 28px;
    margin-top: 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}
</style>

<!-- Hero Section -->
<section class="medical-hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="medical-hero-badge">
                    <i class="fas fa-pills"></i> Upchar Verified Healthcare Network
                </div>
                <h1 class="medical-hero-title">Pharmacy, Medicines &amp; Medical Devices</h1>
                <p class="medical-hero-desc">
                    Explore verified partner pharmacies, genuine prescription medicines, 24/7 doorstep delivery, and clinically validated smart healthcare monitors across Lucknow and Uttar Pradesh.
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="tel:8448440603" class="btn" style="background: #00A896; color: #fff; font-weight: 700; border-radius: 8px; padding: 10px 22px;">
                        <i class="fas fa-phone-alt"></i> Pharmacy Helpline: 8448440603
                    </a>
                    <a href="<?=base_url('medical-login');?>" class="btn" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                        <i class="fas fa-store"></i> Chemist Partner Portal
                    </a>
                </div>
            </div>
            <div class="col-md-4 hidden-xs hidden-sm text-center">
                <img src="https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=450&auto=format&fit=crop&q=80" alt="Medical Devices" style="max-height: 220px; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 2px solid rgba(255,255,255,0.1);">
            </div>
        </div>
    </div>
</section>

<!-- Filter Navigation -->
<div class="container">
    <div class="category-filter-nav">
        <a href="<?=base_url('medical');?>" class="cat-filter-btn <?=$selected_category === 'all' ? 'active' : '';?>">
            <i class="fas fa-th-large"></i> All Offers &amp; Devices
        </a>
        <a href="<?=base_url('medical?category=equipment');?>" class="cat-filter-btn <?=$selected_category === 'equipment' ? 'active' : '';?>">
            <i class="fas fa-heartbeat"></i> Medical Devices &amp; Monitors
        </a>
        <a href="<?=base_url('medical?category=medicine');?>" class="cat-filter-btn <?=$selected_category === 'medicine' ? 'active' : '';?>">
            <i class="fas fa-prescription-bottle-alt"></i> Prescription Medicines
        </a>
        <a href="<?=base_url('medical?category=medical_store');?>" class="cat-filter-btn <?=$selected_category === 'medical_store' ? 'active' : '';?>">
            <i class="fas fa-clinic-medical"></i> Verified Medical Stores
        </a>
        <a href="<?=base_url('mytest');?>" class="cat-filter-btn">
            <i class="fas fa-flask"></i> Diagnostic Lab Tests
        </a>
    </div>

    <!-- Offers Grid -->
    <div class="row" style="margin-bottom: 40px;">
        <?php if (!empty($offers)): ?>
            <?php foreach ($offers as $offer): 
                $imgSrc = filter_var($offer->image, FILTER_VALIDATE_URL) ? $offer->image : base_url('public/assets/upload/' . $offer->image);
                $isHighlighted = ($highlight_offer && $highlight_offer == $offer->id);
                $cat = $offer->category ?: 'general';
            ?>
            <div class="col-md-4 col-sm-6" style="margin-bottom: 24px;">
                <div class="offer-card <?=$isHighlighted ? 'highlighted-offer' : '';?>" id="offer-card-<?=$offer->id;?>">
                    <?php if ($isHighlighted): ?>
                        <div class="badge-highlight-pin">
                            <i class="fas fa-check-circle"></i> Selected Offer
                        </div>
                    <?php endif; ?>

                    <div class="offer-img-box">
                        <img src="<?=$imgSrc;?>" alt="<?=html_escape($offer->title);?>" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500';">
                        <span class="offer-badge-tag">
                            <i class="fas fa-shield-alt"></i> <?=html_escape($offer->sponsor_badge ?: 'Verified Partner');?>
                        </span>
                        <span class="offer-cat-tag">
                            <?=str_replace('_', ' ', $cat);?>
                        </span>
                    </div>

                    <div class="offer-body">
                        <div>
                            <h3 class="offer-title"><?=html_escape($offer->title);?></h3>
                            <p class="offer-short-desc"><?=html_escape($offer->short_description);?></p>
                            <?php if (!empty($offer->long_description)): ?>
                                <div class="offer-long-desc">
                                    <i class="fas fa-check" style="color: #00A896; margin-right: 4px;"></i>
                                    <?=html_escape($offer->long_description);?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="offer-footer">
                            <span style="font-size: 12px; color: #0284C7; font-weight: 700;">
                                <i class="fas fa-check-double"></i> 100% Genuine Certified
                            </span>
                            <div style="display: flex; gap: 6px;">
                                <a href="tel:8448440603" class="btn btn-sm" style="background: #00A896; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 6px 14px; font-size: 12px; text-decoration: none;">
                                    <i class="fas fa-phone-alt"></i> Inquire Now
                                </a>
                                <?php if (!empty($offer->link_url) && !preg_match('#(medical|upchar\.info/medical)#i', $offer->link_url)): ?>
                                    <a href="<?=html_escape($offer->link_url);?>" target="_blank" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px; padding: 6px 10px; font-size: 12px;">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-xs-12 text-center" style="padding: 60px 20px;">
                <i class="fas fa-pills" style="font-size: 48px; color: #CBD5E1; margin-bottom: 14px;"></i>
                <h4 style="color: #64748B; font-weight: 700;">No offers currently listed in this category</h4>
                <a href="<?=base_url('medical');?>" class="btn btn-sm" style="background: #00A896; color: #fff; margin-top: 10px; border-radius: 6px;">View All Offers</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Partner Chemist Banner -->
    <div class="partner-cta-box">
        <div>
            <h3 style="font-size: 20px; font-weight: 800; color: #065F46; margin: 0 0 6px;">
                <i class="fas fa-store-alt" style="color: #059669; margin-right: 6px;"></i> Are you a Pharmacy, Medical Store or Device Distributor?
            </h3>
            <p style="font-size: 14px; color: #047857; margin: 0; max-width: 650px;">
                Join India's fastest growing digital health network. List your pharmacy store, manage online prescription orders, and expand your local reach on Upchar.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?=base_url('medical-signup');?>" class="btn" style="background: #059669; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 10px 20px;">
                <i class="fas fa-user-plus"></i> Register Medical Store
            </a>
            <a href="<?=base_url('medical-login');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; padding: 10px 18px; border-color: #6EE7B7;">
                <i class="fas fa-sign-in-alt"></i> Partner Login
            </a>
        </div>
    </div>
</div>

<div style="height: 40px;"></div>

<?php if ($highlight_offer): ?>
<script>
$(document).ready(function() {
    var targetEl = $('#offer-card-<?=intval($highlight_offer);?>');
    if (targetEl.length) {
        $('html, body').animate({
            scrollTop: targetEl.offset().top - 120
        }, 600);
    }
});
</script>
<?php endif; ?>

<?php include('includes/footer.php'); ?>
