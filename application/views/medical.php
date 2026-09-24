<?php include('includes/header.php'); ?>

<style>
/* ==========================================================================
   UPCHAR Medical & Pharmacy Network - Refactored Design System
   ========================================================================== */

/* Hero Banner */
.pharmacy-hero {
    background: linear-gradient(135deg, #062330 0%, #0A364A 50%, #084B60 100%);
    color: #FFFFFF;
    padding: 50px 0 42px;
    position: relative;
    overflow: hidden;
}
.pharmacy-hero::before {
    content: '';
    position: absolute;
    top: -20%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(0, 168, 255, 0.16) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.pharmacy-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 420px;
    height: 420px;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.pharmacy-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 920px;
    margin: 0 auto;
}
.pharmacy-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 168, 255, 0.16);
    border: 1px solid rgba(56, 189, 248, 0.45);
    color: #38BDF8;
    padding: 6px 16px;
    border-radius: 24px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 16px;
    letter-spacing: 0.4px;
}
.pharmacy-hero-title {
    font-size: 34px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 12px;
    color: #FFFFFF;
    letter-spacing: -0.5px;
}
.pharmacy-hero-desc {
    font-size: 15.5px;
    color: #CBD5E1;
    line-height: 1.6;
    margin: 0 auto 26px;
    max-width: 740px;
}

/* Global Search Bar */
.pharmacy-search-wrapper {
    background: #FFFFFF;
    border-radius: 14px;
    padding: 8px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.28);
    margin: 0 auto 18px;
}
.pharmacy-search-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.pharmacy-search-input-box {
    flex: 2;
    min-width: 260px;
    position: relative;
}
.pharmacy-search-input-box i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
}
.pharmacy-search-input {
    width: 100%;
    height: 50px;
    padding: 8px 16px 8px 46px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    font-size: 15px;
    color: #0F172A;
    background: #F8FAFC;
    outline: none;
    transition: all 0.2s ease;
}
.pharmacy-search-input:focus {
    border-color: #00A8FF;
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(0, 168, 255, 0.15);
}
.pharmacy-location-select-box {
    flex: 1;
    min-width: 200px;
    position: relative;
}
.pharmacy-location-select-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #0284C7;
    font-size: 15px;
    pointer-events: none;
}
.pharmacy-location-select {
    width: 100%;
    height: 50px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 0 14px 0 38px;
    font-size: 14px;
    color: #334155;
    background: #F8FAFC;
    outline: none;
    transition: all 0.2s ease;
}
.pharmacy-location-select:focus {
    border-color: #00A8FF;
    background: #FFFFFF;
}
.pharmacy-search-btn {
    height: 50px;
    background: #00A8FF;
    color: #FFFFFF;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    padding: 0 28px;
    font-size: 15px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
}
.pharmacy-search-btn:hover {
    background: #0090DC;
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(0, 168, 255, 0.4);
}

/* Quick Search Suggestions */
.quick-tags-box {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 14px;
}
.quick-tag-label {
    font-size: 12.5px;
    color: #94A3B8;
    font-weight: 600;
}
.quick-tag-pill {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    color: #E2E8F0;
    padding: 4px 12px;
    border-radius: 18px;
    font-size: 12.5px;
    text-decoration: none;
    transition: all 0.2s ease;
}
.quick-tag-pill:hover {
    background: #00A8FF;
    border-color: #00A8FF;
    color: #FFFFFF;
    text-decoration: none;
    transform: translateY(-1px);
}

/* Hero Trust Ticker */
.hero-trust-ticker {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
    font-size: 12.5px;
    color: #94A3B8;
}
.hero-trust-ticker span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.hero-trust-ticker i {
    color: #38BDF8;
}

/* ==========================================================================
   Quick Services Action Grid (4-Feature Service Bar)
   ========================================================================== */
.pharmacy-features-section {
    margin-top: -30px;
    position: relative;
    z-index: 3;
    margin-bottom: 28px;
}
.feature-service-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    padding: 18px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: #1E293B;
    transition: all 0.25s ease;
    height: 100%;
    cursor: pointer;
}
.feature-service-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    border-color: #00A8FF;
    text-decoration: none;
    color: #08364B;
}
.feature-service-card.active-service {
    border-color: #00A8FF;
    background: #F0F9FF;
    box-shadow: 0 0 0 2px rgba(0, 168, 255, 0.35);
}
.feature-icon-box {
    width: 48px;
    height: 48px;
    min-width: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: transform 0.2s ease;
}
.feature-service-card:hover .feature-icon-box {
    transform: scale(1.08);
}
.feature-icon-delivery {
    background: #E0F2FE;
    color: #0284C7;
}
.feature-icon-rx {
    background: #DCFCE7;
    color: #10B981;
}
.feature-icon-affiliated {
    background: #F3E8FF;
    color: #8B5CF6;
}
.feature-icon-open24 {
    background: #FEF3C7;
    color: #D97706;
}
.feature-info h4 {
    font-size: 14.5px;
    font-weight: 800;
    margin: 0 0 3px;
    color: #08364B;
    display: flex;
    align-items: center;
    gap: 6px;
}
.feature-info p {
    font-size: 12px;
    color: #64748B;
    margin: 0;
    line-height: 1.4;
}
.feature-status-pill {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 10px;
    background: #00A8FF;
    color: #FFFFFF;
    text-transform: uppercase;
}

/* ==========================================================================
   Filter & Search Results Toolbar
   ========================================================================== */
