<?php include('includes/header.php'); ?>

<style>
/* ==========================================================================
   UPCHAR E-Commerce Pharmacy Cart Styling
   ========================================================================== */
.cart-page-header {
    background: linear-gradient(135deg, #062330 0%, #0A364A 100%);
    color: #FFFFFF;
    padding: 32px 0 28px;
    margin-bottom: 30px;
}
.cart-header-title {
    font-size: 26px;
    font-weight: 800;
    margin: 0 0 6px;
    color: #FFFFFF;
}
.cart-breadcrumb {
    font-size: 13px;
    color: #94A3B8;
}
.cart-breadcrumb a {
    color: #38BDF8;
    text-decoration: none;
}
.cart-breadcrumb a:hover {
    text-decoration: underline;
}

/* Cart Item Cards */
.cart-item-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    transition: all 0.2s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.cart-item-card:hover {
    border-color: #00A8FF;
    box-shadow: 0 6px 16px rgba(0, 168, 255, 0.08);
}
.cart-item-details {
    flex: 2;
    min-width: 240px;
}
.cart-item-title {
    font-size: 17px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.cart-item-meta {
    font-size: 12.5px;
    color: #64748B;
    margin: 0 0 6px;
}
.cart-store-tag {
    font-size: 12px;
    color: #0284C7;
    background: #F0F9FF;
    border: 1px solid #BAE6FD;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 4px;
}

/* Quantity Stepper */
.qty-stepper-box {
    display: flex;
    align-items: center;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    overflow: hidden;
    background: #F8FAFC;
}
.qty-btn {
    width: 34px;
    height: 34px;
    border: none;
    background: #F1F5F9;
    color: #0F172A;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s ease;
}
.qty-btn:hover {
    background: #E2E8F0;
    color: #00A8FF;
}
.qty-input {
    width: 44px;
    height: 34px;
    border: none;
    background: #FFFFFF;
    text-align: center;
    font-weight: 700;
    font-size: 14px;
    color: #0F172A;
    outline: none;
}

/* Pricing in Item Card */
.cart-item-price-block {
    text-align: right;
    min-width: 110px;
}
.cart-item-price {
    font-size: 19px;
    font-weight: 800;
    color: #059669;
}
.cart-item-mrp {
    font-size: 12.5px;
    color: #94A3B8;
    text-decoration: line-through;
}
.cart-item-unit-rate {
    font-size: 11px;
    color: #64748B;
}

/* Sidebar Order Summary */
.cart-summary-box {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    padding: 22px;
    margin-bottom: 24px;
    position: sticky;
    top: 20px;
}
.cart-summary-title {
    font-size: 18px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.summary-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13.5px;
    color: #475569;
    margin-bottom: 10px;
}
.summary-line.total-line {
    border-top: 2px dashed #E2E8F0;
    margin-top: 14px;
    padding-top: 14px;
    font-size: 18px;
    font-weight: 800;
    color: #08364B;
}

/* Coupon Box */
.coupon-input-group {
    display: flex;
    gap: 8px;
    margin-bottom: 14px;
}
.coupon-input {
    flex: 1;
    height: 42px;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    padding: 0 12px;
    font-size: 13px;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
    outline: none;
}
.coupon-input:focus {
    border-color: #00A8FF;
    box-shadow: 0 0 0 2px rgba(0, 168, 255, 0.15);
}
.coupon-apply-btn {
    height: 42px;
    background: #08364B;
    color: #FFFFFF;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    padding: 0 16px;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.15s ease;
}
.coupon-apply-btn:hover {
    background: #00A8FF;
}

/* Applied Coupon Pill */
.applied-coupon-pill {
    background: #ECFDF5;
    border: 1px solid #A7F3D0;
    color: #065F46;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 12.5px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

/* Available Coupons Suggestion Tags */
.promo-tags-box {
    margin-top: 10px;
    font-size: 12px;
}
.promo-badge {
    display: inline-block;
    background: #F1F5F9;
    border: 1px dashed #94A3B8;
    color: #0F172A;
    padding: 3px 8px;
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    margin: 2px 4px 2px 0;
    transition: all 0.15s ease;
}
.promo-badge:hover {
    background: #00A8FF;
    border-color: #00A8FF;
    color: #FFFFFF;
}

/* Checkout Button */
.btn-checkout-doorstep {
    width: 100%;
    background: #059669;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 800;
    padding: 13px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
}
.btn-checkout-doorstep:hover {
    background: #047857;
    color: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(5, 150, 105, 0.4);
}

/* Empty Cart State */
.empty-cart-box {
    text-align: center;
    padding: 60px 20px;
    background: #FFFFFF;
    border: 1px dashed #CBD5E1;
    border-radius: 14px;
    margin: 20px 0;
}
.empty-cart-icon {
    font-size: 64px;
    color: #94A3B8;
    margin-bottom: 16px;
}
</style>

<!-- Header Banner -->
<div class="cart-page-header">
    <div class="container">
        <h1 class="cart-header-title"><i class="fas fa-shopping-cart" style="color: #38BDF8;"></i> My Medicine Cart</h1>
        <div class="cart-breadcrumb">
            <a href="<?=base_url();?>">Home</a> &gt; 
            <a href="<?=base_url('medical');?>">Pharmacy Network</a> &gt; 
            <span>Cart</span>
        </div>
    </div>
</div>

<div class="container" style="min-height: 520px; margin-bottom: 50px;">

    <?php if (empty($cart_items)): ?>
        <!-- Empty Cart State -->
        <div class="empty-cart-box">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <h2 style="font-size: 22px; font-weight: 800; color: #08364B; margin: 0 0 8px;">Your Medicine Cart is Empty</h2>
            <p style="font-size: 14.5px; color: #64748B; max-width: 520px; margin: 0 auto 24px;">
                You haven't added any prescription or OTC medicines yet. Search medicines across verified local pharmacies in your city and order doorstep delivery.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                <a href="<?=base_url('medical');?>" class="btn" style="background: #00A8FF; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 10px 24px; font-size: 15px;">
                    <i class="fas fa-search"></i> Browse Medicine Store
                </a>
                <button type="button" onclick="openPrescriptionModal()" class="btn" style="background: #10B981; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 10px 20px; font-size: 15px;">
                    <i class="fas fa-file-prescription"></i> Upload Doctor Rx
                </button>
            </div>
        </div>
    <?php else: ?>
        <!-- Cart Has Items -->
        <div class="row">
            <!-- Left Column: Item List -->
            <div class="col-md-8">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #08364B; margin: 0;">
                        Cart Items (<?=count($cart_items);?>)
                    </h3>
                    <a href="<?=base_url('medical');?>" style="font-size: 13px; color: #00A8FF; font-weight: 700; text-decoration: none;">
                        <i class="fas fa-plus-circle"></i> Add More Medicines
                    </a>
                </div>

                <div id="cartItemsContainer">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item-card" id="cart-item-row-<?=$item->cart_id;?>" data-cart-id="<?=$item->cart_id;?>">
                            <div class="cart-item-details">
                                <div class="cart-item-title">
                                    <?=html_escape($item->brand_name);?>
                                    <?php if ($item->is_prescription_required): ?>
                                        <span class="med-tag med-tag-rx" style="font-size: 11px; padding: 2px 7px; border-radius: 8px;">
                                            <i class="fas fa-file-prescription"></i> Rx
                                        </span>
                                    <?php else: ?>
                                        <span class="med-tag med-tag-otc" style="font-size: 11px; padding: 2px 7px; border-radius: 8px;">
                                            <i class="fas fa-check"></i> OTC
                                        </span>
                                    <?php endif; ?>
                                    <span style="font-size: 11px; background: #F1F5F9; color: #475569; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                                        <?=html_escape($item->dosage_form ?: 'Medicine');?>
                                    </span>
                                </div>

                                <div class="cart-item-meta">
                                    <i class="fas fa-flask" style="color: #94A3B8;"></i> <?=html_escape($item->generic_composition);?>
                                    <?php if (!empty($item->manufacturer)): ?>
                                        &bull; <span><?=html_escape($item->manufacturer);?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="cart-store-tag">
                                    <i class="fas fa-store"></i> Dispensing Chemist: <strong><?=html_escape($item->store_name);?></strong>
                                    (<?=html_escape($item->store_city);?>)
                                </div>
                            </div>

                            <!-- Stepper -->
                            <div class="qty-stepper-box">
                                <button type="button" class="qty-btn btn-qty-minus" data-id="<?=$item->cart_id;?>">-</button>
                                <input type="text" class="qty-input" id="qty-input-<?=$item->cart_id;?>" value="<?=$item->quantity;?>" readonly>
                                <button type="button" class="qty-btn btn-qty-plus" data-id="<?=$item->cart_id;?>">+</button>
                            </div>

                            <!-- Price & Delete -->
                            <div class="cart-item-price-block">
                                <div class="cart-item-price" id="item-total-<?=$item->cart_id;?>">
                                    &#8377;<?=number_format($item->item_total, 2);?>
                                </div>
                                <?php if ($item->unit_mrp > $item->unit_price): ?>
                                    <div class="cart-item-mrp">&#8377;<?=number_format($item->item_mrp_total, 2);?></div>
                                <?php endif; ?>
                                <div class="cart-item-unit-rate">&#8377;<?=number_format($item->unit_price, 2);?> / unit</div>
                                <button type="button" 
                                        class="btn btn-link btn-remove-item" 
                                        data-id="<?=$item->cart_id;?>" 
                                        style="color: #EF4444; font-size: 12px; padding: 4px 0 0; text-decoration: none;">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Prescription Notice Banner -->
                <?php if ($summary['has_rx_required']): ?>
                    <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 10px; padding: 14px 16px; margin-top: 18px; font-size: 13px; color: #92400E; display: flex; align-items: flex-start; gap: 10px;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 18px; color: #D97706; margin-top: 2px;"></i>
                        <div>
                            <strong>Prescription Verification Required:</strong> One or more medicines in your cart require a valid doctor's prescription. Our dispensing pharmacist will verify your prescription prior to dispatch.
                            <a href="javascript:void(0);" onclick="openPrescriptionModal()" style="color: #0284C7; font-weight: 700; text-decoration: underline; margin-left: 4px;">Upload Rx Now</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Coupon & Order Summary -->
            <div class="col-md-4">
                <div class="cart-summary-box">
                    <h3 class="cart-summary-title">
                        <span>Payment Summary</span>
                        <i class="fas fa-receipt" style="color: #00A8FF;"></i>
                    </h3>

                    <!-- Coupon Section -->
                    <div style="margin-bottom: 18px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #475569; margin-bottom: 6px;">
                            <i class="fas fa-tag" style="color: #059669;"></i> Apply Promo / Coupon Code
                        </label>

                        <?php if (!empty($summary['applied_coupon']) && $summary['applied_coupon']['valid']): ?>
                            <div class="applied-coupon-pill" id="appliedCouponDisplay">
                                <div>
                                    <i class="fas fa-check-circle" style="color: #059669;"></i> 
                                    <strong><?=html_escape($summary['applied_coupon']['coupon_code']);?></strong> Applied
                                    <div style="font-size: 11px; color: #047857;">Saved &#8377;<?=number_format($summary['applied_coupon']['discount_amount'], 2);?></div>
                                </div>
                                <button type="button" class="btn btn-link btn-xs" id="btnRemoveCoupon" style="color: #EF4444; font-weight: 700; text-decoration: none;">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="coupon-input-group" id="couponInputGroup">
                                <input type="text" id="couponCodeInput" class="coupon-input" placeholder="e.g. UPCHAR10, MED10">
                                <button type="button" id="btnApplyCoupon" class="coupon-apply-btn">Apply</button>
                            </div>
                        <?php endif; ?>

                        <div id="couponFeedbackMessage" style="display: none; font-size: 12px; margin-bottom: 8px;"></div>

                        <!-- Available Coupons -->
                        <?php if (!empty($available_coupons)): ?>
                            <div class="promo-tags-box">
                                <span style="color: #64748B; font-weight: 600;">Available Offers:</span>
                                <?php foreach ($available_coupons as $cp): ?>
                                    <span class="promo-badge" onclick="selectPromo('<?=$cp->coupon_code;?>')" title="<?=html_escape($cp->description);?>">
                                        <?=$cp->coupon_code;?> (<?=($cp->discount_type === 'PERCENTAGE') ? $cp->discount_value . '% OFF' : '₹' . $cp->discount_value . ' OFF';?>)
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Financial Summary Lines -->
                    <div class="summary-line">
                        <span>Items MRP Total</span>
                        <span id="summaryMrpTotal">&#8377;<?=number_format($summary['mrp_total'], 2);?></span>
                    </div>

                    <?php if ($summary['retail_savings'] > 0): ?>
                        <div class="summary-line" style="color: #059669;">
                            <span>Retail Chemist Discount</span>
                            <span id="summarySavings">-&#8377;<?=number_format($summary['retail_savings'], 2);?></span>
                        </div>
                    <?php endif; ?>

                    <div class="summary-line">
                        <span>Medicine Subtotal</span>
                        <span id="summarySubtotal">&#8377;<?=number_format($summary['subtotal'], 2);?></span>
                    </div>

                    <div class="summary-line">
                        <span>Estimated Tax (5% GST)</span>
                        <span id="summaryTax">&#8377;<?=number_format($summary['tax'], 2);?></span>
                    </div>

                    <div class="summary-line">
                        <span>Delivery Fee</span>
                        <span id="summaryDelivery">
                            <?=$summary['delivery_fee'] > 0 ? '&#8377;' . number_format($summary['delivery_fee'], 2) : '<span style="color: #059669; font-weight: 700;">FREE</span>';?>
                        </span>
                    </div>

                    <div class="summary-line" id="discountSummaryLine" style="<?=($summary['discount'] > 0) ? 'display: flex;' : 'display: none;';?> color: #059669; font-weight: 700;">
                        <span>Coupon Savings</span>
                        <span id="summaryDiscount">-&#8377;<?=number_format($summary['discount'], 2);?></span>
                    </div>

                    <div class="summary-line total-line">
                        <span>Total Payable</span>
                        <span id="summaryGrandTotal" style="color: #059669;">&#8377;<?=number_format($summary['grand_total'], 2);?></span>
                    </div>

                    <!-- Checkout Trigger Button -->
                    <div style="margin-top: 20px;">
                        <button type="button" class="btn-checkout-doorstep" onclick="proceedToCheckoutModal()">
                            <i class="fas fa-lock"></i> Proceed to Doorstep Checkout
                        </button>
                    </div>

                    <!-- Trust Points -->
                    <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid #F1F5F9; font-size: 11.5px; color: #64748B; line-height: 1.5;">
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                            <i class="fas fa-shield-alt" style="color: #00A8FF;"></i> 100% Genuine Medicines from Verified Chemists
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-money-bill-wave" style="color: #10B981;"></i> Cash on Delivery &amp; UPI Available
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Include UPCHAR Medicine & Prescription Modals Suite -->
<?php include(APPPATH . 'views/modals/medicine_order_modals.php'); ?>

<script>
// Quick Promo Code Selector
function selectPromo(code) {
    const input = document.getElementById('couponCodeInput');
    if (input) {
        input.value = code;
        applyCouponAjax(code);
    }
}

// Apply Coupon Event
$(document).on('click', '#btnApplyCoupon', function() {
    const code = $('#couponCodeInput').val().trim();
    if (!code) {
        alert('Please enter a coupon code.');
        return;
    }
    applyCouponAjax(code);
});

// Remove Coupon Event
$(document).on('click', '#btnRemoveCoupon', function() {
    $.ajax({
        url: '<?=base_url("cart/remove_coupon");?>',
        type: 'POST',
        dataType: 'json',
        success: function(resp) {
            window.location.reload();
        }
    });
});

function applyCouponAjax(code) {
    const btn = $('#btnApplyCoupon');
    const originalText = btn.text();
    btn.prop('disabled', true).text('Applying...');

    $.ajax({
        url: '<?=base_url("cart/apply_coupon");?>',
        type: 'POST',
        data: { coupon_code: code },
        dataType: 'json',
        success: function(resp) {
            btn.prop('disabled', false).text(originalText);
            if (resp.status === 'success') {
                window.location.reload();
            } else {
                $('#couponFeedbackMessage')
                    .css('color', '#EF4444')
                    .text(resp.message || 'Invalid coupon code.')
                    .fadeIn();
            }
        },
        error: function() {
            btn.prop('disabled', false).text(originalText);
            alert('Network error while applying coupon.');
        }
    });
}

// Quantity Adjusters (+ / -)
$(document).on('click', '.btn-qty-plus', function() {
    const cartId = $(this).data('id');
    const input = $('#qty-input-' + cartId);
    let val = parseInt(input.val(), 10) || 1;
    val += 1;
    input.val(val);
    updateCartItemQty(cartId, val);
});

$(document).on('click', '.btn-qty-minus', function() {
    const cartId = $(this).data('id');
    const input = $('#qty-input-' + cartId);
    let val = parseInt(input.val(), 10) || 1;
    val -= 1;
    if (val <= 0) {
        if (confirm('Do you want to remove this medicine from your cart?')) {
            removeCartItem(cartId);
        }
        return;
    }
    input.val(val);
    updateCartItemQty(cartId, val);
});

function updateCartItemQty(cartId, qty) {
    $.ajax({
        url: '<?=base_url("cart/update_quantity");?>',
        type: 'POST',
        data: { cart_id: cartId, quantity: qty },
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                updateTotalsOnUI(resp.summary, cartId);
            }
        }
    });
}

// Remove item
$(document).on('click', '.btn-remove-item', function() {
    const cartId = $(this).data('id');
    if (confirm('Are you sure you want to remove this item?')) {
        removeCartItem(cartId);
    }
});

function removeCartItem(cartId) {
    $.ajax({
        url: '<?=base_url("cart/remove_item");?>',
        type: 'POST',
        data: { cart_id: cartId },
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                $('#cart-item-row-' + cartId).fadeOut(250, function() {
                    $(this).remove();
                    if ($('.cart-item-card').length === 0) {
                        window.location.reload();
                    } else {
                        updateTotalsOnUI(resp.summary, null);
                    }
                });
            }
        }
    });
}

