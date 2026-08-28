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
    flex-wrap: wrap;
    gap: 10px;
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
.path-form-input {
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
.path-form-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
.price-pill-banner {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
}
</style>

<div class="pag_cstm" style="padding: 20px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-flask" style="color: #00a896;"></i> Book New Diagnostic Lab Test
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Create pathology test booking orders, calculate bill amounts, and set sample collection preferences.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/test_booking');?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-arrow-left"></i> View All Bookings
                    </a>
                </div>
            </div>

            <!-- Flash & Error Alerts -->
            <?=$this->session->flashdata('flashmsg');?>
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fa fa-exclamation-triangle"></i> Please correct the following errors:</strong>
                    <?=validation_errors();?>
                </div>
            <?php endif; ?>

            <?php echo form_open_multipart("pathlabpanel/book_test", 'id="partner_book_form"');?>
            <input type="hidden" name="pathlab_id" value="<?=$this->did;?>">

            <!-- STEP 1: Select Available Tests -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-list-alt"></i> Step 1: Select Diagnostic Tests
                    </h3>
                    <div class="price-pill-banner">
                        Selected: <span id="partner-test-count" style="color: #0f766e;">0</span> Tests &bull; Total: <span style="font-size: 15px; color: #0f766e;">₹<span id="partner-total-amount">0.00</span></span>
                    </div>
                </div>
                <div class="pathlab-card-body">
                    <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <table class="table table-hover table-striped" id="test-table" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 40px; text-align: center;">
                                        <input type="checkbox" id="partner-checkall" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                                    </th>
                                    <th>Test Name</th>
                                    <th>Short Code</th>
                                    <th>Methodology</th>
                                    <th>Sample Type</th>
                                    <th style="text-align: right; width: 120px;">Price (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $selectedTestIds = (array)$this->input->post('arr_ids');
                                if(is_array($path_test) && !empty($path_test)):
                                    foreach($path_test as $val):
                                        $tid = $val['test_id'];
                                        $isChecked = in_array($tid, $selectedTestIds);
                                        $amt = floatval($val['amount']);
                                ?>
                                <tr id="row-test-<?=$tid;?>">
                                    <td style="text-align: center; vertical-align: middle;">
                                        <input type="checkbox" name="arr_ids[]" value="<?=$tid;?>" data-price="<?=$amt;?>" class="partner-test-chk" <?=$isChecked?'checked':'';?> style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($val['test_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="label label-default" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 11px;">
                                            <?=htmlspecialchars($val['short_name']);?>
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle; color: #64748b; font-size: 12.5px;">
                                        <?=htmlspecialchars($val['method'] ?: 'Standard Automated');?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="label label-info" style="background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; font-size: 11px;">
                                            <i class="fa fa-tint"></i> Blood / Serum
                                        </span>
                                    </td>
                                    <td style="text-align: right; vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($amt, 2);?>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                        <i class="fa fa-flask fa-2x" style="margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                        No diagnostic tests registered yet. Add tests in "Manage Path Test" menu.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Patient Demographics & Preferences -->
            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-user"></i> Step 2: Patient Demographics & Collection Details
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 form-group">
                            <label class="path-form-label">Patient Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="patient_name" name="patient_name" class="path-form-input" value="<?=set_value('patient_name');?>" placeholder="e.g. Anand Singh" required>
                        </div>

                        <div class="col-md-4 col-sm-6 form-group">
                            <label class="path-form-label">Patient Mobile Number <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="patient_mobile" name="patient_mobile" class="path-form-input" value="<?=set_value('patient_mobile');?>" placeholder="10-digit mobile number" required maxlength="12">
                        </div>

                        <div class="col-md-4 col-sm-12 form-group">
                            <label class="path-form-label">Patient Email Address</label>
                            <input type="email" id="patient_email" name="patient_email" class="path-form-input" value="<?=set_value('patient_email');?>" placeholder="patient@example.com">
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4 col-sm-6 form-group">
                            <label class="path-form-label">Sample Collection Preference</label>
                            <select class="path-form-input" name="collection_type">
                                <option value="Home Pickup">🏠 Home Sample Collection (Doorstep Pickup)</option>
                                <option value="Lab Visit">🏥 Walk-in Diagnostic Center Visit</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-6 form-group">
                            <label class="path-form-label">Appointment / Sample Date</label>
                            <input type="date" name="preferred_date" class="path-form-input" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>">
                        </div>

                        <div class="col-md-4 col-sm-12 form-group">
                            <label class="path-form-label">Fasting / Special Instructions</label>
                            <select class="path-form-input" name="fasting_status">
                                <option value="Fasting Required (10-12 hrs)">Fasting Required (10-12 hrs, e.g. Glucose, Lipid)</option>
                                <option value="Non-Fasting (Random)">Non-Fasting (Random / Anytime)</option>
                                <option value="Post Prandial (2 hrs after meal)">Post Prandial (PP)</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 18px;">
                        <a href="<?=base_url('pathlabpanel/test_booking');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 9px 22px;">
                            Cancel
                        </a>
                        <button type="submit" name="submit" value="Add" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; padding: 9px 28px; border-radius: 8px; font-size: 14px;">
                            <i class="fa fa-check-circle"></i> Confirm & Book Lab Order
                        </button>
                    </div>
                </div>
            </div>

            <?php echo form_close(); ?> 
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function updatePartnerTestTotal() {
    var total = 0;
    var count = 0;
    $('.partner-test-chk:checked').each(function(){
        total += parseFloat($(this).data('price')) || 0;
        count++;
        $(this).closest('tr').css('background', '#f0fdfa');
    });

    $('.partner-test-chk:not(:checked)').each(function(){
        $(this).closest('tr').css('background', '');
    });

    $('#partner-total-amount').text(total.toFixed(2));
    $('#partner-test-count').text(count);

    var totalBoxes = $('.partner-test-chk').length;
    if (count > 0 && count === totalBoxes) {
        $('#partner-checkall').prop('checked', true).prop('indeterminate', false);
    } else if (count > 0 && count < totalBoxes) {
        $('#partner-checkall').prop('checked', false).prop('indeterminate', true);
    } else {
        $('#partner-checkall').prop('checked', false).prop('indeterminate', false);
    }
}

$(document).ready(function(){
    updatePartnerTestTotal();

    $(document).on('change', '.partner-test-chk', function(){
        updatePartnerTestTotal();
    });

    $(document).on('change', '#partner-checkall', function(){
        var isChecked = $(this).prop('checked');
        $('.partner-test-chk').prop('checked', isChecked);
        updatePartnerTestTotal();
    });

    $('#partner_book_form').submit(function(e){
        if ($('.partner-test-chk:checked').length === 0) {
            alert('Please select at least one diagnostic test to create the booking.');
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>