.pharmacy-filter-toolbar {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 14px 18px;
    margin-bottom: 26px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.pharmacy-nav-pills {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.pharmacy-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 700;
    color: #475569;
    background: #F1F5F9;
    border: 1px solid #E2E8F0;
    text-decoration: none;
    transition: all 0.2s ease;
}
.pharmacy-pill-btn:hover {
    background: #E2E8F0;
    color: #0F172A;
    text-decoration: none;
}
.pharmacy-pill-btn.active {
    background: #08364B;
    color: #FFFFFF;
    border-color: #08364B;
    box-shadow: 0 3px 8px rgba(8, 54, 75, 0.25);
}
.pharmacy-pill-btn.active i {
    color: #38BDF8 !important;
}

/* ==========================================================================
   Store Spotlight Banner (When store_id is selected)
   ========================================================================== */
.store-spotlight-card {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #BAE6FD;
    box-shadow: 0 6px 24px rgba(0, 168, 255, 0.08);
    padding: 24px 28px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.store-spotlight-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #08364B 0%, #00A8FF 100%);
}
.store-spotlight-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 16px;
}
.store-spotlight-title {
    font-size: 24px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.store-spotlight-desc {
    font-size: 14px;
    color: #64748B;
    margin: 0 0 12px;
}
.store-spotlight-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

/* ==========================================================================
   Medicine Search & Store Inventory Results Cards
   ========================================================================== */
.med-result-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    margin-bottom: 22px;
    padding: 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    height: calc(100% - 22px);
    position: relative;
    overflow: hidden;
}
.med-result-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
    border-color: #CBD5E1;
}
.med-result-card.doctor-affiliated-border {
    border-left: 4px solid #00A8FF;
}
.med-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 12px;
}
.med-title {
    font-size: 18px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.med-composition {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}
.med-tag {
    display: inline-block;
    padding: 3px 9px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}
.med-tag-otc {
    background: #ECFDF5;
    color: #059669;
    border: 1px solid #A7F3D0;
}
.med-tag-rx {
    background: #FEF2F2;
    color: #DC2626;
    border: 1px solid #FECACA;
}

/* Store details inside medicine card */
.med-store-badge {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 12px 14px;
    margin: 12px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.med-store-name {
    font-size: 14px;
    font-weight: 700;
    color: #0F172A;
    display: flex;
    align-items: center;
    gap: 6px;
}
.med-pricing-block {
    display: flex;
    align-items: baseline;
    gap: 10px;
}
.med-price {
    font-size: 22px;
    font-weight: 800;
    color: #059669;
}
.med-mrp {
    font-size: 13.5px;
    color: #94A3B8;
    text-decoration: line-through;
}
.med-discount-tag {
    background: #DEF7EC;
    color: #03543F;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 8px;
}

/* ==========================================================================
   Pharmacy Store Directory Cards (Equal Heights & Clean Alignment)
   ========================================================================== */
.pharmacy-grid {
    display: flex;
    flex-wrap: wrap;
}
.pharmacy-grid > [class*='col-'] {
    display: flex;
    flex-direction: column;
}
.pharmacy-store-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    overflow: hidden;
    position: relative;
}
.pharmacy-store-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.09);
    border-color: #00A8FF;
}
.pharmacy-store-card.has-affiliation {
    border-top: 3px solid #00A8FF;
}
.affil-badge {
    background: linear-gradient(90deg, #08364B 0%, #00A8FF 100%);
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 800;
    padding: 5px 12px;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.pharmacy-card-body {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}
.pharmacy-title {
    font-size: 17px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 6px;
}
.pharmacy-meta {
    font-size: 13px;
    color: #64748B;
    line-height: 1.5;
    margin-bottom: 12px;
}
.pharmacy-affil-box {
    background: #F0F9FF;
    border: 1px solid #BAE6FD;
    border-radius: 8px;
    padding: 7px 12px;
    font-size: 12px;
    color: #0369A1;
    margin-bottom: 12px;
}
.pharmacy-perks {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 16px;
}
.pharmacy-perk-badge {
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.perk-delivery {
    background: #E0F2FE;
    color: #0369A1;
}
.perk-open {
    background: #DCFCE7;
    color: #15803D;
    font-weight: 700;
}
.perk-verified {
    background: #FEF3C7;
    color: #B45309;
}
.pharmacy-card-footer-wrapper {
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #F1F5F9;
}
.pharmacy-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
}

/* ==========================================================================
   3-Step Prescription Workflow Banner
   ========================================================================== */
.rx-process-banner {
    background: linear-gradient(135deg, #F0FDF4 0%, #E6FFFA 100%);
    border: 1px solid #A7F3D0;
    border-radius: 16px;
    padding: 28px 24px;
    margin: 32px 0 28px;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.06);
}
.rx-process-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 24px;
}
.rx-process-header h3 {
    font-size: 22px;
    font-weight: 800;
    color: #065F46;
    margin: 0 0 6px;
}
.rx-process-header p {
    font-size: 14px;
    color: #047857;
    margin: 0;
}
.rx-steps-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.rx-step-item {
    flex: 1;
    min-width: 220px;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid #BBF7D0;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.rx-step-number {
    width: 32px;
    height: 32px;
    min-width: 32px;
    background: #10B981;
    color: #FFFFFF;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
}
.rx-step-text h5 {
    font-size: 14px;
    font-weight: 800;
    color: #065F46;
    margin: 0 0 3px;
}
.rx-step-text p {
    font-size: 12px;
    color: #047857;
    margin: 0;
    line-height: 1.4;
}
.rx-cta-box {
    text-align: center;
}
.rx-cta-btn {
    background: #059669;
    color: #FFFFFF;
    font-weight: 700;
    border-radius: 8px;
    padding: 12px 28px;
    font-size: 15px;
    border: none;
    box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}
.rx-cta-btn:hover {
    background: #047857;
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(5, 150, 105, 0.4);
}

/* ==========================================================================
   Chemist Onboarding Box
   ========================================================================== */
.chemist-join-box {
    background: #F8FAFC;
    border: 1px dashed #CBD5E1;
    border-radius: 14px;
    padding: 24px;
    margin-top: 30px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pharmacy-hero {
        padding: 36px 0 28px;
    }
    .pharmacy-hero-title {
        font-size: 24px;
    }
    .pharmacy-search-form {
        flex-direction: column;
    }
    .pharmacy-search-input-box,
    .pharmacy-location-select-box,
    .pharmacy-search-btn {
        width: 100%;
        min-width: 100%;
    }
    .pharmacy-features-section {
        margin-top: -15px;
    }
    .feature-service-card {
        padding: 14px 12px;
    }
    .feature-icon-box {
        width: 40px;
        height: 40px;
        min-width: 40px;
        font-size: 16px;
    }
    .pharmacy-filter-toolbar {
        flex-direction: column;
        align-items: flex-start;
    }
    .store-spotlight-card {
        padding: 18px;
    }
    .store-spotlight-title {
        font-size: 20px;
    }
}

/* Floating Cart Button */
.upchar-floating-cart {
    position: fixed;
    bottom: 26px;
    right: 26px;
    background: #08364B;
    color: #FFFFFF;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 6px 22px rgba(8, 54, 75, 0.4);
    z-index: 1040;
    text-decoration: none;
    transition: all 0.25s ease;
}
.upchar-floating-cart:hover {
    background: #00A8FF;
    color: #FFFFFF;
    transform: scale(1.08);
    box-shadow: 0 8px 26px rgba(0, 168, 255, 0.5);
    text-decoration: none;
}
.cart-floating-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: #E11D48;
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 800;
    min-width: 22px;
    height: 22px;
    line-height: 20px;
    border-radius: 11px;
    text-align: center;
    border: 2px solid #FFFFFF;
}
</style>

