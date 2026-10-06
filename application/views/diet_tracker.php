<?php
/**
 * Daily Diet Tracker - Main View
 * Compatible with standalone /diet and patient dashboard (/profile?tab=diet)
 */
$summary = !empty($summary) ? $summary : (!empty($diet_summary) ? $diet_summary : null);
$consumed = $summary['consumed'] ?? ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0, 'iron' => 0, 'calcium' => 0, 'vitamin_c' => 0, 'total_items' => 0];
$targets = $summary['targets'] ?? ['target_calories' => 2000, 'protein_g' => 65, 'carbs_g' => 250, 'fat_g' => 55, 'fiber_g' => 30, 'iron_mg' => 18, 'calcium_mg' => 1000, 'vitamin_c_mg' => 75, 'goal_name' => 'Healthy Maintenance'];
$pct = $summary['percentages'] ?? ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0, 'iron' => 0, 'calcium' => 0, 'vitamin_c' => 0];
$rem = $summary['remaining'] ?? ['calories' => 2000, 'protein' => 65, 'carbs' => 250, 'fats' => 55, 'fiber' => 30];
$current_date = $summary['date'] ?? date('Y-m-d');
$date_fmt = $summary['date_formatted'] ?? date('l, M d, Y');
$meals = $summary['meal_categories'] ?? [];
?>

<style>
/* Diet Tracker High-End Aesthetics */
:root {
  --dt-teal: #00A896;
  --dt-teal-dark: #028090;
  --dt-navy: #0F172A;
  --dt-slate: #334155;
  --dt-light: #F8FAFC;
  --dt-border: #E2E8F0;
  --dt-amber: #F59E0B;
  --dt-rose: #F43F5E;
  --dt-emerald: #10B981;
  --dt-sky: #0284C7;
  --dt-violet: #8B5CF6;
}

.dt-wrapper {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  color: var(--dt-slate);
  padding: 15px 0 40px;
}

/* Header Banner */
.dt-header-card {
  background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #028090 100%);
  border-radius: 16px;
  color: #fff;
  padding: 24px 28px;
  margin-bottom: 25px;
  box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}
.dt-header-title h2 {
  font-size: 24px;
  font-weight: 800;
  margin: 0 0 6px;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 10px;
}
.dt-header-title p {
  margin: 0;
  color: #94A3B8;
  font-size: 13.5px;
}
.dt-date-control {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(8px);
  padding: 6px 12px;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.15);
}
.dt-date-btn {
  background: rgba(255, 255, 255, 0.15);
  border: none;
  color: #fff;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}
.dt-date-btn:hover {
  background: #00A896;
}
.dt-date-input {
  background: transparent;
  border: none;
  color: #fff;
  font-weight: 700;
  font-size: 14px;
  outline: none;
  cursor: pointer;
  text-align: center;
}
.dt-date-input::-webkit-calendar-picker-indicator {
  filter: invert(1);
  cursor: pointer;
}

/* Macro Cards Grid */
.dt-macro-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
  margin-bottom: 25px;
}
.dt-macro-card {
  background: #fff;
  border-radius: 14px;
  border: 1px solid var(--dt-border);
  padding: 18px 20px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  position: relative;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}
