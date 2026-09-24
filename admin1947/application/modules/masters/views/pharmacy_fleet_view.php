<div class="content-wrapper upchar-admin-console">
  <!-- Content Header Ribbon -->
  <section class="content-header console-header-section">
    <div class="header-left-col">
      <h1 class="console-main-title">
        <span class="title-icon-badge"><i class="fa fa-hospital-o"></i></span>
        <span>Pharmacy Accounts &amp; Delivery Fleet Console</span>
      </h1>
      <p class="console-sub-title">
        UPCHAR Healthcare Logistics &bull; Chemist Partner Network &amp; Hyperlocal Fulfillment
      </p>
    </div>
    <div class="header-right-col">
      <span class="header-live-pill">
        <span class="pulse-indicator"></span> Platform Operational
      </span>
      <ol class="breadcrumb console-breadcrumb">
        <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Masters</a></li>
        <li class="active"><?= ($active_tab == 'pharmacy') ? 'Partner Pharmacies' : 'Pharmacy &amp; Fleet'; ?></li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content console-content-body">

    <!-- Flash Notifications -->
    <?php if ($this->session->flashdata('success') || $this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible console-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
      <div class="alert-inner-content">
        <i class="fa fa-check-circle alert-icon"></i>
        <span><?= $this->session->flashdata('success') ?: $this->session->flashdata('success_msg'); ?></span>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error') || $this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible console-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
      <div class="alert-inner-content">
        <i class="fa fa-exclamation-circle alert-icon"></i>
        <span><?= $this->session->flashdata('error') ?: $this->session->flashdata('error_msg'); ?></span>
      </div>
    </div>
    <?php endif; ?>

    <!-- Bento KPI Stats Widgets -->
    <div class="bento-kpi-grid">
      <!-- Card 1: Partner Pharmacies -->
      <div class="bento-kpi-card <?= ($active_tab == 'pharmacy') ? 'card-active-context' : ''; ?>">
        <div class="kpi-icon-wrap icon-teal">
          <i class="fa fa-hospital-o"></i>
        </div>
        <div class="kpi-data-wrap">
          <span class="kpi-micro-label">Partner Pharmacies</span>
          <div class="kpi-stat-num"><?= $total_stores ?? 0; ?></div>
          <div class="kpi-sub-badge badge-teal">
            <i class="fa fa-shield"></i> Verified Network
          </div>
        </div>
      </div>

      <!-- Card 2: Fleet Riders -->
      <div class="bento-kpi-card <?= ($active_tab == 'fleet') ? 'card-active-context' : ''; ?>">
        <div class="kpi-icon-wrap icon-blue">
          <i class="fa fa-motorcycle"></i>
        </div>
        <div class="kpi-data-wrap">
          <span class="kpi-micro-label">Fleet Riders Online</span>
          <div class="kpi-stat-num"><?= $active_riders_count ?? 0; ?> <small style="font-size: 14px; font-weight: 600; color: #64748b;">/ <?= $total_riders ?? 0; ?></small></div>
          <div class="kpi-sub-badge badge-blue">
            <i class="fa fa-bolt"></i> Ready for Dispatch
          </div>
        </div>
      </div>

      <!-- Card 3: Active Deliveries -->
      <div class="bento-kpi-card <?= ($active_tab == 'dispatch') ? 'card-active-context' : ''; ?>">
        <div class="kpi-icon-wrap icon-indigo">
          <i class="fa fa-truck"></i>
        </div>
        <div class="kpi-data-wrap">
          <span class="kpi-micro-label">Active Dispatches</span>
          <div class="kpi-stat-num"><?= $active_orders_count ?? 0; ?></div>
          <div class="kpi-sub-badge badge-indigo">
            <i class="fa fa-map-marker"></i> En-Route Pipeline
          </div>
        </div>
      </div>

      <!-- Card 4: Settlements -->
      <div class="bento-kpi-card <?= ($active_tab == 'settlements') ? 'card-active-context' : ''; ?>">
        <div class="kpi-icon-wrap icon-amber">
          <i class="fa fa-credit-card"></i>
        </div>
        <div class="kpi-data-wrap">
          <span class="kpi-micro-label">Settlement Ledgers</span>
          <div class="kpi-stat-num"><?= $total_settlements ?? 0; ?></div>
          <div class="kpi-sub-badge badge-amber">
            <i class="fa fa-check"></i> Reconciled
          </div>
        </div>
      </div>
    </div>

    <!-- Main Card Container -->
    <div class="console-master-card">

      <!-- Segmented Tab Navigation Bar -->
      <div class="console-nav-bar">
        <ul class="console-pill-tabs">
          <li class="<?= ($active_tab == 'pharmacy') ? 'active' : ''; ?>">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=pharmacy'); ?>" class="pill-tab-link">
              <i class="fa fa-medkit"></i>
              <span>Partner Pharmacies</span>
              <span class="tab-count-pill"><?= $total_stores ?? 0; ?></span>
            </a>
          </li>
          <li class="<?= ($active_tab == 'fleet') ? 'active' : ''; ?>">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=fleet'); ?>" class="pill-tab-link">
              <i class="fa fa-motorcycle"></i>
              <span>Delivery Fleet &amp; Riders</span>
              <span class="tab-count-pill"><?= $total_riders ?? 0; ?></span>
            </a>
          </li>
          <li class="<?= ($active_tab == 'dispatch') ? 'active' : ''; ?>">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=dispatch'); ?>" class="pill-tab-link">
              <i class="fa fa-truck"></i>
              <span>Live Dispatch Queue</span>
              <span class="tab-count-pill"><?= $active_orders_count ?? 0; ?></span>
            </a>
          </li>
          <li class="<?= ($active_tab == 'settlements') ? 'active' : ''; ?>">
            <a href="<?= base_url('masters/pharmacy_fleet?tab=settlements'); ?>" class="pill-tab-link">
              <i class="fa fa-file-text-o"></i>
              <span>Financial Settlements</span>
              <span class="tab-count-pill"><?= $total_settlements ?? 0; ?></span>
            </a>
          </li>
        </ul>

        <!-- Action Button according to Active Tab -->
        <div class="console-tab-actions">
          <?php if ($active_tab == 'pharmacy'): ?>
            <a href="<?= base_url('masters/pharmacy_fleet/add_pharmacy'); ?>" class="btn-primary-action btn-teal">
              <i class="fa fa-plus-circle"></i> + Add New Pharmacy
            </a>
          <?php elseif ($active_tab == 'fleet'): ?>
            <a href="<?= base_url('masters/pharmacy_fleet/onboard_rider'); ?>" class="btn-primary-action btn-blue">
              <i class="fa fa-user-plus"></i> + Onboard Rider
            </a>
          <?php elseif ($active_tab == 'dispatch'): ?>
            <a href="<?= base_url('masters/pharmacy_fleet/reassign_order'); ?>" class="btn-primary-action btn-indigo">
              <i class="fa fa-exchange"></i> Manual Dispatch
            </a>
          <?php elseif ($active_tab == 'settlements'): ?>
            <a href="<?= base_url('masters/pharmacy_fleet/record_settlement'); ?>" class="btn-primary-action btn-amber">
              <i class="fa fa-plus-circle"></i> + Record Settlement
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Filter & Search Toolbar -->
      <div class="console-filter-toolbar">
        <div class="filter-left-group">
          <!-- Client-side + Server-side Search -->
          <form action="<?= base_url('masters/pharmacy_fleet'); ?>" method="GET" class="search-form-wrap">
            <input type="hidden" name="tab" value="<?= html_escape($active_tab); ?>">
            <div class="search-box-pill">
              <i class="fa fa-search search-icon"></i>
              <input type="text" id="tableSearchInput" name="keyword" class="search-field-input" placeholder="Search in <?= ucfirst($active_tab); ?> (name, phone, DL, GST)..." value="<?= html_escape($keyword); ?>" autocomplete="off">
              <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('masters/pharmacy_fleet?tab=' . $active_tab); ?>" class="search-clear-btn" title="Clear Search"><i class="fa fa-times"></i></a>
              <?php endif; ?>
              <button type="submit" class="search-submit-btn"><i class="fa fa-arrow-right"></i></button>
            </div>
          </form>

          <?php if ($active_tab == 'pharmacy'): ?>
          <!-- Quick Status Filter Pills for Pharmacy Tab -->
          <div class="quick-status-filters" id="pharmacyQuickFilters">
            <button type="button" class="filter-chip active" data-filter="all">All (<?= count($records); ?>)</button>
            <button type="button" class="filter-chip" data-filter="active"><span class="chip-dot dot-green"></span> Live</button>
            <button type="button" class="filter-chip" data-filter="halted"><span class="chip-dot dot-red"></span> Halted</button>
            <button type="button" class="filter-chip" data-filter="doctor"><span class="chip-dot dot-blue"></span> Doctor Linked</button>
          </div>
          <?php endif; ?>
        </div>

        <div class="filter-right-group">
          <button type="button" class="toolbar-btn" onclick="exportTableToCSV('<?= $active_tab; ?>_export.csv')" title="Export active table to CSV">
            <i class="fa fa-download"></i> CSV
          </button>
          <button type="button" class="toolbar-btn" onclick="window.print();" title="Print this view">
            <i class="fa fa-print"></i> Print
          </button>
          <div class="pagination-page-label">
            Page <strong><?= floor($current_page / 10) + 1; ?></strong> &bull; 10 / page
          </div>
        </div>
      </div>

      <!-- ========================================================
           ACTIVE TAB DATA TABLE
           ======================================================== -->
      <div class="table-responsive console-table-container">

        <!-- TAB 1: PHARMACY STORES -->
        <?php if ($active_tab == 'pharmacy'): ?>
        <table class="console-data-table" id="pharmacyDataTable">
          <thead>
            <tr>
              <th style="min-width: 260px;">Pharmacy Store &amp; Location</th>
              <th style="min-width: 200px;">Regulatory &amp; Licenses</th>
              <th style="min-width: 190px;">Doctor &amp; Hospital Link</th>
              <th style="min-width: 190px;">Radius &amp; Commission</th>
              <th style="min-width: 140px;">Store Status</th>
              <th style="min-width: 180px; text-align: right;">Operational Controls</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($records)): foreach($records as $st): 
              $isHalted = !empty($st['is_emergency_closed']);
              $hasDoctor = !empty($st['doctor_name']);
              $filterCategory = $isHalted ? 'halted' : 'active';
              if ($hasDoctor) $filterCategory .= ' doctor';

              // Store initials for visual badge
              $nameWords = explode(' ', trim($st['store_name'] ?? 'Pharmacy'));
              $initials = strtoupper(substr($nameWords[0], 0, 1) . (isset($nameWords[1]) ? substr($nameWords[1], 0, 1) : substr($nameWords[0], 1, 1)));
            ?>
            <tr class="table-row-item" data-category="<?= $filterCategory; ?>">
              <!-- Column 1: Store & Contact -->
              <td>
                <div class="store-identity-cell">
                  <div class="store-avatar-badge avatar-color-<?= (int)$st['id'] % 5; ?>">
                    <?= htmlspecialchars($initials); ?>
                  </div>
                  <div class="store-info-wrap">
                    <div class="store-name-title">
                      <strong><?= htmlspecialchars($st['store_name'] ?? 'Unnamed Pharmacy'); ?></strong>
                      <?php if ($isHalted): ?>
                        <span class="badge-halt-warning"><i class="fa fa-power-off"></i> HALTED</span>
                      <?php else: ?>
                        <span class="badge-verified-store" title="Verified Chemist Store"><i class="fa fa-check-circle"></i></span>
                      <?php endif; ?>
                    </div>
                    <div class="store-contact-meta">
                      <?php if(!empty($st['phone'])): ?>
                        <a href="tel:<?= htmlspecialchars($st['phone']); ?>" class="contact-link" title="Call Store">
                          <i class="fa fa-phone"></i> <?= htmlspecialchars($st['phone']); ?>
                        </a>
                        <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $st['phone']); ?>" target="_blank" class="whatsapp-link" title="Chat on WhatsApp">
                          <i class="fa fa-whatsapp"></i>
                        </a>
                      <?php endif; ?>
                    </div>
                    <div class="store-address-meta">
                      <i class="fa fa-map-marker text-muted"></i> 
                      <span><?= htmlspecialchars(($st['address'] ?? '') ?: 'Store Address'); ?>, <strong><?= htmlspecialchars($st['city'] ?? 'Varanasi'); ?></strong></span>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Column 2: Drug License & GST -->
              <td>
                <div class="regulatory-data-box">
                  <div class="reg-pill reg-dl" onclick="copyText('<?= htmlspecialchars($st['drug_license_no'] ?? ''); ?>', this)" title="Click to copy Drug License">
                    <span class="pill-label">DL</span>
                    <span class="pill-val"><?= htmlspecialchars(($st['drug_license_no'] ?? '') ?: 'DL-Pending'); ?></span>
                    <i class="fa fa-clone copy-icon"></i>
                  </div>
                  <div class="reg-pill reg-gst" onclick="copyText('<?= htmlspecialchars($st['gstin'] ?? ''); ?>', this)" title="Click to copy GSTIN">
                    <span class="pill-label">GST</span>
                    <span class="pill-val"><?= htmlspecialchars(($st['gstin'] ?? '') ?: 'Unregistered'); ?></span>
                    <i class="fa fa-clone copy-icon"></i>
                  </div>
                  <div class="compliance-status">
                    <i class="fa fa-check-circle text-success"></i> <span>Drugs &amp; Cosmetics Act Verified</span>
                  </div>
                </div>
              </td>

              <!-- Column 3: Affiliated Doctor / Hospital -->
              <td>
                <div class="affiliation-cell">
                  <?php if (!empty($st['doctor_name'])): ?>
                    <div class="doctor-badge-chip">
                      <i class="fa fa-user-md doctor-icon"></i>
                      <span><?= htmlspecialchars($st['doctor_name']); ?></span>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($st['hospital_name'])): ?>
                    <div class="hospital-sub-tag">
                      <i class="fa fa-hospital-o"></i> <?= htmlspecialchars($st['hospital_name']); ?>
                    </div>
                  <?php endif; ?>
                  <?php if (empty($st['doctor_name']) && empty($st['hospital_name'])): ?>
                    <span class="independent-partner-badge">
                      <i class="fa fa-check"></i> Independent Pharmacy
                    </span>
                  <?php endif; ?>
                </div>
              </td>

              <!-- Column 4: Radius & Commission -->
              <td>
                <div class="operational-terms-cell">
                  <div class="terms-metrics-row">
                    <span class="metric-pill pill-radius" title="Delivery Radius">
                      <i class="fa fa-dot-circle-o"></i> <?= htmlspecialchars(($st['delivery_radius_km'] ?? '') ?: '5.0'); ?> km
                    </span>
                    <span class="metric-pill pill-fee" title="Platform Commission">
                      <i class="fa fa-percent"></i> <?= htmlspecialchars($st['commission_rate'] ?? '8.0'); ?>% Fee
                    </span>
                  </div>
                  <div class="operating-hours-text">
                    <i class="fa fa-clock-o text-muted"></i> Hrs: <?= htmlspecialchars(($st['operating_hours'] ?? '') ?: '9:00 AM - 10:00 PM'); ?>
                  </div>
                </div>
              </td>

              <!-- Column 5: Live Status -->
              <td>
                <?php if ($isHalted): ?>
                  <span class="status-indicator-badge status-halted">
                    <i class="fa fa-pause-circle"></i> Emergency Halted
                  </span>
                <?php else: ?>
                  <span class="status-indicator-badge status-live">
                    <span class="pulse-indicator"></span> Active &amp; Live
                  </span>
                <?php endif; ?>
              </td>

              <!-- Column 6: Operational Controls -->
              <td>
                <div class="action-btn-cluster">
                  <a href="<?= base_url('masters/pharmacy_fleet/add_pharmacy/' . ($st['id'] ?? '')); ?>" class="control-btn btn-edit" title="Edit Store Profile">
                    <i class="fa fa-pencil"></i> <span>Edit</span>
                  </a>
                  <a href="<?= base_url('masters/pharmacy_fleet/toggle_emergency_closure/' . ($st['id'] ?? '')); ?>" class="control-btn <?= $isHalted ? 'btn-reopen' : 'btn-halt'; ?>" title="<?= $isHalted ? 'Resume Live Operations' : 'Emergency Halt Orders'; ?>">
                    <i class="fa fa-power-off"></i> <span><?= $isHalted ? 'Reopen' : 'Halt'; ?></span>
                  </a>
                  <a href="<?= base_url('../pharmacy/orders?store_id=' . ($st['id'] ?? '')); ?>" target="_blank" class="control-btn btn-portal" title="Open Chemist Portal in new tab">
                    <i class="fa fa-external-link"></i> <span>Orders</span>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr id="noRecordsRow">
              <td colspan="6" class="empty-state-cell">
                <div class="empty-state-card">
                  <div class="empty-icon-wrap"><i class="fa fa-medkit"></i></div>
                  <h4>No Partner Pharmacies Found</h4>
                  <p class="text-muted">No pharmacy accounts match the selected filter or search keywords.</p>
                  <a href="<?= base_url('masters/pharmacy_fleet/add_pharmacy'); ?>" class="btn-primary-action btn-teal" style="margin-top: 12px;">
                    <i class="fa fa-plus-circle"></i> Onboard First Pharmacy
                  </a>
                </div>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- TAB 2: DELIVERY FLEET RIDERS -->
        <?php elseif ($active_tab == 'fleet'): ?>
        <table class="console-data-table">
          <thead>
            <tr>
              <th>Rider Name &amp; Contact</th>
              <th>Vehicle &amp; License</th>
              <th>Current Status</th>
              <th>Active Delivery</th>
              <th>COD in Hand</th>
              <th style="text-align: right;">Operational Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($records)): foreach($records as $r): ?>
            <tr>
              <td>
                <strong><?= htmlspecialchars(($r['name'] ?? '') ?: ($r['rider_name'] ?? '')); ?></strong><br>
                <small class="text-muted"><i class="fa fa-phone"></i> +91 <?= htmlspecialchars($r['phone'] ?? ''); ?></small>
              </td>
              <td>
                <strong><?= htmlspecialchars(($r['vehicle_type'] ?? '') ?: 'Bike'); ?></strong> (<?= htmlspecialchars($r['vehicle_number'] ?? ''); ?>)<br>
                <small class="text-muted">DL: <?= htmlspecialchars(($r['driving_license_no'] ?? '') ?: 'Verified'); ?></small>
              </td>
              <td>
                <?php 
                $st = strtoupper($r['status'] ?? '');
                if ($st === 'AVAILABLE') {
                  echo '<span class="status-indicator-badge status-live"><span class="pulse-indicator"></span> Available (Idle)</span>';
                } elseif ($st === 'BUSY') {
                  echo '<span class="status-indicator-badge status-busy"><i class="fa fa-motorcycle"></i> En-Route</span>';
                } else {
                  echo '<span class="status-indicator-badge status-offline">Offline</span>';
                }
                ?>
              </td>
              <td>
                <?php if (!empty($r['active_order_code'])): ?>
                  <code style="font-size: 13px; background: #e0f2fe; color: #0284c7; padding: 2px 6px; border-radius: 4px;">#<?= $r['active_order_code']; ?></code>
                <?php else: ?>
                  <em class="text-muted">No active transit</em>
                <?php endif; ?>
              </td>
              <td>
                <strong style="color: #0f172a; font-size: 14px;">₹<?= number_format((float)($r['cod_in_hand'] ?? 0), 2); ?></strong>
              </td>
              <td style="text-align: right;">
                <div class="action-btn-cluster" style="justify-content: flex-end;">
                  <a href="<?= base_url('masters/pharmacy_fleet/onboard_rider/' . ($r['id'] ?? '')); ?>" class="control-btn btn-edit">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                  <?php if (($r['status'] ?? '') === 'BUSY'): ?>
                    <a href="<?= base_url('masters/pharmacy_fleet/reassign_order?rider_id=' . ($r['id'] ?? '')); ?>" class="control-btn btn-reassign">
                      <i class="fa fa-exchange"></i> Reassign
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('masters/pharmacy_fleet/reassign_order?rider_id=' . ($r['id'] ?? '')); ?>" class="control-btn btn-assign">
                      <i class="fa fa-plus"></i> Assign
                    </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="6" class="empty-state-cell">
                <div class="empty-state-card">
                  <div class="empty-icon-wrap"><i class="fa fa-motorcycle"></i></div>
                  <h4>No Delivery Fleet Riders Found</h4>
                  <p class="text-muted">No riders match the current search filters.</p>
                </div>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- TAB 3: LIVE DISPATCH QUEUE -->
        <?php elseif ($active_tab == 'dispatch'): ?>
        <table class="console-data-table">
          <thead>
            <tr>
              <th>Order Code</th>
              <th>Customer &amp; Phone</th>
              <th>Pharmacy Store</th>
              <th>Assigned Fleet Rider</th>
              <th>Order Status</th>
              <th>Order Amount</th>
              <th style="text-align: right;">Quick Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($records)): foreach($records as $ord): ?>
            <tr>
              <td>
                <strong style="font-size: 14px; font-family: monospace; color: #0284c7;">#<?= htmlspecialchars($ord['order_code'] ?? ''); ?></strong><br>
                <small class="text-muted"><?= !empty($ord['created_at']) ? date('d M, Y h:i A', strtotime($ord['created_at'])) : ''; ?></small>
              </td>
              <td>
                <strong><?= htmlspecialchars($ord['customer_name'] ?? ''); ?></strong><br>
                <small class="text-muted"><i class="fa fa-phone"></i> <?= htmlspecialchars($ord['customer_phone'] ?? ''); ?></small>
              </td>
              <td>
                <strong><?= htmlspecialchars(($ord['store_name'] ?? '') ?: 'Partner Pharmacy'); ?></strong>
              </td>
              <td>
                <?php if (!empty($ord['rider_name'])): ?>
                  <span class="doctor-badge-chip"><i class="fa fa-motorcycle"></i> <?= htmlspecialchars($ord['rider_name']); ?></span>
                  <small class="text-muted" style="display:block; margin-top: 2px;"><?= htmlspecialchars($ord['rider_phone'] ?? ''); ?></small>
                <?php else: ?>
                  <span class="status-indicator-badge status-halted"><i class="fa fa-clock-o"></i> Unassigned</span>
                <?php endif; ?>
              </td>
              <td>
                <?php
                $os = strtoupper($ord['order_status'] ?? '');
                if (in_array($os, ['PLACED', 'PENDING_RX'])) echo '<span class="status-indicator-badge status-busy">New Order</span>';
                elseif ($os === 'CONFIRMED') echo '<span class="status-indicator-badge status-live">Confirmed</span>';
                elseif (in_array($os, ['PACKED', 'ASSIGNED'])) echo '<span class="status-indicator-badge status-live">Packed &bull; Ready</span>';
                elseif ($os === 'IN_TRANSIT') echo '<span class="status-indicator-badge status-busy"><i class="fa fa-motorcycle"></i> Out for Delivery</span>';
                elseif ($os === 'DELIVERED') echo '<span class="status-indicator-badge status-live"><i class="fa fa-check"></i> Delivered</span>';
                else echo '<span class="status-indicator-badge status-offline">' . ($os ?: 'PENDING') . '</span>';
                ?>
              </td>
              <td>
                <strong style="font-size: 14px; color: #0f172a;">₹<?= number_format((float)($ord['total_amount'] ?? 0), 2); ?></strong><br>
                <small class="text-muted"><?= $ord['payment_mode'] ?? 'COD'; ?> (<?= $ord['payment_status'] ?? 'PENDING'; ?>)</small>
              </td>
              <td style="text-align: right;">
                <a href="<?= base_url('masters/pharmacy_fleet/reassign_order/' . ($ord['id'] ?? '')); ?>" class="control-btn btn-reassign">
                  <i class="fa fa-exchange"></i> Reassign Rider
                </a>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="7" class="empty-state-cell">
                <div class="empty-state-card">
                  <div class="empty-icon-wrap"><i class="fa fa-truck"></i></div>
                  <h4>No Live Dispatch Orders Found</h4>
                  <p class="text-muted">All customer orders are currently dispatched or completed.</p>
                </div>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- TAB 4: FINANCIAL SETTLEMENTS & RECONCILIATION -->
        <?php elseif ($active_tab == 'settlements'): ?>
        
        <!-- 1. Settlement Control Bar & Summary KPIs -->
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <!-- Summary Cards -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 20px;">
            <div style="padding: 16px; border-radius: 10px; background: rgba(8, 54, 75, 0.04); border-left: 4px solid #08364B;">
              <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Cycle GMV</div>
              <div style="font-size: 22px; font-weight: 800; color: #08364B; margin-top: 4px;">₹<?= number_format((float)($settle_total_gmv ?? 0), 2); ?></div>
              <small style="color: #64748b;">Gross Order Volume</small>
            </div>
            <div style="padding: 16px; border-radius: 10px; background: rgba(0, 168, 255, 0.06); border-left: 4px solid #00A8FF;">
              <div style="font-size: 11.5px; font-weight: 700; color: #0284c7; text-transform: uppercase;">UPCHAR Revenue (8%)</div>
              <div style="font-size: 22px; font-weight: 800; color: #00A8FF; margin-top: 4px;">₹<?= number_format((float)($settle_platform_revenue ?? 0), 2); ?></div>
              <small style="color: #64748b;">Platform Commission Cut</small>
            </div>
            <div style="padding: 16px; border-radius: 10px; background: rgba(230, 57, 70, 0.06); border-left: 4px solid #E63946;">
              <div style="font-size: 11.5px; font-weight: 700; color: #e11d48; text-transform: uppercase;">Net Payout Due</div>
              <div style="font-size: 22px; font-weight: 800; color: #E63946; margin-top: 4px;">₹<?= number_format((float)($settle_net_payout_due ?? 0), 2); ?></div>
              <small style="color: #64748b;">Pending Bank Remittance</small>
            </div>
            <div style="padding: 16px; border-radius: 10px; background: rgba(155, 192, 60, 0.08); border-left: 4px solid #9BC03C;">
              <div style="font-size: 11.5px; font-weight: 700; color: #628214; text-transform: uppercase;">Outstanding COD In Hand</div>
              <div style="font-size: 22px; font-weight: 800; color: #628214; margin-top: 4px;">₹<?= number_format((float)($settle_outstanding_cod ?? 0), 2); ?></div>
              <small style="color: #64748b;">Cash Held by Fleet Riders</small>
            </div>
          </div>

          <!-- Filter Form & Actions -->
          <form method="GET" action="<?= base_url('masters/pharmacy_fleet'); ?>" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;">
            <input type="hidden" name="tab" value="settlements">
            <div style="flex: 1; min-width: 200px;">
              <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Chemist Store / UTR Search</label>
              <input type="text" name="keyword" class="form-control" placeholder="Search by name, license, UTR..." value="<?= htmlspecialchars($keyword ?? ''); ?>" style="border-radius: 6px; font-size: 13px;">
            </div>
            <div style="min-width: 150px;">
              <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Settlement Status</label>
              <select name="status" class="form-control" style="border-radius: 6px; font-size: 13px;">
                <option value="ALL">All Statuses</option>
                <option value="DUE" <?= ($status_filter ?? '') === 'DUE' ? 'selected' : ''; ?>>DUE</option>
                <option value="PROCESSING" <?= ($status_filter ?? '') === 'PROCESSING' ? 'selected' : ''; ?>>PROCESSING</option>
                <option value="PAID" <?= ($status_filter ?? '') === 'PAID' ? 'selected' : ''; ?>>PAID</option>
              </select>
            </div>
            <div style="min-width: 140px;">
              <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Cycle Start</label>
              <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($date_from ?? ''); ?>" style="border-radius: 6px; font-size: 13px;">
            </div>
            <div style="min-width: 140px;">
              <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Cycle End</label>
              <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($date_to ?? ''); ?>" style="border-radius: 6px; font-size: 13px;">
            </div>
            <div style="display: flex; gap: 8px;">
              <button type="submit" class="btn btn-primary" style="background: #08364B; border-color: #08364B; font-weight: 600; border-radius: 6px; font-size: 13px;">
                <i class="fa fa-filter"></i> Filter
              </button>
              <a href="<?= base_url('masters/pharmacy_fleet/export_settlement_csv'); ?>" class="btn btn-success" style="background: #16a34a; border-color: #16a34a; font-weight: 600; border-radius: 6px; font-size: 13px;" title="Export Bank NEFT/RTGS Batch CSV">
                <i class="fa fa-file-excel-o"></i> Export Bank Batch CSV
              </a>
            </div>
          </form>
        </div>

        <!-- 2. Master Reconciliation Grid Table -->
        <table class="console-data-table">
          <thead>
            <tr>
              <th>Chemist Store & DL</th>
              <th>Associated Hospital / Clinic</th>
              <th style="text-align: center;">Orders</th>
              <th style="text-align: right;">Gross Sales</th>
              <th style="text-align: center;">Comm %</th>
              <th style="text-align: right;">UPCHAR (8%)</th>
              <th style="text-align: right;">COD Remit</th>
              <th style="text-align: right;">Net Payable</th>
              <th>Bank Account</th>
              <th>Status</th>
              <th style="text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($records)): foreach($records as $set): ?>
            <tr>
              <td>
                <strong style="color: #08364B; font-size: 13.5px;"><?= htmlspecialchars($set['store_name'] ?? ('Chemist Store #' . ($set['pharmacy_id'] ?? ''))); ?></strong><br>
                <small class="text-muted" style="font-family: monospace; font-size: 11px;">
                  DL: <?= htmlspecialchars($set['drug_license_no'] ?? 'UP-VNS-20B-88391'); ?>
                </small>
              </td>
              <td>
                <span style="font-weight: 600; color: #334155; font-size: 12.5px;">
                  <i class="fa fa-hospital-o text-primary" style="margin-right: 4px;"></i>
                  <?= htmlspecialchars($set['hospital_name'] ?? 'ORIANA HOSPITAL (Adjacent)'); ?>
                </span>
              </td>
              <td style="text-align: center;">
                <span class="badge" style="background: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; font-weight: 600;">
                  <?= (int)($set['order_count'] ?? 1); ?>
                </span>
              </td>
              <td style="text-align: right; font-weight: 600;">₹<?= number_format((float)($set['gross_sales'] ?? 0), 2); ?></td>
              <td style="text-align: center; font-family: monospace;"><?= number_format((float)($set['commission_rate'] ?? 8.00), 2); ?>%</td>
              <td style="text-align: right; color: #0284c7; font-weight: 600;">₹<?= number_format((float)($set['upchar_commission'] ?? 0), 2); ?></td>
              <td style="text-align: right; color: #e11d48; font-size: 12px;">-₹<?= number_format((float)($set['cod_remittance'] ?? 0), 2); ?></td>
              <td style="text-align: right;">
                <strong style="color: #08364B; font-size: 14.5px;">₹<?= number_format((float)($set['net_payout'] ?? 0), 2); ?></strong>
              </td>
              <td>
                <div style="font-size: 12px; font-weight: 600;"><?= htmlspecialchars($set['bank_name'] ?? 'HDFC Bank'); ?></div>
                <div style="font-size: 11px; font-family: monospace; color: #64748b;">
                  A/C: <?= !empty($set['bank_account_no']) ? substr($set['bank_account_no'], 0, 4) . '••••' . substr($set['bank_account_no'], -4) : '•••• •••• 9210'; ?> &bull;
                  <?= htmlspecialchars($set['bank_ifsc'] ?? 'HDFC0001254'); ?>
                </div>
              </td>
              <td>
                <?php 
                  $st = strtoupper($set['settlement_status'] ?? 'DUE');
                  $badgeCls = ($st === 'PAID' || $st === 'PROCESSED') ? 'background: rgba(155, 192, 60, 0.15); color: #628214; border: 1px solid #9BC03C;' : 
                              (($st === 'PROCESSING') ? 'background: rgba(0, 168, 255, 0.12); color: #0284c7; border: 1px solid #00A8FF;' : 
                              'background: rgba(230, 57, 70, 0.12); color: #E63946; border: 1px solid #E63946;');
                ?>
                <span class="status-indicator-badge" style="<?= $badgeCls; ?> font-weight: 700; padding: 4px 8px; border-radius: 999px; font-size: 11px;">
                  <?= $st; ?>
                </span>
                <?php if (!empty($set['utr_number'])): ?>
                  <div style="font-size: 10px; font-family: monospace; color: #64748b; margin-top: 3px;">UTR: <?= htmlspecialchars($set['utr_number']); ?></div>
                <?php endif; ?>
              </td>
              <td style="text-align: center;">
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default" onclick="openOrderBreakdownModal(<?= (int)$set['id']; ?>)" title="View Order Drilldown">
                    <i class="fa fa-list-ul"></i>
                  </button>
                  <?php if ($st !== 'PAID' && $st !== 'PROCESSED'): ?>
                  <button type="button" class="btn btn-success" style="background: #16a34a; font-weight: 600;" onclick="openAdminUtrModal(<?= (int)$set['id']; ?>, '<?= addslashes($set['store_name'] ?? 'Chemist Store'); ?>', <?= (float)($set['net_payout'] ?? 0); ?>)">
                    <i class="fa fa-check"></i> Pay
                  </button>
                  <?php else: ?>
                  <button type="button" class="btn btn-default disabled" title="Settlement Settled">
                    <i class="fa fa-check-circle text-success"></i>
                  </button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="11" class="empty-state-cell">
                <div class="empty-state-card">
                  <div class="empty-icon-wrap"><i class="fa fa-file-text-o"></i></div>
                  <h4>No Financial Settlements Recorded</h4>
                  <p class="text-muted">No payout batches generated matching your filters.</p>
                </div>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Admin UTR Record Modal -->
        <div class="modal fade" id="adminUtrModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
              <div class="modal-header" style="background: #08364B; color: #fff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700; font-size: 16px;"><i class="fa fa-university"></i> Record Bank Transfer & Enter UTR</h4>
              </div>
              <form id="adminMarkPaidForm">
                <input type="hidden" name="settlement_id" id="adminModalSettlementId">
                <div class="modal-body" style="padding: 20px;">
                  <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; margin-bottom: 16px;">
                    <small style="color: #64748b;">Beneficiary Chemist:</small>
                    <div id="adminModalStoreName" style="font-weight: 700; color: #08364B; font-size: 15px;">-</div>
                    <div style="font-size: 20px; font-weight: 800; color: #16a34a; margin-top: 4px;" id="adminModalNetPayout">₹0.00</div>
                  </div>
                  <div class="form-group">
                    <label style="font-weight: 600; font-size: 13px;">Bank UTR / Transaction Reference Number *</label>
                    <input type="text" name="utr_number" id="adminModalUtr" class="form-control" placeholder="e.g. HDFCR520260924001928" required minlength="8" style="font-family: monospace; text-transform: uppercase;">
                    <small class="text-muted">Enter the 16-22 character UTR provided by your bank portal.</small>
                  </div>
                  <div class="form-group">
                    <label style="font-weight: 600; font-size: 13px;">Settlement Notes</label>
                    <input type="text" name="settlement_notes" class="form-control" value="Weekly settlement batch cleared via Corporate NEFT">
                  </div>
                </div>
                <div class="modal-footer" style="padding: 14px 20px; background: #f8fafc;">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success" style="background: #16a34a; font-weight: 700;" id="btnAdminConfirmPayment">
                    <i class="fa fa-check-circle"></i> Confirm Payout
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Admin Order Drilldown Modal / Drawer -->
        <div class="modal fade" id="adminOrderBreakdownModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
              <div class="modal-header" style="background: #08364B; color: #fff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700; font-size: 16px;"><i class="fa fa-shopping-bag"></i> Settlement Order Drilldown</h4>
              </div>
              <div class="modal-body" id="adminOrderBreakdownBody" style="padding: 20px; max-height: 500px; overflow-y: auto;">
                <div style="text-align: center; padding: 40px; color: #64748b;">
                  <i class="fa fa-spinner fa-spin fa-2x"></i>
                  <div style="margin-top: 10px;">Loading order transactions...</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script>
        function openAdminUtrModal(id, storeName, netPayout) {
          $('#adminModalSettlementId').val(id);
          $('#adminModalStoreName').text(storeName);
          $('#adminModalNetPayout').text('₹' + parseFloat(netPayout).toFixed(2));
          $('#adminModalUtr').val('');
          $('#adminUtrModal').modal('show');
        }

        $('#adminMarkPaidForm').on('submit', function(e) {
          e.preventDefault();
          var btn = $('#btnAdminConfirmPayment');
          btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

          $.ajax({
            url: '<?= base_url("masters/pharmacy_fleet/mark_paid_ajax"); ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
              btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Confirm Payout');
              if (res.status === 'success') {
                alert(res.message);
                window.location.reload();
              } else {
                alert(res.message || 'Error recording settlement.');
              }
            },
            error: function() {
              btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Confirm Payout');
              alert('Network error communicating with server.');
            }
          });
        });

        function openOrderBreakdownModal(settlementId) {
          $('#adminOrderBreakdownModal').modal('show');
          $('#adminOrderBreakdownBody').html('<div style="text-align: center; padding: 40px; color: #64748b;"><i class="fa fa-spinner fa-spin fa-2x"></i><div style="margin-top: 10px;">Loading order transactions...</div></div>');

          $.ajax({
            url: '<?= base_url("masters/pharmacy_fleet/order_breakdown_ajax/"); ?>' + settlementId,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
              if (res.status === 'success') {
                var html = '<div style="margin-bottom: 16px; padding: 12px; background: rgba(0, 168, 255, 0.08); border-left: 4px solid #00A8FF; border-radius: 6px;">' +
                           '<strong>' + (res.settlement.store_name || 'Chemist Store') + '</strong> &bull; ' +
                           'Billing Cycle: ' + res.settlement.settlement_period_start + ' to ' + res.settlement.settlement_period_end +
                           '</div>' +
                           '<table class="table table-bordered table-striped" style="font-size: 13px;">' +
                           '<thead><tr style="background: #f1f5f9;"><th>Order Code</th><th>Customer</th><th>Date</th><th>Payment</th><th style="text-align: right;">Gross (₹)</th><th style="text-align: right;">UPCHAR 8%</th><th style="text-align: right;">Net Payable</th></tr></thead><tbody>';

                if (res.orders && res.orders.length > 0) {
                  res.orders.forEach(function(o) {
                    var gross = parseFloat(o.total_amount);
                    var comm = (gross * 0.08).toFixed(2);
                    var net = (gross - comm).toFixed(2);
                    html += '<tr>' +
                            '<td><strong style="color: #00A8FF;">' + o.order_code + '</strong></td>' +
                            '<td>' + (o.customer_name || 'Patient') + '</td>' +
                            '<td>' + o.created_at + '</td>' +
                            '<td>' + (o.payment_mode || 'ONLINE') + '</td>' +
                            '<td style="text-align: right;">₹' + gross.toFixed(2) + '</td>' +
                            '<td style="text-align: right; color: #e11d48;">-₹' + comm + '</td>' +
                            '<td style="text-align: right; font-weight: 700; color: #16a34a;">₹' + net + '</td>' +
                            '</tr>';
                  });
                } else {
                  html += '<tr><td colspan="7" class="text-center text-muted">No individual orders found in this batch cycle.</td></tr>';
                }
                html += '</tbody></table>';
                $('#adminOrderBreakdownBody').html(html);
              } else {
                $('#adminOrderBreakdownBody').html('<div class="alert alert-danger">' + res.message + '</div>');
              }
            },
            error: function() {
              $('#adminOrderBreakdownBody').html('<div class="alert alert-danger">Error retrieving order drilldown from server.</div>');
            }
          });
        }
        </script>
        <?php endif; ?>

      </div>

      <!-- Pagination Links Bar -->
      <div class="console-footer-pagination">
        <div class="pagination-summary">
          Showing <strong><?= count($records); ?></strong> of <strong><?= $total_rows; ?></strong> total records in <?= ucfirst($active_tab); ?>
        </div>
        <div class="pagination-links-wrap">
          <?= $pagination; ?>
        </div>
      </div>

    </div>

  </section>
