<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Central Lab Sample Handoff & Accessioning Desk View -->
<div class="container-fluid" style="padding: 0;">

    <?php
    $pendingCount = count($pending_field_samples ?? []);
    $verifiedCount = count($handoffs ?? []);
    ?>

    <!-- Top Header & Actions -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(99, 102, 241, 0.1); color: #4f46e5; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                <i class="fa fa-barcode"></i> Diagnostic Chain-of-Custody Desk
            </div>
            <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                Central Lab Sample Intake &amp; Accessioning
            </h2>
            <p style="color: #64748b; font-size: 13.5px; margin: 6px 0 0 0;">
                Verify physical diagnostic vials received from doorstep phlebotomists before pathology testing.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="<?= base_url('admin1947/operations'); ?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 10px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-tachometer"></i> Operations Hub
            </a>
            <a href="<?= base_url('admin1947/operations/expenses'); ?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 10px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-credit-card"></i> Expense Desk
            </a>
        </div>
    </div>

    <!-- Quick Barcode Accessioning Bar -->
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; color: #ffffff; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(99, 102, 241, 0.2); color: #818cf8; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa fa-qrcode"></i>
                </div>
                <div>
                    <strong style="font-size: 15px; color: #ffffff; display: block;">Rapid Barcode Accessioning Scanner</strong>
                    <small style="color: #94a3b8; font-size: 11.5px;">Scan barcode scanner input or manually enter vial ID for rapid verification</small>
                </div>
            </div>
            <span style="font-size: 11px; background: rgba(255, 255, 255, 0.1); color: #e2e8f0; padding: 4px 10px; border-radius: 20px; font-weight: 700;">
                <i class="fa fa-wifi" style="color: #10b981;"></i> Lab Intake Online
            </span>
        </div>

        <form id="quickBarcodeForm" style="margin: 0;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: center;">
                <div>
                    <input type="number" id="quickBookingId" class="form-control" placeholder="Order / Booking # (e.g. 101)" required style="height: 42px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.08); color: #ffffff; font-size: 13px;">
                </div>
                <div>
                    <input type="text" id="quickBarcode" class="form-control" placeholder="Scan or Enter Vial Barcode" required style="height: 42px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.08); color: #ffffff; font-size: 13px; font-family: monospace;">
                </div>
                <div>
                    <select id="quickCondition" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); background: #1e293b; color: #ffffff; font-size: 13px;">
                        <option value="good">Sample Condition: Good / Intact</option>
                        <option value="hemolyzed">Sample Condition: Hemolyzed</option>
                        <option value="temperature_alert">Sample Condition: Temp Alert</option>
                        <option value="leakage">Sample Condition: Leakage / Damaged</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn" style="height: 42px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 800; border-radius: 8px; padding: 0 20px; font-size: 13px; border: none; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa fa-check-circle"></i> Inward Sample
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Pending Intake Queue from Field Phlebotomists -->
    <?php if (!empty($pending_field_samples)): ?>
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #fde68a; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.08); margin-bottom: 24px; overflow: hidden;">
        <div style="padding: 16px 20px; background: #fffbeb; border-bottom: 1px solid #fef3c7; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-truck" style="color: #d97706; font-size: 16px;"></i>
                <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #92400e;">
                    Inward Queue: Samples En-route from Phlebotomists (<?= $pendingCount; ?> Pending Intake)
                </h4>
            </div>
            <span style="font-size: 11.5px; font-weight: 700; color: #b45309; background: #fef3c7; padding: 3px 10px; border-radius: 12px;">
                Awaiting physical lab handover
            </span>
        </div>

        <div class="table-responsive">
            <table class="table" style="margin: 0; vertical-align: middle;">
                <thead>
                    <tr style="background: #fffbeb; font-size: 11px; color: #92400e; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                        <th style="padding: 12px 18px; font-weight: 800;">Order ID</th>
                        <th style="padding: 12px 18px; font-weight: 800;">Patient Name &amp; Test</th>
                        <th style="padding: 12px 18px; font-weight: 800;">Collecting Phlebotomist</th>
                        <th style="padding: 12px 18px; font-weight: 800;">Assigned Vial Barcode</th>
                        <th style="padding: 12px 18px; font-weight: 800;">Condition</th>
                        <th style="padding: 12px 18px; font-weight: 800; text-align: right;">Lab Accession</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_field_samples as $ps): 
                        $barcodeVal = $ps['vial_barcode'] ?: 'UPC-' . date('d') . rand(10000, 99999);
                        $collId = $ps['assigned_collector_id'] ?: 4;
                    ?>
                    <tr style="border-bottom: 1px solid #fef3c7;">
                        <td style="padding: 14px 18px;">
                            <strong style="color: #0f172a; font-size: 14px;">#<?= $ps['booking_id']; ?></strong>
                        </td>

                        <td style="padding: 14px 18px;">
                            <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">
                                <?= html_escape($ps['patient_name'] ?: 'Patient Record'); ?>
                            </div>
                            <small style="color: #64748b; font-weight: 600;">
                                <i class="fa fa-flask" style="color: #94a3b8;"></i> <?= html_escape($ps['test_name'] ?: 'Complete Blood Count (CBC)'); ?>
                            </small>
                        </td>

                        <td style="padding: 14px 18px;">
                            <div style="font-weight: 700; color: #1e293b; font-size: 13px;">
                                <?= html_escape($ps['collector_name'] ?: 'Field Phlebotomist'); ?>
                            </div>
                            <small style="color: #64748b;">
                                <i class="fa fa-phone" style="color: #10b981;"></i> <?= $ps['collector_phone'] ?: 'N/A'; ?>
                            </small>
                        </td>

                        <td style="padding: 14px 18px;">
                            <span style="display: inline-block; font-family: monospace; font-size: 12.5px; font-weight: 800; color: #0369a1; background: #e0f2fe; padding: 4px 10px; border-radius: 6px; border: 1px solid #bae6fd;">
                                <?= $barcodeVal; ?>
                            </span>
                        </td>

                        <td style="padding: 14px 18px;">
                            <select class="form-control sample-cond-select" style="height: 34px; font-size: 12px; border-radius: 6px; width: 140px; border: 1px solid #cbd5e1;">
                                <option value="good">Good / Intact</option>
                                <option value="hemolyzed">Hemolyzed</option>
                                <option value="temperature_alert">Temp Alert</option>
                                <option value="leakage">Leakage</option>
                            </select>
                        </td>

                        <td style="padding: 14px 18px; text-align: right;">
                            <button type="button" class="btn btn-sm btn-verify-sample" 
                                    data-booking="<?= $ps['booking_id']; ?>" 
                                    data-collector="<?= $collId; ?>" 
                                    data-barcode="<?= $barcodeVal; ?>" 
                                    style="background: #10b981; color: #ffffff; font-weight: 700; border-radius: 8px; padding: 6px 14px; font-size: 12px; border: none; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);">
                                <i class="fa fa-check"></i> Accept at Lab
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Verified Sample Intake History Log -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04); overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #ffffff; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></div>
                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                    Verified Sample Intake History Log (<?= $verifiedCount; ?> Vials Inwarded)
                </h4>
            </div>

            <div style="position: relative; min-width: 260px;">
                <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
                <input type="text" id="handoffSearchInput" class="form-control" placeholder="Search barcode, patient, collector..." style="padding-left: 34px; height: 36px; border-radius: 8px; font-size: 12.5px; border: 1px solid #cbd5e1;">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="handoffTable" style="margin: 0; vertical-align: middle;">
                <thead>
                    <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                        <th style="padding: 14px 20px; font-weight: 800;">Barcode &amp; Order</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Patient Name</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Phlebotomist</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Received By Lab Officer</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Accession Time</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Sample Quality</th>
                        <th style="padding: 14px 20px; font-weight: 800; text-align: right;">Chain Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($handoffs)): ?>
                        <?php foreach ($handoffs as $h): 
                            $cond = strtolower($h['sample_condition']);
                            $condBg = '#dcfce7';
                            $condColor = '#15803d';
                            if ($cond === 'hemolyzed' || $cond === 'leakage') {
                                $condBg = '#fee2e2';
                                $condColor = '#991b1b';
                            } elseif ($cond === 'temperature_alert') {
                                $condBg = '#fef3c7';
                                $condColor = '#92400e';
                            }
                        ?>
                        <tr class="handoff-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                            <td style="padding: 16px 20px;">
                                <strong style="font-family: monospace; font-size: 13px; color: #0284c7; background: #e0f2fe; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                    <?= $h['barcode']; ?>
                                </strong>
                                <small style="display: block; color: #64748b; font-size: 11px; margin-top: 3px;">
                                    Booking #<?= $h['booking_id']; ?>
                                </small>
                            </td>

                            <td style="padding: 16px 20px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;">
                                    <?= html_escape($h['patient_name'] ?: 'Patient Sample'); ?>
                                </div>
                            </td>

                            <td style="padding: 16px 20px;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 13px;">
                                    <?= html_escape($h['collector_name'] ?: 'Phlebotomist'); ?>
                                </div>
                                <small style="color: #64748b; font-family: monospace;">
                                    <?= $h['collector_code']; ?>
                                </small>
                            </td>

                            <td style="padding: 16px 20px;">
                                <div style="font-size: 13px; color: #334155; font-weight: 600;">
                                    <i class="fa fa-user-md" style="color: #6366f1; margin-right: 4px;"></i>
                                    <?= html_escape($h['received_by_name'] ?: 'Lab Accession Officer'); ?>
                                </div>
                            </td>

                            <td style="padding: 16px 20px; color: #64748b; font-size: 12.5px;">
                                <i class="fa fa-clock-o" style="margin-right: 4px;"></i>
                                <?= date('d M Y, h:i A', strtotime($h['handoff_time'])); ?>
                            </td>

                            <td style="padding: 16px 20px;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: <?= $condBg; ?>; color: <?= $condColor; ?>; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                                    <i class="fa fa-dot-circle-o"></i> <?= html_escape($h['sample_condition']); ?>
                                </span>
                            </td>

                            <td style="padding: 16px 20px; text-align: right;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                                    <i class="fa fa-check-circle"></i> <?= $h['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 48px 20px;">
                                <i class="fa fa-flask" style="font-size: 32px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                                <strong style="font-size: 14px; color: #475569;">No verified sample handoffs logged</strong>
                                <p style="font-size: 12.5px; color: #94a3b8; margin: 4px 0 0 0;">Use the scanner input above or accept pending samples from the queue.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- AJAX Verification & Search Script -->