<!-- 1. Hero Section: Centralized, Spacious Search & Discovery -->
<section class="pharmacy-hero">
    <div class="container">
        <div class="pharmacy-hero-content">
            <div class="pharmacy-hero-badge">
                <i class="fas fa-shield-alt"></i> UPCHAR Verified Pharmacy &amp; Medicine Network
            </div>
            <h1 class="pharmacy-hero-title">Online Medicine Stock &amp; Local Pharmacies</h1>
            <p class="pharmacy-hero-desc">
                Search medicines across licensed retail pharmacies in your city, check real-time stock availability, compare prices, or get fast doorstep delivery from verified chemists.
            </p>

            <!-- Global Search Form -->
            <div class="pharmacy-search-wrapper">
                <form action="<?=base_url('medical');?>" method="GET" class="pharmacy-search-form">
                    <div class="pharmacy-search-input-box">
                        <i class="fas fa-search"></i>
                        <input type="text" 
                               name="q" 
                               class="pharmacy-search-input" 
                               placeholder="Search medicine name or generic salt (e.g. Paracetamol, Dolo 650, Augmentin)..." 
                               value="<?=html_escape($search_query);?>" 
                               autocomplete="off"
                               id="globalMedicineInput">
                    </div>

                    <div class="pharmacy-location-select-box">
                        <i class="fas fa-map-marker-alt"></i>
                        <select name="pincode" class="pharmacy-location-select">
                            <option value="">All Locations / Cities</option>
                            <?php if (!empty($available_locations)): ?>
                                <?php foreach ($available_locations as $loc): ?>
                                    <option value="<?=$loc->pincode;?>" <?=$pincode == $loc->pincode ? 'selected' : '';?>>
                                        <?=$loc->city;?> (<?=$loc->pincode;?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="Varanasi">Varanasi</option>
                                <option value="Lucknow">Lucknow</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <?php if ($service !== 'all'): ?>
                        <input type="hidden" name="service" value="<?=html_escape($service);?>">
                    <?php endif; ?>

                    <?php if ($filter_store > 0): ?>
                        <input type="hidden" name="store_id" value="<?=$filter_store;?>">
                    <?php endif; ?>

                    <button type="submit" class="pharmacy-search-btn">
                        <i class="fas fa-search"></i> Check Stock
                    </button>
                </form>
            </div>

            <!-- Quick Tags -->
            <div class="quick-tags-box">
                <span class="quick-tag-label"><i class="fas fa-bolt" style="color: #F59E0B;"></i> Popular Searches:</span>
                <?php if (!empty($suggested_medicines)): ?>
                    <?php foreach ($suggested_medicines as $sug): ?>
                        <a href="<?=base_url('medical?q=' . urlencode($sug->brand_name) . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" class="quick-tag-pill">
                            <?=html_escape($sug->brand_name);?>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="<?=base_url('medical?q=Dolo+650');?>" class="quick-tag-pill">Dolo 650</a>
                    <a href="<?=base_url('medical?q=Augmentin+625');?>" class="quick-tag-pill">Augmentin 625 Duo</a>
                    <a href="<?=base_url('medical?q=Pan-D');?>" class="quick-tag-pill">Pan-D Capsule</a>
                    <a href="<?=base_url('medical?q=Azithral+500');?>" class="quick-tag-pill">Azithral 500</a>
                    <a href="<?=base_url('medical?q=Paracetamol');?>" class="quick-tag-pill">Paracetamol</a>
                <?php endif; ?>
            </div>

            <!-- Hero Trust Ticker -->
            <div class="hero-trust-ticker">
                <span><i class="fas fa-check-circle"></i> 100% Genuine Medicines</span>
                <span><i class="fas fa-certificate"></i> Licensed Form 20/21 Retailers</span>
                <span><i class="fas fa-hospital-user"></i> Hospital &amp; Doctor Affiliated</span>
                <span><i class="fas fa-motorcycle"></i> Doorstep Fast Delivery</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Auto-Arranged Quick Service Action Grid (4 Interactive Service Tiles) -->
<section class="pharmacy-features-section">
    <div class="container">
        <div class="row">
            <!-- Feature 1: Express Delivery -->
            <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom: 12px;">
                <a href="<?=base_url('medical?service=delivery' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : '') . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" 
                   class="feature-service-card <?=$service === 'delivery' ? 'active-service' : '';?>">
                    <div class="feature-icon-box feature-icon-delivery">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="feature-info">
                        <h4>
                            Home Delivery
                            <?php if ($service === 'delivery'): ?>
                                <span class="feature-status-pill">Active</span>
                            <?php endif; ?>
                        </h4>
                        <p>30–45 min local rider delivery</p>
                    </div>
                </a>
            </div>

            <!-- Feature 2: Upload Prescription -->
            <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom: 12px;">
                <div onclick="openPrescriptionModal()" class="feature-service-card">
                    <div class="feature-icon-box feature-icon-rx">
                        <i class="fas fa-file-prescription"></i>
                    </div>
                    <div class="feature-info">
                        <h4>Upload Rx <i class="fas fa-arrow-right" style="font-size: 11px; color: #10B981;"></i></h4>
                        <p>Instant pharmacist verification</p>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Doctor & Hospital Affiliated -->
            <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom: 12px;">
                <a href="<?=base_url('medical?service=affiliated' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : '') . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" 
                   class="feature-service-card <?=$service === 'affiliated' ? 'active-service' : '';?>">
                    <div class="feature-icon-box feature-icon-affiliated">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="feature-info">
                        <h4>
                            Affiliated Stores
                            <?php if ($service === 'affiliated'): ?>
                                <span class="feature-status-pill">Active</span>
                            <?php endif; ?>
                        </h4>
                        <p>Connected to hospital OPDs</p>
                    </div>
                </a>
            </div>

            <!-- Feature 4: 24/7 Open Emergency Chemists -->
            <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom: 12px;">
                <a href="<?=base_url('medical?service=open24' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : '') . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" 
                   class="feature-service-card <?=$service === 'open24' ? 'active-service' : '';?>">
                    <div class="feature-icon-box feature-icon-open24">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="feature-info">
                        <h4>
                            24/7 Emergency
                            <?php if ($service === 'open24'): ?>
                                <span class="feature-status-pill">Active</span>
                            <?php endif; ?>
                        </h4>
                        <p>Round-the-clock open stores</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 3. Smart Filter & Navigation Toolbar -->
<div class="container">
    <div class="pharmacy-filter-toolbar">
        <div class="pharmacy-nav-pills">
            <span style="font-size: 13px; font-weight: 700; color: #64748B; margin-right: 4px;">
                <i class="fas fa-sliders-h"></i> Filter Stores:
            </span>
            <a href="<?=base_url('medical' . ($search_query ? '?q=' . urlencode($search_query) : '') . ($filter_store > 0 ? ($search_query ? '&' : '?') . 'store_id=' . $filter_store : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'all' ? 'active' : '';?>">
                <i class="fas fa-th-large"></i> All Stores
            </a>
            <a href="<?=base_url('medical?service=delivery' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : '') . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'delivery' ? 'active' : '';?>">
                <i class="fas fa-motorcycle" style="color: #0284C7;"></i> Home Delivery
            </a>
            <a href="<?=base_url('medical?service=open24' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : '') . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'open24' ? 'active' : '';?>">
                <i class="fas fa-clock" style="color: #059669;"></i> 24/7 Open
            </a>
            <a href="<?=base_url('medical?service=affiliated' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : '') . ($filter_store > 0 ? '&store_id=' . $filter_store : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'affiliated' ? 'active' : '';?>">
                <i class="fas fa-user-md" style="color: #D97706;"></i> Hospital Affiliated
            </a>
        </div>

        <div>
            <?php if (!empty($current_store)): ?>
                <span style="font-size: 12.5px; background: #E0F2FE; color: #0284C7; font-weight: 700; padding: 5px 12px; border-radius: 14px; margin-right: 8px;">
                    <i class="fas fa-store"></i> Store: <?=html_escape($current_store->store_name);?>
                </span>
            <?php endif; ?>

            <?php if ($search_query || $pincode || $service !== 'all' || $filter_store): ?>
                <a href="<?=base_url('medical');?>" style="font-size: 12.5px; color: #EF4444; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-times-circle"></i> Clear Filters
                </a>
            <?php else: ?>
                <span style="font-size: 12.5px; color: #64748B; font-weight: 600;">
                    <i class="fas fa-map-marker-alt" style="color: #00A8FF;"></i> <?=!empty($pincode) ? html_escape($pincode) : 'All Locations';?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- 4. Main Body: Results & Store Directory -->
<div class="container">

    <!-- Specific Store Spotlight (When store_id is selected) -->
    <?php if (!empty($current_store)): 
        $hasAffilStore = (!empty($current_store->hospital_id) || !empty($current_store->associated_doctor_id));
        $isOpen24Store = (stripos($current_store->operating_hours, '24') !== false);
    ?>
        <div class="store-spotlight-card">
            <div class="store-spotlight-header">
                <div>
                    <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #0284C7; margin-bottom: 4px;">
                        <i class="fas fa-store"></i> Selected Pharmacy Store Profile
                    </div>
                    <h2 class="store-spotlight-title">
                        <?=html_escape($current_store->store_name);?>
                        <?php if ($current_store->is_verified): ?>
                            <span title="Verified Drug License" style="color: #059669; font-size: 20px;">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        <?php endif; ?>
                    </h2>
                    <p class="store-spotlight-desc">
                        <i class="fas fa-map-marker-alt" style="color: #EF4444; margin-right: 4px;"></i>
                        <?=html_escape($current_store->address);?>, <?=html_escape($current_store->city);?> (<?=html_escape($current_store->pincode);?>)
                    </p>

                    <?php if (!empty($current_store->hospital_name) || !empty($current_store->doctor_name)): ?>
                        <div class="pharmacy-affil-box" style="margin-bottom: 12px; display: inline-block;">
                            <?php if (!empty($current_store->hospital_name)): ?>
                                <div><i class="fas fa-hospital"></i> <strong>Hospital:</strong> <?=html_escape($current_store->hospital_name);?></div>
                            <?php endif; ?>
                            <?php if (!empty($current_store->doctor_name)): ?>
                                <div><i class="fas fa-user-md"></i> <strong>Doctor:</strong> <?=html_escape($current_store->doctor_name);?></div>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($hasAffilStore): ?>
                        <div class="pharmacy-affil-box" style="margin-bottom: 12px; display: inline-block;">
                            <div><i class="fas fa-hospital-user"></i> <strong>Affiliation:</strong> Verified Healthcare Partner</div>
                        </div>
                    <?php endif; ?>

                    <div class="store-spotlight-badges">
                        <span class="pharmacy-perk-badge perk-verified">
                            <i class="fas fa-file-medical"></i> DL: <?=html_escape($current_store->drug_license_no ?: 'Form 20/21');?>
                        </span>
                        <?php if ($isOpen24Store): ?>
                            <span class="pharmacy-perk-badge perk-open">
                                <i class="fas fa-clock"></i> 24/7 Open
                            </span>
                        <?php else: ?>
                            <span class="pharmacy-perk-badge" style="background: #F1F5F9; color: #475569;">
                                <i class="far fa-clock"></i> <?=html_escape($current_store->operating_hours ?: '09:00 AM - 10:00 PM');?>
                            </span>
                        <?php endif; ?>
                        <?php if ($current_store->delivery_radius_km > 0): ?>
                            <span class="pharmacy-perk-badge perk-delivery">
                                <i class="fas fa-motorcycle"></i> <?=floatval($current_store->delivery_radius_km);?> km Delivery Radius
                            </span>
                        <?php endif; ?>
                        <span class="pharmacy-perk-badge" style="background: #ECFDF5; color: #059669; font-weight: 700;">
                            <i class="fas fa-boxes"></i> <?=count($medicine_results);?> Medicines In Stock
                        </span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <a href="tel:<?=html_escape($current_store->phone);?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; padding: 9px 18px;">
                        <i class="fas fa-phone-alt"></i> <?=html_escape($current_store->phone);?>
                    </a>
                    <button type="button" onclick="openPrescriptionModal()" class="btn" style="background: #10B981; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 9px 18px;">
                        <i class="fas fa-file-prescription"></i> Upload Rx for this Store
                    </button>
                    <a href="<?=base_url('medical');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px; padding: 9px 16px;">
                        <i class="fas fa-store-alt"></i> View All Stores
                    </a>
                </div>
            </div>

            <!-- In-Store Medicine Search Filter -->
            <form action="<?=base_url('medical');?>" method="GET" style="display: flex; gap: 8px; margin-top: 14px; max-width: 600px;">
                <input type="hidden" name="store_id" value="<?=$current_store->id;?>">
                <input type="text" 
                       name="q" 
                       value="<?=html_escape($search_query);?>" 
                       placeholder="Search medicines in <?=html_escape($current_store->store_name);?>..." 
                       class="form-control" 
                       style="border-radius: 8px; height: 42px; border: 1px solid #CBD5E1;">
                <button type="submit" class="btn" style="background: #08364B; color: #fff; font-weight: 700; border-radius: 8px; padding: 0 18px;">
                    <i class="fas fa-search"></i> Search
                </button>
                <?php if ($search_query !== ''): ?>
                    <a href="<?=base_url('medical?store_id=' . $current_store->id . '&q=');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center;">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>
    <?php endif; ?>


    <!-- Case A: Medicine Stock Results (Either global search or store inventory) -->
    <?php if ($search_query !== '' || !empty($current_store)): ?>
        <div style="margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div>
                <?php if (!empty($current_store)): ?>
                    <h2 style="font-size: 21px; font-weight: 800; color: #08364B; margin: 0 0 4px;">
                        <i class="fas fa-pills" style="color: #00A8FF;"></i> Available Stock at <?=html_escape($current_store->store_name);?>
                        <?php if ($search_query !== ''): ?>
                            <span style="font-size: 16px; color: #64748B; font-weight: 600;">(matching "<?=html_escape($search_query);?>")</span>
                        <?php endif; ?>
                    </h2>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0;">
                        Verified genuine stock available for immediate dispensing or fast doorstep delivery.
                    </p>
                <?php else: ?>
                    <h2 style="font-size: 21px; font-weight: 800; color: #08364B; margin: 0 0 4px;">
                        Search Results for <span style="color: #00A8FF;">"<?=html_escape($search_query);?>"</span>
                    </h2>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0;">
                        Showing certified partner pharmacies carrying verified inventory.
                    </p>
                <?php endif; ?>
            </div>
            <div>
                <span class="badge" style="background: #08364B; font-size: 13px; padding: 7px 14px; border-radius: 14px;">
                    <?=count($medicine_results);?> <?=count($medicine_results) === 1 ? 'Medicine Item' : 'Medicine Items';?>
                </span>
            </div>
        </div>

        <?php if (!empty($medicine_results)): ?>
            <div class="row pharmacy-grid">
                <?php foreach ($medicine_results as $med): 
                    $isAffiliated = (!empty($med->hospital_id) || !empty($med->associated_doctor_id));
                    $discountPct = ($med->mrp > $med->selling_price && $med->mrp > 0) ? round((($med->mrp - $med->selling_price) / $med->mrp) * 100) : 0;
                ?>
                <div class="col-md-6 col-sm-12" style="margin-bottom: 22px;">
                    <div class="med-result-card <?=$isAffiliated ? 'doctor-affiliated-border' : '';?>">
                        <div class="med-card-header">
                            <div>
                                <h3 class="med-title">
                                    <?=html_escape($med->brand_name);?>
                                    <span class="med-tag <?=$med->is_prescription_required ? 'med-tag-rx' : 'med-tag-otc';?>">
                                        <?=$med->is_prescription_required ? '<i class="fas fa-file-prescription"></i> Rx Required' : '<i class="fas fa-check"></i> OTC';?>
                                    </span>
                                    <span style="font-size: 11px; background: #F1F5F9; color: #475569; padding: 2px 8px; border-radius: 4px; font-weight: 600;">
                                        <?=html_escape($med->dosage_form ?: 'Medicine');?>
                                    </span>
                                </h3>
                                <p class="med-composition">
                                    <i class="fas fa-flask" style="color: #94A3B8; margin-right: 4px;"></i> <?=html_escape($med->generic_composition);?>
                                    <?php if (!empty($med->manufacturer)): ?>
                                        &bull; <span style="color: #64748B;"><?=html_escape($med->manufacturer);?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Store details & Affiliation (shown when not filtered to single store) -->
                        <div class="med-store-badge">
                            <div>
                                <div class="med-store-name">
                                    <i class="fas fa-store" style="color: #00A8FF;"></i> <?=html_escape($med->store_name);?>
                                </div>
                                <div style="font-size: 12px; color: #64748B; margin-top: 2px;">
                                    <i class="fas fa-map-marker-alt" style="color: #EF4444;"></i> <?=html_escape($med->store_address);?>, <?=html_escape($med->store_city);?> (<?=html_escape($med->store_pincode);?>)
                                </div>
                                <?php if ($isAffiliated): ?>
                                    <?php 
                                        $affilText = '';
                                        if (!empty($med->doctor_name)) {
                                            $affilText .= 'Attached to ' . html_escape($med->doctor_name);
                                        }
                                        if (!empty($med->hospital_name)) {
                                            $affilText .= !empty($affilText) ? ' (' . html_escape($med->hospital_name) . ')' : 'Attached to ' . html_escape($med->hospital_name);
                                        }
                                        if (empty($affilText)) {
                                            $affilText = 'Doctor &amp; Hospital Affiliated';
                                        }
                                    ?>
                                    <div style="font-size: 11px; color: #0284C7; font-weight: 700; margin-top: 4px;">
                                        <i class="fas fa-star" style="color: #F59E0B;"></i> <?=$affilText;?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Pricing -->
                            <div class="med-pricing-block">
                                <div>
                                    <div class="med-price">&#8377;<?=number_format($med->selling_price, 2);?></div>
                                    <?php if ($med->mrp > $med->selling_price): ?>
                                        <div style="display: flex; gap: 6px; align-items: center;">
                                            <span class="med-mrp">&#8377;<?=number_format($med->mrp, 2);?></span>
                                            <span class="med-discount-tag"><?=$discountPct;?>% OFF</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Stock and Batch Info -->
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #64748B; margin-bottom: 14px; flex-wrap: wrap; gap: 6px;">
                            <div>
                                <span style="color: #059669; font-weight: 700;">
                                    <i class="fas fa-check-circle"></i> In Stock (<?=$med->stock_quantity;?> units)
                                </span>
                                <?php if (!empty($med->batch_no)): ?>
                                    &bull; <span>Batch: <?=html_escape($med->batch_no);?></span>
                                <?php endif; ?>
                                <?php if (!empty($med->expiry_date)): ?>
                                    &bull; <span>Exp: <?=date('m/Y', strtotime($med->expiry_date));?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <?php if ($med->delivery_radius_km > 0): ?>
                                    <span style="color: #0284C7; font-weight: 600;">
                                        <i class="fas fa-motorcycle"></i> <?=floatval($med->delivery_radius_km);?> km delivery
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Action Buttons pushed to bottom -->
                        <div style="margin-top: auto; padding-top: 10px; display: flex; gap: 8px; justify-content: flex-end; flex-wrap: wrap;">
                            <a href="tel:<?=html_escape($med->store_phone);?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                                <i class="fas fa-phone-alt"></i> Call Store
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-add-cart-action" 
                                    style="background: #00A8FF; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 6px 14px; box-shadow: 0 2px 6px rgba(0, 168, 255, 0.3);"
                                    data-pharmacy-id="<?=$med->pharmacy_id ?? 1;?>"
                                    data-medicine-id="<?=$med->medicine_id ?? 1;?>"
                                    data-price="<?=$med->selling_price;?>"
                                    data-mrp="<?=$med->mrp;?>"
                                    data-brand-name="<?=html_escape($med->brand_name);?>"
                                    onclick="handleAddToCart(this, <?=$med->pharmacy_id ?? 1;?>, <?=$med->medicine_id ?? 1;?>, <?=$med->selling_price;?>, <?=$med->mrp;?>, '<?=addslashes(html_escape($med->brand_name));?>')">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                            <button type="button" 
                                    class="btn btn-sm btn-order-doorstep" 
                                    style="background: #9BC03C; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 6px 16px; box-shadow: 0 2px 6px rgba(155, 192, 60, 0.4);"
                                    data-pharmacy-id="<?=$med->pharmacy_id ?? 1;?>"
                                    data-medicine-id="<?=$med->medicine_id ?? 1;?>"
                                    data-price="<?=$med->selling_price;?>"
                                    data-brand-name="<?=html_escape($med->brand_name);?>"
                                    data-store-name="<?=html_escape($med->store_name);?>"
                                    data-eta="<?=html_escape($med->delivery_radius_km > 0 ? 'Within ' . $med->delivery_radius_km . ' km' : '20 - 30 mins');?>"
                                    onclick="initiateDoorstepOrder(<?=$med->pharmacy_id ?? 1;?>, <?=$med->medicine_id ?? 1;?>, <?=$med->selling_price;?>, '<?=addslashes(html_escape($med->brand_name));?>', '<?=addslashes(html_escape($med->store_name));?>', '<?=addslashes(html_escape($med->delivery_radius_km > 0 ? 'Within ' . $med->delivery_radius_km . ' km' : '20 - 30 mins'));?>')">
                                <i class="fas fa-shopping-bag"></i> Order Doorstep
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center" style="background: #FFFFFF; border: 1px dashed #CBD5E1; border-radius: 14px; padding: 42px 20px; margin-bottom: 30px;">
                <i class="fas fa-pills" style="font-size: 42px; color: #94A3B8; margin-bottom: 14px;"></i>
                <h3 style="font-size: 19px; font-weight: 800; color: #1E293B; margin: 0 0 8px;">
                    <?=!empty($current_store) ? 'No In-Stock Medicines Currently Cataloged for This Store' : 'No Stores Currently Have "' . html_escape($search_query) . '" In Stock';?>
                </h3>
                <p style="font-size: 14px; color: #64748B; max-width: 540px; margin: 0 auto 20px;">
                    Our healthcare team can source this medicine directly for you from our verified distribution network, or you can upload your doctor's prescription.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="openPrescriptionModal()" class="btn" style="background: #10B981; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 9px 20px;">
                        <i class="fas fa-file-prescription"></i> Upload Prescription
                    </button>
                    <a href="<?=base_url('medical');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px; padding: 9px 18px;">
                        View All Partner Pharmacies
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <hr style="border-top: 1px solid #E2E8F0; margin: 32px 0;">
    <?php endif; ?>


    <!-- Case B: Partner Pharmacies Directory (Clean 3-Column Responsive Grid) -->
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #08364B; margin: 0 0 4px;">
                <i class="fas fa-clinic-medical" style="color: #00A8FF;"></i> 
                <?=!empty($current_store) ? 'Other Certified Partner Pharmacies' : 'Verified Partner Pharmacies &amp; Chemist Stores';?>
            </h2>
            <p style="font-size: 14px; color: #64748B; margin: 0;">
                Licensed Form 20/21 retailers ready to fulfill prescriptions and OTC medicine orders.
            </p>
        </div>
        <div>
            <span class="badge" style="background: #00A8FF; font-size: 13px; padding: 7px 14px; border-radius: 14px;">
                <?=count($stores);?> Certified Partners
            </span>
        </div>
    </div>

    <?php if (!empty($stores)): ?>
        <div class="row pharmacy-grid">
            <?php foreach ($stores as $s): 
                $hasAffil = (!empty($s->hospital_id) || !empty($s->associated_doctor_id));
                $isOpen24 = (stripos($s->operating_hours, '24') !== false);
                $isCurrentStoreCard = (!empty($current_store) && $current_store->id == $s->id);
            ?>
            <div class="col-md-4 col-sm-6" style="margin-bottom: 24px;">
                <div class="pharmacy-store-card <?=$hasAffil ? 'has-affiliation' : '';?> <?=$isCurrentStoreCard ? 'active-service' : '';?>">
                    <?php if ($hasAffil): ?>
                        <div class="affil-badge">
                            <i class="fas fa-star" style="color: #F59E0B;"></i> DOCTOR &amp; HOSPITAL AFFILIATED CHEMIST
                        </div>
                    <?php endif; ?>

                    <div class="pharmacy-card-body">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <h3 class="pharmacy-title">
                                    <?=html_escape($s->store_name);?>
                                    <?php if ($isCurrentStoreCard): ?>
                                        <span class="feature-status-pill" style="font-size: 9px; vertical-align: middle;">Viewing</span>
                                    <?php endif; ?>
                                </h3>
                                <?php if ($s->is_verified): ?>
                                    <span title="Verified Drug License" style="color: #059669; font-size: 17px;">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <p class="pharmacy-meta">
                                <i class="fas fa-map-marker-alt" style="color: #EF4444; margin-right: 4px;"></i>
                                <?=html_escape($s->address);?>, <?=html_escape($s->city);?> (<?=html_escape($s->pincode);?>)
                            </p>

                            <?php if (!empty($s->hospital_name) || !empty($s->doctor_name)): ?>
                                <div class="pharmacy-affil-box">
                                    <?php if (!empty($s->hospital_name)): ?>
                                        <div><i class="fas fa-hospital"></i> <strong>Hospital:</strong> <?=html_escape($s->hospital_name);?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($s->doctor_name)): ?>
                                        <div><i class="fas fa-user-md"></i> <strong>Doctor:</strong> <?=html_escape($s->doctor_name);?></div>
                                    <?php endif; ?>
                                </div>
                            <?php elseif ($hasAffil): ?>
                                <div class="pharmacy-affil-box">
                                    <div><i class="fas fa-hospital-user"></i> <strong>Affiliation:</strong> Verified Healthcare Partner</div>
                                </div>
                            <?php endif; ?>

                            <!-- Badges -->
                            <div class="pharmacy-perks">
                                <span class="pharmacy-perk-badge perk-verified">
                                    <i class="fas fa-file-medical"></i> DL: <?=html_escape($s->drug_license_no ?: 'Form 20/21');?>
                                </span>
                                <?php if ($isOpen24): ?>
                                    <span class="pharmacy-perk-badge perk-open">
                                        <i class="fas fa-clock"></i> 24/7 Open
                                    </span>
                                <?php else: ?>
                                    <span class="pharmacy-perk-badge" style="background: #F1F5F9; color: #475569;">
                                        <i class="far fa-clock"></i> <?=html_escape($s->operating_hours ?: '09:00 AM - 10:00 PM');?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($s->delivery_radius_km > 0): ?>
                                    <span class="pharmacy-perk-badge perk-delivery">
                                        <i class="fas fa-motorcycle"></i> <?=floatval($s->delivery_radius_km);?> km Delivery
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card Footer aligned to bottom -->
                        <div class="pharmacy-card-footer-wrapper">
                            <div style="font-size: 12.5px; color: #059669; font-weight: 700; margin-bottom: 10px;">
                                <i class="fas fa-boxes"></i> <?=$s->in_stock_count;?> Verified Medicines In Stock
                            </div>

                            <div class="pharmacy-card-footer">
                                <a href="tel:<?=html_escape($s->phone);?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                                    <i class="fas fa-phone-alt"></i> <?=html_escape($s->phone);?>
                                </a>
                                <a href="<?=base_url('medical?store_id=' . $s->id . '&q=');?>" 
                                   class="btn btn-sm" 
                                   style="background: #08364B; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 6px 14px;">
                                    <i class="fas fa-list"></i> View Stock (<?=$s->in_stock_count;?>)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center" style="padding: 42px 20px; background: #FFFFFF; border-radius: 14px; border: 1px solid #E2E8F0; margin-bottom: 24px;">
            <i class="fas fa-clinic-medical" style="font-size: 42px; color: #CBD5E1; margin-bottom: 14px;"></i>
            <h4 style="color: #64748B; font-weight: 700;">No partner pharmacies found for the selected filter</h4>
            <a href="<?=base_url('medical');?>" class="btn btn-sm" style="background: #00A8FF; color: #fff; margin-top: 10px; border-radius: 6px; padding: 8px 18px;">
                Reset Location / Filter
            </a>
        </div>
    <?php endif; ?>

    <!-- 5. 3-Step Prescription Workflow Banner -->
    <div class="rx-process-banner">
        <div class="rx-process-header">
            <h3><i class="fas fa-file-prescription" style="color: #059669; margin-right: 6px;"></i> Order With Doctor's Prescription</h3>
            <p>Skip manual searching! Upload your prescription and get medicines dispensed by licensed pharmacists.</p>
        </div>

        <div class="rx-steps-row">
            <div class="rx-step-item">
                <div class="rx-step-number">1</div>
                <div class="rx-step-text">
                    <h5>Upload Prescription</h5>
                    <p>Take a clear photo or upload PDF of your doctor's Rx</p>
                </div>
            </div>
            <div class="rx-step-item">
                <div class="rx-step-number">2</div>
                <div class="rx-step-text">
                    <h5>Pharmacist Check</h5>
                    <p>Registered chemist validates dosage &amp; quotes best price</p>
                </div>
            </div>
            <div class="rx-step-item">
                <div class="rx-step-number">3</div>
                <div class="rx-step-text">
                    <h5>Doorstep Delivery</h5>
                    <p>Medicines packed securely and delivered to your home</p>
                </div>
            </div>
        </div>

        <div class="rx-cta-box">
            <button type="button" onclick="openPrescriptionModal()" class="rx-cta-btn">
                <i class="fas fa-upload"></i> Upload Doctor Rx Now
            </button>
            <div style="margin-top: 12px; font-size: 12px; color: #047857;">
                Need help? Call healthcare support at <strong>8448440603</strong> or dial <strong>108 SOS</strong> in emergencies.
            </div>
        </div>
    </div>

    <!-- 6. Chemist & Retail Pharmacy Partner Section -->
    <div class="chemist-join-box">
        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
            <div class="col-md-8 col-sm-7 text-left">
                <h4 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px;">
                    <i class="fas fa-store-alt" style="color: #00A8FF; margin-right: 6px;"></i> Own a Retail Pharmacy or Chemist Store?
                </h4>
                <p style="font-size: 13.5px; color: #64748B; margin: 0;">
                    Partner with UPCHAR to receive digital prescription orders, connect directly with hospital OPDs, manage store inventory, and expand your delivery radius.
                </p>
            </div>
            <div class="col-md-4 col-sm-5 text-right" style="margin-top: 10px;">
                <a href="<?=base_url('medical-signup');?>" class="btn" style="background: #08364B; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 10px 18px; margin-right: 6px;">
                    <i class="fas fa-user-plus"></i> Register Pharmacy
                </a>
                <a href="<?=base_url('pharmacy/dashboard');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; padding: 10px 16px;">
                    <i class="fas fa-sign-in-alt"></i> Chemist Login
                </a>
            </div>
        </div>
    </div>

    <!-- 7. Statutory & Regulatory Transparency Notice -->
    <div style="margin: 26px 0 20px; padding: 14px 18px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 11.5px; color: #64748B; line-height: 1.6;">
        <strong>Statutory Intermediary Notice:</strong> UPCHAR operates as a digital technology intermediary platform under Section 79 of the Information Technology Act, 2000. UPCHAR does not own, manufacture, or directly sell pharmaceutical products. All prescription and OTC orders are fulfilled strictly by independent, licensed retail chemists and pharmacists holding valid Form 20 and Form 21 licenses under the Drugs and Cosmetics Act, 1940 and Rules thereunder. Prescription drugs (Schedule H, H1 &amp; X) will be dispensed solely against valid physical or tele-consultation prescriptions verified by a registered pharmacist.
    </div>

