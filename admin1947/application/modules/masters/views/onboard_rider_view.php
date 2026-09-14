<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #08364b; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-motorcycle" style="color: #00a8ff;"></i> <?= !empty($rider['id']) ? 'Edit Delivery Fleet Rider' : 'Onboard New Delivery Fleet Rider'; ?>
        </h1>
        <p style="color: #64748b; font-size: 13px; margin: 5px 0 0 0;">
          <?= !empty($rider['id']) ? 'Update vehicle credentials, contact details, and fleet operating status.' : 'Register and verify delivery riders for the UPCHAR medicine fulfillment fleet.'; ?>
        </p>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="<?= base_url('masters/pharmacy_fleet?tab=fleet'); ?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-arrow-left"></i> Back to Fleet Roster
        </a>
      </div>
    </div>
    <ol class="breadcrumb" style="position: static; float: none; margin: 12px 0 0 0; background: transparent; padding: 0; font-size: 12px;">
      <li><a href="<?= base_url('masters/dashboard'); ?>" style="color: #64748b;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?= base_url('masters/pharmacy_fleet?tab=fleet'); ?>" style="color: #64748b;">Pharmacy &amp; Fleet</a></li>
      <li class="active" style="color: #08364b; font-weight: 600;"><?= !empty($rider['id']) ? 'Edit Rider' : 'Onboard Rider'; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 0 30px 30px 30px;">
    <div class="container-fluid" style="padding: 0;">

      <!-- Flash Notifications -->
      <?php if ($this->session->flashdata('error') || $this->session->flashdata('error_msg')): ?>
      <div class="alert alert-danger alert-dismissible" style="border-radius: 8px; margin-bottom: 20px;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 style="font-size: 15px; font-weight: 700; margin: 0 0 5px 0;"><i class="fa fa-exclamation-circle"></i> Error:</h4>
        <div style="font-size: 13px;"><?= $this->session->flashdata('error') ?: $this->session->flashdata('error_msg'); ?></div>
      </div>
      <?php endif; ?>

      <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin: 0 auto 30px; background: #ffffff; overflow: hidden;">
        
        <div style="background: #08364b; color: #ffffff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
          <div>
            <h3 style="margin: 0; font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
              <i class="fa fa-id-card-o"></i> Delivery Fleet Onboarding &amp; Verification
            </h3>
            <span style="font-size: 12px; color: #93c5fd;">Fields marked with an asterisk (*) are mandatory for fleet background checks</span>
          </div>
          <?php if (!empty($rider['id'])): ?>
            <span class="badge" style="background: #00a8ff; font-size: 12px; padding: 6px 12px;">Rider ID: #<?= $rider['id']; ?></span>
          <?php endif; ?>
        </div>

        <!-- Form starts here -->
        <form action="<?= base_url('masters/pharmacy_fleet/onboard_rider'); ?>" method="POST" id="riderForm">
          <input type="hidden" name="id" value="<?= !empty($rider['id']) ? (int)$rider['id'] : 0; ?>">

          <div class="box-body" style="padding: 28px 30px;">

            <!-- SECTION 1: PERSONAL IDENTITY & CONTACT -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">1</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Rider Personal &amp; Contact Details</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Full Legal Name <span style="color: #dc2626;">*</span></label>
                  <input type="text" name="name" class="form-control" required placeholder="e.g., Anand Kumar Yadav" value="<?= html_escape($rider['name'] ?? ($rider['rider_name'] ?? '')); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">As printed on Government Driving License &amp; Aadhaar Card.</small>
                </div>

                <div class="col-md-3 form-group">
                  <label style="font-weight: 600; color: #334155;">Mobile Number <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-phone"></i></span>
                    <input type="text" name="phone" class="form-control" required placeholder="10-digit mobile" maxlength="15" value="<?= html_escape($rider['phone'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">Primary number for Rider App login &amp; dispatch OTPs.</small>
                </div>

                <div class="col-md-3 form-group">
                  <label style="font-weight: 600; color: #334155;">Email Address</label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-envelope-o"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="rider@upchar.info" value="<?= html_escape($rider['email'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">For digital payslips &amp; shift statements.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 2: VEHICLE & DRIVING CREDENTIALS -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">2</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Vehicle Specifications &amp; License Compliance</h4>
              </div>

              <div class="row">
                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Driving License Number <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-id-badge"></i></span>
                    <input type="text" name="driving_license_no" class="form-control" required placeholder="e.g., UP652021008761" value="<?= html_escape($rider['driving_license_no'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">Indian RTO Commercial / Non-Transport Two-Wheeler DL.</small>
                </div>

                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Assigned Vehicle Type <span style="color: #dc2626;">*</span></label>
                  <select name="vehicle_type" class="form-control" style="height: 42px; border-radius: 6px;">
                    <?php
                    $vtype = $rider['vehicle_type'] ?? 'Bike';
                    $types = [
                      'Bike'             => 'Motorcycle / Bike (Standard)',
                      'Scooter'          => 'Scooter / Gearless',
                      'Electric Vehicle' => 'Electric Two-Wheeler (EV)',
                      'Bicycle'          => 'Bicycle (Hyperlocal Short Distance)'
                    ];
                    foreach ($types as $val => $label):
                    ?>
                    <option value="<?= $val; ?>" <?= ($vtype === $val) ? 'selected' : ''; ?>><?= $label; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small class="text-muted">Defines cargo payload capacity &amp; speed estimate.</small>
                </div>

                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Vehicle Registration Number <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-car"></i></span>
                    <input type="text" name="vehicle_number" class="form-control" required placeholder="e.g., UP 65 BZ 1092" value="<?= html_escape($rider['vehicle_number'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">Official number plate registered with RTO.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 3: OPERATING STATUS & GPS LOCATION -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #fef3c7; color: #d97706; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">3</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Fleet Availability &amp; Base Coordinates</h4>
              </div>

              <div class="row">
                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Current Dispatch Duty Status</label>
                  <select name="status" class="form-control" style="height: 42px; border-radius: 6px;">
                    <?php
                    $curStatus = strtoupper($rider['status'] ?? 'AVAILABLE');
                    ?>
                    <option value="AVAILABLE" <?= ($curStatus === 'AVAILABLE') ? 'selected' : ''; ?>>🟢 AVAILABLE (Ready for Assignment)</option>
                    <option value="BUSY" <?= ($curStatus === 'BUSY') ? 'selected' : ''; ?>>🟠 BUSY (Currently Out on Delivery)</option>
                    <option value="OFFLINE" <?= ($curStatus === 'OFFLINE') ? 'selected' : ''; ?>>⚪ OFFLINE (Off-Duty / Rest Shift)</option>
                  </select>
                  <small class="text-muted">Affects whether the automated dispatcher routes orders to this rider.</small>
                </div>

                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Base Duty Latitude</label>
                  <input type="text" name="current_latitude" class="form-control" value="<?= html_escape($rider['current_latitude'] ?? '25.3176'); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Default Varanasi Hub: 25.3176</small>
                </div>

                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">Base Duty Longitude</label>
                  <input type="text" name="current_longitude" class="form-control" value="<?= html_escape($rider['current_longitude'] ?? '82.9739'); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Default Varanasi Hub: 82.9739</small>
                </div>
              </div>
            </div>

            <!-- SECTION 4: ACCOUNT STATUS & COMPLIANCE -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
              <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
                <div>
                  <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #08364b; display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-toggle-on text-primary" style="font-size: 18px;"></i> Verification &amp; Operating Status
                  </h4>
                  <small style="color: #64748b; font-size: 12.5px;">Click any switch to toggle rider account access. Changes are saved upon submission or via instant switch.</small>
                </div>
              </div>

              <?php
              $isEdit = !empty($rider['id']);
              $isActive = $isEdit ? ((int)($rider['is_active'] ?? 1) === 1) : true;
              $isVerified = $isEdit ? ((int)($rider['is_verified'] ?? 1) === 1) : true;
              ?>

              <div class="row">
                <!-- Status Card 1: Rider Active -->
                <div class="col-md-6 col-sm-12" style="margin-bottom: 12px;">
                  <div class="status-toggle-card <?= $isActive ? 'card-active' : 'card-inactive'; ?>" id="card_rider_active">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                      <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px;">
                          Rider Active on UPCHAR Fleet
                        </div>
                        <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
                          Enables rider to log in to the UPCHAR Delivery Partner app and receive job assignments.
                        </p>
                        <span id="badge_rider_active" class="status-badge <?= $isActive ? 'badge-on' : 'badge-off'; ?>">
                          <i class="fa <?= $isActive ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i> 
                          <?= $isActive ? 'Active &amp; Authorized' : 'Deactivated (Suspended)'; ?>
                        </span>
                      </div>
                      <div style="padding-top: 2px;">
                        <input type="hidden" name="is_active" value="0">
                        <label class="ios-switch">
                          <input type="checkbox" name="is_active" id="switch_rider_active" value="1" <?= $isActive ? 'checked' : ''; ?> onchange="onRiderToggleChange('is_active', this)">
                          <span class="ios-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Status Card 2: DL Verified -->
                <div class="col-md-6 col-sm-12" style="margin-bottom: 12px;">
                  <div class="status-toggle-card <?= $isVerified ? 'card-verified' : 'card-inactive'; ?>" id="card_rider_verified">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                      <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px;">
                          Driving License Verified &amp; KYC Approved
                        </div>
                        <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
                          Confirms identity background check and valid RTO registration certificate.
                        </p>
                        <span id="badge_rider_verified" class="status-badge <?= $isVerified ? 'badge-blue' : 'badge-amber'; ?>">
                          <i class="fa <?= $isVerified ? 'fa-shield' : 'fa-clock-o'; ?>"></i> 
                          <?= $isVerified ? 'Verified &amp; Approved' : 'Pending Verification'; ?>
                        </span>
                      </div>
                      <div style="padding-top: 2px;">
                        <input type="hidden" name="is_verified" value="0">
                        <label class="ios-switch">
                          <input type="checkbox" name="is_verified" id="switch_rider_verified" value="1" <?= $isVerified ? 'checked' : ''; ?> onchange="onRiderToggleChange('is_verified', this)">
                          <span class="ios-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Form Footer Buttons -->
          <div class="box-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=fleet'); ?>" class="btn btn-default" style="padding: 10px 20px; font-weight: 600; border-radius: 6px;">
              <i class="fa fa-times"></i> Cancel
            </a>
            <div style="display: flex; gap: 10px;">
              <button type="submit" class="btn btn-success" style="padding: 10px 24px; font-weight: 700; border-radius: 6px; background: #16a34a; border-color: #16a34a; box-shadow: 0 2px 4px rgba(22,163,74,0.3);">
                <i class="fa fa-check-circle"></i> <?= !empty($rider['id']) ? 'Update Rider Credentials' : 'Verify &amp; Onboard to Fleet'; ?>
              </button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>

<style>
/* Status Toggle Cards */
.status-toggle-card {
  background: #ffffff;
  border: 1.5px solid #e2e8f0;
  border-radius: 8px;
  padding: 16px;
  height: 100%;
  transition: all 0.25s ease;
}
.status-toggle-card.card-active {
  border-color: #86efac;
  background: #f0fdf4;
}
.status-toggle-card.card-verified {
  border-color: #93c5fd;
  background: #eff6ff;
}
.status-toggle-card.card-inactive {
  border-color: #cbd5e1;
  background: #f8fafc;
}

/* Dynamic Status Badges */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11.5px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: 20px;
}
.badge-on { background: #dcfce7; color: #15803d; }
.badge-off { background: #e2e8f0; color: #475569; }
.badge-blue { background: #dbeafe; color: #1d4ed8; }
.badge-amber { background: #fef3c7; color: #b45309; }

/* iOS-Style Toggle Switch */
.ios-switch {
  position: relative;
  display: inline-block;
  width: 48px;
  height: 26px;
  margin: 0;
  cursor: pointer;
}
.ios-switch input {
  opacity: 0;
  width: 0;
  height: 0;
  position: absolute;
}
.ios-slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #cbd5e1;
  transition: .25s ease;
  border-radius: 26px;
}
.ios-slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: #ffffff;
  transition: .25s ease;
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0,0,0,0.25);
}
.ios-switch input:checked + .ios-slider {
  background-color: #16a34a;
}
.ios-switch input:checked + .ios-slider:before {
  transform: translateX(22px);
}
</style>

<script>
function onRiderToggleChange(field, checkbox) {
  var isChecked = checkbox.checked;
  if (field === 'is_active') {
    var badge = document.getElementById('badge_rider_active');
    var card = document.getElementById('card_rider_active');
    if (isChecked) {
      badge.className = 'status-badge badge-on';
      badge.innerHTML = '<i class="fa fa-check-circle"></i> Active &amp; Authorized';
      card.className = 'status-toggle-card card-active';
    } else {
      badge.className = 'status-badge badge-off';
      badge.innerHTML = '<i class="fa fa-times-circle"></i> Deactivated (Suspended)';
      card.className = 'status-toggle-card card-inactive';
    }
  } else if (field === 'is_verified') {
    var badge = document.getElementById('badge_rider_verified');
    var card = document.getElementById('card_rider_verified');
    if (isChecked) {
      badge.className = 'status-badge badge-blue';
      badge.innerHTML = '<i class="fa fa-shield"></i> Verified &amp; Approved';
      card.className = 'status-toggle-card card-verified';
    } else {
      badge.className = 'status-badge badge-amber';
      badge.innerHTML = '<i class="fa fa-clock-o"></i> Pending Verification';
      card.className = 'status-toggle-card card-inactive';
    }
  }
}
</script>
