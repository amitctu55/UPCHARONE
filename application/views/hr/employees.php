<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* Enterprise Staff Directory Styles */
.staff-kpi-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.staff-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
}
.staff-kpi-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.staff-filter-toolbar {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 16px 20px;
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}
.staff-role-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 9px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.2s;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
}
.staff-role-pill:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.staff-role-pill.active {
    background: #0f172a;
    color: #ffffff !important;
    border-color: #0f172a;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
}

/* Grid Profile Card */
.staff-grid-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 22px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}
.staff-grid-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.09);
    border-color: #cbd5e1;
}
.staff-avatar-circle {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    color: #ffffff;
    font-weight: 800;
    font-size: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.staff-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
}
.staff-view-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}
.staff-view-btn:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.staff-view-btn.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}

/* Toast */
.staff-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #0f172a;
    color: #ffffff;
    padding: 14px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    display: none;
    z-index: 9999;
    font-size: 13.5px;
    font-weight: 600;
    border-left: 4px solid #10b981;
}
</style>

<div class="staff-toast" id="staffDirectoryToast">
    <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
    <span id="staffDirectoryToastMsg">Action completed successfully.</span>
</div>

<!-- Header & Primary Actions -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(0, 168, 150, 0.1); color: #00a896; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
            <i class="fa fa-users"></i> Enterprise Workforce Directory
        </div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
            Staff Profiles &amp; Personnel Directory
        </h1>
        <p style="color: #64748b; font-size: 13.5px; margin: 4px 0 0 0;">
            Central personnel roster across field phlebotomy, healthcare BDEs, operations desk &amp; administrative staff.
        </p>
    </div>
    
    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        <button type="button" class="btn btn-default" onclick="window.print()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 10px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <i class="fa fa-print" style="color: #64748b;"></i> Print Roster
        </button>
        <button type="button" class="btn" data-toggle="modal" data-target="#addEmployeeModal" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; border: none; font-weight: 700; border-radius: 10px; padding: 10px 20px; font-size: 13px; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3); display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa fa-user-plus" style="color: #2dd4bf;"></i> + Onboard New Employee
        </button>
    </div>
</div>

