<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
.rx-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 24px;
}
.rx-section-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 10px;
}
.rx-label {
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.rx-input {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    padding: 8px 12px;
    color: #1e293b;
    width: 100%;
}
.rx-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
.btn-add-med {
    background: #f0fdfa;
    color: #00a896;
    border: 1px solid #99f6e4;
    font-weight: 700;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 12.5px;
}
.btn-save-rx {
    background: #00a896;
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 32px;
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
}
.btn-save-rx:hover {
    background: #008f80;
    color: #ffffff;
}
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-stethoscope" style="color: #00a896; margin-right: 8px;"></i> Clinical SOAP Note &amp; E-Prescription
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Document consultation findings, write structured prescriptions, and issue verifiable digital records.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('doctorpanel/manageappointment');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa fa-arrow-left"></i> Back to Appointments
                    </a>
                </div>
            </div>

            <!-- Patient Summary Bar -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px 20px; margin-bottom: 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Patient Name</div>
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a;">
                        <?=html_escape($appointment->appointment_name);?>
                    </div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Contact Number</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155;">
                        <i class="fa fa-phone" style="color: #00a896;"></i> <?=html_escape($appointment->appointment_mobile);?>
                    </div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Appointment Slot</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155;">
                        <i class="fa fa-calendar" style="color: #00a896;"></i> <?=date('d M Y', strtotime($appointment->appointment_date));?> (<?=$appointment->from_timing;?> - <?=$appointment->to_timing;?>)
                    </div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Status</div>
                    <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 12px; padding: 4px 10px;">
                        Confirmed Booking #<?=$appointment->appointment_id;?>
                    </span>
                </div>
            </div>

            <!-- E-Prescription Form -->
            <form action="<?=base_url('doctorpanel/prescription/'.$appointment->appointment_id);?>" method="post">
                <input type="hidden" name="submit_prescription" value="1">
                
                <div class="row">
                    <!-- Left: SOAP Clinical Documentation -->
                    <div class="col-md-6 col-12">
                        <div class="rx-card">
                            <div class="rx-section-title">
                                <i class="fa fa-file-text-o" style="color: #00a896;"></i> 1. Subjective &amp; Objective Findings (SOAP)
                            </div>
                            
                            <div style="margin-bottom: 16px;">
                                <label class="rx-label">Subjective Symptoms &amp; Chief Complaint *</label>
                                <textarea class="rx-input" name="symptoms" rows="3" placeholder="e.g. Fever for 3 days with mild dry cough, throat irritation, loss of appetite" required><?=html_escape(@$existing_rx->symptoms_subjective);?></textarea>
                            </div>

                            <div style="margin-bottom: 16px;">
                                <label class="rx-label">Objective Examination &amp; Vitals</label>
                                <textarea class="rx-input" name="vitals" rows="2" placeholder="e.g. BP: 120/80 mmHg, Pulse: 78 bpm, Temp: 99.2 F, SpO2: 98%"><?=html_escape(@$existing_rx->examination_objective);?></textarea>
                            </div>

                            <div style="margin-bottom: 16px;">
                                <label class="rx-label">Clinical Assessment &amp; Diagnosis *</label>
                                <input type="text" class="rx-input" name="diagnosis" placeholder="e.g. Acute Upper Respiratory Tract Infection (URTI)" required value="<?=html_escape(@$existing_rx->diagnosis_assessment);?>">
                            </div>

                            <div>
                                <label class="rx-label">Care &amp; Lifestyle Instructions</label>
                                <textarea class="rx-input" name="treatment_plan" rows="3" placeholder="e.g. Adequate hydration, warm saline gargles, avoid cold beverages"><?=html_escape(@$existing_rx->treatment_plan);?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Structured Medications & Lab Tests -->
                    <div class="col-md-6 col-12">
                        <div class="rx-card">
                            <div class="rx-section-title" style="justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa fa-medkit" style="color: #00a896;"></i> 2. Prescribed Medications (Rx)
                                </div>
                                <button type="button" class="btn-add-med" id="btnAddMedRow">
                                    <i class="fa fa-plus"></i> Add Medicine
                                </button>
                            </div>

                            <div id="medicationsContainer">
                                <div class="med-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 10px;">
                                    <div class="row g-2">
                                        <div class="col-xs-6">
                                            <input type="text" class="rx-input" name="medications[0][name]" placeholder="Medicine / Generic Name" required>
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="rx-input" name="medications[0][dosage]" placeholder="Dosage (500mg)">
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="rx-input" name="medications[0][frequency]" placeholder="Freq (1-0-1)">
                                        </div>
                                        <div class="col-xs-6" style="margin-top: 6px;">
                                            <input type="text" class="rx-input" name="medications[0][instructions]" placeholder="Instructions (After meals)">
                                        </div>
                                        <div class="col-xs-6" style="margin-top: 6px;">
                                            <input type="text" class="rx-input" name="medications[0][duration]" placeholder="Duration (5 Days)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 20px;">
                                <div class="rx-section-title">
                                    <i class="fa fa-flask" style="color: #00a896;"></i> Recommended Diagnostic Tests
                                </div>
                                <input type="text" class="rx-input" name="lab_tests[]" placeholder="e.g. Complete Blood Count (CBC), Serum Ferritin">
                            </div>

                            <div style="margin-top: 16px;">
                                <label class="rx-label">Follow-up Consultation Date</label>
                                <input type="date" class="rx-input" name="followup_date" value="<?=html_escape(@$existing_rx->followup_date);?>">
                            </div>
                        </div>

                        <!-- Form Submit Actions -->
                        <div style="text-align: right; margin-bottom: 30px;">
                            <button type="submit" class="btn-save-rx">
                                <i class="fa fa-check-circle" style="margin-right: 6px;"></i> Issue E-Prescription &amp; Complete Visit
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
var medIndex = 1;
document.getElementById('btnAddMedRow').addEventListener('click', function() {
    var container = document.getElementById('medicationsContainer');
    var div = document.createElement('div');
    div.className = 'med-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 10px; position: relative;';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove();" style="position: absolute; right: 6px; top: 6px; border: none; background: transparent; color: #ef4444; font-size: 14px; cursor: pointer;">&times;</button>
        <div class="row g-2">
            <div class="col-xs-6">
                <input type="text" class="rx-input" name="medications[${medIndex}][name]" placeholder="Medicine / Generic Name" required>
            </div>
            <div class="col-xs-3">
                <input type="text" class="rx-input" name="medications[${medIndex}][dosage]" placeholder="Dosage (e.g. 500mg)">
            </div>
            <div class="col-xs-3">
                <input type="text" class="rx-input" name="medications[${medIndex}][frequency]" placeholder="Freq (1-0-1)">
            </div>
            <div class="col-xs-6" style="margin-top: 6px;">
                <input type="text" class="rx-input" name="medications[${medIndex}][instructions]" placeholder="Instructions (After meals)">
            </div>
            <div class="col-xs-6" style="margin-top: 6px;">
                <input type="text" class="rx-input" name="medications[${medIndex}][duration]" placeholder="Duration (5 Days)">
            </div>
        </div>
    `;
    container.appendChild(div);
    medIndex++;
});
</script>
