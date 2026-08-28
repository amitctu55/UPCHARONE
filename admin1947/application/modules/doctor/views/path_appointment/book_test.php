<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Book Diagnostic Lab Test
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Create new pathology appointments, sample collection requests, and calculate test pricing</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/path_appointment')?>" class="btn btn-sm btn-default" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 6px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Bookings List
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px 40px;">
    <div class="container-fluid" style="padding: 0;">

      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <?php if(validation_errors()): ?>
        <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong><i class="fa fa-exclamation-triangle"></i> Please check the following:</strong>
          <?=validation_errors();?>
        </div>
      <?php endif; ?>

      <!-- STEP 1: Select City & Diagnostic Lab -->
      <div class="master-card" style="margin-bottom: 20px;">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-hospital-o" style="color: #00a896;"></i>
            <span>Step 1: Select Pathology Laboratory & Location</span>
          </h3>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <form action="<?=base_url('doctor/path_appointment/book_test')?>" method="get" id="lab_select_form">
            <div class="row">
              <div class="col-md-4 col-sm-6 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  1. City Coverage <span style="color: #ef4444;">*</span>
                </label>
                <select class="form-control" id="city_name" name="city_name" style="border-radius: 6px; height: 38px;">
                  <option value="">-- Choose City --</option>
                  <?php 
                  $cityList = $this->path_appointmentmodel->get_city(array('status'=>'1'));
                  if(is_array($cityList) && !empty($cityList)):
                    foreach($cityList as $list):
                  ?>
                    <option value="<?=$list['id'];?>" <?=$this->input->get_post('city_name')==$list['id']?'selected':'';?>><?=$list['name'];?></option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <div class="col-md-5 col-sm-6 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  2. Pathology Laboratory <span style="color: #ef4444;">*</span>
                </label>
                <select class="form-control" id="pathlab_select" name="pathlab_id" style="border-radius: 6px; height: 38px;">
                  <option value="">-- Choose Lab --</option>
                  <?php  
                  $selectedCity = $this->input->get_post('city_name');
                  $pathlabFilter = !empty($selectedCity) ? array('city' => $selectedCity) : array();
                  $pathlab_list = $this->path_appointmentmodel->pathlab_list($pathlabFilter); 
                  if(is_array($pathlab_list) && !empty($pathlab_list)):
                    foreach($pathlab_list as $val):
                  ?>
                    <option value="<?=$val['id'];?>" <?=$val['id']==$this->input->get_post('pathlab_id')?'selected':'';?>><?=$val['name'];?></option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <div class="col-md-3 col-sm-12 form-group" style="display: flex; align-items: flex-end; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="height: 38px; background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; width: 100%;">
                  <i class="fa fa-filter"></i> Load Lab Tests
                </button>
                <?php if($this->input->get_post('city_name') || $this->input->get_post('pathlab_id')): ?>
                  <a href="<?=base_url('doctor/path_appointment/book_test')?>" class="btn btn-default" style="height: 38px; border-radius: 6px; font-weight: 600;" title="Clear Filter">
                    <i class="fa fa-times text-danger"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- MAIN BOOKING FORM -->
      <?=form_open_multipart(current_url_query_string(), 'id="booking_form"');?>
        <input type="hidden" name="pathlab_id" value="<?=$this->input->get('pathlab_id');?>">

        <!-- STEP 2: Test Selection & Live Calculator -->
        <div class="master-card" style="margin-bottom: 20px;">
          <div class="master-card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="master-card-title">
              <i class="fa fa-flask" style="color: #00a896;"></i>
              <span>Step 2: Select Prescribed Diagnostic Tests</span>
            </h3>
            <div style="background: #e0f2fe; color: #0284c7; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 13px; border: 1px solid #bae6fd;">
              Selected Total: <span style="color: #0f766e; font-size: 15px;">₹<span id="live-total-cost">0.00</span></span> (<span id="live-selected-count">0</span> Tests)
            </div>
          </div>

          <div class="master-card-body" style="padding: 20px;">
            <?php if(!empty($this->input->get('pathlab_id'))): ?>
              <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                <table class="table table-hover table-striped" id="test-picker-table" style="margin: 0;">
                  <thead>
                    <tr>
                      <th style="width: 40px; text-align: center;">
                        <input type="checkbox" id="select-all-test-items" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                      </th>
                      <th>Diagnostic Test Name</th>
                      <th>Short Code</th>
                      <th>Method / Technology</th>
                      <th>Sample Type</th>
                      <th style="width: 120px; text-align: right;">Lab Price (₹)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $selectedTestIds = (array)$this->input->post('arr_ids');
                    if(is_array($path_test) && !empty($path_test)):
                      foreach($path_test as $val):
                        $tid = $val['test_id'];
                        $isChecked = in_array($tid, $selectedTestIds);
                        $amount = floatval($val['amount']);
                    ?>
                      <tr id="test-row-<?=$tid;?>" style="<?=$isChecked ? 'background: #f0fdfa;' : '';?>">
                        <td style="text-align: center; vertical-align: middle;">
                          <input type="checkbox" name="arr_ids[]" value="<?=$tid;?>" data-amount="<?=$amount;?>" class="test-item-checkbox" <?=$isChecked ? 'checked' : '';?> style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                        </td>
                        <td style="vertical-align: middle;">
                          <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($val['test_name']);?></strong>
                        </td>
                        <td style="vertical-align: middle;">
                          <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                            <?=htmlspecialchars($val['short_name']);?>
                          </span>
                        </td>
                        <td style="vertical-align: middle; color: #64748b; font-size: 12.5px;">
                          <?=htmlspecialchars($val['method'] ? $val['method'] : 'Standard Clinical Automated');?>
                        </td>
                        <td style="vertical-align: middle;">
                          <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 11px;">
                            <i class="fa fa-tint"></i> Blood / Serum
                          </span>
                        </td>
                        <td style="text-align: right; vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                          ₹<?=number_format($amount, 2);?>
                        </td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr>
                        <td colspan="6" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                          <i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                          <p style="font-size: 14px; font-weight: 500; margin: 0;">No active tests assigned to this laboratory. Please select another lab or assign tests in Master.</p>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                <i class="fa fa-hospital-o fa-3x" style="color: #94a3b8; margin-bottom: 10px;"></i>
                <h4 style="font-size: 16px; font-weight: 600; color: #334155; margin: 0 0 6px;">Select a Pathology Laboratory Above</h4>
                <p style="font-size: 13px; color: #64748b; margin: 0;">Choose a City and Pathology Lab in Step 1 to load available tests and prices.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- STEP 3: Patient Information & Collection Preferences -->
        <div class="master-card" style="margin-bottom: 25px;">
          <div class="master-card-header">
            <h3 class="master-card-title">
              <i class="fa fa-user" style="color: #00a896;"></i>
              <span>Step 3: Patient Information & Sample Collection Preferences</span>
            </h3>
          </div>

          <div class="master-card-body" style="padding: 20px;">
            <div class="row">
              <div class="col-md-4 col-sm-6 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Patient Full Name <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="patient_name" id="patient_name" class="form-control" value="<?=set_value('patient_name');?>" placeholder="e.g. Ramesh Kumar" required style="border-radius: 6px; height: 38px;">
              </div>

              <div class="col-md-4 col-sm-6 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Patient Mobile Number <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="patient_mobile" id="patient_mobile" class="form-control" value="<?=set_value('patient_mobile');?>" placeholder="10-digit mobile number" required maxlength="12" style="border-radius: 6px; height: 38px;">
              </div>

              <div class="col-md-4 col-sm-12 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Patient Email (Optional)
                </label>
                <input type="email" name="patient_email" id="patient_email" class="form-control" value="<?=set_value('patient_email');?>" placeholder="patient@example.com" style="border-radius: 6px; height: 38px;">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-sm-6 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Sample Collection Preference
                </label>
                <select class="form-control" name="collection_type" style="border-radius: 6px; height: 38px;">
                  <option value="Home Pickup">🏠 Home Sample Collection (Free / Pickup)</option>
                  <option value="Lab Visit">🏥 Walk-in Diagnostic Center Visit</option>
                </select>
              </div>

              <div class="col-md-4 col-sm-6 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Preferred Appointment Date
                </label>
                <input type="date" name="preferred_date" class="form-control" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>" style="border-radius: 6px; height: 38px;">
              </div>

              <div class="col-md-4 col-sm-12 form-group">
                <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Fasting / Clinical Instruction
                </label>
                <select class="form-control" name="fasting_status" style="border-radius: 6px; height: 38px;">
                  <option value="Fasting Required (10-12 hrs)">Fasting Required (10-12 hrs, e.g., FBS, Lipid)</option>
                  <option value="Non-Fasting (Random)">Non-Fasting (Anytime / Random)</option>
                  <option value="Post Prandial (2 hrs after meal)">Post Prandial (PP - 2 hrs after meal)</option>
                </select>
              </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
              <button type="reset" class="btn btn-default" style="border-radius: 6px; font-weight: 600; padding: 8px 20px;">
                <i class="fa fa-refresh"></i> Reset
              </button>
              <button type="submit" name="submit" value="Add" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 28px; border-radius: 6px; font-size: 14px;">
                <i class="fa fa-check-circle"></i> Confirm & Book Lab Order
              </button>
            </div>
          </div>
        </div>
      <?=form_close();?>

    </div>
  </section>
