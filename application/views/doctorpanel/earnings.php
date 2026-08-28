<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.fin-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.fin-kpi-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease;
}

.fin-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
}

.tab-nav-btn {
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 700;
    color: #64748b;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.tab-nav-btn:hover {
    color: var(--upchar-teal);
    background: #f0fdfa;
    border-color: var(--upchar-teal);
}

.tab-nav-btn.active {
    background: var(--upchar-teal);
    color: #ffffff !important;
    border-color: var(--upchar-teal);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
}

.badge-escrow {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}
.badge-held { background: #fef3c7; color: #b45309; }
.badge-released { background: #dcfce7; color: #15803d; }
.badge-queued { background: #e0f2fe; color: #0369a1; }
.badge-processed { background: #d1fae5; color: #065f46; }

.form-label-cstm {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-input-cstm {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-input-cstm:focus {
    background: #ffffff;
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-save-bank {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 12px 28px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-save-bank:hover {
    background: var(--upchar-teal-dark);
}
</style>

<div class="pag_cstm fin-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-line-chart text-aqua" style="margin-right: 8px;"></i> Doctor Financials &amp; Settlement Hub
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Real-time revenue ledger, escrow release tracking, payout bank accounts, and automated weekly settlements.
                    </p>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; padding: 6px 14px; border-radius: 20px; font-weight: 700;">
                        <i class="fa fa-refresh"></i> Settlement Cycle: Weekly (T+7)
                    </span>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Navigation Tabs Bar -->
            <div style="display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap;">
                <a href="<?=base_url('doctorpanel/earnings?tab=overview');?>" class="tab-nav-btn <?=$active_tab=='overview'?'active':'';?>">
                    <i class="fa fa-dashboard"></i> Overview &amp; KPIs
                </a>
                <a href="<?=base_url('doctorpanel/earnings?tab=ledger');?>" class="tab-nav-btn <?=$active_tab=='ledger'?'active':'';?>">
                    <i class="fa fa-list-alt"></i> Transaction &amp; Escrow Ledger
                </a>
                <a href="<?=base_url('doctorpanel/earnings?tab=payment');?>" class="tab-nav-btn <?=$active_tab=='payment'?'active':'';?>">
                    <i class="fa fa-credit-card"></i> Bank Account &amp; Payout Settings
                </a>
            </div>

            <!-- TAB 1: Overview & KPIs -->
            <?php if($active_tab == 'overview'): ?>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fin-kpi-card" style="border-left: 4px solid #00a896;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Net Total Earnings</div>
                            <div style="font-size: 26px; font-weight: 800; color: #00a896; margin: 4px 0 2px 0;">₹<?=number_format(@$earnings->total_net, 2);?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;"><?=intval(@$earnings->total_consultations);?> Total Consultations</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0fdfa; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-inr"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fin-kpi-card" style="border-left: 4px solid #f59e0b;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">In Escrow (Pending)</div>
                            <div style="font-size: 26px; font-weight: 800; color: #d97706; margin: 4px 0 2px 0;">₹<?=number_format(@$earnings->pending_escrow, 2);?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Released on visit completion</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fin-kpi-card" style="border-left: 4px solid #3b82f6;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Queued for Payout</div>
                            <div style="font-size: 26px; font-weight: 800; color: #2563eb; margin: 4px 0 2px 0;">₹<?=number_format(@$earnings->ready_for_payout, 2);?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Scheduled for weekly batch</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fin-kpi-card" style="border-left: 4px solid #10b981;">
                        <div>
                            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Settled &amp; Paid Out</div>
                            <div style="font-size: 26px; font-weight: 800; color: #059669; margin: 4px 0 2px 0;">₹<?=number_format(@$earnings->paid_out, 2);?></div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Transferred to bank account</div>
                        </div>
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workflow Box -->
            <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px 0;">
                    <i class="fa fa-shield text-aqua"></i> How UPCHAR Financial Escrow &amp; Payout Engine Works
                </h3>
                <div class="row">
                    <div class="col-md-4 col-12" style="margin-bottom: 14px;">
                        <div style="background: #f8fafc; border-radius: 12px; padding: 18px; border: 1px solid #f1f5f9; height: 100%;">
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 6px;"><span class="badge" style="background: #00a896; margin-right: 6px;">1</span> Patient Booking</div>
                            <div style="font-size: 12.5px; color: #64748b; line-height: 1.5;">Patient books and pays consultation fee online. Amount is securely held in Escrow (`HELD`).</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12" style="margin-bottom: 14px;">
                        <div style="background: #f8fafc; border-radius: 12px; padding: 18px; border: 1px solid #f1f5f9; height: 100%;">
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 6px;"><span class="badge" style="background: #3b82f6; margin-right: 6px;">2</span> Consultation Completed</div>
                            <div style="font-size: 12.5px; color: #64748b; line-height: 1.5;">Doctor writes Rx and marks visit complete. Escrow unlocks into `RELEASED` &amp; 90% doctor share is queued.</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12" style="margin-bottom: 14px;">
                        <div style="background: #f8fafc; border-radius: 12px; padding: 18px; border: 1px solid #f1f5f9; height: 100%;">
                            <div style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 6px;"><span class="badge" style="background: #10b981; margin-right: 6px;">3</span> Weekly Bank Settlement</div>
                            <div style="font-size: 12.5px; color: #64748b; line-height: 1.5;">Every Tuesday, payout engine batches all queued payouts and deposits directly into your registered bank account.</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- TAB 2: Transaction & Escrow Ledger -->
            <?php if($active_tab == 'ledger' || $active_tab == 'overview'): ?>
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid var(--upchar-border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa fa-list text-aqua"></i> Consultation Transactions &amp; Escrow Ledger
                    </h3>
                    <span style="font-size: 12px; color: #64748b;"><?=count($ledger);?> record(s)</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                                <th style="padding: 14px 16px;">Txn Reference</th>
                                <th style="padding: 14px 16px;">Order #</th>
                                <th style="padding: 14px 16px;">Gross Fee</th>
                                <th style="padding: 14px 16px;">Platform Fee (10%)</th>
                                <th style="padding: 14px 16px;">Net Doctor Share</th>
                                <th style="padding: 14px 16px;">Escrow Status</th>
                                <th style="padding: 14px 16px;">Payout Status</th>
                                <th style="padding: 14px 16px;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ledger)): ?>
                                <?php foreach ($ledger as $row): ?>
                                <tr>
                                    <td style="padding: 14px 16px; font-weight: 700; color: #0f172a; font-family: monospace;">
                                        <?=htmlspecialchars($row->transaction_ref);?>
                                    </td>
                                    <td style="padding: 14px 16px; color: #64748b;">
                                        <?=htmlspecialchars($row->order_id ?: 'N/A');?>
                                    </td>
                                    <td style="padding: 14px 16px; font-weight: 700; color: #0f172a;">
                                        ₹<?=number_format($row->gross_amount, 2);?>
                                    </td>
                                    <td style="padding: 14px 16px; color: #ef4444; font-weight: 600;">
                                        -₹<?=number_format($row->platform_fee, 2);?>
                                    </td>
                                    <td style="padding: 14px 16px; font-weight: 800; color: #00a896;">
                                        ₹<?=number_format($row->net_payout, 2);?>
                                    </td>
                                    <td style="padding: 14px 16px;">
                                        <?php if ($row->escrow_status == 'HELD'): ?>
                                            <span class="badge-escrow badge-held"><i class="fa fa-lock"></i> HELD</span>
                                        <?php else: ?>
                                            <span class="badge-escrow badge-released"><i class="fa fa-check"></i> RELEASED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 16px;">
                                        <?php if ($row->payout_status == 'PROCESSED'): ?>
                                            <span class="badge-escrow badge-processed"><i class="fa fa-check-circle"></i> SETTLED</span>
                                        <?php elseif ($row->payout_status == 'QUEUED'): ?>
                                            <span class="badge-escrow badge-queued"><i class="fa fa-hourglass-half"></i> QUEUED</span>
                                        <?php else: ?>
                                            <span class="badge-escrow badge-held"><i class="fa fa-clock-o"></i> PENDING</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 16px; color: #64748b;">
                                        <?=date('d M Y, h:i A', strtotime($row->created_at));?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="padding: 40px; text-align: center; color: #94a3b8;">
                                        <i class="fa fa-line-chart" style="font-size: 36px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                        No financial ledger transactions recorded yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- TAB 3: Bank Account & Payout Settings -->
            <?php if($active_tab == 'payment'): ?>
            <div class="row">
                <!-- Form Column -->
                <div class="col-md-7 col-12">
                    <div style="background: #ffffff; border-radius: 16px; border: 1px solid var(--upchar-border); padding: 32px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 24px;">
                        
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                <i class="fa fa-bank"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Bank Account for Payout Settlements</h3>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">Direct bank deposit details for your consultation fee earnings</p>
                            </div>
                        </div>

                        <form action="<?=base_url('doctorpanel/earnings');?>" method="post">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="save_bank_details" value="1">

                            <!-- Account Holder Name -->
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Account Holder Name (as per Bank Passbook) *</label>
                                <input type="text" name="account_holder" class="form-input-cstm" value="<?=htmlspecialchars(@$doctor->account_holder ?: ($doctor->fname.' '.$doctor->lname));?>" placeholder="e.g. Dr. Anushka Gupta" required>
                            </div>

                            <!-- Bank Name -->
                            <div class="form-group" style="margin-bottom: 18px;">
                                <label class="form-label-cstm">Bank Name *</label>
                                <input type="text" name="bank_name" class="form-input-cstm" value="<?=htmlspecialchars(@$doctor->bank_name);?>" placeholder="e.g. State Bank of India / HDFC Bank / ICICI" required>
                            </div>

                            <!-- Account Number & IFSC Row -->
                            <div class="row">
                                <div class="col-md-6 col-12" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">Account Number *</label>
                                    <input type="text" name="account_no" class="form-input-cstm" value="<?=htmlspecialchars(@$doctor->account_no);?>" placeholder="e.g. 50100234567890" required>
                                </div>
                                <div class="col-md-6 col-12" style="margin-bottom: 18px;">
                                    <label class="form-label-cstm">IFSC Code *</label>
                                    <input type="text" name="ifsc" class="form-input-cstm" value="<?=htmlspecialchars(@$doctor->ifsc);?>" placeholder="e.g. HDFC0001234" style="text-transform: uppercase;" required>
                                </div>
                            </div>

                            <!-- UPI ID Option -->
                            <div class="form-group" style="margin-bottom: 24px;">
                                <label class="form-label-cstm">UPI ID / VPA (Optional for Instant Settlement)</label>
                                <input type="text" name="upi_id" class="form-input-cstm" value="<?=htmlspecialchars(@$doctor->upi_id);?>" placeholder="e.g. doctoranushka@okhdfcbank">
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">Supports Google Pay, PhonePe, Paytm, and BHIM UPI handles.</span>
                            </div>

                            <button type="submit" class="btn-save-bank">
                                <i class="fa fa-check"></i> Save Payout Bank Details
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-md-5 col-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                            <i class="fa fa-lock text-green"></i> Secure Bank Payouts
                        </h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                            Upchar settles 90% of OPD consultation fees directly into your verified bank account via automated IMPS/NEFT batches every settlement cycle.
                        </p>

                        <div style="background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #f1f5f9; margin-bottom: 12px;">
                            <div style="font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;"><i class="fa fa-check-circle text-aqua"></i> Direct Bank Transfer</div>
                            <div style="font-size: 11.5px; color: #64748b;">No withdrawal request needed. Cleared funds are automatically disbursed weekly.</div>
                        </div>

                        <div style="background: #ecfdf5; border-radius: 10px; padding: 14px; border: 1px solid #d1fae5;">
                            <div style="font-size: 12px; font-weight: 700; color: #065f46; margin-bottom: 4px;"><i class="fa fa-shield text-green"></i> 256-bit Bank Encryption</div>
                            <div style="font-size: 11.5px; color: #047857;">Your account information is stored encrypted and only used for verified payout settlements.</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>
