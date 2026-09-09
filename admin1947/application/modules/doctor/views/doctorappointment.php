<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">
          <?php if(!empty($selected_doctor)): ?>
            Doctor Appointments: Dr. <?=htmlspecialchars($selected_doctor->fname . ' ' . $selected_doctor->lname);?>
          <?php else: ?>
            Doctor Appointments Management
          <?php endif; ?>
        </h1>
        <small style="color: #64748b; font-size: 13px;">
          <?php if(!empty($selected_doctor)): ?>
            Viewing consultation bookings, schedule, and patient history for Dr. <?=htmlspecialchars($selected_doctor->fname);?>
          <?php else: ?>
            Manage doctor consultation bookings, patient visits, and appointment records across all specialists
          <?php endif; ?>
        </small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">
          <?=!empty($selected_doctor) ? 'Dr. ' . htmlspecialchars($selected_doctor->fname) : 'Doctor Wise';?>
        </li>
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

      <!-- Quick Doctor Switcher / Filter Toolbar -->
      <div class="master-card" style="margin-bottom: 18px; background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 14px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
          <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1;">
            <label for="doctor-filter-select" style="font-size: 13px; font-weight: 700; color: #334155; margin: 0;">
              <i class="fa fa-filter" style="color: #00a896;"></i> Filter By Doctor:
            </label>
            <select id="doctor-filter-select" class="form-control" style="width: auto; min-width: 280px; max-width: 420px; height: 38px; border-radius: 8px; font-size: 13px;" onchange="if(this.value) window.location.href=this.value;">
              <option value="<?=base_url('doctor/appointment/doctorappointment');?>">-- All Doctors (System-wide) --</option>
              <?php if(!empty($all_doctors)): foreach($all_doctors as $d): 
                $sel = (!empty($selected_doctor) && ($selected_doctor->id == $d->id || $selected_doctor->user_id == $d->id || $selected_doctor->user_id == $d->user_id)) ? 'selected' : '';
              ?>
                <option value="<?=base_url('doctor/appointment/doctorappointment?doctor='.$d->id);?>" <?=$sel;?>>
                  Dr. <?=htmlspecialchars(trim($d->fname . ' ' . $d->lname));?> (<?=htmlspecialchars($d->speciality ?: 'General');?> - #<?=$d->id;?>)
                </option>
              <?php endforeach; endif; ?>
            </select>
            <?php if(!empty($selected_doctor)): ?>
              <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="btn btn-sm btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 14px;">
                <i class="fa fa-times text-danger"></i> Clear Filter
              </a>
            <?php endif; ?>
          </div>

          <div style="display: flex; gap: 8px; align-items: center;">
            <a href="<?=base_url('doctor/appointment/analytics');?>" class="btn btn-sm btn-info" style="border-radius: 8px; font-weight: 600; background: #0284c7; border-color: #0284c7; padding: 8px 16px;">
              <i class="fa fa-bar-chart"></i> Appointment Analytics
            </a>
            <a href="<?=base_url('doctor/appointment/addappointment' . (!empty($selected_doctor) ? '?doctor='.$selected_doctor->id : ''));?>" class="btn btn-sm btn-primary" style="border-radius: 8px; font-weight: 600; background: #00a896; border-color: #00a896; padding: 8px 18px;">
              <i class="fa fa-plus"></i> Book Appointment
            </a>
          </div>
        </div>
      </div>

      <?php if(!empty($selected_doctor)): 
        $docImg = (!empty($selected_doctor->drimage) && file_exists(FCPATH . 'public/assets/upload/' . $selected_doctor->drimage)) ? base_url('public/assets/upload/' . $selected_doctor->drimage) : base_url('public/assets/upload/dummydr.jpg');
        $specName = htmlspecialchars(!empty($selected_doctor->speciality_name) ? $selected_doctor->speciality_name : 'General Practitioner');
        $mTotal = intval($doctor_metrics['total_appointments'] ?? count($data));
        $mConfirmed = intval($doctor_metrics['confirmed_count'] ?? 0);
        $mPending = intval($doctor_metrics['pending_count'] ?? 0);
        $mToday = intval($doctor_metrics['today_bookings'] ?? 0);
      ?>
        <!-- DOCTOR INTELLIGENCE DOSSIER & METRICS BANNER -->
        <div class="master-card" style="margin-bottom: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
          <!-- Header Banner -->
          <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 22px 24px; color: #ffffff;">
            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap; gap: 16px;">
              <div class="col-md-auto" style="text-align: center;">
                <div style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #00a896; overflow: hidden; background: #334155; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                  <img src="<?=$docImg;?>" alt="Doctor Photo" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?=base_url('public/assets/upload/dummydr.jpg');?>';">
                </div>
              </div>
              
              <div class="col-md" style="flex-grow: 1;">
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;">
                  <h2 style="font-size: 20px; font-weight: 800; margin: 0; color: #ffffff;">
                    Dr. <?=htmlspecialchars(trim($selected_doctor->fname . ' ' . $selected_doctor->lname));?>
                  </h2>
                  <span class="label" style="background: #00a896; color: #ffffff; font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">
                    <?=$specName;?>
                  </span>
                  <?php if($selected_doctor->status == '1'): ?>
                    <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                      <i class="fa fa-check-circle"></i> Active &amp; Verified
                    </span>
                  <?php else: ?>
                    <span class="label label-warning" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">Under Review</span>
                  <?php endif; ?>
                </div>

                <div style="display: flex; gap: 16px; flex-wrap: wrap; font-size: 12.5px; color: #cbd5e1;">
                  <div><i class="fa fa-id-card-o text-muted"></i> <strong>Reg No:</strong> <?=htmlspecialchars($selected_doctor->regd_no ?: 'N/A');?> (<?=$selected_doctor->regd_year ?: 'Year';?>)</div>
                  <div><i class="fa fa-graduation-cap text-muted"></i> <strong>College:</strong> <?=htmlspecialchars($selected_doctor->college ?: 'N/A');?> (<?=$selected_doctor->year ?: '-';?>)</div>
                  <div><i class="fa fa-history text-muted"></i> <strong>Experience:</strong> <?=htmlspecialchars($selected_doctor->exp ? $selected_doctor->exp.' Years' : 'N/A');?></div>
                  <div><i class="fa fa-phone text-muted"></i> <strong>Contact:</strong> <?=htmlspecialchars($selected_doctor->mobile ?: 'N/A');?></div>
                  <div><i class="fa fa-envelope-o text-muted"></i> <strong>Email:</strong> <?=htmlspecialchars($selected_doctor->email ?: 'N/A');?></div>
                </div>

                <?php if(!empty($doctor_affiliations)): ?>
                  <div style="margin-top: 10px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 12px;">
                    <span style="color: #94a3b8; font-weight: 600;"><i class="fa fa-hospital-o"></i> Affiliated Facilities:</span>
                    <?php foreach($doctor_affiliations as $aff): ?>
                      <span class="label" style="background: rgba(255,255,255,0.12); color: #f8fafc; border: 1px solid rgba(255,255,255,0.2); font-weight: 500; padding: 3px 8px; border-radius: 4px;">
                        <?=htmlspecialchars($aff->hospital_name ?: 'Facility Chamber');?> 
                        <?php if($aff->fee > 0): ?><strong style="color: #5eead4;">(&#8377;<?=number_format($aff->fee);?>)</strong><?php endif; ?>
                      </span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- 4 Responsive Metric KPI Cards -->
          <div style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0;">
            <div class="row" style="margin: 0 -8px;">
              <div class="col-lg-3 col-sm-6" style="padding: 6px 8px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                  <div style="width: 44px; height: 44px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-calendar-check-o"></i>
                  </div>
                  <div>
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">Total Appointments</div>
                    <div style="font-size: 20px; font-weight: 800; color: #0f172a;"><?=number_format($mTotal);?></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-sm-6" style="padding: 6px 8px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                  <div style="width: 44px; height: 44px; border-radius: 8px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-check-circle"></i>
                  </div>
                  <div>
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">Confirmed / Completed</div>
                    <div style="font-size: 20px; font-weight: 800; color: #16a34a;"><?=number_format($mConfirmed);?></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-sm-6" style="padding: 6px 8px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                  <div style="width: 44px; height: 44px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <div>
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">Pending Review</div>
                    <div style="font-size: 20px; font-weight: 800; color: #d97706;"><?=number_format($mPending);?></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-sm-6" style="padding: 6px 8px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                  <div style="width: 44px; height: 44px; border-radius: 8px; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-calendar-o"></i>
                  </div>
                  <div>
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">Today's Bookings</div>
                    <div style="font-size: 20px; font-weight: 800; color: #7c3aed;"><?=number_format($mToday);?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- APPOINTMENTS TABLE CARD -->
      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.05); overflow: hidden;">
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <h3 class="master-card-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #1e293b;">
            <i class="fa fa-calendar-check-o" style="color: #00a896;"></i>
            <span>
              <?=!empty($selected_doctor) ? 'Appointments for Dr. ' . htmlspecialchars($selected_doctor->fname) : 'Consultation Appointments List';?>
              <span class="badge bg-teal" style="font-size: 12px; margin-left: 6px;"><?=count($data);?> records</span>
            </span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-app-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="app-selected-count">0</span>)
            </button>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Responsive Table Container -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="table table-hover table-striped" id="appointment-table" style="margin: 0; font-size: 13px; width: 100%;">
              <thead>
                <tr style="background: #f8fafc; color: #475569;">
                  <th style="width: 36px; text-align: center;">
                    <input type="checkbox" id="select-all-apps" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 55px; text-align: center;">#ID</th>
                  <th>Patient Details</th>
                  <th>Appointment Slot</th>
                  <th>Consultation Facility</th>
                  <th>Consulting Doctor</th>
                  <th>Fee &amp; Payment</th>
                  <th style="text-align: center; width: 110px;">Status</th>
                  <th style="width: 100px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if(!empty($data)): foreach($data as $p): 
                  $aid = is_object($p) ? $p->appointment_id : (!empty($p['appointment_id']) ? $p['appointment_id'] : 0);
                  $pname = is_object($p) ? $p->appointment_name : (!empty($p['appointment_name']) ? $p['appointment_name'] : 'Patient');
                  $adate = is_object($p) ? $p->appointment_date : (!empty($p['appointment_date']) ? $p['appointment_date'] : '');
                  $time = is_object($p) ? ($p->from_timing . ' - ' . $p->to_timing) : '';
                  if(empty($time) && !empty($p->appointment_time)) $time = $p->appointment_time;
                  $mobile = is_object($p) ? $p->appointment_mobile : (!empty($p['appointment_mobile']) ? $p['appointment_mobile'] : '');
                  $email = is_object($p) ? $p->appointment_email : (!empty($p['appointment_email']) ? $p['appointment_email'] : '');
                  $age = is_object($p) ? (!empty($p->age) ? $p->age : '') : '';
                  $hname = is_object($p) ? (!empty($p->hospital_name) ? $p->hospital_name : 'Consultation Facility') : 'Consultation Facility';
                  $hcity = is_object($p) ? (!empty($p->hospital_city) ? $p->hospital_city : '') : '';
                  $raw_dname = is_object($p) ? (!empty($p->dr_fname) ? ($p->dr_fname . ' ' . $p->dr_lname) : 'Consulting Doctor') : 'Consulting Doctor';
                  $dname = (stripos(trim($raw_dname), 'Dr.') === 0 || stripos(trim($raw_dname), 'Dr ') === 0) ? $raw_dname : ('Dr. ' . $raw_dname);
                  $feeVal = is_object($p) ? (floatval($p->fee ?: $p->amount)) : 0;
                  $payMode = is_object($p) ? ($p->payment_mode ?: 'Cash/OPD') : 'Cash/OPD';
                  
                  // Status badge logic
                  $st = is_object($p) ? strval($p->status) : '';
                  if ($st === '1' || strtoupper($st) === 'COMPLETED' || strtoupper($st) === 'CONFIRMED') {
                    $stBadge = '<span class="label label-success" style="background-color: #dcfce7 !important; color: #15803d !important; border: 1px solid #bbf7d0; font-weight: 700; font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-check-circle"></i> Confirmed</span>';
                  } elseif ($st === '2' || strtoupper($st) === 'CANCELLED') {
                    $stBadge = '<span class="label label-danger" style="background-color: #fee2e2 !important; color: #b91c1c !important; border: 1px solid #fecaca; font-weight: 700; font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-times-circle"></i> Cancelled</span>';
                  } else {
                    $stBadge = '<span class="label label-warning" style="background-color: #fef3c7 !important; color: #b45309 !important; border: 1px solid #fde68a; font-weight: 700; font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-clock-o"></i> Pending</span>';
                  }
                ?>
                  <tr id="row-<?=$aid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="app-checkbox" value="<?=$aid;?>" data-name="<?=htmlspecialchars($pname);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">#<?=$aid;?></td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($pname);?></strong>
                      <?php if($age): ?><span style="font-size: 11px; color: #64748b; margin-left: 4px;">(Age: <?=$age;?>)</span><?php endif; ?>
                      <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                        <?php if($mobile): ?><span><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($mobile);?></span><?php endif; ?>
                        <?php if($email): ?><span style="margin-left: 8px;"><i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($email);?></span><?php endif; ?>
                      </div>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">
                        <i class="fa fa-calendar"></i> <?=formatedate($adate);?>
                      </span>
                      <?php if(!empty($time)): ?>
                        <div style="font-size: 11.5px; color: #475569; margin-top: 4px;">
                          <i class="fa fa-clock-o text-muted"></i> <?=htmlspecialchars($time);?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #334155; font-size: 12.5px;"><i class="fa fa-hospital-o text-muted"></i> <?=htmlspecialchars($hname);?></strong>
                      <?php if($hcity): ?>
                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;"><i class="fa fa-map-marker text-muted"></i> <?=htmlspecialchars($hcity);?></div>
                      <?php endif; ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #00a896; font-size: 13px;"><i class="fa fa-user-md"></i> <?=htmlspecialchars($dname);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #0f172a; font-size: 13px;">&#8377;<?=number_format($feeVal, 2);?></strong>
                      <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                        <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-weight: 600; font-size: 10px;">
                          <?=htmlspecialchars($payMode);?>
                        </span>
                      </div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <?=$stBadge;?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <div style="display: flex; gap: 5px; justify-content: center;">
                        <a href="<?=base_url('doctor/appointment/data?appointment_id='.$aid);?>" class="btn btn-xs btn-default" style="border-radius: 4px; padding: 4px 8px;" title="View Full Details">
                          <i class="fa fa-eye text-primary"></i>
                        </a>
                        <a href="<?=base_url('doctor/appointment/delete?appointment_id='.$aid);?>" class="btn btn-xs btn-default delete-app-btn" data-id="<?=$aid;?>" data-name="<?=htmlspecialchars($pname);?>" style="border-radius: 4px; padding: 4px 8px;" title="Delete Appointment">
                          <i class="fa fa-trash-o text-danger"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment records found for this doctor.</p>
                      <?php if(!empty($selected_doctor)): ?>
                        <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="btn btn-sm btn-default" style="margin-top: 10px; border-radius: 6px;">
                          View All Appointments
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteAppModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Appointment</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete appointment for <strong id="delete-app-name" style="color: #1e293b;">this patient</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-app-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteAppModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Appointments</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-app-count" style="color: #dc2626;">0</strong> selected appointments? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-app-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete Selected
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showToast(message, type) {
  var bg = (type === 'success') ? '#10b981' : ((type === 'danger') ? '#ef4444' : '#00a896');
  var icon = (type === 'success') ? 'fa-check-circle' : ((type === 'danger') ? 'fa-exclamation-triangle' : 'fa-info-circle');
  var toastId = 'toast-' + Date.now();
  
  var toastHtml = '<div id="' + toastId + '" style="pointer-events: auto; background: #ffffff; color: #1e293b; border-left: 4px solid ' + bg + '; padding: 12px 18px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; min-width: 280px; transition: all 0.3s ease;">' +
    '<i class="fa ' + icon + '" style="color: ' + bg + '; font-size: 16px;"></i>' +
    '<span style="flex-grow: 1;">' + message + '</span>' +
    '<i class="fa fa-times" onclick="$(\'#' + toastId + '\').remove();" style="cursor: pointer; color: #94a3b8; font-size: 12px;"></i>' +
  '</div>';
  
  $('#toast-container').append(toastHtml);
  setTimeout(function(){
    $('#' + toastId).fadeOut(400, function(){ $(this).remove(); });
  }, 4000);
}