</div>

<!-- =========================================================================
     MODERN ENTERPRISE DESIGN SYSTEM: STYLESHEET
     ========================================================================= -->
<style>
/* 1. Global Typography & Canvas */
.upchar-admin-console {
  font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
  color: #1e293b;
  background: #f8fafc;
  min-height: calc(100vh - 50px);
}

/* 2. Header Ribbon */
.console-header-section {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  flex-wrap: wrap !important;
  gap: 16px !important;
  padding: 20px 24px 16px 24px !important;
  background: transparent !important;
}

.console-main-title {
  font-size: 22px !important;
  font-weight: 800 !important;
  color: #08364b !important;
  letter-spacing: -0.4px !important;
  margin: 0 !important;
  display: flex !important;
  align-items: center !important;
  gap: 10px !important;
}

.title-icon-badge {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 18px;
  box-shadow: 0 4px 10px rgba(0, 168, 150, 0.3);
}

.console-sub-title {
  margin: 4px 0 0 46px !important;
  font-size: 13px !important;
  color: #64748b !important;
  font-weight: 500 !important;
}

.header-right-col {
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}

.header-live-pill {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 20px;
  padding: 4px 12px;
  font-size: 12px;
  font-weight: 600;
  color: #0f172a;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.pulse-indicator {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #10b981;
  display: inline-block;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
  animation: pulseGreen 2s infinite cubic-bezier(0.66, 0, 0, 1);
}

