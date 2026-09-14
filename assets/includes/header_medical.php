<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Upchar Chemist Partner Command Center">
    <meta name="author" content="Upchar">

    <title>Chemist Partner Command Center | Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/gif" sizes="16x16">
    
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/theme.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/cstm.css" rel="stylesheet">

<style>
:root {
    --chem-navy: #043d5b;
    --chem-navy-dark: #022b40;
    --chem-teal: #00a896;
    --chem-cyan: #2dd4bf;
    --chem-slate: #0f172a;
    --chem-border: #e2e8f0;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
    background: #f8fafc !important;
    color: #1e293b !important;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* 1. Global Topbar */
.topbar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 60px !important;
    background: linear-gradient(135deg, #0d1b2a 0%, #043d5b 100%) !important;
    color: #ffffff !important;
    z-index: 1030 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 0 20px !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

.topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.topbar-toggle-btn {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 18px;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.topbar-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.12);
}

.topbar-brand-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none !important;
    color: #ffffff !important;
}

.topbar-brand-link img {
    height: 34px;
    width: auto;
}

.topbar-brand-title {
    font-size: 15px;
    font-weight: 700;
    letter-spacing: -0.3px;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.topbar-portal-badge {
    background: rgba(45, 212, 191, 0.15);
    border: 1px solid var(--chem-cyan);
    color: #a7f3d0;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 2px 8px;
    border-radius: 12px;
}

/* 2. Topbar Right & User Dropdown */
.topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.topbar-store-menu {
    position: relative;
}

.store-dropdown-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 5px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #ffffff !important;
    text-decoration: none !important;
    cursor: pointer;
    font-size: 12.5px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.store-dropdown-btn:hover {
    background: rgba(255, 255, 255, 0.18);
    border-color: rgba(255, 255, 255, 0.35);
}

.store-dropdown-card {
    min-width: 240px;
    background: #ffffff !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    border: 1px solid var(--chem-border) !important;
    padding: 8px 0 !important;
    margin-top: 8px !important;
}

.store-dropdown-card .dropdown-header {
    padding: 6px 16px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
}

.store-dropdown-card li a {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 8px 16px !important;
    font-size: 13px !important;
    color: #334155 !important;
    text-decoration: none !important;
    transition: background 0.15s !important;
}

.store-dropdown-card li a:hover,
.store-dropdown-card li a.active {
    background: #f0fdfa !important;
    color: #043d5b !important;
    font-weight: 600;
}

.user-profile-menu {
    position: relative;
}

.user-profile-btn {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 30px;
    padding: 4px 14px 4px 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffffff !important;
    text-decoration: none !important;
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-profile-btn:hover {
    background: rgba(255, 255, 255, 0.16);
    border-color: rgba(255, 255, 255, 0.3);
}

.user-profile-btn img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--chem-cyan);
}

.user-profile-name {
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.2;
}

.user-profile-role {
    font-size: 11px;
    color: #94a3b8;
    display: block;
}

.user-dropdown-card {
    min-width: 220px;
    background: #ffffff !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    border: 1px solid var(--chem-border) !important;
    padding: 8px 0 !important;
    margin-top: 8px !important;
}

.user-dropdown-card .dropdown-header-info {
    padding: 10px 18px 12px 18px;
    border-bottom: 1px solid var(--chem-border);
    margin-bottom: 6px;
}

.user-dropdown-card .dropdown-header-info h5 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: var(--chem-slate);
}

.user-dropdown-card .dropdown-header-info small {
    color: #64748b;
    font-size: 12px;
}

.user-dropdown-card li a {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 9px 18px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #334155 !important;
    text-decoration: none !important;
    transition: background 0.15s !important;
}

.user-dropdown-card li a i {
    width: 16px;
    color: #0284c7;
    font-size: 14px;
    text-align: center;
}

.user-dropdown-card li a:hover {
    background: #f1f5f9 !important;
    color: #0f172a !important;
}

.user-dropdown-card .divider {
    height: 1px;
    margin: 6px 0;
    background-color: var(--chem-border);
}

.user-dropdown-card li a.logout-link {
    color: #e11d48 !important;
}

.user-dropdown-card li a.logout-link i {
    color: #e11d48 !important;
}

