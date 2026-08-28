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

.clinic-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.clinic-stat-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.clinic-card-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    margin-bottom: 20px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
}

.clinic-card-box:hover {
    transform: translateY(-2px);
    border-color: var(--upchar-teal);
    box-shadow: 0 8px 18px rgba(0, 168, 150, 0.1);
}

.badge-claim {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}
.badge-pending { background: #fef3c7; color: #b45309; }
.badge-approved { background: #dcfce7; color: #15803d; }

.btn-add-clinic {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 10px 22px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    text-decoration: none !important;
}

.btn-add-clinic:hover {
    background: var(--upchar-teal-dark);
    color: #ffffff;
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

.action-btn-pill {
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>

<div class="pag_cstm clinic-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Page Title Bar -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-hospital-o text-aqua" style="margin-right: 8px;"></i> Manage Own Clinics &amp; Chambers
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Configure your private clinic locations, consultation fees, chamber hours, and location verification.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('addclinic');?>" class="btn-add-clinic">
                        <i class="fa fa-plus"></i> Add New Clinic
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Stats Row -->
            <?php 
            $total_clinics = count($data);
            $approved_count = 0;
            $pending_count = 0;
            foreach($data as $c) {
                if ($c->claim_status == 'P') $pending_count++;
                else $approved_count++;
            }
            ?>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="clinic-stat-card" style="border-left: 4px solid #00a896;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Clinics Configured</div>
                            <div style="font-size: 26px; font-weight: 800; color: #00a896; margin: 4px 0 2px 0;"><?=$total_clinics;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Active practice locations</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="clinic-stat-card" style="border-left: 4px solid #10b981;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Verified &amp; Published</div>
                            <div style="font-size: 26px; font-weight: 800; color: #059669; margin: 4px 0 2px 0;"><?=$approved_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Discoverable on patient search</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-check-circle-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="clinic-stat-card" style="border-left: 4px solid #f59e0b;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Verification In Progress</div>
                            <div style="font-size: 26px; font-weight: 800; color: #d97706; margin: 4px 0 2px 0;"><?=$pending_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Awaiting address &amp; license review</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clinics Table / Cards -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid var(--upchar-border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa fa-list text-aqua"></i> Configured Practice Clinics
                    </h3>
                    <span style="font-size: 12px; color: #64748b;"><?=$total_clinics;?> Location(s) Listed</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                                <th style="padding: 14px 18px; width: 60px;">#</th>
                                <th style="padding: 14px 18px;">Clinic / Chamber Name</th>
                                <th style="padding: 14px 18px;">Address &amp; Location</th>
                                <th style="padding: 14px 18px;">Verification Status</th>
                                <th style="padding: 14px 18px; text-align: right;">Quick Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data)): ?>
                                <?php $i = 1; foreach($data as $p): ?>
                                <tr>
                                    <td style="padding: 14px 18px; font-weight: 700; color: #64748b; vertical-align: middle;">
                                        <?=$i;?>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14.5px;">
                                            <i class="fa fa-hospital-o text-aqua" style="margin-right: 6px;"></i> <?=htmlspecialchars($p->name);?>
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            Chamber ID: #<?=$p->id;?>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 18px; color: #334155; vertical-align: middle;">
                                        <div><i class="fa fa-map-marker text-danger" style="margin-right: 4px;"></i> <?=htmlspecialchars($p->address ?: 'Address not specified');?></div>
                                    </td>
                                    <td style="padding: 14px 18px; vertical-align: middle;">
                                        <?php if($p->claim_status == 'P'): ?>
                                            <span class="badge-claim badge-pending"><i class="fa fa-clock-o"></i> Verification Pending</span>
                                        <?php else: ?>
                                            <span class="badge-claim badge-approved"><i class="fa fa-check-circle"></i> Verified &amp; Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 18px; text-align: right; vertical-align: middle;">
                                        <a href="<?=base_url('updateclinic/'.mybase64_encode($p->id));?>" class="action-btn-pill btn-default" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; margin-right: 4px;">
                                            <i class="fa fa-pencil"></i> Edit Details
                                        </a>
                                        <a href="<?=base_url('managepractice');?>" class="action-btn-pill btn-default" style="background: #f0fdfa; color: #00a896; border: 1px solid #ccfbf1; margin-right: 4px;">
                                            <i class="fa fa-medkit"></i> Fees
                                        </a>
                                        <a href="<?=base_url('doctorpanel/datetime');?>" class="action-btn-pill btn-default" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                                            <i class="fa fa-clock-o"></i> Timings
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8;">
                                        <i class="fa fa-hospital-o" style="font-size: 36px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                        No private clinics added yet. Click <strong>+ Add New Clinic</strong> to configure your practice location.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Verification Notice Box -->
            <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 12px; padding: 20px; display: flex; align-items: flex-start; gap: 16px;">
                <div style="width: 42px; height: 42px; border-radius: 10px; background: #ffffff; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                    <i class="fa fa-shield"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 800; color: #065f46; margin: 0 0 4px 0;">Why Clinic Verification Matters</h4>
                    <p style="font-size: 12.5px; color: #047857; margin: 0; line-height: 1.5;">
                        Ensuring valid address details and location proof helps our medical compliance team grant a “Verified” badge to your chambers. Doctors with verified clinics receive up to 95% higher patient bookings on Upchar.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>