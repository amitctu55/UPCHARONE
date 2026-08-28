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
                        <i class="fa fa-plus-circle" style="color: #00a896;"></i> Add Diagnostic Test to Catalog
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Select master clinical tests, define lab pricing, and configure report delivery SLA.</p>
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
                        <i class="fa fa-flask"></i> Diagnostic Test Registration
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <?php echo form_open_multipart("pathlabpanel/addtest", 'id="addtest_form"'); ?>
                        <input type="hidden" name="path_lab_id" value="<?=$this->did;?>">

                        <div class="row">
                            <!-- Left Column: Test Metadata -->
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Select Master Diagnostic Test <span style="color: #ef4444;">*</span></label>
                                    <select name="test_id" id="test_id" class="path-form-control" required>
                                        <option value="">-- Choose Pathology Test --</option>
                                        <?php if(is_array($master_test) && !empty($master_test)):
                                            foreach($master_test as $val):
                                        ?>
                                            <option value="<?=$val['test_id'];?>" <?=$val['test_id']==set_value('test_id')?'selected':'';?>><?=$val['test_name'];?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Category</label>
                                        <input type="text" readonly id="category_name" name="category_name" class="path-form-control" value="<?=set_value('category_name');?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Short Code</label>
                                        <input type="text" readonly id="short_name" name="short_name" class="path-form-control" value="<?=set_value('short_name');?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Test Type</label>
                                        <input type="text" readonly id="test_type" name="test_type" class="path-form-control" value="<?=set_value('test_type');?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Sub Category</label>
                                        <input type="text" readonly id="sub_category" name="sub_category" class="path-form-control" value="<?=set_value('sub_category');?>">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Testing Method / Analyzer</label>
                                    <input type="text" readonly id="method" name="method" class="path-form-control" value="<?=set_value('method');?>">
                                </div>
                            </div>

                            <!-- Right Column: Pricing & Timeline -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Report Turnaround (Days)</label>
                                        <input type="text" readonly id="report_day" name="report_day" class="path-form-control" value="<?=set_value('report_day');?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Charge Category</label>
                                        <input type="text" readonly id="charge_category" name="charge_category" class="path-form-control" value="<?=set_value('charge_category');?>">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Billing Test Code</label>
                                    <input type="text" readonly id="code" name="code" class="path-form-control" value="<?=set_value('code');?>">
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Standard Portal MRP (₹)</label>
                                        <input type="text" readonly name="amount" id="amount" class="path-form-control" value="<?=set_value('amount');?>">
                                    </div>
                                    <div class="col-sm-6 form-group" style="margin-bottom: 16px;">
                                        <label class="path-form-label">Your Lab Price (₹) <span style="color: #ef4444;">*</span></label>
                                        <input type="number" step="0.01" name="lab_price" id="lab_price" class="path-form-control" value="<?=set_value('lab_price');?>" placeholder="e.g. 250.00" required>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label class="path-form-label">Catalog Status</label>
                                    <select name="status" class="path-form-control">
                                        <option value="1" <?=set_value('status')=='1'?'selected':'';?>>Active (Available for booking)</option>
                                        <option value="0" <?=set_value('status')=='0'?'selected':'';?>>Inactive (Hidden from search)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 18px; margin-top: 10px;">
                            <a href="<?=base_url('pathlabpanel/pathtest');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 9px 22px;">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 9px 28px;">
                                <i class="fa fa-check-circle"></i> Save Test to Catalog
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
$(document).ready(function() {
    $('#test_id').change(function() {
        var val = $(this).val();
        if (val != '') {
            $.ajax({
                url: '<?=base_url('pathlabpanel/get_test_by_test_id')?>',
                type: 'GET',
                data: { test_id: val },
                dataType: 'json',
                success: function(data) {
                    $('#category_name').val(data.category_name || '');
                    $('#short_name').val(data.short_name || '');
                    $('#test_type').val(data.test_type || '');
                    $('#sub_category').val(data.sub_category || '');
                    $('#method').val(data.method || '');
                    $('#report_day').val(data.report_day || '');
                    $('#charge_category').val(data.charge_category || '');
                    $('#code').val(data.code || '');
                    $('#amount').val(data.amount || '');
                    if(!$('#lab_price').val()) {
                        $('#lab_price').val(data.amount || '');
                    }
                }
            });
        } else {
            $('#category_name, #short_name, #test_type, #sub_category, #method, #report_day, #charge_category, #code, #amount, #lab_price').val('');
        }
    });
});
</script>