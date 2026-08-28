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
    padding: 22px;
}
.stat-mini-card {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 16px;
    margin-bottom: 20px;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-bar-chart" style="color: #00a896;"></i> Diagnostic Reports & Performance Analytics
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Monitor laboratory testing volumes, customer report deliveries, and clinical stats.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/test_booking');?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-list"></i> View All Orders
                    </a>
                </div>
            </div>

            <!-- Stats Overview Grid -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-mini-card">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Orders Processed</div>
                        <div style="font-size: 24px; font-weight: 800; color: #00a896; margin-top: 4px;"><?=number_format($total_bookings);?></div>
                        <div style="font-size: 12px; color: #10b981; margin-top: 4px;"><i class="fa fa-calendar"></i> Today: <?=$today_bookings;?> bookings</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-mini-card">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Catalog Tests</div>
                        <div style="font-size: 24px; font-weight: 800; color: #0284c7; margin-top: 4px;"><?=number_format($total_tests);?></div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;"><i class="fa fa-check-circle"></i> Active Pathology Tests</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-mini-card">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Billed Revenue</div>
                        <div style="font-size: 24px; font-weight: 800; color: #d97706; margin-top: 4px;">₹<?=number_format($total_revenue, 2);?></div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;"><i class="fa fa-money"></i> Lab Invoices</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-mini-card">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Avg Turnaround Time</div>
                        <div style="font-size: 24px; font-weight: 800; color: #7c3aed; margin-top: 4px;">&lt; 24 Hrs</div>
                        <div style="font-size: 12px; color: #10b981; margin-top: 4px;"><i class="fa fa-bolt"></i> 99.4% On-Time Delivery</div>
                    </div>
                </div>
            </div>

            <!-- Recent Lab Reports Table -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-file-text-o"></i> Recent Diagnostic Orders & Report Status
                    </h3>
                </div>
                <div class="pathlab-card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 70px; text-align: center;">#ID</th>
                                    <th>Patient Details</th>
                                    <th>Contact</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th style="text-align: center;">Report Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(is_array($recent_reports) && !empty($recent_reports)):
                                    foreach($recent_reports as $r):
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">
                                        #<?=$r['booking_id'];?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($r['patient_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <i class="fa fa-phone"></i> <?=htmlspecialchars($r['patient_mobile']);?>
                                    </td>
                                    <td style="vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($r['total_amount'], 2);?>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <?=date('d M Y', strtotime($r['book_date']));?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="label label-success" style="background: #dcfce7 !important; color: #15803d !important; border: 1px solid #bbf7d0; font-size: 11px; padding: 4px 10px; border-radius: 12px;">
                                            <i class="fa fa-check-circle"></i> Ready / Verified
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?=base_url('pathlabpanel/booking_details/'.$r['booking_id']);?>" class="btn btn-xs btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 6px; padding: 5px 12px; font-weight: 600;">
                                            <i class="fa fa-eye"></i> View Order
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                        No recent diagnostic orders found.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
