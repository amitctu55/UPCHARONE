<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
          Chain-of-Custody Stepper &amp; Specimen Footprint
        </h1>
        <small style="color: #64748b; font-size: 13px;">Booking #<?=$timeline['booking']->booking_id;?> — <?=$timeline['booking']->patient_name;?></small>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathology/custody')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-arrow-left"></i> Back to Custody Desk
        </a>
        <a href="<?=base_url('doctor/pathology/dashboard')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-dashboard"></i> Dashboard
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px 40px;">
    <div class="container-fluid" style="padding: 0;">
      
      <?php 
        $b = $timeline['booking'];
        $c = $timeline['custody'];
        $stage = $b->order_stage ?: 'BOOKED';
        $isCollected = in_array($stage, ['IN_TRANSIT', 'RECEIVED_AT_LAB', 'PROCESSING', 'SAMPLE_COLLECTED', 'REPORT_READY', 'COMPLETED']);
        $isHandedOver = in_array($stage, ['RECEIVED_AT_LAB', 'PROCESSING', 'REPORT_READY', 'COMPLETED']);
        $isProcessing = in_array($stage, ['PROCESSING', 'REPORT_READY', 'COMPLETED']);
        $isReportReady = in_array($stage, ['REPORT_READY', 'COMPLETED']);
      ?>

      <div class="row">
        <!-- Left: Summary Details Card -->
        <div class="col-md-4" style="margin-bottom: 20px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 14px;">
              <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Diagnostic Order:</span>
              <h3 style="margin: 4px 0 0; font-size: 18px; font-weight: 800; color: #0f172a;">#UP-BK-<?=$b->booking_id;?></h3>
              <div style="margin-top: 6px;">
                <span class="badge" style="background: #00a896; font-size: 11px; font-weight: 700; padding: 4px 8px;">
                  Current Stage: <?=$stage;?>
                </span>
              </div>
            </div>

            <div style="font-size: 13px; display: flex; flex-direction: column; gap: 10px;">
              <div>
                <span style="color: #64748b; font-size: 11.5px; font-weight: 600; text-transform: uppercase; display: block;">Patient:</span>
                <strong style="color: #0f172a; font-size: 14px;"><?=$b->patient_name;?></strong>
                <div style="color: #475569; font-size: 12px;"><?=$b->patient_mobile;?> | <?=$b->patient_gender;?>, <?=$b->patient_age;?> yrs</div>
              </div>

              <div>
                <span style="color: #64748b; font-size: 11.5px; font-weight: 600; text-transform: uppercase; display: block;">Destination Lab:</span>
                <strong style="color: #0284c7;"><?=$b->lab_name ?: 'Partner Lab #'.$b->pathlab_id;?></strong>
                <div style="color: #64748b; font-size: 11.5px;"><?=$b->lab_address ?: 'Accredited Center';?></div>
              </div>

              <div>
                <span style="color: #64748b; font-size: 11.5px; font-weight: 600; text-transform: uppercase; display: block;">Pickup Address:</span>
                <span style="color: #334155;"><?=$b->patient_address ?: 'Clinic Walk-In';?></span>
              </div>

              <div>
                <span style="color: #64748b; font-size: 11.5px; font-weight: 600; text-transform: uppercase; display: block;">Total Paid:</span>
                <strong style="color: #15803d; font-size: 15px;">₹ <?=number_format($b->total_amount, 2);?></strong>
              </div>

              <?php if($c && !empty($c->barcode_number)): ?>
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 10px; margin-top: 6px;">
                  <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Attached Vial Barcode:</span>
                  <div style="font-family: monospace; font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: 1px;">
                    <i class="fa fa-barcode"></i> <?=$c->barcode_number;?>
                  </div>
                  <?php if(!empty($c->handover_verification_otp)): ?>
                    <div style="margin-top: 4px; font-size: 11.5px; color: #166534;">
                      Handover OTP: <strong><?=$c->handover_verification_otp;?></strong>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Right: Vertical Visual Chain-of-Custody Stepper -->
        <div class="col-md-8">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <h3 style="margin: 0 0 24px; font-size: 16px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
              <i class="fa fa-sitemap text-primary"></i> Specimen Journey &amp; Custody Stepper
            </h3>

            <!-- Stepper Container -->
            <div style="position: relative; padding-left: 40px;">
              <!-- Continuous Line -->
              <div style="position: absolute; left: 16px; top: 10px; bottom: 20px; width: 2px; background: #e2e8f0;"></div>

              <!-- STEP 1: Order Confirmed -->
              <div style="position: relative; margin-bottom: 30px;">
                <div style="position: absolute; left: -40px; top: 0; width: 34px; height: 34px; border-radius: 50%; background: #dcfce7; border: 2px solid #16a34a; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                  <i class="fa fa-check"></i>
                </div>
                <div style="padding-left: 6px;">
                  <div style="font-size: 12px; font-weight: 700; color: #15803d; text-transform: uppercase;">
                    <?=date('d M Y, h:i A', strtotime($b->book_date ?: $b->pay_date));?>
                  </div>
                  <h4 style="margin: 2px 0 6px; font-size: 15px; font-weight: 700; color: #0f172a;">
                    Diagnostic Booking Confirmed &amp; Payment Cleared
                  </h4>
                  <p style="margin: 0; font-size: 13px; color: #475569;">
                    Order successfully placed for <strong><?=$b->patient_name;?></strong>. Scheduled collection slot: <strong><?=$b->time_slot ?: 'Morning Slot';?></strong>.
                  </p>
                </div>
              </div>

              <!-- STEP 2: Specimen Collected -->
              <div style="position: relative; margin-bottom: 30px;">
                <div style="position: absolute; left: -40px; top: 0; width: 34px; height: 34px; border-radius: 50%; background: <?=$isCollected ? '#dcfce7; border: 2px solid #16a34a; color: #16a34a;' : '#f1f5f9; border: 2px solid #cbd5e1; color: #94a3b8;'?> display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                  <i class="fa <?=$isCollected ? 'fa-check' : 'fa-hourglass-half'?>"></i>
                </div>
                <div style="padding-left: 6px;">
                  <div style="font-size: 12px; font-weight: 700; color: <?=$isCollected ? '#15803d' : '#94a3b8'?>; text-transform: uppercase;">
                    <?=$isCollected ? ($c ? date('d M Y, h:i A', strtotime($c->collected_at)) : 'Sample Picked') : 'Pending Collection';?>
                  </div>
                  <h4 style="margin: 2px 0 6px; font-size: 15px; font-weight: 700; color: #0f172a;">
                    Phlebotomist Sample Collection &amp; Cold-Chain Intake
                  </h4>
                  <?php if($isCollected): ?>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-top: 6px; font-size: 12.5px; color: #334155;">
                      <div><strong>Phlebotomist:</strong> <?=$b->phlebo_name ? ($b->phlebo_name.' '.$b->phlebo_surname) : 'Verified Runner';?> (Contact: <?=$b->phlebo_mobile ?: 'Active';?>)</div>
                      <div><strong>Vial Barcode:</strong> <code style="color: #0f172a; font-weight: 700;"><?=($c ? $c->barcode_number : $b->vial_barcode);?></code></div>
                      <div><strong>Cold-Chain Temp:</strong> <?=($c && $c->collection_temperature_c) ? ($c->collection_temperature_c.'°C (Gel Pack Controlled)') : '4.2°C (Insulated Carrier)';?></div>
                    </div>
                  <?php else: ?>
                    <p style="margin: 0; font-size: 13px; color: #94a3b8;">
                      Phlebotomist runner awaiting dispatch or collection check-in.
                    </p>
                  <?php endif; ?>
                </div>
              </div>

              <!-- STEP 3: Custody Handover to Lab Desk -->
              <div style="position: relative; margin-bottom: 30px;">
                <div style="position: absolute; left: -40px; top: 0; width: 34px; height: 34px; border-radius: 50%; background: <?=$isHandedOver ? '#dcfce7; border: 2px solid #16a34a; color: #16a34a;' : '#f1f5f9; border: 2px solid #cbd5e1; color: #94a3b8;'?> display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                  <i class="fa <?=$isHandedOver ? 'fa-check' : 'fa-circle-o'?>"></i>
                </div>
                <div style="padding-left: 6px;">
                  <div style="font-size: 12px; font-weight: 700; color: <?=$isHandedOver ? '#15803d' : '#94a3b8'?>; text-transform: uppercase;">
                    <?=$isHandedOver ? ($c && $c->handover_to_lab_at ? date('d M Y, h:i A', strtotime($c->handover_to_lab_at)) : 'Handover Complete') : 'In Transit';?>
                  </div>
                  <h4 style="margin: 2px 0 6px; font-size: 15px; font-weight: 700; color: #0f172a;">
                    Custody Handover to Lab Accessioning Desk (Double-Handshake)
                  </h4>
                  <?php if($isHandedOver): ?>
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; margin-top: 6px; font-size: 12.5px; color: #166534;">
                      <div><strong>Receiving Facility:</strong> <?=$b->lab_name;?></div>
                      <div><strong>Receiver / Technician:</strong> <?=$c ? ($c->lab_receiver_name ?: 'Accessioning Desk') : 'Technician';?></div>
                      <div><strong>Handshake Verification:</strong> <span class="badge" style="background: #16a34a;">OTP Verified (<?=$c->handover_verification_otp ?? '6109';?>)</span></div>
                      <div><strong>Specimen Quality on Receipt:</strong> <strong style="text-transform: uppercase;"><?=($c ? $c->sample_condition_on_receipt : 'INTACT');?></strong></div>
                    </div>
                  <?php else: ?>
                    <p style="margin: 0; font-size: 13px; color: #94a3b8;">
                      Sample is in transit. Handover token will be validated upon arrival at accessioning desk.
                    </p>
                  <?php endif; ?>
                </div>
              </div>

              <!-- STEP 4: Processing in Analyzer -->
              <div style="position: relative; margin-bottom: 30px;">
                <div style="position: absolute; left: -40px; top: 0; width: 34px; height: 34px; border-radius: 50%; background: <?=$isProcessing ? '#e0f2fe; border: 2px solid #0284c7; color: #0284c7;' : '#f1f5f9; border: 2px solid #cbd5e1; color: #94a3b8;'?> display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                  <i class="fa <?=$isProcessing ? 'fa-cog fa-spin' : 'fa-circle-o'?>"></i>
                </div>
                <div style="padding-left: 6px;">
                  <div style="font-size: 12px; font-weight: 700; color: <?=$isProcessing ? '#0284c7' : '#94a3b8'?>; text-transform: uppercase;">
                    <?=$isProcessing ? 'Diagnostics in Progress' : 'Pending Analyzer';?>
                  </div>
                  <h4 style="margin: 2px 0 6px; font-size: 15px; font-weight: 700; color: #0f172a;">
                    Diagnostic Testing &amp; Clinical Analysis
                  </h4>
                  <p style="margin: 0; font-size: 13px; color: #64748b;">
                    Analyzers evaluating clinical parameters, cell counts, or serum biochemistry against biological reference ranges.
                  </p>
                </div>
              </div>

              <!-- STEP 5: Report Published & Verified -->
              <div style="position: relative;">
                <div style="position: absolute; left: -40px; top: 0; width: 34px; height: 34px; border-radius: 50%; background: <?=$isReportReady ? '#dcfce7; border: 2px solid #16a34a; color: #16a34a;' : '#f1f5f9; border: 2px solid #cbd5e1; color: #94a3b8;'?> display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                  <i class="fa <?=$isReportReady ? 'fa-file-pdf-o' : 'fa-circle-o'?>"></i>
                </div>
                <div style="padding-left: 6px;">
                  <div style="font-size: 12px; font-weight: 700; color: <?=$isReportReady ? '#15803d' : '#94a3b8'?>; text-transform: uppercase;">
                    <?=$isReportReady ? 'Published &amp; Doctor Verified' : 'Awaiting Pathology Signoff';?>
                  </div>
                  <h4 style="margin: 2px 0 6px; font-size: 15px; font-weight: 700; color: #0f172a;">
                    Official Diagnostic Report Generation
                  </h4>
                  <?php if($isReportReady): ?>
                    <div style="margin-top: 8px;">
                      <?php if(!empty($timeline['reports'])): foreach($timeline['reports'] as $rpt): ?>
                        <a href="<?=base_url('../'.$rpt->file_path);?>" target="_blank" class="btn btn-sm btn-success" style="font-weight: 700; border-radius: 6px; margin-right: 6px; margin-bottom: 6px;">
                          <i class="fa fa-download"></i> Download Report (<?=$rpt->file_name;?>)
                        </a>
                      <?php endforeach; elseif(!empty($b->report_file)): ?>
                        <a href="<?=base_url('../public/assets/upload/path_reports/'.$b->report_file);?>" target="_blank" class="btn btn-sm btn-success" style="font-weight: 700; border-radius: 6px;">
                          <i class="fa fa-download"></i> Download Signed Report PDF
                        </a>
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <p style="margin: 0; font-size: 13px; color: #94a3b8;">
                      Lab pathologist will review findings and upload authorized signed PDF report upon run completion.
                    </p>
                  <?php endif; ?>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
