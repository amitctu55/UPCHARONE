<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-hospital-o" style="color: #00a896;"></i> Hospital &amp; Clinic Onboarding Portal
        </h1>
        <p style="color: #64748b; font-size: 13px; margin: 5px 0 0 0;">Register and onboard healthcare facilities, hospitals, and specialized day-care clinics.</p>
      </div>
      <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-list"></i> View All Hospitals
        </a>
        <a href="<?=base_url('doctor/clinicreg/hospital_doctor')?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-user-md text-primary"></i> Doctor Affiliations
        </a>
      </div>
    </div>
    <ol class="breadcrumb" style="position: static; float: none; margin: 12px 0 0 0; background: transparent; padding: 0; font-size: 12px;">
      <li><a href="<?=base_url('masters/dashboard')?>" style="color: #64748b;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url('doctor/clinicreg/viewhospital')?>" style="color: #64748b;">Facilities</a></li>
      <li class="active" style="color: #0f172a; font-weight: 600;">Onboard Facility</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 0 30px 30px 30px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 20px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <?php if (validation_errors()): ?>
        <div class="alert alert-danger alert-dismissible" style="border-radius: 8px; margin-bottom: 20px;">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4 style="font-size: 15px; font-weight: 700; margin: 0 0 5px 0;"><i class="fa fa-exclamation-circle"></i> Please resolve the following errors:</h4>
          <?=validation_errors('<div style="font-size: 13px;">&bull; ', '</div>');?>
        </div>
      <?php endif; ?>

      <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin: 0 auto 30px; background: #ffffff; overflow: hidden;">
        
        <!-- Step Navigation Tabs -->
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 12px 20px 0;">
          <ul class="nav nav-tabs" id="clinicTabNav" style="border-bottom: none; display: flex; flex-wrap: wrap; gap: 5px;">
            <li class="active">
              <a href="#cstep-basic" data-toggle="tab" style="font-weight: 600; border-radius: 8px 8px 0 0; padding: 10px 18px; color: #475569;">
                <span class="badge" style="background: #00a896; margin-right: 6px;">1</span> Basic Credentials
              </a>
            </li>
            <li>
              <a href="#cstep-location" data-toggle="tab" style="font-weight: 600; border-radius: 8px 8px 0 0; padding: 10px 18px; color: #475569;">
                <span class="badge" style="background: #0284c7; margin-right: 6px;">2</span> State, City &amp; Address
              </a>
            </li>
            <li>
              <a href="#cstep-services" data-toggle="tab" style="font-weight: 600; border-radius: 8px 8px 0 0; padding: 10px 18px; color: #475569;">
                <span class="badge" style="background: #8b5cf6; margin-right: 6px;">3</span> Services &amp; Packages
              </a>
            </li>
            <li>
              <a href="#cstep-media" data-toggle="tab" style="font-weight: 600; border-radius: 8px 8px 0 0; padding: 10px 18px; color: #475569;">
                <span class="badge" style="background: #f59e0b; margin-right: 6px;">4</span> Media, Docs &amp; Status
              </a>
            </li>
          </ul>
        </div>

        <form action="<?=base_url('doctor/clinicreg/add')?>" method="post" id="clinic-reg-form" enctype="multipart/form-data" style="padding: 24px;">
          <div class="tab-content">
            
            <!-- STEP 1: Basic Details -->
            <div class="tab-pane active" id="cstep-basic">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 24px; padding-bottom: 10px;">
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">Step 1: Facility Classification &amp; Account Credentials</h4>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">Specify facility category, institutional legal identity, and create administrative login details.</p>
              </div>

              <div class="row">
                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="objective" style="font-weight: 600; font-size: 13px; color: #334155;">Facility Category <span style="color:#ef4444;">*</span></label>
                  <select name="objective" id="objective" class="form-control" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                    <option value="H" <?=set_value('objective', 'H')=='H' ? 'selected' : '';?>>Hospital / Multi-Specialty Center</option>
                    <option value="C" <?=set_value('objective')=='C' ? 'selected' : '';?>>Clinic / Day Care Facility</option>
                  </select>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('objective');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="type" style="font-weight: 600; font-size: 13px; color: #334155;">Ownership / Sector <span style="color:#ef4444;">*</span></label>
                  <select name="type" id="type" class="form-control" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                    <option value="1" <?=set_value('type', '1')=='1' ? 'selected' : '';?>>Private Healthcare Facility</option>
                    <option value="2" <?=set_value('type')=='2' ? 'selected' : '';?>>Government / Public / Autonomous</option>
                  </select>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('type');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="name" style="font-weight: 600; font-size: 13px; color: #334155;">Facility / Hospital Name <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Apex Multi-Specialty Hospital" value="<?=set_value('name');?>" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px; font-weight: 600;">
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('name');?></span>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="website" style="font-weight: 600; font-size: 13px; color: #334155;">Official Website URL</label>
                  <input type="url" class="form-control" id="website" name="website" placeholder="https://www.examplehospital.com" value="<?=set_value('website');?>" style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                </div>

                <div class="col-md-4 form-group" style="margin-bottom: 20px;">
                  <label for="email" style="font-weight: 600; font-size: 13px; color: #334155;">Official Email (Login ID) <span style="color:#ef4444;">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="admin@hospital.com" value="<?=set_value('email');?>" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('email');?></span>
                </div>

                <div class="col-md-4 form-group" style="margin-bottom: 20px;">
                  <label for="mobile" style="font-weight: 600; font-size: 13px; color: #334155;">Contact / Emergency Mobile <span style="color:#ef4444;">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="10-digit mobile number" maxlength="10" value="<?=set_value('mobile');?>" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('mobile');?></span>
                </div>

                <div class="col-md-4 form-group" style="margin-bottom: 20px;">
                  <label for="password" style="font-weight: 600; font-size: 13px; color: #334155;">Portal Password <span style="color:#ef4444;">*</span></label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Create secure password" value="<?=set_value('password', 'Upchar@2026');?>" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('password');?></span>
                </div>
              </div>

              <div style="display: flex; justify-content: flex-end; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" class="btn btn-primary next-step-btn" data-next="#cstep-location" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 10px 24px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
                  Continue to Address &amp; State <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 2: Location & Address -->
            <div class="tab-pane" id="cstep-location">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 24px; padding-bottom: 10px;">
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">Step 2: Operational Territory, State &amp; Physical Address</h4>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">Specify institutional state jurisdiction, operational city, local area, and full physical street address.</p>
              </div>

              <?php
                // Fetch active cities and localities from database
                $all_cities = $this->db->select('id, name, state_id')->from('master_city')->where('status', '1')->order_by('name', 'ASC')->get()->result();
                $all_localities = $this->db->select('id, city_id, name')->from('master_locality')->order_by('name', 'ASC')->get()->result();

                // States array
                $indian_states = array(
                  'Uttar Pradesh', 'Delhi NCR', 'Bihar', 'Maharashtra', 'Rajasthan', 
                  'Gujarat', 'Punjab', 'Haryana', 'Uttarakhand', 'Jharkhand', 
                  'Madhya Pradesh', 'West Bengal', 'Karnataka', 'Tamil Nadu', 
                  'Telangana', 'Andhra Pradesh', 'Kerala', 'Odisha', 'Assam', 
                  'Jammu & Kashmir', 'Himachal Pradesh', 'Chhattisgarh', 'Goa'
                );

                // Helper to map city to state
                function mapCityToState($cityName) {
                  $name = strtolower(trim($cityName));
                  if (in_array($name, ['delhi', 'noida', 'ghaziabad'])) return 'Delhi NCR';
                  if (in_array($name, ['ara', 'sasaram', 'purnea bihar', 'bihar'])) return 'Bihar';
                  if (in_array($name, ['jamshedpur', 'jharkhand'])) return 'Jharkhand';
                  if (in_array($name, ['rajasthan', 'jaipur'])) return 'Rajasthan';
                  if (in_array($name, ['gujrat', 'gujarat'])) return 'Gujarat';
                  if (in_array($name, ['punjab'])) return 'Punjab';
                  if (in_array($name, ['u k', 'uttarakhand'])) return 'Uttarakhand';
                  return 'Uttar Pradesh';
                }
              ?>

              <div class="row">
                <!-- State Selection -->
                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="state" style="font-weight: 600; font-size: 13px; color: #334155;">
                    <i class="fa fa-map text-primary"></i> State / Province <span style="color:#ef4444;">*</span>
                  </label>
                  <select name="state" id="state" class="form-control" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px; font-weight: 600;">
                    <option value="">-- Select State / Union Territory --</option>
                    <?php foreach ($indian_states as $st): ?>
                      <option value="<?=$st;?>" <?=set_value('state', 'Uttar Pradesh') == $st ? 'selected' : '';?>><?=$st;?></option>
                    <?php endforeach; ?>
                  </select>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('state');?></span>
                  <small class="text-muted" style="font-size: 11px;">Select state to filter corresponding operational cities.</small>
                </div>

                <!-- City Selection -->
                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="city" style="font-weight: 600; font-size: 13px; color: #334155;">
                    <i class="fa fa-building-o text-success"></i> Operational City <span style="color:#ef4444;">*</span>
                  </label>
                  <select class="form-control" id="city" name="city" required style="border-color: #cbd5e1; border-radius: 6px; height: 40px; font-weight: 600;">
                    <option value="">-- Select Operational City --</option>
                    <?php foreach($all_cities as $ct): ?>
                      <?php $c_state = mapCityToState($ct->name); ?>
                      <option value="<?=$ct->id;?>" data-state="<?=$c_state;?>" <?=set_value('city')==$ct->id ? 'selected' : '';?>>
                        <?=$ct->name;?> (<?=$c_state;?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('city');?></span>
                  <small class="text-muted" style="font-size: 11px;">Governs public doctor searches and locality discovery.</small>
                </div>

                <!-- Locality / Area -->
                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="location" style="font-weight: 600; font-size: 13px; color: #334155;">
                    <i class="fa fa-map-pin text-danger"></i> Locality / Sector / Area
                  </label>
                  <input type="text" class="form-control" id="location" name="location" list="locality_datalist" placeholder="e.g. Lanka, Sigra, Mahmoorganj, Bhelupur" value="<?=set_value('location');?>" style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                  <datalist id="locality_datalist">
                    <?php foreach ($all_localities as $loc): ?>
                      <option value="<?=$loc->name;?>"><?=$loc->name;?></option>
                    <?php endforeach; ?>
                  </datalist>
                  <small class="text-muted" style="font-size: 11px;">Neighborhood, commercial sector, or landmark.</small>
                </div>

                <!-- Pincode -->
                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="pincode" style="font-weight: 600; font-size: 13px; color: #334155;">
                    <i class="fa fa-envelope-o text-warning"></i> Postal PIN Code
                  </label>
                  <input type="text" class="form-control" id="pincode" name="pincode" placeholder="e.g. 221005" maxlength="6" value="<?=set_value('pincode');?>" style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                  <small class="text-muted" style="font-size: 11px;">6-digit postal code for GPS and address resolution.</small>
                </div>

                <!-- Full Address -->
                <div class="col-md-12 form-group" style="margin-bottom: 20px;">
                  <label for="address" style="font-weight: 600; font-size: 13px; color: #334155;">
                    <i class="fa fa-home text-info"></i> Full Physical Street Address <span style="color:#ef4444;">*</span>
                  </label>
                  <textarea class="form-control" id="address" name="address" rows="3" placeholder="Door / Building No., Street, Near Landmark, City, State - Pincode..." required style="border-color: #cbd5e1; border-radius: 6px; font-size: 13px;"><?=set_value('address');?></textarea>
                  <span style="color:#ef4444; font-size: 12px;"><?=form_error('address');?></span>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#cstep-basic" style="font-weight: 600; padding: 10px 22px; border-radius: 6px;">
                  <i class="fa fa-arrow-left"></i> Back to Credentials
                </button>
                <button type="button" class="btn btn-primary next-step-btn" data-next="#cstep-services" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 10px 24px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
                  Continue to Services <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 3: Services & Packages -->
            <div class="tab-pane" id="cstep-services">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 24px; padding-bottom: 10px;">
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">Step 3: Clinical Specializations &amp; Service Offerings</h4>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">Select clinical departments, hospital facilities, diagnostic services, and featured healthcare packages.</p>
              </div>

              <div class="row">
                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label for="services" style="font-weight: 600; font-size: 13px; color: #334155; margin: 0;">
                      Offered Services / Departments
                    </label>
                    <div style="display: flex; gap: 6px;">
                      <button type="button" class="btn btn-xs btn-default" onclick="$('#services option').prop('selected', true);">Select All</button>
                      <button type="button" class="btn btn-xs btn-default" onclick="$('#services option').prop('selected', false);">Clear</button>
                    </div>
                  </div>
                  <select class="form-control" id="services" name="services[]" multiple style="height: 140px; border-color: #cbd5e1; border-radius: 6px; padding: 8px;">
                    <?php
                    $services_list = $this->db->get_where('master_services', array('status'=>1))->result();
                    foreach($services_list as $srv):
                    ?>
                      <option value="<?=$srv->id;?>" <?=in_array($srv->id, (array)set_value('services[]')) ? 'selected' : '';?>>
                        <?=$srv->name;?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <small class="text-muted" style="font-size: 11px;">Hold Ctrl / Cmd key to multi-select relevant departments.</small>
                </div>

                <div class="col-md-6 form-group" style="margin-bottom: 20px;">
                  <label for="package" style="font-weight: 600; font-size: 13px; color: #334155;">Healthcare Packages &amp; Checkups</label>
                  <input type="text" class="form-control" id="package" name="package" placeholder="e.g. Executive Full Body Checkup, Comprehensive Cardiac Plan" value="<?=set_value('package', 'Comprehensive Health Plan');?>" style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                  <small class="text-muted" style="font-size: 11px;">Featured checkup packages offered for online appointment booking.</small>

                  <div style="margin-top: 15px;">
                    <label for="tags" style="font-weight: 600; font-size: 13px; color: #334155;">Search Tags &amp; Keywords</label>
                    <input type="text" class="form-control" id="tags" name="tags" placeholder="e.g. ICU, 24x7 Emergency, Trauma, Dialysis, Ambulance" value="<?=set_value('tags');?>" style="border-color: #cbd5e1; border-radius: 6px; height: 40px;">
                    <small class="text-muted" style="font-size: 11px;">Comma-separated keywords for discoverability.</small>
                  </div>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#cstep-location" style="font-weight: 600; padding: 10px 22px; border-radius: 6px;">
                  <i class="fa fa-arrow-left"></i> Back to Address
                </button>
                <button type="button" class="btn btn-primary next-step-btn" data-next="#cstep-media" style="background: #00a896; border-color: #00a896; font-weight: 600; padding: 10px 24px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
                  Continue to Media &amp; Verification <i class="fa fa-arrow-right"></i>
                </button>
              </div>
            </div>

            <!-- STEP 4: Media & Documents -->
            <div class="tab-pane" id="cstep-media">
              <div style="border-bottom: 1px solid #e2e8f0; margin-bottom: 24px; padding-bottom: 10px;">
                <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">Step 4: Media Assets, Statutory Proofs &amp; Publishing Status</h4>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">Upload hospital building picture, director identification, and medical establishment license (JPG, PNG, PDF up to 5MB).</p>
              </div>

              <div class="row">
                <!-- Facility Photo / Logo -->
                <div class="col-md-4" style="margin-bottom: 20px;">
                  <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">
                    Facility Picture / Logo
                  </label>
                  <div style="border: 2px dashed #cbd5e1; border-radius: 8px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer;" onclick="document.getElementById('uploadimage').click();">
                    <i class="fa fa-hospital-o fa-2x" style="color: #00a896; margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 13px; font-weight: 600; color: #334155; display: block;">Upload Facility Photo</span>
                    <span style="font-size: 11px; color: #94a3b8;">PNG, JPG up to 5MB (Optional)</span>
                    <div style="margin-top: 10px;">
                      <img id="preview_hosp_pic" src="<?=base_url('public/assets/upload/dummyhosp.jpg');?>" alt="Preview" style="max-height: 80px; max-width: 100%; border-radius: 6px; border: 1px solid #e2e8f0;">
                    </div>
                  </div>
                  <input type="file" id="uploadimage" name="uploadimage" accept="image/*" style="display: none;" onchange="previewFile(this, '#preview_hosp_pic');">
                </div>

                <!-- ID Proof -->
                <div class="col-md-4" style="margin-bottom: 20px;">
                  <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">
                    Director / Admin ID Proof
                  </label>
                  <div style="border: 2px dashed #cbd5e1; border-radius: 8px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer;" onclick="document.getElementById('idproof').click();">
                    <i class="fa fa-id-card fa-2x" style="color: #0284c7; margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 13px; font-weight: 600; color: #334155; display: block;">Upload ID Document</span>
                    <span style="font-size: 11px; color: #94a3b8;">Aadhaar / PAN / Passport</span>
                    <div style="margin-top: 10px;">
                      <img id="preview_hosp_id" src="#" alt="Preview" style="display: none; max-height: 80px; max-width: 100%; border-radius: 6px; border: 1px solid #e2e8f0;">
                    </div>
                  </div>
                  <input type="file" id="idproof" name="idproof" accept="image/*,.pdf" style="display: none;" onchange="previewFile(this, '#preview_hosp_id');">
                </div>

                <!-- Clinical License -->
                <div class="col-md-4" style="margin-bottom: 20px;">
                  <label style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">
                    Clinical Establishment License
                  </label>
                  <div style="border: 2px dashed #cbd5e1; border-radius: 8px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer;" onclick="document.getElementById('regproof').click();">
                    <i class="fa fa-certificate fa-2x" style="color: #d97706; margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 13px; font-weight: 600; color: #334155; display: block;">Registration License</span>
                    <span style="font-size: 11px; color: #94a3b8;">State Clinical Reg. Cert</span>
                    <div style="margin-top: 10px;">
                      <img id="preview_hosp_reg" src="#" alt="Preview" style="display: none; max-height: 80px; max-width: 100%; border-radius: 6px; border: 1px solid #e2e8f0;">
                    </div>
                  </div>
                  <input type="file" id="regproof" name="regproof" accept="image/*,.pdf" style="display: none;" onchange="previewFile(this, '#preview_hosp_reg');">
                </div>

                <!-- About / Summary -->
                <div class="col-md-8 form-group" style="margin-top: 10px;">
                  <label for="about" style="font-weight: 600; font-size: 13px; color: #334155;">Institutional Overview &amp; Infrastructure</label>
                  <textarea class="form-control" id="about" name="about" rows="3" placeholder="Provide a brief description of hospital facilities, bed capacity, ICU units, and specialized emergency care..." style="border-color: #cbd5e1; border-radius: 6px; font-size: 13px;"><?=set_value('about');?></textarea>
                </div>

                <!-- Initial Publishing Status -->
                <div class="col-md-4 form-group" style="margin-top: 10px;">
                  <label for="status" style="font-weight: 600; font-size: 13px; color: #334155;">Facility Account Status</label>
                  <select name="status" id="status" class="form-control" style="border-color: #cbd5e1; border-radius: 6px; height: 40px; font-weight: 600;">
                    <option value="1" <?=set_value('status', '1')=='1' ? 'selected' : '';?>>Active / Published (Immediate Listing)</option>
                    <option value="0" <?=set_value('status')=='0' ? 'selected' : '';?>>Draft / Pending Verification</option>
                  </select>
                  <small class="text-muted" style="font-size: 11px;">Active status enables appointment scheduling immediately.</small>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 20px;">
                <button type="button" class="btn btn-default prev-step-btn" data-prev="#cstep-services" style="font-weight: 600; padding: 10px 22px; border-radius: 6px;">
                  <i class="fa fa-arrow-left"></i> Back to Services
                </button>
                <div style="display: flex; gap: 10px;">
                  <button type="reset" class="btn btn-default" style="font-weight: 600; padding: 10px 20px; border-radius: 6px;">
                    <i class="fa fa-refresh"></i> Reset
                  </button>
                  <button type="submit" class="btn btn-primary" name="submit" style="background: #00a896; border-color: #00a896; font-weight: 700; padding: 10px 28px; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0,168,150,0.3);">
                    <i class="fa fa-check-circle"></i> Save &amp; Complete Onboarding
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

<script type="text/javascript">
function previewFile(input, previewSelector) {
  if (input.files && input.files[0]) {
    var file = input.files[0];
    if (file.type.indexOf('image') !== -1) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $(previewSelector).attr('src', e.target.result).show();
      }
      reader.readAsDataURL(file);
    } else {
      // PDF or non-image
      $(previewSelector).attr('src', '<?=base_url("public/assets/dist/img/document-icon.png");?>').show();
    }
  }
}

