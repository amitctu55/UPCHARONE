<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Portal Login &bull; Upchar Healthcare</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Preconnect & Modern Typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Core Icons & Styles -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    :root {
      --brand-primary: #00a896;
      --brand-primary-hover: #008f80;
      --brand-navy-900: #0b1329;
      --brand-navy-800: #131e3b;
      --brand-navy-700: #1e294b;
      --brand-navy-600: #2b3964;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --text-light: #94a3b8;
      --border-color: #e2e8f0;
      --input-bg: #f8fafc;
      --card-bg: #ffffff;
      --focus-ring: rgba(0, 168, 150, 0.22);
      --transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at 20% 20%, rgba(0, 168, 150, 0.18) 0%, transparent 40%),
                  radial-gradient(circle at 80% 80%, rgba(29, 78, 216, 0.15) 0%, transparent 45%),
                  linear-gradient(145deg, var(--brand-navy-900) 0%, var(--brand-navy-800) 50%, #0d162e 100%);
      background-attachment: fixed;
      position: relative;
      overflow-x: hidden;
      padding: 24px 16px;
      color: var(--text-main);
    }

    /* Ambient Background Texture Grid */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: 
        linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }

    .login-container {
      width: 100%;
      max-width: 440px;
      position: relative;
      z-index: 10;
    }

    /* Brand Header */
    .brand-header {
      text-align: center;
      margin-bottom: 24px;
    }

    .brand-logo-link {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      text-decoration: none !important;
      color: #ffffff;
      transition: var(--transition);
    }

    .brand-icon-wrapper {
      width: 46px;
      height: 46px;
      border-radius: 14px;
      background: linear-gradient(135deg, #00a896 0%, #028071 100%);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 22px;
      box-shadow: 0 8px 20px rgba(0, 168, 150, 0.4);
      position: relative;
      animation: heartPulse 3.5s infinite ease-in-out;
    }

    @keyframes heartPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.06); box-shadow: 0 10px 25px rgba(0, 168, 150, 0.6); }
    }

    .brand-name {
      font-size: 24px;
      font-weight: 800;
      letter-spacing: -0.5px;
      color: #ffffff;
      line-height: 1.1;
      text-align: left;
    }

    .brand-name span {
      color: #2dd4bf;
      display: block;
      font-size: 11.5px;
      font-weight: 600;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      margin-top: 3px;
    }

    .badge-pill-portal {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 10px;
      padding: 4px 12px;
      border-radius: 9999px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #cbd5e1;
      font-size: 11.5px;
      font-weight: 600;
      backdrop-filter: blur(8px);
    }

    .badge-pill-portal .status-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #10b981;
      box-shadow: 0 0 8px #10b981;
    }

    /* Glassmorphic Login Card */
    .login-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 38px 32px 34px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45),
                  0 0 0 1px rgba(255, 255, 255, 0.15);
      position: relative;
      overflow: hidden;
    }

    /* Top Accent Line on Card */
    .login-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #00a896 0%, #38bdf8 50%, #6366f1 100%);
    }

    .card-title-box {
      margin-bottom: 24px;
      text-align: left;
    }

    .card-title {
      font-size: 20px;
      font-weight: 700;
      color: #0f172a;
      letter-spacing: -0.3px;
      margin-bottom: 4px;
    }

    .card-subtitle {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.4;
    }

    /* Form Fields Styling */
    .form-group-custom {
      margin-bottom: 20px;
      position: relative;
    }

    .field-label-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 7px;
    }

    .field-label {
      font-size: 12.5px;
      font-weight: 700;
      color: #1e293b;
      letter-spacing: 0.2px;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .field-label i {
      color: var(--brand-primary);
      font-size: 12px;
    }

    .field-badge {
      font-size: 11px;
      color: var(--text-light);
      font-weight: 500;
    }

    /* Custom Input Wrapper */
    .input-control-wrap {
      position: relative;
      display: flex;
      align-items: center;
      border: 1.5px solid var(--border-color);
      border-radius: 12px;
      background: var(--input-bg);
      transition: var(--transition);
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .input-control-wrap:hover {
      border-color: #cbd5e1;
      background: #ffffff;
    }

    .input-control-wrap.is-focused,
    .input-control-wrap:focus-within {
      border-color: var(--brand-primary);
      background: #ffffff;
      box-shadow: 0 0 0 4px var(--focus-ring), 0 2px 6px rgba(0, 168, 150, 0.08);
    }

    .input-icon-left {
      width: 44px;
      height: 46px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #94a3b8;
      font-size: 16px;
      flex-shrink: 0;
      transition: var(--transition);
      pointer-events: none;
    }

    .input-control-wrap:focus-within .input-icon-left {
      color: var(--brand-primary);
    }

    .custom-input {
      width: 100%;
      height: 46px;
      background: transparent;
      border: none;
      outline: none;
      font-size: 14px;
      font-weight: 500;
      color: #0f172a;
      padding: 0 12px 0 0;
      font-family: inherit;
    }

    .custom-input::placeholder {
      color: #94a3b8;
      font-weight: 400;
    }

    /* Password Input Extras */
    .password-toggle-btn {
      width: 44px;
      height: 46px;
      background: transparent;
      border: none;
      color: #94a3b8;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      border-radius: 0 12px 12px 0;
      transition: var(--transition);
      outline: none;
      flex-shrink: 0;
    }

    .password-toggle-btn:hover {
      color: var(--brand-primary);
      background: rgba(0, 168, 150, 0.06);
    }

    /* Caps Lock Warning Tooltip */
    .caps-lock-warning {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      margin-top: 5px;
      background: #fffbeb;
      color: #b45309;
      border: 1px solid #fde68a;
      padding: 5px 10px;
      border-radius: 8px;
      font-size: 11.5px;
      font-weight: 600;
      align-items: center;
      gap: 6px;
      z-index: 20;
      box-shadow: 0 4px 10px rgba(180, 83, 9, 0.1);
    }

    /* Form Utilities Row */
    .form-options-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 2px;
      margin-bottom: 24px;
    }

    .custom-checkbox-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      font-size: 13px;
      color: #475569;
      font-weight: 500;
      user-select: none;
      margin: 0;
    }

    .custom-checkbox-label input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--brand-primary);
      border-radius: 4px;
      cursor: pointer;
      margin: 0;
    }

    .security-badge-small {
      font-size: 11.5px;
      color: #059669;
      background: #ecfdf5;
      padding: 3px 8px;
      border-radius: 6px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      border: 1px solid #a7f3d0;
    }

    /* Modern Submit Button */
    .btn-submit-login {
      width: 100%;
      height: 48px;
      background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
      color: #ffffff;
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 6px 20px rgba(0, 168, 150, 0.35);
      position: relative;
      overflow: hidden;
    }

    .btn-submit-login:hover {
      background: linear-gradient(135deg, #02b6a3 0%, #009989 100%);
      transform: translateY(-1px);
      box-shadow: 0 10px 25px rgba(0, 168, 150, 0.45);
      color: #ffffff;
    }

    .btn-submit-login:active {
      transform: translateY(1px);
      box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
    }

    .btn-submit-login:disabled {
      opacity: 0.75;
      cursor: not-allowed;
      transform: none;
    }

    /* Flash Message Styling */
    .alert-custom {
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 13px;
      line-height: 1.4;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      border: 1px solid transparent;
    }

    .alert-custom.alert-danger {
      background: #fef2f2;
      color: #991b1b;
      border-color: #fecaca;
    }

    .alert-custom.alert-success {
      background: #f0fdf4;
      color: #166534;
      border-color: #bbf7d0;
    }

    /* Card Footer & Security Notes */
    .card-footer-box {
      margin-top: 26px;
      padding-top: 18px;
      border-top: 1px solid #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 11.5px;
      color: #94a3b8;
    }

    .security-note {
      display: flex;
      align-items: center;
      gap: 5px;
      font-weight: 600;
      color: #64748b;
    }

    .security-note i {
      color: var(--brand-primary);
    }

    .portal-version {
      font-weight: 500;
    }

    /* Page Outer Footer */
    .page-footer {
      margin-top: 24px;
      text-align: center;
      font-size: 12px;
      color: #94a3b8;
      position: relative;
      z-index: 10;
    }

    .page-footer a {
      color: #38bdf8;
      text-decoration: none;
      font-weight: 600;
      margin-left: 5px;
    }

    .page-footer a:hover {
      text-decoration: underline;
    }

    /* Responsive Adjustments */
    @media (max-width: 480px) {
      .login-card {
        padding: 28px 20px 24px;
        border-radius: 16px;
      }
      .brand-name {
        font-size: 21px;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  
  <!-- Branding Header -->
  <div class="brand-header">
    <a href="<?=base_url();?>" class="brand-logo-link">
      <div class="brand-icon-wrapper">
        <i class="fa fa-heartbeat"></i>
      </div>
      <div class="brand-name">
        Upchar
        <span>One Place of Healthcare</span>
      </div>
    </a>
    <div>
      <span class="badge-pill-portal">
        <span class="status-dot"></span> Central Master Administration
      </span>
    </div>
  </div>

  <!-- Glassmorphic Login Card -->
  <div class="login-card">
    
    <div class="card-title-box">
      <h1 class="card-title">Sign in to Admin Console</h1>
      <p class="card-subtitle">Authenticate to access platform controls, revenue &amp; operations</p>
    </div>

    <!-- Flash Alert Messages -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div class="alert-custom alert-danger">
        <i class="fa fa-exclamation-circle" style="font-size: 16px; margin-top: 2px;"></i>
        <div>
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Main Authentication Form -->
    <form action="<?=base_url('login');?>" method="post" id="adminLoginForm" autocomplete="off">
      
      <!-- Username / Admin ID Field -->
      <div class="form-group-custom">
        <div class="field-label-row">
          <label for="adminUsernameInput" class="field-label">
            <i class="fa-solid fa-user-shield"></i> Username or Admin ID
          </label>
          <span class="field-badge">Required</span>
        </div>
        <div class="input-control-wrap" id="usernameWrap">
          <div class="input-icon-left">
            <i class="fa fa-user"></i>
          </div>
          <input 
            type="text" 
            id="adminUsernameInput" 
            name="name" 
            class="custom-input" 
            placeholder="e.g. amitadmin" 
            required 
            autofocus 
            autocomplete="username"
            spellcheck="false"
          >
        </div>
      </div>

      <!-- Password Field with View Toggle & Caps Lock Detection -->
      <div class="form-group-custom">
        <div class="field-label-row">
          <label for="adminPasswordInput" class="field-label">
            <i class="fa-solid fa-key"></i> Master Password
          </label>
          <span class="field-badge">Encrypted</span>
        </div>
        <div class="input-control-wrap" id="passwordWrap">
          <div class="input-icon-left">
            <i class="fa fa-lock"></i>
          </div>
          <input 
            type="password" 
            id="adminPasswordInput" 
            name="password" 
            class="custom-input" 
            placeholder="Enter your master password" 
            required 
            autocomplete="current-password"
          >
          <button 
            type="button" 
            id="togglePasswordBtn" 
            class="password-toggle-btn" 
            title="Show/Hide password"
            aria-label="Toggle password visibility"
          >
            <i id="eyeToggleIcon" class="fa fa-eye"></i>
          </button>
        </div>
        
        <!-- Inline Caps Lock Alert Tooltip -->
        <div id="capsLockWarning" class="caps-lock-warning">
          <i class="fa fa-warning"></i> Caps Lock is ON
        </div>
      </div>

      <!-- Options Row -->
      <div class="form-options-row">
        <label class="custom-checkbox-label">
          <input type="checkbox" id="rememberMeCheckbox" name="remember_terminal" value="1" checked>
          <span>Keep session on this workstation</span>
        </label>
        <span class="security-badge-small">
          <i class="fa fa-shield"></i> 2FA / SSL
        </span>
      </div>

      <!-- Submit Action Button -->
      <button type="submit" class="btn-submit-login" id="btnSubmitLogin">
        <i class="fa fa-arrow-right-to-bracket" id="submitBtnIcon"></i>
        <span id="submitBtnText">Sign In to Dashboard</span>
      </button>

    </form>

    <!-- Card Security Footer -->
    <div class="card-footer-box">
      <div class="security-note">
        <i class="fa fa-shield-alt"></i> 256-Bit SSL Protected
      </div>
      <div class="portal-version">
        Admin Portal v2.4
      </div>
    </div>

  </div>

  <!-- Outer Footer -->
  <div class="page-footer">
    &copy; <?=date('Y');?> Upchar Healthcare &bull; 
    <a href="<?=base_url();?>../" target="_blank">Return to Main Site <i class="fa fa-external-link" style="font-size: 10px;"></i></a>
  </div>

</div>

<!-- Interactive JS Logic -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const pwdInput = document.getElementById('adminPasswordInput');
  const toggleBtn = document.getElementById('togglePasswordBtn');
  const eyeIcon = document.getElementById('eyeToggleIcon');
  const capsWarning = document.getElementById('capsLockWarning');
  const loginForm = document.getElementById('adminLoginForm');
  const submitBtn = document.getElementById('btnSubmitLogin');
  const submitText = document.getElementById('submitBtnText');
  const submitIcon = document.getElementById('submitBtnIcon');

  // Password Visibility Toggle
  if (toggleBtn && pwdInput) {
    toggleBtn.addEventListener('click', function(e) {
      e.preventDefault();
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        eyeIcon.className = 'fa fa-eye-slash';
        toggleBtn.setAttribute('title', 'Hide password');
      } else {
        pwdInput.type = 'password';
        eyeIcon.className = 'fa fa-eye';
        toggleBtn.setAttribute('title', 'Show password');
      }
      pwdInput.focus();
    });
  }

  // Caps Lock Detection on Password Field
  if (pwdInput && capsWarning) {
    pwdInput.addEventListener('keyup', function(event) {
      if (event.getModifierState && event.getModifierState('CapsLock')) {
        capsWarning.style.display = 'inline-flex';
      } else {
        capsWarning.style.display = 'none';
      }
    });

    pwdInput.addEventListener('keydown', function(event) {
      if (event.getModifierState && event.getModifierState('CapsLock')) {
        capsWarning.style.display = 'inline-flex';
      } else {
        capsWarning.style.display = 'none';
      }
    });

    pwdInput.addEventListener('blur', function() {
      capsWarning.style.display = 'none';
    });
  }

  // Double Submit Prevention & Loading Spinner
  if (loginForm) {
    loginForm.addEventListener('submit', function() {
      if (submitBtn) {
        submitBtn.disabled = true;
        submitText.textContent = 'Authenticating...';
        if (submitIcon) {
          submitIcon.className = 'fa fa-circle-notch fa-spin';
        }
      }
    });
  }
});
</script>

</body>
</html>
