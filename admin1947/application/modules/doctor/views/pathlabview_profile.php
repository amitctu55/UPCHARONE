<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Pathology Lab Profile Details
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">View laboratory details, ownership credentials, verification status, and offered tests catalog</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('doctor/pathlabreg/viewpathology')?>" class="btn" style="background: #F1F5F9; color: #334155; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #CBD5E1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-arrow-left"></i> Back to Directory
        </a>
        <a href="<?=base_url('doctor/pathlabreg/pathlabupdate/'.@$pathlab->id)?>" class="btn" style="background: #00a896; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 8px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
          <i class="fa fa-pencil"></i> Edit Profile
        </a>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 15px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <style>
      .badge-pill-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
      }
      .badge-status-active {
        background: #D1FAE5;
        color: #065F46;
      }
      .badge-status-inactive {
        background: #FEE2E2;
        color: #991B1B;
      }
      .detail-info-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
      }
      .detail-info-value {
        font-size: 14px;
        font-weight: 600;
        color: #0F172A;
      }
    </style>

    <div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: flex-start;">
      
      <!-- Left Column: Lab Profile Card & Verification Media -->
      <div style="display: flex; flex-direction: column; gap: 20px; position: sticky; top: 20px;">
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px; text-align: center;">
          
          <div style="width: 110px; height: 110px; border-radius: 16px; overflow: hidden; margin: 0 auto 16px; border: 3px solid #00a896; box-shadow: 0 4px 10px rgba(0,168,150,0.15); background: #F0FDFA; display: flex; align-items: center; justify-content: center;">
            <?php 
              $lab_img = !empty($pathlab->drimage) ? $pathlab->drimage : (!empty($pathlab->id_proof) ? $pathlab->id_proof : '');
            ?>
            <?php if(!empty($lab_img) && file_exists(FCPATH . 'public/assets/upload/' . $lab_img)): ?>
              <img src="<?=base_url('public/assets/upload/'.html_escape($lab_img));?>" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
              <i class="fa fa-flask" style="font-size: 44px; color: #00a896;"></i>
            <?php endif; ?>
          </div>

          <h2 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 4px 0;">
            <?=html_escape(@$pathlab->name);?>
          </h2>
          <div style="font-size: 13px; color: #00a896; font-weight: 600; margin-bottom: 14px;">
            Pathlab #<?=html_escape(@$pathlab->id);?>
          </div>

          <!-- Status Badges -->
          <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 16px; flex-wrap: wrap;">
            <span class="badge-pill-status <?=(@$pathlab->verified == 1)? 'badge-status-active' : 'badge-status-inactive';?>">
              <i class="fa fa-check-circle"></i> <?=(@$pathlab->verified == 1)? 'Verified' : 'Unverified';?>
            </span>
            <span class="badge-pill-status <?=(@$pathlab->approved == 1)? 'badge-status-active' : 'badge-status-inactive';?>">
              <i class="fa fa-circle" style="font-size: 7px;"></i> <?=(@$pathlab->approved == 1)? 'Approved' : 'Pending';?>
            </span>
            <span class="badge-pill-status <?=(@$pathlab->status == '1' || @$pathlab->status == 'A')? 'badge-status-active' : 'badge-status-inactive';?>">
              <?=(@$pathlab->status == '1' || @$pathlab->status == 'A')? 'Active' : 'Inactive';?>
            </span>
          </div>

          <!-- Contact Quick Details -->
          <div style="border-top: 1px solid #F1F5F9; padding-top: 16px; text-align: left; display: flex; flex-direction: column; gap: 10px;">
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-envelope-o" style="width: 20px; color: #00a896;"></i> <?=html_escape(@$pathlab->email ?: 'Not Provided');?>
            </div>
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-phone" style="width: 20px; color: #00a896;"></i> <?=html_escape(@$pathlab->mobile ?: 'Not Provided');?>
            </div>
            <div style="font-size: 13px; color: #475569;">
              <i class="fa fa-map-marker" style="width: 20px; color: #00a896;"></i> <?=getCityName(@$pathlab->city);?> <?=!empty($pathlab->location) ? '('.html_escape($pathlab->location).')' : '';?>
            </div>
          </div>
        </div>

        <!-- Verification Proof Documents Card -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
          <h4 style="margin: 0 0 14px 0; font-size: 14px; font-weight: 700; color: #0F172A; text-transform: uppercase;">
            <i class="fa fa-file-text-o" style="color: #00a896; margin-right: 6px;"></i> Verification Credentials
          </h4>
          <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center;">
            
            <!-- 1. Lab Ownership Proof -->
            <div>
              <?php if(!empty($pathlab->drimage)): ?>
                <a href="<?=base_url('public/assets/upload/'.html_escape($pathlab->drimage));?>" target="_blank">
                  <img src="<?=base_url('public/assets/upload/'.html_escape($pathlab->drimage));?>" style="width: 100%; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;">
                </a>
              <?php else: ?>
                <div style="height: 75px; background: #F8FAFC; border-radius: 8px; border: 1px dashed #CBD5E1; display: flex; align-items: center; justify-content: center; color: #94A3B8;">
                  <i class="fa fa-image" style="font-size: 20px;"></i>
                </div>
              <?php endif; ?>
              <div style="font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 600;">Lab Proof</div>
            </div>

            <!-- 2. Display Pic / Logo -->
            <div>
              <?php if(!empty($pathlab->id_proof)): ?>
                <a href="<?=base_url('public/assets/upload/'.html_escape($pathlab->id_proof));?>" target="_blank">
                  <img src="<?=base_url('public/assets/upload/'.html_escape($pathlab->id_proof));?>" style="width: 100%; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;">
                </a>
              <?php else: ?>
                <div style="height: 75px; background: #F8FAFC; border-radius: 8px; border: 1px dashed #CBD5E1; display: flex; align-items: center; justify-content: center; color: #94A3B8;">
                  <i class="fa fa-image" style="font-size: 20px;"></i>
                </div>
              <?php endif; ?>
              <div style="font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 600;">Logo Photo</div>
            </div>

            <!-- 3. Registration Certificate -->
            <div>
              <?php if(!empty($pathlab->med_reg_proof)): ?>
                <a href="<?=base_url('public/assets/upload/'.html_escape($pathlab->med_reg_proof));?>" target="_blank">
                  <img src="<?=base_url('public/assets/upload/'.html_escape($pathlab->med_reg_proof));?>" style="width: 100%; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;">
                </a>
              <?php else: ?>
                <div style="height: 75px; background: #F8FAFC; border-radius: 8px; border: 1px dashed #CBD5E1; display: flex; align-items: center; justify-content: center; color: #94A3B8;">
                  <i class="fa fa-certificate" style="font-size: 20px;"></i>
                </div>
              <?php endif; ?>
              <div style="font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 600;">Registration</div>
            </div>

          </div>
        </div>
      </div>

      <!-- Right Column: Details & Tests -->
      <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Laboratory Primary Overview -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-hospital-o" style="color: #00a896; margin-right: 8px;"></i> Laboratory Information
            </h3>
          </div>

          <div style="padding: 20px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px;">
            <div>
              <div class="detail-info-label">Pathology Lab Name</div>
              <div class="detail-info-value"><?=html_escape(@$pathlab->name);?></div>
            </div>
            <div>
              <div class="detail-info-label">City Coverage</div>
              <div class="detail-info-value"><?=getCityName(@$pathlab->city);?></div>
            </div>
            <div>
              <div class="detail-info-label">Locality / Sector</div>
              <div class="detail-info-value"><?=html_escape(@$pathlab->location ?: 'Not specified');?></div>
            </div>
            <div>
              <div class="detail-info-label">Contact Email</div>
              <div class="detail-info-value"><?=html_escape(@$pathlab->email ?: 'N/A');?></div>
            </div>
            <div style="grid-column: span 2;">
              <div class="detail-info-label">Full Clinical Address</div>
              <div class="detail-info-value"><?=html_escape(@$pathlab->address ?: 'No address specified');?></div>
            </div>
          </div>
        </div>

        <!-- Offered Medical & Diagnostic Tests Table -->
        <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
          <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="fa fa-flask" style="color: #00a896; margin-right: 8px;"></i> Diagnostic Tests Catalog (<?=!empty($tests) ? count($tests) : 0;?>)
            </h3>
            <a href="<?=base_url('doctor/pathtest/addtest');?>" class="btn btn-xs btn-primary" style="background: #00a896; border: none; font-weight: 600; border-radius: 6px; padding: 4px 12px;">
              <i class="fa fa-plus"></i> Add Test
            </a>
          </div>

          <div style="padding: 0;">
            <div class="table-responsive">
              <table class="table table-hover" style="margin: 0; font-size: 13px;">
                <thead>
                  <tr style="background: #F8FAFC; color: #64748B;">
                    <th style="padding: 12px 20px;">#</th>
                    <th>Test Name</th>
                    <th>Price (₹)</th>
                    <th>Discount Price (₹)</th>
                    <th style="text-align: center;">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($tests)): $i = 1; foreach($tests as $t): ?>
                    <tr>
                      <td style="padding: 12px 20px; font-weight: 600; color: #64748B;"><?=$i++;?></td>
                      <td style="font-weight: 600; color: #0F172A;"><?=html_escape($t->test_name);?></td>
                      <td style="color: #64748B; text-decoration: line-through;">₹<?=html_escape($t->price);?></td>
                      <td style="font-weight: 700; color: #00a896;">₹<?=html_escape($t->discount_price ?: $t->price);?></td>
                      <td style="text-align: center;">
                        <span class="badge-pill-status <?=(@$t->status == 1)? 'badge-status-active' : 'badge-status-inactive';?>">
                          <?=(@$t->status == 1)? 'Available' : 'Disabled';?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="5" style="text-align: center; padding: 30px; color: #94A3B8;">
                        <i class="fa fa-flask" style="font-size: 32px; margin-bottom: 8px; display: block; color: #CBD5E1;"></i>
                        No specific diagnostic tests listed for this pathlab center.
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
  </section>
</div>
