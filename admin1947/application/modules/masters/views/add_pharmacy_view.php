<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #08364b; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-medkit" style="color: #00a8ff;"></i> <?= !empty($store['id']) ? 'Edit Partner Pharmacy' : 'Onboard New Partner Pharmacy'; ?>
        </h1>
        <p style="color: #64748b; font-size: 13px; margin: 5px 0 0 0;">
          <?= !empty($store['id']) ? 'Update operational parameters and regulatory licensing for this chemist partner.' : 'Register and configure partner chemist store for UPCHAR medicine delivery network.'; ?>
        </p>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="<?= base_url('masters/pharmacy_fleet?tab=pharmacy'); ?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
          <i class="fa fa-arrow-left"></i> Back to Pharmacy List
        </a>
      </div>
    </div>
    <ol class="breadcrumb" style="position: static; float: none; margin: 12px 0 0 0; background: transparent; padding: 0; font-size: 12px;">
      <li><a href="<?= base_url('masters/dashboard'); ?>" style="color: #64748b;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?= base_url('masters/pharmacy_fleet?tab=pharmacy'); ?>" style="color: #64748b;">Pharmacy &amp; Fleet</a></li>
      <li class="active" style="color: #08364b; font-weight: 600;"><?= !empty($store['id']) ? 'Edit Pharmacy' : 'Add Pharmacy'; ?></li>
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
              <i class="fa fa-building-o"></i> Pharmacy Onboarding &amp; Compliance Configuration
            </h3>
            <span style="font-size: 12px; color: #93c5fd;">Fields marked with an asterisk (*) are mandatory for drug licensing compliance</span>
          </div>
          <?php if (!empty($store['id'])): ?>
            <span class="badge" style="background: #00a8ff; font-size: 12px; padding: 6px 12px;">Store ID: #<?= $store['id']; ?></span>
          <?php endif; ?>
        </div>

        <!-- Form starts here -->
        <form action="<?= base_url('masters/pharmacy_fleet/add_pharmacy'); ?>" method="POST" id="pharmacyForm">
          <input type="hidden" name="id" value="<?= !empty($store['id']) ? (int)$store['id'] : 0; ?>">

          <div class="box-body" style="padding: 28px 30px;">

            <!-- SECTION 1: BASIC STORE CREDENTIALS -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">1</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Store Identity &amp; Contact Details</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Pharmacy / Chemist Store Name <span style="color: #dc2626;">*</span></label>
                  <input type="text" name="store_name" class="form-control" required placeholder="e.g., Sanjivani 24x7 Chemist &amp; Medicos" value="<?= html_escape($store['store_name'] ?? ''); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Trading name displayed to patients and doctors on the app.</small>
                </div>

                <div class="col-md-3 form-group">
                  <label style="font-weight: 600; color: #334155;">Contact Mobile Number <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-phone"></i></span>
                    <input type="text" name="phone" class="form-control" required placeholder="10-digit mobile" maxlength="15" value="<?= html_escape($store['phone'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">Primary number for order alert SMS &amp; OTPs.</small>
                </div>

                <div class="col-md-3 form-group">
                  <label style="font-weight: 600; color: #334155;">Official Email Address</label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-envelope-o"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="chemist@upchar.info" value="<?= html_escape($store['email'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">For monthly financial settlement statements.</small>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Operating Hours &amp; Dispensing Shifts</label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-clock-o"></i></span>
                    <input type="text" name="operating_hours" class="form-control" placeholder="09:00 AM - 10:00 PM (or 24x7)" value="<?= html_escape($store['operating_hours'] ?? '09:00 AM - 10:00 PM'); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">Defines when this store can receive automated order dispatch.</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Maximum Live Order Queue Capacity</label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-tasks"></i></span>
                    <input type="number" name="max_queue_limit" class="form-control" value="<?= html_escape($store['max_queue_limit'] ?? 25); ?>" min="5" max="200" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">System temporarily stops dispatching orders if pending orders reach this limit.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 2: REGULATORY & COMPLIANCE -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">2</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Drug Department Licensing &amp; Taxation</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Retail Drug License Number (Form 20/21) <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-id-card"></i></span>
                    <input type="text" name="drug_license_no" class="form-control" required placeholder="e.g., UP-VNS-2024-9981 / 20B/21B" value="<?= html_escape($store['drug_license_no'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">Issued by State Drug Licensing Authority (Mandatory for Schedule H/X dispensing).</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">GSTIN Registration Certificate Number</label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-file-text-o"></i></span>
                    <input type="text" name="gstin" class="form-control" placeholder="e.g., 09AAACW1234F1Z5" value="<?= html_escape($store['gstin'] ?? ''); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">For B2B input tax credit and automated GST billing.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 3: AFFILIATIONS & COMMISSION -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #fef3c7; color: #d97706; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">3</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Hospital/Doctor Tagging &amp; Platform Commercials</h4>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;"><i class="fa fa-hospital-o text-primary"></i> Associated Hospital (Optional)</label>
                  <select name="hospital_id" class="form-control" style="height: 42px; border-radius: 6px;">
                    <option value="">-- Independent Partner (No Hospital Tag) --</option>
                    <?php if (!empty($all_hospitals)): foreach($all_hospitals as $h): ?>
                    <option value="<?= $h['id']; ?>" <?= (!empty($store['hospital_id']) && $store['hospital_id'] == $h['id']) ? 'selected' : ''; ?>>
                      <?= html_escape($h['name']); ?> <?= !empty($h['city']) ? '('.html_escape($h['city']).')' : ''; ?>
                    </option>
                    <?php endforeach; endif; ?>
                  </select>
                  <small class="text-muted">Links this store as official in-house or tie-up pharmacy for the hospital.</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;"><i class="fa fa-user-md text-success"></i> Associated Doctor (Optional)</label>
                  <select name="associated_doctor_id" class="form-control" style="height: 42px; border-radius: 6px;">
                    <option value="">-- No Specific Doctor Tagging --</option>
                    <?php if (!empty($all_doctors)): foreach($all_doctors as $doc): ?>
                    <option value="<?= $doc['id']; ?>" <?= (!empty($store['associated_doctor_id']) && $store['associated_doctor_id'] == $doc['id']) ? 'selected' : ''; ?>>
                      Dr. <?= html_escape($doc['fname'] . ' ' . $doc['lname']); ?>
                    </option>
                    <?php endforeach; endif; ?>
                  </select>
                  <small class="text-muted">Promotes this pharmacy as preferred dispenser for this doctor's prescriptions.</small>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Platform Commission Fee (%) <span style="color: #dc2626;">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon" style="background: #f8fafc; border-radius: 6px 0 0 6px;"><i class="fa fa-percent"></i></span>
                    <input type="number" step="0.5" name="commission_rate" class="form-control" required value="<?= html_escape($store['commission_rate'] ?? '8.0'); ?>" style="height: 42px; border-radius: 0 6px 6px 0;">
                  </div>
                  <small class="text-muted">UPCHAR commission percentage deducted from gross dispatched sales.</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Delivery Radius Coverage (km) <span style="color: #dc2626;">*</span></label>
                  <select name="delivery_radius_km" class="form-control" style="height: 42px; border-radius: 6px;">
                    <?php 
                    $currRad = (float)($store['delivery_radius_km'] ?? 5.0);
                    $radii = [
                      '3.0'  => '3.0 km - Hyperlocal Quick Delivery',
                      '5.0'  => '5.0 km - Standard Delivery Zone',
                      '8.0'  => '8.0 km - Extended Suburban Zone',
                      '10.0' => '10.0 km - Citywide Express Coverage'
                    ];
                    foreach ($radii as $radVal => $radLabel):
                    ?>
                    <option value="<?= $radVal; ?>" <?= ($currRad == (float)$radVal) ? 'selected' : ''; ?>><?= $radLabel; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small class="text-muted">Radius within which UPCHAR fleet riders deliver from this store.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 4: LOCATION & GEO-COORDINATES -->
            <div style="margin-bottom: 24px;">
              <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 26px; height: 26px; border-radius: 50%; background: #ede9fe; color: #7c3aed; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">4</span>
                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">Physical Address &amp; GPS Coordinates</h4>
              </div>

              <div class="row">
                <div class="col-md-8 form-group">
                  <label style="font-weight: 600; color: #334155;">Full Physical Shop Address <span style="color: #dc2626;">*</span></label>
                  <textarea name="address" class="form-control" rows="2" required placeholder="Shop No, Building Name, Road, Landmark, Area Colony" style="border-radius: 6px;"><?= html_escape($store['address'] ?? ''); ?></textarea>
                  <small class="text-muted">Exact location for delivery rider package pickup.</small>
                </div>

                <div class="col-md-4 form-group">
                  <label style="font-weight: 600; color: #334155;">City / Operational Region <span style="color: #dc2626;">*</span></label>
                  <input type="text" name="city" class="form-control" required value="<?= html_escape($store['city'] ?? 'Varanasi'); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Default: Varanasi</small>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Store Latitude (GPS)</label>
                  <input type="text" name="latitude" class="form-control" value="<?= html_escape($store['latitude'] ?? '25.3176'); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Used for rider distance algorithm (Default Varanasi Center: 25.3176).</small>
                </div>

                <div class="col-md-6 form-group">
                  <label style="font-weight: 600; color: #334155;">Store Longitude (GPS)</label>
                  <input type="text" name="longitude" class="form-control" value="<?= html_escape($store['longitude'] ?? '82.9739'); ?>" style="height: 42px; border-radius: 6px;">
                  <small class="text-muted">Default Varanasi Center: 82.9739.</small>
                </div>
              </div>
            </div>

            <!-- SECTION 5: ACCOUNT & COMPLIANCE STATUS -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
              <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
                <div>
                  <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #08364b; display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-toggle-on text-primary" style="font-size: 18px;"></i> Verification &amp; Operating Status
                  </h4>
                  <small style="color: #64748b; font-size: 12.5px;">Click any switch to toggle store operations. Changes can be saved instantly or via the button below.</small>
                </div>
                <div id="ajaxStatusNotice" style="display: none; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; background: #dcfce7; color: #15803d;">
                  <i class="fa fa-check-circle"></i> Status auto-saved!
                </div>
              </div>

              <?php
              $isEdit = !empty($store['id']);
              $isActive = $isEdit ? ((int)($store['is_active'] ?? 1) === 1) : true;
              $isVerified = $isEdit ? ((int)($store['is_verified'] ?? 1) === 1) : true;
              $isEmergencyClosed = $isEdit ? ((int)($store['is_emergency_closed'] ?? 0) === 1) : false;
              ?>

              <div class="row">
                <!-- Status Card 1: Store Active -->
                <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
                  <div class="status-toggle-card <?= $isActive ? 'card-active' : 'card-inactive'; ?>" id="card_is_active">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                      <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px;">
                          Store Active on Network
                        </div>
                        <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
                          Enables storefront visibility, catalog search, and customer order routing.
                        </p>
                        <span id="badge_is_active" class="status-badge <?= $isActive ? 'badge-on' : 'badge-off'; ?>">
                          <i class="fa <?= $isActive ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i> 
                          <?= $isActive ? 'Active &amp; Visible' : 'Inactive (Hidden)'; ?>
                        </span>
                      </div>
                      <div style="padding-top: 2px;">
                        <input type="hidden" name="is_active" value="0">
                        <label class="ios-switch">
                          <input type="checkbox" name="is_active" id="switch_is_active" value="1" <?= $isActive ? 'checked' : ''; ?> onchange="onStatusToggleChange('is_active', this, <?= !empty($store['id']) ? (int)$store['id'] : 0; ?>)">
                          <span class="ios-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Status Card 2: Drug License Verified -->
                <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
                  <div class="status-toggle-card <?= $isVerified ? 'card-verified' : 'card-inactive'; ?>" id="card_is_verified">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                      <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px;">
                          Drug License Verified
                        </div>
                        <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
                          Displays verified partner badge and unlocks prescription medicine dispatch.
                        </p>
                        <span id="badge_is_verified" class="status-badge <?= $isVerified ? 'badge-blue' : 'badge-amber'; ?>">
                          <i class="fa <?= $isVerified ? 'fa-shield' : 'fa-clock-o'; ?>"></i> 
                          <?= $isVerified ? 'Verified &amp; Approved' : 'Pending Verification'; ?>
                        </span>
                      </div>
                      <div style="padding-top: 2px;">
                        <input type="hidden" name="is_verified" value="0">
                        <label class="ios-switch">
                          <input type="checkbox" name="is_verified" id="switch_is_verified" value="1" <?= $isVerified ? 'checked' : ''; ?> onchange="onStatusToggleChange('is_verified', this, <?= !empty($store['id']) ? (int)$store['id'] : 0; ?>)">
                          <span class="ios-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Status Card 3: Emergency Closure -->
                <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
                  <div class="status-toggle-card <?= $isEmergencyClosed ? 'card-emergency' : 'card-normal'; ?>" id="card_is_emergency_closed">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                      <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 14px; color: #dc2626; margin-bottom: 4px;">
                          Emergency Closed
                        </div>
                        <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
                          Temporarily pauses order routing in case of stock shortage or emergency.
                        </p>
                        <span id="badge_is_emergency_closed" class="status-badge <?= $isEmergencyClosed ? 'badge-red' : 'badge-on'; ?>">
                          <i class="fa <?= $isEmergencyClosed ? 'fa-exclamation-triangle' : 'fa-check'; ?>"></i> 
                          <?= $isEmergencyClosed ? 'Closed &amp; Halted' : 'Normal Operations'; ?>
                        </span>
                      </div>
                      <div style="padding-top: 2px;">
                        <input type="hidden" name="is_emergency_closed" value="0">
                        <label class="ios-switch switch-danger">
                          <input type="checkbox" name="is_emergency_closed" id="switch_is_emergency_closed" value="1" <?= $isEmergencyClosed ? 'checked' : ''; ?> onchange="onStatusToggleChange('is_emergency_closed', this, <?= !empty($store['id']) ? (int)$store['id'] : 0; ?>)">
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
            <a href="<?= base_url('masters/pharmacy_fleet?tab=pharmacy'); ?>" class="btn btn-default" style="padding: 10px 20px; font-weight: 600; border-radius: 6px;">
              <i class="fa fa-times"></i> Cancel
            </a>
            <div style="display: flex; gap: 10px;">
              <button type="submit" class="btn btn-success" style="padding: 10px 24px; font-weight: 700; border-radius: 6px; background: #16a34a; border-color: #16a34a; box-shadow: 0 2px 4px rgba(22,163,74,0.3);">
                <i class="fa fa-check-circle"></i> <?= !empty($store['id']) ? 'Update Partner Pharmacy' : 'Save &amp; Activate Pharmacy'; ?>
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
.status-toggle-card.card-emergency {
  border-color: #fca5a5;
  background: #fef2f2;
}
.status-toggle-card.card-normal {
  border-color: #e2e8f0;
  background: #ffffff;
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
.badge-red { background: #fee2e2; color: #b91c1c; }

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
.ios-switch.switch-danger input:checked + .ios-slider {
  background-color: #dc2626;
}
.ios-switch input:checked + .ios-slider:before {
  transform: translateX(22px);
}
</style>

<script>
function onStatusToggleChange(field, checkbox, storeId) {
  var isChecked = checkbox.checked;

  if (field === 'is_active') {
    var badge = document.getElementById('badge_is_active');
    var card = document.getElementById('card_is_active');
    if (isChecked) {
      badge.className = 'status-badge badge-on';
      badge.innerHTML = '<i class="fa fa-check-circle"></i> Active &amp; Visible';
      card.className = 'status-toggle-card card-active';
    } else {
      badge.className = 'status-badge badge-off';
      badge.innerHTML = '<i class="fa fa-times-circle"></i> Inactive (Hidden)';
      card.className = 'status-toggle-card card-inactive';
    }
  } else if (field === 'is_verified') {
    var badge = document.getElementById('badge_is_verified');
    var card = document.getElementById('card_is_verified');
    if (isChecked) {
      badge.className = 'status-badge badge-blue';
      badge.innerHTML = '<i class="fa fa-shield"></i> Verified &amp; Approved';
      card.className = 'status-toggle-card card-verified';
    } else {
      badge.className = 'status-badge badge-amber';
      badge.innerHTML = '<i class="fa fa-clock-o"></i> Pending Verification';
      card.className = 'status-toggle-card card-inactive';
    }
  } else if (field === 'is_emergency_closed') {
    var badge = document.getElementById('badge_is_emergency_closed');
    var card = document.getElementById('card_is_emergency_closed');
    if (isChecked) {
      badge.className = 'status-badge badge-red';
      badge.innerHTML = '<i class="fa fa-exclamation-triangle"></i> Closed &amp; Halted';
      card.className = 'status-toggle-card card-emergency';
    } else {
      badge.className = 'status-badge badge-on';
      badge.innerHTML = '<i class="fa fa-check"></i> Normal Operations';
      card.className = 'status-toggle-card card-normal';
    }
  }

  // If in edit mode, auto-save status via AJAX for instant feedback
  if (storeId > 0) {
    $.ajax({
      url: '<?= base_url("masters/pharmacy_fleet/toggle_status_ajax"); ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        store_id: storeId,
        field: field,
        value: isChecked ? 1 : 0
      },
      success: function(resp) {
        var notice = document.getElementById('ajaxStatusNotice');
        if (notice) {
          notice.style.display = 'inline-block';
          notice.innerHTML = '<i class="fa fa-check-circle"></i> ' + (resp.message || 'Status auto-saved!');
          setTimeout(function() {
            $(notice).fadeOut(400);
          }, 2500);
        }
      },
      error: function() {
        console.warn('AJAX auto-save failed; status will be saved on form submission.');
      }
    });
  }
}
</script>