<!-- Feedback Alerts -->
<?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success" style="border-radius: 12px; font-size: 13.5px; border-left: 5px solid #10b981; background: #f0fdf4; color: #166534; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.1); margin-bottom: 20px;">
        <i class="fa fa-check-circle" style="color: #10b981; margin-right: 6px;"></i> <?= $this->session->flashdata('success_msg'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger" style="border-radius: 12px; font-size: 13.5px; border-left: 5px solid #ef4444; background: #fef2f2; color: #991b1b; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.1); margin-bottom: 20px;">
        <i class="fa fa-exclamation-circle" style="color: #ef4444; margin-right: 6px;"></i> <?= $this->session->flashdata('error_msg'); ?>
    </div>
<?php endif; ?>

<?php
// Calculate Dynamic Statistics
$totalStaff = count($employees);
$collectorCount = 0;
$bdeCount = 0;
$opsCount = 0;
$activeCount = 0;
$totalPayrollBudget = 0;

foreach ($employees as $e) {
    if ($e['status'] === 'active') $activeCount++;
    if ($e['role'] === 'collector') $collectorCount++;
    elseif ($e['role'] === 'bde') $bdeCount++;
    elseif (in_array($e['role'], ['hr', 'office_staff', 'super_admin'])) $opsCount++;
    $totalPayrollBudget += floatval($e['base_salary']);
}
$avgSalary = ($totalStaff > 0) ? round($totalPayrollBudget / $totalStaff) : 0;
?>

<!-- 4 Executive KPI Metric Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <!-- Active Headcount -->
    <div class="staff-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Active Headcount</small>
                <div style="font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 4px; line-height: 1;"><?= $totalStaff; ?></div>
            </div>
            <div class="staff-kpi-icon" style="background: #e0f2fe; color: #0284c7;">
                <i class="fa fa-users"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #059669; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
            <span><i class="fa fa-check-circle"></i> Active: <strong><?= $activeCount; ?></strong></span>
            <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 800;">100% Verified</span>
        </div>
    </div>

    <!-- Phlebotomists -->
    <div class="staff-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Field Phlebotomists</small>
                <div style="font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 4px; line-height: 1;"><?= $collectorCount; ?></div>
            </div>
            <div class="staff-kpi-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                <i class="fa fa-motorcycle"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #0284c7; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
            <span><i class="fa fa-map-marker"></i> Doorstep sample collection</span>
            <span style="font-size: 11px; color: #64748b; font-weight: 700;">Field Fleet</span>
        </div>
    </div>

    <!-- BDEs -->
    <div class="staff-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">BDEs &amp; Growth Leads</small>
                <div style="font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 4px; line-height: 1;"><?= $bdeCount; ?></div>
            </div>
            <div class="staff-kpi-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                <i class="fa fa-line-chart"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #7c3aed; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
            <span><i class="fa fa-handshake-o"></i> Clinic &amp; Hospital Tie-ups</span>
            <span style="font-size: 11px; color: #64748b; font-weight: 700;">Revenue</span>
        </div>
    </div>

    <!-- Monthly Base Payroll -->
    <div class="staff-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Monthly Base CTC</small>
                <div style="font-size: 28px; font-weight: 800; color: #15803d; margin-top: 4px; line-height: 1;">₹<?= number_format($totalPayrollBudget); ?></div>
            </div>
            <div class="staff-kpi-icon" style="background: #dcfce7; color: #15803d;">
                <i class="fa fa-inr"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #64748b; display: flex; justify-content: space-between; align-items: center;">
            <span>Avg CTC: <strong>₹<?= number_format($avgSalary); ?></strong>/mo</span>
            <span style="color: #15803d; font-weight: 700;">Payroll Roster</span>
        </div>
    </div>
</div>

<!-- Filter Toolbar & View Mode Switcher -->
<div class="staff-filter-toolbar">
    <!-- Role Filter Pills -->
    <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
        <a href="<?= base_url('hr/directory'); ?>" class="staff-role-pill <?= empty($selected_role) ? 'active' : ''; ?>">
            All Roles (<?= $totalStaff; ?>)
        </a>
        <a href="<?= base_url('hr/directory?role=collector'); ?>" class="staff-role-pill <?= $selected_role === 'collector' ? 'active' : ''; ?>">
            <i class="fa fa-motorcycle" style="color: #0284c7;"></i> Phlebotomists (<?= $collectorCount; ?>)
        </a>
        <a href="<?= base_url('hr/directory?role=bde'); ?>" class="staff-role-pill <?= $selected_role === 'bde' ? 'active' : ''; ?>">
            <i class="fa fa-line-chart" style="color: #8b5cf6;"></i> BDE Executives (<?= $bdeCount; ?>)
        </a>
        <a href="<?= base_url('hr/directory?role=hr'); ?>" class="staff-role-pill <?= $selected_role === 'hr' ? 'active' : ''; ?>">
            <i class="fa fa-shield" style="color: #00a896;"></i> HR Specialist
        </a>
        <a href="<?= base_url('hr/directory?role=office_staff'); ?>" class="staff-role-pill <?= $selected_role === 'office_staff' ? 'active' : ''; ?>">
            <i class="fa fa-building-o" style="color: #f59e0b;"></i> Operations &amp; Lab
        </a>
    </div>

    <!-- Right Controls: Status filter, Live Search & Grid/Table Toggle -->
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <!-- Status Filter Select -->
        <select id="staffStatusFilter" class="form-control input-sm" style="width: 120px; height: 36px; border-radius: 8px; font-weight: 600; border-color: #cbd5e1;">
            <option value="all">All Status</option>
            <option value="active">Active Only</option>
            <option value="inactive">Inactive</option>
        </select>

        <!-- Live Instant Search -->
        <div style="position: relative; width: 220px;">
            <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
            <input type="text" id="directorySearchInput" class="form-control" placeholder="Search staff, phone, code..." style="padding-left: 34px; height: 36px; border-radius: 8px; font-size: 12.5px; border: 1px solid #cbd5e1;">
        </div>

        <!-- View Switcher -->
        <div style="display: inline-flex; background: #f1f5f9; padding: 3px; border-radius: 9px; border: 1px solid #e2e8f0; gap: 2px;">
            <button type="button" class="staff-view-btn active" id="btnViewGrid" title="Visual Cards View">
                <i class="fa fa-th-large"></i>
            </button>
            <button type="button" class="staff-view-btn" id="btnViewTable" title="Tabular Roster View">
                <i class="fa fa-list"></i>
            </button>
        </div>
    </div>
</div>

<!-- VIEW 1: Visual Profile Cards View (Default) -->
<div id="staffGridView" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <?php if (!empty($employees)): ?>
        <?php foreach ($employees as $e): 
            $role = strtolower($e['role']);
            $roleGradients = [
                'collector' => ['#0284c7', 'linear-gradient(135deg, #0284c7 0%, #38bdf8 100%)', 'rgba(2, 132, 199, 0.1)', '#0284c7'],
                'bde' => ['#8b5cf6', 'linear-gradient(135deg, #7c3aed 0%, #a855f7 100%)', 'rgba(139, 92, 246, 0.1)', '#7c3aed'],
                'hr' => ['#00a896', 'linear-gradient(135deg, #0f172a 0%, #00a896 100%)', 'rgba(0, 168, 150, 0.1)', '#00a896'],
                'office_staff' => ['#f59e0b', 'linear-gradient(135deg, #d97706 0%, #fbbf24 100%)', 'rgba(245, 158, 11, 0.1)', '#d97706'],
                'super_admin' => ['#0f172a', 'linear-gradient(135deg, #0f172a 0%, #334155 100%)', 'rgba(15, 23, 42, 0.1)', '#0f172a']
            ];
            $rg = $roleGradients[$role] ?? ['#64748b', '#64748b', '#f1f5f9', '#475569'];

            $initials = strtoupper(substr($e['name'], 0, 1));
            if (strpos($e['name'], ' ') !== false) {
                $parts = explode(' ', $e['name']);
                $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[count($parts)-1], 0, 1));
            }
            $isActive = ($e['status'] === 'active');
        ?>
        <div class="staff-grid-card staff-item" 
             data-id="<?=$e['id'];?>" 
             data-status="<?=$e['status'];?>" 
             data-role="<?=$e['role'];?>" 
             data-name="<?=strtolower(html_escape($e['name']));?>" 
             data-code="<?=strtolower(html_escape($e['staff_code']));?>" 
             data-phone="<?=html_escape($e['phone']);?>" 
             data-area="<?=strtolower(html_escape($e['assigned_area']));?>"
             data-dept="<?=strtolower(html_escape($e['department']));?>">
            
            <!-- Top Section: Avatar, Status & Role Badge -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="staff-avatar-circle" style="background: <?=$rg[1];?>;">
                            <?=$initials;?>
                        </div>
                        <div>
                            <strong style="font-size: 15.5px; color: #0f172a; display: block; line-height: 1.2;">
                                <?=html_escape($e['name']);?>
                            </strong>
                            <span style="display: inline-block; font-family: monospace; font-size: 11px; font-weight: 700; color: #64748b; background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; margin-top: 3px;">
                                <?=$e['staff_code'];?>
                            </span>
                        </div>
                    </div>

                    <!-- Status Indicator -->
                    <span class="staff-status-badge" style="display: inline-flex; align-items: center; gap: 5px; background: <?=$isActive ? '#dcfce7' : '#fee2e2';?>; color: <?=$isActive ? '#166534' : '#991b1b';?>; font-size: 10.5px; font-weight: 800; padding: 3px 8px; border-radius: 12px; text-transform: uppercase;">
                        <span class="staff-status-dot" style="background: <?=$isActive ? '#16a34a' : '#dc2626';?>;"></span>
                        <?=$isActive ? 'Active' : 'Inactive';?>
                    </span>
                </div>

                <!-- Designation & Department -->
                <div style="margin-bottom: 14px;">
                    <span style="display: inline-block; font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 3px 9px; border-radius: 6px; background: <?=$rg[2];?>; color: <?=$rg[3];?>;">
                        <?=html_escape($e['designation'] ?: strtoupper($e['role']));?>
                    </span>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                        <i class="fa fa-briefcase" style="color: #94a3b8; margin-right: 4px;"></i> <?=html_escape($e['department'] ?: 'Operations');?>
                    </div>
                </div>

                <!-- Contact & Territory Box -->
                <div style="background: #f8fafc; border-radius: 10px; padding: 12px; border: 1px solid #f1f5f9; margin-bottom: 14px; font-size: 12px; display: grid; gap: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #64748b;"><i class="fa fa-phone" style="color: #10b981; width: 14px;"></i> Phone:</span>
                        <a href="tel:<?=html_escape($e['phone']);?>" style="color: #0284c7; text-decoration: none; font-weight: 700;">
                            <?=html_escape($e['phone']);?>
                        </a>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #64748b;"><i class="fa fa-envelope-o" style="color: #38bdf8; width: 14px;"></i> Email:</span>
                        <a href="mailto:<?=html_escape($e['email']);?>" style="color: #475569; text-decoration: none; font-weight: 600; max-width: 180px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                            <?=html_escape($e['email']);?>
                        </a>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #64748b;"><i class="fa fa-map-marker" style="color: #ef4444; width: 14px;"></i> Area:</span>
                        <span style="color: #0f172a; font-weight: 600;"><?=html_escape($e['assigned_area'] ?: 'Lucknow Central');?></span>
                    </div>
                </div>

                <!-- Base CTC strip -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding: 0 4px;">
                    <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">Monthly Base CTC:</span>
                    <strong style="color: #15803d; font-size: 15px;">₹<?=number_format($e['base_salary'], 0);?><span style="font-size: 11px; color: #64748b; font-weight: 500;">/mo</span></strong>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div style="display: flex; gap: 8px; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                <button type="button" class="btn btn-sm btn-default btn-view-profile" 
                        data-id="<?=$e['id'];?>" 
                        data-name="<?=html_escape($e['name']);?>" 
                        data-code="<?=$e['staff_code'];?>" 
                        data-role="<?=html_escape($e['role']);?>" 
                        data-desig="<?=html_escape($e['designation']);?>" 
                        data-dept="<?=html_escape($e['department']);?>" 
                        data-email="<?=html_escape($e['email']);?>" 
                        data-phone="<?=html_escape($e['phone']);?>" 
                        data-area="<?=html_escape($e['assigned_area']);?>" 
                        data-salary="<?=number_format($e['base_salary'], 2);?>" 
                        data-status="<?=$e['status'];?>" 
                        style="flex-grow: 1; border-radius: 8px; font-weight: 700; font-size: 12px; background: #ffffff; border-color: #cbd5e1;">
                    <i class="fa fa-id-card-o" style="color: #00a896;"></i> Profile
                </button>

                <button type="button" class="btn btn-sm btn-default btn-edit-employee" 
                        data-id="<?=$e['id'];?>" 
                        data-name="<?=html_escape($e['name']);?>" 
                        data-role="<?=$e['role'];?>" 
                        data-desig="<?=html_escape($e['designation']);?>" 
                        data-dept="<?=html_escape($e['department']);?>" 
                        data-email="<?=html_escape($e['email']);?>" 
                        data-phone="<?=html_escape($e['phone']);?>" 
                        data-area="<?=html_escape($e['assigned_area']);?>" 
                        data-salary="<?=$e['base_salary'];?>" 
                        data-status="<?=$e['status'];?>" 
                        title="Edit Details" style="border-radius: 8px; padding: 6px 10px;">
                    <i class="fa fa-pencil" style="color: #64748b;"></i>
                </button>

                <button type="button" class="btn btn-sm btn-default btn-toggle-status" 
                        data-id="<?=$e['id'];?>" 
                        title="Toggle Active/Inactive" style="border-radius: 8px; padding: 6px 10px;">
                    <i class="fa fa-power-off" style="color: <?=$isActive ? '#10b981' : '#ef4444';?>;"></i>
                </button>

                <a href="<?=base_url('attendance/roster?search=' . urlencode($e['name']));?>" class="btn btn-sm btn-default" title="View Attendance" style="border-radius: 8px; padding: 6px 10px;">
                    <i class="fa fa-calendar" style="color: #f59e0b;"></i>
                </a>
            </div>

        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 48px 20px; background: #ffffff; border-radius: 16px; border: 1px dashed #cbd5e1;">
            <i class="fa fa-users" style="font-size: 36px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
            <strong style="font-size: 15px; color: #475569;">No staff profiles found</strong>
            <p style="font-size: 13px; color: #94a3b8; margin: 4px 0 0 0;">Try adjusting your search criteria or click "+ Onboard New Employee".</p>
        </div>
    <?php endif; ?>
