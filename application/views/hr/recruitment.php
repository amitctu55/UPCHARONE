<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ATS Recruitment & Talent Acquisition Modern Command Suite -->
<style>
/* Modern ATS Palette & Kanban Monitor Design System */
:root {
    --col-applied: #0284c7;
    --col-screened: #7c3aed;
    --col-interview: #d97706;
    --col-offered: #16a34a;
    --col-hired: #00a896;
}

.ats-monitor-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 18px;
    padding: 24px 28px;
    margin-bottom: 20px;
    color: #ffffff;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
    position: relative;
    overflow: hidden;
}
.ats-monitor-header::after {
    content: '';
    position: absolute;
    right: -30px;
    top: -30px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(0, 168, 150, 0.25) 0%, rgba(0, 168, 150, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

/* Kanban Monitoring Tool Ribbon */
.kanban-monitor-toolbar {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 12px 18px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}

.ats-board-wrapper {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 20px;
    align-items: flex-start;
    min-height: 600px;
    -webkit-overflow-scrolling: touch;
}

.ats-stage-col {
    flex: 0 0 315px;
    width: 315px;
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    max-height: 84vh;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
    transition: all 0.2s ease;
}
.ats-stage-col.drag-over {
    background: #f0fdf4;
    border: 2px dashed #00a896;
    transform: scale(1.01);
}

.ats-stage-header {
    padding: 14px 16px;
    background: #ffffff;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    border-bottom: 1px solid #edf2f7;
    border-top: 4px solid;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ats-cards-scroll {
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow-y: auto;
    flex-grow: 1;
    min-height: 200px;
}
.ats-cards-scroll::-webkit-scrollbar {
    width: 5px;
}
.ats-cards-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.ats-cand-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 14px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    cursor: grab;
}
.ats-cand-card:active {
    cursor: grabbing;
}
.ats-cand-card.dragging {
    opacity: 0.4;
    transform: scale(0.96);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
}
.ats-cand-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
    border-color: #cbd5e1;
}

.ats-cand-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    color: #ffffff;
    font-weight: 800;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

.ats-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 7px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    line-height: 1.2;
}

.ats-icon-btn {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-size: 11.5px;
    text-decoration: none !important;
    transition: all 0.15s ease;
}
.ats-icon-btn:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #cbd5e1;
}

.ats-chip {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none !important;
}
.ats-chip:hover, .ats-chip.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}

/* Compact Card Mode */
.compact-mode .ats-cand-card {
    padding: 10px 12px;
    margin-bottom: 8px;
}
.compact-mode .ats-cand-avatar {
    width: 28px;
    height: 28px;
    font-size: 12px;
}
.compact-mode .cand-extra-bio,
.compact-mode .cand-dept-tag {
    display: none !important;
}

/* Live Toast Notification */
#atsLiveToast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #0f172a;
    color: #ffffff;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 13px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    display: none;
    z-index: 9999;
    align-items: center;
    gap: 10px;
    border: 1px solid rgba(255,255,255,0.15);
}
</style>

