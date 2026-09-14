<style>
:root {
    --navy: #08364B;
    --navy-dark: #042433;
    --cyan: #00A8FF;
    --green: #10B981;
    --amber: #F59E0B;
    --red: #E63946;
    --card-border: #E2E8F0;
}

.profile-page-wrapper {
    padding: 24px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.profile-page-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.profile-page-title h2 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.profile-page-title p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.compliance-hero {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1px solid var(--card-border);
    padding: 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.verified-pill {
    background: #DCFCE7;
    color: #15803D;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.unverified-pill {
    background: #FEF3C7;
    color: #92400E;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.form-card {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

.form-card-header {
    background: #F8FAFC;
    padding: 16px 20px;
    border-bottom: 1px solid var(--card-border);
    font-size: 15px;
    font-weight: 700;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-card-body {
    padding: 24px;
}

.legal-footer {
    text-align: center;
    padding: 20px;
    font-size: 12.5px;
    color: #64748B;
    border-top: 1px solid #E2E8F0;
    margin-top: 40px;
    background: #FFFFFF;
    border-radius: 12px;
}
</style>

<div class="profile-page-wrapper">
    <!-- Clean Page Header -->
    <div class="profile-page-header">
        <div class="profile-page-title">
            <h2><i class="fa fa-store text-primary me-2" style="color:#0284c7;"></i> Chemist Partner Profile & Compliance</h2>
            <p>Store information, drug license validation, operating hours, and location geo-tagging.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700;">
                <i class="fa fa-hospital-o me-1"></i> <?=htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');?>
            </span>
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control input-sm" onchange="location.href='<?=base_url('pharmacy/profile/edit?store_id=');?>'+this.value" style="display:inline-block; width:auto; height:34px; border-radius:8px; border:1px solid #cbd5e1; font-weight:600;">
                    <?php foreach($stores as $st): ?>
                        <option value="<?=$st['id'];?>" <?=$st['id'] == $current_store['id'] ? 'selected' : '';?>>
                            <?=$st['store_name'];?> (<?=$st['city'];?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <button onclick="location.reload();" class="btn btn-sm btn-default" style="border-radius:8px; background:#fff; border:1px solid #cbd5e1; padding:6px 12px;">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>
</div>

<div class="container" style="max-width: 1100px; padding: 0 15px;">
    <?php if(!empty($flashmsg)): ?>
        <div style="margin-top: 20px;"><?=$flashmsg;?></div>
    <?php endif; ?>

    <!-- Profile Hero Card -->
    <div class="profile-hero">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="profile-avatar-wrap">
                <?php if(!empty($current_store['store_photo'])): ?>
                    <img src="<?=base_url($current_store['store_photo']);?>" alt="Store Photo">
                <?php else: ?>
                    <i class="fas fa-clinic-medical"></i>
                <?php endif; ?>
            </div>
            <div class="profile-hero-info">
                <h2><?=htmlspecialchars($current_store['store_name'] ?? 'Chemist Store Name');?></h2>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                    <span class="badge-verified"><i class="fas fa-check-circle"></i> Verified Chemist Partner</span>
                    <span class="badge" style="background: #E0F2FE; color: #0369A1; font-weight: 600;">
                        Store ID: #<?=htmlspecialchars($current_store['id']);?>
                    </span>
                    <?php if(!empty($current_store['is_emergency_closed'])): ?>
                        <span class="badge-emergency"><i class="fas fa-pause-circle"></i> Store Temporarily Paused</span>
                    <?php else: ?>
                        <span class="badge" style="background: #DCFCE7; color: #15803D; font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px;"></i> Accepting Orders</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div>
            <a href="<?=base_url('pharmacy/dashboard');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Profile Form -->
    <form action="<?=base_url('pharmacy/profile/update');?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="store_id" value="<?=$current_store['id'];?>">

        <div class="row">
            <!-- Left Column: Business & Regulatory Info -->
            <div class="col-md-7">
                <!-- Section 1: Business Identity -->
                <div class="section-card">
                    <h3 class="section-card-title">
                        <i class="fas fa-store-alt" style="color: var(--cyan);"></i> 1. Pharmacy Store & Pharmacist Identity
                    </h3>

                    <div class="form-group">
                        <label class="form-label">Trade / Chemist Store Name <span class="text-danger">*</span></label>
                        <input type="text" name="store_name" value="<?=htmlspecialchars($current_store['store_name'] ?? '');?>" class="form-control" required placeholder="e.g. Metro Care Medicos & Chemist">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Registered Pharmacist In-Charge</label>
                            <input type="text" name="pharmacist_name" value="<?=htmlspecialchars($current_store['pharmacist_name'] ?? ($chem_profile['fname'] ?? ''));?>" class="form-control" placeholder="Pharmacist Full Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Pharmacist Reg. No. (State Council)</label>
                            <input type="text" value="<?=htmlspecialchars($chem_profile['regd_no'] ?? 'UP-PHARM-'.date('ym'));?>" class="form-control" readonly style="background: #F8FAFC;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Primary Business Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="<?=htmlspecialchars($current_store['phone'] ?? ($chem_profile['mobile'] ?? ''));?>" class="form-control" required placeholder="10-digit mobile number">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Official Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="<?=htmlspecialchars($current_store['email'] ?? ($chem_profile['email'] ?? ''));?>" class="form-control" required placeholder="partner@pharmacy.com">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Update Store Front Photo</label>
                        <input type="file" name="store_photo" class="form-control" accept="image/*">
                        <small class="text-muted">Upload high-resolution image of your pharmacy store counter/board (Max 4MB).</small>
                    </div>
                </div>

                <!-- Section 2: Statutory Compliance & Drug License -->
                <div class="section-card">
                    <h3 class="section-card-title">
                        <i class="fas fa-file-contract" style="color: var(--cyan);"></i> 2. Drug License (Form 20/21) & Tax Compliance
                    </h3>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Drug License Number (Form 20/21) <span class="text-danger">*</span></label>
                            <input type="text" name="drug_license_no" value="<?=htmlspecialchars($current_store['drug_license_no'] ?? '');?>" class="form-control" required placeholder="e.g. DL-UP-VNS-20B-10842">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">GSTIN Identification Number <span class="text-danger">*</span></label>
                            <input type="text" name="gstin" value="<?=htmlspecialchars($current_store['gstin'] ?? '');?>" class="form-control" required placeholder="e.g. 09AAACA1122D1Z4">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Drug License Certificate (PDF/Image)</label>
                            <input type="file" name="drug_license_file" class="form-control" accept=".pdf,image/*">
                            <?php if(!empty($current_store['drug_license_file'])): ?>
                                <small><a href="<?=base_url($current_store['drug_license_file']);?>" target="_blank" class="text-success"><i class="fas fa-check-circle"></i> Current License File Attached</a></small>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">GST Certificate (PDF/Image)</label>
                            <input type="file" name="gst_certificate" class="form-control" accept=".pdf,image/*">
                            <?php if(!empty($current_store['gst_certificate'])): ?>
                                <small><a href="<?=base_url($current_store['gst_certificate']);?>" target="_blank" class="text-success"><i class="fas fa-check-circle"></i> Current GST File Attached</a></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="statutory-alert">
                        <i class="fas fa-info-circle" style="color: var(--cyan);"></i> <strong>Statutory Regulatory Notice:</strong> Under the Drugs & Cosmetics Act, 1940 and Pharmacy Act, 1948, online dispensation of prescription medicines is executed strictly by licensed retail chemists. UPCHAR facilitates purely order transmission and logistics routing.
                    </div>
                </div>

                <!-- Section 3: Institutional & Doctor Tagging -->
                <div class="section-card">
                    <h3 class="section-card-title">
                        <i class="fas fa-hospital-user" style="color: var(--cyan);"></i> 3. Hospital & Doctor Affiliation
                    </h3>
                    <p style="font-size: 13px; color: #64748B; margin-bottom: 16px;">
                        Mapping your store to a hospital or doctor profile prioritizes your pharmacy on their patient consultation pages.
                    </p>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Attached Hospital / Medical Center</label>
                            <select name="hospital_id" class="form-control">
                                <option value="">-- No Hospital Tagging --</option>
                                <?php foreach($hospitals as $h): ?>
                                    <option value="<?=$h['id'];?>" <?=$h['id'] == ($current_store['hospital_id'] ?? 0) ? 'selected' : '';?>>
                                        <?=$h['name'];?> (<?=$h['city'];?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Attached Primary Doctor</label>
                            <select name="associated_doctor_id" class="form-control">
                                <option value="">-- No Doctor Tagging --</option>
                                <?php foreach($doctors as $d): ?>
                                    <option value="<?=$d['id'];?>" <?=$d['id'] == ($current_store['associated_doctor_id'] ?? 0) ? 'selected' : '';?>>
                                        Dr. <?=$d['fname'];?> <?=$d['lname'];?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Operations, Delivery Radius & GPS -->
            <div class="col-md-5">
                <!-- Section 4: Operational Controls -->
                <div class="section-card">
                    <h3 class="section-card-title">
                        <i class="fas fa-sliders-h" style="color: var(--cyan);"></i> 4. Operational Controls
                    </h3>

                    <div class="form-group">
                        <label class="form-label">Operating Hours <span class="text-danger">*</span></label>
                        <input type="text" name="operating_hours" value="<?=htmlspecialchars($current_store['operating_hours'] ?? '09:00 AM - 10:00 PM');?>" class="form-control" required placeholder="e.g. 09:00 AM - 10:00 PM">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Delivery Radius Capping (KM) <span class="text-danger">*</span></label>
                        <select name="delivery_radius_km" class="form-control" required>
                            <option value="3.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 3.0 ? 'selected' : '';?>>3.0 KM (Local Neighborhood)</option>
                            <option value="5.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 5.0 ? 'selected' : '';?>>5.0 KM (Standard Urban Fleet)</option>
                            <option value="8.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 8.0 ? 'selected' : '';?>>8.0 KM (Extended Delivery)</option>
                            <option value="10.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 10.0 ? 'selected' : '';?>>10.0 KM (City Wide Hub)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Maximum Active Queue Limit</label>
                        <input type="number" name="max_queue_limit" min="5" max="100" value="<?=htmlspecialchars($current_store['max_queue_limit'] ?? 25);?>" class="form-control">
                        <small class="text-muted">Auto-throttles new orders if pending queue exceeds this limit.</small>
                    </div>

                    <div class="form-group" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed var(--card-border);">
                        <label class="form-label" style="color: var(--red);">Emergency Store Closure Switch</label>
                        <div class="switch-wrap">
                            <input type="checkbox" name="is_emergency_closed" value="1" id="emergencyToggle" <?=!empty($current_store['is_emergency_closed']) ? 'checked' : '';?>>
                            <label for="emergencyToggle" style="font-weight: 600; cursor: pointer; margin: 0; font-size: 13px;">
                                Pause incoming delivery orders immediately
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Store Address & GPS Coordinates -->
                <div class="section-card">
                    <h3 class="section-card-title">
                        <i class="fas fa-map-marked-alt" style="color: var(--cyan);"></i> 5. Location & Dispatch Coordinates
                    </h3>

                    <div class="form-group">
                        <label class="form-label">Physical Store Address <span class="text-danger">*</span></label>
                        <textarea name="address" rows="2" class="form-control" required placeholder="Shop number, floor, road, locality..."><?=htmlspecialchars($current_store['address'] ?? ($chem_profile['street'] ?? ''));?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" value="<?=htmlspecialchars($current_store['city'] ?? ($chem_profile['city'] ?? 'Varanasi'));?>" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" name="pincode" value="<?=htmlspecialchars($current_store['pincode'] ?? '221002');?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="store_lat" value="<?=htmlspecialchars($current_store['latitude'] ?? '25.31760000');?>" class="form-control" placeholder="e.g. 25.3176">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="store_lng" value="<?=htmlspecialchars($current_store['longitude'] ?? '82.97390000');?>" class="form-control" placeholder="e.g. 82.9739">
                        </div>
                    </div>

                    <button type="button" class="btn btn-block btn-default" onclick="detectGPS()" style="font-weight: 600; border-radius: 8px; margin-top: 4px;">
                        <i class="fas fa-crosshairs text-primary"></i> Detect Current GPS Coordinates
                    </button>
                </div>

                <!-- Submit Action Button -->
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-block btn-lg" style="background: linear-gradient(135deg, var(--navy) 0%, #0c4d6a 100%); color: #FFFFFF; font-weight: 800; border: none; border-radius: 10px; padding: 14px; box-shadow: 0 4px 14px rgba(8, 54, 75, 0.3);">
                        <i class="fas fa-save"></i> Save Pharmacy Profile & KYC
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Legal Compliance Disclaimer -->
<div class="legal-footer">
    <strong>STATUTORY INTERMEDIARY NOTICE:</strong> UPCHAR operates solely as a digital technology and delivery logistics intermediary platform under the Information Technology Act, 2000. All pharmaceutical inventory, storage, packaging, and dispensing are conducted exclusively by licensed partner chemist stores under the Drugs & Cosmetics Act, 1940.
</div>

<script>
function detectGPS() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            $('#store_lat').val(position.coords.latitude.toFixed(8));
            $('#store_lng').val(position.coords.longitude.toFixed(8));
            alert('GPS Coordinates captured: ' + position.coords.latitude.toFixed(4) + ', ' + position.coords.longitude.toFixed(4));
        }, function(error) {
            alert('Could not retrieve GPS coordinates: ' + error.message);
        });
    } else {
        alert('Geolocation is not supported by your browser.');
    }
}
</script>

