<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Appointment Confirmation &amp; Settlement</h1>
        <small style="color: #64748b; font-size: 13px;">Review booking invoice details and confirm consultation order</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Checkout Confirmation</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">
      
      <?php 
      $appointment_data = $this->db->get_where('appointment', array('appointment_id' => $AppointmentCheckout))->row(); 
      ?>

      <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
          
          <div class="master-card" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 30px;">
            
            <!-- Card Header -->
            <div style="background: linear-gradient(135deg, #043d5b 0%, #008f80 60%, #00a896 100%); padding: 24px 28px; color: #ffffff;">
              <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div>
                  <span class="badge" style="background: rgba(255,255,255,0.2); font-size: 11px; padding: 4px 10px; margin-bottom: 6px;">
                    <i class="fa fa-file-text-o"></i> Order Reference: <?=$gatewayData['Order_Id'];?>
                  </span>
                  <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: #ffffff;">Consultation Booking Summary</h3>
                </div>
                <div style="text-align: right;">
                  <div style="font-size: 12px; color: rgba(255,255,255,0.85);">Appointment Token</div>
                  <div style="font-size: 22px; font-weight: 800; font-family: monospace; color: #ffffff;">#<?=$AppointmentCheckout;?></div>
                </div>
              </div>
            </div>

            <!-- Card Body -->
            <div style="padding: 28px;">
              
              <!-- Patient & Visit Details Grid -->
              <div class="row" style="margin-bottom: 24px;">
                <div class="col-md-6 col-sm-6" style="margin-bottom: 16px;">
                  <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                    Patient Information
                  </div>
                  <div style="font-size: 16px; font-weight: 800; color: #0f172a; text-transform: capitalize;">
                    <?=$gatewayData['billing_cust_name'];?>
                  </div>
                  <div style="font-size: 13px; color: #475569; margin-top: 4px;">
                    <div><i class="fa fa-phone text-aqua" style="color: #00a896;"></i> <?=$appointment_data->appointment_mobile;?></div>
                    <?php if(!empty($appointment_data->appointment_email)): ?>
                      <div><i class="fa fa-envelope text-aqua" style="color: #00a896;"></i> <?=$appointment_data->appointment_email;?></div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="col-md-6 col-sm-6" style="margin-bottom: 16px;">
                  <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                    Doctor &amp; Facility
                  </div>
                  <div style="font-size: 15px; font-weight: 800; color: #00a896;">
                    Dr. <?=getDoctorName($appointment_data->doctor_id);?>
                  </div>
                  <div style="font-size: 13px; color: #475569; margin-top: 4px;">
                    <div><i class="fa fa-hospital-o" style="color: #00a896;"></i> <?=getInstituteName($appointment_data->institute_id, $appointment_data->institution_type);?></div>
                    <div><i class="fa fa-calendar text-muted"></i> <?=date('d M Y', strtotime($appointment_data->appointment_date));?> (<?=$appointment_data->from_timing;?> - <?=$appointment_data->to_timing;?>)</div>
                  </div>
                </div>
              </div>

              <!-- Itemized Invoice Table -->
              <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 24px;">
                <table class="table" style="margin: 0; font-size: 13.5px;">
                  <thead>
                    <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                      <th style="padding: 12px 16px;">Service Description</th>
                      <th style="padding: 12px 16px; text-align: center;">Session Slot</th>
                      <th style="padding: 12px 16px; text-align: right;">Fee Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="padding: 14px 16px;">
                        <strong>Doctor OPD Consultation Fee</strong>
                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                          Dr. <?=getDoctorName($appointment_data->doctor_id);?> at <?=getInstituteName($appointment_data->institute_id, $appointment_data->institution_type);?>
                        </div>
                      </td>
                      <td style="padding: 14px 16px; text-align: center; color: #334155;">
                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11.5px; padding: 4px 8px;">
                          <?=$appointment_data->from_timing;?> - <?=$appointment_data->to_timing;?>
                        </span>
                      </td>
                      <td style="padding: 14px 16px; text-align: right; font-weight: 700; color: #0f172a;">
                        Rs. <?=number_format(floatval($appointment_data->fee), 2);?>
                      </td>
                    </tr>
                    <tr style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
                      <td colspan="2" style="padding: 14px 16px; text-align: right; font-weight: 800; font-size: 15px; color: #0f172a;">
                        Total Payable at Counter:
                      </td>
                      <td style="padding: 14px 16px; text-align: right; font-weight: 800; font-size: 17px; color: #00a896;">
                        Rs. <?=number_format(floatval($gatewayData['Amount']), 2);?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Settlement Notice -->
              <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #166534;">
                <i class="fa fa-info-circle fa-lg" style="color: #10b981;"></i>
                <span>Clicking <strong>Confirm &amp; Finalize Booking</strong> will send SMS &amp; Email confirmations to the patient and record the appointment in the doctor's active consultation list.</span>
              </div>

              <!-- Action CTAs -->
              <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <a href="<?=base_url('doctor/appointment/addappointment');?>" class="btn btn-default" style="font-weight: 600; padding: 10px 20px; border-radius: 8px; color: #64748b;">
                  <i class="fa fa-arrow-left"></i> Back / Modify
                </a>

                <div style="display: flex; gap: 10px;">
                  <button type="button" id="confirmCocBtn" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; font-size: 14px; padding: 10px 26px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);">
                    <i class="fa fa-check-circle"></i> Confirm &amp; Finalize Booking (Pay on Counter)
                  </button>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function(){
  $('#confirmCocBtn').on('click', function(){
    var btn = $(this);
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Finalizing Booking...');
    window.location = "<?=base_url();?>doctor/appointment/processordercod_admin";
  });
});
</script>