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

.bed-matrix-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.bed-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.bed-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.bed-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.action-hdr-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-primary-action {
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

.btn-primary-action:hover {
    background: #008f80;
    transform: translateY(-1px);
}

.btn-secondary-action {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-weight: 700;
    font-size: 13px;
    padding: 8px 16px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none !important;
    transition: all 0.15s ease;
}

.btn-secondary-action:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

/* KPI Bar */
.kpi-bed-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.kpi-bed-tile {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    border-left: 4px solid var(--upchar-teal);
}

.kpi-bed-tile.cap { border-left-color: #3b82f6; }
.kpi-bed-tile.vac { border-left-color: #10b981; }
.kpi-bed-tile.occ { border-left-color: #ef4444; }
.kpi-bed-tile.types { border-left-color: #8b5cf6; }

.kpi-bed-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.kpi-bed-val {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
}

/* Ward Matrix Container */
.ward-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.ward-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.2s ease;
}

.ward-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.07);
}

.ward-card-header {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 16px 20px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ward-title {
    font-size: 16px;
    font-weight: 800;
    color: #ffffff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ward-card-body {
    padding: 20px;
    flex-grow: 1;
}

.ward-meta-strip {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.ward-rate {
    font-size: 15px;
    font-weight: 800;
    color: #00a896;
}

.ward-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 8px;
    margin-bottom: 16px;
    text-align: center;
}

.ward-stat-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 6px;
}

.ward-stat-val {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
}

.ward-stat-lbl {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    margin-top: 2px;
}

/* Visual Bed Grid */
.bed-slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(36px, 1fr));
    gap: 6px;
    margin-top: 14px;
}

.bed-slot {
    height: 36px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    cursor: default;
}

.bed-slot.vacant {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #86efac;
}

.bed-slot.occupied {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.ward-card-footer {
    padding: 14px 20px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="bed-matrix-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="bed-header-card">
            <div>
                <h1><i class="fa fa-th-large" style="color: #00a896; margin-right: 8px;"></i> Live Inpatient Bed Matrix</h1>
                <p>Real-time occupancy monitor for ICU, General Ward, Deluxe, and Semi-Private bed capacities.</p>
            </div>
            <div class="action-hdr-group">
                <a href="<?=base_url('hospitalpanel/bed');?>" class="btn-secondary-action">
                    <i class="fa fa-sliders"></i> Manage Bed Setup
                </a>
                <a href="<?=base_url('hospitalpanel/admissions');?>" class="btn-primary-action">
                    <i class="fa fa-user-plus"></i> Inpatient Admissions
                </a>
            </div>
        </div>

        <!-- KPI Summary Bar -->
        <div class="kpi-bed-grid">
            <div class="kpi-bed-tile cap">
                <div class="kpi-bed-title">Total Bed Capacity</div>
                <div class="kpi-bed-val"><?=$total_beds;?> Beds</div>
            </div>
            <div class="kpi-bed-tile vac">
                <div class="kpi-bed-title">Available Vacant</div>
                <div class="kpi-bed-val" style="color: #10b981;"><?=$vacant_beds;?> Beds</div>
            </div>
            <div class="kpi-bed-tile occ">
                <div class="kpi-bed-title">Currently Occupied</div>
                <div class="kpi-bed-val" style="color: #ef4444;"><?=$occupied_beds;?> Beds</div>
            </div>
            <div class="kpi-bed-tile types">
                <div class="kpi-bed-title">Configured Wards</div>
                <div class="kpi-bed-val" style="color: #8b5cf6;"><?=$total_types ?? count($beds);?> Types</div>
            </div>
        </div>

        <!-- Visual Bed Matrix Panel -->
        <div class="ward-cards-grid">
            <?php if(!empty($beds)): ?>
                <?php foreach($beds as $b): 
                    $tot = (int)$b->total_bed;
                    $occ = (int)$b->occupied_bed;
                    $avail = max(0, $tot - $occ);
                    $pct = ($tot > 0) ? min(100, round(($occ / $tot) * 100)) : 0;
                ?>
                    <div class="ward-card">
                        <div class="ward-card-header">
                            <h3 class="ward-title">
                                <i class="fa fa-bed"></i> <?=html_escape($b->bed_type);?>
                            </h3>
                            <span style="font-size: 11px; background: rgba(255,255,255,0.2); padding: 3px 8px; border-radius: 4px; font-weight: 700;">
                                #BED-<?=$b->hospital_bed_id;?>
                            </span>
                        </div>

                        <div class="ward-card-body">
                            <div class="ward-meta-strip">
                                <div>
                                    <div class="ward-rate">₹<?=number_format((float)$b->amount, 2);?> <span style="font-size: 11px; color: #64748b; font-weight: normal;">/ day</span></div>
                                </div>
                                <div>
                                    <span style="font-size: 11px; font-weight: 700; color: <?=$pct > 80 ? '#dc2626' : '#15803d';?>">
                                        <?=$pct;?>% Occupancy
                                    </span>
                                </div>
                            </div>

                            <!-- Ward Stats Boxes -->
                            <div class="ward-stats-grid">
                                <div class="ward-stat-box">
                                    <div class="ward-stat-val" style="color: #043d5b;"><?=$tot;?></div>
                                    <div class="ward-stat-lbl">Capacity</div>
                                </div>
                                <div class="ward-stat-box">
                                    <div class="ward-stat-val" style="color: #dc2626;"><?=$occ;?></div>
                                    <div class="ward-stat-lbl">Occupied</div>
                                </div>
                                <div class="ward-stat-box">
                                    <div class="ward-stat-val" style="color: #15803d;"><?=$avail;?></div>
                                    <div class="ward-stat-lbl">Vacant</div>
                                </div>
                            </div>

                            <?php if(!empty($b->comment)): ?>
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
                                    <?=html_escape($b->comment);?>
                                </p>
                            <?php endif; ?>

                            <!-- Individual Bed Slots Preview -->
                            <div style="font-size: 11.5px; font-weight: 700; color: #475569; margin-top: 10px;">
                                Bed Slots Overview:
                            </div>
                            <div class="bed-slots-grid">
                                <?php for($i = 1; $i <= $tot; $i++): 
                                    $is_occ = ($i <= $occ);
                                ?>
                                    <div class="bed-slot <?=$is_occ ? 'occupied' : 'vacant';?>" title="Bed <?=$i;?>: <?=$is_occ ? 'Occupied' : 'Vacant';?>">
                                        B<?=$i;?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="ward-card-footer">
                            <span style="font-size: 11.5px; color: #64748b;">
                                <?=$avail > 0 ? '<strong style="color: #15803d;">' . $avail . ' Beds Ready</strong>' : '<strong style="color: #dc2626;">Ward Full</strong>';?>
                            </span>
                            <?php if($avail > 0): ?>
                                <a href="<?=base_url('hospitalpanel/admissions');?>" style="background: #00a896; color: #fff; font-size: 11.5px; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-decoration: none;">
                                    <i class="fa fa-user-plus"></i> Admit Inpatient
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; color: #94a3b8; background: #fff; border-radius: 14px; border: 1px solid var(--upchar-border);">
                    <i class="fa fa-bed" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                    <strong style="font-size: 15px; color: #64748b; display: block;">No Hospital Beds Configured</strong>
                    <span>Configure hospital beds and wards in <strong>Manage Bed Setup</strong> to view the live occupancy matrix.</span>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