@keyframes pulseGreen {
  0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.console-breadcrumb {
  margin: 0 !important;
  padding: 0 !important;
  background: transparent !important;
  position: static !important;
  font-size: 12.5px !important;
}

/* 3. Alerts */
.console-alert {
  border-radius: 10px !important;
  padding: 12px 18px !important;
  margin-bottom: 20px !important;
  border: none !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
}

.alert-inner-content {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 600;
  font-size: 13.5px;
}

.alert-icon {
  font-size: 18px;
}

/* 4. Bento KPI Metric Grid */
.bento-kpi-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 22px;
}

@media (max-width: 1200px) {
  .bento-kpi-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
  .bento-kpi-grid { grid-template-columns: 1fr; }
}

.bento-kpi-card {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  padding: 18px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.bento-kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}

.card-active-context {
  border-color: #00a896 !important;
  background: linear-gradient(180deg, #ffffff 0%, #f0fdfa 100%) !important;
}

.kpi-icon-wrap {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
  color: #ffffff;
}

.icon-teal   { background: linear-gradient(135deg, #00a896 0%, #008f80 100%); box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25); }
.icon-blue   { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25); }
.icon-indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25); }
.icon-amber  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25); }

.kpi-data-wrap {
  flex: 1;
}

.kpi-micro-label {
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  display: block;
}

