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

.profile-card {
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
    cursor: pointer;
}

.btn-submit-cstm:hover {
    background: var(--upchar-teal-dark);
    color: #ffffff;
}

.gender-box {
    display: flex;
    gap: 16px;
    margin-top: 4px;
}

.gender-label {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    transition: all 0.2s;
}

.gender-label:hover {
    border-color: var(--upchar-teal);
}
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 88vh;">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-user-md text-aqua"></i> Step 1: Clinical Profile Details
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Update your professional credentials, medical specializations, and location.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('doctorpanel/updateprofile');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-arrow-left"></i> Back to Roadmap
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Form Box -->
                <div class="col-md-7 col-12">
                    <div class="profile-card">
                        <form action="" method="post">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Doctor Full Name *</label>
                                <input type="text" name="name" class="form-input-cstm" value="<?=htmlspecialchars(@$data->fname);?>" placeholder="e.g. Dr. Anushka Sharma" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Registered Email Address *</label>
                                <input type="email" name="email" class="form-input-cstm" value="<?=htmlspecialchars(@$data->email);?>" placeholder="e.g. anushka@hospital.com" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Primary Specialization *</label>
                                <select class="form-input-cstm" name="specialisation[]" required>
                                    <option value="">-- Select Specialization --</option>
                                    <?php
                                    $spl_list = $this->db->get_where('master_specialization', array('status'=>1));
                                    foreach(@$spl_list->result() as $list){
                                    ?>
                                    <option value="<?=$list->id;?>" <?php if(in_array($list->id, (array)@$data_spl)){echo 'selected';} ?>><?=$list->name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Gender *</label>
                                <div class="gender-box">
                                    <label class="gender-label">
                                        <input type="radio" name="gender" value="M" <?php if(@$data->gender == 'M' || empty($data->gender)) echo 'checked'; ?>> Male
                                    </label>
                                    <label class="gender-label">
                                        <input type="radio" name="gender" value="F" <?php if(@$data->gender == 'F') echo 'checked'; ?>> Female
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 24px;">
                                <label class="form-label-cstm">Primary Base City *</label>
                                <select class="form-input-cstm" name="city" required>
                                    <option value="">-- Select City --</option>
                                    <?php
                                    $citylist = $this->db->get_where('master_city', array('status'=>'1'));
                                    foreach(@$citylist->result() as $list){
                                    ?>
                                    <option value="<?=$list->id;?>" <?php if(@$data->city == $list->id){ echo 'selected';} ?>><?=$list->name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="<?=base_url('doctorpanel/updateprofile');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                    Cancel
                                </a>
                                <button type="submit" name="submit" class="btn-submit-cstm">
                                    <i class="fa fa-check"></i> Save &amp; Proceed to Next Step
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
                                <i class="fa fa-certificate"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Verified Credentials</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 14px;">
                            Medical registration number and verified degrees establish trust with patients and enable online teleconsultation &amp; e-prescription services.
                        </p>
                        <div style="background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #f1f5f9;">
                            <div style="font-size: 12px; font-weight: 700; color: #00a896; margin-bottom: 4px;"><i class="fa fa-lock"></i> ABDM &amp; HPR Compliance</div>
                            <div style="font-size: 11.5px; color: #64748b;">Your practitioner registry is synchronized with the Healthcare Professionals Registry (HPR).</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>