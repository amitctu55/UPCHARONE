<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Edit Doctor Profile
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Modify doctor registration, credentials, qualifications, and practice details</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/doctorview')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Doctors Directory
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <form id="mainform" action="<?=base_url('doctor/doctorview/updatedoctor/'.@$profile_dr->id)?>" method="post" enctype="multipart/form-data">
      <div style="max-width: 1000px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Basic & Personal Details -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-user-md" style="color: #0d9488; margin-right: 8px;"></i> Personal Information
            </h3>
          </div>
          <div style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">First Name <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="t_fname" name="t_fname" data-validation="required" data-validation-error-msg="First name is required" value="<?=@$profile_dr->fname;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Last Name</label>
              <input type="text" class="form-control" id="t_lname" name="t_lname" value="<?=@$profile_dr->lname;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Gender <span style="color: #EF4444;">*</span></label>
              <div style="display: flex; gap: 14px; align-items: center; height: 40px;">
                <label style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; margin: 0; cursor: pointer;">
                  <input type="radio" id="genderm" name="gender" value="M" <?php if(@$profile_dr->gender=='M' || !isset($profile_dr->gender)){echo "checked";} ?> style="accent-color: #0d9488;"> Male
                </label>
                <label style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; margin: 0; cursor: pointer;">
                  <input type="radio" id="genderf" name="gender" value="F" <?php if(@$profile_dr->gender=='F'){echo "checked";} ?> style="accent-color: #0d9488;"> Female
                </label>
              </div>
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=@$profile_dr->email;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Mobile <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="mobile" name="mobile" data-validation="required" data-validation-error-msg="Mobile is required" value="<?=@$profile_dr->mobile;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">City <span style="color: #EF4444;">*</span></label>
              <select class="form-control" id="city" name="city" data-validation="required" data-validation-error-msg="City is required" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
                <option value="">-- Select City --</option>
                <?php
                $citylist = $this->db->get_where('master_city', array('status'=>'1'));
                foreach(@$citylist->result() as $list) { ?>
                  <option value="<?=$list->id;?>" <?php if(@$profile_dr->city==$list->id){echo "selected";} ?>><?=$list->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <!-- Professional Qualifications -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-graduation-cap" style="color: #0d9488; margin-right: 8px;"></i> Professional Qualifications & Details
            </h3>
          </div>
          <div style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Registration No <span style="color: #EF4444;">*</span></label>
              <input type="text" class="form-control" id="regno" name="regno" data-validation="required" data-validation-error-msg="Reg No is required" value="<?=@$profile_dr->regd_no;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Medical Council</label>
              <select class="form-control" id="council" name="council" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
                <option value="">-- Select Medical Council --</option>
                <?php
                $councils = $this->db->get_where('master_council', array('status'=>1)); 
                foreach(@$councils->result() as $list) { ?>
                  <option value="<?=$list->id;?>" <?php if(@$profile_dr->regd_council==$list->id){echo "selected";} ?>><?=$list->name;?></option>
                <?php } ?>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Graduation Year</label>
              <input type="text" class="form-control" id="year" name="year" value="<?=(isset($profile_dr->regd_year) ? $profile_dr->regd_year : (isset($profile_dr->year) ? $profile_dr->year : ''));?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Experience (Years)</label>
              <input type="text" class="form-control" id="exprience" name="exprience" value="<?=@$profile_dr->exp;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Achievements</label>
              <input type="text" class="form-control" id="achievement" name="achievement" value="<?=@$profile_dr->achievement;?>" style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Qualifications (Degrees)</label>
              <select class="form-control" id="qualification" name="qualification[]" multiple style="height: 90px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
                <?php
                $degrees = $this->db->get_where('master_degree', array('status'=>1))->result();
                $curQuals = isset($data_qual) && is_array($data_qual) ? $data_qual : array();
                foreach($degrees as $d):
                ?>
                  <option value="<?=$d->id;?>" <?=in_array($d->id, $curQuals) ? 'selected' : '';?>><?=$d->name;?></option>
                <?php endforeach; ?>
              </select>
              <small style="font-size: 11px; color: #64748b;">Hold Ctrl/Cmd to select multiple</small>
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Specializations</label>
              <select class="form-control" id="specialisation" name="specialisation[]" multiple style="height: 90px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
                <?php
                $specialties = $this->db->get_where('master_specialization', array('status'=>1))->result();
                $curSpls = isset($data_spl) && is_array($data_spl) ? $data_spl : array();
                foreach($specialties as $s):
                ?>
                  <option value="<?=$s->id;?>" <?=in_array($s->id, $curSpls) ? 'selected' : '';?>><?=$s->name;?></option>
                <?php endforeach; ?>
              </select>
              <small style="font-size: 11px; color: #64748b;">Hold Ctrl/Cmd to select multiple</small>
            </div>

            <div style="grid-column: 1 / -1;">
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">About Doctor / Professional Summary</label>
              <textarea class="form-control" id="about" name="about" rows="3" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px; padding: 10px;"><?=(isset($profile_dr->about) ? $profile_dr->about : (isset($profile_dr->short_about) ? $profile_dr->short_about : ''));?></textarea>
            </div>
          </div>
        </div>

        <!-- Membership & Status -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-sliders" style="color: #0d9488; margin-right: 8px;"></i> Account Status & Plan
            </h3>
          </div>
          <div style="padding: 20px; display: flex; flex-wrap: wrap; gap: 30px;">
            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 8px;">Subscription Tier</label>
              <div style="display: flex; gap: 16px; align-items: center;">
                <?php 
                  $currentSub = isset($profile_dr->subscription) ? $profile_dr->subscription : (isset($profile_dr->package) ? $profile_dr->package : 'B');
                ?>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; margin: 0; cursor: pointer;">
                  <input type="radio" name="package" value="B" <?=$currentSub=='B' || empty($currentSub) ? 'checked' : '';?> style="accent-color: #0d9488;"> Basic (Free)
                </label>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; margin: 0; cursor: pointer;">
                  <input type="radio" name="package" value="P" <?=$currentSub=='P' ? 'checked' : '';?> style="accent-color: #0d9488;"> Premium (Paid)
                </label>
              </div>
            </div>

            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 8px;">Status</label>
              <div style="display: flex; gap: 16px; align-items: center;">
                <?php 
                  $currentStatus = isset($profile_dr->status) ? $profile_dr->status : '1';
                ?>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; margin: 0; cursor: pointer;">
                  <input type="radio" name="status" value="1" <?=$currentStatus=='1' || $currentStatus=='A' ? 'checked' : '';?> style="accent-color: #0d9488;"> Active
                </label>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; margin: 0; cursor: pointer;">
                  <input type="radio" name="status" value="0" <?=$currentStatus=='0' || $currentStatus=='I' ? 'checked' : '';?> style="accent-color: #0d9488;"> Inactive
                </label>
              </div>
            </div>
          </div>

          <div style="padding: 16px 20px; background: #F8FAFC; border-top: 1px solid #F1F5F9; display: flex; justify-content: flex-end; gap: 12px;">
            <button type="submit" id="submit" name="submit" value="Save" class="btn" style="background: #00a896; color: #FFFFFF; font-weight: 600; padding: 10px 28px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(0,168,150,0.3);">
              <i class="fa fa-save" style="margin-right: 6px;"></i> Update Doctor
            </button>
          </div>
        </div>

      </div>
    </form>
  </section>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script> 
if (typeof $.validate === 'function') {
  $.validate({});
}
</script>
