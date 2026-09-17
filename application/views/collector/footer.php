<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Bottom Navigation Bar -->
<nav class="collector-bottom-nav">
    <a href="<?=base_url('collector/dashboard');?>" class="col-nav-item <?=($this->uri->segment(1)=='collector' && empty($this->uri->segment(2))) ? 'active' : '';?>">
        <i class="fa fa-list-alt"></i>
        <span>My Pickups</span>
    </a>
    <a href="<?=base_url('staff/profile');?>" class="col-nav-item <?=($this->uri->segment(1)=='staff' && $this->uri->segment(2)=='profile') ? 'active' : '';?>">
        <i class="fa fa-id-card-o"></i>
        <span>My Profile</span>
    </a>
    <a href="<?=base_url('staff/login');?>" class="col-nav-item">
        <i class="fa fa-user-circle"></i>
        <span>Portal</span>
    </a>
</nav>

<script src="<?=base_url('public/assets/js/bootstrap.min.js');?>"></script>
</body>
</html>
