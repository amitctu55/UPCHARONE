<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="hr-jobs-container" style="max-width: 1400px; margin: 0 auto;">

    <!-- Flash Notifications -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; box-shadow: 0 4px 12px rgba(16,185,129,0.1);">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> <?=html_escape($this->session->flashdata('success_msg'));?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-circle"></i> <?=html_escape($this->session->flashdata('error_msg'));?>
        </div>
    <?php endif; ?>

    <!-- Action Toolbar Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.3px;">
                Job Openings &amp; Requisitions Desk
            </h2>
            <p style="margin: 0; font-size: 13.5px; color: #64748b;">
                Manage clinical &amp; operational vacancies, set target salary ranges, and track applicant funnels.
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-primary" onclick="openCreateJobModal()" style="background: #00a896; color: #ffffff; border: none; border-radius: 10px; padding: 10px 22px; font-size: 13.5px; font-weight: 700; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35); display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-plus-circle" style="font-size: 16px;"></i> Create Job Requisition
            </button>
        </div>
    </div>

    <!-- Summary KPI Metrics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Active Requisitions</span>
                <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=intval($active_count ?? 0);?></div>
                <small style="color: #00a896; font-weight: 600; font-size: 11.5px;">Open for recruitment</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-briefcase"></i>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Total Open Seats</span>
                <div style="font-size: 28px; font-weight: 800; color: #3b82f6; margin-top: 4px;"><?=intval($total_openings ?? 0);?></div>
                <small style="color: #64748b; font-weight: 600; font-size: 11.5px;">Required headcount</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-users"></i>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Total Applicants</span>
                <div style="font-size: 28px; font-weight: 800; color: #8b5cf6; margin-top: 4px;"><?=intval($total_applicants ?? 0);?></div>
                <small style="color: #8b5cf6; font-weight: 600; font-size: 11.5px;">Across all pipelines</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #f5f3ff; color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-user-plus"></i>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Avg Time to Fill</span>
                <div style="font-size: 28px; font-weight: 800; color: #10b981; margin-top: 4px;">14 Days</div>
                <small style="color: #10b981; font-weight: 600; font-size: 11.5px;">Health target: &lt;21d</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-bolt"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div style="background: #ffffff; border-radius: 16px; padding: 16px 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 12px; flex-grow: 1; max-width: 600px;">
            <div style="position: relative; width: 100%;">
                <i class="fa fa-search" style="position: absolute; left: 14px; top: 12px; color: #94a3b8; font-size: 14px;"></i>
                <input type="text" id="jobSearchInput" onkeyup="filterJobsTable()" placeholder="Search requisition title, department, location..." style="width: 100%; padding: 8px 14px 8px 38px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; background: #f8fafc; outline: none; transition: all 0.2s;">
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <span style="font-size: 12.5px; font-weight: 700; color: #64748b;">Department:</span>
            <select id="deptFilter" onchange="filterJobsTable()" style="padding: 7px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; background: #fff; font-weight: 600; color: #334155;">
                <option value="">All Departments</option>
                <option value="Diagnostics & Lab">Diagnostics &amp; Lab</option>
                <option value="Nursing Care">Nursing Care</option>
                <option value="Clinical Services">Clinical Services</option>
                <option value="Pharmacy">Pharmacy</option>
                <option value="Operations & Admin">Operations &amp; Admin</option>
                <option value="Emergency & Fleet">Emergency &amp; Fleet</option>
            </select>

            <span style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-left: 8px;">Status:</span>
            <select id="statusFilter" onchange="filterJobsTable()" style="padding: 7px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; background: #fff; font-weight: 600; color: #334155;">
                <option value="">All Statuses</option>
                <option value="active">Active Openings</option>
                <option value="closed">Closed / Inactive</option>
            </select>
        </div>
    </div>

    <!-- Job Requisitions Table Card -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                    Job Requisitions Registry
                </h3>
                <span id="jobsCountBadge" style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 9999px; font-size: 12px; font-weight: 700;">
                    <?=count($jobs ?? []);?> Openings
                </span>
            </div>
            <div style="font-size: 12.5px; color: #64748b;">
                💡 <em>Click any requisition title to view and filter candidate applications.</em>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="jobsTable" style="margin-bottom: 0;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Requisition Title &amp; Dept</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Location &amp; Type</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Headcount (Seats)</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Target CTC / Salary</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">Pipeline Funnel</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">Status</th>
                        <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jobs)): foreach ($jobs as $job): 
                        $isActive = ($job['status'] === 'active' || $job['status'] === '1');
                        $deptColor = '#0284c7';
                        if (stripos($job['department'], 'lab') !== false) $deptColor = '#00a896';
                        elseif (stripos($job['department'], 'nurs') !== false) $deptColor = '#ec4899';
                        elseif (stripos($job['department'], 'pharma') !== false) $deptColor = '#f59e0b';
                        elseif (stripos($job['department'], 'admin') !== false) $deptColor = '#6366f1';
                    ?>
                        <tr class="job-row" data-title="<?=strtolower(html_escape($job['title']));?>" data-dept="<?=strtolower(html_escape($job['department']));?>" data-status="<?=$job['status'];?>" style="vertical-align: middle;">
                            <!-- Job Title & Dept -->
                            <td style="padding: 16px 20px;">
                                <a href="<?=base_url('admin1947/hr/candidates?job_id=' . $job['job_id']);?>" style="font-weight: 700; font-size: 14px; color: #0f172a; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                    <?=html_escape($job['title']);?>
                                    <i class="fa fa-external-link" style="font-size: 11px; color: #94a3b8;"></i>
                                </a>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                                    <span style="font-size: 11px; font-weight: 700; color: <?=$deptColor;?>; background: <?=$deptColor;?>15; padding: 2px 8px; border-radius: 6px;">
                                        <?=html_escape($job['department']);?>
                                    </span>
                                    <span style="font-size: 12px; color: #64748b;">
                                        <i class="fa fa-clock-o"></i> Req. Exp: <?=html_escape($job['experience_required']);?>
                                    </span>
                                </div>
                            </td>

                            <!-- Location & Type -->
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; font-size: 13px; color: #334155;">
                                    <i class="fa fa-map-marker" style="color: #ef4444; margin-right: 4px;"></i> <?=html_escape($job['location']);?>
                                </div>
                                <span style="font-size: 11.5px; color: #64748b;"><?=html_escape($job['job_type']);?></span>
                            </td>

                            <!-- Headcount / Seats -->
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <strong style="font-size: 15px; color: #0f172a;"><?=$job['openings'];?></strong>
                                    <span style="font-size: 12px; color: #64748b;">Seats</span>
                                </div>
                                <div style="font-size: 11px; color: <?=intval($job['count_hired']) >= intval($job['openings']) ? '#10b981' : '#f59e0b';?>; font-weight: 600;">
                                    <?=intval($job['count_hired']);?> Hired / <?=intval($job['openings']);?> Needed
                                </div>
                            </td>

                            <!-- Target CTC / Salary -->
                            <td style="padding: 16px;">
                                <div style="font-weight: 700; font-size: 13px; color: #047857; background: #ecfdf5; padding: 4px 10px; border-radius: 8px; display: inline-block;">
                                    <?=html_escape($job['salary_range']);?>
                                </div>
                            </td>

                            <!-- Pipeline Funnel Breakdown -->
                            <td style="padding: 16px; text-align: center;">
                                <a href="<?=base_url('admin1947/hr/candidates?job_id=' . $job['job_id']);?>" title="Click to view candidates" style="text-decoration: none;">
                                    <div style="display: inline-flex; align-items: center; gap: 4px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 9999px; padding: 4px 10px;">
                                        <span title="Applied" style="font-size: 11px; font-weight: 700; color: #3b82f6;"><?=intval($job['count_applied']);?> App</span>
                                        <span style="color: #cbd5e1;">•</span>
                                        <span title="Screened" style="font-size: 11px; font-weight: 700; color: #8b5cf6;"><?=intval($job['count_screened']);?> Scr</span>
                                        <span style="color: #cbd5e1;">•</span>
                                        <span title="Interviewing" style="font-size: 11px; font-weight: 700; color: #f59e0b;"><?=intval($job['count_interviewing']);?> Int</span>
                                        <span style="color: #cbd5e1;">•</span>
                                        <span title="Offered" style="font-size: 11px; font-weight: 700; color: #10b981;"><?=intval($job['count_offered']);?> Off</span>
                                    </div>
                                    <div style="font-size: 11.5px; font-weight: 700; color: #00a896; margin-top: 4px;">
                                        <?=intval($job['total_applicants']);?> Total Applicants →
                                    </div>
                                </a>
                            </td>

                            <!-- Status -->
                            <td style="padding: 16px; text-align: center;" id="job-status-cell-<?=$job['job_id'];?>">
                                <?php if ($isActive): ?>
                                    <span class="job-status-badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span> Active
                                    </span>
                                <?php else: ?>
                                    <span class="job-status-badge" style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 700;">
                                        Closed
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Action Buttons -->
                            <td style="padding: 16px 20px; text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <a href="<?=base_url('admin1947/hr/candidates?job_id=' . $job['job_id']);?>" class="btn btn-sm" style="background: #f0fdfa; color: #00a896; border: 1px solid #ccfbf1; border-radius: 8px; font-size: 12px; font-weight: 700;" title="View Applicants">
                                        <i class="fa fa-users"></i> Applicants
                                    </a>

                                    <button type="button" class="btn btn-sm" onclick="editJob(<?=htmlspecialchars(json_encode($job), ENT_QUOTES, 'UTF-8');?>)" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; border-radius: 8px; font-size: 12px; font-weight: 700;" title="Edit Requisition">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-toggle-job" data-id="<?=$job['job_id'];?>" style="background: #f8fafc; color: <?=$isActive ? '#10b981' : '#64748b';?>; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; transition: all 0.2s;" title="Toggle Open / Close Requisition">
                                        <i class="fa fa-power-off"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8;">
                                <i class="fa fa-briefcase" style="font-size: 36px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                                No job requisitions found. Click "Create Job Requisition" to add one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Create / Edit Job Requisition Form -->
