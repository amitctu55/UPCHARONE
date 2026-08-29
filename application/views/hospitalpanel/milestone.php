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

.hospital-dash-container {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Welcome Hero Card */
.hospital-welcome-card {
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

.hospital-welcome-card::after {
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

.hospital-welcome-title {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 6px 0;
    color: #ffffff;
}

.hospital-welcome-sub {
    font-size: 13.5px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

.hospital-welcome-badge {
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #ffffff;
}

/* Metric Cards Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 22px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    text-decoration: none !important;
    color: inherit;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.stat-info h3 {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
    line-height: 1.2;
}

.stat-info p {
    font-size: 13px;
    color: #64748b;
    font-weight: 600;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.stat-icon.green { background: #dcfce7; color: #16a34a; }
.stat-icon.teal { background: #ccfbf1; color: #0d9488; }
.stat-icon.amber { background: #fef3c7; color: #d97706; }
.stat-icon.blue { background: #e0f2fe; color: #0284c7; }
.stat-icon.purple { background: #f3e8ff; color: #7e22ce; }

/* Action Cards */
.dash-section-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}

.action-btn-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none !important;
    color: #334155;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.action-btn-card:hover {
    border-color: #00a896;
    background: #f0fdfa;
    color: #00a896;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.12);
}

.action-btn-card i {
    font-size: 18px;
    color: #00a896;
    width: 24px;
    text-align: center;
}

.action-btn-card span {
    flex: 1;
}

.action-btn-card .arrow-icon {
    font-size: 12px;
    color: #94a3b8;
    transition: transform 0.2s;
}

.action-btn-card:hover .arrow-icon {
    transform: translateX(3px);
    color: #00a896;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="hospital-dash-container">
        
        <!-- Welcome Banner -->
        <div class="hospital-welcome-card">
            <div>
                <h1 class="hospital-welcome-title">
                    Welcome, <?=$this->session->userdata('hospitalname') ? $this->session->userdata('hospitalname') : 'Hospital Partner';?>!
                </h1>
                <p class="hospital-welcome-sub">
                    Manage affiliated doctors, patient appointments, and hospital operations from your central dashboard.
                </p>
            </div>
            <div class="hospital-welcome-badge">
                <i class="fa fa-shield"></i> Verified Healthcare Facility
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="stats-grid">
            <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="stat-card">
                <div class="stat-info">
                    <h3><?=$totaldoctor;?></h3>
                    <p>Affiliated Doctors</p>
                </div>
                <div class="stat-icon green">
                    <i class="fa fa-user-md"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment?d='.date('Y-m-d'));?>" class="stat-card">
                <div class="stat-info">
                    <h3><?=$todayappointment;?></h3>
                    <p>Today's Appointments</p>
                </div>
                <div class="stat-icon amber">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="stat-card">
                <div class="stat-info">
                    <h3><?=$totalappointment;?></h3>
                    <p>Total Appointments</p>
                </div>
                <div class="stat-icon teal">
                    <i class="fa fa-calendar"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/bed_matrix');?>" class="stat-card">
                <div class="stat-info">
                    <h3><i class="fa fa-bed"></i></h3>
                    <p>Live Bed Matrix</p>
                </div>
                <div class="stat-icon blue">
                    <i class="fa fa-hospital-o"></i>
                </div>
            </a>
        </div>

        <!-- Quick Access Shortcuts -->
        <div class="dash-section-title">
            <i class="fa fa-bolt" style="color: #f59e0b;"></i> Quick Navigation &amp; Operations
        </div>

        <div class="quick-actions-grid">
            <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="action-btn-card">
                <i class="fa fa-user-md"></i>
                <span>Manage Doctors</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/adddoctor');?>" class="action-btn-card">
                <i class="fa fa-plus-circle"></i>
                <span>Add Doctor</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="action-btn-card">
                <i class="fa fa-calendar"></i>
                <span>Manage Appointments</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/bed_matrix');?>" class="action-btn-card">
                <i class="fa fa-bed"></i>
                <span>Bed Matrix (IPD)</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/admissions');?>" class="action-btn-card">
                <i class="fa fa-user-plus"></i>
                <span>Inpatient Admissions</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/earnings');?>" class="action-btn-card">
                <i class="fa fa-line-chart"></i>
                <span>Revenue &amp; Payouts</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/updateprofile');?>" class="action-btn-card">
                <i class="fa fa-hospital-o"></i>
                <span>Hospital Profile</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>

            <a href="<?=base_url('hospitalpanel/package');?>" class="action-btn-card">
                <i class="fa fa-tags"></i>
                <span>Health Packages</span>
                <i class="fa fa-chevron-right arrow-icon"></i>
            </a>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>