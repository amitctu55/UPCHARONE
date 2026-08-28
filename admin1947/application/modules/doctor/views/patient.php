<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Doctor Consultation Appointments</h1>
        <small style="color: #64748b; font-size: 13px;">View and manage scheduled patient consultation bookings for selected doctor</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorwise')?>" style="color: #64748b;">Doctor Wise</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Patient Bookings</li>
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

      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden;">
        
        <!-- Header -->
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
          <h3 class="master-card-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-calendar-check-o" style="color: #00a896;"></i>
            <span>Patient Consultation Appointments</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 5px 10px; border-radius: 12px;">
              Total: <?=count($appointment);?> Bookings
            </span>
            <a href="<?=base_url('doctor/appointment/doctorwise')?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
              &larr; Back to Doctor List
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          
          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="patient-app-table" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc;">
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Patient Details</th>
                  <th>Appointment Date &amp; Slot</th>
                  <th>Contact Info</th>
                  <th>Hospital / Facility</th>
                  <th>Consulting Doctor</th>
                  <th style="width: 100px; text-align: center;">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($appointment)): foreach($appointment as $p): 
                  $aid = $p->appointment_id ?? ($p->id ?? 0);
                  $pname = $p->appointment_name ?: 'Patient';
                  $adate = $p->appointment_date ?: '';
                  $time = ($p->from_timing && $p->to_timing) ? ($p->from_timing . ' - ' . $p->to_timing) : '';
                  $mobile = $p->appointment_mobile ?: '';
                  $email = $p->appointment_email ?: '';
                  $hname = $p->hospital_name ?: 'General Hospital';
                  $drName = trim(($p->dr_fname ?? '') . ' ' . ($p->dr_lname ?? ''));
                  $drDisplay = (stripos($drName, 'Dr.') === 0 || stripos($drName, 'Dr ') === 0) ? $drName : ($drName ? 'Dr. ' . $drName : 'Doctor');
                ?>
                  <tr>
                    <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: middle;"><?=$aid;?></td>
                    
                    <!-- Patient Name & Age -->
                    <td style="vertical-align: middle;">
                      <strong style="color: #0f172a; font-size: 13.5px; display: block;"><?=html_escape($pname);?></strong>
                      <?php if(!empty($p->age)): ?>
                        <span style="font-size: 11.5px; color: #64748b;">Age: <?=$p->age;?> Yrs</span>
                      <?php endif; ?>
                    </td>

                    <!-- Scheduled Date & Time -->
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background: #e0f2fe !important; color: #0369a1 !important; border: 1px solid #bae6fd; font-size: 11.5px;">
                        <i class="fa fa-calendar"></i> <?=(function_exists('formatedate') ? formatedate($adate) : $adate);?> <?=$time ? '('.$time.')' : '';?>
                      </span>
                    </td>

                    <!-- Contact -->
                    <td style="vertical-align: middle;">
                      <?php if($mobile): ?>
                        <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape($mobile);?></div>
                      <?php endif; ?>
                      <?php if($email): ?>
                        <div style="font-size: 12px; color: #64748b;"><i class="fa fa-envelope-o" style="color: #64748b;"></i> <?=html_escape($email);?></div>
                      <?php endif; ?>
                    </td>

                    <!-- Hospital -->
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-hospital-o"></i> <?=html_escape($hname);?>
                      </span>
                    </td>

                    <!-- Doctor -->
                    <td style="vertical-align: middle;">
                      <strong style="color: #00a896; font-size: 13px;"><i class="fa fa-user-md"></i> <?=html_escape($drDisplay);?></strong>
                    </td>

                    <!-- Status -->
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                        <i class="fa fa-check-circle"></i> Confirmed
                      </span>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No consultation bookings found for this doctor.</p>
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

<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#patient-app-table')) {
        $('#patient-app-table').DataTable().destroy();
    }
    $('#patient-app-table').DataTable({
        "order": [[ 0, "desc" ]],
        "pageLength": 15,
        "language": {
            "search": "Filter in table:",
            "paginate": {
                "previous": "&larr; Prev",
                "next": "Next &rarr;"
            }
        }
    });
});
</script>
