<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Financial Accounts &amp; Settlements</h1>
        <small style="color: #64748b; font-size: 13px;">Facility billing volume, consultation revenue tracking, and monthly collection overview</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Accounts</li>
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

      <?php
      // Calculate top KPI statistics
      $totalVolume = 0;
      $totalReceived = 0;
      $totalBookings = 0;
      $facilityCount = !empty($hospital_account) ? count($hospital_account) : 0;

      if(!empty($hospital_account)) {
        foreach($hospital_account as $ha) {
          $totalVolume += (float) ($ha->total ?? 0);
          $totalReceived += (float) ($ha->received_amount ?? 0);
          $totalBookings += (int) ($ha->count ?? 0);
        }
      }
      $totalPending = max(0, $totalVolume - $totalReceived);
      ?>

      <!-- KPI Summary Cards Row — Each card is a clickable link -->
      <div class="row" style="margin: 0 -8px 20px;">
        
        <!-- Total Billed Volume — routes to all transactions (no filter) -->
        <div class="col-md-3 col-sm-6" style="padding: 0 8px; margin-bottom: 12px;">
          <a href="<?=base_url('doctor/appointment/account_appointment')?>" style="text-decoration: none; display: block;" title="View all <?=$totalBookings?> bookings">
            <div class="kpi-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: box-shadow 0.18s ease, border-color 0.18s ease, transform 0.18s ease; cursor: pointer;">
              <div style="width: 50px; height: 50px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fa fa-money"></i>
              </div>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Total Billed Volume</div>
                <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 2px;">&#8377;<?=number_format($totalVolume, 2);?></div>
                <div style="font-size: 11px; color: #0284c7; font-weight: 600; margin-top: 2px;"><?=$totalBookings;?> total bookings &rarr;</div>
              </div>
            </div>
          </a>
        </div>

        <!-- Received / Settled — filters to DONE payment_status -->
        <div class="col-md-3 col-sm-6" style="padding: 0 8px; margin-bottom: 12px;">
          <a href="<?=base_url('doctor/appointment/account_appointment?payment_status=DONE')?>" style="text-decoration: none; display: block;" title="View confirmed / settled payments">
            <div class="kpi-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: box-shadow 0.18s ease, border-color 0.18s ease, transform 0.18s ease; cursor: pointer;">
              <div style="width: 50px; height: 50px; border-radius: 10px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fa fa-check-circle-o"></i>
              </div>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Received / Done</div>
                <div style="font-size: 20px; font-weight: 800; color: #16a34a; margin-top: 2px;">&#8377;<?=number_format($totalReceived, 2);?></div>
                <div style="font-size: 11px; color: #16a34a; font-weight: 600; margin-top: 2px;">Confirmed payments &rarr;</div>
              </div>
            </div>
          </a>
        </div>

        <!-- Pending Collections — filters to UNPAID payment_status -->
        <div class="col-md-3 col-sm-6" style="padding: 0 8px; margin-bottom: 12px;">
          <a href="<?=base_url('doctor/appointment/account_appointment?payment_status=UNPAID')?>" style="text-decoration: none; display: block;" title="View pending / unpaid collections">
            <div class="kpi-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: box-shadow 0.18s ease, border-color 0.18s ease, transform 0.18s ease; cursor: pointer;">
              <div style="width: 50px; height: 50px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fa fa-clock-o"></i>
              </div>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Pending Collections</div>
                <div style="font-size: 20px; font-weight: 800; color: #d97706; margin-top: 2px;">&#8377;<?=number_format($totalPending, 2);?></div>
                <div style="font-size: 11px; color: #d97706; font-weight: 600; margin-top: 2px;">Awaiting clearance / COC &rarr;</div>
              </div>
            </div>
          </a>
        </div>

        <!-- Contributing Facilities — routes to facility / hospital view -->
        <div class="col-md-3 col-sm-6" style="padding: 0 8px; margin-bottom: 12px;">
          <a href="<?=base_url('doctor/appointment/hospitalappointment')?>" style="text-decoration: none; display: block;" title="View contributing hospitals & clinics">
            <div class="kpi-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: box-shadow 0.18s ease, border-color 0.18s ease, transform 0.18s ease; cursor: pointer;">
              <div style="width: 50px; height: 50px; border-radius: 10px; background: #f3e8ff; color: #9333ea; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fa fa-hospital-o"></i>
              </div>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Contributing Facilities</div>
                <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 2px;"><?=$facilityCount;?> Facilities</div>
                <div style="font-size: 11px; color: #9333ea; font-weight: 600; margin-top: 2px;">Hospitals &amp; clinics &rarr;</div>
              </div>
            </div>
          </a>
        </div>

      </div>

      <!-- Main Accounts Container Card -->
      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 25px;">
        
        <!-- Header -->
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
          <h3 class="master-card-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-building-o" style="color: #00a896;"></i>
            <span>Facility Collection Summaries</span>
          </h3>
          <div>
            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 5px 10px; border-radius: 12px;">
              <?=$facilityCount;?> Facilities Listed
            </span>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          
          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/appointment/account')?>" method="get" id="search_form" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
            <div class="row" style="margin: 0 -6px;">
              
              <!-- Hospital Selection -->
              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Select Hospital / Facility</label>
                <select class="form-control input-sm" id="hospital_name" name="hospital_name" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Hospitals</option>
                  <?php if(!empty($hospital_list)): foreach ($hospital_list as $val): ?>
                    <option value="<?=$val['id'];?>" <?=($this->input->get_post('hospital_name') == $val['id']) ? 'selected' : '';?>>
                      <?=html_escape($val['name']);?>
                    </option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <!-- Doctor Selection -->
              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Select Consulting Doctor</label>
                <select class="form-control input-sm" id="doctor_name" name="doctor_name" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Doctors</option>
                  <?php 
                  $selectedHosp = $this->input->get_post('hospital_name');
                  $docList = $selectedHosp 
                    ? $this->appointmentmodel->doctor_list(array('type'=>'H','institution_id'=>$selectedHosp))
                    : $this->appointmentmodel->doctor_list(array('type'=>'H'));
                  if(!empty($docList)): foreach ($docList as $val): ?>
                    <option value="<?=$val['id'];?>" <?=($this->input->get_post('doctor_name') == $val['id']) ? 'selected' : '';?>>
                      <?=html_escape($val['fname']);?>
                    </option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <!-- Payment Mode -->
              <div class="col-md-2 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Payment Mode</label>
                <select class="form-control input-sm" name="payment_mode" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Modes</option>
                  <option value="ONLINE" <?=($this->input->get_post('payment_mode') == 'ONLINE') ? 'selected' : '';?>>Online Payment</option>
                  <option value="COC" <?=($this->input->get_post('payment_mode') == 'COC') ? 'selected' : '';?>>Cash on Counter (COC)</option>
                </select>
              </div>

              <!-- Date From -->
              <div class="col-md-2 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Date From</label>
                <input type="date" class="form-control input-sm" name="date_from" value="<?=html_escape($this->input->get_post('date_from'));?>" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
              </div>

              <!-- Date To -->
              <div class="col-md-2 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Date To</label>
                <input type="date" class="form-control input-sm" name="date_to" value="<?=html_escape($this->input->get_post('date_to'));?>" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
              </div>

              <!-- Filter Buttons -->
              <div class="col-md-12" style="padding: 0 6px; display: flex; gap: 8px; justify-content: flex-end; margin-top: 6px;">
                <button type="submit" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 6px; padding: 6px 18px;">
                  <i class="fa fa-filter"></i> Apply Filters
                </button>

                <?php if($this->input->get_post('hospital_name')!='' || $this->input->get_post('doctor_name')!='' || $this->input->get_post('payment_mode')!='' || $this->input->get_post('date_from')!='' || $this->input->get_post('date_to')!=''): ?>
                  <a href="<?=base_url('doctor/appointment/account')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
                    <i class="fa fa-times text-danger"></i> Reset Filters
                  </a>
                <?php endif; ?>
              </div>

            </div>
          </form>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="accounts-table" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc;">
                  <th style="width: 50px; text-align: center;">#</th>
                  <th>Facility / Hospital Name</th>
                  <th>City Location</th>
                  <th style="width: 130px; text-align: center;">Total Bookings</th>
                  <th style="text-align: right; width: 140px;">Billed Volume</th>
                  <th style="text-align: right; width: 140px;">Received Amount</th>
                  <th style="width: 150px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($hospital_account)): $sn = 1; foreach($hospital_account as $h): 
                  $instId = $h->institute_id ?? 0;
                  $hName = $h->hospital_name ?: 'Direct / Clinic Booking';
                  $cityName = $h->city_name ?: 'General';
                  $hBookings = (int) ($h->count ?? 0);
                  $hTotal = (float) ($h->total ?? 0);
                  $hReceived = (float) ($h->received_amount ?? 0);
                ?>
                  <tr>
                    <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: middle;"><?=$sn++;?></td>
                    
                    <!-- Facility Name -->
                    <td style="vertical-align: middle;">
                      <strong style="color: #0f172a; font-size: 13.5px; display: block;">
                        <i class="fa fa-hospital-o text-muted"></i> <?=html_escape($hName);?>
                      </strong>
                      <span style="font-size: 11.5px; color: #64748b;">Facility ID: #<?=$instId;?></span>
                    </td>

                    <!-- City Location -->
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-map-marker" style="color: #ef4444;"></i> <?=html_escape($cityName);?>
                      </span>
                    </td>

                    <!-- Total Bookings -->
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 12px;">
                        <i class="fa fa-calendar-check-o"></i> <?=$hBookings;?> Bookings
                      </span>
                    </td>

                    <!-- Total Billed Amount -->
                    <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 14px; vertical-align: middle;">
                      &#8377;<?=number_format($hTotal, 2);?>
                    </td>

                    <!-- Received Amount -->
                    <td style="text-align: right; font-weight: 700; color: #16a34a; font-size: 14px; vertical-align: middle;">
                      &#8377;<?=number_format($hReceived, 2);?>
                    </td>

                    <!-- Action Link -->
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/appointment/account_appointment?hospital_name='.$instId.'&doctor_name='.$this->input->get('doctor_name').'&payment_mode='.$this->input->get('payment_mode').'&date_from='.$this->input->get('date_from').'&date_to='.$this->input->get('date_to'));?>" class="btn btn-xs btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 6px; padding: 5px 12px; text-decoration: none;" title="View Detailed Appointments">
                        <i class="fa fa-list-alt"></i> View Details
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-file-text-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No financial collection records found matching criteria.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <!-- Monthly Income Analytics Table Card -->
      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden;">
        
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
          <h3 class="master-card-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-calendar" style="color: #00a896;"></i>
            <span>Monthly Revenue Breakdown (<?=date('Y');?>)</span>
          </h3>
          <div>
            <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 11.5px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
              Annual Summary
            </span>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc;">
                  <th>Calendar Month</th>
                  <th style="text-align: right;">Online Payment (&#8377;)</th>
                  <th style="text-align: right;">Cash on Counter / COC (&#8377;)</th>
                  <th style="text-align: right;">Total Collection (&#8377;)</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $curYear = date('Y');
                $curMonth = (int) date('m');
                $grandOnline = 0;
                $grandCash = 0;
                $grandTotal = 0;

                for($m = $curMonth; $m >= 1; $m--):
                  $dateObj = DateTime::createFromFormat('!m', $m);
                  $monthName = $dateObj ? $dateObj->format('F') : "Month $m";
                  
                  $onlineArr = $this->appointmentmodel->get_monthly_totals($curYear, $m, 'ONLINE');
                  $onlineAmt = (float) (!empty($onlineArr[0]['TotalAmount']) ? $onlineArr[0]['TotalAmount'] : 0);
                  
                  $cashArr = $this->appointmentmodel->get_monthly_totals($curYear, $m, 'COC');
                  $cashAmt = (float) (!empty($cashArr[0]['TotalAmount']) ? $cashArr[0]['TotalAmount'] : 0);
                  
                  $totArr = $this->appointmentmodel->get_monthly_totals($curYear, $m);
                  $totAmt = (float) (!empty($totArr[0]['TotalAmount']) ? $totArr[0]['TotalAmount'] : 0);

                  $grandOnline += $onlineAmt;
                  $grandCash += $cashAmt;
                  $grandTotal += $totAmt;
                ?>
                  <tr>
                    <td style="font-weight: 600; color: #0f172a; vertical-align: middle;">
                      <i class="fa fa-calendar-o text-muted"></i> <?=$monthName;?> <?=$curYear;?>
                    </td>
                    <td style="text-align: right; color: #0284c7; font-weight: 600; vertical-align: middle;">
                      &#8377;<?=number_format($onlineAmt, 2);?>
                    </td>
                    <td style="text-align: right; color: #d97706; font-weight: 600; vertical-align: middle;">
                      &#8377;<?=number_format($cashAmt, 2);?>
                    </td>
                    <td style="text-align: right; color: #16a34a; font-weight: 700; font-size: 13.5px; vertical-align: middle;">
                      &#8377;<?=number_format($totAmt, 2);?>
                    </td>
                  </tr>
                <?php endfor; ?>
              </tbody>
              <tfoot>
                <tr style="background: #f1f5f9; font-weight: 800; font-size: 14px;">
                  <td style="color: #0f172a;">Year-to-Date (YTD) Total</td>
                  <td style="text-align: right; color: #0284c7;">&#8377;<?=number_format($grandOnline, 2);?></td>
                  <td style="text-align: right; color: #d97706;">&#8377;<?=number_format($grandCash, 2);?></td>
                  <td style="text-align: right; color: #16a34a;">&#8377;<?=number_format($grandTotal, 2);?></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>

<style>
.kpi-card:hover {
  box-shadow: 0 6px 20px rgba(0,168,150,0.15) !important;
  border-color: #00a896 !important;
  transform: translateY(-2px);
}
</style>

<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#accounts-table')) {
        $('#accounts-table').DataTable().destroy();
    }
    $('#accounts-table').DataTable({
        "order": [[ 4, "desc" ]],
        "pageLength": 15,
        "language": {
            "search": "Filter in table:",
            "paginate": {
                "previous": "&larr; Prev",
                "next": "Next &rarr;"
            }
        }
    });

    $('#hospital_name').on('change', function() {
        var hospId = $(this).val();
        if (hospId) {
            $.ajax({
                url: '<?=base_url("doctor/appointment/get_doctor_by_hospital_id");?>',
                type: 'POST',
                data: { hospital_id: hospId },
                success: function(html) {
                    $('#doctor_name').html(html);
                }
            });
        }
    });
});
</script>
