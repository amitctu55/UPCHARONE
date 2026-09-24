@extends('pharmacy.dashboard.layout')

@section('title', 'Batch Inventory & Stocks (FEFO) - UPCHAR')
@section('page_title', 'Inventory & Batch Stock Formulary (FEFO)')

@section('content')
<div class="dash-card">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 14px; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
        <div style="flex: 1; min-width: 280px; max-width: 450px;">
            <form action="{{ url('medical-dashboard/inventory') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="Search Brand, Generic Composition, or Batch No...">
                <button type="submit" class="btn" style="background: var(--navy-primary); color: #FFF; font-weight: 700;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn" data-toggle="modal" data-target="#inwardStockModal" style="background: var(--accent-cyan); color: #FFF; font-weight: 700; border-radius: 6px; padding: 8px 20px; box-shadow: 0 2px 8px rgba(0, 168, 255, 0.3);">
                <i class="fas fa-plus"></i> Inward New Stock Batch
            </button>
        </div>
    </div>

    <!-- Batch Inventory Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr style="background: #F8FAFC; color: var(--text-muted); font-size: 11.5px; font-weight: 700; text-transform: uppercase;">
                    <th>Medicine &amp; Dosage</th>
                    <th>Batch No</th>
                    <th>Expiry Date (FEFO)</th>
                    <th>Available Qty</th>
                    <th>Buy Rate</th>
                    <th>MRP</th>
                    <th>Selling Price</th>
                    <th>Chemist Margin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $b)
                @php
                    $isExpired = \Carbon\Carbon::parse($b->expiry_date)->isPast();
                    $isNearExpiry = \Carbon\Carbon::parse($b->expiry_date)->diffInDays(now()) <= 60;
                    $isLowStock = $b->available_quantity < ($b->low_stock_threshold ?? 10);
                    $margin = $b->selling_price_per_unit - $b->buy_rate_per_unit;
                    $marginPct = $b->selling_price_per_unit > 0 ? round(($margin / $b->selling_price_per_unit) * 100, 1) : 0;
                @endphp
                <tr>
                    <td>
                        <strong style="color: var(--navy-primary); font-size: 14px;">{{ $b->brand_name }}</strong>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $b->generic_composition }} &bull; {{ $b->dosage_form }} ({{ $b->pack_size }})</div>
                    </td>
                    <td><span class="badge" style="background: #F1F5F9; color: var(--navy-primary); font-weight: 700; border: 1px solid #CBD5E1;">{{ $b->batch_number }}</span></td>
                    <td>
                        <div style="font-weight: 700; color: {{ $isExpired || $isNearExpiry ? 'var(--emergency-red)' : 'inherit' }};">
                            {{ date('m/Y', strtotime($b->expiry_date)) }}
                        </div>
                        <small style="font-size: 11px; color: var(--text-muted);">{{ date('d M Y', strtotime($b->expiry_date)) }}</small>
                    </td>
                    <td>
                        <strong style="font-size: 15px; color: {{ $isLowStock ? '#D97706' : 'var(--navy-primary)' }};">
                            {{ $b->available_quantity }}
                        </strong>
                        <small style="color: var(--text-muted); font-size: 11px;">units</small>
                    </td>
                    <td>₹{{ number_format($b->buy_rate_per_unit, 2) }}</td>
                    <td style="color: var(--text-muted); text-decoration: line-through;">₹{{ number_format($b->mrp_per_unit, 2) }}</td>
                    <td style="font-weight: 800; color: var(--navy-primary);">₹{{ number_format($b->selling_price_per_unit, 2) }}</td>
                    <td>
                        <span style="color: #059669; font-weight: 800;">₹{{ number_format($margin, 2) }} ({{ $marginPct }}%)</span>
                        <div style="font-size: 10.5px; color: var(--text-muted);">UPCHAR Cut: 8% (₹{{ number_format($b->selling_price_per_unit * 0.08, 2) }})</div>
                    </td>
                    <td>
                        @if($isExpired)
                            <span class="label label-danger" style="font-size: 10.5px;"><i class="fas fa-ban"></i> Expired</span>
                        @elseif($isNearExpiry)
                            <span class="label label-warning" style="font-size: 10.5px;"><i class="fas fa-clock"></i> Near Expiry (&lt;60d)</span>
                        @elseif($isLowStock)
                            <span class="label label-warning" style="background: #F59E0B; font-size: 10.5px;"><i class="fas fa-exclamation"></i> Low Stock</span>
                        @else
                            <span class="label label-success" style="background: var(--success-green); font-size: 10.5px;"><i class="fas fa-check"></i> In Stock</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-boxes" style="font-size: 32px; color: #CBD5E1; margin-bottom: 10px;"></i>
                        <p>No inventory batches found matching your search criteria.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($batches, 'links'))
        <div style="margin-top: 16px;">{{ $batches->links() }}</div>
    @endif
</div>

