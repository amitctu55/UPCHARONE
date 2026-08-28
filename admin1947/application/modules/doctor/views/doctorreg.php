<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Add New Doctor</h1>
        <small style="color: #64748b; font-size: 13px;">Register a medical practitioner with professional credentials</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/doctorview')?>" style="color: #64748b;">Doctors</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Add Doctor</li>
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
            <i class="fa fa-user-md" style="color: #00a896;"></i>
            <span>Doctor Registration Form</span>
          </h3>
          <a href="<?=base_url('doctor/doctorview')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
            <i class="fa fa-list"></i> View Doctors Directory
          </a>
        </div>

        <!-- Multi-Step Wizard Tabs -->
        <ul class="form-wizard-tabs" id="doctorTabNav">
          <li class="active">
            <a href="#step-basic" data-toggle="tab">
              <span class="step-number">1</span> Basic Details
            </a>
          </li>
          <li>
            <a href="#step-professional" data-toggle="tab">
              <span class="step-number">2</span> Professional Info
            </a>
          </li>
          <li>
            <a href="#step-media" data-toggle="tab">
              <span class="step-number">3</span> Upload Documents
            </a>
          </li>
          <li>
            <a href="#step-bio" data-toggle="tab">
              <span class="step-number">4</span> Bio & Objectives
            </a>
          </li>
        </ul>

        <form action="<?=base_url('doctor/doctorreg/index')?>" method="post" id="doctor-reg-form" enctype="multipart/form-data" style="padding: 10px 24px 24px;">
          <div class="tab-content" style="padding: 10px 0;">
            
            <!-- STEP 1: Basic Details -->
            <div class="tab-pane active" id="step-basic">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 1: Personal & Account Information</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Enter personal and login credentials for the doctor.</p>
              </div>

              <div class="row">
                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="t_fname" style="font-weight: 600; font-size: 13px; color: #334155;">First Name <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="t_fname" name="t_fname" placeholder="e.g. Rajesh" value="<?=set_value('t_fname');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('t_fname');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="t_lname" style="font-weight: 600; font-size: 13px; color: #334155;">Last Name</label>
                  <input type="text" class="form-control" id="t_lname" name="t_lname" placeholder="e.g. Sharma" value="<?=set_value('t_lname');?>">
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('t_lname');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label style="font-weight: 600; font-size: 13px; color: #334155; display: block;">Gender <span style="color:#ef4444;">*</span></label>
                  <div style="display: flex; gap: 20px; align-items: center; height: 38px;">
                    <label style="font-weight: 500; cursor: pointer; margin: 0; display: flex; align-items: center; gap: 6px;">
                      <input type="radio" name="gender" value="M" <?=set_value('gender')=='M' || set_value('gender')=='' ? 'checked' : '';?>> Male
                    </label>
                    <label style="font-weight: 500; cursor: pointer; margin: 0; display: flex; align-items: center; gap: 6px;">
                      <input type="radio" name="gender" value="F" <?=set_value('gender')=='F' ? 'checked' : '';?>> Female
                    </label>
                  </div>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('gender');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="mobile" style="font-weight: 600; font-size: 13px; color: #334155;">Mobile Number <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="10-digit mobile number" maxlength="10" value="<?=set_value('mobile');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('mobile');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="email" style="font-weight: 600; font-size: 13px; color: #334155;">Email Address <span style="color:#ef4444;">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="doctor@example.com" value="<?=set_value('email');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('email');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="password" style="font-weight: 600; font-size: 13px; color: #334155;">Login Password <span style="color:#ef4444;">*</span></label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Create strong account password" value="<?=set_value('password');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('password');?></span>
                </div>
              </div>

              <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                <button type="button" class="btn btn-primary next-step-btn" data-next="#step-professional" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 22px;">
                  Continue to Professional Info <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 2: Professional Info -->
            <div class="tab-pane" id="step-professional">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 2: Medical Practice & Qualifications</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Specify medical registration council, qualifications, and specializations.</p>
              </div>

              <div class="row">
                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="regno" style="font-weight: 600; font-size: 13px; color: #334155;">Registration Number <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="regno" name="regno" placeholder="Medical Registration No." value="<?=set_value('regno');?>" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('regno');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="council" style="font-weight: 600; font-size: 13px; color: #334155;">Registration Council</label>
                  <select class="form-control" id="council" name="council">
                    <option value="">-- Select Medical Council --</option>
                    <?php
                    $councils = $this->db->get_where('master_council', array('status'=>1))->result();
                    foreach($councils as $c):
                    ?>
                      <option value="<?=$c->id;?>" <?=set_value('council')==$c->id ? 'selected' : '';?>><?=$c->name;?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

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
                  <label for="year" style="font-weight: 600; font-size: 13px; color: #334155;">Registration Year <span style="color:#ef4444;">*</span></label>
                  <input type="number" class="form-control" id="year" name="year" placeholder="e.g. 2015" value="<?=set_value('year');?>" required>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="exprience" style="font-weight: 600; font-size: 13px; color: #334155;">Experience (Years) <span style="color:#ef4444;">*</span></label>
                  <input type="number" class="form-control" id="exprience" name="exprience" placeholder="e.g. 10" value="<?=set_value('exprience');?>" required>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="achievement" style="font-weight: 600; font-size: 13px; color: #334155;">Key Achievements / Awards</label>
                  <input type="text" class="form-control" id="achievement" name="achievement" placeholder="e.g. Best Cardiologist 2023" value="<?=set_value('achievement');?>">
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="qualification" style="font-weight: 600; font-size: 13px; color: #334155;">Qualifications <span style="color:#ef4444;">*</span></label>
                  <select class="form-control" id="qualification" name="qualification[]" multiple style="height: 100px;" required>
                    <?php
                    $degrees = $this->db->get_where('master_degree', array('status'=>1))->result();
                    foreach($degrees as $d):
                    ?>
                      <option value="<?=$d->id;?>"><?=$d->name;?></option>
                    <?php endforeach; ?>
                  </select>
                  <small class="text-muted">Hold Ctrl / Cmd to select multiple qualifications</small>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                  <label for="specialisation" style="font-weight: 600; font-size: 13px; color: #334155;">Specializations <span style="color:#ef4444;">*</span></label>
                  <select class="form-control" id="specialisation" name="specialisation[]" multiple style="height: 100px;" required>
                    <?php
                    $specialties = $this->db->get_where('master_specialization', array('status'=>1))->result();
                    foreach($specialties as $s):
                    ?>
                      <option value="<?=$s->id;?>"><?=$s->name;?></option>
                    <?php endforeach; ?>
                  </select>
                  <small class="text-muted">Hold Ctrl / Cmd to select multiple specializations</small>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#step-basic" style="font-weight: 600; padding: 8px 20px;">
                  <i class="fa fa-arrow-left"></i> Back
                </button>
                <button type="button" class="btn btn-primary next-step-btn" data-next="#step-media" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 22px;">
                  Continue to Documents <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 3: Upload Documents -->
            <div class="tab-pane" id="step-media">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 3: Verification & Profile Media</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Upload doctor photo, ID proof, and council registration certificate (JPG, PNG up to 2MB).</p>
              </div>

              <div class="row">
                <!-- Profile Picture Upload -->
                <div class="col-md-4">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">Profile Picture <span style="color:#ef4444;">*</span></label>
                  <div class="upload-dropzone" onclick="document.getElementById('uploadimage').click();">
                    <i class="fa fa-user-circle-o fa-2x" style="color: #00a896; margin-bottom: 6px;"></i>
                    <p style="margin: 0; font-size: 12.5px; font-weight: 600; color: #334155;">Doctor Photo</p>
                    <span style="font-size: 11px; color: #94a3b8;">Click or drag photo</span>
                    <div>
                      <img id="preview_profile" class="upload-preview-thumb" src="#" alt="Preview">
                    </div>
                  </div>
                  <input type="file" id="uploadimage" name="uploadimage" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_profile');" required>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('uploadimage');?></span>
                </div>

                <!-- ID Proof Upload -->
                <div class="col-md-4">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">ID Proof (Aadhaar / Passport)</label>
                  <div class="upload-dropzone" onclick="document.getElementById('idproof').click();">
                    <i class="fa fa-id-card fa-2x" style="color: #0284c7; margin-bottom: 6px;"></i>
                    <p style="margin: 0; font-size: 12.5px; font-weight: 600; color: #334155;">Identity Document</p>
                    <span style="font-size: 11px; color: #94a3b8;">Click or drag file</span>
                    <div>
                      <img id="preview_idproof" class="upload-preview-thumb" src="#" alt="Preview">
                    </div>
                  </div>
                  <input type="file" id="idproof" name="idproof" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_idproof');">
                </div>

                <!-- Registration Proof Upload -->
                <div class="col-md-4">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">Council Registration Certificate</label>
                  <div class="upload-dropzone" onclick="document.getElementById('regproof').click();">
                    <i class="fa fa-certificate fa-2x" style="color: #d97706; margin-bottom: 6px;"></i>
                    <p style="margin: 0; font-size: 12.5px; font-weight: 600; color: #334155;">Council Certificate</p>
                    <span style="font-size: 11px; color: #94a3b8;">Click or drag file</span>
                    <div>
                      <img id="preview_regproof" class="upload-preview-thumb" src="#" alt="Preview">
                    </div>
                  </div>
                  <input type="file" id="regproof" name="regproof" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_regproof');">
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#step-professional" style="font-weight: 600; padding: 8px 20px;">
                  <i class="fa fa-arrow-left"></i> Back
                </button>
                <button type="button" class="btn btn-primary next-step-btn" data-next="#step-bio" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 22px;">
                  Continue to Bio & Objectives <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 4: Bio & Objectives -->
            <div class="tab-pane" id="step-bio">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Step 4: Biography & Clinical Objectives</h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0;">Provide detailed profile background and key consultation objectives.</p>
              </div>

              <div class="row">
                <div class="col-md-12 form-group" style="margin-bottom: 18px;">
                  <label for="about" style="font-weight: 600; font-size: 13px; color: #334155;">About Doctor / Professional Summary</label>
                  <textarea class="form-control" id="about" name="about" rows="3" placeholder="Provide professional overview, clinical background, and patient care approach..."><?=set_value('about');?></textarea>
                </div>

                <div class="col-md-12 form-group" style="margin-bottom: 18px;">
                  <label style="font-weight: 600; font-size: 13px; color: #334155;">Primary Consultation Objectives <span style="color:#ef4444;">*</span></label>
                  <div class="row">
                    <?php
                    $objectives = array(
                      "To provide high standard clinical care with empathy.",
                      "To utilize modern evidence-based medical diagnostics.",
                      "To maintain patient confidentiality and clinical ethics.",
                      "To offer timely and accessible patient consultation."
                    );
                    foreach($objectives as $idx => $obj):
                    ?>
                      <div class="col-md-6" style="margin-bottom: 8px;">
                        <label style="font-weight: 500; font-size: 12.5px; cursor: pointer; display: flex; align-items: flex-start; gap: 8px;">
                          <input type="checkbox" name="objective[]" value="<?=$obj;?>" checked style="margin-top: 3px;"> <?=$obj;?>
                        </label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 15px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#step-media" style="font-weight: 600; padding: 8px 20px;">
                  <i class="fa fa-arrow-left"></i> Back
                </button>
                <div style="display: flex; gap: 10px;">
                  <button type="reset" class="btn btn-default" style="font-weight: 600; padding: 8px 20px;">
                    <i class="fa fa-refresh"></i> Reset
                  </button>
                  <button type="submit" class="btn btn-primary" name="submit" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 8px 28px;">
                    <i class="fa fa-check"></i> Register Doctor
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
    $('#doctorTabNav a[href="' + target + '"]').tab('show');
    $('html, body').animate({ scrollTop: $('#doctorTabNav').offset().top - 80 }, 200);
  });

  $('.prev-step-btn').click(function(){
    var target = $(this).data('prev');
    $('#doctorTabNav a[href="' + target + '"]').tab('show');
    $('html, body').animate({ scrollTop: $('#doctorTabNav').offset().top - 80 }, 200);
  });
});
</script>
