<div class="content-wrapper">
  <!-- Content Header & Breadcrumb -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Patient & User Management</h1>
        <small style="color: #64748b; font-size: 13px;">Enterprise dossier, clinical appointment history, old medical prescriptions, payments, and rewards</small>
      </div>
      <div style="display: flex; gap: 8px;">
        <a href="<?=base_url('users/patient/export_csv?' . http_build_query($filters));?>" class="btn btn-sm btn-success" style="border-radius: 6px; font-weight: 600; background: #10b981; border-color: #10b981;">
          <i class="fa fa-download"></i> Export Records (CSV)
        </a>
        <a href="<?=base_url('users/usercreate');?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
          <i class="fa fa-user-plus"></i> Register Patient
        </a>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 15px 20px;">
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 15px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <!-- KPI Metric Cards -->
    <div class="row" style="margin-bottom: 16px;">
      <div class="col-md-3 col-sm-6">
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <div style="width: 48px; height: 48px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-users"></i>
          </div>
          <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Total Patients</div>
            <div style="font-size: 20px; font-weight: 800; color: #0f172a;"><?=number_format(@$total_all_patients ?: count($patients));?></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <div style="width: 48px; height: 48px; border-radius: 10px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-check-circle"></i>
          </div>
          <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Active Accounts</div>
            <div style="font-size: 20px; font-weight: 800; color: #0f172a;"><?=number_format(@$total_active_patients ?: 0);?></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <div style="width: 48px; height: 48px; border-radius: 10px; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-calendar-check-o"></i>
          </div>
          <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Total Bookings</div>
            <div style="font-size: 20px; font-weight: 800; color: #0f172a;"><?=number_format(@$total_bookings ?: 0);?></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div style="background: #ffffff; border-radius: 8px; padding: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <div style="width: 48px; height: 48px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-gift"></i>
          </div>
          <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase;">Reward Points Pool</div>
            <div style="font-size: 20px; font-weight: 800; color: #0f172a;"><?=number_format(@$total_wallet_points ?: 0);?> <small style="font-size: 11px; font-weight: 600; color: #b45309;">pts</small></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Card -->
    <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden;">
      
      <!-- Toolbar & Filter Form -->
      <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #fafafa;">
        <form action="<?=base_url('users/patient')?>" method="get" class="row" style="margin: 0;">
          <div class="col-md-3 col-sm-6" style="padding: 4px;">
            <input type="text" class="form-control" name="keyword" placeholder="Search Name, Email, Medical ID..." value="<?=html_escape($filters['keyword']);?>" style="height: 38px; border-radius: 6px; font-size: 13px;">
          </div>
          <div class="col-md-3 col-sm-6" style="padding: 4px;">
            <input type="text" class="form-control" name="mobile" placeholder="Search Mobile No..." value="<?=html_escape($filters['mobile']);?>" style="height: 38px; border-radius: 6px; font-size: 13px;">
          </div>
          <div class="col-md-2 col-sm-4" style="padding: 4px;">
            <select name="blood_group" class="form-control" style="height: 38px; border-radius: 6px; font-size: 13px;">
              <option value="">Blood Group (All)</option>
              <?php foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg): ?>
                <option value="<?=$bg?>" <?=$filters['blood_group']==$bg ? 'selected' : '';?>><?=$bg?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-2 col-sm-4" style="padding: 4px;">
            <select name="status" class="form-control" style="height: 38px; border-radius: 6px; font-size: 13px;">
              <option value="">Status (All)</option>
              <option value="1" <?=$filters['status']==='1' ? 'selected' : '';?>>Active</option>
              <option value="2" <?=$filters['status']==='2' ? 'selected' : '';?>>Blocked</option>
            </select>
          </div>
          <div class="col-md-2 col-sm-4" style="padding: 4px; display: flex; gap: 6px;">
            <button type="submit" class="btn btn-primary" style="height: 38px; flex: 1; border-radius: 6px; background: #00a896; border-color: #00a896; font-weight: 600;">
              <i class="fa fa-filter"></i> Filter
            </button>
            <?php if(!empty($filters['keyword']) || !empty($filters['mobile']) || !empty($filters['blood_group']) || !empty($filters['status'])): ?>
              <a href="<?=base_url('users/patient')?>" class="btn btn-default" style="height: 38px; border-radius: 6px; line-height: 24px;" title="Clear Filters">
                <i class="fa fa-times text-danger"></i>
              </a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <!-- Data Table -->
      <div class="table-responsive" style="padding: 0;">
        <table class="table table-hover table-striped" style="margin: 0; font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569;">
            <tr>
              <th style="padding: 12px 16px; width: 140px;">Medical ID</th>
              <th>Patient Profile</th>
              <th>Contact Details</th>
              <th style="text-align: center; width: 100px;">Blood Group</th>
              <th style="text-align: center; width: 90px;">Bookings</th>
              <th style="text-align: center; width: 120px;">Upchar Wallet</th>
              <th style="text-align: center; width: 100px;">Status</th>
              <th style="text-align: center; width: 150px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($patients)): foreach ($patients as $p): ?>
              <tr id="patient-row-<?=$p['USERID'];?>">
                <td style="padding: 12px 16px; font-weight: 700;">
                  <span class="label" style="background: #e6fffa; color: #00a896; border: 1px solid #b2f5ea; font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                    <?=html_escape($p['medical_id']);?>
                  </span>
                  <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">#UID: <?=$p['USERID'];?></div>
                </td>
                <td>
                  <strong style="color: #1e293b; font-size: 13.5px;"><?=html_escape($p['FNAME'].' '.$p['LNAME']);?></strong>
                  <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                    <?=html_escape($p['GENDER'] ?: 'Gender: Unspecified');?> &bull; <?=html_escape($p['DOB'] ? 'DOB: '.$p['DOB'] : 'Age: N/A');?>
                  </div>
                </td>
                <td>
                  <div style="color: #334155; font-size: 12.5px;"><i class="fa fa-phone text-muted" style="width: 14px;"></i> <?=html_escape($p['MOBILE']);?></div>
                  <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;"><i class="fa fa-envelope-o text-muted" style="width: 14px;"></i> <?=html_escape($p['EMAIL'] ?: 'N/A');?></div>
                </td>
                <td style="text-align: center;">
                  <?php if (!empty($p['BGROUP'])): ?>
                    <span class="label label-danger" style="background-color: #fee2e2 !important; color: #dc2626 !important; border: 1px solid #fecaca; font-weight: 700; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                      <?=html_escape($p['BGROUP']);?>
                    </span>
                  <?php else: ?>
                    <span style="color: #94a3b8;">--</span>
                  <?php endif; ?>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 12px; font-weight: 700; padding: 4px 8px;">
                    <?=intval($p['total_appointments']);?>
                  </span>
                </td>
                <td style="text-align: center;">
                  <span class="label" style="background: #fef3c7; color: #d97706; border: 1px solid #fde68a; font-weight: 700; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                    <i class="fa fa-star" style="color: #f59e0b;"></i> <?=floatval($p['wallet_points']);?> Pts
                  </span>
                </td>
                <td style="text-align: center;">
                  <button type="button" onclick="togglePatientStatus(<?=$p['USERID'];?>)" id="status-btn-<?=$p['USERID'];?>" class="btn btn-xs label label-<?=$p['STATUS']=='1' ? 'success' : 'danger';?>" style="border: none; cursor: pointer; font-size: 10.5px; padding: 4px 8px; border-radius: 4px;" title="Click to toggle status">
                    <?=$p['STATUS']=='1' ? 'ACTIVE' : 'BLOCKED';?>
                  </button>
                </td>
                <td style="text-align: center;">
                  <div style="display: flex; gap: 4px; justify-content: center;">
                    <button type="button" onclick="openPatientDossier(<?=$p['USERID'];?>)" class="btn btn-xs btn-info" style="border-radius: 4px; font-weight: 600; background: #0284c7; border-color: #0284c7;" title="View Complete Dossier">
                      <i class="fa fa-folder-open-o"></i> Dossier
                    </button>
                    <button type="button" onclick="openPasswordModal(<?=$p['USERID'];?>, '<?=html_escape(addslashes($p['FNAME'].' '.$p['LNAME']));?>')" class="btn btn-xs btn-warning" style="border-radius: 4px; font-weight: 600; background: #f59e0b; border-color: #f59e0b;" title="Reset Password">
                      <i class="fa fa-key"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr>
                <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                  <i class="fa fa-users fa-3x" style="opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                  No patient records found matching your filters.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination Footer -->
      <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <span style="font-size: 13px; color: #64748b;">Showing from <strong><?=$total_rows;?></strong> total patient records</span>
        <div><?=$page_links;?></div>
      </div>
    </div>
  </section>
