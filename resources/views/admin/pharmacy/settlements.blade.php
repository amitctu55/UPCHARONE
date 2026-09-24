<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Super Admin | Pharmacy Fleet & Settlements Reconciliation</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-navy: #08364B;
            --accent-cyan: #00A8FF;
            --emergency-red: #E63946;
            --success-green: #9BC03C;
            --bg-canvas: #F8FAFC;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-canvas);
            color: #1e293b;
        }
        .admin-header {
            background: linear-gradient(135deg, var(--primary-navy) 0%, #041822 100%);
            border-bottom: 2px solid rgba(0, 168, 255, 0.3);
            color: #fff;
            padding: 1.25rem 2rem;
        }
        .kpi-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }
        .table-custom {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .table-custom thead th {
            background-color: #f1f5f9;
            color: var(--primary-navy);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #cbd5e1;
        }
        .table-custom tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }
        .status-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .status-due { background: rgba(230, 57, 70, 0.12); color: var(--emergency-red); }
        .status-processing { background: rgba(0, 168, 255, 0.12); color: #0284c7; }
        .status-paid { background: rgba(155, 192, 60, 0.15); color: #628214; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="admin-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <span class="fs-3 fw-bold" style="color: var(--accent-cyan); letter-spacing: 1px;">UPCHAR</span>
            <span class="badge bg-light text-dark px-2 py-1">Super Admin Panel</span>
            <span class="text-white-50">/</span>
            <span class="fw-semibold text-white">Pharmacy Fleet & Settlements</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.pharmacy.settlements.export_csv') }}" class="btn btn-sm btn-outline-info text-white border-light">
                <i class="bi bi-filetype-csv me-1"></i> Export NEFT/RTGS Batch CSV
            </a>
            <span class="badge bg-success bg-opacity-25 text-success border border-success px-3 py-2">
                <i class="bi bi-shield-check me-1"></i> Financial Ledger Verified
            </span>
        </div>
    </header>

    <div class="container-fluid px-4 py-4">
        
        <!-- MODULE 2 NAVIGATION TABS -->
        <ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-3 border">
            <li class="nav-item">
                <a class="nav-link text-muted fw-semibold" href="?tab=pharmacy"><i class="bi bi-hospital me-1"></i> Partner Pharmacies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted fw-semibold" href="?tab=fleet"><i class="bi bi-bicycle me-1"></i> Rider Fleet & GPS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted fw-semibold" href="?tab=dispatch"><i class="bi bi-lightning-charge me-1"></i> Dispatch Monitor</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active fw-bold text-white" style="background: var(--primary-navy);" href="?tab=settlements">
                    <i class="bi bi-cash-stack me-1"></i> Settlements & Financial Reconciliation
                </a>
            </li>
        </ul>

        <!-- 1. SETTLEMENT CONTROL BAR -->
        <div class="card p-3 mb-4 shadow-sm border-0">
            <form method="GET" action="{{ route('admin.pharmacy.settlements') }}" class="row g-3 align-items-end">
                <input type="hidden" name="tab" value="settlements">
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Search Pharmacy / DL No</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="pharmacy" class="form-control" placeholder="Store name, license..." value="{{ $searchPharmacy }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Settlement Status</label>
                    <select name="status" class="form-select">
                        <option value="ALL" {{ $statusFilter == 'ALL' ? 'selected' : '' }}>All Statuses</option>
                        <option value="DUE" {{ $statusFilter == 'DUE' ? 'selected' : '' }}>DUE (Unpaid)</option>
                        <option value="PROCESSING" {{ $statusFilter == 'PROCESSING' ? 'selected' : '' }}>PROCESSING</option>
                        <option value="PAID" {{ $statusFilter == 'PAID' ? 'selected' : '' }}>PAID & Settled</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Cycle Start</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Cycle End</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold" style="background: var(--primary-navy); border-color: var(--primary-navy);">
                        <i class="bi bi-funnel me-1"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.pharmacy.settlements') }}" class="btn btn-light border px-3" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- 2. SUMMARY STATISTICS KPI CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="kpi-card p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Cycle GMV</div>
                        <h3 class="fw-bold mb-0 mt-1" style="color: var(--primary-navy);">₹{{ number_format($totalGmv, 2) }}</h3>
                        <div class="text-muted small mt-1"><i class="bi bi-bag-check text-success me-1"></i> Gross Order Value</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(0, 168, 255, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent-cyan); font-size: 1.5rem;">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="kpi-card p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">UPCHAR Revenue (8%)</div>
                        <h3 class="fw-bold mb-0 mt-1" style="color: var(--accent-cyan);">₹{{ number_format($totalPlatformRevenue, 2) }}</h3>
                        <div class="text-muted small mt-1"><i class="bi bi-graph-up text-primary me-1"></i> Platform Cut Realized</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(8, 54, 75, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-navy); font-size: 1.5rem;">
                        <i class="bi bi-percent"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="kpi-card p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Net Payout Due</div>
                        <h3 class="fw-bold mb-0 mt-1" style="color: var(--emergency-red);">₹{{ number_format($netPayoutDue, 2) }}</h3>
                        <div class="text-muted small mt-1"><i class="bi bi-hourglass-split text-danger me-1"></i> Pending NEFT / RTGS</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(230, 57, 70, 0.1); display: flex; align-items: center; justify-content: center; color: var(--emergency-red); font-size: 1.5rem;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="kpi-card p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Outstanding COD</div>
                        <h3 class="fw-bold mb-0 mt-1" style="color: #628214;">₹{{ number_format($outstandingCod, 2) }}</h3>
                        <div class="text-muted small mt-1"><i class="bi bi-person-badge text-success me-1"></i> In Hand with Fleet Riders</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(155, 192, 60, 0.15); display: flex; align-items: center; justify-content: center; color: var(--success-green); font-size: 1.5rem;">
                        <i class="bi bi-cash"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. MASTER SETTLEMENT RECONCILIATION GRID -->
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="p-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0" style="color: var(--primary-navy);"><i class="bi bi-receipt-cutoff text-primary me-2"></i> Pharmacy Settlement Ledger</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pharmacy.settlements.export_csv') }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-file-earmark-excel me-1"></i> Bank Batch Format (HDFC / ICICI)
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Chemist Store & DL</th>
                            <th>Cycle Dates</th>
                            <th class="text-center">Orders</th>
                            <th class="text-end">Gross Sales</th>
                            <th class="text-center">Comm. %</th>
                            <th class="text-end">UPCHAR Cut</th>
                            <th class="text-end">COD Remit</th>
                            <th class="text-end">Net Payable</th>
                            <th>Bank Account</th>
                            <th>Status</th>
                            <th class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settlements as $s)
                        <tr>
                            <!-- Store & DL -->
                            <td class="ps-3">
                                <div class="fw-bold" style="color: var(--primary-navy);">{{ $s->store_first_name }} {{ $s->store_last_name }}</div>
                                <div class="text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i> {{ $s->city ?? 'Varanasi' }} &bull;
                                    DL: <span class="font-mono text-dark">{{ $s->drug_license_no ?? 'DL-20B-9981' }}</span>
                                </div>
                            </td>

                            <!-- Cycle Dates -->
                            <td>
                                <div class="small fw-semibold">{{ date('d M', strtotime($s->settlement_period_start)) }} - {{ date('d M Y', strtotime($s->settlement_period_end)) }}</div>
                                <span class="text-muted small">Weekly Batch</span>
                            </td>

                            <!-- Order Count -->
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $s->order_count ?? 1 }}</span>
                            </td>

                            <!-- Gross Sales -->
                            <td class="text-end fw-semibold">₹{{ number_format($s->gross_sales, 2) }}</td>

                            <!-- Commission Rate -->
                            <td class="text-center font-mono small">{{ number_format($s->commission_rate ?? 8.00, 2) }}%</td>

                            <!-- Platform Cut -->
                            <td class="text-end text-primary fw-semibold">₹{{ number_format($s->upchar_commission, 2) }}</td>

                            <!-- COD Remittance -->
                            <td class="text-end text-danger small">-₹{{ number_format($s->cod_remittance ?? 0.00, 2) }}</td>

                            <!-- Net Payable -->
                            <td class="text-end fw-bold" style="color: var(--primary-navy); font-size: 1rem;">
                                ₹{{ number_format($s->net_payout, 2) }}
                            </td>

                            <!-- Bank Details -->
                            <td>
                                <div class="small fw-semibold">{{ $s->bank_name ?? 'HDFC Bank' }}</div>
                                <div class="text-muted font-mono" style="font-size: 0.75rem;">
                                    A/C: {{ $s->bank_account_no ? substr($s->bank_account_no, 0, 4) . '****' . substr($s->bank_account_no, -4) : '•••• •••• 9210' }} &bull;
                                    IFSC: {{ $s->bank_ifsc ?? 'HDFC0001824' }}
                                </div>
                            </td>

                            <!-- Status -->
                            <td>
                                @if($s->settlement_status === 'PAID')
                                    <span class="status-badge status-paid">
                                        <i class="bi bi-check-circle-fill"></i> PAID
                                    </span>
                                    @if($s->utr_number)
                                        <div class="text-muted font-mono" style="font-size: 0.7rem;">UTR: {{ $s->utr_number }}</div>
                                    @endif
                                @elseif($s->settlement_status === 'PROCESSING')
                                    <span class="status-badge status-processing">
                                        <i class="bi bi-clock-history"></i> PROCESSING
                                    </span>
                                @else
                                    <span class="status-badge status-due">
                                        <i class="bi bi-exclamation-circle-fill"></i> DUE
                                    </span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="text-center pe-3">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="viewOrderBreakdown({{ $s->id }})" title="View Order Breakdown">
                                        <i class="bi bi-list-check"></i>
                                    </button>
                                    @if($s->settlement_status !== 'PAID')
                                    <button type="button" class="btn btn-sm btn-success fw-semibold" onclick="openUtrModal({{ $s->id }}, '{{ addslashes($s->store_first_name) }}', {{ $s->net_payout }})">
                                        <i class="bi bi-check-lg me-1"></i> Pay
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-sm btn-light border text-muted" disabled>
                                        <i class="bi bi-check2-all text-success"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                No settlement records found matching your filters.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3 bg-white border-top d-flex justify-content-between align-items-center">
                <span class="small text-muted">Showing {{ $settlements->firstItem() ?? 0 }} to {{ $settlements->lastItem() ?? 0 }} of {{ $settlements->total() }} settlement cycles</span>
                {{ $settlements->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- MARK PAID & ENTER UTR MODAL -->
    <div class="modal fade" id="utrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--primary-navy); color: #fff;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-bank me-2"></i> Record Bank Transfer (NEFT/RTGS)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="markPaidForm">
                    <input type="hidden" name="settlement_id" id="modalSettlementId">
                    <div class="modal-body">
                        <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="small text-muted">Payable to Chemist:</div>
                            <h5 class="fw-bold mb-1" id="modalChemistName" style="color: var(--primary-navy);">-</h5>
                            <div class="fs-4 fw-bold text-success" id="modalNetPayout">₹0.00</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Bank UTR / Transaction Reference Number *</label>
                            <input type="text" name="utr_number" id="modalUtrInput" class="form-control font-mono text-uppercase" placeholder="e.g., CMS98210389102" required minlength="8">
                            <div class="form-text small">Obtained from corporate internet banking portal upon debit confirmation.</div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold">Settlement Remarks</label>
                            <input type="text" name="settlement_notes" class="form-control" value="Weekly settlement batch cleared via NEFT">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold px-4" id="btnConfirmPayment">
                            <i class="bi bi-check-circle me-1"></i> Confirm & Mark Paid
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ORDER BREAKDOWN DRAWER (Offcanvas) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="orderDrawer" style="width: 550px;">
        <div class="offcanvas-header" style="background: var(--primary-navy); color: #fff;">
            <h5 class="offcanvas-title fw-bold"><i class="bi bi-cart-check me-2"></i> Settlement Order Drilldown</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body" id="orderDrawerContent">
            <div class="text-center py-5 text-muted">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div>Fetching batch orders and commission audit...</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const utrModal = new bootstrap.Modal(document.getElementById('utrModal'));
    const orderDrawer = new bootstrap.Offcanvas(document.getElementById('orderDrawer'));

    function openUtrModal(id, name, amount) {
        document.getElementById('modalSettlementId').value = id;
        document.getElementById('modalChemistName').innerText = name;
        document.getElementById('modalNetPayout').innerText = '₹' + parseFloat(amount).toFixed(2);
        document.getElementById('modalUtrInput').value = '';
        utrModal.show();
    }

    document.getElementById('markPaidForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnConfirmPayment');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';

        const formData = new FormData(this);
        fetch("{{ route('admin.pharmacy.settlements.mark_paid') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Confirm & Mark Paid';
            if (data.status === 'success') {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Error recording bank UTR.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Confirm & Mark Paid';
            alert('An unexpected network error occurred.');
        });
    });

    function viewOrderBreakdown(settlementId) {
        orderDrawer.show();
        const content = document.getElementById('orderDrawerContent');
        content.innerHTML = '<div class="text-center py-5 text-muted"><div class="spinner-border text-primary mb-2"></div><div>Loading order breakdown...</div></div>';

        fetch(`/admin/pharmacy/settlements/${settlementId}/orders`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                let html = `
                    <div class="mb-3 p-3 rounded" style="background: rgba(0, 168, 255, 0.08); border-left: 4px solid var(--accent-cyan);">
                        <div class="fw-bold" style="color: var(--primary-navy);">${data.settlement.store_first_name}</div>
                        <div class="small text-muted">Cycle: ${data.settlement.settlement_period_start} to ${data.settlement.settlement_period_end}</div>
                        <div class="small fw-bold text-dark mt-1">Total Contributing Orders: ${data.orders.length}</div>
                    </div>
                    <div class="list-group list-group-flush">
                `;

                data.orders.forEach(order => {
                    const comm = (order.total_amount * (data.settlement.commission_rate / 100)).toFixed(2);
                    const net = (order.total_amount - comm).toFixed(2);
                    html += `
                        <div class="list-group-item px-0 py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold font-mono text-primary">${order.order_code}</span>
                                <span class="badge bg-success bg-opacity-10 text-success">${order.order_status}</span>
                            </div>
                            <div class="small text-muted mb-2">Delivered: ${order.created_at} &bull; Mode: ${order.payment_method}</div>
                            <div class="d-flex justify-content-between small">
                                <span>Gross Bill: <strong>₹${parseFloat(order.total_amount).toFixed(2)}</strong></span>
                                <span>UPCHAR (8%): <strong class="text-danger">-₹${comm}</strong></span>
                                <span>Chemist Net: <strong class="text-success">₹${net}</strong></span>
                            </div>
                        </div>
                    `;
                });

                html += '</div>';
                content.innerHTML = html;
            } else {
                content.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(err => {
            content.innerHTML = `<div class="alert alert-danger">Error retrieving order breakdown.</div>`;
        });
    }
    </script>
</body>
</html>
