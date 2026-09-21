<?php include ('includes/header.php'); ?>

<style>
/* Modern Diagnostic Order Confirmation Styling */
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #028090;
    --upchar-teal-light: #f0fdfa;
    --upchar-navy: #0f172a;
    --upchar-slate: #475569;
    --upchar-border: #e2e8f0;
}

.order-success-wrapper {
    background: #f8fafc;
    min-height: 85vh;
    padding: 36px 0 80px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.order-hero-banner {
    background: linear-gradient(135deg, #028090 0%, #00a896 60%, #02c39a 100%);
    border-radius: 16px;
    padding: 36px 28px;
    color: #ffffff;
    text-align: center;
    box-shadow: 0 12px 30px -8px rgba(0, 168, 150, 0.35);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}

.order-hero-banner::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 380px;
    height: 380px;
    background: radial-gradient(circle, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.success-check-circle {
    width: 76px;
    height: 76px;
    background: #ffffff;
    color: #00a896;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    margin-bottom: 18px;
    animation: popIn 0.5s ease-out;
}

@keyframes popIn {
    0% { transform: scale(0.6); opacity: 0; }
    70% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}

/* 4-Step Milestone Progress Stepper */
.milestone-stepper-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.milestone-steps-grid {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 15px 0 5px;
}

.milestone-progress-line {
    position: absolute;
    top: 22px;
    left: 8%;
    right: 8%;
    height: 3px;
    background: #e2e8f0;
    z-index: 1;
}

.milestone-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00a896, #0284c7);
    transition: width 0.4s ease;
}

.milestone-step-item {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
    padding: 0 8px;
}

.milestone-step-bubble {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    margin: 0 auto 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    background: #ffffff;
    border: 3px solid #cbd5e1;
    color: #64748b;
    transition: all 0.3s ease;
}

.milestone-step-item.completed .milestone-step-bubble {
    background: #00a896;
    border-color: #00a896;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
}

.milestone-step-item.active .milestone-step-bubble {
    background: #ffffff;
    border-color: #0284c7;
    color: #0284c7;
    box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.15);
}

.milestone-step-title {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
}

.milestone-step-desc {
    font-size: 11px;
    color: #64748b;
    line-height: 1.3;
}

/* Printable Medical Receipt */
.receipt-paper-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 32px 36px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    position: relative;
}

.receipt-header-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 20px;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.receipt-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.receipt-info-item {
    font-size: 13px;
}
.receipt-info-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}
.receipt-info-value {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}

/* Action CTA Buttons */
.btn-action-primary {
    background: linear-gradient(135deg, #00a896, #028090);
    color: #ffffff !important;
    font-weight: 700;
    border-radius: 10px;
    padding: 12px 26px;
    border: none;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.btn-action-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 168, 150, 0.45);
    color: #ffffff;
}

.btn-action-secondary {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    color: #334155 !important;
    font-weight: 700;
    border-radius: 10px;
    padding: 12px 22px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.btn-action-secondary:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}

/* Print Specific Rules */
@media print {
    header, footer, .order-hero-banner, .milestone-stepper-card, .order-actions-container, #HeadMobile, .careplus-logo {
        display: none !important;
    }
    body, .order-success-wrapper {
        background: #ffffff !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .receipt-paper-card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
}
</style>

