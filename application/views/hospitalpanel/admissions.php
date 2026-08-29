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
    font-size: 13.5px;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-admit-trigger:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
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
    font-size: 11px;
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
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* Admission Source Badges */
.badge-source {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 3px;
}

.source-hosp-amb { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.source-upchar-amb { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.source-self { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
.source-referral { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }

/* Modal Form Styles */
.form-ctrl-modal {
    width: 100%;
    height: 42px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-ctrl-modal:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.source-radio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 10px;
    margin-bottom: 18px;
}

.source-radio-tile {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    gap: 10px;
}

.source-radio-tile:hover {
    border-color: #00a896;
    background: #f0fdfa;
}

.source-radio-tile.selected {
    border-color: #00a896;
    background: #f0fdfa;
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.2);
}

.source-radio-tile input[type="radio"] {
    margin: 0;
    cursor: pointer;
}

.source-tile-text h5 {
    font-size: 12.5px;
    font-weight: 800;
    color: #043d5b;
    margin: 0;
}

.source-tile-text span {
    font-size: 11px;
    color: #64748b;
    display: block;
}

.dynamic-source-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 16px;
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
                <p>Register new inpatients arriving via Ambulance or Self-Arrival, allocate beds, and manage running hospital ledger.</p>
            </div>
            <div>
                <button type="button" class="btn-admit-trigger" onclick="$('#admitPatientModal').modal('show');">
                    <i class="fa fa-plus-circle"></i> New Patient Admission Form
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
                            <th>Arrival / Admission Mode</th>
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
                                    <!-- Admission # -->
                                    <td style="font-weight: 800; color: #043d5b; font-family: monospace;">
                                        <?=html_escape($adm->admission_number);?>
                                    </td>

                                    <!-- Patient Info -->
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                            <?=html_escape($adm->patient_fname.' '.$adm->patient_lname);?>
                                        </div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            <i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape($adm->patient_mobile);?>
                                        </div>
                                    </td>

                                    <!-- Arrival Source -->
                                    <td>
                                        <?php 
                                        $source = !empty($adm->admission_source) ? $adm->admission_source : 'SELF_ADMITTED';
                                        if ($source === 'HOSPITAL_AMBULANCE'):
                                        ?>
                                            <span class="badge-source source-hosp-amb">
                                                <i class="fa fa-ambulance"></i> Hospital Ambulance
                                            </span>
                                            <?php if(!empty($adm->ambulance_vehicle_no)): ?>
                                                <div style="font-size: 11px; color: #b45309; font-weight: 600; margin-top: 2px;">
                                                    <?=$adm->ambulance_vehicle_no;?>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($source === 'UPCHAR_AMBULANCE'): ?>
                                            <span class="badge-source source-upchar-amb">
                                                <i class="fa fa-ambulance"></i> Upchar 24/7 Ambulance
                                            </span>
                                            <?php if(!empty($adm->upchar_dispatch_id)): ?>
                                                <div style="font-size: 11px; color: #0369a1; font-weight: 600; margin-top: 2px;">
                                                    Ref: <?=$adm->upchar_dispatch_id;?>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($source === 'DOCTOR_REFERRAL'): ?>
                                            <span class="badge-source source-referral">
                                                <i class="fa fa-user-md"></i> Doctor Referral
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-source source-self">
                                                <i class="fa fa-male"></i> Self Admitted / Walk-in
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Bed Allocated -->
                                    <td>
                                        <span style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                            <i class="fa fa-bed"></i> <?=html_escape($adm->bed_type ?: 'General Bed');?>
                                        </span>
                                    </td>

                                    <!-- Attending Doctor -->
                                    <td style="font-weight: 600; color: #334155;">
                                        <?=prefixdr($adm->dr_fname).' '.$adm->dr_lname;?>
                                    </td>

                                    <!-- Date -->
                                    <td style="color: #64748b; font-size: 12.5px;">
                                        <?=date('d M Y, h:i A', strtotime($adm->admission_date));?>
                                    </td>

                                    <!-- Deposit & Bill -->
                                    <td>
                                        <div style="font-weight: 800; color: #00a896; font-size: 13.5px;">
                                            ₹<?=number_format((float)$adm->current_running_bill, 2);?>
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b;">
                                            Deposit: ₹<?=number_format((float)$adm->deposit_amount, 2);?>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <?php if($adm->status == 'ADMITTED'): ?>
                                            <span class="badge-admitted"><i class="fa fa-hospital-o"></i> ADMITTED</span>
                                        <?php else: ?>
                                            <span class="badge-discharged"><i class="fa fa-check-circle"></i> DISCHARGED</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Action -->
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
                                <td colspan="9" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-user-plus" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Active Inpatients</strong>
                                    <span>Click <strong>New Patient Admission Form</strong> to admit a patient arriving via Ambulance or Self-Arrival.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal: Admit New Patient (With 3-Way Ambulance & Arrival Modes) -->
<div class="modal fade" id="admitPatientModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #008f80 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9;">&times;</button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: 800; margin: 0; color: #ffffff;">
                    <i class="fa fa-ambulance" style="margin-right: 6px;"></i> Inpatient Admission Form (IPD)
                </h4>
            </div>
            
            <form action="<?=base_url('hospitalpanel/admit_patient');?>" method="post" id="ipdAdmissionForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                
                <div class="modal-body" style="padding: 26px;">
                    
                    <!-- Section 1: Arrival & Admission Mode Selection -->
                    <label style="font-size: 13px; font-weight: 800; color: #043d5b; display: block; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa fa-car" style="color: #00a896;"></i> 1. Patient Arrival &amp; Admission Mode <span style="color: #ef4444;">*</span>
                    </label>

                    <div class="source-radio-grid">
                        <!-- Option 1: Hospital Ambulance -->
                        <label class="source-radio-tile" onclick="selectAdmissionSource('HOSPITAL_AMBULANCE')">
                            <input type="radio" name="admission_source" value="HOSPITAL_AMBULANCE" id="src_hosp_amb">
                            <div class="source-tile-text">
                                <h5><i class="fa fa-ambulance" style="color: #d97706;"></i> Hospital Ambulance</h5>
                                <span>Hospital Emergency Fleet</span>
                            </div>
                        </label>

                        <!-- Option 2: Upchar Ambulance -->
                        <label class="source-radio-tile" onclick="selectAdmissionSource('UPCHAR_AMBULANCE')">
                            <input type="radio" name="admission_source" value="UPCHAR_AMBULANCE" id="src_upchar_amb">
                            <div class="source-tile-text">
                                <h5><i class="fa fa-ambulance" style="color: #0284c7;"></i> Upchar Ambulance</h5>
                                <span>24/7 Network Dispatch</span>
                            </div>
                        </label>

                        <!-- Option 3: Self-Admitted / Walk-in -->
                        <label class="source-radio-tile selected" onclick="selectAdmissionSource('SELF_ADMITTED')">
                            <input type="radio" name="admission_source" value="SELF_ADMITTED" id="src_self" checked>
                            <div class="source-tile-text">
                                <h5><i class="fa fa-male" style="color: #00a896;"></i> Self-Admitted</h5>
                                <span>Walk-in / Family Brought</span>
                            </div>
                        </label>

                        <!-- Option 4: Doctor Referral -->
                        <label class="source-radio-tile" onclick="selectAdmissionSource('DOCTOR_REFERRAL')">
                            <input type="radio" name="admission_source" value="DOCTOR_REFERRAL" id="src_referral">
                            <div class="source-tile-text">
                                <h5><i class="fa fa-user-md" style="color: #7c3aed;"></i> Doctor Referral</h5>
                                <span>Referred from Clinic</span>
                            </div>
                        </label>
                    </div>

                    <!-- Dynamic Details for Hospital Ambulance -->
                    <div class="dynamic-source-box" id="box_hospital_ambulance" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Ambulance Vehicle Number</label>
                                <input type="text" class="form-ctrl-modal" name="ambulance_vehicle_no" placeholder="e.g. UP-65-AB-1234">
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Driver / Paramedic Contact</label>
                                <input type="tel" class="form-ctrl-modal" name="emergency_driver_contact" placeholder="10-digit mobile number">
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Details for Upchar Ambulance -->
                    <div class="dynamic-source-box" id="box_upchar_ambulance" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Upchar Ambulance Booking / Dispatch Ref</label>
                                <input type="text" class="form-ctrl-modal" name="upchar_dispatch_id" placeholder="e.g. UPCHAR-AMB-8831">
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Paramedic / EMT In-charge</label>
                                <input type="text" class="form-ctrl-modal" placeholder="EMT Officer Name">
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Patient Demographics & Contact -->
                    <label style="font-size: 13px; font-weight: 800; color: #043d5b; display: block; margin: 16px 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa fa-id-card-o" style="color: #00a896;"></i> 2. Patient Identity &amp; Contact
                    </label>

                    <div class="row">
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Patient Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="form-ctrl-modal" name="patient_name" placeholder="Full patient name" required>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Patient 10-Digit Mobile <span style="color: #ef4444;">*</span></label>
                            <input type="tel" maxlength="10" class="form-ctrl-modal" name="patient_mobile" placeholder="10-digit mobile number" required>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Emergency Attendant / Guardian Name</label>
                            <input type="text" class="form-ctrl-modal" name="emergency_contact_person" placeholder="Attendant / Relative name">
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Emergency Attendant Phone</label>
                            <input type="tel" maxlength="10" class="form-ctrl-modal" name="emergency_contact_phone" placeholder="Emergency relative mobile">
                        </div>
                    </div>

                    <!-- Section 3: Bed & Clinical Allocation -->
                    <label style="font-size: 13px; font-weight: 800; color: #043d5b; display: block; margin: 16px 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa fa-bed" style="color: #00a896;"></i> 3. Bed Allocation &amp; Physician
                    </label>

                    <div class="row">
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Select Vacant Bed <span style="color: #ef4444;">*</span></label>
                            <select class="form-ctrl-modal" name="bed_id" required>
                                <option value="">-- Choose Inpatient Bed / Ward --</option>
                                <?php if(!empty($vacant_beds)): ?>
                                    <?php foreach ($vacant_beds as $vb): ?>
                                        <option value="<?=$vb->hospital_bed_id;?>">
                                            <?=html_escape($vb->bed_type);?> (Available: <?=max(0, (int)$vb->total_bed - (int)$vb->occupied_bed);?> / Total: <?=$vb->total_bed;?>) - ₹<?=number_format((float)$vb->amount, 2);?>/day
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Attending Specialist / Doctor <span style="color: #ef4444;">*</span></label>
                            <select class="form-ctrl-modal" name="doctor_id" required>
                                <option value="">-- Select Attending Doctor --</option>
                                <?php if(!empty($doctors)): ?>
                                    <?php foreach ($doctors as $doc): ?>
                                        <option value="<?=$doc->id;?>"><?=prefixdr($doc->fname).' '.$doc->lname;?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Initial Admission Deposit (₹)</label>
                            <input type="number" step="0.01" class="form-ctrl-modal" name="deposit_amount" placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Insurance / TPA Provider (Optional)</label>
                            <input type="text" class="form-ctrl-modal" name="insurance_tpa" placeholder="e.g. Star Health / ICICI Lombard">
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 8px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Admission Reason &amp; Clinical Notes</label>
                            <textarea class="form-ctrl-modal" style="height: 65px; resize: vertical;" name="reason" placeholder="Primary diagnosis, emergency symptoms, or clinical summary"></textarea>
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 18px;">Cancel</button>
                    <button type="submit" class="btn-admit-trigger" style="padding: 10px 26px;">
                        <i class="fa fa-check-circle"></i> Complete Inpatient Admission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function selectAdmissionSource(sourceVal) {
    $('.source-radio-tile').removeClass('selected');
    $('input[name="admission_source"][value="' + sourceVal + '"]').closest('.source-radio-tile').addClass('selected');
    $('input[name="admission_source"][value="' + sourceVal + '"]').prop('checked', true);

    if (sourceVal === 'HOSPITAL_AMBULANCE') {
        $('#box_hospital_ambulance').slideDown(200);
        $('#box_upchar_ambulance').slideUp(200);
    } else if (sourceVal === 'UPCHAR_AMBULANCE') {
        $('#box_upchar_ambulance').slideDown(200);
        $('#box_hospital_ambulance').slideUp(200);
    } else {
        $('#box_hospital_ambulance').slideUp(200);
        $('#box_upchar_ambulance').slideUp(200);
    }
}
</script>
