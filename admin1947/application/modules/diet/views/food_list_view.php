<style>
:root {
  --dt-teal: #00a896;
  --dt-teal-dark: #008f80;
  --dt-navy: #1d2a44;
  --dt-slate: #334155;
  --dt-border: #e2e8f0;
  --dt-bg: #f8fafc;
  --dt-radius: 10px;
}

.diet-adm-wrap {
  padding: 15px 5px 30px;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  color: var(--dt-slate);
}

.diet-hdr-banner {
  background: linear-gradient(135deg, var(--dt-navy) 0%, #1e3a5f 100%);
  border-radius: var(--dt-radius);
  padding: 22px 25px;
  color: #fff;
  margin-bottom: 22px;
  box-shadow: 0 8px 20px -4px rgba(29, 42, 68, 0.25);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 15px;
}

.diet-hdr-title {
  font-size: 22px;
  font-weight: 800;
  margin: 0 0 5px;
  display: flex;
  align-items: center;
  gap: 10px;
  color: #fff;
}

.diet-hdr-sub {
  font-size: 13px;
  color: #94a3b8;
  margin: 0;
}

.diet-kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 22px;
}

.diet-kpi-card {
  background: #fff;
  border: 1px solid var(--dt-border);
  border-radius: var(--dt-radius);
  padding: 16px 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  display: flex;
  align-items: center;
  gap: 16px;
  transition: transform 0.15s ease;
}
.diet-kpi-card:hover { transform: translateY(-2px); }

.diet-kpi-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
}

.diet-kpi-val {
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
}

.diet-kpi-lbl {
  font-size: 12px;
  color: #64748b;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 3px;
}

.diet-card {
  background: #fff;
  border: 1px solid var(--dt-border);
  border-radius: var(--dt-radius);
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  overflow: hidden;
  margin-bottom: 22px;
}

.diet-card-head {
  padding: 16px 20px;
  border-bottom: 1px solid var(--dt-border);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  background: #fafbfc;
}

.diet-tbl-filter-form {
  padding: 16px 20px;
  background: #f8fafc;
  border-bottom: 1px solid var(--dt-border);
}

