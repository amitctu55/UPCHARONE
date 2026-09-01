<?php include ('includes/header.php'); ?>

<!-- Modern Pathology Checkout Section Following Upchar Website Theme -->
<section class="section-wrapper" style="padding: 25px 0 70px;">
    <div class="container">
        
        <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; border-bottom: 2px solid #E2E8F0; padding-bottom: 14px;">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0;">
                    <i class="fas fa-lock" style="color: #00A896;"></i> Secure Pathology Checkout
                </h2>
                <p style="font-size: 13.5px; color: #64748B; margin: 0;">
                    Fill patient information, choose doorstep sample pickup time, and select payment mode.
                </p>
            </div>
            <div>
                <a href="<?=base_url('mytest');?>" class="btn btn-outline" style="font-weight: 600; border-radius: 8px; font-size: 13px;">
                    <i class="fas fa-arrow-left"></i> Back to Tests Catalog
                </a>
            </div>
        </div>

        <?php if($this->session->flashdata('flashmsg')): ?>
            <div style="margin-bottom: 20px;">
                <?=$this->session->flashdata('flashmsg');?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <!-- Empty Cart Handler: Quick Test Selection -->
            <div style="background: #FFFFFF; border-radius: 12px; border: 1px solid #E2E8F0; padding: 36px 24px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 30px;">
                <div style="width: 60px; height: 60px; background: #F0FDFA; color: #00A896; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                    <i class="fas fa-vial"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Your Diagnostic Cart is Currently Empty</h3>
                <p style="font-size: 13.5px; color: #64748B; max-width: 540px; margin: 0 auto 24px;">
                    Please select one of our popular certified diagnostic checkups below to proceed with your booking:
                </p>

                <?php if (!empty($popular_tests)): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; text-align: left; max-width: 900px; margin: 0 auto;">
                        <?php foreach ($popular_tests as $pt): ?>
                            <div style="border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 16px; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong style="font-size: 13.5px; color: #0F172A; display: block;">
                                        <?=html_escape($pt->test_name);?>
                                    </strong>
                                    <span style="font-size: 12px; color: #00A896; font-weight: 700;">₹<?=number_format($pt->amount);?></span>
                                    <span style="font-size: 11px; color: #94A3B8; text-decoration: line-through; margin-left: 4px;">₹<?=round($pt->amount * 1.35);?></span>
                                </div>
                                <a href="<?=base_url('mytest/checkout?test_id=' . $pt->test_id);?>" class="btn btn-sm" style="background: #00A896; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 6px 14px; font-size: 12px; text-decoration: none;">
                                    + Add &amp; Book
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>

        <form action="<?=base_url('mytest/process_payment');?>" method="POST" id="checkoutForm">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

            <div class="row">
                
                <!-- LEFT COLUMN: Patient Details, Address & Payment Selection -->
                <div class="col-md-8 col-12">
                    
                    <!-- 1. Patient Information -->
                    <div class="modern-partner-card" style="text-align: left; padding: 24px 22px; margin-bottom: 24px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); background: #ffffff;">
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0; border-bottom: 1px solid #F1F5F9; padding-bottom: 10px;">
                            <i class="fas fa-user-circle" style="color: #00A896; margin-right: 6px;"></i> 1. Patient Details
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6 col-12 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Patient Full Name <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="text" name="patient_name" class="form-control" required placeholder="Full Name as per ID proof" value="<?=html_escape($patient_name ?: @$user->FNAME);?>" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>

                            <div class="col-md-3 col-6 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Age (Yrs) <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="number" name="patient_age" class="form-control" required min="1" max="120" placeholder="e.g. 35" value="<?=$patient_age ?: 32;?>" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>

                            <div class="col-md-3 col-6 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Gender <span style="color: #EF4444;">*</span>
                                </label>
                                <select name="patient_gender" class="form-control" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1;">
                                    <option value="Male" <?=$patient_gender==='Male' ? 'selected' : '';?>>Male</option>
                                    <option value="Female" <?=$patient_gender==='Female' ? 'selected' : '';?>>Female</option>
                                    <option value="Other" <?=$patient_gender==='Other' ? 'selected' : '';?>>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-12 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Mobile Number <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="tel" name="patient_mobile" class="form-control" required maxlength="10" placeholder="10-digit Mobile Number" value="<?=html_escape($patient_mobile ?: @$user->MOBILE);?>" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>

                            <div class="col-md-6 col-12 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Email Address (for Digital Reports) <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="email" name="patient_email" class="form-control" required placeholder="Email for PDF test report" value="<?=html_escape($patient_email ?: @$user->EMAIL);?>" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Sample Collection Location & Timing -->
                    <div class="modern-partner-card" style="text-align: left; padding: 24px 22px; margin-bottom: 24px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); background: #ffffff;">
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0; border-bottom: 1px solid #F1F5F9; padding-bottom: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #00A896; margin-right: 6px;"></i> 2. Collection Location &amp; Schedule
                        </h4>

                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">
                                Sample Collection Preference
                            </label>
                            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                <label style="flex: 1; min-width: 220px; border: 2px solid #00A896; background: #F0FDFA; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; color: #0F766E; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="visit_type" value="HOME_COLLECTION" checked>
                                    <div>
                                        <i class="fas fa-home"></i> Doorstep Home Collection
                                        <span style="display: block; font-size: 11px; color: #16A34A; font-weight: 600;">100% FREE Collection</span>
                                    </div>
                                </label>
                                <label style="flex: 1; min-width: 220px; border: 1px solid #CBD5E1; background: #ffffff; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; color: #475569; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="visit_type" value="VISIT_LAB">
                                    <div>
                                        <i class="fas fa-hospital-alt"></i> Walk-in to Diagnostic Lab
                                        <span style="display: block; font-size: 11px; color: #64748B;">Direct Center Visit</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 14px;">
                            <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                Home Address for Sample Pickup <span style="color: #EF4444;">*</span>
                            </label>
                            <textarea name="patient_address" rows="2" class="form-control" required placeholder="House/Flat No, Apartment/Building, Street, Landmark, Pin Code" style="border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Preferred Date <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="date" name="booking_date" class="form-control" required value="<?=date('Y-m-d', strtotime('+1 day'));?>" min="<?=date('Y-m-d');?>" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>

                            <div class="col-md-6 col-12 form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">
                                    Preferred Time Slot <span style="color: #EF4444;">*</span>
                                </label>
                                <select name="time_slot" class="form-control" style="height: 44px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13px;">
                                    <option value="Early Morning (06:30 AM - 08:30 AM)">Early Morning (06:30 AM - 08:30 AM) - Fasting Recommended</option>
                                    <option value="Morning (08:30 AM - 11:30 AM)" selected>Morning (08:30 AM - 11:30 AM)</option>
                                    <option value="Afternoon (12:00 PM - 03:00 PM)">Afternoon (12:00 PM - 03:00 PM)</option>
                                    <option value="Evening (04:00 PM - 07:00 PM)">Evening (04:00 PM - 07:00 PM)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Payment Method Selection -->
                    <div class="modern-partner-card" style="text-align: left; padding: 24px 22px; margin-bottom: 24px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); background: #ffffff;">
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0; border-bottom: 1px solid #F1F5F9; padding-bottom: 10px;">
                            <i class="fas fa-credit-card" style="color: #00A896; margin-right: 6px;"></i> 3. Payment Method
                        </h4>

                        <label style="border: 2px solid #00A896; background: #F0FDFA; border-radius: 10px; padding: 14px 16px; margin-bottom: 12px; cursor: pointer; display: flex; align-items: flex-start; gap: 12px; width: 100%;">
                            <input type="radio" name="payment_mode" value="COD" checked style="margin-top: 3px;">
                            <div>
                                <div style="font-weight: 800; font-size: 14.5px; color: #0F172A;">
                                    <i class="fas fa-money-bill-wave" style="color: #16A34A; margin-right: 4px;"></i> Pay on Sample Pickup (Cash / UPI QR at Home)
                                </div>
                                <p style="font-size: 12px; color: #64748B; margin: 2px 0 0 0;">
                                    Pay cash or scan QR code via Google Pay / PhonePe directly to our visiting phlebotomist.
                                </p>
                            </div>
                        </label>

                        <label style="border: 1px solid #CBD5E1; background: #ffffff; border-radius: 10px; padding: 14px 16px; margin-bottom: 12px; cursor: pointer; display: flex; align-items: flex-start; gap: 12px; width: 100%;">
                            <input type="radio" name="payment_mode" value="ONLINE_UPI" style="margin-top: 3px;">
                            <div>
                                <div style="font-weight: 800; font-size: 14.5px; color: #0F172A;">
                                    <i class="fas fa-qrcode" style="color: #0284C7; margin-right: 4px;"></i> Instant Online Payment (UPI / GPay / PhonePe / QR)
                                </div>
                                <p style="font-size: 12px; color: #64748B; margin: 2px 0 0 0;">
                                    Instant contactless payment with automatic digital confirmation.
                                </p>
                            </div>
                        </label>

                        <label style="border: 1px solid #CBD5E1; background: #ffffff; border-radius: 10px; padding: 14px 16px; cursor: pointer; display: flex; align-items: flex-start; gap: 12px; width: 100%;">
                            <input type="radio" name="payment_mode" value="ONLINE_CARD" style="margin-top: 3px;">
                            <div>
                                <div style="font-weight: 800; font-size: 14.5px; color: #0F172A;">
                                    <i class="fas fa-credit-card" style="color: #7C3AED; margin-right: 4px;"></i> Debit / Credit Card &amp; Net Banking
                                </div>
                                <p style="font-size: 12px; color: #64748B; margin: 2px 0 0 0;">
                                    128-bit SSL encrypted checkout for all major Indian banks and cards.
                                </p>
                            </div>
                        </label>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Sticky Order Summary -->
                <div class="col-md-4 col-12">
                    <div class="modern-partner-card" style="text-align: left; padding: 22px 20px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); background: #ffffff; position: sticky; top: 90px;">
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0; border-bottom: 1px solid #F1F5F9; padding-bottom: 10px;">
                            <i class="fas fa-shopping-bag" style="color: #00A896; margin-right: 6px;"></i> Order Summary (<?=count($cart);?> Tests)
                        </h4>

                        <div style="max-height: 220px; overflow-y: auto; margin-bottom: 14px;">
                            <?php foreach ($cart as $item): ?>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; padding: 7px 0; border-bottom: 1px dashed #E2E8F0; font-size: 12.5px;">
                                    <div>
                                        <div style="font-weight: 700; color: #1E293B;"><?=html_escape($item['test_name']);?></div>
                                        <div style="font-size: 11px; color: #64748B;"><?=html_escape($item['lab_name']);?></div>
                                    </div>
                                    <div style="font-weight: 800; color: #00A896; margin-left: 8px;">
                                        ₹<?=number_format($item['amount']);?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div style="font-size: 13px; color: #475569; margin-bottom: 14px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>Total M.R.P.:</span>
                                <span style="text-decoration: line-through; color: #94A3B8;">₹<?=number_format($total_mrp);?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: #16A34A; font-weight: 600;">
                                <span>Direct Lab Discount:</span>
                                <span>- ₹<?=number_format($savings);?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>Home Pickup:</span>
                                <span style="color: #16A34A; font-weight: 700;">FREE (₹0)</span>
                            </div>
                            <div style="border-top: 2px solid #E2E8F0; padding-top: 10px; margin-top: 10px; display: flex; justify-content: space-between; align-items: baseline;">
                                <span style="font-size: 15px; font-weight: 800; color: #0F172A;">Total Amount:</span>
                                <span style="font-size: 22px; font-weight: 900; color: #00A896;">₹<?=number_format($final_total);?></span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-cta" id="btnPlaceOrder" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 15px; border-radius: 8px; padding: 12px 20px;">
                            <i class="fas fa-check-circle"></i> Confirm Booking
                        </button>
                    </div>
                </div>

            </div>
        </form>

        <?php endif; ?>

    </div>
</section>

<?php include ('includes/footer.php'); ?>
