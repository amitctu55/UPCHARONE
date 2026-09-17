<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$stage = strtolower($candidate['status_stage'] ?? 'applied');
$stageColor = '#2563eb';
$stageBg = '#eff6ff';
if ($stage === 'screened') { $stageColor = '#7c3aed'; $stageBg = '#f5f3ff'; }
elseif ($stage === 'interviewing') { $stageColor = '#d97706'; $stageBg = '#fffbeb'; }
elseif ($stage === 'offered') { $stageColor = '#059669'; $stageBg = '#ecfdf5'; }
elseif ($stage === 'hired') { $stageColor = '#00a896'; $stageBg = '#f0fdfa'; }
elseif ($stage === 'rejected') { $stageColor = '#dc2626'; $stageBg = '#fef2f2'; }

$initial = strtoupper(substr($candidate['name'] ?? 'C', 0, 1));
$roleTitle = $candidate['job_title'] ?: ($candidate['designation'] ?: 'Applicant');
?>

<div class="hr-dossier-container" style="max-width: 1300px; margin: 0 auto;">

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

    <!-- Breadcrumb & Navigation Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600;">
            <a href="<?=base_url('admin1947/hr/candidates');?>" style="color: #64748b; text-decoration: none;">
                <i class="fa fa-arrow-left" style="margin-right: 4px;"></i> Candidates Pipeline
            </a>
            <span style="color: #cbd5e1;">/</span>
            <a href="<?=base_url('admin1947/hr/candidates/' . $stage);?>" style="color: <?=$stageColor;?>; text-decoration: none; text-transform: capitalize;">
                <?=ucfirst($stage);?>
            </a>
            <span style="color: #cbd5e1;">/</span>
            <span style="color: #0f172a; font-weight: 700;"><?=html_escape($candidate['name']);?></span>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="<?=base_url('admin1947/hr/candidates');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; font-size: 12.5px;">
                <i class="fa fa-list"></i> Pipeline Tabs
            </a>
            <a href="<?=base_url('admin1947/hr/recruitment');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; font-size: 12.5px;">
                <i class="fa fa-columns"></i> Kanban Board
            </a>
        </div>
    </div>

    <!-- Main Dossier Layout Grid -->
    <div class="row">
        <!-- ========================================== -->
        <!-- LEFT COLUMN: Candidate Overview & Actions -->
        <!-- ========================================== -->
        <div class="col-md-4">
            <!-- Identity Profile Card -->
            <div style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 26px; box-shadow: 0 4px 14px rgba(0,0,0,0.03); margin-bottom: 20px; text-align: center;">
                <div style="width: 76px; height: 76px; border-radius: 20px; background: linear-gradient(135deg, <?=$stageColor;?>, #0f172a); color: #ffffff; font-weight: 800; font-size: 32px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px <?=$stageColor;?>40;">
                    <?=$initial;?>
                </div>

                <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">
                    <?=html_escape($candidate['name']);?>
                </h2>

                <div style="display: inline-block; background: <?=$stageBg;?>; color: <?=$stageColor;?>; border: 1px solid <?=$stageColor;?>30; padding: 5px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 18px;">
                    Stage: <?=ucfirst($stage);?>
                </div>

                <!-- Contact Details List -->
                <div style="text-align: left; background: #f8fafc; border-radius: 12px; padding: 16px; border: 1px solid #f1f5f9; margin-bottom: 20px;">
                    <div style="margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 600;">Phone Number:</span>
                        <strong style="font-size: 13px; color: #1e293b;"><?=html_escape($candidate['mobile']);?></strong>
                    </div>
                    <?php if (!empty($candidate['email'])): ?>
                        <div style="margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 12px; color: #64748b; font-weight: 600;">Email:</span>
                            <span style="font-size: 12.5px; color: #2563eb; font-weight: 600;"><?=html_escape($candidate['email']);?></span>
                        </div>
                    <?php endif; ?>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 600;">Application Date:</span>
                        <span style="font-size: 12px; color: #334155; font-weight: 600;"><?=date('d M Y', strtotime($candidate['applied_at'] ?? ($candidate['creat_date'] ?? 'now')));?></span>
                    </div>
                </div>

                <!-- Communication Quick Actions -->
                <div style="display: flex; gap: 8px;">
                    <a href="tel:<?=html_escape($candidate['mobile']);?>" class="btn" style="flex: 1; background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd; border-radius: 10px; font-size: 12.5px; font-weight: 700; padding: 9px;">
                        <i class="fa fa-phone"></i> Call
                    </a>
                    <a href="https://wa.me/91<?=preg_replace('/[^0-9]/', '', $candidate['mobile']);?>?text=Hello%20<?=urlencode($candidate['name']);?>,%20this%20is%20Upchar%20HR%20team%20regarding%20your%20application." target="_blank" class="btn" style="flex: 1; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; border-radius: 10px; font-size: 12.5px; font-weight: 700; padding: 9px;">
                        <i class="fa fa-whatsapp"></i> WhatsApp
                    </a>
                    <?php if (!empty($candidate['email'])): ?>
                        <a href="mailto:<?=html_escape($candidate['email']);?>" class="btn" style="flex: 1; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 10px; font-size: 12.5px; font-weight: 700; padding: 9px;">
                            <i class="fa fa-envelope-o"></i> Email
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Assigned Requisition Card -->
            <div style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 14px rgba(0,0,0,0.03); margin-bottom: 20px;">
                <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0 0 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa fa-id-badge" style="color: #6366f1; margin-right: 6px;"></i> Assigned Requisition
                </h4>

                <div style="font-weight: 700; font-size: 15px; color: #0f172a; line-height: 1.3;">
                    <?=html_escape($roleTitle);?>
                </div>

                <div style="margin-top: 8px;">
                    <span style="font-size: 12px; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 6px;">
                        <?=html_escape($candidate['job_department'] ?: 'Clinical Services');?>
                    </span>
                </div>

                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 12.5px; color: #64748b;">
                    <div><i class="fa fa-map-marker" style="color: #ef4444; width: 18px;"></i> <?=html_escape($candidate['job_location'] ?: 'Gorakhpur, UP');?></div>
                    <div style="margin-top: 4px;"><i class="fa fa-money" style="color: #10b981; width: 18px;"></i> <?=html_escape($candidate['job_salary'] ?: 'Competitive');?></div>
                    <div style="margin-top: 4px;"><i class="fa fa-briefcase" style="color: #6366f1; width: 18px;"></i> <?=html_escape($candidate['job_type'] ?: 'Full Time');?></div>
                </div>
            </div>

            <!-- Primary ATS Action Suite -->
            <div style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
                <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0 0 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa fa-cogs" style="color: #00a896; margin-right: 6px;"></i> Recruitment Actions
                </h4>

                <!-- Advance Stage Button -->
                <button type="button" class="btn btn-block" data-toggle="modal" data-target="#moveStageModal" style="background: #0f172a; color: #ffffff; border-radius: 10px; padding: 11px; font-weight: 700; font-size: 13.5px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa fa-step-forward" style="color: #2dd4bf;"></i> Advance Pipeline Stage
                </button>

                <!-- 1-Click Onboard to Staff -->
                <button type="button" class="btn btn-block" data-toggle="modal" data-target="#onboardStaffModal" style="background: linear-gradient(135deg, #00a896 0%, #059669 100%); color: #ffffff; border: none; border-radius: 10px; padding: 11px; font-weight: 800; font-size: 13.5px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa fa-bolt"></i> Onboard to Staff Directory
                </button>

                <!-- Reject Button -->
                <?php if ($stage !== 'rejected'): ?>
                    <form action="<?=base_url('admin1947/hr/update_candidate_stage');?>" method="POST" onsubmit="return confirm('Are you sure you want to mark this candidate as Rejected?');" style="margin-bottom: 10px;">
                        <input type="hidden" name="candidate_id" value="<?=$candidate['career_id'];?>">
                        <input type="hidden" name="target_stage" value="rejected">
                        <input type="hidden" name="stage_note" value="Application rejected during review.">
                        <button type="submit" class="btn btn-block" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 10px; padding: 10px; font-weight: 700; font-size: 13px;">
                            <i class="fa fa-ban"></i> Mark as Rejected
                        </button>
                    </form>
                <?php endif; ?>

                <!-- Delete Record -->
                <form action="<?=base_url('admin1947/hr/delete_candidate');?>" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this candidate record?');">
                    <input type="hidden" name="candidate_id" value="<?=$candidate['career_id'];?>">
                    <button type="submit" class="btn btn-link btn-block" style="color: #94a3b8; font-size: 12px; text-decoration: none; padding-top: 4px;">
                        <i class="fa fa-trash-o"></i> Delete Candidate Record
                    </button>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN: Experience, Notes & Timeline -->
        <!-- ========================================== -->
        <div class="col-md-8">
            <!-- Qualifications & Professional Experience Section -->
            <div style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 26px; box-shadow: 0 4px 14px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 18px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-graduation-cap" style="color: #6366f1;"></i> Candidate Qualifications &amp; Experience
                </h3>

                <div class="row" style="margin-bottom: 18px;">
                    <div class="col-sm-6">
                        <div style="background: #f8fafc; border-radius: 12px; padding: 16px; border: 1px solid #f1f5f9;">
                            <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Education / Degree</span>
                            <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 4px;">
                                <?=html_escape($candidate['qualification'] ?: 'Not Specified');?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="background: #f8fafc; border-radius: 12px; padding: 16px; border: 1px solid #f1f5f9;">
                            <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Work Experience</span>
                            <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 4px;">
                                <?=html_escape($candidate['experience'] ?: '1+ Years Experience');?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cover Statement / Candidate Summary -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">
                        Candidate Statement / Cover Note:
                    </label>
                    <div style="background: #fdfdfd; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0; font-size: 13.5px; color: #334155; line-height: 1.6; font-style: italic;">
                        "<?=nl2br(html_escape($candidate['message'] ?: 'No personal statement provided with application.'));?>"
                    </div>
                </div>
            </div>

            <!-- HR Evaluation Notes & Timeline Section -->
            <div style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 26px; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-comments-o" style="color: #00a896;"></i> HR Evaluation &amp; Interview Timeline
                    </h3>
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">
                        <?=count($candidate['notes'] ?? []);?> Logged Interactions
                    </span>
                </div>

                <!-- Fast Add Note Form -->
                <form action="<?=base_url('admin1947/hr/add_candidate_note');?>" method="POST" style="margin-bottom: 26px;">
                    <input type="hidden" name="candidate_id" value="<?=$candidate['career_id'];?>">
                    <input type="hidden" name="stage" value="<?=$stage;?>">

                    <div style="background: #f8fafc; border-radius: 14px; padding: 18px; border: 1px solid #e2e8f0;">
                        <label style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">
                            Record Interview Notes / Candidate Evaluation
                        </label>
                        <textarea name="note_text" class="form-control" rows="3" placeholder="e.g. Conducted technical rounds on hematology analyzer calibration. Candidate demonstrated sound knowledge. Recommended for offer." required style="border-radius: 8px; font-size: 13px; margin-bottom: 12px;"></textarea>
                        
                        <div style="display: flex; justify-content: flex-end;">
                            <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 8px; font-weight: 700; font-size: 13px; padding: 8px 20px;">
                                <i class="fa fa-plus-circle"></i> Log Note
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Chronological Audit Timeline -->
                <div class="timeline-stream" style="position: relative; padding-left: 28px;">
                    <!-- Vertical line -->
                    <div style="position: absolute; left: 10px; top: 8px; bottom: 8px; width: 2px; background: #e2e8f0;"></div>

                    <?php if (!empty($candidate['notes'])): foreach ($candidate['notes'] as $n): 
                        $nStage = strtolower($n['stage_at_time'] ?? 'applied');
                        $dotColor = '#00a896';
                        if ($nStage === 'screened') $dotColor = '#7c3aed';
                        elseif ($nStage === 'interviewing') $dotColor = '#d97706';
                        elseif ($nStage === 'offered') $dotColor = '#059669';
                        elseif ($nStage === 'rejected') $dotColor = '#dc2626';
                    ?>
                        <div style="position: relative; margin-bottom: 22px;">
                            <!-- Node Dot -->
                            <div style="position: absolute; left: -24px; top: 4px; width: 14px; height: 14px; border-radius: 50%; background: #ffffff; border: 3px solid <?=$dotColor;?>; box-shadow: 0 0 0 3px #ffffff;"></div>

                            <div style="background: #ffffff; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; flex-wrap: wrap; gap: 6px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <strong style="font-size: 13px; color: #0f172a;"><?=html_escape($n['note_by'] ?: 'HR Lead');?></strong>
                                        <span style="font-size: 11px; font-weight: 700; color: <?=$dotColor;?>; background: <?=$dotColor;?>15; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">
                                            <?=ucfirst($nStage);?>
                                        </span>
                                    </div>
                                    <span style="font-size: 11.5px; color: #94a3b8;">
                                        <i class="fa fa-clock-o"></i> <?=date('d M Y, h:i A', strtotime($n['created_at']));?>
                                    </span>
                                </div>
                                <div style="font-size: 13px; color: #334155; line-height: 1.5;">
                                    <?=nl2br(html_escape($n['note_text']));?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div style="text-align: center; color: #94a3b8; padding: 20px 0;">
                            <i class="fa fa-sticky-note-o" style="font-size: 28px; margin-bottom: 6px; display: block; color: #cbd5e1;"></i>
                            No notes logged yet. Use the form above to add the first evaluation note.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Advance Stage -->
