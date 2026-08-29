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

.pkg-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.pkg-header-card {
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

.pkg-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.pkg-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-pkg {
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

.btn-add-pkg:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

/* Filter Card */
.pkg-filter-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 16px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.filter-grid-pkg {
    display: grid;
    grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr auto;
    gap: 12px;
    align-items: flex-end;
}

@media (max-width: 900px) {
    .filter-grid-pkg {
        grid-template-columns: 1fr;
    }
}

.pkg-form-ctrl {
    width: 100%;
    height: 40px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
}

.pkg-form-ctrl:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-pkg-search {
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

.btn-pkg-search:hover {
    background: #022b40;
}

/* Table Card */
.pkg-table-card {
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

.pkg-thumb {
    width: 60px;
    height: 44px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
    cursor: pointer;
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
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="pkg-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="pkg-header-card">
            <div>
                <h1><i class="fa fa-medkit" style="color: #00a896; margin-right: 8px;"></i> Health &amp; Surgical Packages</h1>
                <p>Manage preventive health checkup plans, surgical bundles, and treatment packages published for patients.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/addpackage');?>" class="btn-add-pkg">
                    <i class="fa fa-plus-circle"></i> Create New Package
                </a>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="pkg-filter-card">
            <form method="GET" action="<?=base_url('hospitalpanel/package');?>">
                <div class="filter-grid-pkg">
                    <div>
                        <input type="text" name="keyword" class="pkg-form-ctrl" placeholder="Search by package name or title..." value="<?=html_escape($this->input->get('keyword'));?>">
                    </div>
                    <div>
                        <input type="date" name="date_from" class="pkg-form-ctrl" value="<?=html_escape($this->input->get('date_from'));?>" placeholder="Date From">
                    </div>
                    <div>
                        <input type="date" name="date_to" class="pkg-form-ctrl" value="<?=html_escape($this->input->get('date_to'));?>" placeholder="Date To">
                    </div>
                    <div>
                        <select name="status" class="pkg-form-ctrl">
                            <option value="">-- All Statuses --</option>
                            <option value="1" <?=$this->input->get('status')==='1' ? 'selected' : '';?>>Active</option>
                            <option value="0" <?=$this->input->get('status')==='0' ? 'selected' : '';?>>Inactive</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button type="submit" class="btn-pkg-search">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <?php if($this->input->get('keyword') || $this->input->get('date_from') || $this->input->get('status') !== null): ?>
                            <a href="<?=base_url('hospitalpanel/package');?>" class="btn btn-default" style="height: 40px; display: inline-flex; align-items: center;" title="Clear Filters">
                                <i class="fa fa-refresh"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Packages Table -->
        <div class="pkg-table-card">
            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Banner</th>
                            <th>Package Title</th>
                            <th>Package Price</th>
                            <th>Summary / Description</th>
                            <th>Video / Media</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($packages)): ?>
                            <?php foreach($packages as $val): ?>
                                <tr>
                                    <!-- Image Thumbnail -->
                                    <td>
                                        <?php if(!empty($val->image)): ?>
                                            <img src="<?=base_url('admin1947/public/assets/upload/'.$val->image);?>" class="pkg-thumb" data-toggle="modal" data-target="#pkgModal<?=$val->package_id;?>" title="Click to view image">
                                            
                                            <!-- Preview Modal -->
                                            <div class="modal fade" id="pkgModal<?=$val->package_id;?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                                                        <div class="modal-header" style="background: #043d5b; color: #fff; padding: 14px 20px;">
                                                            <button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
                                                            <h4 class="modal-title" style="font-size: 15px; font-weight: 700; color: #fff;"><?=html_escape($val->title);?></h4>
                                                        </div>
                                                        <div class="modal-body" style="padding: 16px; text-align: center;">
                                                            <img src="<?=base_url('admin1947/public/assets/upload/'.$val->image);?>" style="max-width: 100%; height: auto; border-radius: 8px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div style="width: 60px; height: 44px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 18px;">
                                                <i class="fa fa-medkit"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Title -->
                                    <td>
                                        <div style="font-weight: 800; color: #043d5b; font-size: 14px;">
                                            <?=html_escape($val->title);?>
                                        </div>
                                        <span style="font-size: 11.5px; color: #64748b;">Ref #PKG-<?=$val->package_id;?></span>
                                    </td>

                                    <!-- Price -->
                                    <td>
                                        <div style="font-weight: 800; color: #00a896; font-size: 14px;">
                                            ₹<?=number_format((float)$val->amount, 2);?>
                                        </div>
                                    </td>

                                    <!-- Description -->
                                    <td style="max-width: 260px; color: #475569; font-size: 12.5px; line-height: 1.4;">
                                        <?php 
                                        $clean_desc = strip_tags($val->description ?? '');
                                        echo html_escape(strlen($clean_desc) > 90 ? substr($clean_desc, 0, 90).'...' : $clean_desc);
                                        ?>
                                    </td>

                                    <!-- Video Link -->
                                    <td>
                                        <?php if(!empty($val->video_url)): ?>
                                            <a href="<?=prep_url($val->video_url);?>" target="_blank" style="color: #dc2626; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa fa-youtube-play"></i> Watch Video
                                            </a>
                                        <?php else: ?>
                                            <span style="color: #94a3b8; font-size: 12px;">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Date -->
                                    <td style="color: #64748b; font-size: 12px;">
                                        <?=date('d M Y', strtotime($val->creat_date));?>
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
                                            <a href="<?=base_url('hospitalpanel/editpackage/'.$val->package_id);?>" class="btn-act-edit">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="<?=base_url('hospitalpanel/delete_package/'.$val->package_id);?>" onclick="return confirm('Are you sure you want to delete this healthcare package?');" class="btn-act-del">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-medkit" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Healthcare Packages Found</strong>
                                    <span>Click <strong>Create New Package</strong> to publish a new medical package for patients.</span>
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
