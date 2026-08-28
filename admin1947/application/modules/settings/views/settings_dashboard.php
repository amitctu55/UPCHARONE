<style>
  :root {
    --adm-primary: #00a896;
    --adm-primary-dark: #008f80;
    --adm-navy: #1d2a44;
    --adm-navy-dark: #131e33;
    --adm-card-bg: #ffffff;
    --adm-border: #e2e8f0;
    --adm-text: #1e293b;
    --adm-muted: #64748b;
    --adm-radius: 10px;
    --adm-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
  }

  .settings-wrapper {
    padding: 15px 5px;
    font-family: 'Inter', sans-serif;
  }

  .settings-header-card {
    background: linear-gradient(135deg, var(--adm-navy) 0%, #2c3e66 100%);
    border-radius: var(--adm-radius);
    padding: 24px;
    color: #ffffff;
    margin-bottom: 24px;
    box-shadow: 0 10px 25px -5px rgba(29, 42, 68, 0.25);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
  }

  .settings-header-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .settings-header-subtitle {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
  }

  .settings-quick-actions {
    display: flex;
    gap: 10px;
    align-items: center;
  }

  .btn-adm-teal {
    background: var(--adm-primary);
    color: #ffffff;
    border: none;
    font-weight: 600;
    border-radius: 6px;
    padding: 8px 16px;
    transition: all 0.2s;
  }
  .btn-adm-teal:hover {
    background: var(--adm-primary-dark);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
  }

  .btn-adm-outline {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 500;
    border-radius: 6px;
    padding: 8px 14px;
    transition: all 0.2s;
  }
  .btn-adm-outline:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
  }

  /* Navigation Tabs */
  .nav-tabs-custom-modern {
    background: transparent;
    border: none;
  }

  .nav-tabs-custom-modern > .nav-tabs {
    border-bottom: 2px solid var(--adm-border);
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
  }

  .nav-tabs-custom-modern > .nav-tabs > li > a {
    border: none !important;
    border-radius: 8px 8px 0 0;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 14px;
    color: var(--adm-muted);
    background: #f1f5f9;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .nav-tabs-custom-modern > .nav-tabs > li.active > a,
  .nav-tabs-custom-modern > .nav-tabs > li.active > a:hover {
    background: #ffffff !important;
    color: var(--adm-primary) !important;
    border-bottom: 3px solid var(--adm-primary) !important;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.03);
  }

  .nav-tabs-custom-modern > .nav-tabs > li > a:hover {
    background: #e2e8f0;
    color: var(--adm-navy);
  }

  /* Form Panels */
  .settings-card {
    background: var(--adm-card-bg);
    border-radius: var(--adm-radius);
    padding: 28px;
    box-shadow: var(--adm-shadow);
    border: 1px solid var(--adm-border);
    margin-bottom: 25px;
  }

  .card-section-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--adm-navy);
    margin-top: 0;
    margin-bottom: 18px;
    padding-bottom: 10px;
    border-bottom: 1px dashed var(--adm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .form-group-modern {
    margin-bottom: 20px;
  }

  .form-group-modern label {
    font-size: 13px;
    font-weight: 600;
    color: var(--adm-text);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .form-group-modern .form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 9px 13px;
    height: auto;
    font-size: 13.5px;
    box-shadow: none;
    transition: all 0.2s;
  }

  .form-group-modern .form-control:focus {
    border-color: var(--adm-primary);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
  }

  .input-hint {
    font-size: 12px;
    color: var(--adm-muted);
    margin-top: 5px;
    display: block;
  }

  /* Secret / Password Input With Toggle */
  .input-group-secret {
    position: relative;
    display: flex;
  }

  .btn-toggle-secret {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-left: none;
    border-radius: 0 6px 6px 0;
    padding: 0 14px;
    color: var(--adm-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: all 0.2s;
  }
  .btn-toggle-secret:hover {
    background: #f1f5f9;
    color: var(--adm-navy);
  }

  /* Color Picker Sync */
  .color-picker-box {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .color-picker-input {
    width: 44px;
    height: 40px;
    padding: 2px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    cursor: pointer;
    background: none;
  }

  /* Image Upload Preview Card */
  .media-upload-card {
    border: 1px dashed #cbd5e1;
    border-radius: 8px;
    padding: 15px;
    background: #f8fafc;
    text-align: center;
    transition: all 0.2s;
  }
  .media-upload-card:hover {
    border-color: var(--adm-primary);
    background: #f0fdfa;
  }
  .media-preview-container {
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
  }
  .media-preview-img {
    max-height: 55px;
    max-width: 100%;
    object-fit: contain;
    border-radius: 4px;
  }

  /* Switches */
  .switch-modern {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
    margin: 0;
  }
  .switch-modern input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  .slider-modern {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 24px;
  }
  .slider-modern:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  }
  input:checked + .slider-modern {
    background-color: var(--adm-primary);
  }
  input:checked + .slider-modern:before {
    transform: translateX(24px);
  }

  /* Health Badges */
  .health-metric-card {
    background: #ffffff;
    border: 1px solid var(--adm-border);
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }
  .health-metric-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }
  .health-good { background: #dcfce7; color: #15803d; }
  .health-warning { background: #fef9c3; color: #a16207; }
  .health-danger { background: #fee2e2; color: #b91c1c; }

  /* Audit Table */
  .audit-table th {
    background: #f8fafc;
    color: var(--adm-muted);
    font-weight: 600;
    font-size: 12.5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--adm-border) !important;
  }
  .audit-table td {
    vertical-align: middle !important;
    font-size: 13px;
  }

  .badge-category {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 4px;
    text-transform: uppercase;
  }
  .cat-general { background: #e0f2fe; color: #0369a1; }
  .cat-email { background: #fef3c7; color: #b45309; }
  .cat-sms { background: #ecfdf5; color: #047857; }
  .cat-integrations { background: #f3e8ff; color: #7e22ce; }
  .cat-security { background: #ffe4e6; color: #be123c; }

  /* Save Sticky Footer */
  .settings-save-bar {
    position: sticky;
    bottom: 15px;
    background: #ffffff;
    border: 1px solid var(--adm-border);
    border-radius: 8px;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    z-index: 100;
    margin-top: 20px;
  }
</style>

<div class="content-wrapper settings-wrapper">
  <section class="content">

    <!-- Flash message from session -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <?=$this->session->flashdata('flashmsg');?>
    <?php endif; ?>

    <!-- AJAX Alert Notification Container -->
    <div id="ajaxAlertContainer"></div>

    <!-- Header Card -->
    <div class="settings-header-card">
      <div>
        <h1 class="settings-header-title">
          <i class="fa fa-cogs" style="color: var(--adm-primary);"></i> System Settings Portal
        </h1>
        <p class="settings-header-subtitle">
          Manage brand identity, communication gateways, security parameters, and third-party healthcare APIs
        </p>
      </div>
      <div class="settings-quick-actions">
        <button type="button" class="btn btn-adm-outline" id="btnFlushCache" title="Clear application settings cache">
          <i class="fa fa-refresh"></i> Flush Cache
        </button>
        <a href="<?=base_url('settings/download_db_backup');?>" class="btn btn-adm-outline" title="Download secure database SQL snapshot">
          <i class="fa fa-database"></i> Backup DB
        </a>
        <span class="badge" style="background: rgba(0, 168, 150, 0.2); color: #00e6cb; padding: 8px 12px; font-size: 12px; border-radius: 6px;">
          <i class="fa fa-shield"></i> AES-256 Encrypted
        </span>
      </div>
    </div>

    <!-- Tabbed Navigation System -->
    <div class="nav-tabs-custom-modern">
      <ul class="nav nav-tabs" id="settingsTabs">
        <li class="<?=$active_tab === 'general' ? 'active' : '';?>">
          <a href="#tab_general" data-toggle="tab">
            <i class="fa fa-globe"></i> General & Branding
          </a>
        </li>
        <li class="<?=$active_tab === 'email' ? 'active' : '';?>">
          <a href="#tab_email" data-toggle="tab">
            <i class="fa fa-envelope-o"></i> Email Gateway
          </a>
        </li>
        <li class="<?=$active_tab === 'sms' ? 'active' : '';?>">
          <a href="#tab_sms" data-toggle="tab">
            <i class="fa fa-commenting-o"></i> SMS & WhatsApp
          </a>
        </li>
        <li class="<?=$active_tab === 'integrations' ? 'active' : '';?>">
          <a href="#tab_integrations" data-toggle="tab">
            <i class="fa fa-plug"></i> Third-Party APIs
          </a>
        </li>
        <li class="<?=$active_tab === 'security' ? 'active' : '';?>">
          <a href="#tab_security" data-toggle="tab">
            <i class="fa fa-lock"></i> Security & Maintenance
          </a>
        </li>
        <li class="<?=$active_tab === 'audit' ? 'active' : '';?>">
          <a href="#tab_audit" data-toggle="tab">
            <i class="fa fa-history"></i> Audit Trail
          </a>
        </li>
        <li class="<?=$active_tab === 'health' ? 'active' : '';?>">
          <a href="#tab_health" data-toggle="tab">
            <i class="fa fa-heartbeat"></i> System Diagnostics
          </a>
        </li>
      </ul>

      <div class="tab-content" style="padding: 0;">

        <!-- ==========================================
             TAB 1: GENERAL & BRANDING
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'general' ? 'active' : '';?>" id="tab_general">
          <form class="ajaxSettingsForm" action="<?=base_url('settings/save');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="category" value="general">

            <!-- Section 1: Brand Identity -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-id-badge text-primary"></i> Brand Identity & Colors</span>
              </h3>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Application / Site Name <span class="text-danger">*</span></label>
                    <input type="text" name="site_name" class="form-control" value="<?=htmlspecialchars($settings['site_name']['value'] ?? '');?>" required>
                    <span class="input-hint">Displayed in browser titles, email templates, and SMS footers</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Platform Tagline / Slogan</label>
                    <input type="text" name="site_tagline" class="form-control" value="<?=htmlspecialchars($settings['site_tagline']['value'] ?? '');?>">
                    <span class="input-hint">Secondary brand slogan used across public portal headers</span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Primary Theme Color</label>
                    <div class="color-picker-box">
                      <input type="color" class="color-picker-input" id="primaryColorPicker" value="<?=$settings['primary_color']['value'] ?? '#00a896';?>">
                      <input type="text" name="primary_color" id="primaryColorText" class="form-control" value="<?=$settings['primary_color']['value'] ?? '#00a896';?>" style="width: 140px; font-family: monospace;">
                    </div>
                    <span class="input-hint">Used for primary action buttons, active navigation states, and key highlights</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Secondary / Sidebar Theme Color</label>
                    <div class="color-picker-box">
                      <input type="color" class="color-picker-input" id="secondaryColorPicker" value="<?=$settings['secondary_color']['value'] ?? '#1d2a44';?>">
                      <input type="text" name="secondary_color" id="secondaryColorText" class="form-control" value="<?=$settings['secondary_color']['value'] ?? '#1d2a44';?>" style="width: 140px; font-family: monospace;">
                    </div>
                    <span class="input-hint">Used for headers, dark sidebar backgrounds, and deep container cards</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 2: Media & Logos -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-image text-primary"></i> Media & Branding Uploads</span>
              </h3>
              <div class="row">
                <div class="col-md-4">
                  <div class="media-upload-card">
                    <label style="font-size: 13px; font-weight: 600;">Main Logo (Light Mode)</label>
                    <div class="media-preview-container">
                      <?php $main_logo_val = $settings['main_logo']['value'] ?? ''; ?>
                      <img src="<?=!empty($main_logo_val) ? (strpos($main_logo_val, 'http') === 0 ? $main_logo_val : base_url($main_logo_val)) : base_url('images/logo.png');?>" class="media-preview-img" id="preview_main_logo" alt="Main Logo">
                    </div>
                    <input type="file" name="main_logo" class="form-control" accept="image/*" onchange="previewMedia(this, 'preview_main_logo')">
                    <span class="input-hint">Recommended: 240x60px PNG / SVG transparent</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="media-upload-card">
                    <label style="font-size: 13px; font-weight: 600;">Browser Favicon (.ico / .png)</label>
                    <div class="media-preview-container">
                      <?php $favicon_val = $settings['favicon']['value'] ?? ''; ?>
                      <img src="<?=!empty($favicon_val) ? (strpos($favicon_val, 'http') === 0 ? $favicon_val : base_url($favicon_val)) : base_url('favicon.ico');?>" class="media-preview-img" id="preview_favicon" alt="Favicon" style="max-height: 32px;">
                    </div>
                    <input type="file" name="favicon" class="form-control" accept=".ico,.png" onchange="previewMedia(this, 'preview_favicon')">
                    <span class="input-hint">Recommended: 32x32px or 64x64px square icon</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="media-upload-card">
                    <label style="font-size: 13px; font-weight: 600;">Email Header Logo</label>
                    <div class="media-preview-container">
                      <?php $email_logo_val = $settings['email_logo']['value'] ?? ''; ?>
                      <img src="<?=!empty($email_logo_val) ? (strpos($email_logo_val, 'http') === 0 ? $email_logo_val : base_url($email_logo_val)) : base_url('images/logo.png');?>" class="media-preview-img" id="preview_email_logo" alt="Email Logo">
                    </div>
                    <input type="file" name="email_logo" class="form-control" accept="image/*" onchange="previewMedia(this, 'preview_email_logo')">
                    <span class="input-hint">Used at top of automated notification emails</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 3: Contact & Support -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-phone text-primary"></i> Contact & Support Details</span>
              </h3>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Official Support Email</label>
                    <input type="email" name="support_email" class="form-control" value="<?=htmlspecialchars($settings['support_email']['value'] ?? '');?>">
                    <span class="input-hint">Inquiries sent via contact forms will copy this email</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Toll-Free / Contact Number</label>
                    <input type="text" name="support_phone" class="form-control" value="<?=htmlspecialchars($settings['support_phone']['value'] ?? '');?>">
                    <span class="input-hint">Displayed on patient app header and appointment receipts</span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Physical / Registered Address</label>
                    <textarea name="physical_address" class="form-control" rows="3"><?=htmlspecialchars($settings['physical_address']['value'] ?? '');?></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Operating / Support Working Hours</label>
                    <input type="text" name="operating_hours" class="form-control" value="<?=htmlspecialchars($settings['operating_hours']['value'] ?? '');?>">
                    <span class="input-hint">Example: Mon - Sat: 08:00 AM - 09:00 PM</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 4: Localization -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-map-marker text-primary"></i> Localization & Formatting</span>
              </h3>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group form-group-modern">
                    <label>System Timezone</label>
                    <select name="timezone" class="form-control">
                      <?php 
                        $tz_current = $settings['timezone']['value'] ?? 'Asia/Kolkata';
                        $tz_options = ['Asia/Kolkata' => 'Asia/Kolkata (IST +5:30)', 'UTC' => 'UTC (+0:00)', 'America/New_York' => 'America/New_York (EST)', 'Europe/London' => 'Europe/London (GMT)', 'Asia/Dubai' => 'Asia/Dubai (+4:00)'];
                        foreach ($tz_options as $tz_val => $tz_label): 
                      ?>
                        <option value="<?=$tz_val;?>" <?=$tz_current === $tz_val ? 'selected' : '';?>><?=$tz_label;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group form-group-modern">
                    <label>Currency Symbol</label>
                    <input type="text" name="currency_symbol" class="form-control" value="<?=htmlspecialchars($settings['currency_symbol']['value'] ?? '₹');?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group form-group-modern">
                    <label>Date Format</label>
                    <select name="date_format" class="form-control">
                      <?php 
                        $df_current = $settings['date_format']['value'] ?? 'd-m-Y';
                        $df_options = ['d-m-Y' => 'DD-MM-YYYY (e.g. 28-08-2026)', 'Y-m-d' => 'YYYY-MM-DD (e.g. 2026-08-28)', 'd M Y' => 'DD Mon YYYY (e.g. 28 Aug 2026)', 'm/d/Y' => 'MM/DD/YYYY (e.g. 08/28/2026)'];
                        foreach ($df_options as $df_val => $df_label):
                      ?>
                        <option value="<?=$df_val;?>" <?=$df_current === $df_val ? 'selected' : '';?>><?=$df_label;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group form-group-modern">
                    <label>Time Format</label>
                    <select name="time_format" class="form-control">
                      <option value="h:i A" <?=($settings['time_format']['value'] ?? '') === 'h:i A' ? 'selected' : '';?>>12-Hour (02:30 PM)</option>
                      <option value="H:i" <?=($settings['time_format']['value'] ?? '') === 'H:i' ? 'selected' : '';?>>24-Hour (14:30)</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="settings-save-bar">
              <span class="text-muted"><i class="fa fa-info-circle"></i> Save changes to apply branding across portal</span>
              <button type="submit" class="btn btn-adm-teal btn-lg">
                <i class="fa fa-save"></i> Save General Settings
              </button>
            </div>
          </form>
        </div>


        <!-- ==========================================
             TAB 2: EMAIL GATEWAY (SMTP / ESP)
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'email' ? 'active' : '';?>" id="tab_email">
          <form class="ajaxSettingsForm" action="<?=base_url('settings/save');?>" method="post">
            <input type="hidden" name="category" value="email">

            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-send-o text-primary"></i> Email Provider Configuration</span>
                <button type="button" class="btn btn-sm btn-adm-teal" data-toggle="modal" data-target="#testEmailModal">
                  <i class="fa fa-paper-plane"></i> Send Test Email
                </button>
              </h3>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Active Email Provider</label>
                    <select name="email_provider" id="emailProviderSelect" class="form-control">
                      <?php $ep = $settings['email_provider']['value'] ?? 'smtp'; ?>
                      <option value="smtp" <?=$ep === 'smtp' ? 'selected' : '';?>>Standard SMTP (Gmail, Hostinger, Custom)</option>
                      <option value="sendgrid" <?=$ep === 'sendgrid' ? 'selected' : '';?>>SendGrid API</option>
                      <option value="ses" <?=$ep === 'ses' ? 'selected' : '';?>>Amazon SES</option>
                      <option value="mailgun" <?=$ep === 'mailgun' ? 'selected' : '';?>>Mailgun API</option>
                      <option value="postmark" <?=$ep === 'postmark' ? 'selected' : '';?>>Postmark</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Default "From Name"</label>
                    <input type="text" name="mail_from_name" class="form-control" value="<?=htmlspecialchars($settings['mail_from_name']['value'] ?? 'Upchar Healthcare');?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Default "From Email Address"</label>
                    <input type="email" name="mail_from_email" class="form-control" value="<?=htmlspecialchars($settings['mail_from_email']['value'] ?? 'noreply@upchar.com');?>">
                  </div>
                </div>
              </div>

              <!-- Conditional SMTP Settings -->
              <div id="smtpSettingsPanel" style="<?=$ep === 'smtp' ? '' : 'display:none;';?>">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin: 20px 0 15px 0;">
                  <i class="fa fa-server text-primary"></i> SMTP Server Parameters
                </h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>SMTP Host</label>
                      <input type="text" name="smtp_host" class="form-control" value="<?=htmlspecialchars($settings['smtp_host']['value'] ?? 'smtp.gmail.com');?>" placeholder="smtp.gmail.com">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>SMTP Port</label>
                      <input type="number" name="smtp_port" class="form-control" value="<?=htmlspecialchars($settings['smtp_port']['value'] ?? '587');?>" placeholder="587">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Encryption Protocol</label>
                      <select name="smtp_crypto" class="form-control">
                        <?php $sc = $settings['smtp_crypto']['value'] ?? 'tls'; ?>
                        <option value="tls" <?=$sc === 'tls' ? 'selected' : '';?>>TLS (Recommended on Port 587)</option>
                        <option value="ssl" <?=$sc === 'ssl' ? 'selected' : '';?>>SSL (Port 465)</option>
                        <option value="none" <?=$sc === 'none' ? 'selected' : '';?>>None (Port 25)</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group-modern">
                      <label>SMTP Username / Email</label>
                      <input type="text" name="smtp_user" class="form-control" value="<?=htmlspecialchars($settings['smtp_user']['value'] ?? '');?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-modern">
                      <label>SMTP Password (Encrypted)</label>
                      <div class="input-group-secret">
                        <input type="password" name="smtp_pass" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['smtp_pass']['value']) ? '••••••••' : '';?>">
                        <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                          <i class="fa fa-eye"></i>
                        </button>
                      </div>
                      <span class="input-hint">Leave as •••••••• to keep the current saved password</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Conditional SendGrid Settings -->
              <div id="sendgridSettingsPanel" style="<?=$ep === 'sendgrid' ? '' : 'display:none;';?>">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin: 20px 0 15px 0;">
                  <i class="fa fa-key text-primary"></i> SendGrid API Credentials
                </h4>
                <div class="form-group form-group-modern">
                  <label>SendGrid API Key</label>
                  <div class="input-group-secret">
                    <input type="password" name="sendgrid_api_key" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['sendgrid_api_key']['value']) ? '••••••••' : '';?>">
                    <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                      <i class="fa fa-eye"></i>
                    </button>
                  </div>
                  <span class="input-hint">Requires 'Mail Send' full permissions</span>
                </div>
              </div>

              <!-- Conditional SES Settings -->
              <div id="sesSettingsPanel" style="<?=$ep === 'ses' ? '' : 'display:none;';?>">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin: 20px 0 15px 0;">
                  <i class="fa fa-amazon text-primary"></i> Amazon SES Credentials
                </h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>SES Access Key ID</label>
                      <div class="input-group-secret">
                        <input type="password" name="ses_key" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['ses_key']['value']) ? '••••••••' : '';?>">
                        <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                          <i class="fa fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>SES Secret Access Key</label>
                      <div class="input-group-secret">
                        <input type="password" name="ses_secret" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['ses_secret']['value']) ? '••••••••' : '';?>">
                        <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                          <i class="fa fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>SES Region</label>
                      <input type="text" name="ses_region" class="form-control" value="<?=htmlspecialchars($settings['ses_region']['value'] ?? 'ap-south-1');?>" placeholder="ap-south-1">
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Sticky Save Bar -->
            <div class="settings-save-bar">
              <span class="text-muted"><i class="fa fa-info-circle"></i> Changes affect patient & doctor notifications immediately</span>
              <button type="submit" class="btn btn-adm-teal btn-lg">
                <i class="fa fa-save"></i> Save Email Settings
              </button>
            </div>
          </form>
        </div>


        <!-- ==========================================
             TAB 3: SMS & WHATSAPP GATEWAY
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'sms' ? 'active' : '';?>" id="tab_sms">
          <form class="ajaxSettingsForm" action="<?=base_url('settings/save');?>" method="post">
            <input type="hidden" name="category" value="sms">

            <!-- Section 1: SMS Gateway -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-mobile text-primary"></i> SMS Provider & India DLT Compliance</span>
                <button type="button" class="btn btn-sm btn-adm-teal" data-toggle="modal" data-target="#testSmsModal">
                  <i class="fa fa-paper-plane"></i> Send Test SMS
                </button>
              </h3>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Active SMS Gateway</label>
                    <select name="sms_provider" id="smsProviderSelect" class="form-control">
                      <?php $sp = $settings['sms_provider']['value'] ?? 'msg91'; ?>
                      <option value="msg91" <?=$sp === 'msg91' ? 'selected' : '';?>>Msg91 (India DLT Compliant)</option>
                      <option value="twilio" <?=$sp === 'twilio' ? 'selected' : '';?>>Twilio Programmable SMS</option>
                      <option value="fast2sms" <?=$sp === 'fast2sms' ? 'selected' : '';?>>Fast2SMS</option>
                      <option value="infobip" <?=$sp === 'infobip' ? 'selected' : '';?>>Infobip</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Default Sender Header / ID</label>
                    <input type="text" name="default_sender_id" class="form-control" maxlength="6" value="<?=htmlspecialchars($settings['default_sender_id']['value'] ?? 'UPCARE');?>" style="text-transform: uppercase;">
                    <span class="input-hint">6-character alpha ID approved on Telecom DLT portal</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>DLT Principal Entity ID (India)</label>
                    <input type="text" name="dlt_entity_id" class="form-control" value="<?=htmlspecialchars($settings['dlt_entity_id']['value'] ?? '11015243100000');?>">
                    <span class="input-hint">Enterprise Entity Registration ID (TRAI DLT)</span>
                  </div>
                </div>
              </div>

              <!-- Conditional Msg91 Credentials -->
              <div id="msg91Fields" style="<?=$sp === 'msg91' ? '' : 'display:none;';?>">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin: 15px 0;">
                  <i class="fa fa-key text-primary"></i> Msg91 API Credentials
                </h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Msg91 Auth Key</label>
                      <div class="input-group-secret">
                        <input type="password" name="msg91_auth_key" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['msg91_auth_key']['value']) ? '••••••••' : '';?>">
                        <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                          <i class="fa fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Msg91 Sender ID</label>
                      <input type="text" name="msg91_sender_id" class="form-control" value="<?=htmlspecialchars($settings['msg91_sender_id']['value'] ?? 'UPCARE');?>" maxlength="6">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Default DLT Template ID</label>
                      <input type="text" name="msg91_dlt_te_id" class="form-control" value="<?=htmlspecialchars($settings['msg91_dlt_te_id']['value'] ?? '1507161519686689997');?>">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Conditional Twilio Credentials -->
              <div id="twilioFields" style="<?=$sp === 'twilio' ? '' : 'display:none;';?>">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin: 15px 0;">
                  <i class="fa fa-key text-primary"></i> Twilio API Credentials
                </h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Twilio Account SID</label>
                      <div class="input-group-secret">
                        <input type="password" name="twilio_sid" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['twilio_sid']['value']) ? '••••••••' : '';?>">
                        <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                          <i class="fa fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Twilio Auth Token</label>
                      <div class="input-group-secret">
                        <input type="password" name="twilio_token" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['twilio_token']['value']) ? '••••••••' : '';?>">
                        <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                          <i class="fa fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-modern">
                      <label>Twilio From Number / Sender</label>
                      <input type="text" name="twilio_from" class="form-control" value="<?=htmlspecialchars($settings['twilio_from']['value'] ?? '');?>" placeholder="+1234567890">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Conditional Fast2SMS Credentials -->
              <div id="fast2smsFields" style="<?=$sp === 'fast2sms' ? '' : 'display:none;';?>">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin: 15px 0;">
                  <i class="fa fa-key text-primary"></i> Fast2SMS Credentials
                </h4>
                <div class="form-group form-group-modern">
                  <label>Fast2SMS Authorization Key</label>
                  <div class="input-group-secret">
                    <input type="password" name="fast2sms_api_key" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['fast2sms_api_key']['value']) ? '••••••••' : '';?>">
                    <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                      <i class="fa fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 2: WhatsApp Business API -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-whatsapp text-success"></i> WhatsApp Business Cloud API (Meta)</span>
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#testWaModal">
                  <i class="fa fa-paper-plane"></i> Send Test WhatsApp
                </button>
              </h3>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>WhatsApp Business Account ID (WABA ID)</label>
                    <input type="text" name="wa_account_id" class="form-control" value="<?=htmlspecialchars($settings['wa_account_id']['value'] ?? '');?>" placeholder="e.g. 10982374982374">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Phone Number ID</label>
                    <input type="text" name="wa_phone_number_id" class="form-control" value="<?=htmlspecialchars($settings['wa_phone_number_id']['value'] ?? '');?>" placeholder="e.g. 10482937482937">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>System User Permanent Access Token</label>
                    <div class="input-group-secret">
                      <input type="password" name="wa_access_token" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['wa_access_token']['value']) ? '••••••••' : '';?>">
                      <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="settings-save-bar">
              <span class="text-muted"><i class="fa fa-info-circle"></i> OTPs and prescription alerts use these gateway configs</span>
              <button type="submit" class="btn btn-adm-teal btn-lg">
                <i class="fa fa-save"></i> Save SMS & WhatsApp Settings
              </button>
            </div>
          </form>
        </div>


        <!-- ==========================================
             TAB 4: THIRD-PARTY INTEGRATIONS
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'integrations' ? 'active' : '';?>" id="tab_integrations">
          <form class="ajaxSettingsForm" action="<?=base_url('settings/save');?>" method="post">
            <input type="hidden" name="category" value="integrations">

            <!-- Section 1: ABDM -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-id-card text-primary"></i> Ayushman Bharat Digital Mission (ABDM / NHA)</span>
                <button type="button" class="btn btn-sm btn-info" onclick="verifyIntegration('abdm')">
                  <i class="fa fa-check-circle"></i> Test ABDM Gateway
                </button>
              </h3>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>ABDM Client ID</label>
                    <input type="text" name="abdm_client_id" class="form-control" value="<?=htmlspecialchars($settings['abdm_client_id']['value'] ?? '');?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>ABDM Client Secret (Encrypted)</label>
                    <div class="input-group-secret">
                      <input type="password" name="abdm_client_secret" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['abdm_client_secret']['value']) ? '••••••••' : '';?>">
                      <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Environment Mode</label>
                    <select name="abdm_sandbox_mode" class="form-control">
                      <option value="1" <?=($settings['abdm_sandbox_mode']['value'] ?? '1') === '1' ? 'selected' : '';?>>Sandbox / Dev Gateway (dev.abdm.gov.in)</option>
                      <option value="0" <?=($settings['abdm_sandbox_mode']['value'] ?? '1') === '0' ? 'selected' : '';?>>Production Live Gateway (gateway.abdm.gov.in)</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 2: Payment Gateways -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-credit-card text-primary"></i> Payment Gateway Integrations</span>
                <button type="button" class="btn btn-sm btn-info" onclick="verifyIntegration('razorpay')">
                  <i class="fa fa-check-circle"></i> Verify Razorpay API
                </button>
              </h3>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Primary Payment Gateway</label>
                    <select name="payment_gateway" class="form-control">
                      <?php $pg = $settings['payment_gateway']['value'] ?? 'razorpay'; ?>
                      <option value="razorpay" <?=$pg === 'razorpay' ? 'selected' : '';?>>Razorpay (Cards, UPI, Netbanking)</option>
                      <option value="cashfree" <?=$pg === 'cashfree' ? 'selected' : '';?>>Cashfree Payments</option>
                      <option value="stripe" <?=$pg === 'stripe' ? 'selected' : '';?>>Stripe</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Razorpay Key ID</label>
                    <input type="text" name="razorpay_key_id" class="form-control" value="<?=htmlspecialchars($settings['razorpay_key_id']['value'] ?? '');?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Razorpay Key Secret (Encrypted)</label>
                    <div class="input-group-secret">
                      <input type="password" name="razorpay_key_secret" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['razorpay_key_secret']['value']) ? '••••••••' : '';?>">
                      <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Razorpay Webhook Secret</label>
                    <div class="input-group-secret">
                      <input type="password" name="razorpay_webhook_secret" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['razorpay_webhook_secret']['value']) ? '••••••••' : '';?>">
                      <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Razorpay Mode</label>
                    <select name="razorpay_mode" class="form-control">
                      <option value="test" <?=($settings['razorpay_mode']['value'] ?? 'test') === 'test' ? 'selected' : '';?>>Test Mode (Sandbox)</option>
                      <option value="live" <?=($settings['razorpay_mode']['value'] ?? 'test') === 'live' ? 'selected' : '';?>>Live Production Mode</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 3: Google Maps & Push Notifications -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-map-marker text-primary"></i> Maps, Location & Firebase Push</span>
                <button type="button" class="btn btn-sm btn-info" onclick="verifyIntegration('maps')">
                  <i class="fa fa-check-circle"></i> Test Maps API
                </button>
              </h3>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Google Maps API Key (Geocoding / Places / Matrix)</label>
                    <div class="input-group-secret">
                      <input type="password" name="google_maps_api_key" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['google_maps_api_key']['value']) ? '••••••••' : '';?>">
                      <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </div>
                    <span class="input-hint">Required for clinic geolocation and doctor search radius</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Firebase Cloud Messaging (FCM) Server Key</label>
                    <div class="input-group-secret">
                      <input type="password" name="fcm_server_key" class="form-control secret-field" placeholder="••••••••" value="<?=!empty($settings['fcm_server_key']['value']) ? '••••••••' : '';?>">
                      <button type="button" class="btn-toggle-secret" onclick="toggleSecretVisibility(this)">
                        <i class="fa fa-eye"></i>
                      </button>
                    </div>
                    <span class="input-hint">Used to dispatch instant push notifications to mobile apps</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="settings-save-bar">
              <span class="text-muted"><i class="fa fa-info-circle"></i> API secrets are saved with AES-256 two-way encryption</span>
              <button type="submit" class="btn btn-adm-teal btn-lg">
                <i class="fa fa-save"></i> Save Third-Party Integrations
              </button>
            </div>
          </form>
        </div>


        <!-- ==========================================
             TAB 5: SECURITY & MAINTENANCE
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'security' ? 'active' : '';?>" id="tab_security">
          <form class="ajaxSettingsForm" action="<?=base_url('settings/save');?>" method="post">
            <input type="hidden" name="category" value="security">

            <!-- Section 1: Maintenance Mode -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-wrench text-danger"></i> System-Wide Maintenance Mode</span>
              </h3>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-group-modern" style="display: flex; align-items: center; gap: 15px; background: #fff1f2; padding: 15px; border-radius: 8px; border: 1px solid #fecdd3;">
                    <label class="switch-modern">
                      <input type="checkbox" name="maintenance_mode" value="1" <?=($settings['maintenance_mode']['value'] ?? '0') == '1' ? 'checked' : '';?>>
                      <span class="slider-modern"></span>
                    </label>
                    <div>
                      <strong style="font-size: 14px; color: #9f1239; display: block;">Enable Maintenance Mode</strong>
                      <span style="font-size: 12.5px; color: #881337;">When enabled, non-admin visitors will see a maintenance notice. Administrators from allowed IPs can still access all portals.</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Maintenance Banner Message</label>
                    <textarea name="maintenance_message" class="form-control" rows="3"><?=htmlspecialchars($settings['maintenance_message']['value'] ?? 'Upchar is currently undergoing scheduled platform maintenance.');?></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Allowed Bypass IP Addresses (Comma-separated)</label>
                    <textarea name="maintenance_allowed_ips" class="form-control" rows="3"><?=htmlspecialchars($settings['maintenance_allowed_ips']['value'] ?? '127.0.0.1, ::1');?></textarea>
                    <span class="input-hint">Your current IP is: <strong><?=$this->input->ip_address();?></strong></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 2: Authentication & Sessions -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-shield text-primary"></i> Authentication & Session Rules</span>
              </h3>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Session Inactivity Timeout (Minutes)</label>
                    <input type="number" name="session_timeout_mins" class="form-control" value="<?=htmlspecialchars($settings['session_timeout_mins']['value'] ?? '60');?>" min="5" max="1440">
                    <span class="input-hint">Users will be logged out after this duration of inactivity</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Max Failed Login Attempts</label>
                    <input type="number" name="login_max_attempts" class="form-control" value="<?=htmlspecialchars($settings['login_max_attempts']['value'] ?? '5');?>" min="3" max="20">
                    <span class="input-hint">Triggers temporary IP lockout</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-modern">
                    <label>Account Lockout Duration (Minutes)</label>
                    <input type="number" name="login_lockout_mins" class="form-control" value="<?=htmlspecialchars($settings['login_lockout_mins']['value'] ?? '15');?>" min="1" max="120">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern" style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
                    <label class="switch-modern">
                      <input type="checkbox" name="mfa_enabled" value="1" <?=($settings['mfa_enabled']['value'] ?? '0') == '1' ? 'checked' : '';?>>
                      <span class="slider-modern"></span>
                    </label>
                    <div>
                      <strong style="font-size: 13.5px; display: block;">Enforce Multi-Factor Authentication (MFA)</strong>
                      <span class="input-hint">Requires OTP verification for all SuperAdmin and Doctor login sessions</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section 3: Upload Limits -->
            <div class="settings-card">
              <h3 class="card-section-title">
                <span><i class="fa fa-cloud-upload text-primary"></i> File Upload Boundaries</span>
              </h3>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Maximum File Size Limit (MB)</label>
                    <input type="number" name="max_upload_size_mb" class="form-control" value="<?=htmlspecialchars($settings['max_upload_size_mb']['value'] ?? '10');?>" min="1" max="100">
                    <span class="input-hint">Server upload_max_filesize is currently: <strong><?=ini_get('upload_max_filesize');?></strong></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-modern">
                    <label>Allowed MIME File Extensions</label>
                    <input type="text" name="allowed_file_types" class="form-control" value="<?=htmlspecialchars($settings['allowed_file_types']['value'] ?? 'pdf, jpg, jpeg, png, dicom, dcm, doc, docx');?>">
                    <span class="input-hint">Comma-separated list (e.g. pdf, jpg, png, dicom)</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="settings-save-bar">
              <span class="text-muted"><i class="fa fa-info-circle"></i> Security parameters are audited with timestamp and IP log</span>
              <button type="submit" class="btn btn-adm-teal btn-lg">
                <i class="fa fa-save"></i> Save Security Configuration
              </button>
            </div>
          </form>
        </div>


        <!-- ==========================================
             TAB 6: AUDIT TRAIL / ACTIVITY LOGS
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'audit' ? 'active' : '';?>" id="tab_audit">
          <div class="settings-card">
            <h3 class="card-section-title">
              <span><i class="fa fa-history text-primary"></i> System Settings Audit Trail (<?=$total_audit_count;?> Entries)</span>
            </h3>

            <!-- Filters -->
            <form method="get" action="<?=base_url('settings');?>" class="row" style="margin-bottom: 20px;">
              <input type="hidden" name="tab" value="audit">
              <div class="col-md-4">
                <select name="log_category" class="form-control" onchange="this.form.submit()">
                  <option value="ALL" <?=$audit_category === 'ALL' ? 'selected' : '';?>>All Setting Categories</option>
                  <option value="general" <?=$audit_category === 'general' ? 'selected' : '';?>>General & Branding</option>
                  <option value="email" <?=$audit_category === 'email' ? 'selected' : '';?>>Email Gateway</option>
                  <option value="sms" <?=$audit_category === 'sms' ? 'selected' : '';?>>SMS & WhatsApp</option>
                  <option value="integrations" <?=$audit_category === 'integrations' ? 'selected' : '';?>>Integrations</option>
                  <option value="security" <?=$audit_category === 'security' ? 'selected' : '';?>>Security & Maintenance</option>
                </select>
              </div>
              <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search by admin, IP, or field..." value="<?=htmlspecialchars($audit_search ?? '');?>">
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-adm-teal"><i class="fa fa-search"></i> Filter Logs</button>
                <a href="<?=base_url('settings?tab=audit');?>" class="btn btn-default">Reset</a>
              </div>
            </form>

            <div class="table-responsive">
              <table class="table table-hover table-striped audit-table">
                <thead>
                  <tr>
                    <th style="width: 70px;">ID</th>
                    <th style="width: 140px;">Admin User</th>
                    <th style="width: 120px;">Category</th>
                    <th style="width: 100px;">Action</th>
                    <th>Changes Summary</th>
                    <th style="width: 130px;">IP Address</th>
                    <th style="width: 170px;">Timestamp</th>
                    <th style="width: 80px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($audit_logs)): ?>
                    <?php foreach($audit_logs as $log): ?>
                      <tr>
                        <td>#<?=$log['id'];?></td>
                        <td>
                          <strong><?=htmlspecialchars($log['admin_username'] ?: 'Admin');?></strong>
                        </td>
                        <td>
                          <span class="badge-category cat-<?=$log['category'];?>"><?=$log['category'];?></span>
                        </td>
                        <td>
                          <span class="label label-info"><?=$log['action'];?></span>
                        </td>
                        <td>
                          <?php 
                            $changes_obj = @json_decode($log['changes'], true);
                            if (is_array($changes_obj)) {
                                $keys = array_keys($changes_obj);
                                echo "Modified <strong>" . count($keys) . "</strong> field(s): <span class='text-muted'>" . implode(', ', array_slice($keys, 0, 3)) . (count($keys) > 3 ? '...' : '') . "</span>";
                            } else {
                                echo "—";
                            }
                          ?>
                        </td>
                        <td><code style="font-size: 11px;"><?=$log['ip_address'];?></code></td>
                        <td><small class="text-muted"><i class="fa fa-clock-o"></i> <?=date('d M Y, h:i A', strtotime($log['created_at']));?></small></td>
                        <td>
                          <button type="button" class="btn btn-xs btn-default" onclick='viewAuditDiff(<?=json_encode($log);?>)'>
                            <i class="fa fa-eye"></i> Diff
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted" style="padding: 30px;">
                        <i class="fa fa-history fa-2x" style="display:block; margin-bottom: 10px;"></i>
                        No audit log entries found matching criteria.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>


        <!-- ==========================================
             TAB 7: SYSTEM DIAGNOSTICS & HEALTH
             ========================================== -->
        <div class="tab-pane <?=$active_tab === 'health' ? 'active' : '';?>" id="tab_health">
          <div class="settings-card">
            <h3 class="card-section-title">
              <span><i class="fa fa-heartbeat text-danger"></i> Server Environment & System Diagnostics</span>
              <span class="badge bg-green" style="font-size: 12px; padding: 6px 10px;">Operational</span>
            </h3>

            <div class="row">
              <!-- PHP Card -->
              <div class="col-md-4">
                <div class="health-metric-card">
                  <div class="health-metric-icon <?=$system_health['php_status'] === 'good' ? 'health-good' : 'health-warning';?>">
                    <i class="fa fa-code"></i>
                  </div>
                  <div>
                    <span style="font-size: 12px; color: var(--adm-muted); display: block;">PHP Version</span>
                    <strong style="font-size: 15px;"><?=$system_health['php_version'];?></strong>
                  </div>
                </div>
              </div>

              <!-- MySQL Card -->
              <div class="col-md-4">
                <div class="health-metric-card">
                  <div class="health-metric-icon health-good">
                    <i class="fa fa-database"></i>
                  </div>
                  <div>
                    <span style="font-size: 12px; color: var(--adm-muted); display: block;">MySQL Database</span>
                    <strong style="font-size: 15px;"><?=$system_health['mysql_version'];?></strong>
                  </div>
                </div>
              </div>

              <!-- Server Time -->
              <div class="col-md-4">
                <div class="health-metric-card">
                  <div class="health-metric-icon health-good">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <div>
                    <span style="font-size: 12px; color: var(--adm-muted); display: block;">Server Time</span>
                    <strong style="font-size: 13.5px;"><?=$system_health['server_time'];?></strong>
                  </div>
                </div>
              </div>
            </div>

            <!-- Health checklist -->
            <div class="row" style="margin-top: 15px;">
              <div class="col-md-6">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin-bottom: 12px;">Required PHP Extensions</h4>
                <ul class="list-group">
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>cURL HTTP Client</span>
                    <span class="label <?=$system_health['curl_installed'] ? 'label-success' : 'label-danger';?>"><?=$system_health['curl_installed'] ? 'Enabled' : 'Missing';?></span>
                  </li>
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>OpenSSL AES-256 Encryption</span>
                    <span class="label <?=$system_health['openssl_installed'] ? 'label-success' : 'label-danger';?>"><?=$system_health['openssl_installed'] ? 'Enabled' : 'Missing';?></span>
                  </li>
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>GD Image Processing Library</span>
                    <span class="label <?=$system_health['gd_installed'] ? 'label-success' : 'label-danger';?>"><?=$system_health['gd_installed'] ? 'Enabled' : 'Missing';?></span>
                  </li>
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>MBString Multibyte Character Handling</span>
                    <span class="label <?=$system_health['mbstring_installed'] ? 'label-success' : 'label-danger';?>"><?=$system_health['mbstring_installed'] ? 'Enabled' : 'Missing';?></span>
                  </li>
                </ul>
              </div>

              <div class="col-md-6">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--adm-navy); margin-bottom: 12px;">Directory & Storage Permissions</h4>
                <ul class="list-group">
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>Uploads Directory (<code>public/uploads/settings</code>)</span>
                    <span class="label <?=$system_health['upload_dir_writable'] ? 'label-success' : 'label-danger';?>"><?=$system_health['upload_dir_writable'] ? 'Writable' : 'Read Only';?></span>
                  </li>
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>Settings Cache Directory (<code>application/cache</code>)</span>
                    <span class="label <?=$system_health['cache_dir_writable'] ? 'label-success' : 'label-danger';?>"><?=$system_health['cache_dir_writable'] ? 'Writable' : 'Read Only';?></span>
                  </li>
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>PHP Memory Limit</span>
                    <strong><?=$system_health['memory_limit'];?></strong>
                  </li>
                  <li class="list-group-item" style="display:flex; justify-content: space-between; align-items: center;">
                    <span>Free Disk Space</span>
                    <strong><?=$system_health['disk_free_gb'];?> / <?=$system_health['disk_total_gb'];?></strong>
                  </li>
                </ul>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </section>
