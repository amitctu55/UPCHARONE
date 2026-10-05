<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification - Upchar Medical Solution</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    :root {
      --primary: #00A896;
      --navy: #0F172A;
      --bg: #F8FAFC;
      --text: #334155;
    }
    body {
      margin: 0;
      padding: 0;
      background-color: var(--bg);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      color: var(--text);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      box-sizing: border-box;
    }
    .verify-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
      max-width: 520px;
      width: 90%;
      margin: 20px auto;
      overflow: hidden;
      border: 1px solid #E2E8F0;
      text-align: center;
    }
    .verify-header {
      background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
      padding: 26px 20px;
      border-bottom: 4px solid var(--primary);
    }
    .verify-brand {
      font-size: 24px;
      font-weight: 800;
      letter-spacing: 1px;
      color: #ffffff;
    }
    .verify-brand span {
      color: var(--primary);
    }
    .verify-body {
      padding: 36px 30px;
    }
    .status-icon-box {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px auto;
      font-size: 36px;
    }
    .status-icon-box.success {
      background: #ECFDF5;
      color: #059669;
      border: 2px solid #A7F3D0;
    }
    .status-icon-box.failed {
      background: #FEF2F2;
      color: #DC2626;
      border: 2px solid #FECACA;
    }
    h1 {
      font-size: 22px;
      font-weight: 700;
      color: var(--navy);
      margin: 0 0 12px 0;
    }
    p {
      font-size: 14.5px;
      line-height: 1.6;
      color: #64748B;
      margin: 0 0 24px 0;
    }
    .btn-action {
      display: inline-block;
      background: var(--primary);
      color: #ffffff;
      text-decoration: none;
      font-size: 15px;
      font-weight: 600;
      padding: 13px 32px;
      border-radius: 8px;
      transition: all 0.2s ease;
      box-shadow: 0 4px 12px rgba(0, 168, 150, 0.28);
    }
    .btn-action:hover {
      background: #028090;
      transform: translateY(-1px);
    }
    .verify-footer {
      background: #F8FAFC;
      border-top: 1px solid #E2E8F0;
      padding: 18px 24px;
      font-size: 12px;
      color: #94A3B8;
    }
  </style>
</head>
<body>
  <div class="verify-card">
    <div class="verify-header">
      <div class="verify-brand">UPCHAR<span>.</span>INFO</div>
      <div style="font-size: 11.5px; color: #94A3B8; letter-spacing: 1.5px; text-transform: uppercase; margin-top: 4px;">Medical & Healthcare Solutions</div>
    </div>
    <div class="verify-body">
      <?php if ($status === 'success'): ?>
        <div class="status-icon-box success">
          <i class="fa fa-check"></i>
        </div>
        <h1>Email Verified Successfully!</h1>
        <p><?=htmlspecialchars($message);?></p>
        <a href="<?=base_url('login');?>" class="btn-action">Proceed to Sign In &rarr;</a>
      <?php else: ?>
        <div class="status-icon-box failed">
          <i class="fa fa-times"></i>
        </div>
        <h1>Verification Failed</h1>
        <p><?=htmlspecialchars($message);?></p>
        <a href="<?=base_url('login');?>" class="btn-action" style="background: #475569;">Back to Login</a>
      <?php endif; ?>
    </div>
    <div class="verify-footer">
      &copy; <?=date('Y');?> Upchar Medical Solution &bull; Need help? Call <strong>8448449603</strong>
    </div>
  </div>
</body>
</html>
