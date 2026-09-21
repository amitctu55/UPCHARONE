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

            <!-- Flash Alert Messages -->
            <?=$this->session->flashdata('flashmsg');?>

            <!-- LIS 4-Stage Diagnostic Pipeline Action Card -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-tasks"></i> Diagnostic Processing Stage &amp; Status
                    </h3>
                    <span class="badge" style="background: #ffffff; color: #00a896; font-weight: 700; font-size: 12px; padding: 5px 12px;">
                        Current: <?=html_escape(!empty($booking['order_stage']) ? $booking['order_stage'] : (!empty($booking['status']) ? $booking['status'] : 'ORDERED'));?>
                    </span>
                </div>
                <div class="pathlab-card-body" style="background: #f8fafc;">
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
                        Update the lab order stage as samples are collected, analyzed, and verified by pathologist:
                    </p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px;">
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=ORDERED');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fa fa-clock-o"></i> 1. Ordered / Pending
                        </a>
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=COLLECTED');?>" class="btn btn-info" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fa fa-tint"></i> 2. Sample Collected
                        </a>
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=PROCESSING');?>" class="btn btn-warning" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fa fa-cogs"></i> 3. In Processing / Analyzers
                        </a>
                        <a href="<?=base_url('pathlabpanel/update_order_stage?booking_id='.$booking['booking_id'].'&status=REPORT_READY');?>" class="btn btn-success" style="font-weight: 700; border-radius: 8px; padding: 8px 16px; background: #00a896; border-color: #00a896;">
                            <i class="fa fa-check-circle"></i> 4. Report Ready / Completed
                        </a>
                    </div>

                    <?php if (!empty($booking['report_file'])): ?>
                        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                            <div style="color: #065f46; font-size: 13.5px; font-weight: 600;">
                                <i class="fa fa-check-circle"></i> Verified Diagnostic Report is currently published &amp; downloadable by the patient.
                            </div>
                            <a href="<?=base_url($booking['report_file']);?>" target="_blank" class="btn btn-sm" style="background: #059669; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 6px 14px;">
                                <i class="fa fa-download"></i> View Current Report
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- PDF Diagnostic Report Upload & History Module -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-file-pdf-o"></i> Diagnostic Test Report Upload &amp; Management
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <div class="row">
                        
                        <!-- Upload Form -->
                        <div class="col-md-5 col-12" style="border-right: 1px solid #e2e8f0; padding-right: 25px;">
                            <h4 style="font-size: 14.5px; font-weight: 700; color: #0f172a; margin: 0 0 14px 0;">
                                <i class="fa fa-upload" style="color: #00a896;"></i> Upload New Patient Report
                            </h4>

                            <?=form_open_multipart('pathlabpanel/upload_report', array('id' => 'reportUploadForm'));?>
                                <input type="hidden" name="booking_id" value="<?=$booking['booking_id'];?>">

                                <div class="form-group" style="margin-bottom: 14px;">
                                    <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                        Report Title / Document Name <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="text" name="report_title" class="form-control" required placeholder="e.g. Complete Blood Count (CBC) Report" value="Diagnostic Test Report" style="height: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;">
                                </div>

                                <div class="form-group" style="margin-bottom: 14px;">
                                    <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                        Select Report File (PDF / Images) <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="file" name="report_file" class="form-control" required accept=".pdf,image/*" style="height: auto; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 12.5px;">
                                    <span style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">
                                        Supported formats: PDF, PNG, JPG (Max 20MB).
                                    </span>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                        Pathologist / Clinical Notes (Optional)
                                    </label>
                                    <textarea name="notes" rows="2" class="form-control" placeholder="Optional notes e.g. Results verified by Senior Pathologist" style="border-radius: 6px; border: 1px solid #cbd5e1; font-size: 12.5px;"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 10px 20px; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="fa fa-cloud-upload"></i> Upload &amp; Publish Report
                                </button>
                            <?=form_close();?>
                        </div>

                        <!-- Uploaded Reports List -->
                        <div class="col-md-7 col-12" style="padding-left: 25px;">
                            <h4 style="font-size: 14.5px; font-weight: 700; color: #0f172a; margin: 0 0 14px 0;">
                                <i class="fa fa-files-o" style="color: #00a896;"></i> Uploaded Reports for Order #<?=$booking['booking_id'];?>
                            </h4>

                            <?php if (!empty($reports)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" style="font-size: 12.5px;">
                                        <thead style="background: #f8fafc; color: #475569;">
                                            <tr>
                                                <th>Report Title</th>
                                                <th>Uploaded Date</th>
                                                <th>File Size</th>
                                                <th style="text-align: center; width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reports as $rep): ?>
                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        <strong style="color: #0f172a; display: block;"><?=htmlspecialchars($rep['report_title']);?></strong>
                                                        <?php if (!empty($rep['notes'])): ?>
                                                            <span style="font-size: 11px; color: #64748b;"><?=htmlspecialchars($rep['notes']);?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="vertical-align: middle; color: #64748b;">
                                                        <?=date('d M Y, h:i A', strtotime($rep['created_at']));?>
                                                    </td>
                                                    <td style="vertical-align: middle; color: #64748b;">
                                                        <?=htmlspecialchars($rep['file_size'] ?: 'N/A');?>
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                                                        <a href="<?=base_url($rep['report_file']);?>" target="_blank" class="btn btn-xs btn-info" style="font-weight: 600; border-radius: 4px; padding: 4px 8px;" title="View Report">
                                                            <i class="fa fa-download"></i> View
                                                        </a>
                                                        <a href="<?=base_url('pathlabpanel/delete_report/'.$rep['report_id']);?>" onclick="return confirm('Are you sure you want to delete this report?');" class="btn btn-xs btn-danger" style="font-weight: 600; border-radius: 4px; padding: 4px 8px; margin-left: 4px;" title="Delete Report">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 10px; padding: 30px; text-align: center; color: #64748b;">
                                    <i class="fa fa-file-pdf-o fa-3x" style="color: #94a3b8; margin-bottom: 10px; display: block;"></i>
                                    <strong style="display: block; color: #334155; font-size: 14px; margin-bottom: 4px;">No Reports Uploaded Yet</strong>
                                    <span>Once patient samples are analyzed, upload the signed PDF report using the form on the left.</span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
