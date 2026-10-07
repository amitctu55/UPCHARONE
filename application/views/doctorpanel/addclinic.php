<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.clinic-page-wrap {
    padding: 26px 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card-custom {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

.card-header-custom {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-body-custom {
    padding: 26px 24px;
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

.facility-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 12.5px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-right: 8px;
    margin-bottom: 8px;
    user-select: none;
}

.facility-chip input {
    margin: 0;
}

.facility-chip:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
    color: var(--upchar-teal);
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
</style>

<div class="clinic-page-wrap">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 22px; gap: 12px;">
                <div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-hospital-o text-aqua" style="margin-right: 8px;"></i> Register Private Practice / Clinic
                    </h1>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Add your private consultation chamber to list practice slots and accept direct patient appointments.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('manageownclinic');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-arrow-left"></i> Back to My Clinics
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Main Form Card -->
                <div class="col-md-8 col-12">
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <div>
                                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                                    <i class="fa fa-pencil-square-o text-aqua"></i> Clinic Profile Details
                                </h3>
                                <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Basic identification and practice location.</p>
                            </div>
                            <span class="badge" style="background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; font-weight: 700; font-size: 11px;">New Practice</span>
                        </div>

                        <div class="card-body-custom">
                            <form action="" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                                <!-- Clinic Name -->
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label class="form-label-bold">Clinic / Chamber Name *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-building-o text-muted"></i></span>
                                        <input type="text" name="clinicname" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="e.g. LifeCare Wellness Clinic &amp; Heart Care" required autofocus>
                                    </div>
                                    <span style="font-size: 11px; color: #94a3b8; margin-top: 4px; display: block;">Official name of the consulting facility displayed to booking patients.</span>
                                </div>

                                <!-- City & Locality 2-Column Row -->
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Operating City *</label>
                                            <select class="form-control-modern getlocality" name="cliniccity" required>
                                                <option value="">-- Select City --</option>
                                                <?php
                                                $citylist = $this->db->order_by('name')->get_where('master_city', array('status'=>'1'));
                                                foreach(@$citylist->result() as $list){
                                                ?>
                                                <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Locality / Sector *</label>
                                            <select class="form-control-modern setlocality" name="cliniclocality" required>
                                                <option value="">-- Select Locality --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info (Optional/Extended) -->
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Clinic Helpdesk Mobile</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-phone text-muted"></i></span>
                                                <input type="text" name="mobile" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="e.g. 9876543210">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Standard Consultation Fee (₹)</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border); font-weight: 700;">₹</span>
                                                <input type="number" name="fee" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="500" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clinic Facilities / Amenities Chips -->
                                <div class="form-group" style="margin-bottom: 24px;">
                                    <label class="form-label-bold">Facilities &amp; Amenities Available</label>
                                    <div>
                                        <label class="facility-chip">
                                            <input type="checkbox" name="facilities[]" value="AC Waiting Lounge" checked> <i class="fa fa-snowflake-o text-info"></i> AC Waiting Lounge
                                        </label>
                                        <label class="facility-chip">
                                            <input type="checkbox" name="facilities[]" value="Wheelchair Accessible" checked> <i class="fa fa-wheelchair text-primary"></i> Wheelchair Accessible
                                        </label>
                                        <label class="facility-chip">
                                            <input type="checkbox" name="facilities[]" value="Card & UPI Payment" checked> <i class="fa fa-credit-card text-success"></i> Card &amp; UPI Payment
                                        </label>
                                        <label class="facility-chip">
                                            <input type="checkbox" name="facilities[]" value="Attached Pharmacy"> <i class="fa fa-medkit text-danger"></i> Attached Pharmacy
                                        </label>
                                        <label class="facility-chip">
                                            <input type="checkbox" name="facilities[]" value="Free Wi-Fi"> <i class="fa fa-wifi text-muted"></i> Free Wi-Fi
                                        </label>
                                        <label class="facility-chip">
                                            <input type="checkbox" name="facilities[]" value="Parking Available"> <i class="fa fa-car text-warning"></i> Parking Available
                                        </label>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                    <a href="<?=base_url('manageownclinic');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                        Cancel
                                    </a>
                                    <button type="submit" name="submit" class="btn-primary-action">
                                        <i class="fa fa-check"></i> Register Practice Clinic
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Guidance & Tips Sidebar -->
                <div class="col-md-4 col-12">
                    <div class="card-custom" style="padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa fa-lightbulb-o"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Clinic Setup Guide</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 14px;">
                            Creating a dedicated clinic profile gives your consulting chamber a dedicated page on the Upchar patient discovery directory.
                        </p>
                        <div style="background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #f1f5f9; margin-bottom: 14px;">
                            <div style="font-size: 12px; font-weight: 700; color: #043d5b; margin-bottom: 4px;"><i class="fa fa-clock-o text-aqua"></i> Next Step: Timings</div>
                            <div style="font-size: 12px; color: #64748b;">After saving, configure your consulting hours and daily slots in <strong>Schedule &amp; Timings</strong>.</div>
                        </div>
                        <div style="background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #f1f5f9;">
                            <div style="font-size: 12px; font-weight: 700; color: #043d5b; margin-bottom: 4px;"><i class="fa fa-picture-o text-aqua"></i> Chamber Photos</div>
                            <div style="font-size: 12px; color: #64748b;">Upload chamber, reception, and clinic photos under <strong>Media Gallery</strong> to boost credibility.</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$('.getlocality').change(function(){
    var city = $(this).val();
    if(city != '' && city != undefined){
        var csrfName = '<?=$this->security->get_csrf_token_name();?>';
        var csrfHash = '<?=$this->security->get_csrf_hash();?>';
        var postData = { city: city };
        postData[csrfName] = csrfHash;

        $('.setlocality').html('<option value="">Loading localities...</option>');

        $.ajax({ 
            type: 'POST', 
            url: '<?=base_url();?>home/getlocalitydd', 
            data: postData, 
            success: function (data) { 
                $('.setlocality').html(data);
            },
            error: function () {
                $.ajax({
                    type: 'GET',
                    url: '<?=base_url();?>home/getlocalitydd',
                    data: { city: city },
                    success: function (data) {
                        $('.setlocality').html(data);
                    },
                    error: function() {
                        $('.setlocality').html('<option value="General">General / Main City Area</option><option value="Other">Other</option>');
                    }
                });
            }
        });
    } else {
        $('.setlocality').html('<option value="">-- Select Locality --</option>');
    }
});
</script>