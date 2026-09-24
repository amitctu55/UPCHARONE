<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? html_escape($page_title) : 'UPCHAR Admin'; ?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body { background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; color: #1e293b; margin: 0; padding: 0; }
    .admin-navbar { background: #043d5b; border: none; border-radius: 0; margin-bottom: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
    .admin-navbar .navbar-brand { color: #ffffff !important; font-weight: 800; font-size: 18px; letter-spacing: 0.5px; }
    .admin-navbar .navbar-brand span { color: #00a896; }
    .admin-navbar .nav > li > a { color: #cbd5e1 !important; font-size: 13px; font-weight: 600; padding: 15px 18px; }
    .admin-navbar .nav > li > a:hover, .admin-navbar .nav > li.active > a { color: #ffffff !important; background: rgba(255,255,255,0.1); }
  </style>
</head>
<body>
  <nav class="navbar navbar-default admin-navbar">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?= base_url('admin/blog'); ?>">UPCHAR <span>ADMIN</span></a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?= base_url('admin/blog'); ?>"><i class="fas fa-newspaper"></i> Blog Posts</a></li>
        <li><a href="<?= base_url('admin/blog/create'); ?>"><i class="fas fa-plus-circle"></i> Create Article</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?= base_url('blog'); ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View Public Blog</a></li>
        <li><a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Main Site</a></li>
      </ul>
    </div>
  </nav>
