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
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-credit-card" style="color: #00a896;"></i> Pathology Payments & Billing Logs
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Track customer test payments, lab settlements, and invoice records.</p>
                </div>
            </div>

            <!-- Revenue Highlight Cards -->
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Billed Amount</div>
                            <div style="font-size: 28px; font-weight: 800; color: #00a896; margin-top: 4px;">₹<?=number_format($total_revenue, 2);?></div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Across <?=number_format($total_bookings);?> Diagnostic Orders</div>
                        </div>
                        <div style="width: 54px; height: 54px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Payment Settlement Status</div>
                            <div style="font-size: 24px; font-weight: 800; color: #0284c7; margin-top: 4px;">Up to Date</div>
                            <div style="font-size: 12px; color: #10b981; margin-top: 4px;"><i class="fa fa-shield"></i> Direct Bank Transfer Active</div>
                        </div>
                        <div style="width: 54px; height: 54px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="fa fa-check-square-o"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-list-alt"></i> Billing & Transaction Records
                    </h3>
                </div>
                <div class="pathlab-card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 70px; text-align: center;">#ID</th>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Invoice Amount</th>
                                    <th>Billing Date</th>
                                    <th style="text-align: center;">Payment Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(is_array($payment_records) && !empty($payment_records)):
                                    foreach($payment_records as $p):
                                        $isPaid = ($p['payment_status'] == 1);
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">
                                        #<?=$p['booking_id'];?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($p['patient_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <i class="fa fa-phone"></i> <?=htmlspecialchars($p['patient_mobile']);?>
                                    </td>
                                    <td style="vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($p['total_amount'], 2);?>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <?=date('d M Y', strtotime($p['book_date']));?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="label <?=$isPaid ? 'label-success' : 'label-warning';?>" style="font-size: 11px; padding: 4px 10px; border-radius: 12px;">
                                            <?=$isPaid ? 'Paid' : 'Pending';?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?=base_url('pathlabpanel/booking_details/'.$p['booking_id']);?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 600; color: #00a896; border-color: #cbd5e1;">
                                            <i class="fa fa-eye"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                        No billing records found.
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
