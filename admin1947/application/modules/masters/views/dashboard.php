<style>
  :root {
    --adm-navy: #1d2a44;
    --adm-teal: #00a896;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-700: #334155;
    --adm-slate-600: #475569;
    --adm-slate-100: #f1f5f9;
    --adm-border: #cbd5e1;
  }

  .dashboard-wrapper {
    font-family: 'Inter', sans-serif;
    color: var(--adm-slate-800);
  }

  .content-header h1 {
    color: var(--adm-slate-900) !important;
    font-weight: 700;
    font-size: 22px;
    margin-bottom: 5px;
  }
  .content-header h1 small {
    color: var(--adm-slate-600) !important;
    font-size: 13px;
  }

  .section-banner {
    background: linear-gradient(135deg, #1d2a44 0%, #0f172a 100%);
    color: #ffffff;
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  }
  .section-banner h2 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* 8 Core Metrics Grid - Auto-responsive & equal height */
  .dash-metric-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
  }
  @media (max-width: 1199px) {
    .dash-metric-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media (max-width: 600px) {
    .dash-metric-grid {
      grid-template-columns: 1fr;
    }
  }

  .dash-metric-link {
    text-decoration: none !important;
    display: flex;
    height: 100%;
    color: inherit;
  }

  /* Metric Cards */
  .dash-metric-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 18px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    margin-bottom: 0;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .dash-metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px -2px rgba(0,0,0,0.08);
    border-color: var(--adm-teal);
  }

  .dash-metric-top {
    display: flex;
    flex-direction: column;
  }

  .dash-metric-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
  }

  .icon-blue { background: #e0f2fe; color: #0284c7; }
  .icon-green { background: #dcfce7; color: #16a34a; }
  .icon-amber { background: #fef3c7; color: #d97706; }
  .icon-purple { background: #f3e8ff; color: #9333ea; }
  .icon-red { background: #fee2e2; color: #dc2626; }
  .icon-teal { background: #ccfbf1; color: #0d9488; }
  .icon-indigo { background: #e0e7ff; color: #4f46e5; }
  .icon-rose { background: #ffe4e6; color: #e11d48; }

  .dash-metric-num {
    font-size: 24px;
    font-weight: 800;
    color: var(--adm-slate-900);
    line-height: 1.1;
    margin-bottom: 4px;
  }
  .dash-metric-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--adm-slate-700);
  }
  .dash-metric-sub {
    font-size: 11.5px;
    color: var(--adm-slate-600);
    margin-top: 10px;
  }

  /* Chart & Card Boxes */
  .dash-box {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    margin-bottom: 25px;
  }
  .dash-box-header {
    padding: 14px 18px;
    border-bottom: 1px solid var(--adm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .dash-box-title {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--adm-slate-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .dash-box-body {
    padding: 18px;
  }

  /* Quick Actions Grid - Auto-responsive & equal height */
  .quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
  @media (max-width: 600px) {
    .quick-actions-grid {
      grid-template-columns: 1fr;
    }
  }

  .quick-action-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 8px;
    background: #f8fafc;
    border: 1px solid var(--adm-border);
    color: var(--adm-slate-800);
    text-decoration: none !important;
    transition: all 0.2s;
    margin-bottom: 0;
    height: 100%;
  }
  .quick-action-card:hover {
    background: #ffffff;
    border-color: var(--adm-teal);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    color: var(--adm-teal);
    transform: translateX(3px);
  }
  .quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
</style>

<div class="content-wrapper dashboard-wrapper">
    <!-- Header -->
    <section class="content-header" style="padding-top: 15px;">
        <h1>
            <i class="fa fa-dashboard" style="color: var(--adm-teal);"></i> Executive Master Dashboard
            <small>Healthcare Ecosystem Overview &amp; Live System Telemetry</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active" style="color: var(--adm-slate-800); font-weight: 600;">Dashboard</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <!-- God's Eye Banner -->
        <div class="section-banner">
            <h2><i class="fa fa-eye" style="color: var(--adm-teal);"></i> God's Eye View &mdash; Platform Ecosystem Metrics</h2>
            <div style="font-size: 12px; color: #94a3b8;">
                <i class="fa fa-clock-o"></i> Live Synchronized: <?=date('d M Y, h:i A');?>
            </div>
        </div>

        <!-- 8 Core Metrics Grid (Auto-responsive & Equal Height) -->
        <div class="dash-metric-grid">
            <!-- 1. Total Hospitals (Approved vs Pending) -->
            <a href="<?=base_url('doctor/clinicreg/viewhospital');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-blue">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($approved_hospitals ?? $total_hospitals);?> <small style="font-size: 13px; font-weight: 600; color: #64748b;">Approved</small></div>
                        <div class="dash-metric-label">Hospital Facilities</div>
                    </div>
                    <div class="dash-metric-sub" style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <span class="label label-success" style="background: #dcfce7 !important; color: #16a34a !important; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                            <i class="fa fa-check-circle"></i> <?=number_format($approved_hospitals ?? $total_hospitals);?> Verified
                        </span>
                        <span class="label label-warning" style="background: #fef3c7 !important; color: #d97706 !important; border: 1px solid #fde68a; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                            <i class="fa fa-clock-o"></i> <?=number_format($pending_hospitals ?? 0);?> Pending
                        </span>
                    </div>
                </div>
            </a>

            <!-- 2. Total Clinics -->
            <a href="<?=base_url('doctor/clinicreg/viewclinic');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-green">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_clinics);?></div>
                        <div class="dash-metric-label">Active Clinics</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-primary"><i class="fa fa-map-marker"></i> Outpatient Centers</span>
                    </div>
                </div>
            </a>

            <!-- 3. Total Doctors -->
            <a href="<?=base_url('doctor/doctorview');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-amber">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_doctors);?></div>
                        <div class="dash-metric-label">Verified Doctors</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-warning"><i class="fa fa-stethoscope"></i> Multi-Specialty Practitioners</span>
                    </div>
                </div>
            </a>

            <!-- 4. Total Appointments -->
            <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-red">
                            <i class="fa fa-calendar-check-o"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_appointments);?></div>
                        <div class="dash-metric-label">Total Appointments</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-muted"><i class="fa fa-users"></i> <?=number_format($total_users);?> Registered Users</span>
                    </div>
                </div>
            </a>

            <!-- 5. ABHA IDs -->
            <a href="<?=base_url('abdm');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-purple">
                            <i class="fa fa-id-card"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_abha_ids);?></div>
                        <div class="dash-metric-label">ABDM ABHA IDs</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-success"><i class="fa fa-shield"></i> <?=number_format($active_abha_ids);?> Active Linked</span>
                    </div>
                </div>
            </a>

            <!-- 6. Consent Records -->
            <a href="<?=base_url('abdm');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-rose">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_consent_records);?></div>
                        <div class="dash-metric-label">Consent Artifacts</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-primary"><i class="fa fa-lock"></i> <?=number_format($active_consent_records);?> Active Records</span>
                    </div>
                </div>
            </a>

            <!-- 7. HPR Registrations -->
            <a href="<?=base_url('abdm');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-teal">
                            <i class="fa fa-address-book-o"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_hpr_registrations);?></div>
                        <div class="dash-metric-label">HPR Healthcare Registry</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-success"><i class="fa fa-check"></i> <?=number_format($approved_hpr_registrations);?> Approved Practitioners</span>
                    </div>
                </div>
            </a>

            <!-- 8. HFR Registrations -->
            <a href="<?=base_url('abdm');?>" class="dash-metric-link">
                <div class="dash-metric-card">
                    <div class="dash-metric-top">
                        <div class="dash-metric-icon-wrap icon-indigo">
                            <i class="fa fa-building-o"></i>
                        </div>
                        <div class="dash-metric-num"><?=number_format($total_hfr_registrations);?></div>
                        <div class="dash-metric-label">HFR Facilities Registry</div>
                    </div>
                    <div class="dash-metric-sub">
                        <span class="text-success"><i class="fa fa-check"></i> <?=number_format($approved_hfr_registrations);?> Approved Facilities</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Analytics Charts Row 1 -->
        <div class="row">
            <!-- Appointment Status Doughnut -->
            <div class="col-md-6 col-xs-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-pie-chart" style="color: #0284c7;"></i> Appointment Status Distribution
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div style="position: relative; height: 240px;">
                            <canvas id="appointmentStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Registration Trend Line -->
            <div class="col-md-6 col-xs-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-line-chart" style="color: #10b981;"></i> User Registration Trend (Last 6 Months)
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div style="position: relative; height: 240px;">
                            <canvas id="userTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Charts Row 2 & Quick Actions -->
        <div class="row">
            <!-- Doctor Specializations Bar -->
            <div class="col-md-6 col-xs-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-bar-chart" style="color: #f59e0b;"></i> Top Doctor Specializations
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div style="position: relative; height: 260px;">
                            <canvas id="specializationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hospital Approval Status Pie & Shortcuts -->
            <div class="col-md-6 col-xs-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-bolt" style="color: var(--adm-teal);"></i> Quick Operations &amp; Portals
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div class="quick-actions-grid">
                            <a href="<?=base_url('doctor/clinicreg/viewhospital');?>" class="quick-action-card">
                                <div class="quick-action-icon icon-blue"><i class="fa fa-hospital-o"></i></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px;">Hospitals</div>
                                    <div style="font-size: 11.5px; color: #64748b;">Manage &amp; verify facilities</div>
                                </div>
                            </a>
                            <a href="<?=base_url('doctor/doctorview');?>" class="quick-action-card">
                                <div class="quick-action-icon icon-amber"><i class="fa fa-user-md"></i></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px;">Doctors</div>
                                    <div style="font-size: 11.5px; color: #64748b;">Directory &amp; credentials</div>
                                </div>
                            </a>
                            <a href="<?=base_url('contactus');?>" class="quick-action-card">
                                <div class="quick-action-icon icon-teal"><i class="fa fa-envelope-o"></i></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px;">Contact Inquiries</div>
                                    <div style="font-size: 11.5px; color: #64748b;">Patient &amp; partner tickets</div>
                                </div>
                            </a>
                            <a href="<?=base_url('settings');?>" class="quick-action-card">
                                <div class="quick-action-icon icon-purple"><i class="fa fa-sliders"></i></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px;">System Settings</div>
                                    <div style="font-size: 11.5px; color: #64748b;">Email, SMS, ABDM, APIs</div>
                                </div>
                            </a>
                            <a href="<?=base_url('abdm');?>" class="quick-action-card">
                                <div class="quick-action-icon icon-rose"><i class="fa fa-id-card"></i></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px;">ABDM Gateway</div>
                                    <div style="font-size: 11.5px; color: #64748b;">ABHA &amp; HPR records</div>
                                </div>
                            </a>
                            <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="quick-action-card">
                                <div class="quick-action-icon icon-red"><i class="fa fa-calendar"></i></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13.5px;">Appointments</div>
                                    <div style="font-size: 11.5px; color: #64748b;">Consultation schedules</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW: Enterprise Portals & Operations Command Center -->
        <div class="section-banner" style="background: linear-gradient(135deg, #0f766e 0%, #0f172a 100%); margin-top: 5px;">
            <h2><i class="fa fa-cubes" style="color: #2dd4bf;"></i> Enterprise Multi-Role &amp; Field Operations Command Hub</h2>
            <div style="font-size: 12px; color: #99f6e4;">
                <i class="fa fa-check-circle"></i> Integrated RBAC Suite &bull; Real-time Field Telemetry
            </div>
        </div>

        <div class="row">
            <!-- 1. HR & Staff Management -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="dash-box" style="border-top: 3px solid #0284c7;">
                    <div class="dash-box-header" style="background: #f8fafc;">
                        <h4 class="dash-box-title" style="color: #0369a1;">
                            <i class="fa fa-users"></i> HR &amp; Staff Suite
                        </h4>
                        <span class="label label-primary" style="font-size: 11px;"><?=number_format($total_staff ?? 0);?> Active</span>
                    </div>
                    <div class="dash-box-body" style="padding: 14px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Today's Present:</span>
                            <strong style="color: #16a34a;"><?=number_format($today_attendance ?? 0);?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Pending Leaves:</span>
                            <strong style="color: #d97706;"><?=number_format($pending_leaves ?? 0);?></strong>
                        </div>
                        <div style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                            <a href="<?=base_url('../hr/dashboard');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-tachometer text-primary"></i> HR Hub
                            </a>
                            <a href="<?=base_url('../hr/employees');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-user-plus text-success"></i> Directory
                            </a>
                            <a href="<?=base_url('../hr/attendance');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-calendar-check-o text-info"></i> Roster
                            </a>
                            <a href="<?=base_url('../hr/payroll');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-money text-warning"></i> Payroll
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Logistics & Phlebotomists -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="dash-box" style="border-top: 3px solid #00a896;">
                    <div class="dash-box-header" style="background: #f8fafc;">
                        <h4 class="dash-box-title" style="color: #0f766e;">
                            <i class="fa fa-motorcycle"></i> Logistics &amp; Pickups
                        </h4>
                        <span class="label label-success" style="background: #00a896;"><?=number_format($total_path_orders ?? 0);?> Orders</span>
                    </div>
                    <div class="dash-box-body" style="padding: 14px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Active Pickups:</span>
                            <strong style="color: #0284c7;"><?=number_format($active_pickups ?? 0);?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Pending Lab Handoffs:</span>
                            <strong style="color: #d97706;"><?=number_format($pending_handoffs ?? 0);?></strong>
                        </div>
                        <div style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                            <a href="<?=base_url('../collector/dashboard');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-list-alt text-teal"></i> Collector App
                            </a>
                            <a href="<?=base_url('../operations/handoffs');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-flask text-primary"></i> Handoffs
                            </a>
                            <a href="<?=base_url('../operations/expenses');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-receipt text-danger"></i> Claims (<?=$pending_expenses ?? 0;?>)
                            </a>
                            <a href="<?=base_url('../attendance/punch');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-camera text-info"></i> GPS Punch
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. BDE CRM & Lead Engine -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="dash-box" style="border-top: 3px solid #f43f5e;">
                    <div class="dash-box-header" style="background: #f8fafc;">
                        <h4 class="dash-box-title" style="color: #be123c;">
                            <i class="fa fa-handshake-o"></i> BDE CRM &amp; Pipeline
                        </h4>
                        <span class="label label-danger" style="background: #f43f5e;"><?=number_format($total_crm_leads ?? 0);?> Leads</span>
                    </div>
                    <div class="dash-box-body" style="padding: 14px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Pipeline Potential:</span>
                            <strong style="color: #0f172a;">₹<?=number_format($crm_pipeline_val ?? 0);?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Acquisition Desk:</span>
                            <strong style="color: #16a34a;">Active</strong>
                        </div>
                        <div style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                            <a href="<?=base_url('../crm/dashboard');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-line-chart text-danger"></i> CRM Metrics
                            </a>
                            <a href="<?=base_url('../crm/leads');?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-columns text-primary"></i> Kanban Board
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Patient Social Auth & Sponsored Ads -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="dash-box" style="border-top: 3px solid #6366f1;">
                    <div class="dash-box-header" style="background: #f8fafc;">
                        <h4 class="dash-box-title" style="color: #4338ca;">
                            <i class="fa fa-google"></i> Google SSO &amp; Ads
                        </h4>
                        <span class="label label-info" style="background: #6366f1;"><?=number_format($total_gmail_users ?? 0);?> Google</span>
                    </div>
                    <div class="dash-box-body" style="padding: 14px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Sponsored Promos:</span>
                            <strong style="color: #eab308;"><?=number_format($active_ads_count ?? 0);?> Active</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px;">
                            <span style="color: #64748b;">Diagnostic Master:</span>
                            <strong style="color: #10b981;">Online</strong>
                        </div>
                        <div style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                            <a href="<?=base_url('users/userlogincreate/gmail_users');?>" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-google text-danger"></i> Gmail Users
                            </a>
                            <a href="<?=base_url('doctor/clinicreg/advertisment');?>" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-bullhorn text-warning"></i> Ads Manager
                            </a>
                            <a href="<?=base_url('doctor/pathology/assign_test');?>" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-heartbeat text-pink"></i> Path Tests
                            </a>
                            <a href="<?=base_url('doctor/pathology/add');?>" class="btn btn-xs btn-default" style="font-weight: 600; text-align: left;">
                                <i class="fa fa-plus text-success"></i> Add Test
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Load Chart.js CDN safely -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Appointment Status Doughnut
    var apptEl = document.getElementById("appointmentStatusChart");
    if (apptEl) {
        new Chart(apptEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [<?php
                    $lbls = [];
                    foreach ($appointment_status as $status) {
                        $label = $status_labels[$status['status']] ?? "Status " . $status['status'];
                        $lbls[] = json_encode($label);
                    }
                    echo !empty($lbls) ? implode(", ", $lbls) : '"Pending", "Confirmed", "Completed", "Cancelled"';
                ?>],
                datasets: [{
                    data: [<?php
                        $counts = [];
                        foreach ($appointment_status as $status) {
                            $counts[] = intval($status['count']);
                        }
                        echo !empty($counts) ? implode(", ", $counts) : '0, 0, 0, 0';
                    ?>],
                    backgroundColor: ['#f59e0b', '#10b981', '#0284c7', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { position: 'bottom', labels: { fontColor: '#334155', fontFamily: 'Inter', fontSize: 11, boxWidth: 12 } }
            }
        });
    }

    // 2. User Registration Trend Line
    var userEl = document.getElementById("userTrendChart");
    if (userEl) {
        new Chart(userEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: [<?php
                    $mLabels = [];
                    foreach ($user_trend as $trend) {
                        $mLabels[] = json_encode($trend['month']);
                    }
                    echo !empty($mLabels) ? implode(", ", $mLabels) : '"Recent"';
                ?>],
                datasets: [{
                    label: 'New Registrations',
                    data: [<?php
                        $mCounts = [];
                        foreach ($user_trend as $trend) {
                            $mCounts[] = intval($trend['count']);
                        }
                        echo !empty($mCounts) ? implode(", ", $mCounts) : '0';
                    ?>],
                    fill: true,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderColor: '#10b981',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#64748b', fontFamily: 'Inter' } }],
                    yAxes: [{ gridLines: { color: '#f1f5f9' }, ticks: { beginAtZero: true, fontColor: '#64748b', fontFamily: 'Inter' } }]
                }
            }
        });
    }

    // 3. Doctor Specialization Bar
    var specEl = document.getElementById("specializationChart");
    if (specEl) {
        new Chart(specEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: [<?php
                    $sLabels = [];
                    foreach ($specialization_dist as $spec) {
                        $sLabels[] = json_encode($spec['specialization']);
                    }
                    echo !empty($sLabels) ? implode(", ", $sLabels) : '"General"';
                ?>],
                datasets: [{
                    label: 'Practitioners',
                    data: [<?php
                        $sCounts = [];
                        foreach ($specialization_dist as $spec) {
                            $sCounts[] = intval($spec['count']);
                        }
                        echo !empty($sCounts) ? implode(", ", $sCounts) : '0';
                    ?>],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6', '#6366f1'],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#64748b', fontFamily: 'Inter', autoSkip: false } }],
                    yAxes: [{ gridLines: { color: '#f1f5f9' }, ticks: { beginAtZero: true, fontColor: '#64748b', fontFamily: 'Inter' } }]
                }
            }
        });
    }
});
</script>