</div>

<!-- ==========================================
     TEST EMAIL MODAL
     ========================================== -->
<div class="modal fade" id="testEmailModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 8px;">
      <div class="modal-header" style="background: var(--adm-navy); color: #ffffff; border-radius: 8px 8px 0 0;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
        <h4 class="modal-title"><i class="fa fa-paper-plane"></i> Send Test Email Verification</h4>
      </div>
      <form id="formSendTestEmail">
        <div class="modal-body" style="padding: 20px;">
          <div class="form-group form-group-modern">
            <label>Recipient Email Address <span class="text-danger">*</span></label>
            <input type="email" id="test_recipient_email" class="form-control" placeholder="e.g. admin@yourdomain.com" required>
            <span class="input-hint">A live diagnostic test email will be sent using current gateway credentials</span>
          </div>

          <div id="testEmailResult" style="display: none; margin-top: 15px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-adm-teal" id="btnSubmitTestEmail">
            <i class="fa fa-send"></i> Dispatch Test Email
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ==========================================
     TEST SMS MODAL
     ========================================== -->
<div class="modal fade" id="testSmsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 8px;">
      <div class="modal-header" style="background: var(--adm-navy); color: #ffffff; border-radius: 8px 8px 0 0;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
        <h4 class="modal-title"><i class="fa fa-commenting"></i> Send Test SMS Verification</h4>
      </div>
      <form id="formSendTestSms">
        <div class="modal-body" style="padding: 20px;">
          <div class="form-group form-group-modern">
            <label>Mobile Number (10 Digits) <span class="text-danger">*</span></label>
            <input type="text" id="test_sms_mobile" class="form-control" placeholder="9876543210" maxlength="12" required>
          </div>
          <div class="form-group form-group-modern">
            <label>Test Message Body</label>
            <textarea id="test_sms_message" class="form-control" rows="2">Upchar Healthcare test SMS verification. System Gateway is operational.</textarea>
          </div>

          <div id="testSmsResult" style="display: none; margin-top: 15px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-adm-teal" id="btnSubmitTestSms">
            <i class="fa fa-paper-plane"></i> Send Test SMS
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ==========================================
     TEST WHATSAPP MODAL
     ========================================== -->
