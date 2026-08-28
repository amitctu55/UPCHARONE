<?php include ('includes/header.php'); ?>

<!-- Modern Order Success Section Following Upchar Website Theme -->
<section class="section-wrapper" style="padding: 30px 0 70px;">
    <div class="container">
        
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-12">
                
                <!-- Success Header Card -->
                <div class="modern-partner-card text-center" style="padding: 36px 24px; margin-bottom: 24px; border-radius: 14px; border: 1px solid #CCFBF1; background: linear-gradient(135deg, #F0FDFA 0%, #FFFFFF 100%); box-shadow: 0 6px 20px rgba(0, 168, 150, 0.08);">
                    <div style="width: 72px; height: 72px; background: #00A896; color: #ffffff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 34px; box-shadow: 0 8px 20px rgba(0, 168, 150, 0.3); margin-bottom: 16px;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">
                        Pathology Test Booking Confirmed!
                    </h2>
                    <p style="font-size: 15px; color: #475569; margin: 0;">
                        Booking Reference: <strong style="color: #00A896; font-size: 16px;"><?=$reference_no;?></strong> &bull; Total Amount: <strong>₹<?=number_format($booking->total_amount, 2);?></strong>
                    </p>
                </div>

                <!-- Printable Receipt Card -->
                <div class="modern-partner-card" id="printReceiptArea" style="text-align: left; padding: 28px 30px; margin-bottom: 24px; border-radius: 14px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); background: #ffffff;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #F1F5F9; padding-bottom: 16px; margin-bottom: 20px;">
                        <div>
                            <h3 style="font-size: 20px; font-weight: 900; color: #00A896; margin: 0 0 2px 0;">
                                Upchar Diagnostic Network
                            </h3>
                            <p style="font-size: 12px; color: #64748B; margin: 0;">Official Booking &amp; Sample Collection Receipt</p>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 17px; font-weight: 800; color: #0F172A;"><?=$reference_no;?></div>
                            <div style="font-size: 12px; color: #64748B;">Date: <?=date('d M Y, h:i A', strtotime($booking->book_date));?></div>
                        </div>
                    </div>

                    <!-- Information Grid -->
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 16px; margin-bottom: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; font-size: 13px;">
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Patient Name</div>
                            <div style="font-weight: 800; color: #0F172A;"><?=html_escape($booking->patient_name);?> (<?=$booking->patient_age ?: '32';?> Yrs / <?=$booking->patient_gender ?: 'M';?>)</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Contact Mobile</div>
                            <div style="font-weight: 800; color: #0F172A;"><?=html_escape($booking->patient_mobile);?></div>
                        </div>
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Collection Schedule</div>
                            <div style="font-weight: 800; color: #0F172A;"><?=date('d M Y', strtotime($booking->book_date));?> (<?=$booking->time_slot ?: 'Morning';?>)</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Payment Mode</div>
                            <div>
                                <?php if ($booking->payment_status === '1'): ?>
                                    <span style="color: #16A34A; font-weight: 800;"><i class="fas fa-check-circle"></i> Paid Online (<?=$booking->payment_mode;?>)</span>
                                <?php else: ?>
                                    <span style="color: #0284C7; font-weight: 800;"><i class="fas fa-money-bill-wave"></i> Pay on Collection (COD)</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div style="grid-column: span 2;">
                            <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Sample Collection Address</div>
                            <div style="font-weight: 700; color: #0F172A;"><?=html_escape($booking->patient_address ?: 'Diagnostic Center Direct Visit');?></div>
                        </div>
                    </div>

                    <!-- Tests Table -->
                    <table class="table table-bordered table-striped" style="margin-bottom: 20px; font-size: 13px;">
                        <thead>
                            <tr style="background: #F1F5F9;">
                                <th style="width: 40px;">#</th>
                                <th>Diagnostic Test / Profile</th>
                                <th style="width: 140px;">Sample Type</th>
                                <th style="width: 120px; text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tests)): ?>
                                <?php $i = 1; foreach ($tests as $t): ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td>
                                            <strong><?=html_escape($t->test_name);?></strong>
                                            <div style="font-size: 11.5px; color: #64748B;">NABL Verified Protocol</div>
                                        </td>
                                        <td><i class="fas fa-tint" style="color: #EF4444;"></i> Blood / Serum</td>
                                        <td style="text-align: right; font-weight: 800; color: #00A896;">₹<?=number_format($t->amount, 2);?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: 700;">Home Sample Collection Fee:</td>
                                <td style="text-align: right; color: #16A34A; font-weight: 800;">FREE (₹0.00)</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right; font-size: 15px; font-weight: 900; color: #0F172A;">Total Amount:</td>
                                <td style="text-align: right; font-size: 18px; font-weight: 900; color: #00A896;">₹<?=number_format($booking->total_amount, 2);?></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- What's Next Card -->
                    <div style="background: #F0FDFA; border: 1.5px solid #CCFBF1; border-radius: 10px; padding: 16px 20px; font-size: 12.5px; color: #334155;">
                        <h5 style="font-size: 14px; font-weight: 800; color: #0F766E; margin: 0 0 6px 0;">
                            <i class="fas fa-info-circle"></i> What Happens Next?
                        </h5>
                        <ul style="padding-left: 18px; margin: 0; line-height: 1.6;">
                            <li>Our certified phlebotomist will visit your address on <strong><?=date('d M Y', strtotime($booking->book_date));?></strong> (<?=$booking->time_slot;?>).</li>
                            <li>Sterile vacuum collection tubes with unique barcode will be used.</li>
                            <li>Digital Smart Report with QR authentication will be delivered to your email/SMS in 6-12 hours.</li>
                        </ul>
                    </div>

                </div>

                <!-- Actions -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <button type="button" onclick="window.print()" class="btn btn-default" style="background: #ffffff; border: 1px solid #CBD5E1; font-weight: 700; color: #334155; border-radius: 8px; padding: 10px 22px;">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>

                    <div style="display: flex; gap: 10px;">
                        <a href="<?=base_url('mytest');?>" class="btn btn-outline" style="font-weight: 700; border-radius: 8px; padding: 10px 22px;">
                            <i class="fas fa-plus-circle"></i> Book Another Test
                        </a>
                        <a href="<?=base_url('pathlabview');?>" class="btn btn-primary-cta" style="font-weight: 700; border-radius: 8px; padding: 10px 22px;">
                            <i class="fas fa-hospital-alt"></i> View All Centers
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<?php include ('includes/footer.php'); ?>
