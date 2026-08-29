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
.kpi-bed-tile.maint { border-left-color: #f59e0b; }

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

/* Bed Grid Container */
.bed-matrix-panel {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
}

.bed-matrix-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}

.bed-matrix-header h3 {
    font-size: 16px;
    font-weight: 800;
    color: #043d5b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.bed-legend {
    display: flex;
    gap: 16px;
    font-size: 12px;
    font-weight: 600;
}

.bed-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 18px;
}

.bed-tile {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    padding: 16px 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    transition: all 0.2s ease;
    border-top: 4px solid #10b981;
}

.bed-tile:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
}

.bed-tile.occupied {
    border-top-color: #ef4444;
    background: #fffafa;
}

.bed-tile.maintenance {
    border-top-color: #f59e0b;
    background: #fffdf5;
}

.bed-tile-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}

.bed-name {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
}

.bed-category {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}

.badge-bed-status {
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 10.5px;
    font-weight: 700;
}

.badge-vacant { background: #dcfce7; color: #15803d; }
.badge-occupied { background: #fee2e2; color: #991b1b; }
.badge-maintenance { background: #fef3c7; color: #b45309; }

.bed-tile-footer {
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
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
                <h1><i class="fa fa-bed" style="color: #00a896; margin-right: 8px;"></i> Live Inpatient Bed Occupancy Matrix</h1>
                <p>Real-time monitor for ICU, General Ward, Deluxe, and Semi-Private bed capacities.</p>
            </div>
            <div>
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
            <div class="kpi-bed-tile maint">
                <div class="kpi-bed-title">Maintenance / Sanitization</div>
                <div class="kpi-bed-val" style="color: #f59e0b;"><?=$maintenance_beds;?> Beds</div>
            </div>
        </div>

        <!-- Visual Bed Matrix Panel -->
        <div class="bed-matrix-panel">
            <div class="bed-matrix-header">
                <h3><i class="fa fa-th"></i> Hospital Bed Layout &amp; Live Occupancy</h3>
                <div class="bed-legend">
                    <span style="color: #10b981;"><i class="fa fa-circle"></i> Vacant</span>
                    <span style="color: #ef4444;"><i class="fa fa-circle"></i> Occupied</span>
                    <span style="color: #f59e0b;"><i class="fa fa-circle"></i> Maintenance</span>
                </div>
            </div>

            <div class="bed-cards-grid">
                <?php if(!empty($beds)): ?>
                    <?php foreach($beds as $b): 
                        $status_class = ($b->status == 'OCCUPIED') ? 'occupied' : (($b->status == 'MAINTENANCE' || $b->status == 'CLEANING') ? 'maintenance' : 'vacant');
                        $badge_class = ($status_class == 'occupied') ? 'badge-occupied' : (($status_class == 'maintenance') ? 'badge-maintenance' : 'badge-vacant');
                    ?>
                        <div class="bed-tile <?=$status_class;?>">
                            <div class="bed-tile-header">
                                <div>
                                    <div class="bed-name"><i class="fa fa-bed" style="color: #64748b; font-size: 14px;"></i> Bed <?=html_escape($b->bed_number);?></div>
                                    <div class="bed-category"><?=html_escape($b->category ?: 'General Ward');?></div>
                                </div>
                                <span class="badge-bed-status <?=$badge_class;?>"><?=html_escape($b->status);?></span>
                            </div>

                            <div class="bed-tile-footer">
                                <span style="font-weight: 700; color: #0f172a;">
                                    ₹<?=number_format((float)(@$b->daily_charge ?: 1500), 2);?> / day
                                </span>
                                <?php if($b->status == 'VACANT'): ?>
                                    <a href="<?=base_url('hospitalpanel/admissions');?>" style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 11.5px; padding: 4px 10px; border-radius: 4px; text-decoration: none;">
                                        Admit Here
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; color: #94a3b8;">
                        <i class="fa fa-bed" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                        <strong style="font-size: 15px; color: #64748b; display: block;">No Beds Configured</strong>
                        <span>Configure hospital beds and wards in <strong>Manage Bed Setup</strong> to view the live occupancy matrix.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
