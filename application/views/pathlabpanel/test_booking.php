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
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 24px;
}
.path-toolbar {
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    gap: 12px;
    align-items: flex-end;
    flex-wrap: wrap;
}
.path-form-input {
    height: 38px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 6px 12px;
    font-size: 13px;
    color: #1e293b;
    width: 100%;
}
.path-form-input:focus {
    border-color: #00a896;
    outline: none;
}
.badge-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.badge-paid {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}
.badge-pending {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}
.badge-active {
    background: #e0f2fe;
    color: #0284c7;
    border: 1px solid #bae6fd;
}
</style>

<div class="pag_cstm" style="padding: 20px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-calendar-check-o" style="color: #00a896;"></i> Diagnostic Test Booking Orders
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Track customer bookings, home sample collections, payments, and generated reports.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/book_test');?>" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 8px; padding: 9px 20px;">
                        <i class="fa fa-plus"></i> Book New Test
                    </a>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            <?=$this->session->flashdata('flashmsg');?>

            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-list"></i> Pathology Test Bookings List
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <!-- Search Toolbar -->
                    <?php echo form_open("pathlabpanel/test_booking/", 'class="path-toolbar" id="search_form" method="get"'); ?>
                        <div style="flex: 1; min-width: 180px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">Patient Name</label>
                            <input type="text" class="path-form-input" name="keyword" placeholder="Search patient..." value="<?=$this->input->get_post('keyword');?>">
                        </div>
                        <div style="width: 150px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">From Date</label>
                            <input type="date" class="path-form-input" name="date_from" value="<?=$this->input->get_post('date_from');?>">
                        </div>
                        <div style="width: 150px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; display: block;">To Date</label>
                            <input type="date" class="path-form-input" name="date_to" value="<?=$this->input->get_post('date_to');?>">
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button type="submit" class="btn btn-primary" style="height: 38px; background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px; padding: 0 18px;">
                                <i class="fa fa-search"></i> Search
                            </button>
                            <?php if($this->input->get_post('keyword') || $this->input->get_post('date_from') || $this->input->get_post('date_to')): ?>
                                <a href="<?=base_url('pathlabpanel/test_booking');?>" class="btn btn-default" style="height: 38px; border-radius: 6px; line-height: 24px;">
                                    <i class="fa fa-times text-danger"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php echo form_close(); ?>

                    <!-- Bookings Table -->
                    <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 60px; text-align: center;">#ID</th>
                                    <th>Patient Details</th>
                                    <th>Contact Info</th>
                                    <th>Total Price</th>
                                    <th>Booking Date</th>
                                    <th style="text-align: center;">Payment</th>
                                    <th style="text-align: center;">Order Status</th>
                                    <th style="text-align: center; width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(is_array($package) && !empty($package)):
                                    foreach($package as $val):
                                        $bid = $val['booking_id'];
                                        $isPaid = ($val['payment_status'] == 1);
                                        $isActive = ($val['status'] == '1');
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">
                                        #<?=$bid;?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($val['patient_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($val['patient_mobile']);?></div>
                                        <?php if(!empty($val['patient_email'])): ?>
                                            <div style="font-size: 11.5px; color: #64748b;"><i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($val['patient_email']);?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($val['total_amount'], 2);?>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <?=date('d M Y', strtotime($val['book_date']));?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="badge-status-pill <?=$isPaid ? 'badge-paid' : 'badge-pending';?>">
                                            <?=$isPaid ? 'Paid' : 'Pending';?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="badge-status-pill <?=$isActive ? 'badge-active' : 'badge-pending';?>">
                                            <?=$isActive ? 'Active' : 'De-Active';?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?=base_url('pathlabpanel/booking_details/'.$bid);?>" class="btn btn-xs btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 6px; padding: 5px 12px; font-weight: 600;">
                                            <i class="fa fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                        <i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                                        No test booking orders found.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(!empty($page_links)): ?>
                        <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <div class="pagination"><?=$page_links;?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
