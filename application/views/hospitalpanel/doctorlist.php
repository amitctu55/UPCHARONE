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

.doclist-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.doclist-header-card {
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

.doclist-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.doclist-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

/* Filter Card */
.filter-box-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    margin-bottom: 24px;
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
}

/* Doctor Network Grid */
.doc-network-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.doc-profile-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    transition: all 0.2s ease;
}

.doc-profile-card:hover {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    border-color: #cbd5e1;
}

.doc-card-left {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
    min-width: 280px;
}

.doc-avatar {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ccfbf1;
    background: #ffffff;
    flex-shrink: 0;
}

.doc-meta h3 {
    font-size: 16px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 4px 0;
}

.doc-meta p {
    font-size: 12.5px;
    color: #64748b;
    margin: 0 0 6px 0;
}

.tag-badge {
    display: inline-block;
    background: #f1f5f9;
    color: #475569;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    margin-right: 4px;
}

.doc-card-right {
    display: flex;
    align-items: center;
    gap: 14px;
}

.btn-link-doc {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 12.5px;
    padding: 8px 18px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-link-doc:hover {
    background: #008f80;
    transform: translateY(-1px);
}

.btn-unlink-doc {
    background: #fee2e2;
    color: #dc2626 !important;
    font-weight: 700;
    font-size: 12.5px;
    padding: 8px 16px;
    border-radius: 6px;
    border: 1px solid #fecaca;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-unlink-doc:hover {
    background: #dc2626;
    color: #ffffff !important;
}

.badge-linked-active {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 12px;
    padding: 6px 14px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.pagination-footer-box {
    margin-top: 24px;
    padding: 16px 20px;
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="doclist-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="doclist-header-card">
            <div>
                <h1><i class="fa fa-stethoscope" style="color: #00a896; margin-right: 8px;"></i> <?=$heading_title ? $heading_title : 'Upchar Doctor Directory';?></h1>
                <p>Browse certified medical doctors, discover specialists, and link practitioners to your hospital facility.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn-search-reset" style="background: #ffffff; border: 1px solid var(--upchar-border); color: #043d5b; font-weight: 700;">
                    <i class="fa fa-user-md"></i> My Hospital Doctors
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="filter-box-card">
            <?php echo form_open("hospitalpanel/doctorlist/", 'class="form-horizontal" id="search_form" method="get"'); ?>
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
                        <input type="text" name="doctor_name" value="<?=html_escape($this->input->get_post('doctor_name'));?>" placeholder="e.g. Dr. Sharma">
                    </div>

                    <div class="filter-field filter-btn-group">
                        <button type="submit" class="btn-search-submit">
                            <i class="fa fa-filter"></i> Search Directory
                        </button>
                        <?php if($this->input->get_post('specialization_id')!='' || $this->input->get_post('qualification_id')!='' || $this->input->get_post('doctor_name')!=''): ?>
                            <a href="<?=base_url('hospitalpanel/doctorlist');?>" class="btn-search-reset" title="Clear Filters">
                                <i class="fa fa-refresh"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- Doctor Directory List -->
        <div class="doc-network-list">
            <?php if(is_array($doctorlist) && !empty($doctorlist)): ?>
                <?php foreach($doctorlist as $d): ?>
                    <div class="doc-profile-card">
                        
                        <!-- Left Info Block -->
                        <div class="doc-card-left">
                            <img src="<?=admin_url();?>public/assets/upload/<?=($d->drimage)? $d->drimage : 'dummydr.jpg';?>" class="doc-avatar" alt="<?=prefixdr($d->fname).' '.$d->lname;?>">
                            
                            <div class="doc-meta">
                                <h3><?=prefixdr($d->fname).' '.$d->lname;?></h3>
                                
                                <p>
                                    <?php 	
                                    $qu = $this->db->get_where('dr_qualifications', array('user_id' => $d->id))->result();
                                    if(!empty($qu)):
                                        foreach($qu as $q):
                                            $qname = getQualificationName($q->qualification_id);
                                            if(!empty($qname)):
                                    ?>
                                                <span class="tag-badge"><i class="fa fa-certificate" style="color: #00a896;"></i> <?=$qname;?></span>
                                    <?php 
                                            endif;
                                        endforeach;
                                    endif; 
                                    ?>
                                    <?php if(!empty($d->exp)): ?>
                                        <span class="tag-badge"><i class="fa fa-clock-o"></i> <?=$d->exp;?> yrs exp</span>
                                    <?php endif; ?>
                                </p>

                                <div>
                                    <?php 
                                    $sp = $this->db->get_where('dr_specialization', array('user_id' => $d->id))->result();
                                    if(!empty($sp)):
                                        foreach($sp as $s):
                                            $sname = getSpecilizationName($s->specialization_id);
                                            if(!empty($sname)):
                                    ?>
                                                <span class="tag-badge" style="background: #e0f2fe; color: #0369a1;"><i class="fa fa-stethoscope"></i> <?=$sname;?></span>
                                    <?php 
                                            endif;
                                        endforeach;
                                    endif; 
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Right Action Block -->
                        <div class="doc-card-right">
                            <?php if($d->p_status == null): ?>
                                <form action="<?=base_url('hospitalpanel/linkdoctor');?>" method="POST" style="margin: 0;">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                    <input type="hidden" name="link" value="1">	
                                    <input type="hidden" name="link2" value="<?=$d->id;?>">	 
                                    <button type="submit" class="btn-link-doc">
                                        <i class="fa fa-link"></i> Link To Hospital
                                    </button>
                                </form>
                            <?php elseif($d->p_status == 0): ?>
                                <span class="tag-badge" style="background: #fef3c7; color: #b45309; font-weight: 700; padding: 6px 12px;">
                                    <i class="fa fa-hourglass-half"></i> Request Pending
                                </span>
                                <form action="<?=base_url('hospitalpanel/unlinkdoctor');?>" method="POST" style="margin: 0;">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                    <input type="hidden" name="link" value="1">	
                                    <input type="hidden" name="link2" value="<?=$d->id;?>">	
                                    <button type="submit" class="btn-unlink-doc" title="Cancel linking request">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="badge-linked-active">
                                    <i class="fa fa-check-circle"></i> Affiliated Doctor
                                </span>
                                <a href="<?=base_url('hospitalpanel/updatedoctor/'.mybase64_encode($d->id));?>" class="btn-search-reset" style="background: #f0fdfa; border-color: #ccfbf1; color: #00a896; font-weight: 700;">
                                    <i class="fa fa-clock-o"></i> Timings
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 12px; border: 1px solid var(--upchar-border);">
                    <i class="fa fa-user-md" style="font-size: 42px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                    <h3 style="font-size: 16px; font-weight: 700; color: #64748b; margin: 0 0 6px 0;">No Practitioners Found</h3>
                    <p style="font-size: 13px; color: #94a3b8; margin: 0;">Try adjusting your specialization or doctor search query.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination Footer -->
        <?php if(!empty($page_links)): ?>
            <div class="pagination-footer-box">
                <span style="font-size: 13px; color: #64748b;">Directory navigation</span>
                <div><?=$page_links;?></div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>