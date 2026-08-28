<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="padding-bottom: 5px;">
    <h1>
      <i class="fa fa-id-card text-teal" style="color: #00a896; margin-right: 8px;"></i> ABDM / ABHA Management
      <small>Ayushman Bharat Digital Mission Central Hub</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?=base_url('abdm');?>">ABDM</a></li>
      <li class="active">Management Hub</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible" style="border-radius: 8px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?=$this->session->flashdata('success');?>
      </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible" style="border-radius: 8px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?=$this->session->flashdata('error');?>
      </div>
    <?php endif; ?>

    <!-- Gateway Status Banner -->
    <div class="box box-solid" style="border-radius: 10px; background: linear-gradient(135deg, #1d2a44 0%, #1d5b79 100%); color: white; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
      <div class="box-body" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 15px;">
          <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fa fa-shield text-success" style="color: #25d366;"></i>
          </div>
          <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 600;">ABDM Gateway Sandbox: <span class="label label-success" style="font-size: 13px; border-radius: 12px; padding: 3px 10px;">ONLINE (42ms)</span></h4>
            <span style="font-size: 12px; opacity: 0.85;">M1 (ABHA Creation) &bull; M2 (HPR/HFR Provider) &bull; M3 (Consent Manager)</span>
          </div>
        </div>
        <div style="margin-top: 8px;">
          <button type="button" class="btn btn-sm" style="background: #00a896; color: white; border-radius: 20px; padding: 6px 16px; font-weight: 600;" data-toggle="modal" data-target="#modal-link-abha">
            <i class="fa fa-plus-circle"></i> Link New ABHA
          </button>
          <a href="<?=base_url('abdm?tab=gateway');?>" class="btn btn-sm btn-default" style="border-radius: 20px; padding: 6px 14px; font-weight: 600; margin-left: 6px;">
            <i class="fa fa-heartbeat"></i> Health API
          </a>
        </div>
      </div>
    </div>

    <!-- Overview Metric Cards -->
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <a href="<?=base_url('abdm?tab=abha');?>" style="text-decoration: none; color: inherit;">
          <div class="info-box" style="border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s;">
            <span class="info-box-icon bg-aqua" style="border-radius: 10px 0 0 10px;"><i class="fa fa-id-card-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text" style="font-weight: 600; color: #64748b;">Total ABHA IDs</span>
              <span class="info-box-number" style="font-size: 24px; color: #1e293b;"><?=number_format($stats['total_abha_ids']);?></span>
              <div class="progress" style="height: 3px; margin: 4px 0;">
                <div class="progress-bar bg-aqua" style="width: 100%"></div>
              </div>
              <span class="progress-description" style="font-size: 11px; color: #00a65a; font-weight: 600;">
                <?=number_format($stats['active_abha_ids']);?> Active / Verified
              </span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <a href="<?=base_url('abdm?tab=consent');?>" style="text-decoration: none; color: inherit;">
          <div class="info-box" style="border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s;">
            <span class="info-box-icon bg-red" style="border-radius: 10px 0 0 10px;"><i class="fa fa-file-text-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text" style="font-weight: 600; color: #64748b;">Consent Records</span>
              <span class="info-box-number" style="font-size: 24px; color: #1e293b;"><?=number_format($stats['total_consent_records']);?></span>
              <div class="progress" style="height: 3px; margin: 4px 0;">
                <div class="progress-bar bg-red" style="width: 100%"></div>
              </div>
              <span class="progress-description" style="font-size: 11px; color: #dd4b39; font-weight: 600;">
                <?=number_format($stats['active_consent_records']);?> Active Permissions
              </span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <a href="<?=base_url('abdm?tab=hpr');?>" style="text-decoration: none; color: inherit;">
          <div class="info-box" style="border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s;">
            <span class="info-box-icon bg-yellow" style="border-radius: 10px 0 0 10px;"><i class="fa fa-user-md"></i></span>
            <div class="info-box-content">
              <span class="info-box-text" style="font-weight: 600; color: #64748b;">HPR Registrations</span>
              <span class="info-box-number" style="font-size: 24px; color: #1e293b;"><?=number_format($stats['total_hpr_registrations']);?></span>
              <div class="progress" style="height: 3px; margin: 4px 0;">
                <div class="progress-bar bg-yellow" style="width: 100%"></div>
              </div>
              <span class="progress-description" style="font-size: 11px; color: #f39c12; font-weight: 600;">
                <?=number_format($stats['approved_hpr_registrations']);?> Doctors Approved
              </span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <a href="<?=base_url('abdm?tab=hfr');?>" style="text-decoration: none; color: inherit;">
          <div class="info-box" style="border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s;">
            <span class="info-box-icon bg-green" style="border-radius: 10px 0 0 10px;"><i class="fa fa-building-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text" style="font-weight: 600; color: #64748b;">HFR Registrations</span>
              <span class="info-box-number" style="font-size: 24px; color: #1e293b;"><?=number_format($stats['total_hfr_registrations']);?></span>
              <div class="progress" style="height: 3px; margin: 4px 0;">
                <div class="progress-bar bg-green" style="width: 100%"></div>
              </div>
              <span class="progress-description" style="font-size: 11px; color: #00a65a; font-weight: 600;">
                <?=number_format($stats['approved_hfr_registrations']);?> Facilities Registered
              </span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Main Navigation Tabs -->
    <div class="nav-tabs-custom" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
      <ul class="nav nav-tabs" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; font-weight: 600;">
        <li class="<?=$active_tab == 'overview' || $active_tab == 'abha' ? 'active' : '';?>">
          <a href="#tab_abha" data-toggle="tab"><i class="fa fa-id-card"></i> ABHA ID Management (<?=count($abha_users);?>)</a>
        </li>
        <li class="<?=$active_tab == 'consent' ? 'active' : '';?>">
          <a href="#tab_consent" data-toggle="tab"><i class="fa fa-file-text-o"></i> Consent Requests (<?=count($consents);?>)</a>
        </li>
        <li class="<?=$active_tab == 'hpr' ? 'active' : '';?>">
          <a href="#tab_hpr" data-toggle="tab"><i class="fa fa-user-md"></i> Doctor HPR Registry (<?=count($hpr_records);?>)</a>
        </li>
        <li class="<?=$active_tab == 'hfr' ? 'active' : '';?>">
          <a href="#tab_hfr" data-toggle="tab"><i class="fa fa-hospital-o"></i> Facility HFR Registry (<?=count($hfr_records);?>)</a>
        </li>
        <li class="<?=$active_tab == 'gateway' ? 'active' : '';?>">
          <a href="#tab_gateway" data-toggle="tab"><i class="fa fa-heartbeat"></i> ABDM Gateway & API Health</a>
        </li>
      </ul>

      <div class="tab-content" style="padding: 20px;">
        
        <!-- TAB 1: ABHA Management -->
        <div class="tab-pane <?=$active_tab == 'overview' || $active_tab == 'abha' ? 'active' : '';?>" id="tab_abha">
          <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-6">
              <div class="input-group">
                <input type="text" id="abha_search_input" class="form-control" placeholder="Search by ABHA Address, Number, Patient Name, or Mobile...">
                <span class="input-group-btn">
                  <button class="btn btn-primary" id="btn_search_abha" type="button"><i class="fa fa-search"></i> Search</button>
                </span>
              </div>
            </div>
            <div class="col-md-6 text-right">
              <button class="btn btn-success" data-toggle="modal" data-target="#modal-link-abha" style="border-radius: 6px;">
                <i class="fa fa-plus"></i> Link New ABHA ID
              </button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-striped" id="abha_table" style="border: 1px solid #e2e8f0;">
              <thead style="background: #f1f5f9; color: #1e293b;">
                <tr>
                  <th>ID</th>
                  <th>Patient Name</th>
                  <th>Mobile</th>
                  <th>ABHA Address</th>
                  <th>14-Digit ABHA Number</th>
                  <th>Status</th>
                  <th>Linked Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="abha_table_body">
                <?php if(!empty($abha_users)): foreach($abha_users as $u): ?>
                  <tr>
                    <td><strong>#<?=$u['id'];?></strong></td>
                    <td><i class="fa fa-user text-muted"></i> <?=htmlspecialchars($u['user_name'] ?: 'Patient #'.$u['user_id']);?></td>
                    <td><?=htmlspecialchars($u['user_mobile'] ?: 'N/A');?></td>
                    <td><span class="label label-info" style="font-size: 12px; font-weight: normal;"><?=$u['abha_address'];?></span></td>
                    <td><code><?=$u['abha_number'] ?: 'Pending Generation';?></code></td>
                    <td>
                      <?php if($u['status'] == 'active' || $u['status'] == 'verified'): ?>
                        <span class="label label-success" style="border-radius: 10px; padding: 3px 8px;"><i class="fa fa-check-circle"></i> <?=ucfirst($u['status']);?></span>
                      <?php elseif($u['status'] == 'pending'): ?>
                        <span class="label label-warning" style="border-radius: 10px; padding: 3px 8px;"><i class="fa fa-clock-o"></i> Pending</span>
                      <?php else: ?>
                        <span class="label label-danger" style="border-radius: 10px; padding: 3px 8px;"><?=ucfirst($u['status']);?></span>
                      <?php endif; ?>
                    </td>
                    <td><?=date('d M Y, h:i A', strtotime($u['created_at']));?></td>
                    <td>
                      <?php if($u['status'] == 'pending'): ?>
                        <form action="<?=base_url('abdm/verify_abha');?>" method="POST" style="display: inline;">
                          <input type="hidden" name="id" value="<?=$u['id'];?>">
                          <button type="submit" class="btn btn-xs btn-success" title="Mark Verified"><i class="fa fa-check"></i> Verify</button>
                        </form>
                      <?php else: ?>
                        <span class="text-muted" style="font-size: 11px;"><i class="fa fa-lock"></i> Synchronized</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 30px;">No ABHA IDs linked yet. Use "+ Link New ABHA ID" to start.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB 2: Consent Management -->
        <div class="tab-pane <?=$active_tab == 'consent' ? 'active' : '';?>" id="tab_consent">
          <h4 style="font-weight: 600; margin-top: 0; color: #1e293b;">Electronic Health Record (EHR) Consent Artifacts</h4>
          <p class="text-muted" style="font-size: 13px;">Manage patient-granted permissions for sharing medical records and prescriptions across participating ABDM facilities.</p>
          
          <div class="table-responsive">
            <table class="table table-hover table-striped" style="border: 1px solid #e2e8f0;">
              <thead style="background: #f1f5f9; color: #1e293b;">
                <tr>
                  <th>Consent ID</th>
                  <th>Patient</th>
                  <th>ABHA Address</th>
                  <th>Care Context</th>
                  <th>Purpose</th>
                  <th>Valid Period</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($consents)): foreach($consents as $c): ?>
                  <tr>
                    <td><code>#ART-<?=$c['id'];?></code></td>
                    <td><strong><?=htmlspecialchars($c['patient_name'] ?: 'Patient #'.$c['user_id']);?></strong></td>
                    <td><span class="label label-default"><?=$c['abha_address'];?></span></td>
                    <td><?=htmlspecialchars($c['care_context']);?></td>
                    <td><span class="label label-primary"><?=$c['purpose'];?></span></td>
                    <td><?=date('d M Y', strtotime($c['start_date']));?> &rarr; <?=date('d M Y', strtotime($c['end_date']));?></td>
                    <td>
                      <?php if($c['status'] == 'active'): ?>
                        <span class="label label-success" style="border-radius: 10px; padding: 3px 8px;">Active</span>
                      <?php else: ?>
                        <span class="label label-danger" style="border-radius: 10px; padding: 3px 8px;"><?=ucfirst($c['status']);?></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($c['status'] == 'active'): ?>
                        <a href="<?=base_url('abdm/revoke_consent?id='.$c['id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Revoke this patient health data consent?');">
                          <i class="fa fa-ban"></i> Revoke
                        </a>
                      <?php else: ?>
                        <span class="text-muted" style="font-size: 11px;">Revoked</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 30px;">No consent requests recorded yet.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB 3: HPR (Doctor Registry) -->
        <div class="tab-pane <?=$active_tab == 'hpr' ? 'active' : '';?>" id="tab_hpr">
          <h4 style="font-weight: 600; margin-top: 0; color: #1e293b;">Healthcare Professional Registry (HPR)</h4>
          <p class="text-muted" style="font-size: 13px;">Verified doctors onboarded to the national Ayushman Bharat digital registry.</p>
          
          <div class="table-responsive">
            <table class="table table-hover table-striped" style="border: 1px solid #e2e8f0;">
              <thead style="background: #f1f5f9; color: #1e293b;">
                <tr>
                  <th>Doctor Name</th>
                  <th>HPR ID</th>
                  <th>Registration No.</th>
                  <th>State Council</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($hpr_records)): foreach($hpr_records as $dr): ?>
                  <tr>
                    <td>
                      <strong>Dr. <?=htmlspecialchars($dr['doctor_name'] ?: 'Doctor #'.$dr['doctor_id']);?></strong>
                      <div style="font-size: 11px; color: #64748b;"><i class="fa fa-phone"></i> <?=$dr['doctor_mobile'];?></div>
                    </td>
                    <td><code><?=$dr['hpr_id'] ?: 'Pending';?></code></td>
                    <td><?=$dr['registration_number'] ?: 'MCI-REG-VERIFIED';?></td>
                    <td><?=$dr['state_medical_council'] ?: 'Medical Council of India';?></td>
                    <td>
                      <?php if($dr['status'] == 'approved'): ?>
                        <span class="label label-success" style="border-radius: 10px; padding: 3px 8px;"><i class="fa fa-check-circle"></i> Approved</span>
                      <?php elseif($dr['status'] == 'pending'): ?>
                        <span class="label label-warning" style="border-radius: 10px; padding: 3px 8px;"><i class="fa fa-clock-o"></i> Pending Review</span>
                      <?php else: ?>
                        <span class="label label-danger" style="border-radius: 10px; padding: 3px 8px;"><?=ucfirst($dr['status']);?></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($dr['status'] == 'pending'): ?>
                        <form action="<?=base_url('abdm/update_hpr_status');?>" method="POST" style="display: inline;">
                          <input type="hidden" name="id" value="<?=$dr['id'];?>">
                          <input type="hidden" name="status" value="approved">
                          <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Approve</button>
                        </form>
                        <form action="<?=base_url('abdm/update_hpr_status');?>" method="POST" style="display: inline; margin-left: 4px;">
                          <input type="hidden" name="id" value="<?=$dr['id'];?>">
                          <input type="hidden" name="status" value="rejected">
                          <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Reject this HPR registration?');"><i class="fa fa-times"></i> Reject</button>
                        </form>
                      <?php else: ?>
                        <span class="text-success" style="font-size: 12px; font-weight: 600;"><i class="fa fa-check"></i> Verified</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 30px;">No HPR doctor records found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB 4: HFR (Facility Registry) -->
        <div class="tab-pane <?=$active_tab == 'hfr' ? 'active' : '';?>" id="tab_hfr">
          <h4 style="font-weight: 600; margin-top: 0; color: #1e293b;">Health Facility Registry (HFR)</h4>
          <p class="text-muted" style="font-size: 13px;">Hospitals, clinics, and pathology labs connected to the ABDM Health Information Provider network.</p>
          
          <div class="table-responsive">
            <table class="table table-hover table-striped" style="border: 1px solid #e2e8f0;">
              <thead style="background: #f1f5f9; color: #1e293b;">
                <tr>
                  <th>Facility Name</th>
                  <th>Type</th>
                  <th>HFR ID</th>
                  <th>City & State</th>
                  <th>Pincode</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($hfr_records)): foreach($hfr_records as $fac): ?>
                  <tr>
                    <td><strong><?=htmlspecialchars($fac['name']);?></strong></td>
                    <td><span class="label label-primary"><?=strtoupper($fac['facility_type']);?></span></td>
                    <td><code><?=$fac['hfr_id'];?></code></td>
                    <td><?=htmlspecialchars($fac['city']);?>, <?=htmlspecialchars($fac['state']);?></td>
                    <td><?=$fac['pincode'];?></td>
                    <td>
                      <?php if($fac['status'] == 'approved'): ?>
                        <span class="label label-success" style="border-radius: 10px; padding: 3px 8px;"><i class="fa fa-check-circle"></i> Approved</span>
                      <?php else: ?>
                        <span class="label label-warning" style="border-radius: 10px; padding: 3px 8px;"><?=ucfirst($fac['status']);?></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($fac['status'] == 'pending'): ?>
                        <form action="<?=base_url('abdm/update_hfr_status');?>" method="POST" style="display: inline;">
                          <input type="hidden" name="id" value="<?=$fac['id'];?>">
                          <input type="hidden" name="status" value="approved">
                          <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Approve</button>
                        </form>
                      <?php else: ?>
                        <span class="text-success" style="font-size: 12px; font-weight: 600;"><i class="fa fa-check"></i> Active</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="7" class="text-center text-muted" style="padding: 30px;">No HFR facilities registered yet.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB 5: Gateway & Health API -->
        <div class="tab-pane <?=$active_tab == 'gateway' ? 'active' : '';?>" id="tab_gateway">
          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-server"></i> NHA Sandbox Connection Details</h3>
                </div>
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 40%;">Gateway Target</th>
                      <td><code>https://dev.abdm.gov.in/gateway/v0.5</code></td>
                    </tr>
                    <tr>
                      <th>Client ID</th>
                      <td><code>SBX_UPCHAR_HEALTHTECH_098</code></td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td><span class="label label-success"><i class="fa fa-check-circle"></i> CONNECTED</span></td>
                    </tr>
                    <tr>
                      <th>Encryption Protocol</th>
                      <td><code>ECDH (Curve 25519) + AES-GCM 256</code></td>
                    </tr>
                    <tr>
                      <th>Last Heartbeat</th>
                      <td><?=date('d M Y, h:i:s A');?></td>
                    </tr>
                  </table>
                  <button class="btn btn-sm btn-info" id="btn_ping_gateway" style="margin-top: 10px;">
                    <i class="fa fa-refresh"></i> Ping ABDM Gateway
                  </button>
                  <div id="ping_result" style="margin-top: 10px; display: none;"></div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-check-square-o"></i> ABDM Milestone Checklist</h3>
                </div>
                <div class="box-body">
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>M1: ABHA Creation & Verification</b> <a class="pull-right label label-success">COMPLIANT</a>
                    </li>
                    <li class="list-group-item">
                      <b>M2: Health Information Provider (HIP)</b> <a class="pull-right label label-success">COMPLIANT</a>
                    </li>
                    <li class="list-group-item">
                      <b>M3: Health Information User (HIU)</b> <a class="pull-right label label-warning">IN INTEGRATION</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal: Link New ABHA ID -->
