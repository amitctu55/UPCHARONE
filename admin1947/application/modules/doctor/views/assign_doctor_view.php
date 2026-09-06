<!DOCTYPE html>
<html>
<head>
  <style>
    .assign-card {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      border: 1px solid #e2e8f0;
      padding: 24px;
      margin-bottom: 24px;
    }
    .form-section-title {
      font-size: 15px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 16px;
      padding-bottom: 8px;
      border-bottom: 1px solid #f1f5f9;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .form-group label {
      font-size: 13px;
      font-weight: 600;
      color: #334155;
    }
    .form-control {
      border-radius: 6px;
      border: 1px solid #cbd5e1;
      height: 38px;
    }
    .form-control:focus {
      border-color: #00a896;
      box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.2);
    }
    .btn-save-assign {
      background: #00a896;
      border-color: #00a896;
      color: #ffffff;
      font-weight: 600;
      padding: 8px 22px;
      border-radius: 6px;
    }
    .btn-save-assign:hover {
      background: #008f80;
      border-color: #008f80;
      color: #ffffff;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content-header" style="padding: 20px 20px 10px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <div>
            <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Doctor-Hospital Affiliation</h1>
            <small style="color: #64748b; font-size: 13px;">Assign registered healthcare practitioners to hospitals and clinics</small>
          </div>
          <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
            <li><a href="<?=base_url('masters/dashboard');?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" style="color: #64748b;">Affiliations</a></li>
            <li class="active" style="color: #1e293b; font-weight: 600;">Assign Doctor</li>
          </ol>
        </div>
      </section>

      <section class="content" style="padding: 15px 20px;">
        <div class="container-fluid" style="padding: 0;">
          <?=$this->session->flashdata('flashmsg');?>

          <div class="assign-card">
            <div class="form-section-title">
              <i class="fa fa-link" style="color: #00a896;"></i>
              <span>Assign Doctor to Healthcare Facility</span>
            </div>

            <form action="<?=base_url('doctor/clinicreg/assign_doctor');?>" method="post" class="form-horizontal">
              <div class="row">
                <!-- Doctor Selection -->
                <div class="col-md-6">
                  <div class="form-group" style="padding: 0 15px;">
                    <label for="doctor_id"><i class="fa fa-user-md text-primary"></i> Select Doctor <span class="text-danger">*</span></label>
                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                      <option value="">-- Choose Doctor --</option>
                      <?php if(!empty($doctors)): ?>
                        <?php foreach($doctors as $doc): ?>
                          <option value="<?=$doc['id'];?>">
                            Dr. <?=htmlspecialchars($doc['fname'].' '.$doc['lname']);?> 
                            <?=!empty($doc['speciality']) ? '('.htmlspecialchars($doc['speciality']).')' : '';?>
                            - Tel: <?=htmlspecialchars($doc['mobile']);?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>

                <!-- Practice / Facility Type -->
                <div class="col-md-6">
                  <div class="form-group" style="padding: 0 15px;">
                    <label for="facility_type"><i class="fa fa-building text-info"></i> Facility Type <span class="text-danger">*</span></label>
                    <select name="type" id="facility_type" class="form-control" onchange="toggleFacilityList(this.value);" required>
                      <option value="H" selected>Hospital</option>
                      <option value="C">Clinic</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <!-- Hospital List -->
                <div class="col-md-6" id="hospital_wrapper">
                  <div class="form-group" style="padding: 0 15px;">
                    <label for="hospital_id"><i class="fa fa-hospital-o text-success"></i> Select Hospital <span class="text-danger">*</span></label>
                    <select name="hospital_id" id="hospital_id" class="form-control">
                      <option value="">-- Choose Hospital --</option>
                      <?php if(!empty($hospitals)): ?>
                        <?php foreach($hospitals as $hosp): ?>
                          <option value="<?=$hosp['id'];?>">
                            <?=htmlspecialchars($hosp['name']);?> (<?=htmlspecialchars($hosp['city'] ?: $hosp['address']);?>)
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>

                <!-- Clinic List (Hidden by default) -->
                <div class="col-md-6" id="clinic_wrapper" style="display: none;">
                  <div class="form-group" style="padding: 0 15px;">
                    <label for="clinic_id"><i class="fa fa-medkit text-warning"></i> Select Clinic <span class="text-danger">*</span></label>
                    <select name="clinic_id" id="clinic_id" class="form-control" onchange="document.getElementById('hospital_id').value = this.value;">
                      <option value="">-- Choose Clinic --</option>
                      <?php if(!empty($clinics)): ?>
                        <?php foreach($clinics as $cl): ?>
                          <option value="<?=$cl['id'];?>">
                            <?=htmlspecialchars($cl['name']);?> (<?=htmlspecialchars($cl['city'] ?: $cl['address']);?>)
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>

                <!-- Consultation Fee -->
                <div class="col-md-3">
                  <div class="form-group" style="padding: 0 15px;">
                    <label for="fee"><i class="fa fa-inr text-muted"></i> Consultation Fee (&#8377;)</label>
                    <input type="number" name="fee" id="fee" class="form-control" placeholder="e.g. 500" min="0" step="50" value="500">
                  </div>
                </div>

                <!-- Slot Duration -->
                <div class="col-md-3">
                  <div class="form-group" style="padding: 0 15px;">
                    <label for="time_duration"><i class="fa fa-clock-o text-muted"></i> Slot Duration (Mins)</label>
                    <select name="time_duration" id="time_duration" class="form-control">
                      <option value="10">10 Minutes</option>
                      <option value="15" selected>15 Minutes</option>
                      <option value="20">20 Minutes</option>
                      <option value="30">30 Minutes</option>
                      <option value="45">45 Minutes</option>
                      <option value="60">60 Minutes</option>
                    </select>
                  </div>
                </div>
              </div>

              <div style="display: flex; gap: 10px; margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                <button type="submit" name="submit_assign" value="1" class="btn btn-save-assign">
                  <i class="fa fa-check"></i> Save Doctor Affiliation
                </button>
                <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>" class="btn btn-default" style="border-radius: 6px;">
                  Cancel
                </a>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script>
    function toggleFacilityList(val) {
      if (val === 'C') {
        document.getElementById('hospital_wrapper').style.display = 'none';
        document.getElementById('clinic_wrapper').style.display = 'block';
        document.getElementById('hospital_id').value = document.getElementById('clinic_id').value;
      } else {
        document.getElementById('hospital_wrapper').style.display = 'block';
        document.getElementById('clinic_wrapper').style.display = 'none';
      }
    }
  </script>
</body>
</html>
