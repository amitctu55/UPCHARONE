<?php
/**
 * Daily Diet Tracker - Modernized & Streamlined View
 * High-performance, clutter-free clinical nutrition dashboard
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

<!-- Load Font Awesome 6 for crisp icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ==========================================================================
   UPCHAR CLINICAL DIET TRACKER - STREAMLINED MODERN DESIGN SYSTEM
   ========================================================================== */
:root {
  --dt-teal: #00A896;
  --dt-teal-dark: #028090;
  --dt-teal-light: #E6FFFA;
  --dt-navy: #0F172A;
  --dt-slate: #334155;
  --dt-muted: #64748B;
  --dt-bg: #F8FAFC;
  --dt-border: #E2E8F0;
  --dt-card-bg: #FFFFFF;
  
  /* Macro Accent Colors */
  --dt-cal: #00A896;
  --dt-pro: #F43F5E;
  --dt-carb: #0284C7;
  --dt-fat: #F59E0B;
  --dt-fiber: #10B981;
}

.dt-container {
  font-family: -apple-system, BlinkMacSystemFont, "Plus Jakarta Sans", "Inter", "Segoe UI", Roboto, sans-serif;
  color: var(--dt-slate);
  padding: 10px 0 40px;
}

/* ==========================================================================
   1. TOP-LEVEL HERO CALORIES BAR & DATE CONTROLLER
   ========================================================================== */