<!-- ========================================== -->
<div class="modal fade" id="moveStageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document" style="max-width: 440px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <form action="<?=base_url('admin1947/hr/update_candidate_stage');?>" method="POST">
                <input type="hidden" name="candidate_id" value="<?=$candidate['career_id'];?>">
                <input type="hidden" name="redirect_to" value="admin1947/hr/candidate_profile/<?=$candidate['career_id'];?>">

                <div class="modal-header" style="background: #0f172a; color: #ffffff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 18px 20px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                    <h4 class="modal-title" style="font-weight: 800; font-size: 15px;">
                        <i class="fa fa-step-forward" style="color: #2dd4bf; margin-right: 6px;"></i> Advance Pipeline Stage
                    </h4>
                </div>

                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 13px; color: #334155;">Target Stage *</label>
                        <select name="target_stage" class="form-control" required style="border-radius: 8px; height: 42px; font-weight: 700;">
                            <option value="applied" <?=$stage=='applied'?'selected':'';?>>📥 1. Applied (Intake)</option>
                            <option value="screened" <?=$stage=='screened'?'selected':'';?>>🔍 2. Screened (Phone / Resume Passed)</option>
                            <option value="interviewing" <?=$stage=='interviewing'?'selected':'';?>>🗓️ 3. Interviewing (Panel Round)</option>
                            <option value="offered" <?=$stage=='offered'?'selected':'';?>>💼 4. Offered (Letter Sent)</option>
                            <option value="hired" <?=$stage=='hired'?'selected':'';?>>🏆 5. Hired (Accepted)</option>
                            <option value="rejected" <?=$stage=='rejected'?'selected':'';?>>❌ 6. Rejected</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 13px; color: #334155;">Stage Transition Note</label>
                        <textarea name="stage_note" class="form-control" rows="2" placeholder="e.g. Cleared clinical interview, advancing to offer stage..." style="border-radius: 8px; font-size: 13px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 14px 20px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 700;">
                        Confirm Advance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Onboard to Staff Directory -->
