<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.hosp-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.hosp-kpi-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 16px 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease;
}

.hosp-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
}

/* Compact Optimized Card */
.hosp-compact-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.hosp-compact-card:hover {
    transform: translateY(-2px);
    border-color: var(--upchar-teal);
    box-shadow: 0 8px 20px rgba(0, 168, 150, 0.12);
}

.hosp-mini-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #f0fdfa;
    color: var(--upchar-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    transition: transform 0.2s ease;
}

.hosp-mini-icon:hover {
    transform: scale(1.08);
}

.hosp-title-text {
    font-size: 13.5px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.2s ease;
}

.hosp-title-text:hover {
    color: var(--upchar-teal);
}

.hosp-address-text {
    font-size: 11.5px;
    color: #64748b;
    margin: 0 0 6px 0;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 31px;
}

.btn-affiliate-compact {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 11.5px;
    border-radius: 6px;
    padding: 6px 12px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    width: 100%;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none !important;
}

.btn-affiliate-compact:hover {
    background: var(--upchar-teal-dark);
}

.btn-pending-compact {
    background: #fffbeb !important;
    color: #b45309 !important;
    border: 1px solid #fde68a !important;
    font-weight: 700;
    font-size: 11.5px;
    border-radius: 6px;
    padding: 6px 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    cursor: default;
}

.badge-affiliated-pill {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 10.5px;
    padding: 3px 8px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.badge-pending-pill {
    background: #fef3c7;
    color: #92400e;
    font-weight: 700;
    font-size: 10.5px;
    padding: 3px 8px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.badge-rejected-pill {
    background: #fee2e2;
    color: #b91c1c;
    font-weight: 700;
    font-size: 10.5px;
    padding: 3px 8px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

/* Pagination Styles */
.pagination-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 16px;
    margin-top: 10px;
    border-top: 1px solid var(--upchar-border);
}

.page-link-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border-radius: 6px;
    border: 1px solid var(--upchar-border);
    background: #ffffff;
    color: #334155;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.15s ease;
}

.page-link-pill:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
    color: var(--upchar-teal);
}

.page-link-pill.active {
    background: var(--upchar-teal);
    border-color: var(--upchar-teal);
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25);
}

.page-link-pill.disabled {
    opacity: 0.4;
    pointer-events: none;
}

/* CRITICAL FIX: Prevent Black Screen Overlay Caused By Stacking Context & Backdrop */
.modal {
    z-index: 1060 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
    background-color: #000000 !important;
}

.modal-backdrop.in {
    opacity: 0.55 !important;
}

body.modal-open {
    overflow: hidden !important;
}

