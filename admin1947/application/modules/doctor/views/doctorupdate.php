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
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin: 0;">Qualifications (Degrees)</label>
                <div style="display: flex; align-items: center; gap: 6px;">
                  <span id="qual_count_badge" style="background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px; transition: all 0.2s ease;">
                    0 Selected
                  </span>
                  <button type="button" id="qual_select_all" class="btn btn-default btn-xs" style="font-size: 10px; padding: 1px 7px; border-radius: 4px; color: #0d9488; font-weight: 600; border-color: #99f6e4;">Select All</button>
                  <button type="button" id="qual_clear_all" class="btn btn-default btn-xs" style="font-size: 10px; padding: 1px 7px; border-radius: 4px; color: #64748b; font-weight: 600; border-color: #cbd5e1;">Clear</button>
                </div>
              </div>

              <!-- Search Box -->
              <div style="position: relative; margin-bottom: 6px;">
                <i class="fa fa-search" style="position: absolute; left: 10px; top: 9px; color: #94a3b8; font-size: 11px;"></i>
                <input type="text" id="qual_search" class="form-control" placeholder="Search degrees..." style="height: 30px; padding-left: 28px; font-size: 12px; border-radius: 6px; border: 1px solid #cbd5e1; background: #f8fafc;">
                <span id="qual_search_clear" style="position: absolute; right: 10px; top: 6px; color: #94a3b8; font-size: 14px; cursor: pointer; display: none;">&times;</span>
              </div>

              <!-- Scrollable Checkbox Grid Container -->
              <div id="qual_container" style="max-height: 160px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px; background: #ffffff; box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 6px;">
                  <?php
                  $degrees = $this->db->order_by('name', 'ASC')->get_where('master_degree', array('status'=>1))->result();
                  $curQuals = isset($data_qual) && is_array($data_qual) ? $data_qual : array();
                  foreach($degrees as $d):
                    $isChecked = in_array($d->id, $curQuals);
                  ?>
                    <label class="qual-item" style="display: flex; align-items: center; gap: 7px; padding: 5px 8px; border-radius: 6px; border: 1px solid <?=$isChecked ? '#0d9488' : '#e2e8f0';?>; background: <?=$isChecked ? '#f0fdfa' : '#f8fafc';?>; cursor: pointer; margin: 0; font-size: 12px; font-weight: 500; color: #1e293b; user-select: none; transition: all 0.15s ease;">
                      <input type="checkbox" name="qualification[]" value="<?=$d->id;?>" class="qual-checkbox" <?=$isChecked ? 'checked' : '';?> style="cursor: pointer; accent-color: #0d9488; width: 14px; height: 14px; margin: 0;">
                      <span class="qual-name" title="<?=htmlspecialchars($d->name);?>" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?=$d->name;?></span>
                    </label>
                  <?php endforeach; ?>
                </div>
                <div id="qual_empty_msg" style="display: none; text-align: center; color: #94a3b8; font-size: 11px; padding: 12px 6px;">
                  <i class="fa fa-info-circle"></i> No qualification matches "<span id="qual_search_term"></span>"
                </div>
              </div>
              <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Select one or multiple qualifications</small>
            </div>

            <div>
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <label style="font-size: 12px; font-weight: 600; color: #475569; margin: 0;">Specializations</label>
                <div style="display: flex; align-items: center; gap: 6px;">
                  <span id="spec_count_badge" style="background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px; transition: all 0.2s ease;">
                    0 Selected
                  </span>
                  <button type="button" id="spec_select_all" class="btn btn-default btn-xs" style="font-size: 10px; padding: 1px 7px; border-radius: 4px; color: #0d9488; font-weight: 600; border-color: #99f6e4;">Select All</button>
                  <button type="button" id="spec_clear_all" class="btn btn-default btn-xs" style="font-size: 10px; padding: 1px 7px; border-radius: 4px; color: #64748b; font-weight: 600; border-color: #cbd5e1;">Clear</button>
                </div>
              </div>

              <!-- Search Box -->
              <div style="position: relative; margin-bottom: 6px;">
                <i class="fa fa-search" style="position: absolute; left: 10px; top: 9px; color: #94a3b8; font-size: 11px;"></i>
                <input type="text" id="spec_search" class="form-control" placeholder="Search specializations..." style="height: 30px; padding-left: 28px; font-size: 12px; border-radius: 6px; border: 1px solid #cbd5e1; background: #f8fafc;">
                <span id="spec_search_clear" style="position: absolute; right: 10px; top: 6px; color: #94a3b8; font-size: 14px; cursor: pointer; display: none;">&times;</span>
              </div>

              <!-- Scrollable Checkbox Grid Container -->
              <div id="spec_container" style="max-height: 160px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px; background: #ffffff; box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 6px;">
                  <?php
                  $specialties = $this->db->order_by('name', 'ASC')->get_where('master_specialization', array('status'=>1))->result();
                  $curSpls = isset($data_spl) && is_array($data_spl) ? $data_spl : array();
                  foreach($specialties as $s):
                    $isChecked = in_array($s->id, $curSpls);
                  ?>
                    <label class="spec-item" style="display: flex; align-items: center; gap: 7px; padding: 5px 8px; border-radius: 6px; border: 1px solid <?=$isChecked ? '#0d9488' : '#e2e8f0';?>; background: <?=$isChecked ? '#f0fdfa' : '#f8fafc';?>; cursor: pointer; margin: 0; font-size: 12px; font-weight: 500; color: #1e293b; user-select: none; transition: all 0.15s ease;">
                      <input type="checkbox" name="specialisation[]" value="<?=$s->id;?>" class="spec-checkbox" <?=$isChecked ? 'checked' : '';?> style="cursor: pointer; accent-color: #0d9488; width: 14px; height: 14px; margin: 0;">
                      <span class="spec-name" title="<?=htmlspecialchars($s->name);?>" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?=$s->name;?></span>
                    </label>
                  <?php endforeach; ?>
                </div>
                <div id="spec_empty_msg" style="display: none; text-align: center; color: #94a3b8; font-size: 11px; padding: 12px 6px;">
                  <i class="fa fa-info-circle"></i> No specialization matches "<span id="spec_search_term"></span>"
                </div>
              </div>
              <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Select one or multiple specializations</small>
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

