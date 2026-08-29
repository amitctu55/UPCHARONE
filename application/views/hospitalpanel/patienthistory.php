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

.patient-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header Banner Card */
.patient-header-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px 26px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.patient-header-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.patient-avatar-box {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: #ccfbf1;
    color: #0f766e;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 800;
    border: 3px solid #99f6e4;
    overflow: hidden;
}

.patient-avatar-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.patient-header-info h1 {
    font-size: 22px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 4px 0;
}

.patient-meta-tags {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    font-size: 13px;
    color: #64748b;
}

.meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f1f5f9;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 12px;
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

/* 2-Column Grid */
.patient-content-grid {
    display: grid;
    grid-template-columns: 1.6fr 1.2fr;
    gap: 24px;
}

@media (max-width: 991px) {
    .patient-content-grid {
        grid-template-columns: 1fr;
    }
}

/* Card Sections */
.detail-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 24px;
}

.detail-card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-card-header h3 {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-card-body {
    padding: 22px;
}

/* Key Value List */
.kv-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.kv-item {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 8px;
    padding: 12px 14px;
}

.kv-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.kv-val {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}

/* Doctor Block */
.doc-consult-box {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 16px;
}

.doc-consult-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #00a896;
    background: #ffffff;
}

/* Form Controls */
.form-group-field {
    margin-bottom: 18px;
}

