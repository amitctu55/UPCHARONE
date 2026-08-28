<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.doctor-profile-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 20px;
    align-items: center;
    transition: all 0.25s ease;
}
.doctor-profile-card:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.07);
    border-color: #cbd5e1;
}
.doctor-avatar-box {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
}
.doctor-avatar-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.doctor-details-box {
    flex: 1;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-users" style="color: #00a896;"></i> Verified Upchar Doctor Directory
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Explore certified specialists on the network and link them to your diagnostic center.</p>
                </div>
            </div>

            <!-- Doctor List Cards -->
            <?php 
            if(is_array($doctorlist) && !empty($doctorlist)):
                foreach($doctorlist as $d):
                    $docName = 'Dr. '.$d->fname.' '.$d->lname;
                    $docImg = !empty($d->drimage) ? admin_url().'public/assets/upload/'.$d->drimage : base_url('images/dummydr.jpg');
                    
                    $quastring = '';
                    $qu = $this->db->get_where('dr_qualifications', array('user_id' => $d->id));
                    foreach(@$qu->result() as $q) {
                        $quastring .= getQualificationName($q->qualification_id).', ';
                    }
                    $quastring = rtrim($quastring, ', ');

                    $splstring = '';
                    $sp = $this->db->get_where('dr_specialization', array('user_id' => $d->id))->result();
                    foreach($sp as $s) {
                        $splstring .= getSpecilizationName($s->specialization_id).', ';
                    }
                    $splstring = rtrim($splstring, ', ');
            ?>
            <div class="doctor-profile-card">
                <div class="doctor-avatar-box">
                    <img src="<?=$docImg;?>" alt="<?=htmlspecialchars($docName);?>" onerror="this.src='<?=base_url('images/dummydr.jpg');?>'">
                </div>
                <div class="doctor-details-box">
                    <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                        <a href="<?=base_url('pathlabpanel/doctordetail/'.$d->id);?>" style="color: inherit; text-decoration: none;">
                            <?=htmlspecialchars($docName);?>
                        </a>
                    </h4>
                    <div style="font-size: 13px; color: #00a896; font-weight: 600; margin-bottom: 4px;">
                        <?=htmlspecialchars($splstring ?: 'Specialist Consultant');?>
                    </div>
                    <div style="font-size: 12.5px; color: #64748b; margin-bottom: 6px;">
                        <span><i class="fa fa-graduation-cap"></i> <?=htmlspecialchars($quastring ?: 'MBBS');?></span> &bull; 
                        <span><i class="fa fa-briefcase"></i> <?=htmlspecialchars($d->exp ? $d->exp.' Yrs Experience' : 'Certified Practicing');?></span>
                    </div>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/doctordetail/'.$d->id);?>" class="btn btn-sm btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #00a896; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-eye"></i> View Profile
                    </a>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div style="text-align: center; padding: 50px 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; color: #94a3b8;">
                <i class="fa fa-user-md fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                No doctor profiles available at this moment.
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>