<!-- ========================================== -->
<div class="modal fade" id="postJobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalTitle">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 860px;">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); overflow: hidden;">
            <form action="<?=base_url('admin1947/hr/save_job');?>" method="POST" id="jobForm" onsubmit="handleJobFormSubmit(event)">
                <input type="hidden" name="job_id" id="modal_job_id" value="">
                
                <!-- Modal Header -->
                <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 22px 28px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #2dd4bf; font-weight: 800; margin-bottom: 2px;">
                            UPCHAR HR WORKFORCE PLANNING
                        </div>
                        <h4 class="modal-title" id="jobModalTitle" style="font-weight: 800; font-size: 18px; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-plus-circle" style="color: #2dd4bf;"></i> Create Job Requisition
                        </h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.7; font-size: 24px; text-shadow: none;">&times;</button>
                </div>
                
                <div class="modal-body" style="padding: 26px 28px; background: #ffffff;">

                    <!-- Quick Role Template Autofill Selector -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-bottom: 22px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 8px;">
                            <span style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fa fa-magic" style="color: #6366f1; margin-right: 4px;"></i> Quick Autofill From Standard Hospital Roles:
                            </span>
                            <small style="color: #64748b; font-size: 11px;">Click a preset to populate title, salary, &amp; requirements</small>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                            <button type="button" class="btn btn-xs" onclick="applyJobTemplate('pathology')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; color: #00a896; padding: 4px 10px;">
                                🧪 Pathology Tech
                            </button>
                            <button type="button" class="btn btn-xs" onclick="applyJobTemplate('nurse')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; color: #ec4899; padding: 4px 10px;">
                                🩺 ICU Staff Nurse
                            </button>
                            <button type="button" class="btn btn-xs" onclick="applyJobTemplate('doctor')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; color: #3b82f6; padding: 4px 10px;">
                                👨‍⚕️ Duty Medical Officer
                            </button>
                            <button type="button" class="btn btn-xs" onclick="applyJobTemplate('pharma')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; color: #f59e0b; padding: 4px 10px;">
                                💊 Pharmacist Incharge
                            </button>
                            <button type="button" class="btn btn-xs" onclick="applyJobTemplate('receptionist')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; color: #6366f1; padding: 4px 10px;">
                                🏢 Front Desk Executive
                            </button>
                        </div>
                    </div>

                    <!-- Row 1: Title & Department -->
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                                    Requisition Title <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="text" name="title" id="modal_title" class="form-control" placeholder="e.g. Senior Pathology & Lab Technician" required style="border-radius: 10px; height: 44px; font-weight: 600; font-size: 14px; border: 1px solid #cbd5e1;">
                                <small style="color: #64748b; font-size: 11px;">Standard clinical or administrative position title</small>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                                    Department <span style="color: #ef4444;">*</span>
                                </label>
                                <select name="department" id="modal_department" class="form-control" required style="border-radius: 10px; height: 44px; font-weight: 600; font-size: 13.5px; border: 1px solid #cbd5e1;">
                                    <option value="Diagnostics & Lab">Diagnostics &amp; Lab</option>
                                    <option value="Nursing Care">Nursing Care</option>
                                    <option value="Clinical Services">Clinical Services</option>
                                    <option value="Pharmacy">Pharmacy</option>
                                    <option value="Operations & Admin">Operations &amp; Admin</option>
                                    <option value="Emergency & Fleet">Emergency &amp; Fleet</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="Finance & Billing">Finance &amp; Billing</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Job Type, Location & Experience -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Job Type</label>
                                <select name="job_type" id="modal_job_type" class="form-control" style="border-radius: 10px; height: 44px; font-size: 13px; border: 1px solid #cbd5e1;">
                                    <option value="Full Time">Full Time</option>
                                    <option value="Full Time (Rotational)">Full Time (Rotational)</option>
                                    <option value="Part Time / Consultant">Part Time / Consultant</option>
                                    <option value="Night Shift Specialist">Night Shift Specialist</option>
                                    <option value="Contract / Temporary">Contract / Temporary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Location / Facility</label>
                                <input type="text" name="location" id="modal_location" class="form-control" value="Gorakhpur, UP" placeholder="e.g. Gorakhpur, UP" style="border-radius: 10px; height: 44px; font-size: 13px; border: 1px solid #cbd5e1;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Experience Required</label>
                                <input type="text" name="experience_required" id="modal_experience_required" class="form-control" placeholder="e.g. 2-5 Years" style="border-radius: 10px; height: 44px; font-size: 13px; border: 1px solid #cbd5e1;">
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Open Seats, Salary & Status -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                                    Open Headcount (Seats) <span style="color: #ef4444;">*</span>
                                </label>
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <button type="button" class="btn btn-default" onclick="adjustSeats(-1)" style="border-radius: 8px; font-weight: 800; padding: 9px 14px;">-</button>
                                    <input type="number" name="openings" id="modal_openings" class="form-control text-center" value="1" min="1" max="50" required style="border-radius: 8px; height: 44px; font-weight: 800; font-size: 15px; border: 1px solid #cbd5e1;">
                                    <button type="button" class="btn btn-default" onclick="adjustSeats(1)" style="border-radius: 8px; font-weight: 800; padding: 9px 14px;">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                                    Target Salary Range (₹)
                                </label>
                                <input type="text" name="salary_range" id="modal_salary_range" class="form-control" placeholder="e.g. ₹25,000 - ₹35,000 / month" style="border-radius: 10px; height: 44px; font-weight: 700; color: #047857; font-size: 13.5px; border: 1px solid #cbd5e1;">
                                <div style="display: flex; gap: 4px; margin-top: 4px;">
                                    <a href="javascript:void(0)" onclick="setSalaryPreset('₹18,000 - ₹25,000 / month')" style="font-size: 10.5px; color: #0284c7; background: #e0f2fe; padding: 1px 6px; border-radius: 4px; text-decoration: none;">₹18k-₹25k</a>
                                    <a href="javascript:void(0)" onclick="setSalaryPreset('₹25,000 - ₹38,000 / month')" style="font-size: 10.5px; color: #0284c7; background: #e0f2fe; padding: 1px 6px; border-radius: 4px; text-decoration: none;">₹25k-₹38k</a>
                                    <a href="javascript:void(0)" onclick="setSalaryPreset('₹50,000 - ₹80,000 / month')" style="font-size: 10.5px; color: #0284c7; background: #e0f2fe; padding: 1px 6px; border-radius: 4px; text-decoration: none;">₹50k-₹80k</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Requisition Status</label>
                                <select name="status" id="modal_status" class="form-control" style="border-radius: 10px; height: 44px; font-weight: 700; font-size: 13px; border: 1px solid #cbd5e1;">
                                    <option value="active">Active (Open)</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Description -->
                    <div class="form-group" style="margin-top: 6px;">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                            Job Description &amp; Scope of Responsibilities
                        </label>
                        <textarea name="description" id="modal_description" class="form-control" rows="3" placeholder="Outline clinical duties, shift hours, equipment handling, patient care protocol..." style="border-radius: 10px; font-size: 13px; line-height: 1.5; border: 1px solid #cbd5e1;"></textarea>
                    </div>

                    <!-- Row 5: Qualifications & Statutory Requirements -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                            Key Qualifications &amp; Statutory Licenses
                        </label>
                        <textarea name="requirements" id="modal_requirements" class="form-control" rows="2" placeholder="e.g. Valid UP Medical / Nursing Council Registration, DMLT / B.Sc, ACLS/BLS..." style="border-radius: 10px; font-size: 13px; line-height: 1.5; border: 1px solid #cbd5e1;"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px 28px; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 10px 20px;">
                        Cancel
                    </button>
                    <button type="submit" id="btnSaveJobSubmit" class="btn btn-primary" style="background: linear-gradient(135deg, #00a896 0%, #059669 100%); border: none; border-radius: 10px; padding: 10px 28px; font-weight: 800; font-size: 14px; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.4);">
                        <i class="fa fa-save" style="margin-right: 6px;"></i> Save Requisition
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var jobTemplates = {
    pathology: {
        title: "Senior Pathology & Lab Technician",
        department: "Diagnostics & Lab",
        job_type: "Full Time",
        location: "Gorakhpur, UP",
        experience_required: "2-5 Years",
        openings: 3,
        salary_range: "₹25,000 - ₹35,000 / month",
        description: "Lead diagnostic biochemistry and hematology sample processing, automated analyzer calibration, and quality control adherence.",
        requirements: "DMLT / B.Sc MLT with valid license, min 2 years experience with automated hematology and biochemistry analyzers."
    },
    nurse: {
        title: "Emergency & ICU Staff Nurse (GNM / B.Sc)",
        department: "Nursing Care",
        job_type: "Full Time (Rotational)",
        location: "Gorakhpur, UP",
        experience_required: "1-4 Years",
        openings: 5,
        salary_range: "₹22,000 - ₹32,000 / month",
        description: "Provide critical care, medication administration, vitals tracking, and rapid response ICU monitoring for in-patient care.",
        requirements: "GNM / B.Sc Nursing, UP Nursing Council registration required, BLS/ACLS certification preferred."
    },
    doctor: {
        title: "Duty Medical Officer (MBBS / BAMS)",
        department: "Clinical Services",
        job_type: "Full Time",
        location: "Gorakhpur, UP",
        experience_required: "1-3 Years",
        openings: 2,
        salary_range: "₹55,000 - ₹80,000 / month",
        description: "Handle OPD triage, emergency patient stabilization, in-patient ward rounds, and physician coordination.",
        requirements: "MBBS or BAMS with valid State Medical Council registration, emergency room experience preferred."
    },
    pharma: {
        title: "Senior Pharmacist & Inventory Supervisor",
        department: "Pharmacy",
        job_type: "Full Time",
        location: "Gorakhpur, UP",
        experience_required: "3-6 Years",
        openings: 1,
        salary_range: "₹28,000 - ₹38,000 / month",
        description: "Oversee hospital retail & IPD pharmacy operations, narcotic register audit, cold chain compliance, and batch management.",
        requirements: "B.Pharm with UP Pharmacy Council registration, inventory management ERP experience."
    },
    receptionist: {
        title: "Hospital Front Desk & Patient Relations Executive",
        department: "Operations & Admin",
        job_type: "Full Time",
        location: "Gorakhpur, UP",
        experience_required: "1-2 Years",
        openings: 2,
        salary_range: "₹18,000 - ₹26,000 / month",
        description: "Manage patient admissions, billing verification, insurance desk queries, and appointment scheduling.",
        requirements: "Graduate with strong Hindi & English communication, hospital HMS software proficiency."
    }
};

