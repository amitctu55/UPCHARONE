<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          System Application Settings
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Configure core operational constraints and global platform parameters</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <span style="font-size: 13px; color: #64748B;">System Configuration</span>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 650px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-cogs" style="color: #0d9488; margin-right: 8px;"></i> Global Configuration Parameters
        </h3>
      </div>

      <form action="<?=base_url()?>masters/setting/create" method="post" id="myform" style="padding: 24px;">
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Max Faculty Batch Limit <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" class="form-control" id="max_batch_faculty" value="<?=$max_batch_faculty;?>" placeholder="Enter batch allocation limit" name="max_batch_faculty" data-validation="required" data-validation-error-msg="Faculty batch limit is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Max Assessor Batch Limit <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" class="form-control" id="max_batch_assessor" value="<?=$max_batch_assessor;?>" placeholder="Enter batch allocation limit" name="max_batch_assessor" data-validation="required" data-validation-error-msg="Assessor batch limit is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <input type="hidden" id="eid" name="eid">

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <button type="reset" id="reset" class="btn" style="background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px 20px; border-radius: 8px; border: 1px solid #CBD5E1;">Reset</button>
            <button type="submit" id="submit" name="submit" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Update Settings
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
