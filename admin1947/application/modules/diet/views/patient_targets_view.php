<style>
:root {
  --dt-teal: #00a896;
  --dt-navy: #1d2a44;
  --dt-slate: #334155;
  --dt-border: #e2e8f0;
}

.pt-card {
  background: #fff;
  border: 1px solid var(--dt-border);
  border-radius: 10px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
  margin-bottom: 20px;
  overflow: hidden;
}

.pt-card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--dt-border);
  background: #fafbfc;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.pt-vitals-strip {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
  gap: 12px;
  padding: 16px 20px;
  background: #f8fafc;
  border-bottom: 1px solid var(--dt-border);
}

.pt-vital-box {
  background: #fff;
  border: 1px solid #edf2f7;
  border-radius: 8px;
  padding: 10px 14px;
}
.pt-vital-lbl {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  color: #64748b;
  margin-bottom: 2px;
}
.pt-vital-val {
  font-size: 16px;
  font-weight: 800;
  color: #0f172a;
}

.macro-preset-btn {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 12px;
  border-radius: 6px;
  border: 1px solid #cbd5e1;
  background: #fff;
  color: #475569;
  cursor: pointer;
  transition: all 0.15s;
}
.macro-preset-btn:hover {
  border-color: var(--dt-teal);
  color: var(--dt-teal);
  background: #f0fdf4;
}

.autocomplete-dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: #fff;
  border: 1px solid #cbd5e1;
  border-radius: 0 0 8px 8px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  max-height: 250px;
  overflow-y: auto;
  z-index: 1050;
  display: none;
}
.autocomplete-item {
  padding: 10px 14px;
  border-bottom: 1px solid #f1f5f9;
  cursor: pointer;
  font-size: 13px;
}
.autocomplete-item:hover {
  background: #f8fafc;
}
</style>