function openCreateJobModal() {
    document.getElementById('jobModalTitle').innerHTML = '<i class="fa fa-plus-circle" style="color: #2dd4bf; margin-right: 8px;"></i> Create Job Requisition';
    document.getElementById('jobForm').reset();
    document.getElementById('modal_job_id').value = '';
    document.getElementById('modal_location').value = 'Gorakhpur, UP';
    document.getElementById('modal_openings').value = '1';
    $('#postJobModal').modal('show');
}

function applyJobTemplate(key) {
    var tpl = jobTemplates[key];
    if (!tpl) return;
    document.getElementById('modal_title').value = tpl.title;
    document.getElementById('modal_department').value = tpl.department;
    document.getElementById('modal_job_type').value = tpl.job_type;
    document.getElementById('modal_location').value = tpl.location;
    document.getElementById('modal_experience_required').value = tpl.experience_required;
    document.getElementById('modal_openings').value = tpl.openings;
    document.getElementById('modal_salary_range').value = tpl.salary_range;
    document.getElementById('modal_description').value = tpl.description;
    document.getElementById('modal_requirements').value = tpl.requirements;
}

function setSalaryPreset(val) {
    document.getElementById('modal_salary_range').value = val;
}

function adjustSeats(delta) {
    var inp = document.getElementById('modal_openings');
    var val = parseInt(inp.value, 10) || 1;
    val = Math.max(1, Math.min(50, val + delta));
    inp.value = val;
}

