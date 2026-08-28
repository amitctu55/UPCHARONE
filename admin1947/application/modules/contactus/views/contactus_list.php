<style>
  :root {
    --adm-navy: #1d2a44;
    --adm-teal: #00a896;
    --adm-teal-dark: #008f80;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-700: #334155;
    --adm-slate-600: #475569;
    --adm-slate-500: #64748b;
    --adm-slate-100: #f1f5f9;
    --adm-border: #cbd5e1;
  }

  .contact-wrapper {
    font-family: 'Inter', sans-serif;
    color: var(--adm-slate-800);
  }

  .content-header h1 {
    color: var(--adm-slate-900) !important;
    font-weight: 700;
    font-size: 22px;
    margin-bottom: 5px;
  }

  .content-header h1 small {
    color: var(--adm-slate-600) !important;
    font-size: 13px;
    font-weight: 400;
  }

  /* Modern Widget Cards */
  .stat-card-modern {
    border-radius: 10px;
    padding: 18px 20px;
    color: #ffffff;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .stat-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.12);
  }

  .stat-card-cyan { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); }
  .stat-card-amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
  .stat-card-emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
  .stat-card-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }

  .stat-card-number {
    font-size: 26px;
    font-weight: 800;
    line-height: 1.1;
    margin: 4px 0;
  }
  .stat-card-title {
    font-size: 12.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.9;
  }
  .stat-card-desc {
    font-size: 11.5px;
    opacity: 0.8;
  }
  .stat-card-icon {
    font-size: 36px;
    opacity: 0.85;
  }

  .stat-card-link {
    display: block;
    text-decoration: none !important;
    color: inherit !important;
  }
  .stat-card-link:focus, .stat-card-link:hover {
    text-decoration: none !important;
    color: inherit !important;
  }
  .stat-card-active {
    box-shadow: 0 0 0 3px #ffffff, 0 0 0 6px var(--adm-teal) !important;
    transform: translateY(-2px);
  }

  /* Table Box & Filters */
  .contact-box {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    margin-bottom: 30px;
  }

  .contact-box-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--adm-border);
    background: #ffffff;
    border-radius: 10px 10px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }

  .contact-box-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--adm-slate-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .filter-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--adm-slate-800);
    margin-right: 6px;
  }

  .filter-select {
    border-radius: 6px;
    border: 1px solid var(--adm-border);
    color: var(--adm-slate-900);
    font-weight: 500;
    padding: 6px 12px;
    height: 34px;
    background-color: #ffffff;
  }
  .filter-select:focus {
    border-color: var(--adm-teal);
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.2);
  }

  /* High Contrast Table */
  #contactTable {
    color: var(--adm-slate-800) !important;
    font-size: 13.5px;
    margin-bottom: 0 !important;
  }

  #contactTable thead th {
    background: #f8fafc !important;
    color: var(--adm-slate-900) !important;
    font-weight: 700 !important;
    font-size: 12.5px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.4px !important;
    border-bottom: 2px solid var(--adm-border) !important;
    vertical-align: middle !important;
    padding: 12px 10px !important;
  }

  #contactTable tbody td {
    color: var(--adm-slate-800) !important;
    vertical-align: middle !important;
    border-top: 1px solid #e2e8f0 !important;
    padding: 12px 10px !important;
  }

  #contactTable tbody tr:hover {
    background-color: #f8fafc !important;
  }

  /* High Contrast Badges */
  .badge-high-contrast {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 4px;
    display: inline-block;
  }

  .badge-cat-general { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
  .badge-cat-doctor { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
  .badge-cat-hospital { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
  .badge-cat-lab { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
  .badge-cat-patient { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
  .badge-cat-billing { background: #fee2e2; color: #991b1b; border: 1px solid #fecdd3; }

  .badge-status-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
  .badge-status-replied { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
  .badge-status-resolved { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
  .badge-status-closed { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

  /* Bulk Action Floating Bar */
  .bulk-actions-toolbar {
    position: sticky;
    bottom: 15px;
    background: #1e293b;
    color: #ffffff;
    border-radius: 8px;
    padding: 12px 20px;
    display: none;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    z-index: 1050;
    margin: 15px 0;
  }

  .bulk-count-badge {
    background: var(--adm-teal);
    color: #ffffff;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 12px;
    margin-right: 6px;
  }

  /* Custom Checkbox */
  .custom-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
    margin: 0;
    vertical-align: middle;
  }
</style>

<div class="content-wrapper contact-wrapper">
    <section class="content-header" style="padding-top: 15px;">
        <h1>
            <i class="fa fa-envelope-o" style="color: var(--adm-teal);"></i> Contact Inquiries &amp; Support Queries
            <small>Manage incoming inquiries, categorize leads, and dispatch responses</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active" style="color: var(--adm-slate-800); font-weight: 600;">Contact Us Management</li>
        </ol>
    </section>

    <section class="content">
        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- AJAX Notification Box -->
        <div id="contactAjaxAlert"></div>

        <!-- High-Contrast Interactive Stat Widgets (Clickable Filters) -->
        <div class="row">
            <!-- 1. Total Inquiries -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?php $is_total_active = ($selected_status == 'ALL' && ($selected_date_filter ?? 'ALL') == 'ALL'); ?>
                <a href="<?=base_url('contactus');?>" class="stat-card-link" title="Click to view all inquiries">
                    <div class="stat-card-modern stat-card-cyan <?=$is_total_active ? 'stat-card-active' : '';?>">
                        <div>
                            <div class="stat-card-title">
                                Total Inquiries
                                <?php if($is_total_active): ?>
                                    <span class="badge" style="background: rgba(255,255,255,0.25); font-size: 10px; margin-left: 4px;">ACTIVE</span>
                                <?php endif; ?>
                            </div>
                            <div class="stat-card-number"><?=$stats['total'];?></div>
                            <div class="stat-card-desc">All time patient &amp; partner leads <i class="fa fa-arrow-right" style="font-size: 10px; margin-left: 2px;"></i></div>
                        </div>
                        <div class="stat-card-icon"><i class="fa fa-envelope-open-o"></i></div>
                    </div>
                </a>
            </div>

            <!-- 2. Pending Response -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?php $is_pending_active = ($selected_status == 'PENDING'); ?>
                <a href="<?=base_url('contactus?status=PENDING');?>" class="stat-card-link" title="Click to filter pending inquiries">
                    <div class="stat-card-modern stat-card-amber <?=$is_pending_active ? 'stat-card-active' : '';?>">
                        <div>
                            <div class="stat-card-title">
                                Pending Response
                                <?php if($is_pending_active): ?>
                                    <span class="badge" style="background: rgba(255,255,255,0.25); font-size: 10px; margin-left: 4px;">ACTIVE</span>
                                <?php endif; ?>
                            </div>
                            <div class="stat-card-number"><?=$stats['pending'];?></div>
                            <div class="stat-card-desc">Awaiting admin review <i class="fa fa-arrow-right" style="font-size: 10px; margin-left: 2px;"></i></div>
                        </div>
                        <div class="stat-card-icon"><i class="fa fa-clock-o"></i></div>
                    </div>
                </a>
            </div>

            <!-- 3. Replied & Resolved -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?php $is_resolved_active = in_array($selected_status, ['RESOLVED_REPLIED', 'REPLIED_OR_RESOLVED', 'REPLIED', 'RESOLVED']); ?>
                <a href="<?=base_url('contactus?status=RESOLVED_REPLIED');?>" class="stat-card-link" title="Click to filter replied & resolved inquiries">
                    <div class="stat-card-modern stat-card-emerald <?=$is_resolved_active ? 'stat-card-active' : '';?>">
                        <div>
                            <div class="stat-card-title">
                                Replied &amp; Resolved
                                <?php if($is_resolved_active): ?>
                                    <span class="badge" style="background: rgba(255,255,255,0.25); font-size: 10px; margin-left: 4px;">ACTIVE</span>
                                <?php endif; ?>
                            </div>
                            <div class="stat-card-number"><?=$stats['replied'] + $stats['resolved'];?></div>
                            <div class="stat-card-desc">Official replies dispatched <i class="fa fa-arrow-right" style="font-size: 10px; margin-left: 2px;"></i></div>
                        </div>
                        <div class="stat-card-icon"><i class="fa fa-check-circle-o"></i></div>
                    </div>
                </a>
            </div>

            <!-- 4. Received Today -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?php $is_today_active = (($selected_date_filter ?? 'ALL') == 'TODAY'); ?>
                <a href="<?=base_url('contactus?date_filter=TODAY');?>" class="stat-card-link" title="Click to filter inquiries received today">
                    <div class="stat-card-modern stat-card-purple <?=$is_today_active ? 'stat-card-active' : '';?>">
                        <div>
                            <div class="stat-card-title">
                                Received Today
                                <?php if($is_today_active): ?>
                                    <span class="badge" style="background: rgba(255,255,255,0.25); font-size: 10px; margin-left: 4px;">ACTIVE</span>
                                <?php endif; ?>
                            </div>
                            <div class="stat-card-number"><?=$stats['today_count'];?></div>
                            <div class="stat-card-desc">Submissions received today <i class="fa fa-arrow-right" style="font-size: 10px; margin-left: 2px;"></i></div>
                        </div>
                        <div class="stat-card-icon"><i class="fa fa-calendar-check-o"></i></div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Main Registry Box -->
        <div class="contact-box">
            <div class="contact-box-header">
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <h3 class="contact-box-title">
                        <i class="fa fa-list" style="color: var(--adm-teal);"></i> Contact Inquiries Registry
                    </h3>
                    <?php if($selected_status != 'ALL' || ($selected_date_filter ?? 'ALL') != 'ALL' || $selected_type != 'ALL'): ?>
                        <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px; border: 1px solid #bae6fd;">
                            <i class="fa fa-filter"></i> 
                            <?php 
                                if(($selected_date_filter ?? 'ALL') == 'TODAY') echo "Today's Inquiries";
                                elseif($selected_status == 'PENDING') echo "Pending Inquiries";
                                elseif($selected_status == 'RESOLVED_REPLIED') echo "Replied & Resolved Inquiries";
                                elseif($selected_status != 'ALL') echo htmlspecialchars($selected_status) . " Inquiries";
                                if($selected_type != 'ALL') echo " &bull; " . htmlspecialchars($selected_type);
                            ?>
                            <a href="<?=base_url('contactus');?>" style="color: #0284c7; margin-left: 6px; text-decoration: underline; font-weight: 700;" title="Reset all filters">&times; View All</a>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Filter & Bulk Controls -->
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <!-- Direct Header Bulk Actions Button Group -->
                    <div class="btn-group" id="headerBulkActions" style="margin-right: 5px;">
                        <button type="button" class="btn btn-sm btn-danger btn-header-bulk" id="btnHeaderBulkDelete" disabled style="font-weight: 700; opacity: 0.5; transition: all 0.2s; padding: 6px 14px; border-radius: 6px;">
                            <i class="fa fa-trash"></i> Delete Selected (<span class="bulk-count-num">0</span>)
                        </button>
                        <button type="button" class="btn btn-sm btn-success btn-header-bulk" id="btnHeaderBulkResolve" disabled style="font-weight: 700; opacity: 0.5; transition: all 0.2s; padding: 6px 14px; border-radius: 6px; margin-left: 6px;">
                            <i class="fa fa-check"></i> Mark Resolved (<span class="bulk-count-num">0</span>)
                        </button>
                    </div>

                    <form method="get" action="<?=base_url('contactus');?>" class="form-inline" style="display: flex; gap: 8px; align-items: center;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="filter-label">Status:</label>
                            <select name="status" class="form-control filter-select" onchange="this.form.submit()">
                                <option value="ALL" <?=$selected_status=='ALL'?'selected':'';?>>All Statuses</option>
                                <option value="PENDING" <?=$selected_status=='PENDING'?'selected':'';?>>Pending</option>
                                <option value="RESOLVED_REPLIED" <?=$selected_status=='RESOLVED_REPLIED'?'selected':'';?>>Replied &amp; Resolved</option>
                                <option value="REPLIED" <?=$selected_status=='REPLIED'?'selected':'';?>>Replied</option>
                                <option value="RESOLVED" <?=$selected_status=='RESOLVED'?'selected':'';?>>Resolved</option>
                                <option value="CLOSED" <?=$selected_status=='CLOSED'?'selected':'';?>>Closed</option>
                            </select>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="filter-label">Category:</label>
                            <select name="type" class="form-control filter-select" onchange="this.form.submit()">
                                <option value="ALL" <?=$selected_type=='ALL'?'selected':'';?>>All Categories</option>
                                <option value="GENERAL" <?=$selected_type=='GENERAL'?'selected':'';?>>General</option>
                                <option value="DOCTOR_PARTNERSHIP" <?=$selected_type=='DOCTOR_PARTNERSHIP'?'selected':'';?>>Doctor Partnership</option>
                                <option value="HOSPITAL_ONBOARDING" <?=$selected_type=='HOSPITAL_ONBOARDING'?'selected':'';?>>Hospital Onboarding</option>
                                <option value="LAB_PARTNERSHIP" <?=$selected_type=='LAB_PARTNERSHIP'?'selected':'';?>>Pathology Lab</option>
                                <option value="PATIENT_SUPPORT" <?=$selected_type=='PATIENT_SUPPORT'?'selected':'';?>>Patient Support</option>
                                <option value="BILLING" <?=$selected_type=='BILLING'?'selected':'';?>>Billing</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="box-body table-responsive" style="padding: 0;">
                <table id="contactTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckbox" class="custom-checkbox" title="Select All">
                            </th>
                            <th style="width: 70px;">Ticket #</th>
                            <th style="width: 200px;">Sender Details</th>
                            <th style="width: 140px;">Category</th>
                            <th>Subject &amp; Message Snippet</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 150px;">Date Received</th>
                            <th style="width: 130px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($queries)): ?>
                            <?php foreach($queries as $q): ?>
                            <tr id="row-inquiry-<?=$q['id'];?>">
                                <td style="text-align: center;">
                                    <input type="checkbox" class="custom-checkbox inquiry-chk" value="<?=$q['id'];?>">
                                </td>
                                <td>
                                    <span style="font-weight: 700; font-family: monospace; color: #008f80; font-size: 14px;">
                                        #<?=$q['id'];?>
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 14px; margin-bottom: 2px;">
                                        <?=htmlspecialchars($q['name']);?>
                                    </div>
                                    <div style="font-size: 12px; color: #334155; margin-bottom: 2px;">
                                        <i class="fa fa-phone" style="color: #00a896; width: 14px;"></i> 
                                        <strong><?=htmlspecialchars($q['mobile']);?></strong>
                                    </div>
                                    <?php if(!empty($q['email'])): ?>
                                    <div style="font-size: 12px; color: #475569;">
                                        <i class="fa fa-envelope-o" style="color: #64748b; width: 14px;"></i> <?=htmlspecialchars($q['email']);?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    $type_badges = array(
                                        'GENERAL' => '<span class="badge-high-contrast badge-cat-general"><i class="fa fa-info-circle"></i> General</span>',
                                        'DOCTOR_PARTNERSHIP' => '<span class="badge-high-contrast badge-cat-doctor"><i class="fa fa-user-md"></i> Doctor Lead</span>',
                                        'HOSPITAL_ONBOARDING' => '<span class="badge-high-contrast badge-cat-hospital"><i class="fa fa-hospital-o"></i> Hospital SaaS</span>',
                                        'LAB_PARTNERSHIP' => '<span class="badge-high-contrast badge-cat-lab"><i class="fa fa-flask"></i> Pathlab LIS</span>',
                                        'PATIENT_SUPPORT' => '<span class="badge-high-contrast badge-cat-patient"><i class="fa fa-heartbeat"></i> Patient Care</span>',
                                        'BILLING' => '<span class="badge-high-contrast badge-cat-billing"><i class="fa fa-credit-card"></i> Billing/Refund</span>'
                                    );
                                    echo isset($type_badges[$q['inquiry_type']]) ? $type_badges[$q['inquiry_type']] : '<span class="badge-high-contrast badge-cat-general">'.htmlspecialchars($q['inquiry_type']).'</span>';
                                    ?>
                                </td>
                                <td>
                                    <?php if(!empty($q['subject'])): ?>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 13.5px; margin-bottom: 3px;">
                                        <?=htmlspecialchars($q['subject']);?>
                                    </div>
                                    <?php endif; ?>
                                    <div style="color: #334155; font-size: 13px; line-height: 1.4;">
                                        <?=htmlspecialchars(substr($q['message'], 0, 95)) . (strlen($q['message']) > 95 ? '...' : '');?>
                                    </div>
                                    <?php if(!empty($q['admin_reply'])): ?>
                                    <div style="margin-top: 5px; font-size: 11.5px; color: #065f46; background: #ecfdf5; padding: 3px 8px; border-radius: 4px; display: inline-block; font-weight: 600; border: 1px solid #a7f3d0;">
                                        <i class="fa fa-reply"></i> Replied by <?=htmlspecialchars($q['replied_by']);?> (<?=date('d M Y', strtotime($q['replied_at']));?>)
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($q['status'] == 'PENDING'): ?>
                                        <span class="badge-high-contrast badge-status-pending"><i class="fa fa-clock-o"></i> PENDING</span>
                                    <?php elseif($q['status'] == 'REPLIED'): ?>
                                        <span class="badge-high-contrast badge-status-replied"><i class="fa fa-reply"></i> REPLIED</span>
                                    <?php elseif($q['status'] == 'RESOLVED'): ?>
                                        <span class="badge-high-contrast badge-status-resolved"><i class="fa fa-check"></i> RESOLVED</span>
                                    <?php else: ?>
                                        <span class="badge-high-contrast badge-status-closed"><?=htmlspecialchars($q['status']);?></span>
                                    <?php endif; ?>
                                </td>
                                <td style="color: #475569; font-size: 12.5px; font-weight: 500;">
                                    <i class="fa fa-calendar-o"></i> <?=date('d M Y', strtotime($q['created_at'] ?: $q['date']));?>
                                    <div style="font-size: 11.5px; color: #64748b;"><?=date('h:i A', strtotime($q['created_at'] ?: $q['date']));?></div>
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="<?=base_url('contactus/view/'.$q['id']);?>" class="btn btn-sm btn-primary" title="View &amp; Reply" style="border-radius: 4px; font-weight: 600; padding: 4px 10px;">
                                            <i class="fa fa-reply"></i> Reply
                                        </a>
                                        <a href="<?=base_url('contactus/delete/'.$q['id']);?>" onclick="return confirm('Are you sure you want to delete inquiry #<?=$q['id'];?>?');" class="btn btn-sm btn-danger" title="Delete" style="border-radius: 4px; margin-left: 4px; padding: 4px 8px;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px 20px; color: #64748b;">
                                    <i class="fa fa-inbox" style="font-size: 36px; display: block; margin-bottom: 10px; color: #94a3b8;"></i>
                                    <strong style="font-size: 15px; color: #1e293b; display: block;">No contact inquiries found</strong>
                                    <span>Try clearing the status or category filter to view all submissions.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sticky Bulk Actions Toolbar -->
        <div id="bulkActionsToolbar" class="bulk-actions-toolbar">
            <div style="display: flex; align-items: center;">
                <span class="bulk-count-badge" id="selectedCountBadge">0</span>
                <span style="font-weight: 600; font-size: 14px;">Inquiry(ies) Selected</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="btn btn-sm btn-success" id="btnBulkResolve" style="font-weight: 600;">
                    <i class="fa fa-check"></i> Mark Resolved
                </button>
                <button type="button" class="btn btn-sm btn-danger" id="btnOpenBulkDeleteModal" style="font-weight: 600;">
                    <i class="fa fa-trash"></i> Delete Selected (<span id="deleteCountText">0</span>)
                </button>
                <button type="button" class="btn btn-sm btn-default" id="btnClearSelection" style="font-weight: 500;">
                    Clear
                </button>
            </div>
        </div>

    </section>
</div>

<!-- ==========================================
     BULK DELETE CONFIRMATION MODAL
     ========================================== -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #e11d48; color: #ffffff; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color:#ffffff;">&times;</button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: 700;">
                    <i class="fa fa-trash"></i> Confirm Bulk Deletion
                </h4>
            </div>
            <div class="modal-body" style="padding: 20px; color: #1e293b;">
                <p style="font-size: 14px; margin-bottom: 8px;">
                    Are you sure you want to permanently delete <strong id="modalDeleteCount">0</strong> selected inquiry(ies)?
                </p>
                <p style="font-size: 12px; color: #e11d48; font-weight: 600; margin: 0;">
                    <i class="fa fa-warning"></i> This action is irreversible.
                </p>
            </div>
            <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 8px 8px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btnConfirmBulkDelete" style="font-weight: 600;">
                    <i class="fa fa-trash"></i> Yes, Delete All
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var dt = null;
    // Initialize DataTable
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#contactTable')) {
        dt = $('#contactTable').DataTable({
            "order": [[ 1, "desc" ]],
            "pageLength": 25,
            "columnDefs": [
                { "orderable": false, "targets": [0, 7] } // Disable sorting on checkbox and action columns
            ]
        });
    }

    // Checkbox & Bulk Actions Logic
    function getSelectedCheckboxes() {
        if (dt) {
            return dt.$('.inquiry-chk:checked');
        }
        return $('.inquiry-chk:checked');
    }

    function updateBulkToolbar() {
        var checkedBoxes = getSelectedCheckboxes();
        var selected = [];
        checkedBoxes.each(function() {
            selected.push($(this).val());
        });

        var count = selected.length;
        $('.bulk-count-num').text(count);
        $('#selectedCountBadge').text(count);
        $('#deleteCountText').text(count);
        $('#modalDeleteCount').text(count);

        if (count > 0) {
            // Enable header buttons
            $('#btnHeaderBulkDelete').prop('disabled', false).css({'opacity': '1', 'cursor': 'pointer', 'box-shadow': '0 2px 4px rgba(225,29,72,0.3)'});
            $('#btnHeaderBulkResolve').prop('disabled', false).css({'opacity': '1', 'cursor': 'pointer', 'box-shadow': '0 2px 4px rgba(22,163,74,0.3)'});
            
            // Show floating bar
            $('#bulkActionsToolbar').css('display', 'flex').hide().fadeIn(150);
        } else {
            // Disable header buttons
            $('#btnHeaderBulkDelete').prop('disabled', true).css({'opacity': '0.5', 'cursor': 'not-allowed', 'box-shadow': 'none'});
            $('#btnHeaderBulkResolve').prop('disabled', true).css({'opacity': '0.5', 'cursor': 'not-allowed', 'box-shadow': 'none'});
            
            // Hide floating bar
            $('#bulkActionsToolbar').fadeOut(150);
            $('#selectAllCheckbox').prop('checked', false);
        }
    }

    // Select All Toggle
    $(document).on('change', '#selectAllCheckbox', function() {
        var checked = $(this).is(':checked');
        if (dt) {
            dt.$('.inquiry-chk').prop('checked', checked);
        } else {
            $('.inquiry-chk').prop('checked', checked);
        }
        updateBulkToolbar();
    });

    // Row Checkbox change
    $(document).on('change', '.inquiry-chk', function() {
        var total = dt ? dt.$('.inquiry-chk').length : $('.inquiry-chk').length;
        var checkedCount = getSelectedCheckboxes().length;
        $('#selectAllCheckbox').prop('checked', total > 0 && total === checkedCount);
        updateBulkToolbar();
    });

    // Re-sync on DataTable draw/page change
    if (dt) {
        dt.on('draw', function() {
            var total = dt.$('.inquiry-chk').length;
            var checkedCount = dt.$('.inquiry-chk:checked').length;
            $('#selectAllCheckbox').prop('checked', total > 0 && total === checkedCount);
            updateBulkToolbar();
        });
    }

    // Clear Selection
    $('#btnClearSelection').on('click', function() {
        if (dt) {
            dt.$('.inquiry-chk').prop('checked', false);
        } else {
            $('.inquiry-chk').prop('checked', false);
        }
        $('#selectAllCheckbox').prop('checked', false);
        updateBulkToolbar();
    });

    // Open Modal (Header button or Floating bar button)
    $(document).on('click', '#btnOpenBulkDeleteModal, #btnHeaderBulkDelete', function(e) {
        e.preventDefault();
        var checkedCount = getSelectedCheckboxes().length;
        if (checkedCount === 0) {
            alert('Please select at least one inquiry to delete.');
            return;
        }
        $('#modalDeleteCount').text(checkedCount);
        $('#bulkDeleteModal').modal('show');
    });

    // Perform Bulk Delete via AJAX
    $('#btnConfirmBulkDelete').on('click', function() {
        var btn = $(this);
        var selectedIds = [];
        getSelectedCheckboxes().each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) return;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');

        $.ajax({
            url: '<?=base_url("contactus/bulk_delete");?>',
            type: 'POST',
            data: { ids: selectedIds },
            dataType: 'json',
            success: function(res) {
                $('#bulkDeleteModal').modal('hide');
                btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Yes, Delete All');

                if (res.status === 'success') {
                    // Animate row removal or redraw datatable
                    $.each(res.deleted_ids, function(idx, id) {
                        if (dt) {
                            dt.row('#row-inquiry-' + id).remove();
                        } else {
                            $('#row-inquiry-' + id).remove();
                        }
                    });
                    if (dt) {
                        dt.draw(false);
                    }

                    showContactAlert('success', res.message);
                    $('#selectAllCheckbox').prop('checked', false);
                    updateBulkToolbar();
                } else {
                    showContactAlert('danger', res.message || 'Error occurred while deleting inquiries.');
                }
            },
            error: function() {
                $('#bulkDeleteModal').modal('hide');
                btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Yes, Delete All');
                showContactAlert('danger', 'Server connection error during deletion.');
            }
        });
    });

    // Bulk Mark Resolved (Header button or Floating bar button)
    $(document).on('click', '#btnBulkResolve, #btnHeaderBulkResolve', function(e) {
        e.preventDefault();
        var selectedIds = [];
        getSelectedCheckboxes().each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('Please select at least one inquiry to update.');
            return;
        }

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: '<?=base_url("contactus/bulk_status");?>',
            type: 'POST',
            data: { ids: selectedIds, status: 'RESOLVED' },
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Mark Resolved');
                if (res.status === 'success') {
                    showContactAlert('success', res.message);
                    setTimeout(function() { window.location.reload(); }, 700);
                } else {
                    showContactAlert('danger', res.message || 'Failed to update status.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Mark Resolved');
                showContactAlert('danger', 'Server connection error during status update.');
            }
        });
    });

    function showContactAlert(type, msg) {
        var html = '<div class="alert alert-' + type + ' alert-dismissible" style="border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">' +
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>' + (type === 'success' ? '<i class="fa fa-check-circle"></i> Success!' : '<i class="fa fa-exclamation-triangle"></i> Notice!') + '</strong> ' + msg +
            '</div>';
        $('#contactAjaxAlert').html(html);
        $('html, body').animate({ scrollTop: $('#contactAjaxAlert').offset().top - 70 }, 200);
    }
});
</script>

