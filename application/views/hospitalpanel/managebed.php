<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.bed-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.bed-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.bed-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.bed-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-bed {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-add-bed:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

/* KPI Summary Cards */
.kpi-bed-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.kpi-bed-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.kpi-bed-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.kpi-bed-value {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.kpi-bed-sub {
    font-size: 11.5px;
    color: #94a3b8;
    margin: 0;
}

/* Filter Card */
.bed-filter-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 16px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.filter-grid-bed {
    display: grid;
    grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr auto;
    gap: 12px;
    align-items: flex-end;
}

@media (max-width: 900px) {
    .filter-grid-bed {
        grid-template-columns: 1fr;
    }
}

.bed-form-ctrl {
    width: 100%;
    height: 40px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
}

.bed-form-ctrl:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-bed-search {
    background: #043d5b;
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.btn-bed-search:hover {
    background: #022b40;
}

/* Table Card */
.bed-table-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-custom-clean {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom-clean thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-custom-clean tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.table-custom-clean tbody tr:hover td {
    background: #f8fafc;
}

.badge-active {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
}

.badge-inactive {
    background: #fee2e2;
    color: #991b1b;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
}

.action-btn-group {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
}

.btn-act-edit {
    background: #e0f2fe;
    color: #0369a1 !important;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s;
}

.btn-act-edit:hover {
    background: #bae6fd;
}

.btn-act-del {
    background: #fee2e2;
    color: #dc2626 !important;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s;
}

.btn-act-del:hover {
    background: #fecaca;
}

/* Occupancy Progress Bar */
.occupancy-meter {
    width: 100%;
    height: 6px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
    margin-top: 4px;
}

.occupancy-fill {
    height: 100%;
    border-radius: 4px;
    background: #00a896;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="bed-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="bed-header-card">
            <div>
                <h1><i class="fa fa-bed" style="color: #00a896; margin-right: 8px;"></i> Hospital Bed &amp; Ward Configuration</h1>
                <p>Configure hospital bed categories, room charges, total capacity, and live inpatient occupancy rates.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/addbed');?>" class="btn-add-bed">
                    <i class="fa fa-plus-circle"></i> Add Bed / Ward Setup
                </a>
            </div>
        </div>

        <!-- KPI Summary Cards -->
        <div class="kpi-bed-grid">
            <div class="kpi-bed-card" style="border-left: 4px solid #043d5b;">
                <div class="kpi-bed-title">Total Bed Capacity</div>
                <div class="kpi-bed-value" style="color: #043d5b;"><?=$total_capacity;?> Beds</div>
                <p class="kpi-bed-sub">Overall hospital inpatient capacity</p>
            </div>

            <div class="kpi-bed-card" style="border-left: 4px solid #ef4444;">
                <div class="kpi-bed-title">Occupied Beds</div>
                <div class="kpi-bed-value" style="color: #ef4444;"><?=$total_occupied;?> Beds</div>
                <p class="kpi-bed-sub">Currently admitted inpatients</p>
            </div>

            <div class="kpi-bed-card" style="border-left: 4px solid #10b981;">
                <div class="kpi-bed-title">Available / Vacant</div>
                <div class="kpi-bed-value" style="color: #10b981;"><?=$total_available;?> Beds</div>
                <p class="kpi-bed-sub">Ready for immediate admission</p>
            </div>

            <div class="kpi-bed-card" style="border-left: 4px solid #00a896;">
                <div class="kpi-bed-title">Ward Categories</div>
                <div class="kpi-bed-value" style="color: #00a896;"><?=$total_types;?></div>
                <p class="kpi-bed-sub">Configured room &amp; ICU tiers</p>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bed-filter-card">
            <form method="GET" action="<?=base_url('hospitalpanel/bed');?>">
                <div class="filter-grid-bed">
                    <div>
                        <input type="text" name="keyword" class="bed-form-ctrl" placeholder="Search by bed / ward type (e.g. ICU, General)..." value="<?=html_escape($this->input->get('keyword'));?>">
                    </div>
                    <div>
                        <input type="date" name="date_from" class="bed-form-ctrl" value="<?=html_escape($this->input->get('date_from'));?>" placeholder="Date From">
                    </div>
                    <div>
                        <input type="date" name="date_to" class="bed-form-ctrl" value="<?=html_escape($this->input->get('date_to'));?>" placeholder="Date To">
                    </div>
                    <div>
                        <select name="status" class="bed-form-ctrl">
                            <option value="">-- All Statuses --</option>
                            <option value="1" <?=$this->input->get('status')==='1' ? 'selected' : '';?>>Active</option>
                            <option value="0" <?=$this->input->get('status')==='0' ? 'selected' : '';?>>Inactive</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button type="submit" class="btn-bed-search">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <?php if($this->input->get('keyword') || $this->input->get('date_from') || $this->input->get('status') !== null): ?>
                            <a href="<?=base_url('hospitalpanel/bed');?>" class="btn btn-default" style="height: 40px; display: inline-flex; align-items: center;" title="Clear Filters">
                                <i class="fa fa-refresh"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Beds Table -->
        <div class="bed-table-card">
            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th>Ward / Bed Category</th>
                            <th>Daily Room Charge</th>
                            <th>Total Capacity</th>
                            <th>Occupied</th>
                            <th>Available Vacant</th>
                            <th>Occupancy Rate</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($beds)): ?>
                            <?php foreach($beds as $val): ?>
                                <?php 
                                $tot = (int)$val->total_bed;
                                $occ = (int)$val->occupied_bed;
                                $avail = max(0, $tot - $occ);
                                $pct = ($tot > 0) ? min(100, round(($occ / $tot) * 100)) : 0;
                                ?>
                                <tr>
                                    <!-- Bed Type -->
                                    <td>
                                        <div style="font-weight: 800; color: #043d5b; font-size: 14px;">
                                            <i class="fa fa-bed" style="color: #00a896; margin-right: 4px;"></i> <?=html_escape($val->bed_type);?>
                                        </div>
                                        <?php if(!empty($val->comment)): ?>
                                            <span style="font-size: 11.5px; color: #64748b;"><?=html_escape($val->comment);?></span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Daily Amount -->
                                    <td>
                                        <div style="font-weight: 800; color: #00a896; font-size: 14px;">
                                            ₹<?=number_format((float)$val->amount, 2);?>
                                            <span style="font-size: 11px; font-weight: normal; color: #64748b;">/ day</span>
                                        </div>
                                    </td>

                                    <!-- Total Beds -->
                                    <td style="font-weight: 700; color: #0f172a;">
                                        <?=$tot;?> Beds
                                    </td>

                                    <!-- Occupied -->
                                    <td>
                                        <span style="background: #fee2e2; color: #991b1b; font-weight: 700; font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                            <?=$occ;?> Occupied
                                        </span>
                                    </td>

                                    <!-- Available Vacant -->
                                    <td>
                                        <span style="background: #dcfce7; color: #15803d; font-weight: 700; font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                            <?=$avail;?> Vacant
                                        </span>
                                    </td>

                                    <!-- Progress / Rate -->
                                    <td style="min-width: 130px;">
                                        <div style="font-size: 11.5px; font-weight: 700; color: #475569;">
                                            <?=$pct;?>% Occupied
                                        </div>
                                        <div class="occupancy-meter">
                                            <div class="occupancy-fill" style="width: <?=$pct;?>%; background: <?=$pct > 80 ? '#ef4444' : ($pct > 50 ? '#f59e0b' : '#00a896');?>;"></div>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <?php if($val->status == '1'): ?>
                                            <span class="badge-active"><i class="fa fa-check"></i> Active</span>
                                        <?php else: ?>
                                            <span class="badge-inactive"><i class="fa fa-times"></i> Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Actions -->
                                    <td style="text-align: right;">
                                        <div class="action-btn-group">
                                            <a href="<?=base_url('hospitalpanel/editbed/'.$val->hospital_bed_id);?>" class="btn-act-edit">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="<?=base_url('hospitalpanel/delete_bed/'.$val->hospital_bed_id);?>" onclick="return confirm('Are you sure you want to delete this bed setup category?');" class="btn-act-del">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-bed" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Bed Categories Configured</strong>
                                    <span>Click <strong>Add Bed / Ward Setup</strong> to configure hospital wards and room charges.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