.kpi-stat-num {
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
  margin: 2px 0 4px 0;
}

.kpi-sub-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-weight: 600;
  padding: 2px 8px;
  border-radius: 6px;
}

.badge-teal   { background: #ccfbf1; color: #0d9488; }
.badge-blue   { background: #e0f2fe; color: #0284c7; }
.badge-indigo { background: #ede9fe; color: #6d28d9; }
.badge-amber  { background: #fef3c7; color: #b45309; }

/* 5. Master Console Card */
.console-master-card {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
  overflow: hidden;
}

/* 6. Segmented Navigation Bar */
.console-nav-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f8fafc;
  padding: 8px 16px;
  border-bottom: 1px solid #e2e8f0;
  flex-wrap: wrap;
  gap: 12px;
}

.console-pill-tabs {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 4px;
  flex-wrap: wrap;
}

.pill-tab-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 9px 15px;
  font-size: 13px;
  font-weight: 600;
  color: #64748b !important;
  border-radius: 8px;
  text-decoration: none !important;
  transition: all 0.2s ease;
}

.pill-tab-link:hover {
  background: #edf2f7;
  color: #0f172a !important;
}

.console-pill-tabs > li.active .pill-tab-link {
  background: #ffffff;
  color: #08364b !important;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
  font-weight: 700;
}

.tab-count-pill {
  background: #e2e8f0;
  color: #475569;
  font-size: 11px;
  font-weight: 700;
  padding: 1px 7px;
  border-radius: 12px;
}

.console-pill-tabs > li.active .tab-count-pill {
  background: #00a896;
  color: #ffffff;
}

.console-tab-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-primary-action {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 700;
  color: #ffffff !important;
  text-decoration: none !important;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.btn-primary-action:hover {
  transform: translateY(-1px);
  box-shadow: 0 5px 14px rgba(0,0,0,0.16);
}

.btn-teal   { background: linear-gradient(135deg, #00a896 0%, #008f80 100%); }
.btn-blue   { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); }
.btn-indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
.btn-amber  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

/* 7. Filter Toolbar */
.console-filter-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 18px;
  background: #ffffff;
  border-bottom: 1px solid #f1f5f9;
  flex-wrap: wrap;
  gap: 12px;
}

.filter-left-group {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  flex: 1;
}

.search-box-pill {
  display: inline-flex;
  align-items: center;
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 2px 4px 2px 10px;
  transition: all 0.2s ease;
  width: 320px;
}

.search-box-pill:focus-within {
  border-color: #00a896;
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.search-icon {
  color: #94a3b8;
  font-size: 13px;
  margin-right: 6px;
}

.search-field-input {
  border: none;
  background: transparent;
  outline: none;
  font-size: 13px;
  color: #0f172a;
  width: 100%;
}

.search-clear-btn {
  color: #94a3b8;
  padding: 4px;
  font-size: 11px;
}

.search-submit-btn {
  background: #e2e8f0;
  border: none;
  border-radius: 6px;
  color: #475569;
  padding: 4px 8px;
  font-size: 11px;
  cursor: pointer;
}

.search-submit-btn:hover {
  background: #00a896;
  color: #fff;
}

.quick-status-filters {
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: wrap;
}

.filter-chip {
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 20px;
  padding: 4px 10px;
  font-size: 11.5px;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  transition: all 0.15s ease;
}

.filter-chip:hover {
  background: #e2e8f0;
  color: #0f172a;
}

.filter-chip.active {
  background: #08364b;
  color: #ffffff;
  border-color: #08364b;
}

.chip-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  display: inline-block;
}

.dot-green { background: #10b981; }
.dot-red   { background: #ef4444; }
.dot-blue  { background: #0284c7; }

.filter-right-group {
  display: flex;
  align-items: center;
  gap: 8px;
}

.toolbar-btn {
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  padding: 6px 12px;
  font-size: 12px;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.15s ease;
}

.toolbar-btn:hover {
  background: #f8fafc;
  color: #08364b;
  border-color: #94a3b8;
}

.pagination-page-label {
  font-size: 12px;
  color: #64748b;
  margin-left: 6px;
}

/* 8. Modern Data Table */
.console-data-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.console-data-table th {
  background: #f8fafc;
  color: #08364b;
  padding: 12px 16px;
  text-align: left;
  border-bottom: 2px solid #e2e8f0;
  font-weight: 700;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.4px;
}

.console-data-table td {
  padding: 14px 16px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
  color: #334155;
}

.console-data-table tbody tr:hover td {
  background-color: #f8fafc;
}

/* 9. Store Identity Cell */
.store-identity-cell {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.store-avatar-badge {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 13px;
  color: #ffffff;
  flex-shrink: 0;
}

.avatar-color-0 { background: linear-gradient(135deg, #00a896, #008f80); }
.avatar-color-1 { background: linear-gradient(135deg, #0284c7, #0369a1); }
.avatar-color-2 { background: linear-gradient(135deg, #6366f1, #4f46e5); }
.avatar-color-3 { background: linear-gradient(135deg, #f59e0b, #d97706); }
.avatar-color-4 { background: linear-gradient(135deg, #ec4899, #db2777); }

.store-info-wrap {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.store-name-title {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 14px;
  color: #0f172a;
}

.badge-verified-store {
  color: #00a896;
  font-size: 13px;
}

.badge-halt-warning {
  background: #fee2e2;
  color: #dc2626;
  font-size: 9.5px;
  font-weight: 800;
  padding: 1px 6px;
  border-radius: 4px;
  border: 1px solid #fca5a5;
}

.store-contact-meta {
  font-size: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.contact-link {
  color: #0284c7 !important;
  text-decoration: none !important;
  font-weight: 500;
}

.contact-link:hover { text-decoration: underline !important; }

.whatsapp-link {
  color: #16a34a !important;
  font-size: 14px;
}

.store-address-meta {
  font-size: 11.5px;
  color: #64748b;
}

/* 10. Regulatory Cell */
.regulatory-data-box {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.reg-pill {
  display: inline-flex;
  align-items: center;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 2px 8px;
  font-size: 11px;
  cursor: pointer;
  transition: all 0.15s ease;
  width: fit-content;
}

.reg-pill:hover {
  background: #f1f5f9;
  border-color: #cbd5e1;
}

.pill-label {
  font-weight: 700;
  color: #64748b;
  margin-right: 6px;
  font-size: 10px;
}

.pill-val {
  font-family: monospace;
  font-weight: 600;
  color: #0f172a;
}

.copy-icon {
  margin-left: 6px;
  font-size: 10px;
  color: #94a3b8;
  opacity: 0.7;
}

.compliance-status {
  font-size: 10.5px;
  color: #15803d;
  font-weight: 600;
  margin-top: 2px;
}

/* 11. Affiliation Cell */
.doctor-badge-chip {
  background: #e0f2fe;
  color: #0369a1;
  padding: 3px 8px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  width: fit-content;
}

.hospital-sub-tag {
  font-size: 11px;
  color: #475569;
  margin-top: 3px;
  font-weight: 500;
}

.independent-partner-badge {
  font-size: 11.5px;
  color: #00a896;
  background: #f0fdfa;
  border: 1px solid #ccfbf1;
  padding: 3px 8px;
  border-radius: 6px;
  font-weight: 600;
  display: inline-block;
}

/* 12. Operational Terms Cell */
.terms-metrics-row {
  display: flex;
  align-items: center;
  gap: 6px;
}

.metric-pill {
  padding: 3px 7px;
  border-radius: 6px;
  font-size: 11.5px;
  font-weight: 700;
}

.pill-radius { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
.pill-fee    { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }

.operating-hours-text {
  font-size: 11px;
  color: #64748b;
  margin-top: 4px;
}

/* 13. Status Indicators */
.status-indicator-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.3px;
}

.status-live {
  background: #dcfce7;
  color: #15803d;
  border: 1px solid #bbf7d0;
}

.status-halted {
  background: #fee2e2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

.status-busy {
  background: #fef3c7;
  color: #d97706;
  border: 1px solid #fde68a;
}

.status-offline {
  background: #f1f5f9;
  color: #64748b;
  border: 1px solid #e2e8f0;
}

/* 14. Action Buttons */
.action-btn-cluster {
  display: flex;
  align-items: center;
  gap: 6px;
  justify-content: flex-end;
}

.control-btn {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 11.5px;
  font-weight: 600;
  text-decoration: none !important;
  transition: all 0.15s ease;
  border: 1px solid transparent;
}

.btn-edit {
  background: #f1f5f9;
  color: #334155 !important;
  border-color: #cbd5e1;
}

.btn-edit:hover {
  background: #e2e8f0;
  color: #0f172a !important;
}

.btn-halt {
  background: #fff1f2;
  color: #e11d48 !important;
  border-color: #fecdd3;
}

.btn-halt:hover {
  background: #ffe4e6;
  color: #be123c !important;
}

.btn-reopen {
  background: #f0fdf4;
  color: #16a34a !important;
  border-color: #bbf7d0;
}

.btn-reopen:hover {
  background: #dcfce7;
  color: #15803d !important;
}

.btn-portal {
  background: #f0fdfa;
  color: #0d9488 !important;
  border-color: #99f6e4;
}

.btn-portal:hover {
  background: #ccfbf1;
  color: #0f766e !important;
}

.btn-assign {
  background: #0284c7;
  color: #ffffff !important;
  font-weight: 700;
}

.btn-assign:hover {
  background: #0369a1;
}

.btn-reassign {
  background: #f1f5f9;
  color: #475569 !important;
  border-color: #cbd5e1;
}

.btn-reassign:hover {
  background: #e2e8f0;
}

/* 15. Empty State */
.empty-state-cell {
  padding: 48px 20px !important;
  text-align: center;
}

.empty-state-card {
  max-width: 360px;
  margin: 0 auto;
}

.empty-icon-wrap {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  background: #f1f5f9;
  color: #94a3b8;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin-bottom: 12px;
}

.empty-state-card h4 {
  font-size: 16px;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 6px 0;
}

/* 16. Pagination Footer */
.console-footer-pagination {
  padding: 12px 20px;
  background: #fafafa;
  border-top: 1px solid #edf2f6;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}

.pagination-summary {
  font-size: 12.5px;
  color: #64748b;
}

.pagination-links-wrap ul.pagination {
  margin: 0;
}

.pagination-links-wrap ul.pagination > li > a,
.pagination-links-wrap ul.pagination > li > span {
  padding: 5px 12px;
  font-size: 12px;
  color: #08364b;
  border-color: #e2e8f0;
}

.pagination-links-wrap ul.pagination > li.active > a,
.pagination-links-wrap ul.pagination > li.active > span {
  background-color: #00a896 !important;
  border-color: #00a896 !important;
  color: #ffffff !important;
}

/* 17. Copy Toast */
.copy-toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  background: #0f172a;
  color: #ffffff;
  padding: 9px 16px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 600;
  box-shadow: 0 8px 24px rgba(0,0,0,0.25);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  z-index: 9999;
  opacity: 0;
  transform: translateY(10px);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  pointer-events: none;
}

.copy-toast.show {
  opacity: 1;
  transform: translateY(0);
}
</style>

<!-- Copy Toast Notification element -->
<div id="copyToast" class="copy-toast">
  <i class="fa fa-check text-success"></i> <span id="copyToastMsg">Copied to clipboard!</span>
</div>

<!-- =========================================================================
     CLIENT-SIDE REAL-TIME INTERACTION SCRIPT
     ========================================================================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var searchInput = document.getElementById('tableSearchInput');
  var table = document.getElementById('pharmacyDataTable');
  var quickFilters = document.querySelectorAll('#pharmacyQuickFilters .filter-chip');

  var currentFilter = 'all';

  function applyFilters() {
    if (!table) return;
    var term = searchInput ? searchInput.value.toLowerCase().trim() : '';
    var rows = table.querySelectorAll('tbody tr.table-row-item');
    var visibleCount = 0;

    rows.forEach(function(row) {
      var rowText = row.innerText.toLowerCase();
      var category = row.getAttribute('data-category') || '';

      var matchesSearch = (term === '') || (rowText.indexOf(term) > -1);
      var matchesCategory = true;

      if (currentFilter === 'active') {
        matchesCategory = category.indexOf('active') > -1 && category.indexOf('halted') === -1;
      } else if (currentFilter === 'halted') {
        matchesCategory = category.indexOf('halted') > -1;
      } else if (currentFilter === 'doctor') {
        matchesCategory = category.indexOf('doctor') > -1;
      }

      if (matchesSearch && matchesCategory) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    var noRecRow = document.getElementById('noRecordsRow');
    if (noRecRow) {
      noRecRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }

  if (quickFilters.length > 0) {
    quickFilters.forEach(function(btn) {
      btn.addEventListener('click', function() {
        quickFilters.forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        currentFilter = btn.getAttribute('data-filter') || 'all';
        applyFilters();
      });
    });
  }
});

// Click-to-copy utility
function copyText(text, el) {
  if (!text || text === 'N/A' || text === 'Not Provided') return;
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(function() {
      showToast('Copied: ' + text);
    });
  } else {
    var ta = document.createElement('textarea');
    ta.value = text;
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
    showToast('Copied: ' + text);
  }
}

function showToast(msg) {
  var toast = document.getElementById('copyToast');
  var toastMsg = document.getElementById('copyToastMsg');
  if (toast && toastMsg) {
    toastMsg.innerText = msg;
    toast.classList.add('show');
    setTimeout(function() {
      toast.classList.remove('show');
    }, 2200);
  }
}

// Export active table to CSV
function exportTableToCSV(filename) {
  var table = document.querySelector('.console-data-table');
  if (!table) return;

  var rows = table.querySelectorAll('tr');
  var csv = [];

  for (var i = 0; i < rows.length; i++) {
    var row = [];
    var cols = rows[i].querySelectorAll('td, th');
    
    // Ignore rows hidden by quick filters
    if (rows[i].style.display === 'none') continue;

    for (var j = 0; j < cols.length - 1; j++) { // Skip the last action column
      var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, ' ').replace(/\s+/g, ' ').trim();
      text = text.replace(/"/g, '""');
      row.push('"' + text + '"');
    }
    if (row.length > 0) {
      csv.push(row.join(','));
    }
  }

  var csvContent = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv.join("\n"));
  var link = document.createElement('a');
  link.setAttribute('href', csvContent);
  link.setAttribute('download', filename);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  showToast('Table exported to ' + filename);
}
</script>
