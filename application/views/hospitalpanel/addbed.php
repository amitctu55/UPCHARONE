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

.bedform-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.bedform-header-card {
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

.bedform-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.bedform-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-back-link {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

.bedform-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 24px;
    max-width: 1100px;
}

@media (max-width: 900px) {
    .bedform-grid {
        grid-template-columns: 1fr;
    }
}

.bedform-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.form-header-bar {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
}

.form-header-bar h3 {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-body-pad {
    padding: 26px 28px;
}

.input-wrap-group {
    margin-bottom: 18px;
}

.input-wrap-group label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.input-wrap-group label .req {
    color: #ef4444;
}

.form-ctrl-input {
    width: 100%;
    height: 42px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-ctrl-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.form-ctrl-textarea {
    width: 100%;
    height: 90px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    resize: vertical;
    transition: all 0.15s ease;
}

.form-ctrl-textarea:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-save-bed {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 14px;
    height: 44px;
    padding: 0 28px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);
    transition: all 0.15s ease;
    width: 100%;
    margin-top: 8px;
}

.btn-save-bed:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.4);
}

.guidelines-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    padding: 24px;
}

.guidelines-card h4 {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 14px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rule-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
}

.rule-list li {
    font-size: 13px;
    color: #475569;
    margin-bottom: 12px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    line-height: 1.5;
}

.rule-list li i {
    color: #00a896;
    margin-top: 3px;
    font-size: 14px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="bedform-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="bedform-header-card">
            <div>
                <h1><i class="fa fa-plus-circle" style="color: #00a896; margin-right: 8px;"></i> Add Ward / Bed Setup</h1>
                <p>Register a new hospital inpatient ward, set daily room charges, and define bed capacity.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/bed');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Bed List
                </a>
            </div>
        </div>

        <!-- Form & Guidelines Grid -->
        <div class="bedform-grid">
            
            <!-- Left: Bed Form -->
            <div class="bedform-card">
                <div class="form-header-bar">
                    <h3><i class="fa fa-bed"></i> Inpatient Ward Specifications</h3>
                </div>

                <div class="form-body-pad">
                    <?php echo form_open("hospitalpanel/addbed", 'id="addBedForm"');?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        
                        <!-- Bed Type -->
                        <div class="input-wrap-group">
                            <label>Ward / Bed Category Name <span class="req">*</span></label>
                            <input type="text" name="bed_type" class="form-ctrl-input" placeholder="e.g. ICU Ward, Deluxe AC Cabin, General Male Ward" value="<?=set_value('bed_type');?>" required>
                            <span style="color: #ef4444; font-size: 12px;"><?=form_error('bed_type');?></span>
                        </div>

                        <!-- Row: Total and Occupied -->
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-wrap-group">
                                    <label>Total Bed Capacity <span class="req">*</span></label>
                                    <input type="number" min="1" name="total_bed" class="form-ctrl-input" placeholder="e.g. 15" value="<?=set_value('total_bed');?>" required>
                                    <span style="color: #ef4444; font-size: 12px;"><?=form_error('total_bed');?></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-wrap-group">
                                    <label>Currently Occupied Beds</label>
                                    <input type="number" min="0" name="occupied_bed" class="form-ctrl-input" placeholder="e.g. 0" value="<?=set_value('occupied_bed', '0');?>">
                                    <span style="color: #ef4444; font-size: 12px;"><?=form_error('occupied_bed');?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="input-wrap-group">
                            <label>Daily Room / Bed Charge (₹ / day) <span class="req">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-ctrl-input" placeholder="e.g. 1500.00" value="<?=set_value('amount');?>" required>
                            <span style="color: #ef4444; font-size: 12px;"><?=form_error('amount');?></span>
                        </div>

                        <!-- Comment -->
                        <div class="input-wrap-group">
                            <label>Amenities, Equipment &amp; Clinical Notes</label>
                            <textarea name="comment" class="form-ctrl-textarea" placeholder="e.g. Equipped with cardiac monitor, oxygen pipeline, electric adjustable bed, and attendant couch..."><?=set_value('comment');?></textarea>
                            <span style="color: #ef4444; font-size: 12px;"><?=form_error('comment');?></span>
                        </div>

                        <!-- Status -->
                        <div class="input-wrap-group">
                            <label>Status</label>
                            <select name="status" class="form-ctrl-input">
                                <option value="1" <?=set_value('status', '1')=='1' ? 'selected' : '';?>>Active (Available for admissions)</option>
                                <option value="0" <?=set_value('status')=='0' ? 'selected' : '';?>>Inactive (Under maintenance / Closed)</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-save-bed">
                            <i class="fa fa-check-circle"></i> Save &amp; Register Bed Setup
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Right: Bed Management Best Practices -->
            <div class="guidelines-card">
                <h4><i class="fa fa-info-circle" style="color: #00a896;"></i> Inpatient Ward Guidelines</h4>
                
                <ul class="rule-list">
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Configured bed categories integrate automatically into the <strong>Inpatient Admissions (IPD)</strong> drop-down.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>When a patient is admitted via the <strong>Admission Form</strong>, occupied counts update in real-time.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Daily room charges are utilized to calculate patient running bills and discharge billing invoices automatically.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>