.dt-hero-card {
  background: linear-gradient(135deg, #0F172A 0%, #1E293B 65%, #028090 100%);
  border-radius: 18px;
  color: #FFFFFF;
  padding: 26px 30px;
  margin-bottom: 22px;
  box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
  position: relative;
  overflow: hidden;
}
.dt-hero-card::after {
  content: "";
  position: absolute;
  top: -40px;
  right: -40px;
  width: 200px;
  height: 200px;
  background: radial-gradient(circle, rgba(0, 168, 150, 0.2) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.dt-hero-top {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 18px;
  margin-bottom: 20px;
}
.dt-hero-info {
  flex: 1 1 320px;
}
.dt-hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(0, 168, 150, 0.25);
  color: #2DD4BF;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  padding: 4px 10px;
  border-radius: 20px;
  margin-bottom: 8px;
  border: 1px solid rgba(45, 212, 191, 0.3);
}
.dt-hero-heading {
  margin: 0 0 6px;
  font-size: 32px;
  font-weight: 800;
  letter-spacing: -0.5px;
  display: flex;
  align-items: baseline;
  gap: 10px;
}
.dt-hero-heading .dt-hero-target {
  font-size: 16px;
  font-weight: 600;
  color: #94A3B8;
}
.dt-hero-sub {
  margin: 0;
  font-size: 13.5px;
  color: #CBD5E1;
}
.dt-hero-sub strong {
  color: #FFFFFF;
}

/* Date Navigator */
.dt-date-nav {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  padding: 6px 12px;
  border-radius: 14px;
  border: 1px solid rgba(255, 255, 255, 0.15);
}
.dt-date-arrow {
  background: rgba(255, 255, 255, 0.15);
  border: none;
  color: #FFFFFF;
  width: 34px;
  height: 34px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 13px;
}
.dt-date-arrow:hover {
  background: var(--dt-teal);
  transform: scale(1.05);
}
.dt-date-display {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 0 6px;
}
.dt-date-icon {
  color: #2DD4BF;
  font-size: 14px;
}
.dt-date-input {
  background: transparent;
  border: none;
  color: #FFFFFF;
  font-weight: 700;
  font-size: 14px;
  outline: none;
  cursor: pointer;
  width: 130px;
}
.dt-date-input::-webkit-calendar-picker-indicator {
  filter: invert(1);
  cursor: pointer;
}
.dt-date-today-btn {
  background: var(--dt-teal);
  color: #FFFFFF;
  border: none;
  border-radius: 8px;
  padding: 6px 12px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}
.dt-date-today-btn:hover {
  background: var(--dt-teal-dark);
}

/* Hero Progress Track */
.dt-hero-progress-wrap {
  width: 100%;
}
.dt-hero-progress-labels {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  font-weight: 600;
  color: #CBD5E1;
  margin-bottom: 8px;
}
.dt-hero-progress-track {
  height: 12px;
  background: rgba(255, 255, 255, 0.16);
  border-radius: 20px;
  overflow: hidden;
  position: relative;
}
.dt-hero-progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #2DD4BF 0%, #00A896 100%);
  border-radius: 20px;
  transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ==========================================================================
   2. CORE MACROS 4-COLUMN RESPONSIVE GRID
   ========================================================================== */
.dt-macro-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 20px;
}
@media (max-width: 991px) {
  .dt-macro-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 575px) {
  .dt-macro-grid {
    grid-template-columns: 1fr;
  }
}

.dt-macro-card {
  background: var(--dt-card-bg);
  border-radius: 16px;
  border: 1px solid var(--dt-border);
  padding: 18px 20px;
  box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.04);
  transition: transform 0.2s, box-shadow 0.2s;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.dt-macro-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px -3px rgba(15, 23, 42, 0.08);
}
.dt-macro-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}
.dt-macro-icon-group {
  display: flex;
  align-items: center;
  gap: 10px;
}
.dt-macro-icon {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
}
.dt-macro-icon.pro { background: #FFE4E6; color: var(--dt-pro); }
.dt-macro-icon.carb { background: #E0F2FE; color: var(--dt-carb); }
.dt-macro-icon.fat { background: #FEF3C7; color: var(--dt-fat); }
.dt-macro-icon.fiber { background: #D1FAE5; color: var(--dt-fiber); }

.dt-macro-title {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--dt-muted);
}
.dt-macro-pct {
  font-size: 12px;
  font-weight: 800;
  padding: 3px 8px;
  border-radius: 12px;
}
.dt-macro-pct.pro { background: #FFF1F2; color: #BE123C; }
.dt-macro-pct.carb { background: #F0F9FF; color: #0369A1; }
.dt-macro-pct.fat { background: #FFFBEB; color: #B45309; }
.dt-macro-pct.fiber { background: #ECFDF5; color: #047857; }

.dt-macro-numbers {
  display: flex;
  align-items: baseline;
  gap: 6px;
  margin-bottom: 10px;
}
.dt-macro-consumed {
  font-size: 22px;
  font-weight: 800;
  color: var(--dt-navy);
}
.dt-macro-target {
  font-size: 13px;
  font-weight: 600;
  color: var(--dt-muted);
}
.dt-progress-track {
  height: 7px;
  background: #F1F5F9;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 8px;
}
.dt-progress-fill {
  height: 100%;
  border-radius: 10px;
  transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.dt-progress-fill.pro { background: var(--dt-pro); }
.dt-progress-fill.carb { background: var(--dt-carb); }
.dt-progress-fill.fat { background: var(--dt-fat); }
.dt-progress-fill.fiber { background: var(--dt-fiber); }

.dt-macro-subtext {
  font-size: 11.5px;
  font-weight: 600;
  color: var(--dt-muted);
  display: flex;
  justify-content: space-between;
}

/* ==========================================================================
   3. MICRONUTRIENTS COMPACT REFERENCE STRIP
   ========================================================================== */
.dt-micro-card {
  background: var(--dt-card-bg);
  border-radius: 16px;
  border: 1px solid var(--dt-border);
  padding: 16px 22px;
  margin-bottom: 24px;
  box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.03);
}
.dt-micro-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}
.dt-micro-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--dt-navy);
  display: flex;
  align-items: center;
  gap: 8px;
}
.dt-micro-ref {
  font-size: 11px;
  font-weight: 600;
  color: var(--dt-muted);
  background: #F1F5F9;
  padding: 3px 9px;
  border-radius: 8px;
}
.dt-micro-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
}
@media (max-width: 767px) {
  .dt-micro-grid {
    grid-template-columns: 1fr;
  }
}
.dt-micro-pill {
  background: #F8FAFC;
  border: 1px solid var(--dt-border);
  border-radius: 12px;
  padding: 10px 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}
.dt-micro-pill-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.dt-micro-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
}
.dt-micro-icon.iron { background: #FFE4E6; color: #E11D48; }
.dt-micro-icon.calcium { background: #E0F2FE; color: #0284C7; }
.dt-micro-icon.vitc { background: #FEF3C7; color: #D97706; }

.dt-micro-label {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--dt-muted);
  text-transform: uppercase;
}
.dt-micro-val {
  font-size: 13.5px;
  font-weight: 800;
  color: var(--dt-navy);
}
.dt-micro-target {
  font-size: 11px;
  color: var(--dt-muted);
  font-weight: 500;
}
.dt-micro-badge {
  font-size: 11px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 10px;
  background: #E2E8F0;
  color: #475569;
}
.dt-micro-badge.achieved {
  background: #DCFCE7;
  color: #15803D;
}

/* ==========================================================================
   4. MEAL SECTION CARDS (BREAKFAST, BRUNCH, LUNCH, SNACKS, DINNER)
   ========================================================================== */
.dt-meal-card {
  background: var(--dt-card-bg);
  border-radius: 16px;
  border: 1px solid var(--dt-border);
  margin-bottom: 18px;
  box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.04);
  overflow: hidden;
  transition: border-color 0.2s;
}
.dt-meal-header {
  padding: 16px 22px;
  background: #F8FAFC;
  border-bottom: 1px solid var(--dt-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}
.dt-meal-header-left {
  display: flex;
  align-items: center;
  gap: 14px;
}
.dt-meal-icon {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  font-size: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
}
.dt-meal-title {
  margin: 0;
  font-size: 16.5px;
  font-weight: 800;
  color: var(--dt-navy);
  display: flex;
  align-items: center;
  gap: 10px;
}
.dt-meal-count-badge {
  font-size: 11.5px;
  font-weight: 700;
  background: #E2E8F0;
  color: #334155;
  padding: 2px 8px;
  border-radius: 12px;
}
.dt-meal-header-right {
  display: flex;
  align-items: center;
  gap: 12px;
}
.dt-meal-cal-badge {
  background: #EFF6FF;
  color: #1D4ED8;
  font-weight: 800;
  font-size: 13px;
  padding: 5px 12px;
  border-radius: 10px;
  border: 1px solid #BFDBFE;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.dt-btn-add-item {
  background: var(--dt-teal);
  color: #FFFFFF;
  border: none;
  font-weight: 700;
  font-size: 13px;
  padding: 7px 16px;
  border-radius: 10px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
  box-shadow: 0 4px 10px rgba(0, 168, 150, 0.25);
}
.dt-btn-add-item:hover {
  background: var(--dt-teal-dark);
  color: #FFFFFF;
  transform: translateY(-1px);
}

/* Compact Logged Items List */
.dt-food-list {
  padding: 0;
  margin: 0;
  list-style: none;
}
.dt-food-row {
  padding: 14px 22px;
  border-bottom: 1px solid #F1F5F9;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  transition: background-color 0.15s;
}
.dt-food-row:last-child {
  border-bottom: none;
}
.dt-food-row:hover {
  background-color: #F8FAFC;
}
.dt-food-row-main {
  flex: 1 1 240px;
  min-width: 0;
}
.dt-food-name {
  font-size: 14.5px;
  font-weight: 700;
  color: var(--dt-navy);
  margin-bottom: 2px;
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.dt-food-notes {
  font-size: 12px;
  color: #64748B;
  font-style: italic;
  display: block;
}

.dt-food-row-meta {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  justify-content: flex-end;
}
.dt-pill-qty {
  font-size: 12px;
  font-weight: 700;
  color: #475569;
  background: #F1F5F9;
  padding: 4px 10px;
  border-radius: 8px;
  border: 1px solid #E2E8F0;
  white-space: nowrap;
}
.dt-pill-cal {
  font-size: 13.5px;
  font-weight: 800;
  color: var(--dt-navy);
  background: #F0FDF4;
  color: #15803D;
  padding: 4px 10px;
  border-radius: 8px;
  border: 1px solid #BBF7D0;
  white-space: nowrap;
}

/* Standardized Macro Chips (P: Xg | C: Yg | F: Zg) */
.dt-macro-chips {
  display: flex;
  align-items: center;
  gap: 6px;
}
.dt-chip {
  font-size: 11.5px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 6px;
  white-space: nowrap;
}
.dt-chip-pro { background: #FFF1F2; color: #BE123C; border: 1px solid #FFE4E6; }
.dt-chip-carb { background: #F0F9FF; color: #0369A1; border: 1px solid #E0F2FE; }
.dt-chip-fat { background: #FFFBEB; color: #B45309; border: 1px solid #FEF3C7; }

/* Subtle Delete Action */
.dt-btn-del {
  background: transparent;
  border: none;
  color: #94A3B8;
  padding: 6px 8px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 13px;
}
.dt-btn-del:hover {
  color: #EF4444;
  background: #FEE2E2;
}

/* Empty State With Dashed Button */
.dt-empty-meal {
  padding: 28px 20px;
  text-align: center;
  color: #94A3B8;
}
.dt-empty-text {
  font-size: 13px;
  color: #64748B;
  margin: 0 0 12px;
}
.dt-btn-empty-add {
  background: #FFFFFF;
  border: 1.5px dashed #CBD5E1;
  color: #475569;
  font-size: 13px;
  font-weight: 700;
  padding: 8px 20px;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.dt-btn-empty-add:hover {
  border-color: var(--dt-teal);
  color: var(--dt-teal);
  background: #F0FDFA;
}

/* ==========================================================================
   5. REFINED POPUP MODAL (LOG FOOD INTAKE)
   ========================================================================== */
.dt-modal .modal-content {
  border-radius: 20px;
  border: none;
  box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.35);
  overflow: hidden;
}
.dt-modal .modal-header {
  background: linear-gradient(135deg, #0F172A 0%, #028090 100%);
  color: #FFFFFF;
  padding: 20px 24px;
  border-bottom: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.dt-modal .modal-title {
  font-size: 18px;
  font-weight: 800;
  color: #FFFFFF;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 10px;
}
.dt-modal .close {
  color: #FFFFFF;
  opacity: 0.85;
  font-size: 24px;
  background: transparent;
  border: none;
  cursor: pointer;
}
.dt-modal .close:hover {
  opacity: 1;
}

.dt-form-label {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #475569;
  margin-bottom: 6px;
  display: block;
}

/* Autocomplete Search input */
.dt-search-wrapper {
  position: relative;
}
.dt-search-input {
  width: 100%;
  height: 46px;
  border-radius: 12px;
  border: 1.5px solid var(--dt-border);
  padding: 10px 16px 10px 42px;
  font-size: 14px;
  font-weight: 600;
  color: var(--dt-navy);
  outline: none;
  transition: all 0.2s;
  background: #FFFFFF;
}
.dt-search-input:focus {
  border-color: var(--dt-teal);
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
  top: 52px;
  left: 0;
  right: 0;
  background: #FFFFFF;
  border: 1px solid var(--dt-border);
  border-radius: 14px;
  max-height: 280px;
  overflow-y: auto;
  z-index: 1060;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
  display: none;
}
.dt-dropdown-item {
  padding: 12px 18px;
  border-bottom: 1px solid #F1F5F9;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: background-color 0.15s;
}
.dt-dropdown-item:last-child {
  border-bottom: none;
}
.dt-dropdown-item:hover, .dt-dropdown-item.active {
  background-color: #F0FDFA;
}
.dt-dropdown-info strong {
  font-size: 14px;
  color: var(--dt-navy);
  display: block;
  margin-bottom: 2px;
}
.dt-dropdown-info small {
  font-size: 12px;
  color: #64748B;
}
.dt-dropdown-cal {
  text-align: right;
  font-size: 13.5px;
  font-weight: 800;
  color: var(--dt-carb);
}

/* Quick Staple Tags */
.dt-staple-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-top: 8px;
}
.dt-staple-tag {
  background: #F1F5F9;
  color: #475569;
  font-size: 11px;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 14px;
  cursor: pointer;
  transition: all 0.15s;
}
.dt-staple-tag:hover {
  background: var(--dt-teal);
  color: #FFFFFF;
}

/* Live Macro Preview Box */
.dt-preview-card {
  background: #F8FAFC;
  border: 1.5px dashed #CBD5E1;
  border-radius: 14px;
  padding: 16px;
  margin: 16px 0;
  display: none;
}
.dt-preview-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}
.dt-preview-label {
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  color: #64748B;
  display: block;
}
.dt-preview-name {
  font-size: 14.5px;
  font-weight: 800;
  color: var(--dt-navy);
}
.dt-preview-cal-badge {
  background: #0284C7;
  color: #FFFFFF;
  font-size: 13px;
  font-weight: 800;
  padding: 4px 12px;
  border-radius: 8px;
}
.dt-preview-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 8px;
}
.dt-preview-cell {
  background: #FFFFFF;
  border: 1px solid var(--dt-border);
  border-radius: 10px;
  padding: 8px 10px;
  text-align: center;
}
.dt-preview-cell small {
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  display: block;
  margin-bottom: 2px;
}
.dt-preview-cell strong {
  font-size: 14px;
  font-weight: 800;
}
.dt-preview-cell.pro small { color: var(--dt-pro); }
.dt-preview-cell.pro strong { color: var(--dt-pro); }
.dt-preview-cell.carb small { color: var(--dt-carb); }
.dt-preview-cell.carb strong { color: var(--dt-carb); }
.dt-preview-cell.fat small { color: var(--dt-fat); }
.dt-preview-cell.fat strong { color: var(--dt-fat); }
.dt-preview-cell.fiber small { color: var(--dt-fiber); }
.dt-preview-cell.fiber strong { color: var(--dt-fiber); }

/* Toast Feedback */
@keyframes dtFadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.dt-toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  z-index: 99999;
  color: #FFFFFF;
  padding: 12px 20px;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 700;
  font-size: 13.5px;
  animation: dtFadeIn 0.3s ease;
}
</style>

<div class="dt-container">

  <!-- ====================================================================== -->
  <!-- 1. TOP-LEVEL HERO CALORIES PROGRESS CARD & DATE SELECTOR               -->
  <!-- ====================================================================== -->
  <div class="dt-hero-card">
    <div class="dt-hero-top">
      <div class="dt-hero-info">
        <div class="dt-hero-badge">
          <i class="fa fa-fire"></i> Daily Energy Budget
        </div>
        <h1 class="dt-hero-heading">
          <span id="dtCalConsumed"><?= number_format($consumed['calories']); ?></span>
          <span class="dt-hero-target">/ <?= number_format($targets['target_calories']); ?> kcal</span>
        </h1>
        <p class="dt-hero-sub">
          <span id="dtCalPct"><?= $pct['calories']; ?>%</span> of target reached &bull; 
          <strong id="dtCalRem"><?= number_format($rem['calories']); ?> kcal</strong> remaining today
        </p>
      </div>

      <!-- Date Navigation -->
      <div class="dt-date-nav">
        <button type="button" class="dt-date-arrow" id="dtPrevDayBtn" title="Previous Day">
          <i class="fa fa-chevron-left"></i>
        </button>
        <div class="dt-date-display">
          <i class="fa fa-calendar dt-date-icon"></i>
          <input type="date" id="dtDatePicker" class="dt-date-input" value="<?= htmlspecialchars($current_date); ?>">
        </div>
        <button type="button" class="dt-date-arrow" id="dtNextDayBtn" title="Next Day">
          <i class="fa fa-chevron-right"></i>
        </button>
        <button type="button" class="dt-date-today-btn" id="dtTodayBtn">
          Today
        </button>
      </div>
    </div>

    <!-- Hero Progress Bar -->
    <div class="dt-hero-progress-wrap">
      <div class="dt-hero-progress-track">
        <div id="dtCalBar" class="dt-hero-progress-fill" style="width: <?= min(100, max(0, $pct['calories'])); ?>%;"></div>
      </div>
    </div>
  </div>

  <!-- ====================================================================== -->
  <!-- 2. CORE MACROS 4-COLUMN RESPONSIVE GRID                                -->
  <!-- ====================================================================== -->
  <div class="dt-macro-grid">
    <!-- 1. Protein -->
    <div class="dt-macro-card" style="border-top: 3.5px solid var(--dt-pro);">
      <div class="dt-macro-card-header">
        <div class="dt-macro-icon-group">
          <div class="dt-macro-icon pro"><i class="fa fa-dumbbell fa-shield"></i></div>
          <span class="dt-macro-title">Protein</span>
        </div>
        <span id="dtProPct" class="dt-macro-pct pro"><?= $pct['protein']; ?>%</span>
      </div>
      <div class="dt-macro-numbers">
        <span id="dtProConsumed" class="dt-macro-consumed"><?= number_format($consumed['protein'], 1); ?>g</span>
        <span class="dt-macro-target">/ <?= number_format($targets['protein_g']); ?>g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtProBar" class="dt-progress-fill pro" style="width: <?= min(100, max(0, $pct['protein'])); ?>%;"></div>
      </div>
      <div class="dt-macro-subtext">
        <span id="dtProRem"><?= number_format($rem['protein'], 1); ?>g left</span>
        <span>Goal: <?= number_format($targets['protein_g']); ?>g</span>
      </div>
    </div>

    <!-- 2. Carbohydrates -->
    <div class="dt-macro-card" style="border-top: 3.5px solid var(--dt-carb);">
      <div class="dt-macro-card-header">
        <div class="dt-macro-icon-group">
          <div class="dt-macro-icon carb"><i class="fa fa-bread-slice fa-cubes"></i></div>
          <span class="dt-macro-title">Carbohydrates</span>
        </div>
        <span id="dtCarbPct" class="dt-macro-pct carb"><?= $pct['carbs']; ?>%</span>
      </div>
      <div class="dt-macro-numbers">
        <span id="dtCarbConsumed" class="dt-macro-consumed"><?= number_format($consumed['carbs'], 1); ?>g</span>
        <span class="dt-macro-target">/ <?= number_format($targets['carbs_g']); ?>g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtCarbBar" class="dt-progress-fill carb" style="width: <?= min(100, max(0, $pct['carbs'])); ?>%;"></div>
      </div>
      <div class="dt-macro-subtext">
        <span id="dtCarbRem"><?= number_format($rem['carbs'], 1); ?>g left</span>
        <span>Goal: <?= number_format($targets['carbs_g']); ?>g</span>
      </div>
    </div>

    <!-- 3. Healthy Fats -->
    <div class="dt-macro-card" style="border-top: 3.5px solid var(--dt-fat);">
      <div class="dt-macro-card-header">
        <div class="dt-macro-icon-group">
          <div class="dt-macro-icon fat"><i class="fa fa-cheese fa-pie-chart"></i></div>
          <span class="dt-macro-title">Healthy Fats</span>
        </div>
        <span id="dtFatPct" class="dt-macro-pct fat"><?= $pct['fats']; ?>%</span>
      </div>
      <div class="dt-macro-numbers">
        <span id="dtFatConsumed" class="dt-macro-consumed"><?= number_format($consumed['fats'], 1); ?>g</span>
        <span class="dt-macro-target">/ <?= number_format($targets['fat_g']); ?>g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtFatBar" class="dt-progress-fill fat" style="width: <?= min(100, max(0, $pct['fats'])); ?>%;"></div>
      </div>
      <div class="dt-macro-subtext">
        <span id="dtFatRem"><?= number_format($rem['fats'], 1); ?>g left</span>
        <span>Goal: <?= number_format($targets['fat_g']); ?>g</span>
      </div>
    </div>

    <!-- 4. Dietary Fiber -->
    <div class="dt-macro-card" style="border-top: 3.5px solid var(--dt-fiber);">
      <div class="dt-macro-card-header">
        <div class="dt-macro-icon-group">
          <div class="dt-macro-icon fiber"><i class="fa fa-seedling fa-leaf"></i></div>
          <span class="dt-macro-title">Dietary Fiber</span>
        </div>
        <span id="dtFiberPct" class="dt-macro-pct fiber"><?= $pct['fiber']; ?>%</span>
      </div>
      <div class="dt-macro-numbers">
        <span id="dtFiberConsumed" class="dt-macro-consumed"><?= number_format($consumed['fiber'], 1); ?>g</span>
        <span class="dt-macro-target">/ <?= number_format($targets['fiber_g']); ?>g</span>
      </div>
      <div class="dt-progress-track">
        <div id="dtFiberBar" class="dt-progress-fill fiber" style="width: <?= min(100, max(0, $pct['fiber'])); ?>%;"></div>
      </div>
      <div class="dt-macro-subtext">
        <span id="dtFiberRem"><?= number_format($rem['fiber'], 1); ?>g left</span>
        <span>Goal: <?= number_format($targets['fiber_g']); ?>g</span>
      </div>
    </div>
  </div>

  <!-- ====================================================================== -->
  <!-- 3. COMPACT MICRONUTRIENTS STRIP                                        -->
  <!-- ====================================================================== -->
  <div class="dt-micro-card">
    <div class="dt-micro-header">
      <div class="dt-micro-title">
        <i class="fa fa-heartbeat text-danger"></i> Essential Micronutrients &amp; Minerals
      </div>
      <span class="dt-micro-ref">Clinical RDA Reference</span>
    </div>
    <div class="dt-micro-grid">
      <!-- Iron -->
      <div class="dt-micro-pill">
        <div class="dt-micro-pill-info">
          <div class="dt-micro-icon iron"><i class="fa fa-tint"></i></div>
          <div>
            <div class="dt-micro-label">Iron (Fe)</div>
            <div>
              <span id="dtIronVal" class="dt-micro-val"><?= number_format($consumed['iron'], 2); ?> mg</span>
              <span class="dt-micro-target">/ <?= $targets['iron_mg']; ?> mg</span>
            </div>
          </div>
        </div>
        <span id="dtIronPct" class="dt-micro-badge <?= $pct['iron'] >= 100 ? 'achieved' : ''; ?>"><?= $pct['iron']; ?>%</span>
      </div>

      <!-- Calcium -->
      <div class="dt-micro-pill">
        <div class="dt-micro-pill-info">
          <div class="dt-micro-icon calcium"><i class="fa fa-bone fa-cube"></i></div>
          <div>
            <div class="dt-micro-label">Calcium (Ca)</div>
            <div>
              <span id="dtCalcVal" class="dt-micro-val"><?= number_format($consumed['calcium'], 1); ?> mg</span>
              <span class="dt-micro-target">/ <?= $targets['calcium_mg']; ?> mg</span>
            </div>
          </div>
        </div>
        <span id="dtCalcPct" class="dt-micro-badge <?= $pct['calcium'] >= 100 ? 'achieved' : ''; ?>"><?= $pct['calcium']; ?>%</span>
      </div>

      <!-- Vitamin C -->
      <div class="dt-micro-pill">
        <div class="dt-micro-pill-info">
          <div class="dt-micro-icon vitc"><i class="fa fa-lemon fa-sun-o"></i></div>
          <div>
            <div class="dt-micro-label">Vitamin C</div>
            <div>
              <span id="dtVitCVal" class="dt-micro-val"><?= number_format($consumed['vitamin_c'], 1); ?> mg</span>
              <span class="dt-micro-target">/ <?= $targets['vitamin_c_mg']; ?> mg</span>
            </div>
          </div>
        </div>
        <span id="dtVitCPct" class="dt-micro-badge <?= $pct['vitamin_c'] >= 100 ? 'achieved' : ''; ?>"><?= $pct['vitamin_c']; ?>%</span>
      </div>
    </div>
  </div>

  <!-- ====================================================================== -->
  <!-- 4. MEAL SECTION CARDS (BREAKFAST, BRUNCH, LUNCH, SNACKS, DINNER)       -->
  <!-- ====================================================================== -->
  <div id="dtMealsContainer">
    <?php foreach ($meals as $catKey => $catData): ?>
      <div class="dt-meal-card" id="dtMealCard_<?= $catKey; ?>">
        <!-- Meal Header -->
        <div class="dt-meal-header">
          <div class="dt-meal-header-left">
            <div class="dt-meal-icon" style="background: <?= $catData['color']; ?>;">
              <i class="fa <?= $catData['icon']; ?>"></i>
            </div>
            <div>
              <h3 class="dt-meal-title">
                <?= htmlspecialchars($catData['title']); ?>
                <span class="dt-meal-count-badge" id="dtCount_<?= $catKey; ?>">
                  <?= count($catData['items']); ?> items
                </span>
              </h3>
            </div>
          </div>
          <div class="dt-meal-header-right">
            <span class="dt-meal-cal-badge" id="dtBadgeCal_<?= $catKey; ?>">
              <i class="fa fa-fire"></i> <?= number_format($catData['subtotal']['calories']); ?> kcal
            </span>
            <button type="button" class="dt-btn-add-item" onclick="openLogModal('<?= $catKey; ?>')">
              <i class="fa fa-plus"></i> Add Item
            </button>
          </div>
        </div>

        <!-- Meal Items List -->
        <ul class="dt-food-list" id="dtFoodList_<?= $catKey; ?>">
          <?php if (!empty($catData['items'])): ?>
            <?php foreach ($catData['items'] as $item): ?>
              <li class="dt-food-row" id="dtItem_<?= $item['id']; ?>">
                <div class="dt-food-row-main">
                  <span class="dt-food-name"><?= htmlspecialchars($item['food_name']); ?></span>
                  <?php if (!empty($item['notes'])): ?>
                    <span class="dt-food-notes"><?= htmlspecialchars($item['notes']); ?></span>
                  <?php endif; ?>
                </div>
                <div class="dt-food-row-meta">
                  <span class="dt-pill-qty"><?= floatval($item['quantity']); ?> <?= htmlspecialchars($item['serving_unit']); ?></span>
                  <span class="dt-pill-cal"><?= number_format($item['calories']); ?> kcal</span>
                  <div class="dt-macro-chips">
                    <span class="dt-chip dt-chip-pro">P: <?= number_format($item['protein'], 1); ?>g</span>
                    <span class="dt-chip dt-chip-carb">C: <?= number_format($item['carbs'], 1); ?>g</span>
                    <span class="dt-chip dt-chip-fat">F: <?= number_format($item['fats'], 1); ?>g</span>
                  </div>
                  <button type="button" class="dt-btn-del" onclick="deleteDietItem(<?= $item['id']; ?>)" title="Remove item">
                    <i class="fa fa-trash-o fa-trash-alt"></i>
                  </button>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="dt-empty-meal">
              <p class="dt-empty-text">No items logged for <?= htmlspecialchars($catData['title']); ?> yet.</p>
              <button type="button" class="dt-btn-empty-add" onclick="openLogModal('<?= $catKey; ?>')">
                <i class="fa fa-plus"></i> Add Food to <?= htmlspecialchars($catData['title']); ?>
              </button>
            </div>
          <?php endif; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<!-- ====================================================================== -->
<!-- 5. REFINED POPUP MODAL: LOG FOOD INTAKE                                -->
<!-- ====================================================================== -->
<div class="modal fade dt-modal" id="dtAddFoodModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dtModalTitle">
          <i class="fa fa-plus-circle text-teal"></i> Log Food Intake
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="dtLogFoodForm" onsubmit="return submitDietLog(event);">
        <!-- CSRF Token -->
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" id="dtCsrfToken">

        <div class="modal-body" style="padding: 22px 24px;">
          <!-- 1. Meal Category Selector -->
          <div class="form-group mb-3">
            <label class="dt-form-label">Meal Time Category</label>
            <select name="meal_category" id="dtModalMealCat" class="form-control" style="border-radius: 10px; height: 44px; font-weight: 700;">
              <option value="breakfast">🌅 Breakfast (Morning)</option>
              <option value="brunch">🥪 Brunch (Late Morning)</option>
              <option value="lunch">🍲 Lunch (Midday Meal)</option>
              <option value="snacks">☕ Snacks (Evening Tea &amp; Bites)</option>
              <option value="dinner">🌙 Dinner (Night Meal)</option>
            </select>
          </div>

          <!-- 2. Autocomplete Food Search Bar -->
          <div class="form-group mb-3 dt-search-wrapper">
            <label class="dt-form-label">Search Food Item</label>
            <i class="fa fa-search dt-search-icon"></i>
            <input type="text" id="dtSearchFoodInput" class="dt-search-input" placeholder="Search food (e.g. Roti, Apple, Dal Tadka, Eggs)..." autocomplete="off" required>
            <!-- Dropdown Results -->
            <div id="dtSearchDropdown" class="dt-dropdown-results"></div>

            <!-- Quick Staple Tags -->
            <div class="dt-staple-tags">
              <span class="dt-staple-tag" onclick="quickFillFood('Roti')">Roti</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Brown Rice')">Brown Rice</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Boiled Egg')">Boiled Egg</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Dal Tadka')">Dal Tadka</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Apple')">Apple</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Paneer')">Paneer</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Oats')">Oats</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Curd')">Curd</span>
              <span class="dt-staple-tag" onclick="quickFillFood('Salad')">Salad</span>
            </div>
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

          <!-- 3. Quantity & Serving Unit Split-Row -->
          <div class="row mb-3">
            <div class="col-6">
              <label class="dt-form-label">Quantity</label>
              <input type="number" step="0.1" min="0.1" name="quantity" id="dtFieldQuantity" class="form-control" value="1" style="border-radius: 10px; height: 44px; font-weight: 800; font-size: 15px;" required oninput="recalcModalNutrition()">
            </div>
            <div class="col-6">
              <label class="dt-form-label">Serving Unit</label>
              <input type="text" name="serving_unit" id="dtFieldServingUnit" class="form-control" value="serving" style="border-radius: 10px; height: 44px; font-weight: 600;" placeholder="e.g. piece, bowl, g">
            </div>
          </div>

          <!-- 4. Live Macro Preview Box -->
          <div id="dtPreviewCard" class="dt-preview-card">
            <div class="dt-preview-header">
              <div>
                <span class="dt-preview-label">Portion Nutrition Preview</span>
                <strong id="dtPreviewName" class="dt-preview-name">Food Item</strong>
              </div>
              <span id="dtPreviewCal" class="dt-preview-cal-badge">0 kcal</span>
            </div>
            <div class="dt-preview-grid">
              <div class="dt-preview-cell pro">
                <small>Protein</small>
                <strong id="dtPrevPro">0g</strong>
              </div>
              <div class="dt-preview-cell carb">
                <small>Carbs</small>
                <strong id="dtPrevCarb">0g</strong>
              </div>
              <div class="dt-preview-cell fat">
                <small>Fats</small>
                <strong id="dtPrevFat">0g</strong>
              </div>
              <div class="dt-preview-cell fiber">
                <small>Fiber</small>
                <strong id="dtPrevFiber">0g</strong>
              </div>
            </div>
          </div>

          <!-- 5. Notes Input (Optional) -->
          <div class="form-group mb-0">
            <label class="dt-form-label">Notes (Optional)</label>
            <input type="text" name="notes" id="dtFieldNotes" class="form-control" placeholder="e.g. cooked with 1 tsp ghee, no sugar" style="border-radius: 10px; height: 42px;">
          </div>
        </div>

        <!-- 6. Modal Footer Action -->
        <div class="modal-footer" style="background: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 14px 24px;">
          <button type="button" class="btn btn-light" data-dismiss="modal" style="font-weight: 700; border-radius: 10px; padding: 9px 18px;">Cancel</button>
          <button type="button" id="dtSubmitBtn" onclick="submitDietLog(event)" class="btn btn-primary" style="background: var(--dt-teal); border-color: var(--dt-teal); font-weight: 800; border-radius: 10px; padding: 9px 24px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);">
            <i class="fa fa-check"></i> Log Food Item
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// ==========================================================================
// DIET TRACKER JAVASCRIPT CONTROLLER
// ==========================================================================
var dtCurrentBaseFood = null;
var dtSearchDebounce = null;
var dtActiveDate = "<?= htmlspecialchars($current_date); ?>";
window.dtSearchResults = [];

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
  $('#dtFieldNotes').val('');
  $('#dtFieldQuantity').val('1');
  dtCurrentBaseFood = null;
  $('#dtAddFoodModal').modal('show');
  setTimeout(function() { $('#dtSearchFoodInput').focus(); }, 400);
}

// Quick Staple Pill Click Handler
function quickFillFood(foodName) {
  $('#dtSearchFoodInput').val(foodName);
  searchFoodApi(foodName);
  $('#dtSearchFoodInput').focus();
}

// Autocomplete Food Search Input Listener
$('#dtSearchFoodInput').on('input focus', function() {
  var q = $(this).val().trim();
  clearTimeout(dtSearchDebounce);
  dtSearchDebounce = setTimeout(function() {
    searchFoodApi(q);
  }, 220);
});

// Click outside dropdown to hide
$(document).on('click', function(e) {
  if (!$(e.target).closest('.dt-search-wrapper').length) {
    $('#dtSearchDropdown').hide();
  }
});

// Food Search API Caller
function searchFoodApi(q) {
  var dropdown = $('#dtSearchDropdown');
  $.ajax({
    url: "<?= base_url('diet/search'); ?>",
    type: "GET",
    data: { q: q },
    dataType: "json",
    success: function(res) {
      if (res && res.status === 'success' && res.data && res.data.length > 0) {
        window.dtSearchResults = res.data;
        var html = '';
        res.data.forEach(function(item, idx) {
          var safeName = escapeHtml(item.name);
          var safeCat = escapeHtml(item.category || 'Standard');
          var safeUnit = escapeHtml(item.serving_unit || 'g');
          var cal = Math.round(item.calories);
          html += '<div class="dt-dropdown-item" data-index="' + idx + '">';
          html += '  <div class="dt-dropdown-info">';
          html += '    <strong>' + safeName + '</strong>';
          html += '    <small>' + safeCat + ' &bull; ' + parseFloat(item.serving_size) + ' ' + safeUnit + '</small>';
          html += '  </div>';
          html += '  <div class="dt-dropdown-cal">' + cal + ' kcal</div>';
          html += '</div>';
        });
        dropdown.html(html).show();
      } else {
        window.dtSearchResults = [];
        dropdown.html('<div style="padding:14px 18px; color:#94A3B8; font-size:13px;"><i class="fa fa-info-circle"></i> No exact food found. Enter custom details to log anyway.</div>').show();
        $('#dtFieldFoodId').val('');
        $('#dtFieldFoodName').val(q);
      }
    },
    error: function() {
      dropdown.hide();
    }
  });
}

// Select Item from Dropdown
$(document).on('click', '.dt-dropdown-item', function(e) {
  e.preventDefault();
  e.stopPropagation();
  var idx = $(this).data('index');
  if (window.dtSearchResults && window.dtSearchResults[idx] !== undefined) {
    selectFoodItem(window.dtSearchResults[idx]);
  }
});

function selectFoodItem(item) {
  if (!item) return;
  dtCurrentBaseFood = item;
  $('#dtSearchFoodInput').val(item.name);
  $('#dtSearchDropdown').hide();

  $('#dtFieldFoodId').val(item.id);
  $('#dtFieldFoodName').val(item.name);
  $('#dtFieldServingUnit').val(item.serving_unit || 'serving');
  $('#dtBaseServing').val(item.serving_size > 0 ? item.serving_size : 1);
  $('#dtFieldQuantity').val('1');

  recalcModalNutrition();
  $('#dtPreviewCard').show();
}

// Dynamic Portion Nutrition Recalculation
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

  var unit = $('#dtFieldServingUnit').val() || dtCurrentBaseFood.serving_unit || 'serving';
  $('#dtPreviewName').text(dtCurrentBaseFood.name + ' (' + qty + ' ' + unit + ')');
  $('#dtPreviewCal').text(cal + ' kcal');
  $('#dtPrevPro').text(pro + 'g');
  $('#dtPrevCarb').text(carb + 'g');
  $('#dtPrevFat').text(fat + 'g');
  $('#dtPrevFiber').text(fib + 'g');
}

// Submit Log Form Handler
function submitDietLog(e) {
  if (e && e.preventDefault) { e.preventDefault(); }
  if (e && e.stopPropagation) { e.stopPropagation(); }

  var btn = $('#dtSubmitBtn');
  var origHtml = btn.html();

  var foodName = $('#dtFieldFoodName').val().trim() || $('#dtSearchFoodInput').val().trim();
  if (!foodName) {
    showDietToast('Please search and select a food item or enter a food name.', 'error');
    $('#dtSearchFoodInput').focus();
    return false;
  }
  $('#dtFieldFoodName').val(foodName);

  var qty = parseFloat($('#dtFieldQuantity').val());
  if (isNaN(qty) || qty <= 0) {
    showDietToast('Please enter a valid quantity greater than 0.', 'error');
    $('#dtFieldQuantity').focus();
    return false;
  }

  if (!$('#dtModalLogDate').val()) {
    $('#dtModalLogDate').val(dtActiveDate);
  }

  recalcModalNutrition();
  btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

  var formData = $('#dtLogFoodForm').serialize();

  $.ajax({
    url: "<?= base_url('diet/add_log'); ?>",
    type: "POST",
    data: formData,
    dataType: "json",
    success: function(res) {
      btn.html(origHtml).prop('disabled', false);
      if (res && res.status === 'success') {
        $('#dtAddFoodModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        if (res.summary) {
          applyDietSummary(res.summary);
        }

        showDietToast(res.message || 'Food item logged successfully!', 'success');

        // Reset fields
        $('#dtSearchFoodInput').val('');
        $('#dtFieldFoodId').val('');
        $('#dtFieldFoodName').val('');
        $('#dtFieldNotes').val('');
        $('#dtPreviewCard').hide();
        dtCurrentBaseFood = null;
      } else {
        var msg = res && res.message ? res.message : 'Failed to save food log.';
        showDietToast(msg, 'error');
      }
    },
    error: function(xhr) {
      btn.html(origHtml).prop('disabled', false);
      var msg = 'Network error while saving meal. Please try again.';
      if (xhr.status === 401) {
        msg = 'Your session has expired. Please login again to track diet.';
      } else if (xhr.responseJSON && xhr.responseJSON.message) {
        msg = xhr.responseJSON.message;
      }
      showDietToast(msg, 'error');
    }
  });

  return false;
}

// Delete Log Item Handler
function deleteDietItem(logId) {
  if (!confirm('Are you sure you want to remove this logged food item?')) return;
  
  var postData = {
    log_id: logId,
    log_date: dtActiveDate,
    "<?= $this->security->get_csrf_token_name(); ?>": "<?= $this->security->get_csrf_hash(); ?>"
  };

  $.ajax({
    url: "<?= base_url('diet/delete_log'); ?>",
    type: "POST",
    data: postData,
    dataType: "json",
    success: function(res) {
      if (res && res.status === 'success') {
        $('#dtItem_' + logId).fadeOut(200, function() { $(this).remove(); });
        if (res.summary) {
          applyDietSummary(res.summary);
        }
        showDietToast(res.message || 'Food item removed.', 'success');
      } else {
        showDietToast(res ? res.message : 'Could not remove item.', 'error');
      }
    },
    error: function() {
      showDietToast('Network error while deleting item.', 'error');
    }
  });
}

// Escape HTML Helper
function escapeHtml(text) {
  if (!text) return '';
  var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
  return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Toast Feedback Notification Helper
function showDietToast(msg, type) {
  var toastId = 'dtToastNotification';
  $('#' + toastId).remove();
  var bg = (type === 'success') ? '#10B981' : '#EF4444';
  var icon = (type === 'success') ? 'fa-check-circle' : 'fa-exclamation-circle';
  var html = '<div id="' + toastId + '" class="dt-toast" style="background:' + bg + ';">' +
             '<i class="fa ' + icon + '"></i> ' + escapeHtml(msg) +
             '</div>';
  $('body').append(html);
  setTimeout(function() {
    $('#' + toastId).fadeOut(400, function() { $(this).remove(); });
  }, 3500);
}

// Update UI with summary payload
function applyDietSummary(s) {
  if (!s) return;
  dtActiveDate = s.date;
  $('#dtDatePicker').val(s.date);
  $('#dtModalLogDate').val(s.date);

  // 1. Calories Hero Bar
  if (s.consumed && s.percentages && s.remaining) {
    $('#dtCalConsumed').text(Math.round(s.consumed.calories).toLocaleString());
    $('#dtCalBar').css('width', Math.min(100, Math.max(0, s.percentages.calories)) + '%');
    $('#dtCalPct').text(s.percentages.calories + '%');
    $('#dtCalRem').text(Math.round(s.remaining.calories).toLocaleString() + ' kcal');

    // 2. Core Macros
    // Protein
    $('#dtProConsumed').text(parseFloat(s.consumed.protein).toFixed(1) + 'g');
    $('#dtProBar').css('width', Math.min(100, Math.max(0, s.percentages.protein)) + '%');
    $('#dtProPct').text(s.percentages.protein + '%');
    $('#dtProRem').text(parseFloat(s.remaining.protein).toFixed(1) + 'g left');

    // Carbs
    $('#dtCarbConsumed').text(parseFloat(s.consumed.carbs).toFixed(1) + 'g');
    $('#dtCarbBar').css('width', Math.min(100, Math.max(0, s.percentages.carbs)) + '%');
    $('#dtCarbPct').text(s.percentages.carbs + '%');
    $('#dtCarbRem').text(parseFloat(s.remaining.carbs).toFixed(1) + 'g left');

    // Fats
    $('#dtFatConsumed').text(parseFloat(s.consumed.fats).toFixed(1) + 'g');
    $('#dtFatBar').css('width', Math.min(100, Math.max(0, s.percentages.fats)) + '%');
    $('#dtFatPct').text(s.percentages.fats + '%');
    $('#dtFatRem').text(parseFloat(s.remaining.fats).toFixed(1) + 'g left');

    // Fiber
    $('#dtFiberConsumed').text(parseFloat(s.consumed.fiber).toFixed(1) + 'g');
    $('#dtFiberBar').css('width', Math.min(100, Math.max(0, s.percentages.fiber)) + '%');
    $('#dtFiberPct').text(s.percentages.fiber + '%');
    $('#dtFiberRem').text(parseFloat(s.remaining.fiber).toFixed(1) + 'g left');

    // 3. Micronutrients
    $('#dtIronVal').text(parseFloat(s.consumed.iron).toFixed(2) + ' mg');
    $('#dtIronPct').text(s.percentages.iron + '%')
      .attr('class', 'dt-micro-badge ' + (s.percentages.iron >= 100 ? 'achieved' : ''));

    $('#dtCalcVal').text(parseFloat(s.consumed.calcium).toFixed(1) + ' mg');
    $('#dtCalcPct').text(s.percentages.calcium + '%')
      .attr('class', 'dt-micro-badge ' + (s.percentages.calcium >= 100 ? 'achieved' : ''));

    $('#dtVitCVal').text(parseFloat(s.consumed.vitamin_c).toFixed(1) + ' mg');
    $('#dtVitCPct').text(s.percentages.vitamin_c + '%')
      .attr('class', 'dt-micro-badge ' + (s.percentages.vitamin_c >= 100 ? 'achieved' : ''));

    // Profile header badge counter if present
    if ($('#dietLoggedItemsCount').length) {
      $('#dietLoggedItemsCount').text(s.consumed.total_items || 0);
    }
  }

  // 4. Meal Section Cards
  if (s.meal_categories) {
    Object.keys(s.meal_categories).forEach(function(catKey) {
      var cat = s.meal_categories[catKey];
      var count = cat.count !== undefined ? cat.count : (cat.items ? cat.items.length : 0);
      var subCal = cat.subtotal && cat.subtotal.calories !== undefined ? cat.subtotal.calories : 0;

      $('#dtCount_' + catKey).text(count + ' items');
      $('#dtBadgeCal_' + catKey).html('<i class="fa fa-fire"></i> ' + Math.round(subCal).toLocaleString() + ' kcal');

      var list = $('#dtFoodList_' + catKey);
      if (cat.items && cat.items.length > 0) {
        var itemsHtml = '';
        cat.items.forEach(function(item) {
          itemsHtml += '<li class="dt-food-row" id="dtItem_' + item.id + '">';
          itemsHtml += '  <div class="dt-food-row-main">';
          itemsHtml += '    <span class="dt-food-name">' + escapeHtml(item.food_name) + '</span>';
          if (item.notes) {
            itemsHtml += '    <span class="dt-food-notes">' + escapeHtml(item.notes) + '</span>';
          }
          itemsHtml += '  </div>';
          itemsHtml += '  <div class="dt-food-row-meta">';
          itemsHtml += '    <span class="dt-pill-qty">' + parseFloat(item.quantity) + ' ' + escapeHtml(item.serving_unit) + '</span>';
          itemsHtml += '    <span class="dt-pill-cal">' + Math.round(item.calories).toLocaleString() + ' kcal</span>';
          itemsHtml += '    <div class="dt-macro-chips">';
          itemsHtml += '      <span class="dt-chip dt-chip-pro">P: ' + parseFloat(item.protein).toFixed(1) + 'g</span>';
          itemsHtml += '      <span class="dt-chip dt-chip-carb">C: ' + parseFloat(item.carbs).toFixed(1) + 'g</span>';
          itemsHtml += '      <span class="dt-chip dt-chip-fat">F: ' + parseFloat(item.fats).toFixed(1) + 'g</span>';
          itemsHtml += '    </div>';
          itemsHtml += '    <button type="button" class="dt-btn-del" onclick="deleteDietItem(' + item.id + ')" title="Remove item"><i class="fa fa-trash-o fa-trash-alt"></i></button>';
          itemsHtml += '  </div>';
          itemsHtml += '</li>';
        });
        list.html(itemsHtml);
      } else {
        list.html('<div class="dt-empty-meal"><p class="dt-empty-text">No items logged for ' + escapeHtml(cat.title) + ' yet.</p><button type="button" class="dt-btn-empty-add" onclick="openLogModal(\'' + catKey + '\')"><i class="fa fa-plus"></i> Add Food to ' + escapeHtml(cat.title) + '</button></div>');
      }
    });
  }
}

// Date Summary Loader
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

// Attach Event Listeners on DOM Ready
$(document).ready(function() {
  $('#dtLogFoodForm').off('submit').on('submit', function(e) {
    e.preventDefault();
    return submitDietLog(e);
  });

  $('#dtSubmitBtn').off('click').on('click', function(e) {
    e.preventDefault();
    return submitDietLog(e);
  });

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
});
</script>
