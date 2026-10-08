<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<!-- Select2 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.profile-page-wrap {
    padding: 26px 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Stepper Progress Bar */
.stepper-wrap {
    display: flex;
    justify-content: space-between;
    margin-bottom: 24px;
    position: relative;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 16px 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    flex: 1;
}

.step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
    flex-shrink: 0;
}

.step-item.active .step-circle {
    background: var(--upchar-teal);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3);
}

.step-item.completed .step-circle {
    background: #dcfce7;
    color: #15803d;
}

.step-item.pending .step-circle {
    background: #f1f5f9;
    color: #94a3b8;
}

.step-label {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
}

.step-item.pending .step-label {
    color: #94a3b8;
}

.step-sub {
    font-size: 11px;
    color: #64748b;
    display: block;
}

.card-custom {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

.form-label-bold {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.form-control-modern {
    width: 100%;
    height: 44px;
    border-radius: 9px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-control-modern:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-primary-action {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 11px 26px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.22);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-primary-action:hover {
    background: var(--upchar-teal-dark);
}

/* Select2 Custom Skin */
.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--single {
    height: 44px !important;
    border: 1px solid var(--upchar-border, #e2e8f0) !important;
    border-radius: 9px !important;
    display: flex !important;
    align-items: center !important;
    padding: 0 12px !important;
}

.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: var(--upchar-teal) !important;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15) !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #1e293b !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    line-height: 42px !important;
    padding-left: 0 !important;
}

.select2-dropdown {
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
}

/* Responsive Media Queries */
@media screen and (max-width: 768px) {
    .profile-page-wrap {
        padding: 14px 12px;
    }
}
</style>

<div class="profile-page-wrap">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-certificate text-aqua" style="margin-right: 8px;"></i> Practitioner Verification Onboarding
                    </h1>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Step 2: Medical Council Registration &amp; Licensure Verification
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?=base_url('profile_step1');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-arrow-left"></i> Back to Step 1
                    </a>
                </div>
            </div>

            <!-- Multi-Step Roadmap Stepper Bar -->
            <div class="stepper-wrap hidden-xs">
                <!-- Step 1: Completed -->
                <div class="step-item completed">
                    <div class="step-circle"><i class="fa fa-check"></i></div>
                    <div>
                        <div class="step-label">Basic Profile</div>
                        <span class="step-sub">Completed</span>
                    </div>
                </div>
                <!-- Step 2: Active -->
                <div class="step-item active">
                    <div class="step-circle">2</div>
                    <div>
                        <div class="step-label">Medical Registration</div>
                        <span class="step-sub">Council Licensure</span>
                    </div>
                </div>
                <!-- Step 3: Pending -->
                <div class="step-item pending">
                    <div class="step-circle">3</div>
                    <div>
                        <div class="step-label">Qualifications</div>
                        <span class="step-sub">Degrees &amp; Colleges</span>
                    </div>
                </div>
                <!-- Step 4: Pending -->
                <div class="step-item pending">
                    <div class="step-circle">4</div>
                    <div>
                        <div class="step-label">Verification</div>
                        <span class="step-sub">Live Badge Activation</span>
                    </div>
                </div>
            </div>

            <!-- Server-Side Flash Alert (Fallback) -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Client-Side AJAX Alert Container -->
            <div id="step2AlertContainer" style="display: none; margin-bottom: 20px;"></div>

            <div class="row">
                <!-- Form Box -->
                <div class="col-md-8 col-xs-12">
                    <div class="card-custom">
                        <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                            <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                                <i class="fa fa-id-card-o text-aqua"></i> Step 2: Medical Council Registration
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Enter your official State Medical Council or National Medical Commission (NMC/MCI) license details.</p>
                        </div>

                        <div style="padding: 26px 24px;">
                            <form id="profileStep2Form" action="<?=base_url('doctorpanel/update_step2');?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf-token" value="<?=$this->security->get_csrf_hash();?>">
                                <input type="hidden" name="is_ajax" value="1">

                                <!-- Registration Number -->
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label class="form-label-bold">Medical Council Registration Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-certificate text-muted"></i></span>
                                        <input type="text" name="regno" id="regno" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="<?=htmlspecialchars(@$data->regd_no);?>" placeholder="e.g. 2018/04/1234 or DMC-54321" required>
                                    </div>
                                    <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                        Your registration number as listed on your State Medical Council certificate.
                                    </span>
                                </div>

                                <!-- Registration Council 2-Column Row -->
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-7 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">State Medical Council / Board *</label>
                                            <select class="form-control-modern" name="council" id="council_select" required>
                                                <option value="">-- Search &amp; Select Medical Council --</option>
                                                <?php
                                                $councillist = $this->db->order_by('name', 'ASC')->get_where('master_council', array('status'=>'1')); 
                                                foreach(@$councillist->result() as $list){
                                                ?>
                                                <option value="<?=$list->id;?>" <?=(@$data->regd_council == $list->id) ? 'selected' : '';?>>
                                                    <?=htmlspecialchars($list->name);?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-5 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Registration Year *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-calendar text-muted"></i></span>
                                                <select class="form-control-modern" name="year" id="year" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" required>
                                                    <option value="">-- Year --</option>
                                                    <?php 
                                                    $current_year = date('Y');
                                                    for($i = $current_year; $i >= 1960; $i--): 
                                                    ?>
                                                    <option value="<?=$i;?>" <?=(@$data->regd_year == $i) ? 'selected' : '';?>>
                                                        <?=$i;?>
                                                    </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trust Banner -->
                                <div style="background: #f0fdfa; border-radius: 10px; padding: 14px 16px; border: 1px solid #ccfbf1; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 12px;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #dcfce7; color: #15803d; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                                        <i class="fa fa-shield"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 700; color: #0f766e; margin-bottom: 2px;">Confidential Verification Protocol</div>
                                        <div style="font-size: 12px; color: #115e59; line-height: 1.45;">
                                            This registration is cross-referenced with official council registries to verify clinical qualifications and prevent license duplicity.
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                    <a href="<?=base_url('profile_step1');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                        <i class="fa fa-arrow-left"></i> Previous Step
                                    </a>
                                    <button type="submit" id="btnSaveStep2" name="submit" value="1" class="btn-primary-action">
                                        <span>Save &amp; Continue to Qualifications</span> <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Verified Credentials Compliance Sidebar -->
                <div class="col-md-4 col-xs-12">
                    <div class="card-custom" style="padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Why Verify Registration?</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                            Registration verification ensures that only accredited, licensed clinicians practice on Upchar. Verified doctors unlock:
                        </p>

                        <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 18px;">
                            <div style="display: flex; align-items: flex-start; gap: 10px; font-size: 12.5px; color: #334155;">
                                <i class="fa fa-check text-success" style="margin-top: 3px;"></i>
                                <span><strong>Blue "Verified" Badge:</strong> Builds patient trust and yields <strong>95% more views</strong>.</span>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 10px; font-size: 12.5px; color: #334155;">
                                <i class="fa fa-check text-success" style="margin-top: 3px;"></i>
                                <span><strong>Digital OPD Slots:</strong> Accept instant patient bookings across linked hospital chambers.</span>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 10px; font-size: 12.5px; color: #334155;">
                                <i class="fa fa-check text-success" style="margin-top: 3px;"></i>
                                <span><strong>EHR Prescriptions:</strong> Full legal compliance to generate tamper-proof digital Rx.</span>
                            </div>
                        </div>

                        <div style="background: #f8fafc; border-radius: 10px; padding: 12px 14px; border: 1px solid #e2e8f0; font-size: 11.5px; color: #475569;">
                            <i class="fa fa-lock text-muted"></i> Medical Council verification is private and safeguarded according to Indian Health Data Management policies.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<!-- Select2 JavaScript CDN & Interactive Controller -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // Initialize Select2 on Medical Council Dropdown
    if ($.fn.select2) {
        $('#council_select').select2({
            placeholder: "-- Search & Select Medical Council --",
            allowClear: false,
            width: '100%'
        });
    }

    // AJAX Submission Handler
    $('#profileStep2Form').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $btn = $('#btnSaveStep2');
        var $alert = $('#step2AlertContainer');

        // Reset previous validation error highlights
        $('.form-control-modern').css('border-color', '');
        $('.field-error-msg').remove();
        $alert.hide().empty();

        // Button loading state
        var originalBtnHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving Registration...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(originalBtnHtml);

                // Update CSRF token
                if (res.csrf_hash) {
                    $('.csrf-token').val(res.csrf_hash);
                }

                if (res.status === 'success') {
                    $alert.html(
                        '<div class="alert alert-success alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-check-circle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            res.message +
                            ' <span style="font-size: 12px; font-weight: normal; margin-left: 6px;">Proceeding to Step 3...</span>' +
                        '</div>'
                    ).slideDown(200);

                    // Transition to Step 3
                    setTimeout(function() {
                        window.location.href = res.next_step || '<?=base_url("profile_step3");?>';
                    }, 1100);
                } else {
                    var errMsg = res.message || 'Please correct the errors below and try again.';
                    $alert.html(
                        '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            errMsg +
                        '</div>'
                    ).slideDown(200);

                    if (res.errors) {
                        $.each(res.errors, function(field, errText) {
                            var $input = $('[name="' + field + '"]');
                            if ($input.length) {
                                $input.css('border-color', '#ef4444');
                                $input.closest('.form-group').append(
                                    '<div class="field-error-msg" style="color: #dc2626; font-size: 11.5px; margin-top: 4px; font-weight: 600;">' +
                                        errText +
                                    '</div>'
                                );
                            }
                        });
                    }

                    $('html, body').animate({
                        scrollTop: $alert.offset().top - 80
                    }, 300);
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(originalBtnHtml);
                $alert.html(
                    '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> A network error occurred while submitting. Please try again.' +
                    '</div>'
                ).slideDown(200);
            }
        });
    });

});
</script>