<div class="container-fluid" style="padding: 0;">

    <!-- Live Toast Container -->
    <div id="atsLiveToast">
        <i class="fa fa-check-circle" style="color: #2dd4bf; font-size: 16px;"></i>
        <span id="atsToastMsg">Candidate stage updated successfully</span>
    </div>

    <!-- Flash Alert Notifications -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; padding: 14px 20px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa fa-check-circle" style="font-size: 18px; color: #10b981;"></i>
                <span><?= $this->session->flashdata('success_msg'); ?></span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #065f46; opacity: 0.7; font-size: 20px;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600; padding: 14px 20px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa fa-exclamation-circle" style="font-size: 18px; color: #ef4444;"></i>
                <span><?= $this->session->flashdata('error_msg'); ?></span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #991b1b; opacity: 0.7; font-size: 20px;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Action Toolbar Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.3px;">
                ATS Recruitment &amp; Kanban Studio
            </h2>
            <p style="margin: 0; font-size: 13.5px; color: #64748b;">
                Interactive 5-column drag &amp; drop board for managing live candidate stages, interview notes, and onboarding.
            </p>
        </div>

        <!-- Primary Actions -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <button type="button" data-toggle="modal" data-target="#addCandidateModal" class="btn btn-primary" style="background: #00a896; color: #ffffff; font-weight: 700; border-radius: 10px; padding: 10px 20px; font-size: 13px; border: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35);">
                <i class="fa fa-user-plus"></i> Add Candidate
            </button>

            <button type="button" onclick="exportApplicantsCSV()" class="btn btn-default" style="font-weight: 700; border-radius: 10px; padding: 10px 14px; font-size: 13px; border: 1px solid #cbd5e1;" title="Download CSV">
                <i class="fa fa-download" style="color: #64748b;"></i> Export CSV
            </button>
        </div>
    </div>

    <!-- The 5 Core Hiring Stages Interactive Summary Bar -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 20px;">
        <!-- 1. Applied -->
        <a href="<?= base_url('admin1947/hr/recruitment?stage=applied'); ?>" style="text-decoration: none; display: block; background: #ffffff; border: 1px solid <?= $selected_stage==='applied' ? '#0284c7' : '#e2e8f0'; ?>; border-top: 4px solid #0284c7; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02); transition: all 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">1. Applied</span>
                <span style="background: #e0f2fe; color: #0284c7; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 6px;">Inbox</span>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: #0284c7; margin-top: 4px; line-height: 1;">
                <?= $counts['applied'] ?? 0; ?>
            </div>
            <small style="color: #64748b; font-size: 11px; font-weight: 600; margin-top: 4px; display: block;">New Applications</small>
        </a>

        <!-- 2. Screened -->
        <a href="<?= base_url('admin1947/hr/recruitment?stage=screened'); ?>" style="text-decoration: none; display: block; background: #ffffff; border: 1px solid <?= $selected_stage==='screened' ? '#7c3aed' : '#e2e8f0'; ?>; border-top: 4px solid #7c3aed; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02); transition: all 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">2. Screened</span>
                <span style="background: #f5f3ff; color: #7c3aed; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 6px;">Shortlist</span>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: #7c3aed; margin-top: 4px; line-height: 1;">
                <?= $counts['screened'] ?? 0; ?>
            </div>
            <small style="color: #64748b; font-size: 11px; font-weight: 600; margin-top: 4px; display: block;">Reviewed Profiles</small>
        </a>

        <!-- 3. Interviewing -->
        <a href="<?= base_url('admin1947/hr/recruitment?stage=interview_scheduled'); ?>" style="text-decoration: none; display: block; background: #ffffff; border: 1px solid <?= $selected_stage==='interview_scheduled' ? '#d97706' : '#e2e8f0'; ?>; border-top: 4px solid #d97706; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02); transition: all 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">3. Interviewing</span>
                <span style="background: #fffbeb; color: #d97706; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 6px;">Active</span>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: #d97706; margin-top: 4px; line-height: 1;">
                <?= $counts['interview'] ?? 0; ?>
            </div>
            <small style="color: #64748b; font-size: 11px; font-weight: 600; margin-top: 4px; display: block;">Technical &amp; HR</small>
        </a>

        <!-- 4. Offered -->
        <a href="<?= base_url('admin1947/hr/recruitment?stage=offered'); ?>" style="text-decoration: none; display: block; background: #ffffff; border: 1px solid <?= $selected_stage==='offered' ? '#16a34a' : '#e2e8f0'; ?>; border-top: 4px solid #16a34a; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02); transition: all 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">4. Offered</span>
                <span style="background: #f0fdf4; color: #16a34a; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 6px;">Proposal</span>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: #16a34a; margin-top: 4px; line-height: 1;">
                <?= $counts['offered'] ?? 0; ?>
            </div>
            <small style="color: #64748b; font-size: 11px; font-weight: 600; margin-top: 4px; display: block;">Offer Dispatched</small>
        </a>

        <!-- 5. Hired -->
        <a href="<?= base_url('admin1947/hr/recruitment?stage=hired'); ?>" style="text-decoration: none; display: block; background: #ffffff; border: 1px solid <?= $selected_stage==='hired' ? '#00a896' : '#e2e8f0'; ?>; border-top: 4px solid #00a896; border-radius: 12px; padding: 12px 14px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02); transition: all 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">5. Hired</span>
                <span style="background: #e6fffa; color: #00a896; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 6px;">Placed</span>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: #00a896; margin-top: 4px; line-height: 1;">
                <?= $counts['hired'] ?? 0; ?>
            </div>
            <small style="color: #64748b; font-size: 11px; font-weight: 600; margin-top: 4px; display: block;">Staff Onboarded</small>
        </a>
    </div>

    <!-- ========================================================================================= -->
    <!-- KANBAN MONITORING TOOLS CONTROL RIBBON                                                    -->
    <!-- ========================================================================================= -->
    <div class="kanban-monitor-toolbar">
        
        <!-- Requisition Quick Filter Chips -->
        <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
            <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Filter:</span>
            
            <a href="<?= base_url('admin1947/hr/recruitment'); ?>" class="ats-chip <?= empty($selected_job_id) ? 'active' : ''; ?>">
                All Positions (<?= $counts['total_applicants'] ?? 0; ?>)
            </a>

            <?php foreach($jobs as $j): 
                if ($j['candidate_count'] == 0 && empty($selected_job_id)) continue;
                $isSel = ($selected_job_id == $j['job_id']);
            ?>
                <a href="<?= base_url('admin1947/hr/recruitment?job_id=' . $j['job_id'] . (!empty($selected_stage) ? '&stage='.$selected_stage : '')); ?>" class="ats-chip <?= $isSel ? 'active' : ''; ?>">
                    <?= html_escape($j['title']); ?> <span style="background: rgba(0,0,0,0.12); border-radius: 10px; padding: 1px 6px; font-size: 10px;"><?= $j['candidate_count']; ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Utility & Monitor Controls -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Live Instant Search -->
            <div style="position: relative; min-width: 220px;">
                <i class="fa fa-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 12.5px;"></i>
                <input type="text" id="candidateSearchInput" class="form-control" value="<?= html_escape($search_keyword ?? ''); ?>" placeholder="Search candidate..." style="padding-left: 34px; height: 34px; border-radius: 8px; font-size: 12px; border: 1px solid #cbd5e1; box-shadow: none;">
            </div>

            <!-- Card Density Toggle (Comfortable vs Compact) -->
            <button type="button" id="btnDensityToggle" class="btn btn-sm btn-default" onclick="toggleDensity()" style="border-radius: 8px; font-weight: 700; font-size: 12px; height: 34px; color: #475569;" title="Toggle Card Density">
                <i class="fa fa-th-large"></i> Compact Mode
            </button>

            <!-- Board Mode View Switcher -->
            <div class="btn-group" style="background: #f1f5f9; border-radius: 8px; padding: 2px;">
                <button type="button" id="btnViewKanban" class="btn btn-xs" onclick="switchView('kanban')" style="border-radius: 6px; font-weight: 700; font-size: 11.5px; padding: 5px 12px; background: #0f172a; color: #ffffff; border: none;">
                    <i class="fa fa-columns"></i> Board
                </button>
                <button type="button" id="btnViewTable" class="btn btn-xs" onclick="switchView('table')" style="border-radius: 6px; font-weight: 700; font-size: 11.5px; padding: 5px 12px; background: transparent; color: #475569; border: none;">
                    <i class="fa fa-list"></i> Table
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================================================= -->
    <!-- VIEW 1: DRAG & DROP 5-STAGE KANBAN BOARD                                                  -->
    <!-- ========================================================================================= -->
    <div id="kanbanViewContainer" style="display: block; margin-bottom: 30px;">
        <?php
        $fiveStages = [
            'applied' => [
                'name'    => 'Applied',
                'sub'     => 'New Applications',
                'color'   => '#0284c7',
                'bg'      => '#f0f9ff',
                'grad'    => 'linear-gradient(135deg, #0284c7, #0369a1)',
                'icon'    => 'fa-inbox'
            ],
            'screened' => [
                'name'    => 'Screened',
                'sub'     => 'Shortlisted Profiles',
                'color'   => '#7c3aed',
                'bg'      => '#f5f3ff',
                'grad'    => 'linear-gradient(135deg, #7c3aed, #6d28d9)',
                'icon'    => 'fa-filter'
            ],
            'interview_scheduled' => [
                'name'    => 'Interviewing',
                'sub'     => 'Technical & HR Rounds',
                'color'   => '#d97706',
                'bg'      => '#fffbeb',
                'grad'    => 'linear-gradient(135deg, #f59e0b, #d97706)',
                'icon'    => 'fa-calendar'
            ],
            'offered' => [
                'name'    => 'Offered',
                'sub'     => 'Offer Letter Sent',
                'color'   => '#16a34a',
                'bg'      => '#f0fdf4',
                'grad'    => 'linear-gradient(135deg, #10b981, #059669)',
                'icon'    => 'fa-handshake-o'
            ],
            'hired' => [
                'name'    => 'Hired',
                'sub'     => 'Onboarded to Staff',
                'color'   => '#00a896',
                'bg'      => '#e6fffa',
                'grad'    => 'linear-gradient(135deg, #00a896, #028090)',
                'icon'    => 'fa-check-circle'
            ]
        ];

        $candidatesGrouped = [
            'applied'             => [],
            'screened'            => [],
            'interview_scheduled' => [],
            'offered'             => [],
            'hired'               => []
        ];

        foreach ($applicants as $app) {
            $st = strtolower($app['status_stage'] ?? 'applied');
            if (isset($candidatesGrouped[$st])) {
                $candidatesGrouped[$st][] = $app;
            } else {
                $candidatesGrouped['applied'][] = $app;
            }
        }
        ?>

        <div class="ats-board-wrapper" id="atsKanbanBoard">
            <?php foreach ($fiveStages as $stageKey => $sMeta): 
                $cards = $candidatesGrouped[$stageKey] ?? [];
            ?>
            <!-- Stage Column with Drag and Drop Listeners -->
            <div class="ats-stage-col" 
                 id="column-<?= $stageKey; ?>"
                 data-stage="<?= $stageKey; ?>"
                 ondragover="handleDragOver(event)"
                 ondragleave="handleDragLeave(event)"
                 ondrop="handleDrop(event, '<?= $stageKey; ?>')">
                
                <!-- Column Header -->
                <div class="ats-stage-header" style="border-top-color: <?= $sMeta['color']; ?>;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: <?= $sMeta['color']; ?>;"></span>
                            <strong style="font-size: 14px; color: #0f172a; font-weight: 800;"><?= $sMeta['name']; ?></strong>
                        </div>
                        <small style="color: #64748b; font-size: 11px; font-weight: 600; display: block; margin-top: 2px;">
                            <?= $sMeta['sub']; ?>
                        </small>
                    </div>
                    <span class="column-count-badge" style="background: <?= $sMeta['bg']; ?>; color: <?= $sMeta['color']; ?>; font-weight: 800; font-size: 11.5px; padding: 3px 9px; border-radius: 12px; border: 1px solid <?= $sMeta['color']; ?>30;">
                        <?= count($cards); ?>
                    </span>
                </div>

                <!-- Cards Scroll Container -->
                <div class="ats-cards-scroll" id="scroll-container-<?= $stageKey; ?>">
                    <?php if (!empty($cards)): foreach ($cards as $app): 
                        $initial = strtoupper(substr($app['name'], 0, 1));
                    ?>
                    <!-- Draggable Candidate Card -->
                    <div class="ats-cand-card" 
                         id="kanban-card-<?= $app['career_id']; ?>"
                         data-career-id="<?= $app['career_id']; ?>"
                         data-candidate-name="<?= html_escape($app['name']); ?>"
                         data-current-stage="<?= $stageKey; ?>"
                         data-search-text="<?= strtolower($app['name'] . ' ' . $app['email'] . ' ' . $app['mobile'] . ' ' . $app['designation'] . ' ' . $app['job_title'] . ' ' . $app['qualification']); ?>"
                         draggable="true"
                         ondragstart="handleDragStart(event)"
                         ondragend="handleDragEnd(event)">
                        
                        <!-- Header: Avatar, Name & Phone -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <div class="ats-cand-avatar" style="background: <?= $sMeta['grad']; ?>;">
                                <?= $initial; ?>
                            </div>
                            <div style="flex-grow: 1; min-width: 0;">
                                <strong style="font-size: 13.5px; color: #0f172a; display: block; line-height: 1.2; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    <?= html_escape($app['name']); ?>
                                </strong>
                                <small style="color: #64748b; font-size: 11.5px; font-weight: 600; font-family: monospace;">
                                    +91 <?= html_escape($app['mobile']); ?>
                                </small>
                            </div>
                            <i class="fa fa-arrows text-muted" style="font-size: 11px; opacity: 0.5;" title="Drag to move stage"></i>
                        </div>

                        <!-- Applied Role & Department -->
                        <div class="cand-dept-tag" style="background: #f8fafc; border-radius: 8px; padding: 7px 9px; border: 1px solid #f1f5f9; margin-bottom: 10px;">
                            <div style="font-size: 12px; font-weight: 800; color: #0f172a; line-height: 1.3;">
                                <?= html_escape($app['job_title'] ?: $app['designation'] ?: 'General Application'); ?>
                            </div>
                            <?php if (!empty($app['job_dept'])): ?>
                                <div style="font-size: 10.5px; color: #64748b; margin-top: 2px; font-weight: 600;">
                                    <i class="fa fa-building-o"></i> <?= html_escape($app['job_dept']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Qualification & Experience Chips -->
                        <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 10px;">
                            <span class="ats-tag" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;">
                                <i class="fa fa-graduation-cap" style="color: #64748b;"></i> <?= html_escape(substr($app['qualification'] ?: 'Graduate', 0, 22)); ?>
                            </span>
                            <span class="ats-tag" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;">
                                <i class="fa fa-briefcase" style="color: #64748b;"></i> <?= html_escape($app['experience'] ?: '1+ yrs'); ?>
                            </span>
                        </div>

                        <?php if (!empty($app['message'])): ?>
                            <p class="cand-extra-bio" style="font-size: 11.5px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-style: italic;">
                                "<?= html_escape($app['message']); ?>"
                            </p>
                        <?php endif; ?>

                        <!-- Quick Contact Bar & Actions -->
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px dashed #f1f5f9;">
                            <!-- Communication Links -->
                            <div style="display: flex; gap: 4px; align-items: center;">
                                <a href="tel:<?= $app['mobile']; ?>" class="ats-icon-btn" title="Call">
                                    <i class="fa fa-phone" style="color: #0284c7;"></i>
                                </a>
                                <a href="mailto:<?= $app['email']; ?>" class="ats-icon-btn" title="Email">
                                    <i class="fa fa-envelope-o" style="color: #475569;"></i>
                                </a>
                                <a href="https://wa.me/91<?= $app['mobile']; ?>" target="_blank" class="ats-icon-btn" title="WhatsApp">
                                    <i class="fa fa-whatsapp" style="color: #16a34a;"></i>
                                </a>
                            </div>

                            <!-- Stage Action Controls -->
                            <div style="display: flex; gap: 4px; align-items: center;">
                                <span class="onboard-btn-container" style="display: <?= ($stageKey === 'offered' || $stageKey === 'hired') ? 'inline-block' : 'none'; ?>;">
                                    <button type="button" class="btn btn-xs" onclick="openOnboardStaffModal(<?= html_escape(json_encode($app)); ?>)" style="background: #00a896; color: #ffffff; font-weight: 800; border-radius: 6px; padding: 4px 8px; font-size: 11px; border: none; box-shadow: 0 2px 6px rgba(0, 168, 150, 0.3);" title="Onboard to Employee Directory">
                                        ⚡ Onboard
                                    </button>
                                </span>

                                <!-- Move Stage Popup Trigger -->
                                <button type="button" class="btn btn-xs btn-default" onclick="openStageModal(<?= html_escape(json_encode($app)); ?>)" style="border-radius: 6px; font-weight: 700; padding: 4px 8px; font-size: 11px; color: #0f172a; border: 1px solid #cbd5e1;">
                                    Stage &rarr;
                                </button>
                                
                                <!-- Dossier Trigger -->
                                <button type="button" class="btn btn-xs btn-default" onclick="openCandidateDossier(<?= html_escape(json_encode($app)); ?>)" style="border-radius: 6px; font-weight: 700; padding: 4px 7px; font-size: 11px; color: #0284c7; border: 1px solid #cbd5e1;" title="View Dossier">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; else: ?>
                        <div class="empty-column-msg" style="text-align: center; color: #94a3b8; padding: 36px 10px;">
                            <i class="fa <?= $sMeta['icon']; ?>" style="font-size: 24px; color: #cbd5e1; display: block; margin-bottom: 6px;"></i>
                            <span style="font-size: 12px; font-weight: 600;">Drag candidate here</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ========================================================================================= -->
    <!-- VIEW 2: TABLE ROSTER                                                                      -->
    <!-- ========================================================================================= -->
    <div id="tableViewContainer" style="display: none; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04); margin-bottom: 30px;">
        <div style="padding: 16px 22px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 15px; color: #0f172a; font-weight: 800;">Candidate Pipeline Roster</strong>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">
                Showing <?= count($applicants); ?> candidate dossiers
            </span>
        </div>

        <div class="table-responsive" style="margin: 0;">
            <table class="table" style="margin: 0; vertical-align: middle; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                        <th style="padding: 14px 20px; font-weight: 800;">Candidate &amp; Contact</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Applied Position</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Education &amp; Experience</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Applied Date</th>
                        <th style="padding: 14px 16px; font-weight: 800;">ATS Stage</th>
                        <th style="padding: 14px 20px; font-weight: 800; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applicants)): foreach($applicants as $app): 
                        $st = strtolower($app['status_stage'] ?? 'applied');
                        $badgeBg = '#e0f2fe'; $badgeColor = '#0284c7'; $stageLabel = 'Applied';
                        if ($st === 'screened') { $badgeBg = '#f5f3ff'; $badgeColor = '#7c3aed'; $stageLabel = 'Screened'; }
                        elseif ($st === 'interview_scheduled') { $badgeBg = '#fffbeb'; $badgeColor = '#d97706'; $stageLabel = 'Interviewing'; }
                        elseif ($st === 'offered') { $badgeBg = '#f0fdf4'; $badgeColor = '#16a34a'; $stageLabel = 'Offered'; }
                        elseif ($st === 'hired') { $badgeBg = '#e6fffa'; $badgeColor = '#00a896'; $stageLabel = 'Hired'; }
                        elseif ($st === 'rejected') { $badgeBg = '#fef2f2'; $badgeColor = '#dc2626'; $stageLabel = 'Rejected'; }
                    ?>
                    <tr class="table-candidate-row" 
                        data-search-text="<?= strtolower($app['name'] . ' ' . $app['email'] . ' ' . $app['mobile'] . ' ' . $app['designation'] . ' ' . $app['job_title'] . ' ' . $app['qualification']); ?>"
                        style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 20px;">
                            <strong style="color: #0f172a; font-size: 14px;"><?= html_escape($app['name']); ?></strong>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                <i class="fa fa-envelope-o"></i> <?= html_escape($app['email']); ?> &bull; <i class="fa fa-phone"></i> +91 <?= html_escape($app['mobile']); ?>
                            </div>
                        </td>
                        <td style="padding: 14px 16px;">
                            <strong style="color: #0f172a; font-size: 13.5px;"><?= html_escape($app['job_title'] ?: $app['designation'] ?: 'General Applicant'); ?></strong>
                            <?php if (!empty($app['job_dept'])): ?>
                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;"><?= html_escape($app['job_dept']); ?></div>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 14px 16px;">
                            <div style="font-weight: 600; color: #334155; font-size: 12.5px;"><?= html_escape($app['qualification'] ?: 'Graduate'); ?></div>
                            <small style="color: #64748b; font-size: 11.5px;"><?= html_escape($app['experience'] ?: '1-2 Years'); ?></small>
                        </td>
                        <td style="padding: 14px 16px; color: #64748b; font-size: 12.5px;">
                            <?= !empty($app['creat_date']) ? date('d M Y', strtotime($app['creat_date'])) : 'Recent'; ?>
                        </td>
                        <td style="padding: 14px 16px;">
                            <span style="padding: 4px 12px; font-size: 11px; font-weight: 800; border-radius: 12px; background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>;">
                                <?= $stageLabel; ?>
                            </span>
                        </td>
                        <td style="padding: 14px 20px; text-align: right; white-space: nowrap;">
                            <?php if ($st === 'offered' || $st === 'hired'): ?>
                                <button type="button" class="btn btn-xs" onclick="openOnboardStaffModal(<?= html_escape(json_encode($app)); ?>)" style="background: #00a896; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 4px 9px; font-size: 11px; border: none; margin-right: 4px;">
                                    ⚡ Onboard
                                </button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-xs btn-default" onclick="openStageModal(<?= html_escape(json_encode($app)); ?>)" style="border-radius: 6px; font-weight: 700; padding: 4px 9px; font-size: 11px; margin-right: 4px;">
                                Move Stage
                            </button>
                            <button type="button" class="btn btn-xs btn-default" onclick="openCandidateDossier(<?= html_escape(json_encode($app)); ?>)" style="border-radius: 6px; font-weight: 700; padding: 4px 9px; font-size: 11px; color: #0284c7;">
                                Dossier
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- MODAL: ADVANCE CANDIDATE STAGE (Quick Switcher)                                           -->
<!-- ========================================================================================= -->
<div class="modal fade" id="moveStageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 18px 22px; border-bottom: none; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h4 class="modal-title" style="font-size: 16px; font-weight: 800; color: #ffffff; margin: 0;">
                        Advance Candidate Stage
                    </h4>
                    <small id="stageModalCandidateName" style="color: #2dd4bf; font-size: 12px;"></small>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; margin-top: -4px;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 20px; background: #ffffff;">
                <p style="font-size: 12px; color: #64748b; margin-bottom: 14px; font-weight: 600;">
                    Select target pipeline milestone:
                </p>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button type="button" onclick="selectStageAndUpdate('applied')" class="btn btn-default" style="text-align: left; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #0284c7;">
                        <span><i class="fa fa-inbox" style="color: #0284c7; width: 20px;"></i> 1. Applied</span>
                        <i class="fa fa-chevron-right" style="color: #cbd5e1; font-size: 11px;"></i>
                    </button>

                    <button type="button" onclick="selectStageAndUpdate('screened')" class="btn btn-default" style="text-align: left; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #7c3aed;">
                        <span><i class="fa fa-filter" style="color: #7c3aed; width: 20px;"></i> 2. Screened</span>
                        <i class="fa fa-chevron-right" style="color: #cbd5e1; font-size: 11px;"></i>
                    </button>

                    <button type="button" onclick="selectStageAndUpdate('interview_scheduled')" class="btn btn-default" style="text-align: left; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #d97706;">
                        <span><i class="fa fa-calendar" style="color: #d97706; width: 20px;"></i> 3. Interviewing</span>
                        <i class="fa fa-chevron-right" style="color: #cbd5e1; font-size: 11px;"></i>
                    </button>

                    <button type="button" onclick="selectStageAndUpdate('offered')" class="btn btn-default" style="text-align: left; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #16a34a;">
                        <span><i class="fa fa-handshake-o" style="color: #16a34a; width: 20px;"></i> 4. Offered</span>
                        <i class="fa fa-chevron-right" style="color: #cbd5e1; font-size: 11px;"></i>
                    </button>

                    <button type="button" onclick="selectStageAndUpdate('hired')" class="btn btn-default" style="text-align: left; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #00a896;">
                        <span><i class="fa fa-check-circle" style="color: #00a896; width: 20px;"></i> 5. Hired</span>
                        <i class="fa fa-chevron-right" style="color: #cbd5e1; font-size: 11px;"></i>
                    </button>

                    <div style="border-top: 1px dashed #e2e8f0; margin: 4px 0;"></div>

                    <button type="button" onclick="selectStageAndUpdate('rejected')" class="btn btn-default" style="text-align: left; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: space-between; color: #dc2626; border-left: 4px solid #dc2626;">
                        <span><i class="fa fa-times-circle" style="color: #dc2626; width: 20px;"></i> Reject Candidate</span>
                        <i class="fa fa-chevron-right" style="color: #fca5a5; font-size: 11px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- MODAL: POST / EDIT JOB OPENING                                                             -->
<!-- ========================================================================================= -->
<div class="modal fade" id="postJobModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 700px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 22px 28px; border-bottom: none; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 11px; font-weight: 800; color: #2dd4bf; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 2px;">
                        <i class="fa fa-briefcase"></i> Requisition Management
                    </div>
                    <h4 class="modal-title" id="jobModalTitle" style="font-size: 18px; font-weight: 800; color: #ffffff; margin: 0;">
                        Post New Job Opening
                    </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 26px; margin-top: -5px;">&times;</button>
            </div>

            <form action="<?= base_url('admin1947/hr/save_job'); ?>" method="POST">
                <input type="hidden" name="redirect_to" value="admin1947/hr/recruitment">
                <?php if (isset($this->security)): ?>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <?php endif; ?>
                
                <input type="hidden" name="job_id" id="modal_job_id" value="0">

                <div class="modal-body" style="padding: 26px 28px; background: #ffffff;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Job Position Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" id="modal_job_title" class="form-control" placeholder="e.g. Senior Pathology &amp; Lab Technician, BDE Lead" required style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Department <span style="color: #ef4444;">*</span></label>
                            <select name="department" id="modal_job_department" class="form-control" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                                <option value="Operations & Logistics">Operations &amp; Logistics</option>
                                <option value="Medical & Clinical">Medical &amp; Clinical</option>
                                <option value="Diagnostics & Lab">Diagnostics &amp; Lab</option>
                                <option value="Pharmacy">Pharmacy &amp; Medicines</option>
                                <option value="Sales & Growth">Sales, BDE &amp; Growth</option>
                                <option value="HR & Administration">HR &amp; Administration</option>
                                <option value="Technology & IT">Technology &amp; IT</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Employment Type</label>
                            <select name="job_type" id="modal_job_type" class="form-control" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                                <option value="Full Time">Full Time (Regular)</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Contractual">Contractual / Field</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Location</label>
                            <input type="text" name="location" id="modal_job_location" class="form-control" value="Lucknow, UP" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Openings Count</label>
                            <input type="number" name="openings" id="modal_job_openings" class="form-control" value="2" min="1" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Experience Required</label>
                            <input type="text" name="experience_required" id="modal_job_exp" class="form-control" placeholder="e.g. 1 - 3 Years" value="1 - 3 Years" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Salary Range</label>
                            <input type="text" name="salary_range" id="modal_job_salary" class="form-control" placeholder="e.g. ₹25,000 - ₹35,000 / mo" value="₹25,000 - ₹35,000 / mo" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Role Description</label>
                        <textarea name="description" id="modal_job_desc" class="form-control" rows="3" placeholder="Key responsibilities and shift deliverables..." style="border-radius: 8px; font-size: 12.5px; border: 1px solid #cbd5e1;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 28px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700; color: #64748b;">Cancel</button>
                    <button type="submit" class="btn" style="background: #00a896; color: #ffffff; border-radius: 8px; font-weight: 800; padding: 9px 24px; font-size: 13.5px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);">
                        <i class="fa fa-save"></i> Save Requisition
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- MODAL: ADD MANUAL CANDIDATE                                                               -->
<!-- ========================================================================================= -->
<div class="modal fade" id="addCandidateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document" style="max-width: 600px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: #0284c7; color: #ffffff; padding: 20px 26px; border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; margin-top: -4px;">&times;</button>
                <h4 class="modal-title" style="font-size: 17px; font-weight: 800; color: #ffffff; margin: 0;">
                    <i class="fa fa-user-plus"></i> Add Candidate to Pipeline
                </h4>
            </div>

            <form action="<?= base_url('admin1947/hr/save_candidate'); ?>" method="POST">
                <input type="hidden" name="redirect_to" value="admin1947/hr/recruitment">
                <?php if (isset($this->security)): ?>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <?php endif; ?>

                <div class="modal-body" style="padding: 24px 26px; background: #ffffff;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Candidate Full Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Anand Rathi" required style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Email Address <span style="color: #ef4444;">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="anand.rathi@gmail.com" required style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Mobile Phone <span style="color: #ef4444;">*</span></label>
                            <input type="tel" name="mobile" class="form-control" placeholder="9876543210" required style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Target Opening</label>
                            <select name="job_id" class="form-control" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                                <option value="0">-- General Application --</option>
                                <?php foreach($jobs as $j): ?>
                                    <option value="<?= $j['job_id']; ?>"><?= html_escape($j['title']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Initial Stage</label>
                            <select name="status_stage" class="form-control" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                                <option value="applied">1. Applied</option>
                                <option value="screened" selected>2. Screened</option>
                                <option value="interview_scheduled">3. Interviewing</option>
                                <option value="offered">4. Offered</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Highest Qualification</label>
                            <input type="text" name="qualification" class="form-control" placeholder="e.g. B.Sc MLT, B.Pharm" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Total Experience</label>
                            <input type="text" name="experience" class="form-control" placeholder="e.g. 2.5 Years" style="height: 42px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">HR Notes / Referral Details</label>
                        <textarea name="message" class="form-control" rows="2" placeholder="Notes or remarks..." style="border-radius: 8px; font-size: 12.5px; border: 1px solid #cbd5e1;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 26px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700; color: #64748b;">Cancel</button>
                    <button type="submit" class="btn" style="background: #0284c7; color: #ffffff; border-radius: 8px; font-weight: 800; padding: 9px 24px; font-size: 13px; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
                        <i class="fa fa-check"></i> Add to Pipeline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- MODAL: CANDIDATE DOSSIER DETAILS                                                          -->
<!-- ========================================================================================= -->
<div class="modal fade" id="candidateDossierModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document" style="max-width: 600px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 20px 24px; border-bottom: none; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div id="dossierAvatar" style="width: 44px; height: 44px; border-radius: 12px; background: #00a896; color: #fff; font-weight: 800; font-size: 18px; display: flex; align-items: center; justify-content: center;">
                        C
                    </div>
                    <div>
                        <h4 id="dossierName" style="font-size: 17px; font-weight: 800; color: #ffffff; margin: 0;"></h4>
                        <div id="dossierRole" style="font-size: 12px; color: #2dd4bf; margin-top: 2px;"></div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; margin-top: -4px;">&times;</button>
            </div>

            <div class="modal-body" style="padding: 24px; background: #ffffff;">
                <div style="background: #f8fafc; border-radius: 12px; padding: 12px 16px; border: 1px solid #e2e8f0; margin-bottom: 18px;">
                    <div style="font-size: 12.5px; color: #1e293b; font-weight: 700;">
                        <i class="fa fa-envelope-o" style="color: #00a896;"></i> <span id="dossierEmail"></span>
                    </div>
                    <div style="font-size: 12.5px; color: #1e293b; font-weight: 700; margin-top: 4px;">
                        <i class="fa fa-phone" style="color: #00a896;"></i> +91 <span id="dossierMobile"></span>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 16px;">
                    <div class="col-xs-6">
                        <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Highest Qualification</label>
                        <div id="dossierQualification" style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">--</div>
                    </div>
                    <div class="col-xs-6">
                        <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Work Experience</label>
                        <div id="dossierExperience" style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">--</div>
                    </div>
                </div>

                <div>
                    <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Cover Statement / Notes</label>
                    <div id="dossierMessage" style="font-size: 12.5px; color: #334155; line-height: 1.5; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 4px;">
                        --
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding: 14px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700; color: #64748b;">Close</button>
                <button type="button" id="btnDossierOnboard" class="btn" style="background: #00a896; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 8px 18px; font-size: 12px;">
                    ⚡ Onboard as Staff
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- MODAL: ONBOARD TO STAFF DIRECTORY                                                         -->
<!-- ========================================================================================= -->
<div class="modal fade" id="onboardStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document" style="max-width: 540px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: #00a896; color: #ffffff; padding: 20px 24px; border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; margin-top: -4px;">&times;</button>
                <h4 class="modal-title" style="font-size: 17px; font-weight: 800; color: #ffffff; margin: 0;">
                    <i class="fa fa-user-check"></i> Onboard Candidate to Staff Directory
                </h4>
            </div>

            <form action="<?= base_url('admin1947/hr/onboard_candidate'); ?>" method="POST">
                <input type="hidden" name="redirect_to" value="admin1947/hr/recruitment">
                <?php if (isset($this->security)): ?>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <?php endif; ?>
                
                <input type="hidden" name="career_id" id="onboard_career_id" value="0">

                <div class="modal-body" style="padding: 24px; background: #ffffff;">
                    <p style="color: #475569; font-size: 13px; margin-bottom: 16px;">
                        Convert <strong id="onboardCandidateName" style="color: #0f172a;"></strong> into an active enterprise employee.
                    </p>

                    <div class="row" style="margin-bottom: 14px;">
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">System Role *</label>
                            <select name="role" id="onboard_role" class="form-control" style="height: 40px; border-radius: 8px; font-size: 12.5px; font-weight: 600; border: 1px solid #cbd5e1;">
                                <option value="collector">Phlebotomist / Collector</option>
                                <option value="bde">Business Development (BDE)</option>
                                <option value="hr">HR &amp; People Lead</option>
                                <option value="office_staff" selected>Operations &amp; Staff</option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Department *</label>
                            <input type="text" name="department" id="onboard_department" class="form-control" value="Operations" style="height: 40px; border-radius: 8px; font-size: 12.5px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 14px;">
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Job Designation</label>
                            <input type="text" name="designation" id="onboard_designation" class="form-control" value="Specialist" style="height: 40px; border-radius: 8px; font-size: 12.5px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Base Salary (₹)</label>
                            <input type="number" name="base_salary" class="form-control" value="28000" style="height: 40px; border-radius: 8px; font-size: 12.5px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Assigned Base Area</label>
                            <input type="text" name="assigned_area" class="form-control" value="Lucknow Central Hub" style="height: 40px; border-radius: 8px; font-size: 12.5px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Default Password</label>
                            <input type="text" name="password" class="form-control" value="upchar@123" style="height: 40px; border-radius: 8px; font-size: 12.5px; font-weight: 600; border: 1px solid #cbd5e1;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 14px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700; color: #64748b;">Cancel</button>
                    <button type="submit" class="btn" style="background: #00a896; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 8px 20px;">
                        <i class="fa fa-check"></i> Confirm Onboard
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- JAVASCRIPT: DRAG & DROP ENGINE & KANBAN MONITOR SCRIPTS                                   -->
<!-- ========================================================================================= -->
<script>
var draggedCard = null;
var activeSelectedCandidate = null;
var isCompact = false;

// HTML5 Drag and Drop Handlers
function handleDragStart(e) {
    draggedCard = e.currentTarget;
    e.dataTransfer.setData('text/plain', $(draggedCard).data('career-id'));
    e.dataTransfer.effectAllowed = 'move';
    $(draggedCard).addClass('dragging');
}

function handleDragEnd(e) {
    if (draggedCard) {
        $(draggedCard).removeClass('dragging');
    }
    $('.ats-stage-col').removeClass('drag-over');
    draggedCard = null;
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
    $(e.currentTarget).addClass('drag-over');
}

function handleDragLeave(e) {
    $(e.currentTarget).removeClass('drag-over');
}

function handleDrop(e, targetStage) {
    e.preventDefault();
    $(e.currentTarget).removeClass('drag-over');
    
    if (!draggedCard) return;

    var careerId = $(draggedCard).data('career-id');
    var candName = $(draggedCard).data('candidate-name');
    var prevStage = $(draggedCard).data('current-stage');

    if (prevStage === targetStage) return;

    // Move Card in DOM (Optimistic Update)
    var $targetContainer = $('#scroll-container-' + targetStage);
    $targetContainer.find('.empty-column-msg').remove();
    $targetContainer.append(draggedCard);
    $(draggedCard).data('current-stage', targetStage);

    // Toggle onboard button visibility if target is offered/hired
    if (targetStage === 'offered' || targetStage === 'hired') {
        $(draggedCard).find('.onboard-btn-container').show();
    } else {
        $(draggedCard).find('.onboard-btn-container').hide();
    }

    // Recalculate Column Counters
    recalculateStageCounters();

    // Trigger Toast
    showToast('✓ ' + candName + ' moved to ' + targetStage.replace('_', ' ').toUpperCase());

    // Send Background AJAX Update
    updateStageSilent(careerId, targetStage);
}

// Recalculate Counters
function recalculateStageCounters() {
    $('.ats-stage-col').each(function() {
        var count = $(this).find('.ats-cand-card:visible').length;
        $(this).find('.column-count-badge').text(count);
    });
}

// Show Toast
function showToast(msg) {
    $('#atsToastMsg').text(msg);
    $('#atsLiveToast').fadeIn(200);
    setTimeout(function() {
        $('#atsLiveToast').fadeOut(400);
    }, 2800);
}

// Silent AJAX Update (No full page reload on drag & drop)
function updateStageSilent(careerId, stage) {
    $.ajax({
        url: '<?= base_url("admin1947/hr/update_candidate_stage"); ?>',
        type: 'POST',
        data: {
            career_id: careerId,
            status_stage: stage,
            ajax: 1
        },
        dataType: 'json',
        success: function(resp) {
            if (resp && resp.status === 'success') {
                // Success: update counters if needed
                recalculateStageCounters();
            } else if (resp && resp.message) {
                alert(resp.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Stage update error:', xhr.responseText, error);
            alert('Failed to save candidate stage update on server.');
        }
    });
}

// Toggle Density Mode
function toggleDensity() {
    isCompact = !isCompact;
    if (isCompact) {
        $('#atsKanbanBoard').addClass('compact-mode');
        $('#btnDensityToggle').html('<i class="fa fa-bars"></i> Comfortable Mode');
    } else {
        $('#atsKanbanBoard').removeClass('compact-mode');
        $('#btnDensityToggle').html('<i class="fa fa-th-large"></i> Compact Mode');
    }
}

// View Switcher (Kanban vs Table)
function switchView(mode) {
    if (mode === 'kanban') {
        $('#kanbanViewContainer').show();
        $('#tableViewContainer').hide();
        $('#btnViewKanban').css({'background': '#0f172a', 'color': '#ffffff'});
        $('#btnViewTable').css({'background': 'transparent', 'color': '#475569'});
    } else {
        $('#kanbanViewContainer').hide();
        $('#tableViewContainer').show();
        $('#btnViewTable').css({'background': '#0f172a', 'color': '#ffffff'});
        $('#btnViewKanban').css({'background': 'transparent', 'color': '#475569'});
    }
}

// Open Stage Selector Modal
function openStageModal(candidate) {
    activeSelectedCandidate = candidate;
    $('#stageModalCandidateName').text(candidate.name + ' (' + (candidate.job_title || candidate.designation || 'Applicant') + ')');
    $('#moveStageModal').modal('show');
}

function selectStageAndUpdate(stage) {
    if (!activeSelectedCandidate) return;
    $('#moveStageModal').modal('hide');
    updateStage(activeSelectedCandidate.career_id, stage);
}

// Open Job Create Modal
function openCreateJobModal() {
    $('#jobModalTitle').text('Post New Job Opening');
    $('#modal_job_id').val('0');
    $('#modal_job_title').val('');
    $('#modal_job_department').val('Operations & Logistics');
    $('#modal_job_type').val('Full Time');
    $('#modal_job_location').val('Lucknow, UP');
    $('#modal_job_openings').val('2');
    $('#modal_job_exp').val('1 - 3 Years');
    $('#modal_job_salary').val('₹25,000 - ₹35,000 / mo');
    $('#modal_job_desc').val('');
    $('#postJobModal').modal('show');
}

// Open Candidate Dossier
function openCandidateDossier(candidate) {
    var initial = (candidate.name || 'C').substring(0, 1).toUpperCase();
    $('#dossierAvatar').text(initial);
    $('#dossierName').text(candidate.name);
    $('#dossierRole').text(candidate.job_title || candidate.designation || 'General Application');
    $('#dossierEmail').text(candidate.email);
    $('#dossierMobile').text(candidate.mobile);
    $('#dossierQualification').text(candidate.qualification || 'Graduate');
    $('#dossierExperience').text(candidate.experience || '1-2 Years');
    $('#dossierMessage').text(candidate.message ? '"' + candidate.message + '"' : 'No statement provided.');
    
    $('#btnDossierOnboard').off('click').on('click', function() {
        $('#candidateDossierModal').modal('hide');
        openOnboardStaffModal(candidate);
    });

    $('#candidateDossierModal').modal('show');
}

// Open Onboard Staff Modal
function openOnboardStaffModal(candidate) {
    $('#onboard_career_id').val(candidate.career_id);
    $('#onboardCandidateName').text(candidate.name);
    $('#onboard_designation').val(candidate.job_title || candidate.designation || 'Specialist');
    $('#onboard_department').val(candidate.job_dept || 'Operations');
    
    var title = (candidate.job_title || candidate.designation || '').toLowerCase();
    if (title.indexOf('technician') > -1 || title.indexOf('phleb') > -1 || title.indexOf('nurse') > -1) {
        $('#onboard_role').val('collector');
    } else if (title.indexOf('bde') > -1 || title.indexOf('sales') > -1) {
        $('#onboard_role').val('bde');
    } else if (title.indexOf('hr') > -1) {
        $('#onboard_role').val('hr');
    } else {
        $('#onboard_role').val('office_staff');
    }

    $('#onboardStaffModal').modal('show');
}

// Standard Stage Update (Full Page Reload)
function updateStage(careerId, stage) {
    $.ajax({
        url: '<?= base_url("admin1947/hr/update_candidate_stage"); ?>',
        type: 'POST',
        data: {
            career_id: careerId,
            status_stage: stage,
            ajax: 1
        },
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                location.reload();
            } else {
                alert(resp.message || 'Failed to update stage');
            }
        },
        error: function(xhr, status, error) {
            console.error('Server error updating candidate stage:', xhr.responseText, error);
            alert('Server error updating candidate stage.');
        }
    });
}

// Search Filter
$(document).ready(function() {
    $('#candidateSearchInput').on('keyup', function() {
        var query = $(this).val().toLowerCase().trim();

        // Filter Kanban Cards
        $('.ats-cand-card').each(function() {
            var text = $(this).data('search-text') || '';
            if (query === '' || text.indexOf(query) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Filter Table Rows
        $('.table-candidate-row').each(function() {
            var text = $(this).data('search-text') || '';
            if (query === '' || text.indexOf(query) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        recalculateStageCounters();
    });
});

// CSV Export
function exportApplicantsCSV() {
    var csv = [];
    csv.push(['UPCHAR TALENT ACQUISITION - CANDIDATE PIPELINE EXPORT']);
    csv.push(['Candidate Name', 'Email', 'Mobile', 'Applied Position', 'Department', 'Qualification', 'Experience', 'ATS Stage', 'Date']);

    $('.table-candidate-row:visible').each(function() {
        var $r = $(this);
        var name  = $r.find('td:nth-child(1) strong').text().trim();
        var email = $r.find('td:nth-child(1) div').text().split('•')[0].trim();
        var phone = $r.find('td:nth-child(1) div').text().split('•')[1] ? $r.find('td:nth-child(1) div').text().split('•')[1].trim() : '';
        var role  = $r.find('td:nth-child(2) strong').text().trim();
        var dept  = $r.find('td:nth-child(2) div').text().trim();
        var qual  = $r.find('td:nth-child(3) div').text().trim();
        var exp   = $r.find('td:nth-child(3) small').text().trim();
        var date  = $r.find('td:nth-child(4)').text().trim();
        var stage = $r.find('td:nth-child(5) span').text().trim();

        csv.push([
            '"' + name + '"',
            '"' + email + '"',
            '"' + phone + '"',
            '"' + role + '"',
            '"' + dept + '"',
            '"' + qual + '"',
            '"' + exp + '"',
            '"' + stage + '"',
            '"' + date + '"'
        ]);
    });

    var csvContent = "data:text/csv;charset=utf-8," + csv.map(e => e.join(",")).join("\n");
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "Upchar_Candidates_Pipeline_" + new Date().toISOString().slice(0, 10) + ".csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