function updateTotalsOnUI(summary, changedCartId) {
    if (!summary) return;

    if (changedCartId && summary.items) {
        summary.items.forEach(function(it) {
            if (it.cart_id == changedCartId) {
                $('#item-total-' + changedCartId).html('&#8377;' + parseFloat(it.item_total).toFixed(2));
            }
        });
    }

    $('#summaryMrpTotal').html('&#8377;' + parseFloat(summary.mrp_total).toFixed(2));
    $('#summarySubtotal').html('&#8377;' + parseFloat(summary.subtotal).toFixed(2));
    $('#summaryTax').html('&#8377;' + parseFloat(summary.tax).toFixed(2));
    $('#summaryGrandTotal').html('&#8377;' + parseFloat(summary.grand_total).toFixed(2));

    if (summary.retail_savings > 0) {
        $('#summarySavings').html('-&#8377;' + parseFloat(summary.retail_savings).toFixed(2));
    }

    if (summary.delivery_fee > 0) {
        $('#summaryDelivery').html('&#8377;' + parseFloat(summary.delivery_fee).toFixed(2));
    } else {
        $('#summaryDelivery').html('<span style="color: #059669; font-weight: 700;">FREE</span>');
    }

    if (summary.discount > 0) {
        $('#discountSummaryLine').show();
        $('#summaryDiscount').html('-&#8377;' + parseFloat(summary.discount).toFixed(2));
    } else {
        $('#discountSummaryLine').hide();
    }
}
</script>

