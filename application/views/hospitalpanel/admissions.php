<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.adm-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.adm-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.adm-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.adm-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-admit-trigger {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-admit-trigger:hover {
    background: #008f80;
    transform: translateY(-1px);
}

.adm-table-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-custom-clean {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom-clean thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-custom-clean tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.table-custom-clean tbody tr:hover td {
    background: #f8fafc;
}

.badge-admitted {
    background: #fee2e2;
    color: #991b1b;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-discharged {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.form-ctrl-modal {
    width: 100%;
    height: 40px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-ctrl-modal:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="adm-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="adm-header-card">
            <div>
                <h1><i class="fa fa-user-plus" style="color: #00a896; margin-right: 8px;"></i> Inpatient Admissions (IPD)</h1>
                <p>Admit patients, allocate beds, track running room charges, and manage discharge settlements.</p>
            </div>
            <div>
                <button type="button" class="btn-admit-trigger" onclick="$('#admitPatientModal').modal('show');">
                    <i class="fa fa-plus-circle"></i> New Patient Admission
                </button>
            </div>
        </div>

        <!-- Admissions Table Card -->
        <div class="adm-table-card">
            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th>IPD Number</th>
                            <th>Patient Information</th>
                            <th>Allocated Bed</th>
                            <th>Attending Doctor</th>
                            <th>Admission Date</th>
                            <th>Deposit &amp; Running Bill</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($admissions)): ?>
                            <?php foreach($admissions as $adm): ?>
                                <tr>
                                    <td style="font-weight: 800; color: #043d5b; font-family: monospace;">
                                        <?=html_escape($adm->admission_number);?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                            <?=html_escape($adm->patient_fname.' '.$adm->patient_lname);?>
                                        </div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            <i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape($adm->patient_mobile);?>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                            <i class="fa fa-bed"></i> Bed <?=html_escape($adm->bed_number);?> (<?=html_escape($adm->bed_type);?>)
                                        </span>
                                    </td>
                                    <td style="font-weight: 600; color: #334155;">
                                        <?=prefixdr($adm->dr_fname).' '.$adm->dr_lname;?>
                                    </td>
                                    <td style="color: #64748b; font-size: 12.5px;">
                                        <?=date('d M Y, h:i A', strtotime($adm->admission_date));?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #00a896; font-size: 13.5px;">
                                            ₹<?=number_format((float)$adm->current_running_bill, 2);?>
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b;">
                                            Deposit: ₹<?=number_format((float)$adm->deposit_amount, 2);?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($adm->status == 'ADMITTED'): ?>
                                            <span class="badge-admitted"><i class="fa fa-hospital-o"></i> ADMITTED</span>
                                        <?php else: ?>
                                            <span class="badge-discharged"><i class="fa fa-check-circle"></i> DISCHARGED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php if($adm->status == 'ADMITTED'): ?>
                                            <a href="<?=base_url('hospitalpanel/discharge_patient?adm_id='.$adm->id);?>" onclick="return confirm('Confirm discharge for this patient and free up the bed?');" class="btn-admit-trigger" style="background: #fee2e2; color: #dc2626 !important; font-size: 12px; padding: 6px 14px; box-shadow: none;">
                                                <i class="fa fa-sign-out"></i> Discharge &amp; Settle
                                            </a>
                                        <?php else: ?>
                                            <span style="font-size: 12px; color: #15803d; font-weight: 700;">
                                                Discharged <?=date('d M Y', strtotime($adm->discharge_date));?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-user-plus" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Active Inpatients</strong>
                                    <span>Click <strong>New Patient Admission</strong> to register a walk-in or referred admission.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal: Admit New Patient -->
<div class="modal fade" id="admitPatientModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #008f80 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9;">&times;</button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: 800; margin: 0; color: #ffffff;">
                    <i class="fa fa-user-plus" style="margin-right: 6px;"></i> Inpatient Admission Form (IPD)
                </h4>
            </div>
            <form action="<?=base_url('hospitalpanel/admit_patient');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="padding: 26px;">
                    <div class="row">
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Patient Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="form-ctrl-modal" name="patient_name" placeholder="Patient name" required>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Patient 10-Digit Mobile <span style="color: #ef4444;">*</span></label>
                            <input type="tel" maxlength="10" class="form-ctrl-modal" name="patient_mobile" placeholder="10-digit mobile" required>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Select Vacant Bed <span style="color: #ef4444;">*</span></label>
                            <select class="form-ctrl-modal" name="bed_id" required>
                                <option value="">-- Select Vacant Bed --</option>
                                <?php if(!empty($vacant_beds)): ?>
                                    <?php foreach ($vacant_beds as $vb): ?>
                                        <option value="<?=$vb->id;?>">Bed <?=$vb->bed_number;?> (<?=$vb->category;?>) - ₹<?=$vb->daily_charge;?>/day</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Attending Doctor <span style="color: #ef4444;">*</span></label>
                            <select class="form-ctrl-modal" name="doctor_id" required>
                                <option value="">-- Select Attending Doctor --</option>
                                <?php if(!empty($doctors)): ?>
                                    <?php foreach ($doctors as $doc): ?>
                                        <option value="<?=$doc->id;?>"><?=prefixdr($doc->fname).' '.$doc->lname;?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Admission Deposit Amount (₹)</label>
                            <input type="number" step="0.01" class="form-ctrl-modal" name="deposit_amount" placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Insurance / TPA Provider (Optional)</label>
                            <input type="text" class="form-ctrl-modal" name="insurance_tpa" placeholder="e.g. Star Health / MediAssist">
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 10px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Admission Reason &amp; Clinical Notes</label>
                            <textarea class="form-ctrl-modal" style="height: 70px; resize: vertical;" name="reason" placeholder="Primary diagnosis or clinical summary"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 18px;">Cancel</button>
                    <button type="submit" class="btn-admit-trigger" style="padding: 9px 24px;">Confirm Admission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
