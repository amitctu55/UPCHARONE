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

.ticket-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.ticket-header-card {
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

.ticket-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.ticket-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-ticket {
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
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-add-ticket:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

/* KPI Summary Cards */
.kpi-ticket-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.kpi-ticket-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.kpi-ticket-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.kpi-ticket-value {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.kpi-ticket-sub {
    font-size: 11.5px;
    color: #94a3b8;
    margin: 0;
}

/* Filter Card */
.ticket-filter-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 16px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.filter-grid-ticket {
    display: grid;
    grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr auto;
    gap: 12px;
    align-items: flex-end;
}

@media (max-width: 900px) {
    .filter-grid-ticket {
        grid-template-columns: 1fr;
    }
}

.ticket-form-ctrl {
    width: 100%;
    height: 40px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
}

.ticket-form-ctrl:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-ticket-search {
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

.btn-ticket-search:hover {
    background: #022b40;
}

/* Table Card */
.ticket-table-card {
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

/* Badges */
.badge-p-low { background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }
.badge-p-medium { background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }
.badge-p-high { background: #fef3c7; color: #b45309; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }
.badge-p-urgent { background: #fee2e2; color: #b91c1c; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }

.badge-s-open { background: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px; }
.badge-s-inprogress { background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px; }
.badge-s-resolved { background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px; }
.badge-s-closed { background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px; }

.btn-view-ticket {
    background: #043d5b;
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 6px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.15s ease;
}

.btn-view-ticket:hover {
    background: #00a896;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="ticket-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="ticket-header-card">
            <div>
                <h1><i class="fa fa-life-ring" style="color: #00a896; margin-right: 8px;"></i> Hospital Helpdesk &amp; Support Tickets</h1>
                <p>Report technical issues, billing discrepancies, or operational questions directly to the Upchar Central Admin team.</p>
            </div>
            <div>
                <button type="button" class="btn-add-ticket" data-toggle="modal" data-target="#createTicketModal">
                    <i class="fa fa-plus-circle"></i> Create New Ticket
                </button>
            </div>
        </div>

        <!-- KPI Summary Cards -->
        <div class="kpi-ticket-grid">
            <div class="kpi-ticket-card" style="border-left: 4px solid #043d5b;">
                <div class="kpi-ticket-title">Total Submitted Tickets</div>
                <div class="kpi-ticket-value" style="color: #043d5b;"><?=$total_count;?></div>
                <p class="kpi-ticket-sub">Lifetime support inquiries</p>
            </div>

            <div class="kpi-ticket-card" style="border-left: 4px solid #eab308;">
                <div class="kpi-ticket-title">Open Tickets</div>
                <div class="kpi-ticket-value" style="color: #ca8a04;"><?=$open_count;?></div>
                <p class="kpi-ticket-sub">Awaiting admin review</p>
            </div>

            <div class="kpi-ticket-card" style="border-left: 4px solid #3b82f6;">
                <div class="kpi-ticket-title">In Progress</div>
                <div class="kpi-ticket-value" style="color: #2563eb;"><?=$in_progress_count;?></div>
                <p class="kpi-ticket-sub">Under active investigation</p>
            </div>

            <div class="kpi-ticket-card" style="border-left: 4px solid #10b981;">
                <div class="kpi-ticket-title">Resolved / Closed</div>
                <div class="kpi-ticket-value" style="color: #10b981;"><?=$resolved_count;?></div>
                <p class="kpi-ticket-sub">Successfully resolved issues</p>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="ticket-filter-card">
            <form method="GET" action="<?=base_url('hospitalpanel/support');?>">
                <div class="filter-grid-ticket">
                    <div>
                        <input type="text" name="keyword" class="ticket-form-ctrl" placeholder="Search ticket code, subject, or message..." value="<?=html_escape($this->input->get('keyword'));?>">
                    </div>
                    <div>
                        <select name="category" class="ticket-form-ctrl">
                            <option value="">-- All Categories --</option>
                            <option value="Billing & Payments" <?=$this->input->get('category')=='Billing & Payments' ? 'selected' : '';?>>Billing &amp; Payments</option>
                            <option value="Technical Issue / Bug" <?=$this->input->get('category')=='Technical Issue / Bug' ? 'selected' : '';?>>Technical Issue / Bug</option>
                            <option value="OPD Management" <?=$this->input->get('category')=='OPD Management' ? 'selected' : '';?>>OPD Management</option>
                            <option value="Bed Setup & Admissions" <?=$this->input->get('category')=='Bed Setup & Admissions' ? 'selected' : '';?>>Bed Setup &amp; Admissions</option>
                            <option value="Doctor Verification" <?=$this->input->get('category')=='Doctor Verification' ? 'selected' : '';?>>Doctor Verification</option>
                            <option value="General Query" <?=$this->input->get('category')=='General Query' ? 'selected' : '';?>>General Query</option>
                        </select>
                    </div>
                    <div>
                        <select name="priority" class="ticket-form-ctrl">
                            <option value="">-- All Priorities --</option>
                            <option value="Low" <?=$this->input->get('priority')=='Low' ? 'selected' : '';?>>Low</option>
                            <option value="Medium" <?=$this->input->get('priority')=='Medium' ? 'selected' : '';?>>Medium</option>
                            <option value="High" <?=$this->input->get('priority')=='High' ? 'selected' : '';?>>High</option>
                            <option value="Urgent" <?=$this->input->get('priority')=='Urgent' ? 'selected' : '';?>>Urgent</option>
                        </select>
                    </div>
                    <div>
                        <select name="status" class="ticket-form-ctrl">
                            <option value="">-- All Statuses --</option>
                            <option value="Open" <?=$this->input->get('status')=='Open' ? 'selected' : '';?>>Open</option>
                            <option value="In Progress" <?=$this->input->get('status')=='In Progress' ? 'selected' : '';?>>In Progress</option>
                            <option value="Resolved" <?=$this->input->get('status')=='Resolved' ? 'selected' : '';?>>Resolved</option>
                            <option value="Closed" <?=$this->input->get('status')=='Closed' ? 'selected' : '';?>>Closed</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button type="submit" class="btn-ticket-search">
                            <i class="fa fa-search"></i> Filter
                        </button>
                        <?php if($this->input->get('keyword') || $this->input->get('category') || $this->input->get('priority') || $this->input->get('status')): ?>
                            <a href="<?=base_url('hospitalpanel/support');?>" class="btn btn-default" style="height: 40px; display: inline-flex; align-items: center;" title="Clear Filters">
                                <i class="fa fa-refresh"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tickets Table -->
        <div class="ticket-table-card">
            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject &amp; Issue Summary</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($tickets)): ?>
                            <?php foreach($tickets as $val): ?>
                                <?php 
                                $p_class = 'badge-p-medium';
                                if ($val->priority == 'Low') $p_class = 'badge-p-low';
                                elseif ($val->priority == 'High') $p_class = 'badge-p-high';
                                elseif ($val->priority == 'Urgent') $p_class = 'badge-p-urgent';

                                $s_class = 'badge-s-open';
                                if ($val->status == 'In Progress') $s_class = 'badge-s-inprogress';
                                elseif ($val->status == 'Resolved') $s_class = 'badge-s-resolved';
                                elseif ($val->status == 'Closed') $s_class = 'badge-s-closed';
                                ?>
                                <tr>
                                    <!-- Ticket Code -->
                                    <td>
                                        <a href="<?=base_url('hospitalpanel/ticket_view/'.$val->ticket_id);?>" style="font-weight: 800; color: #043d5b; text-decoration: none;">
                                            <?=html_escape($val->ticket_code);?>
                                        </a>
                                    </td>

                                    <!-- Subject -->
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                            <a href="<?=base_url('hospitalpanel/ticket_view/'.$val->ticket_id);?>" style="color: #0f172a; text-decoration: none;">
                                                <?=html_escape($val->subject);?>
                                            </a>
                                        </div>
                                        <span style="font-size: 11.5px; color: #64748b;">
                                            <?php 
                                            $clean_desc = strip_tags($val->description);
                                            echo html_escape(strlen($clean_desc) > 80 ? substr($clean_desc, 0, 80).'...' : $clean_desc);
                                            ?>
                                        </span>
                                    </td>

                                    <!-- Category -->
                                    <td>
                                        <span style="font-size: 12.5px; color: #475569; font-weight: 600;">
                                            <?=html_escape($val->category);?>
                                        </span>
                                    </td>

                                    <!-- Priority -->
                                    <td>
                                        <span class="<?=$p_class;?>">
                                            <?=html_escape($val->priority);?>
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <span class="<?=$s_class;?>">
                                            <i class="fa fa-circle" style="font-size: 8px;"></i> <?=html_escape($val->status);?>
                                        </span>
                                    </td>

                                    <!-- Updated Date -->
                                    <td style="color: #64748b; font-size: 12px;">
                                        <?=date('d M Y, h:i A', strtotime($val->updated_at));?>
                                    </td>

                                    <!-- Actions -->
                                    <td style="text-align: right;">
                                        <a href="<?=base_url('hospitalpanel/ticket_view/'.$val->ticket_id);?>" class="btn-view-ticket">
                                            <i class="fa fa-comments-o"></i> View Ticket
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-life-ring" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Support Tickets Found</strong>
                                    <span>Have a question or technical issue? Click <strong>Create New Ticket</strong> to connect with Upchar Admin.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal: Create New Ticket -->
<div class="modal fade" id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="createTicketModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #043d5b 0%, #008f80 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; font-size: 24px;">&times;</button>
                <h4 class="modal-title" id="createTicketModalLabel" style="font-weight: 800; font-size: 17px; color: #ffffff;">
                    <i class="fa fa-plus-circle"></i> Create New Support Ticket
                </h4>
            </div>

            <?php echo form_open_multipart("hospitalpanel/create_ticket", 'id="newTicketForm" style="margin-bottom: 0;"');?>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                
                <div class="modal-body" style="padding: 24px 28px; background: #ffffff;">
                    
                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Issue Category <span style="color: #ef4444;">*</span></label>
                            <select name="category" class="form-control" style="height: 42px; border-radius: 8px; border-color: #cbd5e1;" required>
                                <option value="">-- Select Category --</option>
                                <option value="Billing & Payments">Billing &amp; Payments</option>
                                <option value="Technical Issue / Bug">Technical Issue / Bug</option>
                                <option value="OPD Management">OPD Management</option>
                                <option value="Bed Setup & Admissions">Bed Setup &amp; Admissions</option>
                                <option value="Doctor Verification">Doctor Verification</option>
                                <option value="General Query">General Query</option>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 16px;">
                            <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Priority Level <span style="color: #ef4444;">*</span></label>
                            <select name="priority" class="form-control" style="height: 42px; border-radius: 8px; border-color: #cbd5e1;" required>
                                <option value="Low">Low - General Question</option>
                                <option value="Medium" selected>Medium - Normal Issue</option>
                                <option value="High">High - Impacting Operations</option>
                                <option value="Urgent">Urgent - Critical Emergency</option>
                            </select>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Ticket Subject <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="subject" class="form-control" placeholder="Brief summary of the issue..." style="height: 42px; border-radius: 8px; border-color: #cbd5e1;" required>
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Detailed Description <span style="color: #ef4444;">*</span></label>
                        <textarea name="description" rows="5" class="form-control" placeholder="Explain the issue in detail, steps to reproduce, or transaction IDs..." style="border-radius: 8px; border-color: #cbd5e1;" required></textarea>
                    </div>

                    <!-- File Attachment -->
                    <div style="margin-bottom: 8px;">
                        <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Attach File / Screenshot (Optional)</label>
                        <input type="file" name="attachment" class="form-control" accept="image/*,.pdf,.doc,.docx" style="padding: 6px; height: 42px; border-radius: 8px; border-color: #cbd5e1;">
                        <span style="font-size: 11.5px; color: #64748b; margin-top: 3px; display: block;">Supported files: JPG, PNG, PDF, DOCX (Max 5MB)</span>
                    </div>

                </div>

                <div class="modal-footer" style="background: #f8fafc; padding: 14px 28px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="height: 40px; border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-success" style="background: #00a896; border-color: #00a896; height: 40px; padding: 0 22px; border-radius: 8px; font-weight: 700;">
                        <i class="fa fa-paper-plane"></i> Submit Ticket
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
