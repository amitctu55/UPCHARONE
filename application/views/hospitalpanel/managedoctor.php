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

.panel-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Page Header Card */
.panel-header-card {
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

.panel-header-title h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.panel-header-title p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-primary-action {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-primary-action:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}

/* Search & Filter Card */
.filter-box-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 14px;
    align-items: flex-end;
}

.filter-field label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 5px;
}

.filter-field input,
.filter-field select {
    width: 100%;
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    color: #1e293b;
    background: #ffffff;
    transition: border-color 0.15s ease;
}

.filter-field input:focus,
.filter-field select:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.filter-btn-group {
    display: flex;
    gap: 8px;
}

.btn-search-submit {
    background: #043d5b;
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    height: 38px;
    padding: 0 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex: 1;
    justify-content: center;
    transition: background 0.15s;
}

.btn-search-submit:hover {
    background: #022b40;
}

.btn-search-reset {
    background: #f1f5f9;
    color: #64748b;
    font-weight: 600;
    font-size: 13px;
    height: 38px;
    padding: 0 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    transition: all 0.15s;
}

.btn-search-reset:hover {
    background: #e2e8f0;
    color: #0f172a;
}

/* Data Table Card */
.data-table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
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
    white-space: nowrap;
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

.doc-name-cell {
    font-weight: 700;
    color: #043d5b;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.doc-avatar-badge {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #ccfbf1;
    color: #0f766e;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
}

.tag-pill {
    display: inline-block;
    background: #f1f5f9;
    color: #475569;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    margin: 2px;
}

