<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chemist Partner Console — UPCHAR Online Pharmacy Dispatch</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        :root {
            --navy: #08364B;
            --navy-dark: #042433;
            --cyan: #00A8FF;
            --green: #9BC03C;
            --red: #E63946;
            --bg: #F4F7F9;
            --card-border: #E2E8F0;
        }

        body {
            background-color: var(--bg);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1E293B;
            margin: 0;
            padding-bottom: 60px;
        }

        /* Top Navbar */
        .chemist-navbar {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            padding: 14px 24px;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(4, 36, 51, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .chemist-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .chemist-brand img {
            height: 38px;
        }
        .store-badge {
            background: rgba(0, 168, 255, 0.15);
            border: 1px solid var(--cyan);
            color: #BAE6FD;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .audio-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #FFFFFF;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .audio-toggle-btn.active {
            background: #10B981;
            border-color: #059669;
        }

        /* Subnav Modules Tabs */
        .module-subnav {
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            padding: 0 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
        }
        .module-tab {
            padding: 14px 18px;
            color: #64748B;
            font-weight: 600;
            font-size: 13.5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }
        .module-tab:hover {
            color: var(--navy);
            text-decoration: none;
        }
        .module-tab.active {
            color: var(--navy);
            border-bottom-color: var(--cyan);
            font-weight: 700;
        }

        /* Metrics Bar */
        .metrics-bar {
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            padding: 16px 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .metric-card {
            background: #F8FAFC;
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .metric-card.alert-card {
            border-left: 4px solid var(--cyan);
        }
        .metric-num {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy);
            margin: 0;
            line-height: 1;
        }
        .metric-label {
            font-size: 12.5px;
            color: #64748B;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* Order Cards */
        .order-card {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid var(--card-border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .order-card-header {
            background: #F8FAFC;
            border-bottom: 1px solid var(--card-border);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .order-code-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-PLACED, .status-PENDING_RX {
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FDE68A;
        }
        .status-CONFIRMED {
            background: #E0F2FE;
            color: #0369A1;
            border: 1px solid #BAE6FD;
        }
        .status-PACKED, .status-ASSIGNED {
            background: #EDE9FE;
            color: #6D28D9;
            border: 1px solid #DDD6FE;
        }
        .status-IN_TRANSIT {
            background: #DBEAFE;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
        }
        .status-DELIVERED {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }

        .order-card-body {
            padding: 20px;
        }
        .order-info-grid {
            display: grid;
            grid-template-columns: 2fr 3fr 2fr;
            gap: 20px;
        }
        @media (max-width: 991px) {
            .order-info-grid {
                grid-template-columns: 1fr;
            }
        }
        .customer-sec {
            border-right: 1px dashed var(--card-border);
            padding-right: 18px;
        }
        .items-sec {
            border-right: 1px dashed var(--card-border);
            padding-right: 18px;
        }
        .rx-thumbnail {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .rx-thumbnail:hover {
            opacity: 0.88;
        }
        .items-table {
            width: 100%;
            font-size: 13px;
        }
        .items-table th {
            color: #64748B;
            font-weight: 600;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 6px;
        }
        .items-table td {
            padding: 8px 0;
            border-bottom: 1px solid #F1F5F9;
        }

        .order-card-footer {
            background: #FAFAFA;
            border-top: 1px solid var(--card-border);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-action {
            font-weight: 700;
            font-size: 13.5px;
            padding: 8px 18px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-confirm-stock {
            background: #0284C7;
            color: #FFFFFF;
            border: none;
        }
        .btn-confirm-stock:hover {
            background: #0369A1;
            color: #FFFFFF;
        }
        .btn-print-inv {
            background: #FFFFFF;
            color: var(--navy);
            border: 1px solid var(--navy);
        }
        .btn-print-inv:hover {
            background: var(--navy);
            color: #FFFFFF;
        }
        .btn-mark-packed {
            background: #16A34A;
            color: #FFFFFF;
            border: none;
        }
        .btn-mark-packed:hover {
            background: #15803D;
            color: #FFFFFF;
        }

        /* Prominent Legal Disclaimer */
        .legal-disclaimer-footer {
            background: #FFFFFF;
            border-top: 1px solid var(--card-border);
            padding: 16px 24px;
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #64748B;
            border-left: 4px solid var(--cyan);
        }
        .legal-disclaimer-footer strong {
            color: var(--navy);
        }

        /* Pulse Indicator */
        .live-dot {
            width: 10px;
            height: 10px;
            background-color: #10B981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 1.8s infinite;
        }
        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="chemist-navbar">
    <div class="chemist-brand">
        <a href="<?=base_url();?>">
            <img src="<?=base_url('images/Final_logo23.png');?>" alt="UPCHAR Platform">
        </a>
        <span class="store-badge">
            <i class="fas fa-clinic-medical"></i> <?=htmlspecialchars($current_store['store_name']);?>
        </span>
        <span style="font-size: 12px; opacity: 0.85;">
            DL: <?=htmlspecialchars($current_store['drug_license_no']);?> | GST: <?=htmlspecialchars($current_store['gstin']);?>
        </span>
    </div>
    <div class="navbar-actions">
        <!-- Store Selector -->
        <select class="form-control input-sm" onchange="location.href='<?=base_url('pharmacy/dashboard?store_id=');?>'+this.value" style="width: auto; display: inline-block; background: #0b455f; color: #fff; border: 1px solid #1c6182;">
            <?php foreach($stores as $st): ?>
            <option value="<?=$st['id'];?>" <?=$st['id'] == $current_store['id'] ? 'selected' : '';?>>
                <?=$st['store_name'];?> (<?=$st['city'];?>)
            </option>
            <?php endforeach; ?>
        </select>

        <button class="audio-toggle-btn active" id="audioToggle" onclick="toggleAudioPing()" title="Toggle incoming order chime">
            <i class="fas fa-bell"></i> Audio Ping: <span id="audioStateText">ON</span>
        </button>

        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
            <span class="live-dot"></span> Live Queue
        </div>
    </div>
</nav>

<!-- Subnav Modules -->
<div class="module-subnav">
    <a href="<?=base_url('pharmacy/dashboard');?>" class="module-tab active"><i class="fas fa-desktop"></i> Live Queue</a>
    <a href="<?=base_url('pharmacy/inventory');?>" class="module-tab"><i class="fas fa-cubes"></i> Inventory & Stock</a>
    <a href="<?=base_url('pharmacy/orders');?>" class="module-tab"><i class="fas fa-file-invoice-dollar"></i> Orders & Billing</a>
    <a href="<?=base_url('pharmacy/delivery');?>" class="module-tab"><i class="fas fa-motorcycle"></i> Delivery Handover</a>
    <a href="<?=base_url('pharmacy/payments');?>" class="module-tab"><i class="fas fa-wallet"></i> Payments & Payouts</a>
    <a href="<?=base_url('pharmacy/profile/edit');?>" class="module-tab"><i class="fas fa-id-card"></i> Chemist Profile</a>
</div>

<!-- Metrics Overview -->
<div class="metrics-bar">
    <div class="metric-card alert-card">
        <div>
            <div class="metric-num" id="countPending">0</div>
            <div class="metric-label">New / Pending Rx</div>
        </div>
        <i class="fas fa-bell" style="font-size: 28px; color: #F59E0B; opacity: 0.8;"></i>
    </div>
    <div class="metric-card">
        <div>
            <div class="metric-num" id="countConfirmed">0</div>
            <div class="metric-label">Stock Confirmed</div>
        </div>
        <i class="fas fa-check-circle" style="font-size: 28px; color: #0284C7; opacity: 0.8;"></i>
    </div>
    <div class="metric-card">
        <div>
            <div class="metric-num" id="countPacked">0</div>
            <div class="metric-label">Packed & Ready</div>
        </div>
        <i class="fas fa-box" style="font-size: 28px; color: #7C3AED; opacity: 0.8;"></i>
    </div>
    <div class="metric-card">
        <div>
            <div class="metric-num" id="countInTransit">0</div>
            <div class="metric-label">Rider In-Transit</div>
        </div>
        <i class="fas fa-motorcycle" style="font-size: 28px; color: #2563EB; opacity: 0.8;"></i>
    </div>
    <div class="metric-card">
        <div>
            <div class="metric-num" id="countDelivered">0</div>
            <div class="metric-label">Delivered Today</div>
        </div>
        <i class="fas fa-hand-holding-heart" style="font-size: 28px; color: #16A34A; opacity: 0.8;"></i>
    </div>
</div>

<div class="container-fluid" style="padding: 0 24px;">
    <!-- Active Orders Feed -->
    <div class="row">
        <div class="col-md-12">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: var(--navy);">
                    <i class="fas fa-clipboard-list" style="color: var(--cyan);"></i> Prescription & Order Processing Queue
                </h3>
                <span style="font-size: 13px; color: #64748B;">
                    Auto-refreshing every 10s &bull; Last updated: <span id="lastUpdatedTime"><?=date('h:i:s A');?></span>
                </span>
            </div>

            <div id="ordersContainer">
                <?php if (empty($orders)): ?>
                <div class="text-center" style="background: #FFF; padding: 60px 20px; border-radius: 12px; border: 1px solid var(--card-border);">
                    <i class="fas fa-clipboard-check" style="font-size: 48px; color: #CBD5E1; margin-bottom: 16px;"></i>
                    <h4 style="color: #64748B; font-weight: 700;">No Orders in Queue</h4>
                    <p style="color: #94A3B8; max-width: 420px; margin: 0 auto 20px;">
                        New prescription uploads and patient orders dispatched to this licensed store will trigger an instant audio ping.
                    </p>
                    <button class="btn btn-primary btn-sm" onclick="simulateDemoOrder()">
                        <i class="fas fa-plus-circle"></i> Place Test Demo Order
                    </button>
                </div>
                <?php else: ?>
                    <?php foreach($orders as $ord): ?>
                    <div class="order-card" id="order-card-<?=$ord['id'];?>">
                        <div class="order-card-header">
                            <div class="order-code-title">
                                <span><?=$ord['order_code'];?></span>
                                <span class="status-badge status-<?=$ord['order_status'];?>">
                                    <i class="fas fa-circle" style="font-size: 8px; vertical-align: middle;"></i> <?=$ord['order_status'];?>
                                </span>
                                <?php if (!empty($ord['prescription_file'])): ?>
                                <span class="label label-info" style="font-size: 11px; font-weight: 700; border-radius: 10px;">
                                    <i class="fas fa-file-prescription"></i> Rx Attached
                                </span>
                                <?php endif; ?>
                            </div>
                            <div style="font-size: 13px; color: #64748B;">
                                <i class="fas fa-clock"></i> Placed: <?=date('d M Y, h:i A', strtotime($ord['created_at']));?>
                            </div>
                        </div>

                        <div class="order-card-body">
                            <div class="order-info-grid">
                                <!-- Patient Info -->
                                <div class="customer-sec">
                                    <div style="font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; margin-bottom: 6px;">Patient / Customer</div>
                                    <div style="font-size: 15px; font-weight: 800; color: #0F172A; margin-bottom: 4px;">
                                        <?=htmlspecialchars($ord['customer_name']);?>
                                    </div>
                                    <div style="font-size: 13px; color: #475569; margin-bottom: 4px;">
                                        <i class="fas fa-phone-alt" style="color: var(--cyan);"></i> <?=htmlspecialchars($ord['customer_phone']);?>
                                    </div>
                                    <div style="font-size: 12.5px; color: #64748B;">
                                        <i class="fas fa-map-marker-alt" style="color: var(--red);"></i> <?=htmlspecialchars($ord['delivery_address']);?>
                                    </div>
                                    <div style="margin-top: 10px; font-size: 12px; background: #F1F5F9; padding: 6px 10px; border-radius: 6px;">
                                        <strong>Payment:</strong> <?=$ord['payment_mode'];?> (<?=$ord['payment_status'];?>)
                                    </div>
                                </div>

                                <!-- Ordered Medicines -->
                                <div class="items-sec">
                                    <div style="font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; margin-bottom: 8px;">Prescribed Items (Dispensed by Store)</div>
                                    <table class="items-table">
                                        <thead>
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Dosage / Schedule</th>
                                                <th style="text-align: center;">Qty</th>
                                                <th style="text-align: right;">Selling Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($ord['items'])): foreach($ord['items'] as $it): ?>
                                            <tr>
                                                <td>
                                                    <strong><?=htmlspecialchars($it['brand_name']);?></strong>
                                                    <div style="font-size: 11px; color: #64748B;"><?=htmlspecialchars($it['generic_composition']);?></div>
                                                </td>
                                                <td>
                                                    <span class="label label-default" style="font-size: 10px;"><?=$it['dosage_form'];?></span>
                                                    <span class="label label-warning" style="font-size: 10px;"><?=$it['schedule_type'];?></span>
                                                </td>
                                                <td style="text-align: center; font-weight: 700;"><?=$it['quantity'];?></td>
                                                <td style="text-align: right; font-weight: 700;">₹<?=number_format($it['total_price'], 2);?></td>
                                            </tr>
                                            <?php endforeach; else: ?>
                                            <tr><td colspan="4" class="text-muted">Item details pending stock confirmation.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div style="text-align: right; margin-top: 8px; font-size: 14px;">
                                        Total Billable Amount: <strong style="color: var(--navy); font-size: 16px;">₹<?=number_format($ord['total_amount'], 2);?></strong>
                                    </div>
                                </div>

                                <!-- Prescription Preview / Pharmacist Verification -->
                                <div>
                                    <div style="font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; margin-bottom: 8px;">Prescription Verification</div>
                                    <?php if (!empty($ord['prescription_file'])): ?>
                                        <a href="<?=base_url($ord['prescription_file']);?>" target="_blank" title="Click to view full image">
                                            <img src="<?=base_url($ord['prescription_file']);?>" alt="Prescription" class="rx-thumbnail">
                                        </a>
                                        <div style="margin-top: 8px;">
                                            <?php if ($ord['rx_status'] === 'APPROVED'): ?>
                                                <div class="alert alert-success" style="padding: 6px 10px; margin-bottom: 0; font-size: 11.5px;">
                                                    <i class="fas fa-check-circle"></i> Approved by Reg: <strong><?=$ord['pharmacist_reg_no'];?></strong>
                                                </div>
                                            <?php elseif ($ord['rx_status'] === 'REJECTED'): ?>
                                                <div class="alert alert-danger" style="padding: 6px 10px; margin-bottom: 0; font-size: 11.5px;">
                                                    <i class="fas fa-times-circle"></i> Rejected: <?=$ord['rejection_reason'];?>
                                                </div>
                                            <?php else: ?>
                                                <div style="display: flex; gap: 6px;">
                                                    <button class="btn btn-success btn-xs" style="flex: 1; font-weight: 700;" onclick="openVerifyModal(<?=$ord['id'];?>, 'APPROVED')">
                                                        <i class="fas fa-check"></i> Approve Rx
                                                    </button>
                                                    <button class="btn btn-danger btn-xs" style="flex: 1; font-weight: 700;" onclick="openVerifyModal(<?=$ord['id'];?>, 'REJECTED')">
                                                        <i class="fas fa-ban"></i> Reject Rx
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div style="background: #F8FAFC; border: 1px dashed var(--card-border); border-radius: 8px; padding: 20px; text-align: center; color: #94A3B8;">
                                            <i class="fas fa-prescription" style="font-size: 24px; margin-bottom: 6px;"></i>
                                            <div style="font-size: 12px;">OTC Order (No Rx Required)</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="order-card-footer">
                            <div>
                                <?php if (!empty($ord['rider_name'])): ?>
                                <span style="font-size: 13px; color: #475569;">
                                    <i class="fas fa-motorcycle" style="color: var(--cyan);"></i> Assigned Rider: <strong><?=$ord['rider_name'];?></strong> (<?=$ord['rider_phone'];?>)
                                </span>
                                <?php endif; ?>
                            </div>

                            <div style="display: flex; gap: 8px;">
                                <!-- 1. Accept & Confirm Stock -->
                                <?php if (in_array($ord['order_status'], ['PLACED', 'PENDING_RX'])): ?>
                                <button class="btn btn-action btn-confirm-stock" onclick="openStockConfirmModal(<?=$ord['id'];?>)">
                                    <i class="fas fa-clipboard-check"></i> Accept & Confirm Stock
                                </button>
                                <?php endif; ?>

                                <!-- 2. Generate Chemist Invoice -->
                                <a href="<?=base_url('pharmacy/print_invoice/' . $ord['id']);?>" target="_blank" class="btn btn-action btn-print-inv">
                                    <i class="fas fa-print"></i> Generate Chemist Invoice
                                </a>

                                <!-- 3. Mark Packed & Request UPCHAR Rider -->
                                <?php if ($ord['order_status'] === 'CONFIRMED'): ?>
                                <button class="btn btn-action btn-mark-packed" onclick="markPacked(<?=$ord['id'];?>)">
                                    <i class="fas fa-box-check"></i> Mark Packed & Request UPCHAR Rider
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Prominent Legal Disclaimer -->
<div class="legal-disclaimer-footer">
    <i class="fas fa-balance-scale" style="color: var(--cyan); margin-right: 6px;"></i>
    <strong>Statutory Compliance Disclaimer:</strong> Dispensed and billed exclusively by 
    <strong><?=htmlspecialchars($current_store['store_name']);?></strong> 
    (Retail Drug License: <strong><?=htmlspecialchars($current_store['drug_license_no']);?></strong> | GSTIN: <strong><?=htmlspecialchars($current_store['gstin']);?></strong>). 
    UPCHAR acts solely as an electronic technology intermediary and logistics facilitator.
</div>

<!-- Modal 1: Pharmacist Rx Verification -->
<div class="modal fade" id="verifyRxModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--navy); color: #FFF;">
                <button type="button" class="close" data-dismiss="modal" style="color: #FFF;">&times;</button>
                <h4 class="modal-title" id="rxModalTitle"><i class="fas fa-user-md"></i> Registered Pharmacist Verification</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rxOrderId">
                <input type="hidden" id="rxStatusAction">

                <div id="rxApproveSec">
                    <div class="form-group">
                        <label>Pharmacist Council Registration Number (Required)</label>
                        <input type="text" id="pharmacistRegNo" class="form-control" placeholder="e.g. 58492/UP-PC" value="UP-PHARM-88219">
                        <small class="text-muted">Mandatory under the Drugs and Cosmetics Rules for Schedule H/H1 dispensing.</small>
                    </div>
                    <div class="form-group">
                        <label>Verification Notes / Observations</label>
                        <textarea id="rxApproveNotes" class="form-control" rows="2" placeholder="Prescription verified for dosage, doctor registration, and date of issue."></textarea>
                    </div>
                </div>

                <div id="rxRejectSec" style="display: none;">
                    <div class="form-group">
                        <label class="text-danger">Prescription Rejection Reason (Notified to Patient)</label>
                        <select id="rxRejectPreset" class="form-control" onchange="$('#rxRejectNotes').val(this.value)">
                            <option value="">-- Select Standard Reason --</option>
                            <option value="Prescription image is blurry or unreadable.">Prescription image is blurry or unreadable.</option>
                            <option value="Prescription has expired (older than 6 months).">Prescription has expired (older than 6 months).</option>
                            <option value="Prescription missing Doctor registration number or signature.">Missing Doctor registration or signature.</option>
                            <option value="Scheduled drug requires physical original prescription at clinic.">Scheduled drug requires physical original.</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Detailed Notes to Patient</label>
                        <textarea id="rxRejectNotes" class="form-control" rows="3" placeholder="Explain clearly why this prescription cannot be dispensed."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSubmitRxVerification" onclick="submitRxVerification()">
                    Confirm Pharmacist Action
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Stock Confirmation -->
<div class="modal fade" id="stockConfirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--navy); color: #FFF;">
                <button type="button" class="close" data-dismiss="modal" style="color: #FFF;">&times;</button>
                <h4 class="modal-title"><i class="fas fa-boxes"></i> Itemized Stock & Batch Confirmation</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="stockOrderId">
                <p style="font-size: 13px; color: #475569;">
                    Please confirm that physical stock is reserved and verified against valid batch numbers and unexpired expiry dates.
                </p>
                <div class="form-group">
                    <label>Batch Number Allocation</label>
                    <input type="text" id="confirmBatchNo" class="form-control" value="BATCH-<?=date('yM');?>-01">
                </div>
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" id="confirmExpiryDate" class="form-control" value="<?=date('Y-m-d', strtotime('+18 months'));?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitStockConfirm()">
                    <i class="fas fa-check"></i> Confirm Stock & Mark Order Ready
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let audioEnabled = true;
let previousPendingCount = 0;

// Web Audio API Synth Chime for notification (zero external mp3 dependency)
function playAudioPing() {
    if (!audioEnabled) return;
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(880, audioCtx.currentTime); // A5
        osc.frequency.exponentialRampToValueAtTime(1760, audioCtx.currentTime + 0.15); // A6
        gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.35);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.35);
    } catch(e) {
        console.log('Audio error:', e);
    }
}

function toggleAudioPing() {
    audioEnabled = !audioEnabled;
    const btn = $('#audioToggle');
    if (audioEnabled) {
        btn.addClass('active');
        $('#audioStateText').text('ON');
        playAudioPing();
    } else {
        btn.removeClass('active');
        $('#audioStateText').text('OFF');
    }
}

function openVerifyModal(orderId, action) {
    $('#rxOrderId').val(orderId);
    $('#rxStatusAction').val(action);
    if (action === 'APPROVED') {
        $('#rxModalTitle').html('<i class="fas fa-check-circle" style="color: #10B981;"></i> Approve Prescription & Dispense');
        $('#rxApproveSec').show();
        $('#rxRejectSec').hide();
        $('#btnSubmitRxVerification').attr('class', 'btn btn-success').text('Approve & Confirm Prescription');
    } else {
        $('#rxModalTitle').html('<i class="fas fa-ban" style="color: #EF4444;"></i> Reject Prescription');
        $('#rxApproveSec').hide();
        $('#rxRejectSec').show();
        $('#btnSubmitRxVerification').attr('class', 'btn btn-danger').text('Reject Prescription & Notify Patient');
    }
    $('#verifyRxModal').modal('show');
}

function submitRxVerification() {
    const orderId = $('#rxOrderId').val();
    const action = $('#rxStatusAction').val();
    const regNo = $('#pharmacistRegNo').val();
    const notes = (action === 'APPROVED') ? $('#rxApproveNotes').val() : $('#rxRejectNotes').val();

    if (action === 'APPROVED' && !regNo.trim()) {
        alert('Pharmacist registration number is legally required.');
        return;
    }
    if (action === 'REJECTED' && !notes.trim()) {
        alert('Please specify a reason for rejecting the prescription.');
        return;
    }

    $.ajax({
        url: '<?=base_url("api/v1/pharmacy/orders/");?>' + orderId + '/verify-rx',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            status: action,
            pharmacist_reg_no: regNo,
            notes: notes
        }),
        success: function(resp) {
            $('#verifyRxModal').modal('hide');
            alert(resp.message);
            location.reload();
        },
        error: function(xhr) {
            const err = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to update verification status';
            alert('Error: ' + err);
        }
    });
}

function openStockConfirmModal(orderId) {
    $('#stockOrderId').val(orderId);
    $('#stockConfirmModal').modal('show');
}

function submitStockConfirm() {
    const orderId = $('#stockOrderId').val();
    const batchNo = $('#confirmBatchNo').val();
    const expDate = $('#confirmExpiryDate').val();

    $.ajax({
        url: '<?=base_url("pharmacy/confirm_stock");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            items: [{ item_id: 1, batch_no: batchNo, expiry_date: expDate }]
        }),
        success: function(resp) {
            $('#stockConfirmModal').modal('hide');
            alert('Stock confirmed successfully!');
            location.reload();
        },
        error: function(xhr) {
            alert('Error confirming stock.');
        }
    });
}

function markPacked(orderId) {
    if (!confirm('Mark this order as PACKED and dispatch nearest UPCHAR delivery fleet rider?')) return;

    $.ajax({
        url: '<?=base_url("pharmacy/mark_packed");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ order_id: orderId }),
        success: function(resp) {
            if (resp.dispatch && resp.dispatch.status) {
                alert('Order PACKED! Assigned Rider: ' + resp.dispatch.rider.name + ' (' + resp.dispatch.rider.vehicle_number + ')');
            } else {
                alert('Order PACKED successfully!');
            }
            location.reload();
        },
        error: function(xhr) {
            alert('Failed to update packed status.');
        }
    });
}

function simulateDemoOrder() {
    $.ajax({
        url: '<?=base_url("api/v1/medicines/create-order");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            pharmacy_id: <?=$current_store['id'];?>,
            customer_name: 'Pooja Sharma',
            customer_phone: '9839112244',
            delivery_address: 'B-14 Ravindrapuri Lane 5, Varanasi',
            payment_mode: 'COD',
            item_total: 199.00,
            delivery_fee: 40.00,
            total_amount: 239.00,
            items: [
                { medicine_id: 1, quantity: 2, unit_mrp: 33.60, unit_price: 28.50, total_price: 57.00 },
                { medicine_id: 3, quantity: 1, unit_mrp: 199.00, unit_price: 165.00, total_price: 165.00 }
            ]
        }),
        success: function(resp) {
            playAudioPing();
            alert('Test demo order placed successfully! Code: ' + resp.data.order_code);
            location.reload();
        }
    });
}

// Live Queue Polling every 10 seconds
function pollLiveOrders() {
    $.getJSON('<?=base_url("pharmacy/get_live_orders?store_id=" . $current_store["id"]);?>', function(resp) {
        if (resp && resp.status === 'success') {
            $('#countPending').text(resp.counts.new_pending);
            $('#countConfirmed').text(resp.counts.confirmed);
            $('#countPacked').text(resp.counts.packed);
            $('#countInTransit').text(resp.counts.in_transit);
            $('#countDelivered').text(resp.counts.delivered);

            if (resp.counts.new_pending > previousPendingCount && previousPendingCount !== 0) {
                playAudioPing();
            }
            previousPendingCount = resp.counts.new_pending;
            $('#lastUpdatedTime').text(new Date().toLocaleTimeString());
        }
    });
}

$(document).ready(function() {
    pollLiveOrders();
    setInterval(pollLiveOrders, 10000);
});
</script>

</body>
</html>
