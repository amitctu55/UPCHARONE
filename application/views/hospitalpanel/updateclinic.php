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

.profile-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.profile-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.profile-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.profile-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

/* Tab Navigation */
.profile-nav-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 12px;
}

.profile-nav-tab {
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none !important;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.15s ease;
}

.profile-nav-tab:hover {
    color: #00a896;
    background: #f0fdfa;
    border-color: #ccfbf1;
}

.profile-nav-tab.active {
    background: #00a896;
    color: #ffffff;
    border-color: #008f80;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
}

/* Form Card */
.profile-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.form-card-header {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
}

.form-card-header h3 {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-card-body {
    padding: 28px;
}

.form-grid-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 32px;
}

@media (max-width: 991px) {
    .form-grid-layout {
        grid-template-columns: 1fr;
    }
}

.form-group-custom {
    margin-bottom: 20px;
}

.form-group-custom label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-group-custom .form-control-custom {
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

.form-group-custom .form-control-custom:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.help-info-panel {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 20px;
}

.help-info-panel h4 {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
}

.help-info-panel p {
    font-size: 13px;
    color: #64748b;
    line-height: 1.6;
    margin: 0 0 14px 0;
}

.btn-submit-save {
    background: #00a896;
    color: #ffffff;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 24px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-submit-save:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="profile-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Header -->
        <div class="profile-header-card">
            <h1><i class="fa fa-hospital-o" style="color: #00a896; margin-right: 8px;"></i> Hospital Profile &amp; Practice Setup</h1>
            <p>Update hospital registration, city location, operating hours, and medical compliance proofs.</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="profile-nav-tabs">
            <a href="<?=base_url('hospitalpanel/updateprofile');?>" class="profile-nav-tab active">
                <i class="fa fa-info-circle"></i> Basic Details
            </a>
            <a href="<?=base_url('hospitalpanel/profile_clinicproof');?>" class="profile-nav-tab">
                <i class="fa fa-file-text-o"></i> Registration Proof
            </a>
            <a href="<?=base_url('hospitalpanel/profile_disppic');?>" class="profile-nav-tab">
                <i class="fa fa-picture-o"></i> Hospital Logo / Photo
            </a>
            <a href="<?=base_url('hospitalpanel/profile_maplocation');?>" class="profile-nav-tab">
                <i class="fa fa-map-marker"></i> Map &amp; Geo Location
            </a>
            <a href="<?=base_url('hospitalpanel/profile_clinic_timing');?>" class="profile-nav-tab">
                <i class="fa fa-clock-o"></i> Operating Timings
            </a>
        </div>

        <!-- Form Card -->
        <div class="profile-form-card">
            <div class="form-card-header">
                <h3><i class="fa fa-building"></i> Hospital General Information</h3>
            </div>

            <div class="form-card-body">
                <form action="" method="post">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    
                    <div class="form-grid-layout">
                        <div>
                            <!-- Hospital Name -->
                            <div class="form-group-custom">
                                <label>Hospital / Clinic Name <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="clinicname" class="form-control-custom" placeholder="e.g. Apollo Super Specialty Hospital" value="<?=@$data->name;?>" required>
                            </div>

                            <!-- City -->
                            <div class="form-group-custom">
                                <label>City <span style="color: #ef4444;">*</span></label>
                                <select class="form-control-custom getlocality" name="cliniccity" required>
                                    <option value="">-- Select City --</option>
                                    <?php
                                    $citylist = $this->db->order_by('name')->get_where('master_city', array('status' => '1'));
                                    foreach(@$citylist->result() as $list):
                                    ?>
                                        <option value="<?=$list->id;?>" <?php if(isset($data->city) && $list->id == $data->city){echo 'selected';}?>><?=$list->name;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Locality -->
                            <div class="form-group-custom">
                                <label>Locality / Area</label>
                                <select class="form-control-custom setlocality" name="cliniclocality">
                                    <option value="">-- Select Locality --</option>
                                    <?php
                                    if(isset($data->city) && !empty($data->city)):
                                        $loclist = $this->db->order_by('name')->get_where('master_locality', array('status' => '1', 'city_id' => $data->city));
                                        foreach(@$loclist->result() as $list):
                                    ?>
                                        <option value="<?=$list->id;?>" <?php if(isset($data->location) && $list->id == $data->location){echo 'selected';}?>><?=$list->name;?></option>
                                    <?php 
                                        endforeach;
                                    endif; 
                                    ?>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div style="margin-top: 24px;">
                                <button type="submit" name="submit" class="btn-submit-save">
                                    <i class="fa fa-save"></i> Save &amp; Continue
                                </button>
                            </div>
                        </div>

                        <!-- Sidebar Tips -->
                        <div>
                            <div class="help-info-panel">
                                <h4><i class="fa fa-lightbulb-o" style="color: #f59e0b;"></i> Profile Tip</h4>
                                <p>Keeping your facility name, city, and locality accurate allows patients to find your hospital during localized medical searches and book OPD consultations.</p>
                                
                                <div style="font-size: 12.5px; color: #475569; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa fa-check-circle" style="color: #00a896;"></i> Verified Upchar Partner
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
$('.getlocality').change(function(){
    var city = $(this).val();
    if(city != '' && city != undefined){
        $.ajax({ 
            type: 'POST', 
            url: '<?=base_url();?>home/getlocalitydd', 
            data: { city: city }, 
            success: function (data) { 
                $('.setlocality').html(data);
            }
        });
    }
});
</script>