</div>

<!-- Floating Cart Button -->
<a href="<?=base_url('cart');?>" class="upchar-floating-cart" id="floatingCartBtn" title="View Medicine Cart">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-floating-badge" id="floatingCartBadge">0</span>
</a>

<script>
// Authentication-enforced Add to Cart Handler
function handleAddToCart(btnElement, pharmacyId, medicineId, unitPrice, unitMrp, brandName) {
    const btn = $(btnElement);
    const originalHtml = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding...');

    $.ajax({
        url: '<?=base_url("cart/add_to_cart");?>',
        type: 'POST',
        data: {
            pharmacy_id: pharmacyId,
            medicine_id: medicineId,
            quantity: 1,
            unit_price: unitPrice,
            unit_mrp: unitMrp,
            brand_name: brandName
        },
        dataType: 'json',
        success: function(resp) {
            btn.prop('disabled', false).html(originalHtml);

            if (resp.status === 'auth_required') {
                // User is NOT logged in: Prompt and redirect to Login
                const doLogin = confirm('Authentication Required:\n\nPlease login to your Upchar account to add "' + brandName + '" to your cart.\n\nClick OK to go to the Login page.');
                if (doLogin) {
                    window.location.href = resp.redirect_url || '<?=base_url("login");?>';
                }
            } else if (resp.status === 'success') {
                // Update UI badges
                const count = resp.cart_count || 1;
                $('#floatingCartBadge').text(count);
                $('#navCartBadge, #navCartBadgeAuth').text(count);

                btn.html('<i class="fas fa-check"></i> Added!').css('background', '#10B981');
                setTimeout(function() {
                    btn.html(originalHtml).css('background', '#00A8FF');
                }, 1600);

                if (typeof showOrderToast === 'function') {
                    showOrderToast('Cart Updated', brandName + ' added to your cart!', 'success');
                } else {
                    alert(brandName + ' has been added to your cart!');
                }
            } else {
                alert(resp.message || 'Unable to add item to cart.');
            }
        },
        error: function() {
            btn.prop('disabled', false).html(originalHtml);
            alert('Network error while adding to cart. Please try again.');
        }
    });
}

// Initialize floating cart count
$(document).ready(function() {
    $.ajax({
        url: '<?=base_url("cart/get_count");?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.cart_count > 0) {
                $('#floatingCartBadge').text(res.cart_count);
            }
        }
    });
});
</script>

<?php include('includes/footer.php'); ?>
