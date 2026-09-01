<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Employee Directory &amp; Staff Profiles
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Manage staff roles, field phlebotomists, BDE executives, and compensation packages.
        </p>
    </div>
    <button type="button" class="btn" data-toggle="modal" data-target="#addEmployeeModal" style="background: var(--hr-teal); color: #fff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
        <i class="fa fa-user-plus"></i> Add New Employee
    </button>
</div>

<!-- Filters -->
<div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 14px 18px; margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="<?=base_url('hr/employees');?>" class="btn btn-sm <?=empty($selected_role) ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
            All Staff (<?=count($employees);?>)
        </a>
        <a href="<?=base_url('hr/employees?role=collector');?>" class="btn btn-sm <?=$selected_role==='collector' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
            Phlebotomists
        </a>
        <a href="<?=base_url('hr/employees?role=bde');?>" class="btn btn-sm <?=$selected_role==='bde' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
            BDEs
        </a>
        <a href="<?=base_url('hr/employees?role=hr');?>" class="btn btn-sm <?=$selected_role==='hr' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
            HR Team
        </a>
        <a href="<?=base_url('hr/employees?role=office_staff');?>" class="btn btn-sm <?=$selected_role==='office_staff' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
            Operations Staff
        </a>
    </div>
</div>

<!-- Employee Directory Table -->
<div class="hr-kpi-card" style="padding: 20px;">
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Code &amp; Name</th>
                    <th>Role &amp; Department</th>
                    <th>Contact Info</th>
                    <th>Base Salary</th>
                    <th>Assigned Area</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)): ?>
                    <?php foreach ($employees as $e): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 14px;"><?=html_escape($e['name']);?></div>
                            <small style="color: #64748b; font-family: monospace; font-weight: 600;"><?=$e['staff_code'];?></small>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #1e293b;"><?=html_escape($e['designation'] ?: $e['role']);?></div>
                            <small style="color: #64748b;"><?=html_escape($e['department']);?></small>
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #334155;"><i class="fa fa-phone" style="color: #10b981;"></i> <?=html_escape($e['phone']);?></div>
                            <small style="color: #64748b;"><i class="fa fa-envelope-o"></i> <?=html_escape($e['email']);?></small>
                        </td>
                        <td>
                            <strong style="color: #15803d; font-size: 14px;">₹<?=number_format($e['base_salary'], 2);?></strong>
                            <small style="display: block; color: #64748b; font-size: 11px;">/ month</small>
                        </td>
                        <td style="font-size: 13px; color: #334155;">
                            <i class="fa fa-map-marker" style="color: #ef4444;"></i> <?=html_escape($e['assigned_area']);?>
                        </td>
                        <td>
                            <span class="label label-<?=$e['status']==='active' ? 'success' : 'danger';?>" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=$e['status'];?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No staff members found matching this filter.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Employee -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; padding: 10px;">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; color: #0f172a;">Onboard New Employee</h4>
            </div>
            <form action="<?=base_url('hr/save_employee');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="display: grid; gap: 14px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Full Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Ramesh Kumar" required style="border-radius: 8px;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Email Address *</label>
                            <input type="email" name="email" class="form-control" placeholder="email@upcharr.com" required style="border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Mobile Phone *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile" required style="border-radius: 8px;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Role *</label>
                            <select name="role" class="form-control" style="border-radius: 8px;">
                                <option value="collector">Sample Collector (Phlebotomist)</option>
                                <option value="bde">Business Development Executive (BDE)</option>
                                <option value="hr">HR Manager</option>
                                <option value="office_staff">Operations Staff</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Base Salary (₹/Mo) *</label>
                            <input type="number" name="base_salary" class="form-control" value="25000" required style="border-radius: 8px;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Department</label>
                            <input type="text" name="department" class="form-control" placeholder="e.g. Diagnostic Logistics" style="border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Assigned Area</label>
                            <input type="text" name="assigned_area" class="form-control" placeholder="e.g. Gomti Nagar, Lucknow" style="border-radius: 8px;">
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Initial Password</label>
                        <input type="password" name="password" class="form-control" value="admin@123" style="border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn" style="background: var(--hr-teal); color: #fff; font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-check"></i> Save &amp; Onboard
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