.badge-macro {
  font-size: 11px;
  padding: 2px 6px;
  border-radius: 4px;
  font-weight: 700;
  display: inline-block;
  margin-right: 2px;
}
.bg-carb { background: #e0f2fe; color: #0284c7; }
.bg-prot { background: #dcfce7; color: #16a34a; }
.bg-fat  { background: #fef3c7; color: #d97706; }
.bg-fib  { background: #ede9fe; color: #7c3aed; }

.status-switch {
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 12px;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 20px;
  border: 1px solid transparent;
  transition: all 0.2s;
}
.status-switch.active {
  background: #ecfdf5;
  color: #059669;
  border-color: #a7f3d0;
}
.status-switch.inactive {
  background: #f1f5f9;
  color: #64748b;
  border-color: #cbd5e1;
}

.btn-adm {
  height: 36px;
  padding: 0 16px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: none;
  cursor: pointer;
  transition: all 0.15s;
  text-decoration: none !important;
}
.btn-adm-primary {
  background: var(--dt-teal);
  color: #fff;
}
.btn-adm-primary:hover { background: var(--dt-teal-dark); color: #fff; }
.btn-adm-outline {
  background: #fff;
  border: 1px solid var(--dt-border);
  color: #334155;
}
.btn-adm-outline:hover { background: #f1f5f9; color: #0f172a; }

.diet-tbl th {
  background: #f8fafc;
  color: #475569;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-top: none !important;
  border-bottom: 2px solid var(--dt-border) !important;
  vertical-align: middle !important;
  padding: 12px 14px !important;
}
.diet-tbl td {
  vertical-align: middle !important;
  font-size: 13px;
  padding: 12px 14px !important;
  border-color: #f1f5f9 !important;
}

.veg-icon {
  width: 14px;
  height: 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: 1.5px solid;
  border-radius: 3px;
  font-size: 8px;
  margin-right: 5px;
  vertical-align: middle;
}
.veg-icon.veg { border-color: #16a34a; color: #16a34a; }
.veg-icon.non-veg { border-color: #dc2626; color: #dc2626; }
</style>

<div class="content-wrapper">
<section class="content">
<div class="diet-adm-wrap">

  <!-- Flash Message -->
  <?php if($this->session->flashdata('flashmsg')): ?>
    <div style="margin-bottom: 16px;">
      <?=$this->session->flashdata('flashmsg');?>
    </div>
  <?php endif; ?>

  <!-- Top Banner -->
  <div class="diet-hdr-banner">
    <div>
      <h1 class="diet-hdr-title">
        <i class="fa fa-cutlery" style="color: #2dd4bf;"></i> Food Master Database
      </h1>
      <p class="diet-hdr-sub">
        Universal nutritional reference catalog powering patient meal searches, calories &amp; macro calculations
      </p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
      <a href="<?=base_url('diet/targets');?>" class="btn-adm btn-adm-outline" style="color: #fff; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
        <i class="fa fa-bullseye"></i> Patient Targets
      </a>
      <a href="<?=base_url('diet/logs');?>" class="btn-adm btn-adm-outline" style="color: #fff; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
        <i class="fa fa-book"></i> Meal Logs Monitor
      </a>
      <button type="button" onclick="openFoodModal(0)" class="btn-adm btn-adm-primary" style="box-shadow: 0 4px 10px rgba(0,168,150,0.4);">
        <i class="fa fa-plus-circle"></i> Add Food Item
      </button>
    </div>
  </div>

  <!-- KPI Summary Cards -->
  <div class="diet-kpi-grid">
    <div class="diet-kpi-card">
      <div class="diet-kpi-icon" style="background: #e6fffa; color: #0d9488;">
        <i class="fa fa-database"></i>
      </div>
      <div>
        <div class="diet-kpi-val"><?=number_format($kpis['total_foods'] ?? 0);?></div>
        <div class="diet-kpi-lbl">Total Foods</div>
      </div>
    </div>
    <div class="diet-kpi-card">
      <div class="diet-kpi-icon" style="background: #ecfdf5; color: #059669;">
        <i class="fa fa-check-circle-o"></i>
      </div>
      <div>
        <div class="diet-kpi-val"><?=number_format($kpis['active_foods'] ?? 0);?></div>
        <div class="diet-kpi-lbl">Active in Search</div>
      </div>
    </div>
    <div class="diet-kpi-card">
      <div class="diet-kpi-icon" style="background: #eff6ff; color: #2563eb;">
        <i class="fa fa-user-circle"></i>
      </div>
      <div>
        <div class="diet-kpi-val"><?=number_format($kpis['total_custom_targets'] ?? 0);?></div>
        <div class="diet-kpi-lbl">Custom Target Patients</div>
      </div>
    </div>
    <div class="diet-kpi-card">
      <div class="diet-kpi-icon" style="background: #fef3c7; color: #d97706;">
        <i class="fa fa-calendar-check-o"></i>
      </div>
      <div>
        <div class="diet-kpi-val"><?=number_format($kpis['today_logs'] ?? 0);?></div>
        <div class="diet-kpi-lbl">Items Logged Today</div>
      </div>
    </div>
  </div>

  <!-- Main Catalog Table Card -->
  <div class="diet-card">
    
    <!-- Filter Bar -->
    <div class="diet-tbl-filter-form">
      <form action="<?=base_url('diet/foods');?>" method="get" class="row" style="margin: 0 -6px;">
        <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
          <input type="text" name="keyword" value="<?=html_escape($filters['keyword'] ?? '');?>" class="form-control input-sm" placeholder="Search by name, dal, roti, etc..." style="height: 36px;">
        </div>
        <div class="col-md-3 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
          <select name="category" class="form-control input-sm" style="height: 36px;">
            <option value="">All Categories</option>
            <?php foreach($categories as $cat): ?>
              <option value="<?=html_escape($cat);?>" <?=(isset($filters['category']) && $filters['category'] === $cat) ? 'selected' : '';?>>
                <?=html_escape($cat);?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2 col-sm-4" style="padding: 0 6px; margin-bottom: 10px;">
          <select name="status" class="form-control input-sm" style="height: 36px;">
            <option value="all">All Statuses</option>
            <option value="active" <?=(isset($filters['status']) && $filters['status'] === 'active') ? 'selected' : '';?>>Active</option>
            <option value="inactive" <?=(isset($filters['status']) && $filters['status'] === 'inactive') ? 'selected' : '';?>>Inactive</option>
          </select>
        </div>
        <div class="col-md-2 col-sm-4" style="padding: 0 6px; margin-bottom: 10px;">
          <select name="is_veg" class="form-control input-sm" style="height: 36px;">
            <option value="all">Diet Type</option>
            <option value="1" <?=(isset($filters['is_veg']) && $filters['is_veg'] === '1') ? 'selected' : '';?>>Vegetarian</option>
            <option value="0" <?=(isset($filters['is_veg']) && $filters['is_veg'] === '0') ? 'selected' : '';?>>Non-Veg / Egg</option>
          </select>
        </div>
        <div class="col-md-2 col-sm-4" style="padding: 0 6px; margin-bottom: 10px; display: flex; gap: 6px;">
          <button type="submit" class="btn-adm btn-adm-primary" style="flex: 1; justify-content: center;">
            <i class="fa fa-filter"></i> Filter
          </button>
          <a href="<?=base_url('diet/foods');?>" class="btn-adm btn-adm-outline" title="Reset Filters" style="padding: 0 10px;">
            <i class="fa fa-refresh"></i>
          </a>
        </div>
      </form>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-hover diet-tbl" style="margin: 0;">
        <thead>
          <tr>
            <th style="width: 50px;">#ID</th>
            <th>Food Item &amp; Category</th>
            <th>Serving Baseline</th>
            <th style="text-align: right;">Energy</th>
            <th>Macronutrients (P / C / F / Fib)</th>
            <th>Micronutrients</th>
            <th style="text-align: center;">Status</th>
            <th style="width: 110px; text-align: center;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($foods)): ?>
            <?php foreach($foods as $f): ?>
              <tr id="foodRow_<?=$f->id;?>">
                <td style="color: #94a3b8; font-weight: 700;">#<?=$f->id;?></td>
                <td>
                  <div>
                    <span class="veg-icon <?=(isset($f->is_veg) && $f->is_veg) ? 'veg' : 'non-veg';?>" title="<?=(isset($f->is_veg) && $f->is_veg) ? 'Vegetarian' : 'Non-Vegetarian';?>">●</span>
                    <strong style="color: #0f172a; font-size: 13.5px;"><?=html_escape($f->name);?></strong>
                  </div>
                  <span style="font-size: 11px; color: #64748b; background: #f1f5f9; padding: 1px 7px; border-radius: 4px; display: inline-block; margin-top: 3px;">
                    <i class="fa fa-tag"></i> <?=html_escape($f->category ?: 'General');?>
                  </span>
                </td>
                <td>
                  <span style="font-weight: 700; color: #334155;">
                    <?=rtrim(rtrim(number_format($f->serving_size, 2), '0'), '.');?> <?=html_escape($f->serving_unit);?>
                  </span>
                </td>
                <td style="text-align: right;">
                  <strong style="color: #ea580c; font-size: 14px;">
                    <?=round($f->calories);?>
                  </strong>
                  <span style="font-size: 11px; color: #94a3b8;">kcal</span>
                </td>
                <td>
                  <span class="badge-macro bg-prot" title="Protein">P: <?=rtrim(rtrim(number_format($f->protein, 1), '0'), '.');?>g</span>
                  <span class="badge-macro bg-carb" title="Carbohydrates">C: <?=rtrim(rtrim(number_format($f->carbs, 1), '0'), '.');?>g</span>
                  <span class="badge-macro bg-fat" title="Fats">F: <?=rtrim(rtrim(number_format($f->fats, 1), '0'), '.');?>g</span>
                  <span class="badge-macro bg-fib" title="Dietary Fiber">Fib: <?=rtrim(rtrim(number_format($f->fiber, 1), '0'), '.');?>g</span>
                </td>
                <td style="font-size: 11.5px; color: #64748b;">
                  <div>Fe: <strong><?=floatval($f->iron);?></strong>mg | Ca: <strong><?=floatval($f->calcium);?></strong>mg</div>
                  <div>Vit C: <strong><?=floatval($f->vitamin_c);?></strong>mg</div>
                </td>
                <td style="text-align: center;">
                  <?php $is_act = (!isset($f->status) || $f->status === 'active'); ?>
                  <span class="status-switch <?=$is_act ? 'active' : 'inactive';?>" id="statusBadge_<?=$f->id;?>" onclick="toggleStatus(<?=$f->id;?>)" title="Click to toggle status">
                    <i class="fa fa-circle" style="font-size: 8px;"></i>
                    <span id="statusTxt_<?=$f->id;?>"><?=$is_act ? 'Active' : 'Inactive';?></span>
                  </span>
                </td>
                <td style="text-align: center;">
                  <div class="btn-group">
                    <button type="button" onclick="openFoodModal(<?=$f->id;?>)" class="btn btn-xs btn-default" title="Edit Food Details">
                      <i class="fa fa-pencil" style="color: #00a896;"></i>
                    </button>
                    <a href="<?=base_url('diet/edit_food/' . $f->id);?>" class="btn btn-xs btn-default" title="Full Form Edit">
                      <i class="fa fa-external-link text-muted"></i>
                    </a>
                    <button type="button" onclick="confirmDelete(<?=$f->id;?>, '<?=html_escape(addslashes($f->name));?>')" class="btn btn-xs btn-default" title="Delete Food Item">
                      <i class="fa fa-trash text-danger"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                <i class="fa fa-cutlery" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                <div style="font-size: 15px; font-weight: 700; color: #334155;">No Food Items Found</div>
                <p style="font-size: 13px; margin: 4px 0 14px;">Try refining your search keyword or add a new food item.</p>
                <button type="button" onclick="openFoodModal(0)" class="btn-adm btn-adm-primary">
                  <i class="fa fa-plus"></i> Add First Food Item
                </button>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Footer -->
    <div class="diet-card-head" style="background: #fff;">
      <div style="font-size: 13px; color: #64748b;">
        Showing <strong><?=count($foods);?></strong> of <strong><?=number_format($total_rows);?></strong> food items in master database
      </div>
      <div>
        <?=$page_links;?>
      </div>
    </div>

  </div>

</div>
</section>
</div>

<!-- ==========================================================
     ADD / EDIT FOOD MODAL
     ========================================================== -->
<div class="modal fade" id="foodModal" tabindex="-1" role="dialog" aria-labelledby="foodModalTitle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
      
      <div class="modal-header" style="background: #1d2a44; color: #fff; padding: 18px 24px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px;">&times;</button>
        <h4 class="modal-title" id="foodModalTitle" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
          <i class="fa fa-cutlery" style="color: #2dd4bf;"></i> Food Item Details
        </h4>
      </div>

      <form id="foodForm" onsubmit="handleFoodFormSubmit(event)">
        <input type="hidden" name="id" id="m_id" value="0">
        <input type="hidden" name="ajax" value="1">

        <div class="modal-body" style="padding: 24px;">
          <div id="modalNotice" style="display: none; margin-bottom: 16px;"></div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label style="font-weight: 700; font-size: 12.5px; color: #334155;">Food Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="m_name" class="form-control" placeholder="e.g. Roti / Chapati (Whole Wheat)" required>
            </div>
            <div class="col-md-6 form-group">
              <label style="font-weight: 700; font-size: 12.5px; color: #334155;">Category</label>
              <input type="text" name="category" id="m_category" class="form-control" list="catList" placeholder="e.g. Grains & Breads">
              <datalist id="catList">
                <?php foreach($categories as $cat): ?>
                  <option value="<?=html_escape($cat);?>">
                <?php endforeach; ?>
              </datalist>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 col-sm-6 form-group">
              <label style="font-weight: 700; font-size: 12.5px; color: #334155;">Serving Size</label>
              <input type="number" step="0.1" name="serving_size" id="m_serving_size" value="1" class="form-control" required>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
              <label style="font-weight: 700; font-size: 12.5px; color: #334155;">Serving Unit</label>
              <input type="text" name="serving_unit" id="m_serving_unit" value="piece" class="form-control" placeholder="piece, grams, bowl, cup" required>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
              <label style="font-weight: 700; font-size: 12.5px; color: #334155;">Calories (kcal) <span class="text-danger">*</span></label>
              <input type="number" step="0.1" name="calories" id="m_calories" value="0" class="form-control" required>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
              <label style="font-weight: 700; font-size: 12.5px; color: #334155;">Diet Classification</label>
              <select name="is_veg" id="m_is_veg" class="form-control">
                <option value="1">Vegetarian</option>
                <option value="0">Non-Vegetarian / Egg</option>
              </select>
            </div>
          </div>

          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
            <div style="font-weight: 800; font-size: 12px; color: #475569; text-transform: uppercase; margin-bottom: 12px;">
              <i class="fa fa-pie-chart" style="color: #00a896;"></i> Baseline Macronutrients (per serving)
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #16a34a; font-weight: 700;">Protein (g)</label>
                <input type="number" step="0.1" name="protein" id="m_protein" value="0" class="form-control">
              </div>
              <div class="col-md-3 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #0284c7; font-weight: 700;">Carbohydrates (g)</label>
                <input type="number" step="0.1" name="carbs" id="m_carbs" value="0" class="form-control">
              </div>
              <div class="col-md-3 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #d97706; font-weight: 700;">Fats (g)</label>
                <input type="number" step="0.1" name="fats" id="m_fats" value="0" class="form-control">
              </div>
              <div class="col-md-3 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #7c3aed; font-weight: 700;">Fiber (g)</label>
                <input type="number" step="0.1" name="fiber" id="m_fiber" value="0" class="form-control">
              </div>
            </div>
          </div>

          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px;">
            <div style="font-weight: 800; font-size: 12px; color: #475569; text-transform: uppercase; margin-bottom: 12px;">
              <i class="fa fa-flask" style="color: #0284c7;"></i> Key Micronutrients (per serving)
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #334155; font-weight: 700;">Iron (mg)</label>
                <input type="number" step="0.1" name="iron" id="m_iron" value="0" class="form-control">
              </div>
              <div class="col-md-4 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #334155; font-weight: 700;">Calcium (mg)</label>
                <input type="number" step="0.1" name="calcium" id="m_calcium" value="0" class="form-control">
              </div>
              <div class="col-md-4 col-sm-6 form-group" style="margin-bottom: 0;">
                <label style="font-size: 12px; color: #334155; font-weight: 700;">Vitamin C (mg)</label>
                <input type="number" step="0.1" name="vitamin_c" id="m_vitamin_c" value="0" class="form-control">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer" style="padding: 14px 24px; background: #fafbfc; border-top: 1px solid #e2e8f0;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" id="m_submitBtn" class="btn-adm btn-adm-primary" style="height: 38px;">
            <i class="fa fa-save"></i> Save Food Item
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
function openFoodModal(id) {
  var modal = $('#foodModal');
  var form = document.getElementById('foodForm');
  form.reset();
  $('#modalNotice').hide();
  $('#m_id').val(id);

  if (id > 0) {
    $('#foodModalTitle').html('<i class="fa fa-pencil" style="color: #2dd4bf;"></i> Edit Food Item #' + id);
    $('#m_submitBtn').html('<i class="fa fa-save"></i> Update Food');

    $.getJSON('<?=base_url("diet/get_food_ajax");?>/' + id, function(res) {
      if (res && res.status === 'success' && res.data) {
        var d = res.data;
        $('#m_name').val(d.name);
        $('#m_category').val(d.category);
        $('#m_serving_size').val(d.serving_size);
        $('#m_serving_unit').val(d.serving_unit);
        $('#m_calories').val(d.calories);
        $('#m_protein').val(d.protein);
        $('#m_carbs').val(d.carbs);
        $('#m_fats').val(d.fats);
        $('#m_fiber').val(d.fiber);
        $('#m_iron').val(d.iron);
        $('#m_calcium').val(d.calcium);
        $('#m_vitamin_c').val(d.vitamin_c);
        $('#m_is_veg').val(d.is_veg !== undefined ? d.is_veg : 1);
        modal.modal('show');
      }
    });
  } else {
    $('#foodModalTitle').html('<i class="fa fa-plus-circle" style="color: #2dd4bf;"></i> Add New Food Item');
    $('#m_submitBtn').html('<i class="fa fa-save"></i> Save Food Item');
    modal.modal('show');
  }
}

function handleFoodFormSubmit(e) {
  e.preventDefault();
  var form = document.getElementById('foodForm');
  var btn = document.getElementById('m_submitBtn');
  var origHtml = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';

  var formData = new FormData(form);
  var id = $('#m_id').val();
  var url = id > 0 ? '<?=base_url("diet/edit_food");?>/' + id : '<?=base_url("diet/add_food");?>';

  fetch(url, {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(function(r) { return r.json(); })
  .then(function(res) {
    btn.disabled = false;
    btn.innerHTML = origHtml;
    if (res && res.status === 'success') {
      $('#modalNotice').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + res.message + '</div>').show();
      setTimeout(function() {
        $('#foodModal').modal('hide');
        location.reload();
      }, 800);
    } else {
      $('#modalNotice').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> ' + (res.message || 'Error saving food') + '</div>').show();
    }
  })
  .catch(function(err) {
    btn.disabled = false;
    btn.innerHTML = origHtml;
    form.submit();
  });
}

function toggleStatus(id) {
  var badge = $('#statusBadge_' + id);
  var txt = $('#statusTxt_' + id);
  
  $.post('<?=base_url("diet/toggle_status");?>/' + id, { is_ajax: 1 }, function(res) {
    if (res && res.status === 'success') {
      if (res.new_status === 'active') {
        badge.removeClass('inactive').addClass('active');
        txt.text('Active');
      } else {
        badge.removeClass('active').addClass('inactive');
        txt.text('Inactive');
      }
    }
  }, 'json');
}

function confirmDelete(id, name) {
  if (confirm('Are you sure you want to delete "' + name + '" from the food master catalog?')) {
    $.post('<?=base_url("diet/delete_food");?>/' + id, { ajax: 1 }, function(res) {
      if (res && res.status === 'success') {
        $('#foodRow_' + id).fadeOut(300, function() { $(this).remove(); });
      } else {
        alert(res.message || 'Failed to delete');
      }
    }, 'json');
  }
}
</script>
