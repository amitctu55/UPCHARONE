<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Assign Test Parameters
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Attach metric parameters, reference ranges, and units to diagnostic test panel #<?=$test_id;?></p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/pathtest/viewtest')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Test List
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Add Parameter Card Form -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 24px;">
      <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-plus-circle" style="color: #0d9488; margin-right: 8px;"></i> Attach New Parameter
        </h3>
      </div>

      <?php echo form_open("doctor/pathtest/test_parameter/".$test_id, 'id="mainform" method="post" style="padding: 20px;"'); ?>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 16px; align-items: flex-end;">
          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Select Parameter <span style="color: #EF4444;">*</span></label>
            <select name="parameter_id" id="param_select" onchange="Addtest_parameter(this.value)" class="form-control" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
              <option value="">-- Choose Parameter --</option>
              <?php 
              if(is_array($parameter) && !empty($parameter)) {
                foreach($parameter as $val) { ?>
                <option value="<?php echo $val['parameter_id']?>"><?php echo $val['parameter_name']?></option>
              <?php } } ?>
            </select>
            <span style="color: #EF4444; font-size: 11px;"><?php echo form_error('parameter_id');?></span>
          </div>

          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Reference Range</label>
            <input type="text" readonly class="form-control" id="reference_range" name="reference_range" value="<?php echo $this->input->get_post('reference_range');?>" placeholder="Auto-populated..." style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px; background: #F8FAFC;">
            <span style="color: #EF4444; font-size: 11px;"><?php echo form_error('reference_range');?></span>
          </div>

          <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Metric Unit</label>
            <input type="text" readonly class="form-control" id="unit" name="unit" value="<?php echo $this->input->get_post('unit');?>" placeholder="Auto-populated..." style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px; background: #F8FAFC;">
            <span style="color: #EF4444; font-size: 11px;"><?php echo form_error('unit');?></span>
          </div>

          <div>
            <button type="submit" id="submit" name="submit" value="Add" class="btn" style="height: 40px; background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 0 22px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3); display: inline-flex; align-items: center; gap: 6px;">
              <i class="fa fa-plus"></i> Add
            </button>
          </div>
        </div>
      <?php echo form_close();?>
    </div>

    <!-- Table Card -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-list" style="color: #0d9488; margin-right: 8px;"></i> Currently Assigned Parameters
        </h3>
      </div>

      <div class="table-responsive">
        <table class="table table-hover" id="exportTable" style="margin: 0; border-collapse: separate; border-spacing: 0;">
          <thead>
            <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Parameter Name</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Standard Reference Range</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Measurement Unit</th>
              <th style="padding: 14px 16px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($data)) {
              foreach($data as $p) { ?>
              <tr style="border-bottom: 1px solid #F1F5F9;">
                <td style="padding: 14px 16px; font-weight: 600; color: #0F172A; font-size: 14px;">
                  <?=$p->parameter_name;?>
                </td>
                <td style="padding: 14px 16px; font-size: 13px; color: #334155; font-family: monospace;">
                  <?=$p->reference_range;?>
                </td>
                <td style="padding: 14px 16px;">
                  <span style="background: #F1F5F9; color: #334155; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                    <?=$p->unit_name;?>
                  </span>
                </td>
                <td style="padding: 14px 16px; text-align: right;">
                  <a href="<?=base_url()?>doctor/pathtest/test_parameter_delete?test_parameter_id=<?=$p->test_parameter_id;?>" onclick="return confirm('Are you sure you want to remove this parameter?');" class="btn btn-sm" style="background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; border-radius: 6px; padding: 5px 8px; font-size: 12px;">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php } } else { ?>
              <tr>
                <td colspan="4" style="text-align: center; padding: 32px; color: #94A3B8; font-size: 14px;">
                  No parameters assigned to this diagnostic test.
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div style="display: flex; align-items: center; justify-content: flex-end; padding: 16px 20px; border-top: 1px solid #F1F5F9;">
        <div class="pagination" style="margin: 0;">
          <?php echo $page_links; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
function Addtest_parameter(parameter_id) {
  if(!parameter_id) {
    $("#reference_range").val('');
    $("#unit").val('');
    return;
  }
  $.ajax({
    type: "post",
    url: "<?php echo base_url();?>doctor/pathtest/get_test_parameter/",
    dataType: 'json',
    data: {'parameter_id': parameter_id},
    success: function(res) {
      if(res) {
        $("#reference_range").val(res['reference_range'] || '');
        $("#unit").val(res['unit_name'] || '');
      }
    }
  });
}
</script>
<?=$this->load->view('inc/footer');?>