<div class="modal fade" id="testWaModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 8px;">
      <div class="modal-header" style="background: #075e54; color: #ffffff; border-radius: 8px 8px 0 0;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
        <h4 class="modal-title"><i class="fa fa-whatsapp"></i> Test WhatsApp Cloud API</h4>
      </div>
      <form id="formSendTestWa">
        <div class="modal-body" style="padding: 20px;">
          <div class="form-group form-group-modern">
            <label>Recipient WhatsApp Number (with country code) <span class="text-danger">*</span></label>
            <input type="text" id="test_wa_mobile" class="form-control" placeholder="919876543210" required>
          </div>
          <div class="form-group form-group-modern">
            <label>Test Message</label>
            <textarea id="test_wa_message" class="form-control" rows="2">Hello from Upchar Healthcare! This is a test WhatsApp notification from your admin portal.</textarea>
          </div>

          <div id="testWaResult" style="display: none; margin-top: 15px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="btnSubmitTestWa">
            <i class="fa fa-paper-plane"></i> Send WhatsApp
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ==========================================
     AUDIT DIFF MODAL
     ========================================== -->
<div class="modal fade" id="auditDiffModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 8px;">
      <div class="modal-header" style="background: var(--adm-navy); color: #ffffff; border-radius: 8px 8px 0 0;">
        <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
        <h4 class="modal-title"><i class="fa fa-history"></i> Audit Change Inspection</h4>
      </div>
      <div class="modal-body" style="padding: 20px;">
        <div id="auditMetaContainer" style="margin-bottom: 15px; font-size: 13px;"></div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr style="background: #f8fafc;">
                <th>Field Name</th>
                <th style="color: #dc2626;">Previous Value</th>
                <th style="color: #16a34a;">Updated Value</th>
              </tr>
            </thead>
            <tbody id="auditDiffTbody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Interactive Client-side Javascript Logic -->