/* 3. Sidebar Master Layout */
.sidebar {
    position: fixed !important;
    top: 60px !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 250px !important;
    height: calc(100vh - 60px) !important;
    max-height: calc(100vh - 60px) !important;
    z-index: 1020 !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    background: #043d5b !important;
    scrollbar-width: thin !important;
    scrollbar-color: rgba(255, 255, 255, 0.25) transparent !important;
    transition: left 0.25s ease-in-out !important;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.06) !important;
}

.sidebar .logopanel {
    padding: 16px 20px !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    text-align: center !important;
}

.sidebar .nav-sidebar {
    padding: 12px 0 !important;
    margin: 0 !important;
    list-style: none !important;
}

.sidebar .nav-sidebar > li > a {
    color: #cbd5e1 !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    padding: 12px 20px !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    border-left: 3px solid transparent !important;
}

.sidebar .nav-sidebar > li > a i {
    color: #2dd4bf !important;
    font-size: 15px !important;
    width: 20px !important;
    text-align: center !important;
    transition: color 0.2s ease !important;
}

.sidebar .nav-sidebar > li:hover > a,
.sidebar .nav-sidebar > li.active > a {
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    border-left: 3px solid #2dd4bf !important;
}

.sidebar .nav-sidebar > li.active > a i {
    color: #ffffff !important;
}

/* 4. Fluid Main Content Container */
.main-content {
    margin-left: 250px !important;
    margin-top: 60px !important;
    min-height: calc(100vh - 60px) !important;
    background: #f8fafc !important;
    transition: margin-left 0.25s ease-in-out !important;
    box-sizing: border-box !important;
    display: flex !important;
    flex-direction: column !important;
}

.pag_cstm {
    flex: 1 0 auto !important;
    padding: 0 !important;
    margin: 0 !important;
    background: transparent !important;
}

/* 5. Responsive Breakpoints */
@media screen and (max-width: 991px) {
    .sidebar {
        left: -250px !important;
    }
    body.sidebar-show .sidebar,
    .sidebar-show .sidebar {
        display: block !important;
        visibility: visible !important;
        left: 0 !important;
        opacity: 1 !important;
    }
    .main-content {
        margin-left: 0 !important;
    }
    .topbar-brand-title {
        display: none !important;
    }
}
</style>
</head>

