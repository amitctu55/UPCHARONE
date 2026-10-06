<style>
:root {
  --dt-teal: #00a896;
  --dt-navy: #1d2a44;
  --dt-slate: #334155;
  --dt-border: #e2e8f0;
}

.log-mon-card {
  background: #fff;
  border: 1px solid var(--dt-border);
  border-radius: 10px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
  margin-bottom: 20px;
  overflow: hidden;
}

.log-mon-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--dt-border);
  background: #fafbfc;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
}

.meal-block {
  border: 1px solid var(--dt-border);
  border-radius: 8px;
  margin-bottom: 16px;
  overflow: hidden;
  background: #fff;
}
.meal-block-header {
  padding: 12px 18px;
  background: #f8fafc;
  border-bottom: 1px solid var(--dt-border);
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.meal-block-title {
  font-size: 14px;
  font-weight: 800;
  color: #0f172a;
  display: flex;
  align-items: center;
  gap: 8px;
}

.prog-bar-wrap {
  background: #f1f5f9;
  border-radius: 20px;
  height: 8px;
  overflow: hidden;
  margin-top: 6px;
}
.prog-bar-fill {
  height: 100%;
  border-radius: 20px;
  transition: width 0.3s ease;
}

.autocomplete-dropdown-logs {
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
</style>

<div class="content-wrapper">
<section class="content">
<div style="padding: 15px 5px 30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

  <!-- Top Banner -->
  <div style="background: linear-gradient(135deg, #1d2a44 0%, #1e3a5f 100%); border-radius: 10px; padding: 22px 25px; color: #fff; margin-bottom: 22px; box-shadow: 0 8px 20px -4px rgba(29, 42, 68, 0.25); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
      <h1 style="font-size: 22px; font-weight: 800; margin: 0 0 5px; color: #fff; display: flex; align-items: center; gap: 10px;">
        <i class="fa fa-book" style="color: #2dd4bf;"></i> Patient Meal Logs Monitor
      </h1>
      <p style="font-size: 13px; color: #94a3b8; margin: 0;">
        Clinical review of daily patient food intake across all 5 meal categories (Breakfast, Brunch, Lunch, Snacks, Dinner)
      </p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
      <a href="<?=base_url('diet/foods');?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600; color: #fff; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
        <i class="fa fa-cutlery"></i> Food Catalog
      </a>
      <a href="<?=base_url('diet/targets' . ($patient_id ? '/' . $patient_id : ''));?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600; color: #fff; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
        <i class="fa fa-bullseye"></i> Edit Diet Targets
      </a>
    </div>
  </div>

  <!-- Search & Date Filter Card -->
  <div class="log-mon-card">
    <div class="log-mon-header">
      <strong style="font-size: 14px; color: #0f172a;">
        <i class="fa fa-filter" style="color: #00a896;"></i> Select Patient &amp; Date to Inspect
      </strong>
    </div>
    <div style="padding: 16px 20px;">
      <form action="<?=base_url('diet/logs');?>" method="get" class="row">
        
        <div class="col-md-5 col-sm-6 form-group" style="position: relative;">
          <label style="font-size: 12px; font-weight: 700; color: #334155;">Patient</label>
          <input type="text" id="patientSearchLogs" value="<?=!empty($patient_data) ? html_escape($patient_data['full_name'] . ' (#' . $patient_data['user_id'] . ')') : '';?>" class="form-control" placeholder="Search patient name, mobile, ID..." autocomplete="off" style="height: 40px;">
          <input type="hidden" name="patient_id" id="hiddenPatientId" value="<?=$patient_id ?: '';?>">
          <div id="patientDropdownLogs" class="autocomplete-dropdown-logs"></div>
        </div>

        <div class="col-md-4 col-sm-4 form-group">
          <label style="font-size: 12px; font-weight: 700; color: #334155;">Date</label>
          <input type="date" name="date" value="<?=$selected_date;?>" class="form-control" style="height: 40px;">
        </div>

        <div class="col-md-3 col-sm-2 form-group" style="padding-top: 24px;">
          <button type="submit" class="btn btn-primary" style="height: 40px; background: #00a896; border-color: #00a896; font-weight: 700; width: 100%;">
            <i class="fa fa-search"></i> Inspect Log
          </button>
        </div>

      </form>
    </div>
  </div>

  <?php if(!empty($patient_data) && !empty($log_summary)): ?>
    <?php 
      $c = $log_summary['consumed'];
      $t = $log_summary['targets'];
      $p = $log_summary['percentages'];
      $meals = $log_summary['meals'];
    ?>

    <!-- Patient Header Card -->
    <div class="log-mon-card">
      <div class="log-mon-header" style="background: #f8fafc;">
        <div>
          <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 3px;">
            <?=html_escape($patient_data['full_name'] ?: 'Patient #' . $patient_id);?>
            <span style="font-size: 12px; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-weight: 700;">
              UPC-<?=str_pad($patient_id, 5, '0', STR_PAD_LEFT);?>
            </span>
          </h3>
          <span style="font-size: 13px; color: #64748b;">
            <i class="fa fa-calendar"></i> Log Date: <strong><?=$log_summary['date_formatted'];?></strong>
          </span>
        </div>
        <div>
          <a href="<?=base_url('diet/targets/' . $patient_id);?>" class="btn btn-sm btn-default" style="font-weight: 700;">
            <i class="fa fa-pencil"></i> Adjust Targets
          </a>
        </div>
      </div>

      <!-- Macro Summary Cards Grid -->
      <div style="padding: 20px; border-bottom: 1px solid var(--dt-border); background: #fafbfc;">
        <div class="row">
          
          <!-- Calories Card -->
          <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px;">
              <div style="display: flex; justify-content: space-between; align-items: baseline;">
                <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Energy / Calories</span>
                <span style="font-size: 12px; font-weight: 800; color: <?=$p['calories'] > 100 ? '#ea580c' : '#00a896';?>;"><?=$p['calories'];?>%</span>
              </div>
              <div style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 6px 0;">
                <?=number_format($c['calories']);?> <span style="font-size: 13px; font-weight: 600; color: #94a3b8;">/ <?=number_format($t['target_calories']);?> kcal</span>
              </div>
              <div class="prog-bar-wrap">
                <div class="prog-bar-fill" style="width: <?=min(100, $p['calories']);?>%; background: <?=$p['calories'] > 100 ? '#ea580c' : '#00a896';?>;"></div>
              </div>
            </div>
          </div>

          <!-- Macros Progress Grid -->
          <div class="col-md-8 col-sm-12">
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px;">
              <div class="row">
                
                <div class="col-md-3 col-6" style="margin-bottom: 10px;">
                  <div style="font-size: 11px; font-weight: 700; color: #16a34a; text-transform: uppercase;">Protein</div>
                  <div style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 2px 0;">
                    <?=$c['protein'];?>g <small style="font-size: 11px; color: #94a3b8;">/ <?=$t['protein_g'];?>g</small>
                  </div>
                  <div class="prog-bar-wrap">
                    <div class="prog-bar-fill" style="width: <?=min(100, $p['protein']);?>%; background: #16a34a;"></div>
                  </div>
                </div>

                <div class="col-md-3 col-6" style="margin-bottom: 10px;">
                  <div style="font-size: 11px; font-weight: 700; color: #0284c7; text-transform: uppercase;">Carbs</div>
                  <div style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 2px 0;">
                    <?=$c['carbs'];?>g <small style="font-size: 11px; color: #94a3b8;">/ <?=$t['carbs_g'];?>g</small>
                  </div>
                  <div class="prog-bar-wrap">
                    <div class="prog-bar-fill" style="width: <?=min(100, $p['carbs']);?>%; background: #0284c7;"></div>
                  </div>
                </div>

                <div class="col-md-3 col-6" style="margin-bottom: 10px;">
                  <div style="font-size: 11px; font-weight: 700; color: #d97706; text-transform: uppercase;">Fats</div>
                  <div style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 2px 0;">
                    <?=$c['fats'];?>g <small style="font-size: 11px; color: #94a3b8;">/ <?=$t['fat_g'];?>g</small>
                  </div>
                  <div class="prog-bar-wrap">
                    <div class="prog-bar-fill" style="width: <?=min(100, $p['fats']);?>%; background: #d97706;"></div>
                  </div>
                </div>

                <div class="col-md-3 col-6" style="margin-bottom: 10px;">
                  <div style="font-size: 11px; font-weight: 700; color: #7c3aed; text-transform: uppercase;">Fiber</div>
                  <div style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 2px 0;">
                    <?=$c['fiber'];?>g <small style="font-size: 11px; color: #94a3b8;">/ <?=$t['fiber_g'];?>g</small>
                  </div>
                  <div class="prog-bar-wrap">
                    <div class="prog-bar-fill" style="width: <?=min(100, $p['fiber']);?>%; background: #7c3aed;"></div>
                  </div>
                </div>

              </div>

              <!-- Micros row -->
              <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; gap: 16px; font-size: 12px; color: #64748b; flex-wrap: wrap;">
                <span>Iron (Fe): <strong><?=$c['iron'];?> mg</strong> / <?=$t['iron_mg'];?> mg</span>
                <span>Calcium (Ca): <strong><?=$c['calcium'];?> mg</strong> / <?=$t['calcium_mg'];?> mg</span>
                <span>Vitamin C: <strong><?=$c['vitamin_c'];?> mg</strong> / <?=$t['vitamin_c_mg'];?> mg</span>
              </div>

            </div>
          </div>

        </div>
      </div>

      <!-- 5 Meal Times Breakdown -->
      <div style="padding: 24px;">
        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 16px;">
          <i class="fa fa-clock-o" style="color: #00a896;"></i> 5 Daily Meal Times Breakdown
        </h4>

        <?php 
          $meal_configs = [
            'breakfast' => ['name' => 'Breakfast', 'icon' => 'fa fa-sun-o', 'color' => '#f59e0b'],
            'brunch'    => ['name' => 'Brunch',    'icon' => 'fa fa-coffee', 'color' => '#8b5cf6'],
            'lunch'     => ['name' => 'Lunch',     'icon' => 'fa fa-cutlery', 'color' => '#10b981'],
            'snacks'    => ['name' => 'Snacks',    'icon' => 'fa fa-apple',   'color' => '#ec4899'],
            'dinner'    => ['name' => 'Dinner',    'icon' => 'fa fa-moon-o',  'color' => '#3b82f6']
          ];
        ?>

        <?php foreach($meal_configs as $m_key => $m_cfg): ?>
          <?php 
            $items = $meals[$m_key] ?? [];
            $meal_cal = 0;
            $meal_prot = 0;
            $meal_carb = 0;
            $meal_fat = 0;
            foreach($items as $it) {
              $meal_cal += $it->calories;
              $meal_prot += $it->protein;
              $meal_carb += $it->carbs;
              $meal_fat += $it->fats;
            }
          ?>

          <div class="meal-block">
            <div class="meal-block-header">
              <div class="meal-block-title">
                <i class="<?=$m_cfg['icon'];?>" style="color: <?=$m_cfg['color'];?>;"></i>
                <span><?=$m_cfg['name'];?></span>
                <span style="font-size: 11px; background: #e2e8f0; color: #475569; padding: 1px 7px; border-radius: 10px; font-weight: 700;">
                  <?=count($items);?> <?=count($items) === 1 ? 'item' : 'items';?>
                </span>
              </div>
              <div>
                <strong style="color: #ea580c; font-size: 13.5px;"><?=round($meal_cal);?> kcal</strong>
                <?php if(!empty($items)): ?>
                  <span style="font-size: 11px; color: #64748b; margin-left: 6px;">
                    (P: <?=round($meal_prot, 1);?>g | C: <?=round($meal_carb, 1);?>g | F: <?=round($meal_fat, 1);?>g)
                  </span>
                <?php endif; ?>
              </div>
            </div>

            <?php if(!empty($items)): ?>
              <div class="table-responsive">
                <table class="table table-condensed" style="margin: 0; font-size: 12.5px;">
                  <thead>
                    <tr style="background: #fafbfc; color: #64748b; font-size: 11px;">
                      <th>Food Item</th>
                      <th>Quantity Logged</th>
                      <th style="text-align: right;">Energy</th>
                      <th>Macros (P / C / F)</th>
                      <th>Logged At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($items as $row): ?>
                      <tr>
                        <td>
                          <strong><?=html_escape($row->food_name);?></strong>
                        </td>
                        <td>
                          <?=rtrim(rtrim(number_format($row->quantity, 2), '0'), '.');?> <?=html_escape($row->serving_unit ?: 'serving');?>
                        </td>
                        <td style="text-align: right; color: #ea580c; font-weight: 700;">
                          <?=round($row->calories);?> kcal
                        </td>
                        <td>
                          <span style="color: #16a34a; font-weight: 600;">P: <?=floatval($row->protein);?>g</span> | 
                          <span style="color: #0284c7; font-weight: 600;">C: <?=floatval($row->carbs);?>g</span> | 
                          <span style="color: #d97706; font-weight: 600;">F: <?=floatval($row->fats);?>g</span>
                        </td>
                        <td style="color: #94a3b8;">
                          <?=!empty($row->created_at) ? date('h:i A', strtotime($row->created_at)) : 'Today';?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div style="padding: 14px 18px; color: #94a3b8; font-size: 12.5px; font-style: italic;">
                No items logged for <?=$m_cfg['name'];?> on this date.
              </div>
            <?php endif; ?>
          </div>

        <?php endforeach; ?>

      </div>

    </div>
  <?php else: ?>
    <!-- No patient selected -->
    <div class="log-mon-card" style="padding: 40px 20px; text-align: center; color: #64748b;">
      <i class="fa fa-book" style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
      <h3 style="font-size: 16px; font-weight: 700; color: #334155; margin: 0 0 6px;">Select a Patient to Monitor</h3>
      <p style="font-size: 13px; max-width: 480px; margin: 0 auto 16px;">
        Use the search bar above to look up any patient and view their meal logs and calorie totals.
      </p>

      <?php if(!empty($recent_patients)): ?>
        <div style="max-width: 550px; margin: 20px auto 0; text-align: left;">
          <strong style="font-size: 12px; text-transform: uppercase; color: #94a3b8; display: block; margin-bottom: 8px;">
            Quick Select Recent Patients:
          </strong>
          <div class="list-group">
            <?php foreach($recent_patients as $rp): ?>
              <a href="<?=base_url('diet/logs/' . $rp->id . '?date=' . $selected_date);?>" class="list-group-item" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                  <strong><?=html_escape(trim($rp->fname . ' ' . $rp->lname) ?: 'Patient #' . $rp->id);?></strong>
                  <span class="text-muted" style="font-size: 11px; margin-left: 6px;">#<?=$rp->id;?> (<?=$rp->mobile ?: $rp->email;?>)</span>
                </div>
                <span class="badge" style="background: #00a896;">View Logs</span>
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
var logSearchTimer = null;
$('#patientSearchLogs').on('input', function() {
  clearTimeout(logSearchTimer);
  var q = $(this).val().trim();
  if (q.length < 2) {
    $('#patientDropdownLogs').hide();
    return;
  }
  logSearchTimer = setTimeout(function() {
    $.getJSON('<?=base_url("diet/search_patients_ajax");?>', { q: q }, function(res) {
      if (res && res.status === 'success' && res.data && res.data.length > 0) {
        var html = '';
        res.data.forEach(function(p) {
          var name = (p.fname + ' ' + (p.lname || '')).trim() || ('Patient #' + p.id);
          var meta = (p.mobile || p.email || 'No contact');
          html += '<div class="autocomplete-item" onclick="selectPatientForLogs(' + p.id + ', \'' + escapeQuotes(name) + '\')">';
          html += '<strong>' + name + '</strong> <span style="color: #64748b;">(#' + p.id + ' - ' + meta + ')</span>';
          html += '</div>';
        });
        $('#patientDropdownLogs').html(html).show();
      } else {
        $('#patientDropdownLogs').html('<div class="autocomplete-item text-muted">No matching patients found</div>').show();
      }
    });
  }, 250);
});

function selectPatientForLogs(id, name) {
  $('#hiddenPatientId').val(id);
  $('#patientSearchLogs').val(name + ' (#' + id + ')');
  $('#patientDropdownLogs').hide();
}

function escapeQuotes(str) {
  return str.replace(/'/g, "\\'");
}

$(document).on('click', function(e) {
  if (!$(e.target).closest('#patientSearchLogs, #patientDropdownLogs').length) {
    $('#patientDropdownLogs').hide();
  }
});
</script>
