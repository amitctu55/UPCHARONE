<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.appt-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.appt-kpi-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease;
}

.appt-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
}

.badge-paid {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 10px;
}

.badge-unpaid {
    background: #fee2e2;
    color: #991b1b;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 10px;
}

.badge-active {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 10px;
}

.badge-completed {
    background: #ecfdf5;
    color: #059669;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 10px;
}

.btn-rx-action {
    background: #f0fdfa;
    color: #00a896 !important;
    border: 1px solid #ccfbf1;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
    padding: 5px 10px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-decoration: none !important;
}

.btn-rx-action:hover {
    background: #00a896;
    color: #ffffff !important;
}

.btn-complete-action {
    background: #f59e0b;
    color: #ffffff !important;
    border: 1px solid #d97706;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
    padding: 5px 10px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-decoration: none !important;
}

.btn-complete-action:hover {
    background: #d97706;
}
</style>

<div class="pag_cstm appt-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-calendar-check-o text-aqua" style="margin-right: 8px;"></i> Appointments &amp; Consultations
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Review patient queues, manage consultation status, write digital prescriptions, and release escrow fee settlements.
                    </p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="<?=base_url('manageappointment?d='.date('Y-m-d'));?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; color: #00a896; border-color: #ccfbf1; background: #f0fdfa;">
                        <i class="fa fa-calendar"></i> Today's Queue (<?=$today_count;?>)
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- 4-Grid KPI Row -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="appt-kpi-card" style="border-left: 4px solid #f59e0b;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Today's Visits</div>
                            <div style="font-size: 26px; font-weight: 800; color: #d97706; margin: 4px 0 2px 0;"><?=$today_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;"><?=date('d M Y');?></div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="appt-kpi-card" style="border-left: 4px solid #00a896;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Active / Scheduled</div>
                            <div style="font-size: 26px; font-weight: 800; color: #00a896; margin: 4px 0 2px 0;"><?=$pending_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Awaiting consultation</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-stethoscope"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="appt-kpi-card" style="border-left: 4px solid #10b981;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Completed Visits</div>
                            <div style="font-size: 26px; font-weight: 800; color: #059669; margin: 4px 0 2px 0;"><?=$completed_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Discharged with Rx</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-check-circle-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="appt-kpi-card" style="border-left: 4px solid #3b82f6;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Consultations</div>
                            <div style="font-size: 26px; font-weight: 800; color: #2563eb; margin: 4px 0 2px 0;"><?=$total_count;?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">All-time bookings</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Bar Box -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); margin-bottom: 24px;">
                <form action="<?=base_url('manageappointment');?>" method="get" class="form-inline" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                        <div class="form-group">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-right: 6px;">Filter by Date:</label>
                            <input type="date" name="d" class="form-control input-sm" value="<?=@$selected_date;?>" style="border-radius: 6px;">
                        </div>

                        <div class="form-group" style="margin-left: 8px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-right: 6px;">Status:</label>
                            <select name="status" class="form-control input-sm" style="border-radius: 6px;">
                                <option value="ALL" <?=$selected_status=='ALL'?'selected':'';?>>All Statuses</option>
                                <option value="1" <?=$selected_status=='1'?'selected':'';?>>Active / Scheduled</option>
                                <option value="2" <?=$selected_status=='2'?'selected':'';?>>Completed (Visited)</option>
                            </select>
                        </div>

                        <div class="form-group" style="margin-left: 8px;">
                            <input type="text" name="q" class="form-control input-sm" placeholder="Search Patient / Mobile / #ID" value="<?=@$search_query;?>" style="border-radius: 6px; width: 220px;">
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700; border-radius: 6px; padding: 5px 14px;">
                            <i class="fa fa-filter"></i> Apply Filter
                        </button>

                        <?php if(!empty($selected_date) || !empty($search_query) || ($selected_status != 'ALL' && $selected_status != '')): ?>
                            <a href="<?=base_url('manageappointment');?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                                <i class="fa fa-times"></i> Reset
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Appointments Table Card -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid var(--upchar-border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa fa-list text-aqua"></i> Patient Appointments Queue
                    </h3>
                    <span style="font-size: 12px; color: #64748b;">
                        Showing <?=count($appointments);?> booking(s)
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                                <th style="padding: 14px 16px; width: 70px;">Appt #</th>
                                <th style="padding: 14px 16px;">Patient Demographics</th>
                                <th style="padding: 14px 16px;">Establishment / Chamber</th>
                                <th style="padding: 14px 16px;">Visit Date &amp; Slot</th>
                                <th style="padding: 14px 16px;">Fee</th>
                                <th style="padding: 14px 16px;">Payment</th>
                                <th style="padding: 14px 16px;">Status</th>
                                <th style="padding: 14px 16px; text-align: right;">Clinical Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($appointments)): ?>
                                <?php foreach($appointments as $p): 
                                    $appt = $p['appointment'];
                                    $inst = $p['institute'];
                                    $p_name = $appt->patient_name ?: ($appt->user_fname . ' ' . $appt->user_lname);
                                    $p_mobile = $appt->patient_mobile ?: $appt->user_mobile;
                                ?>
                                <tr>
                                    <td style="padding: 14px 16px; font-weight: 700; font-family: monospace; color: #00a896; vertical-align: middle;">
                                        #<?=$appt->appointment_id;?>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                            <?=htmlspecialchars($p_name ?: 'Patient #'.$appt->appointment_id);?>
                                        </div>
                                        <?php if(!empty($p_mobile)): ?>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            <a href="tel:<?=$p_mobile;?>" style="color: #0284c7; text-decoration: none;">
                                                <i class="fa fa-phone"></i> <?=htmlspecialchars($p_mobile);?>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 16px; color: #334155; vertical-align: middle;">
                                        <div style="font-weight: 700; color: #1e293b;">
                                            <?=htmlspecialchars($inst ? $inst->name : ($appt->institution_type == 'H' ? 'Visiting Hospital' : 'Private Clinic'));?>
                                        </div>
                                        <div style="font-size: 11px; color: #64748b;">
                                            <?=$appt->institution_type == 'H' ? '<span class="label label-info">Hospital</span>' : '<span class="label label-primary">Clinic</span>';?>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <div style="font-weight: 600; color: #0f172a;">
                                            <i class="fa fa-calendar text-muted"></i> <?=date('d M Y', strtotime($appt->appointment_date));?>
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            <i class="fa fa-clock-o text-muted"></i> <?=$appt->from_timing;?> - <?=$appt->to_timing;?>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 16px; font-weight: 800; color: #0f172a; vertical-align: middle;">
                                        ₹<?=number_format($appt->amount ?: $appt->fee, 2);?>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <?php if($appt->payment_status == 'DONE' || $appt->payment_status == 'PAID'): ?>
                                            <span class="badge-paid"><i class="fa fa-check"></i> Paid</span>
                                        <?php else: ?>
                                            <span class="badge-unpaid"><i class="fa fa-clock-o"></i> Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <?php if($appt->status == '2'): ?>
                                            <span class="badge-completed"><i class="fa fa-check-circle"></i> Visited</span>
                                        <?php else: ?>
                                            <span class="badge-active"><i class="fa fa-clock-o"></i> Scheduled</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 16px; text-align: right; vertical-align: middle;">
                                        <a href="<?=base_url('doctorpanel/prescription/'.$appt->appointment_id);?>" class="btn-rx-action" title="Write Rx SOAP">
                                            <i class="fa fa-stethoscope"></i> Write Rx
                                        </a>
                                        <?php if($appt->status != '2'): ?>
                                        <a href="<?=base_url('doctorpanel/complete_appointment?aid='.$appt->appointment_id);?>" onclick="return confirm('Mark consultation complete and release escrow payout?');" class="btn-complete-action" title="Complete Visit" style="margin-left: 4px;">
                                            <i class="fa fa-check"></i> Complete
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="padding: 40px; text-align: center; color: #94a3b8;">
                                        <i class="fa fa-calendar-times-o" style="font-size: 36px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                        No patient appointments found matching the selected criteria.
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

<?php include ("assets/includes/footer.php"); ?>