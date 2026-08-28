<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Facility Appointment Transactions</h1>
        <small style="color: #64748b; font-size: 13px;">Itemized appointment billing records, consultation fees, and payment settlement status</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/account')?>" style="color: #64748b;">Accounts</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Facility Transactions</li>
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
      // Compute summary totals from current filtered dataset
      $pgTotal    = 0;
      $pgReceived = 0;
      $pgPending  = 0;
      if (!empty($appointment)) {
        foreach ($appointment as $ap) {
          $apAmt    = (float) ($ap->amount ?: ($ap->fee ?: 0));
          $apStatus = strtoupper($ap->payment_status ?: 'UNPAID');
          $pgTotal += $apAmt;
          if ($apStatus === 'DONE') {
            $pgReceived += $apAmt;
          } else {
            $pgPending += $apAmt;
          }
        }
      }
      $activeFilters = (
        $this->input->get_post('hospital_name') != '' ||
        $this->input->get_post('doctor_name')   != '' ||
        $this->input->get_post('payment_mode')  != '' ||
        $this->input->get_post('payment_status')!= '' ||
        $this->input->get_post('date_from')     != '' ||
        $this->input->get_post('date_to')       != ''
      );
      ?>

      <!-- Dynamic KPI Summary Bar (updates after AJAX edits) -->
      <div class="row" id="summary-bar" style="margin: 0 -8px 18px;">
        <div class="col-md-4 col-sm-4" style="padding: 0 8px; margin-bottom: 8px;">
          <div style="background: #e0f2fe; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
            <i class="fa fa-money fa-lg" style="color: #0284c7;"></i>
            <div>
              <div style="font-size: 11px; font-weight: 600; color: #0369a1; text-transform: uppercase;">Filtered Billed Volume</div>
              <div id="summary-total" style="font-size: 17px; font-weight: 800; color: #0f172a;">&#8377;<?=number_format($pgTotal, 2);?></div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4" style="padding: 0 8px; margin-bottom: 8px;">
          <div style="background: #dcfce7; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
            <i class="fa fa-check-circle fa-lg" style="color: #16a34a;"></i>
            <div>
              <div style="font-size: 11px; font-weight: 600; color: #15803d; text-transform: uppercase;">Received / Settled</div>
              <div id="summary-received" style="font-size: 17px; font-weight: 800; color: #15803d;">&#8377;<?=number_format($pgReceived, 2);?></div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4" style="padding: 0 8px; margin-bottom: 8px;">
          <div style="background: #fef3c7; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
            <i class="fa fa-clock-o fa-lg" style="color: #d97706;"></i>
            <div>
              <div style="font-size: 11px; font-weight: 600; color: #b45309; text-transform: uppercase;">Pending Collections</div>
              <div id="summary-pending" style="font-size: 17px; font-weight: 800; color: #d97706;">&#8377;<?=number_format($pgPending, 2);?></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Card -->
      <div class="master-card" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden;">
        
        <!-- Header -->
        <div class="master-card-header" style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
          <h3 class="master-card-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-list-alt" style="color: #00a896;"></i>
            <span>Itemized Appointment Transactions</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 5px 10px; border-radius: 12px;">
              Total: <?=count($appointment);?> Records
            </span>
            <a href="<?=base_url('doctor/appointment/account')?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
              &larr; Back to Accounts Overview
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">

          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/appointment/account_appointment')?>" method="get" id="filter_form" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
            <div class="row" style="margin: 0 -6px;">

              <!-- Hospital -->
              <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Hospital / Facility</label>
                <select class="form-control input-sm" name="hospital_name" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Hospitals</option>
                  <?php if(!empty($hospital_list)): foreach ($hospital_list as $val): ?>
                    <option value="<?=$val['id'];?>" <?=($this->input->get_post('hospital_name') == $val['id']) ? 'selected' : '';?>>
                      <?=html_escape($val['name']);?>
                    </option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <!-- Payment Status Filter -->
              <div class="col-md-2 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Payment Status</label>
                <select class="form-control input-sm" name="payment_status" id="filter_payment_status" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Statuses</option>
                  <option value="UNPAID" <?=($this->input->get_post('payment_status') == 'UNPAID') ? 'selected' : '';?>>Unpaid / Pending</option>
                  <option value="DONE"   <?=($this->input->get_post('payment_status') == 'DONE')   ? 'selected' : '';?>>Settled / Paid</option>
                  <option value="CANCELLED" <?=($this->input->get_post('payment_status') == 'CANCELLED') ? 'selected' : '';?>>Cancelled</option>
                  <option value="REFUNDED"  <?=($this->input->get_post('payment_status') == 'REFUNDED')  ? 'selected' : '';?>>Refunded</option>
                </select>
              </div>

              <!-- Payment Mode -->
              <div class="col-md-2 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Payment Mode</label>
                <select class="form-control input-sm" name="payment_mode" style="height: 34px; border-radius: 6px; border: 1px solid #cbd5e1;">
                  <option value="">All Modes</option>
                  <option value="ONLINE" <?=($this->input->get_post('payment_mode') == 'ONLINE') ? 'selected' : '';?>>Online</option>
                  <option value="COC"    <?=($this->input->get_post('payment_mode') == 'COC')    ? 'selected' : '';?>>Cash (COC)</option>
                  <option value="UPI"    <?=($this->input->get_post('payment_mode') == 'UPI')    ? 'selected' : '';?>>UPI</option>
                  <option value="CARD"   <?=($this->input->get_post('payment_mode') == 'CARD')   ? 'selected' : '';?>>Card</option>
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

              <!-- Buttons -->
              <div class="col-md-12" style="padding: 0 6px; display: flex; gap: 8px; justify-content: flex-end; margin-top: 6px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 6px; padding: 6px 18px;">
                  <i class="fa fa-filter"></i> Apply Filters
                </button>
                <?php if ($activeFilters): ?>
                  <a href="<?=base_url('doctor/appointment/account_appointment')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
                    <i class="fa fa-times text-danger"></i> Reset Filters
                  </a>
                <?php endif; ?>
              </div>

            </div>
          </form>

          <!-- Active filter badges -->
          <?php if ($this->input->get_post('payment_status') != ''): ?>
            <div style="margin-bottom: 12px;">
              <?php
              $psVal = $this->input->get_post('payment_status');
              $psLabels = array('UNPAID'=>'Pending / Unpaid','DONE'=>'Settled / Paid','CANCELLED'=>'Cancelled','REFUNDED'=>'Refunded');
              $psColors  = array('UNPAID'=>'#fef3c7; color: #b45309','DONE'=>'#dcfce7; color: #15803d','CANCELLED'=>'#fee2e2; color: #991b1b','REFUNDED'=>'#f3e8ff; color: #7e22ce');
              $psLabel = $psLabels[$psVal] ?? $psVal;
              $psColor = $psColors[$psVal]  ?? '#e2e8f0; color: #475569';
              ?>
              <span style="background: <?=$psColor?>; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-tag"></i> Filtered by Status: <?=html_escape($psLabel);?>
                <a href="<?=base_url('doctor/appointment/account_appointment?hospital_name='.$this->input->get('hospital_name').'&payment_mode='.$this->input->get('payment_mode').'&date_from='.$this->input->get('date_from').'&date_to='.$this->input->get('date_to'));?>" style="color: inherit; margin-left: 4px; text-decoration: none;" title="Clear status filter">&times;</a>
              </span>
            </div>
          <?php endif; ?>

          <!-- Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="account-app-table" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc;">
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Patient Details</th>
                  <th>Appointment Date &amp; Slot</th>
                  <th>Facility / Clinic</th>
                  <th>Consulting Doctor</th>
                  <th style="text-align: right; width: 100px;">Fee (&#8377;)</th>
                  <th style="width: 110px; text-align: center;">Payment Mode</th>
                  <th style="width: 110px; text-align: center;">Status</th>
                  <th style="width: 80px; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($appointment)): foreach($appointment as $p): 
                  $aid    = $p->appointment_id ?? ($p->id ?? 0);
                  $pname  = $p->appointment_name ?: 'Patient';
                  $adate  = $p->appointment_date ?: '';
                  $time   = ($p->from_timing && $p->to_timing) ? ($p->from_timing . ' - ' . $p->to_timing) : '';
                  $mobile = $p->appointment_mobile ?: '';
                  $email  = $p->appointment_email ?: '';
                  $hname  = $p->hospital_name ?: 'Direct / Clinic Booking';
                  $drName = trim(($p->dr_fname ?? '') . ' ' . ($p->dr_lname ?? ''));
                  $drDisplay = (stripos($drName, 'Dr.') === 0 || stripos($drName, 'Dr ') === 0) ? $drName : ($drName ? 'Dr. ' . $drName : 'Doctor');
                  $amt    = (float) ($p->amount ?: ($p->fee ?: 0));
                  $mode   = strtoupper($p->payment_mode ?: 'COC');
                  $status = strtoupper($p->payment_status ?: 'UNPAID');
                  $txnId  = html_escape($p->transaction_id ?? '');
                  $canEdit = !in_array($status, array('DONE', 'CANCELLED', 'REFUNDED')) || $status === 'DONE';
                ?>
                  <tr id="row-<?=$aid?>">
                    <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: middle;"><?=$aid;?></td>
                    
                    <!-- Patient Name -->
                    <td style="vertical-align: middle;">
                      <strong style="color: #0f172a; font-size: 13.5px; display: block;"><?=html_escape($pname);?></strong>
                      <?php if($mobile): ?>
                        <span style="font-size: 11.5px; color: #64748b;"><i class="fa fa-phone"></i> <?=html_escape($mobile);?></span>
                      <?php endif; ?>
                    </td>

                    <!-- Date & Time -->
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background: #e0f2fe !important; color: #0369a1 !important; border: 1px solid #bae6fd; font-size: 11.5px;">
                        <i class="fa fa-calendar"></i> <?=(function_exists('formatedate') ? formatedate($adate) : $adate);?> <?=$time ? '('.$time.')' : '';?>
                      </span>
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

                    <!-- Amount -->
                    <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 13.5px; vertical-align: middle;">
                      &#8377;<?=number_format($amt, 2);?>
                    </td>

                    <!-- Mode -->
                    <td style="text-align: center; vertical-align: middle;" class="mode-cell-<?=$aid?>">
                      <?php if($mode == 'ONLINE'): ?>
                        <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">Online</span>
                      <?php elseif($mode == 'UPI'): ?>
                        <span class="badge" style="background: #ede9fe; color: #7c3aed; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">UPI</span>
                      <?php elseif($mode == 'CARD'): ?>
                        <span class="badge" style="background: #e0e7ff; color: #4338ca; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">Card</span>
                      <?php else: ?>
                        <span class="badge" style="background: #fef3c7; color: #d97706; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">Cash (COC)</span>
                      <?php endif; ?>
                    </td>

                    <!-- Status -->
                    <td style="text-align: center; vertical-align: middle;" class="status-cell-<?=$aid?>">
                      <?php if($status == 'DONE'): ?>
                        <span class="badge status-badge" style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                          <i class="fa fa-check-circle"></i> Settled
                        </span>
                      <?php elseif($status == 'CANCELLED'): ?>
                        <span class="badge status-badge" style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                          <i class="fa fa-times-circle"></i> Cancelled
                        </span>
                      <?php elseif($status == 'REFUNDED'): ?>
                        <span class="badge status-badge" style="background: #f3e8ff; color: #7e22ce; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                          <i class="fa fa-undo"></i> Refunded
                        </span>
                      <?php else: ?>
                        <span class="badge status-badge" style="background: #fee2e2; color: #dc2626; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                          <i class="fa fa-clock-o"></i> Unpaid
                        </span>
                      <?php endif; ?>
                    </td>

                    <!-- Action Column -->
                    <td style="text-align: center; vertical-align: middle;">
                      <button type="button"
                        class="btn btn-xs btn-warning edit-payment-btn"
                        style="border-radius: 6px; font-weight: 700; padding: 4px 10px; background: <?=($status=='DONE') ? '#dcfce7' : '#fef3c7'?>; border-color: <?=($status=='DONE') ? '#86efac' : '#fcd34d'?>; color: <?=($status=='DONE') ? '#15803d' : '#92400e'?>;"
                        title="Edit Payment Status"
                        data-id="<?=$aid?>"
                        data-status="<?=$status?>"
                        data-mode="<?=$mode?>"
                        data-txn="<?=$txnId?>"
                        data-name="<?=html_escape($pname)?>"
                        data-amount="<?=number_format($amt, 2)?>"
                      >
                        <i class="fa <?=($status=='DONE') ? 'fa-pencil-square-o' : 'fa-pencil'?>"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment transaction records found for this criteria.</p>
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

<!-- =====================================================
     EDIT PAYMENT STATUS MODAL
     ===================================================== -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog" aria-labelledby="editPaymentModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 520px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.18);">

      <!-- Modal Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 12px 12px 0 0; padding: 18px 22px; border-bottom: none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.7; font-size: 22px; margin-top: -2px;">&times;</button>
        <h4 class="modal-title" id="editPaymentModalLabel" style="color: #ffffff; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-pencil-square-o" style="color: #00a896;"></i>
          Edit Payment Status
          <span id="modal-appt-label" style="font-size: 12px; font-weight: 500; color: #94a3b8; margin-left: 4px;"></span>
        </h4>
      </div>

      <!-- Patient Info Banner -->
      <div id="modal-patient-info" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 12px 22px; display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <i class="fa fa-user" style="color: #0284c7;"></i>
        </div>
        <div>
          <div id="modal-patient-name" style="font-weight: 700; color: #0f172a; font-size: 13.5px;"></div>
          <div id="modal-patient-amount" style="font-size: 12px; color: #64748b; font-weight: 600;"></div>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" style="padding: 22px;">
        <input type="hidden" id="modal-appointment-id">

        <!-- Alert area -->
        <div id="modal-alert" style="display: none; margin-bottom: 14px;"></div>

        <!-- Payment Status -->
        <div class="form-group" style="margin-bottom: 16px;">
          <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block;">
            <i class="fa fa-toggle-on" style="color: #00a896;"></i> Payment Status <span style="color: #ef4444;">*</span>
          </label>
          <select class="form-control" id="modal-payment-status" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 40px; font-weight: 600;">
            <option value="UNPAID">&#9679; Unpaid / Pending</option>
            <option value="DONE">&#10003; Settled / Paid</option>
            <option value="CANCELLED">&#10007; Cancelled</option>
            <option value="REFUNDED">&#8617; Refunded</option>
          </select>
        </div>

        <!-- Payment Mode -->
        <div class="form-group" style="margin-bottom: 16px;">
          <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block;">
            <i class="fa fa-credit-card" style="color: #00a896;"></i> Payment Mode <span style="color: #ef4444;">*</span>
          </label>
          <select class="form-control" id="modal-payment-mode" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 40px; font-weight: 600;">
            <option value="COC">Cash on Counter (COC)</option>
            <option value="ONLINE">Online Payment</option>
            <option value="UPI">UPI</option>
            <option value="CARD">Card</option>
          </select>
        </div>

        <!-- Transaction / Reference ID -->
        <div class="form-group" id="txn-id-group" style="margin-bottom: 16px;">
          <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block;">
            <i class="fa fa-hashtag" style="color: #00a896;"></i> Transaction / Reference ID
            <span id="txn-required-star" style="color: #ef4444; display: none;">*</span>
            <small style="color: #94a3b8; font-weight: 400; text-transform: none;">(optional for Cash)</small>
          </label>
          <input type="text" class="form-control" id="modal-transaction-id" placeholder="e.g. TXN1234567890, UTR, Ref#" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 40px;">
        </div>

        <!-- Admin Notes -->
        <div class="form-group" style="margin-bottom: 4px;">
          <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block;">
            <i class="fa fa-sticky-note-o" style="color: #00a896;"></i> Admin Notes / Reason
            <small style="color: #94a3b8; font-weight: 400; text-transform: none;">(for audit trail)</small>
          </label>
          <textarea class="form-control" id="modal-admin-notes" rows="3" placeholder="Add any notes, reason for change, or remarks..." style="border-radius: 8px; border: 1px solid #cbd5e1; resize: vertical;"></textarea>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 14px 22px; border-radius: 0 0 12px 12px; background: #f8fafc;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
        <button type="button" class="btn btn-primary" id="save-payment-btn" style="background: #00a896; border-color: #00a896; border-radius: 8px; font-weight: 700; padding: 8px 24px; min-width: 120px;">
          <i class="fa fa-save"></i> <span id="save-btn-text">Save Changes</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Toast Notification -->
