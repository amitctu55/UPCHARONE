<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$currentStage = $current_stage ?? 'all';
$selectedJobId = $selected_job_id ?? null;
?>

<div class="hr-candidates-container" style="max-width: 1400px; margin: 0 auto;">

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
            <div style="display: flex; align-items: center; gap: 8px;">
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                    Candidate Talent Pipeline
                </h2>
                <?php if ($selected_job): ?>
                    <span style="background: #f0fdfa; color: #00a896; border: 1px solid #ccfbf1; padding: 2px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 700;">
                        Requisition: <?=html_escape($selected_job['title']);?>
                    </span>
                <?php endif; ?>
            </div>
            <p style="margin: 4px 0 0; font-size: 13.5px; color: #64748b;">
                Track applicants across recruitment stages, advance candidate milestones, and review profiles.
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-primary" onclick="openAddCandidateModal()" data-toggle="modal" data-target="#addCandidateModal" style="background: #00a896; color: #ffffff; border: none; border-radius: 10px; padding: 10px 22px; font-size: 13.5px; font-weight: 700; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35); display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <i class="fa fa-user-plus"></i> Add Candidate
            </button>
        </div>
    </div>

    <!-- Horizontal Stage Tabs Navigation Bar -->
    <div style="background: #ffffff; border-radius: 16px; padding: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
        <div style="display: flex; align-items: center; gap: 4px; overflow-x: auto; max-width: 100%; padding: 4px;">
            <?php
            $tabs = [
                'all' => ['label' => 'All Candidates', 'icon' => 'fa-users', 'color' => '#0f172a', 'bg' => '#f1f5f9'],
                'applied' => ['label' => 'Applied', 'icon' => 'fa-inbox', 'color' => '#2563eb', 'bg' => '#eff6ff'],
                'screened' => ['label' => 'Screened', 'icon' => 'fa-check-square-o', 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
                'interviewing' => ['label' => 'Interviewing', 'icon' => 'fa-comments-o', 'color' => '#d97706', 'bg' => '#fffbeb'],
                'offered' => ['label' => 'Offered', 'icon' => 'fa-gift', 'color' => '#059669', 'bg' => '#ecfdf5'],
                'hired' => ['label' => 'Hired', 'icon' => 'fa-trophy', 'color' => '#00a896', 'bg' => '#f0fdfa'],
                'rejected' => ['label' => 'Rejected', 'icon' => 'fa-times-circle-o', 'color' => '#dc2626', 'bg' => '#fef2f2'],
            ];

            foreach ($tabs as $tKey => $tInfo):
                $isActive = ($currentStage === $tKey);
                $cnt = $stage_counts[$tKey] ?? 0;
                $jobQuery = $selectedJobId ? '?job_id=' . $selectedJobId : '';
            ?>
                <a href="<?=base_url('admin1947/hr/candidates/' . $tKey . $jobQuery);?>" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 700; transition: all 0.2s; white-space: nowrap; <?=$isActive ? 'background: ' . $tInfo['color'] . '; color: #ffffff; box-shadow: 0 4px 12px ' . $tInfo['color'] . '40;' : 'background: transparent; color: #64748b;';?>">
                    <i class="fa <?=$tInfo['icon'];?>" style="font-size: 13px; color: <?=$isActive ? '#ffffff' : $tInfo['color'];?>;"></i>
                    <span><?=$tInfo['label'];?></span>
                    <span style="font-size: 11px; padding: 2px 7px; border-radius: 9999px; font-weight: 800; <?=$isActive ? 'background: rgba(255,255,255,0.25); color: #ffffff;' : 'background: ' . $tInfo['bg'] . '; color: ' . $tInfo['color'] . ';';?>">
                        <?=$cnt;?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Toolbar: Search, Requisition Filter & View Switcher -->
    <div style="background: #ffffff; border-radius: 16px; padding: 16px 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 12px; flex-grow: 1; max-width: 500px;">
            <div style="position: relative; width: 100%;">
                <i class="fa fa-search" style="position: absolute; left: 14px; top: 12px; color: #94a3b8; font-size: 14px;"></i>
                <input type="text" id="candidateSearchInput" onkeyup="filterCandidateCards()" placeholder="Search by name, phone, qualifications, role..." style="width: 100%; padding: 8px 14px 8px 38px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13.5px; background: #f8fafc; outline: none;">
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <!-- Filter by Requisition -->
            <form action="<?=base_url('admin1947/hr/candidates/' . $currentStage);?>" method="GET" style="display: inline-flex; align-items: center; gap: 8px; margin: 0;">
                <label style="font-size: 12.5px; font-weight: 700; color: #64748b; margin: 0;">Requisition:</label>
                <select name="job_id" onchange="this.form.submit()" style="padding: 7px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; background: #fff; font-weight: 600; color: #334155; max-width: 250px;">
                    <option value="">All Requisitions (<?=count($candidates ?? []);?>)</option>
                    <?php if (!empty($jobs)): foreach ($jobs as $j): ?>
                        <option value="<?=$j['job_id'];?>" <?=$selectedJobId == $j['job_id'] ? 'selected' : '';?>>
                            <?=html_escape($j['title']);?> (<?=$j['department'];?>)
                        </option>
                    <?php endforeach; endif; ?>
                </select>
                <?php if ($selectedJobId): ?>
                    <a href="<?=base_url('admin1947/hr/candidates/' . $currentStage);?>" class="btn btn-sm" style="color: #ef4444; font-size: 12px; padding: 6px 10px;" title="Clear filter">
                        <i class="fa fa-times"></i> Clear
                    </a>
                <?php endif; ?>
            </form>

            <!-- Card vs Table View Toggle -->
            <div style="display: inline-flex; background: #f1f5f9; padding: 3px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <button type="button" id="btnViewGrid" onclick="switchView('grid')" class="btn btn-sm" style="padding: 4px 10px; font-size: 12px; font-weight: 700; border-radius: 6px; background: #ffffff; color: #0f172a; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <i class="fa fa-th-large"></i> Cards
                </button>
                <button type="button" id="btnViewTable" onclick="switchView('table')" class="btn btn-sm" style="padding: 4px 10px; font-size: 12px; font-weight: 700; border-radius: 6px; background: transparent; color: #64748b; border: none;">
                    <i class="fa fa-list"></i> Table
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- VIEW 1: Candidate Card Grid -->
    <!-- ========================================== -->
    <div id="candidatesGridView" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 20px;">
        <?php if (!empty($candidates)): foreach ($candidates as $cand): 
            $stage = strtolower($cand['status_stage'] ?? 'applied');
            $stageBadgeColor = '#2563eb';
            $stageBg = '#eff6ff';
            if ($stage === 'screened') { $stageBadgeColor = '#7c3aed'; $stageBg = '#f5f3ff'; }
            elseif ($stage === 'interviewing') { $stageBadgeColor = '#d97706'; $stageBg = '#fffbeb'; }
            elseif ($stage === 'offered') { $stageBadgeColor = '#059669'; $stageBg = '#ecfdf5'; }
            elseif ($stage === 'hired') { $stageBadgeColor = '#00a896'; $stageBg = '#f0fdfa'; }
            elseif ($stage === 'rejected') { $stageBadgeColor = '#dc2626'; $stageBg = '#fef2f2'; }

            $initial = strtoupper(substr($cand['name'] ?? 'C', 0, 1));
            $roleTitle = $cand['job_title'] ?: ($cand['designation'] ?: 'Applicant');
        ?>
            <div class="candidate-card" data-name="<?=strtolower(html_escape($cand['name']));?>" data-role="<?=strtolower(html_escape($roleTitle));?>" data-mobile="<?=html_escape($cand['mobile']);?>" data-qual="<?=strtolower(html_escape($cand['qualification']));?>" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.03); padding: 22px; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;">
                <div>
                    <!-- Card Top Header -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, <?=$stageBadgeColor;?>, #0f172a); color: #ffffff; font-weight: 800; font-size: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px <?=$stageBadgeColor;?>30;">
                                <?=$initial;?>
                            </div>
                            <div>
                                <a href="<?=base_url('admin1947/hr/candidate_profile/' . $cand['career_id']);?>" style="font-weight: 800; font-size: 15.5px; color: #0f172a; text-decoration: none; display: block; line-height: 1.2;">
                                    <?=html_escape($cand['name']);?>
                                </a>
                                <span style="font-size: 12px; color: #64748b; font-weight: 500;">
                                    <i class="fa fa-phone" style="font-size: 11px;"></i> <?=html_escape($cand['mobile']);?>
                                </span>
                            </div>
                        </div>

                        <!-- Stage Badge -->
                        <span style="background: <?=$stageBg;?>; color: <?=$stageBadgeColor;?>; border: 1px solid <?=$stageBadgeColor;?>30; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 800; text-transform: capitalize;">
                            <?=ucfirst($stage);?>
                        </span>
                    </div>

                    <!-- Role & Requisition -->
                    <div style="background: #f8fafc; border-radius: 10px; padding: 10px 14px; margin-bottom: 14px; border: 1px solid #f1f5f9;">
                        <div style="font-weight: 700; font-size: 13px; color: #1e293b; line-height: 1.3;">
                            <?=html_escape($roleTitle);?>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                            <span style="font-size: 11px; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 1px 6px; border-radius: 4px;">
                                <?=html_escape($cand['job_department'] ?: 'Clinical Services');?>
                            </span>
                            <span style="font-size: 11px; color: #64748b;">
                                • <?=html_escape($cand['experience'] ?: '1+ Yrs');?>
                            </span>
                        </div>
                    </div>

                    <!-- Qualification & Cover Statement -->
                    <div style="margin-bottom: 16px;">
                        <div style="font-size: 12px; color: #475569; font-weight: 600; margin-bottom: 4px;">
                            <i class="fa fa-graduation-cap" style="color: #6366f1; margin-right: 4px;"></i> <?=html_escape($cand['qualification'] ?: 'Not Specified');?>
                        </div>
                        <?php if (!empty($cand['message'])): ?>
                            <p style="font-size: 12px; color: #64748b; margin: 6px 0 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                "<?=html_escape($cand['message']);?>"
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Footer & Actions -->
                <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                    <!-- Quick Contact Icons -->
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <a href="tel:<?=html_escape($cand['mobile']);?>" class="btn btn-sm" style="background: #f1f5f9; color: #0284c7; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Call Candidate">
                            <i class="fa fa-phone"></i>
                        </a>
                        <a href="https://wa.me/91<?=preg_replace('/[^0-9]/', '', $cand['mobile']);?>?text=Hello%20<?=urlencode($cand['name']);?>,%20this%20is%20Upchar%20HR%20team%20regarding%20your%20application." target="_blank" class="btn btn-sm" style="background: #f0fdf4; color: #16a34a; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="WhatsApp">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                        <?php if (!empty($cand['email'])): ?>
                            <a href="mailto:<?=html_escape($cand['email']);?>" class="btn btn-sm" style="background: #eff6ff; color: #2563eb; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Email">
                                <i class="fa fa-envelope-o"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; align-items: center; gap: 6px;">
                        <!-- Advance Stage Trigger -->
                        <button type="button" class="btn btn-sm" onclick="openMoveStageModal(<?=$cand['career_id'];?>, '<?=html_escape(addslashes($cand['name']));?>', '<?=$stage;?>')" style="background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 11.5px; font-weight: 700;">
                            Stage <i class="fa fa-chevron-right" style="font-size: 10px; margin-left: 2px;"></i>
                        </button>

                        <!-- View Dossier Profile -->
                        <a href="<?=base_url('admin1947/hr/candidate_profile/' . $cand['career_id']);?>" class="btn btn-sm btn-primary" style="background: #00a896; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; padding: 6px 14px;">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; else: ?>
            <div style="grid-column: 1 / -1; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 60px 20px; text-align: center; color: #94a3b8;">
                <i class="fa fa-users" style="font-size: 44px; margin-bottom: 12px; display: block; color: #cbd5e1;"></i>
                <h4 style="font-size: 16px; font-weight: 700; color: #475569; margin: 0 0 6px;">No candidates in <?=ucfirst($currentStage);?> stage</h4>
                <p style="font-size: 13px; color: #94a3b8; margin: 0 0 16px;">Try switching tabs, clearing the job filter, or adding a new candidate.</p>
                <button type="button" class="btn btn-primary" onclick="openAddCandidateModal()" data-toggle="modal" data-target="#addCandidateModal" style="background: #00a896; border: none; border-radius: 10px; font-weight: 700; padding: 8px 20px; cursor: pointer;">
                    <i class="fa fa-user-plus"></i> Add New Candidate
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- ========================================== -->
    <!-- VIEW 2: Candidate Data Table (Alternative) -->
    <!-- ========================================== -->
    <div id="candidatesTableView" style="display: none; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom: 0;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Candidate Name &amp; Contact</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Applied Requisition</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Qualifications &amp; Exp</th>
                        <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: center;">Pipeline Stage</th>
                        <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($candidates)): foreach ($candidates as $cand): 
                        $stage = strtolower($cand['status_stage'] ?? 'applied');
                        $roleTitle = $cand['job_title'] ?: ($cand['designation'] ?: 'Applicant');
                    ?>
                        <tr class="candidate-row" style="vertical-align: middle;">
                            <td style="padding: 14px 20px;">
                                <a href="<?=base_url('admin1947/hr/candidate_profile/' . $cand['career_id']);?>" style="font-weight: 700; font-size: 14px; color: #0f172a; text-decoration: none;">
                                    <?=html_escape($cand['name']);?>
                                </a>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    <i class="fa fa-phone"></i> <?=html_escape($cand['mobile']);?> 
                                    <?php if (!empty($cand['email'])): ?>• <?=html_escape($cand['email']);?><?php endif; ?>
                                </div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <strong style="font-size: 13px; color: #334155;"><?=html_escape($roleTitle);?></strong>
                                <div style="font-size: 11.5px; color: #0284c7;"><?=html_escape($cand['job_department'] ?: 'Operations & Admin');?></div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <div style="font-size: 12.5px; color: #334155; font-weight: 600;"><?=html_escape($cand['qualification'] ?: '-');?></div>
                                <div style="font-size: 11.5px; color: #64748b;"><?=html_escape($cand['experience'] ?: '-');?></div>
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <span style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 800; text-transform: capitalize;">
                                    <?=ucfirst($stage);?>
                                </span>
                            </td>
                            <td style="padding: 14px 20px; text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <button type="button" class="btn btn-sm" onclick="openMoveStageModal(<?=$cand['career_id'];?>, '<?=html_escape(addslashes($cand['name']));?>', '<?=$stage;?>')" style="background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; font-weight: 700;">
                                        Stage <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                                    </button>
                                    <a href="<?=base_url('admin1947/hr/candidate_profile/' . $cand['career_id']);?>" class="btn btn-sm" style="background: #00a896; color: #fff; border-radius: 8px; font-size: 12px; font-weight: 700;">
                                        View Profile
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Advance Candidate Stage -->
<!-- ========================================== -->
<div class="modal fade" id="moveStageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <form action="<?=base_url('admin1947/hr/update_candidate_stage');?>" method="POST">
                <input type="hidden" name="candidate_id" id="stage_modal_candidate_id" value="">
                <input type="hidden" name="redirect_to" value="admin1947/hr/candidates/<?=$currentStage;?><?=$selectedJobId ? '?job_id=' . $selectedJobId : '';?>">

                <div class="modal-header" style="background: #0f172a; color: #ffffff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 18px 20px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                    <h4 class="modal-title" style="font-weight: 800; font-size: 15px;">
                        <i class="fa fa-step-forward" style="color: #2dd4bf; margin-right: 6px;"></i> Advance Candidate Stage
                    </h4>
                </div>

                <div class="modal-body" style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 12px; color: #64748b;">Candidate:</span>
                        <div id="stage_modal_candidate_name" style="font-weight: 800; font-size: 15px; color: #0f172a;"></div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 13px; color: #334155;">Target Pipeline Stage *</label>
                        <select name="target_stage" id="stage_modal_target_stage" class="form-control" required style="border-radius: 8px; height: 42px; font-weight: 700;">
                            <option value="applied">📥 1. Applied (New Intake)</option>
                            <option value="screened">🔍 2. Screened (Phone / Resume Passed)</option>
                            <option value="interviewing">🗓️ 3. Interviewing (Clinical / Panel)</option>
                            <option value="offered">💼 4. Offered (Letter Issued)</option>
                            <option value="hired">🏆 5. Hired (Accepted / Onboarding)</option>
                            <option value="rejected">❌ 6. Rejected</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 13px; color: #334155;">Stage Transition Note / Feedback</label>
                        <textarea name="stage_note" class="form-control" rows="2" placeholder="e.g. Cleared clinical interview with flying colors..." style="border-radius: 8px; font-size: 13px;"></textarea>
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
<!-- MODAL: Fast Add Candidate -->
<!-- ========================================== -->
<div class="modal fade" id="addCandidateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <form action="<?=base_url('admin1947/hr/save_candidate');?>" method="POST">
                <input type="hidden" name="redirect_to" value="admin1947/hr/candidates/<?=$currentStage;?><?=$selectedJobId ? '?job_id=' . $selectedJobId : '';?>">
                <div class="modal-header" style="background: #0f172a; color: #ffffff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 20px 24px;">
                    <button type="button" class="close" data-dismiss="modal" onclick="closeAddCandidateModal()" style="color: #ffffff; opacity: 0.8;">&times;</button>
                    <h4 class="modal-title" style="font-weight: 800; font-size: 17px;">
                        <i class="fa fa-user-plus" style="color: #2dd4bf; margin-right: 8px;"></i> Fast Intake Candidate
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Full Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Rajesh Nair" required style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Mobile Number *</label>
                                <input type="text" name="mobile" class="form-control" placeholder="10-digit mobile number" required style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="e.g. doctor@hospital.com" style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Target Requisition Opening *</label>
                                <select name="job_id" id="candidate_modal_job_id" class="form-control" required style="border-radius: 8px; height: 42px;">
                                    <?php if (!empty($jobs)): foreach ($jobs as $j): ?>
                                        <option value="<?=$j['job_id'];?>" <?=(intval($selectedJobId) == intval($j['job_id'])) ? 'selected' : '';?>>
                                            <?=html_escape($j['title']);?> (<?=$j['department'];?>) <?=($j['status'] === 'closed') ? '— [Closed Requisition]' : '';?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Qualifications</label>
                                <input type="text" name="qualification" class="form-control" placeholder="e.g. MBBS, DNB, B.Sc Nursing" style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Experience (Years &amp; Hospital)</label>
                                <input type="text" name="experience" class="form-control" placeholder="e.g. 3.5 Yrs at Max Healthcare" style="border-radius: 8px; height: 42px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #334155;">Initial Pipeline Stage</label>
                                <select name="status_stage" class="form-control" style="border-radius: 8px; height: 42px; font-weight: 700;">
                                    <option value="applied" <?=$currentStage=='applied'?'selected':'';?>>Applied</option>
                                    <option value="screened" <?=$currentStage=='screened'?'selected':'';?>>Screened</option>
                                    <option value="interviewing" <?=$currentStage=='interviewing'?'selected':'';?>>Interviewing</option>
                                    <option value="offered" <?=$currentStage=='offered'?'selected':'';?>>Offered</option>
                                    <option value="hired" <?=$currentStage=='hired'?'selected':'';?>>Hired</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 13px; color: #334155;">Cover Note / Candidate Summary</label>
                        <textarea name="message" class="form-control" rows="2" placeholder="Brief clinical background, key achievements, notice period..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 16px 24px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeAddCandidateModal()" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 8px; padding: 8px 24px; font-weight: 700;">
                        <i class="fa fa-save"></i> Save Candidate to Pipeline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddCandidateModal() {
    var selJob = '<?=$selectedJobId ? $selectedJobId : "";?>';
    if (selJob && document.getElementById('candidate_modal_job_id')) {
        document.getElementById('candidate_modal_job_id').value = selJob;
    }
    if (typeof $.fn.modal === 'function') {
        $('#addCandidateModal').modal('show');
    } else {
        $('#addCandidateModal').addClass('in').show();
        if (!$('.modal-backdrop').length) {
            $('body').addClass('modal-open').append('<div class="modal-backdrop fade in" onclick="closeAddCandidateModal()"></div>');
        }
    }
}

