<?php
  // Extract appointment data (support both single object and list)
  $app = !empty($appointment) ? $appointment : (!empty($data[0]) ? $data[0] : null);
  $aid = $app ? ($app->appointment_id ?? $appointment_id ?? 0) : ($appointment_id ?? 0);
?>
<style>
@media print {
  .main-header,
  .main-sidebar,
  .main-footer,
  .control-sidebar,
  .content-header,
  .no-print,
  .breadcrumb,
  .modal,
  .modal-backdrop,
  #appointmentToast {
    display: none !important;
  }

  body, html {
    background: #ffffff !important;
    color: #000000 !important;
  }
  .content-wrapper, .right-side, .main-footer {
    margin-left: 0 !important;
    padding: 0 !important;
    background: #ffffff !important;
    border: none !important;
  }
  .content {
    padding: 10px 0 !important;
  }

  .print-only-header {
    display: block !important;
    margin-bottom: 15px !important;
  }

  div, section, table, td, th {
    box-shadow: none !important;
    text-shadow: none !important;
  }

  .col-md-6 {
    width: 50% !important;
    float: left !important;
  }
  .col-md-3 {
    width: 25% !important;
    float: left !important;
  }

  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
}
</style>

<div class="content-wrapper">
  <!-- Print Header Only -->
  <div class="print-only-header" style="display: none;">
    <div style="text-align: center; border-bottom: 2px solid #00a896; padding-bottom: 12px; margin-bottom: 20px;">
      <h2 style="margin: 0; color: #00a896; font-weight: 700; font-size: 24px;">UPCHAR HEALTHCARE</h2>
      <p style="margin: 3px 0 0; font-size: 13px; color: #475569;">Official Patient Consultation Appointment Slip / Receipt</p>
    </div>
  </div>

  <!-- Content Header & Breadcrumbs -->
  <section class="content-header no-print" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">
          Appointment Details Dossier: #<?=$aid;?>
        </h1>
        <small style="color: #64748b; font-size: 13px;">
          Comprehensive patient consultation, doctor assignment, facility location, and payment records
        </small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">#<?=$aid;?></li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">

      <!-- Flash Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div class="no-print" style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Actions Toolbar -->
      <div class="no-print" style="margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
          <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569; border-color: #cbd5e1;">
            <i class="fa fa-arrow-left"></i> Back to Appointments
          </a>
          <a href="<?=base_url('doctor/appointment/addappointment');?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #0284c7; border-color: #bae6fd; background: #f0f9ff;">
            <i class="fa fa-plus"></i> Book Another
          </a>
        </div>
        
        <?php if($app): ?>
        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
          <!-- Quick Edit Status / Payment Modal Trigger -->
          <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#updateStatusModal" style="border-radius: 6px; font-weight: 600; background: #f59e0b; border-color: #d97706; color: #ffffff; padding: 6px 13px;">
            <i class="fa fa-pencil-square-o"></i> Update Status / Payment
          </button>

          <!-- Reassign Doctor Modal Trigger -->
          <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#reassignDoctorModal" style="border-radius: 6px; font-weight: 600; background: #f8fafc; border-color: #cbd5e1; color: #334155; padding: 6px 13px;">
            <i class="fa fa-user-md" style="color: #00a896;"></i> Reassign Doctor
          </button>

          <!-- Reschedule Modal Trigger -->
          <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#rescheduleModal" style="border-radius: 6px; font-weight: 600; background: #f8fafc; border-color: #cbd5e1; color: #334155; padding: 6px 13px;">
            <i class="fa fa-calendar" style="color: #0284c7;"></i> Reschedule
          </button>

          <!-- Print Invoice -->
          <button type="button" onclick="window.print();" class="btn btn-sm btn-info" style="border-radius: 6px; font-weight: 600; background: #0284c7; border-color: #0284c7; padding: 6px 13px;">
            <i class="fa fa-print"></i> Print Slip
          </button>

          <?php if(!empty($app->doctor_id)): ?>
            <a href="<?=base_url('doctor/appointment/doctorappointment?doctor=' . ($app->dr_profile_id ?? $app->doctor_id));?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896; padding: 6px 13px;">
              <i class="fa fa-stethoscope"></i> Doctor Schedule
            </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <?php if(!$app): ?>
        <!-- EMPTY STATE IF APPOINTMENT NOT FOUND -->
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 60px 20px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
          <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2; color: #ef4444; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 18px;">
            <i class="fa fa-calendar-times-o"></i>
          </div>
          <h3 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Appointment Record Not Found</h3>
          <p style="font-size: 14px; color: #64748b; max-width: 480px; margin: 0 auto 22px;">
            No appointment was found matching ID <strong style="color: #0f172a;">#<?=$aid;?></strong>. The record may have been permanently deleted or the ID is incorrect.
          </p>
          <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 8px; padding: 8px 24px;">
            <i class="fa fa-list"></i> View All Appointments
          </a>
        </div>
      <?php else: 
        // Compute appointment display attributes
        $pname = !empty($app->appointment_name) ? $app->appointment_name : (!empty($app->user_fname) ? trim($app->user_fname . ' ' . $app->user_lname) : 'Patient');
        $pmobile = !empty($app->appointment_mobile) ? $app->appointment_mobile : ($app->user_mobile ?? 'N/A');
        $pemail = !empty($app->appointment_email) ? $app->appointment_email : ($app->user_email ?? 'N/A');
        $page = !empty($app->age) ? $app->age : 'N/A';
        $pgender = !empty($app->user_gender) ? ($app->user_gender == 'M' ? 'Male' : ($app->user_gender == 'F' ? 'Female' : $app->user_gender)) : 'Not Specified';

        $raw_dname = !empty($app->dr_fname) ? trim($app->dr_fname . ' ' . $app->dr_lname) : '';
        $has_doctor = !empty($raw_dname);
        if ($has_doctor) {
            $dname = (stripos($raw_dname, 'Dr.') === 0 || stripos($raw_dname, 'Dr ') === 0) ? $raw_dname : ('Dr. ' . $raw_dname);
        } else {
            $dname = 'Doctor Not Assigned (ID #' . ($app->doctor_id ?: 'Unassigned') . ')';
        }

        $dspec = !empty($app->dr_speciality) ? $app->dr_speciality : 'General Consultation';
        $dmobile = !empty($app->dr_mobile) ? $app->dr_mobile : 'N/A';
        $demail = !empty($app->dr_email) ? $app->dr_email : 'N/A';
        $dreg = !empty($app->dr_regd_no) ? $app->dr_regd_no : 'N/A';
        $dexp = !empty($app->dr_exp) ? ($app->dr_exp . ' Years') : 'N/A';
        $docImg = (!empty($app->dr_image) && file_exists(FCPATH . 'public/assets/upload/' . $app->dr_image)) ? base_url('public/assets/upload/' . $app->dr_image) : base_url('public/assets/upload/dummydr.jpg');

        // Doctor verified badge logic
        if (!$has_doctor) {
            $drBadge = '<span class="label" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-size: 11px; padding: 4px 9px; border-radius: 4px; font-weight: 700;"><i class="fa fa-exclamation-triangle"></i> Doctor Profile Pending</span>';
        } elseif (!empty($app->dr_verified) && (int)$app->dr_verified === 1) {
            $drBadge = '<span class="label" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 11px; padding: 4px 9px; border-radius: 4px; font-weight: 700;"><i class="fa fa-check-circle"></i> Verified Specialist</span>';
        } else {
            $drBadge = '<span class="label" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 11px; padding: 4px 9px; border-radius: 4px; font-weight: 600;"><i class="fa fa-clock-o"></i> Verification Pending</span>';
        }

        $hname = !empty($app->facility_name) ? $app->facility_name : (!empty($app->hospital_name) ? $app->hospital_name : 'Upchar Partner Clinic / Consultation Chamber');
        $haddress = !empty($app->facility_address) ? $app->facility_address : (!empty($app->hospital_address) ? $app->hospital_address : 'Address not specified');
        $hcity = !empty($app->facility_city) ? $app->facility_city : (!empty($app->hospital_city) ? $app->hospital_city : '');
        $hmobile = !empty($app->facility_mobile) ? $app->facility_mobile : (!empty($app->hospital_mobile) ? $app->hospital_mobile : 'N/A');

        $adate = !empty($app->appointment_date) ? $app->appointment_date : 'N/A';
        $fromTime = !empty($app->from_timing) ? $app->from_timing : '';
        $toTime = !empty($app->to_timing) ? $app->to_timing : '';
        $slotTiming = ($fromTime && $toTime) ? ($fromTime . ' - ' . $toTime) : (!empty($app->appointment_time) ? $app->appointment_time : 'Standard OPD Timing');

        $feeAmount = floatval($app->amount ?: ($app->fee ?: 0));
        $payMode = (!empty($app->payment_mode) && strtoupper($app->payment_mode) !== 'NA') ? strtoupper($app->payment_mode) : 'OPD / CASH';
        $rawPay = strtoupper(trim(strval($app->payment_status ?? '')));
        $bookDate = !empty($app->book_date) ? $app->book_date : 'N/A';
        $payDate = (!empty($app->pay_date) && $app->pay_date !== '0000-00-00 00:00:00') ? $app->pay_date : 'Pending Settlement';
        $checkoutId = !empty($app->checkout_id) ? $app->checkout_id : 'N/A';

        // Appointment status styling
        $st = strval($app->status ?? '');
        if ($st === '1' || strtoupper($st) === 'CONFIRMED') {
          $stBadge = '<span class="label" style="background-color: #dcfce7 !important; color: #15803d !important; border: 1px solid #bbf7d0; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-check-circle"></i> Confirmed</span>';
        } elseif ($st === '3' || strtoupper($st) === 'COMPLETED') {
          $stBadge = '<span class="label" style="background-color: #e0f2fe !important; color: #0369a1 !important; border: 1px solid #bae6fd; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-check-square-o"></i> Completed</span>';
        } elseif ($st === '2' || strtoupper($st) === 'CANCELLED') {
          $stBadge = '<span class="label" style="background-color: #fee2e2 !important; color: #b91c1c !important; border: 1px solid #fecaca; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-times-circle"></i> Cancelled</span>';
        } else {
          $stBadge = '<span class="label" style="background-color: #fef3c7 !important; color: #b45309 !important; border: 1px solid #fde68a; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-clock-o"></i> Pending</span>';
        }

        // Payment status badge
        if ($rawPay === 'DONE' || $rawPay === 'SUCCESS' || $rawPay === 'PAID') {
          $payBadge = '<span class="label" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><i class="fa fa-check"></i> Paid</span>';
          $payStatusText = 'Paid (Settled)';
        } elseif ($rawPay === 'CANCELLED') {
          $payBadge = '<span class="label" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><i class="fa fa-times"></i> Cancelled</span>';
          $payStatusText = 'Cancelled';
        } elseif ($rawPay === 'REFUNDED') {
          $payBadge = '<span class="label" style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><i class="fa fa-undo"></i> Refunded</span>';
          $payStatusText = 'Refunded';
        } else {
          $payBadge = '<span class="label" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><i class="fa fa-hourglass-half"></i> Pending Payment</span>';
          $payStatusText = 'Pending / At Clinic';
        }
      ?>

        <!-- TOP SUMMARY KPI CARDS -->
        <div class="row" style="margin-bottom: 20px;">
          <!-- Card 1: Appointment Status -->
          <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
            <div style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa fa-calendar-check-o"></i>
              </div>
              <div style="overflow: hidden;">
                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Booking Status</span>
                <div style="margin-top: 4px;"><?=$stBadge;?></div>
              </div>
            </div>
          </div>

          <!-- Card 2: Consultation Schedule -->
          <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
            <div style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa fa-clock-o"></i>
              </div>
              <div style="overflow: hidden; flex-grow: 1;">
                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Schedule Slot</span>
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-top: 2px;">
                  <strong style="font-size: 14px; color: #1e293b;">
                    <?=function_exists('formatedate') ? formatedate($adate) : $adate;?>
                  </strong>
                  <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#rescheduleModal" style="border-radius: 4px; font-weight: 600; color: #0284c7; border-color: #bae6fd; background: #f0f9ff; font-size: 11px; padding: 2px 7px;" title="Reschedule Slot">
                    <i class="fa fa-calendar"></i> Reschedule
                  </button>
                </div>
                <small style="color: #64748b; font-size: 11.5px;"><?=htmlspecialchars($slotTiming);?></small>
              </div>
            </div>
          </div>

          <!-- Card 3: Fee & Payment -->
          <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
            <div style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: #ecfdf5; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa fa-money"></i>
              </div>
              <div style="overflow: hidden; flex-grow: 1;">
                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Consultation Fee</span>
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: 2px;">
                  <div style="display: flex; align-items: center; gap: 6px;">
                    <strong style="font-size: 16px; color: #0f172a;">&#8377;<?=number_format($feeAmount, 2);?></strong>
                    <?=$payBadge;?>
                  </div>
                  <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#updateStatusModal" style="border-radius: 4px; font-weight: 600; color: #15803d; border-color: #bbf7d0; background: #f0fdf4; font-size: 11px; padding: 2px 7px;" title="Update Payment">
                    <i class="fa fa-pencil"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 4: Type & Token -->
          <div class="col-md-3 col-sm-6" style="margin-bottom: 12px;">
            <div style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: #faf5ff; color: #9333ea; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa fa-ticket"></i>
              </div>
              <div style="overflow: hidden;">
                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Appointment Token</span>
                <strong style="font-size: 15px; color: #1e293b; display: block; margin-top: 2px;">
                  #<?=htmlspecialchars($aid);?>
                </strong>
                <small style="color: #64748b; font-size: 11px;">Type: <?=htmlspecialchars(ucwords(str_replace('_', ' ', $app->appointment_type ?? 'In-Clinic')));?></small>
              </div>
            </div>
          </div>
        </div>

        <!-- 2-COLUMN COMPREHENSIVE DOSSIER GRID -->
        <div class="row">
          
          <!-- LEFT COLUMN: PATIENT & DOCTOR -->
          <div class="col-md-6" style="margin-bottom: 20px;">
            
            <!-- SECTION 1: PATIENT DOSSIER CARD -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
              <div style="background: #f8fafc; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                  <i class="fa fa-user" style="color: #00a896;"></i> Patient Identification & Contact
                </span>
                <span class="label" style="background: #e2e8f0; color: #475569; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                  User ID: <?=$app->user_id ? ('#' . $app->user_id) : 'Guest / Direct';?>
                </span>
              </div>
              <div style="padding: 20px;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 18px; padding-bottom: 16px; border-bottom: 1px dashed #e2e8f0;">
                  <div style="width: 52px; height: 52px; border-radius: 50%; background: #00a896; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700;">
                    <?=strtoupper(substr($pname, 0, 1));?>
                  </div>
                  <div>
                    <h4 style="margin: 0 0 4px; font-size: 16px; font-weight: 700; color: #1e293b;">
                      <?=htmlspecialchars($pname);?>
                    </h4>
                    <span style="font-size: 12px; color: #64748b;">
                      Age: <strong style="color: #334155;"><?=$page;?></strong> &bull; Gender: <strong style="color: #334155;"><?=$pgender;?></strong>
                    </span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Contact Mobile</label>
                    <div style="font-size: 13.5px; font-weight: 600; color: #1e293b;">
                      <?php if($pmobile && $pmobile !== 'N/A'): ?>
                        <a href="tel:<?=htmlspecialchars($pmobile);?>" style="color: #0284c7; text-decoration: none;">
                          <i class="fa fa-phone" style="color: #10b981; margin-right: 4px;"></i> <?=htmlspecialchars($pmobile);?>
                        </a>
                      <?php else: ?>
                        <span style="color: #94a3b8;">Not Provided</span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Email Address</label>
                    <div style="font-size: 13px; font-weight: 500; color: #1e293b;">
                      <?php if($pemail && $pemail !== 'N/A'): ?>
                        <a href="mailto:<?=htmlspecialchars($pemail);?>" style="color: #0284c7; text-decoration: none; word-break: break-all;">
                          <i class="fa fa-envelope-o" style="margin-right: 4px;"></i> <?=htmlspecialchars($pemail);?>
                        </a>
                      <?php else: ?>
                        <span style="color: #94a3b8;">Not Provided</span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <?php if(!empty($app->user_fname) && $app->user_fname !== $app->appointment_name): ?>
                    <div class="col-sm-12" style="margin-top: 6px; padding: 10px; background: #f8fafc; border-radius: 6px; font-size: 12px; color: #64748b;">
                      <i class="fa fa-info-circle text-info"></i> Registered Account: <strong><?=htmlspecialchars($app->user_fname . ' ' . $app->user_lname);?></strong> (Mobile: <?=htmlspecialchars($app->user_mobile);?>, Email: <?=htmlspecialchars($app->user_email);?>)
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- SECTION 2: DOCTOR DOSSIER CARD -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
              <div style="background: #f8fafc; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                  <i class="fa fa-user-md" style="color: #00a896;"></i> Consulting Doctor Profile
                </span>
                <?=$drBadge;?>
              </div>
              <div style="padding: 20px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 18px; padding-bottom: 16px; border-bottom: 1px dashed #e2e8f0;">
                  <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; border: 2px solid #00a896; flex-shrink: 0; background: #f1f5f9;">
                    <img src="<?=$docImg;?>" alt="Doctor Photo" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?=base_url('public/assets/upload/dummydr.jpg');?>';">
                  </div>
                  <div style="flex-grow: 1;">
                    <h4 style="margin: 0 0 4px; font-size: 16px; font-weight: 700; color: #0f172a;">
                      <?=htmlspecialchars($dname);?>
                    </h4>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
                      <span class="label" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 11px; padding: 3px 8px; border-radius: 4px; font-weight: 600;">
                        <?=htmlspecialchars($dspec);?>
                      </span>
                      <span style="font-size: 12px; color: #64748b;">
                        Doctor ID: #<?=$app->dr_profile_id ?? $app->doctor_id;?>
                      </span>
                    </div>
                  </div>
                  <div>
                    <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#reassignDoctorModal" style="border-radius: 6px; font-weight: 600; color: #0284c7; border-color: #cbd5e1; padding: 5px 10px;" title="Reassign Doctor">
                      <i class="fa fa-refresh"></i> Change
                    </button>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Medical Reg. No.</label>
                    <div style="font-size: 13px; font-weight: 600; color: #1e293b;">
                      <?=htmlspecialchars($dreg);?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Clinical Experience</label>
                    <div style="font-size: 13px; font-weight: 600; color: #1e293b;">
                      <?=htmlspecialchars($dexp);?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Doctor Contact</label>
                    <div style="font-size: 13px; font-weight: 500; color: #1e293b;">
                      <?php if($dmobile && $dmobile !== 'N/A'): ?>
                        <a href="tel:<?=htmlspecialchars($dmobile);?>" style="color: #0284c7; text-decoration: none;">
                          <i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($dmobile);?>
                        </a>
                      <?php else: ?>
                        <span style="color: #94a3b8;">N/A</span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Doctor Email</label>
                    <div style="font-size: 13px; font-weight: 500; color: #1e293b;">
                      <?php if($demail && $demail !== 'N/A'): ?>
                        <a href="mailto:<?=htmlspecialchars($demail);?>" style="color: #0284c7; text-decoration: none;">
                          <i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($demail);?>
                        </a>
                      <?php else: ?>
                        <span style="color: #94a3b8;">N/A</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <!-- RIGHT COLUMN: FACILITY & FINANCIAL AUDIT -->
          <div class="col-md-6" style="margin-bottom: 20px;">
            
            <!-- SECTION 3: FACILITY / VENUE CARD -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
              <div style="background: #f8fafc; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                  <i class="fa fa-hospital-o" style="color: #00a896;"></i> Consultation Venue & Facility
                </span>
                <span class="label" style="background: #e2e8f0; color: #475569; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                  Facility ID: <?=$app->institute_id ? ('#' . $app->institute_id) : 'Primary Clinic';?>
                </span>
              </div>
              <div style="padding: 20px;">
                <div style="margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px dashed #e2e8f0;">
                  <h4 style="margin: 0 0 6px; font-size: 15px; font-weight: 700; color: #0f172a;">
                    <?=htmlspecialchars($hname);?>
                  </h4>
                  <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.5;">
                    <i class="fa fa-map-marker text-danger" style="margin-right: 4px;"></i> <?=htmlspecialchars($haddress);?> <?=$hcity ? ('&bull; ' . htmlspecialchars($hcity)) : '';?>
                  </p>
                </div>

                <div class="row">
                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Facility Type</label>
                    <div style="font-size: 13px; font-weight: 600; color: #1e293b;">
                      <?=($app->institution_type === 'H') ? 'Hospital Center' : (($app->institution_type === 'C') ? 'Specialty Clinic' : 'Consultation Center');?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Facility Phone</label>
                    <div style="font-size: 13px; font-weight: 500; color: #1e293b;">
                      <?php if($hmobile && $hmobile !== 'N/A'): ?>
                        <a href="tel:<?=htmlspecialchars($hmobile);?>" style="color: #0284c7; text-decoration: none;">
                          <i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($hmobile);?>
                        </a>
                      <?php else: ?>
                        <span style="color: #94a3b8;">N/A</span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="col-sm-12" style="margin-bottom: 6px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Consultation Channel</label>
                    <div style="font-size: 13px; color: #334155;">
                      <span class="label" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                        <i class="fa fa-stethoscope text-primary"></i> <?=htmlspecialchars(ucwords(str_replace('_', ' ', $app->appointment_type ?? 'In-Clinic Physical Visit')));?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- SECTION 4: BILLING & TRANSACTION AUDIT -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
              <div style="background: #f8fafc; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                  <i class="fa fa-credit-card" style="color: #00a896;"></i> Billing, Settlement & Audit Log
                </span>
                <?=$payBadge;?>
              </div>
              <div style="padding: 20px;">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px 18px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                  <div>
                    <span style="font-size: 12px; color: #15803d; font-weight: 600; text-transform: uppercase;">Total Billed Amount</span>
                    <h3 style="margin: 2px 0 0; font-size: 22px; font-weight: 800; color: #166534;">
                      &#8377;<?=number_format($feeAmount, 2);?>
                    </h3>
                  </div>
                  <div style="text-align: right;">
                    <span style="font-size: 11px; color: #15803d; font-weight: 600; text-transform: uppercase;">Payment Mode</span>
                    <div style="font-weight: 700; font-size: 14px; color: #166534; margin-top: 2px;">
                      <?=htmlspecialchars($payMode);?>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Payment Status</label>
                    <div style="font-size: 13px; font-weight: 600; color: #1e293b;">
                      <?=htmlspecialchars($payStatusText);?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Payment Timestamp</label>
                    <div style="font-size: 12.5px; color: #1e293b;">
                      <?=htmlspecialchars($payDate);?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 8px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Booking Created At</label>
                    <div style="font-size: 12.5px; color: #1e293b;">
                      <?=htmlspecialchars($bookDate);?>
                    </div>
                  </div>

                  <div class="col-sm-6" style="margin-bottom: 8px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Checkout Ref / Order</label>
                    <div style="font-size: 12.5px; color: #1e293b;">
                      <?=htmlspecialchars($checkoutId);?>
                    </div>
                  </div>
                </div>

                <div style="margin-top: 10px; padding-top: 12px; border-top: 1px dashed #e2e8f0; display: flex; justify-content: flex-end;">
                  <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#updateStatusModal" style="border-radius: 6px; font-weight: 600; color: #15803d; border-color: #bbf7d0; background: #f0fdf4;">
                    <i class="fa fa-money"></i> Update Payment & Status
                  </button>
                </div>
              </div>
            </div>

          </div>

        </div>

      <?php endif; ?>

    </div>
  </section>
