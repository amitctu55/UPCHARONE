<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <h1>
      <i class="fa fa-motorcycle" style="color: #00a8ff;"></i> Pharmacy Accounts &amp; Delivery Fleet Console
      <small>UPCHAR Healthcare Logistics &amp; Chemist Partner Intermediary</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Masters</a></li>
      <li class="active">Pharmacy &amp; Delivery Fleet</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Flash Notifications -->
    <?php if ($this->session->flashdata('success') || $this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible" style="border-radius: 6px;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success') ?: $this->session->flashdata('success_msg'); ?>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error') || $this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible" style="border-radius: 6px;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="fa fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?: $this->session->flashdata('error_msg'); ?>
    </div>
    <?php endif; ?>

    <!-- Metric Stats Widgets -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
          <span class="info-box-icon" style="background: #08364b; color: #fff; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <i class="fa fa-medkit"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Partner Pharmacies</span>
            <span class="info-box-number"><?=$total_stores;?> <small>Verified</small></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
          <span class="info-box-icon" style="background: #00a8ff; color: #fff; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <i class="fa fa-motorcycle"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Fleet Riders</span>
            <span class="info-box-number"><?=$active_riders_count;?> / <?=$total_riders;?> <small>Active</small></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
          <span class="info-box-icon" style="background: #16a34a; color: #fff; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <i class="fa fa-truck"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Active Deliveries</span>
            <span class="info-box-number"><?=$active_orders_count;?> <small>En-Route</small></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
          <span class="info-box-icon" style="background: #0284c7; color: #fff; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
            <i class="fa fa-money"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Settlements</span>
            <span class="info-box-number"><?=$total_settlements;?> <small>Ledgers</small></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Card Container -->
    <div class="upchar-admin-container">
      <div class="admin-card">

        <!-- Tab Navigation Menu (Server-side rendered HTML links) -->
        <div class="server-tabs-bar">
          <ul class="nav nav-tabs server-nav-tabs">
            <li class="<?= ($active_tab == 'pharmacy') ? 'active' : ''; ?>">
              <a href="<?= base_url('masters/pharmacy_fleet?tab=pharmacy'); ?>">
                <i class="fa fa-medkit"></i> Partner Pharmacies <span class="badge"><?=$total_stores;?></span>
              </a>
            </li>
            <li class="<?= ($active_tab == 'fleet') ? 'active' : ''; ?>">
              <a href="<?= base_url('masters/pharmacy_fleet?tab=fleet'); ?>">
                <i class="fa fa-motorcycle"></i> Delivery Fleet &amp; Riders <span class="badge"><?=$total_riders;?></span>
              </a>
            </li>
            <li class="<?= ($active_tab == 'dispatch') ? 'active' : ''; ?>">
              <a href="<?= base_url('masters/pharmacy_fleet?tab=dispatch'); ?>">
                <i class="fa fa-truck"></i> Live Dispatch Queue <span class="badge"><?=$active_orders_count;?></span>
              </a>
            </li>
            <li class="<?= ($active_tab == 'settlements') ? 'active' : ''; ?>">
              <a href="<?= base_url('masters/pharmacy_fleet?tab=settlements'); ?>">
                <i class="fa fa-file-text-o"></i> Financial Settlements <span class="badge"><?=$total_settlements;?></span>
              </a>
            </li>
          </ul>

          <!-- Action Button according to Active Tab -->
          <div class="tab-action-btn-area">
            <?php if ($active_tab == 'pharmacy'): ?>
              <a href="<?= base_url('masters/pharmacy_fleet/add_pharmacy'); ?>" class="btn-primary-add" style="text-decoration: none; color: #fff;">
                <i class="fa fa-plus-circle"></i> + Add New Pharmacy
              </a>
            <?php elseif ($active_tab == 'fleet'): ?>
              <a href="<?= base_url('masters/pharmacy_fleet/onboard_rider'); ?>" class="btn-primary-add" style="text-decoration: none; color: #fff;">
                <i class="fa fa-user-plus"></i> + Onboard Rider
              </a>
            <?php elseif ($active_tab == 'dispatch'): ?>
              <a href="<?= base_url('masters/pharmacy_fleet/reassign_order'); ?>" class="btn-primary-add" style="text-decoration: none; color: #fff;">
                <i class="fa fa-exchange"></i> Manual Dispatch
              </a>
            <?php elseif ($active_tab == 'settlements'): ?>
              <a href="<?= base_url('masters/pharmacy_fleet/record_settlement'); ?>" class="btn-primary-add" style="text-decoration: none; color: #fff;">
                <i class="fa fa-plus-circle"></i> + Record Settlement
              </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="table-search-bar">
          <form action="<?= base_url('masters/pharmacy_fleet'); ?>" method="GET" class="form-inline">
            <input type="hidden" name="tab" value="<?= html_escape($active_tab); ?>">
            <div class="input-group input-group-sm" style="width: 320px;">
              <input type="text" name="keyword" class="form-control" placeholder="Search in <?= ucfirst($active_tab); ?>..." value="<?= html_escape($keyword); ?>">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                <?php if (!empty($keyword)): ?>
                  <a href="<?= base_url('masters/pharmacy_fleet?tab=' . $active_tab); ?>" class="btn btn-default" title="Clear Search"><i class="fa fa-times"></i></a>
                <?php endif; ?>
              </span>
            </div>
          </form>
          <div class="text-muted" style="font-size: 12.5px;">
            Showing page <?= floor($current_page / 10) + 1; ?> &bull; 10 per page
          </div>
        </div>

        <!-- ========================================================
             SERVER-SIDE ACTIVE TAB CONTENT
             ======================================================== -->
        <div class="table-responsive">

          <!-- TAB 1: PHARMACY STORES -->
          <?php if ($active_tab == 'pharmacy'): ?>
          <table class="upchar-table">
            <thead>
              <tr>
                <th>Store &amp; Contact</th>
                <th>Drug License / GST</th>
                <th>Affiliated Doctor/Hospital</th>
                <th>Radius &amp; Commission</th>
                <th>Status</th>
                <th>Operational Controls</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($records)): foreach($records as $st): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars($st['store_name']); ?></strong>
                  <?php if (!empty($st['is_emergency_closed'])): ?>
                    <span class="badge" style="background: #dc2626; font-size: 10px; margin-left: 4px;">EMERGENCY CLOSED</span>
                  <?php endif; ?>
                  <br>
                  <small class="text-muted">
                    <i class="fa fa-phone"></i> <?= htmlspecialchars($st['phone']); ?> | 
                    <?= htmlspecialchars($st['address'] ?: 'Varanasi'); ?>, <?= htmlspecialchars($st['city']); ?>
                  </small>
                </td>
                <td>
                  <code><?= htmlspecialchars($st['drug_license_no'] ?: 'N/A'); ?></code><br>
                  <small class="text-muted">GST: <?= htmlspecialchars($st['gstin'] ?: 'Not Provided'); ?></small>
                </td>
                <td>
                  <?php if (!empty($st['doctor_name'])): ?>
                    <span class="doctor-tag"><?= htmlspecialchars($st['doctor_name']); ?></span>
                  <?php endif; ?>
                  <?php if (!empty($st['hospital_name'])): ?>
                    <small style="color: #475569; display: block;">(<?= htmlspecialchars($st['hospital_name']); ?>)</small>
                  <?php endif; ?>
                  <?php if (empty($st['doctor_name']) && empty($st['hospital_name'])): ?>
                    <span style="color: #94a3b8; font-size: 12px;">Independent Partner</span>
                  <?php endif; ?>
                </td>
                <td>
                  <strong><?= $st['delivery_radius_km'] ?: '5.0'; ?> km</strong> radius | <strong><?= $st['commission_rate']; ?>%</strong> fee
                  <div style="font-size: 11px; color: #64748b;">Hrs: <?= htmlspecialchars($st['operating_hours'] ?: '9AM - 10PM'); ?></div>
                </td>
                <td>
                  <?php if ($st['is_emergency_closed']): ?>
                    <span class="status-pill" style="background: #fee2e2; color: #dc2626;">Halted</span>
                  <?php else: ?>
                    <span class="status-pill status-active"><i class="fa fa-check-circle"></i> Active &amp; Live</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= base_url('masters/pharmacy_fleet/add_pharmacy/' . $st['id']); ?>" class="btn-sm-action">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                  <a href="<?= base_url('masters/pharmacy_fleet/toggle_emergency_closure/' . $st['id']); ?>" class="btn-sm-action" style="<?= $st['is_emergency_closed'] ? 'color: #16a34a;' : 'color: #dc2626;'; ?>">
                    <i class="fa fa-power-off"></i> <?= $st['is_emergency_closed'] ? 'Reopen' : 'Halt'; ?>
                  </a>
                  <a href="<?= base_url('../pharmacy/orders?store_id=' . $st['id']); ?>" target="_blank" class="btn-sm-action" title="Open Chemist Portal">
                    <i class="fa fa-external-link"></i> Orders
                  </a>
                </td>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="6" class="text-center" style="padding: 36px 20px;">
                  <i class="fa fa-medkit text-muted" style="font-size: 32px; margin-bottom: 8px;"></i>
                  <p class="text-muted" style="margin: 0;">No partner pharmacies match the criteria.</p>
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <!-- TAB 2: DELIVERY FLEET RIDERS -->
          <?php elseif ($active_tab == 'fleet'): ?>
          <table class="upchar-table">
            <thead>
              <tr>
                <th>Rider Name &amp; Contact</th>
                <th>Vehicle &amp; License</th>
                <th>Current Status</th>
                <th>Active Delivery</th>
                <th>COD in Hand</th>
                <th>Operational Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($records)): foreach($records as $r): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars($r['name'] ?: $r['rider_name']); ?></strong><br>
                  <small class="text-muted"><i class="fa fa-phone"></i> +91 <?= htmlspecialchars($r['phone']); ?></small>
                </td>
                <td>
                  <strong><?= htmlspecialchars($r['vehicle_type'] ?: 'Bike'); ?></strong> (<?= htmlspecialchars($r['vehicle_number']); ?>)<br>
                  <small class="text-muted">DL: <?= htmlspecialchars($r['driving_license_no'] ?: 'Verified'); ?></small>
                </td>
                <td>
                  <?php 
                  $st = strtoupper($r['status'] ?? '');
                  if ($st === 'AVAILABLE') {
                    echo '<span class="status-pill status-idle"><i class="fa fa-circle text-success"></i> Available (Idle)</span>';
                  } elseif ($st === 'BUSY') {
                    echo '<span class="status-pill status-delivering"><i class="fa fa-motorcycle"></i> En-Route</span>';
                  } else {
                    echo '<span class="status-pill" style="background:#f1f5f9; color:#64748b;">Offline</span>';
                  }
                  ?>
                </td>
                <td>
                  <?php if (!empty($r['active_order_code'])): ?>
                    <code style="font-size: 13px;">#<?= $r['active_order_code']; ?></code>
                  <?php else: ?>
                    <em class="text-muted">No active transit</em>
                  <?php endif; ?>
                </td>
                <td>
                  <strong style="color: #0f172a;">₹<?= number_format($r['cod_in_hand'] ?: 0, 2); ?></strong>
                </td>
                <td>
                  <a href="<?= base_url('masters/pharmacy_fleet/onboard_rider/' . $r['id']); ?>" class="btn-sm-action">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                  <?php if ($r['status'] === 'BUSY'): ?>
                    <a href="<?= base_url('masters/pharmacy_fleet/reassign_order?rider_id=' . $r['id']); ?>" class="btn-sm-action">
                      <i class="fa fa-exchange"></i> Reassign
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('masters/pharmacy_fleet/reassign_order?rider_id=' . $r['id']); ?>" class="btn-sm-assign" style="text-decoration: none; color: #fff;">
                      <i class="fa fa-plus"></i> Assign
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="6" class="text-center" style="padding: 36px 20px;">
                  <i class="fa fa-motorcycle text-muted" style="font-size: 32px; margin-bottom: 8px;"></i>
                  <p class="text-muted" style="margin: 0;">No delivery fleet riders found.</p>
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <!-- TAB 3: LIVE DISPATCH QUEUE -->
          <?php elseif ($active_tab == 'dispatch'): ?>
          <table class="upchar-table">
            <thead>
              <tr>
                <th>Order Code</th>
                <th>Customer &amp; Phone</th>
                <th>Pharmacy Store</th>
                <th>Assigned Fleet Rider</th>
                <th>Order Status</th>
                <th>Order Amount</th>
                <th>Quick Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($records)): foreach($records as $ord): ?>
              <tr>
                <td>
                  <strong style="font-size: 14px; font-family: monospace;">#<?= htmlspecialchars($ord['order_code']); ?></strong><br>
                  <small class="text-muted"><?= date('d M, Y h:i A', strtotime($ord['created_at'])); ?></small>
                </td>
                <td>
                  <strong><?= htmlspecialchars($ord['customer_name']); ?></strong><br>
                  <small><i class="fa fa-phone"></i> <?= htmlspecialchars($ord['customer_phone']); ?></small>
                </td>
                <td>
                  <?= htmlspecialchars($ord['store_name'] ?: 'Partner Pharmacy'); ?>
                </td>
                <td>
                  <?php if (!empty($ord['rider_name'])): ?>
                    <span class="doctor-tag"><i class="fa fa-motorcycle"></i> <?= htmlspecialchars($ord['rider_name']); ?></span>
                    <small class="text-muted" style="display:block;"><?= htmlspecialchars($ord['rider_phone']); ?></small>
                  <?php else: ?>
                    <span class="status-pill" style="background:#fee2e2; color:#dc2626;">Unassigned</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                  $os = strtoupper($ord['order_status']);
                  if (in_array($os, ['PLACED', 'PENDING_RX'])) echo '<span class="status-pill status-delivering">New Order</span>';
                  elseif ($os === 'CONFIRMED') echo '<span class="status-pill status-idle">Confirmed</span>';
                  elseif (in_array($os, ['PACKED', 'ASSIGNED'])) echo '<span class="status-pill status-idle">Packed &bull; Ready</span>';
                  elseif ($os === 'IN_TRANSIT') echo '<span class="status-pill status-delivering"><i class="fa fa-motorcycle"></i> Out for Delivery</span>';
                  elseif ($os === 'DELIVERED') echo '<span class="status-pill status-active"><i class="fa fa-check"></i> Delivered</span>';
                  else echo '<span class="status-pill">' . $os . '</span>';
                  ?>
                </td>
                <td>
                  <strong>₹<?= number_format($ord['total_amount'], 2); ?></strong><br>
                  <small class="text-muted"><?= $ord['payment_mode']; ?> (<?= $ord['payment_status']; ?>)</small>
                </td>
                <td>
                  <a href="<?= base_url('masters/pharmacy_fleet/reassign_order/' . $ord['id']); ?>" class="btn-sm-action">
                    <i class="fa fa-exchange"></i> Reassign Rider
                  </a>
                </td>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="7" class="text-center" style="padding: 36px 20px;">
                  <i class="fa fa-truck text-muted" style="font-size: 32px; margin-bottom: 8px;"></i>
                  <p class="text-muted" style="margin: 0;">No live dispatch orders found.</p>
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <!-- TAB 4: FINANCIAL SETTLEMENTS -->
          <?php elseif ($active_tab == 'settlements'): ?>
          <table class="upchar-table">
            <thead>
              <tr>
                <th>Partner Pharmacy</th>
                <th>Settlement Billing Period</th>
                <th>Gross Dispatched Sales</th>
                <th>Upchar Commission</th>
                <th>Net Payout (₹)</th>
                <th>Bank UTR Reference</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($records)): foreach($records as $set): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars($set['store_name']); ?></strong><br>
                  <small class="text-muted">GST: <?= htmlspecialchars($set['gstin'] ?: 'Not Provided'); ?></small>
                </td>
                <td>
                  <?= date('d M Y', strtotime($set['settlement_period_start'])); ?> &rarr; 
                  <?= date('d M Y', strtotime($set['settlement_period_end'])); ?>
                </td>
                <td>₹<?= number_format($set['gross_sales'], 2); ?></td>
                <td style="color: #0284c7; font-weight: 600;">₹<?= number_format($set['upchar_commission'], 2); ?></td>
                <td><strong style="color: #16a34a; font-size: 14px;">₹<?= number_format($set['net_payout'], 2); ?></strong></td>
                <td><code><?= $set['utr_number'] ?: 'Pending'; ?></code></td>
                <td>
                  <span class="status-pill <?= $set['settlement_status'] === 'PROCESSED' ? 'status-active' : 'status-delivering'; ?>">
                    <?= $set['settlement_status']; ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="7" class="text-center" style="padding: 36px 20px;">
                  <i class="fa fa-file-text-o text-muted" style="font-size: 32px; margin-bottom: 8px;"></i>
                  <p class="text-muted" style="margin: 0;">No financial settlements recorded.</p>
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
          <?php endif; ?>

        </div>

        <!-- Pagination Links Bar -->
        <div class="table-footer-pagination clearfix">
          <div class="pull-left pagination-info">
            Showing <strong><?= count($records); ?></strong> of <strong><?= $total_rows; ?></strong> total records in <?= ucfirst($active_tab); ?>
          </div>
          <div class="pull-right">
            <?= $pagination; ?>
          </div>
        </div>

      </div>
    </div>

  </section>
