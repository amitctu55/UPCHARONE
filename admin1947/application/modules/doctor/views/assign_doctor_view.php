<style>
  .assign-container {
    padding: 15px 20px 40px;
  }
  .assign-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    border: 1px solid #e2e8f0;
    padding: 24px;
    margin-bottom: 24px;
  }
  .form-section-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
  }
  .form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    height: 38px;
    box-shadow: none;
    transition: all 0.2s;
  }
  .form-control:focus {
    border-color: #00a896;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
  }
  .btn-save-assign {
    background: #00a896;
    border-color: #00a896;
    color: #ffffff;
    font-weight: 700;
    padding: 11px 28px;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .btn-save-assign:hover {
    background: #008f80;
    border-color: #008f80;
    color: #ffffff;
  }
  .fee-preset-btn {
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s;
    margin-right: 4px;
  }
  .fee-preset-btn:hover {
    background: #00a896;
    border-color: #00a896;
    color: #ffffff;
  }
  .facility-type-toggle {
    display: flex;
    gap: 12px;
    margin-top: 4px;
  }
  .facility-radio-label {
    flex: 1;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 9px 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    background: #f8fafc;
    transition: all 0.2s;
  }
  .facility-radio-label.active {
    background: #f0fdf4;
    border-color: #00a896;
    color: #00a896;
  }
  /* Timings Builder Styles */
  .timing-block-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #00a896;
    border-radius: 8px;
    padding: 18px;
    margin-bottom: 16px;
  }
  .timing-block-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    flex-wrap: wrap;
    gap: 8px;
  }
  .day-checkbox-label {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    user-select: none;
    transition: all 0.15s;
    margin-right: 6px;
    margin-bottom: 6px;
  }
  .day-checkbox-label.checked {
    background: #ecfdf5;
    border-color: #059669;
    color: #065f46;
  }
  .day-preset-link {
    font-size: 11.5px;
    font-weight: 600;
    color: #0284c7;
    cursor: pointer;
    text-decoration: underline;
    margin-right: 10px;
  }
  .session-row {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">
          <i class="fa fa-user-plus" style="color: #00a896; margin-right: 6px;"></i> Doctor Affiliation &amp; Multi-Session Scheduling
        </h1>
        <small style="color: #64748b; font-size: 13px;">Search doctors across the registry, affiliate to hospitals/clinics, and configure multi-slot working days</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard');?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?=base_url('doctor/clinicreg/viewhospital');?>" style="color: #64748b;">Facilities</a></li>
        <li><a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" style="color: #64748b;">Affiliations</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Assign Doctor</li>
      </ol>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content assign-container">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Message -->
      <?php if ($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 18px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Affiliation Creation Form Card -->
      <div class="assign-card">
        <div class="form-section-title">
          <span><i class="fa fa-stethoscope" style="color: #00a896; margin-right: 6px;"></i> Affiliation &amp; Timing Configuration</span>
          <span style="font-size: 12px; font-weight: 600; color: #64748b;">All 1,400+ Registered Doctors Searchable</span>
        </div>

        <form action="<?=base_url('doctor/clinicreg/assign_doctor');?>" method="post" id="assignDoctorForm">
          
          <!-- SECTION 1: SEARCH & SELECT DOCTOR -->
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
            <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
              <span><i class="fa fa-search text-primary" style="margin-right: 6px;"></i> 1. Search &amp; Select Doctor</span>
              <span id="doc_count_badge" class="label label-info" style="font-size: 11px;"><?=count($doctors);?> Doctors Available</span>
            </div>

            <!-- Instant Search Input -->
            <div class="row">
              <div class="col-md-6 col-xs-12" style="margin-bottom: 10px;">
                <div class="input-group" style="width: 100%;">
                  <span class="input-group-addon" style="background: #ffffff; border-right: none; border-color: #cbd5e1;">
                    <i class="fa fa-search text-muted"></i>
                  </span>
                  <input type="text" id="doctor_quick_search" class="form-control" placeholder="Quick search by Doctor Name, Speciality, Mobile, or City..." style="border-left: none;" onkeyup="filterDoctorDropdown()">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" onclick="clearDoctorSearch()" title="Clear Search" style="height: 38px; border-color: #cbd5e1;">
                      <i class="fa fa-times text-danger"></i>
                    </button>
                  </span>
                </div>
              </div>

              <!-- Doctor Select Dropdown -->
              <div class="col-md-6 col-xs-12" style="margin-bottom: 10px;">
                <select name="doctor_id" id="doctor_id" class="form-control" required style="width: 100%; height: 38px;" onchange="onDoctorSelected()">
                  <option value="">-- Choose Doctor from Search Results --</option>
                  <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doc): ?>
                      <?php 
                        $docName = trim($doc['fname'].' '.$doc['lname']);
                        $spec = !empty($doc['speciality']) ? $doc['speciality'] : 'General Practitioner';
                        $city = !empty($doc['city']) ? $doc['city'] : '';
                        $mobile = !empty($doc['mobile']) ? $doc['mobile'] : '';
                      ?>
                      <option value="<?=$doc['id'];?>" 
                              data-name="<?=htmlspecialchars($docName);?>" 
                              data-speciality="<?=htmlspecialchars($spec);?>" 
                              data-mobile="<?=htmlspecialchars($mobile);?>" 
                              data-city="<?=htmlspecialchars($city);?>">
                        Dr. <?=htmlspecialchars($docName);?> (<?=htmlspecialchars($spec);?>) <?=!empty($city) ? '- '.htmlspecialchars($city) : '';?> - Tel: <?=htmlspecialchars($mobile);?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>

            <!-- Selected Doctor Summary Preview Card -->
            <div id="selected_doctor_card" style="display: none; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px 16px; margin-top: 10px; align-items: center; justify-content: space-between;">
              <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                  <i class="fa fa-user-md"></i>
                </div>
                <div>
                  <div style="font-size: 15px; font-weight: 700; color: #0f172a;" id="sel_doc_name">Dr. Name</div>
                  <div style="font-size: 12.5px; color: #64748b;">
                    <span class="label label-success" id="sel_doc_spec" style="font-size: 11px;">Speciality</span> &bull; 
                    <span id="sel_doc_contact">Tel: </span> &bull; 
                    <span id="sel_doc_city">City</span>
                  </div>
                </div>
              </div>
              <span class="label label-primary" style="padding: 5px 10px;"><i class="fa fa-check"></i> Doctor Selected</span>
            </div>
          </div>

          <!-- SECTION 2: SELECT FACILITY & BASE FEE -->
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
            <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 14px;">
              <i class="fa fa-building-o text-primary" style="margin-right: 6px;"></i> 2. Healthcare Facility &amp; Base Consultation Charge
            </div>

            <div class="row">
              <!-- Facility Type Selector -->
              <div class="col-md-4 col-xs-12" style="margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <label><i class="fa fa-tags text-primary" style="margin-right: 4px;"></i> Facility Type <span class="text-danger">*</span></label>
                  <div class="facility-type-toggle">
                    <label class="facility-radio-label active" id="label_type_h">
                      <input type="radio" name="type" value="H" checked onchange="toggleFacilityType('H')" style="margin: 0;">
                      <i class="fa fa-hospital-o text-primary"></i> Hospital
                    </label>
                    <label class="facility-radio-label" id="label_type_c">
                      <input type="radio" name="type" value="C" onchange="toggleFacilityType('C')" style="margin: 0;">
                      <i class="fa fa-medkit text-warning"></i> Clinic
                    </label>
                  </div>
                </div>
              </div>

              <!-- Hospital Dropdown -->
              <div class="col-md-4 col-xs-12" id="hospital_wrapper" style="margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <label for="hospital_id">
                    <i class="fa fa-hospital-o text-success" style="margin-right: 4px;"></i> Select Hospital <span class="text-danger">*</span>
                  </label>
                  <select name="hospital_id" id="hospital_id" class="form-control" required style="width: 100%;">
                    <option value="">-- Choose Hospital (<?=count($hospitals);?>) --</option>
                    <?php if (!empty($hospitals)): ?>
                      <?php foreach ($hospitals as $hosp): ?>
                        <option value="<?=$hosp['id'];?>">
                          <?=htmlspecialchars($hosp['name']);?> (<?=htmlspecialchars($hosp['city'] ?: $hosp['address']);?>)
                        </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                </div>
              </div>

              <!-- Clinic Dropdown -->
              <div class="col-md-4 col-xs-12" id="clinic_wrapper" style="display: none; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <label for="clinic_id">
                    <i class="fa fa-medkit text-warning" style="margin-right: 4px;"></i> Select Clinic <span class="text-danger">*</span>
                  </label>
                  <select name="clinic_id" id="clinic_id" class="form-control" style="width: 100%;">
                    <option value="">-- Choose Clinic (<?=count($clinics);?>) --</option>
                    <?php if (!empty($clinics)): ?>
                      <?php foreach ($clinics as $cl): ?>
                        <option value="<?=$cl['id'];?>">
                          <?=htmlspecialchars($cl['name']);?> (<?=htmlspecialchars($cl['city'] ?: $cl['address']);?>)
                        </option>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <option value="" disabled>No private clinics registered yet</option>
                    <?php endif; ?>
                  </select>
                </div>
              </div>

              <!-- Consultation Base Fee -->
              <div class="col-md-4 col-xs-12" style="margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <label for="fee">
                    <i class="fa fa-inr text-success" style="margin-right: 4px;"></i> Base Consultation Fee (&#8377;) <span class="text-danger">*</span>
                  </label>
                  <input type="number" name="fee" id="fee" class="form-control" placeholder="e.g. 500" min="0" step="50" value="500" required>
                  <div style="margin-top: 6px;">
                    <span style="font-size: 11px; color: #64748b; margin-right: 4px;">Presets:</span>
                    <button type="button" class="fee-preset-btn" onclick="setFee(300)">&#8377;300</button>
                    <button type="button" class="fee-preset-btn" onclick="setFee(500)">&#8377;500</button>
                    <button type="button" class="fee-preset-btn" onclick="setFee(800)">&#8377;800</button>
                    <button type="button" class="fee-preset-btn" onclick="setFee(1000)">&#8377;1000</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- SECTION 3: MULTI-SESSION OPD TIMINGS & REMAINING DAYS SCHEDULER -->
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
              <div>
                <div style="font-size: 14px; font-weight: 700; color: #1e293b;">
                  <i class="fa fa-clock-o text-success" style="margin-right: 6px;"></i> 3. OPD Working Days &amp; Multi-Session Timings
                </div>
                <small style="color: #64748b; font-size: 12.5px;">Configure multiple sessions per day (e.g. Morning &amp; Evening), and add separate slots for remaining days (e.g. Weekends)</small>
              </div>
              <div>
                <button type="button" class="btn btn-sm btn-info" onclick="addRemainingDaysBlock()" style="font-weight: 600; border-radius: 6px; background: #0284c7; border-color: #0284c7;">
                  <i class="fa fa-plus-circle"></i> Add Remaining Days with Different Time Slots
                </button>
              </div>
            </div>

            <!-- Dynamic Day & Session Blocks Container -->
            <div id="timing_blocks_container">
              
              <!-- SCHEDULE BLOCK 0 (Primary) -->
              <div class="timing-block-card" id="timing_block_0">
                <div class="timing-block-header">
                  <div>
                    <span class="label label-primary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">Schedule Block #1 (Primary Days)</span>
                  </div>
                  <div>
                    <span style="font-size: 11.5px; color: #64748b; margin-right: 6px;">Day Presets:</span>
                    <span class="day-preset-link" onclick="applyDayPreset(0, ['M','T','W','TH','F'])">Mon-Fri (Weekdays)</span>
                    <span class="day-preset-link" onclick="applyDayPreset(0, ['M','T','W','TH','F','SA'])">Mon-Sat</span>
                    <span class="day-preset-link" onclick="applyDayPreset(0, ['M','T','W','TH','F','SA','S'])">All 7 Days</span>
                    <span class="day-preset-link" onclick="applyDayPreset(0, ['SA','S'])">Sat-Sun (Weekend)</span>
                  </div>
                </div>

                <!-- Days Checkboxes -->
                <div style="margin-bottom: 14px;">
                  <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Select Working Days for this Slot:</label>
                  <div id="days_wrapper_0" style="display: flex; flex-wrap: wrap;">
                    <label class="day-checkbox-label checked" id="lbl_day_0_M"><input type="checkbox" name="timing_blocks[0][days][]" value="M" checked onchange="toggleDayLabel(this)"> Mon</label>
                    <label class="day-checkbox-label checked" id="lbl_day_0_T"><input type="checkbox" name="timing_blocks[0][days][]" value="T" checked onchange="toggleDayLabel(this)"> Tue</label>
                    <label class="day-checkbox-label checked" id="lbl_day_0_W"><input type="checkbox" name="timing_blocks[0][days][]" value="W" checked onchange="toggleDayLabel(this)"> Wed</label>
                    <label class="day-checkbox-label checked" id="lbl_day_0_TH"><input type="checkbox" name="timing_blocks[0][days][]" value="TH" checked onchange="toggleDayLabel(this)"> Thu</label>
                    <label class="day-checkbox-label checked" id="lbl_day_0_F"><input type="checkbox" name="timing_blocks[0][days][]" value="F" checked onchange="toggleDayLabel(this)"> Fri</label>
                    <label class="day-checkbox-label" id="lbl_day_0_SA"><input type="checkbox" name="timing_blocks[0][days][]" value="SA" onchange="toggleDayLabel(this)"> Sat</label>
                    <label class="day-checkbox-label" id="lbl_day_0_S"><input type="checkbox" name="timing_blocks[0][days][]" value="S" onchange="toggleDayLabel(this)"> Sun</label>
                  </div>
                </div>

                <!-- Sessions / Slots for Block 0 -->
                <div style="margin-bottom: 10px;">
                  <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Time Slots / Sessions for these Days:</label>
                  <div id="sessions_wrapper_0">
                    <!-- Session Row 0 -->
                    <div class="session-row" id="session_row_0_0">
                      <div style="flex: 1; min-width: 140px;">
                        <label style="font-size: 11px; margin-bottom: 3px;">From Time</label>
                        <input type="time" name="timing_blocks[0][sessions][0][from_timing]" class="form-control input-sm" value="09:00" required>
                      </div>
                      <div style="flex: 1; min-width: 140px;">
                        <label style="font-size: 11px; margin-bottom: 3px;">To Time</label>
                        <input type="time" name="timing_blocks[0][sessions][0][to_timing]" class="form-control input-sm" value="13:00" required>
                      </div>
                      <div style="flex: 1; min-width: 120px;">
                        <label style="font-size: 11px; margin-bottom: 3px;">Max Patients</label>
                        <input type="number" name="timing_blocks[0][sessions][0][max_patient]" class="form-control input-sm" value="20" min="1">
                      </div>
                      <div style="flex: 1; min-width: 130px;">
                        <label style="font-size: 11px; margin-bottom: 3px;">Slot Fee (&#8377; Optional)</label>
                        <input type="number" name="timing_blocks[0][sessions][0][fee]" class="form-control input-sm" placeholder="Base fee">
                      </div>
                      <div style="padding-top: 18px;">
                        <button type="button" class="btn btn-sm btn-default" style="color: #94a3b8;" disabled title="Primary session cannot be removed"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-xs btn-default" onclick="addSessionRow(0)" style="font-weight: 600; border-radius: 4px; color: #00a896; border-color: #00a896; margin-top: 4px;">
                    <i class="fa fa-plus"></i> Add Another Time Slot to this Block (e.g. Evening 17:00 - 20:00)
                  </button>
                </div>

              </div>

            </div>

            <!-- Add Remaining Days Button Link -->
            <div style="margin-top: 10px; display: flex; align-items: center; justify-content: flex-end;">
              <button type="button" class="btn btn-sm btn-info" onclick="addRemainingDaysBlock()" style="font-weight: 600; border-radius: 6px; background: #0284c7; border-color: #0284c7;">
                <i class="fa fa-plus-circle"></i> Add Remaining Days with Different Time Slots
              </button>
            </div>
          </div>

          <!-- Submit Button Toolbar -->
          <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <button type="submit" name="submit_assign" value="1" class="btn btn-save-assign">
              <i class="fa fa-check-circle"></i> Save Doctor Affiliation &amp; Timings
            </button>
            <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600; padding: 11px 20px;">
              <i class="fa fa-list" style="margin-right: 4px;"></i> View Practice Directory
            </a>
          </div>

        </form>
      </div>

      <!-- Recent Affiliations Card -->
      <div class="assign-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 16px 20px; background: #ffffff; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <div style="display: flex; align-items: center; gap: 12px;">
            <div style="font-weight: 700; font-size: 15px; color: #1e293b;">
              <i class="fa fa-history" style="color: #00a896; margin-right: 6px;"></i> Active Doctor Affiliations &amp; Schedule Directory
            </div>
            <span class="badge" style="background: #e2e8f0; color: #334155; font-size: 11.5px;"><?=count(@$recent_affiliations ?: array());?> Affiliations</span>
          </div>
          <div style="display: flex; gap: 8px; align-items: center;">
            <input type="text" id="filter_affiliations_input" placeholder="Filter affiliations table..." class="form-control input-sm" style="width: 220px; height: 32px; font-size: 12px;" onkeyup="filterAffiliationsTable()">
            <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 4px;">
              Full Directory <i class="fa fa-arrow-right" style="margin-left: 4px;"></i>
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-affiliations" id="affiliations_table">
            <thead>
              <tr>
                <th style="width: 60px;">ID</th>
                <th>Doctor Details</th>
                <th>Facility &amp; City</th>
                <th style="width: 110px;">Type</th>
                <th style="width: 110px;">Fee</th>
                <th>Configured Timings &amp; Sessions</th>
                <th style="width: 130px; text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($recent_affiliations)): ?>
                <?php foreach ($recent_affiliations as $aff): ?>
                  <?php 
                    $doc_name = trim($aff['fname'].' '.$aff['lname']);
                    $facility_name = ($aff['type'] === 'C') ? ($aff['clinic_name'] ?: 'Clinic #'.$aff['institution_id']) : ($aff['hosp_name'] ?: 'Hospital #'.$aff['institution_id']);
                    $facility_city = ($aff['type'] === 'C') ? $aff['clinic_city'] : $aff['hosp_city'];
                  ?>
                  <tr class="aff-row">
                    <td style="color: #64748b; font-weight: 600;">#<?=$aff['id'];?></td>
                    <td class="aff-doc-col">
                      <div style="font-weight: 700; color: #0f172a;">
                        <i class="fa fa-user-md text-primary" style="margin-right: 4px;"></i>
                        Dr. <?=htmlspecialchars($doc_name ?: 'Unnamed Doctor');?>
                      </div>
                      <div style="font-size: 12px; color: #64748b;">
                        <?=!empty($aff['speciality']) ? '<span style="color: #00a896; font-weight: 600;">'.htmlspecialchars($aff['speciality']).'</span> &bull; ' : '';?>
                        Tel: <?=htmlspecialchars($aff['doc_mobile'] ?: 'N/A');?>
                      </div>
                    </td>
                    <td class="aff-fac-col">
                      <div style="font-weight: 600; color: #334155;">
                        <?=htmlspecialchars($facility_name);?>
                      </div>
                      <?php if (!empty($facility_city)): ?>
                        <div style="font-size: 12px; color: #64748b;">
                          <i class="fa fa-map-marker text-danger" style="margin-right: 3px;"></i> <?=htmlspecialchars($facility_city);?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($aff['type'] === 'C'): ?>
                        <span class="badge-clinic"><i class="fa fa-medkit"></i> Clinic</span>
                      <?php else: ?>
                        <span class="badge-hosp"><i class="fa fa-hospital-o"></i> Hospital</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                        &#8377;<?=number_format((float)$aff['fee'], 0);?>
                      </span>
                    </td>
                    <td>
                      <?php if (!empty($aff['timings'])): ?>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                          <?php foreach ($aff['timings'] as $tItem): ?>
                            <div style="font-size: 11.5px; background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 8px; border-radius: 4px;">
                              <strong style="color: #0f172a;"><?=htmlspecialchars($tItem['days']);?>:</strong>
                              <?php if (!empty($tItem['sessions'])): ?>
                                <?php foreach ($tItem['sessions'] as $sItem): ?>
                                  <span class="label label-info" style="font-size: 10px; font-weight: 600; margin-left: 4px;">
                                    <?=htmlspecialchars($sItem['from_timing']);?> - <?=htmlspecialchars($sItem['to_timing']);?>
                                  </span>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <span class="text-muted">No session slots</span>
                              <?php endif; ?>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <span style="color: #94a3b8; font-size: 12px;"><i class="fa fa-info-circle"></i> Standard OPD schedule</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                      <div style="display: flex; gap: 4px; justify-content: flex-end;">
                        <a href="<?=base_url('doctor/clinicreg/doctor_fee_time/'.$aff['id']);?>" 
                           class="btn btn-xs btn-default" 
                           title="Manage Timings &amp; Fee"
                           style="border-radius: 4px; padding: 4px 8px; font-weight: 600;">
                          <i class="fa fa-clock-o text-primary"></i> Timings
                        </a>
                        <a href="<?=base_url('doctor/clinicreg/delete_affiliation/'.$aff['id']);?>" 
                           class="btn btn-xs btn-danger" 
                           onclick="return confirm('Are you sure you want to unlink this doctor affiliation?');"
                           title="Unlink Affiliation"
                           style="border-radius: 4px; padding: 4px 8px;">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" style="text-align: center; color: #94a3b8; padding: 24px;">
                    No affiliations found. Use the form above to assign doctors to healthcare facilities.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
  let totalBlocks = 1;
  let sessionCounters = {0: 1};

  // Facility Type Switcher
  function toggleFacilityType(type) {
    if (type === 'C') {
      document.getElementById('hospital_wrapper').style.display = 'none';
      document.getElementById('clinic_wrapper').style.display = 'block';
      document.getElementById('hospital_id').removeAttribute('required');
      document.getElementById('clinic_id').setAttribute('required', 'required');
      document.getElementById('label_type_h').classList.remove('active');
      document.getElementById('label_type_c').classList.add('active');
    } else {
      document.getElementById('hospital_wrapper').style.display = 'block';
      document.getElementById('clinic_wrapper').style.display = 'none';
      document.getElementById('clinic_id').removeAttribute('required');
      document.getElementById('hospital_id').setAttribute('required', 'required');
      document.getElementById('label_type_c').classList.remove('active');
      document.getElementById('label_type_h').classList.add('active');
    }
  }

  function setFee(amount) {
    document.getElementById('fee').value = amount;
  }

  // Real-Time Doctor Search Filter
  function filterDoctorDropdown() {
    const filter = document.getElementById('doctor_quick_search').value.toLowerCase();
    const select = document.getElementById('doctor_id');
    const options = select.getElementsByTagName('option');
    let matchCount = 0;

    for (let i = 1; i < options.length; i++) {
      const txt = options[i].textContent.toLowerCase();
      if (txt.indexOf(filter) > -1) {
        options[i].style.display = "";
        matchCount++;
      } else {
        options[i].style.display = "none";
      }
    }
    const badge = document.getElementById('doc_count_badge');
    if (badge) {
      badge.textContent = filter ? matchCount + " Matched" : (options.length - 1) + " Doctors Available";
    }
  }

  function clearDoctorSearch() {
    document.getElementById('doctor_quick_search').value = "";
    filterDoctorDropdown();
  }

  // Doctor Selection Info Preview
  function onDoctorSelected() {
    const select = document.getElementById('doctor_id');
    const selected = select.options[select.selectedIndex];
    const card = document.getElementById('selected_doctor_card');
    
    if (selected && selected.value) {
      document.getElementById('sel_doc_name').textContent = selected.getAttribute('data-name');
      document.getElementById('sel_doc_spec').textContent = selected.getAttribute('data-speciality');
      document.getElementById('sel_doc_contact').textContent = 'Tel: ' + (selected.getAttribute('data-mobile') || 'N/A');
      document.getElementById('sel_doc_city').textContent = selected.getAttribute('data-city') || 'City: N/A';
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  }

  // Toggle Day Checkbox Label styling
  function toggleDayLabel(cb) {
    const label = cb.closest('label');
    if (label) {
      if (cb.checked) label.classList.add('checked');
      else label.classList.remove('checked');
    }
  }

  // Apply Day Preset to a Block
  function applyDayPreset(blockIndex, daysArray) {
    const allDays = ['M', 'T', 'W', 'TH', 'F', 'SA', 'S'];
    allDays.forEach(d => {
      const el = document.getElementById('lbl_day_' + blockIndex + '_' + d);
      if (el) {
        const input = el.querySelector('input');
        if (daysArray.includes(d)) {
          input.checked = true;
          el.classList.add('checked');
        } else {
          input.checked = false;
          el.classList.remove('checked');
        }
      }
    });
  }

  // Add Another Session Row to a Day Block
  function addSessionRow(blockIndex) {
    if (!sessionCounters[blockIndex]) sessionCounters[blockIndex] = 1;
    const sessIndex = sessionCounters[blockIndex]++;
    const wrapper = document.getElementById('sessions_wrapper_' + blockIndex);
    if (!wrapper) return;

    const row = document.createElement('div');
    row.className = 'session-row';
    row.id = 'session_row_' + blockIndex + '_' + sessIndex;
    row.innerHTML = `
      <div style="flex: 1; min-width: 140px;">
        <label style="font-size: 11px; margin-bottom: 3px;">From Time</label>
        <input type="time" name="timing_blocks[${blockIndex}][sessions][${sessIndex}][from_timing]" class="form-control input-sm" value="17:00" required>
      </div>
      <div style="flex: 1; min-width: 140px;">
        <label style="font-size: 11px; margin-bottom: 3px;">To Time</label>
        <input type="time" name="timing_blocks[${blockIndex}][sessions][${sessIndex}][to_timing]" class="form-control input-sm" value="20:00" required>
      </div>
      <div style="flex: 1; min-width: 120px;">
        <label style="font-size: 11px; margin-bottom: 3px;">Max Patients</label>
        <input type="number" name="timing_blocks[${blockIndex}][sessions][${sessIndex}][max_patient]" class="form-control input-sm" value="20" min="1">
      </div>
      <div style="flex: 1; min-width: 130px;">
        <label style="font-size: 11px; margin-bottom: 3px;">Slot Fee (&#8377; Optional)</label>
        <input type="number" name="timing_blocks[${blockIndex}][sessions][${sessIndex}][fee]" class="form-control input-sm" placeholder="Base fee">
      </div>
      <div style="padding-top: 18px;">
        <button type="button" class="btn btn-sm btn-danger" onclick="removeSessionRow(${blockIndex}, ${sessIndex})" title="Remove time slot"><i class="fa fa-trash"></i></button>
      </div>
    `;
    wrapper.appendChild(row);
  }

  function removeSessionRow(blockIndex, sessIndex) {
    const row = document.getElementById('session_row_' + blockIndex + '_' + sessIndex);
    if (row) row.remove();
  }

  // Add Remaining Days with Different Time Slots Block
  function addRemainingDaysBlock() {
    const blockIndex = totalBlocks++;
    sessionCounters[blockIndex] = 1;

    // Detect checked days in block 0
    const checkedDaysBlock0 = [];
    document.querySelectorAll('#days_wrapper_0 input[type="checkbox"]:checked').forEach(cb => {
      checkedDaysBlock0.push(cb.value);
    });

    const allDays = [
      {key: 'M', label: 'Mon'},
      {key: 'T', label: 'Tue'},
      {key: 'W', label: 'Wed'},
      {key: 'TH', label: 'Thu'},
      {key: 'F', label: 'Fri'},
      {key: 'SA', label: 'Sat'},
      {key: 'S', label: 'Sun'}
    ];

    let daysHtml = '';
    allDays.forEach(d => {
      const isRemaining = !checkedDaysBlock0.includes(d.key);
      const isChecked = isRemaining ? 'checked' : '';
      const isCheckedClass = isRemaining ? 'checked' : '';
      daysHtml += `
        <label class="day-checkbox-label ${isCheckedClass}" id="lbl_day_${blockIndex}_${d.key}">
          <input type="checkbox" name="timing_blocks[${blockIndex}][days][]" value="${d.key}" ${isChecked} onchange="toggleDayLabel(this)"> ${d.label}
        </label>
      `;
    });

    const blockCard = document.createElement('div');
    blockCard.className = 'timing-block-card';
    blockCard.id = 'timing_block_' + blockIndex;
    blockCard.style.borderLeftColor = '#0284c7';
    blockCard.innerHTML = `
      <div class="timing-block-header">
        <div>
          <span class="label label-info" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; background: #0284c7;">Schedule Block #${blockIndex + 1} (Remaining / Alternate Days)</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
          <span style="font-size: 11.5px; color: #64748b;">Presets:</span>
          <span class="day-preset-link" onclick="applyDayPreset(${blockIndex}, ['SA','S'])">Weekend (Sat-Sun)</span>
          <span class="day-preset-link" onclick="applyDayPreset(${blockIndex}, ['SA'])">Saturday Only</span>
          <span class="day-preset-link" onclick="applyDayPreset(${blockIndex}, ['S'])">Sunday Only</span>
          <button type="button" class="btn btn-xs btn-danger" onclick="removeTimingBlock(${blockIndex})" style="border-radius: 4px; margin-left: 8px;">
            <i class="fa fa-trash"></i> Remove Block
          </button>
        </div>
      </div>

      <div style="margin-bottom: 14px;">
        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Select Remaining Working Days:</label>
        <div id="days_wrapper_${blockIndex}" style="display: flex; flex-wrap: wrap;">
          ${daysHtml}
        </div>
      </div>

      <div style="margin-bottom: 10px;">
        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">Time Slots / Sessions for Remaining Days:</label>
        <div id="sessions_wrapper_${blockIndex}">
          <div class="session-row" id="session_row_${blockIndex}_0">
            <div style="flex: 1; min-width: 140px;">
              <label style="font-size: 11px; margin-bottom: 3px;">From Time</label>
              <input type="time" name="timing_blocks[${blockIndex}][sessions][0][from_timing]" class="form-control input-sm" value="10:00" required>
            </div>
            <div style="flex: 1; min-width: 140px;">
              <label style="font-size: 11px; margin-bottom: 3px;">To Time</label>
              <input type="time" name="timing_blocks[${blockIndex}][sessions][0][to_timing]" class="form-control input-sm" value="14:00" required>
            </div>
            <div style="flex: 1; min-width: 120px;">
              <label style="font-size: 11px; margin-bottom: 3px;">Max Patients</label>
              <input type="number" name="timing_blocks[${blockIndex}][sessions][0][max_patient]" class="form-control input-sm" value="20" min="1">
            </div>
            <div style="flex: 1; min-width: 130px;">
              <label style="font-size: 11px; margin-bottom: 3px;">Slot Fee (&#8377; Optional)</label>
              <input type="number" name="timing_blocks[${blockIndex}][sessions][0][fee]" class="form-control input-sm" placeholder="Base fee">
            </div>
            <div style="padding-top: 18px;">
              <button type="button" class="btn btn-sm btn-default" style="color: #94a3b8;" disabled><i class="fa fa-trash"></i></button>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-xs btn-default" onclick="addSessionRow(${blockIndex})" style="font-weight: 600; border-radius: 4px; color: #0284c7; border-color: #0284c7; margin-top: 4px;">
          <i class="fa fa-plus"></i> Add Another Time Slot to this Block
        </button>
      </div>
    `;

    document.getElementById('timing_blocks_container').appendChild(blockCard);
  }

  function removeTimingBlock(blockIndex) {
    const card = document.getElementById('timing_block_' + blockIndex);
    if (card) card.remove();
  }

  // Filter Affiliations Table
  function filterAffiliationsTable() {
    const filter = document.getElementById('filter_affiliations_input').value.toLowerCase();
    const rows = document.querySelectorAll('#affiliations_table tbody tr.aff-row');
    rows.forEach(r => {
      const docTxt = (r.querySelector('.aff-doc-col') ? r.querySelector('.aff-doc-col').textContent : '').toLowerCase();
      const facTxt = (r.querySelector('.aff-fac-col') ? r.querySelector('.aff-fac-col').textContent : '').toLowerCase();
      if (docTxt.indexOf(filter) > -1 || facTxt.indexOf(filter) > -1) {
        r.style.display = '';
      } else {
        r.style.display = 'none';
      }
    });
  }
</script>