</div>

<!-- VIEW 2: Detailed Tabular Roster View (Hidden by default, toggled via JS) -->
<div id="staffTableView" style="display: none; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04); overflow: hidden; margin-bottom: 24px;">
    <div class="table-responsive">
        <table class="table" id="staffDirectoryTable" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                    <th style="padding: 14px 20px; font-weight: 800; border: none;">Staff Code &amp; Name</th>
                    <th style="padding: 14px 20px; font-weight: 800; border: none;">Role &amp; Department</th>
                    <th style="padding: 14px 20px; font-weight: 800; border: none;">Contact Details</th>
                    <th style="padding: 14px 20px; font-weight: 800; border: none;">Territory / Area</th>
                    <th style="padding: 14px 20px; font-weight: 800; border: none;">Monthly Base Pay</th>
                    <th style="padding: 14px 20px; font-weight: 800; border: none;">Status</th>
                    <th style="padding: 14px 20px; font-weight: 800; border: none; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)): ?>
                    <?php foreach ($employees as $e): 
                        $role = strtolower($e['role']);
                        $initials = strtoupper(substr($e['name'], 0, 1));
                        if (strpos($e['name'], ' ') !== false) {
                            $parts = explode(' ', $e['name']);
                            $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[count($parts)-1], 0, 1));
                        }
                        $isActive = ($e['status'] === 'active');
                    ?>
                    <tr class="staff-row staff-item" 
                        data-id="<?=$e['id'];?>" 
                        data-status="<?=$e['status'];?>" 
                        data-role="<?=$e['role'];?>" 
                        data-name="<?=strtolower(html_escape($e['name']));?>" 
                        data-code="<?=strtolower(html_escape($e['staff_code']));?>" 
                        data-phone="<?=html_escape($e['phone']);?>" 
                        data-area="<?=strtolower(html_escape($e['assigned_area']));?>"
                        data-dept="<?=strtolower(html_escape($e['department']));?>"
                        style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                        
                        <td style="padding: 14px 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #0f172a; color: #ffffff; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <?=$initials;?>
                                </div>
                                <div>
                                    <strong style="color: #0f172a; font-size: 14px; display: block; line-height: 1.2;">
                                        <?=html_escape($e['name']);?>
                                    </strong>
                                    <span style="display: inline-block; font-family: monospace; font-size: 11px; font-weight: 700; color: #64748b; background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; margin-top: 2px;">
                                        <?=$e['staff_code'];?>
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td style="padding: 14px 20px;">
                            <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11px; text-transform: uppercase; font-weight: 800; padding: 4px 8px;">
                                <?=html_escape($e['designation'] ?: strtoupper($e['role']));?>
                            </span>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                                <?=html_escape($e['department'] ?: 'Operations');?>
                            </div>
                        </td>

                        <td style="padding: 14px 20px;">
                            <div style="font-size: 13px; font-weight: 600; color: #1e293b;">
                                <a href="tel:<?=html_escape($e['phone']);?>" style="color: #0284c7; text-decoration: none;">
                                    <i class="fa fa-phone" style="color: #10b981; margin-right: 4px;"></i> <?=html_escape($e['phone']);?>
                                </a>
                            </div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                <?=html_escape($e['email']);?>
                            </div>
                        </td>

                        <td style="padding: 14px 20px;">
                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #f8fafc; border: 1px solid #e2e8f0; padding: 3px 8px; border-radius: 6px; font-size: 11.5px; color: #334155; font-weight: 600;">
                                <i class="fa fa-map-marker" style="color: #ef4444;"></i> <?=html_escape($e['assigned_area'] ?: 'Lucknow Central');?>
                            </span>
                        </td>

                        <td style="padding: 14px 20px;">
                            <strong style="color: #15803d; font-size: 14px;">₹<?=number_format($e['base_salary'], 2);?></strong>
                            <small style="display: block; color: #94a3b8; font-size: 11px;">monthly CTC</small>
                        </td>

                        <td style="padding: 14px 20px;">
                            <span style="display: inline-flex; align-items: center; gap: 5px; background: <?=$isActive ? '#dcfce7' : '#fee2e2';?>; color: <?=$isActive ? '#166534' : '#991b1b';?>; font-size: 10.5px; font-weight: 800; padding: 4px 9px; border-radius: 20px; text-transform: uppercase;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: <?=$isActive ? '#16a34a' : '#dc2626';?>;"></span>
                                <?=$isActive ? 'Active' : 'Inactive';?>
                            </span>
                        </td>

                        <td style="padding: 14px 20px; text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                <button type="button" class="btn btn-xs btn-default btn-view-profile" 
                                        data-id="<?=$e['id'];?>" 
                                        data-name="<?=html_escape($e['name']);?>" 
                                        data-code="<?=$e['staff_code'];?>" 
                                        data-role="<?=html_escape($e['role']);?>" 
                                        data-desig="<?=html_escape($e['designation']);?>" 
                                        data-dept="<?=html_escape($e['department']);?>" 
                                        data-email="<?=html_escape($e['email']);?>" 
                                        data-phone="<?=html_escape($e['phone']);?>" 
                                        data-area="<?=html_escape($e['assigned_area']);?>" 
                                        data-salary="<?=number_format($e['base_salary'], 2);?>" 
                                        data-status="<?=$e['status'];?>" 
                                        title="View Profile" style="border-radius: 6px; padding: 5px 8px;">
                                    <i class="fa fa-id-card-o" style="color: #00a896;"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-default btn-edit-employee" 
                                        data-id="<?=$e['id'];?>" 
                                        data-name="<?=html_escape($e['name']);?>" 
                                        data-role="<?=$e['role'];?>" 
                                        data-desig="<?=html_escape($e['designation']);?>" 
                                        data-dept="<?=html_escape($e['department']);?>" 
                                        data-email="<?=html_escape($e['email']);?>" 
                                        data-phone="<?=html_escape($e['phone']);?>" 
                                        data-area="<?=html_escape($e['assigned_area']);?>" 
                                        data-salary="<?=$e['base_salary'];?>" 
                                        data-status="<?=$e['status'];?>" 
                                        title="Edit" style="border-radius: 6px; padding: 5px 8px;">
                                    <i class="fa fa-pencil" style="color: #64748b;"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-default btn-toggle-status" data-id="<?=$e['id'];?>" title="Toggle Status" style="border-radius: 6px; padding: 5px 8px;">
                                    <i class="fa fa-power-off" style="color: <?=$isActive ? '#10b981' : '#ef4444';?>;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal 1: Detailed Staff Profile Modal -->
