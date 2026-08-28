<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.pathlab-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.pathlab-card-header {
    background: linear-gradient(135deg, #1d2a44 0%, #295771 100%);
    color: #ffffff;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pathlab-card-title {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 24px;
}
.path-form-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.path-form-control {
    width: 100%;
    height: 42px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #1e293b;
    transition: all 0.2s ease;
    background: #ffffff;
}
.path-form-control:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-hospital-o" style="color: #00a896;"></i> Pathlab Basic Profile Details
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Update diagnostic laboratory name, registered city, locality, and full clinical address.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlab-dashboard');?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Flash & Success Alert -->
            <?=$this->session->flashdata('flashmsg');?>

            <div class="row">
                <div class="col-md-8">
                    <div class="pathlab-card">
                        <div class="pathlab-card-header">
                            <h3 class="pathlab-card-title">
                                <i class="fa fa-pencil-square-o"></i> Edit Laboratory Profile
                            </h3>
                        </div>
                        <div class="pathlab-card-body">
                            <form action="" method="post">
                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="path-form-label">Pathology Diagnostic Center Name <span style="color: #ef4444;">*</span></label>
                                    <input type="text" name="clinicname" class="path-form-control" placeholder="e.g. Upchar Clinical Lab & Diagnostics" value="<?=@$data->name;?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                                        <label class="path-form-label">City Coverage <span style="color: #ef4444;">*</span></label>
                                        <select class="path-form-control" name="cliniccity" required>
                                            <option value="">-- Choose City --</option>
                                            <?php
                                            $citylist = $this->db->get_where('master_city', array('status'=>'1'));
                                            foreach(@$citylist->result() as $list):
                                            ?>
                                                <option value="<?=$list->id;?>" <?=(@$list->id == @$data->city) ? 'selected' : '';?>><?=$list->name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group" style="margin-bottom: 18px;">
                                        <label class="path-form-label">Locality / Sector</label>
                                        <select class="path-form-control" name="cliniclocality">
                                            <option value="">-- Choose Locality --</option>
                                            <?php
                                            $localitylist = $this->db->get_where('master_locality', array('status'=>'1'));
                                            foreach(@$localitylist->result() as $loc):
                                            ?>
                                                <option value="<?=$loc->id;?>" <?=(@$loc->id == @$data->location) ? 'selected' : '';?>><?=$loc->name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 22px;">
                                    <label class="path-form-label">Complete Street Address <span style="color: #ef4444;">*</span></label>
                                    <textarea name="address" class="path-form-control" style="height: 80px; resize: vertical;" placeholder="Building, Street, Landmark, Pincode" required><?=@$data->address;?></textarea>
                                </div>

                                <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 18px;">
                                    <a href="<?=base_url('pathlab-dashboard');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 9px 20px;">
                                        Cancel
                                    </a>
                                    <button type="submit" name="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 9px 28px;">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info Side Card -->
                <div class="col-md-4">
                    <div class="pathlab-card">
                        <div class="pathlab-card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #1e293b;">
                            <h3 class="pathlab-card-title" style="color: #1e293b; font-size: 14px;">
                                <i class="fa fa-info-circle" style="color: #00a896;"></i> Profile Guidelines
                            </h3>
                        </div>
                        <div class="pathlab-card-body" style="font-size: 13px; line-height: 1.6; color: #64748b;">
                            <p style="margin-bottom: 12px;">Keeping your laboratory profile and address accurate ensures:</p>
                            <ul style="padding-left: 20px; margin: 0 0 16px 0;">
                                <li style="margin-bottom: 6px;">Patients in your city can easily locate and book your tests.</li>
                                <li style="margin-bottom: 6px;">Sample pickup executives can navigate to your center accurately.</li>
                                <li>Invoices and diagnostic reports display the official lab address.</li>
                            </ul>
                            <div style="background: #f0fdfa; border: 1px solid #ccfbf1; padding: 12px; border-radius: 8px; color: #0f766e; font-size: 12px;">
                                <i class="fa fa-shield"></i> All submitted information is verified by Upchar Healthcare Quality Assurance.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>