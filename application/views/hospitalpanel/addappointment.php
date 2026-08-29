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

.opd-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.opd-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.opd-title-group h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.opd-title-group p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-back-link {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

/* Form Container Card */
.opd-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.opd-card-header {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 20px 26px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.opd-card-header h3 {
    font-size: 17px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.opd-badge {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.35);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    color: #ffffff;
}

.opd-card-body {
    padding: 28px;
}

.section-label-bar {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 24px 0 16px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-label-bar:first-of-type {
    margin-top: 0;
}

.section-label-bar i {
    color: #00a896;
}

.form-grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 18px;
    margin-bottom: 12px;
}

.form-grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 18px;
    margin-bottom: 12px;
}

.form-group-custom label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-group-custom label .req {
    color: #ef4444;
}

.form-group-custom .input-ctrl {
    width: 100%;
    height: 42px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-group-custom .input-ctrl:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.form-group-custom select.input-ctrl {
    cursor: pointer;
}

/* Doctor Live Preview Box */
.doc-preview-banner {
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.doc-preview-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.doc-avatar-img {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #00a896;
    background: #ffffff;
}

.doc-preview-name {
    font-weight: 800;
    color: #043d5b;
    font-size: 14.5px;
    margin: 0;
}

.doc-preview-sub {
    font-size: 12px;
    color: #64748b;
    margin: 2px 0 0 0;
}

.doc-fee-badge {
    background: #ffffff;
    border: 1px solid #00a896;
    color: #00a896;
    font-weight: 800;
    font-size: 13px;
    padding: 6px 14px;
    border-radius: 20px;
}

/* Submit Toolbar */
.form-submit-toolbar {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 14px;
}

.btn-book-submit {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 14px;
    padding: 12px 28px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);
    transition: all 0.15s ease;
}

.btn-book-submit:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.4);
}

