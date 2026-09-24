<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UPCHAR Pharmacy Partner Portal')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <style>
        :root {
            --navy-primary: #08364B;
            --accent-cyan: #00A8FF;
            --emergency-red: #E63946;
            --success-green: #9BC03C;
            --bg-dark: #041822;
            --bg-light: #F8FAFC;
            --card-border: #E2E8F0;
            --text-dark: #0F172A;
            --text-muted: #64748B;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .pharmacy-sidebar {
            width: 260px;
            background: var(--navy-primary);
            color: #FFF;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(4, 24, 34, 0.2);
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand img {
            height: 38px;
            width: auto;
        }

        .sidebar-brand-text h4 {
            margin: 0;
            font-weight: 800;
            font-size: 16px;
            color: #FFF;
            letter-spacing: 0.5px;
        }

        .sidebar-brand-text span {
            font-size: 11px;
            color: var(--accent-cyan);
            font-weight: 600;
            text-transform: uppercase;
        }

        .sidebar-nav {
            list-style: none;
            padding: 16px 12px;
            margin: 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav li {
            margin-bottom: 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: #94A3B8;
            text-decoration: none;
            font-weight: 600;
            font-size: 13.5px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-nav a:hover {
            color: #FFF;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-nav li.active a {
            color: #FFF;
            background: var(--accent-cyan);
            box-shadow: 0 4px 14px rgba(0, 168, 255, 0.35);
        }

        .sidebar-nav a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--emergency-red);
            color: #FFF;
            font-size: 10.5px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 10px;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(4, 24, 34, 0.4);
        }

        /* Main Content Wrapper */
        .pharmacy-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Top Navbar */
        .pharmacy-topbar {
            background: #FFF;
            border-bottom: 1px solid var(--card-border);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-title h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--navy-primary);
        }

        .topbar-title span {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .store-status-toggle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
            color: #065F46;
            cursor: pointer;
        }

        .store-status-toggle.closed {
            background: #FEF2F2;
            border-color: #FECACA;
            color: #991B1B;
        }

        .store-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success-green);
        }

        .store-status-toggle.closed .store-status-dot {
            background: var(--emergency-red);
        }

        .content-body {
            padding: 28px 32px;
        }

        /* UI Cards */
        .dash-card {
            background: #FFF;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
            padding: 20px;
            margin-bottom: 24px;
        }

        /* KPI Bento Box */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .kpi-card {
            background: #FFF;
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--accent-cyan);
        }

        .kpi-card.success::before { background: var(--success-green); }
        .kpi-card.danger::before { background: var(--emergency-red); }
        .kpi-card.navy::before { background: var(--navy-primary); }

        .kpi-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .kpi-value {
            font-size: 26px;
            font-weight: 900;
            color: var(--navy-primary);
            line-height: 1.2;
        }

        .kpi-sub {
            font-size: 12px;
            color: #059669;
            font-weight: 600;
            margin-top: 6px;
        }

        /* Responsive Mobile Drawer */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--navy-primary);
        }

        @media (max-width: 991px) {
            .pharmacy-sidebar {
                transform: translateX(-100%);
            }
            .pharmacy-sidebar.open {
                transform: translateX(0);
            }
            .pharmacy-main {
                margin-left: 0;
            }
            .mobile-nav-toggle {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- 1. Aesthetic Master Left Sidebar (8 Tabs) -->
    <aside class="pharmacy-sidebar" id="pharmacySidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/Final_logo23.png') }}" alt="UPCHAR Logo">
            <div class="sidebar-brand-text">
                <h4>UPCHAR CHEMIS</h4>
                <span>Partner Portal</span>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="{{ request()->is('medical-dashboard') || request()->get('tab') == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/inventory*') || request()->get('tab') == 'inventory' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/inventory') }}">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory &amp; Stocks</span>
                    @if(isset($lowStockCount) && $lowStockCount > 0)
                        <span class="nav-badge">{{ $lowStockCount }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/orders*') || request()->get('tab') == 'orders' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/orders') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Live Orders &amp; Bills</span>
                    @if(isset($pendingRxCount) && $pendingRxCount > 0)
                        <span class="nav-badge">{{ $pendingRxCount }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/handover*') || request()->get('tab') == 'handover' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/handover') }}">
                    <i class="fas fa-motorcycle"></i>
                    <span>Delivery Handover</span>
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/payouts*') || request()->get('tab') == 'payouts' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/payouts') }}">
                    <i class="fas fa-wallet"></i>
                    <span>Payments &amp; Payouts</span>
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/profile*') || request()->get('tab') == 'profile' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/profile') }}">
                    <i class="fas fa-clinic-medical"></i>
                    <span>Pharmacy Profile</span>
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/reports*') || request()->get('tab') == 'reports' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/reports') }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Reports &amp; Stats</span>
                </a>
            </li>
            <li class="{{ request()->is('medical-dashboard/gallery*') || request()->get('tab') == 'gallery' ? 'active' : '' }}">
                <a href="{{ url('medical-dashboard/gallery') }}">
                    <i class="fas fa-images"></i>
                    <span>Store Gallery</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div style="font-size: 11.5px; color: #94A3B8; margin-bottom: 6px;">
                <i class="fas fa-shield-alt text-success"></i> Drug License: <strong>DL-20B/21B</strong>
            </div>
            <a href="{{ url('logout') }}" style="color: #F87171; font-size: 13px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-sign-out-alt"></i> Secure Chemist Logout
            </a>
        </div>
    </aside>

    <!-- 2. Main View Container -->
    <div class="pharmacy-main">
        <header class="pharmacy-topbar">
            <div class="topbar-left">
                <button type="button" class="mobile-nav-toggle" onclick="$('#pharmacySidebar').toggleClass('open')">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h2>@yield('page_title', 'Pharmacy Management Dashboard')</h2>
                    <span>Authorized Chemist Fulfillment Network &bull; Varanasi Central</span>
                </div>
            </div>

            <div class="topbar-right">
                <div class="store-status-toggle" id="storeStatusToggle" onclick="toggleStoreStatus()">
                    <span class="store-status-dot"></span>
                    <span id="storeStatusText">Store Accepting Orders</span>
                </div>
                <div style="width: 1px; height: 28px; background: #E2E8F0;"></div>
                <div style="font-size: 13px; font-weight: 700; color: var(--navy-primary);">
                    <i class="fas fa-user-circle" style="color: var(--accent-cyan); font-size: 16px;"></i> Sanjivani 24x7 Chemist
                </div>
            </div>
        </header>

        <main class="content-body">
            @yield('content')
        </main>
    </div>

    <!-- Audio Chime for Live Orders -->
    <audio id="orderAudioChime" preload="auto">
        <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
    </audio>

    <script>
        function toggleStoreStatus() {
            const $btn = $('#storeStatusToggle');
            const isClosed = $btn.hasClass('closed');
            const newStatus = isClosed ? 1 : 0;

            $.post('{{ url("medical-dashboard/toggle-status") }}', {
                status: newStatus,
                _token: '{{ csrf_token() }}'
            }, function(resp) {
                if (newStatus === 1) {
                    $btn.removeClass('closed');
                    $('#storeStatusText').text('Store Accepting Orders');
                } else {
                    $btn.addClass('closed');
                    $('#storeStatusText').text('Store Temporarily Closed');
                }
            }).fail(function() {
                // Fallback demo toggle
                $btn.toggleClass('closed');
                $('#storeStatusText').text($btn.hasClass('closed') ? 'Store Temporarily Closed' : 'Store Accepting Orders');
            });
        }

        function triggerOrderChime() {
            const chime = document.getElementById('orderAudioChime');
            if (chime) {
                chime.play().catch(function(e) {});
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
