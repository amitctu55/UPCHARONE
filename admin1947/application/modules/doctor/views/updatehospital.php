<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Edit Hospital Facility
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Update hospital infrastructure, bed capacity, departments, and institutional services</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Hospitals Directory
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <div style="max-width: 960px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-hospital-o" style="color: #0d9488; margin-right: 8px;"></i> Hospital Details
        </h3>
      </div>

      <form id="mainform" action="" method="post" enctype="multipart/form-data" style="padding: 24px;">
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Hospital Type <span style="color: #EF4444;">*</span>
              </label>
              <select name="type" id="type" class="form-control" data-validation="required" data-validation-error-msg="Type is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="1" <?php if(set_value('type', @$hospital_login->TYPE)=='1'){ echo "selected"; } ?>>Private Hospital</option>
                <option value="2" <?php if(set_value('type', @$hospital_login->TYPE)=='2'){ echo "selected"; } ?>>Government Hospital</option>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Hospital Name <span style="color: #EF4444;">*</span>
              </label>
              <input type="text" class="form-control" id="name" name="name" data-validation="required" data-validation-error-msg="Hospital name is required" value="<?=set_value('name', @$hospital->name); ?>" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Official Website
              </label>
              <input type="text" class="form-control" id="website" name="website" value="<?=set_value('website', @$hospital->website);?>" placeholder="https://" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>
          </div>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                City <span style="color: #EF4444;">*</span>
              </label>
              <select class="form-control" id="city" name="city" data-validation="required" data-validation-error-msg="City is required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="">-- Choose City --</option>
                <?php
                $citylist = $this->db->get_where('master_city', array('status'=>'1'));
                foreach(@$citylist->result() as $list) { ?>
                  <option value="<?=$list->id;?>" <?php if(@$hospital->city == $list->id){ echo "selected"; } ?>><?=$list->name;?></option>
                <?php } ?>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Area / Locality
              </label>
              <select class="form-control" id="location" name="location" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="">-- Choose Location --</option>
                <?php
                $locations = $this->db->get_where('master_location', array('status'=>'1'));
                foreach(@$locations->result() as $loc) { ?>
                  <option value="<?=$loc->id;?>" <?php if(@$hospital->location == $loc->id){ echo "selected"; } ?>><?=$loc->name;?></option>
                <?php } ?>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Contact Phone
              </label>
              <input type="text" class="form-control" id="mobile" name="mobile" value="<?=set_value('mobile', @$hospital->mobile);?>" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Physical Address
            </label>
            <textarea class="form-control" id="address" name="address" rows="2" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?=set_value('address', @$hospital->address);?></textarea>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Hospital Overview / Bio
            </label>
            <textarea class="form-control" id="about" name="about" rows="3" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?=set_value('about', @$hospital->about);?></textarea>
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
            <button type="submit" id="submit" name="submit" value="Update" class="btn" style="background: #0d9488; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(13,148,136,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Save Hospital Changes
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
