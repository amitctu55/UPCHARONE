</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg, #1d2a44 0%, #131e33 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif;">

<div class="login-box" style="width: 420px; max-width: 92%; margin: 30px auto;">
  <!-- Branding Header -->
  <div class="login-logo" style="margin-bottom: 20px; text-align: center;">
    <a href="<?=base_url();?>" style="color: #ffffff; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">
      <i class="fa fa-heartbeat" style="color: #00a896; font-size: 28px;"></i> Upchar Healthcare
    </a>
    <div style="font-size: 13px; color: #94a3b8; font-weight: 500; margin-top: 4px;">
      One Place of Healthcare &bull; Master Admin Portal
    </div>
  </div>

  <!-- Login Card Box -->
  <div class="login-box-body" style="background: #ffffff; border-radius: 12px; padding: 32px 28px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1);">
    <h2 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0; text-align: center;">
      Sign in to Admin Console
    </h2>
    <p style="font-size: 13px; color: #64748b; margin-bottom: 22px; text-align: center;">
      Enter your credentials to access system control panels
    </p>

    <!-- Flash Alert Message -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 18px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <!-- Clean Login Form -->
    <form action="<?=base_url('login');?>" method="post">
      <!-- Username Input -->
      <div class="form-group has-feedback" style="margin-bottom: 18px;">
        <label style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 6px;">Username or Admin ID</label>
        <div style="position: relative;">
          <input type="text" class="form-control" name="name" placeholder="Enter your username" required autofocus style="border-radius: 6px; padding: 10px 12px 10px 38px; height: 42px; font-size: 14px; border: 1px solid #cbd5e1;">
          <span class="fa fa-user" style="position: absolute; left: 13px; top: 13px; color: #94a3b8; font-size: 15px;"></span>
        </div>
      </div>

      <!-- Password Input -->
      <div class="form-group has-feedback" style="margin-bottom: 22px;">
        <label style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 6px;">Password</label>
        <div style="position: relative;">
          <input type="password" id="adminPasswordInput" class="form-control" name="password" placeholder="••••••••••••" required style="border-radius: 6px; padding: 10px 38px 10px 38px; height: 42px; font-size: 14px; border: 1px solid #cbd5e1;">
          <span class="fa fa-lock" style="position: absolute; left: 13px; top: 13px; color: #94a3b8; font-size: 15px;"></span>
          <button type="button" onclick="toggleLoginPassword()" style="position: absolute; right: 10px; top: 11px; background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0;">
            <i id="eyeToggleIcon" class="fa fa-eye"></i>
          </button>
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-block" style="background: #00a896; color: #ffffff; font-weight: 700; font-size: 14.5px; padding: 11px; border-radius: 6px; border: none; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 168, 150, 0.3);">
        <i class="fa fa-sign-in" style="margin-right: 6px;"></i> Sign In to Dashboard
      </button>
    </form>

    <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; text-align: center; font-size: 12px; color: #94a3b8;">
      <i class="fa fa-shield" style="color: #00a896;"></i> 256-Bit Encrypted Healthcare Session
    </div>
  </div>

  <div style="text-align: center; margin-top: 16px; font-size: 12px; color: #64748b;">
    &copy; <?=date('Y');?> Upchar. All rights reserved.
  </div>
</div>

<script>
function toggleLoginPassword() {
  var pwdInput = document.getElementById('adminPasswordInput');
  var eyeIcon = document.getElementById('eyeToggleIcon');
  if (pwdInput.type === 'password') {
    pwdInput.type = 'text';
    eyeIcon.className = 'fa fa-eye-slash';
  } else {
    pwdInput.type = 'password';
    eyeIcon.className = 'fa fa-eye';
  }
}
</script>

</body>
</html>