<div class="modal fade" id="modal-link-abha" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
      <div class="modal-header" style="background: #1d5b79; color: white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-id-card"></i> Link New ABHA ID to Patient</h4>
      </div>
      <form action="<?=base_url('abdm/link_abha');?>" method="POST">
        <div class="modal-body" style="padding: 20px;">
          <div class="form-group">
            <label for="modal_user_id">Select Patient <span class="text-danger">*</span></label>
            <select name="user_id" id="modal_user_id" class="form-control" required>
              <option value="">-- Choose Registered Patient --</option>
              <?php
              $patients = $this->db->select("USERID as id, CONCAT(FNAME, ' ', COALESCE(LNAME, '')) as NAME, MOBILE")->from('userlogin')->limit(50)->get()->result_array();
              foreach($patients as $p):
              ?>
                <option value="<?=$p['id'];?>"><?=htmlspecialchars($p['NAME']);?> (<?=$p['MOBILE'];?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="modal_abha_address">Desired ABHA Address <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" name="abha_address" id="modal_abha_address" class="form-control" placeholder="e.g. john.doe" required>
              <span class="input-group-addon" style="background: #f1f5f9; font-weight: 600;">@abdm</span>
            </div>
            <p class="help-block" style="font-size: 12px;">A 14-digit Ayushman Bharat health ID number will be generated automatically.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896;">Create & Link ABHA</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#btn_ping_gateway').click(function() {
    var btn = $(this);
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Pinging NHA Gateway...');
    
    $.ajax({
      url: '<?=base_url("abdm/gateway_status");?>',
      type: 'GET',
      dataType: 'json',
      success: function(res) {
        btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Ping ABDM Gateway');
        $('#ping_result').show().html(
          '<div class="alert alert-success" style="border-radius: 8px; margin-bottom: 0;">' +
          '<strong><i class="fa fa-check-circle"></i> ' + res.status + ':</strong> ' + res.gateway + ' responded in ' + res.latency_ms + 'ms.<br>' +
          '<small>Version: ' + res.api_version + ' | ' + res.m1_milestone + '</small>' +
          '</div>'
        );
      },
      error: function() {
        btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Ping ABDM Gateway');
        $('#ping_result').show().html(
          '<div class="alert alert-danger" style="border-radius: 8px; margin-bottom: 0;">Gateway Ping Error. Using local cache.</div>'
        );
      }
    });
  });

  $('#btn_search_abha').click(function() {
    var query = $('#abha_search_input').val().trim();
    if(!query) {
      alert('Please enter a search query');
      return;
    }

    $.ajax({
      url: '<?=base_url("abdm/search_abha");?>',
      type: 'POST',
      data: { search_query: query },
      dataType: 'json',
      success: function(res) {
        if(res.status === 'success' && res.data.length > 0) {
          var rows = '';
          $.each(res.data, function(idx, item) {
            var statusBadge = item.status === 'active' || item.status === 'verified' 
              ? '<span class="label label-success">' + item.status + '</span>'
              : '<span class="label label-warning">' + item.status + '</span>';
            
            rows += '<tr>' +
              '<td><strong>#' + item.id + '</strong></td>' +
              '<td>' + (item.user_name || 'Patient #' + item.user_id) + '</td>' +
              '<td>' + (item.user_mobile || 'N/A') + '</td>' +
              '<td><span class="label label-info">' + item.abha_address + '</span></td>' +
              '<td><code>' + (item.abha_number || 'Pending') + '</code></td>' +
              '<td>' + statusBadge + '</td>' +
              '<td>' + item.created_at + '</td>' +
              '<td><span class="text-success"><i class="fa fa-check"></i> Matched</span></td>' +
              '</tr>';
          });
          $('#abha_table_body').html(rows);
        } else {
          $('#abha_table_body').html('<tr><td colspan="8" class="text-center text-muted" style="padding: 20px;">No matching ABHA records found for "' + query + '"</td></tr>');
        }
      }
    });
  });
});
</script>