<div class="content-wrapper">
<section class="content">
<div style="padding: 15px 5px 30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

  <!-- Flash Message -->
  <?php if($this->session->flashdata('flashmsg')): ?>
    <div style="margin-bottom: 16px;">
      <?=$this->session->flashdata('flashmsg');?>
    </div>
  <?php endif; ?>

  <!-- Top Banner -->
  <div style="background: linear-gradient(135deg, #1d2a44 0%, #1e3a5f 100%); border-radius: 10px; padding: 22px 25px; color: #fff; margin-bottom: 22px; box-shadow: 0 8px 20px -4px rgba(29, 42, 68, 0.25); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
      <h1 style="font-size: 22px; font-weight: 800; margin: 0 0 5px; color: #fff; display: flex; align-items: center; gap: 10px;">
        <i class="fa fa-bullseye" style="color: #2dd4bf;"></i> Patient Clinical Diet Targets
      </h1>
      <p style="font-size: 13px; color: #94a3b8; margin: 0;">
        Manually adjust and clinically override personalized daily calorie, macronutrient, and micronutrient thresholds
      </p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
      <a href="<?=base_url('diet/foods');?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600; color: #fff; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
        <i class="fa fa-cutlery"></i> Food Catalog
      </a>
      <a href="<?=base_url('users/patient');?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600; color: #fff; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
        <i class="fa fa-users"></i> Patient Dossiers
      </a>
    </div>
  </div>

  <!-- Search Patient Card -->
  <div class="pt-card">
    <div class="pt-card-header">
      <strong style="font-size: 14px; color: #0f172a;">
        <i class="fa fa-search" style="color: #00a896;"></i> Select Patient to Configure Daily Targets
      </strong>
      <?php if(!empty($patient_data)): ?>
        <a href="<?=base_url('diet/logs/' . $patient_data['user_id']);?>" class="btn btn-xs btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700;">
          <i class="fa fa-eye"></i> View This Patient's Logs
        </a>
      <?php endif; ?>
    </div>
    <div style="padding: 16px 20px;">
      <div style="position: relative; max-width: 600px;">
        <div class="input-group">
          <input type="text" id="patientSearchInput" class="form-control" placeholder="Search patient by Name, Phone, Email, or Patient ID..." autocomplete="off" style="height: 42px; font-size: 14px;">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button" onclick="triggerPatientSearch()" style="height: 42px; background: #00a896; border-color: #00a896;">
              <i class="fa fa-search"></i> Search
            </button>
          </span>
        </div>
        <div id="patientDropdown" class="autocomplete-dropdown"></div>
      </div>
    </div>
  </div>

  <?php if(!empty($patient_data)): ?>
    <!-- Active Patient Target Editor -->
    <div class="pt-card">
      
      <!-- Patient Header Strip -->
      <div class="pt-card-header" style="background: #f8fafc;">
        <div>
          <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 3px;">
            <?=html_escape($patient_data['full_name'] ?: 'Patient #' . $patient_data['user_id']);?>
            <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-weight: 700; margin-left: 6px;">
              UPC-<?=str_pad($patient_data['user_id'], 5, '0', STR_PAD_LEFT);?>
            </span>
            <?php if($patient_data['is_custom_override']): ?>
              <span style="font-size: 11px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 2px 8px; border-radius: 4px; font-weight: 700; margin-left: 6px;">
                <i class="fa fa-stethoscope"></i> Clinical Override Active
              </span>
            <?php else: ?>
              <span style="font-size: 11px; background: #fef3c7; color: #b45309; padding: 2px 8px; border-radius: 4px; font-weight: 700; margin-left: 6px;">
                <i class="fa fa-bolt"></i> Auto Mifflin-St Jeor Defaults
              </span>
            <?php endif; ?>
          </h3>
          <div style="font-size: 12px; color: #64748b;">
            <span><i class="fa fa-envelope-o"></i> <?=html_escape($patient_data['email'] ?: 'No email');?></span> | 
            <span><i class="fa fa-phone"></i> <?=html_escape($patient_data['mobile'] ?: 'No mobile');?></span>
          </div>
        </div>
        <div>
          <a href="<?=base_url('diet/logs/' . $patient_data['user_id']);?>" class="btn btn-sm btn-default" style="font-weight: 600;">
            <i class="fa fa-calendar"></i> Check Today's Food Logs
          </a>
        </div>
      </div>

      <!-- Vitals Strip -->
      <div class="pt-vitals-strip">
        <div class="pt-vital-box">
          <div class="pt-vital-lbl">Gender / Age</div>
          <div class="pt-vital-val"><?=($patient_data['gender'] === 'F' ? 'Female' : 'Male');?> / <?=$patient_data['age'];?> yrs</div>
        </div>
        <div class="pt-vital-box">
          <div class="pt-vital-lbl">Height</div>
          <div class="pt-vital-val"><?=round($patient_data['height_cm']);?> cm</div>
        </div>
        <div class="pt-vital-box">
          <div class="pt-vital-lbl">Weight</div>
          <div class="pt-vital-val"><?=round($patient_data['weight_kg'], 1);?> kg</div>
        </div>
        <div class="pt-vital-box">
          <div class="pt-vital-lbl">Calculated BMI</div>
          <div class="pt-vital-val" style="color: <?=$patient_data['bmi'] > 25 ? '#ea580c' : ($patient_data['bmi'] < 18.5 ? '#f59e0b' : '#16a34a');?>;">
            <?=$patient_data['bmi'];?>
          </div>
        </div>
        <div class="pt-vital-box">
          <div class="pt-vital-lbl">Resting BMR</div>
          <div class="pt-vital-val"><?=number_format($patient_data['bmr']);?> kcal</div>
        </div>
        <div class="pt-vital-box">
          <div class="pt-vital-lbl">Estimated TDEE</div>
          <div class="pt-vital-val" style="color: #0284c7;"><?=number_format($patient_data['tdee']);?> kcal</div>
        </div>
      </div>

      <!-- Target Override Form -->
      <form action="<?=base_url('diet/targets/' . $patient_data['user_id']);?>" method="post" style="padding: 24px;">
        <input type="hidden" name="patient_id" value="<?=$patient_data['user_id'];?>">
        <input type="hidden" name="height_cm" value="<?=$patient_data['height_cm'];?>">
        <input type="hidden" name="weight_kg" value="<?=$patient_data['weight_kg'];?>">

        <!-- Preset Buttons -->
        <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
          <span style="font-size: 13px; font-weight: 700; color: #334155;">
            <i class="fa fa-magic" style="color: #00a896;"></i> Clinical Macro Calculation Presets:
          </span>
          <div style="display: flex; gap: 6px; flex-wrap: wrap;">
            <button type="button" class="macro-preset-btn" onclick="applyMacroPreset('balanced')">Balanced (50C / 20P / 30F)</button>
            <button type="button" class="macro-preset-btn" onclick="applyMacroPreset('high_protein')">High Protein (40C / 30P / 30F)</button>
            <button type="button" class="macro-preset-btn" onclick="applyMacroPreset('weight_loss')">Weight Loss Deficit (-400 kcal)</button>
            <button type="button" class="macro-preset-btn" onclick="applyMacroPreset('diabetic')">Low Glycemic / Diabetic (35C / 30P / 35F)</button>
          </div>
        </div>

        <!-- Main Calories Target -->
        <div class="row" style="margin-bottom: 20px;">
          <div class="col-md-4 form-group">
            <label style="font-weight: 800; font-size: 13px; color: #0f172a;">Daily Caloric Target (Max kcal) <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="number" step="10" name="target_calories" id="inp_calories" value="<?=round($patient_data['target_calories']);?>" oninput="recalcGramsFromCalories()" class="form-control" required style="height: 44px; font-size: 16px; font-weight: 800; color: #ea580c;">
              <span class="input-group-addon" style="font-weight: 700;">kcal/day</span>
            </div>
            <small class="text-muted">Calculated baseline: <?=number_format($patient_data['tdee']);?> kcal/day</small>
          </div>

          <div class="col-md-4 form-group">
            <label style="font-weight: 700; font-size: 13px; color: #334155;">Activity Level</label>
            <select name="activity_level" class="form-control" style="height: 44px;">
              <option value="sedentary" <?=($patient_data['activity_level'] === 'sedentary') ? 'selected' : '';?>>Sedentary (desk work, minimal movement)</option>
              <option value="light" <?=($patient_data['activity_level'] === 'light') ? 'selected' : '';?>>Light (walks 1-3 days/week)</option>
              <option value="moderate" <?=($patient_data['activity_level'] === 'moderate') ? 'selected' : '';?>>Moderate (active 3-5 days/week)</option>
              <option value="very_active" <?=($patient_data['activity_level'] === 'very_active') ? 'selected' : '';?>>Very Active (heavy physical work / intense training)</option>
            </select>
          </div>

          <div class="col-md-4 form-group">
            <label style="font-weight: 700; font-size: 13px; color: #334155;">Clinical Goal Directives</label>
            <select name="fitness_goal" class="form-control" style="height: 44px;">
              <option value="maintain" <?=($patient_data['fitness_goal'] === 'maintain') ? 'selected' : '';?>>Maintain Healthy Weight</option>
              <option value="lose" <?=($patient_data['fitness_goal'] === 'lose') ? 'selected' : '';?>>Weight Loss / Calorie Deficit</option>
              <option value="gain" <?=($patient_data['fitness_goal'] === 'gain') ? 'selected' : '';?>>Weight Gain / Calorie Surplus</option>
              <option value="diabetic_control" <?=($patient_data['fitness_goal'] === 'diabetic_control') ? 'selected' : '';?>>Diabetic Blood Sugar Control</option>
              <option value="hypertension" <?=($patient_data['fitness_goal'] === 'hypertension') ? 'selected' : '';?>>Hypertension &amp; DASH Diet</option>
              <option value="clinical_custom" <?=($patient_data['fitness_goal'] === 'clinical_custom') ? 'selected' : '';?>>Custom Medical Nutrition Protocol</option>
            </select>
          </div>
        </div>

        <!-- Macronutrient Thresholds -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
          <h4 style="font-size: 13px; font-weight: 800; color: #334155; text-transform: uppercase; margin: 0 0 16px;">
            <i class="fa fa-pie-chart" style="color: #00a896;"></i> Daily Macronutrient Targets
          </h4>
          <div class="row">
            <div class="col-md-3 col-sm-6 form-group">
              <label style="color: #16a34a; font-weight: 700;">Protein Target (grams)</label>
              <div class="input-group">
                <input type="number" step="1" name="protein_g" id="inp_protein" value="<?=round($patient_data['protein_g']);?>" class="form-control" required style="height: 40px; font-weight: 700;">
                <span class="input-group-addon">g</span>
              </div>
              <small class="text-muted" id="prot_cal_lbl">~<?=round($patient_data['protein_g'] * 4);?> kcal</small>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
              <label style="color: #0284c7; font-weight: 700;">Carbohydrates Target (grams)</label>
              <div class="input-group">
                <input type="number" step="1" name="carbs_g" id="inp_carbs" value="<?=round($patient_data['carbs_g']);?>" class="form-control" required style="height: 40px; font-weight: 700;">
                <span class="input-group-addon">g</span>
              </div>
              <small class="text-muted" id="carb_cal_lbl">~<?=round($patient_data['carbs_g'] * 4);?> kcal</small>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
              <label style="color: #d97706; font-weight: 700;">Fats Target (grams)</label>
              <div class="input-group">
                <input type="number" step="1" name="fat_g" id="inp_fats" value="<?=round($patient_data['fat_g']);?>" class="form-control" required style="height: 40px; font-weight: 700;">
                <span class="input-group-addon">g</span>
              </div>
              <small class="text-muted" id="fat_cal_lbl">~<?=round($patient_data['fat_g'] * 9);?> kcal</small>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
              <label style="color: #7c3aed; font-weight: 700;">Dietary Fiber Target (grams)</label>
              <div class="input-group">
                <input type="number" step="1" name="fiber_g" id="inp_fiber" value="<?=round($patient_data['fiber_g']);?>" class="form-control" required style="height: 40px; font-weight: 700;">
                <span class="input-group-addon">g</span>
              </div>
              <small class="text-muted">Standard minimum: 30g</small>
            </div>
          </div>
        </div>

        <!-- Micronutrient Thresholds -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
          <h4 style="font-size: 13px; font-weight: 800; color: #334155; text-transform: uppercase; margin: 0 0 16px;">
            <i class="fa fa-flask" style="color: #0284c7;"></i> Key Micronutrient Thresholds
          </h4>
          <div class="row">
            <div class="col-md-4 form-group">
              <label style="font-weight: 700; color: #334155;">Iron (mg/day)</label>
              <div class="input-group">
                <input type="number" step="1" name="iron_mg" id="inp_iron" value="<?=round($patient_data['iron_mg']);?>" class="form-control" style="height: 40px;">
                <span class="input-group-addon">mg</span>
              </div>
              <small class="text-muted">RDA: 18mg (adult female) / 10mg (male)</small>
            </div>
            <div class="col-md-4 form-group">
              <label style="font-weight: 700; color: #334155;">Calcium (mg/day)</label>
              <div class="input-group">
                <input type="number" step="50" name="calcium_mg" id="inp_calcium" value="<?=round($patient_data['calcium_mg']);?>" class="form-control" style="height: 40px;">
                <span class="input-group-addon">mg</span>
              </div>
              <small class="text-muted">RDA: 1000mg</small>
            </div>
            <div class="col-md-4 form-group">
              <label style="font-weight: 700; color: #334155;">Vitamin C (mg/day)</label>
              <div class="input-group">
                <input type="number" step="5" name="vitamin_c_mg" id="inp_vitamin_c" value="<?=round($patient_data['vitamin_c_mg']);?>" class="form-control" style="height: 40px;">
                <span class="input-group-addon">mg</span>
              </div>
              <small class="text-muted">RDA: 75-90mg</small>
            </div>
          </div>
        </div>

        <!-- Clinical Notes -->
        <div class="form-group" style="margin-bottom: 24px;">
          <label style="font-weight: 700; color: #334155;">
            <i class="fa fa-sticky-note-o" style="color: #00a896;"></i> Clinical Dietitian Notes &amp; Special Directives (Visible on Patient Summary)
          </label>
          <textarea name="clinical_notes" rows="3" class="form-control" placeholder="e.g. Patient presents with pre-hypertension and elevated HbA1c. Limit processed carbs, maintain protein intake at 1.2g/kg, and prioritize potassium-rich foods."><?=html_escape($patient_data['clinical_notes'] ?? '');?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; padding: 12px 28px; font-size: 14px; font-weight: 700; border-radius: 6px; box-shadow: 0 4px 10px rgba(0,168,150,0.3);">
            <i class="fa fa-save"></i> Save Clinical Diet Targets
          </button>
        </div>

      </form>
    </div>
  <?php else: ?>
    <!-- Empty State -->
    <div class="pt-card" style="padding: 40px 20px; text-align: center; color: #64748b;">
      <i class="fa fa-user-circle-o" style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
      <h3 style="font-size: 16px; font-weight: 700; color: #334155; margin: 0 0 6px;">No Patient Selected</h3>
      <p style="font-size: 13px; max-width: 480px; margin: 0 auto 16px;">
        Use the search bar above to select a patient by Name, Phone Number, Email, or Patient ID to configure and override their daily diet goals.
      </p>

      <?php if(!empty($recent_patients)): ?>
        <div style="max-width: 600px; margin: 20px auto 0; text-align: left;">
          <strong style="font-size: 12px; text-transform: uppercase; color: #94a3b8; display: block; margin-bottom: 8px;">
            Recent Registered Patients:
          </strong>
          <div class="list-group">
            <?php foreach($recent_patients as $rp): ?>
              <a href="<?=base_url('diet/targets/' . $rp->id);?>" class="list-group-item" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                  <strong><?=html_escape(trim($rp->fname . ' ' . $rp->lname) ?: 'Patient #' . $rp->id);?></strong>
                  <span class="text-muted" style="font-size: 11px; margin-left: 6px;">#<?=$rp->id;?> | <?=$rp->mobile ?: $rp->email;?></span>
                </div>
                <span class="badge" style="background: <?=$rp->is_custom_override ? '#10b981' : '#cbd5e1';?>;">
                  <?=$rp->is_custom_override ? 'Custom Override' : 'Automated';?>
                </span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

