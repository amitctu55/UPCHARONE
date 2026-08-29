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

.bio-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.bio-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.bio-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.bio-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.bio-catalog-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.bio-item-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: grid;
    grid-template-columns: 220px 1fr 240px;
    gap: 24px;
    align-items: center;
    transition: all 0.2s ease;
}

@media (max-width: 991px) {
    .bio-item-card {
        grid-template-columns: 1fr;
    }
}

.bio-item-card:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    border-color: #cbd5e1;
}

.bio-thumb-wrap {
    border-radius: 10px;
    overflow: hidden;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bio-thumb-wrap img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.bio-details h3 {
    font-size: 17px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 4px 0;
}

.bio-company {
    font-size: 13px;
    font-weight: 700;
    color: #00a896;
    margin-bottom: 8px;
}

.bio-distributor {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 12px;
}

.bio-pricing-strip {
    display: flex;
    gap: 16px;
    margin-top: 12px;
    flex-wrap: wrap;
}

.price-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 14px;
}

.price-box span {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    display: block;
}

.price-box strong {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
}

.bio-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
}

.btn-bio-order {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 10px 18px;
    border-radius: 8px;
    text-align: center;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
}

.btn-bio-order:hover {
    background: #008f80;
}

.btn-bio-pdf {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569 !important;
    font-weight: 700;
    font-size: 12.5px;
    padding: 8px 16px;
    border-radius: 8px;
    text-align: center;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.btn-bio-pdf:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="bio-page-wrap">

        <!-- Header -->
        <div class="bio-header-card">
            <h1><i class="fa fa-medkit" style="color: #00a896; margin-right: 8px;"></i> Bio-Medical Equipment &amp; Hospital Supplies</h1>
            <p>Procure certified medical machinery, consumables, and bio-medical sterilization equipment directly.</p>
        </div>

        <!-- Catalog List -->
        <div class="bio-catalog-list">
            <?php if(!empty($data)): ?>
                <?php foreach($data as $p): ?>
                    <div class="bio-item-card">
                        
                        <!-- Thumbnail -->
                        <div class="bio-thumb-wrap">
                            <img src="<?=admin_url('public/assets/upload/'.$p->image);?>" alt="<?=$p->equipment;?>">
                        </div>

                        <!-- Details -->
                        <div class="bio-details">
                            <h3><?=html_escape($p->equipment);?></h3>
                            <div class="bio-company"><i class="fa fa-industry"></i> <?=html_escape($p->company_name);?></div>
                            <div class="bio-distributor"><i class="fa fa-truck"></i> Authorized Distributor: <strong><?=html_escape($p->distributor_name);?></strong></div>
                            
                            <div class="bio-pricing-strip">
                                <div class="price-box">
                                    <span>Special Offer</span>
                                    <strong style="color: #00a896;">₹<?=number_format((float)$p->price);?></strong>
                                </div>
                                <div class="price-box">
                                    <span>M.R.P.</span>
                                    <strong style="text-decoration: line-through; color: #94a3b8;">₹<?=number_format((float)$p->mrp_price);?></strong>
                                </div>
                                <?php if(!empty($p->discount)): ?>
                                    <div class="price-box" style="background: #ecfdf5; border-color: #a7f3d0;">
                                        <span style="color: #059669;">Discount</span>
                                        <strong style="color: #059669;"><?=$p->discount;?>% OFF</strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bio-actions">
                            <a href="#" class="btn-bio-order">
                                <i class="fa fa-shopping-cart"></i> Inquire / Order
                            </a>
                            <?php if(!empty($p->image)): ?>
                                <a href="<?=admin_url('public/assets/upload/'.$p->image);?>" class="btn-bio-pdf" download>
                                    <i class="fa fa-file-pdf-o" style="color: #ef4444;"></i> Specification PDF
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 64px 20px; background: #ffffff; border-radius: 12px; border: 1px solid var(--upchar-border);">
                    <i class="fa fa-medkit" style="font-size: 44px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                    <h3 style="font-size: 16px; font-weight: 700; color: #64748b; margin: 0 0 6px 0;">No Equipment Listed</h3>
                    <p style="font-size: 13px; color: #94a3b8; margin: 0;">Bio-medical equipment and hospital supplies will appear here once published by vendors.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>