</div>

<?php if($app): ?>
<!-- FLOATING NOTIFICATION TOAST -->
<div id="appointmentToast" style="display: none; position: fixed; top: 70px; right: 25px; z-index: 99999; min-width: 320px; max-width: 450px; padding: 16px 20px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.18); font-size: 13.5px; font-weight: 600; transition: all 0.3s ease;">
  <div style="display: flex; align-items: center; gap: 12px;">
    <i id="toastIcon" class="fa fa-check-circle" style="font-size: 20px;"></i>
    <span id="toastMsg" style="flex-grow: 1; line-height: 1.4;"></span>
  </div>
</div>

<!-- ========================================================= -->
<!-- PROCESS 1: UPDATE STATUS & PAYMENT MODAL                  -->
<!-- ========================================================= -->
<div class="modal fade no-print" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
      <form action="<?=base_url('doctor/appointment/update_status');?>" method="post" id="formUpdateStatus">
        <input type="hidden" name="process_type" value="payment_status">
        <input type="hidden" name="appointment_id" value="<?=$aid;?>">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" class="csrf-field">
        
        <div class="modal-header" style="background: #1e293b; color: #ffffff; padding: 18px 22px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.85;"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="updateStatusModalLabel" style="font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-credit-card" style="color: #10b981;"></i> Update Booking Status & Payment Audit
          </h4>
        </div>
        
        <div class="modal-body" style="padding: 22px;">
          <div id="statusModalAlert" style="display: none; margin-bottom: 16px;" class="alert"></div>

          <!-- Current Patient & Booking Reference -->
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
            <div>
              <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Appointment Target</span>
              <strong style="font-size: 14px; color: #0f172a;">#<?=$aid;?> &bull; <?=htmlspecialchars($pname);?></strong>
            </div>
            <div style="text-align: right;">
              <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Current Doctor</span>
              <span style="font-size: 13px; font-weight: 600; color: #0284c7;"><?=htmlspecialchars($dname);?></span>
            </div>
          </div>

          <!-- Booking Status -->
          <div class="form-group" style="margin-bottom: 16px;">
            <label style="font-weight: 600; color: #334155; font-size: 13px;">Booking Status <span class="text-danger">*</span></label>
            <select name="status" id="selectBookingStatus" class="form-control" style="border-radius: 6px; height: 42px; font-weight: 600;" required>
              <option value="0" <?=(strval($app->status ?? '') === '0') ? 'selected' : '';?>>🟡 Pending (Awaiting Confirmation)</option>
              <option value="1" <?=(strval($app->status ?? '') === '1') ? 'selected' : '';?>>🟢 Confirmed (Scheduled & Ready)</option>
              <option value="3" <?=(strval($app->status ?? '') === '3') ? 'selected' : '';?>>🔵 Completed (Consultation Done)</option>
              <option value="2" <?=(strval($app->status ?? '') === '2') ? 'selected' : '';?>>🔴 Cancelled</option>
            </select>
          </div>

          <!-- Cancellation Reason (Shows if Cancelled) -->
          <div class="form-group" id="cancelReasonGroup" style="margin-bottom: 16px; display: <?=(strval($app->status ?? '') === '2') ? 'block' : 'none';?>;">
            <label style="font-weight: 600; color: #b91c1c; font-size: 13px;">Cancellation Reason</label>
            <select name="cancel_reason" class="form-control" style="border-radius: 6px; height: 40px;">
              <option value="0">Other / Reason Not Specified</option>
              <option value="1" <?=($app->cancel_reason == 1) ? 'selected' : '';?>>Patient Requested Cancellation</option>
              <option value="2" <?=($app->cancel_reason == 2) ? 'selected' : '';?>>Doctor Unavailable / Emergency</option>
              <option value="3" <?=($app->cancel_reason == 3) ? 'selected' : '';?>>Duplicate / Incorrect Booking</option>
              <option value="4" <?=($app->cancel_reason == 4) ? 'selected' : '';?>>Facility / Clinic Closed</option>
            </select>
          </div>

          <!-- Payment Status & Mode Row -->
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Payment Status <span class="text-danger">*</span></label>
                <select name="payment_status" class="form-control" style="border-radius: 6px; height: 42px; font-weight: 600;" required>
                  <option value="PENDING" <?=(in_array(strtoupper($app->payment_status ?? ''), array('NA', 'PENDING', 'UNPAID', '0', ''))) ? 'selected' : '';?>>Pending / Unpaid</option>
                  <option value="PAID" <?=(in_array(strtoupper($app->payment_status ?? ''), array('DONE', 'SUCCESS', 'PAID'))) ? 'selected' : '';?>>Paid (Settled)</option>
                  <option value="REFUNDED" <?=(strtoupper($app->payment_status ?? '') === 'REFUNDED') ? 'selected' : '';?>>Refunded</option>
                  <option value="CANCELLED" <?=(strtoupper($app->payment_status ?? '') === 'CANCELLED') ? 'selected' : '';?>>Cancelled</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Payment Mode</label>
                <select name="payment_mode" class="form-control" style="border-radius: 6px; height: 42px;">
                  <option value="CASH" <?=(strtoupper($app->payment_mode ?? '') === 'CASH' || strtoupper($app->payment_mode ?? '') === 'NA') ? 'selected' : '';?>>OPD Desk / Cash</option>
                  <option value="UPI" <?=(strtoupper($app->payment_mode ?? '') === 'UPI') ? 'selected' : '';?>>UPI (GPay / PhonePe / Paytm)</option>
                  <option value="ONLINE" <?=(strtoupper($app->payment_mode ?? '') === 'ONLINE') ? 'selected' : '';?>>Online Gateway (Razorpay)</option>
                  <option value="CARD" <?=(strtoupper($app->payment_mode ?? '') === 'CARD') ? 'selected' : '';?>>POS / Credit / Debit Card</option>
                  <option value="WALLET" <?=(strtoupper($app->payment_mode ?? '') === 'WALLET') ? 'selected' : '';?>>Upchar Digital Wallet</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Consultation Fee & Transaction Reference -->
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Consultation Fee (₹)</label>
                <div class="input-group">
                  <span class="input-group-addon" style="background: #f1f5f9; font-weight: 700; color: #166534; border-radius: 6px 0 0 6px;">&#8377;</span>
                  <input type="number" name="fee" class="form-control" value="<?=htmlspecialchars((string)$feeAmount);?>" min="0" step="1" style="border-radius: 0 6px 6px 0; height: 42px; font-weight: 700; font-size: 15px; color: #166534;" placeholder="500">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">Ref / UTR / Transaction ID</label>
                <input type="text" name="ref_no" class="form-control" value="<?=htmlspecialchars($app->ref_no ?? '');?>" placeholder="e.g. UPI/2026/89214" style="border-radius: 6px; height: 42px;">
              </div>
            </div>
          </div>

          <div style="background: #f0fdf4; border-radius: 8px; padding: 12px 16px; border: 1px solid #bbf7d0; font-size: 12px; color: #166534; line-height: 1.5;">
            <i class="fa fa-shield" style="margin-right: 4px;"></i>
            Marking as <strong>Paid</strong> automatically records payment settlement timestamp. Marking as <strong>Completed</strong> records consultation done timestamp for doctor settlement audits.
          </div>
        </div>
        
        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 22px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Close</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitStatus" style="background: #10b981; border-color: #059669; border-radius: 6px; font-weight: 600; padding: 8px 20px;">
            <i class="fa fa-check"></i> Save Status & Payment
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ========================================================= -->
<!-- PROCESS 2: REASSIGN DOCTOR MODAL                          -->
<!-- ========================================================= -->
<div class="modal fade no-print" id="reassignDoctorModal" tabindex="-1" role="dialog" aria-labelledby="reassignDoctorModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
      <form action="<?=base_url('doctor/appointment/update_status');?>" method="post" id="formReassignDoctor">
        <input type="hidden" name="process_type" value="reassign_doctor">
        <input type="hidden" name="appointment_id" value="<?=$aid;?>">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" class="csrf-field">
        
        <div class="modal-header" style="background: #1e293b; color: #ffffff; padding: 18px 22px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.85;"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="reassignDoctorModalLabel" style="font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-user-md" style="color: #00a896;"></i> Reassign Consulting Doctor
          </h4>
        </div>
        
        <div class="modal-body" style="padding: 22px;">
          <div id="doctorModalAlert" style="display: none; margin-bottom: 16px;" class="alert"></div>

          <!-- Current Doctor Banner -->
          <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
            <div>
              <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Currently Assigned Doctor</span>
              <strong style="font-size: 14.5px; color: #0f172a;">
                <?=htmlspecialchars($dname);?>
              </strong>
              <span style="font-size: 12px; color: #64748b; margin-left: 8px;">
                (Speciality: <?=htmlspecialchars($dspec);?> &bull; ID #<?=$app->doctor_id;?>)
              </span>
            </div>
            <div>
              <span class="label" style="background: #e2e8f0; color: #334155; font-size: 11px; padding: 4px 8px; border-radius: 4px;">Current Roster</span>
            </div>
          </div>

          <!-- Live Doctor Filter Box -->
          <div class="form-group" style="margin-bottom: 12px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
              <label style="font-weight: 600; color: #334155; font-size: 13px; margin: 0;">
                <i class="fa fa-search" style="color: #0284c7;"></i> Search Doctor by Name, Speciality, or ID
              </label>
              <span id="docCountBadge" class="label" style="background: #e0f2fe; color: #0369a1; font-size: 11px; padding: 3px 8px; border-radius: 10px;">
                <?=!empty($doctor_list) ? count($doctor_list) : 0;?> Doctors Available
              </span>
            </div>
            <div class="input-group">
              <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-filter text-muted"></i></span>
              <input type="text" id="doctorFilterBox" class="form-control" placeholder="Type here to filter doctors instantly (e.g. Dr. Atul, Cardiologist, 55)..." autocomplete="off" style="border-radius: 0 6px 6px 0; height: 42px; font-size: 13.5px;">
            </div>
          </div>

          <!-- Doctor Selection Listbox -->
          <div class="form-group" style="margin-bottom: 16px;">
            <label style="font-weight: 600; color: #334155; font-size: 13px;">Select New Doctor <span class="text-danger">*</span></label>
            <select name="doctor_id" id="doctorSelectEl" class="form-control" size="8" style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; padding: 6px;" required>
              <?php if(!empty($doctor_list)): ?>
                <?php foreach($doctor_list as $doc): ?>
                  <?php 
                    $doc_display_name = trim($doc->fname . ' ' . $doc->lname);
                    if (stripos($doc_display_name, 'Dr.') !== 0 && stripos($doc_display_name, 'Dr ') !== 0) {
                      $doc_display_name = 'Dr. ' . $doc_display_name;
                    }
                    $spec_text = !empty($doc->specialization_name) ? $doc->specialization_name : 'General Practitioner';
                    $fee_val = !empty($doc->dr_fee) ? (int)$doc->dr_fee : 0;
                    $fee_display = $fee_val > 0 ? ('₹' . $fee_val) : 'Standard';
                    $isSelected = ($app->doctor_id == $doc->id || $app->doctor_id == $doc->user_id) ? 'selected' : '';
                  ?>
                  <option value="<?=$doc->id;?>" 
                          data-name="<?=htmlspecialchars($doc_display_name);?>" 
                          data-spec="<?=htmlspecialchars($spec_text);?>" 
                          data-fee="<?=$fee_val;?>" 
                          data-id="<?=$doc->id;?>"
                          data-user-id="<?=$doc->user_id;?>"
                          <?=$isSelected;?> 
                          style="padding: 7px 10px; border-bottom: 1px solid #f1f5f9;">
                    <?=htmlspecialchars($doc_display_name);?> &bull; <?=htmlspecialchars($spec_text);?> &bull; Fee: <?=$fee_display;?> &bull; [ID #<?=$doc->id;?>]
                  </option>
                <?php endforeach; ?>
              <?php else: ?>
                <option value="" disabled>No active doctors found</option>
              <?php endif; ?>
            </select>
            <small class="text-muted" style="font-size: 11.5px; display: block; margin-top: 4px;">
              <i class="fa fa-info-circle"></i> Click on any doctor to select. The search box above filters the list instantly in real-time.
            </small>
          </div>

          <!-- Dynamic Selected Doctor Card & Fee Application Option -->
          <div id="doctorPreviewCard" style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 14px 18px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
              <div>
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #166534; display: block;">Selected Doctor</span>
                <strong id="previewDocName" style="font-size: 15px; color: #14532d;"><?=htmlspecialchars($dname);?></strong>
                <span id="previewDocSpec" class="label" style="background: #bbf7d0; color: #14532d; font-size: 11px; margin-left: 6px; padding: 3px 8px; border-radius: 4px;">
                  <?=htmlspecialchars($dspec);?>
                </span>
              </div>
              <div style="text-align: right;">
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #166534; display: block;">Doctor Base Fee</span>
                <strong id="previewDocFee" style="font-size: 16px; color: #14532d;">&#8377;<?=number_format($feeAmount, 2);?></strong>
              </div>
            </div>

            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #86efac;">
              <label style="font-weight: 600; font-size: 12.5px; color: #166534; cursor: pointer; margin: 0; display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="apply_doctor_fee" value="1" id="chkApplyDocFee" checked style="margin: 0; width: 16px; height: 16px;">
                Update appointment fee to this doctor's base fee (<span id="previewDocFeeText">&#8377;<?=number_format($feeAmount, 2);?></span>)
              </label>
            </div>
          </div>

          <div style="background: #f8fafc; border-radius: 8px; padding: 12px 16px; border: 1px solid #e2e8f0; font-size: 12px; color: #64748b; line-height: 1.5;">
            <i class="fa fa-check-circle text-info" style="margin-right: 4px;"></i>
            Reassigning the doctor immediately updates the patient slip, prints, and assigns the booking to the new doctor's daily schedule.
          </div>
        </div>
        
        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 22px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Close</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitDoctor" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600; padding: 8px 22px;">
            <i class="fa fa-refresh"></i> Confirm Doctor Reassignment
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ========================================================= -->
<!-- PROCESS 3: RESCHEDULE APPOINTMENT MODAL                   -->
<!-- ========================================================= -->
<div class="modal fade no-print" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
      <form action="<?=base_url('doctor/appointment/update_status');?>" method="post" id="formReschedule">
        <input type="hidden" name="process_type" value="reschedule">
        <input type="hidden" name="appointment_id" value="<?=$aid;?>">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" class="csrf-field">
        
        <div class="modal-header" style="background: #1e293b; color: #ffffff; padding: 18px 22px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.85;"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="rescheduleModalLabel" style="font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-calendar-check-o" style="color: #38bdf8;"></i> Reschedule Appointment Date & Timing Slot
          </h4>
        </div>
        
        <div class="modal-body" style="padding: 22px;">
          <div id="rescheduleModalAlert" style="display: none; margin-bottom: 16px;" class="alert"></div>

          <!-- Current Schedule Banner -->
          <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
            <div>
              <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #0369a1; display: block;">Current Appointment Time</span>
              <strong style="font-size: 14.5px; color: #0c4a6e;">
                <?=function_exists('formatedate') ? formatedate($adate) : $adate;?> &bull; <?=htmlspecialchars($slotTiming);?>
              </strong>
            </div>
            <div>
              <span class="label" style="background: #e0f2fe; color: #0284c7; font-size: 11px; padding: 4px 8px; border-radius: 4px;">Slot Active</span>
            </div>
          </div>

          <!-- Date Selector with Quick Preset Buttons -->
          <div class="form-group" style="margin-bottom: 16px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
              <label style="font-weight: 600; color: #334155; font-size: 13px; margin: 0;">Appointment Date <span class="text-danger">*</span></label>
              <div style="display: flex; gap: 4px;">
                <button type="button" class="btn btn-xs btn-default btn-date-preset" data-days="0" style="border-radius: 4px; font-size: 11px; padding: 2px 7px;">Today</button>
                <button type="button" class="btn btn-xs btn-default btn-date-preset" data-days="1" style="border-radius: 4px; font-size: 11px; padding: 2px 7px;">Tomorrow</button>
                <button type="button" class="btn btn-xs btn-default btn-date-preset" data-days="2" style="border-radius: 4px; font-size: 11px; padding: 2px 7px;">+2 Days</button>
                <button type="button" class="btn btn-xs btn-default btn-date-preset" data-days="7" style="border-radius: 4px; font-size: 11px; padding: 2px 7px;">+1 Week</button>
              </div>
            </div>
            <input type="date" name="appointment_date" id="rescheduleDateInput" class="form-control" value="<?=htmlspecialchars($adate);?>" required style="border-radius: 6px; height: 42px; font-size: 14px; font-weight: 600;">
          </div>

          <!-- Quick Slot Preset Pills -->
          <div class="form-group" style="margin-bottom: 16px;">
            <label style="font-weight: 600; color: #334155; font-size: 13px; margin-bottom: 8px; display: block;">Quick Timing Slot Presets</label>
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
              <button type="button" class="btn btn-sm btn-default btn-slot-preset" data-from="10:00 AM" data-to="01:00 PM" style="border-radius: 6px; font-weight: 600; padding: 6px 12px; font-size: 12px; border-color: #cbd5e1;">
                🌅 Morning (10:00 AM - 01:00 PM)
              </button>
              <button type="button" class="btn btn-sm btn-default btn-slot-preset" data-from="02:00 PM" data-to="05:00 PM" style="border-radius: 6px; font-weight: 600; padding: 6px 12px; font-size: 12px; border-color: #cbd5e1;">
                ☀️ Afternoon (02:00 PM - 05:00 PM)
              </button>
              <button type="button" class="btn btn-sm btn-default btn-slot-preset" data-from="06:00 PM" data-to="09:00 PM" style="border-radius: 6px; font-weight: 600; padding: 6px 12px; font-size: 12px; border-color: #cbd5e1;">
                🌆 Evening (06:00 PM - 09:00 PM)
              </button>
              <button type="button" class="btn btn-sm btn-default btn-slot-preset" data-from="08:00 PM" data-to="10:00 PM" style="border-radius: 6px; font-weight: 600; padding: 6px 12px; font-size: 12px; border-color: #cbd5e1;">
                🌙 Night (08:00 PM - 10:00 PM)
              </button>
            </div>
          </div>

          <!-- Timing Custom Inputs -->
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">From Timing <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-clock-o text-muted"></i></span>
                  <input type="text" name="from_timing" id="fromTimingInput" class="form-control" value="<?=htmlspecialchars($fromTime ?: '10:00 AM');?>" placeholder="e.g. 10:00 AM" required style="border-radius: 0 6px 6px 0; height: 42px; font-weight: 600;">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group" style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #334155; font-size: 13px;">To Timing <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-clock-o text-muted"></i></span>
                  <input type="text" name="to_timing" id="toTimingInput" class="form-control" value="<?=htmlspecialchars($toTime ?: '01:00 PM');?>" placeholder="e.g. 01:00 PM" required style="border-radius: 0 6px 6px 0; height: 42px; font-weight: 600;">
                </div>
              </div>
            </div>
          </div>

          <div style="background: #f8fafc; border-radius: 8px; padding: 12px 16px; border: 1px solid #e2e8f0; font-size: 12px; color: #64748b; line-height: 1.5;">
            <i class="fa fa-info-circle text-info" style="margin-right: 4px;"></i>
            Rescheduling instantly updates the appointment time across doctor queue, patient slip, and reactivates the booking if previously cancelled.
          </div>
        </div>
        
        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 22px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Close</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitReschedule" style="background: #0284c7; border-color: #0284c7; border-radius: 6px; font-weight: 600; padding: 8px 22px;">
            <i class="fa fa-calendar-check-o"></i> Update & Reschedule Slot
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Print Stylesheet -->
<style>
@media print {
  body {
    background: #ffffff !important;
    font-size: 12px !important;
    color: #000000 !important;
  }
  .main-header, .main-sidebar, .sidebar, .control-sidebar, .main-footer, .no-print, .breadcrumb, .modal, #appointmentToast {
    display: none !important;
  }
  .content-wrapper {
    margin-left: 0 !important;
    padding: 0 !important;
    background: #ffffff !important;
  }
  .print-only-header {
    display: block !important;
  }
  .master-card, .col-md-6, .col-md-3, div[style*="background: #ffffff"] {
    box-shadow: none !important;
    border: 1px solid #cccccc !important;
  }
}
</style>

<!-- CLIENT JAVASCRIPT HANDLERS FOR THE 3 PROCESSES -->
<script>
(function($) {
  'use strict';

  // Toast Helper
  function showToast(message, isSuccess) {
    var $t = $('#appointmentToast');
    var $icon = $('#toastIcon');
    var $msg = $('#toastMsg');
    
    $msg.text(message);
    if (isSuccess) {
      $t.css({ background: '#065f46', color: '#ecfdf5', border: '1px solid #10b981' });
      $icon.attr('class', 'fa fa-check-circle text-success').css('color', '#34d399');
    } else {
      $t.css({ background: '#7f1d1d', color: '#fef2f2', border: '1px solid #ef4444' });
      $icon.attr('class', 'fa fa-exclamation-triangle text-danger').css('color', '#f87171');
    }
    $t.fadeIn(250);
    setTimeout(function() {
      $t.fadeOut(400);
    }, 4000);
  }

  // -------------------------------------------------------------
  // 1. UPDATE STATUS & PAYMENT MODAL LOGIC
  // -------------------------------------------------------------
  $('#selectBookingStatus').on('change', function() {
    if ($(this).val() === '2') {
      $('#cancelReasonGroup').slideDown(200);
    } else {
      $('#cancelReasonGroup').slideUp(200);
    }
  });

  // -------------------------------------------------------------
  // 2. REASSIGN DOCTOR FILTER & PREVIEW LOGIC
  // -------------------------------------------------------------
  var $docSelect = $('#doctorSelectEl');
  var allDocOptions = [];

  // Cache options on page load
  $docSelect.find('option').each(function() {
    allDocOptions.push({
      value: $(this).val(),
      text: $(this).text(),
      name: $(this).data('name') || '',
      spec: $(this).data('spec') || '',
      fee: $(this).data('fee') || 0,
      id: $(this).data('id') || '',
      userId: $(this).data('userId') || '',
      selected: $(this).is(':selected')
    });
  });

  // Real-time doctor filter
  $('#doctorFilterBox').on('input', function() {
    var query = $.trim($(this).val()).toLowerCase();
    var matchCount = 0;
    $docSelect.empty();

    for (var i = 0; i < allDocOptions.length; i++) {
      var doc = allDocOptions[i];
      var haystack = (doc.text + ' ' + doc.name + ' ' + doc.spec + ' ' + doc.id + ' ' + doc.userId).toLowerCase();
      if (!query || haystack.indexOf(query) !== -1) {
        matchCount++;
        var $opt = $('<option></option>')
          .val(doc.value)
          .text(doc.text)
          .data('name', doc.name)
          .data('spec', doc.spec)
          .data('fee', doc.fee)
          .data('id', doc.id);
        if (doc.selected) {
          $opt.prop('selected', true);
        }
        $docSelect.append($opt);
      }
    }
    $('#docCountBadge').text(matchCount + ' Doctors Matching');
    if (matchCount === 0) {
      $docSelect.append('<option value="" disabled>No matching doctors found</option>');
    }
  });

  // Doctor select change
  $docSelect.on('change', function() {
    var $sel = $(this).find('option:selected');
    if (!$sel.length || !$sel.val()) return;
    
    var dname = $sel.data('name') || $sel.text();
    var dspec = $sel.data('spec') || 'General Specialist';
    var dfee = parseFloat($sel.data('fee') || 0);

    $('#previewDocName').text(dname);
    $('#previewDocSpec').text(dspec);
    $('#previewDocFee').text('₹' + dfee.toFixed(2));
    $('#previewDocFeeText').text('₹' + dfee.toFixed(2));
  });

  // -------------------------------------------------------------
  // 3. RESCHEDULE MODAL PRESETS LOGIC
  // -------------------------------------------------------------
  $('.btn-date-preset').on('click', function(e) {
    e.preventDefault();
    var days = parseInt($(this).data('days') || 0, 10);
    var d = new Date();
    d.setDate(d.getDate() + days);
    
    var yyyy = d.getFullYear();
    var mm = String(d.getMonth() + 1).padStart(2, '0');
    var dd = String(d.getDate()).padStart(2, '0');
    $('#rescheduleDateInput').val(yyyy + '-' + mm + '-' + dd);

    $('.btn-date-preset').removeClass('btn-primary').addClass('btn-default');
    $(this).removeClass('btn-default').addClass('btn-primary');
  });

  $('.btn-slot-preset').on('click', function(e) {
    e.preventDefault();
    var from = $(this).data('from');
    var to = $(this).data('to');
    $('#fromTimingInput').val(from);
    $('#toTimingInput').val(to);

    $('.btn-slot-preset').removeClass('btn-info').addClass('btn-default').css({ background: '#ffffff', color: '#334155' });
    $(this).removeClass('btn-default').addClass('btn-info').css({ background: '#0284c7', color: '#ffffff', borderColor: '#0284c7' });
  });

  // -------------------------------------------------------------
  // 4. UNIFIED AJAX FORM SUBMISSIONS FOR ALL 3 PROCESSES
  // -------------------------------------------------------------
  function bindAjaxForm(formId, btnId, alertId, modalId) {
    $(formId).on('submit', function(e) {
      e.preventDefault();
      var $form = $(this);
      var $btn = $(btnId);
      var $alert = $(alertId);
      var originalBtnHtml = $btn.html();

      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
      $alert.hide().removeClass('alert-danger alert-success');

      var formData = $form.serialize();
      if (formData.indexOf('is_ajax=') === -1) {
        formData += '&is_ajax=1';
      }

      $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(resp) {
          if (resp && resp.status == 1) {
            showToast(resp.message || 'Updated successfully!', true);
            $alert.addClass('alert-success').html('<i class="fa fa-check"></i> ' + (resp.message || 'Saved successfully!')).show();
            setTimeout(function() {
              $(modalId).modal('hide');
              window.location.reload();
            }, 600);
          } else {
            $btn.prop('disabled', false).html(originalBtnHtml);
            var err = (resp && resp.message) ? resp.message : 'An error occurred. Please try again.';
            $alert.addClass('alert-danger').html('<i class="fa fa-exclamation-circle"></i> ' + err).show();
            showToast(err, false);
          }
        },
        error: function(xhr, status, error) {
          $btn.prop('disabled', false).html(originalBtnHtml);
          var errMsg = 'Server error (' + xhr.status + '). Falling back to standard submission...';
          $alert.addClass('alert-danger').html('<i class="fa fa-exclamation-circle"></i> ' + errMsg).show();
          showToast(errMsg, false);
          // Fallback to normal form submit after 1 second if AJAX failed
          setTimeout(function() {
            $form.off('submit').submit();
          }, 1000);
        }
      });
    });
  }

  // Bind the 3 process forms
  bindAjaxForm('#formUpdateStatus', '#btnSubmitStatus', '#statusModalAlert', '#updateStatusModal');
  bindAjaxForm('#formReassignDoctor', '#btnSubmitDoctor', '#doctorModalAlert', '#reassignDoctorModal');
  bindAjaxForm('#formReschedule', '#btnSubmitReschedule', '#rescheduleModalAlert', '#rescheduleModal');

})(jQuery);
</script>

