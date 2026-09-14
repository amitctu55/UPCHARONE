<?php include('includes/header.php'); ?>

<style>
/* UPCHAR Medical & Pharmacy Network Styling */
.pharmacy-hero {
    background: linear-gradient(135deg, #08364B 0%, #0F2D3D 55%, #0A4958 100%);
    color: #FFFFFF;
    padding: 48px 0 36px;
    position: relative;
    overflow: hidden;
}
.pharmacy-hero::after {
    content: '';
    position: absolute;
    top: -40%;
    right: -10%;
    width: 480px;
    height: 480px;
    background: radial-gradient(circle, rgba(0, 168, 255, 0.18) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.pharmacy-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 168, 255, 0.15);
    border: 1px solid rgba(0, 168, 255, 0.4);
    color: #38BDF8;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 14px;
    letter-spacing: 0.3px;
}
.pharmacy-hero-title {
    font-size: 32px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 10px;
    color: #FFFFFF;
}
.pharmacy-hero-desc {
    font-size: 15px;
    color: #CBD5E1;
    max-width: 680px;
    line-height: 1.6;
    margin: 0 0 24px;
}

/* Global Medicine Search Form */
.pharmacy-search-wrapper {
    background: #FFFFFF;
    border-radius: 12px;
    padding: 8px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
    max-width: 820px;
    margin-bottom: 18px;
}
.pharmacy-search-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.pharmacy-search-input-box {
    flex: 1;
    min-width: 260px;
    position: relative;
}
.pharmacy-search-input-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 16px;
}
.pharmacy-search-input {
    width: 100%;
    height: 48px;
    padding: 8px 14px 8px 42px;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
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
.pharmacy-location-select {
    height: 48px;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 0 14px;
    font-size: 14px;
    color: #334155;
    background: #F8FAFC;
    min-width: 170px;
    outline: none;
}
.pharmacy-search-btn {
    height: 48px;
    background: #00A8FF;
    color: #FFFFFF;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    padding: 0 24px;
    font-size: 15px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s ease, transform 0.15s ease;
}
.pharmacy-search-btn:hover {
    background: #0090DC;
    transform: translateY(-1px);
    color: #FFFFFF;
}

/* Quick Search Suggestions */
.quick-tags-box {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 10px;
}
.quick-tag-label {
    font-size: 12px;
    color: #94A3B8;
    font-weight: 600;
}
.quick-tag-pill {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #E2E8F0;
    padding: 3px 10px;
    border-radius: 16px;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.2s ease;
}
.quick-tag-pill:hover {
    background: #00A8FF;
    border-color: #00A8FF;
    color: #FFFFFF;
    text-decoration: none;
}

/* Filter Toolbar */
.pharmacy-filter-toolbar {
    background: #FFFFFF;
    border-bottom: 1px solid #E2E8F0;
    padding: 14px 0;
    margin-bottom: 28px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}
.pharmacy-nav-pills {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.pharmacy-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
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

/* Medicine Results Cards */
.med-result-card {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    margin-bottom: 18px;
    padding: 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
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
    gap: 12px;
    margin-bottom: 12px;
}
.med-title {
    font-size: 18px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 4px;
}
.med-composition {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}
.med-tag {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    margin-left: 6px;
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

/* Store details within medicine card */
.med-store-badge {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
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
    font-size: 14px;
    color: #94A3B8;
    text-decoration: line-through;
}
.med-discount-tag {
    background: #DEF7EC;
    color: #03543F;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 10px;
}

/* Pharmacy Store Directory Card */
.pharmacy-store-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
    height: calc(100% - 24px);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
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
    padding: 4px 12px;
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
    justify-content: space-between;
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
}
.perk-verified {
    background: #FEF3C7;
    color: #B45309;
}
.pharmacy-card-footer {
    border-top: 1px solid #F1F5F9;
    padding-top: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
}

/* Prescription Upload CTA Banner */
.rx-banner-box {
    background: linear-gradient(135deg, #F0FDF4 0%, #E6FFFA 100%);
    border: 1px solid #A7F3D0;
    border-radius: 16px;
    padding: 24px 28px;
    margin: 30px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 18px;
}

/* Chemist Onboarding Box */
.chemist-join-box {
    background: #F8FAFC;
    border: 1px dashed #CBD5E1;
    border-radius: 14px;
    padding: 22px;
    margin-top: 30px;
    text-align: center;
}
</style>

<!-- Hero Section with Global Medicine Search Bar -->
<section class="pharmacy-hero">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="pharmacy-hero-badge">
                    <i class="fas fa-shield-alt"></i> UPCHAR Verified Pharmacy &amp; Medicine Network
                </div>
                <h1 class="pharmacy-hero-title">Online Medicine Stock &amp; Local Pharmacies</h1>
                <p class="pharmacy-hero-desc">
                    Search medicines across certified pharmacies in your city, check live stock availability, compare local chemist prices, or request doorstep delivery.
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

                        <?php if ($service !== 'all'): ?>
                            <input type="hidden" name="service" value="<?=html_escape($service);?>">
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
                            <a href="<?=base_url('medical?q=' . urlencode($sug->brand_name));?>" class="quick-tag-pill">
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
            </div>

            <div class="col-md-3 hidden-xs hidden-sm text-center" style="margin-top: 10px;">
                <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 14px; padding: 18px; text-align: center;">
                    <i class="fas fa-file-prescription" style="font-size: 38px; color: #38BDF8; margin-bottom: 10px;"></i>
                    <h4 style="font-size: 15px; font-weight: 700; color: #FFFFFF; margin: 0 0 6px;">Have a Prescription?</h4>
                    <p style="font-size: 12px; color: #CBD5E1; margin: 0 0 12px;">Upload your Rx and get medicines delivered from certified local pharmacies.</p>
                    <button type="button" onclick="openPrescriptionModal()" class="btn btn-sm btn-block" style="background: #10B981; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 8px 12px;">
                        <i class="fas fa-upload"></i> Upload Rx Now
                    </button>
                    <div style="margin-top: 12px; font-size: 11px; color: #94A3B8;">
                        <i class="fas fa-phone-alt"></i> 24/7 Helpline: 8448440603
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Service Toolbar -->
<div class="pharmacy-filter-toolbar">
    <div class="container">
        <div class="pharmacy-nav-pills">
            <span style="font-size: 13px; font-weight: 700; color: #64748B; margin-right: 4px;">
                <i class="fas fa-filter"></i> Filters:
            </span>
            <a href="<?=base_url('medical' . ($search_query ? '?q=' . urlencode($search_query) : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'all' ? 'active' : '';?>">
                <i class="fas fa-th-large"></i> All Stores
            </a>
            <a href="<?=base_url('medical?service=delivery' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'delivery' ? 'active' : '';?>">
                <i class="fas fa-motorcycle" style="color: #0284C7;"></i> Home Delivery Available
            </a>
            <a href="<?=base_url('medical?service=open24' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'open24' ? 'active' : '';?>">
                <i class="fas fa-clock" style="color: #059669;"></i> 24/7 Open
            </a>
            <a href="<?=base_url('medical?service=affiliated' . ($search_query ? '&q=' . urlencode($search_query) : '') . ($pincode ? '&pincode=' . urlencode($pincode) : ''));?>" 
               class="pharmacy-pill-btn <?=$service === 'affiliated' ? 'active' : '';?>">
                <i class="fas fa-user-md" style="color: #D97706;"></i> Doctor &amp; Hospital Affiliated
            </a>

            <?php if ($search_query || $pincode || $service !== 'all' || $filter_store): ?>
                <a href="<?=base_url('medical');?>" style="font-size: 12px; color: #EF4444; font-weight: 700; margin-left: auto; text-decoration: none;">
                    <i class="fas fa-times-circle"></i> Clear All Filters
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Main Body -->
<div class="container">

    <!-- Case A: Medicine Search Results -->
    <?php if ($search_query !== ''): ?>
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div>
                <h2 style="font-size: 20px; font-weight: 800; color: #08364B; margin: 0 0 4px;">
                    Search Results for <span style="color: #00A8FF;">"<?=html_escape($search_query);?>"</span>
                </h2>
                <p style="font-size: 13px; color: #64748B; margin: 0;">
                    Showing local partner pharmacies carrying verified stock.
                </p>
            </div>
            <div>
                <span class="badge" style="background: #08364B; font-size: 13px; padding: 6px 12px;">
                    <?=count($medicine_results);?> <?=count($medicine_results) === 1 ? 'Store Match' : 'Store Matches';?>
                </span>
            </div>
        </div>

        <?php if (!empty($medicine_results)): ?>
            <div class="row">
                <?php foreach ($medicine_results as $med): 
                    $isAffiliated = (!empty($med->hospital_id) || !empty($med->associated_doctor_id));
                    $discountPct = ($med->mrp > $med->selling_price && $med->mrp > 0) ? round((($med->mrp - $med->selling_price) / $med->mrp) * 100) : 0;
                ?>
                <div class="col-md-6" style="margin-bottom: 20px;">
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

                        <!-- Store details & Affiliation -->
                        <div class="med-store-badge">
                            <div>
                                <div class="med-store-name">
                                    <i class="fas fa-store" style="color: #00A8FF;"></i> <?=html_escape($med->store_name);?>
                                </div>
                                <div style="font-size: 12px; color: #64748B; margin-top: 2px;">
                                    <i class="fas fa-map-marker-alt" style="color: #EF4444;"></i> <?=html_escape($med->store_address);?>, <?=html_escape($med->store_city);?> (<?=html_escape($med->store_pincode);?>)
                                </div>
                                <?php if ($isAffiliated): ?>
                                    <div style="font-size: 11px; color: #0284C7; font-weight: 700; margin-top: 4px;">
                                        <i class="fas fa-star" style="color: #F59E0B;"></i> 
                                        <?=!empty($med->doctor_name) ? 'Attached to ' . html_escape($med->doctor_name) : '';?>
                                        <?=!empty($med->hospital_name) ? ' (' . html_escape($med->hospital_name) . ')' : '';?>
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

                        <!-- Actions -->
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="tel:<?=html_escape($med->store_phone);?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                                <i class="fas fa-phone-alt"></i> Call Store
                            </a>
                            <button type="button" 
                                    class="btn btn-sm" 
                                    style="background: #00A8FF; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 6px 16px;"
                                    onclick="initiateDoorstepOrder(<?=$med->inventory_id;?>, '<?=addslashes(html_escape($med->brand_name));?>', '<?=addslashes(html_escape($med->store_name));?>', <?=$med->selling_price;?>)">
                                <i class="fas fa-shopping-bag"></i> Order Doorstep
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center" style="background: #FFFFFF; border: 1px dashed #CBD5E1; border-radius: 12px; padding: 40px 20px; margin-bottom: 30px;">
                <i class="fas fa-search" style="font-size: 40px; color: #94A3B8; margin-bottom: 12px;"></i>
                <h3 style="font-size: 18px; font-weight: 800; color: #1E293B; margin: 0 0 6px;">No Registered Stores Currently Have "<?=html_escape($search_query);?>" In Stock</h3>
                <p style="font-size: 14px; color: #64748B; max-width: 540px; margin: 0 auto 18px;">
                    Our team can source this medicine directly for you from our verified distribution network, or you can upload your doctor's prescription.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="openPrescriptionModal()" class="btn" style="background: #10B981; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 8px 18px;">
                        <i class="fas fa-file-prescription"></i> Upload Prescription
                    </button>
                    <a href="<?=base_url('medical');?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px;">
                        View All Registered Pharmacies
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <hr style="border-top: 1px solid #E2E8F0; margin: 30px 0;">
    <?php endif; ?>


    <!-- Case B: Partner Pharmacies Directory (Always displayed or when no specific search) -->
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #08364B; margin: 0 0 4px;">
                <i class="fas fa-clinic-medical" style="color: #00A8FF;"></i> Verified Partner Pharmacies &amp; Chemist Stores
            </h2>
            <p style="font-size: 14px; color: #64748B; margin: 0;">
                Licensed Form 20/21 retailers ready to fulfill prescriptions and OTC medicines.
            </p>
        </div>
        <div>
            <span class="badge" style="background: #00A8FF; font-size: 13px; padding: 6px 12px;">
                <?=count($stores);?> Certified Partners
            </span>
        </div>
    </div>

    <?php if (!empty($stores)): ?>
        <div class="row">
            <?php foreach ($stores as $s): 
                $hasAffil = (!empty($s->hospital_id) || !empty($s->associated_doctor_id));
                $isOpen24 = (stripos($s->operating_hours, '24') !== false);
            ?>
            <div class="col-md-4 col-sm-6" style="margin-bottom: 24px;">
                <div class="pharmacy-store-card <?=$hasAffil ? 'has-affiliation' : '';?>">
                    <?php if ($hasAffil): ?>
                        <div class="affil-badge">
                            <i class="fas fa-star" style="color: #F59E0B;"></i> DOCTOR &amp; HOSPITAL AFFILIATED CHEMIST
                        </div>
                    <?php endif; ?>

                    <div class="pharmacy-card-body">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <h3 class="pharmacy-title"><?=html_escape($s->store_name);?></h3>
                                <?php if ($s->is_verified): ?>
                                    <span title="Verified Drug License" style="color: #059669; font-size: 16px;">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <p class="pharmacy-meta">
                                <i class="fas fa-map-marker-alt" style="color: #EF4444; margin-right: 4px;"></i>
                                <?=html_escape($s->address);?>, <?=html_escape($s->city);?> (<?=html_escape($s->pincode);?>)
                            </p>

                            <?php if ($hasAffil): ?>
                                <div style="background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #0369A1; margin-bottom: 12px;">
                                    <?php if (!empty($s->hospital_name)): ?>
                                        <div><i class="fas fa-hospital"></i> <strong>Hospital:</strong> <?=html_escape($s->hospital_name);?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($s->doctor_name)): ?>
                                        <div><i class="fas fa-user-md"></i> <strong>Attached Doctor:</strong> <?=html_escape($s->doctor_name);?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Badges -->
                            <div class="pharmacy-perks">
                                <span class="pharmacy-perk-badge perk-verified">
                                    <i class="fas fa-file-medical"></i> DL: <?=html_escape($s->drug_license_no ?: 'Verified Form 20/21');?>
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

                        <!-- Card Footer -->
                        <div>
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
                                    <i class="fas fa-list"></i> Check Stock
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center" style="padding: 40px 20px; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0;">
            <i class="fas fa-clinic-medical" style="font-size: 40px; color: #CBD5E1; margin-bottom: 12px;"></i>
            <h4 style="color: #64748B; font-weight: 700;">No partner pharmacies found for the selected filter</h4>
            <a href="<?=base_url('medical');?>" class="btn btn-sm" style="background: #00A8FF; color: #fff; margin-top: 10px; border-radius: 6px;">
                Reset Location / Filter
            </a>
        </div>
    <?php endif; ?>

    <!-- Prescription Upload Banner -->
    <div class="rx-banner-box">
        <div>
            <h3 style="font-size: 20px; font-weight: 800; color: #065F46; margin: 0 0 6px;">
                <i class="fas fa-file-prescription" style="color: #059669; margin-right: 6px;"></i> Have a Doctor's Prescription? Let Us Dispense It
            </h3>
            <p style="font-size: 14px; color: #047857; margin: 0; max-width: 680px;">
                Skip manual searches! Upload a clear photo or PDF of your doctor's prescription. Our nearest licensed chemist will verify the dosages, quote the best discounted price, and dispatch to your doorstep.
            </p>
        </div>
        <div>
            <button type="button" onclick="openPrescriptionModal()" class="btn" style="background: #059669; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 12px 24px; font-size: 15px; box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);">
                <i class="fas fa-upload"></i> Upload Doctor Rx
            </button>
        </div>
    </div>

    <!-- Chemist Onboarding Box -->
    <div class="chemist-join-box">
        <div class="row">
            <div class="col-md-8 text-left">
                <h4 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 4px;">
                    <i class="fas fa-store-alt" style="color: #00A8FF; margin-right: 6px;"></i> Own a Retail Pharmacy or Chemist Store?
                </h4>
                <p style="font-size: 13.5px; color: #64748B; margin: 0;">
                    Partner with UPCHAR to receive digital prescription orders, manage store inventory, and expand your delivery radius with our local rider fleet.
                </p>
            </div>
            <div class="col-md-4 text-right" style="margin-top: 6px;">
                <a href="<?=base_url('medical-signup');?>" class="btn" style="background: #08364B; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 10px 18px; margin-right: 6px;">
                    <i class="fas fa-user-plus"></i> Register Pharmacy
                </a>
                <a href="<?=base_url('pharmacy/dashboard');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; padding: 10px 16px;">
                    <i class="fas fa-sign-in-alt"></i> Chemist Login
                </a>
            </div>
        </div>
    </div>

    <!-- Statutory Compliance Notice -->
    <div style="margin: 30px 0 20px; padding: 14px 18px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 11.5px; color: #64748B; line-height: 1.6;">
        <strong>Statutory Intermediary Notice:</strong> UPCHAR operates as a digital technology intermediary platform under Section 79 of the Information Technology Act, 2000. UPCHAR does not own, manufacture, or directly sell pharmaceutical products. All prescription and OTC orders are fulfilled strictly by independent, licensed retail chemists and pharmacists holding valid Form 20 and Form 21 licenses under the Drugs and Cosmetics Act, 1940 and Rules thereunder. Prescription drugs (Schedule H, H1 &amp; X) will be dispensed solely against valid physical or tele-consultation prescriptions verified by a registered pharmacist.
    </div>

</div>

<div style="height: 30px;"></div>

<!-- Include UPCHAR Medicine & Prescription Modals Suite -->
<?php include(APPPATH . 'views/modals/medicine_order_modals.php'); ?>

<?php include('includes/footer.php'); ?>
