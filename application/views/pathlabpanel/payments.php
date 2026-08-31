<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<?php
$userid = $this->session->userdata('userid') ?: $this->session->userdata('did');
$payout_acc = $this->db->get_where('facility_payout_accounts', array('facility_type' => 'pathlab', 'facility_id' => $userid))->row_array();
?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

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
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 22px;
}

.tab-btn-path {
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 700;
    color: #64748b;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.tab-btn-path:hover {
    color: var(--upchar-teal);
    background: #f0fdfa;
    border-color: var(--upchar-teal);
}

.tab-btn-path.active {
    background: var(--upchar-teal);
    color: #ffffff !important;
    border-color: var(--upchar-teal);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
}

.form-label-cstm {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-input-cstm {
    width: 100%;
    height: 44px;
    border-radius: 8px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-input-cstm:focus {
    border-color: var(--upchar-teal);
    background: #ffffff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-credit-card" style="color: #00a896;"></i> Pathology Billing &amp; Settlements
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Track diagnostic test billing, platform escrow releases, and bank account payouts.</p>
                </div>
            </div>

            <!-- Revenue Highlight Cards -->
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Billed Orders</div>
                            <div style="font-size: 28px; font-weight: 800; color: #00a896; margin-top: 4px;">₹<?=number_format($total_revenue, 2);?></div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Across <?=number_format($total_bookings);?> Diagnostic Bookings</div>
                        </div>
                        <div style="width: 54px; height: 54px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Disbursal Schedule</div>
                            <div style="font-size: 24px; font-weight: 800; color: #0284c7; margin-top: 4px;">Weekly (T+7)</div>
                            <div style="font-size: 12px; color: #10b981; margin-top: 4px;"><i class="fa fa-shield"></i> RazorpayX Automated Disbursals</div>
                        </div>
                        <div style="width: 54px; height: 54px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Bank Account Status</div>
                            <div style="font-size: 20px; font-weight: 800; color: <?=!empty($payout_acc['is_verified']) ? '#16a34a' : '#d97706';?>; margin-top: 4px;">
                                <?=!empty($payout_acc['is_verified']) ? '<i class="fa fa-check-circle"></i> Verified' : '<i class="fa fa-exclamation-triangle"></i> Pending Setup';?>
                            </div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                <?=!empty($payout_acc['account_number']) ? 'A/C: ••••' . substr($payout_acc['account_number'], -4) : 'Add settlement bank details';?>
                            </div>
                        </div>
                        <div style="width: 54px; height: 54px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="fa fa-bank"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Buttons -->
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <button type="button" class="tab-btn-path active" id="btn-tab-records" onclick="switchTab('records')">
                    <i class="fa fa-list-alt"></i> Billing &amp; Transaction Records
                </button>
                <button type="button" class="tab-btn-path" id="btn-tab-bank" onclick="switchTab('bank')">
                    <i class="fa fa-bank"></i> Payout Bank &amp; UPI Details
                </button>
            </div>

            <!-- TAB 1: Payments Table -->
            <div id="tab-content-records" class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-list-alt"></i> Billing &amp; Transaction Records
                    </h3>
                </div>
                <div class="pathlab-card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="margin: 0;">
                            <thead style="background: #f8fafc; color: #475569;">
                                <tr>
                                    <th style="width: 70px; text-align: center;">#ID</th>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Invoice Amount</th>
                                    <th>Billing Date</th>
                                    <th style="text-align: center;">Payment Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(is_array($payment_records) && !empty($payment_records)):
                                    foreach($payment_records as $p):
                                        $isPaid = ($p['payment_status'] == 1);
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">
                                        #<?=$p['booking_id'];?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($p['patient_name']);?></strong>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <i class="fa fa-phone"></i> <?=htmlspecialchars($p['patient_mobile']);?>
                                    </td>
                                    <td style="vertical-align: middle; font-weight: 700; color: #00a896; font-size: 14px;">
                                        ₹<?=number_format($p['total_amount'], 2);?>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 12.5px; color: #64748b;">
                                        <?=date('d M Y', strtotime($p['book_date']));?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="label <?=$isPaid ? 'label-success' : 'label-warning';?>" style="font-size: 11px; padding: 4px 10px; border-radius: 12px;">
                                            <?=$isPaid ? 'Paid' : 'Pending';?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?=base_url('pathlabpanel/booking_details/'.$p['booking_id']);?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 600; color: #00a896; border-color: #cbd5e1;">
                                            <i class="fa fa-eye"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                        No billing records found.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Payout Account Settings -->
            <div id="tab-content-bank" class="pathlab-card" style="display: none;">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-university"></i> Bank Account &amp; UPI Settlement Settings
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <div id="payout-alert" style="display: none; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;"></div>

                    <form id="form-pathlab-payout" onsubmit="savePayoutAccount(event)">
                        <input type="hidden" name="facility_type" value="pathlab">
                        <input type="hidden" name="facility_id" value="<?=$userid;?>">
                        <input type="hidden" name="account_type" value="BANK_ACCOUNT">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">Account Holder / Lab Legal Name *</label>
                                    <input type="text" name="account_name" class="form-input-cstm" value="<?=htmlspecialchars($payout_acc['account_name'] ?? '');?>" placeholder="e.g. Apex Diagnostics Pvt Ltd" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">Bank Name *</label>
                                    <input type="text" name="bank_name" class="form-input-cstm" value="<?=htmlspecialchars($payout_acc['bank_name'] ?? '');?>" placeholder="e.g. HDFC Bank, ICICI Bank, SBI" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">Bank Account Number *</label>
                                    <input type="text" name="account_number" class="form-input-cstm" value="<?=htmlspecialchars($payout_acc['account_number'] ?? '');?>" placeholder="Enter current/savings account number" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">IFSC Code *</label>
                                    <input type="text" name="ifsc_code" class="form-input-cstm" value="<?=htmlspecialchars($payout_acc['ifsc_code'] ?? '');?>" placeholder="e.g. HDFC0001234" style="text-transform: uppercase;" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" style="margin-bottom: 24px;">
                                    <label class="form-label-cstm">UPI Virtual Payment Address (VPA / UPI ID) (Optional)</label>
                                    <input type="text" name="vpa" class="form-input-cstm" value="<?=htmlspecialchars($payout_acc['vpa'] ?? '');?>" placeholder="e.g. apexdiagnostics@icici">
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="btn-save-payout" class="btn btn-primary" style="background: var(--upchar-teal); border-color: var(--upchar-teal); padding: 10px 24px; font-weight: 700; border-radius: 8px;">
                            <i class="fa fa-save"></i> Save &amp; Verify Settlement Account
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    if (tab === 'records') {
        document.getElementById('tab-content-records').style.display = 'block';
        document.getElementById('tab-content-bank').style.display = 'none';
        document.getElementById('btn-tab-records').classList.add('active');
        document.getElementById('btn-tab-bank').classList.remove('active');
    } else {
        document.getElementById('tab-content-records').style.display = 'none';
        document.getElementById('tab-content-bank').style.display = 'block';
        document.getElementById('btn-tab-bank').classList.add('active');
        document.getElementById('btn-tab-records').classList.remove('active');
    }
}

function savePayoutAccount(e) {
    e.preventDefault();
    const btn = document.getElementById('btn-save-payout');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';

    const formData = new FormData(document.getElementById('form-pathlab-payout'));
    const alertBox = document.getElementById('payout-alert');

    fetch('<?=base_url("payout/add_account");?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-save"></i> Save & Verify Settlement Account';
        if (data.status === 'success') {
            alertBox.style.display = 'block';
            alertBox.style.background = '#dcfce7';
            alertBox.style.color = '#15803d';
            alertBox.style.border = '1px solid #bbf7d0';
            alertBox.innerHTML = '<i class="fa fa-check-circle"></i> ' + data.message;
        } else {
            alertBox.style.display = 'block';
            alertBox.style.background = '#fee2e2';
            alertBox.style.color = '#b91c1c';
            alertBox.style.border = '1px solid #fecaca';
            alertBox.innerHTML = '<i class="fa fa-exclamation-circle"></i> ' + data.message;
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-save"></i> Save & Verify Settlement Account';
        alertBox.style.display = 'block';
        alertBox.style.background = '#fee2e2';
        alertBox.style.color = '#b91c1c';
        alertBox.style.border = '1px solid #fecaca';
        alertBox.innerHTML = '<i class="fa fa-exclamation-circle"></i> Network error. Please try again.';
    });
}
</script>

<?php include ("assets/includes/footer_hospital.php"); ?>
