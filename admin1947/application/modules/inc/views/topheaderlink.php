<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Upchar One Place of Healthcare | Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/morris.js/morris.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?=base_url();?>public/assets/newpanel/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

  <!-- Modern Admin Overrides & Design System -->
  <style>
    :root {
      --admin-navy: #1d2a44;
      --admin-navy-dark: #131e33;
      --admin-teal: #00a896;
      --admin-teal-hover: #008f80;
      --admin-bg-light: #f8fafc;
      --admin-text-dark: #1e293b;
      --admin-text-muted: #64748b;
      --admin-border: #e2e8f0;
    }

    body, .main-header, .content-wrapper, .main-footer, .form-control, .btn {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    body {
      background-color: var(--admin-bg-light) !important;
      color: var(--admin-text-dark);
    }

    .content-wrapper {
      background-color: var(--admin-bg-light) !important;
    }

    /* Top Navbar */
    .main-header .navbar {
      background: var(--admin-navy) !important;
      border-bottom: 2px solid var(--admin-teal);
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .main-header .logo {
      background: var(--admin-navy-dark) !important;
      font-weight: 700;
      color: var(--admin-teal) !important;
      border-bottom: 2px solid var(--admin-teal);
      letter-spacing: 0.5px;
    }

    .main-header .logo:hover {
      background: #0d1524 !important;
    }

    /* Sidebar Styling */
    .main-sidebar {
      background-color: var(--admin-navy) !important;
      box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }

    .sidebar-menu > li.header {
      background: var(--admin-navy-dark) !important;
      color: #94a3b8 !important;
      font-size: 10px !important;
      font-weight: 700 !important;
      letter-spacing: 0.8px;
      padding: 12px 15px 8px !important;
    }

    .sidebar-menu > li > a {
      padding: 11px 15px !important;
      color: #cbd5e1 !important;
      font-weight: 500;
      transition: all 0.2s ease;
      border-left: 3px solid transparent;
    }

    .sidebar-menu > li:hover > a, 
    .sidebar-menu > li.active > a {
      background: #243452 !important;
      color: #ffffff !important;
      border-left-color: var(--admin-teal) !important;
    }

    .sidebar-menu .treeview-menu {
      background: var(--admin-navy-dark) !important;
      padding: 4px 0;
    }

    .sidebar-menu .treeview-menu > li > a {
      padding: 8px 15px 8px 25px !important;
      color: #94a3b8 !important;
      font-size: 13px;
      transition: all 0.15s ease;
    }

    .sidebar-menu .treeview-menu > li.active > a,
    .sidebar-menu .treeview-menu > li:hover > a {
      color: var(--admin-teal) !important;
      font-weight: 600;
      padding-left: 28px !important;
    }

    /* Content Header & Breadcrumbs */
    .content-header {
      padding: 20px 20px 10px !important;
    }

    .content-header > h1 {
      font-size: 22px;
      font-weight: 700;
      color: var(--admin-text-dark);
      margin: 0;
    }

    .content-header > h1 > small {
      font-size: 13px;
      color: var(--admin-text-muted);
      margin-left: 8px;
    }

    .breadcrumb {
      background: transparent !important;
      padding: 0 !important;
      font-size: 12px;
      color: var(--admin-text-muted);
    }

    .breadcrumb > li > a {
      color: var(--admin-teal);
    }

    /* Modern Card Boxes */
    .box {
      border-radius: 12px !important;
      box-shadow: 0 4px 15px rgba(0,0,0,0.04) !important;
      border: 1px solid var(--admin-border) !important;
      background: #ffffff !important;
      margin-bottom: 24px !important;
    }

    .box-header {
      padding: 16px 20px !important;
      border-bottom: 1px solid var(--admin-border) !important;
    }

    .box-header .box-title {
      font-size: 16px !important;
      font-weight: 600 !important;
      color: var(--admin-text-dark) !important;
    }

    .box-body {
      padding: 20px !important;
    }

    /* Modern Tables */
    .table {
      margin-bottom: 0 !important;
    }

    .table thead th {
      background: #f1f5f9 !important;
      color: #334155 !important;
      font-weight: 600 !important;
      font-size: 11.5px !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
      border-bottom: 2px solid #cbd5e1 !important;
      padding: 12px 14px !important;
    }

    .table tbody td {
      vertical-align: middle !important;
      padding: 12px 14px !important;
      border-top: 1px solid #f1f5f9 !important;
      font-size: 13px !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #fafbfc;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f5f9 !important;
    }

    /* Modern Status Badges */
    .label {
      border-radius: 20px !important;
      padding: 4px 10px !important;
      font-weight: 600 !important;
      font-size: 11px !important;
      display: inline-block !important;
      letter-spacing: 0.3px;
    }

    .label-success { background-color: #10b981 !important; }
    .label-warning { background-color: #f59e0b !important; }
    .label-danger { background-color: #ef4444 !important; }
    .label-info { background-color: #0ea5e9 !important; }
    .label-primary { background-color: #1d5b79 !important; }
    .label-default { background-color: #64748b !important; }

    /* Modern Form Controls */
    .form-control {
      border-radius: 8px !important;
      border: 1px solid #cbd5e1 !important;
      box-shadow: none !important;
      padding: 8px 12px !important;
      height: 38px !important;
      color: var(--admin-text-dark);
      font-size: 13px;
    }

    .form-control:focus {
      border-color: var(--admin-teal) !important;
      box-shadow: 0 0 0 3px rgba(0,168,150,0.15) !important;
    }

    /* Modern Buttons */
    .btn {
      border-radius: 8px !important;
      font-weight: 500 !important;
      padding: 7px 16px !important;
      font-size: 13px !important;
      transition: all 0.15s ease-in-out;
    }

    .btn-sm, .btn-xs {
      padding: 4px 10px !important;
      font-size: 12px !important;
      border-radius: 6px !important;
    }

    .btn-primary {
      background-color: var(--admin-teal) !important;
      border-color: var(--admin-teal) !important;
      color: #ffffff !important;
    }

    .btn-primary:hover, .btn-primary:focus {
      background-color: var(--admin-teal-hover) !important;
      border-color: var(--admin-teal-hover) !important;
    }

    .btn-success {
      background-color: #10b981 !important;
      border-color: #10b981 !important;
    }

    .btn-success:hover {
      background-color: #059669 !important;
      border-color: #059669 !important;
    }

    /* Metric Cards on Dashboard */
    .metric-card {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid var(--admin-border);
      padding: 20px 15px;
      margin-bottom: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.04);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .metric-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      border-color: var(--admin-teal);
    }

    .metric-value {
      font-size: 26px;
      font-weight: 700;
      color: var(--admin-text-dark);
      margin: 8px 0 2px;
    }

    .metric-label {
      font-size: 13px;
      font-weight: 600;
      color: var(--admin-text-muted);
    }

    /* Modern Master Components & Design System */
    .master-card {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid var(--admin-border);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      margin-bottom: 24px;
      overflow: hidden;
    }

    .master-card-header {
      padding: 16px 20px;
      background: #ffffff;
      border-bottom: 1px solid var(--admin-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .master-card-title {
      font-size: 16px;
      font-weight: 700;
      color: var(--admin-text-dark);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .master-card-body {
      padding: 20px;
    }

    .master-sticky-form {
      position: -webkit-sticky;
      position: sticky;
      top: 15px;
      z-index: 10;
    }

    .master-toolbar {
      background: #f8fafc;
      border-radius: 8px;
      border: 1px solid var(--admin-border);
      padding: 12px 16px;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
    }

    .badge-pill-status {
      border-radius: 9999px;
      padding: 4px 12px;
      font-weight: 600;
      font-size: 11.5px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
      text-decoration: none !important;
      transition: all 0.2s ease;
    }

    .badge-status-active {
      background: #dcfce7 !important;
      color: #15803d !important;
      border: 1px solid #bbf7d0 !important;
    }

    .badge-status-active:hover {
      background: #bbf7d0 !important;
      color: #14532d !important;
    }

    .badge-status-inactive {
      background: #fee2e2 !important;
      color: #b91c1c !important;
      border: 1px solid #fecaca !important;
    }

    .badge-status-inactive:hover {
      background: #fecaca !important;
      color: #7f1d1d !important;
    }

    .btn-icon-action {
      width: 32px;
      height: 32px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid transparent;
      transition: all 0.15s ease;
      cursor: pointer;
      font-size: 13px;
      text-decoration: none !important;
      margin: 0 2px;
    }

    .btn-action-edit {
      color: #0284c7 !important;
      background: #e0f2fe !important;
      border-color: #bae6fd !important;
    }

    .btn-action-edit:hover {
      background: #0284c7 !important;
      color: #ffffff !important;
      transform: translateY(-1px);
    }

    .btn-action-delete {
      color: #dc2626 !important;
      background: #fee2e2 !important;
      border-color: #fecaca !important;
    }

    .btn-action-delete:hover {
      background: #dc2626 !important;
      color: #ffffff !important;
      transform: translateY(-1px);
    }

    .upload-dropzone {
      border: 2px dashed #cbd5e1;
      border-radius: 8px;
      padding: 16px;
      text-align: center;
      background: #f8fafc;
      cursor: pointer;
      transition: all 0.2s;
      margin-bottom: 15px;
    }

    .upload-dropzone:hover {
      border-color: var(--admin-teal);
      background: #f0fdf4;
    }

    .upload-preview-thumb {
      max-height: 70px;
      border-radius: 6px;
      margin-top: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: none;
    }

    /* Live File Upload Box */
    .upload-preview-box {
      border: 2px dashed #cbd5e1;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      background: #f8fafc;
      cursor: pointer;
      transition: border-color 0.2s;
    }

    .upload-preview-box:hover {
      border-color: var(--admin-teal);
      background: #f0fdf4;
    }

    .upload-preview-img {
      max-height: 120px;
      border-radius: 8px;
      margin-top: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Multi-Step Tabbed Form Cards */
    .form-wizard-tabs {
      display: flex;
      border-bottom: 2px solid #e2e8f0;
      margin-bottom: 24px;
      background: #f8fafc;
      border-radius: 10px 10px 0 0;
      padding: 6px 12px 0;
      overflow-x: auto;
    }

    .form-wizard-tabs li {
      list-style: none;
      margin-right: 8px;
    }

    .form-wizard-tabs li a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 12px 18px;
      color: #64748b;
      font-weight: 600;
      font-size: 13.5px;
      border: none;
      border-bottom: 3px solid transparent;
      text-decoration: none !important;
      transition: all 0.2s;
      border-radius: 6px 6px 0 0;
    }

    .form-wizard-tabs li a:hover {
      color: var(--admin-teal);
      background: rgba(0, 168, 150, 0.05);
    }

    .form-wizard-tabs li.active a {
      color: var(--admin-teal);
      border-bottom: 3px solid var(--admin-teal);
      background: #ffffff;
    }

    .step-number {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: #e2e8f0;
      color: #475569;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 11.5px;
      font-weight: 700;
    }

    .form-wizard-tabs li.active .step-number {
      background: var(--admin-teal);
      color: #ffffff;
    }

    /* Responsive Gallery Grid */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
      margin-top: 15px;
    }

    .gallery-card {
      background: #ffffff;
      border-radius: 10px;
      border: 1px solid #e2e8f0;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.04);
      transition: transform 0.2s, box-shadow 0.2s;
      display: flex;
      flex-direction: column;
    }

    .gallery-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
      border-color: var(--admin-teal);
    }

    .gallery-thumb-container {
      width: 100%;
      height: 150px;
      background: #f1f5f9;
      position: relative;
      overflow: hidden;
    }

    .gallery-thumb-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;
    }

    .gallery-card:hover .gallery-thumb-img {
      transform: scale(1.05);
    }

    .gallery-card-body {
      padding: 12px 14px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .gallery-card-title {
      font-size: 13px;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 6px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .gallery-card-meta {
      font-size: 11.5px;
      color: #64748b;
      margin-bottom: 10px;
    }

    .gallery-card-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid #f1f5f9;
      padding-top: 10px;
    }

    /* Pending Badge */
    .badge-status-pending {
      background: #fef3c7 !important;
      color: #d97706 !important;
      border: 1px solid #fde68a !important;
    }
  </style>

  <!-- jQuery 3 (Loaded in head so view scripts always execute reliably) -->
  <script src="<?=base_url();?>public/assets/newpanel/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">