<!-- ========================================== -->
<div class="modal fade" id="onboardStaffModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <form action="<?=base_url('admin1947/hr/onboard_candidate');?>" method="POST">
                <input type="hidden" name="candidate_id" value="<?=$candidate['career_id'];?>">

                <div class="modal-header" style="background: #0f172a; color: #ffffff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 20px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                    <h4 class="modal-title" style="font-weight: 800; font-size: 17px;">
                        <i class="fa fa-bolt" style="color: #2dd4bf; margin-right: 8px;"></i> 1-Click Convert Candidate to Active Staff
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <p style="color: #64748b; font-size: 13px; margin-bottom: 20px;">
                        This will automatically generate a staff profile in the official <strong>Upchar Staff Directory</strong> and mark this candidate as <strong>Hired</strong>.
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Full Name *</label>
                                <input type="text" name="name" class="form-control" value="<?=html_escape($candidate['name']);?>" required style="border-radius: 8px; height: 42px; font-weight: 700;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Generated Employee ID *</label>
                                <input type="text" name="employee_id" class="form-control" value="UP-EMP-<?=date('Y');?>-<?=rand(100, 999);?>" required style="border-radius: 8px; height: 42px; font-weight: 700; color: #0284c7; background: #f0f9ff;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Department *</label>
                                <select name="department" class="form-control" required style="border-radius: 8px; height: 42px;">
                                    <?php foreach ($departments as $d): ?>
                                        <option value="<?=$d;?>" <?=($candidate['job_department'] == $d) ? 'selected' : '';?>><?=$d;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Designation / Role Title *</label>
                                <input type="text" name="designation" class="form-control" value="<?=html_escape($roleTitle);?>" required style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Monthly Basic Salary (₹) *</label>
                                <input type="number" name="basic_salary" class="form-control" value="28000" required style="border-radius: 8px; height: 42px; font-weight: 700;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Date of Joining *</label>
                                <input type="date" name="date_of_joining" class="form-control" value="<?=date('Y-m-d');?>" required style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Gender</label>
                                <select name="gender" class="form-control" style="border-radius: 8px; height: 42px;">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Qualification</label>
                                <input type="text" name="qualification" class="form-control" value="<?=html_escape($candidate['qualification']);?>" style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Work Experience</label>
                                <input type="text" name="work_exp" class="form-control" value="<?=html_escape($candidate['experience']);?>" style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 16px 24px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #00a896 0%, #059669 100%); border: none; border-radius: 8px; padding: 8px 24px; font-weight: 800;">
                        <i class="fa fa-check-circle"></i> Confirm &amp; Onboard Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
