<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
.bed-stat-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 20px;
}
.bed-stat-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.bed-stat-val {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin-top: 4px;
}
.bed-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 16px;
    margin-bottom: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
.bed-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.05);
}
.bed-card.occupied {
    border-top: 4px solid #ef4444;
    background: #fffafa;
}
.bed-card.vacant {
    border-top: 4px solid #10b981;
}
.bed-card.maintenance {
    border-top: 4px solid #f59e0b;
    background: #fffdf5;
}
.badge-bed {
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 10.5px;
    font-weight: 700;
}
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-bed" style="color: #00a896; margin-right: 8px;"></i> Live Inpatient Bed Occupancy Matrix
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Real-time floor monitor for ICU, General Ward, Deluxe, and Semi-Private bed capacities.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('hospitalpanel/admissions');?>" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 9px 20px;">
                        <i class="fa fa-user-plus"></i> Inpatient Admissions
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Stats Bar -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="bed-stat-card" style="border-left: 4px solid #3b82f6;">
                        <div class="bed-stat-title">Total Capacity</div>
                        <div class="bed-stat-val"><?=$total_beds;?> Beds</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="bed-stat-card" style="border-left: 4px solid #10b981;">
                        <div class="bed-stat-title">Available Vacant</div>
                        <div class="bed-stat-val" style="color: #10b981;"><?=$vacant_beds;?> Beds</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="bed-stat-card" style="border-left: 4px solid #ef4444;">
                        <div class="bed-stat-title">Currently Occupied</div>
                        <div class="bed-stat-val" style="color: #ef4444;"><?=$occupied_beds;?> Beds</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="bed-stat-card" style="border-left: 4px solid #f59e0b;">
                        <div class="bed-stat-title">Cleaning / Maintenance</div>
                        <div class="bed-stat-val" style="color: #f59e0b;"><?=$maintenance_beds;?> Beds</div>
                    </div>
                </div>
            </div>

            <!-- Visual Grid of Beds -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">
                        <i class="fa fa-th" style="color: #00a896;"></i> Hospital Bed Layout &amp; Live Status
                    </h3>
                    <div style="display: flex; gap: 12px; font-size: 12px; font-weight: 600;">
                        <span style="color: #10b981;"><i class="fa fa-circle"></i> Vacant</span>
                        <span style="color: #ef4444;"><i class="fa fa-circle"></i> Occupied</span>
                        <span style="color: #f59e0b;"><i class="fa fa-circle"></i> Maintenance</span>
                    </div>
                </div>

                <div class="row">
                    <?php if (!empty($beds)): ?>
                        <?php foreach ($beds as $b): 
                            $status_class = ($b->status == 'OCCUPIED') ? 'occupied' : (($b->status == 'MAINTENANCE' || $b->status == 'CLEANING') ? 'maintenance' : 'vacant');
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="bed-card <?=$status_class;?>">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <div style="font-size: 16px; font-weight: 800; color: #0f172a;">
                                            <i class="fa fa-bed" style="margin-right: 4px; color: #64748b;"></i> Bed <?=html_escape($b->bed_number);?>
                                        </div>
                                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                            <?=html_escape($b->category ?: 'General Ward');?>
                                        </div>
                                    </div>
                                    <span class="badge-bed <?=$status_class == 'occupied' ? 'label-danger' : ($status_class == 'vacant' ? 'label-success' : 'label-warning');?>">
                                        <?=html_escape($b->status);?>
                                    </span>
                                </div>
                                <div style="margin-top: 14px; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                                    <span style="font-weight: 700; color: #0f172a;">
                                        ₹<?=number_format(@$b->daily_charge ?: 1500, 2);?> / day
                                    </span>
                                    <?php if ($b->status == 'VACANT'): ?>
                                    <a href="<?=base_url('hospitalpanel/admissions');?>" class="btn btn-xs" style="background: #e0f2fe; color: #0369a1; font-weight: 700; border-radius: 4px;">
                                        Admit Here
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fa fa-bed" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No beds configured yet. Click <strong>Manage Bed Setup</strong> in the sidebar to add ward beds.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
