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
                        <i class="fa fa-pencil-square-o text-aqua"></i> Edit Practice Clinic
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Update your consulting chamber location and details.
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
                                <input type="text" name="clinicname" class="form-input-cstm" value="<?=htmlspecialchars(@$data->name);?>" required autofocus>
                            </div>

                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">City *</label>
                                <select class="form-input-cstm getlocality" name="cliniccity" required>
                                    <option value="">-- Select City --</option>
                                    <?php
                                    $citylist = $this->db->order_by('name')->get_where('master_city', array('status'=>'1'));
                                    foreach(@$citylist->result() as $list){
                                    ?>
                                    <option value="<?=$list->id;?>" <?php if($list->id == @$data->city){echo 'selected';}?>><?=$list->name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 24px;">
                                <label class="form-label-cstm">Locality / Sector *</label>
                                <select class="form-input-cstm setlocality" name="cliniclocality" required>
                                    <?php
                                    if(!empty($data->city)){
                                        $loclist = $this->db->order_by('name')->get_where('master_locality', array('status'=>'1', 'city_id'=>$data->city));
                                        foreach(@$loclist->result() as $list){
                                        ?>
                                        <option value="<?=$list->id;?>" <?php if($list->id == @$data->location){echo 'selected';}?>><?=$list->name;?></option>
                                    <?php } } else { ?>
                                        <option value="">-- Select Locality --</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="<?=base_url('manageownclinic');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                    Cancel
                                </a>
                                <button type="submit" name="submit" class="btn-submit-cstm">
                                    <i class="fa fa-check"></i> Update Clinic
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
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Next Steps</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 12px;">
                            Updating the clinic details will update your address for new patient appointments immediately.
                        </p>
                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                            <a href="<?=base_url('managepractice');?>" class="btn btn-sm btn-default" style="font-weight: 700; width: 100%; text-align: left; margin-bottom: 8px; color: #00a896;">
                                <i class="fa fa-medkit"></i> Configure Consultation Fee &rarr;
                            </a>
                            <a href="<?=base_url('doctorpanel/datetime');?>" class="btn btn-sm btn-default" style="font-weight: 700; width: 100%; text-align: left; color: #2563eb;">
                                <i class="fa fa-calendar"></i> Update Slot Timings &rarr;
                            </a>
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