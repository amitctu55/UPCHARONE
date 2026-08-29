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

.adddoc-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Page Header */
.adddoc-header-card {
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

.adddoc-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.adddoc-header-card p {
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

/* Main Form Card */
.adddoc-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.form-header-bar {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 20px 26px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.form-header-bar h3 {
    font-size: 17px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.auto-badge {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.35);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    color: #ffffff;
}

.form-body-pad {
    padding: 28px;
}

.section-label {
    font-size: 13.5px;
    font-weight: 800;
    color: #043d5b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 20px 0 16px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-label:first-of-type {
    margin-top: 0;
}

.form-grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 14px;
}

.form-grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 14px;
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

.form-ctrl {
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

.form-ctrl:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.form-ctrl[readonly] {
    background: #f8fafc;
    color: #475569;
    border-color: #e2e8f0;
}

select.form-ctrl[multiple] {
    height: 100px;
    padding: 8px;
}

/* Doctor Live Match Banner */
.doc-match-banner {
    background: #f0fdfa;
    border: 1px solid #99f6e4;
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
}

.doc-match-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.doc-match-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #00a896;
    background: #ffffff;
}

.doc-match-info h4 {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 2px 0;
}

.doc-match-info p {
    font-size: 12.5px;
    color: #0d9488;
    font-weight: 600;
    margin: 0;
}

/* Radio Group */
.gender-radio-group {
    display: flex;
    gap: 20px;
    align-items: center;
    height: 42px;
}

.gender-radio-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
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

.btn-link-submit {
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

.btn-link-submit:hover {
    background: #008f80;
    transform: translateY(-1px);
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="adddoc-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="adddoc-header-card">
            <div>
                <h1><i class="fa fa-user-md" style="color: #00a896; margin-right: 8px;"></i> Link &amp; Add Doctor</h1>
                <p>Lookup registered Upchar specialists by mobile/email or register a new practitioner for your hospital.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Doctor List
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="adddoc-form-card">
            <div class="form-header-bar">
                <h3><i class="fa fa-stethoscope"></i> Doctor Registration &amp; Affiliation Form</h3>
                <span class="auto-badge"><i class="fa fa-magic"></i> Auto-fills on Mobile / Email Lookup</span>
            </div>

            <div class="form-body-pad">
                <form action="<?=base_url('hospitalpanel/linkdoctor');?>" method="POST" id="addDoctorForm">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <input type="hidden" name="link" value="0" id="link">
                    <input type="hidden" name="link2" value="" id="link2">

                    <!-- Live Doctor Match Notification Banner (Initially Hidden) -->
                    <div class="doc-match-banner" id="docMatchBanner" style="display: none;">
                        <div class="doc-match-left">
                            <img src="<?=base_url('assets/images/user.jpg');?>" id="docMatchImg" class="doc-match-avatar" alt="Doctor">
                            <div class="doc-match-info">
                                <h4 id="docMatchName">Dr. Practitioner Name</h4>
                                <p><i class="fa fa-check-circle"></i> Registered Upchar Doctor Found! Details auto-filled below.</p>
                            </div>
                        </div>
                        <div>
                            <span style="background: #ffffff; color: #00a896; font-size: 12px; font-weight: 800; padding: 6px 14px; border-radius: 20px; border: 1px solid #00a896;">
                                <i class="fa fa-link"></i> Ready to Link
                            </span>
                        </div>
                    </div>

                    <!-- Step 1: Identification & Basic Info -->
                    <div class="section-label">
                        <i class="fa fa-id-card-o" style="color: #00a896;"></i> Step 1: Contact Lookup &amp; Personal Details
                    </div>

                    <div class="form-grid-2">
                        
                        <!-- Mobile -->
                        <div class="form-group-custom">
                            <label>Doctor Mobile Number <span class="req">*</span> <small style="color: #64748b; font-weight: normal;">(Lookup key)</small></label>
                            <input type="tel" id="mobile" name="mobile" class="form-ctrl" placeholder="10-digit mobile number" maxlength="10" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group-custom">
                            <label>Email Address <span class="req">*</span> <small style="color: #64748b; font-weight: normal;">(Lookup key)</small></label>
                            <input type="email" id="email" name="email" class="form-ctrl" placeholder="doctor@example.com" required>
                        </div>

                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Doctor Full Name -->
                        <div class="form-group-custom">
                            <label>Doctor Full Name <span class="req">*</span></label>
                            <input type="text" name="name" id="docNameInput" class="form-ctrl" placeholder="e.g. Dr. Rajesh Sharma" required>
                        </div>

                        <!-- Gender -->
                        <div class="form-group-custom">
                            <label>Gender</label>
                            <div class="gender-radio-group">
                                <label class="gender-radio-label">
                                    <input type="radio" name="gender" value="M" checked> Male
                                </label>
                                <label class="gender-radio-label">
                                    <input type="radio" name="gender" value="F"> Female
                                </label>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="form-group-custom">
                            <label>City <span class="req">*</span></label>
                            <select class="form-ctrl" id="city" name="city" required>
                                <option value="">-- Select City --</option>
                                <?php
                                $citylist = $this->db->order_by('name')->get_where('master_city', array('status' => '1'));
                                foreach(@$citylist->result() as $list):
                                ?>
                                    <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <!-- Step 2: Specialization & Medical Qualifications -->
                    <div class="section-label" style="margin-top: 24px;">
                        <i class="fa fa-graduation-cap" style="color: #00a896;"></i> Step 2: Specializations &amp; Medical Degrees
                    </div>

                    <div class="form-grid-2">
                        
                        <!-- Specialization -->
                        <div class="form-group-custom">
                            <label>Specialization(s) <span class="req">*</span> <small style="color: #64748b;">(Hold Ctrl to select multiple)</small></label>
                            <select class="form-ctrl" id="spl" name="specialisation[]" multiple required>
                                <?php
                                $spllist = $this->db->order_by('name')->get_where('master_specialization', array('status' => 1));
                                foreach(@$spllist->result() as $list):
                                ?>
                                    <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Degree -->
                        <div class="form-group-custom">
                            <label>Medical Degree(s) <span class="req">*</span> <small style="color: #64748b;">(Hold Ctrl to select multiple)</small></label>
                            <select class="form-ctrl" id="qual" name="qualification[]" multiple required>
                                <?php
                                $degreelist = $this->db->order_by('name')->get_where('master_degree', array('status' => 1));
                                foreach(@$degreelist->result() as $list):
                                ?>
                                    <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Medical College / Institute -->
                        <div class="form-group-custom">
                            <label>College / Institute <span class="req">*</span></label>
                            <input type="text" name="college" class="form-ctrl" placeholder="e.g. AIIMS / CMC" required>
                        </div>

                        <!-- Completion Year -->
                        <div class="form-group-custom">
                            <label>Year of Completion <span class="req">*</span></label>
                            <select class="form-ctrl" id="year" name="year" required>
                                <option value="">-- Select Year --</option>
                                <?php for($i = date('Y'); $i >= 1960; $i--): ?>
                                    <option value="<?=$i;?>"><?=$i;?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Years of Experience -->
                        <div class="form-group-custom">
                            <label>Years of Experience <span class="req">*</span></label>
                            <input type="number" name="exp" class="form-ctrl" placeholder="e.g. 10" min="0" max="60" required>
                        </div>

                    </div>

                    <!-- Step 3: Registration Council & License -->
                    <div class="section-label" style="margin-top: 24px;">
                        <i class="fa fa-certificate" style="color: #00a896;"></i> Step 3: Medical Council &amp; Registration
                    </div>

                    <div class="form-grid-3">
                        
                        <!-- Registration Number -->
                        <div class="form-group-custom">
                            <label>Medical Registration No. <span class="req">*</span></label>
                            <input type="text" name="regno" class="form-ctrl" placeholder="e.g. MCI-123456" required>
                        </div>

                        <!-- Registration Council -->
                        <div class="form-group-custom">
                            <label>State / National Medical Council <span class="req">*</span></label>
                            <select class="form-ctrl" id="council" name="council" required>
                                <option value="">-- Select Council --</option>
                                <?php
                                $councillist = $this->db->order_by('name')->get_where('master_council', array('status' => 1));
                                foreach(@$councillist->result() as $list):
                                ?>
                                    <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Registration Year -->
                        <div class="form-group-custom">
                            <label>Registration Year <span class="req">*</span></label>
                            <select class="form-ctrl" id="ryear" name="ryear" required>
                                <option value="">-- Select Year --</option>
                                <?php for($i = date('Y'); $i >= 1960; $i--): ?>
                                    <option value="<?=$i;?>"><?=$i;?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                    </div>

                    <!-- Submit Toolbar -->
                    <div class="form-submit-toolbar">
                        <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn-back-link">Cancel</a>
                        <button type="submit" name="submit" id="btnLinkSubmit" class="btn-link-submit">
                            <i class="fa fa-user-plus"></i> Link Doctor To Hospital
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
    $('body').on('blur', '#email, #mobile', function() {
        var value = $.trim($(this).val());
        if (value && value.length >= 5) {
            $.ajax({			
                type: "POST",			
                url: '<?=base_url();?>hospitalpanel/checkdoctor',			
                data: { key: value },	
                dataType: "text",			
                success: function(response) {			 
                    try {
                        response = JSON.parse(response);				
                        if (response.status === 'success' && response.data) {
                            $('#link').val('1');				
                            $('#link2').val(response.data.drid);				
                            $('input[name=email]').val(response.data.email).attr('readonly', true);				
                            $('input[name=mobile]').val(response.data.mobile).attr('readonly', true);				
                            $('input[name=name]').val(response.data.name).attr('readonly', true);				
                            $('input[name=college]').val(response.data.college).attr('readonly', true);				
                            $('input[name=exp]').val(response.data.exp).attr('readonly', true);				
                            $('input[name=regno]').val(response.data.regd_no).attr('readonly', true);				
                            
                            if (response.data.gender) {
                                $('input[name=gender][value=' + response.data.gender + ']').prop('checked', true);
                            }
                            
                            if (response.data.regd_council) {
                                $('#council').val(response.data.regd_council);
                            }
                            if (response.data.regd_year) {
                                $('#ryear').val(response.data.regd_year);
                            }
                            if (response.data.year) {
                                $('#year').val(response.data.year);
                            }
                            if (response.data.city) {
                                $('#city').val(response.data.city);
                            }
                            
                            if (response.data.specialization) {
                                $('#spl').val(response.data.specialization);
                            }
                            if (response.data.qualification) {
                                $('#qual').val(response.data.qualification);
                            }

                            // Show match banner
                            $('#docMatchName').text(response.data.name);
                            if (response.data.image) {
                                $('#docMatchImg').attr('src', response.data.image);
                            }
                            $('#docMatchBanner').slideDown(200);
                            $('#btnLinkSubmit').html('<i class="fa fa-link"></i> Confirm Link To Hospital');
                        } else {
                            $('#docMatchBanner').slideUp(200);
                            $('#link').val('0');
                            $('#link2').val('');
                            $('input, select').removeAttr('readonly');
                            $('#btnLinkSubmit').html('<i class="fa fa-user-plus"></i> Register &amp; Link Doctor');
                        }
                    } catch(e) {}
                }		
            });	
        }
    });
});
</script>