<!-- Inward Stock Modal with Real-time Margin & 8% Commission Calculator -->
<div class="modal fade" id="inwardStockModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: var(--navy-primary); color: #FFF; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #FFF; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px;">
                    <i class="fas fa-box-open" style="color: var(--accent-cyan);"></i> Inward Stock Batch &bull; Statutory FEFO Entry
                </h4>
            </div>
            <form id="inwardStockForm" onsubmit="submitInwardStock(event)">
                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <!-- Medicine Master Select -->
                        <div class="col-sm-8" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Select Master Medicine / Generic Composition <span class="text-danger">*</span></label>
                            <select name="medicine_id" id="inwardMedSelect" class="form-control" required>
                                <option value="">-- Choose from Master Formulary --</option>
                                @foreach($masterMedicines ?? [] as $m)
                                    <option value="{{ $m->id }}">{{ $m->brand_name }} ({{ $m->generic_composition }}) - {{ $m->dosage_form }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Batch Number <span class="text-danger">*</span></label>
                            <input type="text" name="batch_number" class="form-control" placeholder="e.g. BATCH-2026-X" required style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Expiry Date (FEFO) <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control" min="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Inward Quantity (Units) <span class="text-danger">*</span></label>
                            <input type="number" name="available_quantity" class="form-control" value="50" min="1" required>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">GST Slab <span class="text-danger">*</span></label>
                            <select name="gst_percent" class="form-control" required>
                                <option value="12">12% (Standard Formulations)</option>
                                <option value="5">5% (Life Saving)</option>
                                <option value="18">18% (Supplements)</option>
                                <option value="0">0% (Nil)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Buy Rate (Wholesale) ₹ <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="buy_rate_per_unit" id="inwardBuyRate" class="form-control" placeholder="0.00" oninput="calculateMarginPreview()" required>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Maximum Retail Price (MRP) ₹ <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="mrp_per_unit" id="inwardMrp" class="form-control" placeholder="0.00" oninput="calculateMarginPreview()" required>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 14px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Patient Discount %</label>
                            <input type="number" step="0.1" name="discount_percent" id="inwardDiscount" class="form-control" value="10" min="0" max="50" oninput="calculateMarginPreview()">
                        </div>
                    </div>

                    <!-- Real-Time Calculation Preview Card -->
                    <div style="background: #F8FAFC; border: 1.5px solid var(--accent-cyan); border-radius: 8px; padding: 14px 18px; margin-top: 10px;">
                        <h5 style="margin: 0 0 10px; font-weight: 800; color: var(--navy-primary); font-size: 13px;">
                            <i class="fas fa-calculator" style="color: var(--accent-cyan);"></i> Live Profit Margin &amp; Statutory UPCHAR Cut Preview
                        </h5>
                        <div class="row text-center">
                            <div class="col-xs-3">
                                <div style="font-size: 11px; color: var(--text-muted);">Selling Price to Patient</div>
                                <div style="font-size: 16px; font-weight: 800; color: var(--navy-primary);" id="previewSellingPrice">₹0.00</div>
                            </div>
                            <div class="col-xs-3">
                                <div style="font-size: 11px; color: var(--text-muted);">UPCHAR Platform Cut (8%)</div>
                                <div style="font-size: 16px; font-weight: 800; color: var(--emergency-red);" id="previewUpcharCut">₹0.00</div>
                            </div>
                            <div class="col-xs-3">
                                <div style="font-size: 11px; color: var(--text-muted);">Chemist Net Retention</div>
                                <div style="font-size: 16px; font-weight: 800; color: #059669;" id="previewChemistNet">₹0.00</div>
                            </div>
                            <div class="col-xs-3">
                                <div style="font-size: 11px; color: var(--text-muted);">Gross Chemist Profit</div>
                                <div style="font-size: 16px; font-weight: 900; color: var(--success-green);" id="previewProfit">₹0.00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background: #F8FAFC; padding: 14px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: var(--navy-primary); color: #FFF; font-weight: 800; padding: 9px 24px; border-radius: 6px;">
                        <i class="fas fa-check-circle"></i> Confirm Inward Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculateMarginPreview() {
    const buyRate = parseFloat($('#inwardBuyRate').val()) || 0;
    const mrp = parseFloat($('#inwardMrp').val()) || 0;
    const discount = parseFloat($('#inwardDiscount').val()) || 0;

    const sellingPrice = mrp - (mrp * (discount / 100));
    const upcharCut = sellingPrice * 0.08;
    const chemistNet = sellingPrice - upcharCut;
    const profit = chemistNet - buyRate;

    $('#previewSellingPrice').text('₹' + sellingPrice.toFixed(2));
    $('#previewUpcharCut').text('₹' + upcharCut.toFixed(2));
    $('#previewChemistNet').text('₹' + chemistNet.toFixed(2));
    $('#previewProfit').text('₹' + profit.toFixed(2));
}

function submitInwardStock(e) {
    e.preventDefault();
    const form = document.getElementById('inwardStockForm');
    const formData = new FormData(form);

    $.ajax({
        url: '{{ url("medical-dashboard/inventory/inward") }}',
        type: 'POST',
        data: $(form).serialize(),
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function(resp) {
            alert('Stock Batch Successfully Created under FEFO formulary!');
            window.location.reload();
        },
        error: function(xhr) {
            let msg = 'Failed to inward stock.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            alert(msg);
        }
    });
}
</script>
@endsection
