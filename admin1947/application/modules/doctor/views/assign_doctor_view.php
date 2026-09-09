<style>
  :root {
    --primary: #00a896;
    --primary-dark: #008f80;
    --primary-light: #ecfdf5;
    --navy: #0f172a;
    --slate: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg-card: #ffffff;
    --bg-page: #f8fafc;
  }

  .assign-container {
    padding: 15px 20px 40px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  .assign-card {
    background: var(--bg-card);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    border: 1px solid var(--border);
    padding: 26px;
    margin-bottom: 26px;
  }

  .form-section-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--slate);
    margin-bottom: 18px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
  }

  .form-group label {
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
  }

  .form-control {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    height: 40px;
    box-shadow: none;
    transition: all 0.2s;
    font-size: 13px;
  }

  .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
  }

  /* Unified Doctor Combobox (Search & List at Same Field) */
  .doctor-combobox-container {
    position: relative;
    width: 100%;
  }

  .doctor-combobox-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }

  .doctor-combobox-icon {
    position: absolute;
    left: 14px;
    font-size: 16px;
    color: var(--primary);
    pointer-events: none;
    z-index: 2;
  }

  .doctor-combobox-input {
    padding-left: 42px !important;
    padding-right: 70px !important;
    height: 44px !important;
    font-size: 13.5px !important;
    font-weight: 500;
    border-radius: 8px !important;
    background: #ffffff;
    cursor: text;
  }

  .doctor-combobox-actions {
    position: absolute;
    right: 8px;
    display: flex;
    align-items: center;
    gap: 4px;
    z-index: 2;
  }

  .combobox-btn {
    background: none;
    border: none;
    padding: 6px 8px;
    color: #94a3b8;
    cursor: pointer;
    font-size: 14px;
    border-radius: 4px;
    transition: all 0.15s;
  }

  .combobox-btn:hover {
    color: var(--slate);
    background: #f1f5f9;
  }

  .combobox-clear-btn {
    color: #ef4444 !important;
    font-size: 16px;
    line-height: 1;
  }

  /* Floating Dropdown under the same field */
  .doctor-combobox-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    overflow: hidden;
    display: none;
    animation: fadeInSlide 0.15s ease-out;
  }

  @keyframes fadeInSlide {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .dropdown-header-bar {
    padding: 10px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
  }

  .dropdown-items-list {
    max-height: 280px;
    overflow-y: auto;
    padding: 4px 0;
    -webkit-overflow-scrolling: touch;
  }

  .doctor-option-item {
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    cursor: pointer;
    transition: background 0.15s;
    border-bottom: 1px solid #f8fafc;
  }

  .doctor-option-item:last-child {
    border-bottom: none;
  }

  .doctor-option-item:hover,
  .doctor-option-item.active-item {
    background: #f0fdfa;
  }

  .doc-avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e0f2fe;
    color: #0284c7;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .doc-name-text {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--slate);
  }

  .doc-meta-text {
    font-size: 12px;
    color: var(--muted);
    margin-top: 2px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .doctor-option-item:hover .doc-name-text {
    color: var(--primary);
  }

  /* Selected Doctor Intelligence Dossier Card */
  .selected-doctor-dossier {
    margin-top: 14px;
    background: #f0fdfa;
    border: 1px solid #99f6e4;
    border-radius: 10px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    animation: fadeInSlide 0.2s ease-out;
  }

  /* Facility Radio Labels */
  .facility-type-toggle {
    display: flex;
    gap: 10px;
  }

  .facility-radio-label {
    flex: 1;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 10px 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    background: #f8fafc;
    transition: all 0.2s;
    user-select: none;
    margin: 0;
  }

  .facility-radio-label.active-hosp {
    background: #ecfdf5;
    border-color: #10b981;
    color: #047857;
    box-shadow: 0 1px 3px rgba(16, 185, 129, 0.15);
  }

  .facility-radio-label.active-clinic {
    background: #fffbeb;
    border-color: #f59e0b;
    color: #b45309;
    box-shadow: 0 1px 3px rgba(245, 158, 11, 0.15);
  }

  .facility-radio-label input {
    display: none;
  }

  /* Fee Presets */
  .fee-preset-btn {
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s;
    margin-right: 4px;
    margin-bottom: 4px;
  }

  .fee-preset-btn:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
  }

  /* Timings Builder Styles */
  .timing-block-card {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-left: 4px solid var(--primary);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 18px;
    transition: all 0.2s;
  }

  .timing-block-card.block-secondary {
    border-left-color: #0284c7;
    background: #f0f9ff;
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
    gap: 6px;
    padding: 6px 14px;
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

  .day-checkbox-label input {
    accent-color: var(--primary);
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
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }

  .btn-save-assign {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
    font-weight: 700;
    padding: 12px 32px;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 168, 150, 0.2);
  }

  .btn-save-assign:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    color: #ffffff;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .assign-card {
      padding: 18px 14px;
    }
    .session-row > div {
      flex: 1 1 100% !important;
    }
    .doctor-combobox-input {
      font-size: 13px !important;
    }
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

      <!-- Quick Metrics Strip -->
      <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-4 col-sm-6" style="margin-bottom: 10px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px;">
              <i class="fa fa-user-md"></i>
            </div>
            <div>
              <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">Available Specialists</div>
              <div style="font-size: 18px; font-weight: 800; color: #0f172a;"><?=number_format(count($doctors));?> Doctors</div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6" style="margin-bottom: 10px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 8px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 18px;">
              <i class="fa fa-hospital-o"></i>
            </div>
            <div>
              <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">Medical Facilities</div>
              <div style="font-size: 18px; font-weight: 800; color: #0f172a;"><?=number_format(count($hospitals));?> Hospitals &bull; <?=number_format(count($clinics));?> Clinics</div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12" style="margin-bottom: 10px;">
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 8px; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 18px;">
              <i class="fa fa-clock-o"></i>
            </div>
            <div>
              <div style="font-size: 11.5px; color: #64748b; font-weight: 600; text-transform: uppercase;">OPD Scheduling Engine</div>
              <div style="font-size: 18px; font-weight: 800; color: #0f172a;">Multi-Session / Remaining Days</div>
            </div>
          </div>
        </div>
      </div>

      <!-- MAIN FORM CARD -->
      <div class="assign-card">
        <div class="form-section-title">
          <span><i class="fa fa-stethoscope" style="color: #00a896; margin-right: 6px;"></i> Affiliation &amp; Timing Configuration Form</span>
          <span style="font-size: 12px; font-weight: 600; color: #64748b;">Step-by-Step Assignment</span>
        </div>

        <form action="<?=base_url('doctor/clinicreg/assign_doctor');?>" method="post" id="assignDoctorForm" onsubmit="return validateAssignForm();">
          
          <!-- STEP 1: DOCTOR SEARCH & LIST AT SAME FIELD -->
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 22px;">
            <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
              <span>
                <i class="fa fa-user-md" style="color: #00a896; margin-right: 6px;"></i> Step 1: Search &amp; Select Doctor <span class="text-danger">*</span>
              </span>
              <div class="doctor-verif-filters" style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Filter:</span>
                <button type="button" class="btn btn-xs doc-filter-pill active" id="pill-all" onclick="setDoctorFilter('all', this)" style="border-radius: 20px; font-weight: 600; padding: 3px 10px; background: #0f172a; color: white; border: 1px solid #0f172a;">
                  All (<span id="count-all-pills"><?=number_format(count($doctors));?></span>)
                </button>
                <button type="button" class="btn btn-xs doc-filter-pill" id="pill-verified" onclick="setDoctorFilter('verified', this)" style="border-radius: 20px; font-weight: 600; padding: 3px 10px; background: #ffffff; color: #059669; border: 1px solid #a7f3d0;" title="Show only verified medical specialists">
                  <i class="fa fa-check-circle text-success"></i> Verified (<span id="count-verified-pills">--</span>)
                </button>
                <button type="button" class="btn btn-xs doc-filter-pill" id="pill-unverified" onclick="setDoctorFilter('unverified', this)" style="border-radius: 20px; font-weight: 600; padding: 3px 10px; background: #ffffff; color: #b45309; border: 1px solid #fde68a;" title="Show unverified or pending verification doctors">
                  <i class="fa fa-clock-o text-warning"></i> Unverified (<span id="count-unverified-pills">--</span>)
                </button>
              </div>
            </div>

            <!-- UNIFIED COMBOBOX FIELD: SEARCH & LIST AT SAME FIELD -->
            <div class="doctor-combobox-container" id="doctorCombobox">
              <div class="doctor-combobox-input-wrap">
                <span class="doctor-combobox-icon"><i class="fa fa-search"></i></span>
                <input type="text" 
                       id="doctor_combobox_input" 
                       class="form-control doctor-combobox-input" 
                       placeholder="Click or type to search doctor by name, speciality, mobile, or city..." 
                       autocomplete="off" 
                       required>
                <input type="hidden" name="doctor_id" id="doctor_id" value="" required>

                <div class="doctor-combobox-actions">
                  <button type="button" class="combobox-btn combobox-clear-btn" id="comboboxClearBtn" style="display: none;" title="Clear selected doctor">
                    <i class="fa fa-times"></i>
                  </button>
                  <button type="button" class="combobox-btn" id="comboboxToggleBtn" title="Toggle doctor list">
                    <i class="fa fa-chevron-down"></i>
                  </button>
                </div>
              </div>

              <!-- FLOATING DROPDOWN MENU DIRECTLY UNDERNEATH SAME FIELD -->
              <div class="doctor-combobox-dropdown" id="doctorComboboxDropdown">
                <div class="dropdown-header-bar">
                  <span id="comboboxStatusText">Showing doctors</span>
                  <small style="color: #94a3b8;"><i class="fa fa-keyboard-o"></i> Use &uarr; &darr; to navigate, Enter to select</small>
                </div>
                <div class="dropdown-items-list" id="doctorItemsList">
                  <!-- Dynamic items populated by JS -->
                </div>
              </div>
            </div>

            <!-- Selected Doctor Dossier Confirmation Box -->
            <div id="selectedDoctorDossier" class="selected-doctor-dossier" style="display: none;">
              <div style="display: flex; align-items: center; gap: 14px; flex-grow: 1;">
                <div class="doc-avatar-circle" id="dossierAvatar" style="width: 48px; height: 48px; font-size: 16px; background: #00a896; color: #ffffff;">
                  DR
                </div>
                <div>
                  <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <strong style="font-size: 15px; color: #0f172a;" id="dossierName">Dr. Name</strong>
                    <span class="label label-success" id="dossierSpec" style="font-size: 11px; padding: 3px 8px; border-radius: 4px;">Speciality</span>
                    <span class="label label-primary" style="font-size: 10px; padding: 2px 6px; border-radius: 4px;">#ID: <span id="dossierId">0</span></span>
                  </div>
                  <div style="font-size: 12.5px; color: #475569; margin-top: 4px;">
                    <span id="dossierMobile"><i class="fa fa-phone text-muted"></i> </span> &bull; 
                    <span id="dossierCity"><i class="fa fa-map-marker text-muted"></i> </span> &bull; 
                    <span id="dossierEmail"><i class="fa fa-envelope-o text-muted"></i> </span>
                  </div>
                </div>
              </div>

              <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="btn btn-xs btn-default" onclick="reopenDoctorCombobox()" style="border-radius: 6px; font-weight: 600; padding: 6px 12px;">
                  <i class="fa fa-exchange text-primary"></i> Change Doctor
                </button>
              </div>
            </div>

          </div>

          <!-- STEP 2: HEALTHCARE FACILITY & BASE FEE -->
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 22px;">
            <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 16px;">
              <i class="fa fa-building-o" style="color: #00a896; margin-right: 6px;"></i> Step 2: Healthcare Facility &amp; Base Consultation Charge
            </div>

            <div class="row">
              <!-- Facility Type Selector (Hospital vs Clinic) -->
              <div class="col-md-4 col-xs-12" style="margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <label><i class="fa fa-tags text-primary" style="margin-right: 4px;"></i> Facility Type <span class="text-danger">*</span></label>
                  <div class="facility-type-toggle">
                    <label class="facility-radio-label active-hosp" id="label_type_h">
                      <input type="radio" name="type" value="H" checked onchange="toggleFacilityType('H')">
                      <i class="fa fa-hospital-o text-success" style="font-size: 16px;"></i> Hospital
                    </label>
                    <label class="facility-radio-label" id="label_type_c">
                      <input type="radio" name="type" value="C" onchange="toggleFacilityType('C')">
                      <i class="fa fa-medkit text-warning" style="font-size: 16px;"></i> Clinic
                    </label>
                  </div>
                </div>
              </div>

              <!-- Hospital Selection Combobox & Verification Filter -->
              <div class="col-md-4 col-xs-12" id="hospital_wrapper" style="margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 4px; margin-bottom: 6px;">
                    <label style="font-weight: 700; color: #1e293b; font-size: 13px; margin: 0;">
                      <i class="fa fa-hospital-o text-success" style="margin-right: 4px;"></i> Select Hospital <span class="text-danger">*</span>
                    </label>
                    <!-- Hospital Verification Filter Pills -->
                    <div class="hospital-filter-pills" style="display: flex; gap: 4px; align-items: center;">
                      <span style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Filter:</span>
                      <button type="button" class="btn btn-xs hosp-filter-pill active" id="hosp-pill-all" onclick="setHospitalFilter('all', this)" style="border-radius: 20px; font-weight: 600; padding: 2px 8px; background: #0f172a; color: white; border: 1px solid #0f172a;">
                        All (<span id="count-hosp-all"><?=count($hospitals);?></span>)
                      </button>
                      <button type="button" class="btn btn-xs hosp-filter-pill" id="hosp-pill-verified" onclick="setHospitalFilter('verified', this)" style="border-radius: 20px; font-weight: 600; padding: 2px 8px; background: #ffffff; color: #059669; border: 1px solid #a7f3d0;" title="Show verified hospitals only">
                        <i class="fa fa-check-circle text-success"></i> Verified (<span id="count-hosp-verified">--</span>)
                      </button>
                      <button type="button" class="btn btn-xs hosp-filter-pill" id="hosp-pill-unverified" onclick="setHospitalFilter('unverified', this)" style="border-radius: 20px; font-weight: 600; padding: 2px 8px; background: #ffffff; color: #b45309; border: 1px solid #fde68a;" title="Show unverified or pending verification hospitals">
                        <i class="fa fa-clock-o text-warning"></i> Unverified (<span id="count-hosp-unverified">--</span>)
                      </button>
                    </div>
                  </div>

                  <!-- Unified Hospital Combobox Container -->
                  <div class="doctor-combobox-container" id="hospitalCombobox" style="position: relative;">
                    <div class="doctor-combobox-input-wrap">
                      <span class="doctor-combobox-icon"><i class="fa fa-search"></i></span>
                      <input type="text" 
                             id="hospital_combobox_input" 
                             class="form-control doctor-combobox-input" 
                             placeholder="Click or type to search hospital by name, city, or ID..." 
                             autocomplete="off">
                      <input type="hidden" name="hospital_id" id="hospital_id" value="" required>

                      <div class="doctor-combobox-actions">
                        <button type="button" class="combobox-btn" id="hospComboboxClearBtn" style="display: none; color: #94a3b8; background: none; border: none; cursor: pointer; padding: 4px;" onclick="clearSelectedHospital()" title="Clear selected hospital">
                          <i class="fa fa-times-circle"></i>
                        </button>
                        <button type="button" class="combobox-btn" id="hospComboboxToggleBtn" style="color: #64748b; background: none; border: none; cursor: pointer; padding: 4px;" title="Toggle hospital list">
                          <i class="fa fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>

                    <!-- Floating Autocomplete Dropdown List for Hospitals -->
                    <div id="hospitalComboboxDropdown" class="doctor-combobox-dropdown" style="display: none;">
                      <div class="combobox-search-status" id="hospComboboxStatusText">
                        Showing hospitals (type to filter)...
                      </div>
                      <div class="doctor-items-list" id="hospitalItemsList">
                        <!-- Populated via JS -->
                      </div>
                    </div>
                  </div>

                  <!-- Selected Hospital Confirmation Card -->
                  <div id="selectedHospitalCard" style="display: none; margin-top: 8px; background: #f8fafc; border: 1.5px solid #00a896; border-radius: 8px; padding: 10px 14px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                      <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                        <div style="width: 34px; height: 34px; border-radius: 50%; background: #00a896; color: white; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">
                          <i class="fa fa-hospital-o"></i>
                        </div>
                        <div style="min-width: 0;">
                          <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                            <strong style="font-size: 13.5px; color: #0f172a;" id="selectedHospName">Hospital Name</strong>
                            <span id="selectedHospVerifBadge" class="badge" style="background: #10b981; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px;"><i class="fa fa-check-circle"></i> Verified</span>
                            <span style="font-size: 11px; color: #64748b;">ID: #<span id="selectedHospId">--</span></span>
                          </div>
                          <div style="font-size: 11.5px; color: #64748b; margin-top: 1px;" id="selectedHospCity">
                            <i class="fa fa-map-marker text-muted"></i> City
                          </div>
                        </div>
                      </div>
                      <button type="button" class="btn btn-xs btn-default" onclick="changeSelectedHospital()" style="border-radius: 4px; font-weight: 600; padding: 3px 8px;">
                        <i class="fa fa-pencil text-primary"></i> Change
                      </button>
                    </div>
                    <div id="selectedHospUnverNotice" class="alert alert-warning" style="display: none; margin-top: 8px; margin-bottom: 0; padding: 6px 10px; font-size: 11.5px; border-radius: 6px; background: #fffbeb; border: 1px solid #fde68a; color: #92400e;">
                      <i class="fa fa-info-circle"></i> <strong>Notice:</strong> This hospital's profile verification is currently pending. Doctor affiliation &amp; OPD timings can still be configured and assigned by the admin.
                    </div>
                  </div>
                </div>
              </div>

              <!-- Clinic Dropdown -->
              <div class="col-md-4 col-xs-12" id="clinic_wrapper" style="display: none; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                  <label for="clinic_id">
                    <i class="fa fa-medkit text-warning" style="margin-right: 4px;"></i> Select Clinic <span class="text-danger">*</span>
                  </label>
                  <select name="clinic_id" id="clinic_id" class="form-control" style="width: 100%;">
                    <option value="">-- Choose Clinic (<?=count($clinics);?> available) --</option>
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
                    <button type="button" class="fee-preset-btn" onclick="setFee(1500)">&#8377;1500</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- STEP 3: MULTI-SESSION OPD TIMINGS & REMAINING DAYS SCHEDULER -->
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
              <div>
                <div style="font-size: 14px; font-weight: 700; color: #1e293b;">
                  <i class="fa fa-clock-o" style="color: #00a896; margin-right: 6px;"></i> Step 3: OPD Working Days &amp; Multi-Session Timings
                </div>
                <small style="color: #64748b; font-size: 12.5px;">Configure multiple sessions per day (e.g. Morning &amp; Evening), and add separate time slots for remaining days (e.g. Weekends)</small>
              </div>
              <div>
                <button type="button" class="btn btn-sm btn-info" onclick="addRemainingDaysBlock()" style="font-weight: 600; border-radius: 8px; background: #0284c7; border-color: #0284c7; padding: 7px 14px;">
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
                    <span class="label label-primary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; background: #00a896;">
                      Schedule Block #1 (Primary Days)
                    </span>
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
                  <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">
                    Select Working Days for this Slot:
                  </label>
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
                  <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">
                    Time Slots / Sessions for these Days:
                  </label>
                  <div id="sessions_wrapper_0">
                    <!-- Session Row 0 -->
                    <div class="session-row" id="session_row_0_0">
                      <div style="flex: 1; min-width: 140px;">
                        <label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">From Time</label>
                        <input type="time" name="timing_blocks[0][sessions][0][from_timing]" class="form-control input-sm" value="09:00" required>
                      </div>
                      <div style="flex: 1; min-width: 140px;">
                        <label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">To Time</label>
                        <input type="time" name="timing_blocks[0][sessions][0][to_timing]" class="form-control input-sm" value="13:00" required>
                      </div>
                      <div style="flex: 1; min-width: 120px;">
                        <label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">Max Patients</label>
                        <input type="number" name="timing_blocks[0][sessions][0][max_patient]" class="form-control input-sm" value="20" min="1">
                      </div>
                      <div style="flex: 1; min-width: 130px;">
                        <label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">Slot Fee (&#8377; Optional)</label>
                        <input type="number" name="timing_blocks[0][sessions][0][fee]" class="form-control input-sm" placeholder="Base fee">
                      </div>
                      <div style="padding-top: 18px;">
                        <button type="button" class="btn btn-sm btn-default" onclick="removeSessionRow(0, 0)" title="Delete session" style="color: #94a3b8; border-radius: 6px;">
                          <i class="fa fa-trash-o"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <div style="margin-top: 10px;">
                    <button type="button" class="btn btn-xs btn-default" onclick="addSessionRow(0)" style="font-weight: 600; border-radius: 6px; color: #00a896; border-color: #99f6e4; background: #f0fdfa; padding: 6px 12px;">
                      <i class="fa fa-plus"></i> Add Another Session (e.g. Evening Shift)
                    </button>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <!-- FORM ACTIONS -->
          <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid #e2e8f0; flex-wrap: wrap; gap: 10px;">
            <button type="reset" class="btn btn-default" onclick="resetForm()" style="border-radius: 8px; font-weight: 600; padding: 10px 20px;">
              <i class="fa fa-refresh"></i> Reset Form
            </button>
            <button type="submit" name="submit_assign" value="1" class="btn btn-save-assign" id="submitBtn">
              <i class="fa fa-check-circle"></i> Save &amp; Affiliate Doctor to Facility
            </button>
          </div>

        </form>
      </div>

      <!-- RECENT AFFILIATIONS DIRECTORY TABLE -->
      <div class="assign-card" style="padding: 22px;">
        <div class="form-section-title">
          <span><i class="fa fa-history" style="color: #00a896; margin-right: 6px;"></i> Recently Affiliated Doctors &amp; OPD Timings</span>
          <span style="font-size: 12px; font-weight: 600; color: #64748b;">Showing Latest 25 Assignments</span>
        </div>

        <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 8px;">
          <table class="table table-hover table-striped" style="margin: 0; font-size: 13px;">
            <thead>
              <tr style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                <th style="padding: 12px 14px;">#ID</th>
                <th style="padding: 12px 14px;">Doctor</th>
                <th style="padding: 12px 14px;">Facility (Hospital / Clinic)</th>
                <th style="padding: 12px 14px;">Consultation Fee</th>
                <th style="padding: 12px 14px;">Configured OPD Timings</th>
                <th style="padding: 12px 14px; text-align: center;">Status</th>
                <th style="padding: 12px 14px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($recent_affiliations)): ?>
                <?php foreach ($recent_affiliations as $r): 
                  $facilityName = ($r['type'] === 'H') ? ($r['hosp_name'] ?: 'Hospital') : ($r['clinic_name'] ?: 'Clinic');
                  $facilityCity = ($r['type'] === 'H') ? $r['hosp_city'] : $r['clinic_city'];
                ?>
                  <tr>
                    <td style="padding: 12px 14px; font-weight: 600; color: #64748b;">#<?=$r['id'];?></td>
                    <td style="padding: 12px 14px;">
                      <strong style="color: #1e293b;">Dr. <?=htmlspecialchars(trim($r['fname'].' '.$r['lname']));?></strong>
                      <?php if ($r['verified'] == '1'): ?>
                        <span class="badge" style="background: #10b981; color: white; font-size: 9.5px; padding: 1px 5px; border-radius: 8px; margin-left: 4px;"><i class="fa fa-check-circle"></i> Verified</span>
                      <?php else: ?>
                        <span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 9.5px; padding: 1px 5px; border-radius: 8px; margin-left: 4px;"><i class="fa fa-clock-o"></i> Unverified</span>
                      <?php endif; ?>
                      <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                        <span class="label label-info" style="font-size: 10.5px;"><?=htmlspecialchars($r['speciality'] ?: 'General');?></span>
                        <?php if($r['doc_mobile']): ?><span style="margin-left: 4px;"><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($r['doc_mobile']);?></span><?php endif; ?>
                      </div>
                    </td>
                    <td style="padding: 12px 14px;">
                      <strong style="color: #334155;"><i class="fa fa-building-o text-muted"></i> <?=htmlspecialchars($facilityName);?></strong>
                      <?php 
                        $facVer = ($r['type'] === 'H') ? ($r['hosp_verified'] ?? '') : ($r['clinic_verified'] ?? ''); 
                        if ($facVer == '1'): ?>
                        <span class="badge" style="background: #10b981; color: white; font-size: 9.5px; padding: 1px 5px; border-radius: 8px; margin-left: 4px;"><i class="fa fa-check-circle"></i> Verified</span>
                      <?php else: ?>
                        <span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 9.5px; padding: 1px 5px; border-radius: 8px; margin-left: 4px;"><i class="fa fa-clock-o"></i> Unverified</span>
                      <?php endif; ?>
                      <?php if($facilityCity): ?>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;"><i class="fa fa-map-marker text-muted"></i> <?=htmlspecialchars($facilityCity);?></div>
                      <?php endif; ?>
                    </td>
                    <td style="padding: 12px 14px;">
                      <strong style="color: #0f172a; font-size: 13.5px;">&#8377;<?=number_format($r['fee'], 2);?></strong>
                    </td>
                    <td style="padding: 12px 14px;">
                      <?php if (!empty($r['timings'])): ?>
                        <?php foreach ($r['timings'] as $tItem): ?>
                          <div style="margin-bottom: 4px;">
                            <span class="label label-default" style="font-weight: 600; background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11px;">
                              <?=$tItem['days'];?>:
                            </span>
                            <?php if (!empty($tItem['sessions'])): ?>
                              <?php foreach ($tItem['sessions'] as $s): ?>
                                <span style="font-size: 12px; color: #475569; margin-left: 4px;">
                                  <?=htmlspecialchars($s['from_timing'].' - '.$s['to_timing']);?>
                                  <small class="text-muted">(Max: <?=$s['max_patient'];?>)</small>
                                </span>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <span style="font-size: 11.5px; color: #94a3b8;">Timings active</span>
                            <?php endif; ?>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span style="color: #94a3b8; font-size: 12px;">Standard OPD schedule</span>
                      <?php endif; ?>
                    </td>
                    <td style="padding: 12px 14px; text-align: center;">
                      <?php if ($r['status'] == '1'): ?>
                        <span class="label label-success" style="padding: 4px 8px; border-radius: 4px;"><i class="fa fa-check"></i> Active</span>
                      <?php else: ?>
                        <span class="label label-warning" style="padding: 4px 8px; border-radius: 4px;">Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td style="padding: 12px 14px; text-align: center;">
                      <a href="<?=base_url('doctor/clinicreg/doctor_fee_time/'.$r['id']);?>" class="btn btn-xs btn-default" style="border-radius: 4px; padding: 4px 8px;" title="Edit Fee &amp; Timings">
                        <i class="fa fa-clock-o text-info"></i> Manage Timings
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">
                    <i class="fa fa-calendar-times-o fa-2x" style="opacity: 0.4; margin-bottom: 6px; display: block;"></i>
                    No doctor affiliations found. Assign a doctor above to establish facility affiliation.
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

