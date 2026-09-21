<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
          Specimen Chain-of-Custody &amp; Handover Desk
        </h1>
        <small style="color: #64748b; font-size: 13px;">Monitor phlebotomy dispatches, vial barcodes, cold-chain temperature, and lab accession handovers</small>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathology/dashboard')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-dashboard"></i> Dashboard
        </a>
        <a href="<?=base_url('doctor/pathology/index')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #475569;">
          <i class="fa fa-link"></i> Assigned Tests
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px 40px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 16px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Stage Filter Pills -->
      <div style="display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathology/custody')?>" class="btn btn-sm" style="border-radius: 20px; font-weight: 700; padding: 6px 16px; <?=empty($stage) ? 'background: #0f172a; color: #ffffff;' : 'background: #ffffff; border: 1px solid #cbd5e1; color: #475569;'?>">
          All Bookings
        </a>
        <a href="<?=base_url('doctor/pathology/custody?stage=PENDING')?>" class="btn btn-sm" style="border-radius: 20px; font-weight: 700; padding: 6px 16px; <?=$stage=='PENDING' ? 'background: #d97706; color: #ffffff;' : 'background: #ffffff; border: 1px solid #cbd5e1; color: #475569;'?>">
          Pending Collection
        </a>
        <a href="<?=base_url('doctor/pathology/custody?stage=IN_TRANSIT')?>" class="btn btn-sm" style="border-radius: 20px; font-weight: 700; padding: 6px 16px; <?=$stage=='IN_TRANSIT' ? 'background: #0284c7; color: #ffffff;' : 'background: #ffffff; border: 1px solid #cbd5e1; color: #475569;'?>">
          In Transit Runs
        </a>
        <a href="<?=base_url('doctor/pathology/custody?stage=RECEIVED_AT_LAB')?>" class="btn btn-sm" style="border-radius: 20px; font-weight: 700; padding: 6px 16px; <?=$stage=='RECEIVED_AT_LAB' ? 'background: #16a34a; color: #ffffff;' : 'background: #ffffff; border: 1px solid #cbd5e1; color: #475569;'?>">
          Received at Lab
        </a>
        <a href="<?=base_url('doctor/pathology/custody?stage=REPORT_READY')?>" class="btn btn-sm" style="border-radius: 20px; font-weight: 700; padding: 6px 16px; <?=$stage=='REPORT_READY' ? 'background: #7c3aed; color: #ffffff;' : 'background: #ffffff; border: 1px solid #cbd5e1; color: #475569;'?>">
          Reports Ready / Published
        </a>
      </div>

      <!-- Main Custody Table Card -->
      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden;">
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
          <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-truck" style="color: #00a896;"></i>
            <span>Specimen Logistics &amp; Custody Runs (<?=number_format($total_rows ?? 0);?>)</span>
          </h3>

          <form action="<?=base_url('doctor/pathology/custody')?>" method="get" style="display: flex; gap: 8px; margin: 0;">
            <input type="hidden" name="stage" value="<?=$stage;?>">
            <input type="text" name="keyword" class="form-control input-sm" placeholder="Search patient, barcode, booking..." value="<?=htmlspecialchars($keyword ?? '');?>" style="height: 34px; border-radius: 6px; width: 220px;">
            <button type="submit" class="btn btn-sm btn-default" style="height: 34px; border-radius: 6px; font-weight: 600;">
              <i class="fa fa-search"></i>
            </button>
            <?php if(!empty($keyword)): ?>
              <a href="<?=base_url('doctor/pathology/custody?stage='.$stage)?>" class="btn btn-sm btn-default text-danger" style="height: 34px; line-height: 20px; border-radius: 6px;">
                <i class="fa fa-times"></i>
              </a>
            <?php endif; ?>
          </form>
        </div>

        <div class="master-card-body" style="padding: 0;">
          <div class="table-responsive">
            <table class="table table-hover table-striped" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc; color: #475569; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                  <th style="width: 80px;">Booking #</th>
                  <th>Patient Info</th>
                  <th>Partner Lab</th>
                  <th>Phlebotomist / Runner</th>
                  <th>Vial Barcode</th>
                  <th style="text-align: center;">Temp (°C)</th>
                  <th style="text-align: center;">Custody Stage</th>
                  <th style="text-align: center; width: 170px;">Custody Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($bookings)): foreach($bookings as $row): 
                  $bId = $row->booking_id;
                  $currStage = $row->order_stage ?: 'BOOKED';
                  $barcode = $row->barcode_number ?: ($row->vial_barcode ?: 'Unassigned');
                  $temp = $row->collection_temperature_c ? ($row->collection_temperature_c . '°C') : '—';
                  $phlebo = (!empty($row->phlebo_name)) ? ($row->phlebo_name . ' ' . $row->phlebo_surname) : 'Unassigned';
                  
                  $stageBg = ($currStage == 'IN_TRANSIT') ? '#e0f2fe; color: #0284c7;' : (($currStage == 'RECEIVED_AT_LAB') ? '#dcfce7; color: #16a34a;' : (($currStage == 'REPORT_READY'||$currStage=='COMPLETED') ? '#f3e8ff; color: #7e22ce;' : '#fef3c7; color: #d97706;'));
                ?>
                  <tr>
                    <td style="vertical-align: middle; font-weight: 700; color: #0f172a;">
                      #<?=$bId;?>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;"><?=$row->patient_name;?></div>
                      <div style="font-size: 12px; color: #64748b;">
                        <i class="fa fa-phone"></i> <?=$row->patient_mobile;?> | <?=$row->patient_gender;?>, <?=$row->patient_age;?>y
                      </div>
                      <small style="color: #94a3b8; display: block; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <i class="fa fa-map-marker"></i> <?=$row->patient_address ?: 'Clinic Walk-in';?>
                      </small>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 600; color: #0f172a; font-size: 13px;">
                        <i class="fa fa-hospital-o text-muted"></i> <?=$row->lab_name ?: 'Partner Lab #'.$row->pathlab_id;?>
                      </div>
                    </td>
                    <td style="vertical-align: middle;">
                      <?php if($row->assigned_collector_id > 0): ?>
                        <div style="font-weight: 600; color: #1e293b; font-size: 13px;">
                          <i class="fa fa-user-circle text-info"></i> <?=$phlebo;?>
                        </div>
                        <small style="color: #64748b; font-size: 11px;"><?=$row->phlebo_mobile;?></small>
                      <?php else: ?>
                        <span class="badge" style="background: #f1f5f9; color: #64748b; font-weight: 600; font-size: 11px;">
                          Unassigned
                        </span>
                      <?php endif; ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <?php if($barcode != 'Unassigned'): ?>
                        <div style="display: inline-flex; align-items: center; gap: 4px; background: #f8fafc; border: 1px dashed #cbd5e1; padding: 3px 8px; border-radius: 4px; font-family: monospace; font-weight: 700; color: #0f172a;">
                          <i class="fa fa-barcode"></i> <?=$barcode;?>
                        </div>
                      <?php else: ?>
                        <span style="color: #94a3b8; font-size: 12px;">Not Barcoded</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle; font-weight: 700; color: #0369a1; font-size: 12.5px;">
                      <?=$temp;?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge" style="background: <?=$stageBg;?> font-size: 11px; font-weight: 700; padding: 4px 10px;">
                        <?=$currStage;?>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <div style="display: flex; gap: 4px; justify-content: center; align-items: center; flex-wrap: wrap;">
                        
                        <!-- Assign Phlebo Button -->
                        <?php if($currStage == 'BOOKED' || $currStage == 'PENDING' || empty($currStage) || $row->assigned_collector_id == 0): ?>
                          <button type="button" class="btn btn-xs btn-primary" onclick="openAssignModal(<?=$bId;?>, '<?=htmlspecialchars(addslashes($row->patient_name));?>', '<?=$row->vial_barcode ?? '';?>')" style="background: #0284c7; border-color: #0284c7; font-weight: 600; border-radius: 4px;" title="Assign Phlebotomist">
                            <i class="fa fa-user-plus"></i> Dispatch
                          </button>
                        <?php endif; ?>

                        <!-- Lab Handover Handshake Button -->
                        <?php if($currStage == 'IN_TRANSIT' || $currStage == 'SAMPLE_COLLECTED'): ?>
                          <button type="button" class="btn btn-xs btn-success" onclick="openHandoverModal(<?=$bId;?>, '<?=htmlspecialchars(addslashes($row->patient_name));?>', '<?=$barcode;?>', '<?=$row->handover_verification_otp ?? '1234';?>')" style="background: #16a34a; border-color: #16a34a; font-weight: 600; border-radius: 4px;" title="Verify Lab Handover">
                            <i class="fa fa-check-square-o"></i> Lab Handover
                          </button>
                        <?php endif; ?>

                        <!-- Stepper Timeline -->
                        <a href="<?=base_url('doctor/pathology/custody_timeline/'.$bId);?>" class="btn btn-xs btn-default" style="font-weight: 600; border-radius: 4px;" title="View Chain-of-Custody Timeline">
                          <i class="fa fa-line-chart"></i> Stepper
                        </a>

                      </div>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" style="text-align: center; padding: 36px 20px; color: #94a3b8;">
                      <i class="fa fa-truck fa-3x" style="opacity: 0.4; margin-bottom: 8px; display: block;"></i>
                      No specimen custody records matching this filter.
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

