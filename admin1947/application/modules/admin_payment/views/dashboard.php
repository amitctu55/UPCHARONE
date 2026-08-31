<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-credit-card text-teal"></i> Payment & Wallet Control Center
            <small>Manage Gateways, Provider Payouts, Wallet Rules & Refunds</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Payment System</li>
        </ol>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('flashmsg')): ?>
            <?php echo $this->session->flashdata('flashmsg'); ?>
        <?php endif; ?>

        <!-- Nav Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="<?php echo ($active_tab === 'dashboard' || empty($active_tab)) ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('admin_payment?tab=dashboard'); ?>">
                        <i class="fa fa-pie-chart"></i> Revenue & Overview
                    </a>
                </li>
                <li class="<?php echo ($active_tab === 'transactions') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('admin_payment?tab=transactions'); ?>">
                        <i class="fa fa-exchange"></i> Payment Orders (<?php echo count($orders); ?>)
                    </a>
                </li>
                <li class="<?php echo ($active_tab === 'wallet_settings') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('admin_payment?tab=wallet_settings'); ?>">
                        <i class="fa fa-sliders"></i> Wallet & Points Rules
                    </a>
                </li>
                <li class="<?php echo ($active_tab === 'payouts') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('admin_payment?tab=payouts'); ?>">
                        <i class="fa fa-bank"></i> Provider Settlements (RazorpayX)
                    </a>
                </li>
                <li class="<?php echo ($active_tab === 'refunds') ? 'active' : ''; ?>">
                    <a href="<?php echo base_url('admin_payment?tab=refunds'); ?>">
                        <i class="fa fa-undo"></i> Refunds (<?php echo count($refunds); ?>)
                    </a>
                </li>
            </ul>

            <div class="tab-content" style="padding: 20px;">
                <!-- TAB 1: OVERVIEW -->
                <?php if ($active_tab === 'dashboard' || empty($active_tab)): ?>
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-teal">
                            <div class="inner">
                                <h3>₹<?php echo number_format($payment_summary['total_volume'], 2); ?></h3>
                                <p>Total Gateway Volume</p>
                            </div>
                            <div class="icon"><i class="fa fa-inr"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>₹<?php echo number_format($payment_summary['today_volume'], 2); ?></h3>
                                <p>Today's Collection</p>
                            </div>
                            <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php echo $payment_summary['success_orders']; ?></h3>
                                <p>Successful Orders (<?php echo $payment_summary['success_rate']; ?>%)</p>
                            </div>
                            <div class="icon"><i class="fa fa-check-circle"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?php echo $payment_summary['failed_orders']; ?></h3>
                                <p>Failed / Dropped Orders</p>
                            </div>
                            <div class="icon"><i class="fa fa-times-circle"></i></div>
                        </div>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-clock-o"></i> Recent Gateway Transactions</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('admin_payment/export_orders'); ?>" class="btn btn-sm btn-success">
                                <i class="fa fa-file-excel-o"></i> Export All to CSV
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Ref No</th>
                                    <th>Service</th>
                                    <th>Amount (INR)</th>
                                    <th>Points Used</th>
                                    <th>Gateway Paid</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($orders, 0, 10) as $o): ?>
                                <tr>
                                    <td><code><?php echo $o['internal_order_ref']; ?></code></td>
                                    <td><span class="label label-info"><?php echo $o['purpose']; ?></span></td>
                                    <td><strong>₹<?php echo number_format($o['amount'], 2); ?></strong></td>
                                    <td><?php echo number_format($o['wallet_points_used'], 0); ?> Pts</td>
                                    <td>₹<?php echo number_format($o['gateway_amount'], 2); ?></td>
                                    <td>
                                        <span class="label label-<?php echo ($o['status'] === 'PAID') ? 'success' : (($o['status'] === 'FAILED') ? 'danger' : 'warning'); ?>">
                                            <?php echo $o['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- TAB 2: TRANSACTIONS / ORDERS -->
                <?php if ($active_tab === 'transactions'): ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Complete Payment Order Register</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('admin_payment/export_orders'); ?>" class="btn btn-sm btn-success">
                                <i class="fa fa-download"></i> Export CSV
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Internal Ref</th>
                                    <th>Gateway Order ID</th>
                                    <th>Gateway Payment ID</th>
                                    <th>User ID</th>
                                    <th>Purpose</th>
                                    <th>Gross (INR)</th>
                                    <th>Points</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($orders as $o): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><code><?php echo $o['internal_order_ref']; ?></code></td>
                                    <td><small><?php echo $o['razorpay_order_id']; ?></small></td>
                                    <td><small><?php echo $o['razorpay_payment_id'] ?: '-'; ?></small></td>
                                    <td>#P-<?php echo $o['user_id']; ?></td>
                                    <td><span class="label label-primary"><?php echo $o['purpose']; ?></span></td>
                                    <td><strong>₹<?php echo number_format($o['amount'], 2); ?></strong></td>
                                    <td><?php echo number_format($o['wallet_points_used'], 0); ?></td>
                                    <td>
                                        <span class="label label-<?php echo ($o['status'] === 'PAID') ? 'success' : (($o['status'] === 'FAILED') ? 'danger' : 'warning'); ?>">
                                            <?php echo $o['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($o['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- TAB 3: WALLET & POINTS SETTINGS -->
                <?php if ($active_tab === 'wallet_settings'): ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-cogs"></i> Configure Global Points & Rewards Engine</h3>
                    </div>
                    <form action="<?php echo base_url('admin_payment/save_wallet_settings'); ?>" method="POST" class="form-horizontal">
                        <div class="box-body" style="max-width: 800px;">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">1 Upchar Point = (INR)</label>
                                <div class="col-sm-8">
                                    <input type="number" step="0.01" name="point_to_inr_ratio" class="form-control" value="<?php echo $point_ratio; ?>" required>
                                    <span class="help-block">e.g. 1.00 means 1 point equals Rs 1.00</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Signup Bonus Points</label>
                                <div class="col-sm-8">
                                    <input type="number" step="1" name="signup_bonus_points" class="form-control" value="<?php echo $signup_bonus; ?>" required>
                                    <span class="help-block">Free points credited to every new patient upon registration</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Cashback Percentage (%)</label>
                                <div class="col-sm-8">
                                    <input type="number" step="0.5" name="cashback_percentage" class="form-control" value="<?php echo $cashback_pct; ?>" required>
                                    <span class="help-block">Percentage of paid amount returned to patient as reward points</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Min Wallet Top-Up (INR)</label>
                                <div class="col-sm-8">
                                    <input type="number" step="10" name="min_recharge_amount" class="form-control" value="<?php echo $min_recharge; ?>" required>
                                    <span class="help-block">Minimum recharge allowed via payment gateway</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Referral Reward (Referrer)</label>
                                <div class="col-sm-8">
                                    <input type="number" step="5" name="referral_bonus_referrer" class="form-control" value="<?php echo $referral_referrer; ?>" required>
                                    <span class="help-block">Points credited to the inviter on referee's first booking</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Referral Reward (Referee)</label>
                                <div class="col-sm-8">
                                    <input type="number" step="5" name="referral_bonus_referee" class="form-control" value="<?php echo $referral_referee; ?>" required>
                                    <span class="help-block">Welcome bonus points credited to invited friend</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Configurations</button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

                <!-- TAB 4: PAYOUTS -->
                <?php if ($active_tab === 'payouts'): ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-bank"></i> Provider Balances & Settlement Batches</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('payout/dashboard'); ?>" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fa fa-external-link"></i> Open Dedicated Settlement Portal
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Facility</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Completed Encounters</th>
                                    <th>Pending Net Share (INR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pending_settlements)): ?>
                                    <?php foreach ($pending_settlements as $ps): ?>
                                    <tr>
                                        <td><span class="label label-info"><?php echo strtoupper($ps['facility_type']); ?></span></td>
                                        <td>#<?php echo $ps['facility_id']; ?></td>
                                        <td><strong><?php echo htmlspecialchars($ps['facility_name'] ?: 'Provider ' . $ps['facility_id']); ?></strong></td>
                                        <td><?php echo $ps['total_txns']; ?> Encounters</td>
                                        <td class="text-green"><strong>₹<?php echo number_format($ps['total_pending_amount'], 2); ?></strong></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">All provider earnings have been disbursed!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- TAB 5: REFUNDS -->
                <?php if ($active_tab === 'refunds'): ?>
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-undo"></i> Processed & Pending Refunds</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Refund Ref</th>
                                    <th>Original Order</th>
                                    <th>User ID</th>
                                    <th>Refund Amount (INR)</th>
                                    <th>Destination</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Initiated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($refunds)): ?>
                                    <?php foreach ($refunds as $r): ?>
                                    <tr>
                                        <td><code><?php echo $r['refund_ref']; ?></code></td>
                                        <td><?php echo $r['original_order_ref']; ?></td>
                                        <td>#P-<?php echo $r['user_id']; ?></td>
                                        <td class="text-red"><strong>₹<?php echo number_format($r['refund_amount'], 2); ?></strong></td>
                                        <td><span class="label label-<?php echo ($r['refund_to'] === 'WALLET') ? 'warning' : 'primary'; ?>"><?php echo $r['refund_to']; ?></span></td>
                                        <td><?php echo htmlspecialchars($r['reason']); ?></td>
                                        <td>
                                            <span class="label label-<?php echo ($r['status'] === 'COMPLETED') ? 'success' : 'warning'; ?>">
                                                <?php echo $r['status']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d M Y, h:i A', strtotime($r['created_at'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No refund requests recorded.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
</div>
