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
}

.hosp-address-text {
    font-size: 11.5px;
    color: #64748b;
    margin: 0 0 8px 0;
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
</style>

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
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">My Affiliated Hospitals</div>
                            <div style="font-size: 24px; font-weight: 800; color: #059669; margin: 2px 0;"><?=count($affiliated_hospitals);?></div>
                            <div style="font-size: 11px; color: #94a3b8;">Active visiting chambers</div>
                        </div>
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="hosp-kpi-card" style="border-left: 4px solid #3b82f6;">
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Network Partner Hospitals</div>
                            <div style="font-size: 24px; font-weight: 800; color: #2563eb; margin: 2px 0;"><?=$total_hospitals;?></div>
                            <div style="font-size: 11px; color: #94a3b8;">Available for empanelment</div>
                        </div>
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-building"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="hosp-kpi-card" style="border-left: 4px solid #00a896;">
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Cities with Hospital Network</div>
                            <div style="font-size: 24px; font-weight: 800; color: #00a896; margin: 2px 0;"><?=count($cities);?></div>
                            <div style="font-size: 11px; color: #94a3b8;">Regional healthcare coverage</div>
                        </div>
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-map-marker"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 1: My Affiliated Hospitals (if any) -->
            <?php if(!empty($affiliated_hospitals)): ?>
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                    <i class="fa fa-check-circle text-green" style="margin-right: 6px;"></i> My Active Hospital Affiliations (<?=count($affiliated_hospitals);?>)
                </h3>

                <div class="row">
                    <?php foreach($affiliated_hospitals as $ah): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12" style="margin-bottom: 16px;">
                        <div class="hosp-compact-card" style="border-color: #a7f3d0; background: #f0fdf4;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <div class="hosp-mini-icon" style="background: #dcfce7; color: #059669;">
                                        <i class="fa fa-hospital-o"></i>
                                    </div>
                                    <span class="badge-affiliated-pill">
                                        <i class="fa fa-check"></i> Linked
                                    </span>
                                </div>
                                <h4 class="hosp-title-text" title="<?=htmlspecialchars($ah->name);?>">
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
                                <a href="<?=base_url('doctorpanel/datetime');?>" class="btn btn-xs btn-default" style="flex: 1; font-weight: 600; font-size: 11px; border-radius: 4px; padding: 4px;">
                                    <i class="fa fa-clock-o"></i> Timings
                                </a>
                                <a href="<?=base_url('managepractice');?>" class="btn btn-xs btn-default" style="flex: 1; font-weight: 600; font-size: 11px; border-radius: 4px; padding: 4px;">
                                    <i class="fa fa-pencil"></i> Edit Fee
                                </a>
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
                            $is_affiliated = in_array($hosp->id, $affiliated_ids);
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12" style="margin-bottom: 16px;">
                            <div class="hosp-compact-card">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <div class="hosp-mini-icon">
                                            <i class="fa fa-hospital-o"></i>
                                        </div>
                                        <?php if($is_affiliated): ?>
                                            <span class="badge-affiliated-pill"><i class="fa fa-check"></i> Linked</span>
                                        <?php else: ?>
                                            <span style="background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Partner</span>
                                        <?php endif; ?>
                                    </div>
                                    <h4 class="hosp-title-text" title="<?=htmlspecialchars($hosp->name);?>">
                                        <?=htmlspecialchars($hosp->name);?>
                                    </h4>
                                    <div class="hosp-address-text" title="<?=htmlspecialchars($hosp->address ?: 'Address on file');?>">
                                        <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($hosp->address ?: 'Address on file');?>
                                    </div>
                                    <?php if(!empty($hosp->mobile)): ?>
                                    <div style="font-size: 11px; color: #64748b; margin-bottom: 8px;">
                                        <i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($hosp->mobile);?>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div style="border-top: 1px solid #f1f5f9; padding-top: 8px; margin-top: 4px;">
                                    <?php if($is_affiliated): ?>
                                        <a href="<?=base_url('doctorpanel/datetime');?>" class="btn btn-xs btn-default btn-block" style="font-weight: 700; color: #00a896; border-color: #ccfbf1; background: #f0fdfa; border-radius: 6px; padding: 5px;">
                                            <i class="fa fa-clock-o"></i> Visiting Hours
                                        </a>
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

<!-- Quick Affiliation Modal -->
<div class="modal fade" id="affiliateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-size: 15px; font-weight: 800;"><i class="fa fa-hospital-o"></i> Link Visiting Hospital</h4>
            </div>
            <form action="<?=base_url('doctorpanel/upcharhospital');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="affiliate_hospital" value="1">
                <input type="hidden" name="hospital_id" id="modal_hospital_id">

                <div class="modal-body" style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Hospital Name:</span>
                        <div id="modal_hospital_name" style="font-weight: 800; color: #0f172a; font-size: 14px; margin-top: 2px;"></div>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">OPD Consultation Fee (₹) *</label>
                        <div class="input-group">
                            <span class="input-group-addon" style="font-weight: 700; background: #f8fafc;">₹</span>
                            <input type="number" name="fee" class="form-control" value="500" min="0" required autofocus>
                        </div>
                        <span style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">Your standard consultation fee at this hospital.</span>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background: var(--upchar-teal); border-color: var(--upchar-teal); font-weight: 700;">
                        <i class="fa fa-check"></i> Link Hospital
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).on('click', '.open-affiliate-modal-btn', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    $('#modal_hospital_id').val(id);
    $('#modal_hospital_name').text(name);
    $('#affiliateModal').modal('show');
});
</script>