<div class="modal fade" id="staffProfileModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 18px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 22px 24px; border: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 24px;">&times;</button>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #00a896 0%, #0284c7 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; box-shadow: 0 4px 12px rgba(0,0,0,0.2);" id="modalProfileAvatar">
                        H
                    </div>
                    <div>
                        <h4 class="modal-title" id="modalProfileName" style="font-weight: 800; font-size: 18px; margin: 0; color: #ffffff;">
                            Employee Name
                        </h4>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                            <span class="badge" id="modalProfileCode" style="background: rgba(255,255,255,0.15); font-family: monospace; font-size: 11px;">
                                UPC-STF-001
                            </span>
                            <span class="badge" id="modalProfileStatus" style="background: #10b981; font-size: 10px; text-transform: uppercase;">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-body" style="padding: 24px; background: #ffffff;">
                <div style="display: grid; gap: 16px;">
                    <!-- Role & Dept strip -->
                    <div style="background: #f8fafc; border-radius: 12px; padding: 14px 18px; border: 1px solid #e2e8f0; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <small style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Designation / Title</small>
                            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="modalProfileDesig">
                                Senior Specialist
                            </div>
                        </div>
                        <div>
                            <small style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Department</small>
                            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="modalProfileDept">
                                Operations
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details Box -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px;">
                        <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px;">
                            Contact &amp; Location Telemetry
                        </div>
                        <div style="display: grid; gap: 10px; font-size: 13px;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #64748b;"><i class="fa fa-phone" style="color: #10b981; width: 16px;"></i> Mobile Phone:</span>
                                <strong id="modalProfilePhone">+91 9999990001</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #64748b;"><i class="fa fa-envelope-o" style="color: #0284c7; width: 16px;"></i> Corporate Email:</span>
                                <strong id="modalProfileEmail">staff@upchar.info</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #64748b;"><i class="fa fa-map-marker" style="color: #ef4444; width: 16px;"></i> Assigned Territory:</span>
                                <strong id="modalProfileArea">Lucknow Central</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Compensation Box -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; background: #f0fdf4;">
                        <div style="font-size: 11.5px; font-weight: 800; color: #166534; text-transform: uppercase; margin-bottom: 8px;">
                            Compensation &amp; Payroll Band
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: baseline;">
                            <span style="font-size: 13px; color: #166534; font-weight: 600;">Monthly Base CTC:</span>
                            <strong style="font-size: 20px; color: #15803d;" id="modalProfileSalary">₹35,000.00</strong>
                        </div>
                        <small style="color: #166534; font-size: 11.5px; display: block; margin-top: 2px;">
                            Subject to standard PF/ESI deductions and biometric punch log attendance.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 9px; font-weight: 600;">Close</button>
                <div style="display: flex; gap: 8px;">
                    <a href="#" id="modalProfileCallBtn" class="btn btn-default" style="border-radius: 9px; font-weight: 700;">
                        <i class="fa fa-phone" style="color: #10b981;"></i> Call
                    </a>
                    <a href="#" id="modalProfileEmailBtn" class="btn btn-default" style="border-radius: 9px; font-weight: 700;">
                        <i class="fa fa-envelope" style="color: #0284c7;"></i> Email
                    </a>
                    <a href="#" id="modalProfileRosterBtn" class="btn btn-primary" style="background: #0f172a; border-color: #0f172a; border-radius: 9px; font-weight: 700;">
                        <i class="fa fa-calendar"></i> Attendance Roster
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Quick Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 18px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px; margin: 0;">
                    <i class="fa fa-pencil" style="color: #00a896; margin-right: 6px;"></i> Edit Staff Profile: <span id="editModalStaffTitle" style="color: #2dd4bf;"></span>
                </h4>
            </div>

            <form id="editEmployeeForm" action="<?=base_url('hr/update_employee');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="staff_id" id="editStaffId" value="">
                
                <div class="modal-body" style="padding: 24px;">
                    <div style="display: grid; gap: 14px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Full Name *</label>
                            <input type="text" name="name" id="editStaffName" class="form-control" required style="border-radius: 8px; height: 38px;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Email *</label>
                                <input type="email" name="email" id="editStaffEmail" class="form-control" required style="border-radius: 8px; height: 38px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Phone *</label>
                                <input type="tel" name="phone" id="editStaffPhone" class="form-control" required style="border-radius: 8px; height: 38px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Role Assignment</label>
                                <select name="role" id="editStaffRole" class="form-control" style="border-radius: 8px; height: 38px;">
                                    <option value="collector">Phlebotomist (Collector)</option>
                                    <option value="bde">Business Development (BDE)</option>
                                    <option value="office_staff">Operations &amp; Lab Desk</option>
                                    <option value="hr">HR Specialist</option>
                                    <option value="super_admin">Super Admin</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Account Status</label>
                                <select name="status" id="editStaffStatus" class="form-control" style="border-radius: 8px; height: 38px;">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Department</label>
                                <input type="text" name="department" id="editStaffDept" class="form-control" style="border-radius: 8px; height: 38px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Designation Title</label>
                                <input type="text" name="designation" id="editStaffDesig" class="form-control" style="border-radius: 8px; height: 38px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Monthly Base CTC (₹)</label>
                                <input type="number" name="base_salary" id="editStaffSalary" class="form-control" style="border-radius: 8px; height: 38px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155;">Assigned Territory</label>
                                <input type="text" name="assigned_area" id="editStaffArea" class="form-control" style="border-radius: 8px; height: 38px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 8px; font-weight: 700;">
                        <i class="fa fa-check"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Add New Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 18px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 24px; border: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 24px;">&times;</button>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 168, 150, 0.25); color: #2dd4bf; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" style="font-weight: 800; font-size: 16.5px; margin: 0; color: #ffffff;">Onboard New Enterprise Employee</h4>
                        <small style="color: #94a3b8; font-size: 12px;">Register staff credentials, role assignment, and compensation</small>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('hr/save_employee'); ?>" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body" style="padding: 24px; background: #ffffff;">
                    <div style="display: grid; gap: 14px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                Full Employee Name <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Rahul Sharma" required style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Email Address <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" placeholder="r.sharma@upchar.info" required style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Mobile Phone <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile" required style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Staff Role <span style="color: #ef4444;">*</span>
                                </label>
                                <select name="role" class="form-control" required style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600;">
                                    <option value="collector">Sample Collector (Phlebotomist)</option>
                                    <option value="bde">Business Development (BDE)</option>
                                    <option value="office_staff">Operations &amp; Lab Staff</option>
                                    <option value="hr">HR Specialist / Manager</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Monthly Base CTC (₹) <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="number" name="base_salary" class="form-control" value="25000" step="500" required style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Department
                                </label>
                                <input type="text" name="department" class="form-control" placeholder="e.g. Diagnostic Logistics" value="Diagnostic Logistics" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Designation Title
                                </label>
                                <input type="text" name="designation" class="form-control" placeholder="e.g. Senior Phlebotomist" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Assigned Area / Territory
                                </label>
                                <input type="text" name="assigned_area" class="form-control" placeholder="e.g. Gomti Nagar, Lucknow" value="Lucknow Central" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                                    Initial Password
                                </label>
                                <input type="password" name="password" class="form-control" value="admin@123" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 9px 18px; font-size: 13px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 9px 24px; font-size: 13px; border: none; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);">
                        <i class="fa fa-check"></i> Complete Onboarding
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function showToast(msg) {
        $('#staffDirectoryToastMsg').text(msg);
        $('#staffDirectoryToast').fadeIn(200).delay(2500).fadeOut(200);
    }

    // Grid vs Table View Mode Switcher
    $('#btnViewGrid').click(function() {
        $('#btnViewTable').removeClass('active');
        $(this).addClass('active');
        $('#staffTableView').hide();
        $('#staffGridView').fadeIn(150);
    });

    $('#btnViewTable').click(function() {
        $('#btnViewGrid').removeClass('active');
        $(this).addClass('active');
        $('#staffGridView').hide();
        $('#staffTableView').fadeIn(150);
    });

    // Real-Time Live Filter & Search
    function applyStaffFilter() {
        var query = $('#directorySearchInput').val().toLowerCase().trim();
        var statusFilter = $('#staffStatusFilter').val();

        $('.staff-item').each(function() {
            var name = $(this).data('name') || '';
            var code = $(this).data('code') || '';
            var phone = $(this).data('phone') || '';
            var area = $(this).data('area') || '';
            var dept = $(this).data('dept') || '';
            var status = $(this).data('status') || '';

            var matchesSearch = (query === '' || 
                name.indexOf(query) !== -1 || 
                code.indexOf(query) !== -1 || 
                phone.indexOf(query) !== -1 || 
                area.indexOf(query) !== -1 || 
                dept.indexOf(query) !== -1);

            var matchesStatus = (statusFilter === 'all' || status === statusFilter);

            if (matchesSearch && matchesStatus) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#directorySearchInput').on('keyup input', applyStaffFilter);
    $('#staffStatusFilter').on('change', applyStaffFilter);

    // Open Staff Profile Modal
    $(document).on('click', '.btn-view-profile', function() {
        var name = $(this).data('name');
        var code = $(this).data('code');
        var desig = $(this).data('desig');
        var dept = $(this).data('dept');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var area = $(this).data('area');
        var salary = $(this).data('salary');
        var status = $(this).data('status');

        var initial = name.charAt(0).toUpperCase();
        $('#modalProfileAvatar').text(initial);
        $('#modalProfileName').text(name);
        $('#modalProfileCode').text(code);
        $('#modalProfileDesig').text(desig || 'Staff Specialist');
        $('#modalProfileDept').text(dept || 'Operations');
        $('#modalProfilePhone').text(phone);
        $('#modalProfileEmail').text(email);
        $('#modalProfileArea').text(area || 'Lucknow Central');
        $('#modalProfileSalary').text('₹' + salary);
        
        if (status === 'active') {
            $('#modalProfileStatus').text('Active').css('background', '#10b981');
        } else {
            $('#modalProfileStatus').text('Inactive').css('background', '#ef4444');
        }

        $('#modalProfileCallBtn').attr('href', 'tel:' + phone);
        $('#modalProfileEmailBtn').attr('href', 'mailto:' + email);
        $('#modalProfileRosterBtn').attr('href', '<?=base_url("attendance/roster?search=");?>' + encodeURIComponent(name));

        $('#staffProfileModal').modal('show');
    });

    // Open Edit Employee Modal
    $(document).on('click', '.btn-edit-employee', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var role = $(this).data('role');
        var desig = $(this).data('desig');
        var dept = $(this).data('dept');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var area = $(this).data('area');
        var salary = $(this).data('salary');
        var status = $(this).data('status');

        $('#editStaffId').val(id);
        $('#editStaffName').val(name);
        $('#editModalStaffTitle').text(name);
        $('#editStaffRole').val(role);
        $('#editStaffDesig').val(desig);
        $('#editStaffDept').val(dept);
        $('#editStaffEmail').val(email);
        $('#editStaffPhone').val(phone);
        $('#editStaffArea').val(area);
        $('#editStaffSalary').val(salary);
        $('#editStaffStatus').val(status);

        $('#editEmployeeModal').modal('show');
    });

    // Submit Edit Employee Form via AJAX
    $('#editEmployeeForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("hr/update_employee");?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#editEmployeeModal').modal('hide');
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 600);
                } else {
                    alert(res.message || 'Error updating employee.');
                }
            },
            error: function() {
                alert('Connection error. Please try again.');
            }
        });
    });

    // AJAX Toggle Staff Status
    $(document).on('click', '.btn-toggle-status', function() {
        var staffId = $(this).data('id');
        var $btn = $(this);
        var csrfName = '<?=$this->security->get_csrf_token_name();?>';
        var csrfHash = '<?=$this->security->get_csrf_hash();?>';

        var postData = { staff_id: staffId };
        postData[csrfName] = csrfHash;

        $btn.prop('disabled', true);
        $.ajax({
            url: '<?=base_url("hr/toggle_staff_status");?>',
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false);
                if (res.status === 'success') {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else {
                    alert(res.message || 'Error changing status.');
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                alert('Connection error. Please try again.');
            }
        });
    });
});
</script>