</div>
</section>
</div>

<script>
var searchTimer = null;
$('#patientSearchInput').on('input', function() {
  clearTimeout(searchTimer);
  var q = $(this).val().trim();
  if (q.length < 2) {
    $('#patientDropdown').hide();
    return;
  }
  searchTimer = setTimeout(function() {
    $.getJSON('<?=base_url("diet/search_patients_ajax");?>', { q: q }, function(res) {
      if (res && res.status === 'success' && res.data && res.data.length > 0) {
        var html = '';
        res.data.forEach(function(p) {
          var name = (p.fname + ' ' + (p.lname || '')).trim() || ('Patient #' + p.id);
          var meta = (p.mobile || p.email || 'No contact');
          var badge = p.is_custom_override ? '<span class="badge" style="background: #10b981; float: right;">Override Active</span>' : '';
          html += '<div class="autocomplete-item" onclick="selectPatient(' + p.id + ')">';
          html += badge + '<strong>' + name + '</strong> <span style="color: #64748b;">(#' + p.id + ' - ' + meta + ')</span>';
          html += '</div>';
        });
        $('#patientDropdown').html(html).show();
      } else {
        $('#patientDropdown').html('<div class="autocomplete-item text-muted">No matching patients found</div>').show();
      }
    });
  }, 250);
});

