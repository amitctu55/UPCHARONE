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

.report-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.report-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.report-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.report-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

/* KPI Grid */
.kpi-report-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.kpi-report-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.kpi-report-card h3 {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 2px 0;
}

.kpi-report-card span {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
}

.kpi-report-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

/* Data Table Card */
.report-table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-report-custom {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table-report-custom thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-report-custom tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.table-report-custom tbody tr:hover td {
    background: #f8fafc;
}

.btn-view-report {
    background: #f0fdfa;
    color: #00a896 !important;
    border: 1px solid #ccfbf1;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
    padding: 6px 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none !important;
    transition: all 0.15s ease;
}

.btn-view-report:hover {
    background: #00a896;
    color: #ffffff !important;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="report-page-wrap">

        <!-- Header -->
        <div class="report-header-card">
            <h1><i class="fa fa-bar-chart" style="color: #00a896; margin-right: 8px;"></i> Hospital Analytics &amp; Doctor Performance Reports</h1>
            <p>Generate clinical consultation summaries, patient encounter logs, and physician performance analytics.</p>
        </div>

        <!-- KPI Grid -->
        <div class="kpi-report-grid">
            <div class="kpi-report-card">
                <div>
                    <h3><?=!empty($clinic) ? count($clinic) : 0;?></h3>
                    <span>Active Doctors</span>
                </div>
                <div class="kpi-report-icon" style="background: #ccfbf1; color: #0d9488;">
                    <i class="fa fa-user-md"></i>
                </div>
            </div>

            <div class="kpi-report-card">
                <div>
                    <h3>Live IPD</h3>
                    <span>Hospital Reports</span>
                </div>
                <div class="kpi-report-icon" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fa fa-file-text-o"></i>
                </div>
            </div>

            <div class="kpi-report-card">
                <div>
                    <h3>Direct Export</h3>
                    <span>Data Audits</span>
                </div>
                <div class="kpi-report-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="fa fa-download"></i>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="report-table-card">
            <div class="table-responsive">
                <table class="table table-report-custom">
                    <thead>
                        <tr>
                            <th>Practitioner Name</th>
                            <th>Contact Mobile</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th style="text-align: right;">Performance Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($clinic)): ?>
                            <?php foreach($clinic as $p): ?>
                                <tr>
                                    <td>
                                        <strong style="color: #043d5b; font-size: 13.5px;">
                                            <i class="fa fa-user-md" style="color: #00a896; margin-right: 6px;"></i>
                                            <?=prefixdr($p->fname).' '.$p->lname;?>
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="tel:<?=$p->mobile;?>" style="color: #475569; text-decoration: none;">
                                            <i class="fa fa-phone" style="color: #00a896; font-size: 12px;"></i> <?=$p->mobile;?>
                                        </a>
                                    </td>
                                    <td>
                                        <span style="color: #64748b; font-size: 12.5px;">
                                            <i class="fa fa-envelope-o" style="font-size: 11px;"></i> <?=$p->email;?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="background: #dcfce7; color: #15803d; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa fa-check-circle"></i> Active
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="<?=base_url('hospitalpanel/data?id='.$p->id);?>" class="btn-view-report">
                                            <i class="fa fa-line-chart"></i> View Clinical Report
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                    <i class="fa fa-file-text-o" style="font-size: 36px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Doctor Reports Available</strong>
                                    <span>No affiliated practitioners found to generate clinical reports.</span>
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