/* Responsive Media Queries */
@media screen and (max-width: 768px) {
    .hosp-container {
        padding: 14px 12px;
    }
    .hosp-compact-card {
        padding: 12px;
    }
    .hosp-kpi-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .pagination-wrap {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
}
</style>

<!-- Top Toast Alert Container -->
<div id="affiliation_toast_alert" style="display: none; position: fixed; top: 76px; right: 24px; z-index: 99999; min-width: 320px; max-width: 460px; box-shadow: 0 10px 30px rgba(0,0,0,0.18); border-radius: 10px; padding: 14px 18px; transition: all 0.3s ease;"></div>

<div class="pag_cstm hosp-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h2 style="font-size: 21px; font-weight: 800; color: #0f172a; margin: 0 0 3px 0;">
                        <i class="fa fa-hospital-o text-aqua" style="margin-right: 6px;"></i> Affiliated Hospitals &amp; Partner Network
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">
                        Browse certified healthcare institutions on the Upchar network, link your visiting consultant practice, and configure hospital OPD slots.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('managepractice');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-medkit"></i> Manage All Practices
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- 3-Grid KPI Row -->
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="hosp-kpi-card" style="border-left: 4px solid #10b981;">
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Active Affiliations</div>
                            <div id="kpi_active_count" style="font-size: 24px; font-weight: 800; color: #059669; margin: 2px 0;"><?=count($affiliated_hospitals);?></div>
                            <div style="font-size: 11px; color: #94a3b8;">Verified visiting chambers</div>
                        </div>
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="hosp-kpi-card" style="border-left: 4px solid #f59e0b;">
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Pending Verification</div>
                            <div id="kpi_pending_count" style="font-size: 24px; font-weight: 800; color: #d97706; margin: 2px 0;"><?=isset($pending_count) ? $pending_count : 0;?></div>
                            <div style="font-size: 11px; color: #94a3b8;">Awaiting hospital approval</div>
                        </div>
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="hosp-kpi-card" style="border-left: 4px solid #00a896;">
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Network Partner Hospitals</div>
                            <div style="font-size: 24px; font-weight: 800; color: #00a896; margin: 2px 0;"><?=$total_hospitals;?></div>
                            <div style="font-size: 11px; color: #94a3b8;">In <?=count($cities);?> cities across network</div>
                        </div>
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 1: My Affiliated Hospitals (if any) -->
            <?php if(!empty($affiliated_hospitals)): ?>
            <div id="section_active_affiliations" style="margin-bottom: 24px;">
                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                    <i class="fa fa-check-circle text-green" style="margin-right: 6px;"></i> My Active Hospital Affiliations (<?=count($affiliated_hospitals);?>)
                </h3>

                <div class="row" id="active_affiliations_container">
                    <?php foreach($affiliated_hospitals as $ah): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 active-affil-card-<?=$ah->id;?>" style="margin-bottom: 16px;">
                        <div class="hosp-compact-card" style="border-color: #a7f3d0; background: #f0fdf4;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <div class="hosp-mini-icon view-hospital-profile-btn" data-id="<?=$ah->id;?>" style="background: #dcfce7; color: #059669; cursor: pointer;" title="View Hospital Details">
                                        <i class="fa fa-hospital-o"></i>
                                    </div>
                                    <span class="badge-affiliated-pill">
                                        <i class="fa fa-check"></i> Linked
                                    </span>
                                </div>
                                <h4 class="hosp-title-text view-hospital-profile-btn" data-id="<?=$ah->id;?>" style="cursor: pointer;" title="View details: <?=htmlspecialchars($ah->name);?>">
                                    <?=htmlspecialchars($ah->name);?>
                                </h4>
                                <div class="hosp-address-text" title="<?=htmlspecialchars($ah->address ?: 'Address on file');?>">
                                    <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($ah->address ?: 'Address on file');?>
                                </div>
                                <div style="font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                                    Fee: <span style="color: #00a896;">₹<?=number_format($ah->practice_fee, 2);?></span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 4px; border-top: 1px solid #d1fae5; padding-top: 8px;">
                                <a href="<?=base_url('doctorpanel/datetime');?>" class="btn btn-xs btn-default" style="flex: 1; font-weight: 600; font-size: 11px; border-radius: 4px; padding: 4px;" title="Configure OPD Timings">
                                    <i class="fa fa-clock-o"></i> Timings
                                </a>
                                <a href="<?=base_url('managepractice');?>" class="btn btn-xs btn-default" style="flex: 1; font-weight: 600; font-size: 11px; border-radius: 4px; padding: 4px;" title="Edit Consultation Fee">
                                    <i class="fa fa-pencil"></i> Fee
                                </a>
                                <button type="button" class="btn btn-xs btn-default cancel-affiliate-btn" data-id="<?=$ah->id;?>" data-name="<?=htmlspecialchars($ah->name, ENT_QUOTES, 'UTF-8');?>" data-action="unlink" title="Unlink Hospital" style="color: #dc2626; border-color: #fecaca; background: #fff5f5; font-size: 11px; font-weight: 700; border-radius: 4px; padding: 4px 8px;">
                                    <i class="fa fa-chain-broken"></i> Unlink
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- SECTION 2: Network Partner Hospitals Directory with Pagination -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                
                <!-- Filter Bar -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 18px; gap: 12px;">
                    <div>
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            <i class="fa fa-building text-aqua" style="margin-right: 6px;"></i> Partner Hospitals Directory
                        </h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">
                            Showing <?=$total_hospitals ? (($current_page - 1) * $per_page + 1) : 0;?> - <?=min($current_page * $per_page, $total_hospitals);?> of <?=$total_hospitals;?> hospitals
                        </p>
                    </div>

                    <form action="<?=base_url('doctorpanel/upcharhospital');?>" method="get" class="form-inline" style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <select name="city" class="form-control input-sm" style="border-radius: 6px; font-size: 12.5px; height: 34px;">
                            <option value="">-- All Cities --</option>
                            <?php foreach($cities as $c): ?>
                            <option value="<?=$c->id;?>" <?=$selected_city==$c->id?'selected':'';?>><?=htmlspecialchars($c->name);?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="text" name="q" class="form-control input-sm" placeholder="Search Hospital Name..." value="<?=htmlspecialchars(@$search_query);?>" style="border-radius: 6px; width: 170px; font-size: 12.5px; height: 34px;">

                        <button type="submit" class="btn btn-sm btn-primary" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700; border-radius: 6px; height: 34px; padding: 0 14px;">
                            <i class="fa fa-search"></i> Filter
                        </button>

                        <?php if(!empty($selected_city) || !empty($search_query)): ?>
                        <a href="<?=base_url('doctorpanel/upcharhospital');?>" class="btn btn-sm btn-default" style="border-radius: 6px; height: 34px; display: inline-flex; align-items: center;">
                            <i class="fa fa-times"></i> Reset
                        </a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Hospital Compact 4-Column Grid -->
                <div class="row">
                    <?php if(!empty($partner_hospitals)): ?>
                        <?php foreach($partner_hospitals as $hosp): 
                            $affil_status = isset($affiliation_status_map[$hosp->id]) ? $affiliation_status_map[$hosp->id] : (in_array($hosp->id, $affiliated_ids) ? 'verified' : 'none');
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 hosp-card-wrapper hosp-card-<?=$hosp->id;?>" style="margin-bottom: 16px;">
                            <div class="hosp-compact-card">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <div class="hosp-mini-icon view-hospital-profile-btn" data-id="<?=$hosp->id;?>" style="cursor: pointer;" title="View Hospital Details">
                                            <i class="fa fa-hospital-o"></i>
                                        </div>
                                        <div class="badge-status-container">
                                            <?php if($affil_status === 'verified'): ?>
                                                <span class="badge-affiliated-pill"><i class="fa fa-check"></i> Linked</span>
                                            <?php elseif($affil_status === 'pending'): ?>
                                                <span class="badge-pending-pill"><i class="fa fa-clock-o"></i> Pending</span>
                                            <?php elseif($affil_status === 'rejected'): ?>
                                                <span class="badge-rejected-pill"><i class="fa fa-times"></i> Rejected</span>
                                            <?php else: ?>
                                                <span style="background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Partner</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <h4 class="hosp-title-text view-hospital-profile-btn" data-id="<?=$hosp->id;?>" style="cursor: pointer;" title="Click to view full details: <?=htmlspecialchars($hosp->name);?>">
                                        <?=htmlspecialchars($hosp->name);?>
                                    </h4>
                                    <div class="hosp-address-text" title="<?=htmlspecialchars($hosp->address ?: 'Address on file');?>">
                                        <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($hosp->address ?: 'Address on file');?>
                                    </div>
                                    
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <?php if(!empty($hosp->mobile)): ?>
                                            <span style="font-size: 11px; color: #64748b;">
                                                <i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($hosp->mobile);?>
                                            </span>
                                        <?php else: ?>
                                            <span></span>
                                        <?php endif; ?>
                                        
                                        <a href="javascript:void(0);" class="view-hospital-profile-btn" data-id="<?=$hosp->id;?>" style="font-size: 11px; font-weight: 700; color: var(--upchar-teal); text-decoration: none;">
                                            <i class="fa fa-info-circle"></i> Details
                                        </a>
                                    </div>
                                </div>

                                <div class="action-btn-container" style="border-top: 1px solid #f1f5f9; padding-top: 8px; margin-top: 4px;">
                                    <?php if($affil_status === 'verified'): ?>
                                        <div style="display: flex; gap: 6px;">
                                            <a href="<?=base_url('doctorpanel/datetime');?>" class="btn btn-xs btn-default" style="flex: 1; font-weight: 700; color: #00a896; border-color: #ccfbf1; background: #f0fdfa; border-radius: 6px; padding: 6px;" title="Manage Schedule">
                                                <i class="fa fa-clock-o"></i> Timings
                                            </a>
                                            <button type="button" class="btn btn-xs btn-default cancel-affiliate-btn" data-id="<?=$hosp->id;?>" data-name="<?=htmlspecialchars($hosp->name, ENT_QUOTES, 'UTF-8');?>" data-action="unlink" title="Unlink Hospital" style="color: #dc2626; border-color: #fecaca; background: #fff5f5; border-radius: 6px; padding: 6px 8px; font-weight: 700;">
                                                <i class="fa fa-chain-broken"></i> Unlink
                                            </button>
                                        </div>
                                    <?php elseif($affil_status === 'pending'): ?>
                                        <div style="display: flex; gap: 6px; align-items: center;">
                                            <button type="button" class="btn-pending-compact" style="flex: 1; cursor: default;" disabled>
                                                <i class="fa fa-clock-o"></i> Pending
                                            </button>
                                            <button type="button" class="btn btn-xs btn-default cancel-affiliate-btn" data-id="<?=$hosp->id;?>" data-name="<?=htmlspecialchars($hosp->name, ENT_QUOTES, 'UTF-8');?>" data-action="cancel" title="Cancel Affiliation Request" style="color: #dc2626; border-color: #fca5a5; background: #fef2f2; border-radius: 6px; padding: 6px 10px; font-weight: 700; font-size: 11px;">
                                                <i class="fa fa-times-circle"></i> Cancel
                                            </button>
                                        </div>
                                    <?php elseif($affil_status === 'rejected'): ?>
                                        <button type="button" class="btn-affiliate-compact open-affiliate-modal-btn" data-id="<?=$hosp->id;?>" data-name="<?=htmlspecialchars($hosp->name, ENT_QUOTES, 'UTF-8');?>" style="background: #f59e0b;">
                                            <i class="fa fa-refresh"></i> Re-apply Affiliation
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn-affiliate-compact open-affiliate-modal-btn" data-id="<?=$hosp->id;?>" data-name="<?=htmlspecialchars($hosp->name, ENT_QUOTES, 'UTF-8');?>">
                                            <i class="fa fa-plus-circle"></i> Affiliate / Link
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="fa fa-hospital-o" style="font-size: 36px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                            No partner hospitals found matching your search criteria.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Numbered Pagination Bar -->
                <?php if($total_pages > 1): ?>
                <?php 
                $query_params = array();
                if(!empty($selected_city)) $query_params['city'] = $selected_city;
                if(!empty($search_query)) $query_params['q'] = $search_query;
                
                function make_page_url($p, $params) {
                    $params['page'] = $p;
                    return base_url('doctorpanel/upcharhospital') . '?' . http_build_query($params);
                }
                ?>
                <div class="pagination-wrap">
                    <div style="font-size: 12.5px; color: #64748b;">
                        Page <strong><?=$current_page;?></strong> of <strong><?=$total_pages;?></strong> (Total <?=$total_hospitals;?> Hospitals)
                    </div>

                    <div style="display: flex; gap: 4px; align-items: center;">
                        <!-- Prev Button -->
                        <a href="<?=make_page_url(max(1, $current_page - 1), $query_params);?>" class="page-link-pill <?=$current_page<=1?'disabled':'';?>">
                            <i class="fa fa-angle-left"></i> Prev
                        </a>

                        <!-- Page Numbers -->
                        <?php 
                        $start_p = max(1, $current_page - 2);
                        $end_p = min($total_pages, $current_page + 2);
                        if ($start_p > 1) {
                            echo '<a href="'.make_page_url(1, $query_params).'" class="page-link-pill">1</a>';
                            if ($start_p > 2) echo '<span style="color: #94a3b8; padding: 0 4px;">...</span>';
                        }
                        for ($p = $start_p; $p <= $end_p; $p++) {
                            $active = ($p == $current_page) ? 'active' : '';
                            echo '<a href="'.make_page_url($p, $query_params).'" class="page-link-pill '.$active.'">'.$p.'</a>';
                        }
                        if ($end_p < $total_pages) {
                            if ($end_p < $total_pages - 1) echo '<span style="color: #94a3b8; padding: 0 4px;">...</span>';
                            echo '<a href="'.make_page_url($total_pages, $query_params).'" class="page-link-pill">'.$total_pages.'</a>';
                        }
                        ?>

                        <!-- Next Button -->
                        <a href="<?=make_page_url(min($total_pages, $current_page + 1), $query_params);?>" class="page-link-pill <?=$current_page>=$total_pages?'disabled':'';?>">
                            Next <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<!-- Quick Affiliation Modal (AJAX Driven) -->
<div class="modal fade" id="affiliateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-size: 15px; font-weight: 800;"><i class="fa fa-handshake-o"></i> Link Visiting Hospital</h4>
            </div>
            <form id="affiliateForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf_token_input" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="affiliate_hospital" value="1">
                <input type="hidden" name="hospital_id" id="modal_hospital_id">

                <div class="modal-body" style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Selected Hospital:</span>
                        <div id="modal_hospital_name" style="font-weight: 800; color: #0f172a; font-size: 14px; margin-top: 2px;"></div>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">OPD Consultation Fee (₹) *</label>
                        <div class="input-group">
                            <span class="input-group-addon" style="font-weight: 700; background: #f8fafc;">₹</span>
                            <input type="number" name="fee" id="modal_fee_input" class="form-control" value="500" min="0" step="50" required autofocus>
                        </div>
                        <span style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Your standard consultation fee at this hospital chamber.</span>
                    </div>

                    <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; border: 1px dashed #cbd5e1; font-size: 11.5px; color: #475569;">
                        <i class="fa fa-info-circle text-info"></i> Affiliation status will become <strong>Pending Verification</strong> until approved by the hospital admin.
                    </div>
                </div>

                <div class="modal-footer" style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600;">Close</button>
                    <button type="submit" id="btnSubmitAffiliate" class="btn btn-primary btn-sm" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700;">
                        <i class="fa fa-paper-plane"></i> Send Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Affiliation / Unlink Confirmation Modal -->
<div class="modal fade" id="cancelAffiliationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.25);">
            <div class="modal-header" id="cancelModalHeader" style="background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%); color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelModalTitle" style="font-size: 15px; font-weight: 800;">
                    <i class="fa fa-exclamation-triangle"></i> Cancel Affiliation
                </h4>
            </div>
            <form id="cancelAffiliateForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf_token_input" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="hospital_id" id="cancel_modal_hospital_id">
                <input type="hidden" name="cancel_action" id="cancel_modal_action" value="cancel">

                <div class="modal-body" style="padding: 20px;">
                    <div style="margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Hospital:</span>
                        <div id="cancel_modal_hospital_name" style="font-weight: 800; color: #0f172a; font-size: 14px; margin-top: 2px;"></div>
                    </div>
                    
                    <p id="cancelModalMessage" style="font-size: 13px; color: #475569; line-height: 1.45; margin: 0 0 14px 0;">
                        Are you sure you want to cancel your pending affiliation request with this hospital?
                    </p>

                    <div style="background: #fef2f2; border-radius: 8px; padding: 10px 12px; border: 1px dashed #fca5a5; font-size: 11.5px; color: #991b1b;">
                        <i class="fa fa-info-circle text-danger"></i> <span id="cancelModalSubtext">This request will be withdrawn immediately and the hospital will not see your application.</span>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600;">Keep Affiliation</button>
                    <button type="submit" id="btnSubmitCancel" class="btn btn-danger btn-sm" style="background: #dc2626; border-color: #dc2626; font-weight: 700;">
                        <i class="fa fa-times-circle"></i> Confirm Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detailed Hospital Profile Modal -->
<div class="modal fade" id="hospitalProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 40px rgba(0,0,0,0.25);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: 800;"><i class="fa fa-hospital-o"></i> Hospital Profile &amp; Facilities</h4>
            </div>

            <!-- Modal Loading State -->
            <div id="hp_loader" style="text-align: center; padding: 40px;">
                <i class="fa fa-spinner fa-spin" style="font-size: 32px; color: var(--upchar-teal);"></i>
                <p style="font-size: 13px; color: #64748b; margin-top: 10px;">Loading hospital details...</p>
            </div>

            <!-- Modal Content State -->
            <div id="hp_content" style="display: none;">
                <div class="modal-body" style="padding: 22px;">
                    <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 16px;">
                        <div id="hp_avatar_wrap" style="width: 58px; height: 58px; border-radius: 12px; background: #f0fdfa; border: 1px solid #ccfbf1; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;">
                            <img id="hp_image" src="" alt="Hospital" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <i id="hp_default_icon" class="fa fa-hospital-o" style="font-size: 26px; color: var(--upchar-teal);"></i>
                        </div>
                        <div>
                            <h3 id="hp_name" style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;"></h3>
                            <div style="font-size: 12.5px; color: #64748b;">
                                <i class="fa fa-map-marker text-danger"></i> <span id="hp_address"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Bar -->
                    <div style="display: flex; flex-wrap: wrap; gap: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                        <div style="font-size: 12.5px; color: #334155;">
                            <i class="fa fa-phone text-muted"></i> <strong>Phone:</strong> <span id="hp_phone"></span>
                        </div>
                        <div style="font-size: 12.5px; color: #334155;">
                            <i class="fa fa-envelope-o text-muted"></i> <strong>Email:</strong> <span id="hp_email"></span>
                        </div>
                        <div id="hp_website_wrap" style="font-size: 12.5px; color: #334155; display: none;">
                            <i class="fa fa-globe text-muted"></i> <strong>Website:</strong> <a id="hp_website" href="#" target="_blank" style="color: var(--upchar-teal); font-weight: 600;"></a>
                        </div>
                    </div>

                    <!-- Facilities / Services Section -->
                    <div style="margin-bottom: 16px;">
                        <h5 style="font-size: 12.5px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin: 0 0 8px 0;">
                            <i class="fa fa-stethoscope text-aqua"></i> Medical Facilities &amp; Clinical Services:
                        </h5>
                        <div id="hp_facilities_list" style="display: flex; flex-wrap: wrap; gap: 6px;"></div>
                    </div>

                    <!-- About Hospital Section -->
                    <div style="margin-bottom: 10px;">
                        <h5 style="font-size: 12.5px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin: 0 0 6px 0;">
                            <i class="fa fa-info-circle text-muted"></i> About Institution:
                        </h5>
                        <p id="hp_about" style="font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0; background: #ffffff; border-radius: 6px;"></p>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div id="hp_affiliation_action"></div>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600;">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).ready(function() {

    // CRITICAL FIX: Append modals directly to <body> to prevent stacking context clipping
    // (which causes the backdrop to render on top of the modal, turning the screen completely black)
    $('#affiliateModal, #cancelAffiliationModal, #hospitalProfileModal').appendTo('body');

    // Clean up lingering modal backdrops and body locks on modal close
    $('#affiliateModal, #cancelAffiliationModal, #hospitalProfileModal').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });

    // Toast Alert Helper
    function showAffiliationToast(type, msg) {
        var $t = $('#affiliation_toast_alert');
        if (type === 'success') {
            $t.css({ background: '#065f46', color: '#ffffff', border: '1px solid #059669' })
              .html('<div style="display:flex;align-items:center;gap:12px;"><i class="fa fa-check-circle" style="font-size:20px;"></i><div style="font-size:13px;font-weight:600;line-height:1.4;">' + msg + '</div></div>');
        } else if (type === 'info') {
            $t.css({ background: '#0369a1', color: '#ffffff', border: '1px solid #0284c7' })
              .html('<div style="display:flex;align-items:center;gap:12px;"><i class="fa fa-info-circle" style="font-size:20px;"></i><div style="font-size:13px;font-weight:600;line-height:1.4;">' + msg + '</div></div>');
        } else {
            $t.css({ background: '#991b1b', color: '#ffffff', border: '1px solid #dc2626' })
              .html('<div style="display:flex;align-items:center;gap:12px;"><i class="fa fa-exclamation-circle" style="font-size:20px;"></i><div style="font-size:13px;font-weight:600;line-height:1.4;">' + msg + '</div></div>');
        }
        $t.fadeIn(200).delay(4000).fadeOut(300);
    }

    // Update CSRF token helper
    function refreshCsrfToken(newHash) {
        if (newHash) {
            $('.csrf_token_input').val(newHash);
        }
    }

    // 1. OPEN AFFILIATION MODAL
    $(document).on('click', '.open-affiliate-modal-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');

        $('#modal_hospital_id').val(id);
        $('#modal_hospital_name').text(name);
        $('#modal_fee_input').val('500');

        // If Hospital Profile Modal is open, close it cleanly first
        $('#hospitalProfileModal').modal('hide');

        $('#affiliateModal').modal('show');
    });

    // 2. SUBMIT AFFILIATION REQUEST VIA AJAX
    $('#affiliateForm').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $btn = $('#btnSubmitAffiliate');
        var hospId = $('#modal_hospital_id').val();
        var hospName = $('#modal_hospital_name').text();

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting Request...');

        $.ajax({
            url: '<?=base_url("doctorpanel/ajax_affiliate_hospital");?>',
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Send Request');
                
                // Close modal and force backdrop removal
                $('#affiliateModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');

                if (res.status === 'success' || res.status === 'info') {
                    // Update the target hospital card immediately without reload
                    var $card = $('.hosp-card-' + hospId);
                    if ($card.length) {
                        $card.find('.badge-status-container').html('<span class="badge-pending-pill"><i class="fa fa-clock-o"></i> Pending</span>');
                        
                        var safeHospName = $('<div>').text(hospName).html();
                        $card.find('.action-btn-container').html(
                            '<div style="display: flex; gap: 6px; align-items: center;">' +
                                '<button type="button" class="btn-pending-compact" style="flex: 1; cursor: default;" disabled>' +
                                    '<i class="fa fa-clock-o"></i> Pending' +
                                '</button>' +
                                '<button type="button" class="btn btn-xs btn-default cancel-affiliate-btn" data-id="' + hospId + '" data-name="' + safeHospName + '" data-action="cancel" title="Cancel Affiliation Request" style="color: #dc2626; border-color: #fca5a5; background: #fef2f2; border-radius: 6px; padding: 6px 10px; font-weight: 700; font-size: 11px;">' +
                                    '<i class="fa fa-times-circle"></i> Cancel' +
                                '</button>' +
                            '</div>'
                        );
                    }

                    // Dynamically update Pending KPI counter
                    if (res.pending_count !== undefined) {
                        $('#kpi_pending_count').text(res.pending_count);
                    }
                    if (res.active_count !== undefined) {
                        $('#kpi_active_count').text(res.active_count);
                    }

                    refreshCsrfToken(res.csrf_hash);
                    showAffiliationToast('success', res.message || ('Affiliation request sent to ' + hospName + '!'));
                } else {
                    showAffiliationToast('error', res.message || 'Unable to submit affiliation request.');
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Send Request');
                $('#affiliateModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');
                showAffiliationToast('error', 'A network error occurred. Please try again.');
            }
        });
    });

    // 3. OPEN CANCEL / UNLINK CONFIRMATION MODAL
    $(document).on('click', '.cancel-affiliate-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var hid = $(this).attr('data-id');
        var hname = $(this).attr('data-name');
        var action = $(this).attr('data-action') || 'cancel'; // 'cancel' or 'unlink'

        $('#cancel_modal_hospital_id').val(hid);
        $('#cancel_modal_hospital_name').text(hname);
        $('#cancel_modal_action').val(action);

        if (action === 'unlink') {
            $('#cancelModalHeader').css('background', 'linear-gradient(135deg, #b91c1c 0%, #dc2626 100%)');
            $('#cancelModalTitle').html('<i class="fa fa-chain-broken"></i> Unlink Hospital Practice');
            $('#cancelModalMessage').html('Are you sure you want to unlink your practice from <strong>' + hname + '</strong>? All configured OPD slots and visiting timings for this hospital will be cleared.');
            $('#cancelModalSubtext').text('You can re-apply to affiliate with this partner hospital at any time in the future.');
            $('#btnSubmitCancel').html('<i class="fa fa-chain-broken"></i> Unlink Hospital');
        } else {
            $('#cancelModalHeader').css('background', 'linear-gradient(135deg, #b91c1c 0%, #ef4444 100%)');
            $('#cancelModalTitle').html('<i class="fa fa-times-circle"></i> Cancel Affiliation Request');
            $('#cancelModalMessage').html('Are you sure you want to cancel your pending affiliation request with <strong>' + hname + '</strong>?');
            $('#cancelModalSubtext').text('This request will be withdrawn immediately and the hospital will not see your pending application.');
            $('#btnSubmitCancel').html('<i class="fa fa-times-circle"></i> Confirm Cancel');
        }

        // If Hospital Profile Modal is open, close it cleanly first
        $('#hospitalProfileModal').modal('hide');

        $('#cancelAffiliationModal').modal('show');
    });

    // 4. SUBMIT CANCEL / UNLINK VIA AJAX
    $('#cancelAffiliateForm').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $btn = $('#btnSubmitCancel');
        var hospId = $('#cancel_modal_hospital_id').val();
        var hospName = $('#cancel_modal_hospital_name').text();
        var action = $('#cancel_modal_action').val();

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: '<?=base_url("doctorpanel/ajax_cancel_affiliation");?>',
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html('<i class="fa fa-times-circle"></i> Confirm Cancel');

                // Close modal and force backdrop removal
                $('#cancelAffiliationModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');

                if (res.status === 'success') {
                    // Update target hospital card in Section 2 (Partner Directory)
                    var $card = $('.hosp-card-' + hospId);
                    if ($card.length) {
                        $card.find('.badge-status-container').html('<span style="background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Partner</span>');
                        
                        var safeHospName = $('<div>').text(hospName).html();
                        $card.find('.action-btn-container').html(
                            '<button type="button" class="btn-affiliate-compact open-affiliate-modal-btn" data-id="' + hospId + '" data-name="' + safeHospName + '">' +
                                '<i class="fa fa-plus-circle"></i> Affiliate / Link' +
                            '</button>'
                        );
                    }

                    // If unlinked from Section 1 (My Active Affiliations), remove card with smooth fade
                    var $activeCard = $('.active-affil-card-' + hospId);
                    if ($activeCard.length) {
                        $activeCard.fadeOut(300, function() {
                            $(this).remove();
                            if ($('#active_affiliations_container').children().length === 0) {
                                $('#section_active_affiliations').fadeOut(200);
                            }
                        });
                    }

                    // Dynamically update KPI counts
                    if (res.pending_count !== undefined) {
                        $('#kpi_pending_count').text(res.pending_count);
                    }
                    if (res.active_count !== undefined) {
                        $('#kpi_active_count').text(res.active_count);
                    }

                    refreshCsrfToken(res.csrf_hash);
                    showAffiliationToast('info', res.message || ('Affiliation removed for ' + hospName + '.'));
                } else {
                    showAffiliationToast('error', res.message || 'Unable to cancel affiliation request.');
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).html('<i class="fa fa-times-circle"></i> Confirm Cancel');
                $('#cancelAffiliationModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');
                showAffiliationToast('error', 'A network error occurred. Please try again.');
            }
        });
    });

    // 5. VIEW HOSPITAL PROFILE & FACILITIES MODAL (DYNAMIC AJAX)
    $(document).on('click', '.view-hospital-profile-btn', function(e) {
        e.preventDefault();
        var hid = $(this).attr('data-id');
        if (!hid) return;

        $('#hp_loader').show();
        $('#hp_content').hide();
        $('#hospitalProfileModal').modal('show');

        $.ajax({
            url: '<?=base_url("doctorpanel/ajax_get_hospital_profile");?>',
            type: 'GET',
            data: { hospital_id: hid },
            dataType: 'json',
            success: function(res) {
                $('#hp_loader').hide();
                if (res.status === 'success' && res.data) {
                    var d = res.data;
                    $('#hp_name').text(d.name || 'Hospital Profile');
                    $('#hp_address').text(d.address + (d.city ? (', ' + d.city) : '') + (d.pincode ? (' - ' + d.pincode) : ''));
                    $('#hp_phone').text(d.mobile || 'Not available');
                    $('#hp_email').text(d.email || 'Not available');
                    $('#hp_about').text(d.about || 'Specialized healthcare and clinical facility.');
                    
                    if (d.website && d.website.trim() !== '') {
                        $('#hp_website_wrap').show();
                        var wUrl = (d.website.indexOf('http') === 0) ? d.website : ('http://' + d.website);
                        $('#hp_website').attr('href', wUrl).text(d.website);
                    } else {
                        $('#hp_website_wrap').hide();
                    }

                    if (d.image && d.image.trim() !== '') {
                        $('#hp_image').attr('src', d.image).show();
                        $('#hp_default_icon').hide();
                    } else {
                        $('#hp_image').hide();
                        $('#hp_default_icon').show();
                    }

                    // Render facilities
                    var $facWrap = $('#hp_facilities_list');
                    $facWrap.empty();
                    if (d.facilities && d.facilities.length > 0) {
                        $.each(d.facilities, function(i, f) {
                            $facWrap.append('<span style="background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; font-weight: 700; font-size: 11.5px; padding: 4px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;"><i class="fa fa-check text-success"></i> ' + f + '</span>');
                        });
                    } else {
                        $facWrap.append('<span style="color: #94a3b8; font-size: 12px; font-style: italic;">General Inpatient & Outpatient Specialized Services</span>');
                    }

                    // Affiliation Action in Modal
                    var $statusWrap = $('#hp_affiliation_action');
                    var safeHospName = $('<div>').text(d.name).html();

                    if (d.affiliation_status === 'verified') {
                        $statusWrap.html(
                            '<div style="display:inline-flex;align-items:center;gap:8px;">' +
                                '<span style="background: #dcfce7; color: #15803d; font-weight: 700; font-size: 12px; padding: 6px 14px; border-radius: 8px;"><i class="fa fa-check-circle"></i> Affiliated &amp; Verified</span>' +
                                '<button type="button" class="btn btn-xs btn-default cancel-affiliate-btn" data-id="' + d.id + '" data-name="' + safeHospName + '" data-action="unlink" style="color: #dc2626; border-color: #fecaca; background: #fff5f5; border-radius: 6px; padding: 6px 10px; font-weight: 700;"><i class="fa fa-chain-broken"></i> Unlink</button>' +
                            '</div>'
                        );
                    } else if (d.affiliation_status === 'pending') {
                        $statusWrap.html(
                            '<div style="display:inline-flex;align-items:center;gap:8px;">' +
                                '<span style="background: #fef3c7; color: #b45309; font-weight: 700; font-size: 12px; padding: 6px 14px; border-radius: 8px;"><i class="fa fa-clock-o"></i> Pending Verification</span>' +
                                '<button type="button" class="btn btn-xs btn-default cancel-affiliate-btn" data-id="' + d.id + '" data-name="' + safeHospName + '" data-action="cancel" style="color: #dc2626; border-color: #fca5a5; background: #fef2f2; border-radius: 6px; padding: 6px 10px; font-weight: 700;"><i class="fa fa-times-circle"></i> Cancel Request</button>' +
                            '</div>'
                        );
                    } else {
                        $statusWrap.html(
                            '<button type="button" class="btn btn-sm btn-primary open-affiliate-modal-btn" data-id="' + d.id + '" data-name="' + safeHospName + '" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700;"><i class="fa fa-plus-circle"></i> Affiliate with this Hospital</button>'
                        );
                    }

                    $('#hp_content').fadeIn(150);
                } else {
                    $('#hp_name').text('Hospital Profile Not Found');
                    $('#hp_about').text(res.message || 'Unable to load profile data.');
                    $('#hp_content').show();
                }
            },
            error: function() {
                $('#hp_loader').hide();
                $('#hp_name').text('Error Loading Profile');
                $('#hp_about').text('Could not retrieve profile information. Please check your connection.');
                $('#hp_content').show();
            }
        });
    });

});
</script>