.dt-macro-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
}
.dt-macro-icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  margin-bottom: 12px;
}
.dt-macro-title {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748B;
  margin-bottom: 4px;
}
.dt-macro-val {
  font-size: 22px;
  font-weight: 800;
  color: var(--dt-navy);
  margin-bottom: 8px;
  display: flex;
  align-items: baseline;
  gap: 6px;
}
.dt-macro-target {
  font-size: 12px;
  font-weight: 600;
  color: #94A3B8;
}
.dt-progress-track {
  height: 8px;
  background: #F1F5F9;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 6px;
}
.dt-progress-fill {
  height: 100%;
  border-radius: 10px;
  transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.dt-macro-sub {
  font-size: 11.5px;
  color: #64748B;
  display: flex;
  justify-content: space-between;
}

/* Micronutrient Badges Bar */
.dt-micro-card {
  background: #fff;
  border-radius: 14px;
  border: 1px solid var(--dt-border);
  padding: 16px 20px;
  margin-bottom: 25px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
}
.dt-micro-header {
  font-size: 13px;
  font-weight: 700;
  color: var(--dt-navy);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.dt-micro-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}
.dt-micro-chip {
  flex: 1 1 180px;
  background: #F8FAFC;
  border: 1px solid var(--dt-border);
  border-radius: 10px;
  padding: 10px 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.dt-micro-chip strong {
  color: var(--dt-navy);
  font-size: 14px;
}
.dt-micro-chip small {
  color: #64748B;
  font-size: 11px;
}

/* Meal Section Cards */
.dt-meal-card {
  background: #fff;
  border-radius: 14px;
  border: 1px solid var(--dt-border);
  margin-bottom: 18px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}
.dt-meal-header {
  padding: 16px 20px;
  background: #F8FAFC;
  border-bottom: 1px solid var(--dt-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}
.dt-meal-title-group {
  display: flex;
  align-items: center;
  gap: 12px;
}
.dt-meal-icon {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 15px;
}
.dt-meal-name {
  font-size: 16px;
  font-weight: 700;
  color: var(--dt-navy);
  margin: 0;
}
.dt-meal-sub {
  font-size: 12px;
  color: #64748B;
  margin: 0;
}
.dt-meal-stats {
  display: flex;
  align-items: center;
  gap: 12px;
}
.dt-meal-calorie-badge {
  background: #EFF6FF;
  color: #1E40AF;
  font-weight: 700;
  font-size: 12.5px;
  padding: 4px 10px;
  border-radius: 8px;
  border: 1px solid #BFDBFE;
}
.dt-btn-add {
  background: #00A896;
  color: #fff;
  border: none;
  font-weight: 600;
  font-size: 12.5px;
  padding: 6px 14px;
  border-radius: 8px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
}
.dt-btn-add:hover {
  background: #028090;
  color: #fff;
}

/* Logged Food Items Table */
.dt-food-list {
  padding: 0;
  margin: 0;
  list-style: none;
}
.dt-food-item {
  padding: 14px 20px;
  border-bottom: 1px solid #F1F5F9;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  transition: background 0.15s;
}
.dt-food-item:last-child {
  border-bottom: none;
}
.dt-food-item:hover {
  background: #F8FAFC;
}
.dt-food-name {
  font-size: 14px;
  font-weight: 700;
  color: var(--dt-navy);
  margin-bottom: 3px;
}
.dt-food-portion {
  font-size: 12px;
  color: #64748B;
}
.dt-food-macros {
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 12px;
}
.dt-food-macros span {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}
.dt-food-macros strong {
  color: var(--dt-navy);
  font-weight: 700;
}
.dt-food-macros small {
  color: #94A3B8;
  font-size: 10.5px;
}
.dt-btn-del {
  background: transparent;
  border: none;
  color: #CBD5E1;
  padding: 6px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
}
.dt-btn-del:hover {
  color: #EF4444;
  background: #FEE2E2;
}

/* Empty Meal State */
.dt-empty-meal {
  padding: 24px 20px;
  text-align: center;
  color: #94A3B8;
  font-size: 13px;
}
.dt-empty-meal i {
  font-size: 20px;
  margin-bottom: 6px;
  display: block;
}

/* Food Search Autocomplete Modal & Panel */
.dt-search-container {
  position: relative;
}
.dt-search-input {
  width: 100%;
  height: 46px;
  border-radius: 10px;
  border: 1px solid var(--dt-border);
  padding: 10px 16px 10px 42px;
  font-size: 14px;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.dt-search-input:focus {
  border-color: #00A896;
  box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
.dt-search-icon {
  position: absolute;
  left: 15px;
  top: 15px;
  color: #94A3B8;
  font-size: 15px;
}
.dt-dropdown-results {
  position: absolute;
  top: 50px;
  left: 0;
  right: 0;
  background: #fff;
  border: 1px solid var(--dt-border);
  border-radius: 12px;
  max-height: 280px;
  overflow-y: auto;
  z-index: 1050;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
  display: none;
}
.dt-dropdown-item {
  padding: 10px 16px;
  border-bottom: 1px solid #F1F5F9;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: background 0.15s;
}
.dt-dropdown-item:hover, .dt-dropdown-item.active {
  background: #F0FDFA;
}
.dt-dropdown-item-info strong {
  font-size: 13.5px;
  color: var(--dt-navy);
  display: block;
}
.dt-dropdown-item-info small {
  color: #64748B;
  font-size: 11.5px;
}
.dt-dropdown-item-cal {
  text-align: right;
  font-size: 13px;
  font-weight: 700;
  color: #0284C7;
}

/* Modal Styling */
.dt-modal .modal-content {
  border-radius: 16px;
  border: none;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  overflow: hidden;
}
.dt-modal .modal-header {
  background: linear-gradient(135deg, #0F172A 0%, #00A896 100%);
  color: #fff;
  padding: 18px 24px;
  border-bottom: none;
}
.dt-modal .modal-title {
  font-size: 17px;
  font-weight: 700;
  color: #fff;
}
.dt-modal .modal-header .close {
  color: #fff;
  opacity: 0.8;
  font-size: 24px;
}
.dt-preview-card {
  background: #F8FAFC;
  border: 1px dashed #CBD5E1;
  border-radius: 12px;
  padding: 14px 16px;
  margin: 15px 0;
  display: none;
}
.dt-preview-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 8px;
  text-align: center;
  margin-top: 8px;
}
.dt-preview-stat {
  background: #fff;
  padding: 8px;
  border-radius: 8px;
  border: 1px solid #E2E8F0;
}
.dt-preview-stat small {
  display: block;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  color: #64748B;
}
.dt-preview-stat strong {
  font-size: 13px;
  color: var(--dt-navy);
}
</style>

<div class="dt-wrapper">
  <!-- 1. Header & Date Controller -->
  <div class="dt-header-card">
    <div class="dt-header-title">
      <h2><i class="fas fa-utensils text-success"></i> Daily Diet Tracker</h2>
      <p>Log your 5 meals, track key macros &amp; micronutrients vs clinical targets.</p>
    </div>
    <div class="dt-date-control">
      <button type="button" class="dt-date-btn" id="dtPrevDayBtn" title="Previous Day"><i class="fas fa-chevron-left"></i></button>
      <input type="date" id="dtDatePicker" class="dt-date-input" value="<?= htmlspecialchars($current_date); ?>">
      <button type="button" class="dt-date-btn" id="dtNextDayBtn" title="Next Day"><i class="fas fa-chevron-right"></i></button>
      <button type="button" class="dt-date-btn" id="dtTodayBtn" title="Jump to Today"><i class="fas fa-calendar-check"></i></button>
    </div>
  </div>

  <!-- 2. Daily Summary Dashboard: Target vs Consumed -->
  <div class="dt-macro-grid">
    <!-- Calories -->
    <div class="dt-macro-card" style="border-left: 4px solid #00A896;">
      <div class="dt-macro-icon" style="background: #E6FFFA; color: #00A896;">
        <i class="fas fa-fire"></i>
      </div>
      <div class="dt-macro-title">Calories (Energy)</div>
      <div class="dt-macro-val">
        <span id="dtCalConsumed"><?= number_format($consumed['calories']); ?></span>
        <span class="dt-macro-target">/ <?= number_format($targets['target_calories']); ?> kcal</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtCalBar" class="dt-progress-fill" style="background: #00A896; width: <?= min(100, $pct['calories']); ?>%;"></div>
      </div>
      <div class="dt-macro-sub">
        <span id="dtCalPct"><?= $pct['calories']; ?>% of target</span>
        <span id="dtCalRem"><?= number_format($rem['calories']); ?> kcal left</span>
      </div>
    </div>

    <!-- Protein -->
    <div class="dt-macro-card" style="border-left: 4px solid #F43F5E;">
      <div class="dt-macro-icon" style="background: #FFE4E6; color: #F43F5E;">
        <i class="fas fa-dumbbell"></i>
      </div>
      <div class="dt-macro-title">Protein</div>
      <div class="dt-macro-val">
        <span id="dtProConsumed"><?= number_format($consumed['protein'], 1); ?></span>
        <span class="dt-macro-target">/ <?= number_format($targets['protein_g']); ?> g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtProBar" class="dt-progress-fill" style="background: #F43F5E; width: <?= min(100, $pct['protein']); ?>%;"></div>
      </div>
      <div class="dt-macro-sub">
        <span id="dtProPct"><?= $pct['protein']; ?>%</span>
        <span id="dtProRem"><?= number_format($rem['protein'], 1); ?> g left</span>
      </div>
    </div>

    <!-- Carbohydrates -->
    <div class="dt-macro-card" style="border-left: 4px solid #0284C7;">
      <div class="dt-macro-icon" style="background: #E0F2FE; color: #0284C7;">
        <i class="fas fa-bread-slice"></i>
      </div>
      <div class="dt-macro-title">Carbohydrates</div>
      <div class="dt-macro-val">
        <span id="dtCarbConsumed"><?= number_format($consumed['carbs'], 1); ?></span>
        <span class="dt-macro-target">/ <?= number_format($targets['carbs_g']); ?> g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtCarbBar" class="dt-progress-fill" style="background: #0284C7; width: <?= min(100, $pct['carbs']); ?>%;"></div>
      </div>
      <div class="dt-macro-sub">
        <span id="dtCarbPct"><?= $pct['carbs']; ?>%</span>
        <span id="dtCarbRem"><?= number_format($rem['carbs'], 1); ?> g left</span>
      </div>
    </div>

    <!-- Healthy Fats -->
    <div class="dt-macro-card" style="border-left: 4px solid #F59E0B;">
      <div class="dt-macro-icon" style="background: #FEF3C7; color: #F59E0B;">
        <i class="fas fa-cheese"></i>
      </div>
      <div class="dt-macro-title">Healthy Fats</div>
      <div class="dt-macro-val">
        <span id="dtFatConsumed"><?= number_format($consumed['fats'], 1); ?></span>
        <span class="dt-macro-target">/ <?= number_format($targets['fat_g']); ?> g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtFatBar" class="dt-progress-fill" style="background: #F59E0B; width: <?= min(100, $pct['fats']); ?>%;"></div>
      </div>
      <div class="dt-macro-sub">
        <span id="dtFatPct"><?= $pct['fats']; ?>%</span>
        <span id="dtFatRem"><?= number_format($rem['fats'], 1); ?> g left</span>
      </div>
    </div>

    <!-- Dietary Fiber -->
    <div class="dt-macro-card" style="border-left: 4px solid #10B981;">
      <div class="dt-macro-icon" style="background: #D1FAE5; color: #10B981;">
        <i class="fas fa-seedling"></i>
      </div>
      <div class="dt-macro-title">Dietary Fiber</div>
      <div class="dt-macro-val">
        <span id="dtFiberConsumed"><?= number_format($consumed['fiber'], 1); ?></span>
        <span class="dt-macro-target">/ <?= number_format($targets['fiber_g']); ?> g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtFiberBar" class="dt-progress-fill" style="background: #10B981; width: <?= min(100, $pct['fiber']); ?>%;"></div>
      </div>
      <div class="dt-macro-sub">
        <span id="dtFiberPct"><?= $pct['fiber']; ?>%</span>
        <span id="dtFiberRem"><?= number_format($rem['fiber'], 1); ?> g left</span>
      </div>
    </div>
  </div>

  <!-- 3. Key Micronutrients (Iron, Calcium, Vitamin C) -->
  <div class="dt-micro-card">
    <div class="dt-micro-header">
      <i class="fas fa-heartbeat text-danger"></i>
      <span>Key Micronutrients &amp; Essential Mineral Intake</span>
      <span class="badge badge-light" style="font-size: 11px; margin-left: auto;">RDA Standard Reference</span>
    </div>
    <div class="dt-micro-chips">
      <!-- Iron -->
      <div class="dt-micro-chip">
        <div>
          <small><i class="fas fa-tint text-danger"></i> Iron (Fe)</small>
          <div><strong id="dtIronVal"><?= number_format($consumed['iron'], 2); ?> mg</strong> <span class="text-muted" style="font-size: 11px;">/ <?= $targets['iron_mg']; ?> mg</span></div>
        </div>
        <span id="dtIronPct" class="badge <?= $pct['iron'] >= 100 ? 'badge-success' : 'badge-light'; ?>" style="font-size: 12px;"><?= $pct['iron']; ?>%</span>
      </div>
      <!-- Calcium -->
      <div class="dt-micro-chip">
        <div>
          <small><i class="fas fa-bone text-info"></i> Calcium (Ca)</small>
          <div><strong id="dtCalcVal"><?= number_format($consumed['calcium'], 1); ?> mg</strong> <span class="text-muted" style="font-size: 11px;">/ <?= $targets['calcium_mg']; ?> mg</span></div>
        </div>
        <span id="dtCalcPct" class="badge <?= $pct['calcium'] >= 100 ? 'badge-success' : 'badge-light'; ?>" style="font-size: 12px;"><?= $pct['calcium']; ?>%</span>
      </div>
      <!-- Vitamin C -->
      <div class="dt-micro-chip">
        <div>
          <small><i class="fas fa-lemon text-warning"></i> Vitamin C</small>
          <div><strong id="dtVitCVal"><?= number_format($consumed['vitamin_c'], 1); ?> mg</strong> <span class="text-muted" style="font-size: 11px;">/ <?= $targets['vitamin_c_mg']; ?> mg</span></div>
        </div>
        <span id="dtVitCPct" class="badge <?= $pct['vitamin_c'] >= 100 ? 'badge-success' : 'badge-light'; ?>" style="font-size: 12px;"><?= $pct['vitamin_c']; ?>%</span>
      </div>
    </div>
  </div>

  <!-- 4. The 5 Specific Meal Times (Breakfast, Brunch, Lunch, Snacks, Dinner) -->
  <div id="dtMealsContainer">
    <?php foreach ($meals as $catKey => $catData): ?>
      <div class="dt-meal-card" id="dtMealCard_<?= $catKey; ?>">
        <div class="dt-meal-header">
          <div class="dt-meal-title-group">
            <div class="dt-meal-icon" style="background: <?= $catData['color']; ?>;">
              <i class="fas <?= $catData['icon']; ?>"></i>
            </div>
            <div>
              <h3 class="dt-meal-name"><?= $catData['title']; ?></h3>
              <p class="dt-meal-sub">
                <span id="dtCount_<?= $catKey; ?>"><?= count($catData['items']); ?></span> items logged
              </p>
            </div>
          </div>
          <div class="dt-meal-stats">
            <span class="dt-meal-calorie-badge" id="dtBadgeCal_<?= $catKey; ?>">
              <i class="fas fa-fire"></i> <?= number_format($catData['subtotal']['calories']); ?> kcal
            </span>
            <button type="button" class="dt-btn-add" onclick="openLogModal('<?= $catKey; ?>')">
              <i class="fas fa-plus"></i> Add Item
            </button>
          </div>
        </div>

        <!-- Food items list -->
        <ul class="dt-food-list" id="dtFoodList_<?= $catKey; ?>">
          <?php if (!empty($catData['items'])): ?>
            <?php foreach ($catData['items'] as $item): ?>
              <li class="dt-food-item" id="dtItem_<?= $item['id']; ?>">
                <div>
                  <div class="dt-food-name"><?= htmlspecialchars($item['food_name']); ?></div>
                  <div class="dt-food-portion">
                    <?= floatval($item['quantity']); ?> <?= htmlspecialchars($item['serving_unit']); ?>
                    <?php if (!empty($item['notes'])): ?>
                      &bull; <span class="text-muted font-italic"><?= htmlspecialchars($item['notes']); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="dt-food-macros">
                  <span>
                    <strong><?= number_format($item['calories']); ?> kcal</strong>
                    <small>Energy</small>
                  </span>
                  <span>
                    <strong><?= number_format($item['protein'], 1); ?>g</strong>
                    <small>Prot</small>
                  </span>
                  <span>
                    <strong><?= number_format($item['carbs'], 1); ?>g</strong>
                    <small>Carb</small>
                  </span>
                  <span>
                    <strong><?= number_format($item['fats'], 1); ?>g</strong>
                    <small>Fat</small>
                  </span>
                  <button type="button" class="dt-btn-del" onclick="deleteDietItem(<?= $item['id']; ?>)" title="Remove item">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="dt-empty-meal">
              <i class="fas fa-utensils"></i>
              No food logged for <?= $catData['title']; ?> yet. Click "+ Add Item" to log.
            </div>
          <?php endif; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ========================================================= -->
<!-- MODAL: ADD FOOD TO MEAL CATEGORY                          -->
<!-- ========================================================= -->
<div class="modal fade dt-modal" id="dtAddFoodModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dtModalTitle">
          <i class="fas fa-plus-circle"></i> Log Food Intake
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="dtLogFoodForm" onsubmit="submitDietLog(event)">
        <div class="modal-body" style="padding: 22px 24px;">
          <!-- Meal Category Picker -->
          <div class="form-group mb-3">
            <label style="font-weight: 700; font-size: 12.5px; color: #475569;">MEAL TIME CATEGORY</label>
            <select name="meal_category" id="dtModalMealCat" class="form-control" style="border-radius: 8px; height: 42px; font-weight: 600;">
              <option value="breakfast">Breakfast (Morning)</option>
              <option value="brunch">Brunch (Late Morning)</option>
              <option value="lunch">Lunch (Afternoon)</option>
              <option value="snacks">Snacks (Evening Tea & Snacks)</option>
              <option value="dinner">Dinner (Night Meal)</option>
            </select>
          </div>

          <!-- Food Search Autocomplete -->
          <div class="form-group mb-3 dt-search-container">
            <label style="font-weight: 700; font-size: 12.5px; color: #475569;">SEARCH FOOD ITEM</label>
            <i class="fas fa-search dt-search-icon"></i>
            <input type="text" id="dtSearchFoodInput" class="dt-search-input" placeholder="Type food name (e.g. Roti, Apple, Dal, Eggs)..." autocomplete="off" required>
            <!-- Dropdown autocomplete list -->
            <div id="dtSearchDropdown" class="dt-dropdown-results"></div>
          </div>

          <!-- Hidden Food Fields -->
          <input type="hidden" name="food_id" id="dtFieldFoodId" value="">
          <input type="hidden" name="food_name" id="dtFieldFoodName" value="">
          <input type="hidden" name="calories" id="dtFieldCalories" value="0">
          <input type="hidden" name="protein" id="dtFieldProtein" value="0">
          <input type="hidden" name="carbs" id="dtFieldCarbs" value="0">
          <input type="hidden" name="fats" id="dtFieldFats" value="0">
          <input type="hidden" name="fiber" id="dtFieldFiber" value="0">
          <input type="hidden" name="iron" id="dtFieldIron" value="0">
          <input type="hidden" name="calcium" id="dtFieldCalcium" value="0">
          <input type="hidden" name="vitamin_c" id="dtFieldVitaminC" value="0">
          <input type="hidden" name="base_serving" id="dtBaseServing" value="1">
          <input type="hidden" name="log_date" id="dtModalLogDate" value="<?= htmlspecialchars($current_date); ?>">

          <!-- Quantity & Serving Unit -->
          <div class="row mb-3">
            <div class="col-6">
              <label style="font-weight: 700; font-size: 12.5px; color: #475569;">QUANTITY</label>
              <input type="number" step="0.1" min="0.1" name="quantity" id="dtFieldQuantity" class="form-control" value="1" style="border-radius: 8px; height: 42px; font-weight: 700;" required oninput="recalcModalNutrition()">
            </div>
            <div class="col-6">
              <label style="font-weight: 700; font-size: 12.5px; color: #475569;">SERVING UNIT</label>
              <input type="text" name="serving_unit" id="dtFieldServingUnit" class="form-control" value="serving" style="border-radius: 8px; height: 42px;" placeholder="e.g. piece, bowl, g">
            </div>
          </div>

          <!-- Live Nutrition Preview Card -->
          <div id="dtPreviewCard" class="dt-preview-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <strong id="dtPreviewName" style="color: #0F172A; font-size: 13.5px;">Food Item</strong>
              <span id="dtPreviewCal" class="badge badge-primary" style="font-size: 12px; background: #0284C7;">0 kcal</span>
            </div>
            <div class="dt-preview-grid">
              <div class="dt-preview-stat">
                <small>Protein</small>
                <strong id="dtPrevPro">0g</strong>
              </div>
              <div class="dt-preview-stat">
                <small>Carbs</small>
                <strong id="dtPrevCarb">0g</strong>
              </div>
              <div class="dt-preview-stat">
                <small>Fats</small>
                <strong id="dtPrevFat">0g</strong>
              </div>
              <div class="dt-preview-stat">
                <small>Fiber</small>
                <strong id="dtPrevFiber">0g</strong>
              </div>
            </div>
          </div>

          <!-- Notes -->
          <div class="form-group mb-0">
            <label style="font-weight: 700; font-size: 12.5px; color: #475569;">NOTES (OPTIONAL)</label>
            <input type="text" name="notes" id="dtFieldNotes" class="form-control" placeholder="e.g. with 1 tsp ghee, no sugar" style="border-radius: 8px;">
          </div>
        </div>
        <div class="modal-footer" style="background: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 14px 24px;">
          <button type="button" class="btn btn-light" data-dismiss="modal" style="font-weight: 600; border-radius: 8px;">Cancel</button>
          <button type="submit" id="dtSubmitBtn" class="btn btn-primary" style="background: #00A896; border-color: #00A896; font-weight: 700; border-radius: 8px; padding: 8px 22px;">
            <i class="fas fa-check"></i> Log Food Item
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Base Nutrition storage for dynamic scaling
var dtCurrentBaseFood = null;
var dtSearchDebounce = null;
var dtActiveDate = "<?= htmlspecialchars($current_date); ?>";

// Open Log Modal with pre-selected meal category
function openLogModal(mealCat) {
  if (mealCat) {
    $('#dtModalMealCat').val(mealCat);
  }
  $('#dtModalLogDate').val(dtActiveDate);
  $('#dtSearchFoodInput').val('');
  $('#dtSearchDropdown').hide();
  $('#dtPreviewCard').hide();
  $('#dtFieldFoodId').val('');
  $('#dtFieldFoodName').val('');
  $('#dtFieldQuantity').val('1');
  dtCurrentBaseFood = null;
  $('#dtAddFoodModal').modal('show');
  setTimeout(function() { $('#dtSearchFoodInput').focus(); }, 400);
}

// Autocomplete Search
$('#dtSearchFoodInput').on('input focus', function() {
  var q = $(this).val().trim();
  clearTimeout(dtSearchDebounce);
  dtSearchDebounce = setTimeout(function() {
    searchFoodApi(q);
  }, 250);
});

// Click outside dropdown to hide
$(document).on('click', function(e) {
  if (!$(e.target).closest('.dt-search-container').length) {
    $('#dtSearchDropdown').hide();
  }
});

function searchFoodApi(q) {
  var dropdown = $('#dtSearchDropdown');
  $.ajax({
    url: "<?= base_url('diet/search'); ?>",
    type: "GET",
    data: { q: q },
    dataType: "json",
    success: function(res) {
      if (res && res.status === 'success' && res.data && res.data.length > 0) {
        var html = '';
        res.data.forEach(function(item) {
          html += '<div class="dt-dropdown-item" onclick="selectFoodItem(' + JSON.stringify(item).replace(/"/g, '&quot;') + ')">';
          html += '  <div class="dt-dropdown-item-info">';
          html += '    <strong>' + item.name + '</strong>';
          html += '    <small>' + (item.category || 'General') + ' &bull; ' + item.serving_size + ' ' + item.serving_unit + '</small>';
          html += '  </div>';
          html += '  <div class="dt-dropdown-item-cal">' + Math.round(item.calories) + ' kcal</div>';
          html += '</div>';
        });
        dropdown.html(html).show();
      } else {
        dropdown.html('<div style="padding:12px 16px; color:#94A3B8; font-size:13px;">No foods found. Enter a custom name to log anyway.</div>').show();
        // Allow custom entry
        $('#dtFieldFoodId').val('');
        $('#dtFieldFoodName').val(q);
      }
    }
  });
}

function selectFoodItem(item) {
  dtCurrentBaseFood = item;
  $('#dtSearchFoodInput').val(item.name);
  $('#dtSearchDropdown').hide();

  $('#dtFieldFoodId').val(item.id);
  $('#dtFieldFoodName').val(item.name);
  $('#dtFieldServingUnit').val(item.serving_unit);
  $('#dtBaseServing').val(item.serving_size > 0 ? item.serving_size : 1);
  $('#dtFieldQuantity').val('1');

  recalcModalNutrition();
  $('#dtPreviewCard').show();
}

function recalcModalNutrition() {
  var qty = parseFloat($('#dtFieldQuantity').val()) || 1;
  if (!dtCurrentBaseFood) {
    return;
  }

  var baseServ = parseFloat(dtCurrentBaseFood.serving_size) > 0 ? parseFloat(dtCurrentBaseFood.serving_size) : 1;
  var mult = qty / baseServ;

  var cal = Math.round(parseFloat(dtCurrentBaseFood.calories || 0) * mult);
  var pro = (parseFloat(dtCurrentBaseFood.protein || 0) * mult).toFixed(1);
  var carb = (parseFloat(dtCurrentBaseFood.carbs || 0) * mult).toFixed(1);
  var fat = (parseFloat(dtCurrentBaseFood.fats || 0) * mult).toFixed(1);
  var fib = (parseFloat(dtCurrentBaseFood.fiber || 0) * mult).toFixed(1);
  var iron = (parseFloat(dtCurrentBaseFood.iron || 0) * mult).toFixed(2);
  var calc = (parseFloat(dtCurrentBaseFood.calcium || 0) * mult).toFixed(1);
  var vitc = (parseFloat(dtCurrentBaseFood.vitamin_c || 0) * mult).toFixed(1);

  $('#dtFieldCalories').val(cal);
  $('#dtFieldProtein').val(pro);
  $('#dtFieldCarbs').val(carb);
  $('#dtFieldFats').val(fat);
  $('#dtFieldFiber').val(fib);
  $('#dtFieldIron').val(iron);
  $('#dtFieldCalcium').val(calc);
  $('#dtFieldVitaminC').val(vitc);

  $('#dtPreviewName').text(dtCurrentBaseFood.name + ' (' + qty + ' ' + $('#dtFieldServingUnit').val() + ')');
  $('#dtPreviewCal').text(cal + ' kcal');
  $('#dtPrevPro').text(pro + 'g');
  $('#dtPrevCarb').text(carb + 'g');
  $('#dtPrevFat').text(fat + 'g');
  $('#dtPrevFiber').text(fib + 'g');
}

// Submit Log Form
function submitDietLog(e) {
  e.preventDefault();
  var btn = $('#dtSubmitBtn');
  var origHtml = btn.html();
  btn.html('<i class="fas fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

  // If custom food without selecting from dropdown
  if (!$('#dtFieldFoodId').val() && $('#dtSearchFoodInput').val().trim()) {
    $('#dtFieldFoodName').val($('#dtSearchFoodInput').val().trim());
  }

  $.ajax({
    url: "<?= base_url('diet/add_log'); ?>",
    type: "POST",
    data: $('#dtLogFoodForm').serialize(),
    dataType: "json",
    success: function(res) {
      btn.html(origHtml).prop('disabled', false);
      if (res && res.status === 'success') {
        $('#dtAddFoodModal').modal('hide');
        applyDietSummary(res.summary);
      } else {
        alert(res ? res.message : 'Failed to save food log.');
      }
    },
    error: function() {
      btn.html(origHtml).prop('disabled', false);
      alert('Network error while saving meal. Please try again.');
    }
  });
}

// Delete Log Item
function deleteDietItem(logId) {
  if (!confirm('Are you sure you want to remove this logged food item?')) return;
  $.ajax({
    url: "<?= base_url('diet/delete_log'); ?>",
    type: "POST",
    data: { log_id: logId, log_date: dtActiveDate },
    dataType: "json",
    success: function(res) {
      if (res && res.status === 'success') {
        $('#dtItem_' + logId).fadeOut(200, function() { $(this).remove(); });
        applyDietSummary(res.summary);
      }
    }
  });
}

// Update UI with summary payload
function applyDietSummary(s) {
  if (!s) return;
  dtActiveDate = s.date;
  $('#dtDatePicker').val(s.date);

  // Calories
  $('#dtCalConsumed').text(Math.round(s.consumed.calories));
  $('#dtCalBar').css('width', Math.min(100, s.percentages.calories) + '%');
  $('#dtCalPct').text(s.percentages.calories + '% of target');
  $('#dtCalRem').text(Math.round(s.remaining.calories) + ' kcal left');

  // Protein
  $('#dtProConsumed').text(parseFloat(s.consumed.protein).toFixed(1));
  $('#dtProBar').css('width', Math.min(100, s.percentages.protein) + '%');
  $('#dtProPct').text(s.percentages.protein + '%');
  $('#dtProRem').text(parseFloat(s.remaining.protein).toFixed(1) + ' g left');

  // Carbs
  $('#dtCarbConsumed').text(parseFloat(s.consumed.carbs).toFixed(1));
  $('#dtCarbBar').css('width', Math.min(100, s.percentages.carbs) + '%');
  $('#dtCarbPct').text(s.percentages.carbs + '%');
  $('#dtCarbRem').text(parseFloat(s.remaining.carbs).toFixed(1) + ' g left');

  // Fats
  $('#dtFatConsumed').text(parseFloat(s.consumed.fats).toFixed(1));
  $('#dtFatBar').css('width', Math.min(100, s.percentages.fats) + '%');
  $('#dtFatPct').text(s.percentages.fats + '%');
  $('#dtFatRem').text(parseFloat(s.remaining.fats).toFixed(1) + ' g left');

  // Fiber
  $('#dtFiberConsumed').text(parseFloat(s.consumed.fiber).toFixed(1));
  $('#dtFiberBar').css('width', Math.min(100, s.percentages.fiber) + '%');
  $('#dtFiberPct').text(s.percentages.fiber + '%');
  $('#dtFiberRem').text(parseFloat(s.remaining.fiber).toFixed(1) + ' g left');

  // Micronutrients
  $('#dtIronVal').text(parseFloat(s.consumed.iron).toFixed(2) + ' mg');
  $('#dtIronPct').text(s.percentages.iron + '%');
  $('#dtCalcVal').text(parseFloat(s.consumed.calcium).toFixed(1) + ' mg');
  $('#dtCalcPct').text(s.percentages.calcium + '%');
  $('#dtVitCVal').text(parseFloat(s.consumed.vitamin_c).toFixed(1) + ' mg');
  $('#dtVitCPct').text(s.percentages.vitamin_c + '%');

  // Update Badge in Profile if embedded
  if ($('#dietLoggedItemsCount').length) {
    $('#dietLoggedItemsCount').text(s.consumed.total_items || 0);
  }

  // Update Meal Sections
  if (s.meal_categories) {
    Object.keys(s.meal_categories).forEach(function(catKey) {
      var cat = s.meal_categories[catKey];
      $('#dtCount_' + catKey).text(cat.count || (cat.items ? cat.items.length : 0));
      $('#dtBadgeCal_' + catKey).html('<i class="fas fa-fire"></i> ' + Math.round(cat.subtotal.calories) + ' kcal');

      var list = $('#dtFoodList_' + catKey);
      if (cat.items && cat.items.length > 0) {
        var itemsHtml = '';
        cat.items.forEach(function(item) {
          itemsHtml += '<li class="dt-food-item" id="dtItem_' + item.id + '">';
          itemsHtml += '  <div>';
          itemsHtml += '    <div class="dt-food-name">' + item.food_name + '</div>';
          itemsHtml += '    <div class="dt-food-portion">' + parseFloat(item.quantity) + ' ' + item.serving_unit + (item.notes ? ' &bull; <span class="text-muted font-italic">' + item.notes + '</span>' : '') + '</div>';
          itemsHtml += '  </div>';
          itemsHtml += '  <div class="dt-food-macros">';
          itemsHtml += '    <span><strong>' + Math.round(item.calories) + ' kcal</strong><small>Energy</small></span>';
          itemsHtml += '    <span><strong>' + parseFloat(item.protein).toFixed(1) + 'g</strong><small>Prot</small></span>';
          itemsHtml += '    <span><strong>' + parseFloat(item.carbs).toFixed(1) + 'g</strong><small>Carb</small></span>';
          itemsHtml += '    <span><strong>' + parseFloat(item.fats).toFixed(1) + 'g</strong><small>Fat</small></span>';
          itemsHtml += '    <button type="button" class="dt-btn-del" onclick="deleteDietItem(' + item.id + ')" title="Remove item"><i class="fas fa-trash-alt"></i></button>';
          itemsHtml += '  </div>';
          itemsHtml += '</li>';
        });
        list.html(itemsHtml);
      } else {
        list.html('<div class="dt-empty-meal"><i class="fas fa-utensils"></i>No food logged for ' + cat.title + ' yet. Click "+ Add Item" to log.</div>');
      }
    });
  }
}

// Date Navigation
function loadDateSummary(dt) {
  $.ajax({
    url: "<?= base_url('diet/get_summary'); ?>",
    type: "GET",
    data: { date: dt },
    dataType: "json",
    success: function(res) {
      if (res && res.status === 'success') {
        applyDietSummary(res.summary);
      }
    }
  });
}

$('#dtDatePicker').on('change', function() {
  loadDateSummary($(this).val());
});

$('#dtPrevDayBtn').click(function() {
  var d = new Date(dtActiveDate);
  d.setDate(d.getDate() - 1);
  var newDt = d.toISOString().split('T')[0];
  loadDateSummary(newDt);
});

$('#dtNextDayBtn').click(function() {
  var d = new Date(dtActiveDate);
  d.setDate(d.getDate() + 1);
  var newDt = d.toISOString().split('T')[0];
  loadDateSummary(newDt);
});

$('#dtTodayBtn').click(function() {
  var today = new Date().toISOString().split('T')[0];
  loadDateSummary(today);
});
</script>