.btn-book-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="opd-page-wrap">

        <!-- Flash Alert Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="opd-header">
            <div class="opd-title-group">
                <h1>Hospital OPD &amp; Walk-in Booking</h1>
                <p>Register on-spot patient appointments directly without SMS/OTP verification.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Appointments
                </a>
            </div>
        </div>

        <!-- OPD Form Card -->
        <div class="opd-form-card">
            <div class="opd-card-header">
                <h3><i class="fa fa-calendar-plus-o"></i> Patient OPD Registration Form</h3>
                <span class="opd-badge"><i class="fa fa-bolt"></i> Instant Walk-in (No OTP Required)</span>
            </div>

            <div class="opd-card-body">
                <form action="<?=base_url('hospitalpanel/addappointment');?>" method="POST" id="opdBookingForm">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                    <!-- Section 1: Doctor & Schedule -->
                    <div class="section-label-bar">
                        <i class="fa fa-user-md"></i> Step 1: Doctor &amp; Visit Timing
                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Attending Doctor -->
                        <div class="form-group-custom">
                            <label>Attending Doctor <span class="req">*</span></label>
                            <select name="doctor_id" id="doctorSelect" class="input-ctrl" required>
                                <option value="">-- Choose Affiliated Doctor --</option>
                                <?php if(!empty($doctors)): ?>
                                    <?php foreach($doctors as $doc): ?>
                                        <?php 
                                        $doc_fee = !empty($doc->practice_fee) ? $doc->practice_fee : 500;
                                        $doc_img = !empty($doc->drimage) ? admin_url()."public/assets/upload/".$doc->drimage : base_url()."assets/images/user.jpg";
                                        ?>
                                        <option value="<?=$doc->id;?>" data-fee="<?=$doc_fee;?>" data-img="<?=$doc_img;?>" data-name="<?=prefixdr($doc->fname).' '.$doc->lname;?>">
                                            <?=prefixdr($doc->fname).' '.$doc->lname;?> (₹<?=$doc_fee;?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Appointment Date -->
                        <div class="form-group-custom">
                            <label>Appointment Date <span class="req">*</span></label>
                            <input type="date" name="appointment_date" id="appointmentDate" class="input-ctrl" value="<?=date('Y-m-d');?>" required>
                        </div>

                        <!-- Time Slot / OPD Session -->
                        <div class="form-group-custom">
                            <label>Time Slot / OPD Session</label>
                            <select name="time_slot" id="timeSlotSelect" class="input-ctrl">
                                <option value="10:00 AM - 01:00 PM">Morning OPD (10:00 AM - 01:00 PM)</option>
                                <option value="02:00 PM - 05:00 PM">Afternoon OPD (02:00 PM - 05:00 PM)</option>
                                <option value="06:00 PM - 09:00 PM">Evening OPD (06:00 PM - 09:00 PM)</option>
                                <option value="Immediate Walk-in">Immediate Walk-in (Queue Now)</option>
                            </select>
                        </div>

                    </div>

                    <!-- Doctor Info Preview Box -->
                    <div class="doc-preview-banner" id="docPreviewBanner" style="display: none;">
                        <div class="doc-preview-left">
                            <img src="<?=base_url('assets/images/user.jpg');?>" id="docPreviewImg" class="doc-avatar-img" alt="Doctor">
                            <div>
                                <h4 class="doc-preview-name" id="docPreviewName">Dr. Name</h4>
                                <p class="doc-preview-sub">Affiliated Hospital Practitioner</p>
                            </div>
                        </div>
                        <div class="doc-fee-badge" id="docPreviewFee">
                            Consultation Fee: ₹500
                        </div>
                    </div>

                    <!-- Section 2: Patient Information -->
                    <div class="section-label-bar">
                        <i class="fa fa-id-card-o"></i> Step 2: Patient Information
                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Patient Full Name -->
                        <div class="form-group-custom">
                            <label>Patient Full Name <span class="req">*</span></label>
                            <input type="text" name="patient_name" id="patientName" class="input-ctrl" placeholder="e.g. Ramesh Kumar" required>
                        </div>

                        <!-- 10-Digit Mobile Number -->
                        <div class="form-group-custom">
                            <label>Mobile Number (No OTP Required) <span class="req">*</span></label>
                            <input type="tel" name="patient_mobile" id="patientMobile" class="input-ctrl" placeholder="10-digit mobile number" maxlength="10" pattern="[0-9]{10}" required>
                        </div>

                        <!-- Email (Optional) -->
                        <div class="form-group-custom">
                            <label>Email Address <small style="color: #94a3b8; font-weight: normal;">(Optional)</small></label>
                            <input type="email" name="patient_email" class="input-ctrl" placeholder="patient@example.com">
                        </div>

                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Gender -->
                        <div class="form-group-custom">
                            <label>Gender</label>
                            <select name="patient_gender" class="input-ctrl">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select>
                        </div>

                        <!-- Age -->
                        <div class="form-group-custom">
                            <label>Age (Years)</label>
                            <input type="number" name="patient_age" class="input-ctrl" placeholder="e.g. 34" min="1" max="120">
                        </div>

                        <!-- Visit Status -->
                        <div class="form-group-custom">
                            <label>Initial OPD Status</label>
                            <select name="appointment_status" class="input-ctrl">
                                <option value="0">In Queue (Waiting for Doctor)</option>
                                <option value="1">Completed (Consultation Done)</option>
                            </select>
                        </div>

                    </div>

                    <!-- Section 3: Billing & Payment -->
                    <div class="section-label-bar">
                        <i class="fa fa-credit-card"></i> Step 3: Consultation Fee &amp; Payment Details
                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Consultation Fee -->
                        <div class="form-group-custom">
                            <label>Consultation Fee (₹)</label>
                            <input type="number" name="fee" id="feeInput" class="input-ctrl" value="500" min="0" step="10">
                        </div>

                        <!-- Payment Mode -->
                        <div class="form-group-custom">
                            <label>Payment Method</label>
                            <select name="payment_mode" class="input-ctrl">
                                <option value="CASH">Cash at Counter</option>
                                <option value="UPI">UPI / QR Code</option>
                                <option value="CARD">Debit / Credit Card</option>
                                <option value="COUNTER">Pay Later / At Exit</option>
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div class="form-group-custom">
                            <label>Payment Collection Status</label>
                            <select name="payment_status" class="input-ctrl">
                                <option value="DONE">Paid (Fee Collected)</option>
                                <option value="UNPAID">Unpaid (Payment Pending)</option>
                            </select>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="form-submit-toolbar">
                        <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="btn-back-link">Cancel</a>
                        <button type="submit" id="btnBookSubmit" class="btn-book-submit">
                            <i class="fa fa-check-circle"></i> Confirm &amp; Create OPD Appointment
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
$(document).ready(function() {
    // 1. Doctor selection update
    $('#doctorSelect').on('change', function() {
        var selectedOpt = $(this).find('option:selected');
        var drId = $(this).val();
        
        if (drId) {
            var fee = selectedOpt.data('fee') || 500;
            var name = selectedOpt.data('name') || 'Doctor';
            var img = selectedOpt.data('img') || '<?=base_url('assets/images/user.jpg');?>';

            $('#docPreviewName').text(name);
            $('#docPreviewImg').attr('src', img);
            $('#docPreviewFee').text('Consultation Fee: ₹' + fee);
            $('#feeInput').val(fee);
            $('#docPreviewBanner').slideDown(200);

            // Fetch dynamic sessions if available
            var appDate = $('#appointmentDate').val();
            $.ajax({
                type: "GET",
                url: "<?=base_url('hospitalpanel/app_conf_pop_time');?>?doctor=" + drId + "&date=" + appDate,
                success: function(data) {
                    if (data && data.indexOf('<option') !== -1) {
                        $('#timeSlotSelect').html(data + "<option value='Immediate Walk-in'>Immediate Walk-in (Queue Now)</option>");
                    }
                }
            });
        } else {
            $('#docPreviewBanner').slideUp(200);
        }
    });

    // 2. Date change updates doctor slot timings
    $('#appointmentDate').on('change', function() {
        var drId = $('#doctorSelect').val();
        var appDate = $(this).val();
        if (drId && appDate) {
            $.ajax({
                type: "GET",
                url: "<?=base_url('hospitalpanel/app_conf_pop_time');?>?doctor=" + drId + "&date=" + appDate,
                success: function(data) {
                    if (data && data.indexOf('<option') !== -1) {
                        $('#timeSlotSelect').html(data + "<option value='Immediate Walk-in'>Immediate Walk-in (Queue Now)</option>");
                    }
                }
            });
        }
    });

    // 3. Form submission validation
    $('#opdBookingForm').on('submit', function(e) {
        var drId = $('#doctorSelect').val();
        var patName = $.trim($('#patientName').val());
        var patMobile = $.trim($('#patientMobile').val());

        if (!drId) {
            e.preventDefault();
            alert("Please choose an attending doctor.");
            $('#doctorSelect').focus();
            return false;
        }

        if (!patName) {
            e.preventDefault();
            alert("Please enter the patient full name.");
            $('#patientName').focus();
            return false;
        }

        if (!patMobile || patMobile.length !== 10 || isNaN(patMobile)) {
            e.preventDefault();
            alert("Please enter a valid 10-digit mobile number.");
            $('#patientMobile').focus();
            return false;
        }

        $('#btnBookSubmit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Booking OPD Appointment...');
    });
});
</script>