function selectPatient(id) {
  window.location.href = '<?=base_url("diet/targets");?>/' + id;
}

$(document).on('click', function(e) {
  if (!$(e.target).closest('#patientSearchInput, #patientDropdown').length) {
    $('#patientDropdown').hide();
  }
});

function applyMacroPreset(preset) {
  var cal = parseFloat($('#inp_calories').val()) || 2000;

  if (preset === 'weight_loss') {
    cal = Math.max(1200, cal - 400);
    $('#inp_calories').val(cal);
    preset = 'high_protein';
  }

  var protG, carbG, fatG;

  if (preset === 'high_protein') {
    protG = Math.round((cal * 0.30) / 4);
    carbG = Math.round((cal * 0.40) / 4);
    fatG  = Math.round((cal * 0.30) / 9);
  } else if (preset === 'diabetic') {
    protG = Math.round((cal * 0.30) / 4);
    carbG = Math.round((cal * 0.35) / 4);
    fatG  = Math.round((cal * 0.35) / 9);
  } else {
    // Balanced
    protG = Math.round((cal * 0.20) / 4);
    carbG = Math.round((cal * 0.50) / 4);
    fatG  = Math.round((cal * 0.30) / 9);
  }

  $('#inp_protein').val(protG);
  $('#inp_carbs').val(carbG);
  $('#inp_fats').val(fatG);
  updateCalorieBreakdown();
}

function recalcGramsFromCalories() {
  applyMacroPreset('balanced');
}

function updateCalorieBreakdown() {
  var p = parseFloat($('#inp_protein').val()) || 0;
  var c = parseFloat($('#inp_carbs').val()) || 0;
  var f = parseFloat($('#inp_fats').val()) || 0;
  $('#prot_cal_lbl').text('~' + Math.round(p * 4) + ' kcal');
  $('#carb_cal_lbl').text('~' + Math.round(c * 4) + ' kcal');
  $('#fat_cal_lbl').text('~' + Math.round(f * 9) + ' kcal');
}

$('#inp_protein, #inp_carbs, #inp_fats').on('input', updateCalorieBreakdown);
</script>
