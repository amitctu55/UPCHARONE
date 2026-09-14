<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory & Stock Management — UPCHAR Pharmacy Master Dashboard</title>
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

        body {
            background-color: #F4F7F9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1E293B;
            margin: 0;
            padding-bottom: 60px;
        }

        .inventory-page-wrapper {
            padding: 24px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .inventory-page-header {
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

        .inventory-page-title h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .inventory-page-title p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .kpi-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .kpi-card {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 18px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .kpi-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
        }
        .kpi-lbl {
            font-size: 12px;
            color: #64748B;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .filter-bar {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid var(--card-border);
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .inventory-card {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        /* Table Card */
        .content-card {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.03);
            padding: 24px;
            margin-bottom: 30px;
        }
        .inv-table {
            width: 100%;
            margin-top: 16px;
        }
        .inv-table th {
            background: #F8FAFC;
            color: #475569;
            font-weight: 700;
            font-size: 13px;
            padding: 12px 14px;
            border-bottom: 2px solid #E2E8F0;
        }
        .inv-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
            font-size: 13.5px;
        }
        .badge-stock {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-in-stock { background: #DCFCE7; color: #15803D; }
        .badge-low-stock { background: #FEF3C7; color: #B45309; }
        .badge-out-stock { background: #FEE2E2; color: #B91C1C; }

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

<div class="inventory-page-wrapper">
    <!-- Clean Page Header -->
    <div class="inventory-page-header">
        <div class="inventory-page-title">
            <h2><i class="fa fa-boxes-stacked text-primary me-2" style="color:#0284c7;"></i> Inventory & Stock Management</h2>
            <p>Live cataloguing, pricing, low-stock notifications, and batch tracking.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700;">
                <i class="fa fa-hospital-o me-1"></i> <?=htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');?>
            </span>
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control input-sm" onchange="location.href='<?=base_url('pharmacy/inventory?store_id=');?>'+this.value" style="display:inline-block; width:auto; height:34px; border-radius:8px; border:1px solid #cbd5e1; font-weight:600;">
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
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddStock" style="border-radius:8px; background:#0284c7; border:none; padding:6px 14px; font-weight:600;">
                <i class="fa fa-plus me-1"></i> Add Stock
            </button>
        </div>
    </div>
</div>

<div class="container-fluid" style="padding: 0 24px;">
    <!-- KPI Row -->
    <div class="kpi-row">
        <div class="kpi-card">
            <div>
                <div class="kpi-val"><?=$kpis['total_skus'];?></div>
                <div class="kpi-lbl">Total Medicines</div>
            </div>
            <i class="fas fa-pills" style="font-size: 28px; color: var(--cyan); opacity: 0.8;"></i>
        </div>
        <div class="kpi-card">
            <div>
                <div class="kpi-val" style="color: var(--amber);"><?=$kpis['low_stock'];?></div>
                <div class="kpi-lbl">Low Stock (&le; 10 units)</div>
            </div>
            <i class="fas fa-exclamation-triangle" style="font-size: 28px; color: var(--amber); opacity: 0.8;"></i>
        </div>
        <div class="kpi-card">
            <div>
                <div class="kpi-val" style="color: var(--red);"><?=$kpis['out_of_stock'];?></div>
                <div class="kpi-lbl">Out of Stock</div>
            </div>
            <i class="fas fa-times-circle" style="font-size: 28px; color: var(--red); opacity: 0.8;"></i>
        </div>
        <div class="kpi-card">
            <div>
                <div class="kpi-val" style="color: var(--green);">₹<?=number_format($kpis['total_value'], 2);?></div>
                <div class="kpi-lbl">Total Inventory Valuation</div>
            </div>
            <i class="fas fa-rupee-sign" style="font-size: 28px; color: var(--green); opacity: 0.8;"></i>
        </div>
    </div>

    <!-- Inventory Table Card -->
    <div class="content-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 18px;">
            <div>
                <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: var(--navy);">
                    <i class="fas fa-boxes" style="color: var(--cyan);"></i> Pharmacy Stock Catalog
                </h3>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: #64748B;">
                    Update stock quantities, batch details, and pricing in real-time.
                </p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddStock" style="background: var(--navy); border: none; font-weight: 700; border-radius: 8px;">
                    <i class="fas fa-plus-circle"></i> Add / Map Medicine
                </button>
                <a href="<?=base_url('pharmacy/inventory/import');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                    <i class="fas fa-file-import"></i> Bulk Import
                </a>
            </div>
        </div>

        <!-- Filter / Search Bar -->
        <form method="get" action="<?=base_url('pharmacy/inventory');?>" class="form-inline" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
            <input type="hidden" name="store_id" value="<?=$current_store['id'];?>">
            <input type="text" name="q" value="<?=htmlspecialchars($search);?>" class="form-control" placeholder="Search brand, composition, batch..." style="width: 280px; border-radius: 6px;">
            <select name="filter" class="form-control" style="border-radius: 6px;">
                <option value="" <?=$filter == '' ? 'selected' : '';?>>All Stock Levels</option>
                <option value="low_stock" <?=$filter == 'low_stock' ? 'selected' : '';?>>Low Stock Only (&le; 10)</option>
                <option value="out_of_stock" <?=$filter == 'out_of_stock' ? 'selected' : '';?>>Out of Stock Only</option>
            </select>
            <button type="submit" class="btn btn-info" style="border-radius: 6px; font-weight: 600;"><i class="fas fa-search"></i> Filter</button>
            <?php if(!empty($search) || !empty($filter)): ?>
                <a href="<?=base_url('pharmacy/inventory?store_id='.$current_store['id']);?>" class="btn btn-default" style="border-radius: 6px;">Reset</a>
            <?php endif; ?>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="inv-table">
                <thead>
                    <tr>
                        <th>Medicine & Composition</th>
                        <th>Dosage / Strength</th>
                        <th>Batch No.</th>
                        <th>Expiry Date</th>
                        <th>MRP (₹)</th>
                        <th>Selling Price (₹)</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($inventory)): ?>
                        <tr><td colspan="9" style="text-align: center; padding: 30px; color: #94A3B8;">No medicines found matching the filter.</td></tr>
                    <?php else: ?>
                        <?php foreach($inventory as $item): ?>
                        <tr>
                            <td>
                                <strong><?=htmlspecialchars($item['brand_name']);?></strong>
                                <?php if($item['is_prescription_required']): ?>
                                    <span class="label label-danger" style="font-size: 10px; margin-left: 4px;">Rx</span>
                                <?php endif; ?>
                                <div style="font-size: 12px; color: #64748B;"><?=htmlspecialchars($item['generic_composition']);?></div>
                            </td>
                            <td><?=htmlspecialchars($item['dosage_form']);?> (<?=htmlspecialchars($item['strength']);?>)</td>
                            <td><span class="badge" style="background: #E2E8F0; color: #334155;"><?=htmlspecialchars($item['batch_no'] ?: 'N/A');?></span></td>
                            <td><?=htmlspecialchars($item['expiry_date'] ?: 'N/A');?></td>
                            <td>₹<?=number_format($item['mrp'], 2);?></td>
                            <td><strong style="color: var(--navy);">₹<?=number_format($item['selling_price'], 2);?></strong></td>
                            <td>
                                <input type="number" min="0" value="<?=$item['stock_quantity'];?>" id="qty_<?=$item['id'];?>" class="form-control input-sm" style="width: 80px; display: inline-block; font-weight: 700;">
                            </td>
                            <td>
                                <?php if($item['stock_quantity'] <= 0): ?>
                                    <span class="badge-stock badge-out-stock">Out of Stock</span>
                                <?php elseif($item['stock_quantity'] <= 10): ?>
                                    <span class="badge-stock badge-low-stock">Low (<?=$item['stock_quantity'];?>)</span>
                                <?php else: ?>
                                    <span class="badge-stock badge-in-stock">In Stock (<?=$item['stock_quantity'];?>)</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <button class="btn btn-xs btn-success" onclick="quickUpdateStock(<?=$item['id'];?>, 'qty_<?=$item['id'];?>')" style="font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                                    <i class="fas fa-check"></i> Save
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Add / Map Medicine -->
<div class="modal fade" id="modalAddStock" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: var(--navy); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700;"><i class="fas fa-plus-circle"></i> Add Medicine to Stock</h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <form id="formAddStock">
                    <input type="hidden" name="pharmacy_id" value="<?=$current_store['id'];?>">
                    <div class="form-group">
                        <label>Select Medicine from Master Catalog <span class="text-danger">*</span></label>
                        <select name="medicine_id" class="form-control" required style="border-radius: 6px;">
                            <option value="">-- Choose Master Medicine --</option>
                            <?php foreach($all_medicines as $m): ?>
                                <option value="<?=$m['id'];?>"><?=$m['brand_name'];?> (<?=$m['dosage_form'];?> - <?=$m['strength'];?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Batch Number <span class="text-danger">*</span></label>
                            <input type="text" name="batch_no" class="form-control" required placeholder="e.g. BATCH-2026A" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock_quantity" class="form-control" required min="1" value="50" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>MRP (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="mrp" class="form-control" required placeholder="120.00" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Selling Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="selling_price" class="form-control" required placeholder="105.00" style="border-radius: 6px;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary" style="background: var(--navy); border: none; font-weight: 700; padding: 10px; border-radius: 8px; margin-top: 10px;">
                        Save to Pharmacy Inventory
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
function quickUpdateStock(inventoryId, inputId) {
    var newQty = $('#' + inputId).val();
    $.ajax({
        url: '<?=base_url("pharmacy/inventory/update");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            inventory_id: inventoryId,
            stock_quantity: newQty
        }),
        success: function(res) {
            alert(res.message || 'Stock updated!');
            location.reload();
        },
        error: function(err) {
            alert('Error updating stock. Please try again.');
        }
    });
}

$('#formAddStock').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serializeArray();
    var payload = {};
    $.each(formData, function(i, field) {
        payload[field.name] = field.value;
    });

    $.ajax({
        url: '<?=base_url("pharmacy/inventory/update");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function(res) {
            alert(res.message || 'Medicine added!');
            location.reload();
        },
        error: function(err) {
            alert('Failed to add medicine to inventory.');
        }
    });
});
</script>

