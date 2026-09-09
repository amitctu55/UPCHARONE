<?php
  // Extract appointment data (support both single object and list)
  $app = !empty($appointment) ? $appointment : (!empty($data[0]) ? $data[0] : null);
  $aid = $app ? ($app->appointment_id ?? $appointment_id ?? 0) : ($appointment_id ?? 0);
?>
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
        <div style="display: flex; align-items: center; gap: 10px;">
          <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569; border-color: #cbd5e1;">
            <i class="fa fa-arrow-left"></i> Back to Appointments
          </a>
          <a href="<?=base_url('doctor/appointment/addappointment');?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #0284c7; border-color: #bae6fd; background: #f0f9ff;">
            <i class="fa fa-plus"></i> Book Another Appointment
          </a>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
          <button type="button" onclick="window.print();" class="btn btn-sm btn-info" style="border-radius: 6px; font-weight: 600; background: #0284c7; border-color: #0284c7; padding: 6px 14px;">
            <i class="fa fa-print"></i> Print Slip / Invoice
          </button>
          <?php if($app && !empty($app->doctor_id)): ?>
            <a href="<?=base_url('doctor/appointment/doctorappointment?doctor=' . ($app->dr_profile_id ?? $app->doctor_id));?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896; padding: 6px 14px;">
              <i class="fa fa-user-md"></i> Doctor's Schedule
            </a>
          <?php endif; ?>
        </div>
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

        $raw_dname = !empty($app->dr_fname) ? trim($app->dr_fname . ' ' . $app->dr_lname) : 'Assigned Doctor';
        $dname = (stripos($raw_dname, 'Dr.') === 0 || stripos($raw_dname, 'Dr ') === 0) ? $raw_dname : ('Dr. ' . $raw_dname);
        $dspec = !empty($app->dr_speciality) ? $app->dr_speciality : 'General Practitioner';
        $dmobile = !empty($app->dr_mobile) ? $app->dr_mobile : 'N/A';
        $demail = !empty($app->dr_email) ? $app->dr_email : 'N/A';
        $dreg = !empty($app->dr_regd_no) ? $app->dr_regd_no : 'N/A';
        $dexp = !empty($app->dr_exp) ? ($app->dr_exp . ' Years') : 'N/A';
        $docImg = (!empty($app->dr_image) && file_exists(FCPATH . 'public/assets/upload/' . $app->dr_image)) ? base_url('public/assets/upload/' . $app->dr_image) : base_url('public/assets/upload/dummydr.jpg');

        $hname = !empty($app->facility_name) ? $app->facility_name : (!empty($app->hospital_name) ? $app->hospital_name : 'Upchar Partner Clinic / Consultation Chamber');
        $haddress = !empty($app->facility_address) ? $app->facility_address : (!empty($app->hospital_address) ? $app->hospital_address : 'Address not specified');
        $hcity = !empty($app->facility_city) ? $app->facility_city : (!empty($app->hospital_city) ? $app->hospital_city : '');
        $hmobile = !empty($app->facility_mobile) ? $app->facility_mobile : (!empty($app->hospital_mobile) ? $app->hospital_mobile : 'N/A');

        $adate = !empty($app->appointment_date) ? $app->appointment_date : 'N/A';
        $fromTime = !empty($app->from_timing) ? $app->from_timing : '';
        $toTime = !empty($app->to_timing) ? $app->to_timing : '';
        $slotTiming = ($fromTime && $toTime) ? ($fromTime . ' - ' . $toTime) : (!empty($app->appointment_time) ? $app->appointment_time : 'Standard OPD Timing');

        $feeAmount = floatval($app->amount ?: ($app->fee ?: 0));
        $payMode = !empty($app->payment_mode) ? strtoupper($app->payment_mode) : 'OPD / CASH';
        $payStatus = !empty($app->payment_status) ? strtoupper($app->payment_status) : 'PENDING';
        $bookDate = !empty($app->book_date) ? $app->book_date : 'N/A';
        $payDate = !empty($app->pay_date) ? $app->pay_date : 'N/A';
        $checkoutId = !empty($app->checkout_id) ? $app->checkout_id : 'N/A';

        // Appointment status styling
        $st = strval($app->status ?? '');
        if ($st === '1' || strtoupper($st) === 'COMPLETED' || strtoupper($st) === 'CONFIRMED') {
          $stBadge = '<span class="label" style="background-color: #dcfce7 !important; color: #15803d !important; border: 1px solid #bbf7d0; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-check-circle"></i> Confirmed</span>';
        } elseif ($st === '2' || strtoupper($st) === 'CANCELLED') {
          $stBadge = '<span class="label" style="background-color: #fee2e2 !important; color: #b91c1c !important; border: 1px solid #fecaca; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-times-circle"></i> Cancelled</span>';
        } else {
          $stBadge = '<span class="label" style="background-color: #fef3c7 !important; color: #b45309 !important; border: 1px solid #fde68a; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 6px;"><i class="fa fa-clock-o"></i> Pending</span>';
        }

        // Payment status badge
        if ($payStatus === 'DONE' || $payStatus === 'SUCCESS' || $payStatus === 'PAID') {
          $payBadge = '<span class="label" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><i class="fa fa-check"></i> Paid</span>';
        } else {
          $payBadge = '<span class="label" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><i class="fa fa-hourglass-half"></i> ' . htmlspecialchars($payStatus) . '</span>';
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
              <div style="overflow: hidden;">
                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Schedule Slot</span>
                <strong style="font-size: 14px; color: #1e293b; display: block; margin-top: 2px;">
                  <?=function_exists('formatedate') ? formatedate($adate) : $adate;?>
                </strong>
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
              <div style="overflow: hidden;">
                <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748b; display: block;">Consultation Fee</span>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                  <strong style="font-size: 16px; color: #0f172a;">&#8377;<?=number_format($feeAmount, 2);?></strong>
                  <?=$payBadge;?>
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
                      <i class="fa fa-info-circle text-info"></i> Registered Account Profile: <strong><?=htmlspecialchars($app->user_fname . ' ' . $app->user_lname);?></strong> (Mobile: <?=htmlspecialchars($app->user_mobile);?>, Email: <?=htmlspecialchars($app->user_email);?>)
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
                <span class="label" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 11px; padding: 3px 8px; border-radius: 4px; font-weight: 700;">
                  <i class="fa fa-check-circle"></i> Verified Specialist
                </span>
              </div>
              <div style="padding: 20px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 18px; padding-bottom: 16px; border-bottom: 1px dashed #e2e8f0;">
                  <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; border: 2px solid #00a896; flex-shrink: 0; background: #f1f5f9;">
                    <img src="<?=$docImg;?>" alt="Doctor Photo" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?=base_url('public/assets/upload/dummydr.jpg');?>';">
                  </div>
                  <div>
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
                  Facility ID: <?=$app->institute_id ? ('#' . $app->institute_id) : 'Private Chamber';?>
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
                    <span style="font-size: 11px; color: #15803d; font-weight: 600; text-transform: uppercase;">Payment Method</span>
                    <div style="font-weight: 700; font-size: 14px; color: #166534; margin-top: 2px;">
                      <?=htmlspecialchars($payMode);?>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6" style="margin-bottom: 12px;">
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Checkout Reference</label>
                    <div style="font-size: 12.5px; font-family: monospace; color: #1e293b;">
                      <?=htmlspecialchars($checkoutId);?>
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
                    <label style="font-size: 11.5px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 3px; display: block;">Settlement Ref No.</label>
                    <div style="font-size: 12.5px; color: #1e293b;">
                      <?=(!empty($app->ref_no)) ? htmlspecialchars($app->ref_no) : 'Direct Confirmation';?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      <?php endif; ?>

    </div>
  </section>
</div>

<!-- Print Stylesheet -->
<style>
@media print {
  body {
    background: #ffffff !important;
    font-size: 12px !important;
    color: #000000 !important;
  }
  .main-header, .main-sidebar, .sidebar, .control-sidebar, .main-footer, .no-print, .breadcrumb {
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
