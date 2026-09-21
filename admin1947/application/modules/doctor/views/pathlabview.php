<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Pathology Labs Directory &amp; Onboarding</h1>
        <small style="color: #64748b; font-size: 13px;">Manage diagnostic partners, provision access credentials, and audit lab governance</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('doctor/pathology/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Pathology Dashboard</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Partner Labs</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Toast Notification Container -->
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <!-- Quick Status Filter KPI Badges -->
      <div class="row" style="margin: 0 -6px 16px;">
        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/pathlabreg/index')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='') ? '#00a896' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-flask"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">All Partner Labs</div>
                  <div style="font-size: 16px; font-weight: 800; color: #0f172a;"><?=number_format($total_count ?? 0);?></div>
                </div>
              </div>
              <?php if($this->input->get_post('status_filter')==''): ?>
                <span class="badge" style="background: #00a896; font-size: 10px;">Active View</span>
              <?php endif; ?>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/pathlabreg/index?status_filter=approved'.($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered') ? '#10b981' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-check-circle"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #15803d; text-transform: uppercase;">Approved &amp; Verified</div>
                  <div style="font-size: 16px; font-weight: 800; color: #16a34a;"><?=number_format($approved_count ?? 0);?></div>
                </div>
              </div>
              <?php if($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered'): ?>
                <span class="badge" style="background: #10b981; font-size: 10px;">Active View</span>
              <?php endif; ?>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/pathlabreg/index?status_filter=pending'.($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='pending'||$this->input->get_post('status_filter')=='pending_verification') ? '#f59e0b' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-clock-o"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #b45309; text-transform: uppercase;">Pending Verification</div>
                  <div style="font-size: 16px; font-weight: 800; color: #d97706;"><?=number_format($pending_count ?? 0);?></div>
                </div>
              </div>
              <?php if($this->input->get_post('status_filter')=='pending'||$this->input->get_post('status_filter')=='pending_verification'): ?>
                <span class="badge" style="background: #f59e0b; font-size: 10px;">Active View</span>
              <?php endif; ?>
            </div>
          </a>
        </div>
      </div>

      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
          <h3 class="master-card-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-flask" style="color: #00a896;"></i>
            <span>Registered Pathology Labs Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <button type="button" id="bulk-delete-pathlab-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="pathlab-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/pathology/dashboard')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
              <i class="fa fa-dashboard"></i> Dashboard
            </a>
            <a href="<?=base_url('doctor/pathology/audit_logs')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
              <i class="fa fa-history"></i> Audit Trail
            </a>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-pathlab" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
              <i class="fa fa-plus-circle"></i> Add Lab &amp; Provision Credentials
            </button>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter & Search Toolbar -->
          <form action="<?=base_url('doctor/pathlabreg/index')?>" method="get" id="search_form" class="master-toolbar" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <!-- Registration / Verification Status Filter -->
              <div style="min-width: 175px;">
                <select class="form-control input-sm" name="status_filter" id="status_filter" onchange="$('#search_form').submit();" style="height: 34px; border-radius: 6px; font-weight: 600;">
                  <option value="">-- All Verification States --</option>
                  <option value="approved" <?=($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered') ? 'selected' : ''?>>Approved &amp; Verified</option>
                  <option value="pending" <?=($this->input->get_post('status_filter')=='pending'||$this->input->get_post('status_filter')=='pending_verification') ? 'selected' : ''?>>Pending Verification</option>
                  <option value="pending_approval" <?=($this->input->get_post('status_filter')=='pending_approval') ? 'selected' : ''?>>Pending Approval Only</option>
                  <option value="unverified" <?=($this->input->get_post('status_filter')=='unverified') ? 'selected' : ''?>>Unverified Only</option>
                </select>
              </div>

              <!-- Keyword Search Box -->
              <div style="position: relative; width: 260px;">
                <input type="text" class="form-control input-sm" name="keyword" id="keyword" placeholder="Search by name, email, phone, city..." value="<?=htmlspecialchars($this->input->get_post('keyword') ?? '')?>" style="height: 34px; border-radius: 6px; padding-right: 32px;">
                <button type="submit" style="position: absolute; right: 0; top: 0; height: 34px; width: 34px; border: none; background: transparent; color: #64748b; cursor: pointer;">
                  <i class="fa fa-search"></i>
                </button>
              </div>

              <?php if($this->input->get_post('keyword')!='' || $this->input->get_post('status_filter')!=''): ?>
                <a href="<?=base_url('doctor/pathlabreg/index')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Active Filter Pill Banner -->
          <?php if($this->input->get_post('status_filter')!=''): 
            $sf = $this->input->get_post('status_filter');
            $sfLabel = ($sf == 'approved' || $sf == 'registered') ? 'Approved & Verified Pathology Labs' : (($sf == 'pending' || $sf == 'pending_verification') ? 'Pending Verification Pathology Labs' : ucfirst($sf));
            $sfBg = ($sf == 'approved' || $sf == 'registered') ? '#dcfce7; color: #15803d; border-color: #bbf7d0;' : '#fef3c7; color: #b45309; border-color: #fde68a;';
          ?>
            <div style="margin-bottom: 14px;">
              <span style="background: <?=$sfBg?>; border: 1px solid; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-filter"></i> Filtering: <?=$sfLabel;?>
                <a href="<?=base_url('doctor/pathlabreg/index?keyword='.$this->input->get_post('keyword'))?>" style="color: inherit; margin-left: 4px; text-decoration: none;" title="Remove status filter">&times;</a>
              </span>
            </div>
          <?php endif; ?>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="pathlab-table" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc; color: #475569; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-pathlabs" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Pathology Lab Profile</th>
                  <th>Operational Territory</th>
                  <th>Contact Info</th>
                  <th style="width: 110px; text-align: center;">Platform Fee</th>
                  <th style="width: 100px; text-align: center;">Verification</th>
                  <th style="width: 100px; text-align: center;">Approval</th>
                  <th style="width: 150px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($pathlab)): foreach($pathlab as $val): 
                  $id = is_object($val) ? $val->id : $val['id'];
                  $name = is_object($val) ? $val->name : $val['name'];
                  $city = is_object($val) ? $val->city : $val['city'];
                  $email = is_object($val) ? $val->email : $val['email'];
                  $mobile = is_object($val) ? $val->mobile : $val['mobile'];
                  $verified = is_object($val) ? $val->verified : $val['verified'];
                  $approved = is_object($val) ? $val->approved : $val['approved'];
                  $cdate = is_object($val) ? $val->creat_date : $val['creat_date'];
                  $commission = is_object($val) ? ($val->commission_rate ?? 15.00) : ($val['commission_rate'] ?? 15.00);
                  $nabl = is_object($val) ? ($val->nabl_accredited ?? 0) : ($val['nabl_accredited'] ?? 0);
                  $rawPwd = is_object($val) ? ($val->raw_password_temp ?? '') : ($val['raw_password_temp'] ?? '');

                  $isVerified = ($verified == 1);
                  $isApproved = ($approved == 1);
                ?>
                  <tr id="row-<?=$id;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="pathlab-checkbox" value="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$id;?></td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px; display: flex; align-items: center; gap: 6px;">
                        <?=$name;?>
                        <?php if($nabl == 1): ?>
                          <span class="badge" style="background: #10b981; font-size: 10px; font-weight: 700; padding: 2px 6px;">NABL</span>
                        <?php endif; ?>
                      </div>
                      <div style="font-size: 11px; color: #64748b; display: flex; gap: 8px; margin-top: 2px;">
                        <span><i class="fa fa-tag"></i> LAB-<?=$id;?></span>
                        <span><i class="fa fa-calendar-o"></i> <?=date('d M Y', strtotime($cdate));?></span>
                      </div>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px; font-weight: 600;">
                        <i class="fa fa-map-marker text-danger"></i> <?=getCityName($city);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-size: 12px; color: #334155;"><i class="fa fa-envelope-o text-muted"></i> <?=$email;?></div>
                      <div style="font-size: 12px; color: #64748b;"><i class="fa fa-phone text-muted"></i> <?=$mobile;?></div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <button type="button" class="btn btn-xs btn-default inline-commission-btn" data-id="<?=$id;?>" data-rate="<?=$commission;?>" title="Click to adjust platform commission" style="font-weight: 700; color: #0284c7; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 4px; padding: 3px 8px;">
                        <span id="rate-display-<?=$id;?>"><?=$commission;?>%</span> <i class="fa fa-pencil" style="font-size: 9px; opacity: 0.6;"></i>
                      </button>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathlabreg/pathlabverify/'.$id);?>" class="badge-pill-status <?=$isVerified ? 'badge-status-active' : 'badge-status-inactive';?> action-lab-verify" data-id="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" title="Toggle Verification" style="text-decoration: none; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; <?=$isVerified ? 'background: #dcfce7; color: #16a34a;' : 'background: #fee2e2; color: #dc2626;'?>">
                        <i class="fa <?=$isVerified ? 'fa-check-circle' : 'fa-times-circle';?>"></i>
                        <span><?=$isVerified ? 'Verified' : 'Unverified';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathlabreg/pathlabapprove/'.$id);?>" class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-lab-approve" data-id="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" title="Toggle Approval" style="text-decoration: none; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; <?=$isApproved ? 'background: #dcfce7; color: #16a34a;' : 'background: #fef3c7; color: #d97706;'?>">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <div style="display: flex; gap: 4px; justify-content: center; align-items: center;">
                        <!-- Credentials Modal Trigger -->
                        <button type="button" class="btn-icon-action" onclick="openCredentialsModal(<?=$id;?>, '<?=htmlspecialchars(addslashes($name));?>', '<?=htmlspecialchars(addslashes($email));?>', '<?=htmlspecialchars(addslashes($rawPwd));?>')" style="background: #e0f2fe; color: #0284c7; width: 28px; height: 28px; border-radius: 6px; border: none; display: inline-flex; align-items: center; justify-content: center;" title="View &amp; Reset Portal Credentials">
                          <i class="fa fa-key"></i>
                        </button>
                        <!-- Audit Footprints -->
                        <a href="<?=base_url('doctor/pathology/audit_logs?entity_type=lab&entity_id='.$id);?>" class="btn-icon-action" style="background: #fef3c7; color: #b45309; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="Audit Trail &amp; History">
                          <i class="fa fa-history"></i>
                        </a>
                        <!-- View Profile -->
                        <a href="<?=base_url('doctor/pathlabreg/pathlabview/'.$id);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="View Lab Details">
                          <i class="fa fa-eye"></i>
                        </a>
                        <!-- Edit -->
                        <a href="<?=base_url('doctor/pathlabreg/pathlabupdate/'.$id);?>" class="btn-icon-action btn-action-edit" style="background: #f1f5f9; color: #00a896; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="Edit Pathlab">
                          <i class="fa fa-pencil"></i>
                        </a>
                        <!-- Delete -->
                        <a href="<?=base_url('doctor/pathlabreg/deletepathlab/'.$id);?>" class="btn-icon-action btn-action-delete delete-lab-btn" data-id="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" style="background: #fee2e2; color: #dc2626; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="Delete Pathlab">
                          <i class="fa fa-trash-o"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No pathology lab records found.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Footer -->
          <?php if(!empty($page_links)): ?>
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 18px;">
              <div class="pagination-wrapper">
                <?=$page_links;?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Add Lab & Provision Credentials Modal -->
<div class="modal fade" id="modal-add-pathlab" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="margin-top: 40px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.18); overflow: hidden;">
      <div class="modal-header" style="background: linear-gradient(135deg, #00a896, #028090); color: #ffffff; padding: 18px 24px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85; font-size: 24px;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; font-size: 17px; display: flex; align-items: center; gap: 8px;">
          <i class="fa fa-plus-circle"></i> Onboard Partner Pathology Lab &amp; Provision Credentials
        </h4>
        <div style="font-size: 12px; opacity: 0.9; margin-top: 2px;">Creates accredited lab entity and provisions secure portal account</div>
      </div>
      
      <form action="<?=base_url('doctor/pathlabreg/create')?>" method="post" id="form-quick-add-lab" enctype="multipart/form-data" style="margin: 0;">
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          
          <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 16px;">
            <h5 style="margin: 0; font-weight: 700; color: #1e293b; font-size: 14px;"><i class="fa fa-hospital-o text-primary"></i> 1. Laboratory Identity &amp; Accreditations</h5>
          </div>

          <div class="row">
            <div class="col-md-8 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Registered Lab Name <span style="color: #ef4444;">*</span></label>
              <input type="text" class="form-control" name="name" placeholder="e.g. Apollo Diagnostics Central, SRL Care" required minlength="3">
            </div>
            <div class="col-md-4 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">NABL Accreditation</label>
              <div style="padding-top: 6px;">
                <label style="font-weight: 600; font-size: 13px; color: #15803d; cursor: pointer;">
                  <input type="checkbox" name="nabl_accredited" value="1" style="width: 16px; height: 16px; accent-color: #10b981; vertical-align: middle;"> NABL Accredited Lab
                </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Clinical License / Reg. Number</label>
              <input type="text" class="form-control" name="license_number" placeholder="e.g. UP-PATH-2026-8812">
            </div>
            <div class="col-md-6 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Platform Commission Rate (%)</label>
              <div class="input-group">
                <input type="number" step="0.5" min="0" max="100" class="form-control" name="commission_rate" value="15.00" required>
                <span class="input-group-addon" style="font-weight: 700;">%</span>
              </div>
            </div>
          </div>

          <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin: 20px 0 16px;">
            <h5 style="margin: 0; font-weight: 700; color: #1e293b; font-size: 14px;"><i class="fa fa-map-marker text-danger"></i> 2. Location &amp; Contact</h5>
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Operational City <span style="color: #ef4444;">*</span></label>
              <select class="form-control" name="city" required>
                <option value="">-- Select City --</option>
                <?php
                $allCities = $this->db->get_where('master_city', array('status'=>1))->result();
                foreach($allCities as $c): ?>
                  <option value="<?=$c->id;?>"><?=$c->name;?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Locality / Area Name</label>
              <input type="text" class="form-control" name="location" placeholder="e.g. Sector 62 / Civil Lines">
            </div>
            <div class="col-md-12 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Physical Lab Address</label>
              <input type="text" class="form-control" name="address" placeholder="Premises/Plot No., Street, Landmark, Pincode">
            </div>
          </div>

          <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin: 20px 0 16px;">
            <h5 style="margin: 0; font-weight: 700; color: #1e293b; font-size: 14px;"><i class="fa fa-lock text-info"></i> 3. Lab Manager Portal Credentials</h5>
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Manager Email (Login Username) <span style="color: #ef4444;">*</span></label>
              <input type="email" class="form-control" name="email" id="onboard-email" placeholder="lab.admin@example.com" required>
            </div>
            <div class="col-md-6 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Authorized Phone / Mobile <span style="color: #ef4444;">*</span></label>
              <input type="text" class="form-control" name="mobile" placeholder="10-digit phone number" maxlength="10" minlength="10" pattern="[0-9]{10}" required>
            </div>
            <div class="col-md-8 form-group">
              <label style="font-weight: 600; font-size: 13px; color: #334155;">Auto-Provisioned Password</label>
              <div class="input-group">
                <input type="text" class="form-control" name="password" id="onboard-password" value="Lab@<?=rand(10000,99999);?>" style="font-family: monospace; font-weight: 700; color: #0f172a;" required>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" onclick="regenerateAddPassword();" title="Generate New Secure Password" style="font-weight: 600;">
                    <i class="fa fa-refresh"></i> Regenerate
                  </button>
                  <button type="button" class="btn btn-default" onclick="copyAddPassword();" title="Copy Password" style="font-weight: 600;">
                    <i class="fa fa-copy"></i> Copy
                  </button>
                </span>
              </div>
              <small style="color: #64748b;">Password is stored securely and logged in audit footprint.</small>
            </div>
          </div>

        </div>
        <div class="modal-footer" style="background: #f8fafc; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 6px;">Cancel</button>
          <button type="submit" name="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; padding: 8px 24px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,168,150,0.3);">
            <i class="fa fa-check-circle"></i> Save &amp; Onboard Partner Lab
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Lab Credentials View & Reset Modal -->
<div class="modal fade" id="modal-lab-credentials" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 480px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.18); overflow: hidden;">
      <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
          <i class="fa fa-key text-warning"></i> Lab Portal Access Credentials
        </h4>
      </div>
      <div class="modal-body" style="padding: 24px;">
        <div style="margin-bottom: 16px;">
          <div style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700;">Pathology Partner:</div>
          <div id="cred-modal-labname" style="font-size: 16px; font-weight: 800; color: #0f172a;">Apollo Diagnostics</div>
        </div>

        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 16px; margin-bottom: 18px;">
          <div style="margin-bottom: 10px;">
            <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Portal URL:</span>
            <div style="font-size: 13px; font-weight: 600; color: #0284c7; word-break: break-all;">
              <a href="<?=base_url('../pathlabpanel');?>" target="_blank"><?=base_url('../pathlabpanel');?></a>
            </div>
          </div>
          <div style="margin-bottom: 10px;">
            <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Username / Login Email:</span>
            <div id="cred-modal-email" style="font-size: 14px; font-weight: 700; color: #1e293b; font-family: monospace;">lab@example.com</div>
          </div>
          <div>
            <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Access Password:</span>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 2px;">
              <span id="cred-modal-pwd" style="font-size: 15px; font-weight: 800; color: #0f172a; font-family: monospace;">••••••••</span>
              <button type="button" class="btn btn-xs btn-default" onclick="togglePasswordView();" id="btn-toggle-pwd" style="font-weight: 600;">
                <i class="fa fa-eye"></i> Show
              </button>
            </div>
          </div>
        </div>

        <div style="display: flex; gap: 8px; justify-content: space-between; align-items: center;">
          <button type="button" id="btn-reset-lab-pwd" class="btn btn-sm btn-warning" style="border-radius: 6px; font-weight: 700; background: #f59e0b; border-color: #f59e0b;">
            <i class="fa fa-refresh"></i> Reset Password
          </button>
          <button type="button" id="btn-copy-all-cred" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 700; background: #00a896; border-color: #00a896;">
            <i class="fa fa-copy"></i> Copy Full Credentials
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteLabModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Pathology Lab</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-lab-name" style="color: #1e293b;">this lab</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-lab-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var activeLabCredId = 0;
var activeLabEmail = '';
var activeLabPassword = '';
var pwdVisible = false;

function showToast(message, type) {
  var bg = (type === 'success') ? '#10b981' : ((type === 'danger') ? '#ef4444' : '#00a896');
  var icon = (type === 'success') ? 'check-circle' : ((type === 'danger') ? 'exclamation-triangle' : 'info-circle');
  var toast = $('<div style="background:'+bg+'; color:#fff; padding:12px 18px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15); font-weight:600; font-size:13px; display:flex; align-items:center; gap:8px; pointer-events:auto; min-width:260px;"><i class="fa fa-'+icon+'"></i><span>'+message+'</span></div>');
  $('#toast-container').append(toast);
  setTimeout(function() {
    toast.fadeOut(400, function() { $(this).remove(); });
  }, 3500);
}

function regenerateAddPassword() {
  var pwd = 'Lab@' + Math.floor(10000 + Math.random() * 90000);
  $('#onboard-password').val(pwd);
}

function copyAddPassword() {
  var pwd = $('#onboard-password').val();
  navigator.clipboard.writeText(pwd);
  showToast('Password copied to clipboard!', 'success');
}

function openCredentialsModal(id, name, email, rawPwd) {
  activeLabCredId = id;
  activeLabEmail = email;
  activeLabPassword = rawPwd || 'Lab@' + Math.floor(10000 + Math.random() * 90000);
  pwdVisible = false;

  $('#cred-modal-labname').text(name);
  $('#cred-modal-email').text(email);
  $('#cred-modal-pwd').text('••••••••');
  $('#btn-toggle-pwd').html('<i class="fa fa-eye"></i> Show');
  $('#modal-lab-credentials').modal('show');
}

function togglePasswordView() {
  pwdVisible = !pwdVisible;
  if (pwdVisible) {
    $('#cred-modal-pwd').text(activeLabPassword);
    $('#btn-toggle-pwd').html('<i class="fa fa-eye-slash"></i> Hide');
  } else {
    $('#cred-modal-pwd').text('••••••••');
    $('#btn-toggle-pwd').html('<i class="fa fa-eye"></i> Show');
  }
}

$('#btn-copy-all-cred').on('click', function() {
  var portalUrl = '<?=base_url("../pathlabpanel")?>';
  var text = "Pathology Lab Portal Credentials\nPortal: " + portalUrl + "\nLogin Email: " + activeLabEmail + "\nPassword: " + activeLabPassword;
  navigator.clipboard.writeText(text);
  showToast('Full credentials copied to clipboard!', 'success');
});

$('#btn-reset-lab-pwd').on('click', function() {
  if (!confirm('Generate and assign a new password for this lab?')) return;
  var newPwd = 'Lab@' + Math.floor(10000 + Math.random() * 90000);

  $.ajax({
    url: '<?=base_url("doctor/pathlabreg/reset_credentials")?>',
    type: 'POST',
    data: { id: activeLabCredId, new_password: newPwd },
    dataType: 'json',
    success: function(resp) {
      if (resp && resp.status == 1) {
        activeLabPassword = resp.password;
        if (pwdVisible) {
          $('#cred-modal-pwd').text(activeLabPassword);
        }
        showToast('Password reset successfully! New password: ' + activeLabPassword, 'success');
      } else {
        showToast((resp && resp.message) ? resp.message : 'Error resetting password', 'danger');
      }
    },
    error: function() {
      showToast('Server error while resetting password', 'danger');
    }
  });
});

// Inline Commission edit
$('.inline-commission-btn').on('click', function() {
  var labId = $(this).data('id');
  var currentRate = $(this).data('rate');
  var newRate = prompt('Enter new platform commission percentage (%):', currentRate);
  if (newRate !== null && newRate !== '') {
    newRate = parseFloat(newRate);
    if (!isNaN(newRate) && newRate >= 0 && newRate <= 100) {
      $.ajax({
        url: '<?=base_url("doctor/pathlabreg/update_commission")?>',
        type: 'POST',
        data: { id: labId, commission_rate: newRate },
        dataType: 'json',
        success: function(resp) {
          if (resp && resp.status == 1) {
            $('#rate-display-' + labId).text(newRate + '%');
            showToast(resp.message, 'success');
          } else {
            showToast((resp && resp.message) ? resp.message : 'Update failed', 'danger');
          }
        }
      });
    } else {
      alert('Please enter a valid percentage between 0 and 100.');
    }
  }
});

// Verification Toggle AJAX
$(document).on('click', '.action-lab-verify', function(e) {
  e.preventDefault();
  var link = $(this);
  var labId = link.data('id');
  var labName = link.data('name');

  $.ajax({
    url: '<?=base_url("doctor/pathlabreg/pathlabverify")?>',
    type: 'POST',
    data: { did: labId },
    dataType: 'json',
    success: function(res) {
      if (res && (res.status == '1' || res.status == 1)) {
        link.removeClass('badge-status-inactive').addClass('badge-status-active');
        link.css({background: '#dcfce7', color: '#16a34a'});
        link.html('<i class="fa fa-check-circle"></i> <span>Verified</span>');
        showToast(labName + ' is now Verified', 'success');
      } else {
        link.removeClass('badge-status-active').addClass('badge-status-inactive');
        link.css({background: '#fee2e2', color: '#dc2626'});
        link.html('<i class="fa fa-times-circle"></i> <span>Unverified</span>');
        showToast(labName + ' is now Unverified', 'info');
      }
    }
  });
});

// Approval Toggle AJAX
$(document).on('click', '.action-lab-approve', function(e) {
  e.preventDefault();
  var link = $(this);
  var labId = link.data('id');
  var labName = link.data('name');

  $.ajax({
    url: '<?=base_url("doctor/pathlabreg/pathlabapprove")?>',
    type: 'POST',
    data: { did: labId },
    dataType: 'json',
    success: function(res) {
      if (res && (res.status == '1' || res.status == 1)) {
        link.removeClass('badge-status-inactive').addClass('badge-status-active');
        link.css({background: '#dcfce7', color: '#16a34a'});
        link.html('<i class="fa fa-circle" style="font-size: 7px;"></i> <span>Approved</span>');
        showToast(labName + ' is now Approved', 'success');
      } else {
        link.removeClass('badge-status-active').addClass('badge-status-inactive');
        link.css({background: '#fef3c7', color: '#d97706'});
        link.html('<i class="fa fa-circle" style="font-size: 7px;"></i> <span>Pending</span>');
        showToast(labName + ' approval set to Pending', 'info');
      }
    }
  });
});

// Single Delete handling
var activeDeleteLabId = null;
$(document).on('click', '.delete-lab-btn', function(e) {
  e.preventDefault();
  activeDeleteLabId = $(this).data('id');
  $('#delete-lab-name').text($(this).data('name'));
  $('#deleteLabModal').modal('show');
});

$('#confirm-delete-lab-btn').on('click', function() {
  if (activeDeleteLabId) {
    $.ajax({
      url: '<?=base_url("doctor/pathlabreg/deletepathlab")?>',
      type: 'POST',
      data: { id: activeDeleteLabId, is_ajax: 1 },
      dataType: 'json',
      success: function(res) {
        $('#deleteLabModal').modal('hide');
        $('#row-' + activeDeleteLabId).fadeOut(400, function() { $(this).remove(); });
        showToast('Pathology Lab deleted successfully', 'success');
      },
      error: function() {
        window.location.href = '<?=base_url("doctor/pathlabreg/deletepathlab/")?>' + activeDeleteLabId;
      }
    });
  }
});

// Bulk selection & deletion
$('#select-all-pathlabs').on('change', function() {
  $('.pathlab-checkbox').prop('checked', $(this).is(':checked')).trigger('change');
});

$(document).on('change', '.pathlab-checkbox', function() {
  var count = $('.pathlab-checkbox:checked').length;
  $('#pathlab-selected-count').text(count);
  if (count > 0) {
    $('#bulk-delete-pathlab-btn').show();
  } else {
    $('#bulk-delete-pathlab-btn').hide();
    $('#select-all-pathlabs').prop('checked', false);
  }
});

$('#bulk-delete-pathlab-btn').on('click', function() {
  var ids = [];
  $('.pathlab-checkbox:checked').each(function() { ids.push($(this).val()); });
  if (ids.length > 0) {
    if (confirm('Delete ' + ids.length + ' selected pathology labs? This cannot be undone.')) {
      $.ajax({
        url: '<?=base_url("doctor/pathlabreg/bulk_delete_pathlab")?>',
        type: 'POST',
        data: { ids: ids, is_ajax: 1 },
        dataType: 'json',
        success: function() {
          window.location.reload();
        }
      });
    }
  }
});
</script>