<!-- Modal: Assign Phlebotomist & Barcode -->
<div class="modal fade" id="modal-assign-phlebo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 480px; margin-top: 80px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.18); overflow: hidden;">
      <div class="modal-header" style="background: #0284c7; color: #ffffff; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; font-size: 16px;">
          <i class="fa fa-user-plus"></i> Dispatch Field Phlebotomist
        </h4>
        <small style="opacity: 0.9;">Booking #<span id="assign-modal-bid"></span> — <span id="assign-modal-pname"></span></small>
      </div>

      <form action="<?=base_url('doctor/pathology/custody_assign')?>" method="post">
        <input type="hidden" name="booking_id" id="assign_booking_id">

        <div class="modal-body" style="padding: 22px;">
          <div class="form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Select Phlebotomist / Collector <span style="color: #ef4444;">*</span></label>
            <select name="staff_id" id="staff_id" class="form-control" required style="height: 40px; border-radius: 6px; font-weight: 600;">
              <option value="">-- Choose Phlebotomist --</option>
              <?php if(!empty($phlebotomists)): foreach($phlebotomists as $ph): ?>
                <option value="<?=$ph->id;?>"><?=$ph->name;?> <?=$ph->surname;?> (Ph: <?=$ph->contact_no;?>)</option>
              <?php endforeach; endif; ?>
            </select>
          </div>

          <div class="form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Assign Vial Barcode <span style="color: #ef4444;">*</span></label>
            <div class="input-group">
              <input type="text" name="barcode" id="assign_barcode" class="form-control" placeholder="BC-892341" required style="height: 40px; font-family: monospace; font-weight: 700;">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" onclick="generateBarcode()" style="font-weight: 600; height: 40px;">
                  <i class="fa fa-refresh"></i> Generate
                </button>
              </span>
            </div>
          </div>

          <div class="form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Collection / Gel-Pack Temp (°C)</label>
            <input type="number" step="0.1" name="temperature_c" class="form-control" value="4.2" placeholder="e.g. 4.2" style="height: 40px; border-radius: 6px;">
            <small style="color: #64748b;">Specimen cold-chain target: 2°C - 8°C</small>
          </div>
        </div>

        <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 6px;">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #0284c7; border-color: #0284c7; font-weight: 700; border-radius: 6px; padding: 8px 20px;">
            <i class="fa fa-paper-plane"></i> Confirm Dispatch
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Lab Accession Handover Double-Handshake -->
<div class="modal fade" id="modal-lab-handover" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 480px; margin-top: 80px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.18); overflow: hidden;">
      <div class="modal-header" style="background: #16a34a; color: #ffffff; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; font-size: 16px;">
          <i class="fa fa-handshake-o"></i> Lab Accession Handover Double-Handshake
        </h4>
        <small style="opacity: 0.9;">Booking #<span id="handover-modal-bid"></span> — <span id="handover-modal-pname"></span></small>
      </div>

      <form action="<?=base_url('doctor/pathology/custody_handover')?>" method="post">
        <input type="hidden" name="booking_id" id="handover_booking_id">

        <div class="modal-body" style="padding: 22px;">
          <div style="background: #f0fdf4; border: 1px dashed #86efac; border-radius: 8px; padding: 12px; margin-bottom: 16px; text-align: center;">
            <span style="font-size: 11px; font-weight: 700; color: #166534; text-transform: uppercase;">Handover Token / Expected OTP:</span>
            <div id="handover-expected-otp" style="font-size: 24px; font-weight: 800; color: #15803d; letter-spacing: 4px; margin-top: 2px;">
              6109
            </div>
            <small style="color: #64748b; font-size: 11px;">Phlebotomist runner provides this OTP to Lab Desk technician</small>
          </div>

          <div class="form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Lab Desk Receiver / Technician Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="receiver_name" class="form-control" placeholder="e.g. Anil Verma (Accessioning Desk)" required style="height: 40px; border-radius: 6px;">
          </div>

          <div class="form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Verify Handover OTP <span style="color: #ef4444;">*</span></label>
            <input type="text" name="otp" id="handover_otp_input" class="form-control" placeholder="Enter 4-digit OTP" maxlength="6" required style="height: 40px; border-radius: 6px; font-family: monospace; font-weight: 700; font-size: 16px; letter-spacing: 2px;">
          </div>

          <div class="form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Specimen Physical Quality on Receipt <span style="color: #ef4444;">*</span></label>
            <select name="condition" class="form-control" required style="height: 40px; border-radius: 6px; font-weight: 600;">
              <option value="intact" selected>✅ INTACT / Non-Hemolyzed (Accept Sample)</option>
              <option value="hemolyzed">⚠️ Hemolyzed (Reject / Recollect)</option>
              <option value="lipemic">⚠️ Lipemic (Notice)</option>
              <option value="leaked">❌ Leaked / Broken Tube (Reject)</option>
              <option value="quantity_insufficient">❌ Quantity Insufficient / QNS (Reject)</option>
            </select>
          </div>
        </div>

        <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 6px;">Cancel</button>
          <button type="submit" class="btn btn-success" style="background: #16a34a; border-color: #16a34a; font-weight: 700; border-radius: 6px; padding: 8px 22px;">
            <i class="fa fa-check-circle"></i> Complete Custody Handover
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function generateBarcode() {
  var bc = 'BC-' + Math.floor(100000 + Math.random() * 900000);
  $('#assign_barcode').val(bc);
}

function openAssignModal(bId, pName, existingBarcode) {
  $('#assign_booking_id').val(bId);
  $('#assign-modal-bid').text(bId);
  $('#assign-modal-pname').text(pName);
  $('#assign_barcode').val(existingBarcode || ('BC-' + Math.floor(100000 + Math.random() * 900000)));
  $('#modal-assign-phlebo').modal('show');
}

function openHandoverModal(bId, pName, barcode, otp) {
  $('#handover_booking_id').val(bId);
  $('#handover-modal-bid').text(bId);
  $('#handover-modal-pname').text(pName);
  $('#handover-expected-otp').text(otp || '6109');
  $('#handover_otp_input').val(otp || '6109');
  $('#modal-lab-handover').modal('show');
}
</script>
