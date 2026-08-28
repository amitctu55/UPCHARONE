<?php include ('includes/header.php'); ?>

<!-- Compact Diagnostic Tests & Cart Design -->
<style>
:root {
    --primary-color: #00a896;
    --primary-hover: #028090;
    --bg-color: #f8fafc;
    --card-bg: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --radius: 10px;
}

body {
    background-color: var(--bg-color);
    color: var(--text-main);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Compact Search Bar Header */
.hero-section {
    background: linear-gradient(135deg, #028090 0%, #00a896 100%);
    color: white;
    padding: 28px 16px 32px 16px;
    text-align: center;
}

.hero-section h1 {
    font-size: 1.5rem;
    margin-bottom: 4px;
    font-weight: 800;
    color: #ffffff;
}

.hero-section p {
    font-size: 0.9rem;
    opacity: 0.92;
    margin-bottom: 18px;
    color: #f0fdfa;
}

.search-container-compact {
    max-width: 780px;
    margin: 0 auto;
    display: flex;
    gap: 8px;
    background: white;
    padding: 6px 8px;
    border-radius: 30px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    align-items: center;
}

.search-input-compact {
    flex: 1;
    border: none;
    padding: 8px 14px;
    font-size: 0.88rem;
    outline: none;
    color: #1e293b;
    background: transparent;
}

.search-select-compact {
    border: none;
    border-right: 1px solid #e2e8f0;
    padding: 8px 14px;
    font-size: 0.85rem;
    outline: none;
    color: #334155;
    background: transparent;
    max-width: 180px;
}

.search-btn-compact {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 9px 22px;
    border-radius: 24px;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    transition: background 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.search-btn-compact:hover {
    background-color: var(--primary-hover);
    color: white;
}

/* Tab Navigation */
.tab-pills-row {
    display: flex;
    gap: 10px;
    margin: 20px 0 16px 0;
    overflow-x: auto;
    padding-bottom: 6px;
}

.tab-pill-btn {
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.84rem;
    color: #475569;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.tab-pill-btn:hover {
    color: var(--primary-color);
    border-color: var(--primary-color);
    background: #f0fdfa;
}

.tab-pill-btn.active {
    background: var(--primary-color);
    color: #ffffff !important;
    border-color: var(--primary-color);
    box-shadow: 0 3px 10px rgba(0, 168, 150, 0.25);
}

.tab-pill-btn .count-badge {
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
    padding: 1px 7px;
    border-radius: 10px;
    font-size: 0.72rem;
}

.tab-pill-btn.active .count-badge {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

/* Compact Container & Grid */
.compact-main-container {
    max-width: 1180px;
    margin: 20px auto 40px auto;
    padding: 0 16px;
}

.section-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

/* Grid Layout */
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 18px;
}

/* Compact Reframed Card */
.compact-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.compact-card:hover {
    border-color: var(--primary-color);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.12);
    transform: translateY(-2px);
}

.card-header-compact {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
}

.center-info h3 {
    font-size: 1rem;
    color: var(--text-main);
    font-weight: 700;
    margin: 0 0 3px 0;
    line-height: 1.35;
}

.center-info span {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 5px;
}

.badge-tag-custom {
    background-color: #e6fffa;
    color: #047857;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 12px;
    white-space: nowrap;
    border: 1px solid #ccfbf1;
}

.test-list-compact {
    list-style: none;
    margin: 10px 0;
    border-top: 1px dotted var(--border-color);
    border-bottom: 1px dotted var(--border-color);
    padding: 8px 0;
}

.test-item-compact {
    font-size: 0.82rem;
    color: var(--text-muted);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
}

.test-item-compact:last-child {
    margin-bottom: 0;
}

.test-item-compact i {
    color: var(--primary-color);
    font-size: 0.75rem;
}

.card-footer-compact {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
    padding-top: 6px;
}

.price-tag-compact {
    display: flex;
    flex-direction: column;
}

.price-compact {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-main);
}

.cashback-compact {
    font-size: 0.72rem;
    color: #059669;
    font-weight: 600;
}

.action-btn-compact {
    background-color: var(--primary-color);
    color: white !important;
    text-decoration: none !important;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    transition: background 0.2s;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.action-btn-compact:hover {
    background-color: var(--primary-hover);
    box-shadow: 0 3px 10px rgba(0, 168, 150, 0.3);
}

.action-btn-compact.in-cart {
    background-color: #047857;
}

@media (max-width: 640px) {
    .search-container-compact {
        flex-direction: column;
        border-radius: 14px;
        padding: 10px;
    }
    .search-select-compact {
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
        max-width: 100%;
        width: 100%;
    }
    .search-input-compact, .search-btn-compact {
        width: 100%;
        border-radius: 8px;
    }
}
</style>

<!-- Header Section -->
<div class="hero-section">
    <h1>Pathology Centers &amp; Diagnostic Packages</h1>
    <p>Book verified lab tests near you with doorstep sample collection</p>
    
    <form class="search-container-compact" action="<?=base_url('mytest');?>" method="GET">
        <input type="hidden" name="tab" value="<?=html_escape($active_tab);?>">
        
        <select name="city" class="search-select-compact">
            <option value="">All Cities</option>
            <?php if (!empty($cities)): ?>
                <?php foreach ($cities as $c): ?>
                    <option value="<?=html_escape($c->id);?>" <?=($selected_city == $c->id) ? 'selected' : '';?>>
                        <?=html_escape($c->name);?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <input type="text" name="keyword" class="search-input-compact" placeholder="Search Pathology or Test (CBC, Thyroid, Lipid...)" value="<?=html_escape($keyword);?>">
        
        <button type="submit" class="search-btn-compact">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>

<!-- Compact Cards Section -->
<div class="compact-main-container">
    
    <!-- Tab Filter Switcher -->
    <div class="tab-pills-row">
        <a href="<?=base_url('mytest?tab=tests' . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-pill-btn <?=($active_tab == 'tests') ? 'active' : '';?>">
            <i class="fas fa-flask"></i> Diagnostic Tests
            <span class="count-badge"><?=$total_tests_count;?></span>
        </a>
        <a href="<?=base_url('mytest?tab=packages' . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-pill-btn <?=($active_tab == 'packages') ? 'active' : '';?>">
            <i class="fas fa-heartbeat"></i> Health Packages
            <span class="count-badge"><?=$total_packages_count;?></span>
        </a>
        <a href="<?=base_url('mytest?tab=labs' . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-pill-btn <?=($active_tab == 'labs') ? 'active' : '';?>">
            <i class="fas fa-hospital-alt"></i> Pathology Centers
            <span class="count-badge"><?=$total_labs_count;?></span>
        </a>
    </div>

    <!-- Section Header -->
    <div class="section-header-row">
        <h2 class="section-title">
            <?php if ($active_tab == 'tests'): ?>
                Available Diagnostic Blood Tests (<?=$total_tests_count;?>)
            <?php elseif ($active_tab == 'packages'): ?>
                Preventive Health Checkup Packages (<?=$total_packages_count;?>)
            <?php else: ?>
                Available Diagnostic Laboratories (<?=$total_labs_count;?>)
            <?php endif; ?>
        </h2>

        <?php if (!empty($selected_city) || !empty($keyword)): ?>
            <a href="<?=base_url('mytest?tab='.$active_tab);?>" style="font-size: 0.8rem; color: #0284c7; font-weight: 700; text-decoration: underline;">
                &times; Clear Filters
            </a>
        <?php endif; ?>
    </div>

    <!-- TAB 1: DIAGNOSTIC TESTS WITH ADD TO CART -->
    <?php if ($active_tab == 'tests'): ?>
        <div class="grid-container">
            <?php if (!empty($all_tests)): ?>
                <?php foreach ($all_tests as $test): ?>
                    <?php $in_cart = isset($cart[$test->test_id]); ?>
                    <div class="compact-card">
                        <div>
                            <div class="card-header-compact">
                                <div class="center-info">
                                    <h3><?=html_escape($test->test_name);?></h3>
                                    <span><i class="fas fa-hospital"></i> <?=html_escape($test->lab_name);?> (<?=html_escape($test->city_name ?: 'Partner');?>)</span>
                                </div>
                                <span class="badge-tag-custom"><?=html_escape($test->category_name ?: 'Diagnostic');?></span>
                            </div>

                            <ul class="test-list-compact">
                                <li class="test-item-compact">
                                    <span><i class="fas fa-tint" style="color: #ef4444;"></i> Sample:</span>
                                    <strong><?=html_escape($test->test_type ?: 'Blood');?></strong>
                                </li>
                                <li class="test-item-compact">
                                    <span><i class="fas fa-clock" style="color: #0284c7;"></i> Report:</span>
                                    <strong><?=html_escape($test->report_day ?: 'Same Day');?></strong>
                                </li>
                                <li class="test-item-compact">
                                    <span><i class="fas fa-barcode"></i> Code:</span>
                                    <strong><?=html_escape($test->code ?: 'UPC-'.$test->test_id);?></strong>
                                </li>
                            </ul>
                        </div>

                        <div class="card-footer-compact">
                            <div class="price-tag-compact">
                                <span class="price-compact">₹<?=number_format($test->amount);?></span>
                                <span class="cashback-compact"><i class="fas fa-home"></i> Free Home Collection</span>
                            </div>
                            <button type="button" class="action-btn-compact btn-cart-toggle <?=$in_cart ? 'in-cart' : '';?>" 
                                data-test-id="<?=$test->test_id;?>">
                                <?=$in_cart ? '<i class="fas fa-check"></i> Added' : '<i class="fas fa-shopping-cart"></i> Add to Cart';?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- TAB 2: HEALTH PACKAGES -->
    <?php if ($active_tab == 'packages'): ?>
        <div class="grid-container">
            <?php if (!empty($packages)): ?>
                <?php foreach ($packages as $pkg): ?>
                    <?php $in_cart = isset($cart[$pkg->test_id]); ?>
                    <div class="compact-card" style="border: 2px solid #ccfbf1;">
                        <div>
                            <div class="card-header-compact">
                                <div class="center-info">
                                    <h3><?=html_escape($pkg->test_name);?></h3>
                                    <span><i class="fas fa-hospital"></i> <?=html_escape($pkg->lab_name);?></span>
                                </div>
                                <span class="badge-tag-custom" style="background: #fef08a; color: #854d0e;">Featured</span>
                            </div>

                            <ul class="test-list-compact">
                                <li class="test-item-compact"><i class="fas fa-check"></i> Complete Hemogram (CBC)</li>
                                <li class="test-item-compact"><i class="fas fa-check"></i> Liver &amp; Kidney Screening</li>
                                <li class="test-item-compact"><i class="fas fa-check"></i> Lipid &amp; Fasting Glucose</li>
                            </ul>
                        </div>

                        <div class="card-footer-compact">
                            <div class="price-tag-compact">
                                <span class="price-compact">₹<?=number_format($pkg->amount);?></span>
                                <span class="cashback-compact"><i class="fas fa-home"></i> Free Home Collection</span>
                            </div>
                            <button type="button" class="action-btn-compact btn-cart-toggle <?=$in_cart ? 'in-cart' : '';?>" 
                                data-test-id="<?=$pkg->test_id;?>">
                                <?=$in_cart ? '<i class="fas fa-check"></i> Added' : '<i class="fas fa-shopping-cart"></i> Add to Cart';?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- TAB 3: PATHOLOGY CENTERS -->
    <?php if ($active_tab == 'labs'): ?>
        <div class="grid-container">
            <?php if (!empty($pathologies)): ?>
                <?php foreach ($pathologies as $lab): ?>
                    <div class="compact-card">
                        <div>
                            <div class="card-header-compact">
                                <div class="center-info">
                                    <h3><?=html_escape($lab->name);?></h3>
                                    <span><i class="fas fa-map-marker-alt" style="color: #ef4444;"></i> <?=html_escape($lab->city_name ?: 'Varanasi');?></span>
                                </div>
                                <span class="badge-tag-custom">Verified Lab</span>
                            </div>

                            <ul class="test-list-compact">
                                <li class="test-item-compact"><i class="fas fa-check"></i> Free Home Sample Pickup</li>
                                <li class="test-item-compact"><i class="fas fa-check"></i> 6-12 Hrs Digital PDF Reports</li>
                                <li class="test-item-compact"><i class="fas fa-check"></i> NABL / ISO Certified Testing</li>
                            </ul>
                        </div>

                        <div class="card-footer-compact">
                            <div class="price-tag-compact">
                                <span class="price-compact">Starts @ ₹<?=number_format($lab->starting_price);?></span>
                                <span class="cashback-compact"><i class="fas fa-home"></i> Free Pickup</span>
                            </div>
                            <a href="<?=base_url('mytest?tab=tests&keyword='.urlencode($lab->name));?>" class="action-btn-compact">
                                View Tests
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<!-- Floating Cart Trigger Pill -->
<div class="floating-cart-bar" id="floatingCartBtn" style="<?=empty($cart) ? 'display:none;' : '';?> position: fixed; bottom: 24px; right: 24px; z-index: 1050; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border: 1.5px solid #00a896; color: #ffffff; border-radius: 40px; padding: 10px 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); display: flex; align-items: center; gap: 14px; cursor: pointer;">
    <i class="fas fa-shopping-cart" style="font-size: 16px; color: #5eead4;"></i>
    <span style="font-weight: 700; font-size: 13.5px;">
        <span class="cart-total-items"><?=count($cart);?></span> Tests Selected
    </span>
    <span style="font-weight: 800; font-size: 14px; color: #5eead4;">
        ₹<span class="cart-total-amount"><?=number_format(array_sum(array_column($cart, 'amount')));?></span>
    </span>
    <span style="background: #00a896; color: #ffffff; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 16px;">
        View Cart &rarr;
    </span>
</div>

<!-- Slide-out Cart Drawer -->
<div class="cart-drawer-overlay" id="cartOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1060; display: none;"></div>
<div class="cart-drawer-panel" id="cartDrawer" style="position: fixed; top: 0; right: -420px; width: 380px; max-width: 90%; height: 100%; background: #ffffff; z-index: 1070; box-shadow: -8px 0 30px rgba(0,0,0,0.15); transition: right 0.3s ease; display: flex; flex-direction: column;">
    
    <div style="background: #0f172a; color: #ffffff; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-shopping-bag" style="color: #00a896; font-size: 18px;"></i>
            <h4 style="font-size: 15px; font-weight: 800; margin: 0; color: #ffffff;">Pathology Test Cart</h4>
        </div>
        <button type="button" id="btnCloseDrawer" style="background: none; border: none; color: #94a3b8; font-size: 22px; cursor: pointer; line-height: 1;">&times;</button>
    </div>

    <div id="drawerCartItems" style="flex-grow: 1; overflow-y: auto; padding: 16px 18px;">
        <!-- Dynamic items -->
    </div>

    <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 18px;">
        <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #64748b; margin-bottom: 6px;">
            <span>Sample Pickup:</span>
            <span style="color: #16a34a; font-weight: 700;">FREE (₹0)</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: baseline; font-size: 14.5px; font-weight: 800; color: #0f172a; margin-bottom: 14px;">
            <span>Total Payable:</span>
            <span style="font-size: 20px; color: #00a896;">₹<span class="cart-total-amount"><?=number_format(array_sum(array_column($cart, 'amount')));?></span></span>
        </div>
        <a href="<?=base_url('mytest/checkout');?>" class="action-btn-compact" style="width: 100%; justify-content: space-between; display: flex; align-items: center; padding: 11px 18px; font-weight: 800; font-size: 14px; border-radius: 8px;">
            <span>Proceed to Checkout</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>

<!-- Cart Scripts Integration -->
<script>
$(document).ready(function() {

    $('#floatingCartBtn').on('click', function() {
        refreshCartDrawer();
        $('#cartOverlay').fadeIn(200);
        $('#cartDrawer').css('right', '0');
    });

    $('#btnCloseDrawer, #cartOverlay').on('click', function() {
        $('#cartDrawer').css('right', '-420px');
        $('#cartOverlay').fadeOut(200);
    });

    $(document).on('click', '.btn-cart-toggle', function(e) {
        e.preventDefault();
        var btn = $(this);
        var testId = btn.data('test-id');

        if (btn.hasClass('in-cart')) {
            $.post('<?=base_url("mytest/remove_from_cart");?>', { test_id: testId }, function(res) {
                btn.removeClass('in-cart').html('<i class="fas fa-shopping-cart"></i> Add to Cart');
                updateCartUI(res);
            }, 'json');
        } else {
            btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
            $.post('<?=base_url("mytest/add_to_cart");?>', { test_id: testId }, function(res) {
                if (res.status === 'success') {
                    btn.addClass('in-cart').html('<i class="fas fa-check"></i> Added');
                    updateCartUI(res);
                    refreshCartDrawer();
                    $('#cartOverlay').fadeIn(200);
                    $('#cartDrawer').css('right', '0');
                }
            }, 'json');
        }
    });

    $(document).on('click', '.btn-drawer-remove', function() {
        var testId = $(this).data('test-id');
        $.post('<?=base_url("mytest/remove_from_cart");?>', { test_id: testId }, function(res) {
            $('.btn-cart-toggle[data-test-id="' + testId + '"]').removeClass('in-cart').html('<i class="fas fa-shopping-cart"></i> Add to Cart');
            updateCartUI(res);
            refreshCartDrawer();
        }, 'json');
    });

    function updateCartUI(res) {
        if (res.cart_count > 0) {
            $('.cart-total-items').text(res.cart_count);
            $('.cart-total-amount').text(Number(res.subtotal).toLocaleString());
            $('#floatingCartBtn').fadeIn(200);
        } else {
            $('#floatingCartBtn').fadeOut(200);
            $('#cartDrawer').css('right', '-420px');
            $('#cartOverlay').fadeOut(200);
        }
    }

    function refreshCartDrawer() {
        $.getJSON('<?=base_url("mytest/get_cart");?>', function(res) {
            if (res.cart_items && res.cart_items.length > 0) {
                var html = '';
                $.each(res.cart_items, function(idx, item) {
                    html += '<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">' +
                        '<div>' +
                        '<div style="font-weight: 700; font-size: 13.5px; color: #0f172a; margin-bottom: 2px;">' + item.test_name + '</div>' +
                        '<div style="font-size: 11.5px; color: #64748b;"><i class="fas fa-hospital"></i> ' + item.lab_name + '</div>' +
                        '<div style="font-size: 11.5px; color: #0284c7; margin-top: 3px;"><i class="fas fa-tint"></i> ' + item.sample_type + ' &bull; ' + item.report_time + '</div>' +
                        '</div>' +
                        '<div style="text-align: right; flex-shrink: 0;">' +
                        '<div style="font-weight: 800; font-size: 14px; color: #00a896;">₹' + Number(item.amount).toLocaleString() + '</div>' +
                        '<button type="button" class="btn-drawer-remove" data-test-id="' + item.test_id + '" style="background: none; border: none; color: #ef4444; font-size: 11.5px; font-weight: 600; cursor: pointer; padding: 2px 0;">&times; Remove</button>' +
                        '</div>' +
                        '</div>';
                });
                $('#drawerCartItems').html(html);
                $('.cart-total-amount').text(Number(res.subtotal).toLocaleString());
            } else {
                $('#drawerCartItems').html('<div style="text-align:center; padding: 30px 10px; color:#94a3b8;"><i class="fas fa-shopping-cart" style="font-size: 30px; margin-bottom:8px;"></i><p style="font-size:13px;">Your cart is empty.</p></div>');
            }
        });
    }

});
</script>

<?php include ('includes/footer.php'); ?>