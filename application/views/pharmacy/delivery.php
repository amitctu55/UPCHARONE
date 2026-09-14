<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Boy Handover System — UPCHAR Pharmacy Master Dashboard</title>
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
            --green: #10B981;
            --amber: #F59E0B;
            --red: #E63946;
            --card-border: #E2E8F0;
        }

        .delivery-page-wrapper {
            padding: 24px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .delivery-page-header {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .delivery-page-title h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .delivery-page-title p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .card-box {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid var(--card-border);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 24px;
            margin-bottom: 24px;
        }

        .handover-table th {
            background: #F8FAFC;
            color: #475569;
            font-weight: 700;
            font-size: 13px;
            padding: 12px;
            border-bottom: 2px solid #E2E8F0;
        }
        .handover-table td {
            padding: 12px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
            font-size: 13.5px;
        }

        .rider-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #166534;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12.5px;
        }

        .legal-footer {
            text-align: center;
            padding: 20px;
            font-size: 12.5px;
            color: #64748B;
            border-top: 1px solid #E2E8F0;
            margin-top: 40px;
            background: #FFFFFF;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="delivery-page-wrapper">
    <!-- Clean Page Header -->
    <div class="delivery-page-header">
        <div class="delivery-page-title">
            <h2><i class="fa fa-truck-fast text-primary me-2" style="color:#0284c7;"></i> Delivery Boy Handover System</h2>
            <p>Assign riders to packed medicine orders and confirm physical dispatch handover.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700;">
                <i class="fa fa-hospital-o me-1"></i> <?=htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');?>
            </span>
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control input-sm" onchange="location.href='<?=base_url('pharmacy/delivery?store_id=');?>'+this.value" style="display:inline-block; width:auto; height:34px; border-radius:8px; border:1px solid #cbd5e1; font-weight:600;">
                    <?php foreach($stores as $st): ?>
                        <option value="<?=$st['id'];?>" <?=$st['id'] == $current_store['id'] ? 'selected' : '';?>>
                            <?=$st['store_name'];?> (<?=$st['city'];?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <button onclick="location.reload();" class="btn btn-sm btn-default" style="border-radius:8px; background:#fff; border:1px solid #cbd5e1; padding:6px 12px;">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>

<div class="container-fluid" style="padding: 24px;">
    <div class="row">
        <!-- Main Column: Orders Awaiting Pickup / Handover -->
        <div class="col-md-8">
            <div class="card-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                    <div>
                        <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--navy);">
                            <i class="fas fa-people-carry" style="color: var(--cyan);"></i> Handover & Pickup Desk
                        </h3>
                        <p style="margin: 4px 0 0 0; font-size: 13px; color: #64748B;">
                            Assign delivery personnel, verify sealed packages, and record dispatch handoffs.
                        </p>
                    </div>
                    <span class="badge" style="background: #E0F2FE; color: #0369A1; font-size: 13px; padding: 6px 12px;">
                        <?=count($handovers);?> Active Dispatches
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-handover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Patient / Destination</th>
                                <th>Assigned Rider</th>
                                <th>Amount & Mode</th>
                                <th>Status</th>
                                <th style="text-align: right;">Handover Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($handovers)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 30px; color: #94A3B8;">
                                        No orders currently waiting for rider handover.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($handovers as $h): ?>
                                <tr>
                                    <td>
                                        <strong>#<?=htmlspecialchars($h['order_code']);?></strong>
                                        <div style="font-size: 11px; color: #64748B;">
                                            <?=date('h:i A', strtotime($h['created_at']));?>
                                        </div>
                                    </td>
                                    <td>
                                        <div><strong><?=htmlspecialchars($h['customer_name']);?></strong></div>
                                        <div style="font-size: 12px; color: #64748B; max-width: 180px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                            <?=htmlspecialchars($h['delivery_address']);?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if(!empty($h['rider_name'])): ?>
                                            <strong><?=htmlspecialchars($h['rider_name']);?></strong>
                                            <div style="font-size: 11px; color: #475569;"><i class="fas fa-phone"></i> <?=htmlspecialchars($h['rider_phone']);?></div>
                                            <span class="badge" style="background: #F1F5F9; color: #334155; font-size: 10px;"><?=htmlspecialchars($h['vehicle_number']);?></span>
                                        <?php else: ?>
                                            <span style="color: #94A3B8; font-style: italic;">Unassigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong>₹<?=number_format($h['total_amount'], 2);?></strong>
                                        <div style="font-size: 11px; color: <?=$h['payment_mode']=='COD'?'var(--amber)':'var(--green)';?>">
                                            <?=$h['payment_mode'];?> (<?=$h['payment_status'];?>)
                                        </div>
                                    </td>
                                    <td>
                                        <span class="label <?=$h['order_status']=='IN_TRANSIT'?'label-primary':($h['order_status']=='ASSIGNED'?'label-info':'label-warning');?>">
                                            <?=$h['order_status'];?>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php if(empty($h['rider_id'])): ?>
                                            <button class="btn btn-xs btn-primary" onclick="openAssignModal(<?=$h['id'];?>, '<?=$h['order_code'];?>')" style="font-weight: 700;">
                                                <i class="fas fa-user-plus"></i> Assign
                                            </button>
                                        <?php elseif($h['order_status'] !== 'IN_TRANSIT'): ?>
                                            <button class="btn btn-xs btn-success" onclick="confirmHandover(<?=$h['id'];?>)" style="font-weight: 700;">
                                                <i class="fas fa-handshake"></i> Handoff & Dispatch
                                            </button>
                                        <?php else: ?>
                                            <span class="badge" style="background: #DCFCE7; color: #15803D;">En Route</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Active Fleet & Handover Instructions -->
        <div class="col-md-4">
            <!-- Active Delivery Agents -->
            <div class="card-box">
                <h4 style="margin-top: 0; font-size: 16px; font-weight: 800; color: var(--navy);">
                    <i class="fas fa-biking" style="color: var(--cyan);"></i> Available Delivery Fleet
                </h4>
                <p style="font-size: 12.5px; color: #64748B;">
                    Riders within operating radius eligible for dispatch.
                </p>

                <div style="max-height: 320px; overflow-y: auto;">
                    <?php if(empty($riders)): ?>
                        <p style="color: #94A3B8; font-size: 13px;">No active riders online.</p>
                    <?php else: ?>
                        <?php foreach($riders as $r): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #F1F5F9;">
                            <div>
                                <strong style="font-size: 13.5px;"><?=htmlspecialchars($r['rider_name']);?></strong>
                                <div style="font-size: 12px; color: #64748B;">
                                    <?=htmlspecialchars($r['vehicle_type']);?> &bull; <?=htmlspecialchars($r['vehicle_number']);?>
                                </div>
                                <div style="font-size: 11px; color: #94A3B8;">
                                    Completed: <?=htmlspecialchars($r['total_completed_orders'] ?? 0);?> deliveries
                                </div>
                            </div>
                            <div>
                                <span class="rider-badge-avail"><?=$r['status'] ?? 'AVAILABLE';?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mandatory Protocol Checklist -->
            <div class="card-box" style="background: #F8FAFC; border-left: 4px solid var(--navy);">
                <h5 style="margin-top: 0; font-weight: 700; color: var(--navy);"><i class="fas fa-shield-alt"></i> Chemist Handoff Protocol</h5>
                <ul style="padding-left: 18px; font-size: 12.5px; color: #475569; margin-bottom: 0;">
                    <li style="margin-bottom: 6px;">Check that invoice copy and doctor prescription are securely attached inside the tamper-evident pouch.</li>
                    <li style="margin-bottom: 6px;">Ensure Schedule H & H1 medications have Pharmacist Registration Stamp.</li>
                    <li style="margin-bottom: 6px;">Verify rider vehicle number before handing over high-value packages.</li>
                    <li>For COD orders, inform the rider of the exact cash amount to be collected at the patient's doorstep.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Assign Rider -->
<div class="modal fade" id="modalAssignRider" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: var(--navy); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700;"><i class="fas fa-motorcycle"></i> Assign Rider</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <form id="formAssignRider">
                    <input type="hidden" name="order_id" id="assign_order_id">
                    <div class="form-group">
                        <label>Order Code:</label>
                        <input type="text" id="assign_order_code" class="form-control" readonly style="font-weight: 700;">
                    </div>
                    <div class="form-group">
                        <label>Select Active Rider:</label>
                        <select name="rider_id" class="form-control" required style="border-radius: 6px;">
                            <option value="">-- Choose Rider --</option>
                            <?php foreach($riders as $r): ?>
                                <option value="<?=$r['id'];?>"><?=$r['rider_name'];?> (<?=$r['vehicle_number'];?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary" style="background: var(--navy); border: none; font-weight: 700; border-radius: 8px;">
                        Confirm Assignment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Legal Compliance Disclaimer -->
<div class="legal-footer">
    <strong>STATUTORY INTERMEDIARY NOTICE:</strong> UPCHAR operates solely as a digital technology and delivery logistics intermediary platform under the Information Technology Act, 2000. All pharmaceutical inventory, storage, packaging, and dispensing are conducted exclusively by licensed partner chemist stores under the Drugs & Cosmetics Act, 1940.
</div>

<script>
function openAssignModal(orderId, orderCode) {
    $('#assign_order_id').val(orderId);
    $('#assign_order_code').val(orderCode);
    $('#modalAssignRider').modal('show');
}

$('#formAssignRider').on('submit', function(e) {
    e.preventDefault();
    var orderId = $('#assign_order_id').val();
    var riderId = $('select[name="rider_id"]').val();

    $.ajax({
        url: '<?=base_url("pharmacy/delivery/assign");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            rider_id: riderId
        }),
        success: function(res) {
            alert(res.message || 'Rider assigned!');
            location.reload();
        },
        error: function(err) {
            alert('Failed to assign rider.');
        }
    });
});

function confirmHandover(orderId) {
    if (!confirm('Confirm physical handover to delivery rider and mark In-Transit?')) return;

    $.ajax({
        url: '<?=base_url("pharmacy/orders/status");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            status: 'IN_TRANSIT'
        }),
        success: function(res) {
            alert(res.message || 'Handoff confirmed. Order is In-Transit!');
            location.reload();
        },
        error: function(err) {
            alert('Failed to confirm handoff.');
        }
    });
}
</script>