<script>
  // Color Picker Sync
  document.getElementById('primaryColorPicker').addEventListener('input', function() {
    document.getElementById('primaryColorText').value = this.value;
  });
  document.getElementById('primaryColorText').addEventListener('input', function() {
    document.getElementById('primaryColorPicker').value = this.value;
  });
  document.getElementById('secondaryColorPicker').addEventListener('input', function() {
    document.getElementById('secondaryColorText').value = this.value;
  });
  document.getElementById('secondaryColorText').addEventListener('input', function() {
    document.getElementById('secondaryColorPicker').value = this.value;
  });

  // Password / Secret Toggle Visibility
  function toggleSecretVisibility(btn) {
    var input = $(btn).siblings('input.secret-field');
    var icon = $(btn).find('i');
    if (input.attr('type') === 'password') {
      input.attr('type', 'text');
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
      input.attr('type', 'password');
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
  }

  // Image Upload Preview
  function previewMedia(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#' + previewId).attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Provider Selectors dynamic panels
  $('#emailProviderSelect').on('change', function() {
    var val = $(this).val();
    $('#smtpSettingsPanel, #sendgridSettingsPanel, #sesSettingsPanel').hide();
    if (val === 'smtp') $('#smtpSettingsPanel').slideDown();
    else if (val === 'sendgrid') $('#sendgridSettingsPanel').slideDown();
    else if (val === 'ses') $('#sesSettingsPanel').slideDown();
  });

  $('#smsProviderSelect').on('change', function() {
    var val = $(this).val();
    $('#msg91Fields, #twilioFields, #fast2smsFields').hide();
    if (val === 'msg91') $('#msg91Fields').slideDown();
    else if (val === 'twilio') $('#twilioFields').slideDown();
    else if (val === 'fast2sms') $('#fast2smsFields').slideDown();
  });

  // AJAX Form Submission
  $('.ajaxSettingsForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var submitBtn = form.find('button[type="submit"]');
    var originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    var formData = new FormData(this);

    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(res) {
        submitBtn.prop('disabled', false).html(originalText);
        if (res.status === 'success') {
          showNotification('success', res.message || 'Settings saved successfully!');
        } else {
          showNotification('danger', res.message || 'Failed to save settings.');
        }
      },
      error: function(xhr) {
        submitBtn.prop('disabled', false).html(originalText);
        showNotification('danger', 'Server error while saving settings. Please try again.');
      }
    });
  });

  function showNotification(type, msg) {
    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible" style="border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">' +
      '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
      '<strong>' + (type === 'success' ? 'Success!' : 'Error!') + '</strong> ' + msg +
      '</div>';
    $('#ajaxAlertContainer').html(alertHtml);
    $('html, body').animate({ scrollTop: $('#ajaxAlertContainer').offset().top - 70 }, 300);
  }

  // Flush Cache
  $('#btnFlushCache').on('click', function() {
    var btn = $(this);
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Flushing...');
    $.post('<?=base_url("settings/clear_cache");?>', function(res) {
      btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Flush Cache');
      showNotification('success', 'Application settings cache flushed successfully!');
    }, 'json');
  });

  // Test Email
  $('#formSendTestEmail').on('submit', function(e) {
    e.preventDefault();
    var btn = $('#btnSubmitTestEmail');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Dispatching...');
    $('#testEmailResult').hide().empty();

    $.post('<?=base_url("settings/send_test_email");?>', {
      test_email: $('#test_recipient_email').val(),
      email_provider: $('#emailProviderSelect').val()
    }, function(res) {
      btn.prop('disabled', false).html('<i class="fa fa-send"></i> Dispatch Test Email');
      var alertClass = (res.status === 'success') ? 'alert-success' : 'alert-danger';
      var out = '<div class="alert ' + alertClass + '"><strong>' + (res.status === 'success' ? 'Success:' : 'Error:') + '</strong> ' + res.message;
      if (res.debug) {
        out += '<pre style="margin-top: 10px; font-size: 11px; max-height: 150px; overflow-y: auto;">' + res.debug + '</pre>';
      }
      out += '</div>';
      $('#testEmailResult').html(out).slideDown();
    }, 'json');
  });

  // Test SMS
  $('#formSendTestSms').on('submit', function(e) {
    e.preventDefault();
    var btn = $('#btnSubmitTestSms');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
    $('#testSmsResult').hide().empty();

    $.post('<?=base_url("settings/send_test_sms");?>', {
      test_mobile: $('#test_sms_mobile').val(),
      test_message: $('#test_sms_message').val()
    }, function(res) {
      btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Send Test SMS');
      var alertClass = (res.status === 'success') ? 'alert-success' : 'alert-danger';
      var out = '<div class="alert ' + alertClass + '"><strong>' + (res.status === 'success' ? 'Success (' + res.provider + '):' : 'Error:') + '</strong> ' + res.message;
      if (res.raw_response) {
        out += '<pre style="margin-top: 10px; font-size: 11px; max-height: 120px; overflow-y: auto;">' + res.raw_response + '</pre>';
      }
      out += '</div>';
      $('#testSmsResult').html(out).slideDown();
    }, 'json');
  });

  // Test WhatsApp
  $('#formSendTestWa').on('submit', function(e) {
    e.preventDefault();
    var btn = $('#btnSubmitTestWa');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
    $('#testWaResult').hide().empty();

    $.post('<?=base_url("settings/send_test_whatsapp");?>', {
      test_mobile: $('#test_wa_mobile').val(),
      test_message: $('#test_wa_message').val()
    }, function(res) {
      btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Send WhatsApp');
      var alertClass = (res.status === 'success') ? 'alert-success' : 'alert-danger';
      $('#testWaResult').html('<div class="alert ' + alertClass + '">' + res.message + '</div>').slideDown();
    }, 'json');
  });

  // Verify Third-Party Integrations
  function verifyIntegration(type) {
    showNotification('info', '<i class="fa fa-spinner fa-spin"></i> Verifying ' + type.toUpperCase() + ' credentials with remote gateway...');
    $.post('<?=base_url("settings/test_integration");?>', { type: type }, function(res) {
      if (res.status === 'success') {
        showNotification('success', res.message);
      } else {
        showNotification('danger', res.message);
      }
    }, 'json');
  }

  // View Audit Diff Modal
  function viewAuditDiff(log) {
    $('#auditMetaContainer').html('<strong>Admin:</strong> ' + (log.admin_username || 'Admin') + ' | <strong>Category:</strong> ' + log.category + ' | <strong>IP:</strong> ' + log.ip_address + ' | <strong>Time:</strong> ' + log.created_at);
    var tbody = $('#auditDiffTbody');
    tbody.empty();

    try {
      var changes = JSON.parse(log.changes);
      for (var key in changes) {
        var oldVal = changes[key].old !== null ? changes[key].old : '<em>(empty)</em>';
        var newVal = changes[key].new !== null ? changes[key].new : '<em>(empty)</em>';
        tbody.append('<tr><td><code>' + key + '</code></td><td><del>' + oldVal + '</del></td><td><strong>' + newVal + '</strong></td></tr>');
      }
    } catch(e) {
      tbody.append('<tr><td colspan="3">' + log.changes + '</td></tr>');
    }

    $('#auditDiffModal').modal('show');
  }
</script>