<!-- Dedicated Cart Doorstep Checkout & Payment Modal -->
<div class="modal fade" id="cartCheckoutPaymentModal" tabindex="-1" role="dialog" aria-labelledby="cartCheckoutModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 560px;">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.18);">
            <div class="modal-header" style="background: linear-gradient(135deg, #08364B 0%, #0c4a6e 100%); color: #FFFFFF; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFFFFF; opacity: 0.85; font-size: 26px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cartCheckoutModalLabel" style="font-weight: 800; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shield-alt" style="color: #38BDF8;"></i> Doorstep Checkout &amp; Payment
                </h4>
                <div style="font-size: 12px; color: #BAE6FD; margin-top: 4px;">
                    Fast local dispatch from licensed pharmacy with verified OTP &amp; QR doorstep delivery
                </div>
            </div>
            
            <div class="modal-body" style="padding: 22px 24px; background: #F8FAFC;">
                <!-- Store & Total Badge -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 16px; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748B; letter-spacing: 0.5px;">Dispensing Pharmacy</div>
                        <div style="font-weight: 800; font-size: 14px; color: #08364B;">
                            <i class="fas fa-store" style="color: #0284C7;"></i> <?=html_escape(!empty($cart_items[0]->store_name) ? $cart_items[0]->store_name : 'Apex Care Medicos & Chemist');?>
                        </div>
                        <div style="font-size: 12px; color: #64748B;">
                            <?=html_escape(!empty($cart_items[0]->store_city) ? $cart_items[0]->store_city : 'Varanasi');?> &bull; <?=count($cart_items);?> item(s) in cart
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 11px; color: #64748B; font-weight: 600;">Total Payable</div>
                        <div style="font-size: 20px; font-weight: 900; color: #059669;" id="modalPayableAmount">
                            &#8377;<?=number_format($summary['grand_total'], 2);?>
                        </div>
                    </div>
                </div>

                <!-- Patient & Delivery Details Form -->
                <form id="cartCheckoutForm" onsubmit="return false;">
                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">
                                Patient Name <span style="color: #EF4444;">*</span>
                            </label>
                            <input type="text" id="chkCustomerName" class="form-control" placeholder="Full Name" value="<?=html_escape($user_profile['name'] ?? 'Patient');?>" required style="border-radius: 8px; height: 40px; font-size: 13.5px;">
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">
                                Contact Mobile (for Delivery OTP) <span style="color: #EF4444;">*</span>
                            </label>
                            <input type="tel" id="chkCustomerPhone" class="form-control" placeholder="10-digit mobile" value="<?=html_escape(!empty($user_profile['phone']) ? $user_profile['phone'] : '9876543210');?>" maxlength="10" required style="border-radius: 8px; height: 40px; font-size: 13.5px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">
                            Doorstep Delivery Address <span style="color: #EF4444;">*</span>
                        </label>
                        <textarea id="chkDeliveryAddress" class="form-control" rows="2" placeholder="House/Flat No., Landmark, Street, Colony, City" required style="border-radius: 8px; font-size: 13.5px; resize: none;">Sigra / Luxa Road, Varanasi, Uttar Pradesh - 221001</textarea>
                    </div>

                    <!-- Payment Mode Selection -->
                    <div style="margin-bottom: 16px;">
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;">
                            Select Payment Method
                        </label>
                        
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; gap: 12px; background: #FFFFFF; border: 2px solid #10B981; border-radius: 10px; padding: 12px 14px; margin: 0; cursor: pointer; transition: all 0.2s;" id="labelPayCOD">
                                <input type="radio" name="cart_payment_mode" value="COD" checked style="accent-color: #10B981; transform: scale(1.2);">
                                <div style="flex: 1;">
                                    <div style="font-weight: 800; font-size: 13.5px; color: #065F46; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-hand-holding-usd" style="color: #10B981;"></i> Cash on Delivery (COD) / UPI QR at Doorstep
                                        <span class="badge" style="background: #10B981; font-size: 10px; margin-left: auto;">RECOMMENDED</span>
                                    </div>
                                    <div style="font-size: 11.5px; color: #047857; margin-top: 2px;">
                                        Pay via Cash, GPay, PhonePe or Paytm to the delivery partner upon arrival.
                                    </div>
                                </div>
                            </label>

                            <label style="display: flex; align-items: center; gap: 12px; background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 10px; padding: 12px 14px; margin: 0; cursor: pointer; transition: all 0.2s;" id="labelPayOnline">
                                <input type="radio" name="cart_payment_mode" value="ONLINE" style="accent-color: #00A8FF; transform: scale(1.2);">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; font-size: 13.5px; color: #1E293B; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-credit-card" style="color: #0284C7;"></i> Online Payment (UPI / Credit &amp; Debit Cards / NetBanking)
                                    </div>
                                    <div style="font-size: 11.5px; color: #64748B; margin-top: 2px;">
                                        Instant 256-bit encrypted checkout via Razorpay / Upchar Pay.
                                    </div>
                                </div>
                            </label>

                            <label style="display: flex; align-items: center; gap: 12px; background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 10px; padding: 12px 14px; margin: 0; cursor: pointer; transition: all 0.2s;" id="labelPayWallet">
                                <input type="radio" name="cart_payment_mode" value="WALLET" style="accent-color: #8B5CF6; transform: scale(1.2);">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; font-size: 13.5px; color: #1E293B; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-wallet" style="color: #8B5CF6;"></i> Upchar Health Wallet
                                    </div>
                                    <div style="font-size: 11.5px; color: #64748B; margin-top: 2px;">
                                        Instant 1-click deduction from your Upchar wallet balance.
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>

                <div id="checkoutErrorAlert" style="display: none; background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; border-radius: 8px; padding: 10px 14px; font-size: 12.5px; margin-bottom: 12px;"></div>
            </div>

            <div class="modal-footer" style="background: #FFFFFF; border-top: 1px solid #E2E8F0; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 600; border-radius: 8px;">Cancel</button>
                <button type="button" class="btn" id="btnSubmitCartCheckout" onclick="submitCartOrderCheckout()" style="background: #059669; color: #FFFFFF; font-weight: 800; border-radius: 8px; padding: 10px 24px; font-size: 14.5px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35); border: none;">
                    <i class="fas fa-check-circle"></i> Place Order &amp; Dispatch Rider
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Radio border highlight styling
$(document).on('change', 'input[name="cart_payment_mode"]', function() {
    $('#labelPayCOD, #labelPayOnline, #labelPayWallet').css({
        'border-color': '#CBD5E1',
        'border-width': '1px'
    });
    $(this).closest('label').css({
        'border-color': '#10B981',
        'border-width': '2px'
    });
});