<body class="sidebar-light fixed-topbar theme-sltl bg-light-dark color-default dashboard">

    <!-- Global Chemist Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <button type="button" class="topbar-toggle-btn menutoggle" data-toggle="sidebar-collapsed" title="Toggle Navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a href="<?=base_url('medical-dashboard');?>" class="topbar-brand-link" title="Chemist Dashboard">
                <img src="<?=base_url('images/logo.png');?>" alt="Upchar Logo">
                <span class="topbar-brand-title">
                    <span>UPCHAR</span>
                    <span class="topbar-portal-badge">Chemist Command Center</span>
                </span>
            </a>
        </div>

        <div class="topbar-right">
            <?php 
                $userId = $this->session->userdata('medicaluserid') ?: ($this->session->userdata('user_id') ?: $this->session->userdata('userid'));
                $chemProfRow = $this->db->select('id, drimage, fname, mobile')->from('profile_chem')
                    ->group_start()
                        ->where('id', $userId)
                        ->or_where('user_id', $userId)
                    ->group_end()
                    ->get()->row();
                if(!$chemProfRow || empty($chemProfRow->drimage))
                    $profileimg = base_url()."assets/images/user.jpg";
                else
                    $profileimg = admin_url()."public/assets/upload/".$chemProfRow->drimage;

                // Strictly fetch stores owned by or affiliated with the logged-in chemist (NO cross-account leakage)
                $userStores = [];
                if (!empty($userId)) {
                    $this->db->select('id, store_name, city, is_active')->from('pharmacy_stores');
                    $this->db->group_start();
                    $this->db->where('owner_id', (int)$userId);
                    if (!empty($chemProfRow->id)) {
                        $this->db->or_where('hospital_id', (int)$chemProfRow->id);
                    }
                    if (!empty($chemProfRow->mobile)) {
                        $this->db->or_where('phone', $chemProfRow->mobile);
                    }
                    $this->db->group_end();
                    $this->db->where('is_active', 1);
                    $this->db->order_by('id', 'ASC');
                    $userStores = $this->db->get()->result_array();
                }

                $activeStoreId = (int)($this->input->get('store_id') ?: ($userStores[0]['id'] ?? 0));
                $activeStore = null;
                foreach ($userStores as $st) {
                    if ((int)$st['id'] === $activeStoreId) {
                        $activeStore = $st;
                        break;
                    }
                }
                if (!$activeStore && !empty($userStores)) {
                    $activeStore = $userStores[0];
                    $activeStoreId = (int)$activeStore['id'];
                }

                // Full Store / Profile Name (prevents first-word truncation)
                $sessionStoreName = $this->session->userdata('store_name');
                $profileFullName = !empty($chemProfRow->fname) ? trim($chemProfRow->fname . ' ' . ($chemProfRow->lname ?? '')) : '';
                $sessionUsername = $this->session->userdata('medicalusername');

                $chemistName = $sessionStoreName 
                    ?: (!empty($activeStore['store_name']) ? $activeStore['store_name'] 
                    : (!empty($profileFullName) ? $profileFullName 
                    : (!empty($sessionUsername) ? $sessionUsername : 'Chemist Partner')));
            ?>

            <?php if (!empty($userStores)): ?>
                <?php if (count($userStores) > 1): ?>
                    <!-- Multi-store selector dropdown (Strictly filtered to this chemist) -->
                    <div class="dropdown topbar-store-menu">
                        <a href="#" class="store-dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Switch Active Pharmacy Store">
                            <i class="fa fa-hospital-o text-cyan" style="color: #2dd4bf;"></i>
                            <span><?=html_escape($activeStore['store_name']);?></span>
                            <i class="fa fa-angle-down" style="font-size: 12px; opacity: 0.7;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right store-dropdown-card">
                            <li class="dropdown-header">Your Pharmacy Stores</li>
                            <?php foreach ($userStores as $st): ?>
                                <li>
                                    <a href="?store_id=<?=$st['id'];?>" class="<?=$st['id'] == $activeStoreId ? 'active' : '';?>">
                                        <i class="fa fa-check <?=$st['id'] == $activeStoreId ? 'text-success' : 'text-muted';?>"></i>
                                        <div>
                                            <div style="font-weight:600;"><?=html_escape($st['store_name']);?></div>
                                            <small class="text-muted"><?=html_escape($st['city'] ?: 'Pharmacy Store');?></small>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Single store badge for logged-in chemist -->
                    <div class="store-dropdown-btn" style="cursor: default;" title="Active Pharmacy Store">
                        <i class="fa fa-hospital-o text-cyan" style="color: #2dd4bf;"></i>
                        <span><?=html_escape($activeStore['store_name']);?></span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="dropdown user-profile-menu">
                <a href="#" class="user-profile-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?=$profileimg;?>" alt="User Profile">
                    <div style="text-align: left;">
                        <span class="user-profile-name"><?=html_escape($chemistName);?></span>
                        <span class="user-profile-role">Pharmacist &bull; Partner</span>
                    </div>
                    <i class="fa fa-angle-down" style="font-size: 14px; margin-left: 4px; color: #94a3b8;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right user-dropdown-card">
                    <li class="dropdown-header-info">
                        <h5><?=html_escape($chemistName);?></h5>
                        <small><?=html_escape($chemProfRow->mobile ?? ($this->session->userdata('medicaluseremail') ?: 'Verified Chemist'));?></small>
                    </li>
                    <li><a href="<?=base_url('pharmacy/profile/edit');?>"><i class="fa fa-medkit"></i> Pharmacy Profile</a></li>
                    <li><a href="<?=base_url('pharmacy/inventory');?>"><i class="fa fa-cubes"></i> Inventory & Stocks</a></li>
                    <li><a href="<?=base_url('medicalpanel/profile_idproof2');?>"><i class="fa fa-file-text-o"></i> Drug License & KYC</a></li>
                    <li><a href="<?=base_url('medicalpanel/change_password');?>"><i class="fa fa-key"></i> Change Password</a></li>
                    <li class="divider"></li>
                    <li><a href="<?=base_url('medicaluser/logout');?>" class="logout-link"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section>
        <div class="main-content">