<div id="payment-toast" style="display: none; position: fixed; bottom: 24px; right: 24px; z-index: 9999; min-width: 280px; max-width: 380px; background: #0f172a; color: #ffffff; border-radius: 10px; padding: 14px 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.25); font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 12px; transition: opacity 0.3s ease;">
  <i id="toast-icon" class="fa fa-check-circle" style="font-size: 20px; color: #4ade80; flex-shrink: 0;"></i>
  <span id="toast-msg">Payment status updated successfully.</span>
</div>

<style>
/* Modal animation polish */
.modal-content { animation: modalSlideIn 0.2s ease; }
@keyframes modalSlideIn {
  from { opacity: 0; transform: translateY(-16px); }
  to   { opacity: 1; transform: translateY(0); }
}
/* Edit button hover */
.edit-payment-btn:hover { opacity: 0.85; transform: scale(1.08); transition: all 0.15s; }
/* Status badge update flash */
.badge-flash {
  animation: badgeFlash 0.6s ease;
}
@keyframes badgeFlash {
  0%   { transform: scale(1); }
  40%  { transform: scale(1.18); }
  100% { transform: scale(1); }
}
</style>

<script>
$(document).ready(function() {

    // -------------------------------------------
    // DataTable initialisation (preserve on modal)
    // -------------------------------------------
    var accountTable;
    if ($.fn.DataTable.isDataTable('#account-app-table')) {
        $('#account-app-table').DataTable().destroy();
    }
    accountTable = $('#account-app-table').DataTable({
        "order": [[ 0, "desc" ]],
        "pageLength": 25,
        "language": {
            "search": "Search transactions:",
            "paginate": { "previous": "&larr; Prev", "next": "Next &rarr;" }
        }
    });

    // -------------------------------------------
    // Open Edit Payment Modal
    // -------------------------------------------
    $(document).on('click', '.edit-payment-btn', function() {
        var btn    = $(this);
        var aid    = btn.data('id');
        var status = btn.data('status');
        var mode   = btn.data('mode');
        var txn    = btn.data('txn');
        var name   = btn.data('name');
        var amount = btn.data('amount');

        // Populate modal fields
        $('#modal-appointment-id').val(aid);
        $('#modal-appt-label').text('Appt #' + aid);
        $('#modal-patient-name').text(name);
        $('#modal-patient-amount').html('&#8377;' + amount + ' &nbsp;|&nbsp; Appt ID: ' + aid);
        $('#modal-payment-status').val(status);
        $('#modal-payment-mode').val(mode);
        $('#modal-transaction-id').val(txn);
        $('#modal-admin-notes').val('');
        $('#modal-alert').hide().html('');

        // Toggle TXN required indicator
        toggleTxnRequired();

        $('#editPaymentModal').modal('show');
    });

    // -------------------------------------------
    // Toggle TXN required star based on mode
    // -------------------------------------------
    function toggleTxnRequired() {
        var mode = $('#modal-payment-mode').val();
        var onlineModes = ['ONLINE','UPI','CARD'];
        if (onlineModes.indexOf(mode) !== -1) {
            $('#txn-required-star').show();
            $('#modal-transaction-id').attr('placeholder', 'Required: UTR / Ref / Transaction ID');
        } else {
            $('#txn-required-star').hide();
            $('#modal-transaction-id').attr('placeholder', 'e.g. TXN1234567890, UTR, Ref# (optional)');
        }
    }
    $('#modal-payment-mode').on('change', toggleTxnRequired);

    // -------------------------------------------
    // Save Payment Status via AJAX
    // -------------------------------------------
    $('#save-payment-btn').on('click', function() {
        var aid    = $('#modal-appointment-id').val();
        var status = $('#modal-payment-status').val();
        var mode   = $('#modal-payment-mode').val();
        var txn    = $.trim($('#modal-transaction-id').val());
        var notes  = $.trim($('#modal-admin-notes').val());

        // Client-side validation
        var onlineModes = ['ONLINE','UPI','CARD'];
        if (onlineModes.indexOf(mode) !== -1 && txn === '') {
            showModalAlert('danger', '<i class="fa fa-exclamation-circle"></i> Transaction / Reference ID is required for online payment settlements.');
            return;
        }

        // Loading state
        var $btn = $(this);
        $btn.prop('disabled', true);
        $('#save-btn-text').text('Saving...');
        $('#modal-alert').hide();

        $.ajax({
            url:  '<?=base_url("doctor/appointment/update_payment_status")?>',
            type: 'POST',
            data: {
                appointment_id: aid,
                payment_status: status,
                payment_mode:   mode,
                transaction_id: txn,
                admin_notes:    notes,
                is_ajax:        1
            },
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false);
                $('#save-btn-text').text('Save Changes');

                if (res.status === 1) {
                    // Update the status badge in the table row
                    updateRowStatus(aid, status, mode);

                    // Update summary bar KPIs if summary data is returned
                    if (res.summary) {
                        updateSummaryBar(res.summary);
                    }

                    // Close modal & show toast
                    $('#editPaymentModal').modal('hide');
                    showToast('success', res.message || 'Payment status updated successfully.');

                } else {
                    showModalAlert('danger', '<i class="fa fa-exclamation-circle"></i> ' + (res.message || 'Update failed. Please try again.'));
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                $('#save-btn-text').text('Save Changes');
                showModalAlert('danger', '<i class="fa fa-exclamation-triangle"></i> Network error. Please check your connection and retry.');
            }
        });
    });

    // -------------------------------------------
    // Update row badge in-place (no page reload)
    // -------------------------------------------
    function updateRowStatus(aid, status, mode) {
        var statusHtml = '';
        var modeHtml   = '';

        // Build status badge
        if (status === 'DONE') {
            statusHtml = '<span class="badge status-badge badge-flash" style="background:#dcfce7;color:#15803d;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;"><i class="fa fa-check-circle"></i> Settled</span>';
        } else if (status === 'CANCELLED') {
            statusHtml = '<span class="badge status-badge badge-flash" style="background:#fee2e2;color:#991b1b;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;"><i class="fa fa-times-circle"></i> Cancelled</span>';
        } else if (status === 'REFUNDED') {
            statusHtml = '<span class="badge status-badge badge-flash" style="background:#f3e8ff;color:#7e22ce;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;"><i class="fa fa-undo"></i> Refunded</span>';
        } else {
            statusHtml = '<span class="badge status-badge badge-flash" style="background:#fee2e2;color:#dc2626;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;"><i class="fa fa-clock-o"></i> Unpaid</span>';
        }

        // Build mode badge
        if (mode === 'ONLINE') {
            modeHtml = '<span class="badge" style="background:#e0f2fe;color:#0284c7;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;">Online</span>';
        } else if (mode === 'UPI') {
            modeHtml = '<span class="badge" style="background:#ede9fe;color:#7c3aed;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;">UPI</span>';
        } else if (mode === 'CARD') {
            modeHtml = '<span class="badge" style="background:#e0e7ff;color:#4338ca;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;">Card</span>';
        } else {
            modeHtml = '<span class="badge" style="background:#fef3c7;color:#d97706;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;">Cash (COC)</span>';
        }

        // Inject into DOM
        $('.status-cell-' + aid).html(statusHtml);
        $('.mode-cell-' + aid).html(modeHtml);

        // Update the edit button appearance
        var newBg    = (status === 'DONE') ? '#dcfce7' : '#fef3c7';
        var newBc    = (status === 'DONE') ? '#86efac' : '#fcd34d';
        var newColor = (status === 'DONE') ? '#15803d' : '#92400e';
        var newIcon  = (status === 'DONE') ? 'fa-pencil-square-o' : 'fa-pencil';
        $('[data-id="' + aid + '"]')
            .css({'background': newBg, 'border-color': newBc, 'color': newColor})
            .attr('data-status', status)
            .attr('data-mode', mode)
            .find('i').attr('class', 'fa ' + newIcon);
    }

    // -------------------------------------------
    // Update the summary KPI bar numbers
    // -------------------------------------------
    function updateSummaryBar(summary) {
        // summary has: total_volume, total_received, total_pending
        // We do a simple animated swap using the global totals returned from server
        function fmt(n) {
            return '&#8377;' + parseFloat(n).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
        }
        // Recalculate filtered totals from visible DOM rows instead of global summary
        var filteredTotal    = 0;
        var filteredReceived = 0;
        var filteredPending  = 0;
        $('#account-app-table tbody tr').each(function() {
            var statusCell  = $(this).find('[class*="status-cell-"]');
            var badgeText   = statusCell.find('.status-badge').text().trim().toLowerCase();
            var amountCell  = $(this).find('td:eq(5)').text().replace(/[₹,\s]/g, '');
            var amt         = parseFloat(amountCell) || 0;
            filteredTotal  += amt;
            if (badgeText.indexOf('settled') !== -1) {
                filteredReceived += amt;
            } else if (badgeText.indexOf('unpaid') !== -1 || badgeText.indexOf('pending') !== -1) {
                filteredPending  += amt;
            }
        });

        // Animate the numbers
        animateCounter('#summary-total',    filteredTotal);
        animateCounter('#summary-received', filteredReceived);
        animateCounter('#summary-pending',  filteredPending);
    }

    function animateCounter(selector, targetValue) {
        var $el     = $(selector);
        var current = parseFloat($el.text().replace(/[₹,]/g, '')) || 0;
        var diff    = targetValue - current;
        var steps   = 20;
        var step    = 0;
        var interval = setInterval(function() {
            step++;
            var val = current + (diff * (step / steps));
            $el.html('&#8377;' + val.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2}));
            if (step >= steps) {
                clearInterval(interval);
                $el.html('&#8377;' + targetValue.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2}));
            }
        }, 20);
    }

    // -------------------------------------------
    // Modal alert helper
    // -------------------------------------------
    function showModalAlert(type, html) {
        var color = (type === 'danger') ? '#fee2e2' : '#dcfce7';
        var border = (type === 'danger') ? '#fca5a5' : '#86efac';
        var text   = (type === 'danger') ? '#991b1b' : '#15803d';
        $('#modal-alert')
            .html('<div style="background:'+color+';border:1px solid '+border+';color:'+text+';border-radius:8px;padding:10px 14px;font-size:13px;font-weight:600;">'+html+'</div>')
            .show();
    }

    // -------------------------------------------
    // Toast notification
    // -------------------------------------------
    function showToast(type, msg) {
        var iconClass = (type === 'success') ? 'fa-check-circle' : 'fa-exclamation-triangle';
        var iconColor = (type === 'success') ? '#4ade80' : '#fbbf24';
        $('#toast-icon').attr('class', 'fa ' + iconClass).css('color', iconColor);
        $('#toast-msg').text(msg);
        var $toast = $('#payment-toast');
        $toast.css({'display':'flex', opacity: 0}).animate({opacity: 1}, 300);
        setTimeout(function() {
            $toast.animate({opacity: 0}, 400, function() { $(this).hide(); });
        }, 3500);
    }

    // Reset modal state on close
    $('#editPaymentModal').on('hidden.bs.modal', function() {
        $('#modal-alert').hide().html('');
        $('#save-btn-text').text('Save Changes');
        $('#save-payment-btn').prop('disabled', false);
    });
});
</script>