.badge-status-active {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-status-pending {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-update-timing {
    background: #f0fdfa;
    color: #00a896 !important;
    border: 1px solid #ccfbf1;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
    padding: 5px 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-decoration: none !important;
    transition: all 0.15s;
}

.btn-update-timing:hover {
    background: #00a896;
    color: #ffffff !important;
}

.table-pagination-footer {
    padding: 16px 20px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="panel-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="panel-header-card">
            <div class="panel-header-title">
                <h1><i class="fa fa-user-md" style="color: #00a896; margin-right: 8px;"></i> <?=$heading_title ? $heading_title : 'Manage Doctors';?></h1>
                <p>View, configure schedules, consultation fees, and link affiliated medical specialists.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/adddoctor');?>" class="btn-primary-action">
                    <i class="fa fa-plus-circle"></i> Add / Link New Doctor
                </a>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="filter-box-card">
            <?php echo form_open("hospitalpanel/managedoctor/", 'class="form-horizontal" id="search_form" method="get"'); ?>
                <div class="filter-grid">
                    
                    <div class="filter-field">
                        <label><i class="fa fa-stethoscope"></i> Specialization</label>
                        <select name="specialization_id">
                            <option value="">All Specializations</option>
                            <?php if(is_array($specialization) && !empty($specialization)): ?>
                                <?php foreach($specialization as $val): ?>
                                    <option value="<?=$val['id'];?>" <?=$this->input->get_post('specialization_id')==$val['id'] ? 'selected' : '';?>>
                                        <?=$val['name'];?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="filter-field">
                        <label><i class="fa fa-graduation-cap"></i> Medical Degree</label>
                        <select name="qualification_id">
                            <option value="">All Degrees</option>
                            <?php if(is_array($degree) && !empty($degree)): ?>
                                <?php foreach($degree as $val): ?>
                                    <option value="<?=$val['id'];?>" <?=$this->input->get_post('qualification_id')==$val['id'] ? 'selected' : '';?>>
                                        <?=$val['name'];?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="filter-field">
                        <label><i class="fa fa-search"></i> Doctor Name</label>
                        <input type="text" name="doctor_name" value="<?=html_escape($this->input->get_post('doctor_name'));?>" placeholder="Search by name...">
                    </div>

                    <div class="filter-field filter-btn-group">
                        <button type="submit" class="btn-search-submit">
                            <i class="fa fa-filter"></i> Search
                        </button>
                        <?php if($this->input->get_post('specialization_id')!='' || $this->input->get_post('qualification_id')!='' || $this->input->get_post('doctor_name')!=''): ?>
                            <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn-search-reset" title="Clear Filters">
                                <i class="fa fa-refresh"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- Doctors Data Table -->
        <div class="data-table-card">
            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th>Doctor Details</th>
                            <th>Qualifications</th>
                            <th>Specializations</th>
                            <th>Contact Info</th>
                            <th>Affiliation Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($clinic) && !empty($clinic)): ?>
                            <?php foreach($clinic as $val): ?>
                                <tr>
                                    <!-- Doctor Details -->
                                    <td>
                                        <div class="doc-name-cell">
                                            <div class="doc-avatar-badge">
                                                <?=strtoupper(substr($val->fname, 0, 1));?>
                                            </div>
                                            <div>
                                                <strong><?=prefixdr($val->fname).' '.$val->lname;?></strong>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Qualifications -->
                                    <td>
                                        <?php 	
                                        $qu = $this->db->get_where('dr_qualifications', array('user_id' => $val->id))->result();
                                        if(!empty($qu)):
                                            foreach($qu as $q):
                                                $qname = getQualificationName($q->qualification_id);
                                                if(!empty($qname)):
                                        ?>
                                                    <span class="tag-pill"><i class="fa fa-certificate" style="color: #00a896; font-size: 10px;"></i> <?=$qname;?></span>
                                        <?php 
                                                endif;
                                            endforeach;
                                        else:
                                            echo '<span style="color: #94a3b8; font-size: 12px;">Not Specified</span>';
                                        endif; 
                                        ?>
                                    </td>

                                    <!-- Specializations -->
                                    <td>
                                        <?php 
                                        $sp = $this->db->get_where('dr_specialization', array('user_id' => $val->id))->result();
                                        if(!empty($sp)):
                                            foreach($sp as $s):
                                                $sname = getSpecilizationName($s->specialization_id);
                                                if(!empty($sname)):
                                        ?>
                                                    <span class="tag-pill"><i class="fa fa-stethoscope" style="color: #0284c7; font-size: 10px;"></i> <?=$sname;?></span>
                                        <?php 
                                                endif;
                                            endforeach;
                                        else:
                                            echo '<span style="color: #94a3b8; font-size: 12px;">General</span>';
                                        endif; 
                                        ?>
                                    </td>

                                    <!-- Contact Info -->
                                    <td>
                                        <div>
                                            <?php if(!empty($val->mobile)): ?>
                                                <div style="font-size: 12.5px; font-weight: 600;">
                                                    <i class="fa fa-phone" style="color: #00a896;"></i> <?=$val->mobile;?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($val->email)): ?>
                                                <div style="font-size: 12px; color: #64748b;">
                                                    <i class="fa fa-envelope-o"></i> <?=$val->email;?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <?php if($val->p_status == 1): ?>
                                            <span class="badge-status-active"><i class="fa fa-check-circle"></i> Approved Active</span>
                                        <?php else: ?>
                                            <span class="badge-status-pending"><i class="fa fa-clock-o"></i> Approval Pending</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Actions -->
                                    <td style="text-align: right;">
                                        <?php if($val->p_status == 1): ?>
                                            <a href="<?=base_url('hospitalpanel/updatedoctor/'.mybase64_encode($val->id));?>" class="btn-update-timing">
                                                <i class="fa fa-clock-o"></i> Timings &amp; Fees
                                            </a>
                                        <?php else: ?>
                                            <span style="font-size: 12px; color: #94a3b8;"><i class="fa fa-lock"></i> Verification Required</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                    <i class="fa fa-user-md" style="font-size: 38px; display: block; margin-bottom: 10px; color: #cbd5e1;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Doctors Found</strong>
                                    <span>No affiliated practitioners match your search criteria.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <?php if(!empty($page_links)): ?>
                <div class="table-pagination-footer">
                    <span style="font-size: 13px; color: #64748b;">Showing active directory records</span>
                    <div><?=$page_links;?></div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>