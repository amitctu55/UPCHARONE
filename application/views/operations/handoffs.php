<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Central Lab Sample Handoff &amp; Intake Desk
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Verify physical diagnostic vials received from field phlebotomists before pathology testing.
        </p>
    </div>
</div>

<!-- Pending Inward Samples Queue -->
<?php if (!empty($pending_field_samples)): ?>
<div class="ops-card" style="padding: 20px; margin-bottom: 24px; border-left: 4px solid #f59e0b;">
    <h4 style="margin: 0 0 14px; font-size: 16px; font-weight: 800; color: #92400e;">
        <i class="fa fa-truck"></i> Pending Handoffs from Field Collectors (<?=count($pending_field_samples);?>)
    </h4>
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #fef3c7; font-size: 11.5px; color: #92400e; text-transform: uppercase;">
                    <th>Order #</th>
                    <th>Patient Name</th>
                    <th>Collector</th>
                    <th>Vial Barcode</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_field_samples as $ps): ?>
                <tr>
                    <td><strong>#<?=$ps['booking_id'];?></strong></td>
                    <td>
                        <div style="font-weight: 700; color: #0f172a;"><?=html_escape($ps['patient_name']);?></div>
                        <small style="color: #64748b;"><?=html_escape($ps['test_name']);?></small>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #334155;"><?=html_escape($ps['collector_name'] ?: 'Phlebotomist');?></div>
                        <small style="color: #64748b;"><?=$ps['collector_phone'];?></small>
                    </td>
                    <td>
                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-family: monospace; font-size: 12px; font-weight: 700;">
                            <?=$ps['vial_barcode'] ?: 'UPC-BAR-'.rand(100000, 999999);?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-success btn-verify-sample" data-booking="<?=$ps['booking_id'];?>" data-collector="<?=$ps['assigned_collector_id'] ?: 4;?>" data-barcode="<?=$ps['vial_barcode'] ?: 'UPC-BAR-'.rand(100000, 999999);?>" style="font-weight: 700; border-radius: 8px;">
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

<!-- Verified Sample Intake Log -->
<div class="ops-card" style="padding: 20px;">
    <h4 style="margin: 0 0 16px; font-size: 16px; font-weight: 800; color: #0f172a;">
        <i class="fa fa-check-circle" style="color: #10b981; margin-right: 6px;"></i> Verified Sample Intake Log
    </h4>
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Barcode &amp; Order</th>
                    <th>Patient Name</th>
                    <th>Collector</th>
                    <th>Received By</th>
                    <th>Intake Time</th>
                    <th>Sample Condition</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($handoffs)): ?>
                    <?php foreach ($handoffs as $h): ?>
                    <tr>
                        <td>
                            <strong style="font-family: monospace; color: #0284c7; font-size: 14px;"><?=$h['barcode'];?></strong>
                            <small style="display: block; color: #64748b;">Order #<?=$h['booking_id'];?></small>
                        </td>
                        <td style="font-weight: 700; color: #1e293b;">
                            <?=html_escape($h['patient_name'] ?: 'Patient Sample');?>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #334155;"><?=html_escape($h['collector_name'] ?: 'Collector');?></div>
                            <small style="color: #64748b; font-family: monospace;"><?=$h['collector_code'];?></small>
                        </td>
                        <td style="color: #334155; font-size: 13px;">
                            <?=html_escape($h['received_by_name'] ?: 'Operations Officer');?>
                        </td>
                        <td style="color: #64748b; font-size: 13px;">
                            <?=date('d M Y, h:i A', strtotime($h['handoff_time']));?>
                        </td>
                        <td>
                            <span class="badge" style="background: #dcfce7; color: #15803d; text-transform: uppercase; font-size: 11px;">
                                <?=html_escape($h['sample_condition']);?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No sample handoffs recorded yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$('.btn-verify-sample').click(function() {
    var bId = $(this).data('booking');
    var cId = $(this).data('collector');
    var bar = $(this).data('barcode');

    if (confirm('Verify and accept sample vial barcode ' + bar + ' into central pathology testing?')) {
        $.post('<?=base_url("operations/verify_handoff");?>', {
            booking_id: bId,
            collector_id: cId,
            barcode: bar,
            condition: 'good'
        }, function(res) {
            alert(res.message);
            location.reload();
        }, 'json');
    }
});
</script>
