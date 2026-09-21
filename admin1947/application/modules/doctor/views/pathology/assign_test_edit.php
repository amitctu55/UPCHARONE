<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Edit Assigned Pathology Test
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Modify laboratory test mapping, custom pricing override, and active status</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url()?>doctor/pathology/index" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Assignments
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 750px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-pencil" style="color: #0d9488; margin-right: 8px;"></i> Edit Mapping #<?=$assignment['id'];?>
        </h3>
        <span class="badge" style="background: #0d9488; color: #ffffff; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
          ID #<?=$assignment['id'];?>
        </span>
      </div>

      <form id="mainform" action="<?=base_url()?>doctor/pathology/edit/<?=$assignment['id'];?>" method="post" enctype="multipart/form-data" style="padding: 24px;">
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Select Pathology Center <span style="color: #EF4444;">*</span>
            </label>
            <select name="path_lab_id" id="path_lab_id" class="form-control" data-validation="required" data-validation-error-msg="Pathology laboratory is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
              <option value="">-- Choose Laboratory --</option>
              <?php if(is_array($pathlab) && !empty($pathlab)) {
                foreach($pathlab as $val) { ?>
                <option value="<?php echo $val['id'];?>" <?php if($val['id'] == (set_value('path_lab_id') ?: $assignment['path_lab_id'])){ echo "selected"; } ?>><?php echo $val['name'];?></option>
              <?php } } ?>
            </select>
            <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('path_lab_id');?></span>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Select Diagnostic Test <span style="color: #EF4444;">*</span>
            </label>
            <select name="test_id" id="test_id" class="form-control" data-validation="required" data-validation-error-msg="Diagnostic test is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
              <option value="">-- Choose Diagnostic Test --</option>
              <?php if(is_array($test) && !empty($test)) {
                foreach($test as $val) { ?>
                <option value="<?php echo $val['test_id'];?>" <?php if($val['test_id'] == (set_value('test_id') ?: $assignment['test_id'])){ echo "selected"; } ?>><?php echo $val['test_name'];?></option>
              <?php } } ?>
            </select>
            <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('test_id');?></span>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Laboratory Test Price (₹) <small style="color: #64748B; font-weight: 400;">(Optional override)</small>
              </label>
              <input type="number" name="lab_price" id="lab_price" class="form-control" placeholder="e.g. 299" value="<?=set_value('lab_price', $assignment['lab_price']);?>" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
            </div>
            <div class="col-md-6">
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Notes / Sample Instructions
              </label>
              <input type="text" name="comment" id="comment" class="form-control" placeholder="e.g. 10-12 hrs fasting required" value="<?=set_value('comment', $assignment['comment']);?>" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
            </div>
          </div>

          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px;">Assignment Status</label>
            <div style="display: flex; gap: 16px; align-items: center;">
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #0F172A; cursor: pointer; margin: 0;">
                <input type="radio" name="status" value="1" <?=($assignment['status'] == '1') ? 'checked' : '';?> style="accent-color: #0d9488;"> Active / Enabled
              </label>
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #64748B; cursor: pointer; margin: 0;">
                <input type="radio" name="status" value="0" <?=($assignment['status'] == '0') ? 'checked' : '';?> style="accent-color: #0d9488;"> Inactive / Disabled
              </label>
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <a href="<?=base_url()?>doctor/pathology/index" class="btn" style="background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px 20px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none;">Cancel</a>
            <button type="submit" id="submit" name="submit" value="Save" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Update Assignment
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script> $.validate({}); </script>
<?=$this->load->view('inc/footer');?>
