<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Appointment Analytics &amp; Tracking</h1>
        <small style="color: #64748b; font-size: 13px;">Doctor-level metrics, hospital-doctor cross-breakdowns, and consultation volume intelligence</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Analytics &amp; Tracking</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">

      <!-- Top KPI Metric Cards -->
      <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #00a896 0%, #028090 100%); color: #fff; border-radius: 8px 0 0 8px;">
              <i class="fa fa-calendar-check-o"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Appointments</span>
              <span class="info-box-number" style="font-size: 22px; font-weight: 700; color: #1e293b;"><?=number_format($total_appointments);?></span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: #fff; border-radius: 8px 0 0 8px;">
              <i class="fa fa-clock-o"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase;">Today's Bookings</span>
              <span class="info-box-number" style="font-size: 22px; font-weight: 700; color: #1e293b;"><?=number_format($today_appointments);?></span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: #fff; border-radius: 8px 0 0 8px;">
              <i class="fa fa-user-md"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase;">Tracked Doctors</span>
              <span class="info-box-number" style="font-size: 22px; font-weight: 700; color: #1e293b;"><?=number_format(@$total_doctors ?: count($doctor_stats));?></span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 8px 0 0 8px;">
              <i class="fa fa-hospital-o"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase;">Active Hospital Links</span>
              <span class="info-box-number" style="font-size: 22px; font-weight: 700; color: #1e293b;"><?=count($hospital_doctor_stats);?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Analytics Navigation Tabs -->
      <div class="nav-tabs-custom" style="border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; background: #fff;">
        <ul class="nav nav-tabs" style="border-bottom: 1px solid #e2e8f0; padding: 5px 15px 0; background: #f8fafc; border-radius: 8px 8px 0 0;">
          <li class="active">
            <a href="#tab_doctor_tracking" data-toggle="tab" style="font-weight: 600; color: #334155; border-radius: 6px 6px 0 0;">
              <i class="fa fa-user-md" style="color: #00a896; margin-right: 5px;"></i> Doctor-Level Tracking
            </a>
          </li>
          <li>
            <a href="#tab_hospital_doctor" data-toggle="tab" style="font-weight: 600; color: #334155; border-radius: 6px 6px 0 0;">
              <i class="fa fa-hospital-o" style="color: #3b82f6; margin-right: 5px;"></i> Hospital-Doctor Cross Tracking
            </a>
          </li>
          <li>
            <a href="#tab_affiliations" data-toggle="tab" style="font-weight: 600; color: #334155; border-radius: 6px 6px 0 0;">
              <i class="fa fa-sitemap" style="color: #8b5cf6; margin-right: 5px;"></i> Practice &amp; Fee Affiliations
            </a>
          </li>
        </ul>

        <div class="tab-content" style="padding: 20px;">
          <!-- TAB 1: Doctor-Level Tracking -->
          <div class="tab-pane active" id="tab_doctor_tracking">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
              <h4 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
                Doctor Appointment Volume Breakdown
              </h4>
              <div style="display: flex; gap: 8px; align-items: center;">
                <input type="text" id="doctor-search" class="form-control input-sm" placeholder="Filter by Doctor / Speciality..." style="width: 250px; border-radius: 6px;">
                <a href="<?=base_url('doctor/appointment/doctorappointment');?>" class="btn btn-sm btn-default" style="border-radius: 6px;">
                  <i class="fa fa-list"></i> Manage Appointments
                </a>
              </div>
            </div>

            <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 6px;">
              <table class="table table-hover table-striped" id="doctor-table" style="margin: 0;">
                <thead>
                  <tr style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                    <th style="padding: 12px 15px;">#ID</th>
                    <th style="padding: 12px 15px;">Doctor Name</th>
                    <th style="padding: 12px 15px;">Speciality</th>
                    <th style="padding: 12px 15px;">Contact Info</th>
                    <th style="padding: 12px 15px; text-align: center;">Total Appointments</th>
                    <th style="padding: 12px 15px; text-align: center;">Today's Bookings</th>
                    <th style="padding: 12px 15px; text-align: center;">Confirmed / Completed</th>
                    <th style="padding: 12px 15px; text-align: center;">Pending / Other</th>
                    <th style="padding: 12px 15px; text-align: center;">Actions</th>
                  </tr>
                </thead>
                <tbody id="doctor-table-body"></tbody>
              </table>
            </div>
          </div>

          <!-- TAB 2: Hospital-Doctor Cross Tracking Breakdown -->
          <div class="tab-pane" id="tab_hospital_doctor">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
              <h4 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
                Hospital-Doctor Cross Consultation Matrix
              </h4>
              <div style="display: flex; gap: 8px; align-items: center;">
                <input type="text" id="hd-search" class="form-control input-sm" placeholder="Filter by Hospital or Doctor..." style="width: 250px; border-radius: 6px;">
              </div>
            </div>

            <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 6px;">
              <table class="table table-hover table-striped" id="hd-table" style="margin: 0;">
                <thead>
                  <tr style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                    <th style="padding: 12px 15px;">Hospital / Healthcare Facility</th>
                    <th style="padding: 12px 15px;">City</th>
                    <th style="padding: 12px 15px;">Doctor</th>
                    <th style="padding: 12px 15px;">Speciality</th>
                    <th style="padding: 12px 15px; text-align: center;">Appointments Under Doctor in Hospital</th>
                    <th style="padding: 12px 15px; text-align: center;">Confirmed Bookings</th>
                    <th style="padding: 12px 15px; text-align: center;">Last Appointment Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($hospital_doctor_stats)): ?>
                    <?php foreach($hospital_doctor_stats as $hd): ?>
                      <tr>
                        <td style="padding: 12px 15px;">
                          <strong style="color: #00a896;"><?=htmlspecialchars($hd['hospital_name']);?></strong>
                        </td>
                        <td style="padding: 12px 15px; color: #64748b;">
                          <i class="fa fa-map-marker text-muted"></i> <?=htmlspecialchars($hd['hospital_city'] ?: 'N/A');?>
                        </td>
                        <td style="padding: 12px 15px;">
                          <strong style="color: #1e293b;">Dr. <?=htmlspecialchars($hd['dr_fname'].' '.$hd['dr_lname']);?></strong>
                        </td>
                        <td style="padding: 12px 15px; color: #64748b;">
                          <?=htmlspecialchars($hd['dr_speciality'] ?: 'General Practice');?>
                        </td>
                        <td style="padding: 12px 15px; text-align: center;">
                          <span class="badge bg-purple" style="font-size: 13px; padding: 4px 10px;"><?=number_format($hd['total_appointments']);?></span>
                        </td>
                        <td style="padding: 12px 15px; text-align: center;">
                          <span class="badge bg-green" style="font-size: 12px; padding: 3px 8px;"><?=number_format($hd['confirmed_count']);?></span>
                        </td>
                        <td style="padding: 12px 15px; text-align: center; color: #64748b; font-size: 12px;">
                          <?=!empty($hd['last_appointment_date']) ? date('d M Y', strtotime($hd['last_appointment_date'])) : 'N/A';?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">
                        <i class="fa fa-hospital-o" style="font-size: 32px; margin-bottom: 8px; display: block;"></i>
                        No hospital-doctor consultation records found.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- TAB 3: Practice & Fee Affiliations -->
          <div class="tab-pane" id="tab_affiliations">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
              <h4 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
                Doctor Affiliated Practices &amp; Consultation Fees
              </h4>
              <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-sm btn-primary" style="border-radius: 6px; background: #00a896; border-color: #00a896;">
                <i class="fa fa-user-plus"></i> New Doctor Affiliation
              </a>
            </div>

            <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 6px;">
              <table class="table table-hover table-striped" style="margin: 0;">
                <thead>
                  <tr style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                    <th style="padding: 12px 15px;">Practice ID</th>
                    <th style="padding: 12px 15px;">Doctor</th>
                    <th style="padding: 12px 15px;">Facility</th>
                    <th style="padding: 12px 15px;">Type</th>
                    <th style="padding: 12px 15px;">Consultation Fee</th>
                    <th style="padding: 12px 15px; text-align: center;">Total Patient Bookings</th>
                    <th style="padding: 12px 15px; text-align: center;">Status</th>
                    <th style="padding: 12px 15px; text-align: center;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($affiliations_stats)): ?>
                    <?php foreach($affiliations_stats as $aff): ?>
                      <tr>
                        <td style="padding: 12px 15px; font-weight: 600; color: #64748b;">#<?=$aff['practice_id'];?></td>
                        <td style="padding: 12px 15px;">
                          <strong style="color: #1e293b;">Dr. <?=htmlspecialchars($aff['dr_fname'].' '.$aff['dr_lname']);?></strong>
                        </td>
                        <td style="padding: 12px 15px;">
                          <?=htmlspecialchars($aff['hospital_name']);?> (<?=htmlspecialchars($aff['hospital_city']);?>)
                        </td>
                        <td style="padding: 12px 15px;">
                          <span class="label <?=$aff['type']=='H'?'label-primary':'label-success';?>">
                            <?=$aff['type']=='H'?'Hospital':'Clinic';?>
                          </span>
                        </td>
                        <td style="padding: 12px 15px; font-weight: 600; color: #059669;">
                          &#8377; <?=number_format($aff['fee'], 2);?>
                        </td>
                        <td style="padding: 12px 15px; text-align: center;">
                          <span class="badge bg-teal" style="font-size: 12px; padding: 3px 8px;"><?=number_format($aff['appointment_count']);?></span>
                        </td>
                        <td style="padding: 12px 15px; text-align: center;">
                          <?php if($aff['practice_status'] == '1'): ?>
                            <span class="label label-success">Active</span>
                          <?php else: ?>
                            <span class="label label-warning">Pending</span>
                          <?php endif; ?>
                        </td>
                        <td style="padding: 12px 15px; text-align: center;">
                          <a href="<?=base_url('doctor/clinicreg/doctor_fee_time/'.$aff['practice_id']);?>" class="btn btn-xs btn-default" style="border-radius: 4px;" title="Edit Fee &amp; Timing">
                            <i class="fa fa-clock-o text-info"></i> Timing
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="8" style="text-align: center; padding: 30px; color: #94a3b8;">
                        <i class="fa fa-sitemap" style="font-size: 32px; margin-bottom: 8px; display: block;"></i>
                        No practice affiliation records found.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function() {
  // Server-Side DataTables for Doctor-Level Tracking (Handles 1,400+ doctors instantly)
  if ($.fn.DataTable.isDataTable('#doctor-table')) {
    $('#doctor-table').DataTable().destroy();
  }

  var doctorTable = $('#doctor-table').DataTable({
    "processing": true,
    "serverSide": true,
    "responsive": true,
    "pageLength": 25,
    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "ajax": {
      "url": "<?=base_url('doctor/appointment/ajax_doctor_analytics');?>",
      "type": "POST"
    },
    "order": [[4, "desc"]], // Default sort by Total Appointments descending
    "columns": [
      { "width": "70px", "className": "text-center" },
      { "width": "22%" },
      { "width": "16%" },
      { "width": "18%" },
      { "className": "text-center" },
      { "className": "text-center" },
      { "className": "text-center" },
      { "className": "text-center" },
      { "width": "120px", "className": "text-center", "orderable": false }
    ],
    "language": {
      "processing": '<div style="padding: 15px; color: #00a896; font-weight: 700; font-size: 14px;"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading Doctor Analytics...</div>',
      "lengthMenu": "Show _MENU_ doctors per page",
      "info": "Showing _START_ to _END_ of _TOTAL_ doctors",
      "infoEmpty": "No doctors found",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Quick Search:",
      "searchPlaceholder": "Search doctor name, phone, email, speciality...",
      "paginate": {
        "first": '<i class="fa fa-angle-double-left"></i>',
        "last": '<i class="fa fa-angle-double-right"></i>',
        "next": '<i class="fa fa-angle-right"></i>',
        "previous": '<i class="fa fa-angle-left"></i>'
      }
    }
  });

  // Custom search filter input integration
  var docSearch = document.getElementById('doctor-search');
  if (docSearch) {
    $(docSearch).on('keyup change', function() {
      doctorTable.search(this.value).draw();
    });
  }

  // Client-side quick filter for Hospital-Doctor table (128 rows)
  var hdSearch = document.getElementById('hd-search');
  if (hdSearch) {
    hdSearch.addEventListener('keyup', function() {
      var filter = this.value.toLowerCase();
      var rows = document.querySelectorAll('#hd-table tbody tr');
      rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
      });
    });
  }
});
</script>
