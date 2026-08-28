<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.pathlab-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.pathlab-card-header {
    background: linear-gradient(135deg, #1d2a44 0%, #295771 100%);
    color: #ffffff;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pathlab-card-title {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 24px;
}
.path-form-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.path-form-control {
    width: 100%;
    height: 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #1e293b;
    transition: all 0.2s ease;
    background: #ffffff;
}
.path-form-control:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
.path-form-control[readonly] {
    background: #f8fafc;
    color: #64748b;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-pencil" style="color: #00a896;"></i> Edit Diagnostic Test Pricing & SLA
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Update lab rate, active visibility status, and turnaround days for this test.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/pathtest');?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-arrow-left"></i> Back to Test List
                    </a>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            <?=$this->session->flashdata('flashmsg');?>
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fa fa-exclamation-triangle"></i> Please check the required fields:</strong>
                    <?=validation_errors();?>
                </div>
            <?php endif; ?>

            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-flask"></i> <?=htmlspecialchars($package['test_name']);?> (#<?=htmlspecialchars($package['short_name']);?>)
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <?php echo form_open_multipart(current_url_query_string(), 'id="edittest_form"'); ?>
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Diagnostic Test Full Name</label>
                                    <input type="text" readonly name="test_name" class="path-form-control" value="<?=set_value('test_name', $package['test_name']);?>">
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Category</label>
                                        <input type="text" readonly name="category_name" class="path-form-control" value="<?=set_value('category_name', $package['category_name']);?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Short Code</label>
                                        <input type="text" readonly name="short_name" class="path-form-control" value="<?=set_value('short_name', $package['short_name']);?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Test Type</label>
                                        <input type="text" readonly name="test_type" class="path-form-control" value="<?=set_value('test_type', $package['test_type']);?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Sub Category</label>
                                        <input type="text" readonly name="sub_category" class="path-form-control" value="<?=set_value('sub_category', $package['sub_category']);?>">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Testing Methodology</label>
                                    <input type="text" readonly name="method" class="path-form-control" value="<?=set_value('method', $package['method']);?>">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Report Turnaround (Days)</label>
                                        <input type="text" name="report_day" class="path-form-control" value="<?=set_value('report_day', $package['report_day']);?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Charge Category</label>
                                        <input type="text" readonly name="charge_category" class="path-form-control" value="<?=set_value('charge_category', $package['charge_category']);?>">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Billing Test Code</label>
                                    <input type="text" readonly name="code" class="path-form-control" value="<?=set_value('code', $package['code']);?>">
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Standard Portal MRP (₹)</label>
                                        <input type="text" readonly name="amount" class="path-form-control" value="<?=set_value('amount', $package['amount']);?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Your Lab Price (₹) <span style="color: #ef4444;">*</span></label>
                                        <input type="number" step="0.01" name="lab_price" class="path-form-control" value="<?=set_value('lab_price', $package['lab_price']);?>" required>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Catalog Status <span style="color: #ef4444;">*</span></label>
                                    <select name="status" class="path-form-control" required>
                                        <option value="1" <?=set_value('status', $package['status'])=='1'?'selected':'';?>>Active (Available for booking)</option>
                                        <option value="0" <?=set_value('status', $package['status'])=='0'?'selected':'';?>>Inactive (Hidden from search)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 18px; margin-top: 10px;">
                            <a href="<?=base_url('pathlabpanel/pathtest');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 9px 22px;">
                                Cancel
                            </a>
                            <button type="submit" name="submit" value="update" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 9px 28px;">
                                <i class="fa fa-save"></i> Save Updates
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>