<!-- CLIENT-SIDE DOCTOR DATA FOR ZERO-LATENCY COMBOBOX -->
<script>
var ALL_HOSPITALS = <?=json_encode($hospitals, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);?>;
var ALL_DOCTORS = <?=json_encode($doctors, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);?>;
var blockCount = 1;

// Color palette for doctor avatar initials
var AVATAR_COLORS = ['#00a896', '#0284c7', '#7c3aed', '#d97706', '#059669', '#dc2626', '#4f46e5', '#0891b2'];
function getAvatarColor(name) {
  var hash = 0;
  for (var i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
  return AVATAR_COLORS[Math.abs(hash) % AVATAR_COLORS.length];
}

// Doctor Verification Filter State
var currentDoctorFilter = 'all'; // 'all', 'verified', 'unverified'

function setDoctorFilter(filterType, btn) {
  currentDoctorFilter = filterType;
  $('.doc-filter-pill').css({ 'background': '#ffffff', 'color': '#334155', 'border': '1px solid #cbd5e1' }).removeClass('active');
  if (filterType === 'all') {
    $(btn).css({ 'background': '#0f172a', 'color': 'white', 'border': '1px solid #0f172a' }).addClass('active');
  } else if (filterType === 'verified') {
    $(btn).css({ 'background': '#ecfdf5', 'color': '#059669', 'border': '1px solid #a7f3d0' }).addClass('active');
  } else if (filterType === 'unverified') {
    $(btn).css({ 'background': '#fffbeb', 'color': '#b45309', 'border': '1px solid #fde68a' }).addClass('active');
  }
  
  // Re-run filter on combobox
  var $input = $('#doctor_combobox_input');
  if ($('#doctorComboboxDropdown').is(':visible')) {
    renderDoctorItems($input.val());
  }
}

// -------------------------------------------------------------
// UNIFIED COMBOBOX ENGINE (SEARCH & LIST AT SAME FIELD)
// -------------------------------------------------------------
$(document).ready(function() {
  // Compute Doctor Verification Counts for Pills
  var totalVer = 0, totalUnver = 0;
  for (var k = 0; k < ALL_DOCTORS.length; k++) {
    if (ALL_DOCTORS[k].verified == '1') {
      totalVer++;
    } else {
      totalUnver++;
    }
  }
  $('#count-all-pills').text(ALL_DOCTORS.length.toLocaleString());
  $('#count-verified-pills').text(totalVer.toLocaleString());
  $('#count-unverified-pills').text(totalUnver.toLocaleString());

  // Compute Hospital Verification Counts for Filter Pills
  var numHospVer = 0, numHospUnver = 0;
  for (var m = 0; m < ALL_HOSPITALS.length; m++) {
    if (ALL_HOSPITALS[m].verified == '1') {
      numHospVer++;
    } else {
      numHospUnver++;
    }
  }
  $('#count-hosp-verified').text(numHospVer.toLocaleString());
  $('#count-hosp-unverified').text(numHospUnver.toLocaleString());

  // Wire Hospital Combobox Events
  var $hospInput = $('#hospital_combobox_input');
  var $hospDropdown = $('#hospitalComboboxDropdown');
  var $hospToggleBtn = $('#hospComboboxToggleBtn');

  $hospInput.on('focus click', function() {
    $hospDropdown.show();
    filterHospitals($(this).val());
  });

  $hospInput.on('input', function() {
    var val = $(this).val();
    if (val.length > 0) {
      $('#hospComboboxClearBtn').show();
    } else {
      $('#hospComboboxClearBtn').hide();
      $('#hospital_id').val('');
    }
    filterHospitals(val);
  });

  $hospToggleBtn.on('click', function(e) {
    e.stopPropagation();
    if ($hospDropdown.is(':visible')) {
      $hospDropdown.hide();
    } else {
      $hospDropdown.show();
      filterHospitals($hospInput.val());
      $hospInput.focus();
    }
  });

  // Keyboard navigation for hospitals
  $hospInput.on('keydown', function(e) {
    var $items = $('#hospitalItemsList .hosp-option-item');
    if (!$items.length || !$hospDropdown.is(':visible')) return;

    if (e.which === 40) { // ArrowDown
      e.preventDefault();
      activeHospIndex = (activeHospIndex + 1) % $items.length;
      $items.removeClass('active-item');
      $items.eq(activeHospIndex).addClass('active-item');
      $items.eq(activeHospIndex)[0].scrollIntoView({ block: 'nearest' });
    } else if (e.which === 38) { // ArrowUp
      e.preventDefault();
      activeHospIndex = (activeHospIndex - 1 + $items.length) % $items.length;
      $items.removeClass('active-item');
      $items.eq(activeHospIndex).addClass('active-item');
      $items.eq(activeHospIndex)[0].scrollIntoView({ block: 'nearest' });
    } else if (e.which === 13) { // Enter
      e.preventDefault();
      if (activeHospIndex >= 0 && activeHospIndex < $items.length) {
        $items.eq(activeHospIndex).trigger('click');
      }
    } else if (e.which === 27) { // Escape
      $hospDropdown.hide();
    }
  });

  // Close hospital dropdown on outside click
  $(document).on('click', function(e) {
    if (!$(e.target).closest('#hospitalCombobox').length) {
      $hospDropdown.hide();
    }
  });

  var $input = $('#doctor_combobox_input');
  var $hidden = $('#doctor_id');
  var $dropdown = $('#doctorComboboxDropdown');
  var $list = $('#doctorItemsList');
  var $clearBtn = $('#comboboxClearBtn');
  var $toggleBtn = $('#comboboxToggleBtn');
  var $statusText = $('#comboboxStatusText');
  var $dossier = $('#selectedDoctorDossier');

  var activeIndex = -1;
  var currentMatches = [];

  // Render list items based on filter
  function renderDoctorItems(query) {
    query = (query || '').toLowerCase().trim();
    $list.empty();
    activeIndex = -1;

    var matches = [];
    if (!query) {
      if (currentDoctorFilter === 'all') {
        matches = ALL_DOCTORS.slice(0, 40);
      } else {
        for (var k = 0; k < ALL_DOCTORS.length; k++) {
          var isV = (ALL_DOCTORS[k].verified == '1');
          if (currentDoctorFilter === 'verified' && isV) matches.push(ALL_DOCTORS[k]);
          if (currentDoctorFilter === 'unverified' && !isV) matches.push(ALL_DOCTORS[k]);
          if (matches.length >= 40) break;
        }
      }
      $statusText.text('Showing ' + matches.length + ' doctor(s) (' + currentDoctorFilter + ') - type to filter');
    } else {
      for (var i = 0; i < ALL_DOCTORS.length; i++) {
        var d = ALL_DOCTORS[i];
        var isV = (d.verified == '1');
        if (currentDoctorFilter === 'verified' && !isV) continue;
        if (currentDoctorFilter === 'unverified' && isV) continue;

        var name = (d.fname + ' ' + (d.lname || '')).toLowerCase();
        var spec = (d.speciality || '').toLowerCase();
        var mobile = (d.mobile || '').toLowerCase();
        var city = (d.city || '').toLowerCase();
        var id = String(d.id);

        if (name.indexOf(query) !== -1 || spec.indexOf(query) !== -1 || mobile.indexOf(query) !== -1 || city.indexOf(query) !== -1 || id === query) {
          matches.push(d);
          if (matches.length >= 60) break; // Limit rendered matches to 60 for 60fps rendering
        }
      }
      $statusText.text(matches.length === 0 ? 'No matching doctors found' : 'Found ' + matches.length + ' doctor(s)');
    }

    currentMatches = matches;

    if (matches.length === 0) {
      $list.html('<div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px;"><i class="fa fa-user-times fa-2x" style="opacity: 0.5; margin-bottom: 8px; display: block;"></i>No doctors found matching "<strong>' + htmlEscape(query) + '</strong>"</div>');
      return;
    }

    var html = '';
    for (var j = 0; j < matches.length; j++) {
      var doc = matches[j];
      var fullName = $.trim(doc.fname + ' ' + (doc.lname || ''));
      var initials = (doc.fname ? doc.fname.charAt(0) : 'D') + (doc.lname ? doc.lname.charAt(0) : '');
      var color = getAvatarColor(fullName);
      var spec = doc.speciality || 'General Practitioner';
      var cityStr = doc.city ? '<span style="margin-right: 6px;"><i class="fa fa-map-marker text-muted"></i> ' + htmlEscape(doc.city) + '</span>' : '';
      var mobileStr = doc.mobile ? '<span><i class="fa fa-phone text-muted"></i> ' + htmlEscape(doc.mobile) + '</span>' : '';

      var isVer = (doc.verified == '1');
      var vBadge = isVer 
        ? '<span class="badge" style="background: #10b981; color: white; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 10px; margin-left: 5px;"><i class="fa fa-check-circle"></i> Verified</span>'
        : '<span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 10px; margin-left: 5px;"><i class="fa fa-clock-o"></i> Unverified</span>';

      html += '<div class="doctor-option-item" data-index="' + j + '" data-id="' + doc.id + '">' +
        '<div style="display: flex; align-items: center; gap: 12px; flex-grow: 1;">' +
          '<div class="doc-avatar-circle" style="background: ' + color + '; color: #ffffff;">' + initials.toUpperCase() + '</div>' +
          '<div>' +
            '<div class="doc-name-text">Dr. ' + htmlEscape(fullName) + vBadge + ' <span class="label label-info" style="font-size: 10.5px; font-weight: 500; margin-left: 4px;">' + htmlEscape(spec) + '</span></div>' +
            '<div class="doc-meta-text">' + cityStr + mobileStr + '</div>' +
          '</div>' +
        '</div>' +
        '<div style="text-align: right; flex-shrink: 0;">' +
          '<span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 11px;">#ID: ' + doc.id + '</span>' +
        '</div>' +
      '</div>';
    }

    $list.html(html);
  }

  function htmlEscape(str) {
    if (!str) return '';
    return $('<div>').text(str).html();
  }

  function selectDoctor(doc) {
    var fullName = 'Dr. ' + $.trim(doc.fname + ' ' + (doc.lname || ''));
    var label = fullName + ' (' + (doc.speciality || 'General') + ')' + (doc.city ? ' - ' + doc.city : '');
    
    $input.val(label).addClass('selected-valid');
    $hidden.val(doc.id);
    $clearBtn.show();
    $dropdown.hide();

    // Populate and show Dossier Confirmation Card
    $('#dossierName').text(fullName);
    $('#dossierSpec').text(doc.speciality || 'General Practitioner');
    $('#dossierId').text(doc.id);
    
    var isVer = (doc.verified == '1');
    if (isVer) {
      $('#dossierVerifBadge').attr('class', 'badge').css({'background': '#10b981', 'color': '#ffffff', 'border': 'none'}).html('<i class="fa fa-check-circle"></i> Verified Doctor');
      $('#dossierUnverAlert').hide();
    } else {
      $('#dossierVerifBadge').attr('class', 'badge').css({'background': '#fef3c7', 'color': '#b45309', 'border': '1px solid #fde68a'}).html('<i class="fa fa-clock-o"></i> Unverified Doctor');
      $('#dossierUnverAlert').fadeIn();
    }
    $('#dossierMobile').html('<i class="fa fa-phone text-muted"></i> ' + (doc.mobile || 'N/A'));
    $('#dossierCity').html('<i class="fa fa-map-marker text-muted"></i> ' + (doc.city || 'Unspecified Location'));
    $('#dossierEmail').html('<i class="fa fa-envelope-o text-muted"></i> ' + (doc.email || 'N/A'));
    
    var initials = (doc.fname ? doc.fname.charAt(0) : 'D') + (doc.lname ? doc.lname.charAt(0) : '');
    $('#dossierAvatar').text(initials.toUpperCase()).css('background', getAvatarColor(fullName));

    $dossier.slideDown(200);
  }

  window.reopenDoctorCombobox = function() {
    $input.focus().select();
    renderDoctorItems($input.val());
    $dropdown.show();
  };

  function clearSelection() {
    $input.val('').removeClass('selected-valid');
    $hidden.val('');
    $clearBtn.hide();
    $dossier.slideUp(150);
    renderDoctorItems('');
  }

  // Events
  $input.on('focus click', function(e) {
    e.stopPropagation();
    if (!$dropdown.is(':visible')) {
      renderDoctorItems($input.val());
      $dropdown.show();
    }
  });

  $input.on('input keyup', function(e) {
    // If navigation keys, handle separately
    if (e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13 || e.keyCode === 27) {
      return;
    }
    $clearBtn.toggle($input.val().length > 0);
    $hidden.val(''); // Invalidate until clicked
    $dossier.slideUp(100);
    renderDoctorItems($input.val());
    $dropdown.show();
  });

  // Keyboard navigation
  $input.on('keydown', function(e) {
    var $items = $list.find('.doctor-option-item');
    if (!$dropdown.is(':visible') && (e.keyCode === 40 || e.keyCode === 38)) {
      renderDoctorItems($input.val());
      $dropdown.show();
      return;
    }

    if (e.keyCode === 40) { // Down
      e.preventDefault();
      activeIndex = Math.min(activeIndex + 1, $items.length - 1);
      highlightActiveItem($items);
    } else if (e.keyCode === 38) { // Up
      e.preventDefault();
      activeIndex = Math.max(activeIndex - 1, 0);
      highlightActiveItem($items);
    } else if (e.keyCode === 13) { // Enter
      e.preventDefault();
      if (activeIndex >= 0 && activeIndex < currentMatches.length) {
        selectDoctor(currentMatches[activeIndex]);
      } else if (currentMatches.length > 0) {
        selectDoctor(currentMatches[0]);
      }
    } else if (e.keyCode === 27) { // Esc
      $dropdown.hide();
    }
  });

  function highlightActiveItem($items) {
    $items.removeClass('active-item');
    if (activeIndex >= 0 && activeIndex < $items.length) {
      var $active = $items.eq(activeIndex).addClass('active-item');
      // Scroll into view
      var itemTop = $active.position().top;
      var listScroll = $list.scrollTop();
      if (itemTop < 0) {
        $list.scrollTop(listScroll + itemTop);
      } else if (itemTop + $active.outerHeight() > $list.height()) {
        $list.scrollTop(listScroll + itemTop + $active.outerHeight() - $list.height());
      }
    }
  }

  // Click on doctor item
  $(document).on('click', '.doctor-option-item', function(e) {
    e.stopPropagation();
    var idx = $(this).data('index');
    if (typeof currentMatches[idx] !== 'undefined') {
      selectDoctor(currentMatches[idx]);
    }
  });

  // Clear button click
  $clearBtn.on('click', function(e) {
    e.stopPropagation();
    clearSelection();
    $input.focus();
  });

  // Toggle button click
  $toggleBtn.on('click', function(e) {
    e.stopPropagation();
    if ($dropdown.is(':visible')) {
      $dropdown.hide();
    } else {
      $input.focus();
      renderDoctorItems($input.val());
      $dropdown.show();
    }
  });

  // Click outside to close dropdown
  $(document).on('click', function(e) {
    if (!$(e.target).closest('#doctorCombobox').length) {
      $dropdown.hide();
    }
  });
});

// -------------------------------------------------------------
// FACILITY SELECTION & BASE FEE
// -------------------------------------------------------------
function toggleFacilityType(type) {
  if (type === 'H') {
    $('#hospital_wrapper').show();
    $('#clinic_wrapper').hide();
    $('#hospital_id').prop('required', true);
    $('#clinic_id').prop('required', false).val('');
    $('#label_type_h').addClass('active-hosp');
    $('#label_type_c').removeClass('active-clinic');
  } else {
    $('#hospital_wrapper').hide();
    $('#clinic_wrapper').show();
    $('#hospital_id').prop('required', false).val('');
    $('#clinic_id').prop('required', true);
    $('#label_type_h').removeClass('active-hosp');
    $('#label_type_c').addClass('active-clinic');
  }
}

function setFee(amount) {
  $('#fee').val(amount);
}

// -------------------------------------------------------------
// TIMINGS BUILDER & REMAINING DAYS SCHEDULER
// -------------------------------------------------------------
function toggleDayLabel(checkbox) {
  var $lbl = $(checkbox).closest('.day-checkbox-label');
  if (checkbox.checked) {
    $lbl.addClass('checked');
  } else {
    $lbl.removeClass('checked');
  }
}

function applyDayPreset(blockIndex, daysArray) {
  $('#days_wrapper_' + blockIndex + ' input[type="checkbox"]').each(function() {
    var val = $(this).val();
    var shouldCheck = daysArray.indexOf(val) !== -1;
    $(this).prop('checked', shouldCheck);
    toggleDayLabel(this);
  });
}

function addSessionRow(blockIndex) {
  var wrapper = $('#sessions_wrapper_' + blockIndex);
  var sessionIndex = wrapper.children('.session-row').length;
  
  var newRow = '<div class="session-row" id="session_row_' + blockIndex + '_' + sessionIndex + '">' +
    '<div style="flex: 1; min-width: 140px;">' +
      '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">From Time</label>' +
      '<input type="time" name="timing_blocks[' + blockIndex + '][sessions][' + sessionIndex + '][from_timing]" class="form-control input-sm" value="17:00" required>' +
    '</div>' +
    '<div style="flex: 1; min-width: 140px;">' +
      '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">To Time</label>' +
      '<input type="time" name="timing_blocks[' + blockIndex + '][sessions][' + sessionIndex + '][to_timing]" class="form-control input-sm" value="20:00" required>' +
    '</div>' +
    '<div style="flex: 1; min-width: 120px;">' +
      '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">Max Patients</label>' +
      '<input type="number" name="timing_blocks[' + blockIndex + '][sessions][' + sessionIndex + '][max_patient]" class="form-control input-sm" value="15" min="1">' +
    '</div>' +
    '<div style="flex: 1; min-width: 130px;">' +
      '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">Slot Fee (&#8377; Optional)</label>' +
      '<input type="number" name="timing_blocks[' + blockIndex + '][sessions][' + sessionIndex + '][fee]" class="form-control input-sm" placeholder="Base fee">' +
    '</div>' +
    '<div style="padding-top: 18px;">' +
      '<button type="button" class="btn btn-sm btn-default" onclick="removeSessionRow(' + blockIndex + ', ' + sessionIndex + ')" title="Delete session" style="color: #ef4444; border-radius: 6px;">' +
        '<i class="fa fa-trash-o"></i>' +
      '</button>' +
    '</div>' +
  '</div>';

  wrapper.append(newRow);
}

function removeSessionRow(blockIndex, sessionIndex) {
  var wrapper = $('#sessions_wrapper_' + blockIndex);
  if (wrapper.children('.session-row').length <= 1) {
    alert('At least one time slot is required for this schedule block.');
    return;
  }
  $('#session_row_' + blockIndex + '_' + sessionIndex).remove();
}

function addRemainingDaysBlock() {
  // Check if Block 1 already exists
  if ($('#timing_block_1').length > 0) {
    alert('You have already added a secondary schedule block.');
    return;
  }

  // Find unselected days in Block 0
  var allDays = ['M', 'T', 'W', 'TH', 'F', 'SA', 'S'];
  var block0Selected = [];
  $('#days_wrapper_0 input[type="checkbox"]:checked').each(function() {
    block0Selected.push($(this).val());
  });

  var remainingDays = allDays.filter(function(d) {
    return block0Selected.indexOf(d) === -1;
  });

  if (remainingDays.length === 0) {
    remainingDays = ['SA', 'S']; // Default fallback if block 0 selected all
  }

  var dayLabels = {
    'M': 'Mon', 'T': 'Tue', 'W': 'Wed', 'TH': 'Thu', 'F': 'Fri', 'SA': 'Sat', 'S': 'Sun'
  };

  var daysHtml = '';
  allDays.forEach(function(d) {
    var isChecked = remainingDays.indexOf(d) !== -1;
    var cls = isChecked ? 'day-checkbox-label checked' : 'day-checkbox-label';
    var chkAttr = isChecked ? 'checked' : '';
    daysHtml += '<label class="' + cls + '" id="lbl_day_1_' + d + '"><input type="checkbox" name="timing_blocks[1][days][]" value="' + d + '" ' + chkAttr + ' onchange="toggleDayLabel(this)"> ' + dayLabels[d] + '</label> ';
  });

  var blockHtml = '<div class="timing-block-card block-secondary" id="timing_block_1">' +
    '<div class="timing-block-header">' +
      '<div>' +
        '<span class="label" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; background: #0284c7; color: #ffffff;">' +
          '<i class="fa fa-calendar"></i> Schedule Block #2 (Remaining Days / Alternate Timing)' +
        '</span>' +
      '</div>' +
      '<div>' +
        '<button type="button" class="btn btn-xs btn-danger" onclick="removeBlock(1)" style="border-radius: 4px; font-weight: 600;">' +
          '<i class="fa fa-times"></i> Remove Block #2' +
        '</button>' +
      '</div>' +
    '</div>' +

    '<div style="margin-bottom: 14px;">' +
      '<label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">' +
        'Select Working Days for this Second Slot:' +
      '</label>' +
      '<div id="days_wrapper_1" style="display: flex; flex-wrap: wrap;">' +
        daysHtml +
      '</div>' +
    '</div>' +

    '<div style="margin-bottom: 10px;">' +
      '<label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 6px; display: block;">' +
        'Time Slots / Sessions for these Remaining Days:' +
      '</label>' +
      '<div id="sessions_wrapper_1">' +
        '<div class="session-row" id="session_row_1_0">' +
          '<div style="flex: 1; min-width: 140px;">' +
            '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">From Time</label>' +
            '<input type="time" name="timing_blocks[1][sessions][0][from_timing]" class="form-control input-sm" value="10:00" required>' +
          '</div>' +
          '<div style="flex: 1; min-width: 140px;">' +
            '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">To Time</label>' +
            '<input type="time" name="timing_blocks[1][sessions][0][to_timing]" class="form-control input-sm" value="14:00" required>' +
          '</div>' +
          '<div style="flex: 1; min-width: 120px;">' +
            '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">Max Patients</label>' +
            '<input type="number" name="timing_blocks[1][sessions][0][max_patient]" class="form-control input-sm" value="15" min="1">' +
          '</div>' +
          '<div style="flex: 1; min-width: 130px;">' +
            '<label style="font-size: 11px; margin-bottom: 3px; font-weight: 600; color: #475569;">Slot Fee (&#8377; Optional)</label>' +
            '<input type="number" name="timing_blocks[1][sessions][0][fee]" class="form-control input-sm" placeholder="Base fee">' +
          '</div>' +
          '<div style="padding-top: 18px;">' +
            '<button type="button" class="btn btn-sm btn-default" onclick="removeSessionRow(1, 0)" title="Delete session" style="color: #94a3b8; border-radius: 6px;">' +
              '<i class="fa fa-trash-o"></i>' +
            '</button>' +
          '</div>' +
        '</div>' +
      '</div>' +

      '<div style="margin-top: 10px;">' +
        '<button type="button" class="btn btn-xs btn-default" onclick="addSessionRow(1)" style="font-weight: 600; border-radius: 6px; color: #0284c7; border-color: #bae6fd; background: #f0f9ff; padding: 6px 12px;">' +
          '<i class="fa fa-plus"></i> Add Another Session to Block #2' +
        '</button>' +
      '</div>' +
    '</div>' +

  '</div>';

  $('#timing_blocks_container').append(blockHtml);
  $('html, body').animate({ scrollTop: $('#timing_block_1').offset().top - 80 }, 300);
}

function removeBlock(blockIndex) {
  $('#timing_block_' + blockIndex).remove();
}

function resetForm() {
  $('#assignDoctorForm')[0].reset();
  $('#doctor_id').val('');
  $('#comboboxClearBtn').hide();
  $('#selectedDoctorDossier').slideUp();
  applyDayPreset(0, ['M', 'T', 'W', 'TH', 'F']);
  if ($('#timing_block_1').length > 0) {
    $('#timing_block_1').remove();
  }
}


// -------------------------------------------------------------
// HOSPITAL VERIFICATION FILTER & COMBOBOX ENGINE
// -------------------------------------------------------------
var currentHospitalFilter = 'all'; // 'all', 'verified', 'unverified'
var currentHospMatches = [];
var activeHospIndex = -1;

function setHospitalFilter(type, btn) {
  currentHospitalFilter = type;
  $('.hosp-filter-pill').css({ 'background': '#ffffff', 'color': '#334155', 'border': '1px solid #cbd5e1' }).removeClass('active');
  if (type === 'all') {
    $(btn).css({ 'background': '#0f172a', 'color': 'white', 'border': '1px solid #0f172a' }).addClass('active');
  } else if (type === 'verified') {
    $(btn).css({ 'background': '#ecfdf5', 'color': '#059669', 'border': '1px solid #a7f3d0' }).addClass('active');
  } else if (type === 'unverified') {
    $(btn).css({ 'background': '#fffbeb', 'color': '#b45309', 'border': '1px solid #fde68a' }).addClass('active');
  }
  
  if ($('#hospitalComboboxDropdown').is(':visible') || $('#hospital_combobox_input').val()) {
    filterHospitals($('#hospital_combobox_input').val());
  }
}

function filterHospitals(query) {
  var $dropdown = $('#hospitalComboboxDropdown');
  var $list = $('#hospitalItemsList');
  var $statusText = $('#hospComboboxStatusText');
  var q = $.trim(query || '').toLowerCase();
  var matches = [];

  if (!q) {
    if (currentHospitalFilter === 'all') {
      matches = ALL_HOSPITALS.slice(0, 40);
    } else {
      for (var i = 0; i < ALL_HOSPITALS.length; i++) {
        var isVer = (ALL_HOSPITALS[i].verified == '1');
        if (currentHospitalFilter === 'verified' && isVer) matches.push(ALL_HOSPITALS[i]);
        if (currentHospitalFilter === 'unverified' && !isVer) matches.push(ALL_HOSPITALS[i]);
        if (matches.length >= 40) break;
      }
    }
    $statusText.text('Showing ' + matches.length + ' hospital(s) (' + currentHospitalFilter + ') - type to filter');
  } else {
    for (var i = 0; i < ALL_HOSPITALS.length; i++) {
      var h = ALL_HOSPITALS[i];
      var isVer = (h.verified == '1');
      if (currentHospitalFilter === 'verified' && !isVer) continue;
      if (currentHospitalFilter === 'unverified' && isVer) continue;

      var name = (h.name || '').toLowerCase();
      var city = ((h.city_name || h.city || '') + '').toLowerCase();
      var addr = (h.address || '').toLowerCase();
      var idStr = String(h.id);

      if (name.indexOf(q) !== -1 || city.indexOf(q) !== -1 || addr.indexOf(q) !== -1 || idStr === q) {
        matches.push(h);
        if (matches.length >= 50) break;
      }
    }
    $statusText.text(matches.length === 0 ? 'No matching hospitals found' : 'Found ' + matches.length + ' hospital(s)');
  }

  currentHospMatches = matches;

  if (matches.length === 0) {
    $list.html('<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 13px;"><i class="fa fa-hospital-o fa-2x" style="opacity: 0.4; margin-bottom: 6px; display: block;"></i>No hospitals found matching "<strong>' + htmlEscape(query) + '</strong>"</div>');
    return;
  }

  var html = '';
  for (var j = 0; j < matches.length; j++) {
    var hosp = matches[j];
    var isVer = (hosp.verified == '1');
    var vBadge = isVer 
      ? '<span class="badge" style="background: #10b981; color: white; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 10px; margin-left: 5px;"><i class="fa fa-check-circle"></i> Verified</span>'
      : '<span class="badge" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 10px; margin-left: 5px;"><i class="fa fa-clock-o"></i> Unverified</span>';
    
    var cityLabel = hosp.city_name || (hosp.city ? 'City #' + hosp.city : '');
    var addrLabel = hosp.address ? '<span style="color: #94a3b8; font-size: 11px;"> &bull; ' + htmlEscape(hosp.address.substring(0, 35)) + '</span>' : '';

    html += '<div class="doctor-option-item hosp-option-item" data-index="' + j + '" onclick="selectHospitalFromList(' + j + ')">';
    html += '  <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1; min-width: 0;">';
    html += '    <div style="width: 32px; height: 32px; border-radius: 50%; background: #00a896; color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;"><i class="fa fa-hospital-o"></i></div>';
    html += '    <div style="min-width: 0;">';
    html += '      <div class="doc-name-text">' + htmlEscape(hosp.name) + vBadge + '</div>';
    html += '      <div class="doc-meta-text"><i class="fa fa-map-marker text-muted"></i> ' + htmlEscape(cityLabel) + addrLabel + '</div>';
    html += '    </div>';
    html += '  </div>';
    html += '  <div style="text-align: right; flex-shrink: 0;">';
    html += '    <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 10.5px;">#ID: ' + hosp.id + '</span>';
    html += '  </div>';
    html += '</div>';
  }

  $list.html(html);
  activeHospIndex = -1;
}

function selectHospitalFromList(index) {
  if (currentHospMatches && currentHospMatches[index]) {
    selectHospital(currentHospMatches[index]);
  }
}

function selectHospital(hosp) {
  var $input = $('#hospital_combobox_input');
  var $hidden = $('#hospital_id');
  var $dropdown = $('#hospitalComboboxDropdown');
  var $clearBtn = $('#hospComboboxClearBtn');

  var cityLabel = hosp.city_name || (hosp.city ? 'City #' + hosp.city : 'Varanasi');
  var display = hosp.name + ' (' + cityLabel + ')';

  $input.val(display).addClass('selected-valid');
  $hidden.val(hosp.id);
  $clearBtn.show();
  $dropdown.hide();

  // Populate selected hospital card
  $('#selectedHospName').text(hosp.name);
  $('#selectedHospId').text(hosp.id);
  $('#selectedHospCity').html('<i class="fa fa-map-marker text-muted"></i> ' + htmlEscape(cityLabel) + (hosp.address ? ' &bull; ' + htmlEscape(hosp.address) : ''));

  var isVer = (hosp.verified == '1');
  if (isVer) {
    $('#selectedHospVerifBadge').attr('class', 'badge').css({'background': '#10b981', 'color': '#ffffff', 'border': 'none'}).html('<i class="fa fa-check-circle"></i> Verified Hospital');
    $('#selectedHospUnverNotice').hide();
  } else {
    $('#selectedHospVerifBadge').attr('class', 'badge').css({'background': '#fef3c7', 'color': '#b45309', 'border': '1px solid #fde68a'}).html('<i class="fa fa-clock-o"></i> Unverified Hospital');
    $('#selectedHospUnverNotice').fadeIn();
  }

  $('#selectedHospitalCard').fadeIn(200);
}

function clearSelectedHospital() {
  var $input = $('#hospital_combobox_input');
  var $hidden = $('#hospital_id');
  var $clearBtn = $('#hospComboboxClearBtn');
  $input.val('').removeClass('selected-valid');
  $hidden.val('');
  $clearBtn.hide();
  $('#selectedHospitalCard').hide();
  filterHospitals('');
}

function changeSelectedHospital() {
  $('#selectedHospitalCard').hide();
  var $input = $('#hospital_combobox_input');
  $input.focus().select();
  $('#hospitalComboboxDropdown').show();
  filterHospitals($input.val());
}

function validateAssignForm() {
  var docId = $('#doctor_id').val();
  if (!docId) {
    alert('Please search and select a doctor from the list.');
    $('#doctor_combobox_input').focus();
    return false;
  }

  var facilityType = $('input[name="type"]:checked').val();
  if (facilityType === 'H' && !$('#hospital_id').val()) {
    alert('Please select a hospital.');
    $('#hospital_combobox_input').focus();
    return false;
  }
  if (facilityType === 'C' && !$('#clinic_id').val()) {
    alert('Please select a clinic.');
    $('#clinic_id').focus();
    return false;
  }

  var hasDays = false;
  $('input[name^="timing_blocks"][name$="[days][]"]:checked').each(function() {
    hasDays = true;
  });

  if (!hasDays) {
    alert('Please select at least one working day for the doctor.');
    return false;
  }

  // Show loading spinner on submit button
  $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving Affiliation & Timings...');
  return true;
}
</script>