<script>
$(document).ready(function() {
    // Verify from table row button
    $('.btn-verify-sample').click(function() {
        var $btn = $(this);
        var bookingId   = $btn.data('booking');
        var collectorId = $btn.data('collector');
        var barcode     = $btn.data('barcode');
        var condition   = $btn.closest('tr').find('.sample-cond-select').val() || 'good';

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');

        $.post('<?= base_url("admin1947/operations/verify_handoff"); ?>', {
            booking_id: bookingId,
            collector_id: collectorId,
            barcode: barcode,
            condition: condition,
            '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
        }, function(res) {
            alert(res.message);
            location.reload();
        }, 'json').fail(function() {
            alert('An error occurred during sample accessioning.');
            $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Accept at Lab');
        });
    });

    // Quick scanner form submit
    $('#quickBarcodeForm').submit(function(e) {
        e.preventDefault();
        var bookingId = $('#quickBookingId').val();
        var barcode   = $('#quickBarcode').val();
        var condition = $('#quickCondition').val();

        $.post('<?= base_url("admin1947/operations/verify_handoff"); ?>', {
            booking_id: bookingId,
            collector_id: 4,
            barcode: barcode,
            condition: condition,
            '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
        }, function(res) {
            alert(res.message);
            location.reload();
        }, 'json').fail(function() {
            alert('Verification failed. Check order ID and barcode.');
        });
    });

    // Client search filter
    $('#handoffSearchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#handoffTable tbody tr.handoff-row').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
