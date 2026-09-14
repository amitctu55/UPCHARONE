<?php
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

// Dynamic active state determination strictly for Chemist Panel
$isDashboard = ($seg1 == 'medical-dashboard') 
            || ($seg1 == 'pharmacy' && ($seg2 == 'dashboard' || empty($seg2))) 
            || ($seg1 == 'medicalpanel' && ($seg2 == 'dashboard' || empty($seg2)));

$isInventory = ($seg1 == 'pharmacy' && in_array($seg2, array('inventory', 'inventory_import', 'confirm_stock'))) 
            || ($seg1 == 'medicalpanel' && in_array($seg2, array('addandimport', 'import', 'exportsheet')));

$isOrders    = ($seg1 == 'pharmacy' && in_array($seg2, array('orders', 'billing', 'billing_generate', 'print_invoice', 'orders_pending', 'orders_status', 'mark_packed'))) 
            || ($seg1 == 'medicalpanel' && in_array($seg2, array('pendingorder', 'order')));

$isDelivery  = ($seg1 == 'pharmacy' && in_array($seg2, array('delivery', 'delivery_assign'))) 
            || ($seg1 == 'delivery');

$isPayments  = ($seg1 == 'pharmacy' && in_array($seg2, array('payments', 'webhook_payment')));

$isProfile   = ($seg1 == 'pharmacy' && in_array($seg2, array('profile', 'profile_edit', 'profile_update', 'profile_verification', 'profile_onboarding'))) 
            || ($seg1 == 'medicalpanel' && in_array($seg2, array('updateprofile', 'change_password', 'profile_step21', 'profile_step22', 'profile_step23', 'profile_about2', 'profile_drpic2', 'profile_idproof2', 'profile_regproof2')));

$isReport    = ($seg1 == 'pharmacy' && $seg2 == 'reports') 
            || ($seg1 == 'medicalpanel' && $seg2 == 'report');

$isGallery   = ($seg1 == 'pharmacy' && $seg2 == 'gallery') 
            || ($seg1 == 'medicalpanel' && in_array($seg2, array('gallery', 'managegallery')));
?>

<div class="sidebar">
  <div class="sidebar-inner">
    <div class="sidebar-heading" style="padding: 14px 20px 8px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8;">
      Chemist Command
    </div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isDashboard ? 'active' : '';?>">
        <a href="<?=base_url('medical-dashboard');?>" class="<?=$isDashboard ? 'active' : '';?>">
          <i class="fa fa-home"></i><span>Dashboard</span>
        </a>
      </li>
      <li class="<?=$isInventory ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/inventory');?>" class="<?=$isInventory ? 'active' : '';?>">
          <i class="fa fa-cubes" aria-hidden="true"></i><span>Inventory & Stocks</span>
        </a>
      </li>
      <li class="<?=$isOrders ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/orders');?>" class="<?=$isOrders ? 'active' : '';?>">
          <i class="fa fa-shopping-bag" aria-hidden="true"></i><span>Live Orders & Bills</span>
        </a>
      </li>
      <li class="<?=$isDelivery ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/delivery');?>" class="<?=$isDelivery ? 'active' : '';?>">
          <i class="fa fa-motorcycle" aria-hidden="true"></i><span>Delivery Handover</span>
        </a>
      </li>
      <li class="<?=$isPayments ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/payments');?>" class="<?=$isPayments ? 'active' : '';?>">
          <i class="fa fa-credit-card" aria-hidden="true"></i><span>Payments & Payouts</span>
        </a>
      </li>
      <li class="<?=$isProfile ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/profile/edit');?>" class="<?=$isProfile ? 'active' : '';?>">
          <i class="fa fa-medkit" aria-hidden="true"></i><span>Pharmacy Profile</span>
        </a>
      </li>
      <li class="<?=$isReport ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/reports');?>" class="<?=$isReport ? 'active' : '';?>">
          <i class="fa fa-bar-chart" aria-hidden="true"></i><span>Reports & Stats</span>
        </a>
      </li>
      <li class="<?=$isGallery ? 'active' : '';?>">
        <a href="<?=base_url('pharmacy/gallery');?>" class="<?=$isGallery ? 'active' : '';?>">
          <i class="fa fa-picture-o" aria-hidden="true"></i><span>Gallery</span>
        </a>
      </li>
    </ul>
  </div>
</div>