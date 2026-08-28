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

.practice-card {
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

.type-pill-label {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 10px;
    padding: 12px 20px;
    cursor: pointer;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    transition: all 0.2s;
    flex: 1;
}

.type-pill-label:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
}

.type-pill-label input[type="radio"]:checked + span {
    color: var(--upchar-teal);
    font-weight: 700;
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
    cursor: pointer;
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
                        <i class="fa fa-medkit text-aqua"></i> Add New Practice Location
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Link your private clinic chamber or visiting hospital to accept online and walk-in consultations.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('managepractice');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-arrow-left"></i> Back to Practice
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Form Box -->
                <div class="col-md-7 col-12">
                    <div class="practice-card">
                        <form action="<?=base_url('addpractice');?>" method="post">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                            <!-- Institution Type -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="form-label-cstm">Practice Establishment Type *</label>
                                <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                                    <label class="type-pill-label">
                                        <input type="radio" name="practicetype" value="C" checked>
                                        <span><i class="fa fa-hospital-o text-aqua"></i> Private Clinic / Chamber</span>
                                    </label>
                                    <label class="type-pill-label">
                                        <input type="radio" name="practicetype" value="H">
                                        <span><i class="fa fa-building text-primary"></i> Visiting Hospital / IPD</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Establishment / Chamber Name *</label>
                                <input type="text" name="clinicname" class="form-input-cstm" placeholder="e.g. Upchar Specialty Clinic &amp; Diagnostic Center" required autofocus>
                            </div>

                            <!-- City & Locality Row -->
                            <div class="row">
                                <div class="col-md-6 col-12" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">City *</label>
                                    <select class="form-input-cstm getlocality" name="cliniccity" required>
                                        <option value="">-- Select City --</option>
                                        <?php
                                        $citylist = $this->db->order_by('name', 'asc')->get_where('master_city', array('status'=>'1'));
                                        foreach(@$citylist->result() as $list){
                                        ?>
                                        <option value="<?=$list->id;?>"><?=$list->name;?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-6 col-12" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">Locality / Sector *</label>
                                    <select class="form-input-cstm setlocality" name="cliniclocality" required>
                                        <option value="">-- Select Locality --</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Street Address -->
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Full Street Address &amp; Landmark</label>
                                <input type="text" name="address" class="form-input-cstm" placeholder="e.g. Shop 12, 1st Floor, Near BHU Gate">
                            </div>

                            <!-- Consultation Fee -->
                            <div class="form-group" style="margin-bottom: 24px;">
                                <label class="form-label-cstm">Consultation Fee (₹) *</label>
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="background: #f1f5f9; border-color: var(--upchar-border); font-weight: 700;">₹</span>
                                    <input type="number" name="fee" class="form-input-cstm" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="e.g. 500" value="500" min="0" required>
                                </div>
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">Standard in-clinic consultation fee for 15-minute slot.</span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="<?=base_url('managepractice');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                    Cancel
                                </a>
                                <button type="submit" name="submit" class="btn-submit-cstm">
                                    <i class="fa fa-check"></i> Save &amp; Link Practice Location
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Sidebar -->
                <div class="col-md-5 col-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Multi-Practice Locations</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 14px;">
                            Upchar allows doctors to consult across multiple private clinics and visiting hospitals simultaneously with distinct fees and schedules.
                        </p>
                        <div style="background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #f1f5f9; margin-bottom: 14px;">
                            <div style="font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;"><i class="fa fa-calendar text-aqua"></i> Schedule Timings</div>
                            <div style="font-size: 11.5px; color: #64748b;">After adding the location, configure your weekly visiting days and session slots under <strong>Schedule &amp; Availability</strong>.</div>
                        </div>
                        <div style="background: #ecfdf5; border-radius: 10px; padding: 14px; border: 1px solid #d1fae5;">
                            <div style="font-size: 12px; font-weight: 700; color: #065f46; margin-bottom: 4px;"><i class="fa fa-shield text-green"></i> Verified Location</div>
                            <div style="font-size: 11.5px; color: #047857;">Accurate street addresses and pin codes enable one-tap Google Maps directions for visiting patients.</div>
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