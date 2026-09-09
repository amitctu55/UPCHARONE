<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-hospital-o" style="color: #00a896;"></i> Hospital Profile &amp; Facility Dossier
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">View institutional credentials, address, affiliated specialists, compliance documents, and operational status</p>
      </div>
      <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/clinicreg/updatehospital/'.@$hospital->id)?>" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; color: #FFFFFF; font-weight: 600; padding: 6px 14px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa fa-pencil"></i> Edit Hospital
        </a>
        <a href="<?=base_url('doctor/clinicreg/hospitalverify/'.@$hospital->id)?>" class="btn btn-sm btn-warning" style="background: #f59e0b; border-color: #f59e0b; color: #FFFFFF; font-weight: 600; padding: 6px 14px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa fa-shield"></i> Verification Portal
        </a>
        <a href="<?=base_url('doctor/clinicreg/assign_doctor')?>" class="btn btn-sm btn-info" style="background: #0284c7; border-color: #0284c7; color: #FFFFFF; font-weight: 600; padding: 6px 14px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa fa-user-md"></i> Assign Doctor
        </a>
        <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" class="btn btn-sm btn-default" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 6px 14px; border-radius: 6px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa fa-arrow-left"></i> Back to Hospitals
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    
    <!-- Flash Alert Messages -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 15px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <?php
      $isVerified = (!empty($hospital->verified) && $hospital->verified == '1');
      $isApproved = (!empty($hospital->approved) && $hospital->approved == '1');
      $isActive   = (!empty($hospital->status) && ($hospital->status == '1' || $hospital->status == 'A'));
    ?>

    <!-- Facility Header Banner -->
    <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px; margin-bottom: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 18px;">
          <?php if(!empty($hospital->drimage) && file_exists(FCPATH . 'public/assets/images/hospital/' . $hospital->drimage)): ?>
            <img src="<?=base_url('public/assets/images/hospital/' . $hospital->drimage);?>" alt="Logo" style="width: 76px; height: 76px; object-fit: cover; border-radius: 12px; border: 2px solid #E2E8F0;">
          <?php elseif(!empty($hospital->drimage) && file_exists(FCPATH . 'public/assets/upload/' . $hospital->drimage)): ?>
            <img src="<?=base_url('public/assets/upload/' . $hospital->drimage);?>" alt="Logo" style="width: 76px; height: 76px; object-fit: cover; border-radius: 12px; border: 2px solid #E2E8F0;">
          <?php else: ?>
            <div style="width: 76px; height: 76px; border-radius: 12px; background: #E0F2FE; color: #0284C7; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700;">
              <i class="fa fa-hospital-o"></i>
            </div>
          <?php endif; ?>
          <div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
              <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0; font-family: 'Inter', sans-serif;">
                <?=htmlspecialchars($hospital->name);?>
              </h2>
              <span class="label" style="background-color: #00a896; color: #fff; font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 600;">
                HOSP-#<?=$hospital->id;?>
              </span>
              <?php if($isVerified): ?>
                <span class="label" style="background-color: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 600;">
                  <i class="fa fa-check-circle"></i> Verified &amp; Compliant
                </span>
              <?php else: ?>
                <span class="label" style="background-color: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 600;">
                  <i class="fa fa-clock-o"></i> Verification Pending
                </span>
              <?php endif; ?>
              <span class="label" style="background-color: <?=$isActive ? '#ECFDF5; color: #059669; border: 1px solid #A7F3D0;' : '#FEF2F2; color: #DC2626; border: 1px solid #FECACA;';?> font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 600;">
                <?=$isActive ? 'Active Facility' : 'Inactive / Suspended';?>
              </span>
            </div>
            <div style="color: #64748B; font-size: 13px; margin-top: 6px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
              <span><i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars(@$city_name ?: 'City Unspecified');?><?=!empty($hospital->state) ? ', '.htmlspecialchars($hospital->state) : '';?></span>
              <span><i class="fa fa-phone text-primary"></i> <?=htmlspecialchars($hospital->mobile);?></span>
              <span><i class="fa fa-envelope-o text-warning"></i> <?=htmlspecialchars($hospital->email);?></span>
              <span><i class="fa fa-calendar text-muted"></i> Registered: <?=date('d M Y, h:i A', strtotime($hospital->creat_date));?></span>
            </div>
          </div>
        </div>

        <!-- Quick Metrics -->
        <div style="display: flex; gap: 12px;">
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 18px; text-align: center; min-width: 100px;">
            <div style="font-size: 11px; color: #64748B; font-weight: 700; text-transform: uppercase;">Doctors</div>
            <div style="font-size: 20px; font-weight: 800; color: #0F172A;"><?=count(@$affiliated_doctors ?: array());?></div>
          </div>
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 18px; text-align: center; min-width: 100px;">
            <div style="font-size: 11px; color: #64748B; font-weight: 700; text-transform: uppercase;">Services</div>
            <div style="font-size: 20px; font-weight: 800; color: #00A896;"><?=count(@$services_list ?: array());?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Left Column: Information Details -->
      <div class="col-md-7">
        
        <!-- Card 1: Basic Demographics & Contact -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">
              <i class="fa fa-info-circle" style="color: #00a896; margin-right: 6px;"></i> Facility Information &amp; Contact
            </h3>
          </div>
          <div style="padding: 20px;">
            <table class="table table-bordered" style="margin: 0; font-size: 13px;">
              <tr>
                <th style="width: 32%; background: #F8FAFC; color: #475569;">Hospital / Facility Name</th>
                <td style="font-weight: 600; color: #1E293B;"><?=htmlspecialchars($hospital->name);?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Official Email</th>
                <td><a href="mailto:<?=htmlspecialchars($hospital->email);?>" style="color: #00a896; font-weight: 600;"><?=htmlspecialchars($hospital->email);?></a></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Primary Contact Mobile</th>
                <td style="font-weight: 600; color: #1E293B;"><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($hospital->mobile);?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Official Website</th>
                <td>
                  <?php if(!empty($hospital->website)): ?>
                    <a href="<?=htmlspecialchars($hospital->website);?>" target="_blank" rel="noopener noreferrer" style="color: #0284c7; font-weight: 600;">
                      <?=htmlspecialchars($hospital->website);?> <i class="fa fa-external-link"></i>
                    </a>
                  <?php else: ?>
                    <span style="color: #94A3B8;">Not specified</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">About Facility</th>
                <td style="color: #334155; line-height: 1.5;">
                  <?=!empty($hospital->about) ? nl2br(htmlspecialchars($hospital->about)) : '<span style="color: #94A3B8;">No description provided.</span>';?>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Card 2: Physical Address & Geographic Location -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">
              <i class="fa fa-map-marker" style="color: #EF4444; margin-right: 6px;"></i> Physical Location &amp; Address
            </h3>
          </div>
          <div style="padding: 20px;">
            <table class="table table-bordered" style="margin: 0; font-size: 13px;">
              <tr>
                <th style="width: 32%; background: #F8FAFC; color: #475569;">State</th>
                <td style="font-weight: 600; color: #1E293B;"><?=htmlspecialchars(@$hospital->state ?: 'Uttar Pradesh');?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">City</th>
                <td style="font-weight: 600; color: #1E293B;"><?=htmlspecialchars(@$city_name ?: 'City Not Specified');?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Locality / Area</th>
                <td><?=htmlspecialchars(@$hospital->location ?: 'Not specified');?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Street Address</th>
                <td style="color: #1E293B; font-weight: 500;"><?=htmlspecialchars($hospital->address);?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">PIN Code</th>
                <td style="font-weight: 700; color: #0F172A;"><?=htmlspecialchars(@$hospital->pincode ?: 'N/A');?></td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Card 3: Clinical Services & Departments -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">
              <i class="fa fa-stethoscope" style="color: #00a896; margin-right: 6px;"></i> Medical Departments &amp; Specialities
            </h3>
          </div>
          <div style="padding: 20px;">
            <div style="margin-bottom: 12px;">
              <label style="font-size: 12px; color: #64748B; font-weight: 700; text-transform: uppercase;">Active Services &amp; Facilities</label>
              <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px;">
                <?php if(!empty($services_list)): foreach($services_list as $srv): ?>
                  <span style="background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; padding: 5px 12px; border-radius: 6px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa fa-check text-success"></i> <?=htmlspecialchars($srv['service_name']);?>
                  </span>
                <?php endforeach; else: ?>
                  <span style="color: #94A3B8; font-size: 13px;">No explicit services mapped in registry.</span>
                <?php endif; ?>
              </div>
            </div>

            <?php if(!empty($hospital->tag)): ?>
              <div style="margin-top: 16px;">
                <label style="font-size: 12px; color: #64748B; font-weight: 700; text-transform: uppercase;">Speciality Search Tags</label>
                <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;">
                  <?php foreach(explode(',', $hospital->tag) as $t): if(trim($t)): ?>
                    <span style="background: #F1F5F9; color: #334155; border: 1px solid #CBD5E1; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                      <i class="fa fa-tag text-muted"></i> <?=htmlspecialchars(trim($t));?>
                    </span>
                  <?php endif; endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Card 4: Affiliated Doctors Roster -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">
              <i class="fa fa-user-md" style="color: #0284c7; margin-right: 6px;"></i> Affiliated Specialists &amp; Doctors (<?=count(@$affiliated_doctors ?: array());?>)
            </h3>
            <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-xs btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 4px;">
              <i class="fa fa-plus"></i> Assign Doctor
            </a>
          </div>
          <div style="padding: 0;">
            <div class="table-responsive">
              <table class="table table-hover table-striped" style="margin: 0; font-size: 12.5px;">
                <thead style="background: #F8FAFC; color: #475569;">
                  <tr>
                    <th style="padding: 10px 16px;">Doctor Name</th>
                    <th>Speciality</th>
                    <th>Contact</th>
                    <th style="text-align: center;">OPD Fee</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center; width: 80px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($affiliated_doctors)): foreach($affiliated_doctors as $doc): ?>
                    <tr>
                      <td style="padding: 10px 16px; font-weight: 600; color: #0F172A;">
                        Dr. <?=htmlspecialchars($doc['fname'].' '.$doc['lname']);?>
                      </td>
                      <td>
                        <span class="label" style="background: #E0F2FE; color: #0369A1; font-weight: 600;">
                          <?=htmlspecialchars(@$doc['speciality'] ?: 'General Practice');?>
                        </span>
                      </td>
                      <td><?=htmlspecialchars($doc['mobile']);?></td>
                      <td style="text-align: center; font-weight: 700; color: #00a896;">Rs. <?=floatval($doc['fee']);?></td>
                      <td style="text-align: center;">
                        <span class="label label-<?=$doc['practice_status']=='1' ? 'success' : 'warning';?>" style="font-size: 10px;">
                          <?=$doc['practice_status']=='1' ? 'ACTIVE' : 'INACTIVE';?>
                        </span>
                      </td>
                      <td style="text-align: center;">
                        <a href="<?=base_url('doctor/clinicreg/doctor_fee_time/'.$doc['practice_id']);?>" class="btn btn-xs btn-default" title="Edit Timings &amp; Fee" style="border-radius: 4px;">
                          <i class="fa fa-clock-o text-primary"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="6" style="text-align: center; padding: 24px; color: #94A3B8;">
                        <i class="fa fa-user-md fa-2x" style="opacity: 0.3; display: block; margin-bottom: 6px;"></i>
                        No doctors currently affiliated with this hospital.
                        <div style="margin-top: 8px;">
                          <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-xs btn-info" style="font-weight: 600;">Assign Doctor Now</a>
                        </div>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Column: Compliance Documents, Account Credentials & Actions -->
      <div class="col-md-5">
        
        <!-- Document Proofs Inspection -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">
              <i class="fa fa-file-text-o" style="color: #7C3AED; margin-right: 6px;"></i> Statutory Compliance Documents
            </h3>
          </div>
          <div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Document 1: Medical Registration Certificate -->
            <div style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px; background: #F8FAFC;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <strong style="font-size: 13px; color: #1E293B;">
                  <i class="fa fa-certificate text-warning"></i> Medical Registration Proof
                </strong>
                <?php if(!empty($hospital->med_reg_proof)): ?>
                  <span class="label label-success">Uploaded</span>
                <?php else: ?>
                  <span class="label label-default">Missing</span>
                <?php endif; ?>
              </div>
              <?php if(!empty($hospital->med_reg_proof)): ?>
                <?php 
                $docFile = $hospital->med_reg_proof;
                $docUrl = base_url('public/assets/upload/' . $docFile);
                if (!file_exists(FCPATH . 'public/assets/upload/' . $docFile) && file_exists(FCPATH . 'public/assets/images/hospital/' . $docFile)) {
                  $docUrl = base_url('public/assets/images/hospital/' . $docFile);
                }
              ?>
                <div style="margin-top: 8px;">
                  <a href="<?=$docUrl;?>" target="_blank" class="btn btn-xs btn-primary" style="font-weight: 600; background: #00a896; border-color: #00a896;">
                    <i class="fa fa-external-link"></i> View Document
                  </a>
                </div>
              <?php else: ?>
                <p style="font-size: 12px; color: #94A3B8; margin: 4px 0 0;">No registration certificate uploaded.</p>
              <?php endif; ?>
            </div>

            <!-- Document 2: Authorized Signatory ID Proof -->
            <div style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px; background: #F8FAFC;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <strong style="font-size: 13px; color: #1E293B;">
                  <i class="fa fa-id-card text-info"></i> Signatory Identity Proof
                </strong>
                <?php if(!empty($hospital->id_proof)): ?>
                  <span class="label label-success">Uploaded</span>
                <?php else: ?>
                  <span class="label label-default">Missing</span>
                <?php endif; ?>
              </div>
              <?php if(!empty($hospital->id_proof)): ?>
                <?php 
                $idFile = $hospital->id_proof;
                $idUrl = base_url('public/assets/upload/' . $idFile);
                if (!file_exists(FCPATH . 'public/assets/upload/' . $idFile) && file_exists(FCPATH . 'public/assets/images/hospital/' . $idFile)) {
                  $idUrl = base_url('public/assets/images/hospital/' . $idFile);
                }
              ?>
                <div style="margin-top: 8px;">
                  <a href="<?=$idUrl;?>" target="_blank" class="btn btn-xs btn-primary" style="font-weight: 600; background: #00a896; border-color: #00a896;">
                    <i class="fa fa-external-link"></i> View ID Proof
                  </a>
                </div>
              <?php else: ?>
                <p style="font-size: 12px; color: #94A3B8; margin: 4px 0 0;">No identity proof uploaded.</p>
              <?php endif; ?>
            </div>

            <!-- Document 3: Logo / Facade Photo -->
            <div style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px; background: #F8FAFC;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <strong style="font-size: 13px; color: #1E293B;">
                  <i class="fa fa-picture-o text-success"></i> Hospital Logo / Photo
                </strong>
                <?php if(!empty($hospital->drimage)): ?>
                  <span class="label label-success">Available</span>
                <?php else: ?>
                  <span class="label label-default">Default</span>
                <?php endif; ?>
              </div>
              <?php if(!empty($hospital->drimage)): ?>
                <?php 
                  $logoUrl = base_url('public/assets/images/hospital/'.$hospital->drimage);
                  if (!file_exists(FCPATH . 'public/assets/images/hospital/' . $hospital->drimage) && file_exists(FCPATH . 'public/assets/upload/' . $hospital->drimage)) {
                    $logoUrl = base_url('public/assets/upload/'.$hospital->drimage);
                  }
                ?>
                <div style="margin-top: 8px; display: flex; align-items: center; gap: 10px;">
                  <img src="<?=$logoUrl;?>" alt="Hospital Photo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #CBD5E1;">
                  <a href="<?=$logoUrl;?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600;">
                    <i class="fa fa-expand"></i> Full View
                  </a>
                </div>
              <?php else: ?>
                <p style="font-size: 12px; color: #94A3B8; margin: 4px 0 0;">Using default facility logo.</p>
              <?php endif; ?>
            </div>

          </div>
        </div>

        <!-- Portal Account & Security -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">
              <i class="fa fa-lock" style="color: #6366F1; margin-right: 6px;"></i> Portal Account Credentials
            </h3>
          </div>
          <div style="padding: 20px;">
            <table class="table table-bordered table-sm" style="margin: 0; font-size: 12.5px;">
              <tr>
                <th style="width: 40%; background: #F8FAFC; color: #475569;">Linked Portal UID</th>
                <td style="font-weight: 700; color: #0F172A;"><?=htmlspecialchars(@$hospital->uid ?: 'Not Linked');?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Registration Date</th>
                <td><?=date('d M Y, h:i A', strtotime($hospital->creat_date));?></td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Admin Approval</th>
                <td>
                  <span class="label label-<?=$isApproved ? 'success' : 'warning';?>">
                    <?=$isApproved ? 'APPROVED' : 'PENDING APPROVAL';?>
                  </span>
                </td>
              </tr>
              <tr>
                <th style="background: #F8FAFC; color: #475569;">Subscription Package</th>
                <td>
                  <span class="label label-info">
                    <?=(!empty($hospital->package) && $hospital->package=='P') ? 'Premium (Paid)' : 'Basic (Free)';?>
                  </span>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Action Quick Panel -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
          <h4 style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0 0 12px 0;">Administrative Actions</h4>
          <div style="display: flex; flex-direction: column; gap: 8px;">
            <a href="<?=base_url('doctor/clinicreg/hospitalverify/'.@$hospital->id);?>" class="btn btn-block btn-success" style="font-weight: 700; background: #10B981; border-color: #10B981; padding: 10px;">
              <i class="fa fa-check-shield"></i> Open Verification &amp; Compliance Portal
            </a>
            <a href="<?=base_url('doctor/clinicreg/updatehospital/'.@$hospital->id);?>" class="btn btn-block btn-primary" style="font-weight: 700; background: #00A896; border-color: #00A896; padding: 10px;">
              <i class="fa fa-pencil"></i> Edit Hospital Information
            </a>
            <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-block btn-info" style="font-weight: 700; background: #0284C7; border-color: #0284C7; padding: 10px;">
              <i class="fa fa-user-md"></i> Assign Doctors to this Facility
            </a>
          </div>
        </div>

      </div>
    </div>

  </section>
</div>
