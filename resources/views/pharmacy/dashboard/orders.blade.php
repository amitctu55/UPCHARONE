@extends('pharmacy.dashboard.layout')

@section('title', 'Live Orders & Bills - UPCHAR')
@section('page_title', 'Live Orders Pipeline & Statutory Invoicing')

@section('content')
<!-- Kanban Stage Filters -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <a href="{{ url('medical-dashboard/orders?tab=ALL') }}" class="btn btn-sm {{ $statusTab == 'ALL' ? 'btn-primary' : 'btn-default' }}" style="font-weight: 700; border-radius: 20px; padding: 6px 18px;">
        All Orders
    </a>
    <a href="{{ url('medical-dashboard/orders?tab=PLACED') }}" class="btn btn-sm {{ $statusTab == 'PLACED' ? 'btn-primary' : 'btn-default' }}" style="font-weight: 700; border-radius: 20px; padding: 6px 18px;">
        <i class="fas fa-inbox"></i> New Orders ({{ $counts['NEW_ORDERS'] ?? 0 }})
    </a>
    <a href="{{ url('medical-dashboard/orders?tab=PENDING_RX') }}" class="btn btn-sm {{ $statusTab == 'PENDING_RX' ? 'btn-warning' : 'btn-default' }}" style="font-weight: 700; border-radius: 20px; padding: 6px 18px;">
        <i class="fas fa-file-prescription"></i> Prescription Audit ({{ $counts['PRESCRIPTION_AUDIT'] ?? 0 }})
    </a>
    <a href="{{ url('medical-dashboard/orders?tab=PACKED') }}" class="btn btn-sm {{ $statusTab == 'PACKED' ? 'btn-info' : 'btn-default' }}" style="font-weight: 700; border-radius: 20px; padding: 6px 18px;">
        <i class="fas fa-box-check"></i> Packing Queue ({{ $counts['PACKING'] ?? 0 }})
    </a>
    <a href="{{ url('medical-dashboard/orders?tab=ASSIGNED') }}" class="btn btn-sm {{ $statusTab == 'ASSIGNED' ? 'btn-success' : 'btn-default' }}" style="font-weight: 700; border-radius: 20px; padding: 6px 18px;">
        <i class="fas fa-motorcycle"></i> Ready for Pickup ({{ $counts['READY_FOR_PICKUP'] ?? 0 }})
    </a>
</div>

<!-- Orders Grid -->
<div class="row">
    @forelse($orders as $o)
    <div class="col-md-6 col-lg-4" style="margin-bottom: 20px;">
        <div class="dash-card" style="padding: 18px; margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 10px; margin-bottom: 12px;">
                    <div>
                        <span style="font-size: 11px; color: var(--text-muted); font-weight: 700;">ORDER CODE</span>
                        <h4 style="margin: 0; font-weight: 900; color: var(--navy-primary); font-size: 16px;">{{ $o->order_code }}</h4>
                    </div>
                    <span class="label label-info" style="font-size: 11px; padding: 4px 10px; border-radius: 12px;">{{ $o->order_status }}</span>
                </div>

                <div style="font-size: 13px; margin-bottom: 6px;">
                    <i class="fas fa-user" style="color: var(--accent-cyan); width: 16px;"></i> <strong>{{ $o->customer_name ?? 'Patient' }}</strong>
                </div>
                <div style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 6px;">
                    <i class="fas fa-phone-alt" style="color: var(--accent-cyan); width: 16px;"></i> {{ $o->customer_phone ?? '9839112233' }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-bottom: 12px; line-height: 1.4;">
                    <i class="fas fa-map-marker-alt" style="color: var(--emergency-red); width: 16px;"></i> {{ $o->delivery_address ?? 'Varanasi, UP' }}
                </div>

                <div style="background: #F8FAFC; border: 1px solid var(--card-border); border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">Grand Total</span>
                    <strong style="font-size: 16px; color: var(--navy-primary);">₹{{ number_format($o->total_amount, 2) }}</strong>
                </div>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center; border-top: 1px solid var(--card-border); padding-top: 12px;">
                @if($o->prescription_id)
                <button type="button" class="btn btn-sm btn-warning" onclick="openRxViewer('{{ $o->prescription_id }}', '{{ $o->order_code }}')" style="font-weight: 700; border-radius: 6px;">
                    <i class="fas fa-file-prescription"></i> Audit Rx
                </button>
                @endif
                <a href="{{ url('medical-dashboard/orders/' . $o->id . '/invoice') }}" target="_blank" class="btn btn-sm" style="background: var(--navy-primary); color: #FFF; font-weight: 700; border-radius: 6px;">
                    <i class="fas fa-print"></i> Tax Invoice
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-xs-12">
        <div class="dash-card text-center" style="padding: 50px;">
            <i class="fas fa-clipboard-check" style="font-size: 40px; color: #10B981; margin-bottom: 14px;"></i>
            <h3>No orders found in this queue</h3>
            <p style="color: var(--text-muted);">Switch between Kanban tabs above to view active, packed, or fulfilled orders.</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Prescription Audit Modal with Zoom & Rotate Controls -->
<div class="modal fade" id="rxViewerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: var(--navy-primary); color: #FFF; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px;">
                    <i class="fas fa-microscope" style="color: var(--accent-cyan);"></i> Registered Pharmacist Rx Audit &bull; <span id="rxOrderTitle">Order</span>
                </h4>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-xs btn-default" onclick="zoomRx(0.2)"><i class="fas fa-search-plus"></i></button>
                    <button type="button" class="btn btn-xs btn-default" onclick="zoomRx(-0.2)"><i class="fas fa-search-minus"></i></button>
                    <button type="button" class="btn btn-xs btn-default" onclick="rotateRx()"><i class="fas fa-redo"></i></button>
                    <button type="button" class="close" data-dismiss="modal" style="color: #FFF; opacity: 0.8; margin-left: 8px;">&times;</button>
                </div>
            </div>
            <div class="modal-body" style="padding: 20px; background: #041822; text-align: center; min-height: 400px; overflow: auto;">
                <img id="rxViewerImage" src="{{ asset('images/sample_rx.jpg') }}" alt="Uploaded Prescription" onerror="this.onerror=null; this.src='https://dummyimage.com/600x800/08364b/ffffff.png&text=Doctor+Prescription+Scan';" style="max-width: 100%; height: auto; transition: transform 0.2s ease; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            </div>
            <div class="modal-footer" style="background: #F8FAFC; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: var(--text-muted);"><i class="fas fa-user-check text-success"></i> Registered Pharmacist Sign-Off Required under Form 20B/21B</span>
                <button type="button" class="btn btn-success" data-dismiss="modal" style="font-weight: 700; background: var(--success-green); border: none;">
                    <i class="fas fa-check"></i> Approve Prescription
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentZoom = 1;
let currentRotation = 0;

function openRxViewer(rxId, orderCode) {
    $('#rxOrderTitle').text(orderCode);
    currentZoom = 1;
    currentRotation = 0;
    applyRxTransform();
    $('#rxViewerModal').modal('show');
}

function zoomRx(delta) {
    currentZoom = Math.max(0.6, Math.min(3.0, currentZoom + delta));
    applyRxTransform();
}

function rotateRx() {
    currentRotation = (currentRotation + 90) % 360;
    applyRxTransform();
}

function applyRxTransform() {
    $('#rxViewerImage').css('transform', `scale(${currentZoom}) rotate(${currentRotation}deg)`);
}
</script>
@endsection
