@extends('pharmacy.dashboard.layout')

@section('title', 'Fleet Delivery Handover - UPCHAR')
@section('page_title', 'Rider Handover & Security Dispatch Queue')

@section('content')
<div class="dash-card">
    <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 14px; margin-bottom: 20px;">
        <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--navy-primary);">
            <i class="fas fa-shield-check" style="color: var(--success-green);"></i> Active UPCHAR Rider Handover Queue
        </h3>
        <span style="font-size: 12.5px; color: var(--text-muted);">
            Verify tamper-evident package seal and validate the rider's 4-digit handover code before releasing medicine packages.
        </span>
    </div>

    <div class="row">
        @forelse($handoverOrders as $ho)
        <div class="col-md-6" style="margin-bottom: 20px;">
            <div style="background: #F8FAFC; border: 1.5px solid var(--card-border); border-radius: 12px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px;">
                    <div>
                        <span style="font-size: 11px; font-weight: 700; color: var(--text-muted);">PACKAGE ID</span>
                        <h4 style="margin: 0; font-weight: 900; color: var(--navy-primary); font-size: 16px;">{{ $ho->order_code }}</h4>
                    </div>
                    <span class="label label-info" style="font-size: 11.5px; padding: 4px 10px; border-radius: 12px;">READY_FOR_HANDOFF</span>
                </div>

                <!-- Assigned Rider Information Card -->
                <div style="background: #FFF; border: 1px solid var(--card-border); border-radius: 8px; padding: 12px 16px; margin-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #E0F2FE; color: var(--accent-cyan); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div>
                            <div style="font-weight: 800; font-size: 14px; color: var(--navy-primary);">Rahul Yadav (Fleet ID: UPR-4412)</div>
                            <div style="font-size: 12px; color: var(--text-muted);"><i class="fas fa-phone-alt"></i> +91 9839445566 &bull; Bike: UP-65-BX-4412</div>
                            <div style="font-size: 12px; color: #059669; font-weight: 700; margin-top: 2px;">
                                <i class="fas fa-map-marker-alt"></i> Proximity: <strong>At Store Entrance (0.1 km)</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 14px;">
                    Patient: <strong>{{ $ho->customer_name }}</strong> &bull; Total Amount: <strong>₹{{ number_format($ho->total_amount, 2) }}</strong> (COD)
                </div>

                <!-- 4-Digit Handover Security Verification Input -->
                <div style="background: #FFF; border: 1.5px dashed var(--accent-cyan); border-radius: 8px; padding: 14px; display: flex; gap: 10px; align-items: center;">
                    <div style="flex: 1;">
                        <label style="font-size: 11px; font-weight: 800; color: var(--navy-primary); text-transform: uppercase; margin-bottom: 4px; display: block;">
                            <i class="fas fa-key text-warning"></i> Rider 4-Digit Handover Code
                        </label>
                        <input type="password" id="handoverCode_{{ $ho->id }}" class="form-control input-sm text-center" placeholder="••••" maxlength="4" style="font-size: 18px; letter-spacing: 6px; font-weight: 800; height: 38px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; opacity: 0;">Action</label>
                        <button type="button" class="btn btn-sm" onclick="submitHandoverVerification({{ $ho->id }})" style="background: var(--success-green); color: #FFF; font-weight: 800; height: 38px; padding: 0 20px; border-radius: 6px; border: none;">
                            <i class="fas fa-check"></i> Dispatch
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-xs-12">
            <div class="text-center" style="padding: 40px; color: var(--text-muted);">
                <i class="fas fa-check-circle" style="font-size: 36px; color: #10B981; margin-bottom: 10px;"></i>
                <h4>No packages waiting for rider handover</h4>
                <p>New packed orders will appear here automatically when UPCHAR riders arrive for pickup.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
function submitHandoverVerification(orderId) {
    const code = $(`#handoverCode_${orderId}`).val().trim();
    if (code.length < 4) {
        alert('Please enter the 4-digit code provided by the UPCHAR delivery rider.');
        $(`#handoverCode_${orderId}`).focus();
        return;
    }

    $.ajax({
        url: '{{ url("medical-dashboard/handover/verify") }}',
        type: 'POST',
        data: {
            order_id: orderId,
            handover_code: code,
            _token: '{{ csrf_token() }}'
        },
        success: function(resp) {
            alert(resp.message || 'Rider handover verified successfully! Order is now IN_TRANSIT.');
            window.location.reload();
        },
        error: function(xhr) {
            let msg = 'Handover verification failed.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            alert(msg);
        }
    });
}
</script>
@endsection
