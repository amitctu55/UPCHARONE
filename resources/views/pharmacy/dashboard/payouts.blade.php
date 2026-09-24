@extends('pharmacy.dashboard.layout')

@section('title', 'Payments & Payouts Ledger - UPCHAR')
@section('page_title', 'Settlements Ledger & Banking Configuration')

@section('content')
<div class="row">
    <!-- Settlement Cycles & Bank Account Card -->
    <div class="col-md-4">
        <div class="dash-card">
            <h4 style="margin: 0 0 14px; font-weight: 800; font-size: 15px; color: var(--navy-primary);">
                <i class="fas fa-university" style="color: var(--accent-cyan);"></i> Verified Settlement Bank Account
            </h4>
            <div style="background: #F8FAFC; border: 1px solid var(--card-border); border-radius: 8px; padding: 14px; margin-bottom: 16px;">
                <div style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Primary Payout Account</div>
                <div style="font-size: 16px; font-weight: 900; color: var(--navy-primary); letter-spacing: 1px; margin: 4px 0;">
                    •••• •••• 3940
                </div>
                <div style="font-size: 12px; color: #475569;">HDFC Bank &bull; Maldahiya Branch</div>
                <div style="font-size: 12px; color: #475569;">IFSC: <strong>HDFC0001254</strong></div>
                <div style="margin-top: 6px;">
                    <span class="label label-success" style="background: var(--success-green); font-size: 10px;">
                        <i class="fas fa-check-circle"></i> Penniless Drop Verified
                    </span>
                </div>
            </div>

            <div style="border-top: 1px solid var(--card-border); padding-top: 14px;">
                <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">SETTLEMENT CYCLE</div>
                <div style="font-size: 13.5px; font-weight: 700; color: var(--navy-primary);">
                    <i class="fas fa-calendar-alt text-primary"></i> Weekly Remittance (Every Wednesday)
                </div>
                <small style="color: var(--text-muted); font-size: 11.5px; display: block; margin-top: 4px;">
                    All orders marked DELIVERED up to Sunday 23:59 are settled via NEFT/RTGS after 8.00% UPCHAR platform take-rate deduction.
                </small>
            </div>
        </div>
    </div>

    <!-- Settlement History Ledger -->
    <div class="col-md-8">
        <div class="dash-card">
            <h4 style="margin: 0 0 16px; font-weight: 800; font-size: 15px; color: var(--navy-primary);">
                <i class="fas fa-history" style="color: var(--navy-primary);"></i> Weekly Settlement Cycles
            </h4>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr style="background: #F8FAFC; color: var(--text-muted); font-size: 11.5px; font-weight: 700; text-transform: uppercase;">
                            <th>Period</th>
                            <th>Gross Sales</th>
                            <th>UPCHAR (8%)</th>
                            <th>Net Payable</th>
                            <th>UTR Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settlements as $s)
                        <tr>
                            <td>
                                <strong>{{ date('d M', strtotime($s->settlement_period_start)) }} - {{ date('d M Y', strtotime($s->settlement_period_end)) }}</strong>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $s->order_count ?? 28 }} completed orders</div>
                            </td>
                            <td>₹{{ number_format($s->gross_sales, 2) }}</td>
                            <td style="color: var(--emergency-red); font-weight: 700;">-₹{{ number_format($s->upchar_commission, 2) }}</td>
                            <td style="font-weight: 900; color: #059669;">₹{{ number_format($s->net_payout, 2) }}</td>
                            <td>
                                @if($s->utr_number)
                                    <span style="font-family: monospace; font-size: 11px; background: #F1F5F9; padding: 2px 6px; border-radius: 4px;">{{ $s->utr_number }}</span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 11px;">In Batch Queue</span>
                                @endif
                            </td>
                            <td>
                                @if($s->settlement_status === 'PAID')
                                    <span class="label label-success" style="background: var(--success-green); font-size: 10.5px;">PAID</span>
                                @elseif($s->settlement_status === 'PROCESSING')
                                    <span class="label label-warning" style="font-size: 10.5px;">PROCESSING</span>
                                @else
                                    <span class="label label-info" style="font-size: 10.5px;">DUE</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 30px; color: var(--text-muted);">
                                No settlement records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
