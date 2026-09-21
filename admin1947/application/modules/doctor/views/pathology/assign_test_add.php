<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
          Lab-Test Assignment &amp; Pricing Engine
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 13px;">Map master diagnostic tests to partner laboratories with automated platform margin and consumer price computation</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathology/dashboard')?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #cbd5e1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-dashboard text-muted"></i> Dashboard
        </a>
        <a href="<?=base_url('doctor/pathology/index')?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #cbd5e1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> View All Assignments
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 16px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <div style="max-width: 860px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; align-items: center; justify-content: space-between;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-link" style="color: #00a896; margin-right: 8px;"></i> Lab-Test Mapping &amp; Margin Configuration
        </h3>
        <span class="badge" style="background: #10b981; font-size: 11px; padding: 4px 8px;">Margin Calculator Active</span>
      </div>

      <form id="assign-test-form" action="<?=base_url('doctor/pathology/assign_test')?>" method="post" style="padding: 24px;">
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <div class="row">
            <div class="col-md-6 form-group">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Select Partner Pathology Lab <span style="color: #ef4444;">*</span>
              </label>
              <select name="path_lab_id" id="path_lab_id" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13.5px; font-weight: 600;" onchange="onLabSelected()">
                <option value="">-- Choose Accredited Lab --</option>
                <?php if(!empty($pathlab)): foreach($pathlab as $val): 
                  $lid = is_object($val) ? $val->id : $val['id'];
                  $lname = is_object($val) ? $val->name : $val['name'];
                  $lcomm = is_object($val) ? ($val->commission_rate ?? 15.00) : ($val['commission_rate'] ?? 15.00);
                  $lcity = is_object($val) ? ($val->city ?? '') : ($val['city'] ?? '');
                ?>
                  <option value="<?=$lid;?>" data-commission="<?=$lcomm;?>" <?=set_value('path_lab_id')==$lid ? 'selected' : ''?>>
                    <?=$lname;?> (Commission: <?=$lcomm;?>%)
                  </option>
                <?php endforeach; endif; ?>
              </select>
              <span style="color: #ef4444; font-size: 12px;"><?=form_error('path_lab_id');?></span>
            </div>

            <div class="col-md-6 form-group">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Select Master Diagnostic Test <span style="color: #ef4444;">*</span>
              </label>
              <select name="test_id" id="test_id" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13.5px; font-weight: 600;" onchange="onTestSelected()">
                <option value="">-- Choose Master Diagnostic Test --</option>
                <?php if(!empty($test)): foreach($test as $val): 
                  $tid = is_object($val) ? $val->test_id : $val['test_id'];
                  $tname = is_object($val) ? $val->test_name : $val['test_name'];
                  $tprice = is_object($val) ? ($val->amount ?? 0) : ($val['amount'] ?? 0);
                  $tcode = is_object($val) ? ($val->code ?? '') : ($val['code'] ?? '');
                  $tdept = is_object($val) ? ($val->department ?? '') : ($val['department'] ?? '');
                ?>
                  <option value="<?=$tid;?>" data-base-price="<?=$tprice;?>" data-code="<?=$tcode;?>" data-dept="<?=$tdept;?>" <?=set_value('test_id')==$tid ? 'selected' : ''?>>
                    <?=$tname;?> [<?=($tcode ?: 'ID:'.$tid);?>] - Base ₹<?=$tprice;?>
                  </option>
                <?php endforeach; endif; ?>
              </select>
              <span style="color: #ef4444; font-size: 12px;"><?=form_error('test_id');?></span>
            </div>
          </div>

          <!-- Live Margin & Consumer Price Calculation Card -->
          <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(16,185,129,0.05);">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dcfce7; padding-bottom: 10px; margin-bottom: 14px;">
              <span style="font-weight: 700; color: #166534; font-size: 13.5px;">
                <i class="fa fa-calculator" style="margin-right: 6px;"></i> Automated Price &amp; Platform Margin Breakdown
              </span>
              <span class="badge" style="background: #16a34a; font-size: 11px;">Live Calculation</span>
            </div>

            <div class="row" style="align-items: center;">
              <div class="col-md-4">
                <label style="font-size: 12.5px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                  Lab Payout Base Price (₹) <span style="color: #ef4444;">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-addon" style="font-weight: 700;">₹</span>
                  <input type="number" step="1" name="lab_price" id="lab_price" class="form-control" placeholder="0" value="<?=set_value('lab_price', '300');?>" min="0" required style="height: 40px; font-weight: 700; font-size: 16px; color: #0f172a;" oninput="recalculatePricing()">
                </div>
                <small style="color: #64748b; font-size: 11px;">Base amount remitted to partner lab</small>
              </div>

              <div class="col-md-4">
                <label style="font-size: 12.5px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                  Admin Commission Rate (%)
                </label>
                <div class="input-group">
                  <input type="number" step="0.5" id="calc_commission_rate" class="form-control" value="15.0" min="0" max="100" style="height: 40px; font-weight: 700; font-size: 15px; color: #0f172a;" oninput="recalculatePricing()">
                  <span class="input-group-addon" style="font-weight: 700;">%</span>
                </div>
                <small style="color: #64748b; font-size: 11px;">Upchar platform fee on this lab</small>
              </div>

              <div class="col-md-4">
                <div style="background: #ffffff; border: 1px dashed #10b981; border-radius: 8px; padding: 10px 14px; text-align: center;">
                  <div style="font-size: 11px; font-weight: 700; color: #15803d; text-transform: uppercase;">Consumer Listing Price</div>
                  <div id="calc_patient_price_display" style="font-size: 22px; font-weight: 800; color: #047857; margin: 2px 0;">
                    ₹ 345.00
                  </div>
                  <div style="font-size: 11px; color: #64748b;">Platform Margin: <strong id="calc_margin_rupees" style="color: #15803d;">₹ 45.00</strong></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Operational Flags & Notes -->
          <div class="row">
            <div class="col-md-6 form-group">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Special Sample Handling Notes (Optional)
              </label>
              <input type="text" name="comment" id="comment" class="form-control" placeholder="e.g. 10-12 hrs fasting mandatory; centrifuge within 2 hrs" value="<?=set_value('comment');?>" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13.5px;">
            </div>

            <div class="col-md-6 form-group">
              <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Operational Mode &amp; Home Collection
              </label>
              <div style="display: flex; gap: 20px; align-items: center; padding-top: 8px;">
                <label style="font-weight: 600; font-size: 13px; color: #0284c7; cursor: pointer; margin: 0;">
                  <input type="checkbox" name="is_available_home_collection" value="1" checked style="accent-color: #0284c7; width: 16px; height: 16px; vertical-align: middle;"> Home Sample Pickup Available
                </label>
              </div>
            </div>
          </div>

          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between;">
            <div>
              <span style="font-size: 13px; font-weight: 700; color: #334155;">Assignment Status:</span>
              <span style="font-size: 12px; color: #64748b; margin-left: 6px;">Controls whether test shows on Upchar public portal for this lab</span>
            </div>
            <div style="display: flex; gap: 16px; align-items: center;">
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #0f172a; cursor: pointer; margin: 0;">
                <input type="radio" name="status" value="1" checked style="accent-color: #00a896;"> Active / Published
              </label>
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #64748b; cursor: pointer; margin: 0;">
                <input type="radio" name="status" value="0" style="accent-color: #00a896;"> Inactive / Hidden
              </label>
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <a href="<?=base_url('doctor/pathology/index')?>" class="btn btn-default" style="font-weight: 600; padding: 10px 20px; border-radius: 8px; border: 1px solid #cbd5e1;">Cancel</a>
            <button type="submit" name="submit" value="Add" class="btn btn-primary" style="background: #00a896; border-color: #00a896; color: #ffffff; font-weight: 700; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 5px rgba(0,168,150,0.3);">
              <i class="fa fa-check-circle" style="margin-right: 6px;"></i> Authorize &amp; Assign Test
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>

<script>
function onLabSelected() {
  var selected = $('#path_lab_id option:selected');
  var comm = selected.data('commission');
  if (comm !== undefined && comm !== null && comm !== '') {
    $('#calc_commission_rate').val(parseFloat(comm));
  }
  recalculatePricing();
}

function onTestSelected() {
  var selected = $('#test_id option:selected');
  var basePrice = selected.data('base-price');
  if (basePrice !== undefined && basePrice !== null && basePrice > 0) {
    $('#lab_price').val(parseFloat(basePrice));
  }
  recalculatePricing();
}

function recalculatePricing() {
  var labPrice = parseFloat($('#lab_price').val()) || 0;
  var commRate = parseFloat($('#calc_commission_rate').val()) || 0;
  var margin = (labPrice * (commRate / 100));
  var patientPrice = labPrice + margin;

  $('#calc_patient_price_display').text('₹ ' + patientPrice.toFixed(2));
  $('#calc_margin_rupees').text('₹ ' + margin.toFixed(2));
}

$(document).ready(function() {
  recalculatePricing();
});
</script>
