<style>
@media (max-width: 768px) {
  .career-nav-tabs {
    flex-direction: column;
    align-items: stretch !important;
    gap: 8px;
    border-bottom: none !important;
  }
  .career-nav-tabs > a {
    width: 100%;
    justify-content: space-between;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px !important;
    border-bottom: 1px solid #e2e8f0 !important;
  }
  .career-nav-actions {
    margin-left: 0 !important;
    width: 100%;
    justify-content: stretch;
  }
  .career-nav-actions > * {
    flex: 1 1 auto;
    text-align: center;
  }
  .master-card-body {
    padding: 14px 10px !important;
  }
}
</style>
<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">
          <i class="fa fa-briefcase" style="color: #00a896; margin-right: 6px;"></i> Career & Recruitment Management
        </h1>
        <small style="color: #64748b; font-size: 13px;">Manage hospital job vacancies, candidate applications, hiring pipeline, and resumes</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/career')?>" style="color: #64748b;">Doctor & Staff</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Career Portal</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Toast Notification Container -->
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <!-- Recruitment Metrics Overview -->
      <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
          <div style="background: #fff; border-radius: 10px; padding: 16px 18px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div>
              <div style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">Total Applications</div>
              <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$stats['total_applications'] ?? 0?></div>
              <small style="color: #00a896; font-weight: 500; font-size: 11px;"><i class="fa fa-users"></i> All Candidates</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(0, 168, 150, 0.12); display: flex; align-items: center; justify-content: center; color: #00a896; font-size: 20px;">
              <i class="fa fa-id-card-o"></i>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
          <div style="background: #fff; border-radius: 10px; padding: 16px 18px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div>
              <div style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">Pending Review</div>
              <div style="font-size: 26px; font-weight: 800; color: #d97706; margin-top: 4px;"><?=$stats['pending'] ?? 0?></div>
              <small style="color: #b45309; font-weight: 500; font-size: 11px;"><i class="fa fa-clock-o"></i> Needs Attention</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(245, 158, 11, 0.12); display: flex; align-items: center; justify-content: center; color: #d97706; font-size: 20px;">
              <i class="fa fa-hourglass-half"></i>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
          <div style="background: #fff; border-radius: 10px; padding: 16px 18px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div>
              <div style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">Shortlisted / Interview</div>
              <div style="font-size: 26px; font-weight: 800; color: #2563eb; margin-top: 4px;"><?=($stats['shortlisted'] ?? 0) + ($stats['interview'] ?? 0)?></div>
              <small style="color: #1d4ed8; font-weight: 500; font-size: 11px;"><i class="fa fa-check-circle-o"></i> Active Pipeline</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(37, 99, 235, 0.12); display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 20px;">
              <i class="fa fa-calendar-check-o"></i>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
          <div style="background: #fff; border-radius: 10px; padding: 16px 18px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div>
              <div style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">Active Job Openings</div>
              <div style="font-size: 26px; font-weight: 800; color: #059669; margin-top: 4px;"><?=$stats['active_jobs'] ?? 0?> <span style="font-size: 14px; font-weight: 500; color: #64748b;">/ <?=$stats['total_jobs'] ?? 0?></span></div>
              <small style="color: #059669; font-weight: 500; font-size: 11px;"><i class="fa fa-bullhorn"></i> Live on Website</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(16, 185, 129, 0.12); display: flex; align-items: center; justify-content: center; color: #059669; font-size: 20px;">
              <i class="fa fa-hospital-o"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Navigation Tabs -->
      <div class="career-nav-tabs" style="display: flex; gap: 10px; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
        <a href="<?=base_url('doctor/career?tab=applications')?>" style="padding: 12px 20px; font-size: 14px; font-weight: 700; text-decoration: none; border-bottom: 3px solid <?=($active_tab == 'applications') ? '#00a896' : 'transparent'?>; color: <?=($active_tab == 'applications') ? '#00a896' : '#64748b'?>; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
          <i class="fa fa-file-text-o"></i> Candidate Applications
          <span style="background: <?=($active_tab == 'applications') ? '#00a896' : '#e2e8f0'?>; color: <?=($active_tab == 'applications') ? '#fff' : '#475569'?>; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
            <?=$stats['total_applications'] ?? 0?>
          </span>
        </a>

        <a href="<?=base_url('doctor/career?tab=jobs')?>" style="padding: 12px 20px; font-size: 14px; font-weight: 700; text-decoration: none; border-bottom: 3px solid <?=($active_tab == 'jobs') ? '#00a896' : 'transparent'?>; color: <?=($active_tab == 'jobs') ? '#00a896' : '#64748b'?>; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
          <i class="fa fa-briefcase"></i> Job Vacancies & Postings
          <span style="background: <?=($active_tab == 'jobs') ? '#00a896' : '#e2e8f0'?>; color: <?=($active_tab == 'jobs') ? '#fff' : '#475569'?>; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
            <?=$stats['total_jobs'] ?? 0?>
          </span>
        </a>

        <div class="career-nav-actions" style="margin-left: auto; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
          <a href="<?=base_url('Home/career')?>" target="_blank" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
            <i class="fa fa-external-link"></i> View Frontend Portal
          </a>
          <?php if($active_tab == 'jobs'): ?>
            <button type="button" class="btn btn-sm btn-success" id="btn-create-job" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600;">
              <i class="fa fa-plus"></i> Post New Job Opening
            </button>
          <?php else: ?>
            <a href="<?=base_url('doctor/career/export_applications')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #1e293b;">
              <i class="fa fa-download"></i> Export CSV
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- TAB 1: CANDIDATE APPLICATIONS -->
      <?php if ($active_tab == 'applications'): ?>
        <div class="master-card" style="background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
              <i class="fa fa-id-badge" style="color: #00a896;"></i>
              <span>Received Applications</span>
            </h3>
            <div style="display: flex; gap: 8px; align-items: center;">
              <button type="button" id="bulk-delete-career-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
                <i class="fa fa-trash"></i> Delete Selected (<span id="career-selected-count">0</span>)
              </button>
            </div>
          </div>

          <div class="master-card-body" style="padding: 20px;">
            <!-- Filter Toolbar -->
            <form action="<?=base_url('doctor/career')?>" method="get" id="search_form" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 18px;">
              <input type="hidden" name="tab" value="applications">

              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
                <div style="width: 85px;">
                  <?php echo display_record_per_page();?>
                </div>
              </div>

              <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
                <!-- Filter by Recruitment Stage -->
                <div style="width: 160px;">
                  <select name="stage" class="form-control input-sm" onchange="this.form.submit()" style="height: 34px; border-radius: 6px; font-size: 13px;">
                    <option value="">All Stages</option>
                    <option value="pending" <?=$this->input->get('stage') == 'pending' ? 'selected' : ''?>>Pending</option>
                    <option value="reviewing" <?=$this->input->get('stage') == 'reviewing' ? 'selected' : ''?>>Reviewing</option>
                    <option value="shortlisted" <?=$this->input->get('stage') == 'shortlisted' ? 'selected' : ''?>>Shortlisted</option>
                    <option value="interview" <?=$this->input->get('stage') == 'interview' ? 'selected' : ''?>>Interview</option>
                    <option value="selected" <?=$this->input->get('stage') == 'selected' ? 'selected' : ''?>>Selected</option>
                    <option value="rejected" <?=$this->input->get('stage') == 'rejected' ? 'selected' : ''?>>Rejected</option>
                  </select>
                </div>

                <!-- Filter by Job Opening -->
                <div style="width: 200px;">
                  <select name="job_id" class="form-control input-sm" onchange="this.form.submit()" style="height: 34px; border-radius: 6px; font-size: 13px;">
                    <option value="">All Job Openings</option>
                    <?php if(!empty($active_jobs)): foreach($active_jobs as $aj): ?>
                      <option value="<?=$aj['job_id']?>" <?=$this->input->get('job_id') == $aj['job_id'] ? 'selected' : ''?>><?=htmlspecialchars($aj['title'])?></option>
                    <?php endforeach; endif; ?>
                  </select>
                </div>

                <!-- Keyword Search -->
                <div style="width: 250px;">
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" class="form-control" name="keyword" placeholder="Search applicant, phone, role..." value="<?=htmlspecialchars($this->input->get_post('keyword') ?? '')?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                </div>

                <?php if($this->input->get('keyword') || $this->input->get('stage') || $this->input->get('job_id')): ?>
                  <a href="<?=base_url('doctor/career?tab=applications')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px;">
                    <i class="fa fa-times text-danger"></i> Clear
                  </a>
                <?php endif; ?>
              </div>
            </form>

            <!-- Table -->
            <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
              <table class="table table-hover table-striped" id="career-table" style="margin: 0;">
                <thead>
                  <tr style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                    <th style="width: 40px; text-align: center;">
                      <input type="checkbox" id="select-all-careers" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                    </th>
                    <th>Candidate Details</th>
                    <th>Role Applied / Vacancy</th>
                    <th>Qualification & Exp</th>
                    <th style="width: 90px; text-align: center;">Resume</th>
                    <th style="width: 140px; text-align: center;">Hiring Stage</th>
                    <th style="width: 100px; text-align: center;">Date</th>
                    <th style="width: 90px; text-align: center;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($career)): foreach($career as $val): 
                    $cid        = $val['career_id'];
                    $cname      = $val['name'];
                    $hasResume  = !empty($val['resume']);
                    $resumeUrl  = $hasResume ? base_url('admin1947/public/assets/document/'.$val['resume']) : '';
                    $roleName   = !empty($val['job_title']) ? $val['job_title'] : (!empty($val['designation']) ? $val['designation'] : 'General Application');
                    $deptName   = !empty($val['job_department']) ? $val['job_department'] : 'Clinical / Support';
                    $stage      = !empty($val['status_stage']) ? $val['status_stage'] : 'pending';
                  ?>
                    <tr id="row-<?=$cid;?>" style="vertical-align: middle;">
                      <td style="text-align: center; vertical-align: middle;">
                        <input type="checkbox" class="career-checkbox" value="<?=$cid;?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                      </td>
                      <td style="vertical-align: middle;">
                        <div style="font-weight: 700; color: #1e293b; font-size: 14px;"><?=$cname;?></div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                          <i class="fa fa-envelope-o" style="width: 14px;"></i> <?=htmlspecialchars($val['email']);?>
                        </div>
                        <div style="font-size: 12px; color: #00a896; font-weight: 600; margin-top: 2px;">
                          <i class="fa fa-phone" style="width: 14px;"></i> <?=htmlspecialchars($val['mobile']);?>
                        </div>
                      </td>
                      <td style="vertical-align: middle;">
                        <div style="font-weight: 600; color: #0f172a; font-size: 13px;"><?=htmlspecialchars($roleName);?></div>
                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 600; border-radius: 4px; padding: 3px 6px; margin-top: 4px; display: inline-block;">
                          <?=htmlspecialchars($deptName);?>
                        </span>
                      </td>
                      <td style="vertical-align: middle;">
                        <div style="font-size: 13px; color: #334155; font-weight: 500;">
                          <i class="fa fa-graduation-cap text-muted"></i> <?=htmlspecialchars($val['qualification'] ?: 'Not Specified');?>
                        </div>
                        <?php if(!empty($val['experience'])): ?>
                          <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                            <i class="fa fa-clock-o text-muted"></i> Exp: <?=htmlspecialchars($val['experience']);?>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td style="text-align: center; vertical-align: middle;">
                        <?php if($hasResume): ?>
                          <a href="<?=$resumeUrl;?>" target="_blank" class="btn btn-xs btn-default" title="Download / View Resume" style="color: #00a896; border-color: #00a896; border-radius: 4px; font-weight: 600; padding: 4px 8px;">
                            <i class="fa fa-file-pdf-o"></i> View
                          </a>
                        <?php else: ?>
                          <span style="color: #94a3b8; font-size: 12px; font-style: italic;">None</span>
                        <?php endif; ?>
                      </td>
                      <td style="text-align: center; vertical-align: middle;">
                        <select class="form-control input-sm stage-selector" data-id="<?=$cid;?>" style="height: 30px; border-radius: 6px; font-size: 12px; font-weight: 600; padding: 2px 6px; 
                          background-color: <?php 
                            switch($stage) {
                              case 'pending': echo '#fef3c7; color: #92400e;'; break;
                              case 'reviewing': echo '#e0f2fe; color: #075985;'; break;
                              case 'shortlisted': echo '#dbeafe; color: #1e40af;'; break;
                              case 'interview': echo '#f3e8ff; color: #6b21a8;'; break;
                              case 'selected': echo '#dcfce7; color: #166534;'; break;
                              case 'rejected': echo '#fee2e2; color: #991b1b;'; break;
                              default: echo '#f1f5f9; color: #475569;'; break;
                            }
                          ?>">
                          <option value="pending" <?=$stage=='pending'?'selected':'';?>>Pending</option>
                          <option value="reviewing" <?=$stage=='reviewing'?'selected':'';?>>Reviewing</option>
                          <option value="shortlisted" <?=$stage=='shortlisted'?'selected':'';?>>Shortlisted</option>
                          <option value="interview" <?=$stage=='interview'?'selected':'';?>>Interview</option>
                          <option value="selected" <?=$stage=='selected'?'selected':'';?>>Selected</option>
                          <option value="rejected" <?=$stage=='rejected'?'selected':'';?>>Rejected</option>
                        </select>
                      </td>
                      <td style="text-align: center; vertical-align: middle; font-size: 12px; color: #64748b;">
                        <?=date('d M Y', strtotime($val['creat_date']));?>
                      </td>
                      <td style="text-align: center; vertical-align: middle;">
                        <div class="btn-group">
                          <button type="button" class="btn btn-xs btn-info btn-view-candidate" data-id="<?=$cid;?>" title="View Full Details" style="border-radius: 4px; margin-right: 4px;">
                            <i class="fa fa-eye"></i>
                          </button>
                          <button type="button" class="btn btn-xs btn-danger btn-delete-single" data-id="<?=$cid;?>" data-name="<?=htmlspecialchars($cname);?>" title="Delete Application" style="border-radius: 4px;">
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="8" style="text-align: center; padding: 40px 20px;">
                        <div style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"><i class="fa fa-id-card-o"></i></div>
                        <h4 style="font-weight: 600; color: #64748b; margin: 0 0 5px;">No Candidate Applications Found</h4>
                        <p style="color: #94a3b8; font-size: 13px; margin: 0;">Try adjusting your search criteria or filter stage.</p>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <!-- Pagination Bar -->
            <?php if(!empty($page_links)): ?>
              <div style="margin-top: 15px; display: flex; justify-content: flex-end;">
                <?=$page_links;?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- TAB 2: JOB OPENINGS & VACANCIES -->
      <?php if ($active_tab == 'jobs'): ?>
        <div class="master-card" style="background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
              <i class="fa fa-bullhorn" style="color: #00a896;"></i>
              <span>Active Hospital Job Postings</span>
            </h3>
            <div>
              <button type="button" class="btn btn-sm btn-success btn-create-job-trigger" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600;">
                <i class="fa fa-plus"></i> Post New Job Opening
              </button>
            </div>
          </div>

          <div class="master-card-body" style="padding: 20px;">
            <!-- Jobs Filter Toolbar -->
            <form action="<?=base_url('doctor/career')?>" method="get" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 18px;">
              <input type="hidden" name="tab" value="jobs">

              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
                <div style="width: 85px;">
                  <?php echo display_record_per_page();?>
                </div>
              </div>

              <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
                <!-- Filter Status -->
                <div style="width: 140px;">
                  <select name="job_status" class="form-control input-sm" onchange="this.form.submit()" style="height: 34px; border-radius: 6px; font-size: 13px;">
                    <option value="">All Statuses</option>
                    <option value="active" <?=$this->input->get('job_status') == 'active' ? 'selected' : ''?>>Active (Open)</option>
                    <option value="closed" <?=$this->input->get('job_status') == 'closed' ? 'selected' : ''?>>Closed</option>
                  </select>
                </div>

                <!-- Filter Department -->
                <div style="width: 180px;">
                  <select name="job_dept" class="form-control input-sm" onchange="this.form.submit()" style="height: 34px; border-radius: 6px; font-size: 13px;">
                    <option value="">All Departments</option>
                    <option value="Medical & Clinical" <?=$this->input->get('job_dept') == 'Medical & Clinical' ? 'selected' : ''?>>Medical & Clinical</option>
                    <option value="Nursing" <?=$this->input->get('job_dept') == 'Nursing' ? 'selected' : ''?>>Nursing</option>
                    <option value="Diagnostics & Lab" <?=$this->input->get('job_dept') == 'Diagnostics & Lab' ? 'selected' : ''?>>Diagnostics & Lab</option>
                    <option value="Pharmacy" <?=$this->input->get('job_dept') == 'Pharmacy' ? 'selected' : ''?>>Pharmacy</option>
                    <option value="Operations & Admin" <?=$this->input->get('job_dept') == 'Operations & Admin' ? 'selected' : ''?>>Operations & Admin</option>
                    <option value="Technology & IT" <?=$this->input->get('job_dept') == 'Technology & IT' ? 'selected' : ''?>>Technology & IT</option>
                  </select>
                </div>

                <!-- Keyword -->
                <div style="width: 240px;">
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" class="form-control" name="job_keyword" placeholder="Search job title, skills..." value="<?=htmlspecialchars($this->input->get_post('job_keyword') ?? '')?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                </div>

                <?php if($this->input->get('job_keyword') || $this->input->get('job_status') || $this->input->get('job_dept')): ?>
                  <a href="<?=base_url('doctor/career?tab=jobs')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px;">
                    <i class="fa fa-times text-danger"></i> Clear
                  </a>
                <?php endif; ?>
              </div>
            </form>

            <!-- Jobs Table -->
            <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
              <table class="table table-hover table-striped" style="margin: 0;">
                <thead>
                  <tr style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                    <th style="width: 50px; text-align: center;">#</th>
                    <th>Role Title & Department</th>
                    <th>Job Type & Location</th>
                    <th>Experience & Openings</th>
                    <th>Salary Range</th>
                    <th style="width: 110px; text-align: center;">Applicants</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($jobs)): foreach($jobs as $job): 
                    $jid = $job['job_id'];
                    $isActive = ($job['status'] == 'active');
                  ?>
                    <tr id="job-row-<?=$jid?>" style="vertical-align: middle;">
                      <td style="text-align: center; vertical-align: middle; color: #94a3b8; font-weight: 600;">
                        <?=$jid;?>
                      </td>
                      <td style="vertical-align: middle;">
                        <div style="font-weight: 700; color: #1e293b; font-size: 14px;">
                          <?=htmlspecialchars($job['title']);?>
                        </div>
                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 600; border-radius: 4px; padding: 3px 6px; margin-top: 4px; display: inline-block;">
                          <?=htmlspecialchars($job['department']);?>
                        </span>
                      </td>
                      <td style="vertical-align: middle;">
                        <div style="font-size: 13px; color: #334155; font-weight: 600;">
                          <i class="fa fa-clock-o text-muted"></i> <?=htmlspecialchars($job['job_type']);?>
                        </div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                          <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($job['location']);?>
                        </div>
                      </td>
                      <td style="vertical-align: middle;">
                        <div style="font-size: 13px; color: #334155;">
                          <i class="fa fa-briefcase text-muted"></i> <?=htmlspecialchars($job['experience_required']);?>
                        </div>
                        <div style="font-size: 12px; color: #00a896; font-weight: 600; margin-top: 2px;">
                          <i class="fa fa-user-plus"></i> <?=$job['openings'];?> Opening(s)
                        </div>
                      </td>
                      <td style="vertical-align: middle; font-size: 13px; font-weight: 600; color: #0f172a;">
                        <?=htmlspecialchars($job['salary_range']);?>
                      </td>
                      <td style="text-align: center; vertical-align: middle;">
                        <a href="<?=base_url('doctor/career?tab=applications&job_id='.$jid)?>" class="badge" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; font-size: 12px; padding: 5px 10px; border-radius: 12px; text-decoration: none; font-weight: 700;">
                          <i class="fa fa-users text-primary"></i> <?=$job['applicant_count'];?> candidates
                        </a>
                      </td>
                      <td style="text-align: center; vertical-align: middle;">
                        <button type="button" class="btn btn-xs btn-toggle-job-status" data-id="<?=$jid;?>" style="border-radius: 12px; font-weight: 700; padding: 4px 10px; <?=$isActive ? 'background: #dcfce7; color: #166534; border: 1px solid #86efac;' : 'background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;'?>">
                          <?=$isActive ? '<i class="fa fa-check-circle"></i> Active' : '<i class="fa fa-ban"></i> Closed';?>
                        </button>
                      </td>
                      <td style="text-align: center; vertical-align: middle;">
                        <div class="btn-group">
                          <button type="button" class="btn btn-xs btn-warning btn-edit-job" data-id="<?=$jid;?>" title="Edit Opening" style="border-radius: 4px; margin-right: 4px; background: #f59e0b; border-color: #f59e0b; color: #fff;">
                            <i class="fa fa-pencil"></i>
                          </button>
                          <button type="button" class="btn btn-xs btn-danger btn-delete-job" data-id="<?=$jid;?>" data-title="<?=htmlspecialchars($job['title']);?>" title="Delete Opening" style="border-radius: 4px;">
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="8" style="text-align: center; padding: 40px 20px;">
                        <div style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"><i class="fa fa-briefcase"></i></div>
                        <h4 style="font-weight: 600; color: #64748b; margin: 0 0 5px;">No Job Openings Found</h4>
                        <p style="color: #94a3b8; font-size: 13px; margin: 0 0 15px;">Create your first vacancy to start receiving qualified candidates.</p>
                        <button type="button" class="btn btn-sm btn-success btn-create-job-trigger" style="background: #00a896; border-color: #00a896; border-radius: 6px;">
                          <i class="fa fa-plus"></i> Post Job Opening
                        </button>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <!-- Pagination Bar -->
            <?php if(!empty($page_links)): ?>
              <div style="margin-top: 15px; display: flex; justify-content: flex-end;">
                <?=$page_links;?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </section>
