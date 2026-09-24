<style>
:root {
    --primary-navy: #08364B;
    --navy-dark: #041822;
    --accent-cyan: #00A8FF;
    --emergency-red: #E63946;
    --success-green: #9BC03C;
    --bg-canvas: #F8FAFC;
    --card-border: #E2E8F0;
    --text-slate: #1E293B;
    --text-muted: #64748B;
}

.profile-page-wrapper {
    padding: 24px 28px;
    background: var(--bg-canvas);
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--text-slate);
    min-height: calc(100vh - 60px);
}

/* Header & Switcher */
.profile-page-header {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(8, 54, 75, 0.04);
}

.profile-page-title h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--primary-navy);
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-page-title p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

/* Profile Hero Banner */
.profile-hero {
    background: linear-gradient(135deg, var(--primary-navy) 0%, var(--navy-dark) 100%);
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 24px;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 10px 25px -5px rgba(8, 54, 75, 0.25);
    border-bottom: 3px solid var(--accent-cyan);
}

.profile-avatar-wrap {
    width: 72px;
    height: 72px;
    border-radius: 14px;
    background: rgba(0, 168, 255, 0.15);
    border: 2px solid rgba(0, 168, 255, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: var(--accent-cyan);
    overflow: hidden;
    flex-shrink: 0;
}

.profile-avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-hero-info h2 {
    font-size: 22px;
    font-weight: 800;
    color: #FFFFFF;
    margin: 0 0 8px 0;
    letter-spacing: -0.3px;
}

.badge-verified {
    background: rgba(155, 192, 60, 0.2);
    color: #bbf7d0;
    border: 1px solid var(--success-green);
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-emergency {
    background: rgba(230, 57, 70, 0.25);
    color: #fca5a5;
    border: 1px solid var(--emergency-red);
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-active-store {
    background: rgba(0, 168, 255, 0.2);
    color: #bae6fd;
    border: 1px solid var(--accent-cyan);
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* 5-Section Nav Tabs */
.section-nav-tabs {
    display: flex;
    gap: 8px;
    background: #FFFFFF;
    padding: 8px;
    border-radius: 12px;
    border: 1px solid var(--card-border);
    margin-bottom: 24px;
    overflow-x: auto;
    white-space: nowrap;
    box-shadow: 0 2px 6px rgba(8, 54, 75, 0.03);
}

.section-tab-btn {
    border: none;
    background: transparent;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text-muted);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.section-tab-btn:hover {
    color: var(--primary-navy);
    background: rgba(0, 168, 255, 0.06);
}

.section-tab-btn.active {
    background: var(--primary-navy);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(8, 54, 75, 0.2);
}

.section-tab-btn.active .tab-icon {
    color: var(--accent-cyan) !important;
}

.section-tab-btn .tab-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 2px 7px;
    border-radius: 10px;
    font-size: 11px;
}

/* Form Section Cards */
.section-card {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    padding: 26px 28px;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(8, 54, 75, 0.03);
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    position: relative;
}

.section-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 6px 18px rgba(8, 54, 75, 0.06);
}

.section-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--card-border);
}

.section-card-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--primary-navy);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-save-badge {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--text-muted);
    background: #F1F5F9;
    padding: 4px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.form-label {
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 10px 14px;
    font-size: 13.5px;
    color: var(--text-slate);
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    border-color: var(--accent-cyan);
    box-shadow: 0 0 0 3px rgba(0, 168, 255, 0.15);
    outline: none;
}

.font-mono {
    font-family: 'JetBrains Mono', monospace;
}

.statutory-alert {
    background: rgba(8, 54, 75, 0.04);
    border: 1px solid rgba(8, 54, 75, 0.15);
    border-left: 4px solid var(--accent-cyan);
    border-radius: 8px;
    padding: 14px 16px;
    font-size: 12px;
    color: #334155;
    line-height: 1.5;
    margin-top: 16px;
}