<div class="order-success-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-xs-12">
                
                <!-- SUCCESS HERO BANNER -->
                <div class="order-hero-banner">
                    <div class="success-check-circle">
                        <i class="fas fa-check"></i>
                    </div>
                    <h1 style="font-size: 28px; font-weight: 900; margin: 0 0 8px; letter-spacing: -0.5px;">
                        Pathology Test Booking Confirmed!
                    </h1>
                    <p style="font-size: 15px; opacity: 0.95; max-width: 650px; margin: 0 auto 18px; line-height: 1.5;">
                        Thank you, <strong><?=html_escape($booking->patient_name);?></strong>. Your sample collection order has been scheduled with 
                        <strong><?=html_escape($booking->lab_name ?: 'Upchar Accredited Partner Lab');?></strong>.
                    </p>
                    
                    <!-- Quick Reference Pill -->
                    <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); padding: 8px 18px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.35); font-size: 13.5px;">
                        <span>Booking ID: <strong style="color: #ffffff; font-family: monospace; letter-spacing: 0.5px; font-size: 15px;"><?=$reference_no;?></strong></span>
                        <span style="opacity: 0.6;">&bull;</span>
                        <span>Amount: <strong>₹<?=number_format($booking->total_amount, 2);?></strong></span>
                        <button type="button" onclick="navigator.clipboard.writeText('<?=$reference_no;?>'); alert('Booking ID copied to clipboard!');" style="background: transparent; border: none; color: #ffffff; padding: 0 4px; cursor: pointer;" title="Copy Booking Reference">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- 4-STEP LIVE MILESTONE TRACKER -->
                <?php
                    $stage = $booking->order_stage ?: 'BOOKED';
                    // Progress line width
                    $progressWidth = '12%';
                    if (in_array($stage, ['IN_TRANSIT', 'SAMPLE_COLLECTED'])) $progressWidth = '42%';
                    elseif (in_array($stage, ['RECEIVED_AT_LAB', 'PROCESSING'])) $progressWidth = '75%';
                    elseif (in_array($stage, ['REPORT_READY', 'COMPLETED'])) $progressWidth = '100%';
                ?>
                <div class="milestone-stepper-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 16px;">
                        <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-tasks text-primary" style="color: #00a896;"></i> Diagnostic Fulfillment Tracker
                        </h4>
                        <span class="badge" style="background: #e0f2fe; color: #0284c7; font-weight: 700; font-size: 11px; padding: 5px 10px;">
                            Current Stage: <?=$stage;?>
                        </span>
                    </div>

                    <div class="milestone-steps-grid">
                        <div class="milestone-progress-line">
                            <div class="milestone-progress-fill" style="width: <?=$progressWidth;?>;"></div>
                        </div>

                        <!-- Step 1: Confirmed -->
                        <div class="milestone-step-item completed">
                            <div class="milestone-step-bubble">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-step-title">Order Confirmed</div>
                            <div class="milestone-step-desc"><?=date('d M, h:i A', strtotime($booking->book_date));?></div>
                        </div>

                        <!-- Step 2: Collection -->
                        <div class="milestone-step-item <?=in_array($stage, ['IN_TRANSIT', 'SAMPLE_COLLECTED', 'RECEIVED_AT_LAB', 'PROCESSING', 'REPORT_READY', 'COMPLETED']) ? 'completed' : 'active';?>">
                            <div class="milestone-step-bubble">
                                <i class="fas fa-user-nurse"></i>
                            </div>
                            <div class="milestone-step-title">Sample Collection</div>
                            <div class="milestone-step-desc">
                                <?php if(!empty($collector)): ?>
                                    <?=$collector->name;?> <?=$collector->surname;?>
                                <?php else: ?>
                                    <?=$booking->time_slot ?: 'Home Pickup';?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Step 3: Testing -->
                        <div class="milestone-step-item <?=in_array($stage, ['RECEIVED_AT_LAB', 'PROCESSING', 'REPORT_READY', 'COMPLETED']) ? 'completed' : '';?>">
                            <div class="milestone-step-bubble">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <div class="milestone-step-title">Lab Processing</div>
                            <div class="milestone-step-desc"><?=html_escape($booking->lab_name ?: 'Diagnostic Lab');?></div>
                        </div>

                        <!-- Step 4: Report -->
                        <div class="milestone-step-item <?=in_array($stage, ['REPORT_READY', 'COMPLETED']) ? 'completed' : '';?>">
                            <div class="milestone-step-bubble">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <div class="milestone-step-title">Smart Report</div>
                            <div class="milestone-step-desc">
                                <?=in_array($stage, ['REPORT_READY', 'COMPLETED']) ? 'Ready to Download' : 'SLA: 6-12 Hrs';?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OFFICIAL MEDICAL RECEIPT CARD -->
                <div class="receipt-paper-card" id="printReceiptArea">
                    
                    <div class="receipt-header-row">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                <img src="<?=base_url('images/Final_logo23.png');?>" alt="Upchar" style="height: 32px; max-width: 130px; object-fit: contain;">
                                <span style="background: #00a896; color: #ffffff; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">Diagnostics</span>
                            </div>
                            <p style="font-size: 12px; color: #64748b; margin: 0;">Official Diagnostic Booking &amp; Specimen Intake Receipt</p>
                        </div>

                        <div style="text-align: right;">
                            <div style="font-family: monospace; font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: 1px;">
                                <i class="fas fa-barcode"></i> <?=$reference_no;?>
                            </div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                Generated: <?=date('d M Y, h:i A', strtotime($booking->book_date));?>
                            </div>
                        </div>
                    </div>

                    <!-- 2-Column Metadata Grid -->
                    <div class="receipt-info-grid">
                        <!-- Patient Info -->
                        <div class="receipt-info-item">
                            <div class="receipt-info-label">Patient Details</div>
                            <div class="receipt-info-value"><?=html_escape($booking->patient_name);?></div>
                            <div style="color: #64748b; font-size: 12px; margin-top: 2px;">
                                <?=html_escape($booking->patient_gender);?>, <?=html_escape($booking->patient_age);?> Yrs &bull; <?=html_escape($booking->patient_mobile);?>
                            </div>
                        </div>

                        <!-- Scheduled Collection -->
                        <div class="receipt-info-item">
                            <div class="receipt-info-label">Collection Window</div>
                            <div class="receipt-info-value"><?=date('d M Y', strtotime($booking->book_date));?></div>
                            <div style="color: #0284c7; font-size: 12px; font-weight: 600; margin-top: 2px;">
                                <i class="far fa-clock"></i> <?=html_escape($booking->time_slot ?: 'Morning Slot');?>
                            </div>
                        </div>

                        <!-- Accredited Partner Lab -->
                        <div class="receipt-info-item">
                            <div class="receipt-info-label">Assigned Pathology Lab</div>
                            <div class="receipt-info-value" style="color: #0f766e; display: flex; align-items: center; gap: 6px;">
                                <?=html_escape($booking->lab_name ?: 'City Partner Lab');?>
                                <?php if(!empty($booking->nabl_accredited)): ?>
                                    <span class="badge" style="background: #10b981; font-size: 9px;">NABL</span>
                                <?php endif; ?>
                            </div>
                            <div style="color: #64748b; font-size: 12px; margin-top: 2px;">
                                <?=html_escape($booking->lab_address ?: 'Accredited Center');?> 
                                <?php if(!empty($booking->lab_mobile)): ?>
                                    (Ph: <?=html_escape($booking->lab_mobile);?>)
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Payment & Protocol -->
                        <div class="receipt-info-item">
                            <div class="receipt-info-label">Payment Mode &amp; Status</div>
                            <div>
                                <?php if ($booking->payment_status === '1'): ?>
                                    <span style="color: #16a34a; font-weight: 800; font-size: 13.5px;"><i class="fas fa-check-circle"></i> Paid Online (<?=$booking->payment_mode;?>)</span>
                                <?php else: ?>
                                    <span style="color: #d97706; font-weight: 800; font-size: 13.5px;"><i class="fas fa-money-bill-wave"></i> Pay on Sample Collection (COD)</span>
                                <?php endif; ?>
                            </div>
                            <div style="color: #64748b; font-size: 11.5px; margin-top: 2px;">
                                Mode: <?=html_escape($booking->visit_type ?: 'Home Collection');?>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="receipt-info-item" style="grid-column: 1 / -1; border-top: 1px dashed #e2e8f0; padding-top: 12px;">
                            <div class="receipt-info-label">Sample Collection Address</div>
                            <div style="color: #1e293b; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-map-marker-alt text-danger" style="color: #ef4444; margin-right: 4px;"></i>
                                <?=html_escape($booking->patient_address ?: 'Direct Laboratory Walk-in Visit');?>
                            </div>
                        </div>
                    </div>

                    <!-- Test Items Breakdown Table -->
                    <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                        <table class="table table-hover" style="margin: 0; font-size: 13px;">
                            <thead>
                                <tr style="background: #f8fafc; color: #475569; font-size: 11.5px; font-weight: 700; text-transform: uppercase;">
                                    <th style="width: 40px; text-align: center;">#</th>
                                    <th>Diagnostic Test / Health Package</th>
                                    <th style="width: 160px;">Specimen Matrix</th>
                                    <th style="width: 130px; text-align: right;">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tests)): $i = 1; foreach ($tests as $t): ?>
                                    <tr>
                                        <td style="text-align: center; font-weight: 600; color: #64748b;"><?=$i++;?></td>
                                        <td>
                                            <strong style="color: #0f172a; font-size: 13.5px;"><?=html_escape($t->test_name);?></strong>
                                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                                <i class="fas fa-shield-alt text-success" style="color: #10b981;"></i> NABL &amp; ICMR Standard Protocols
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 600; font-size: 11px;">
                                                <i class="fas fa-tint text-danger" style="color: #ef4444;"></i> Whole Blood / Serum
                                            </span>
                                        </td>
                                        <td style="text-align: right; font-weight: 800; color: #00a896; font-size: 14px;">
                                            ₹<?=number_format($t->amount, 2);?>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                            <tfoot style="background: #fafafa; border-top: 2px solid #e2e8f0;">
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: 600; color: #64748b;">Home Sample Collection Fee:</td>
                                    <td style="text-align: right; color: #16a34a; font-weight: 800;">FREE</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-size: 15px; font-weight: 800; color: #0f172a;">Total Payable Amount:</td>
                                    <td style="text-align: right; font-size: 18px; font-weight: 900; color: #00a896;">₹<?=number_format($booking->total_amount, 2);?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Pre-Collection Preparation Advisory -->
                    <div style="background: #f0fdfa; border: 1.5px solid #ccfbf1; border-radius: 10px; padding: 18px 20px; font-size: 12.5px; color: #334155;">
                        <h5 style="font-size: 13.5px; font-weight: 800; color: #0f766e; margin: 0 0 8px 0; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-info-circle"></i> Specimen Collection &amp; Phlebotomist Advisory:
                        </h5>
                        <ul style="padding-left: 18px; margin: 0; line-height: 1.6;">
                            <li><strong>Phlebotomist Safety:</strong> Certified runner equipped with single-use sterile vacutainer tubes and alcohol swabs will visit at scheduled slot.</li>
                            <li><strong>Sample Verification:</strong> Cross-check the attached vial barcode and verify runner identity on home check-in.</li>
                            <li><strong>Digital Report Delivery:</strong> Pathologist-verified digital reports with QR authenticity will be accessible on your dashboard within 6-12 hours.</li>
                        </ul>
                    </div>

                </div>

                <!-- ACTION BUTTONS -->
                <div class="order-actions-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-top: 10px;">
                    
                    <div>
                        <button type="button" onclick="window.print()" class="btn-action-secondary">
                            <i class="fas fa-print"></i> Print Official Receipt
                        </button>
                    </div>

                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="<?=base_url('mytest');?>" class="btn-action-secondary">
                            <i class="fas fa-search"></i> Book Another Test
                        </a>
                        <a href="<?=base_url('manageappointment');?>" class="btn-action-primary">
                            <i class="fas fa-calendar-check"></i> Track in My Bookings &rarr;
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>