</div>



<style>
.upchar-admin-container {
  font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  color: #2c3e50;
}
.admin-card {
  background: #ffffff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(8, 54, 75, 0.08);
  border: 1px solid #e1e8ed;
  overflow: hidden;
}
.server-tabs-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f8fafc;
  border-bottom: 2px solid #e2e8f0;
  padding: 0 16px;
  flex-wrap: wrap;
}
.server-nav-tabs {
  border-bottom: none;
  margin-bottom: -2px;
}
.server-nav-tabs > li > a {
  padding: 14px 18px;
  font-size: 13.5px;
  font-weight: 600;
  color: #64748b;
  border: none;
  border-bottom: 3px solid transparent;
  background: transparent;
  transition: all 0.2s ease;
}
.server-nav-tabs > li > a:hover {
  background: #f1f5f9;
  color: #08364b;
  border-color: transparent;
}
.server-nav-tabs > li.active > a,
.server-nav-tabs > li.active > a:hover,
.server-nav-tabs > li.active > a:focus {
  color: #08364b;
  background: #ffffff;
  border: none;
  border-bottom: 3px solid #00a8ff;
}
.server-nav-tabs .badge {
  background: #e2e8f0;
  color: #475569;
  font-size: 11px;
  font-weight: 700;
  margin-left: 5px;
}
.server-nav-tabs > li.active .badge {
  background: #00a8ff;
  color: #ffffff;
}
.tab-action-btn-area {
  padding: 8px 0;
}
.btn-primary-add {
  background: #16a34a;
  border: none;
  color: #fff;
  font-weight: bold;
  padding: 9px 18px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 12.5px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: background 0.2s ease;
}
.btn-primary-add:hover {
  background: #15803d;
}
.table-search-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 20px;
  background: #ffffff;
  border-bottom: 1px solid #edf2f6;
  flex-wrap: wrap;
  gap: 12px;
}
.upchar-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
.upchar-table th {
  background: #f8fafc;
  color: #08364b;
  padding: 13px 18px;
  text-align: left;
  border-bottom: 2px solid #e1e8ed;
  font-weight: 600;
}
.upchar-table td {
  padding: 13px 18px;
  border-bottom: 1px solid #edf2f6;
  vertical-align: middle;
}
.doctor-tag {
  background: #e8f4fd;
  color: #0077b6;
  padding: 2px 6px;
  border-radius: 4px;
  font-weight: 600;
}
.status-pill {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: bold;
}
.status-active { background: #e3f8df; color: #2e7d32; }
.status-delivering { background: #fff3e0; color: #e65100; }
.status-idle { background: #e1f5fe; color: #0277bd; }
.btn-sm-action {
  background: #f0f4f8;
  border: 1px solid #d0dbe5;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  display: inline-block;
  color: #334155;
  text-decoration: none;
}
.btn-sm-action:hover {
  background: #e2e8f0;
  color: #08364b;
  text-decoration: none;
}
.btn-sm-assign {
  background: #00a8ff;
  border: none;
  color: white;
  padding: 5px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  font-size: 12px;
}
.btn-sm-assign:hover {
  background: #0090db;
}
.table-footer-pagination {
  padding: 14px 20px;
  background: #fafafa;
  border-top: 1px solid #edf2f6;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}
.pagination-info {
  font-size: 12.5px;
  color: #64748b;
}
</style>