</div>

<!-- 5-Tab Patient Dossier Modal -->
<div class="modal fade" id="patientDetailModal" tabindex="-1" role="dialog" aria-labelledby="patientDetailModalLabel">
  <div class="modal-dialog modal-lg" style="width: 85%; max-width: 1100px; margin-top: 50px;">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 20px 30px rgba(0,0,0,0.15);">
      
      <!-- Modal Header -->
      <div class="modal-header" style="background: #00a896; color: #ffffff; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 18px;">
            <i class="fa fa-user"></i>
          </div>
          <div>
            <h4 class="modal-title" style="font-weight: 700; font-size: 17px; margin: 0;">
              <span id="modal-patient-name">Patient Profile</span>
            </h4>
            <span id="modal-patient-medical-id" class="label" style="background: rgba(255,255,255,0.25); font-size: 11px; margin-top: 4px; display: inline-block;"></span>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; font-size: 26px; line-height: 1;">&times;</button>
      </div>

      <!-- Modal Body with Tabs -->
      <div class="modal-body" style="padding: 0;">
        <ul class="nav nav-tabs" style="background: #f8fafc; padding: 12px 20px 0; border-bottom: 1px solid #e2e8f0; font-weight: 600; font-size: 13px;">
          <li class="active"><a href="#tab-overview" data-toggle="tab"><i class="fa fa-user-circle"></i> 1. Overview & Profile</a></li>
          <li><a href="#tab-appointments" data-toggle="tab"><i class="fa fa-calendar-check-o"></i> 2. Appointments (<span id="count-appts">0</span>)</a></li>
          <li><a href="#tab-medical" data-toggle="tab"><i class="fa fa-stethoscope"></i> 3. Medical History (<span id="count-meds">0</span>)</a></li>
          <li><a href="#tab-payments" data-toggle="tab"><i class="fa fa-credit-card"></i> 4. Payments & Financials</a></li>
          <li><a href="#tab-rewards" data-toggle="tab"><i class="fa fa-gift"></i> 5. Wallet & Rewards</a></li>
        </ul>

        <div class="tab-content" style="padding: 24px; min-height: 380px;">
          
          <!-- Tab 1: Overview -->
          <div class="tab-pane active" id="tab-overview">
            <div class="row">
              <div class="col-md-6">
                <h5 style="font-weight: 700; color: #334155; border-bottom: 2px solid #00a896; padding-bottom: 6px; margin-top: 0;">
                  <i class="fa fa-id-card-o text-primary"></i> Demographic Information
                </h5>
                <style>
                  .patient-info-table tr > th:first-child,
                  .patient-info-table tr > td:first-child {
                    width: 38% !important;
                    background-color: #f1f5f9 !important;
                    color: #1e293b !important;
                    font-weight: 600 !important;
                    vertical-align: middle !important;
                    border-color: #e2e8f0 !important;
                  }
                  .patient-info-table tr > td:last-child {
                    background-color: #ffffff !important;
                    color: #0f172a !important;
                    font-weight: 500 !important;
                    vertical-align: middle !important;
                    border-color: #e2e8f0 !important;
                  }
                </style>
                <table class="table table-bordered table-sm patient-info-table" style="font-size: 13px; margin-top: 10px;">
                  <tr><th>Full Name</th><td id="dt-name">--</td></tr>
                  <tr><th>Mobile Number</th><td id="dt-mobile">--</td></tr>
                  <tr><th>Email Address</th><td id="dt-email">--</td></tr>
                  <tr><th>DOB / Gender</th><td id="dt-dob-gender">--</td></tr>
                  <tr><th>Blood Group</th><td id="dt-blood">--</td></tr>
                  <tr><th>Height / Weight</th><td id="dt-vitals">--</td></tr>
                  <tr><th>Registration Date</th><td id="dt-regdate">--</td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <h5 style="font-weight: 700; color: #334155; border-bottom: 2px solid #00a896; padding-bottom: 6px; margin-top: 0;">
                  <i class="fa fa-users text-primary"></i> Family Dependents
                </h5>
                <div id="dt-dependents-wrapper" style="margin-top: 10px;"></div>
              </div>
            </div>
          </div>

          <!-- Tab 2: Appointments -->
          <div class="tab-pane" id="tab-appointments">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" style="font-size: 12.5px;">
                <thead style="background: #f8fafc; color: #475569;">
                  <tr>
                    <th>Date & Slot</th>
                    <th>Doctor Assigned</th>
                    <th>Speciality</th>
                    <th>Facility</th>
                    <th>Fee</th>
                    <th style="text-align: center;">Status</th>
                  </tr>
                </thead>
                <tbody id="dt-appointments-body"></tbody>
              </table>
            </div>
          </div>

          <!-- Tab 3: Medical History -->
          <div class="tab-pane" id="tab-medical">
            <div id="dt-medical-timeline"></div>
          </div>

          <!-- Tab 4: Payments -->
          <div class="tab-pane" id="tab-payments">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" style="font-size: 12.5px;">
                <thead style="background: #f8fafc; color: #475569;">
                  <tr>
                    <th>Transaction Code</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th style="text-align: center;">Status</th>
                    <th>Date / Time</th>
                  </tr>
                </thead>
                <tbody id="dt-payments-body"></tbody>
              </table>
            </div>
          </div>

          <!-- Tab 5: Rewards -->
          <div class="tab-pane" id="tab-rewards">
            <div class="row" style="margin-bottom: 16px;">
              <div class="col-md-4">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; text-align: center;">
                  <small style="color: #1e40af; font-weight: 700;">CURRENT BALANCE</small>
                  <h3 style="margin: 6px 0; color: #1d4ed8; font-weight: 800;" id="dt-wallet-balance">0 Pts</h3>
                </div>
              </div>
              <div class="col-md-4">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; text-align: center;">
                  <small style="color: #166534; font-weight: 700;">LIFETIME EARNED</small>
                  <h3 style="margin: 6px 0; color: #15803d; font-weight: 800;" id="dt-wallet-earned">0 Pts</h3>
                </div>
              </div>
              <div class="col-md-4">
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; text-align: center;">
                  <small style="color: #991b1b; font-weight: 700;">REDEEMED POINTS</small>
                  <h3 style="margin: 6px 0; color: #b91c1c; font-weight: 800;" id="dt-wallet-spent">0 Pts</h3>
                </div>
              </div>
            </div>
            <h5 style="font-weight: 700; color: #334155; margin-bottom: 10px;">
              <i class="fa fa-history text-muted"></i> Points Ledger History
            </h5>
            <div class="table-responsive">
              <table class="table table-bordered table-striped" style="font-size: 12px;">
                <thead style="background: #f8fafc;">
                  <tr><th>Date</th><th>Type</th><th>Points</th><th>Balance After</th><th>Description</th></tr>
                </thead>
                <tbody id="dt-rewards-body"></tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer" style="background: #f8fafc; padding: 12px 24px; border-top: 1px solid #e2e8f0;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Admin Password Reset Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" style="margin-top: 100px;">
    <div class="modal-content" style="border-radius: 10px; overflow: hidden; border: none;">
      <div class="modal-header" style="background: #f59e0b; color: #ffffff; padding: 12px 20px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; font-size: 15px;"><i class="fa fa-key"></i> Reset Patient Password</h4>
      </div>
      <form action="<?=base_url('users/patient/reset_password');?>" method="post" id="reset-password-form">
        <div class="modal-body" style="padding: 20px;">
          <input type="hidden" name="patient_id" id="reset_patient_id">
          <div style="margin-bottom: 12px; font-size: 13px; color: #475569;">
            Patient: <strong id="reset_patient_name" style="color: #0f172a;"></strong>
          </div>
          <div class="form-group">
            <label style="font-size: 12px; font-weight: 700; color: #334155;">New Password</label>
            <div class="input-group">
              <input type="text" name="new_password" id="reset_new_password" required class="form-control" placeholder="Enter new password..." style="border-radius: 6px 0 0 6px;">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" onclick="generateRandomPassword()" title="Generate Random Password" style="border-radius: 0 6px 6px 0;">
                  <i class="fa fa-magic text-warning"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background: #f8fafc; padding: 10px 20px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning" style="font-weight: 600; background: #f59e0b; border-color: #f59e0b;">Update Password</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openPatientDossier(patientId) {
  $('#patientDetailModal').modal('show');
  
  // Set loading placeholders
  $('#modal-patient-name').text('Loading Patient Details...');
  $('#modal-patient-medical-id').text('');
  $('#dt-appointments-body').html('<tr><td colspan="6" class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i> Loading appointments...</td></tr>');
  $('#dt-medical-timeline').html('<div class="text-center text-muted" style="padding: 30px;"><i class="fa fa-spinner fa-spin"></i> Loading medical records...</div>');
  $('#dt-payments-body').html('<tr><td colspan="5" class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i> Loading payments...</td></tr>');
  $('#dt-rewards-body').html('<tr><td colspan="5" class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i> Loading reward points...</td></tr>');

  fetch('<?=base_url("users/patient/details_ajax/");?>' + patientId + '?ajax=1')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const p = data.profile;
        $('#modal-patient-name').text(p.FNAME + ' ' + (p.LNAME || ''));
        $('#modal-patient-medical-id').text(p.medical_id);

        $('#dt-name').text(p.FNAME + ' ' + (p.LNAME || ''));
        $('#dt-mobile').text(p.MOBILE);
        $('#dt-email').text(p.EMAIL || 'N/A');
        $('#dt-dob-gender').text((p.DOB || 'N/A') + ' / ' + (p.GENDER || 'N/A'));
        $('#dt-blood').text(p.BGROUP || 'Not Specified');
        $('#dt-vitals').text((p.HEIGHT ? p.HEIGHT + ' cm' : '-') + ' / ' + (p.WEIGHT ? p.WEIGHT + ' kg' : '-'));
        $('#dt-regdate').text(p.REG_DATE || 'N/A');

        // Dependents
        let depHtml = '<ul class="list-group" style="margin: 0;">';
        if (p.dependents && p.dependents.length > 0) {
          p.dependents.forEach(d => {
            depHtml += '<li class="list-group-item" style="font-size: 12px; display: flex; justify-content: space-between;"><span><strong>' + d.name + '</strong> (' + d.relationship + ')</span> <span class="label label-default">' + (d.blood_group || 'Blood: N/A') + '</span></li>';
          });
        } else {
          depHtml += '<li class="list-group-item text-muted" style="font-size: 12px;">No family dependents registered</li>';
        }
        depHtml += '</ul>';
        $('#dt-dependents-wrapper').html(depHtml);

        // Appointments
        $('#count-appts').text(data.appointments.length);
        let apptHtml = '';
        if (data.appointments.length > 0) {
          data.appointments.forEach(a => {
            let stBadge = '<span class="label label-info">' + a.booking_status + '</span>';
            if (a.booking_status === '1' || a.booking_status === 'COMPLETED') stBadge = '<span class="label label-success">COMPLETED</span>';
            else if (a.booking_status === '0' || a.booking_status === 'PENDING') stBadge = '<span class="label label-warning">PENDING</span>';
            else if (a.booking_status === 'CANCELLED') stBadge = '<span class="label label-danger">CANCELLED</span>';

            apptHtml += '<tr>';
            apptHtml += '<td><strong>' + a.appointment_date + '</strong><br><small class="text-muted">' + a.from_timing + ' - ' + a.to_timing + '</small></td>';
            apptHtml += '<td>Dr. ' + a.dr_fname + ' ' + (a.dr_lname || '') + '</td>';
            apptHtml += '<td>' + a.dr_speciality + '</td>';
            apptHtml += '<td>' + a.facility_name + '</td>';
            apptHtml += '<td>Rs. ' + a.fee + '</td>';
            apptHtml += '<td style="text-align: center;">' + stBadge + '</td>';
            apptHtml += '</tr>';
          });
        } else {
          apptHtml = '<tr><td colspan="6" class="text-center text-muted" style="padding: 20px;">No appointments recorded for this patient.</td></tr>';
        }
        $('#dt-appointments-body').html(apptHtml);

        // Medical History
        $('#count-meds').text(data.medical_history.length);
        let medHtml = '';
        if (data.medical_history.length > 0) {
          data.medical_history.forEach(m => {
            medHtml += '<div style="background: #f8fafc; border-left: 4px solid #00a896; padding: 14px; margin-bottom: 12px; border-radius: 4px;">';
            medHtml += '<div style="display: flex; justify-content: space-between;"><strong style="color: #0f172a; font-size: 14px;">Diagnosis: ' + (m.diagnosis_assessment || 'Clinical Assessment') + '</strong><span style="font-size: 11.5px; color: #64748b;">' + m.created_at + '</span></div>';
            medHtml += '<div style="font-size: 12.5px; color: #475569; margin-top: 4px;"><strong>Consultant:</strong> Dr. ' + m.dr_fname + ' ' + (m.dr_lname || '') + ' (' + m.dr_speciality + ') &bull; <em>' + m.hospital_name + '</em></div>';
            if (m.symptoms_subjective) medHtml += '<div style="font-size: 12px; margin-top: 4px;"><strong>Symptoms:</strong> ' + m.symptoms_subjective + '</div>';
            if (m.treatment_plan) medHtml += '<div style="font-size: 12px; margin-top: 4px;"><strong>Treatment Plan:</strong> ' + m.treatment_plan + '</div>';
            if (m.pdf_url) medHtml += '<div style="margin-top: 8px;"><a href="' + m.pdf_url + '" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600;"><i class="fa fa-file-pdf-o text-danger"></i> View Prescription PDF</a></div>';
            medHtml += '</div>';
          });
        } else {
          medHtml = '<div class="text-center text-muted" style="padding: 30px;">No previous prescriptions or doctor notes logged.</div>';
        }
        $('#dt-medical-timeline').html(medHtml);

        // Payments
        let payHtml = '';
        if (data.payments.length > 0) {
          data.payments.forEach(py => {
            payHtml += '<tr>';
            payHtml += '<td style="font-weight: 600; color: #0284c7;">' + py.txn_code + '</td>';
            payHtml += '<td>' + (py.category || 'Consultation') + '</td>';
            payHtml += '<td style="font-weight: 700;">Rs. ' + parseFloat(py.gross_amount).toFixed(2) + '</td>';
            payHtml += '<td style="text-align: center;"><span class="label label-success">' + (py.payment_status || 'PAID') + '</span></td>';
            payHtml += '<td>' + py.created_at + '</td>';
            payHtml += '</tr>';
          });
        } else {
          payHtml = '<tr><td colspan="5" class="text-center text-muted" style="padding: 20px;">No transaction logs available for this patient.</td></tr>';
        }
        $('#dt-payments-body').html(payHtml);

        // Rewards
        $('#dt-wallet-balance').text(parseFloat(data.rewards.wallet.points_balance || 0).toFixed(2) + ' Pts');
        $('#dt-wallet-earned').text(parseFloat(data.rewards.wallet.lifetime_earned || 0).toFixed(2) + ' Pts');
        $('#dt-wallet-spent').text(parseFloat(data.rewards.wallet.lifetime_spent || 0).toFixed(2) + ' Pts');

        let rewHtml = '';
        if (data.rewards.transactions && data.rewards.transactions.length > 0) {
          data.rewards.transactions.forEach(t => {
            let isCredit = (t.type === 'CREDIT' || t.type === 'EARNED');
            rewHtml += '<tr>';
            rewHtml += '<td>' + t.created_at + '</td>';
            rewHtml += '<td><span class="label label-' + (isCredit ? 'success' : 'danger') + '">' + t.type + '</span></td>';
            rewHtml += '<td style="font-weight: 700;">' + (isCredit ? '+' : '-') + parseFloat(t.amount_points).toFixed(2) + '</td>';
            rewHtml += '<td>' + parseFloat(t.balance_after || 0).toFixed(2) + '</td>';
            rewHtml += '<td>' + (t.description || '-') + '</td>';
            rewHtml += '</tr>';
          });
        } else {
          rewHtml = '<tr><td colspan="5" class="text-center text-muted" style="padding: 20px;">No reward points transactions on record.</td></tr>';
        }
        $('#dt-rewards-body').html(rewHtml);
      }
    });
}

function openPasswordModal(patientId, name) {
  $('#reset_patient_id').val(patientId);
  $('#reset_patient_name').text(name);
  $('#reset_new_password').val('');
  $('#resetPasswordModal').modal('show');
}

function generateRandomPassword() {
  const chars = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789@#$";
  let pwd = "";
  for (let i = 0; i < 10; i++) {
    pwd += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  $('#reset_new_password').val(pwd);
}

function togglePatientStatus(patientId) {
  if (!confirm('Toggle status for this patient account?')) return;
  fetch('<?=base_url("users/patient/toggle_status");?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
    body: 'patient_id=' + patientId
  })
  .then(r => r.json())
  .then(res => {
    if (res.status === 'success') {
      const btn = document.getElementById('status-btn-' + patientId);
      if (btn) {
        btn.textContent = res.status_label;
        btn.className = 'btn btn-xs label label-' + (res.new_status === '1' ? 'success' : 'danger');
      }
    }
  });
}
</script>
