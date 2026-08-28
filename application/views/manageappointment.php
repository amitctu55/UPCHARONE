<!-- Patient Dashboard: Appointment History View -->
<div class="patient-topbar">
    <div>
        <h2 class="patient-topbar-title">Appointment History</h2>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13.5px;">
            Manage and review all your medical consultations, hospital visits, and diagnostic bookings.
        </p>
    </div>
    <div>
        <a href="<?=base_url();?>" class="btn" style="background: var(--upchar-teal); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 10px 20px; text-decoration: none; font-size: 13.5px; box-shadow: 0 2px 6px rgba(0,168,150,0.25);">
            <i class="fa fa-plus" style="margin-right: 6px;"></i> Book New Appointment
        </a>
    </div>
</div>

<style>
.appointment-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    margin-bottom: 20px;
    transition: all 0.2s ease;
    overflow: hidden;
}

.appointment-card:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
    border-color: var(--upchar-teal);
}

.appointment-card-header {
    background: #f8fafc;
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.appt-id-badge {
    font-size: 12px;
    font-weight: 800;
    color: var(--upchar-teal-dark);
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    padding: 4px 10px;
    border-radius: 20px;
}

.appt-date-text {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
}

.badge-payment-done {
    background: #d1fae5;
    color: #065f46;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

.badge-payment-unpaid {
    background: #fef3c7;
    color: #92400e;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

.badge-booking-confirmed {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

.appointment-card-body {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}

.info-block-label {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
    letter-spacing: 0.5px;
}

.info-block-value {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 6px;
}

.empty-history-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px dashed #cbd5e1;
    padding: 50px 20px;
    text-align: center;
    margin-top: 20px;
}
</style>

<!-- Main Appointments List Container -->
<div class="appointments-section">

    <!-- Check if appointments_data exists and is not empty -->
    <?php if (!empty($appointments_data)): ?>

        <?php foreach ($appointments_data as $p): ?>
            <?php
                $appt_id    = isset($p->appointment_id) ? $p->appointment_id : 'N/A';
                $appt_date  = !empty($p->appointment_date) ? date('d M Y', strtotime($p->appointment_date)) : 'Date N/A';
                $timing     = (!empty($p->from_timing) && !empty($p->to_timing)) ? html_escape($p->from_timing . ' - ' . $p->to_timing) : 'Scheduled';
                $patient    = isset($p->patient_name) && !empty($p->patient_name) ? $p->patient_name : 'Patient';
                $doctor     = isset($p->doctor_name) && !empty($p->doctor_name) ? $p->doctor_name : 'Medical Doctor';
                $institute  = isset($p->institute_name) && !empty($p->institute_name) ? $p->institute_name : 'Healthcare Center';
                $mobile     = isset($p->appointment_mobile) ? $p->appointment_mobile : 'N/A';
                $amount     = isset($p->amount) && $p->amount > 0 ? $p->amount : (isset($p->fee) ? $p->fee : 0);
                $pay_status = isset($p->payment_status) ? strtoupper($p->payment_status) : 'UNPAID';
                $status     = isset($p->status) ? $p->status : '1';
            ?>

            <div class="appointment-card">
                <div class="appointment-card-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="appt-id-badge">#<?=html_escape($appt_id);?></span>
                        <span class="appt-date-text">
                            <i class="fa fa-calendar" style="color: var(--upchar-teal); margin-right: 4px;"></i>
                            <?=$appt_date;?> &nbsp;|&nbsp; 
                            <i class="fa fa-clock-o" style="color: var(--upchar-teal); margin-right: 2px;"></i>
                            <?=$timing;?>
                        </span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span class="badge-booking-confirmed">
                            <i class="fa fa-check-circle"></i> Confirmed
                        </span>
                        <span class="<?=($pay_status == 'DONE' || $pay_status == 'PAID') ? 'badge-payment-done' : 'badge-payment-unpaid';?>">
                            <i class="fa fa-credit-card"></i> <?=($pay_status == 'DONE' || $pay_status == 'PAID') ? 'Paid' : 'Unpaid';?>
                        </span>
                    </div>
                </div>

                <div class="appointment-card-body">
                    <div>
                        <div class="info-block-label">Patient Name</div>
                        <div class="info-block-value">
                            <i class="fa fa-user" style="color: #64748b;"></i>
                            <?=html_escape($patient);?>
                        </div>
                    </div>

                    <div>
                        <div class="info-block-label">Consulting Doctor</div>
                        <div class="info-block-value">
                            <i class="fa fa-user-md" style="color: var(--upchar-teal);"></i>
                            <?=html_escape($doctor);?>
                        </div>
                    </div>

                    <div>
                        <div class="info-block-label">Hospital / Clinic</div>
                        <div class="info-block-value">
                            <i class="fa fa-hospital-o" style="color: #028072;"></i>
                            <?=html_escape($institute);?>
                        </div>
                    </div>

                    <div>
                        <div class="info-block-label">Contact &amp; Fee</div>
                        <div class="info-block-value">
                            <i class="fa fa-phone" style="color: #64748b;"></i>
                            <?=html_escape($mobile);?> &nbsp;|&nbsp;
                            <span style="color: #0f172a; font-weight: 800;">₹<?=html_escape($amount);?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>

        <!-- Graceful fallback UI when user has no appointments -->
        <div class="empty-history-box">
            <i class="fa fa-calendar-o" style="font-size: 48px; color: #cbd5e1; margin-bottom: 14px; display: block;"></i>
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">
                You do not have any appointment history yet
            </h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px 0;">
                Book your first doctor consultation or diagnostic checkup online with instant confirmation.
            </p>
            <a href="<?=base_url();?>" class="btn" style="background: var(--upchar-teal); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 10px 24px;">
                <i class="fa fa-stethoscope" style="margin-right: 6px;"></i> Book an Appointment
            </a>
        </div>

    <?php endif; ?>

</div>
