@extends('pharmacy.dashboard.layout')

@section('title', 'Pharmacy Master Dashboard - UPCHAR')
@section('page_title', 'Pharmacy Command Dashboard')

@section('content')
<!-- 1. KPI Bento Grid -->
<div class="kpi-grid">
    <div class="kpi-card success">
        <div class="kpi-label">Today's Gross Sales</div>
        <div class="kpi-value">₹{{ number_format($todaySales ?? 4850.00, 2) }}</div>
        <div class="kpi-sub"><i class="fas fa-arrow-up"></i> +14.2% vs yesterday</div>
    </div>

    <div class="kpi-card danger">
        <div class="kpi-label">Pending Prescriptions</div>
        <div class="kpi-value">{{ $pendingRxCount ?? 3 }}</div>
        <div class="kpi-sub" style="color: var(--emergency-red);"><i class="fas fa-hourglass-half"></i> Pharmacist Review Required</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-label">Ready for Pickup</div>
        <div class="kpi-value">{{ $readyForPickupCount ?? 4 }}</div>
        <div class="kpi-sub" style="color: var(--accent-cyan);"><i class="fas fa-motorcycle"></i> UPCHAR Fleet Dispatched</div>
    </div>

    <div class="kpi-card" style="--kpi-border: #F59E0B;">
        <div class="kpi-label">Low Stock Alerts</div>
        <div class="kpi-value">{{ $lowStockCount ?? 2 }}</div>
        <div class="kpi-sub" style="color: #D97706;"><i class="fas fa-exclamation-triangle"></i> Batches &lt; 10 units</div>
    </div>

    <div class="kpi-card navy">
        <div class="kpi-label">Wallet / Payout Balance</div>
        <div class="kpi-value">₹{{ number_format($walletBalance ?? 17406.40, 2) }}</div>
        <div class="kpi-sub" style="color: var(--navy-primary);"><i class="fas fa-calendar-check"></i> Next Settlement: Wednesday</div>
    </div>
</div>

<!-- 2. Live Order Radar & Incoming Stream -->
<div class="dash-card">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 14px; margin-bottom: 18px;">
        <div>
            <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--navy-primary); display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #10B981; animation: pulse 1.5s infinite;"></span>
                Live Order Radar (Real-Time Stream)
            </h3>
            <span style="font-size: 12.5px; color: var(--text-muted);">Incoming patient orders automatically routed by GPS proximity</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ url('medical-dashboard/inventory') }}" class="btn btn-sm" style="background: var(--navy-primary); color: #FFF; font-weight: 700; border-radius: 6px; padding: 7px 16px;">
                <i class="fas fa-plus-circle"></i> Add Inward Stock
            </a>
            <button type="button" class="btn btn-sm btn-default" onclick="triggerOrderChime()" title="Test Audio Chime">
                <i class="fas fa-bell"></i> Audio Chime
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" style="margin-bottom: 0;">
            <thead>
                <tr style="background: #F8FAFC; color: var(--text-muted); font-size: 12px; font-weight: 700; text-transform: uppercase;">
                    <th>Order Code</th>
                    <th>Patient Name &amp; Phone</th>
                    <th>Total Amount</th>
                    <th>Prescription Status</th>
                    <th>Order Status</th>
                    <th>Time Received</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($liveOrders ?? [] as $ord)
                <tr>
                    <td style="font-weight: 800; color: var(--navy-primary);">{{ $ord->order_code }}</td>
                    <td>
                        <strong>{{ $ord->customer_name ?? 'Patient' }}</strong>
                        <div style="font-size: 12px; color: var(--text-muted);"><i class="fas fa-phone-alt"></i> {{ $ord->customer_phone ?? '9839112233' }}</div>
                    </td>
                    <td style="font-weight: 800; color: var(--navy-primary);">₹{{ number_format($ord->total_amount, 2) }}</td>
                    <td>
                        @if($ord->prescription_id)
                            <span class="label label-warning" style="font-size: 11px; padding: 3px 8px;"><i class="fas fa-file-medical"></i> Rx Attached</span>
                        @else
                            <span class="label label-default" style="font-size: 11px; padding: 3px 8px;">OTC Medicine</span>
                        @endif
                    </td>
                    <td>
                        <span class="label label-info" style="font-size: 11px; padding: 4px 10px; border-radius: 10px;">{{ $ord->order_status }}</span>
                    </td>
                    <td style="font-size: 12.5px; color: var(--text-muted);">{{ \Carbon\Carbon::parse($ord->created_at)->diffForHumans() }}</td>
                    <td style="text-align: right;">
                        <a href="{{ url('medical-dashboard/orders') }}" class="btn btn-xs" style="background: var(--accent-cyan); color: #FFF; font-weight: 700; border-radius: 4px; padding: 4px 12px;">
                            Review Order
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 30px; color: var(--text-muted);">
                        <i class="fas fa-check-circle" style="font-size: 32px; color: #10B981; margin-bottom: 8px;"></i>
                        <p style="margin: 0;">All pending orders have been processed and dispatched.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
