<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          <i class="fa fa-hospital-o" style="color: #00A896;"></i> Edit Hospital Facility: <?=htmlspecialchars(@$hospital->name);?>
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">
          Super Admin Master Access &bull; Full administrative editing of all institutional credentials, infrastructure, and contacts
        </p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/clinicreg/hospitalview/'.@$hospital->id)?>" class="btn" style="background: #00A896; color: #FFFFFF; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-eye"></i> View Hospital Dossier
        </a>
        <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> All Hospitals
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Super Admin Access Banner -->
    <div style="max-width: 1040px; margin: 0 auto 20px; background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 10px; padding: 14px 18px; display: flex; align-items: flex-start; gap: 14px;">
      <div style="width: 32px; height: 32px; border-radius: 50%; background: #DCFCE7; color: #16A34A; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; margin-top: 2px;">
        <i class="fa fa-unlock-alt"></i>
      </div>
      <div style="font-size: 13px; color: #166534; line-height: 1.5;">
        <strong>Super Admin Master Privileges:</strong> You have full administrative permission to edit every field of this hospital, including trade name, registered contact phone, official email, infrastructure classification, address, cancellation rules, and accreditation files. Changes will synchronize across institutional profiles and linked login credentials.
      </div>
    </div>

    <div style="max-width: 1040px; margin: 0 auto; background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
      
      <div style="padding: 18px 24px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; align-items: center; justify-content: space-between;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
          <i class="fa fa-pencil-square-o" style="color: #00A896; margin-right: 8px;"></i> Hospital Information Editor (HOSP-#<?=@$hospital->id;?>)
        </h3>
        <span class="label" style="background: <?=(!empty($hospital->status) && ($hospital->status == '1' || $hospital->status == 'A')) ? '#DCFCE7; color: #15803D;' : '#FEF2F2; color: #DC2626;';?> font-size: 12px; padding: 4px 10px; border-radius: 10px; font-weight: 600;">
          <?=(!empty($hospital->status) && ($hospital->status == '1' || $hospital->status == 'A')) ? 'Active Facility' : 'Inactive / Suspended';?>
        </span>
      </div>

      <form id="mainform" action="" method="post" enctype="multipart/form-data" style="padding: 24px;">
        <div style="display: flex; flex-direction: column; gap: 22px;">

          <!-- SECTION 1: CORE CREDENTIALS (NAME, PHONE, EMAIL) -->
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px;">
            <div style="font-size: 13px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
              <i class="fa fa-id-card-o" style="color: #00A896;"></i> Institutional Name &amp; Contact Credentials
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
              <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                  Hospital Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" class="form-control" id="name" name="name" data-validation="required" value="<?=set_value('name', @$hospital->name); ?>" placeholder="Enter official hospital name" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; font-weight: 600; color: #0F172A; padding: 8px 14px;">
                <small style="color: #64748B; font-size: 11.5px;">Updates institutional title and linked user profile</small>
              </div>

              <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                  Contact Phone / Mobile <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" class="form-control" id="mobile" name="mobile" data-validation="required" value="<?=set_value('mobile', @$hospital->mobile); ?>" placeholder="10-digit mobile number" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; font-weight: 600; color: #0F172A; padding: 8px 14px;">
                <small style="color: #64748B; font-size: 11.5px;">Primary phone used for patient queries &amp; login</small>
              </div>

              <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                  Official Email Address
                </label>
                <input type="email" class="form-control" id="email" name="email" value="<?=set_value('email', @$hospital->email); ?>" placeholder="admin@hospital.com" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
                <small style="color: #64748B; font-size: 11.5px;">Used for appointment notifications &amp; password resets</small>
              </div>
            </div>
          </div>

          <!-- SECTION 2: CLASSIFICATION, WEB PRESENCE & STATUS -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Hospital Classification / Type <span style="color: #EF4444;">*</span>
              </label>
              <select name="type" id="type" class="form-control" data-validation="required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="1" <?php if(set_value('type', @$hospital_login->TYPE)=='1'){ echo "selected"; } ?>>Private Hospital</option>
                <option value="2" <?php if(set_value('type', @$hospital_login->TYPE)=='2'){ echo "selected"; } ?>>Government Hospital</option>
                <option value="3" <?php if(set_value('type', @$hospital_login->TYPE)=='3'){ echo "selected"; } ?>>Super-Specialty Tertiary Care</option>
                <option value="4" <?php if(set_value('type', @$hospital_login->TYPE)=='4'){ echo "selected"; } ?>>Daycare Nursing Home</option>
                <option value="5" <?php if(set_value('type', @$hospital_login->TYPE)=='5'){ echo "selected"; } ?>>Multispecialty Clinic &amp; Diagnostic</option>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Official Website
              </label>
              <input type="text" class="form-control" id="website" name="website" value="<?=set_value('website', @$hospital->website);?>" placeholder="https://example.com" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Operating Status
              </label>
              <select name="status" id="status" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="1" <?=(@$hospital->status == '1' || @$hospital->status == 'A') ? 'selected' : '';?>>Active</option>
                <option value="0" <?=(@$hospital->status === '0' || empty($hospital->status)) ? 'selected' : '';?>>Inactive / Suspended</option>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Approval &amp; Verification
              </label>
              <select name="approved" id="approved" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="1" <?=(@$hospital->approved == '1') ? 'selected' : '';?>>Approved</option>
                <option value="0" <?=(@$hospital->approved === '0' || empty($hospital->approved)) ? 'selected' : '';?>>Pending Approval</option>
              </select>
            </div>
          </div>

          <!-- SECTION 3: LOCATION & PHYSICAL ADDRESS -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                City <span style="color: #EF4444;">*</span>
              </label>
              <select class="form-control" id="city" name="city" data-validation="required" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px;">
                <option value="">-- Choose City --</option>
                <?php
                $citylist = $this->db->get_where('master_city', array('status'=>'1'));
                foreach(@$citylist->result() as $list) { ?>
                  <option value="<?=$list->id;?>" <?php if(@$hospital->city == $list->id || @$hospital->city == $list->name){ echo "selected"; } ?>><?=$list->name;?></option>
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
                $all_localities = $this->db->select('id, city_id, name')->from('master_locality')->where('status', '1')->order_by('name', 'ASC')->get()->result();
                $cur_loc = @$hospital->location;
                // Auto-detect locality if empty but mentioned in address
                if (empty($cur_loc) && !empty($hospital->address)) {
                  $addr_lower = strtolower($hospital->address);
                  foreach($all_localities as $loc_chk) {
                    if (strlen($loc_chk->name) >= 4 && strpos($addr_lower, strtolower($loc_chk->name)) !== false) {
                      $cur_loc = $loc_chk->id;
                      break;
                    }
                  }
                }
                $custom_matched = false;
                foreach($all_localities as $loc) { 
                  $is_sel = ($cur_loc == $loc->id || (!empty($cur_loc) && strtolower(trim($cur_loc)) == strtolower(trim($loc->name))));
                  if ($is_sel) $custom_matched = true;
                ?>
                  <option value="<?=$loc->id;?>" data-city="<?=$loc->city_id;?>" <?=$is_sel ? "selected" : "";?>><?=$loc->name;?></option>
                <?php } 
                if (!empty($cur_loc) && !$custom_matched && !is_numeric($cur_loc)) { ?>
                  <option value="<?=htmlspecialchars($cur_loc);?>" data-city="<?=@$hospital->city;?>" selected><?=htmlspecialchars($cur_loc);?> (Custom)</option>
                <?php } ?>
              </select>
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                State / Province
              </label>
              <input type="text" class="form-control" id="state" name="state" value="<?=set_value('state', @$hospital->state);?>" placeholder="e.g. Uttar Pradesh" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>

            <div>
              <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Pincode / Postal Code
              </label>
              <input type="text" class="form-control" id="pincode" name="pincode" value="<?=set_value('pincode', @$hospital->pincode);?>" placeholder="e.g. 221002" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
            </div>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Full Physical Address
            </label>
            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Street address, building number, landmark" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?=set_value('address', @$hospital->address);?></textarea>
          </div>

          <!-- SECTION 4: OVERVIEW & TAGS -->
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Hospital Overview &amp; Clinical Background
            </label>
            <textarea class="form-control" id="about" name="about" rows="4" placeholder="Comprehensive description of hospital facilities, bed capacity, emergency trauma capabilities, and diagnostic labs" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 10px 14px;"><?=set_value('about', @$hospital->about);?></textarea>
          </div>

          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
              Specialty Tags / Focus Areas (Comma-separated)
            </label>
            <input type="text" class="form-control" id="tag" name="tag" value="<?=set_value('tag', @$hospital->tag);?>" placeholder="Cardiology, ICU, Pediatrics, Emergency, Oncology, Neurology" style="height: 42px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; padding: 8px 14px;">
          </div>

          <!-- SECTION 5: CANCELLATION POLICIES -->
          <div style="background: #FFFBEB; border: 1px solid #FEF3C7; border-radius: 10px; padding: 18px;">
            <div style="font-size: 13px; font-weight: 700; color: #92400E; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
              <i class="fa fa-clock-o"></i> Patient Consultation &amp; Cancellation Policies
            </div>
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px; align-items: start;">
              <div>
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #92400E; margin-bottom: 5px;">
                  Cancellation Cutoff (Hours Before Appointment)
                </label>
                <input type="number" min="0" max="720" class="form-control" id="cancellation_hours" name="cancellation_hours" value="<?=set_value('cancellation_hours', @$hospital->cancellation_hours ?? 3);?>" style="height: 40px; border-radius: 8px; border: 1px solid #FDE68A; font-size: 14px; font-weight: 700; padding: 8px 14px;">
                <small style="color: #B45309; font-size: 11px; display: block; margin-top: 4px;">Default: 3 hours. Patients cannot cancel within this cutoff window.</small>
              </div>
              <div>
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #92400E; margin-bottom: 5px;">
                  Cancellation Policy Text Displayed to Patients
                </label>
                <input type="text" class="form-control" id="cancellation_policy_text" name="cancellation_policy_text" value="<?=set_value('cancellation_policy_text', @$hospital->cancellation_policy_text ?? 'Cancellations allowed up to 3 hours prior to consultation slot.');?>" style="height: 40px; border-radius: 8px; border: 1px solid #FDE68A; font-size: 13.5px; padding: 8px 14px;">
                <small style="color: #B45309; font-size: 11px; display: block; margin-top: 4px;">Explains the refund/cancellation rule clearly to patients on the booking portal.</small>
              </div>
            </div>
          </div>

          <!-- SECTION 6: MEDIA & DOCUMENT UPLOADS -->
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px;">
            <div style="font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">
              <i class="fa fa-camera" style="color: #00A896; margin-right: 6px;"></i> Facility Media &amp; Verification Documents
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px;">
              <!-- 1. Hospital Photo / Logo -->
              <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 8px;">
                  Hospital Photo / Logo
                </label>
                <?php
                $hosp_img = (!empty($hospital->drimage) && $hospital->drimage != 'dummyhosp.jpg' && file_exists(FCPATH . 'public/assets/upload/' . $hospital->drimage))
                  ? base_url('public/assets/upload/' . $hospital->drimage)
                  : base_url('public/assets/images/hospital/dummyhosp.jpg');
                ?>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                  <img src="<?=$hosp_img;?>" alt="Current Photo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;">
                  <div style="font-size: 11.5px; color: #64748B;">
                    <strong>Current:</strong> <?=htmlspecialchars(@$hospital->drimage ?: 'dummyhosp.jpg');?>
                  </div>
                </div>
                <input type="file" name="uploadimage" id="uploadimage" accept="image/*" class="form-control" style="border-radius: 6px; font-size: 12px; height: 36px; padding: 6px;">
                <small style="color: #94A3B8; font-size: 11px;">Leave empty to keep existing image</small>
              </div>

              <!-- 2. Identity Proof -->
              <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 8px;">
                  Facility Identity Proof
                </label>
                <div style="margin-bottom: 10px; font-size: 12px;">
                  <?php if (!empty($hospital->id_proof)): ?>
                    <a href="<?=base_url('public/assets/upload/' . $hospital->id_proof);?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600;">
                      <i class="fa fa-file-text-o text-primary"></i> View Current Document
                    </a>
                  <?php else: ?>
                    <span class="text-muted"><i class="fa fa-times-circle text-warning"></i> No document uploaded yet</span>
                  <?php endif; ?>
                </div>
                <input type="file" name="idproof" id="idproof" accept=".pdf,image/*" class="form-control" style="border-radius: 6px; font-size: 12px; height: 36px; padding: 6px;">
                <small style="color: #94A3B8; font-size: 11px;">Supports PDF or image files</small>
              </div>

              <!-- 3. Medical Registration Proof -->
              <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 8px;">
                  Clinical Establishment License Proof
                </label>
                <div style="margin-bottom: 10px; font-size: 12px;">
                  <?php if (!empty($hospital->med_reg_proof)): ?>
                    <a href="<?=base_url('public/assets/upload/' . $hospital->med_reg_proof);?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600;">
                      <i class="fa fa-file-text-o text-success"></i> View Current License
                    </a>
                  <?php else: ?>
                    <span class="text-muted"><i class="fa fa-times-circle text-warning"></i> No license uploaded yet</span>
                  <?php endif; ?>
                </div>
                <input type="file" name="regproof" id="regproof" accept=".pdf,image/*" class="form-control" style="border-radius: 6px; font-size: 12px; height: 36px; padding: 6px;">
                <small style="color: #94A3B8; font-size: 11px;">Supports PDF or image files</small>
              </div>
            </div>
          </div>

          <!-- Bottom Action Buttons -->
          <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px; margin-top: 10px; padding-top: 16px; border-top: 1px solid #F1F5F9;">
            <a href="<?=base_url('doctor/clinicreg/hospitalview/'.@$hospital->id)?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px; padding: 10px 22px;">
              Cancel
            </a>
            <button type="submit" id="submit" name="submit" value="Update" class="btn" style="background: #00A896; color: #FFFFFF; font-weight: 700; padding: 10px 32px; border-radius: 8px; border: none; box-shadow: 0 4px 12px rgba(0,168,150,0.25);">
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
<script>
  $(document).ready(function() {
    $.validate({});
  });

  // Cross-browser Dynamic Locality Filter by City
  (function() {
    var allLocalityOptions = [];

    function initLocalityFilter() {
      var citySelect = document.getElementById('city');
      var locSelect = document.getElementById('location');
      if (!citySelect || !locSelect) return;

      if (allLocalityOptions.length === 0) {
        for (var i = 0; i < locSelect.options.length; i++) {
          var o = locSelect.options[i];
          allLocalityOptions.push({
            value: o.value,
            text: o.text,
            city: o.getAttribute('data-city') || '',
            selected: o.selected
          });
        }
      }

      function rebuildLocalities(cityId, preserveSelected) {
        var prevVal = locSelect.value;
        locSelect.innerHTML = '';
        var foundSelected = false;

        for (var j = 0; j < allLocalityOptions.length; j++) {
          var item = allLocalityOptions[j];
          if (!item.city || !cityId || String(item.city) === String(cityId)) {
            var newOpt = document.createElement('option');
            newOpt.value = item.value;
            newOpt.textContent = item.text;
            if (item.city) {
              newOpt.setAttribute('data-city', item.city);
            }
            if (preserveSelected && (item.value === prevVal || item.selected)) {
              newOpt.selected = true;
              foundSelected = true;
            }
            locSelect.appendChild(newOpt);
          }
        }

        if (!preserveSelected && !foundSelected) {
          locSelect.value = '';
        }
      }

      citySelect.addEventListener('change', function() {
        rebuildLocalities(this.value, false);
      });

      // Filter on initial load if city is selected
      if (citySelect.value) {
        rebuildLocalities(citySelect.value, true);
      }
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initLocalityFilter);
    } else {
      initLocalityFilter();
    }
  })();
</script>
<?=$this->load->view('inc/footer');?>
