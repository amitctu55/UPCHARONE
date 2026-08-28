<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.pathlab-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.pathlab-card-header {
    background: linear-gradient(135deg, #1d2a44 0%, #295771 100%);
    color: #ffffff;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.pathlab-card-title {
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 20px;
}
</style>

<div class="pag_cstm" style="padding: 20px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-file-text-o" style="color: #00a896;"></i> Diagnostic Order Details #<?=$booking['booking_id'];?>
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Prescribed pathology tests, patient contact details, and invoice summary.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/test_booking');?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>

            <!-- Two-column info cards -->
            <div class="row">
                <!-- Patient Demographics -->
                <div class="col-md-6">
                    <div class="pathlab-card">
                        <div class="pathlab-card-header">
                            <h3 class="pathlab-card-title">
                                <i class="fa fa-user"></i> Patient Information
                            </h3>
                        </div>
                        <div class="pathlab-card-body">
                            <div style="margin-bottom: 12px;">
                                <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">Full Patient Name</div>
                                <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                    <?=htmlspecialchars($booking['patient_name']);?>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                <div>
                                    <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">Phone Number</div>
                                    <div style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 2px;">
                                        <i class="fa fa-phone" style="color: #00a896;"></i> <?=htmlspecialchars($booking['patient_mobile']);?>
                                    </div>
                                </div>
                                <div>
                                    <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">Email Address</div>
                                    <div style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 2px;">
                                        <i class="fa fa-envelope-o" style="color: #00a896;"></i> <?=htmlspecialchars($booking['patient_email'] ?: 'N/A');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laboratory & Location Info -->
                <div class="col-md-6">
                    <div class="pathlab-card">
                        <div class="pathlab-card-header">
                            <h3 class="pathlab-card-title">
                                <i class="fa fa-hospital-o"></i> Laboratory Information
                            </h3>
                        </div>
                        <div class="pathlab-card-body">
                            <div style="margin-bottom: 12px;">
                                <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">Pathology Center</div>
                                <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                                    <?=htmlspecialchars($booking['pathlab_name']);?>
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">City / Region</div>
                                <div style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 2px;">
                                    <i class="fa fa-map-marker" style="color: #00a896;"></i> <?=htmlspecialchars($booking['city_name'] ?: 'Local Center');?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tests Breakdown Table -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-flask"></i> Prescribed Diagnostic Tests Breakdown
                    </h3>
                </div>
                <div class="pathlab-card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 50px; text-align: center;">#</th>
                                    <th>Diagnostic Test Name</th>
                                    <th>Short Code</th>
                                    <th>Testing Method</th>
                                    <th style="text-align: right; width: 150px;">Test Price (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                if(is_array($booking_test) && !empty($booking_test)):
                                    foreach($booking_test as $val):
                                ?>
                                <tr>
                                    <td style="text-align: center; vertical-align: middle; color: #64748b; font-weight: 600;"><?=$i;?></td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($val['test_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="label label-default" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 11px;">
                                            <?=htmlspecialchars($val['short_name']);?>
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle; color: #64748b; font-size: 12.5px;">
                                        <?=htmlspecialchars($val['method'] ?: 'Automated Diagnostic Analyzer');?>
                                    </td>
                                    <td style="text-align: right; vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($val['amount'], 2);?>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">
                                        No tests recorded for this order.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
                                    <th colspan="4" style="text-align: right; font-size: 14px; font-weight: 700; color: #1e293b; padding: 16px;">
                                        Total Order Amount:
                                    </th>
                                    <th style="text-align: right; font-size: 17px; font-weight: 800; color: #00a896; padding: 16px;">
                                        ₹<?=number_format($booking['total_amount'], 2);?>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- LIS 4-Stage Diagnostic Pipeline Action Card -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-tasks"></i> Diagnostic Processing Stage &amp; Status
                    </h3>
                    <span class="badge" style="background: #ffffff; color: #00a896; font-weight: 700; font-size: 12px; padding: 5px 12px;">
                        Current: <?=html_escape(!empty($booking['status']) ? $booking['status'] : 'ORDERED');?>
                    </span>
                </div>
                <div class="pathlab-card-body" style="background: #f8fafc;">
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
                        Update the lab order stage as samples are collected, analyzed, and verified:
                    </p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=ORDERED');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fa fa-clock-o"></i> 1. Ordered
                        </a>
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=COLLECTED');?>" class="btn btn-info" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fa fa-tint"></i> 2. Sample Collected
                        </a>
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=PROCESSING');?>" class="btn btn-warning" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fa fa-cogs"></i> 3. In Processing
                        </a>
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=COMPLETED');?>" onclick="return confirm('Complete this order and release payment escrow?');" class="btn btn-success" style="font-weight: 700; border-radius: 8px; padding: 8px 16px; background: #00a896; border-color: #00a896;">
                            <i class="fa fa-check-circle"></i> 4. Report Ready &amp; Completed
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
