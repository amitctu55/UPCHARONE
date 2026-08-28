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
    flex-wrap: wrap;
    gap: 10px;
}
.pathlab-card-title {
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 22px;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-user-md" style="color: #00a896;"></i> Associated Clinical Doctors
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Manage doctor affiliations, consultation schedules, and practicing clinical shifts.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/adddoctor');?>" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 8px; padding: 9px 20px;">
                        <i class="fa fa-user-plus"></i> Link / Add Doctor
                    </a>
                </div>
            </div>

            <!-- Flash Alerts -->
            <?=$this->session->flashdata('flashmsg');?>

            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-users"></i> Linked Doctor Roster
                    </h3>
                </div>
                <div class="pathlab-card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 50px; text-align: center;">#</th>
                                    <th>Doctor Name</th>
                                    <th>Contact Phone</th>
                                    <th>Email ID</th>
                                    <th style="text-align: center;">Affiliation Status</th>
                                    <th style="text-align: center; width: 180px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                if(is_array($clinic) && !empty($clinic)):
                                    foreach($clinic as $p):
                                        $isApproved = ($p->p_status == '1');
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$i;?></td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?='Dr. '.htmlspecialchars($p->fname.' '.$p->lname);?></strong>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <i class="fa fa-phone"></i> <?=htmlspecialchars($p->mobile);?>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <?=htmlspecialchars($p->email ?: 'N/A');?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="label <?=$isApproved ? 'label-success' : 'label-warning';?>" style="font-size: 11px; padding: 4px 10px; border-radius: 12px;">
                                            <?=$isApproved ? 'Approved Active' : 'Approval Pending';?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?=base_url('pathlabpanel/updatedoctor/'.mybase64_encode($p->id));?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 600; color: #00a896; border-color: #cbd5e1; padding: 5px 12px;">
                                            <i class="fa fa-calendar"></i> Shift &amp; Fee
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                        <i class="fa fa-user-md fa-3x" style="margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                        No doctors linked to this laboratory yet. Click "Link / Add Doctor" to affiliate specialists.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>