function updateAppBulkState() {
  var checkedBoxes = $('.app-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.app-checkbox').length;

  $('#app-selected-count').text(count);
  $('#bulk-app-count').text(count);

  if (count > 0) {
    $('#bulk-delete-app-btn').fadeIn(200);
  } else {
    $('#bulk-delete-app-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-apps').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-apps').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-apps').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  // Initialize responsive DataTables on appointment table
  if ($.fn.DataTable.isDataTable('#appointment-table')) {
    $('#appointment-table').DataTable().destroy();
  }
  
  var appTable = $('#appointment-table').DataTable({
    "responsive": true,
    "pageLength": 25,
    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "order": [[1, "desc"]],
    "columnDefs": [
      { "orderable": false, "targets": [0, 8] }
    ],
    "language": {
      "search": "Quick Filter:",
      "searchPlaceholder": "Search patient, hospital, doctor, date...",
      "lengthMenu": "Show _MENU_ entries",
      "info": "Showing _START_ to _END_ of _TOTAL_ appointments",
      "paginate": {
        "first": '<i class="fa fa-angle-double-left"></i>',
        "last": '<i class="fa fa-angle-double-right"></i>',
        "next": '<i class="fa fa-angle-right"></i>',
        "previous": '<i class="fa fa-angle-left"></i>'
      }
    }
  });

  // Re-bind checkbox listeners whenever DataTables redraws
  appTable.on('draw', function() {
    updateAppBulkState();
  });

  // Select all checkboxes
  $(document).on('change', '#select-all-apps', function(){
    var isChecked = $(this).is(':checked');
    $('.app-checkbox').prop('checked', isChecked);
    updateAppBulkState();
  });

  $(document).on('change', '.app-checkbox', function(){
    updateAppBulkState();
  });

  // Bulk Delete Modal
  $('#bulk-delete-app-btn').click(function(){
    var count = $('.app-checkbox:checked').length;
    if(count === 0) return;
    $('#bulkDeleteAppModal').modal('show');
  });

  $('#confirm-bulk-delete-app-btn').click(function(){
    var selectedIds = [];
    $('.app-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if(selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/appointment/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteAppModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
          });
        });

        updateAppBulkState();
        showToast(res.message || 'Selected appointments deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting appointments.', 'danger');
      }
    });
  });

  // Delete Single Appointment
  var activeDeleteAppId = null;
  $(document).on('click', '.delete-app-btn', function(e){
    e.preventDefault();
    activeDeleteAppId = $(this).data('id');
    var name = $(this).data('name') || 'this appointment';
    $('#delete-app-name').text('"' + name + '"');
    $('#deleteAppModal').modal('show');
  });

  $('#confirm-delete-app-btn').click(function(){
    if(!activeDeleteAppId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/appointment/delete')?>',
      dataType: 'json',
      data: { id: activeDeleteAppId, appointment_id: activeDeleteAppId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteAppModal').modal('hide');
        $('#row-' + activeDeleteAppId).fadeOut(400, function(){
          $(this).remove();
          updateAppBulkState();
        });
        showToast(res.message || 'Appointment deleted successfully.', 'success');
        activeDeleteAppId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/appointment/delete?appointment_id=')?>' + activeDeleteAppId;
      }
    });
  });
});
</script>
