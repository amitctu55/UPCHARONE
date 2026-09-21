<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
          Master Diagnostic Test Creator
        </h1>
        <p style="margin: 0; color: #64748b; font-size: 13px;">Define clinical specifications, vacutainer container codes, reference requirements, and base pricing</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('doctor/pathology/dashboard')?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #cbd5e1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-dashboard text-muted"></i> Dashboard
        </a>
        <a href="<?=base_url('doctor/pathtest/index')?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: 1px solid #cbd5e1; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-list text-muted"></i> Master Tests Directory
        </a>
        <a href="<?=base_url('doctor/pathology/index')?>" class="btn" style="background: #00a896; color: #ffffff; font-weight: 600; padding: 8px 16px; border-radius: 8px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; box-shadow: 0 2px 4px rgba(0,168,150,0.25);">
          <i class="fa fa-link"></i> Lab Assignments
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 16px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <div style="max-width: 960px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden;">
      <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; align-items: center; justify-content: space-between;">
        <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
          <i class="fa fa-flask" style="color: #00a896;"></i> Diagnostic Catalog Definition Form
        </h3>
        <span class="badge" style="background: #0284c7; font-size: 11px; padding: 4px 8px;">Master Dictionary</span>
      </div>

      <form id="master-test-form" action="<?=base_url('doctor/pathology/add')?>" method="post" style="padding: 24px;">
        
        <!-- SECTION 1: Test Identity -->
        <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 18px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-stethoscope text-primary"></i> 1. Test Identity &amp; Classification
          </h4>
        </div>

        <div class="row">
          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Unique Test Code <span style="color: #ef4444;">*</span></label>
            <input type="text" name="code" id="code" class="form-control" placeholder="e.g. UP-CBC-01" value="<?=set_value('code', 'UP-TEST-' . rand(100, 999));?>" required style="height: 40px; border-radius: 6px; font-weight: 700; font-family: monospace;">
          </div>
          <div class="col-md-8 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Full Test Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="test_name" id="test_name" class="form-control" placeholder="e.g. Complete Blood Count (CBC) with ESR" value="<?=set_value('test_name');?>" required minlength="3" style="height: 40px; border-radius: 6px;">
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Short Name / Alias</label>
            <input type="text" name="short_name" id="short_name" class="form-control" placeholder="e.g. CBC, Hemogram" value="<?=set_value('short_name');?>" style="height: 40px; border-radius: 6px;">
          </div>
          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Clinical Department <span style="color: #ef4444;">*</span></label>
            <select name="department" id="department" class="form-control" required style="height: 40px; border-radius: 6px; font-weight: 600;">
              <option value="Biochemistry" <?=set_value('department')=='Biochemistry' ? 'selected' : ''?>>Biochemistry</option>
              <option value="Hematology" <?=set_value('department')=='Hematology' ? 'selected' : ''?>>Hematology</option>
              <option value="Microbiology" <?=set_value('department')=='Microbiology' ? 'selected' : ''?>>Microbiology</option>
              <option value="Histopathology" <?=set_value('department')=='Histopathology' ? 'selected' : ''?>>Histopathology</option>
              <option value="Immunology" <?=set_value('department')=='Immunology' ? 'selected' : ''?>>Immunology &amp; Serology</option>
              <option value="Radiology" <?=set_value('department')=='Radiology' ? 'selected' : ''?>>Radiology &amp; Imaging</option>
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Analytical Method</label>
            <input type="text" name="method" id="method" class="form-control" placeholder="e.g. Automated Flow Cytometry / Photometry" value="<?=set_value('method', 'Automated Analyzer');?>" style="height: 40px; border-radius: 6px;">
          </div>
        </div>

        <!-- SECTION 2: Specimen & Collection Protocol -->
        <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin: 24px 0 18px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-eyedropper text-danger"></i> 2. Specimen &amp; Phlebotomy Specifications
          </h4>
        </div>

        <div class="row">
          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Specimen Matrix <span style="color: #ef4444;">*</span></label>
            <select name="specimen_type" id="specimen_type" class="form-control" required style="height: 40px; border-radius: 6px;">
              <option value="Whole Blood EDTA">Whole Blood (EDTA)</option>
              <option value="Serum">Serum (Clotted Blood)</option>
              <option value="Plasma (Citrate)">Plasma (Sodium Citrate)</option>
              <option value="Plasma (Fluoride)">Plasma (Fluoride / Sugar)</option>
              <option value="Plasma (Heparin)">Plasma (Heparin)</option>
              <option value="Spot Urine">Spot Urine Sample</option>
              <option value="24-Hour Urine">24-Hour Urine Collection</option>
              <option value="Nasopharyngeal Swab">Nasopharyngeal / Throat Swab</option>
              <option value="Stool Sample">Stool Sample</option>
              <option value="Sputum">Sputum</option>
              <option value="Tissue Biopsy">Tissue Biopsy</option>
            </select>
          </div>

          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Tube / Vacutainer Color Code <span style="color: #ef4444;">*</span></label>
            <select name="container_color" id="container_color" class="form-control" required style="height: 40px; border-radius: 6px; font-weight: 600;" onchange="updateTubePreview(this.value)">
              <option value="Purple (EDTA)">🟣 Purple / Lavender (K2/K3 EDTA)</option>
              <option value="Gold/Red (SST)">🟡 Gold / Red (SST Gel Clot Activator)</option>
              <option value="Grey (Fluoride)">⚪ Grey (Sodium Fluoride / Oxalate)</option>
              <option value="Blue (Citrate)">🔵 Light Blue (3.2% Sodium Citrate)</option>
              <option value="Green (Heparin)">🟢 Green (Sodium / Lithium Heparin)</option>
              <option value="Red (Plain)">🔴 Plain Red (No Additive)</option>
              <option value="Yellow (ACD)">🟡 Yellow (ACD Solution)</option>
              <option value="Sterile Container">⚪ Sterile Universal Container</option>
            </select>
          </div>

          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Patient Fasting Required?</label>
            <div style="padding-top: 6px; display: flex; align-items: center; gap: 20px;">
              <label style="font-weight: 600; font-size: 13px; color: #1e293b; cursor: pointer; margin: 0;">
                <input type="radio" name="fasting_required" value="1" style="accent-color: #00a896;"> Yes (8-12 hrs)
              </label>
              <label style="font-weight: 600; font-size: 13px; color: #64748b; cursor: pointer; margin: 0;">
                <input type="radio" name="fasting_required" value="0" checked style="accent-color: #00a896;"> No Fasting
              </label>
            </div>
          </div>
        </div>

        <!-- SECTION 3: Turnaround Time & Base Pricing -->
        <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin: 24px 0 18px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
            <i class="fa fa-clock-o text-warning"></i> 3. TAT SLA &amp; Master Pricing
          </h4>
        </div>

        <div class="row">
          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Standard TAT (Hours) <span style="color: #ef4444;">*</span></label>
            <div class="input-group">
              <input type="number" name="standard_tat_hours" id="standard_tat_hours" class="form-control" placeholder="24" value="<?=set_value('standard_tat_hours', '24');?>" min="1" required style="height: 40px; border-radius: 6px 0 0 6px;">
              <span class="input-group-addon" style="font-weight: 700;">Hours</span>
            </div>
          </div>

          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">System Base Price (₹) <span style="color: #ef4444;">*</span></label>
            <div class="input-group">
              <span class="input-group-addon" style="font-weight: 700;">₹</span>
              <input type="number" step="1" name="amount" id="amount" class="form-control" placeholder="e.g. 450" value="<?=set_value('amount', '350');?>" min="0" required style="height: 40px; border-radius: 0 6px 6px 0; font-weight: 700; font-size: 15px; color: #0f172a;">
            </div>
          </div>

          <div class="col-md-4 form-group">
            <label style="font-weight: 600; font-size: 13px; color: #334155;">Recommended Patient Price</label>
            <div class="input-group">
              <span class="input-group-addon" style="font-weight: 700;">₹</span>
              <input type="text" id="rec_patient_price" class="form-control" readonly value="₹ 402.50 (incl. 15% Platform Fee)" style="height: 40px; border-radius: 0 6px 6px 0; font-weight: 600; background: #f8fafc; color: #15803d;">
            </div>
          </div>
        </div>

        <div class="form-group" style="margin-top: 10px;">
          <label style="font-weight: 600; font-size: 13px; color: #334155;">Clinical Significance &amp; Patient Preparation Instructions</label>
          <textarea name="method_details" class="form-control" rows="3" placeholder="Explain test utility, fasting guidelines, or medications to avoid prior to collection..." style="border-radius: 6px;"></textarea>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 20px; margin-top: 24px;">
          <a href="<?=base_url('doctor/pathology/index')?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px; padding: 9px 20px;">
            Cancel
          </a>
          <button type="submit" name="submit" value="Save" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; padding: 9px 28px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,168,150,0.3);">
            <i class="fa fa-check-circle" style="margin-right: 6px;"></i> Publish Master Diagnostic Test
          </button>
        </div>

      </form>
    </div>
  </section>
</div>

<script>
$('#amount').on('input', function() {
  var base = parseFloat($(this).val()) || 0;
  var rec = base + (base * 0.15);
  $('#rec_patient_price').val('₹ ' + rec.toFixed(2) + ' (incl. 15% Platform Fee)');
});
</script>