function editJob(job) {
    document.getElementById('jobModalTitle').innerHTML = '<i class="fa fa-pencil" style="color: #38bdf8; margin-right: 8px;"></i> Edit Requisition: ' + job.title;
    document.getElementById('modal_job_id').value = job.job_id;
    document.getElementById('modal_title').value = job.title;
    document.getElementById('modal_department').value = job.department;
    document.getElementById('modal_job_type').value = job.job_type || 'Full Time';
    document.getElementById('modal_location').value = job.location || 'Gorakhpur, UP';
    document.getElementById('modal_experience_required').value = job.experience_required || '';
    document.getElementById('modal_openings').value = job.openings || 1;
    document.getElementById('modal_salary_range').value = job.salary_range || '';
    document.getElementById('modal_status').value = job.status || 'active';
    document.getElementById('modal_description').value = job.description || '';
    document.getElementById('modal_requirements').value = job.requirements || '';
    $('#postJobModal').modal('show');
}

function handleJobFormSubmit(e) {
    var title = document.getElementById('modal_title').value.trim();
    if (!title) {
        e.preventDefault();
        alert('Please enter a valid Requisition Title.');
        return false;
    }
    return true;
}

function filterJobsTable() {
    var query = document.getElementById('jobSearchInput').value.toLowerCase().trim();
    var dept = document.getElementById('deptFilter').value.toLowerCase().trim();
    var status = document.getElementById('statusFilter').value.toLowerCase().trim();
    var rows = document.querySelectorAll('.job-row');
    var visibleCount = 0;

    rows.forEach(function(row) {
        var title = row.getAttribute('data-title') || '';
        var rowDept = row.getAttribute('data-dept') || '';
        var rowStatus = row.getAttribute('data-status') || '';

        var matchQuery = !query || title.includes(query) || rowDept.includes(query);
        var matchDept = !dept || rowDept === dept;
        var matchStatus = !status || rowStatus === status;

        if (matchQuery && matchDept && matchStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('jobsCountBadge').innerText = visibleCount + ' Openings';
}

// Toast notification helper
function showJobToast(msg, isSuccess) {
    var $t = $('#jobLiveToast');
    var $icon = $('#jobLiveToastIcon');
    $('#jobLiveToastMsg').text(msg);
    if (isSuccess) {
        $t.css('border-color', '#10b981');
        $icon.removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle').css('color', '#10b981');
    } else {
        $t.css('border-color', '#ef4444');
        $icon.removeClass('fa-check-circle').addClass('fa-exclamation-circle').css('color', '#ef4444');
    }
    $t.fadeIn(200);
    setTimeout(function() {
        $t.fadeOut(300);
    }, 2800);
}

// AJAX Toggle Job Status
$(document).on('click', '.btn-toggle-job', function(e) {
    e.preventDefault();
    var $btn = $(this);
    var jid = $btn.data('id');
    var $icon = $btn.find('i');
    
    $icon.addClass('fa-spin');
    $btn.prop('disabled', true);

    $.ajax({
        url: '<?=base_url("admin1947/hr/toggle_job_status");?>',
        type: 'POST',
        data: {
            job_id: jid,
            is_ajax: 1
        },
        dataType: 'json',
        success: function(res) {
            $icon.removeClass('fa-spin');
            $btn.prop('disabled', false);
            if (res && res.status === 'success') {
                var $cell = $('#job-status-cell-' + jid);
                var $row = $btn.closest('.job-row');
                if (res.new_status === 'active') {
                    $btn.css('color', '#10b981');
                    $row.attr('data-status', 'active');
                    $cell.html('<span class="job-status-badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;"><span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span> Active</span>');
                } else {
                    $btn.css('color', '#64748b');
                    $row.attr('data-status', 'closed');
                    $cell.html('<span class="job-status-badge" style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 700;">Closed</span>');
                }
                showJobToast(res.message || 'Job requisition status updated', true);
            } else {
                showJobToast(res ? res.message : 'Error updating status', false);
            }
        },
        error: function() {
            $icon.removeClass('fa-spin');
            $btn.prop('disabled', false);
            showJobToast('Server connection error. Please try again.', false);
        }
    });
});
</script>

<!-- Floating Toast Notification -->
<div id="jobLiveToast" style="display: none; position: fixed; bottom: 24px; right: 24px; z-index: 99999; background: #0f172a; color: #ffffff; padding: 12px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; box-shadow: 0 10px 25px rgba(0,0,0,0.25); border-left: 4px solid #10b981; display: none; align-items: center; gap: 10px;">
    <i id="jobLiveToastIcon" class="fa fa-check-circle" style="color: #10b981; font-size: 16px;"></i>
    <span id="jobLiveToastMsg">Status updated</span>
</div>
