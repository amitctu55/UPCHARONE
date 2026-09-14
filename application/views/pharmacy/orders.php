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

.orders-page-wrapper {
    padding: 24px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.orders-page-header {
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

.orders-page-title h2 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.orders-page-title p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.status-pills {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 12px;
    margin-bottom: 20px;
}

.pill-item {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    padding: 8px 18px;
    border-radius: 30px;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    white-space: nowrap;
    transition: all 0.2s;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}

.pill-item:hover {
    border-color: var(--cyan);
    color: #0369a1;
}

.pill-item.active {
    background: #0284c7;
    color: #FFFFFF !important;
    border-color: #0284c7;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
}

.order-card {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    border-radius: 12px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.order-header {
    padding: 16px 20px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.order-body {
    padding: 20px;
}

.status-tag {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
}

.tag-placed { background: #FEF3C7; color: #B45309; }
.tag-confirmed { background: #E0F2FE; color: #0369A1; }
.tag-packed { background: #EDE9FE; color: #6D28D9; }
.tag-in_transit { background: #DBEAFE; color: #1D4ED8; }
.tag-delivered { background: #D1FAE5; color: #047857; }
.tag-cancelled { background: #FEE2E2; color: #B91C1C; }

.item-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    border-bottom: 1px dashed #F1F5F9;
    font-size: 13px;
}

.rx-badge {
    background: #FEF2F2;
    color: var(--red);
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 700;
    border: 1px solid #FECACA;
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

<div class="orders-page-wrapper">
    <!-- Clean Page Header -->
    <div class="orders-page-header">
        <div class="orders-page-title">
            <h2><i class="fa fa-receipt text-primary me-2" style="color:#0284c7;"></i> Live Orders & Bills</h2>
            <p>Real-time customer medicine orders, verification, packaging, and delivery tracking.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700;">
                <i class="fa fa-hospital-o me-1"></i> <?=htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');?>
            </span>
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control input-sm" onchange="location.href='<?=base_url('pharmacy/orders?store_id=');?>'+this.value" style="display:inline-block; width:auto; height:34px; border-radius:8px; border:1px solid #cbd5e1; font-weight:600;">
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
</div>

<div class="container-fluid" style="padding: 0 24px;">
    <!-- Status Filter Pills -->
    <div class="status-pills">
        <a href="<?=base_url('pharmacy/orders?status=ALL&store_id='.$current_store['id']);?>" class="pill-item <?=$current_status=='ALL'?'active':'';?>">All Orders (<?=count($orders);?>)</a>
        <a href="<?=base_url('pharmacy/orders?status=PENDING&store_id='.$current_store['id']);?>" class="pill-item <?=$current_status=='PENDING'?'active':'';?>"><i class="fas fa-clock text-warning"></i> Placed / Pending Rx</a>
        <a href="<?=base_url('pharmacy/orders?status=CONFIRMED&store_id='.$current_store['id']);?>" class="pill-item <?=$current_status=='CONFIRMED'?'active':'';?>"><i class="fas fa-check-circle text-info"></i> Stock Confirmed</a>
        <a href="<?=base_url('pharmacy/orders?status=PACKED&store_id='.$current_store['id']);?>" class="pill-item <?=$current_status=='PACKED'?'active':'';?>"><i class="fas fa-box text-primary"></i> Packed & Ready</a>
        <a href="<?=base_url('pharmacy/orders?status=IN_TRANSIT&store_id='.$current_store['id']);?>" class="pill-item <?=$current_status=='IN_TRANSIT'?'active':'';?>"><i class="fas fa-motorcycle text-primary"></i> In-Transit</a>
        <a href="<?=base_url('pharmacy/orders?status=DELIVERED&store_id='.$current_store['id']);?>" class="pill-item <?=$current_status=='DELIVERED'?'active':'';?>"><i class="fas fa-hand-holding-heart text-success"></i> Delivered</a>
    </div>

    <!-- Orders Feed -->
    <?php if(empty($orders)): ?>
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid var(--card-border); padding: 50px; text-align: center; color: #94A3B8;">
            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 14px; opacity: 0.5;"></i>
            <h4>No orders found in status "<?=$current_status;?>".</h4>
        </div>
    <?php else: ?>
        <?php foreach($orders as $ord): ?>
        <div class="order-card" id="order_card_<?=$ord['id'];?>">
            <!-- Card Header -->
            <div class="order-card-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-weight: 800; font-size: 16px; color: var(--navy);">
                        #<?=htmlspecialchars($ord['order_code']);?>
                    </span>
                    <span class="badge-status status-<?=$ord['order_status'];?>">
                        <?=$ord['order_status'];?>
                    </span>
                    <span style="font-size: 12px; color: #64748B;">
                        Placed: <?=date('d M Y, h:i A', strtotime($ord['created_at']));?>
                    </span>
                </div>
                <div>
                    <span class="label <?=$ord['payment_status']=='PAID'?'label-success':'label-warning';?>" style="font-size: 12px; padding: 4px 10px;">
                        Payment: <?=$ord['payment_status'];?> (<?=$ord['payment_mode'];?>)
                    </span>
                    <strong style="margin-left: 12px; font-size: 16px; color: var(--navy);">
                        ₹<?=number_format($ord['total_amount'], 2);?>
                    </strong>
                </div>
            </div>

            <!-- Card Body -->
            <div class="order-card-body">
                <div class="order-grid">
                    <!-- Column 1: Customer Info & Rx -->
                    <div class="col-sec">
                        <h5 style="margin-top: 0; font-weight: 700; color: var(--navy);"><i class="fas fa-user"></i> Patient Details</h5>
                        <p style="margin-bottom: 4px;"><strong><?=htmlspecialchars($ord['customer_name']);?></strong></p>
                        <p style="margin-bottom: 4px; font-size: 13px; color: #475569;"><i class="fas fa-phone"></i> <?=htmlspecialchars($ord['customer_phone']);?></p>
                        <p style="font-size: 12.5px; color: #64748B;"><i class="fas fa-map-marker-alt"></i> <?=htmlspecialchars($ord['delivery_address']);?></p>

                        <?php if(!empty($ord['prescription_file'])): ?>
                            <div style="margin-top: 12px;">
                                <label style="font-size: 11px; text-transform: uppercase; color: #64748B;">Uploaded Prescription</label>
                                <div>
                                    <a href="<?=base_url($ord['prescription_file']);?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600;">
                                        <i class="fas fa-external-link-alt"></i> View Doctor Rx
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Column 2: Order Items -->
                    <div class="col-sec">
                        <h5 style="margin-top: 0; font-weight: 700; color: var(--navy);"><i class="fas fa-pills"></i> Prescribed Medicines</h5>
                        <table class="table table-condensed" style="font-size: 13px;">
                            <thead>
                                <tr style="color: #64748B;">
                                    <th>Medicine Name</th>
                                    <th>Qty</th>
                                    <th>Batch Assigned</th>
                                    <th style="text-align: right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ord['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?=htmlspecialchars($item['brand_name']);?></strong>
                                        <?php if($item['is_prescription_required']): ?>
                                            <span class="label label-danger" style="font-size: 9px;">Rx</span>
                                        <?php endif; ?>
                                        <div style="font-size: 11px; color: #64748B;"><?=htmlspecialchars($item['strength']);?></div>
                                    </td>
                                    <td><?=$item['quantity'];?></td>
                                    <td>
                                        <input type="text" value="<?=htmlspecialchars($item['batch_no'] ?: 'BATCH-'.date('ym'));?>" id="batch_<?=$item['id'];?>" class="form-control input-sm" style="height: 24px; padding: 2px 6px; font-size: 12px; width: 100px;">
                                    </td>
                                    <td style="text-align: right;">₹<?=number_format($item['total_price'], 2);?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Column 3: Rider & Handover Details -->
                    <div class="col-sec">
                        <h5 style="margin-top: 0; font-weight: 700; color: var(--navy);"><i class="fas fa-motorcycle"></i> Delivery Status</h5>
                        <?php if(!empty($ord['rider_id'])): ?>
                            <p style="margin-bottom: 4px;"><strong>Rider:</strong> <?=htmlspecialchars($ord['rider_name']);?></p>
                            <p style="margin-bottom: 4px; font-size: 13px;"><i class="fas fa-phone"></i> <?=htmlspecialchars($ord['rider_phone']);?></p>
                            <p style="margin-bottom: 4px; font-size: 12px; color: #64748B;"><i class="fas fa-biking"></i> <?=htmlspecialchars($ord['vehicle_number']);?></p>
                            <?php if(!empty($ord['delivery_otp'])): ?>
                                <div style="background: #FEF3C7; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; color: #92400E; display: inline-block; margin-top: 6px;">
                                    Customer Delivery OTP: <?=$ord['delivery_otp'];?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p style="color: #94A3B8; font-size: 13px;">No rider assigned yet.</p>
                            <button class="btn btn-sm btn-info" onclick="openAssignModal(<?=$ord['id'];?>, '<?=$ord['order_code'];?>')" style="border-radius: 6px; font-weight: 600;">
                                <i class="fas fa-user-plus"></i> Assign Rider
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Card Footer Actions -->
            <div class="order-card-footer">
                <div style="font-size: 13px; color: #64748B;">
                    Subtotal: ₹<?=number_format($ord['item_total'], 2);?> &bull; Delivery Fee: ₹<?=number_format($ord['delivery_fee'], 2);?>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <!-- Print Bill -->
                    <a href="<?=base_url('pharmacy/billing/generate/'.$ord['id']);?>" target="_blank" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                        <i class="fas fa-print"></i> Print Tax Invoice
                    </a>

                    <!-- State Actions -->
                    <?php if(in_array($ord['order_status'], ['PLACED', 'PENDING_RX'])): ?>
                        <button class="btn btn-sm btn-info" onclick="updateOrderStatus(<?=$ord['id'];?>, 'CONFIRMED')" style="font-weight: 700; border-radius: 6px;">
                            <i class="fas fa-check"></i> Confirm Stock
                        </button>
                    <?php elseif($ord['order_status'] === 'CONFIRMED'): ?>
                        <button class="btn btn-sm btn-primary" onclick="updateOrderStatus(<?=$ord['id'];?>, 'PACKED')" style="font-weight: 700; border-radius: 6px; background: #6D28D9; border: none;">
                            <i class="fas fa-box"></i> Mark Packed & Dispatch Fleet
                        </button>
                    <?php elseif(in_array($ord['order_status'], ['PACKED', 'ASSIGNED'])): ?>
                        <button class="btn btn-sm btn-primary" onclick="updateOrderStatus(<?=$ord['id'];?>, 'IN_TRANSIT')" style="font-weight: 700; border-radius: 6px; background: #1D4ED8; border: none;">
                            <i class="fas fa-motorcycle"></i> Rider Picked Up (In-Transit)
                        </button>
                    <?php elseif($ord['order_status'] === 'IN_TRANSIT'): ?>
                        <button class="btn btn-sm btn-success" onclick="updateOrderStatus(<?=$ord['id'];?>, 'DELIVERED')" style="font-weight: 700; border-radius: 6px;">
                            <i class="fas fa-check-double"></i> Mark Delivered
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal: Assign Rider -->
<div class="modal fade" id="modalAssignRider" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: var(--navy); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700;"><i class="fas fa-motorcycle"></i> Assign Delivery Agent</h4>
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
                        Confirm Rider Assignment
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
function updateOrderStatus(orderId, targetStatus) {
    if (!confirm('Change status of order #' + orderId + ' to ' + targetStatus + '?')) return;

    $.ajax({
        url: '<?=base_url("pharmacy/orders/status");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            status: targetStatus
        }),
        success: function(res) {
            alert(res.message || 'Status updated!');
            location.reload();
        },
        error: function(err) {
            alert('Failed to update status.');
        }
    });
}

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
</script>

