<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Add Pathology Lab</h1>
        <small style="color: #64748b; font-size: 13px;">Register a diagnostic laboratory, pathology center, or collection point</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/pathlabreg/viewpathology')?>" style="color: #64748b;">Pathology</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Add Pathlab</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <div class="master-card" style="max-width: 1000px; margin: 0 auto 30px;">
        <div class="master-card-header" style="background: #f8fafc;">
          <h3 class="master-card-title">
            <i class="fa fa-flask" style="color: #00a896;"></i>
            <span>Pathology Registration Form</span>
          </h3>
          <a href="<?=base_url('doctor/pathlabreg/viewpathology')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
            <i class="fa fa-list"></i> View Pathlabs
          </a>
        </div>

        <!-- Multi-Step Wizard Tabs -->
        <ul class="form-wizard-tabs" id="pathTabNav">
          <li class="active">
            <a href="#pstep-basic" data-toggle="tab">
              <span class="step-number">1</span> Basic Details
            </a>
          </li>
          <li>
            <a href="#pstep-location" data-toggle="tab">
              <span class="step-number">2</span> Location & Contact
            </a>
          </li>
          <li>
            <a href="#pstep-media" data-toggle="tab">
              <span class="step-number">3</span> Accreditations & Docs
            </a>
          </li>
        </ul>

        <form action="<?=base_url('doctor/pathlabreg/create')?>" method="post" id="pathlab-reg-form" enctype="multipart/form-data" style="padding: 10px 24px 24px;">
          <div class="tab-content" style="padding: 10px 0;">
            
            <!-- STEP 1: Basic Details -->
            <div class="tab-pane active" id="pstep-basic">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 1: Laboratory Info & Credentials</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Enter laboratory name and administrative login details.</p>
              </div>

              <div class="row">
                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="name" style="font-weight: 600; font-size: 13px; color: #334155;">Pathology / Diagnostic Center Name <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="e.g. SRL Diagnostics, Dr. Lal PathLabs" value="<?=set_value('name');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('name');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="website" style="font-weight: 600; font-size: 13px; color: #334155;">Website (Optional)</label>
                  <input type="url" class="form-control" id="website" name="website" placeholder="https://www.pathlab.com" value="<?=set_value('website');?>">
                </div>

                <div class="col-md-4 form-group" style="margin-bottom: 18px;">
                  <label for="email" style="font-weight: 600; font-size: 13px; color: #334155;">Lab Email Address <span style="color:#ef4444;">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="lab@example.com" value="<?=set_value('email');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('email');?></span>
                </div>

                <div class="col-md-4 form-group" style="margin-bottom: 18px;">
                  <label for="mobile" style="font-weight: 600; font-size: 13px; color: #334155;">Mobile / Phone <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="10-digit mobile" maxlength="10" value="<?=set_value('mobile');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('mobile');?></span>
                </div>

                <div class="col-md-4 form-group" style="margin-bottom: 18px;">
                  <label for="password" style="font-weight: 600; font-size: 13px; color: #334155;">Account Password <span style="color:#ef4444;">*</span></label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Account password" value="<?=set_value('password');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('password');?></span>
                </div>
              </div>

              <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                <button type="button" class="btn btn-primary next-step-btn" data-next="#pstep-location" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 22px;">
                  Continue to Location <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 2: Location & Address -->
            <div class="tab-pane" id="pstep-location">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 2: Operational Territory & Physical Address</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Specify diagnostic lab city and full laboratory address.</p>
              </div>

              <div class="row">
                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="city" style="font-weight: 600; font-size: 13px; color: #334155;">City <span style="color:#ef4444;">*</span></label>
                  <select class="form-control" id="city" name="city" required>
                    <option value="">-- Select Operational City --</option>
                    <?php
                    $cities = $this->db->get_where('master_city', array('status'=>1))->result();
                    foreach($cities as $ct):
                    ?>
                      <option value="<?=$ct->id;?>" <?=set_value('city')==$ct->id ? 'selected' : '';?>><?=$ct->name;?></option>
                    <?php endforeach; ?>
                  </select>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('city');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="location" style="font-weight: 600; font-size: 13px; color: #334155;">Locality / Area Name</label>
                  <input type="text" class="form-control" id="location" name="location" placeholder="e.g. Maldahiya, Lahurabir" value="<?=set_value('location');?>">
                </div>

                <div class="col-md-12 form-group" style="margin-bottom: 18px;">
                  <label for="address" style="font-weight: 600; font-size: 13px; color: #334155;">Full Lab Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3" placeholder="Plot / Building no., Street, Landmark, Pincode..."><?=set_value('address');?></textarea>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#pstep-basic" style="font-weight: 600; padding: 8px 20px;">
                  <i class="fa fa-arrow-left"></i> Back
                </button>
                <button type="button" class="btn btn-primary next-step-btn" data-next="#pstep-media" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 22px;">
                  Continue to Documents <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 3: Accreditations & Docs -->
            <div class="tab-pane" id="pstep-media">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 3: Verification & Accreditation Documents</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Upload pathology logo, authorized pathologist ID, and NABL/clinical establishment registration certificate.</p>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">Lab Logo / Photo <span style="color:#ef4444;">*</span></label>
                  <div class="upload-dropzone" onclick="document.getElementById('uploadimage').click();">
                    <i class="fa fa-flask fa-2x" style="color: #00a896; margin-bottom: 6px;"></i>
                    <p style="margin: 0; font-size: 12.5px; font-weight: 600; color: #334155;">Lab Logo / Photo</p>
                    <span style="font-size: 11px; color: #94a3b8;">Click or drag photo</span>
                    <div>
                      <img id="preview_path_logo" class="upload-preview-thumb" src="#" alt="Preview">
                    </div>
                  </div>
                  <input type="file" id="uploadimage" name="uploadimage" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_path_logo');" required>
                </div>

                <div class="col-md-4">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">Director / Pathologist ID</label>
                  <div class="upload-dropzone" onclick="document.getElementById('idproof').click();">
                    <i class="fa fa-id-card fa-2x" style="color: #0284c7; margin-bottom: 6px;"></i>
                    <p style="margin: 0; font-size: 12.5px; font-weight: 600; color: #334155;">Authorized ID Proof</p>
                    <span style="font-size: 11px; color: #94a3b8;">Click or drag file</span>
                    <div>
                      <img id="preview_path_id" class="upload-preview-thumb" src="#" alt="Preview">
                    </div>
                  </div>
                  <input type="file" id="idproof" name="idproof" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_path_id');">
                </div>

                <div class="col-md-4">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">Lab Accreditation Proof</label>
                  <div class="upload-dropzone" onclick="document.getElementById('regproof').click();">
                    <i class="fa fa-certificate fa-2x" style="color: #d97706; margin-bottom: 6px;"></i>
                    <p style="margin: 0; font-size: 12.5px; font-weight: 600; color: #334155;">NABL / Reg Certificate</p>
                    <span style="font-size: 11px; color: #94a3b8;">Click or drag file</span>
                    <div>
                      <img id="preview_path_reg" class="upload-preview-thumb" src="#" alt="Preview">
                    </div>
                  </div>
                  <input type="file" id="regproof" name="regproof" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_path_reg');">
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 15px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#pstep-location" style="font-weight: 600; padding: 8px 20px;">
                  <i class="fa fa-arrow-left"></i> Back
                </button>
                <div style="display: flex; gap: 10px;">
                  <button type="reset" class="btn btn-default" style="font-weight: 600; padding: 8px 20px;">
                    <i class="fa fa-refresh"></i> Reset
                  </button>
                  <button type="submit" class="btn btn-primary" name="submit" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 28px;">
                    <i class="fa fa-check"></i> Register Pathology Lab
                  </button>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>

    </div>
  </section>
</div>

<script>
function previewFile(input, previewSelector) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $(previewSelector).attr('src', e.target.result).show();
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function(){
  $('.next-step-btn').click(function(){
    var target = $(this).data('next');
    $('#pathTabNav a[href="' + target + '"]').tab('show');
    $('html, body').animate({ scrollTop: $('#pathTabNav').offset().top - 80 }, 200);
  });

  $('.prev-step-btn').click(function(){
    var target = $(this).data('prev');
    $('#pathTabNav a[href="' + target + '"]').tab('show');
    $('html, body').animate({ scrollTop: $('#pathTabNav').offset().top - 80 }, 200);
  });
});
</script>
