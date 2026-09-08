<div class="content-wrapper" style="min-height: 900px; background-color: #f8fafc;">
  <!-- Header & Breadcrumbs -->
  <section class="content-header" style="padding: 24px 30px 15px 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
      <div>
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa fa-shield" style="color: #00a896;"></i> Hospital Verification &amp; Compliance Portal
        </h1>
        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 13px;">
          Review statutory medical accreditation documents, institutional identity proofs, and credentials.
        </p>
      </div>
      <div>
        <a href="<?=base_url('doctor/clinicreg/viewhospital');?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px;">
          <i class="fa fa-arrow-left"></i> Back to Hospital List
        </a>
        <a href="<?=base_url('doctor/clinicreg/updatehospital/'.$hospital['id']);?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; margin-left: 5px;">
          <i class="fa fa-pencil"></i> Edit Hospital
        </a>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 0 30px 40px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Status & Action Banner -->
    <?php
      $isVerified = ($hospital['verified'] == '1');
      $isApproved = ($hospital['approved'] == '1');
      $verStatus  = !empty($hospital['verification_status']) ? strtolower($hospital['verification_status']) : ($isVerified ? 'verified' : 'pending');
    ?>
    <div style="background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; margin-bottom: 25px;">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 18px;">
          <?php if (!empty($hospital['drimage'])): ?>
            <img src="<?=base_url('public/assets/images/hospital/'.$hospital['drimage']);?>" alt="Logo" style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 2px solid #e2e8f0;">
          <?php else: ?>
            <div style="width: 70px; height: 70px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700;">
              <i class="fa fa-hospital-o"></i>
            </div>
          <?php endif; ?>
          <div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
              <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;"><?=htmlspecialchars($hospital['name']);?></h2>
              <span class="label" style="background-color: #00a896; color: #fff; font-size: 11.5px; padding: 4px 10px; border-radius: 12px;">
                HOSP-<?=$hospital['id'];?>
              </span>
              <?php if ($isVerified): ?>
                <span class="label" style="background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 12px; padding: 4px 10px; border-radius: 12px;">
                  <i class="fa fa-check-circle"></i> Verified &amp; Compliant
                </span>
              <?php else: ?>
                <span class="label" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 12px; padding: 4px 10px; border-radius: 12px;">
                  <i class="fa fa-clock-o"></i> Verification Pending
                </span>
              <?php endif; ?>
            </div>
            <div style="color: #64748b; font-size: 13px; margin-top: 6px;">
              <i class="fa fa-map-marker text-danger"></i> <?=getCityName($hospital['city']);?> &nbsp;|&nbsp;
              <i class="fa fa-calendar-o"></i> Registered: <?=date('d M Y, h:i A', strtotime($hospital['creat_date']));?> &nbsp;|&nbsp;
              <i class="fa fa-building"></i> <?='Healthcare Institution';?>
            </div>
          </div>
        </div>

        <!-- Verification Toggle Actions -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
          <?php if (!$isVerified): ?>
            <form action="<?=base_url('doctor/clinicreg/hospitalverify/'.$hospital['id']);?>" method="post" style="margin: 0;">
              <input type="hidden" name="did" value="<?=$hospital['id'];?>">
              <input type="hidden" name="target_action" value="verify">
              <button type="submit" class="btn btn-success" style="font-weight: 700; padding: 9px 20px; border-radius: 8px; background: #00a896; border-color: #00a896; box-shadow: 0 2px 4px rgba(0,168,150,0.2);">
                <i class="fa fa-check-circle"></i> Approve &amp; Verify Hospital
              </button>
            </form>
          <?php else: ?>
            <form action="<?=base_url('doctor/clinicreg/hospitalverify/'.$hospital['id']);?>" method="post" style="margin: 0;">
              <input type="hidden" name="did" value="<?=$hospital['id'];?>">
              <input type="hidden" name="target_action" value="unverify">
              <button type="submit" class="btn btn-warning" style="font-weight: 600; padding: 9px 18px; border-radius: 8px;" onclick="return confirm('Are you sure you want to revoke verification for this hospital?');">
                <i class="fa fa-times-circle"></i> Revoke Verification
              </button>
            </form>
          <?php endif; ?>
          <a href="<?=base_url('doctor/clinicreg/hospital_doctor/'.$hospital['id']);?>" class="btn btn-info" style="font-weight: 600; padding: 9px 16px; border-radius: 8px;">
            <i class="fa fa-user-md"></i> Affiliated Doctors (<?=count($affiliated_doctors);?>)
          </a>
        </div>
      </div>
    </div>

    <!-- Verification Documents & Details Grid -->
    <div class="row">
      <!-- Left Column: Verification Documents -->
      <div class="col-md-7">
        <div class="box box-primary" style="border-radius: 12px; border-top: 3px solid #00a896; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 25px;">
          <div class="box-header with-border" style="padding: 16px 20px;">
            <h3 class="box-title" style="font-weight: 700; color: #1e293b; font-size: 16px;">
              <i class="fa fa-file-text-o text-primary"></i> Statutory Verification Documents
            </h3>
          </div>
          <div class="box-body" style="padding: 20px;">
            
            <!-- 1. Medical Registration Proof -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; margin-bottom: 20px;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div>
                  <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">
                    <i class="fa fa-certificate text-warning"></i> Medical Registration / Hospital License Proof
                  </h4>
                  <small style="color: #64748b;">Clinical Establishment License / State Health Authority Certificate</small>
                </div>
                <?php if (!empty($hospital['med_reg_proof'])): ?>
                  <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 10px;"><i class="fa fa-check"></i> Uploaded</span>
                <?php else: ?>
                  <span class="label label-danger" style="font-size: 11px; padding: 4px 8px; border-radius: 10px;"><i class="fa fa-times"></i> Missing</span>
                <?php endif; ?>
              </div>

              <?php if (!empty($hospital['med_reg_proof'])): 
                $med_path = 'public/assets/images/hospital/' . $hospital['med_reg_proof'];
                $is_pdf = (strtolower(pathinfo($hospital['med_reg_proof'], PATHINFO_EXTENSION)) === 'pdf');
              ?>
                <div style="margin-top: 10px;">
                  <?php if (!$is_pdf): ?>
                    <a href="<?=base_url($med_path);?>" target="_blank" title="Click to view full size">
                      <img src="<?=base_url($med_path);?>" style="max-width: 100%; max-height: 240px; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: block; margin-bottom: 10px;">
                    </a>
                  <?php else: ?>
                    <div style="padding: 30px; text-align: center; background: #fff; border-radius: 8px; border: 1px dashed #cbd5e1; margin-bottom: 10px;">
                      <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                      <p style="margin: 10px 0 0 0; font-weight: 600; color: #334155;"><?=$hospital['med_reg_proof'];?></p>
                    </div>
                  <?php endif; ?>
                  <a href="<?=base_url($med_path);?>" target="_blank" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                    <i class="fa fa-external-link"></i> View Full Document
                  </a>
                  <a href="<?=base_url($med_path);?>" download class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px; margin-left: 6px;">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #94a3b8; background: #ffffff; border-radius: 8px; border: 1px dashed #e2e8f0;">
                  <i class="fa fa-exclamation-triangle fa-2x" style="opacity: 0.4; margin-bottom: 8px; display: block;"></i>
                  No medical registration certificate uploaded by this institution yet.
                </div>
              <?php endif; ?>
            </div>

            <!-- 2. Legal ID Proof -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div>
                  <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">
                    <i class="fa fa-id-card-o text-info"></i> Legal Representative ID Proof
                  </h4>
                  <small style="color: #64748b;">Aadhaar / PAN / Authorized Signatory Identity Proof</small>
                </div>
                <?php if (!empty($hospital['id_proof'])): ?>
                  <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 10px;"><i class="fa fa-check"></i> Uploaded</span>
                <?php else: ?>
                  <span class="label label-danger" style="font-size: 11px; padding: 4px 8px; border-radius: 10px;"><i class="fa fa-times"></i> Missing</span>
                <?php endif; ?>
              </div>

              <?php if (!empty($hospital['id_proof'])): 
                $id_path = 'public/assets/images/hospital/' . $hospital['id_proof'];
                $is_id_pdf = (strtolower(pathinfo($hospital['id_proof'], PATHINFO_EXTENSION)) === 'pdf');
              ?>
                <div style="margin-top: 10px;">
                  <?php if (!$is_id_pdf): ?>
                    <a href="<?=base_url($id_path);?>" target="_blank" title="Click to view full size">
                      <img src="<?=base_url($id_path);?>" style="max-width: 100%; max-height: 240px; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: block; margin-bottom: 10px;">
                    </a>
                  <?php else: ?>
                    <div style="padding: 30px; text-align: center; background: #fff; border-radius: 8px; border: 1px dashed #cbd5e1; margin-bottom: 10px;">
                      <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                      <p style="margin: 10px 0 0 0; font-weight: 600; color: #334155;"><?=$hospital['id_proof'];?></p>
                    </div>
                  <?php endif; ?>
                  <a href="<?=base_url($id_path);?>" target="_blank" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                    <i class="fa fa-external-link"></i> View Full Document
                  </a>
                  <a href="<?=base_url($id_path);?>" download class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px; margin-left: 6px;">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #94a3b8; background: #ffffff; border-radius: 8px; border: 1px dashed #e2e8f0;">
                  <i class="fa fa-exclamation-triangle fa-2x" style="opacity: 0.4; margin-bottom: 8px; display: block;"></i>
                  No representative identity proof uploaded for this institution.
                </div>
              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>

      <!-- Right Column: Institutional Details & Contact -->
      <div class="col-md-5">
        <div class="box box-info" style="border-radius: 12px; border-top: 3px solid #0284c7; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 25px;">
          <div class="box-header with-border" style="padding: 16px 20px;">
            <h3 class="box-title" style="font-weight: 700; color: #1e293b; font-size: 16px;">
              <i class="fa fa-info-circle text-info"></i> Institutional Information
            </h3>
          </div>
          <div class="box-body" style="padding: 20px;">
            <table class="table table-bordered" style="margin: 0; font-size: 13.5px;">
              <tbody>
                <tr>
                  <th style="width: 38%; background: #f8fafc; color: #64748b; font-weight: 600;">Facility Name</th>
                  <td style="font-weight: 700; color: #1e293b;"><?=htmlspecialchars($hospital['name']);?></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Facility Type</th>
                  <td><?='<span class="label label-primary" style="background:#0284c7!important;">Hospital / Medical Center</span>';?></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">City</th>
                  <td><i class="fa fa-map-marker text-danger"></i> <?=getCityName($hospital['city']);?></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Address</th>
                  <td><?=!empty($hospital['address']) ? htmlspecialchars($hospital['address']) : '<em class="text-muted">Not specified</em>';?></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Official Email</th>
                  <td><a href="mailto:<?=$hospital['email'];?>"><i class="fa fa-envelope-o"></i> <?=$hospital['email'];?></a></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Contact Phone</th>
                  <td><a href="tel:<?=$hospital['mobile'];?>"><i class="fa fa-phone"></i> <?=$hospital['mobile'];?></a></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Official Website</th>
                  <td>
                    <?php if (!empty($hospital['website'])): ?>
                      <a href="<?=$hospital['website'];?>" target="_blank"><i class="fa fa-globe"></i> <?=$hospital['website'];?></a>
                    <?php else: ?>
                      <em class="text-muted">Not provided</em>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">User Account (UID)</th>
                  <td><span class="badge bg-purple">UID-<?=$hospital['uid'];?></span></td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Subscription</th>
                  <td>
                    <?php if ($hospital['subscription'] == '1'): ?>
                      <span class="label label-success"><i class="fa fa-star"></i> Premium Active</span>
                    <?php else: ?>
                      <span class="label label-default">Standard</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th style="background: #f8fafc; color: #64748b; font-weight: 600;">Registration Date</th>
                  <td><?=date('d F Y, H:i', strtotime($hospital['creat_date']));?></td>
                </tr>
              </tbody>
            </table>

            <?php if (!empty($hospital['about'])): ?>
              <div style="margin-top: 18px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                <label style="font-size: 13px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">About / Institutional Overview:</label>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0; white-space: pre-wrap;"><?=htmlspecialchars($hospital['about']);?></p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Affiliated Doctors Preview -->
        <div class="box box-solid" style="border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
          <div class="box-header with-border" style="padding: 14px 20px; display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title" style="font-weight: 700; color: #1e293b; font-size: 15px;">
              <i class="fa fa-user-md text-success"></i> Affiliated Doctors (<?=count($affiliated_doctors);?>)
            </h3>
            <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>" class="btn btn-xs btn-primary" style="font-weight: 600; border-radius: 4px; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Assign New
            </a>
          </div>
          <div class="box-body" style="padding: 10px 20px 15px 20px;">
            <?php if (!empty($affiliated_doctors)): ?>
              <ul style="list-style: none; padding: 0; margin: 0;">
                <?php foreach (array_slice($affiliated_doctors, 0, 5) as $doc): ?>
                  <li style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                      <strong style="color: #1e293b; font-size: 13px;">Dr. <?=htmlspecialchars($doc['fname'].' '.$doc['lname']);?></strong>
                      <div style="font-size: 11.5px; color: #64748b;">
                        <?=!empty($doc['speciality']) ? htmlspecialchars($doc['speciality']) : 'General Practitioner';?> &bull; Fee: Rs. <?=floatval($doc['fee']);?>
                      </div>
                    </div>
                    <a href="<?=base_url('doctor/clinicreg/doctor_fee_time/'.$doc['practice_id']);?>" class="btn btn-xs btn-default" title="Doctor Fee &amp; Timings">
                      <i class="fa fa-clock-o"></i> Timings
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
              <?php if (count($affiliated_doctors) > 5): ?>
                <div style="text-align: center; margin-top: 10px;">
                  <a href="<?=base_url('doctor/clinicreg/hospital_doctor/'.$hospital['id']);?>" style="font-size: 12px; font-weight: 600; color: #00a896;">
                    View all <?=count($affiliated_doctors);?> affiliated doctors &rarr;
                  </a>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div style="text-align: center; padding: 20px; color: #94a3b8;">
                <i class="fa fa-user-md fa-2x" style="opacity: 0.3; margin-bottom: 5px; display: block;"></i>
                No doctors currently affiliated with this hospital.
              </div>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
