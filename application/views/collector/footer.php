<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Bottom Navigation Bar -->
<nav class="collector-bottom-nav">
    <a href="<?=base_url('collector/dashboard');?>" class="col-nav-item <?=($this->uri->segment(1)=='collector' && empty($this->uri->segment(2))) ? 'active' : '';?>">
        <i class="fa fa-list-alt"></i>
        <span>My Pickups</span>
    </a>
    <a href="<?=base_url('attendance/punch');?>" class="col-nav-item <?=($this->uri->segment(1)=='attendance') ? 'active' : '';?>">
        <i class="fa fa-clock-o"></i>
        <span>Attendance</span>
    </a>
    <a href="<?=base_url('operations/expenses');?>" class="col-nav-item <?=($this->uri->segment(1)=='operations' && $this->uri->segment(2)=='expenses') ? 'active' : '';?>">
        <i class="fa fa-file-text-o"></i>
        <span>Expenses</span>
    </a>
    <a href="<?=base_url('staff/login');?>" class="col-nav-item">
        <i class="fa fa-user-circle"></i>
        <span>Portal</span>
    </a>
</nav>

<script src="<?=base_url('public/assets/js/bootstrap.min.js');?>"></script>
</body>
</html>
