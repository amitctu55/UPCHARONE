<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Edit Test Parameter
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Modify standard reference ranges, measurement units, and normal values</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/pathtest/parameter')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Parameters
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 750px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-pencil-square-o" style="color: #0d9488; margin-right: 8px;"></i> Parameter Details
        </h3>
      </div>

      <form id="mainform" action="<?=base_url()?>doctor/pathtest/editparameter/<?php echo $res->parameter_id; ?>" method="post" enctype="multipart/form-data" style="padding: 24px;">
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Parameter Name <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="parameter_name" value="<?php echo set_value('parameter_name', $res->parameter_name);?>" name="parameter_name" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
              <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('parameter_name');?></span>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Measurement Unit <span style="color: #EF4444;">*</span>
              </label>
              <select name="unit_id" class="form-control" id="unit_id" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="">-- Select Unit --</option>
                <?php if(is_array($unit) && !empty($unit)) {
                  foreach($unit as $val) { ?>
                  <option value="<?php echo $val['unit_id']?>" <?php if(set_value('unit_id', $res->unit_id) == $val['unit_id']){ echo "selected";}?>><?php echo $val['unit_name']?></option>
                <?php } } ?>
              </select>
              <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('unit_id');?></span>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Reference Normal Range</label>
              <input type="text" class="form-control" id="reference_range" value="<?php echo set_value('reference_range', $res->reference_range);?>" name="reference_range" placeholder="e.g., 70 - 110" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
              <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('reference_range');?></span>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Description / Notes</label>
              <input type="text" class="form-control" id="description" value="<?php echo set_value('description', $res->description);?>" name="description" placeholder="Clinical notes..." style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
              <span style="color: #EF4444; font-size: 12px;"><?php echo form_error('description');?></span>
            </div>
          </div>

          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px;">Status</label>
            <div style="display: flex; gap: 16px; align-items: center;">
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #0F172A; cursor: pointer; margin: 0;">
                <input type="radio" name="status" value="1" <?php if($res->status == '1') echo "checked"; ?> style="accent-color: #0d9488;"> Active
              </label>
              <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #64748B; cursor: pointer; margin: 0;">
                <input type="radio" name="status" value="0" <?php if($res->status == '0') echo "checked"; ?> style="accent-color: #0d9488;"> Inactive
              </label>
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <button type="submit" id="submit" name="submit" value="Update" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Update Parameter
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
