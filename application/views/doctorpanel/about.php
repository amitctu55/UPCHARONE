<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-teal-light: #e6f7f5;
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
    border-radius: 9px;
    border: 1px solid var(--upchar-border);
    padding: 12px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
    box-sizing: border-box;
    font-family: inherit;
    line-height: 1.5;
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
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.32);
    transform: translateY(-1px);
}

.btn-secondary-action {
    background: #ffffff;
    color: #475569 !important;
    font-weight: 600;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 11px 20px;
    border: 1px solid var(--upchar-border);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-secondary-action:hover {
    background: #f8fafc;
    color: #1e293b !important;
}

/* Character Count Badge */
.char-counter {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    background: #f1f5f9;
    padding: 3px 8px;
    border-radius: 12px;
}
.char-counter.warning {
    color: #b45309;
    background: #fef3c7;
}

/* Quick Snippet Chips */
.bio-chip {
    display: inline-block;
    padding: 4px 11px;
    border-radius: 14px;
    font-size: 11px;
    font-weight: 700;
    background: #f1f5f9;
    color: #334155;
    margin: 2px 4px 2px 0;
    cursor: pointer;
    border: 1px solid #e2e8f0;
    transition: all 0.15s;
    user-select: none;
}
.bio-chip:hover {
    background: var(--upchar-teal-light);
    color: var(--upchar-teal-dark);
    border-color: #b2ece5;
}

/* Preview Card */
.preview-patient-bio {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
</style>

<div class="profile-page-wrap">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 0;">

        <!-- Header Title Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 22px; gap: 14px;">
            <div>
                <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                    Doctor Biography &amp; Professional Summary
                </h1>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">
                    Introduce yourself to prospective patients. Highlighting your philosophy and areas of focus builds instant confidence.
                </p>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="<?=base_url('profile_step3');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                    <i class="fa fa-arrow-left"></i> Back to Step 3
                </a>
            </div>
        </div>

        <!-- 4-Step Roadmap Stepper Bar -->
        <div class="stepper-wrap hidden-xs">
            <!-- Step 1: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Basic Profile</div>
                    <span class="step-sub">Completed</span>
                </div>
            </div>
            <!-- Step 2: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Registration</div>
                    <span class="step-sub">License Verified</span>
                </div>
            </div>
            <!-- Step 3: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Qualifications</div>
                    <span class="step-sub">Degrees &amp; Alma Mater</span>
                </div>
            </div>
            <!-- Step 4: Active -->
            <div class="step-item active">
                <div class="step-circle">4</div>
                <div>
                    <div class="step-label">Doctor Bio</div>
                    <span class="step-sub">Clinical Summary</span>
                </div>
            </div>
        </div>

        <!-- Server-Side Flash Alert (Fallback) -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Client-Side AJAX Alert Container -->
        <div id="aboutAlertContainer" style="display: none; margin-bottom: 20px;"></div>

        <div class="row">
            <!-- Form Box (Left 8 Cols) -->
            <div class="col-md-8 col-xs-12">
                <div class="card-custom">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            <i class="fa fa-file-text-o" style="color: var(--upchar-teal); margin-right: 6px;"></i> Step 4: Professional Profile &amp; Bio
                        </h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">
                            Provide a concise headline for search listings, plus a comprehensive clinical biography for your full consultation profile.
                        </p>
                    </div>

                    <div style="padding: 26px 24px;">
                        <form id="profileAboutForm" action="<?=base_url('doctorpanel/update_about');?>" method="post">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf-token" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="is_ajax" value="1">

                            <!-- Section A: Short About You -->
                            <div class="form-group" style="margin-bottom: 24px;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                                    <label class="form-label-bold" style="margin-bottom: 0;">
                                        Short About you *
                                    </label>
                                    <span id="shortAboutCounter" class="char-counter">
                                        350 chars left
                                    </span>
                                </div>
                                <textarea name="short_about" id="short_about" rows="3" class="form-control-modern" maxlength="350" placeholder="e.g. Senior Consultant Physician with 12+ years of experience in managing chronic metabolic conditions, preventive lifestyle healthcare, and acute internal medicine." required><?=htmlspecialchars(@$data->short_about);?></textarea>
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                    This headline appears directly under your name on patient search results, appointment cards, and Google previews.
                                </span>
                            </div>

                            <!-- Section B: Detailed Biography & Doctor Background -->
                            <div class="form-group" style="margin-bottom: 26px;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                                    <label class="form-label-bold" style="margin-bottom: 0;">
                                        Detailed Biography &amp; doctor Background *
                                    </label>
                                    <span style="font-size: 11.5px; color: var(--upchar-teal); font-weight: 600;">
                                        Detailed Patient View
                                    </span>
                                </div>

                                <!-- Quick Snippet Starters -->
                                <div style="margin-bottom: 8px;">
                                    <span style="font-size: 11px; color: #64748b; font-weight: 600; margin-right: 6px;">Insert Heading:</span>
                                    <span class="bio-chip" onclick="insertBioSnippet('Special Interests:')">+ Special Interests</span>
                                    <span class="bio-chip" onclick="insertBioSnippet('Clinical Approach:')">+ Clinical Approach</span>
                                    <span class="bio-chip" onclick="insertBioSnippet('Memberships & Fellowships:')">+ Memberships</span>
                                    <span class="bio-chip" onclick="insertBioSnippet('Languages Spoken: English, Hindi')">+ Languages</span>
                                </div>

                                <textarea name="about" id="about_text" rows="8" class="form-control-modern" placeholder="Provide details about your medical journey, patient care philosophy, clinical specializations, fellowships, and hospital associations..." required><?=htmlspecialchars(@$data->about);?></textarea>
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                    A thorough biography helps patients feel comfortable and informed before booking consultations.
                                </span>
                            </div>

                            <!-- Trust Notice -->
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px 18px; margin-bottom: 26px; display: flex; gap: 14px; align-items: flex-start;">
                                <i class="fa fa-info-circle" style="font-size: 20px; color: #16a34a; margin-top: 2px;"></i>
                                <div style="font-size: 12.5px; color: #166534; line-height: 1.5;">
                                    <strong>Visibility Guarantee:</strong>
                                    Your biography is published to your live Upchar profile and public web portal immediately upon saving. You can edit or refine your biography at any time from your doctor dashboard settings.
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 18px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px;">
                                <a href="<?=base_url('profile_step3');?>" class="btn-secondary-action">
                                    <i class="fa fa-arrow-left"></i> Back to Step 3
                                </a>

                                <button type="submit" id="btnSaveAbout" class="btn-primary-action">
                                    <span>Save &amp; Continue to Profile Photo</span>
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information Cards (Right 4 Cols) -->
            <div class="col-md-4 col-xs-12">

                <!-- Live Doctor Profile Card Simulation -->
                <div class="preview-patient-bio" style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">
                            Live Card Preview
                        </span>
                        <span style="font-size: 11px; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 12px;">
                            <i class="fa fa-eye"></i> Patient View
                        </span>
                    </div>

                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div style="min-width: 0;">
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                                Dr. <?=htmlspecialchars($this->session->userdata('drusername') ?: (@$data->fname . ' ' . @$data->lname));?>
                            </h4>
                            <div style="font-size: 12px; color: var(--upchar-teal); font-weight: 700; margin-top: 2px;">
                                Verified Practitioner
                            </div>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 10px; padding: 12px 14px; font-size: 12px; color: #334155; line-height: 1.5; margin-bottom: 12px;">
                        <strong style="color: #0f172a; display: block; margin-bottom: 4px;">Short About you:</strong>
                        <span id="previewShortAbout" style="color: #475569;">
                            <?=(@$data->short_about ? htmlspecialchars(@$data->short_about) : 'Your headline will appear here as you type...');?>
                        </span>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 10px; font-size: 12px; color: #64748b;">
                        <strong style="color: #0f172a; display: block; margin-bottom: 4px;">Biography Snippet:</strong>
                        <div id="previewAbout" style="color: #475569; max-height: 120px; overflow-y: auto; font-size: 11.5px; line-height: 1.5;">
                            <?=(@$data->about ? nl2br(htmlspecialchars(substr(@$data->about, 0, 200))) . '...' : 'Complete biography will be formatted nicely for your patients.');?>
                        </div>
                    </div>
                </div>

                <!-- Writing Tips Card -->
                <div class="card-custom" style="padding: 22px;">
                    <div style="display: flex; gap: 12px; align-items: flex-start; margin-bottom: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                            <i class="fa fa-lightbulb-o"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">Writing a Great Bio</h4>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0;">Tips to boost consultation bookings</p>
                        </div>
                    </div>

                    <div style="font-size: 12px; color: #475569; line-height: 1.6;">
                        <div style="margin-bottom: 10px;">
                            <strong style="color: #0f172a;">1. Be Approachable:</strong> Use empathetic, patient-friendly language avoiding overly dense jargon.
                        </div>
                        <div style="margin-bottom: 10px;">
                            <strong style="color: #0f172a;">2. Mention Clinical Focus:</strong> Highlight conditions you treat most frequently.
                        </div>
                        <div>
                            <strong style="color: #0f172a;">3. Languages Spoken:</strong> Patients frequently filter by comfortable communication languages.
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
// Insert quick template snippets
function insertBioSnippet(text) {
    var textarea = document.getElementById('about_text');
    var val = textarea.value;
    var insert = (val.length > 0 ? "\n\n" : "") + text + "\n";
    textarea.value = val + insert;
    textarea.focus();
    $('#about_text').trigger('input');
}

$(document).ready(function() {

    // Character counter for short_about
    function updateCounter() {
        var len = $('#short_about').val().length;
        var remaining = 350 - len;
        var $badge = $('#shortAboutCounter');
        $badge.text(remaining + ' chars left');
        if (remaining < 30) {
            $badge.addClass('warning');
        } else {
            $badge.removeClass('warning');
        }

        var text = $('#short_about').val().trim();
        $('#previewShortAbout').text(text ? text : 'Your headline will appear here as you type...');
    }

    $('#short_about').on('input', updateCounter);
    updateCounter();

    // Live update for detailed biography preview
    $('#about_text').on('input', function() {
        var text = $(this).val().trim();
        if (text) {
            $('#previewAbout').text(text.length > 250 ? text.substring(0, 250) + '...' : text);
        } else {
            $('#previewAbout').text('Complete biography will be formatted nicely for your patients.');
        }
    });

    // AJAX Submission Handler
    $('#profileAboutForm').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $btn = $('#btnSaveAbout');
        var $alert = $('#aboutAlertContainer');

        // Reset previous validation
        $('.form-control-modern').css('border-color', '');
        $('.field-error-msg').remove();
        $alert.hide().empty();

        // Button loading state
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving Biography...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);

                if (res.csrf_hash) {
                    $('.csrf-token').val(res.csrf_hash);
                }

                if (res.status === 'success') {
                    $alert.html(
                        '<div class="alert alert-success alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-check-circle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            res.message +
                            ' <span style="font-size: 12px; font-weight: normal; margin-left: 6px;">Proceeding to Profile Photo...</span>' +
                        '</div>'
                    ).slideDown(200);

                    setTimeout(function() {
                        window.location.href = res.next_step || '<?=base_url("profile_drpic");?>';
                    }, 1100);
                } else {
                    var errMsg = res.message || 'Please correct the highlighted errors below and try again.';
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
                $btn.prop('disabled', false).html(origHtml);
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