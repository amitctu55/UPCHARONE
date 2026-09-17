<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 Forbidden - Access Restricted | Upchar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      background: #0f172a;
      color: #f8fafc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .error-card {
      background: #1e293b;
      border: 1px solid #334155;
      border-radius: 16px;
      max-width: 540px;
      width: 100%;
      padding: 40px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    .icon-wrap {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      background: rgba(239, 68, 68, 0.12);
      border: 2px solid rgba(239, 68, 68, 0.3);
      color: #ef4444;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 34px;
      margin-bottom: 22px;
    }
    h1 {
      font-size: 24px;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 10px;
      letter-spacing: -0.5px;
    }
    .tag {
      display: inline-block;
      padding: 4px 12px;
      background: rgba(239, 68, 68, 0.2);
      color: #fca5a5;
      border-radius: 9999px;
      font-size: 11.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 16px;
    }
    p {
      color: #94a3b8;
      font-size: 14.5px;
      line-height: 1.6;
      margin-bottom: 24px;
    }
    .user-info {
      background: #0f172a;
      border: 1px solid #334155;
      border-radius: 8px;
      padding: 12px 16px;
      font-size: 13px;
      color: #cbd5e1;
      margin-bottom: 26px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .actions {
      display: flex;
      gap: 12px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      cursor: pointer;
    }
    .btn-primary {
      background: #00a896;
      color: #ffffff;
      border: 1px solid #00a896;
    }
    .btn-primary:hover {
      background: #028072;
    }
    .btn-secondary {
      background: transparent;
      color: #94a3b8;
      border: 1px solid #475569;
    }
    .btn-secondary:hover {
      background: #334155;
      color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="error-card">
    <div class="icon-wrap">
      <i class="fa fa-shield"></i>
    </div>
    <div class="tag">403 Forbidden &bull; Role Authorization Failure</div>
    <h1>Administrator Privileges Required</h1>
    <p>
      The resource you requested resides within the secured <strong style="color: #f1f5f9;">/admin1947</strong> namespace. Access is strictly restricted to authenticated accounts with an <strong style="color: #f1f5f9;">admin</strong> or <strong style="color: #f1f5f9;">super admin</strong> role.
    </p>

    <div class="user-info">
      <span>Current Session: <strong><?=htmlspecialchars($currentUser ?? 'Guest');?></strong></span>
      <span style="color: #ef4444; font-weight: 700;">Role: <?=htmlspecialchars($currentRole ?? 'RESTRICTED');?></span>
    </div>

    <div class="actions">
      <a href="<?=base_url('admin1947/login');?>" class="btn btn-primary">
        <i class="fa fa-sign-in"></i> Admin Login
      </a>
      <a href="<?=base_url();?>" class="btn btn-secondary">
        <i class="fa fa-home"></i> Return to Homepage
      </a>
    </div>
  </div>
</body>
</html>
