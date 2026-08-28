<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
.adm-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 20px;
}
.badge-status {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}
.badge-admitted { background: #fee2e2; color: #991b1b; }
.badge-discharged { background: #dcfce7; color: #15803d; }
.form-input-cstm {
    height: 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 8px 12px;
    font-size: 13px;
    width: 100%;
}
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-user-plus" style="color: #00a896; margin-right: 8px;"></i> Inpatient Admissions (IPD)
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Admit patients, track running room &amp; treatment bills, and process discharge settlements.
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" onclick="$('#admitPatientModal').modal('show');" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 9px 20px;">
                        <i class="fa fa-plus"></i> New Patient Admission
                    </button>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Admissions Table -->
            <div class="adm-card" style="padding: 0; overflow: hidden;">
                <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 0;">
                        <i class="fa fa-list" style="color: #00a896;"></i> Current &amp; Past Inpatient Records
                    </h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                                <th style="padding: 12px 16px;">IPD Number</th>
                                <th style="padding: 12px 16px;">Patient Name</th>
                                <th style="padding: 12px 16px;">Bed Allocated</th>
                                <th style="padding: 12px 16px;">Attending Doctor</th>
                                <th style="padding: 12px 16px;">Admission Date</th>
                                <th style="padding: 12px 16px;">Deposit / Running Bill</th>
                                <th style="padding: 12px 16px;">Status</th>
                                <th style="padding: 12px 16px; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admissions)): ?>
                                <?php foreach ($admissions as $adm): ?>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #0f172a; font-family: monospace;">
                                        <?=html_escape($adm->admission_number);?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <div style="font-weight: 700; color: #0f172a;">
                                            <?=html_escape($adm->patient_fname . ' ' . $adm->patient_lname);?>
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b;">
                                            <i class="fa fa-phone"></i> <?=html_escape($adm->patient_mobile);?>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 12px; padding: 4px 10px;">
                                            <i class="fa fa-bed"></i> Bed <?=html_escape($adm->bed_number);?> (<?=html_escape($adm->bed_type);?>)
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; color: #334155; font-weight: 600;">
                                        Dr. <?=html_escape($adm->dr_fname . ' ' . $adm->dr_lname);?>
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">
                                        <?=date('d M Y, h:i A', strtotime($adm->admission_date));?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <div style="font-weight: 700; color: #00a896;">
                                            ₹<?=number_format($adm->current_running_bill, 2);?>
                                        </div>
                                        <div style="font-size: 11px; color: #64748b;">
                                            Deposit: ₹<?=number_format($adm->deposit_amount, 2);?>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <?php if ($adm->status == 'ADMITTED'): ?>
                                            <span class="badge-status badge-admitted"><i class="fa fa-hospital-o"></i> ADMITTED</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-discharged"><i class="fa fa-check-circle"></i> DISCHARGED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right;">
                                        <?php if ($adm->status == 'ADMITTED'): ?>
                                            <a href="<?=base_url('hospitalpanel/discharge_patient?adm_id='.$adm->id);?>" onclick="return confirm('Confirm discharge for this patient and free up the bed?');" class="btn btn-xs btn-danger" style="font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                                                <i class="fa fa-sign-out"></i> Discharge &amp; Settle
                                            </a>
                                        <?php else: ?>
                                            <span style="font-size: 11.5px; color: #15803d; font-weight: 700;">
                                                Discharged on <?=date('d M Y', strtotime($adm->discharge_date));?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="padding: 30px; text-align: center; color: #64748b;">
                                        <i class="fa fa-user-plus" style="font-size: 24px; color: #cbd5e1; margin-bottom: 6px; display: block;"></i>
                                        No active inpatient admissions. Click <strong>New Patient Admission</strong> to check in a patient.
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

<!-- Modal: Admit New Patient -->
<div class="modal fade" id="admitPatientModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: #00a896; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9;">&times;</button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: 700; margin: 0;">
                    <i class="fa fa-user-plus" style="margin-right: 6px;"></i> Inpatient Admission Form (IPD)
                </h4>
            </div>
            <form action="<?=base_url('hospitalpanel/admit_patient');?>" method="post">
                <div class="modal-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Patient Full Name *</label>
                            <input type="text" class="form-input-cstm" name="patient_name" placeholder="Patient name" required>
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Patient 10-Digit Mobile *</label>
                            <input type="text" class="form-input-cstm" name="patient_mobile" placeholder="Mobile number" required>
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Select Available Bed *</label>
                            <select class="form-input-cstm" name="bed_id" required>
                                <option value="">-- Select Vacant Bed --</option>
                                <?php foreach ($vacant_beds as $vb): ?>
                                    <option value="<?=$vb->id;?>">Bed <?=$vb->bed_number;?> (<?=$vb->category;?>) - ₹<?=$vb->daily_charge;?>/day</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Attending Doctor *</label>
                            <select class="form-input-cstm" name="doctor_id" required>
                                <option value="">-- Select Attending Doctor --</option>
                                <?php foreach ($doctors as $doc): ?>
                                    <option value="<?=$doc->id;?>">Dr. <?=$doc->fname.' '.$doc->lname;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Admission Deposit Amount (INR)</label>
                            <input type="number" step="0.01" class="form-input-cstm" name="deposit_amount" placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Insurance / TPA Provider (Optional)</label>
                            <input type="text" class="form-input-cstm" name="insurance_tpa" placeholder="e.g. Star Health / ICICI Lombard">
                        </div>
                        <div class="col-md-6 col-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">TPA / Claim Reference No.</label>
                            <input type="text" class="form-input-cstm" name="claim_number" placeholder="Claim reference number">
                        </div>
                        <div class="col-12" style="margin-bottom: 10px;">
                            <label style="font-size: 12.5px; font-weight: 600; color: #334155;">Admission Reason &amp; Clinical Notes</label>
                            <textarea class="form-input-cstm" style="height: 70px; resize: vertical;" name="reason" placeholder="Primary diagnosis or reason for admission"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; padding: 9px 24px; font-weight: 700; border-radius: 8px;">Admit Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
