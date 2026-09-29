<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    /* Accessioning Scanner Bar */
    .scanner-console {
        background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 28px;
        color: #ffffff;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
        position: relative;
        overflow: hidden;
    }
    .scanner-console::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #10b981, #f59e0b, #6366f1);
        background-size: 200% 100%;
        animation: scanner-glow 3s linear infinite;
    }
    @keyframes scanner-glow {
        0% { background-position: 0% 0%; }
        100% { background-position: 200% 0%; }
    }
    .scanner-input {
        height: 46px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
        font-size: 14px;
        padding: 0 16px;
        transition: all 0.2s ease;
        width: 100%;
    }
    .scanner-input:focus {
        outline: none;
        border-color: #818cf8;
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
    }
    .scanner-select {
        height: 46px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: #1e293b;
        color: #ffffff;
        font-size: 13.5px;
        padding: 0 14px;
        width: 100%;
    }
    .scanner-btn {
        height: 46px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        font-weight: 800;
        border-radius: 12px;
        padding: 0 24px;
        font-size: 14px;
        border: none;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        width: 100%;
        justify-content: center;
    }
    .scanner-btn:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
    }

    /* Pending Queue Card */
    .pending-queue-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #fde68a;
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.08);
        margin-bottom: 28px;
        overflow: hidden;
    }
    .pending-queue-head {
        padding: 16px 22px;
        background: #fffbeb;
        border-bottom: 1px solid #fef3c7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Audit Log Table */
    .ops-table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--ops-slate-200);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }
    .ops-data-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }
    .ops-data-table th {
        background: #f8fafc;
        padding: 12px 20px;
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        border-bottom: 1px solid var(--ops-slate-200);
        white-space: nowrap;
    }
    .ops-data-table td {
        padding: 14px 20px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .ops-data-table tr:hover td {
        background-color: #f8fafc;
    }
</style>

<!-- TOP BANNER -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(99, 102, 241, 0.1); color: var(--ops-primary); font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 8px;">
            <i class="fa fa-barcode"></i> Diagnostic Chain-of-Custody Desk
        </div>
        <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
            Lab Sample Intake &amp; Accessioning Console
        </h1>
        <p style="color: #64748b; font-size: 14px; margin: 6px 0 0 0;">
            Verify physical diagnostic blood/urine vials received from doorstep phlebotomists into the central laboratory.
        </p>
    </div>

    <div style="display: flex; gap: 10px;">
        <a href="<?= base_url('admin1947/operations'); ?>" class="btn" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 12px; padding: 10px 18px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa fa-tachometer"></i> Operations Hub
        </a>
        <a href="<?= base_url('admin1947/operations/expenses'); ?>" class="btn" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 12px; padding: 10px 18px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa fa-credit-card"></i> Expense Desk
        </a>
    </div>
</div>

<!-- RAPID BARCODE ACCESSIONING CONSOLE -->
<div class="scanner-console">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 8px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(99, 102, 241, 0.25); color: #a5b4fc; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fa fa-qrcode"></i>
            </div>
            <div>
                <strong style="font-size: 16px; color: #ffffff; display: block; font-family: var(--font-head);">Rapid Barcode Accessioning Scanner</strong>
                <small style="color: #94a3b8; font-size: 12px;">Scan vial tube with handheld barcode gun or manually enter Order ID</small>
            </div>
        </div>
        <span style="font-size: 11px; background: rgba(16, 185, 129, 0.15); color: #34d399; padding: 4px 12px; border-radius: 999px; font-weight: 700; border: 1px solid rgba(52, 211, 153, 0.3);">
            <i class="fa fa-circle" style="font-size: 7px; color: #10b981; margin-right: 4px;"></i> Scanner Active
        </span>
    </div>

    <form id="quickBarcodeForm" onsubmit="handleInwardSubmit(event)" style="margin: 0;">
        <div class="row">
            <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                <label style="font-size: 11px; font-weight: 700; color: #94a3b8; margin-bottom: 4px; display: block;">Booking / Order ID #</label>
                <input type="number" id="quickBookingId" class="scanner-input" placeholder="e.g. 101" required>
            </div>
            <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                <label style="font-size: 11px; font-weight: 700; color: #94a3b8; margin-bottom: 4px; display: block;">Vial Barcode Scanner Input</label>
                <input type="text" id="quickBarcode" class="scanner-input" placeholder="Scan or enter barcode" style="font-family: monospace; letter-spacing: 1px;" required>
            </div>
            <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                <label style="font-size: 11px; font-weight: 700; color: #94a3b8; margin-bottom: 4px; display: block;">Sample Physical Condition</label>
                <select id="quickCondition" class="scanner-select">
                    <option value="good">Intact / Standard Temperature</option>
                    <option value="hemolyzed">Hemolyzed (Red Discoloration)</option>
                    <option value="temperature_alert">Temperature Alert (Warm Box)</option>
                    <option value="leakage">Leakage / Damaged Vial Tube</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                <label style="font-size: 11px; font-weight: 700; color: transparent; margin-bottom: 4px; display: block;">Action</label>
                <button type="submit" class="scanner-btn" id="inwardBtn">
                    <i class="fa fa-check-circle"></i> Inward Into Lab
                </button>
            </div>
        </div>
    </form>
</div>

<!-- PENDING FIELD SAMPLES QUEUE -->
<?php if (!empty($pending_field_samples)): ?>
<div class="pending-queue-card">
    <div class="pending-queue-head">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-motorcycle" style="color: #d97706; font-size: 18px;"></i>
            <strong style="color: #92400e; font-size: 14px;">Field Phlebotomist Collections in Transit (<?= count($pending_field_samples); ?> Pending Inward)</strong>
        </div>
        <small style="color: #b45309; font-weight: 600;">Click "Accept Into Lab" to autofill barcode &amp; order</small>
    </div>
    <div class="table-responsive">
        <table class="ops-data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Patient Name</th>
                    <th>Prescribed Test</th>
                    <th>Phlebotomist</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_field_samples as $p): ?>
                <tr>
                    <td><strong style="font-family: monospace; color: #0f172a;">#<?= $p['booking_id']; ?></strong></td>
                    <td><strong><?= html_escape($p['patient_name'] ?? 'Patient'); ?></strong></td>
                    <td><span style="color: #475569;"><?= html_escape($p['test_name'] ?? 'Diagnostic Panel'); ?></span></td>
                    <td><?= html_escape($p['collector_name'] ?? 'Field Staff'); ?></td>
                    <td><a href="tel:<?= $p['collector_phone']; ?>" style="color: #0284c7; font-weight: 600; text-decoration: none;"><i class="fa fa-phone"></i> <?= html_escape($p['collector_phone'] ?? 'N/A'); ?></a></td>
                    <td>
                        <button type="button" class="btn btn-xs" onclick="prefillInward(<?= $p['booking_id']; ?>, '<?= html_escape($p['vial_barcode'] ?? ('VIAL-' . $p['booking_id'])); ?>', <?= (int)($p['assigned_collector_id'] ?? 0); ?>)" style="background: #f59e0b; color: #fff; font-weight: 700; border-radius: 6px; padding: 4px 10px;">
                            <i class="fa fa-arrow-up"></i> Accept Sample
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- VERIFIED ACCESSION LOG -->
<div class="ops-table-card">
    <div style="padding: 18px 24px; background: #ffffff; border-bottom: 1px solid var(--ops-slate-200); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-list-alt" style="color: var(--ops-primary);"></i>
            Verified Chain-of-Custody Accession Log (<?= count($handoffs); ?> Records)
        </h3>
        <span style="font-size: 12px; color: #64748b;">Sorted by newest accession timestamp</span>
    </div>

    <div class="table-responsive">
        <table class="ops-data-table" id="accessionTable">
            <thead>
                <tr>
                    <th>Accession ID</th>
                    <th>Order #</th>
                    <th>Vial Barcode</th>
                    <th>Phlebotomist</th>
                    <th>Lab Inward Time</th>
                    <th>Sample Condition</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($handoffs)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                        <i class="fa fa-barcode" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px;"></i>
                        <strong style="color: #475569; display: block;">No sample accessions logged yet</strong>
                        <small>Use the scanner bar above to inward diagnostic samples.</small>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($handoffs as $h): ?>
                    <tr>
                        <td><span style="color: #64748b; font-family: monospace;">#ACC-<?= str_pad($h['id'], 5, '0', STR_PAD_LEFT); ?></span></td>
                        <td><strong style="font-family: monospace; color: #0f172a;">#<?= html_escape($h['booking_id']); ?></strong></td>
                        <td>
                            <strong style="font-family: monospace; color: #4338ca; background: #eef2ff; padding: 3px 8px; border-radius: 6px; letter-spacing: 0.5px;">
                                <?= html_escape($h['barcode']); ?>
                            </strong>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;"><?= html_escape($h['collector_name'] ?? 'Field Staff'); ?></div>
                            <small style="color: #94a3b8; font-size: 11px;"><?= html_escape($h['collector_phone'] ?? ''); ?></small>
                        </td>
                        <td><small style="color: #64748b; font-weight: 600;"><?= date('d M Y, h:i A', strtotime($h['handoff_time'])); ?></small></td>
                        <td>
                            <?php if ($h['sample_condition'] === 'good'): ?>
                                <span class="badge-status badge-good"><i class="fa fa-check"></i> Intact</span>
                            <?php else: ?>
                                <span class="badge-status badge-alert"><i class="fa fa-exclamation-triangle"></i> <?= html_escape(ucwords(str_replace('_', ' ', $h['sample_condition']))); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge-status badge-info"><i class="fa fa-check-circle"></i> In Lab</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