</div>

<!-- ============================================== -->
<!-- MODAL 1: VIEW CANDIDATE APPLICATION DETAILS -->
<!-- ============================================== -->
<div class="modal fade" id="candidateDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);">
      <div class="modal-header" style="background: #00a896; color: #fff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
        <h4 class="modal-title" style="font-weight: 700; font-size: 18px; margin: 0;">
          <i class="fa fa-user-circle-o" style="margin-right: 8px;"></i> Candidate Application Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9; font-size: 24px; margin-top: -5px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 24px;">
        <div id="candidate-modal-loading" style="text-align: center; padding: 40px;">
          <i class="fa fa-spinner fa-spin fa-2x" style="color: #00a896;"></i>
          <p style="margin-top: 10px; color: #64748b;">Loading candidate profile...</p>
        </div>
        <div id="candidate-modal-content" style="display: none;">
          <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700;">
              <span id="modal-candidate-avatar">U</span>
            </div>
            <div style="flex-grow: 1;">
              <h3 id="modal-candidate-name" style="margin: 0 0 4px; font-size: 20px; font-weight: 800; color: #0f172a;">Candidate Name</h3>
              <div style="display: flex; gap: 15px; flex-wrap: wrap; font-size: 13px; color: #64748b;">
                <span><i class="fa fa-envelope-o" style="color: #00a896;"></i> <span id="modal-candidate-email">email@example.com</span></span>
                <span><i class="fa fa-phone" style="color: #00a896;"></i> <span id="modal-candidate-mobile">+91 0000000000</span></span>
                <span><i class="fa fa-calendar" style="color: #00a896;"></i> Applied: <span id="modal-candidate-date">2026-09-07</span></span>
              </div>
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #64748b; display: block; margin-bottom: 4px;">Recruitment Stage:</label>
              <select id="modal-stage-select" class="form-control input-sm" style="width: 140px; border-radius: 6px; font-weight: 700;">
                <option value="pending">Pending</option>
                <option value="reviewing">Reviewing</option>
                <option value="shortlisted">Shortlisted</option>
                <option value="interview">Interview</option>
                <option value="selected">Selected</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
          </div>

          <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6" style="margin-bottom: 15px;">
              <div style="background: #f8fafc; padding: 14px 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">Applied Position</div>
                <div id="modal-candidate-role" style="font-size: 15px; font-weight: 700; color: #1e293b; margin-top: 4px;">Staff Nurse</div>
                <div id="modal-candidate-dept" style="font-size: 12px; color: #0284c7; font-weight: 600; margin-top: 2px;">Nursing Department</div>
              </div>
            </div>
            <div class="col-md-6" style="margin-bottom: 15px;">
              <div style="background: #f8fafc; padding: 14px 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">Education & Experience</div>
                <div id="modal-candidate-qual" style="font-size: 14px; font-weight: 600; color: #1e293b; margin-top: 4px;">B.Sc Nursing</div>
                <div id="modal-candidate-exp" style="font-size: 12px; color: #475569; margin-top: 2px;">Experience: 2 Years</div>
              </div>
            </div>
          </div>

          <div style="margin-bottom: 20px;">
            <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Cover Letter / Candidate Message:</label>
            <div id="modal-candidate-message" style="background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px; color: #334155; line-height: 1.6; max-height: 160px; overflow-y: auto; white-space: pre-wrap;">
              No cover message provided.
            </div>
          </div>

          <div id="modal-candidate-resume-box" style="background: #eff6ff; padding: 14px 18px; border-radius: 8px; border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
              <i class="fa fa-file-pdf-o" style="font-size: 28px; color: #2563eb;"></i>
              <div>
                <div style="font-weight: 700; color: #1e3a8a; font-size: 14px;">Candidate Resume / Curriculum Vitae</div>
                <small id="modal-resume-filename" style="color: #60a5fa;">resume.pdf</small>
              </div>
            </div>
            <a href="#" id="modal-resume-download-btn" target="_blank" class="btn btn-sm btn-primary" style="background: #2563eb; border-color: #2563eb; border-radius: 6px; font-weight: 600;">
              <i class="fa fa-download"></i> View / Download Resume
            </a>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px; display: flex; justify-content: space-between;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Close</button>
        <button type="button" id="btn-save-modal-stage" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600;">
          <i class="fa fa-check"></i> Save Recruitment Status
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================== -->
<!-- MODAL 2: CREATE / EDIT JOB OPENING -->
<!-- ============================================== -->
<div class="modal fade" id="jobFormModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);">
      <form id="jobForm" action="<?=base_url('doctor/career/save_job')?>" method="post">
        <input type="hidden" name="job_id" id="form-job-id" value="">
        <input type="hidden" name="is_ajax" value="1">

        <div class="modal-header" style="background: #00a896; color: #fff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
          <h4 class="modal-title" id="jobModalTitle" style="font-weight: 700; font-size: 18px; margin: 0;">
            <i class="fa fa-plus-circle" style="margin-right: 8px;"></i> Post New Job Opening
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9; font-size: 24px; margin-top: -5px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body" style="padding: 24px;">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Job Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="job-title" class="form-control" placeholder="e.g. Duty Medical Officer (MBBS)" required style="border-radius: 6px; height: 38px;">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Department <span class="text-danger">*</span></label>
                <select name="department" id="job-department" class="form-control" required style="border-radius: 6px; height: 38px;">
                  <option value="">Select Department</option>
                  <option value="Medical & Clinical">Medical & Clinical</option>
                  <option value="Nursing">Nursing</option>
                  <option value="Diagnostics & Lab">Diagnostics & Lab</option>
                  <option value="Pharmacy">Pharmacy</option>
                  <option value="Operations & Admin">Operations & Admin</option>
                  <option value="Technology & IT">Technology & IT</option>
                  <option value="Sales & Marketing">Sales & Marketing</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Job Type</label>
                <select name="job_type" id="job-type" class="form-control" style="border-radius: 6px; height: 38px;">
                  <option value="Full Time">Full Time</option>
                  <option value="Part Time">Part Time</option>
                  <option value="Contract">Contract</option>
                  <option value="Locum / Consultant">Locum / Consultant</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Location</label>
                <input type="text" name="location" id="job-location" class="form-control" value="Gorakhpur, UP" style="border-radius: 6px; height: 38px;">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Experience Required</label>
                <input type="text" name="experience_required" id="job-experience" class="form-control" placeholder="e.g. 1-3 Years" value="1-3 Years" style="border-radius: 6px; height: 38px;">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Number of Openings</label>
                <input type="number" name="openings" id="job-openings" class="form-control" value="1" min="1" style="border-radius: 6px; height: 38px;">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Salary / Compensation Range</label>
                <input type="text" name="salary_range" id="job-salary" class="form-control" placeholder="e.g. ₹25,000 - ₹40,000 / mo" value="Best in Industry" style="border-radius: 6px; height: 38px;">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Status</label>
                <select name="status" id="job-status" class="form-control" style="border-radius: 6px; height: 38px;">
                  <option value="active">Active (Open)</option>
                  <option value="closed">Closed</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label style="font-weight: 600; color: #334155; font-size: 13px;">Job Role & Description</label>
            <textarea name="description" id="job-description" class="form-control" rows="3" placeholder="Key responsibilities, day-to-day duties, and hospital department overview..." style="border-radius: 6px;"></textarea>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label style="font-weight: 600; color: #334155; font-size: 13px;">Candidate Qualifications & Key Requirements</label>
            <textarea name="requirements" id="job-requirements" class="form-control" rows="3" placeholder="Required degrees, licenses/registrations, clinical competencies, soft skills..." style="border-radius: 6px;"></textarea>
          </div>
        </div>

        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Cancel</button>
          <button type="submit" id="btn-submit-job" class="btn btn-success" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600;">
            <i class="fa fa-save"></i> Save Job Opening
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================== -->
<!-- MODAL 3: DELETE CONFIRMATION -->
<!-- ============================================== -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);">
      <div class="modal-body" style="padding: 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #0f172a; margin: 0 0 8px;">Confirm Deletion</h4>
        <p id="delete-confirm-text" style="color: #64748b; font-size: 13px; margin: 0;">Are you sure you want to delete this record? This action cannot be undone.</p>
      </div>
      <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px; display: flex; justify-content: space-between;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Cancel</button>
        <button type="button" id="btn-execute-delete" class="btn btn-danger" style="border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
          Delete Now
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var activeDeleteAction = null;
  var currentViewingCandidateId = null;

  function showToast(message, type) {
    type = type || 'success';
    var bg = (type === 'success') ? '#059669' : ((type === 'danger' || type === 'error') ? '#dc2626' : '#d97706');
    var icon = (type === 'success') ? 'fa-check-circle' : ((type === 'danger' || type === 'error') ? 'fa-exclamation-circle' : 'fa-info-circle');

    var toastHtml = '<div class="custom-toast" style="background: ' + bg + '; color: #fff; padding: 12px 18px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 10px; pointer-events: auto; animation: slideIn 0.3s ease-out;">' +
      '<i class="fa ' + icon + '" style="font-size: 16px;"></i>' +
      '<span>' + message + '</span>' +
    '</div>';

    var $toast = $(toastHtml);
    $('#toast-container').append($toast);
    setTimeout(function() {
      $toast.fadeOut(300, function() { $(this).remove(); });
    }, 3500);
  }

  // Checkbox management for bulk candidate deletion
  function updateBulkDeleteState() {
    var checkedCount = $('.career-checkbox:checked').length;
    $('#career-selected-count').text(checkedCount);
    if (checkedCount > 0) {
      $('#bulk-delete-career-btn').fadeIn(150);
    } else {
      $('#bulk-delete-career-btn').fadeOut(150);
    }
  }

  $('#select-all-careers').on('change', function() {
    $('.career-checkbox').prop('checked', $(this).prop('checked'));
    updateBulkDeleteState();
  });

  $(document).on('change', '.career-checkbox', function() {
    var allChecked = ($('.career-checkbox:checked').length === $('.career-checkbox').length);
    $('#select-all-careers').prop('checked', allChecked);
    updateBulkDeleteState();
  });

  // Bulk Delete Candidates
  $('#bulk-delete-career-btn').on('click', function() {
    var selectedIds = [];
    $('.career-checkbox:checked').each(function() {
      selectedIds.push($(this).val());
    });
    if (selectedIds.length === 0) return;

    $('#delete-confirm-text').text('Are you sure you want to permanently delete ' + selectedIds.length + ' selected candidate applications?');
    activeDeleteAction = function() {
      $.ajax({
        url: '<?=base_url("doctor/career/bulk_delete")?>',
        type: 'POST',
        data: { ids: selectedIds, is_ajax: 1 },
        dataType: 'json',
        success: function(res) {
          $('#deleteConfirmModal').modal('hide');
          if (res.status == 1) {
            showToast(res.message, 'success');
            selectedIds.forEach(function(id) {
              $('#row-' + id).fadeOut(300, function() { $(this).remove(); });
            });
            $('#select-all-careers').prop('checked', false);
            updateBulkDeleteState();
          } else {
            showToast(res.message || 'Deletion failed', 'danger');
          }
        },
        error: function() {
          $('#deleteConfirmModal').modal('hide');
          showToast('Server error during deletion', 'danger');
        }
      });
    };
    $('#deleteConfirmModal').modal('show');
  });

  // Single Candidate Delete
  $(document).on('click', '.btn-delete-single', function() {
    var cid = $(this).data('id');
    var cname = $(this).data('name');

    $('#delete-confirm-text').text('Are you sure you want to delete application from ' + cname + '?');
    activeDeleteAction = function() {
      $.ajax({
        url: '<?=base_url("doctor/career/delete")?>',
        type: 'POST',
        data: { id: cid, is_ajax: 1 },
        dataType: 'json',
        success: function(res) {
          $('#deleteConfirmModal').modal('hide');
          if (res.status == 1) {
            showToast(res.message, 'success');
            $('#row-' + cid).fadeOut(300, function() { $(this).remove(); });
            updateBulkDeleteState();
          } else {
            showToast(res.message || 'Deletion failed', 'danger');
          }
        },
        error: function() {
          $('#deleteConfirmModal').modal('hide');
          showToast('Server error during deletion', 'danger');
        }
      });
    };
    $('#deleteConfirmModal').modal('show');
  });

  // Stage Selector Dropdown Change in Table
  $(document).on('change', '.stage-selector', function() {
    var $select = $(this);
    var cid = $select.data('id');
    var stage = $select.val();

    $.ajax({
      url: '<?=base_url("doctor/career/update_status")?>',
      type: 'POST',
      data: { id: cid, stage: stage },
      dataType: 'json',
      success: function(res) {
        if (res.status == 1) {
          showToast(res.message, 'success');
          // Update colors dynamically
          var colorStyle = {
            'pending': { bg: '#fef3c7', text: '#92400e' },
            'reviewing': { bg: '#e0f2fe', text: '#075985' },
            'shortlisted': { bg: '#dbeafe', text: '#1e40af' },
            'interview': { bg: '#f3e8ff', text: '#6b21a8' },
            'selected': { bg: '#dcfce7', text: '#166534' },
            'rejected': { bg: '#fee2e2', text: '#991b1b' }
          };
          var c = colorStyle[stage] || { bg: '#f1f5f9', text: '#475569' };
          $select.css({ 'background-color': c.bg, 'color': c.text });
        } else {
          showToast(res.message || 'Update failed', 'danger');
        }
      },
      error: function() {
        showToast('Error updating recruitment stage', 'danger');
      }
    });
  });

  // View Candidate Details Modal
  $(document).on('click', '.btn-view-candidate', function() {
    var cid = $(this).data('id');
    currentViewingCandidateId = cid;

    $('#candidate-modal-loading').show();
    $('#candidate-modal-content').hide();
    $('#candidateDetailsModal').modal('show');

    $.ajax({
      url: '<?=base_url("doctor/career/view_applicant")?>',
      type: 'GET',
      data: { id: cid },
      dataType: 'json',
      success: function(res) {
        $('#candidate-modal-loading').hide();
        if (res.status == 1 && res.data) {
          var d = res.data;
          $('#modal-candidate-name').text(d.name || 'Anonymous');
          $('#modal-candidate-avatar').text((d.name || 'U').charAt(0).toUpperCase());
          $('#modal-candidate-email').text(d.email || 'N/A');
          $('#modal-candidate-mobile').text(d.mobile || 'N/A');
          $('#modal-candidate-date').text(d.creat_date || '');
          $('#modal-candidate-role').text(d.job_title || d.designation || 'General Application');
          $('#modal-candidate-dept').text(d.job_department || 'General Healthcare');
          $('#modal-candidate-qual').text(d.qualification || 'Not Specified');
          $('#modal-candidate-exp').text(d.experience ? 'Experience: ' + d.experience : 'Experience: Not Specified');
          $('#modal-candidate-message').text(d.message || 'No cover letter or message submitted.');

          var stage = d.status_stage || 'pending';
          $('#modal-stage-select').val(stage);

          if (d.resume && d.resume_url) {
            $('#modal-candidate-resume-box').show();
            $('#modal-resume-filename').text(d.resume);
            $('#modal-resume-download-btn').attr('href', d.resume_url);
          } else {
            $('#modal-candidate-resume-box').hide();
          }

          $('#candidate-modal-content').fadeIn(200);
        } else {
          showToast('Failed to load candidate information', 'danger');
        }
      },
      error: function() {
        $('#candidate-modal-loading').hide();
        showToast('Network error loading candidate profile', 'danger');
      }
    });
  });

  // Save Recruitment Stage from Candidate Modal
  $('#btn-save-modal-stage').on('click', function() {
    if (!currentViewingCandidateId) return;
    var stage = $('#modal-stage-select').val();

    $.ajax({
      url: '<?=base_url("doctor/career/update_status")?>',
      type: 'POST',
      data: { id: currentViewingCandidateId, stage: stage },
      dataType: 'json',
      success: function(res) {
        if (res.status == 1) {
          showToast(res.message, 'success');
          // Reflect back to table row dropdown
          var $rowSelect = $('#row-' + currentViewingCandidateId).find('.stage-selector');
          if ($rowSelect.length) {
            $rowSelect.val(stage).trigger('change');
          }
          $('#candidateDetailsModal').modal('hide');
        } else {
          showToast(res.message || 'Failed to update stage', 'danger');
        }
      }
    });
  });

  // ==============================================
  // JOB OPENINGS MANAGEMENT (TAB 2)
  // ==============================================

  // Open Create Job Modal
  $('.btn-create-job-trigger, #btn-create-job').on('click', function() {
    $('#jobForm')[0].reset();
    $('#form-job-id').val('');
    $('#jobModalTitle').html('<i class="fa fa-plus-circle"></i> Post New Job Opening');
    $('#job-status').val('active');
    $('#job-location').val('Gorakhpur, UP');
    $('#job-openings').val(1);
    $('#job-salary').val('Best in Industry');
    $('#job-experience').val('1-3 Years');
    $('#jobFormModal').modal('show');
  });

  // Open Edit Job Modal
  $(document).on('click', '.btn-edit-job', function() {
    var jid = $(this).data('id');
    $.ajax({
      url: '<?=base_url("doctor/career/get_job")?>',
      type: 'GET',
      data: { id: jid },
      dataType: 'json',
      success: function(res) {
        if (res.status == 1 && res.data) {
          var j = res.data;
          $('#form-job-id').val(j.job_id);
          $('#job-title').val(j.title);
          $('#job-department').val(j.department);
          $('#job-type').val(j.job_type);
          $('#job-location').val(j.location);
          $('#job-experience').val(j.experience_required);
          $('#job-openings').val(j.openings);
          $('#job-salary').val(j.salary_range);
          $('#job-status').val(j.status);
          $('#job-description').val(j.description);
          $('#job-requirements').val(j.requirements);

          $('#jobModalTitle').html('<i class="fa fa-pencil-square-o"></i> Edit Job Opening: ' + j.title);
          $('#jobFormModal').modal('show');
        } else {
          showToast(res.message || 'Job opening not found', 'danger');
        }
      },
      error: function() {
        showToast('Error loading job details', 'danger');
      }
    });
  });

  // Save Job Opening Form Submit (AJAX)
  $('#jobForm').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(res) {
        if (res.status == 1) {
          showToast(res.message, 'success');
          $('#jobFormModal').modal('hide');
          setTimeout(function() {
            window.location = '<?=base_url("doctor/career?tab=jobs")?>';
          }, 800);
        } else {
          showToast(res.message || 'Failed to save job opening', 'danger');
        }
      },
      error: function() {
        showToast('Server error saving job vacancy', 'danger');
      }
    });
  });

  // Toggle Job Status (Active / Closed)
  $(document).on('click', '.btn-toggle-job-status', function() {
    var $btn = $(this);
    var jid = $btn.data('id');

    $.ajax({
      url: '<?=base_url("doctor/career/toggle_job_status")?>',
      type: 'POST',
      data: { id: jid, is_ajax: 1 },
      dataType: 'json',
      success: function(res) {
        if (res.status == 1) {
          showToast(res.message, 'success');
          if (res.new_status === 'active') {
            $btn.html('<i class="fa fa-check-circle"></i> Active')
                .css({ 'background': '#dcfce7', 'color': '#166534', 'border': '1px solid #86efac' });
          } else {
            $btn.html('<i class="fa fa-ban"></i> Closed')
                .css({ 'background': '#fee2e2', 'color': '#991b1b', 'border': '1px solid #fca5a5' });
          }
        } else {
          showToast(res.message || 'Failed to toggle status', 'danger');
        }
      },
      error: function() {
        showToast('Server error updating status', 'danger');
      }
    });
  });

  // Delete Job Opening
  $(document).on('click', '.btn-delete-job', function() {
    var jid = $(this).data('id');
    var jtitle = $(this).data('title');

    $('#delete-confirm-text').text('Are you sure you want to delete job opening "' + jtitle + '"?');
    activeDeleteAction = function() {
      $.ajax({
        url: '<?=base_url("doctor/career/delete_job")?>',
        type: 'POST',
        data: { id: jid, is_ajax: 1 },
        dataType: 'json',
        success: function(res) {
          $('#deleteConfirmModal').modal('hide');
          if (res.status == 1) {
            showToast(res.message, 'success');
            $('#job-row-' + jid).fadeOut(300, function() { $(this).remove(); });
          } else {
            showToast(res.message || 'Deletion failed', 'danger');
          }
        },
        error: function() {
          $('#deleteConfirmModal').modal('hide');
          showToast('Server error deleting job', 'danger');
        }
      });
    };
    $('#deleteConfirmModal').modal('show');
  });

  // Execute Confirmed Delete Action
  $('#btn-execute-delete').on('click', function() {
    if (typeof activeDeleteAction === 'function') {
      activeDeleteAction();
    }
  });

});
</script>