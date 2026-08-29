<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Account Under Verification | Upchar Healthcare Platform</title>
    <link rel="shortcut icon" href="<?=base_url();?>images/favicon.png" type="image/png">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css">

    <style>
    :root {
        --upchar-teal: #00a896;
        --upchar-teal-dark: #008f80;
        --upchar-navy: #043d5b;
        --upchar-slate: #0f172a;
        --upchar-gray: #64748b;
        --upchar-amber: #f59e0b;
        --upchar-light: #f8fafc;
        --upchar-border: #e2e8f0;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f1f5f9;
        color: #1e293b;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .top-brand-bar {
        background: #ffffff;
        border-bottom: 1px solid var(--upchar-border);
        padding: 14px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand-logo {
        height: 38px;
        width: auto;
    }

    .btn-signout {
        background: #fee2e2;
        color: #dc2626 !important;
        font-weight: 700;
        font-size: 12.5px;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-signout:hover {
        background: #fecaca;
    }

    .pending-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 16px;
    }

    .pending-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--upchar-border);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        max-width: 680px;
        width: 100%;
        overflow: hidden;
    }

    .pending-card-header {
        background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
        padding: 30px 32px;
        text-align: center;
        color: #ffffff;
    }

    .shield-badge-icon {
        width: 68px;
        height: 68px;
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #fef08a;
        margin: 0 auto 16px auto;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .pending-card-header h2 {
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 6px 0;
        color: #ffffff;
    }

    .pending-card-header p {
        font-size: 13.5px;
        color: #e2e8f0;
        margin: 0;
    }

    .pending-card-body {
        padding: 32px;
    }

    .status-alert-box {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-left: 4px solid #f59e0b;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .status-alert-box i {
        color: #d97706;
        font-size: 18px;
        margin-top: 2px;
    }

    .status-alert-box strong {
        color: #92400e;
        font-size: 13.5px;
        display: block;
        margin-bottom: 2px;
    }

    .status-alert-box p {
        color: #b45309;
        font-size: 12.5px;
        margin: 0;
        line-height: 1.4;
    }

    .steps-timeline {
        position: relative;
        padding-left: 28px;
        margin-bottom: 28px;
    }

    .steps-timeline::before {
        content: '';
        position: absolute;
        top: 8px;
        bottom: 8px;
        left: 9px;
        width: 2px;
        background: #e2e8f0;
    }

    .step-item {
        position: relative;
        margin-bottom: 20px;
    }

    .step-item:last-child {
        margin-bottom: 0;
    }

    .step-dot {
        position: absolute;
        left: -28px;
        top: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #00a896;
        color: #00a896;
        font-size: 10px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .step-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .step-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
    }

    .action-button-strip {
        display: flex;
        gap: 12px;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-contact-support {
        background: #00a896;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 13.5px;
        padding: 10px 22px;
        border-radius: 8px;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
        transition: all 0.15s ease;
    }

    .btn-contact-support:hover {
        background: #008f80;
        transform: translateY(-1px);
    }
    </style>
</head>
<body>

    <!-- Top Brand Navbar -->
    <div class="top-brand-bar">
        <div style="display: flex; align-items: center; gap: 12px;">
            <img src="<?=base_url();?>images/logo.png" alt="Upchar Logo" class="brand-logo">
            <span style="font-weight: 800; color: #043d5b; font-size: 16px;">UPCHAR HEALTHCARE</span>
        </div>
        <div>
            <a href="<?=base_url('hospitalpanel/logout');?>" class="btn-signout">
                <i class="fa fa-sign-out"></i> Sign Out
            </a>
        </div>
    </div>

    <!-- Centered Card -->
    <div class="pending-wrapper">
        <div class="pending-card">
            
            <div class="pending-card-header">
                <div class="shield-badge-icon">
                    <i class="fa fa-shield"></i>
                </div>
                <h2>Account Verification Under Process</h2>
                <p>Facility: <strong><?=html_escape($hospital->name ?? 'Hospital / Clinic Account');?></strong></p>
            </div>

            <div class="pending-card-body">
                
                <div class="status-alert-box">
                    <i class="fa fa-clock-o"></i>
                    <div>
                        <strong>Verification Status: PENDING ACQUISITION REVIEW</strong>
                        <p>Your facility registration has been submitted and is currently being reviewed by the Upchar Acquisition &amp; Onboarding Team. Protected dashboard modules remain locked until approval.</p>
                    </div>
                </div>

                <!-- Step-by-Step Onboarding Timeline -->
                <div class="steps-timeline">
                    <div class="step-item">
                        <div class="step-dot">1</div>
                        <div class="step-title">Clinical &amp; Registration Document Review</div>
                        <div class="step-desc">Our onboarding compliance desk inspects clinical establishment licenses, doctor MCI registrations, and tax identification certificates.</div>
                    </div>

                    <div class="step-item">
                        <div class="step-dot">2</div>
                        <div class="step-title">Field Inspection &amp; Acquisition Call</div>
                        <div class="step-desc">An assigned Upchar Partner Success Manager will conduct a brief telephonic briefing or physical verification visit.</div>
                    </div>

                    <div class="step-item">
                        <div class="step-dot">3</div>
                        <div class="step-title">Full Dashboard &amp; Inpatient Module Activation</div>
                        <div class="step-desc">Upon approval (typically within 24 to 48 business hours), OPD appointments, Bed management, and revenue payouts will be instantly unlocked.</div>
                    </div>
                </div>

                <!-- Action Button Strip -->
                <div class="action-button-strip">
                    <a href="<?=base_url('hospitalpanel/support');?>" class="btn-contact-support">
                        <i class="fa fa-life-ring"></i> Contact Verification Helpdesk
                    </a>
                    
                    <a href="<?=base_url('hospitalpanel/logout');?>" style="color: #64748b; font-size: 13px; font-weight: 600; text-decoration: none;">
                        <i class="fa fa-power-off"></i> Exit to Login
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- Footer -->
    <div style="text-align: center; padding: 16px; font-size: 12px; color: #94a3b8;">
        &copy; <?=date('Y');?> Upchar Healthcare Network. All Rights Reserved. &bull; Partner Verification Desk: support@upchar.info
    </div>

</body>
</html>