// Proceed to Checkout Handler
function proceedToCheckoutModal() {
    <?php if (!empty($cart_items)): ?>
        $('#checkoutErrorAlert').hide();
        $('#cartCheckoutPaymentModal').modal('show');
    <?php else: ?>
        alert('Your cart is empty. Please add medicines first.');
    <?php endif; ?>
}

// Submit Cart Order & Initiate Doorstep Delivery
function submitCartOrderCheckout() {
    const custName = $('#chkCustomerName').val().trim();
    const custPhone = $('#chkCustomerPhone').val().trim();
    const address = $('#chkDeliveryAddress').val().trim();
    const paymentMode = $('input[name="cart_payment_mode"]:checked').val() || 'COD';

    if (!custName) {
        showCheckoutError('Please enter the patient / recipient name.');
        $('#chkCustomerName').focus();
        return;
    }

    if (!custPhone || custPhone.length < 10) {
        showCheckoutError('Please enter a valid 10-digit mobile number for delivery OTP verification.');
        $('#chkCustomerPhone').focus();
        return;
    }

    if (!address) {
        showCheckoutError('Please provide a complete doorstep delivery address.');
        $('#chkDeliveryAddress').focus();
        return;
    }

    const $btn = $('#btnSubmitCartCheckout');
    const origHtml = $btn.html();
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing &amp; Assigning Rider...');
    $('#checkoutErrorAlert').hide();

    $.ajax({
        url: '<?=base_url("cart/checkout");?>',
        type: 'POST',
        data: {
            customer_name: custName,
            customer_phone: custPhone,
            delivery_address: address,
            payment_mode: paymentMode
        },
        dataType: 'json',
        success: function(resp) {
            if (typeof resp === 'string') {
                try { resp = JSON.parse(resp); } catch(e) {}
            }

            if (resp && resp.status === 'success') {
                $btn.html('<i class="fas fa-check"></i> Order Confirmed!');
                
                // Show toast notification
                if (typeof showOrderToast === 'function') {
                    showOrderToast(
                        'Order Placed Successfully! 🎉',
                        'Order #' + resp.order_code + ' created.<br>Doorstep Delivery OTP: <strong>' + resp.delivery_otp + '</strong>',
                        'success'
                    );
                }

                // Redirect to Live Order Tracking Page
                setTimeout(function() {
                    window.location.href = resp.redirect_url || ('<?=base_url("cart/order/");?>' + resp.order_id);
                }, 800);
            } else if (resp && resp.status === 'auth_required') {
                $btn.prop('disabled', false).html(origHtml);
                window.location.href = resp.redirect_url || '<?=base_url("login");?>';
            } else {
                $btn.prop('disabled', false).html(origHtml);
                const errMsg = (resp && resp.message) ? resp.message : 'Unable to complete checkout. Please try again.';
                showCheckoutError(errMsg);
            }
        },
        error: function(xhr) {
            $btn.prop('disabled', false).html(origHtml);
            let errMsg = 'Network or server error while placing order.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errMsg = xhr.responseJSON.message;
            }
            showCheckoutError(errMsg);
        }
    });
}

function showCheckoutError(msg) {
    $('#checkoutErrorAlert').html('<i class="fas fa-exclamation-circle"></i> ' + msg).slideDown(200);
}
</script>

<?php include('includes/footer.php'); ?>