.switch-wrap {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 8px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.legal-footer {
    text-align: center;
    padding: 20px;
    font-size: 12px;
    color: var(--text-muted);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    background: #FFFFFF;
    margin-top: 20px;
    line-height: 1.6;
}

/* Dedicated Partial Save Button */
.btn-save-section {
    background: linear-gradient(135deg, var(--primary-navy) 0%, #0d4661 100%);
    color: #FFFFFF !important;
    font-weight: 700;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(8, 54, 75, 0.2);
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-save-section:hover {
    background: linear-gradient(135deg, #0d4661 0%, var(--primary-navy) 100%);
    box-shadow: 0 6px 18px rgba(8, 54, 75, 0.3);
    transform: translateY(-1px);
}

.btn-save-section:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.btn-save-section.btn-saved-success {
    background: var(--success-green) !important;
    box-shadow: 0 4px 14px rgba(155, 192, 60, 0.4);
}

.section-footer-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid var(--card-border);
}

.section-status-msg {
    font-size: 13px;
    font-weight: 600;
    display: none;
}

/* Floating Toast Notification */
.profile-toast-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
}

.profile-toast {
    background: #FFFFFF;
    border: 1px solid #cbd5e1;
    border-left: 4px solid var(--success-green);
    border-radius: 10px;
    padding: 14px 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 320px;
    max-width: 440px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-slate);
    pointer-events: auto;
    animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.profile-toast.error-toast {
    border-left-color: var(--emergency-red);
}

@keyframes toastSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.fade-out {
    animation: toastFadeOut 0.3s forwards;
}

@keyframes toastFadeOut {
    to {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
    }
}

/* Section visibility */
.section-panel {
    display: none;
}

.section-panel.active {
    display: block;
    animation: fadeIn 0.25s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}

.show-all-mode .section-panel {
    display: block !important;
}
</style>

<div class="profile-page-wrapper">

    <!-- Toast Notification Host -->
    <div id="toastContainer" class="profile-toast-container"></div>

    <!-- Top Action & Navigation Ribbon -->
    <div class="profile-page-header">
        <div class="profile-page-title">
            <h2>
                <i class="fa fa-medkit" style="color: var(--accent-cyan);"></i> 
                Chemist Partner Profile & Regulatory Compliance
            </h2>
            <p>Form 20/21 Drug Licenses, pharmacist in-charge identity, delivery GPS perimeter, and clinic affiliations.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">Switch Pharmacy:</span>
                    <select class="form-control" onchange="location.href='<?=base_url('pharmacy/profile/edit?store_id=');?>'+this.value+'&tab='+getCurrentTab()" style="width: auto; height: 36px; font-weight: 600; border-radius: 8px;">
                        <?php foreach($stores as $st): ?>
                            <option value="<?=$st['id'];?>" <?=$st['id'] == ($current_store['id'] ?? 0) ? 'selected' : '';?>>
                                <?=$st['store_name'];?> (<?=$st['city'];?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <a href="<?=base_url('medical-dashboard');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 7px 14px; border: 1px solid var(--card-border);">
                <i class="fa fa-arrow-left me-1"></i> Chemist Command Center
            </a>
            <button onclick="location.reload();" class="btn btn-default" style="border-radius: 8px; padding: 7px 12px; border: 1px solid var(--card-border);" title="Refresh">
                <i class="fa fa-refresh"></i>
            </button>
        </div>
    </div>

    <?php if(!empty($flashmsg)): ?>
        <div style="margin-bottom: 24px;"><?=$flashmsg;?></div>
    <?php endif; ?>

    <!-- Profile Hero Card -->
    <div class="profile-hero">
        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div class="profile-avatar-wrap" id="heroStoreAvatar">
                <?php if(!empty($current_store['store_photo'])): ?>
                    <img src="<?=base_url($current_store['store_photo']);?>" alt="Store Photo">
                <?php else: ?>
                    <i class="fa fa-hospital-o"></i>
                <?php endif; ?>
            </div>
            <div class="profile-hero-info">
                <h2 id="heroStoreName"><?=htmlspecialchars($current_store['store_name'] ?? 'Sanjivani 24x7 Chemist & Druggists');?></h2>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                    <span class="badge-verified">
                        <i class="fa fa-check-circle"></i> KYC Verified Licensed Retail Chemist
                    </span>
                    <span class="badge-active-store">
                        <i class="fa fa-hashtag"></i> Store ID: #<?=htmlspecialchars($current_store['id'] ?? 1);?>
                    </span>
                    <span id="heroEmergencyBadge">
                        <?php if(!empty($current_store['is_emergency_closed'])): ?>
                            <span class="badge-emergency">
                                <i class="fa fa-pause-circle"></i> Emergency Orders Paused
                            </span>
                        <?php else: ?>
                            <span class="badge-verified" style="background: rgba(155, 192, 60, 0.2); color: #bbf7d0;">
                                <i class="fa fa-circle" style="font-size: 8px;"></i> Live Order Accepting Active
                            </span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 11.5px; text-transform: uppercase; color: rgba(255,255,255,0.7); font-weight: 700;">Form 20/21 Status</div>
            <div id="heroDlStatus" style="font-size: 16px; font-weight: 800; color: #FFFFFF; font-family: monospace; margin-top: 2px;">
                <?=htmlspecialchars($current_store['dl_20'] ?? ($current_store['drug_license_no'] ?? 'UP-VNS-20B-88391'));?>
            </div>
            <div style="font-size: 11.5px; color: var(--accent-cyan); margin-top: 4px;">
                <i class="fa fa-shield"></i> FDA UP Good Pharmacy Practice
            </div>
        </div>
    </div>

    <!-- 5 Dedicated Section Nav Tabs -->
    <div class="section-nav-tabs">
        <button type="button" class="section-tab-btn <?=($active_tab == 'identity' || empty($active_tab)) ? 'active' : '';?>" onclick="switchTab('identity', this)">
            <i class="fa fa-id-card tab-icon" style="color: var(--accent-cyan);"></i>
            <span>1. Store & Pharmacist Identity</span>
        </button>
        <button type="button" class="section-tab-btn <?=$active_tab == 'compliance' ? 'active' : '';?>" onclick="switchTab('compliance', this)">
            <i class="fa fa-file-text-o tab-icon" style="color: var(--accent-cyan);"></i>
            <span>2. Drug License & Tax Compliance</span>
        </button>
        <button type="button" class="section-tab-btn <?=$active_tab == 'affiliation' ? 'active' : '';?>" onclick="switchTab('affiliation', this)">
            <i class="fa fa-hospital-o tab-icon" style="color: var(--accent-cyan);"></i>
            <span>3. Hospital & Doctor Affiliation</span>
        </button>
        <button type="button" class="section-tab-btn <?=$active_tab == 'operations' ? 'active' : '';?>" onclick="switchTab('operations', this)">
            <i class="fa fa-sliders tab-icon" style="color: var(--accent-cyan);"></i>
            <span>4. Operational Controls & SLAs</span>
        </button>
        <button type="button" class="section-tab-btn <?=$active_tab == 'location' ? 'active' : '';?>" onclick="switchTab('location', this)">
            <i class="fa fa-map-marker tab-icon" style="color: var(--emergency-red);"></i>
            <span>5. Location & Coordinates</span>
        </button>
        <button type="button" class="section-tab-btn <?=$active_tab == 'all' ? 'active' : '';?>" onclick="switchTab('all', this)" style="margin-left: auto;">
            <i class="fa fa-th-list tab-icon"></i>
            <span>View All Sections</span>
        </button>
    </div>

    <!-- Section Container Panels -->
    <div id="sectionContainer">

        <!-- ========================================== -->
        <!-- SECTION 1: Pharmacy Store & Pharmacist Identity -->
        <!-- ========================================== -->
        <div class="section-panel <?=($active_tab == 'identity' || empty($active_tab) || $active_tab == 'all') ? 'active' : '';?>" id="panel_identity">
            <div class="section-card">
                <div class="section-card-header">
                    <h3 class="section-card-title">
                        <i class="fa fa-id-card" style="color: var(--accent-cyan);"></i> 
                        1. Pharmacy Store & Pharmacist Identity
                    </h3>
                    <div class="section-save-badge">
                        <i class="fa fa-lock text-success"></i> Saves Independently &bull; Partial Sync
                    </div>
                </div>

                <form id="form_identity" class="partial-profile-form" action="<?=base_url('pharmacy/profile/update');?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="store_id" value="<?=$current_store['id'] ?? 1;?>">
                    <input type="hidden" name="section" value="identity">

                    <div class="form-group">
                        <label class="form-label">Trade / Chemist Store Name <span class="text-danger">*</span></label>
                        <input type="text" name="store_name" value="<?=htmlspecialchars($current_store['store_name'] ?? '');?>" class="form-control" required placeholder="e.g. Sanjivani 24x7 Chemist & Druggists">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Registered Pharmacist In-Charge <span class="text-danger">*</span></label>
                            <input type="text" name="pharmacist_name" value="<?=htmlspecialchars($current_store['pharmacist_name'] ?? ($chem_profile['fname'] ?? 'Rameshwar Verma, B.Pharm'));?>" class="form-control" required placeholder="Pharmacist Full Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Pharmacist Reg. No. (State Pharmacy Council)</label>
                            <input type="text" value="<?=htmlspecialchars($chem_profile['regd_no'] ?? 'PCI-UP-482910');?>" class="form-control font-mono" readonly style="background: #F8FAFC;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Primary Business Helpline Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" value="<?=htmlspecialchars($current_store['phone'] ?? ($chem_profile['mobile'] ?? '9876543210'));?>" class="form-control font-mono" required placeholder="10-digit mobile number">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Official Support Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="<?=htmlspecialchars($current_store['email'] ?? ($chem_profile['email'] ?? 'sanjivani@upchar.health'));?>" class="form-control" required placeholder="partner@upchar.health">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Update Store Front Photographic Proof</label>
                        <input type="file" name="store_photo" class="form-control" accept="image/*">
                        <small class="text-muted" style="font-size: 11.5px; display: block; margin-top: 4px;">
                            <i class="fa fa-camera me-1"></i> Upload photograph showing store entrance, board signage, and dispensing counter. (JPG/PNG, Max 4MB)
                        </small>
                    </div>

                    <div class="section-footer-actions">
                        <span class="section-status-msg text-success" id="status_identity">
                            <i class="fa fa-check-circle"></i> Identity saved successfully!
                        </span>
                        <button type="submit" class="btn-save-section ms-auto">
                            <i class="fa fa-save"></i> Save Store & Pharmacist Identity
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 2: Drug License (Form 20/21) & Tax Compliance -->
        <!-- ========================================== -->
        <div class="section-panel <?=$active_tab == 'compliance' ? 'active' : '';?>" id="panel_compliance">
            <div class="section-card">
                <div class="section-card-header">
                    <h3 class="section-card-title">
                        <i class="fa fa-file-text-o" style="color: var(--accent-cyan);"></i> 
                        2. Drug License (Form 20/21) & Tax Compliance
                    </h3>
                    <div class="section-save-badge">
                        <i class="fa fa-shield text-primary"></i> Statutory Regulatory Compliance &bull; Partial Save
                    </div>
                </div>

                <form id="form_compliance" class="partial-profile-form" action="<?=base_url('pharmacy/profile/update');?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="store_id" value="<?=$current_store['id'] ?? 1;?>">
                    <input type="hidden" name="section" value="compliance">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Drug License Form 20 (Allopathic Retail) <span class="text-danger">*</span></label>
                            <input type="text" name="dl_20" value="<?=htmlspecialchars($current_store['dl_20'] ?? ($current_store['drug_license_no'] ?? 'UP-VNS-20B-88391'));?>" class="form-control font-mono text-uppercase" required placeholder="e.g. UP-VNS-20B-88391">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Drug License Form 21 (Schedule C/C1) <span class="text-danger">*</span></label>
                            <input type="text" name="dl_21" value="<?=htmlspecialchars($current_store['dl_21'] ?? 'UP-VNS-21B-88392');?>" class="form-control font-mono text-uppercase" required placeholder="e.g. UP-VNS-21B-88392">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">GSTIN (15 Digits) <span class="text-danger">*</span></label>
                            <input type="text" name="gstin" value="<?=htmlspecialchars($current_store['gstin'] ?? '09AABCU9603R1ZM');?>" class="form-control font-mono text-uppercase" maxlength="15" required placeholder="e.g. 09AABCU9603R1ZM">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Master License Reference Number</label>
                            <input type="text" name="drug_license_no" value="<?=htmlspecialchars($current_store['drug_license_no'] ?? 'UP-VNS-20B-88391');?>" class="form-control font-mono" placeholder="Form 20/21 Combined Number">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Upload Form 20/21 License Copy (PDF/Image)</label>
                            <input type="file" name="drug_license_file" class="form-control" accept=".pdf,image/*">
                            <div id="dlFileLink">
                                <?php if(!empty($current_store['drug_license_file'])): ?>
                                    <small style="display: block; margin-top: 5px;"><a href="<?=base_url($current_store['drug_license_file']);?>" target="_blank" style="color: #16a34a; font-weight: 600;"><i class="fa fa-check-circle"></i> View Current License Certificate</a></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Upload GST Certificate (PDF/Image)</label>
                            <input type="file" name="gst_certificate" class="form-control" accept=".pdf,image/*">
                            <div id="gstFileLink">
                                <?php if(!empty($current_store['gst_certificate'])): ?>
                                    <small style="display: block; margin-top: 5px;"><a href="<?=base_url($current_store['gst_certificate']);?>" target="_blank" style="color: #16a34a; font-weight: 600;"><i class="fa fa-check-circle"></i> View Current GST Certificate</a></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="statutory-alert">
                        <i class="fa fa-shield" style="color: var(--accent-cyan); font-size: 14px;"></i> 
                        <strong>Statutory Regulatory Notice:</strong> Under the Drugs & Cosmetics Act, 1940 and Pharmacy Act, 1948, online dispensation of prescription medicines is executed strictly by licensed retail chemists. UPCHAR acts purely as an intermediary technology and logistics platform.
                    </div>

                    <div class="section-footer-actions">
                        <span class="section-status-msg text-success" id="status_compliance">
                            <i class="fa fa-check-circle"></i> Compliance saved successfully!
                        </span>
                        <button type="submit" class="btn-save-section ms-auto">
                            <i class="fa fa-save"></i> Save Drug License & Tax Compliance
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 3: Hospital & Doctor Affiliation -->
        <!-- ========================================== -->
        <div class="section-panel <?=$active_tab == 'affiliation' ? 'active' : '';?>" id="panel_affiliation">
            <div class="section-card">
                <div class="section-card-header">
                    <h3 class="section-card-title">
                        <i class="fa fa-hospital-o" style="color: var(--accent-cyan);"></i> 
                        3. Hospital & Doctor Affiliation
                    </h3>
                    <div class="section-save-badge">
                        <i class="fa fa-stethoscope text-primary"></i> OPD Routing Affinity &bull; Partial Save
                    </div>
                </div>

                <form id="form_affiliation" class="partial-profile-form" action="<?=base_url('pharmacy/profile/update');?>" method="post">
                    <input type="hidden" name="store_id" value="<?=$current_store['id'] ?? 1;?>">
                    <input type="hidden" name="section" value="affiliation">

                    <p style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 20px; line-height: 1.6;">
                        Linking your pharmacy to an adjacent clinic or hospital (e.g. Oriana Hospital) provides top algorithmic search ranking and automated prescription routing when doctors prescribe medications to outpatients.
                    </p>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Attached Hospital / Medical Center</label>
                            <select name="hospital_id" class="form-control">
                                <option value="">-- No Hospital Tagging (Standalone Chemist) --</option>
                                <?php foreach($hospitals as $h): ?>
                                    <option value="<?=$h['id'];?>" <?=$h['id'] == ($current_store['hospital_id'] ?? 11) ? 'selected' : '';?>>
                                        <?=$h['name'];?> (<?=$h['city'] ?? 'Varanasi';?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted" style="font-size: 11.5px; display: block; margin-top: 4px;">
                                Primary facility for fast outpatient pick-and-pack fulfillment.
                            </small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Attached Primary Consulting Doctor</label>
                            <select name="associated_doctor_id" class="form-control">
                                <option value="">-- No Specific Doctor Tagging --</option>
                                <?php foreach($doctors as $d): ?>
                                    <option value="<?=$d['id'];?>" <?=$d['id'] == ($current_store['associated_doctor_id'] ?? 0) ? 'selected' : '';?>>
                                        Dr. <?=$d['fname'];?> <?=$d['lname'];?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted" style="font-size: 11.5px; display: block; margin-top: 4px;">
                                Physician whose digital prescriptions will automatically prioritize this chemist counter.
                            </small>
                        </div>
                    </div>

                    <div class="section-footer-actions">
                        <span class="section-status-msg text-success" id="status_affiliation">
                            <i class="fa fa-check-circle"></i> Affiliations saved successfully!
                        </span>
                        <button type="submit" class="btn-save-section ms-auto">
                            <i class="fa fa-save"></i> Save Hospital & Doctor Affiliation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 4: Operational Controls & Dispatch SLAs -->
        <!-- ========================================== -->
        <div class="section-panel <?=$active_tab == 'operations' ? 'active' : '';?>" id="panel_operations">
            <div class="section-card">
                <div class="section-card-header">
                    <h3 class="section-card-title">
                        <i class="fa fa-sliders" style="color: var(--accent-cyan);"></i> 
                        4. Operational Controls & Dispatch SLAs
                    </h3>
                    <div class="section-save-badge">
                        <i class="fa fa-clock-o text-primary"></i> Queue & Dispatch Rules &bull; Partial Save
                    </div>
                </div>

                <form id="form_operations" class="partial-profile-form" action="<?=base_url('pharmacy/profile/update');?>" method="post">
                    <input type="hidden" name="store_id" value="<?=$current_store['id'] ?? 1;?>">
                    <input type="hidden" name="section" value="operations">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Store Operating Hours <span class="text-danger">*</span></label>
                            <input type="text" name="operating_hours" value="<?=htmlspecialchars($current_store['operating_hours'] ?? '08:00 AM - 11:00 PM (24x7 Emergency)');?>" class="form-control" required placeholder="e.g. 08:00 AM - 11:00 PM">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Delivery Dispatch Radius Capping <span class="text-danger">*</span></label>
                            <select name="delivery_radius_km" class="form-control" required>
                                <option value="3.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 3.0 ? 'selected' : '';?>>3.0 KM (Ultra-Fast 15-Minute Delivery)</option>
                                <option value="5.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 5.0 ? 'selected' : '';?>>5.0 KM (Standard Urban Fleet Perimeter)</option>
                                <option value="8.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 8.0 ? 'selected' : '';?>>8.0 KM (Extended Neighborhood Coverage)</option>
                                <option value="10.0" <?=($current_store['delivery_radius_km'] ?? 5.0) == 10.0 ? 'selected' : '';?>>10.0 KM (City Wide Central Hub)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Maximum Active Packing Queue Limit</label>
                        <input type="number" name="max_queue_limit" min="5" max="100" value="<?=htmlspecialchars($current_store['max_queue_limit'] ?? 25);?>" class="form-control font-mono">
                        <small class="text-muted" style="font-size: 11.5px; display: block; margin-top: 4px;">
                            Auto-throttles incoming prescription assignments if pending packing queue exceeds this threshold.
                        </small>
                    </div>

                    <div class="form-group" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed var(--card-border);">
                        <label class="form-label" style="color: var(--emergency-red);"><i class="fa fa-power-off me-1"></i> Emergency Store Closure Switch</label>
                        <div class="switch-wrap">
                            <input type="checkbox" name="is_emergency_closed" value="1" id="emergencyToggle" <?=!empty($current_store['is_emergency_closed']) ? 'checked' : '';?> style="width: 20px; height: 20px; cursor: pointer;">
                            <label for="emergencyToggle" style="font-weight: 700; cursor: pointer; margin: 0; font-size: 13.5px; color: var(--emergency-red);">
                                Pause incoming prescription orders immediately (Maintenance / Inventory Stocktaking)
                            </label>
                        </div>
                    </div>

                    <div class="section-footer-actions">
                        <span class="section-status-msg text-success" id="status_operations">
                            <i class="fa fa-check-circle"></i> Operational controls saved successfully!
                        </span>
                        <button type="submit" class="btn-save-section ms-auto">
                            <i class="fa fa-save"></i> Save Operational Controls & SLAs
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECTION 5: Location & Dispatch Coordinates -->
        <!-- ========================================== -->
        <div class="section-panel <?=$active_tab == 'location' ? 'active' : '';?>" id="panel_location">
            <div class="section-card">
                <div class="section-card-header">
                    <h3 class="section-card-title">
                        <i class="fa fa-map-marker" style="color: var(--emergency-red);"></i> 
                        5. Location & Dispatch Coordinates
                    </h3>
                    <div class="section-save-badge">
                        <i class="fa fa-location-arrow text-danger"></i> Rider Dispatch GPS &bull; Partial Save
                    </div>
                </div>

                <form id="form_location" class="partial-profile-form" action="<?=base_url('pharmacy/profile/update');?>" method="post">
                    <input type="hidden" name="store_id" value="<?=$current_store['id'] ?? 1;?>">
                    <input type="hidden" name="section" value="location">

                    <div class="form-group">
                        <label class="form-label">Physical Store Street Address <span class="text-danger">*</span></label>
                        <textarea name="address" rows="2" class="form-control" required placeholder="Shop number, building, road, locality..."><?=htmlspecialchars($current_store['address'] ?? ($chem_profile['street'] ?? 'Shop 4, Durgakund Road, Near Kabir Mandir, Varanasi'));?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" value="<?=htmlspecialchars($current_store['city'] ?? ($chem_profile['city'] ?? 'Varanasi'));?>" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" name="pincode" value="<?=htmlspecialchars($current_store['pincode'] ?? '221005');?>" class="form-control font-mono" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="store_lat" value="<?=htmlspecialchars($current_store['latitude'] ?? '25.31760000');?>" class="form-control font-mono" placeholder="e.g. 25.3176">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="store_lng" value="<?=htmlspecialchars($current_store['longitude'] ?? '82.97390000');?>" class="form-control font-mono" placeholder="e.g. 82.9739">
                        </div>
                    </div>

                    <div style="margin-top: 10px;">
                        <button type="button" class="btn btn-default" onclick="detectGPS()" style="font-weight: 700; border-radius: 8px; border: 1px solid var(--accent-cyan); color: var(--primary-navy); padding: 8px 18px;">
                            <i class="fa fa-crosshairs" style="color: var(--accent-cyan); margin-right: 6px;"></i> Detect Current GPS Coordinates
                        </button>
                    </div>

                    <div class="section-footer-actions">
                        <span class="section-status-msg text-success" id="status_location">
                            <i class="fa fa-check-circle"></i> Location coordinates saved successfully!
                        </span>
                        <button type="submit" class="btn-save-section ms-auto">
                            <i class="fa fa-save"></i> Save Location & Coordinates
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Legal Compliance Disclaimer -->
    <div class="legal-footer">
        <strong>STATUTORY INTERMEDIARY NOTICE:</strong> UPCHAR operates solely as a digital technology and delivery logistics intermediary platform under the Information Technology Act, 2000. All pharmaceutical inventory, storage, cold-chain maintenance, packaging, and dispensing are conducted exclusively by licensed partner chemist stores under the Drugs & Cosmetics Act, 1940.
    </div>

</div>

<script>
// Pure Vanilla JavaScript implementation (Zero dependency on jQuery)
function switchTab(tabName, btnElem) {
    document.querySelectorAll('.section-tab-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    if (btnElem) {
        btnElem.classList.add('active');
    }

    var container = document.getElementById('sectionContainer');
    var panels = document.querySelectorAll('.section-panel');

    if (tabName === 'all') {
        container.classList.add('show-all-mode');
        panels.forEach(function(p) {
            p.classList.add('active');
        });
        updateUrlTab('all');
    } else {
        container.classList.remove('show-all-mode');
        panels.forEach(function(p) {
            p.classList.remove('active');
        });
        var targetPanel = document.getElementById('panel_' + tabName);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }
        updateUrlTab(tabName);
    }
}

function updateUrlTab(tabName) {
    if (window.history && window.history.replaceState) {
        var url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        window.history.replaceState(null, '', url.toString());
    }
}

function getCurrentTab() {
    var activeBtn = document.querySelector('.section-tab-btn.active');
    if (!activeBtn) return 'identity';
    var onclickAttr = activeBtn.getAttribute('onclick') || '';
    var match = onclickAttr.match(/switchTab\('([^']+)'/);
    return match ? match[1] : 'identity';
}

function showToast(message, isError) {
    var container = document.getElementById('toastContainer');
    if (!container) return;

    var toast = document.createElement('div');
    toast.className = 'profile-toast' + (isError ? ' error-toast' : '');
    toast.innerHTML = (isError ? '<i class="fa fa-exclamation-circle text-danger" style="font-size:18px;"></i> ' : '<i class="fa fa-check-circle text-success" style="font-size:18px;"></i> ') +
                      '<span>' + message + '</span>';
    container.appendChild(toast);

    setTimeout(function() {
        toast.classList.add('fade-out');
        setTimeout(function() {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 350);
    }, 4000);
}

// Attach AJAX form handler via Vanilla JS
function initPartialForms() {
    var forms = document.querySelectorAll('.partial-profile-form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var sectionInput = form.querySelector('input[name="section"]');
            var section = sectionInput ? sectionInput.value : '';
            var submitBtn = form.querySelector('button[type="submit"]');
            var origBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            var statusMsg = document.getElementById('status_' + section);

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
            }
            if (statusMsg) {
                statusMsg.style.display = 'none';
            }

            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(resp) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                }

                if (resp && resp.status) {
                    if (submitBtn) {
                        submitBtn.classList.add('btn-saved-success');
                        submitBtn.innerHTML = '<i class="fa fa-check"></i> Saved!';
                    }
                    if (statusMsg) {
                        statusMsg.style.display = 'inline-block';
                    }

                    showToast(resp.message || 'Changes saved successfully.', false);

                    // Update Hero elements dynamically
                    if (resp.store_name) {
                        var heroName = document.getElementById('heroStoreName');
                        if (heroName) heroName.textContent = resp.store_name;
                    }
                    if (resp.dl_20) {
                        var heroDl = document.getElementById('heroDlStatus');
                        if (heroDl) heroDl.textContent = resp.dl_20;
                    }
                    if (resp.store_photo) {
                        var heroAvatar = document.getElementById('heroStoreAvatar');
                        if (heroAvatar) heroAvatar.innerHTML = '<img src="' + resp.store_photo + '" alt="Store Photo">';
                    }
                    if (resp.drug_license_file) {
                        var dlLink = document.getElementById('dlFileLink');
                        if (dlLink) dlLink.innerHTML = '<small style="display: block; margin-top: 5px;"><a href="' + resp.drug_license_file + '" target="_blank" style="color: #16a34a; font-weight: 600;"><i class="fa fa-check-circle"></i> View Current License Certificate</a></small>';
                    }
                    if (resp.gst_certificate) {
                        var gstLink = document.getElementById('gstFileLink');
                        if (gstLink) gstLink.innerHTML = '<small style="display: block; margin-top: 5px;"><a href="' + resp.gst_certificate + '" target="_blank" style="color: #16a34a; font-weight: 600;"><i class="fa fa-check-circle"></i> View Current GST Certificate</a></small>';
                    }
                    if (resp.is_emergency_closed !== null && resp.is_emergency_closed !== undefined) {
                        var emergencyBadge = document.getElementById('heroEmergencyBadge');
                        if (emergencyBadge) {
                            if (resp.is_emergency_closed == 1) {
                                emergencyBadge.innerHTML = '<span class="badge-emergency"><i class="fa fa-pause-circle"></i> Emergency Orders Paused</span>';
                            } else {
                                emergencyBadge.innerHTML = '<span class="badge-verified" style="background: rgba(155, 192, 60, 0.2); color: #bbf7d0;"><i class="fa fa-circle" style="font-size: 8px;"></i> Live Order Accepting Active</span>';
                            }
                        }
                    }

                    setTimeout(function() {
                        if (submitBtn) {
                            submitBtn.classList.remove('btn-saved-success');
                            submitBtn.innerHTML = origBtnHtml;
                        }
                        if (statusMsg) {
                            statusMsg.style.display = 'none';
                        }
                    }, 3000);

                } else {
                    if (submitBtn) {
                        submitBtn.innerHTML = origBtnHtml;
                    }
                    showToast((resp && resp.message) ? resp.message : 'Failed to save changes.', true);
                }
            })
            .catch(function(err) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origBtnHtml;
                }
                showToast('Save failed. Please check network connection.', true);
            });
        });
    });
}

// Geolocation GPS Helper
function detectGPS() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latElem = document.getElementById('store_lat');
            var lngElem = document.getElementById('store_lng');
            if (latElem) latElem.value = position.coords.latitude.toFixed(8);
            if (lngElem) lngElem.value = position.coords.longitude.toFixed(8);
            showToast('GPS Coordinates detected: Lat ' + position.coords.latitude.toFixed(6) + ', Lng ' + position.coords.longitude.toFixed(6), false);
        }, function(error) {
            showToast('Could not retrieve GPS coordinates: ' + error.message, true);
        });
    } else {
        showToast('Geolocation is not supported by your browser.', true);
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPartialForms);
} else {
    initPartialForms();
}
</script>
