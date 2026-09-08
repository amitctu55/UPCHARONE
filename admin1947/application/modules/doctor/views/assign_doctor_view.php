<style>
  .assign-container {
    padding: 15px 20px;
  }
  .assign-card {
    background: #ffffff;
    border-radius: 10px;
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
    gap: 10px;
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
    height: 40px;
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
    font-weight: 600;
    padding: 10px 24px;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s;
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
  .table-affiliations {
    margin-bottom: 0;
  }
  .table-affiliations th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0 !important;
    padding: 12px 14px;
  }
  .table-affiliations td {
    padding: 12px 14px;
    vertical-align: middle !important;
    font-size: 13px;
    border-top: 1px solid #f1f5f9 !important;
  }
  .badge-hosp {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
  }
  .badge-clinic {
    background: #fef3c7;
    color: #92400e;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
  }
  .badge-active {
    background: #dcfce7;
    color: #15803d;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
  }
  .badge-inactive {
    background: #fee2e2;
    color: #b91c1c;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
  }
</style>

<!-- Select2 CSS for high-performance searchable selects -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<style>
  .select2-container .select2-selection--single {
    height: 40px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 6px !important;
    padding: 5px 8px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px !important;
    right: 8px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px !important;
    color: #1e293b !important;
    font-size: 13px !important;
  }
  .select2-dropdown {
    border-color: #cbd5e1 !important;
    border-radius: 6px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">
          <i class="fa fa-user-plus" style="color: #00a896; margin-right: 6px;"></i> Assign Doctor to Facility
        </h1>
        <small style="color: #64748b; font-size: 13px;">Create doctor-hospital practice affiliations and configure consultation charges</small>
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
          <i class="fa fa-link" style="color: #00a896;"></i>
          <span>Doctor Affiliation Form</span>
        </div>

        <form action="<?=base_url('doctor/clinicreg/assign_doctor');?>" method="post" id="assignDoctorForm">
          <div class="row">
            
            <!-- Step 1: Select Doctor -->
            <div class="col-md-6 col-xs-12" style="margin-bottom: 16px;">
              <div class="form-group">
                <label for="doctor_id">
                  <i class="fa fa-user-md text-primary" style="margin-right: 4px;"></i> Select Doctor <span class="text-danger">*</span>
                </label>
                <select name="doctor_id" id="doctor_id" class="form-control select2-searchable" required style="width: 100%;">
                  <option value="">-- Search &amp; Choose Doctor (Name, Specialty, Phone) --</option>
                  <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doc): ?>
                      <option value="<?=$doc['id'];?>">
                        Dr. <?=htmlspecialchars(trim($doc['fname'].' '.$doc['lname']));?> 
                        <?=!empty($doc['speciality']) ? '('.htmlspecialchars($doc['speciality']).')' : '';?>
                        <?=!empty($doc['city']) ? '- '.htmlspecialchars($doc['city']) : '';?>
                        - Tel: <?=htmlspecialchars($doc['mobile']);?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>

            <!-- Step 2: Select Facility Type -->
            <div class="col-md-6 col-xs-12" style="margin-bottom: 16px;">
              <div class="form-group">
                <label><i class="fa fa-building text-info" style="margin-right: 4px;"></i> Facility Type <span class="text-danger">*</span></label>
                <div class="facility-type-toggle">
                  <label class="facility-radio-label active" id="label_type_h">
                    <input type="radio" name="type" value="H" checked onchange="toggleFacilityType('H')" style="margin: 0;">
                    <i class="fa fa-hospital-o text-primary"></i> Multi-Specialty Hospital
                  </label>
                  <label class="facility-radio-label" id="label_type_c">
                    <input type="radio" name="type" value="C" onchange="toggleFacilityType('C')" style="margin: 0;">
                    <i class="fa fa-medkit text-warning"></i> Private Clinic
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            
            <!-- Hospital Dropdown (Active when type = H) -->
            <div class="col-md-6 col-xs-12" id="hospital_wrapper" style="margin-bottom: 16px;">
              <div class="form-group">
                <label for="hospital_id">
                  <i class="fa fa-hospital-o text-success" style="margin-right: 4px;"></i> Select Hospital <span class="text-danger">*</span>
                </label>
                <select name="hospital_id" id="hospital_id" class="form-control select2-searchable" required style="width: 100%;">
                  <option value="">-- Search &amp; Choose Hospital --</option>
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

            <!-- Clinic Dropdown (Active when type = C) -->
            <div class="col-md-6 col-xs-12" id="clinic_wrapper" style="display: none; margin-bottom: 16px;">
              <div class="form-group">
                <label for="clinic_id">
                  <i class="fa fa-medkit text-warning" style="margin-right: 4px;"></i> Select Clinic <span class="text-danger">*</span>
                </label>
                <select name="clinic_id" id="clinic_id" class="form-control select2-searchable" style="width: 100%;">
                  <option value="">-- Search &amp; Choose Clinic --</option>
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

            <!-- Consultation Fee -->
            <div class="col-md-6 col-xs-12" style="margin-bottom: 16px;">
              <div class="form-group">
                <label for="fee">
                  <i class="fa fa-inr text-success" style="margin-right: 4px;"></i> Consultation Fee (&#8377;) <span class="text-danger">*</span>
                </label>
                <input type="number" name="fee" id="fee" class="form-control" placeholder="e.g. 500" min="0" step="50" value="500" required>
                <div style="margin-top: 6px;">
                  <span style="font-size: 11px; color: #64748b; margin-right: 6px;">Quick Presets:</span>
                  <button type="button" class="fee-preset-btn" onclick="setFee(300)">&#8377;300</button>
                  <button type="button" class="fee-preset-btn" onclick="setFee(500)">&#8377;500</button>
                  <button type="button" class="fee-preset-btn" onclick="setFee(800)">&#8377;800</button>
                  <button type="button" class="fee-preset-btn" onclick="setFee(1000)">&#8377;1000</button>
                </div>
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 12px; margin-top: 20px; padding-top: 18px; border-top: 1px solid #f1f5f9; align-items: center; flex-wrap: wrap;">
            <button type="submit" name="submit_assign" value="1" class="btn btn-save-assign">
              <i class="fa fa-check" style="margin-right: 6px;"></i> Save Doctor Affiliation
            </button>
            <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600; padding: 10px 18px;">
              <i class="fa fa-list" style="margin-right: 4px;"></i> View All Affiliations
            </a>
          </div>
        </form>
      </div>

      <!-- Recent Affiliations Card -->
      <div class="assign-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 16px 20px; background: #ffffff; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <div style="font-weight: 700; font-size: 15px; color: #1e293b;">
            <i class="fa fa-history" style="color: #00a896; margin-right: 6px;"></i> Recent Doctor-Facility Affiliations
          </div>
          <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 4px;">
            View Full Practice Directory (1,300+) <i class="fa fa-arrow-right" style="margin-left: 4px;"></i>
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-affiliations">
            <thead>
              <tr>
                <th style="width: 60px;">ID</th>
                <th>Doctor Details</th>
                <th>Affiliated Facility</th>
                <th style="width: 120px;">Facility Type</th>
                <th style="width: 140px;">Consultation Fee</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 100px; text-align: right;">Action</th>
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
                  <tr>
                    <td style="color: #64748b; font-weight: 600;">#<?=$aff['id'];?></td>
                    <td>
                      <div style="font-weight: 700; color: #0f172a;">
                        <i class="fa fa-user-md text-primary" style="margin-right: 4px;"></i>
                        Dr. <?=htmlspecialchars($doc_name ?: 'Unnamed Doctor');?>
                      </div>
                      <div style="font-size: 12px; color: #64748b;">
                        <?=!empty($aff['speciality']) ? '<span style="color: #00a896; font-weight: 600;">'.htmlspecialchars($aff['speciality']).'</span> &bull; ' : '';?>
                        Tel: <?=htmlspecialchars($aff['doc_mobile'] ?: 'N/A');?>
                      </div>
                    </td>
                    <td>
                      <div style="font-weight: 600; color: #334155;">
                        <?=htmlspecialchars($facility_name);?>
                      </div>
                      <?php if (!empty($facility_city)): ?>
                        <div style="font-size: 12px; color: #64748b;">
                          <i class="fa fa-map-marker" style="margin-right: 3px;"></i> <?=htmlspecialchars($facility_city);?>
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
                      <span style="font-weight: 700; color: #0f172a; font-size: 14px;">
                        &#8377;<?=number_format((float)$aff['fee'], 0);?>
                      </span>
                    </td>
                    <td>
                      <?php if ($aff['status'] == '1'): ?>
                        <span class="badge-active"><i class="fa fa-check-circle"></i> Active</span>
                      <?php else: ?>
                        <span class="badge-inactive"><i class="fa fa-ban"></i> Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                      <a href="<?=base_url('doctor/clinicreg/delete_affiliation/'.$aff['id']);?>" 
                         class="btn btn-xs btn-danger" 
                         onclick="return confirm('Are you sure you want to unlink this doctor affiliation?');"
                         title="Unlink Affiliation"
                         style="border-radius: 4px; padding: 4px 8px;">
                        <i class="fa fa-trash"></i> Unlink
                      </a>
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

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
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

  $(document).ready(function() {
    // Initialize searchable Select2 dropdowns if jQuery & Select2 available
    if ($.fn.select2) {
      $('.select2-searchable').select2({
        placeholder: "Search and select...",
        allowClear: true,
        width: '100%'
      });
    }

    // Validate form on submission
    $('#assignDoctorForm').on('submit', function(e) {
      var docId = $('#doctor_id').val();
      var type = $('input[name="type"]:checked').val();
      var instId = (type === 'C') ? $('#clinic_id').val() : $('#hospital_id').val();

      if (!docId) {
        alert('Please choose a doctor.');
        $('#doctor_id').focus();
        e.preventDefault();
        return false;
      }
      if (!instId) {
        alert('Please choose a healthcare facility (' + (type === 'C' ? 'Clinic' : 'Hospital') + ').');
        (type === 'C' ? $('#clinic_id') : $('#hospital_id')).focus();
        e.preventDefault();
        return false;
      }
    });
  });
</script>
