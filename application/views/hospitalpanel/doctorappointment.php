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

.doc-report-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header Doctor Card */
.doc-header-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px 26px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 18px;
}

.doc-profile-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.doc-hero-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ccfbf1;
    background: #ffffff;
}

.doc-hero-details h1 {
    font-size: 20px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 4px 0;
}

.doc-hero-details p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

.btn-back-report {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-back-report:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

/* KPI Summary Cards */
.kpi-doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.kpi-doc-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 16px 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.kpi-doc-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.kpi-doc-val {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
}

/* Filter Card */
.filter-date-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 14px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
}

.date-filter-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.date-filter-input {
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
}

.date-filter-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-date-filter {
    background: #00a896;
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    height: 38px;
    padding: 0 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Appointments Data Table */
.doc-table-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-custom-clean {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom-clean thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-custom-clean tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.table-custom-clean tbody tr:hover td {
    background: #f8fafc;
}

.badge-paid {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-unpaid {
    background: #fee2e2;
    color: #dc2626;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-anc {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-visited {
    background: #dbeafe;
    color: #1d4ed8;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 12px;
}

.badge-pending {
    background: #f1f5f9;
    color: #64748b;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 12px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="doc-report-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Doctor Profile Header Banner -->
        <div class="doc-header-card">
            <div class="doc-profile-left">
                <?php 
                $dr_avatar = !empty($doctor->drimage) ? admin_url()."public/assets/upload/".$doctor->drimage : base_url()."assets/images/user.jpg";
                $dr_name = !empty($doctor) ? prefixdr($doctor->fname).' '.$doctor->lname : 'Doctor Report';
                ?>
                <img src="<?=$dr_avatar;?>" class="doc-hero-avatar" alt="<?=$dr_name;?>">
                <div class="doc-hero-details">
                    <h1><i class="fa fa-user-md" style="color: #00a896; margin-right: 6px;"></i> <?=$dr_name;?></h1>
                    <p>
                        <?php if(!empty($doctor->mobile)): ?>
                            <span><i class="fa fa-phone" style="color: #00a896;"></i> <?=$doctor->mobile;?></span>
                        <?php endif; ?>
                        <?php if(!empty($doctor->email)): ?>
                            <span><i class="fa fa-envelope-o"></i> <?=$doctor->email;?></span>
                        <?php endif; ?>
                        <span style="color: #0284c7; font-weight: 700;"><i class="fa fa-hospital-o"></i> Hospital Clinical Ledger</span>
                    </p>
                </div>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/report');?>" class="btn-back-report">
                    <i class="fa fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </div>

        <!-- KPI Strip -->
        <div class="kpi-doc-grid">
            <div class="kpi-doc-card" style="border-left: 4px solid #00a896;">
                <div class="kpi-doc-title">Total Consultations</div>
                <div class="kpi-doc-val"><?=$hospital;?> Patients</div>
            </div>
            <div class="kpi-doc-card" style="border-left: 4px solid #10b981;">
                <div class="kpi-doc-title">Total Billed Revenue</div>
                <div class="kpi-doc-val" style="color: #10b981;">₹<?=number_format((float)$total_fee, 2);?></div>
            </div>
            <div class="kpi-doc-card" style="border-left: 4px solid #0284c7;">
                <div class="kpi-doc-title">Paid Consultations</div>
                <div class="kpi-doc-val" style="color: #0284c7;"><?=$total_paid;?></div>
            </div>
            <div class="kpi-doc-card" style="border-left: 4px solid #f59e0b;">
                <div class="kpi-doc-title">Pending / Unpaid</div>
                <div class="kpi-doc-val" style="color: #f59e0b;"><?=$total_unpaid;?></div>
            </div>
        </div>

        <!-- Filter by Date -->
        <div class="filter-date-card">
            <div>
                <strong style="font-size: 14px; color: #043d5b;">
                    <i class="fa fa-filter" style="color: #00a896;"></i> Filter Consultation Logs
                </strong>
            </div>
            <form action="<?=base_url('hospitalpanel/data');?>" method="GET" class="date-filter-form">
                <input type="hidden" name="id" value="<?=$doctor_id;?>">
                <input type="date" name="d" class="date-filter-input" value="<?=html_escape($filter_date);?>">
                <button type="submit" class="btn-date-filter">
                    <i class="fa fa-search"></i> Filter
                </button>
                <?php if(!empty($filter_date)): ?>
                    <a href="<?=base_url('hospitalpanel/data?id='.$doctor_id);?>" class="btn-back-report" style="padding: 7px 14px;">
                        <i class="fa fa-refresh"></i> Clear Date
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Data Table -->
        <div class="doc-table-card">
            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th>Apt #</th>
                            <th>Appointment Date</th>
                            <th>Time Session</th>
                            <th>Patient Full Name</th>
                            <th>Consultation Fee</th>
                            <th>Payment Status</th>
                            <th>Visit Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data)): ?>
                            <?php foreach($data as $p): ?>
                                <tr>
                                    <td style="font-weight: 800; color: #043d5b; font-family: monospace;">
                                        #<?=$p->appointment_id;?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a;">
                                            <?=date('d M Y', strtotime($p->appointment_date));?>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 12.5px; color: #64748b;">
                                            <i class="fa fa-clock-o"></i> <?=$p->from_timing.' - '.$p->to_timing;?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                            <?=html_escape($p->appointment_name);?>
                                        </div>
                                        <?php if(!empty($p->appointment_mobile)): ?>
                                            <div style="font-size: 11.5px; color: #64748b;">
                                                <i class="fa fa-phone"></i> <?=html_escape($p->appointment_mobile);?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong style="color: #043d5b; font-size: 13.5px;">
                                            ₹<?=number_format((float)$p->fee, 2);?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?php if($p->payment_status == 'DONE'): ?>
                                            <span class="badge-paid"><i class="fa fa-check-circle"></i> Paid</span>
                                        <?php elseif($p->payment_status == 'UNPAID'): ?>
                                            <span class="badge-unpaid"><i class="fa fa-exclamation-circle"></i> Unpaid</span>
                                        <?php else: ?>
                                            <span class="badge-anc"><i class="fa fa-clock-o"></i> Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(isset($p->appointment_status) && $p->appointment_status == '1'): ?>
                                            <span class="badge-visited"><i class="fa fa-check"></i> Visited</span>
                                        <?php else: ?>
                                            <span class="badge-pending"><i class="fa fa-hourglass-half"></i> In Queue</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="<?=base_url('hospitalpanel/manageappointment?search='.urlencode($p->appointment_name));?>" class="btn-back-report" style="font-size: 11.5px; padding: 4px 10px;">
                                            <i class="fa fa-external-link"></i> Manage
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-calendar-times-o" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Patient Consultations Found</strong>
                                    <span>No appointment logs recorded for this doctor matching the selected filters.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>