.form-group-field label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-ctrl-cstm {
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

.form-ctrl-cstm:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-update-encounter {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 14px;
    width: 100%;
    height: 44px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
    transition: all 0.15s ease;
}

.btn-update-encounter:hover {
    background: #008f80;
    transform: translateY(-1px);
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="patient-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Patient Header Card -->
        <div class="patient-header-card">
            <div class="patient-header-left">
                <div class="patient-avatar-box">
                    <?php if(!empty($p->u_image)): ?>
                        <img src="<?=admin_url('public/assets/upload/'.$p->u_image);?>" alt="Patient">
                    <?php else: ?>
                        <?=strtoupper(substr(!empty($p->appointment_name) ? $p->appointment_name : 'P', 0, 1));?>
                    <?php endif; ?>
                </div>
                <div class="patient-header-info">
                    <h1><?=!empty($p->appointment_name) ? html_escape($p->appointment_name) : 'Patient Record';?></h1>
                    <div class="patient-meta-tags">
                        <?php if(!empty($p->appointment_mobile)): ?>
                            <span class="meta-pill"><i class="fa fa-phone" style="color: #00a896;"></i> <?=$p->appointment_mobile;?></span>
                        <?php endif; ?>
                        <?php if(!empty($p->u_email) || !empty($p->appointment_email)): ?>
                            <span class="meta-pill"><i class="fa fa-envelope-o"></i> <?=$p->appointment_email ?: $p->u_email;?></span>
                        <?php endif; ?>
                        <?php if(!empty($p->age)): ?>
                            <span class="meta-pill"><i class="fa fa-birthday-cake"></i> <?=$p->age;?> Years</span>
                        <?php endif; ?>
                        <?php if(!empty($p->GENDER) || !empty($p->u_gender)): ?>
                            <span class="meta-pill"><i class="fa fa-user"></i> <?=($p->u_gender == 'F' || $p->GENDER == 'F') ? 'Female' : 'Male';?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Appointments
                </a>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="patient-content-grid">
            
            <!-- Left Column: Encounter & Clinical Details -->
            <div>
                
                <!-- Clinical Consultation Details -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h3><i class="fa fa-stethoscope" style="color: #00a896;"></i> Consultation &amp; Doctor Schedule</h3>
                        <span style="font-weight: 800; color: #043d5b; font-family: monospace;">#<?=$p->appointment_id;?></span>
                    </div>

                    <div class="detail-card-body">
                        <!-- Attending Doctor Box -->
                        <div class="doc-consult-box">
                            <?php 
                            $dr_photo = !empty($p->drimage) ? admin_url('public/assets/upload/'.$p->drimage) : base_url('assets/images/user.jpg');
                            $dr_name = !empty($p->dr_fname) ? prefixdr($p->dr_fname).' '.$p->dr_lname : prefixdr($p->fname);
                            ?>
                            <img src="<?=$dr_photo;?>" class="doc-consult-avatar" alt="Doctor">
                            <div>
                                <h4 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 0 0 2px 0;">
                                    <?=$dr_name;?>
                                </h4>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                                    <?php if(!empty($p->dr_mobile)): ?>
                                        <i class="fa fa-phone"></i> <?=$p->dr_mobile;?> &nbsp;|&nbsp; 
                                    <?php endif; ?>
                                    Hospital Affiliated Specialist
                                </p>
                            </div>
                        </div>

                        <!-- Schedule Metrics -->
                        <div class="kv-grid">
                            <div class="kv-item">
                                <div class="kv-label">Appointment Date</div>
                                <div class="kv-val"><i class="fa fa-calendar" style="color: #00a896;"></i> <?=date('d M Y', strtotime($p->appointment_date));?></div>
                            </div>
                            <div class="kv-item">
                                <div class="kv-label">Time Slot / OPD Session</div>
                                <div class="kv-val"><i class="fa fa-clock-o" style="color: #00a896;"></i> <?=$p->from_timing ?: '10:00 AM';?> - <?=$p->to_timing ?: '01:00 PM';?></div>
                            </div>
                            <div class="kv-item">
                                <div class="kv-label">Consultation Fee</div>
                                <div class="kv-val" style="color: #00a896;">₹<?=number_format((float)($p->amount > 0 ? $p->amount : $p->fee), 2);?></div>
                            </div>
                            <div class="kv-item">
                                <div class="kv-label">Booking Timestamp</div>
                                <div class="kv-val"><?=date('d M Y, h:i A', strtotime($p->book_date ?: $p->appointment_date));?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Physical Vitals & Medical Info -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h3><i class="fa fa-heartbeat" style="color: #ef4444;"></i> Patient Vitals &amp; Profile Summary</h3>
                    </div>

                    <div class="detail-card-body">
                        <div class="kv-grid">
                            <div class="kv-item">
                                <div class="kv-label">Blood Group</div>
                                <div class="kv-val"><?=!empty($p->BGROUP) ? $p->BGROUP : 'Not Specified';?></div>
                            </div>
                            <div class="kv-item">
                                <div class="kv-label">Height</div>
                                <div class="kv-val"><?=!empty($p->HEIGHT) ? $p->HEIGHT.' cm' : 'Not Recorded';?></div>
                            </div>
                            <div class="kv-item">
                                <div class="kv-label">Weight</div>
                                <div class="kv-val"><?=!empty($p->WEIGHT) ? $p->WEIGHT.' kg' : 'Not Recorded';?></div>
                            </div>
                            <div class="kv-item">
                                <div class="kv-label">Date of Birth</div>
                                <div class="kv-val"><?=!empty($p->DOB) ? $p->DOB : 'Not Recorded';?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Online Payment / Order Details (if any) -->
                <?php if(!empty($p->orderid) || !empty($p->billingaddress)): ?>
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <h3><i class="fa fa-credit-card" style="color: #0284c7;"></i> Online Checkout &amp; Billing Address</h3>
                        </div>

                        <div class="detail-card-body">
                            <div class="kv-grid">
                                <div class="kv-item">
                                    <div class="kv-label">Order Reference ID</div>
                                    <div class="kv-val" style="font-family: monospace;"><?=$p->orderid;?></div>
                                </div>
                                <div class="kv-item">
                                    <div class="kv-label">Payment Gateway Mode</div>
                                    <div class="kv-val"><?=$p->paymentmod ?: 'Online Gateway';?></div>
                                </div>
                                <div class="kv-item" style="grid-column: span 2;">
                                    <div class="kv-label">Billing Address</div>
                                    <div class="kv-val"><?=implode(', ', array_filter(array($p->billingaddress, $p->billingcity, $p->billingstate, $p->billingzip, $p->billingcountry))) ?: 'Not Provided';?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right Column: Interactive Encounter & Billing Management Form -->
            <div>
                <div class="detail-card">
                    <div class="detail-card-header" style="background: linear-gradient(135deg, #043d5b 0%, #008f80 100%); color: #ffffff;">
                        <h3 style="color: #ffffff;"><i class="fa fa-sliders"></i> Manage Billing &amp; Visit Status</h3>
                    </div>

                    <div class="detail-card-body">
                        <form action="<?=base_url('hospitalpanel/patient/'.$p->appointment_id);?>" method="POST">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="aid" value="<?=$p->appointment_id;?>">

                            <!-- Consultation Fee -->
                            <div class="form-group-field">
                                <label>Consultation Fee (₹)</label>
                                <input type="number" step="10" name="fee" class="form-ctrl-cstm" value="<?=$p->fee;?>" required>
                            </div>

                            <!-- Payment Method -->
                            <div class="form-group-field">
                                <label>Payment Method</label>
                                <select name="payment_mode" class="form-ctrl-cstm">
                                    <option value="CASH" <?=$p->payment_mode == 'CASH' ? 'selected' : '';?>>Cash at Counter</option>
                                    <option value="UPI" <?=$p->payment_mode == 'UPI' ? 'selected' : '';?>>UPI / QR Code</option>
                                    <option value="CARD" <?=$p->payment_mode == 'CARD' ? 'selected' : '';?>>Debit / Credit Card</option>
                                    <option value="ONLINE" <?=$p->payment_mode == 'ONLINE' ? 'selected' : '';?>>Online Portal Payment</option>
                                    <option value="COUNTER" <?=$p->payment_mode == 'COUNTER' ? 'selected' : '';?>>Pay Later / At Exit</option>
                                </select>
                            </div>

                            <!-- Payment Collection Status -->
                            <div class="form-group-field">
                                <label>Payment Collection Status</label>
                                <select name="payment_status" class="form-ctrl-cstm">
                                    <option value="DONE" <?=$p->payment_status == 'DONE' ? 'selected' : '';?>>Paid (Fee Collected)</option>
                                    <option value="UNPAID" <?=$p->payment_status == 'UNPAID' || empty($p->payment_status) ? 'selected' : '';?>>Unpaid (Payment Pending)</option>
                                </select>
                            </div>

                            <!-- Visit Status -->
                            <div class="form-group-field">
                                <label>OPD Consultation Status</label>
                                <select name="appointment_status" class="form-ctrl-cstm">
                                    <option value="0" <?=$p->appointment_status == '0' ? 'selected' : '';?>>In Queue (Waiting for Doctor)</option>
                                    <option value="1" <?=$p->appointment_status == '1' ? 'selected' : '';?>>Completed (Consultation Done)</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div style="margin-top: 24px;">
                                <button type="submit" class="btn-update-encounter">
                                    <i class="fa fa-save"></i> Save &amp; Update Encounter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Help / Summary Panel -->
                <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 12px; padding: 18px 20px;">
                    <h4 style="font-size: 13.5px; font-weight: 800; color: #043d5b; margin: 0 0 6px 0;">
                        <i class="fa fa-shield" style="color: #00a896;"></i> Hospital Reception Tip
                    </h4>
                    <p style="font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0;">
                        Once the patient has met the physician, set the status to <strong>Completed</strong> and ensure the payment status is marked <strong>Paid</strong> to finalize the clinical ledger.
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>