<?php
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

$isDashboard   = ($seg1 == 'pathlab-dashboard' || ($seg1 == 'pathlabpanel' && ($seg2 == 'dashboard' || $seg2 == '' || $seg2 == 'milestone')));
$isPathTest    = ($seg1 == 'pathlabpanel' && $seg2 == 'pathtest');
$isAddTest     = ($seg1 == 'pathlabpanel' && $seg2 == 'addtest');
$isTestBooking = ($seg1 == 'pathlabpanel' && ($seg2 == 'test_booking' || $seg2 == 'booking_details'));
$isBookTest    = ($seg1 == 'pathlabpanel' && $seg2 == 'book_test');
$isReport      = ($seg1 == 'pathlabpanel' && $seg2 == 'report');
$isManageDoc   = ($seg1 == 'pathlabpanel' && in_array($seg2, array('managedoctor', 'adddoctor', 'updatedoctor', 'manageappointment')));
$isDocList     = ($seg1 == 'pathlabpanel' && in_array($seg2, array('doctorlist', 'doctordetail')));
$isProfile     = ($seg1 == 'pathlabpanel' && in_array($seg2, array('updateprofile', 'profile_clinicproof', 'profile_drpic', 'profile_regproof', 'profile_maplocation', 'profile_clinic_timing')));
$isPayments    = ($seg1 == 'pathlabpanel' && $seg2 == 'payments');
$isSettings    = ($seg1 == 'pathlabpanel' && in_array($seg2, array('settings', 'change_password')));
?>

<aside class="pathlab-sidebar">
    <div style="padding: 20px 14px 10px;">
        <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; padding-left: 10px; margin-bottom: 8px;">
            Main Navigation
        </div>
        
        <nav style="display: flex; flex-direction: column; gap: 4px;">
            <!-- 1. Dashboard -->
            <a href="<?=base_url('pathlab-dashboard');?>" class="sidebar-nav-link <?=$isDashboard ? 'active' : '';?>">
                <i class="fa fa-th-large"></i>
                <span>Dashboard</span>
            </a>

            <!-- 2. Path Tests Catalog -->
            <a href="<?=base_url('pathlabpanel/pathtest');?>" class="sidebar-nav-link <?=$isPathTest ? 'active' : '';?>">
                <i class="fa fa-flask"></i>
                <span>Path Tests Catalog</span>
            </a>

            <!-- 3. Add New Test -->
            <a href="<?=base_url('pathlabpanel/addtest');?>" class="sidebar-nav-link <?=$isAddTest ? 'active' : '';?>">
                <i class="fa fa-plus-square-o"></i>
                <span>Add New Test</span>
            </a>

            <!-- 4. Test Bookings Queue -->
            <a href="<?=base_url('pathlabpanel/test_booking');?>" class="sidebar-nav-link <?=$isTestBooking ? 'active' : '';?>">
                <i class="fa fa-calendar-check-o"></i>
                <span>Test Bookings</span>
            </a>

            <!-- 5. Book Diagnostic Test -->
            <a href="<?=base_url('pathlabpanel/book_test');?>" class="sidebar-nav-link <?=$isBookTest ? 'active' : '';?>">
                <i class="fa fa-pencil-square-o"></i>
                <span>Book Lab Test</span>
            </a>

            <!-- 6. Reports & Analytics -->
            <a href="<?=base_url('pathlabpanel/report');?>" class="sidebar-nav-link <?=$isReport ? 'active' : '';?>">
                <i class="fa fa-bar-chart"></i>
                <span>Reports & Analytics</span>
            </a>

            <div style="height: 1px; background: rgba(255,255,255,0.08); margin: 12px 10px;"></div>

            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; padding-left: 10px; margin-bottom: 6px;">
                Specialists & Center
            </div>

            <!-- 7. Manage Doctors -->
            <a href="<?=base_url('pathlabpanel/managedoctor');?>" class="sidebar-nav-link <?=$isManageDoc ? 'active' : '';?>">
                <i class="fa fa-user-md"></i>
                <span>Manage Doctors</span>
            </a>

            <!-- 8. Doctor List -->
            <a href="<?=base_url('pathlabpanel/doctorlist');?>" class="sidebar-nav-link <?=$isDocList ? 'active' : '';?>">
                <i class="fa fa-users"></i>
                <span>Doctor Directory</span>
            </a>

            <!-- 9. Pathlab Profile -->
            <a href="<?=base_url('pathlabpanel/updateprofile');?>" class="sidebar-nav-link <?=$isProfile ? 'active' : '';?>">
                <i class="fa fa-hospital-o"></i>
                <span>Pathlab Profile</span>
            </a>

            <!-- 10. Payments -->
            <a href="<?=base_url('pathlabpanel/payments');?>" class="sidebar-nav-link <?=$isPayments ? 'active' : '';?>">
                <i class="fa fa-credit-card"></i>
                <span>Billing & Payments</span>
            </a>

            <!-- 11. Settings -->
            <a href="<?=base_url('pathlabpanel/settings');?>" class="sidebar-nav-link <?=$isSettings ? 'active' : '';?>">
                <i class="fa fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>
    </div>
</aside>

<div class="pathlab-main-viewport">
    <main id="main-content" style="flex: 1;">

<style>
.sidebar-nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 8px;
    color: #cbd5e1 !important;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.sidebar-nav-link:hover {
    background: rgba(255,255,255,0.07);
    color: #ffffff !important;
    transform: translateX(2px);
}

.sidebar-nav-link.active {
    background: #00a896 !important;
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}

.sidebar-nav-link i {
    font-size: 15px;
    width: 20px;
    text-align: center;
    opacity: 0.85;
}

.sidebar-nav-link.active i {
    opacity: 1;
}
</style>