function closeAddCandidateModal() {
    if (typeof $.fn.modal === 'function') {
        $('#addCandidateModal').modal('hide');
    }
    $('#addCandidateModal').removeClass('in').hide();
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
}
function openMoveStageModal(candidateId, candidateName, currentStage) {
    document.getElementById('stage_modal_candidate_id').value = candidateId;
    document.getElementById('stage_modal_candidate_name').innerText = candidateName;
    document.getElementById('stage_modal_target_stage').value = currentStage;
    $('#moveStageModal').modal('show');
}

function switchView(mode) {
    var grid = document.getElementById('candidatesGridView');
    var tbl = document.getElementById('candidatesTableView');
    var btnGrid = document.getElementById('btnViewGrid');
    var btnTbl = document.getElementById('btnViewTable');

    if (mode === 'table') {
        grid.style.display = 'none';
        tbl.style.display = 'block';
        btnTbl.style.background = '#ffffff';
        btnTbl.style.color = '#0f172a';
        btnTbl.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
        btnGrid.style.background = 'transparent';
        btnGrid.style.color = '#64748b';
        btnGrid.style.boxShadow = 'none';
    } else {
        grid.style.display = 'grid';
        tbl.style.display = 'none';
        btnGrid.style.background = '#ffffff';
        btnGrid.style.color = '#0f172a';
        btnGrid.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
        btnTbl.style.background = 'transparent';
        btnTbl.style.color = '#64748b';
        btnTbl.style.boxShadow = 'none';
    }
}

function filterCandidateCards() {
    var q = document.getElementById('candidateSearchInput').value.toLowerCase().trim();
    var cards = document.querySelectorAll('.candidate-card');

    cards.forEach(function(card) {
        var name = card.getAttribute('data-name') || '';
        var role = card.getAttribute('data-role') || '';
        var mobile = card.getAttribute('data-mobile') || '';
        var qual = card.getAttribute('data-qual') || '';

        if (!q || name.includes(q) || role.includes(q) || mobile.includes(q) || qual.includes(q)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