$(document).ready(function(){
  function updateQualCount() {
    var count = $('.qual-checkbox:checked').length;
    var badge = $('#qual_count_badge');
    badge.text(count + ' Selected');
    if (count > 0) {
      badge.css({ 'background': '#0d9488', 'color': '#ffffff' });
    } else {
      badge.css({ 'background': '#e2e8f0', 'color': '#475569' });
    }
  }

  function updateSpecCount() {
    var count = $('.spec-checkbox:checked').length;
    var badge = $('#spec_count_badge');
    badge.text(count + ' Selected');
    if (count > 0) {
      badge.css({ 'background': '#0d9488', 'color': '#ffffff' });
    } else {
      badge.css({ 'background': '#e2e8f0', 'color': '#475569' });
    }
  }

  // Checkbox change handlers
  $(document).on('change', '.qual-checkbox', function(){
    var isChecked = $(this).is(':checked');
    var parent = $(this).closest('.qual-item');
    if (isChecked) {
      parent.css({ 'border-color': '#0d9488', 'background': '#f0fdfa' });
    } else {
      parent.css({ 'border-color': '#e2e8f0', 'background': '#f8fafc' });
    }
    updateQualCount();
  });

  $(document).on('change', '.spec-checkbox', function(){
    var isChecked = $(this).is(':checked');
    var parent = $(this).closest('.spec-item');
    if (isChecked) {
      parent.css({ 'border-color': '#0d9488', 'background': '#f0fdfa' });
    } else {
      parent.css({ 'border-color': '#e2e8f0', 'background': '#f8fafc' });
    }
    updateSpecCount();
  });

  // Select all & Clear all
  $('#qual_select_all').click(function(){
    $('.qual-item:visible .qual-checkbox').prop('checked', true).trigger('change');
  });
  $('#qual_clear_all').click(function(){
    $('.qual-checkbox').prop('checked', false).trigger('change');
  });

  $('#spec_select_all').click(function(){
    $('.spec-item:visible .spec-checkbox').prop('checked', true).trigger('change');
  });
  $('#spec_clear_all').click(function(){
    $('.spec-checkbox').prop('checked', false).trigger('change');
  });

  // Search filter - Qualifications
  $('#qual_search').on('input', function(){
    var term = $(this).val().toLowerCase().trim();
    $('#qual_search_clear').toggle(term.length > 0);
    var matches = 0;
    $('.qual-item').each(function(){
      var text = $(this).find('.qual-name').text().toLowerCase();
      if (text.indexOf(term) > -1) {
        $(this).show();
        matches++;
      } else {
        $(this).hide();
      }
    });
    if (matches === 0) {
      $('#qual_search_term').text(term);
      $('#qual_empty_msg').show();
    } else {
      $('#qual_empty_msg').hide();
    }
  });
  $('#qual_search_clear').click(function(){
    $('#qual_search').val('').trigger('input');
  });

  // Search filter - Specializations
  $('#spec_search').on('input', function(){
    var term = $(this).val().toLowerCase().trim();
    $('#spec_search_clear').toggle(term.length > 0);
    var matches = 0;
    $('.spec-item').each(function(){
      var text = $(this).find('.spec-name').text().toLowerCase();
      if (text.indexOf(term) > -1) {
        $(this).show();
        matches++;
      } else {
        $(this).hide();
      }
    });
    if (matches === 0) {
      $('#spec_search_term').text(term);
      $('#spec_empty_msg').show();
    } else {
      $('#spec_empty_msg').hide();
    }
  });
  $('#spec_search_clear').click(function(){
    $('#spec_search').val('').trigger('input');
  });

  // Hover states for items
  $(document).on('mouseenter', '.qual-item, .spec-item', function(){
    if (!$(this).find('input[type="checkbox"]').is(':checked')) {
      $(this).css('background', '#f1f5f9');
    }
  }).on('mouseleave', '.qual-item, .spec-item', function(){
    if (!$(this).find('input[type="checkbox"]').is(':checked')) {
      $(this).css('background', '#f8fafc');
    }
  });

  // Initialize counts
  updateQualCount();
  updateSpecCount();
});
</script>