var currentCollectorId = 0;

function prefillInward(bookingId, barcode, collectorId) {
    document.getElementById('quickBookingId').value = bookingId;
    document.getElementById('quickBarcode').value = barcode;
    currentCollectorId = collectorId;
    document.getElementById('quickBarcode').focus();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function handleInwardSubmit(e) {
    e.preventDefault();
    var bId = document.getElementById('quickBookingId').value.trim();
    var barcode = document.getElementById('quickBarcode').value.trim();
    var cond = document.getElementById('quickCondition').value;
    var btn = document.getElementById('inwardBtn');

    if (!bId || !barcode) {
        alert("Please provide both Booking Order ID and Vial Barcode.");
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Inwarding...';

    $.ajax({
        url: "<?= base_url('admin1947/operations/verify_handoff'); ?>",
        type: "POST",
        dataType: "json",
        data: {
            booking_id: bId,
            barcode: barcode,
            collector_id: currentCollectorId,
            condition: cond
        },
        success: function(resp) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-check-circle"></i> Inward Into Lab';
            if (resp.status === 'success') {
                // Audio beep feedback
                try {
                    var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    var osc = audioCtx.createOscillator();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, audioCtx.currentTime);
                    osc.connect(audioCtx.destination);
                    osc.start();
                    osc.stop(audioCtx.currentTime + 0.15);
                } catch(e) {}

                alert(resp.message);
                location.reload();
            } else {
                alert(resp.message || "Failed to record sample handoff.");
            }
        },
        error: function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-check-circle"></i> Inward Into Lab';
            alert("Network error communicating with the accessioning desk.");
        }
    });
}
</script>