</div>

<script>
function calculateTestTotal() {
  var total = 0;
  var count = 0;
  $('.test-item-checkbox:checked').each(function(){
    var amt = parseFloat($(this).data('amount')) || 0;
    total += amt;
    count++;
    $(this).closest('tr').css('background', '#f0fdfa');
  });

  $('.test-item-checkbox:not(:checked)').each(function(){
    $(this).closest('tr').css('background', '');
  });

  $('#live-total-cost').text(total.toFixed(2));
  $('#live-selected-count').text(count);

  var totalBoxes = $('.test-item-checkbox').length;
  if (count > 0 && count === totalBoxes) {
    $('#select-all-test-items').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < totalBoxes) {
    $('#select-all-test-items').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-test-items').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  calculateTestTotal();

  $(document).on('change', '.test-item-checkbox', function(){
    calculateTestTotal();
  });

  $(document).on('change', '#select-all-test-items', function(){
    var isChecked = $(this).prop('checked');
    $('.test-item-checkbox').prop('checked', isChecked);
    calculateTestTotal();
  });

  // Dynamic Lab loading on city change
  $('#city_name').change(function(){
    var cityId = $(this).val();
    if (cityId != '') {
      $.ajax({
        url: '<?=base_url('doctor/path_appointment/get_pathlab_by_city_id')?>',
        type: 'GET',
        data: { city_id: cityId },
        success: function(data){
          $('#pathlab_select').html(data);
        }
      });
    } else {
      $('#pathlab_select').html('<option value="">-- Choose Lab --</option>');
    }
  });

  // Client Validation on submit
  $('#booking_form').submit(function(e){
    var selectedTests = $('.test-item-checkbox:checked').length;
    var labId = $('input[name="pathlab_id"]').val();

    if (!labId) {
      alert('Please choose a pathology lab in Step 1 first.');
      e.preventDefault();
      return false;
    }

    if (selectedTests === 0) {
      alert('Please select at least one diagnostic test to book.');
      e.preventDefault();
      return false;
    }
    return true;
  });
});
</script>