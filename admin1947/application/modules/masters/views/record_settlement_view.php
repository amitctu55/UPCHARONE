<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #08364b; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-file-text-o" style="color: #0284c7;"></i> Process &amp; Record Financial Settlement
        </h1>
        <p style="color: #64748b; font-size: 13px; margin: 5px 0 0 0;">
          Calculate platform commission, reconcile gross customer order sales, and record bank UTR payout transfers.
        </p>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="<?= base_url('masters/pharmacy_fleet?tab=settlements'); ?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-arrow-left"></i> Back to Settlements Ledger
        </a>
      </div>
    </div>
    <ol class="breadcrumb" style="position: static; float: none; margin: 12px 0 0 0; background: transparent; padding: 0; font-size: 12px;">
      <li><a href="<?= base_url('masters/dashboard'); ?>" style="color: #64748b;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?= base_url('masters/pharmacy_fleet?tab=settlements'); ?>" style="color: #64748b;">Pharmacy &amp; Fleet</a></li>
      <li class="active" style="color: #08364b; font-weight: 600;">Record Settlement</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 0 30px 30px 30px;">
    <div class="container-fluid" style="padding: 0;">

      <!-- Flash Notifications -->
      <?php if ($this->session->flashdata('error') || $this->session->flashdata('error_msg')): ?>
      <div class="alert alert-danger alert-dismissible" style="border-radius: 8px; margin-bottom: 20px;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 style="font-size: 15px; font-weight: 700; margin: 0 0 5px 0;"><i class="fa fa-exclamation-circle"></i> Error:</h4>
        <div style="font-size: 13px;"><?= $this->session->flashdata('error') ?: $this->session->flashdata('error_msg'); ?></div>
      </div>
      <?php endif; ?>

      <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin: 0 auto 30px; background: #ffffff; overflow: hidden;">
        
        <div style="background: #08364b; color: #ffffff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
          <div>
            <h3 style="margin: 0; font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
              <i class="fa fa-university"></i> Partner Chemist Payout Settlement Voucher
            </h3>
            <span style="font-size: 12px; color: #93c5fd;">Commission deduction and net bank transfer calculation</span>
          </div>
          <span class="badge" style="background: #0284c7; font-size: 12px; padding: 6px 12px;">Financial Ledger Entry</span>
        </div>

        <!-- Form starts here -->
        <form action="<?= base_url('masters/pharmacy_fleet/record_settlement'); ?>" method="POST" id="settlementForm">

          <div class="box-body" style="padding: 28px 30px;">

            <!-- SECTION 1: STORE SELECTION & BILLING PERIOD -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">1</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Partner Pharmacy &amp; Settlement Period</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Select Partner Pharmacy Store <span style="color: #dc2626;">*</span></label>
                  <select name="pharmacy_id" id="settleStoreSelect" class="form-control" required style="height: 42px; border-radius: 6px;" onchange="onPharmacySelected(this)">
                    <option value="">-- Choose Partner Chemist Store --</option>
                    <?php if (!empty($all_stores)): foreach($all_stores as $st): ?>
                    <option value="<?= $st['id']; ?>" data-rate="<?= $st['commission_rate'] ?? '8.0'; ?>" <?= (!empty($selected_store_id) && $selected_store_id == $st['id']) ? 'selected' : ''; ?>>
                      <?= html_escape($st['store_name']); ?> (Default Rate: <?= $st['commission_rate'] ?? '8.0'; ?>%)
                    </option>
                    <?php endforeach; endif; ?>
                  </select>
                  <small class="text-muted">Target store to reconcile dispatched orders and bank payout.</small>
                </div>

                <div class="col-md-3 form-group">
                  <label style="font-weight: 600; color: #334155;">Billing Cycle Start Date <span style="color: #dc2626;">*</span></label>
                  <input type="date" name="period_start" class="form-control" required value="<?= date('Y-m-d', strtotime('-7 days')); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Start date of reconciled sales period.</small>
                </div>

                <div class="col-md-3 form-group">
                  <label style="font-weight: 600; color: #334155;">Billing Cycle End Date <span style="color: #dc2626;">*</span></label>
                  <input type="date" name="period_end" class="form-control" required value="<?= date('Y-m-d'); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">End date of reconciled sales period.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 2: SALES & COMMISSION RECONCILIATION -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">2</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Sales Volume &amp; Platform Commission Computation</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Gross Dispatched Sales (₹) <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px; font-weight: bold;">₹</span>
                    <input type="number" step="0.01" name="gross_sales" id="grossSalesInput" class="form-control" required placeholder="e.g., 25000.00" style="height: 42px; font-size: 15px; font-weight: 700; border-radius: 0 6px 6px 0;" oninput="recalcSettlement()">
                  </div>
                  <small class="text-muted">Total value of successfully delivered orders within the billing cycle.</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">UPCHAR Commission Fee Rate (%) <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-percent"></i></span>
                    <input type="number" step="0.1" name="commission_rate" id="commRateInput" class="form-control" required value="8.0" style="height: 42px; font-size: 15px; font-weight: 700; border-radius: 0 6px 6px 0;" oninput="recalcSettlement()">
                  </div>
                  <small class="text-muted">Contracted platform commission rate percentage.</small>
                </div>
              </div>

              <!-- Live Financial Calculation Preview Card -->
              <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 10px; padding: 20px; margin-top: 10px;">
                <div class="row text-center">
                  <div class="col-md-4 col-xs-12" style="border-right: 1px solid #e2e8f0; margin-bottom: 10px;">
                    <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Gross Sales Volume</div>
                    <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 4px;" id="dispGross">₹0.00</div>
                  </div>
                  <div class="col-md-4 col-xs-12" style="border-right: 1px solid #e2e8f0; margin-bottom: 10px;">
                    <div style="font-size: 12px; font-weight: 700; color: #0284c7; text-transform: uppercase;">Upchar Platform Fee</div>
                    <div style="font-size: 20px; font-weight: 800; color: #0284c7; margin-top: 4px;" id="dispComm">- ₹0.00</div>
                  </div>
                  <div class="col-md-4 col-xs-12">
                    <div style="font-size: 12px; font-weight: 700; color: #16a34a; text-transform: uppercase;">Net Payable Bank Transfer</div>
                    <div style="font-size: 22px; font-weight: 800; color: #16a34a; margin-top: 4px;" id="dispNet">₹0.00</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- SECTION 3: BANK UTR & SETTLEMENT STATUS -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #ede9fe; color: #7c3aed; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">3</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Banking Transaction Reference &amp; Status</h4>
              </div>

              <div class="row">
                <div class="col-md-8 form-group">
                  <label style="font-weight: 600; color: #334155;">Bank Transfer UTR / Transaction Reference Number</label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-university"></i></span>
                    <input type="text" name="utr_number" class="form-control" placeholder="e.g., CMS260907114258 / AXISN240899" style="height: 42px; font-family: monospace; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">NEFT / RTGS / IMPS reference for chemist ledger auditing (leave blank to auto-generate reference).</small>
                </div>

                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Settlement Payout Status</label>
                  <select name="settlement_status" class="form-control" style="height: 42px; border-radius: 6px;">
                    <option value="PROCESSED" selected>🟢 PROCESSED (Paid &amp; Transferred)</option>
                    <option value="PENDING">🟡 PENDING (Queued for Clearing)</option>
                    <option value="FAILED">🔴 FAILED (Bank Issue / Reprocess)</option>
                  </select>
                  <small class="text-muted">Current status in the partner financial ledger.</small>
                </div>
              </div>
            </div>

          </div>

          <!-- Form Footer Buttons -->
          <div class="box-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=settlements'); ?>" class="btn btn-default" style="padding: 10px 20px; font-weight: 600; border-radius: 6px;">
              <i class="fa fa-times"></i> Cancel
            </a>
            <div style="display: flex; gap: 10px;">
              <button type="submit" class="btn btn-success" style="padding: 10px 24px; font-weight: 700; border-radius: 6px; background: #0284c7; border-color: #0284c7; color: #fff; box-shadow: 0 2px 4px rgba(2,132,199,0.3);">
                <i class="fa fa-check-circle"></i> Record &amp; Post Financial Settlement
              </button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>

<script>
function onPharmacySelected(select) {
  var selected = select.options[select.selectedIndex];
  var rate = selected.getAttribute('data-rate');
  if (rate) {
    document.getElementById('commRateInput').value = parseFloat(rate).toFixed(1);
    recalcSettlement();
  }
}

function recalcSettlement() {
  var gross = parseFloat(document.getElementById('grossSalesInput').value) || 0;
  var rate  = parseFloat(document.getElementById('commRateInput').value) || 0;
  var comm  = Math.round(gross * (rate / 100) * 100) / 100;
  var net   = Math.max(0, Math.round((gross - comm) * 100) / 100);

  document.getElementById('dispGross').innerText = '₹' + gross.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('dispComm').innerText = '- ₹' + comm.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('dispNet').innerText = '₹' + net.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}
</script>
