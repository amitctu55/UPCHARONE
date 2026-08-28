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

.clinic-form-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--upchar-border);
    padding: 32px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.form-label-cstm {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-input-cstm {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-input-cstm:focus {
    background: #ffffff;
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-submit-cstm {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 11px 28px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-submit-cstm:hover {
    background: var(--upchar-teal-dark);
    color: #ffffff;
}
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 88vh;">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-plus-circle text-aqua"></i> Add New Practice Clinic
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Register your private chamber or consulting clinic on Upchar.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('manageownclinic');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-arrow-left"></i> Back to Clinics
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Form Box -->
                <div class="col-md-7 col-12">
                    <div class="clinic-form-card">
                        <form action="" method="post">
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Clinic / Chamber Name *</label>
                                <input type="text" name="clinicname" class="form-input-cstm" placeholder="e.g. Sharma Health Care &amp; Heart Clinic" required autofocus>
                            </div>

                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">City *</label>
                                <select class="form-input-cstm getlocality" name="cliniccity" required>
                                    <option value="">-- Select City --</option>
                                    <?php
                                    $citylist = $this->db->order_by('name')->get_where('master_city', array('status'=>'1'));
                                    foreach(@$citylist->result() as $list){
                                    ?>
                                    <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 24px;">
                                <label class="form-label-cstm">Locality / Sector *</label>
                                <select class="form-input-cstm setlocality" name="cliniclocality" required>
                                    <option value="">-- Select Locality --</option>
                                </select>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="<?=base_url('manageownclinic');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                    Cancel
                                </a>
                                <button type="submit" name="submit" class="btn-submit-cstm">
                                    <i class="fa fa-check"></i> Save &amp; Continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Sidebar -->
                <div class="col-md-5 col-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Clinic Setup Tips</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 12px;">
                            Accurate clinic names and locality tags make it easier for neighborhood patients to discover your chamber on Google Maps and the Upchar app.
                        </p>
                        <ul style="padding-left: 18px; font-size: 12.5px; color: #334155; line-height: 1.8; margin: 0;">
                            <li>After registering, you can configure consultation fees under <strong>Manage Practice</strong>.</li>
                            <li>Set your operating hours under <strong>Date &amp; Time</strong>.</li>
                            <li>Upload clinic chamber photos under <strong>Media &amp; Gallery</strong>.</li>
                        </ul>
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