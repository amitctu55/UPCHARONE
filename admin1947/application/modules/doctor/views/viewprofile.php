<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Doctor Profile Details
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">View medical credentials, practice details, contact information, and verification status</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/doctorview')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Directory
        </a>
        <a href="<?=base_url('doctor/doctorview/updatedoctor/'.@$profile_dr->id)?>" class="btn" style="background: #00a896; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 8px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
          <i class="fa fa-pencil"></i> Edit Profile
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 15px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: flex-start;">
      
      <!-- Left Column: Doctor Profile Card & Media -->
      <div style="display: flex; flex-direction: column; gap: 20px; position: sticky; top: 20px;">
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px; text-align: center;">
          <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin: 0 auto 16px; border: 3px solid #00a896; box-shadow: 0 4px 6px rgba(0,168,150,0.15);">
            <img src="<?=base_url();?>public/assets/upload/<?=(!empty($profile_dr->drimage))? $profile_dr->drimage : 'dummydr.jpg';?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?=base_url();?>public/assets/upload/dummydr.jpg';">
          </div>
          <h2 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 4px 0;">
            Dr. <?=@$profile_dr->fname.' '.@$profile_dr->lname;?>
          </h2>
          <div style="font-size: 13px; color: #00a896; font-weight: 600; margin-bottom: 14px;">
            Reg. #<?=@$profile_dr->regd_no ? $profile_dr->regd_no : 'N/A';?>
          </div>

          <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 16px; flex-wrap: wrap;">
            <span class="badge-pill-status <?=(@$profile_dr->verified == 1)? 'badge-status-active' : 'badge-status-inactive';?>">
              <i class="fa fa-check-circle"></i> <?=(@$profile_dr->verified == 1)? 'Verified' : 'Unverified';?>
            </span>
            <span class="badge-pill-status <?=(@$profile_dr->approved == 1)? 'badge-status-active' : 'badge-status-inactive';?>">
              <i class="fa fa-circle" style="font-size: 7px;"></i> <?=(@$profile_dr->approved == 1)? 'Approved' : 'Pending';?>
            </span>
            <span class="badge-pill-status <?=(@$profile_dr->status == '1' || @$profile_dr->status == 'A')? 'badge-status-active' : 'badge-status-inactive';?>">
              <?=(@$profile_dr->status == '1' || @$profile_dr->status == 'A')? 'Active' : 'Inactive';?>
            </span>
          </div>

          <div style="border-top: 1px solid #F1F5F9; padding-top: 16px; text-align: left; display: flex; flex-direction: column; gap: 10px;">
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-envelope-o" style="width: 20px; color: #00a896;"></i> <?=@$profile_dr->email ? $profile_dr->email : 'Not Provided';?>
            </div>
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-phone" style="width: 20px; color: #00a896;"></i> <?=@$profile_dr->mobile ? $profile_dr->mobile : 'Not Provided';?>
            </div>
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-map-marker" style="width: 20px; color: #00a896;"></i> <?=getCityName(@$profile_dr->city);?>
            </div>
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-clock-o" style="width: 20px; color: #00a896;"></i> <?=@$profile_dr->exp ? $profile_dr->exp : 0;?> Years Experience
            </div>
          </div>
        </div>

        <!-- Documents Card -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
          <h4 style="margin: 0 0 14px 0; font-size: 14px; font-weight: 700; color: #0F172A; text-transform: uppercase;">
            <i class="fa fa-file-text-o" style="color: #00a896; margin-right: 6px;"></i> Verification Proofs
          </h4>
          <div style="display: flex; gap: 12px; justify-content: space-around;">
            <div style="text-align: center;">
              <img src="<?=base_url();?>public/assets/upload/<?=(!empty($profile_dr->id_proof))? $profile_dr->id_proof : 'dummydr.jpg';?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;" onerror="this.src='<?=base_url();?>public/assets/upload/dummydr.jpg';">
              <div style="font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 600;">ID Proof</div>
            </div>
            <div style="text-align: center;">
              <img src="<?=base_url();?>public/assets/upload/<?=(!empty($profile_dr->med_reg_proof))? $profile_dr->med_reg_proof : 'dummydr.jpg';?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;" onerror="this.src='<?=base_url();?>public/assets/upload/dummydr.jpg';">
              <div style="font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 600;">Council Certificate</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Profile Sections -->
      <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Professional Credentials -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-graduation-cap" style="color: #00a896; margin-right: 8px;"></i> Professional Credentials
            </h3>
          </div>
          <div style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
            <div>
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px;">Registration Number</span>
              <div style="font-size: 14px; font-weight: 700; color: #1e293b;"><?=@$profile_dr->regd_no ? $profile_dr->regd_no : 'N/A';?></div>
            </div>

            <div>
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px;">Registration Council</span>
              <div style="font-size: 14px; font-weight: 600; color: #1e293b;">
                <?php
                $councilRow = @$profile_dr->regd_council ? $this->db->get_where('master_council', array('id'=>@$profile_dr->regd_council))->row() : null;
                echo $councilRow ? $councilRow->name : 'N/A';
                ?>
              </div>
            </div>

            <div>
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px;">Graduation Year</span>
              <div style="font-size: 14px; font-weight: 600; color: #1e293b;">
                <?=(!empty($profile_dr->regd_year) ? $profile_dr->regd_year : (!empty($profile_dr->year) ? $profile_dr->year : 'N/A'));?>
              </div>
            </div>

            <div>
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px;">Experience</span>
              <div style="font-size: 14px; font-weight: 600; color: #1e293b;"><?=@$profile_dr->exp ? $profile_dr->exp.' Years' : 'N/A';?></div>
            </div>

            <div>
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px;">Subscription Tier</span>
              <div style="font-size: 14px; font-weight: 600; color: #1e293b;">
                <?=(@$profile_dr->subscription == 'P' || @$profile_dr->package == 'P') ? '<span class="label label-warning" style="background-color: #f59e0b !important;">Premium</span>' : '<span class="label label-default" style="background-color: #64748b !important;">Basic</span>';?>
              </div>
            </div>

            <div>
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px;">Achievements</span>
              <div style="font-size: 13.5px; color: #334155;"><?=@$profile_dr->achievement ? $profile_dr->achievement : 'None specified';?></div>
            </div>

            <!-- Qualifications / Degrees -->
            <div style="grid-column: 1 / -1; border-top: 1px solid #f1f5f9; padding-top: 14px;">
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Qualifications (Degrees)</span>
              <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <?php 
                $quals = $this->db->select('master_degree.name')
                                  ->join('master_degree', 'master_degree.id = dr_qualifications.qualification_id')
                                  ->get_where('dr_qualifications', array('dr_qualifications.user_id' => @$profile_dr->id))
                                  ->result_array();
                if(!empty($quals)): 
                  foreach($quals as $q): ?>
                    <span class="label label-info" style="background-color: #e0f2fe !important; color: #0369a1 !important; border: 1px solid #bae6fd; font-size: 12px; padding: 5px 10px; border-radius: 6px;">
                      <i class="fa fa-graduation-cap"></i> <?=$q['name'];?>
                    </span>
                  <?php endforeach; 
                else: ?>
                  <span style="color: #94a3b8; font-size: 13px;">No degrees listed</span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Specializations -->
            <div style="grid-column: 1 / -1; border-top: 1px solid #f1f5f9; padding-top: 14px;">
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Specializations</span>
              <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <?php 
                $spls = $this->db->select('master_specialization.name')
                                 ->join('master_specialization', 'master_specialization.id = dr_specialization.specialization_id')
                                 ->get_where('dr_specialization', array('dr_specialization.user_id' => @$profile_dr->id))
                                 ->result_array();
                if(!empty($spls)): 
                  foreach($spls as $s): ?>
                    <span class="label label-success" style="background-color: #ecfdf5 !important; color: #047857 !important; border: 1px solid #a7f3d0; font-size: 12px; padding: 5px 10px; border-radius: 6px;">
                      <i class="fa fa-stethoscope"></i> <?=$s['name'];?>
                    </span>
                  <?php endforeach; 
                else: ?>
                  <span style="color: #94a3b8; font-size: 13px;">No specializations listed</span>
                <?php endif; ?>
              </div>
            </div>

            <!-- About Doctor -->
            <div style="grid-column: 1 / -1; border-top: 1px solid #f1f5f9; padding-top: 14px;">
              <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Professional Bio & Summary</span>
              <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; font-size: 13px; line-height: 1.6; color: #334155;">
                <?=(!empty($profile_dr->about) ? nl2br(htmlspecialchars($profile_dr->about)) : (!empty($profile_dr->short_about) ? nl2br(htmlspecialchars($profile_dr->short_about)) : 'No professional summary provided.'));?>
              </div>
            </div>
          </div>
        </div>

        <!-- Practice & Clinics / Hospitals Affiliations -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-hospital-o" style="color: #00a896; margin-right: 8px;"></i> Hospital & Clinic Affiliations
            </h3>
          </div>
          <div style="padding: 20px;">
            <?php
            $practices = $this->db->select('dr_practice.*, hospital.name as hospital_name, hospital.city as hospital_city, hospital.address as hospital_address')
                                  ->join('hospital', 'hospital.id = dr_practice.institution_id', 'left')
                                  ->get_where('dr_practice', array('dr_practice.user_id' => @$profile_dr->id))
                                  ->result_array();
            if(!empty($practices)): ?>
              <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 8px;">
                <table class="table table-hover" style="margin: 0;">
                  <thead>
                    <tr style="background: #f8fafc;">
                      <th>Institution Name</th>
                      <th>Type</th>
                      <th>Location</th>
                      <th>Consultation Fee</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($practices as $p): ?>
                      <tr>
                        <td style="font-weight: 600; color: #1e293b;"><?=$p['hospital_name'] ? $p['hospital_name'] : 'Private Practice';?></td>
                        <td>
                          <span class="label label-default" style="font-size: 11px;">
                            <?=$p['type'] == 'H' ? 'Hospital' : ($p['type'] == 'C' ? 'Clinic' : 'Consultant');?>
                          </span>
                        </td>
                        <td style="font-size: 12.5px; color: #64748b;"><?=$p['hospital_address'] ? $p['hospital_address'] : getCityName($p['hospital_city']);?></td>
                        <td style="font-weight: 700; color: #00a896;">₹ <?=$p['fee'] ? $p['fee'] : '0.00';?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <p style="margin: 0; color: #94a3b8; font-size: 13.5px; text-align: center; padding: 20px 0;">
                <i class="fa fa-info-circle"></i> No hospital or clinic affiliations attached yet.
              </p>
            <?php endif; ?>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>