$(document).ready(function(){
  // Tab navigation buttons
  $('.next-step-btn').click(function(){
    var target = $(this).data('next');
    $('#clinicTabNav a[href="' + target + '"]').tab('show');
    $('html, body').animate({ scrollTop: $('#clinicTabNav').offset().top - 80 }, 200);
  });

  $('.prev-step-btn').click(function(){
    var target = $(this).data('prev');
    $('#clinicTabNav a[href="' + target + '"]').tab('show');
    $('html, body').animate({ scrollTop: $('#clinicTabNav').offset().top - 80 }, 200);
  });

  // State -> City Dynamic Filter
  $('#state').on('change', function(){
    var selectedState = $(this).val();
    if (!selectedState) {
      $('#city option').show();
      return;
    }

    var matchCount = 0;
    var firstMatchVal = '';

    $('#city option').each(function(){
      var cityState = $(this).data('state');
      if (!cityState || $(this).val() === '') {
        $(this).show();
      } else if (cityState.toLowerCase() === selectedState.toLowerCase()) {
        $(this).show();
        matchCount++;
        if (!firstMatchVal) firstMatchVal = $(this).val();
      } else {
        $(this).hide();
      }
    });

    // If current selected city does not belong to new state, pick first match or prompt
    var curCityState = $('#city option:selected').data('state');
    if (curCityState && curCityState.toLowerCase() !== selectedState.toLowerCase()) {
      if (firstMatchVal) {
        $('#city').val(firstMatchVal);
      } else {
        $('#city').val('');
      }
    }
  });

  // City -> State Auto Selection
  $('#city').on('change', function(){
    var cityState = $('#city option:selected').data('state');
    if (cityState && (! $('#state').val() || $('#state').val() !== cityState)) {
      $('#state').val(cityState);
    }
  });

  // Trigger state filter on page load if state is already set
  if ($('#state').val()) {
    $('#state').trigger('change');
  }

  // Auto switch to tab containing validation errors if any exist
  <?php if (validation_errors()): ?>
    if ($('#cstep-basic .text-danger, #cstep-basic span[style*="color:#ef4444"]').filter(':not(:empty)').length > 0) {
      $('#clinicTabNav a[href="#cstep-basic"]').tab('show');
    } else if ($('#cstep-location .text-danger, #cstep-location span[style*="color:#ef4444"]').filter(':not(:empty)').length > 0) {
      $('#clinicTabNav a[href="#cstep-location"]').tab('show');
    } else if ($('#cstep-services .text-danger, #cstep-services span[style*="color:#ef4444"]').filter(':not(:empty)').length > 0) {
      $('#clinicTabNav a[href="#cstep-services"]').tab('show');
    } else if ($('#cstep-media .text-danger, #cstep-media span[style*="color:#ef4444"]').filter(':not(:empty)').length > 0) {
      $('#clinicTabNav a[href="#cstep-media"]').tab('show');
    }
  <?php endif; ?>
});
</script>
