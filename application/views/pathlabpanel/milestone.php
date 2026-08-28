<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.dash-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.dash-card-header {
    background: #ffffff;
    border-bottom: 1px solid #f1f5f9;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.dash-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dash-card-body {
    padding: 22px;
}
.kpi-stat-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    transition: all 0.25s ease;
}
.kpi-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.07);
}
.kpi-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.kpi-val {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    margin: 4px 0 2px;
}
.kpi-label {
    font-size: 12.5px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}
.quick-action-tile {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px;
    text-decoration: none !important;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.2s ease;
}
.quick-action-tile:hover {
    border-color: #00a896;
    background: #f0fdfa;
    transform: translateY(-2px);
}
.quick-action-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #00a896;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Dashboard Welcome Banner -->
            <div style="background: linear-gradient(135deg, #1d2a44 0%, #295771 100%); border-radius: 12px; padding: 24px 28px; color: #ffffff; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.15); padding: 4px 12px; border-radius: 20px; font-size: 12px; margin-bottom: 8px;">
                        <i class="fa fa-hospital-o"></i> Pathology Diagnostic Partner Center
                    </div>
                    <h1 style="font-size: 22px; font-weight: 700; margin: 0 0 6px 0; color: #ffffff;">
                        Welcome, <?=htmlspecialchars(@$lab_profile->name ?: $this->session->userdata('pathusername') ?: 'Diagnostic Lab Partner');?>!
                    </h1>
                    <p style="margin: 0; color: #cbd5e1; font-size: 13.5px;">
                        Diagnostic operations overview, active test catalog, order queue, and patient appointments.
                    </p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="<?=base_url('pathlabpanel/book_test');?>" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 9px 20px;">
                        <i class="fa fa-plus-circle"></i> Book New Test
                    </a>
                    <a href="<?=base_url('pathlabpanel/pathtest');?>" class="btn btn-default" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #ffffff; font-weight: 600; border-radius: 8px; padding: 9px 18px;">
                        <i class="fa fa-list-alt"></i> Manage Tests
                    </a>
                </div>
            </div>

            <!-- KPI Metric Stats Grid -->
            <div class="row" style="margin-bottom: 10px;">
                <!-- 1. Total Pathology Test Orders -->
                <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                    <div class="kpi-stat-card">
                        <div>
                            <p class="kpi-label">Total Test Bookings</p>
                            <h3 class="kpi-val"><?=number_format($total_bookings);?></h3>
                            <span style="font-size: 11.5px; color: #059669; font-weight: 600;">
                                <i class="fa fa-calendar-check-o"></i> Today: <?=$today_bookings;?> orders
                            </span>
                        </div>
                        <div class="kpi-icon-box" style="background: #ecfdf5; color: #10b981;">
                            <i class="fa fa-flask"></i>
                        </div>
                    </div>
                </div>

                <!-- 2. Diagnostic Tests Offered -->
                <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                    <div class="kpi-stat-card">
                        <div>
                            <p class="kpi-label">Active Lab Tests</p>
                            <h3 class="kpi-val"><?=number_format($total_tests);?></h3>
                            <span style="font-size: 11.5px; color: #0284c7; font-weight: 600;">
                                <i class="fa fa-check-circle"></i> In Clinical Catalog
                            </span>
                        </div>
                        <div class="kpi-icon-box" style="background: #e0f2fe; color: #0284c7;">
                            <i class="fa fa-stethoscope"></i>
                        </div>
                    </div>
                </div>

                <!-- 3. Total Billed Revenue -->
                <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                    <div class="kpi-stat-card">
                        <div>
                            <p class="kpi-label">Total Diagnostic Revenue</p>
                            <h3 class="kpi-val">₹<?=number_format($total_revenue, 2);?></h3>
                            <span style="font-size: 11.5px; color: #d97706; font-weight: 600;">
                                <i class="fa fa-money"></i> Lab Invoices
                            </span>
                        </div>
                        <div class="kpi-icon-box" style="background: #fef3c7; color: #d97706;">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>

                <!-- 4. Linked Specialists -->
                <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                    <div class="kpi-stat-card">
                        <div>
                            <p class="kpi-label">Associated Doctors</p>
                            <h3 class="kpi-val"><?=number_format($totaldoctor);?></h3>
                            <span style="font-size: 11.5px; color: #7c3aed; font-weight: 600;">
                                <i class="fa fa-user-md"></i> Today Appts: <?=$todayappointment;?>
                            </span>
                        </div>
                        <div class="kpi-icon-box" style="background: #ede9fe; color: #7c3aed;">
                            <i class="fa fa-user-md"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area: Recent Bookings & Quick Actions -->
            <div class="row">
                <!-- Recent Test Bookings Table -->
                <div class="col-md-8">
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h3 class="dash-card-title">
                                <i class="fa fa-clock-o" style="color: #00a896;"></i> Recent Diagnostic Test Bookings
                            </h3>
                            <a href="<?=base_url('pathlabpanel/test_booking');?>" style="font-size: 12.5px; color: #00a896; font-weight: 600; text-decoration: none;">
                                View All <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                        <div class="dash-card-body" style="padding: 0;">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" style="margin: 0;">
                                    <thead style="background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase;">
                                        <tr>
                                            <th style="padding: 12px 16px;">#Order</th>
                                            <th style="padding: 12px 16px;">Patient</th>
                                            <th style="padding: 12px 16px;">Contact</th>
                                            <th style="padding: 12px 16px;">Amount</th>
                                            <th style="padding: 12px 16px;">Date</th>
                                            <th style="padding: 12px 16px; text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if(is_array($recent_bookings) && !empty($recent_bookings)):
                                            foreach($recent_bookings as $b):
                                        ?>
                                        <tr>
                                            <td style="padding: 12px 16px; font-weight: 600; color: #64748b; vertical-align: middle;">
                                                #<?=$b['booking_id'];?>
                                            </td>
                                            <td style="padding: 12px 16px; vertical-align: middle;">
                                                <strong style="color: #1e293b; font-size: 13px;"><?=htmlspecialchars($b['patient_name']);?></strong>
                                            </td>
                                            <td style="padding: 12px 16px; vertical-align: middle; font-size: 12px; color: #64748b;">
                                                <i class="fa fa-phone"></i> <?=htmlspecialchars($b['patient_mobile']);?>
                                            </td>
                                            <td style="padding: 12px 16px; vertical-align: middle; font-weight: 700; color: #00a896; font-size: 13.5px;">
                                                ₹<?=number_format($b['total_amount'], 2);?>
                                            </td>
                                            <td style="padding: 12px 16px; vertical-align: middle; font-size: 12px; color: #64748b;">
                                                <?=date('d M Y', strtotime($b['book_date']));?>
                                            </td>
                                            <td style="padding: 12px 16px; vertical-align: middle; text-align: center;">
                                                <a href="<?=base_url('pathlabpanel/booking_details/'.$b['booking_id']);?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 600; color: #00a896; border-color: #cbd5e1;">
                                                    <i class="fa fa-eye"></i> Details
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">
                                                No diagnostic orders recorded yet.
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Action Shortcuts & Lab Center Info -->
                <div class="col-md-4">
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h3 class="dash-card-title">
                                <i class="fa fa-bolt" style="color: #00a896;"></i> Quick Shortcuts
                            </h3>
                        </div>
                        <div class="dash-card-body" style="display: flex; flex-direction: column; gap: 10px; padding: 16px;">
                            <a href="<?=base_url('pathlabpanel/book_test');?>" class="quick-action-tile">
                                <div class="quick-action-icon" style="background: #e0f2fe; color: #0284c7;">
                                    <i class="fa fa-flask"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin: 0 0 2px;">Book Diagnostic Test</h4>
                                    <p style="font-size: 11.5px; color: #64748b; margin: 0;">Create new lab sample order</p>
                                </div>
                            </a>

                            <a href="<?=base_url('pathlabpanel/pathtest');?>" class="quick-action-tile">
                                <div class="quick-action-icon" style="background: #ecfdf5; color: #059669;">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin: 0 0 2px;">Pathology Catalog</h4>
                                    <p style="font-size: 11.5px; color: #64748b; margin: 0;">Manage tests, rates & parameters</p>
                                </div>
                            </a>

                            <a href="<?=base_url('pathlabpanel/test_booking');?>" class="quick-action-tile">
                                <div class="quick-action-icon" style="background: #fef3c7; color: #d97706;">
                                    <i class="fa fa-calendar-check-o"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin: 0 0 2px;">All Bookings Queue</h4>
                                    <p style="font-size: 11.5px; color: #64748b; margin: 0;">Track orders and home pickups</p>
                                </div>
                            </a>

                            <a href="<?=base_url('pathlabpanel/updateprofile');?>" class="quick-action-tile">
                                <div class="quick-action-icon" style="background: #ede9fe; color: #7c3aed;">
                                    <i class="fa fa-hospital-o"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin: 0 0 2px;">Laboratory Profile</h4>
                                    <p style="font-size: 11.5px; color: #64748b; margin: 0;">Update location, timings & details</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>