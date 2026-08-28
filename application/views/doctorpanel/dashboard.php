<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

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

.doc-dash-container {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Welcome Hero Card */
.doc-welcome-card {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 60%, #00a896 100%);
    border-radius: 14px;
    padding: 24px 28px;
    color: #ffffff;
    margin-bottom: 24px;
    box-shadow: 0 10px 24px -5px rgba(4, 61, 91, 0.22);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    position: relative;
    overflow: hidden;
}

.doc-welcome-card::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.doc-welcome-title {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 6px 0;
    color: #ffffff;
}

.doc-welcome-sub {
    font-size: 13.5px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

/* Standardized Metric Cards (Stat Boxes) */
.stat-box,
.kpi-card {
    background: #ffffff;
    border-left: 4px solid #00a896;
    border-radius: 8px;
    padding: 16px 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    transition: all 0.2s ease-in-out;
    border-top: 1px solid #e2e8f0;
    border-right: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

.stat-box:hover,
.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
}

.stat-box .stat-number,
.kpi-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-top: 4px;
}

.stat-box .stat-label,
.kpi-title {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-box .stat-sub,
.kpi-sub {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 2px;
}

.stat-icon-wrap,
.kpi-icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

/* Improved Module Cards Grid */
.grid-container, 
.practice-modules-grid,
.tile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.module-card,
.app-tile {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 16px;
    text-align: center;
    text-decoration: none !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
}

.module-card:hover,
.app-tile:hover {
    border-color: #00a896;
    box-shadow: 0 8px 20px rgba(0, 168, 150, 0.08);
    transform: translateY(-2px);
}

.module-icon-wrap,
.app-tile-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    margin: 0 auto 10px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: all 0.2s;
    background: #f0fdfa;
    color: #00a896;
    border: 1px solid #ccfbf1;
}

.module-card:hover .module-icon-wrap,
.app-tile:hover .app-tile-icon {
    transform: scale(1.08);
    background: #00a896;
    color: #ffffff;
    border-color: #00a896;
}

.module-title,
.app-tile-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.module-desc,
.app-tile-desc {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 3px;
}

/* Consultations Table */
.table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.table-card-header {
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid var(--upchar-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.badge-status {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}
.badge-paid { background: #dcfce7; color: #15803d; }
.badge-unpaid { background: #fee2e2; color: #991b1b; }
.badge-visited { background: #e0f2fe; color: #0369a1; }
</style>

<div class="pag_cstm doc-dash-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Welcome Hero Banner -->
            <?php 
            $doc_name = $this->session->userdata('drusername') ?: 'Anushka';
            $doc_lname = $this->session->userdata('druserlname') ?: '';
            ?>
            <div class="doc-welcome-card">
                <div>
                    <span class="badge" style="background: rgba(255,255,255,0.2); color: #ffffff; font-size: 11.5px; padding: 4px 10px; margin-bottom: 8px;">
                        <i class="fa fa-stethoscope"></i> Clinical Practitioner Workspace
                    </span>
                    <h1 class="doc-welcome-title">Welcome back, Dr. <?=$doc_name;?> <?=$doc_lname;?></h1>
                    <p class="doc-welcome-sub">Manage patient consultations, visit schedules, clinic setups, and earnings.</p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="<?=base_url('doctorpanel/datetime');?>" class="btn" style="background: rgba(255,255,255,0.2); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 8px 16px; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fa fa-clock-o"></i> Set Slot Availability
                    </a>
                    <a href="<?=base_url('doctorpanel/earnings');?>" class="btn" style="background: #ffffff; color: #043d5b; font-weight: 800; border-radius: 8px; padding: 8px 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <i class="fa fa-line-chart"></i> View Earnings
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- 4 Standardized Metric Cards (Flex aligned & uniform padding) -->
            <div class="row">
                <!-- Metric 1: Today's Visits -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="stat-box" style="border-left-color: #f59e0b;">
                        <div>
                            <div class="stat-label">Today's Visits</div>
                            <div class="stat-number" style="color: #d97706;"><?=$todayappointment;?></div>
                            <div class="stat-sub">Scheduled for <?=date('d M Y');?></div>
                        </div>
                        <div class="stat-icon-wrap" style="background: #fef3c7; color: #d97706;">
                            <i class="fa fa-calendar-check-o"></i>
                        </div>
                    </div>
                </div>

                <!-- Metric 2: Net Doctor Earnings -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="stat-box" style="border-left-color: #00a896;">
                        <div>
                            <div class="stat-label">Net Doctor Earnings</div>
                            <div class="stat-number" style="color: #00a896;">₹<?=number_format(@$earnings->total_net, 2);?></div>
                            <div class="stat-sub">Minus 10% platform fee</div>
                        </div>
                        <div class="stat-icon-wrap" style="background: #f0fdfa; color: #00a896;">
                            <i class="fa fa-inr"></i>
                        </div>
                    </div>
                </div>

                <!-- Metric 3: Total Consultations -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="stat-box" style="border-left-color: #3b82f6;">
                        <div>
                            <div class="stat-label">Total Consultations</div>
                            <div class="stat-number" style="color: #2563eb;"><?=$totalappointment;?></div>
                            <div class="stat-sub">Lifetime booked visits</div>
                        </div>
                        <div class="stat-icon-wrap" style="background: #e0f2fe; color: #0284c7;">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>

                <!-- Metric 4: Practice Locations -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="stat-box" style="border-left-color: #10b981;">
                        <div>
                            <div class="stat-label">Practice Locations</div>
                            <div class="stat-number" style="color: #059669;"><?=intval($total_clinics) + intval($total_hospitals);?></div>
                            <div class="stat-sub"><?=$total_clinics;?> Clinics &bull; <?=$total_hospitals;?> Hospitals</div>
                        </div>
                        <div class="stat-icon-wrap" style="background: #ecfdf5; color: #059669;">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Practice Modules & Management Tools (High-Contrast Solid Icons) -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 14px 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-th-large" style="color: #00a896;"></i> Practice Modules &amp; Management Tools
                </h3>

                <div class="practice-modules-grid">
                    <a href="<?=base_url('manageappointment');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #00a896; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div class="module-title">Appointments</div>
                        <div class="module-desc">View &amp; manage visit slots</div>
                    </a>

                    <a href="<?=base_url('doctorpanel/earnings');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #028090; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-line-chart"></i>
                        </div>
                        <div class="module-title">Financials &amp; Payouts</div>
                        <div class="module-desc">Escrow &amp; weekly settlements</div>
                    </a>

                    <a href="<?=base_url('manageownclinic');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #043d5b; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                        <div class="module-title">Own Clinic Setup</div>
                        <div class="module-desc">Configure clinic chambers</div>
                    </a>

                    <a href="<?=base_url('managepractice');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #00a896; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <div class="module-title">Manage Practice</div>
                        <div class="module-desc">Consultation fees &amp; timings</div>
                    </a>

                    <a href="<?=base_url('doctorpanel/datetime');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #028090; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="module-title">Schedule Timings</div>
                        <div class="module-desc">Working days &amp; hours</div>
                    </a>

                    <a href="<?=base_url('doctorpanel/upcharhospital');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #043d5b; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-building-o"></i>
                        </div>
                        <div class="module-title">Hospital Affiliations</div>
                        <div class="module-desc">Visiting hospitals list</div>
                    </a>

                    <a href="<?=base_url('doctorpanel/managegallery');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #00a896; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-picture-o"></i>
                        </div>
                        <div class="module-title">Media &amp; Gallery</div>
                        <div class="module-desc">Clinic &amp; facility photos</div>
                    </a>

                    <a href="<?=base_url('doctorpanel/managenews');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #028090; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-newspaper-o"></i>
                        </div>
                        <div class="module-title">News &amp; Articles</div>
                        <div class="module-desc">Publish healthcare tips</div>
                    </a>

                    <a href="<?=base_url('profile_step1');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #043d5b; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div class="module-title">Doctor Profile</div>
                        <div class="module-desc">Credentials &amp; bio</div>
                    </a>

                    <a href="<?=base_url('doctorpanel/change_password/');?>" class="module-card">
                        <div class="module-icon-wrap" style="color: #00a896; background: #f0fdfa; border-color: #ccfbf1;">
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="module-title">Security Settings</div>
                        <div class="module-desc">Password &amp; account</div>
                    </a>
                </div>
            </div>

            <!-- Recent Appointments Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <div>
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-list" style="color: #00a896;"></i> Recent &amp; Upcoming Consultations
                        </h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Latest bookings across your clinics and visiting hospitals</p>
                    </div>
                    <a href="<?=base_url('manageappointment');?>" class="btn btn-xs btn-default" style="font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                        View All Bookings <i class="fa fa-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                                <th style="padding: 12px 16px;">Appt #</th>
                                <th style="padding: 12px 16px;">Patient Name</th>
                                <th style="padding: 12px 16px;">Contact</th>
                                <th style="padding: 12px 16px;">Visit Date &amp; Slot</th>
                                <th style="padding: 12px 16px;">Fee</th>
                                <th style="padding: 12px 16px;">Payment</th>
                                <th style="padding: 12px 16px; text-align: right;">Clinical Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($recent_appointments)): ?>
                                <?php foreach($recent_appointments as $a): ?>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; font-family: monospace; color: #00a896;">
                                        #<?=$a->appointment_id;?>
                                    </td>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #0f172a;">
                                        <?=htmlspecialchars($a->patient_name ?: ($a->user_fname . ' ' . $a->user_lname));?>
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">
                                        <i class="fa fa-phone" style="color: #00a896;"></i> <?=htmlspecialchars($a->patient_mobile ?: $a->user_mobile);?>
                                    </td>
                                    <td style="padding: 12px 16px; color: #334155;">
                                        <div><i class="fa fa-calendar text-muted"></i> <?=date('d M Y', strtotime($a->appointment_date));?></div>
                                        <div style="font-size: 11.5px; color: #64748b;"><i class="fa fa-clock-o text-muted"></i> <?=$a->from_timing;?> - <?=$a->to_timing;?></div>
                                    </td>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #0f172a;">
                                        ₹<?=number_format($a->amount, 2);?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <?php if($a->payment_status == 'DONE' || $a->payment_status == 'PAID'): ?>
                                            <span class="badge-status badge-paid"><i class="fa fa-check"></i> Paid</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-unpaid"><i class="fa fa-clock-o"></i> Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right;">
                                        <a href="<?=base_url('doctorpanel/prescription/'.$a->appointment_id);?>" class="btn btn-xs btn-default" style="color: #00a896; font-weight: 700; border-radius: 4px; padding: 4px 8px; margin-right: 4px;">
                                            <i class="fa fa-stethoscope"></i> Write Rx
                                        </a>
                                        <?php if($a->status != '2'): ?>
                                        <a href="<?=base_url('doctorpanel/complete_appointment?aid='.$a->appointment_id);?>" onclick="return confirm('Complete consultation visit and queue fee for settlement?');" class="btn btn-xs btn-warning" style="font-weight: 700; color: #ffffff; border-radius: 4px; padding: 4px 8px;">
                                            <i class="fa fa-check"></i> Complete
                                        </a>
                                        <?php else: ?>
                                        <span class="badge-status badge-visited"><i class="fa fa-check-circle"></i> Visited</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="padding: 30px; text-align: center; color: #94a3b8;">
                                        <i class="fa fa-calendar-o" style="font-size: 28px; display: block; margin-bottom: 6px;"></i>
                                        No recent appointments recorded yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>
