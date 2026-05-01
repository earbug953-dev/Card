@extends('layouts.app')
@section('title', 'Receipt ' . $sale->receipt_number)
@section('breadcrumb-parent', 'Sales')
@section('breadcrumb-current', $sale->receipt_number)

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Receipt</h1>
        <p>{{ $sale->receipt_number }} — {{ $sale->created_at->format('F d, Y') }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Sales
        </a>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> Print
        </button>
        @if($sale->payment_status === 'pending')
        <form method="POST" action="{{ route('sales.markPaid', $sale) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button class="btn btn-success"><i class="fas fa-check"></i> Mark as Paid</button>
        </form>
        @endif
    </div>
</div>

<div style="display:grid; grid-template-columns: 1.4fr 1fr; gap:20px; align-items:start;" id="receiptContent">

    <!-- Receipt Panel -->
    <div class="panel">
        <!-- Receipt Header -->
        <div style="background: linear-gradient(135deg, #13141A, #0C0D10); padding:32px; border-bottom:1px solid var(--border-subtle); position:relative; overflow:hidden;">
            <div style="position:absolute; top:-40px; right:-40px; width:160px; height:160px; background:radial-gradient(circle, rgba(201,168,76,0.12), transparent); border-radius:50%;"></div>
            <div style="display:flex; justify-content:space-between; align-items:flex-start; position:relative;">
                <div>
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                        <div style="width:36px; height:36px; background:linear-gradient(135deg,var(--gold-dark),var(--gold)); border-radius:9px; display:flex; align-items:center; justify-content:center; color:var(--bg-dark); font-size:15px;">
                            <i class="fas fa-crown"></i>
                        </div>
                        <span style="font-family:var(--font-display); font-size:20px; font-weight:600; color:var(--gold-light);">Membership Card</span>
                    </div>
                    <div style="font-size:12px; color:var(--text-muted);">Official Sales Receipt</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-family:var(--font-display); font-size:28px; font-weight:700; color:var(--text-primary);">
                        ${{ number_format($sale->amount, 2) }}
                    </div>
                    @if($sale->payment_status === 'paid')
                        <span class="badge badge-success" style="margin-top:4px;"><i class="fas fa-check-circle"></i> PAID</span>
                    @else
                        <span class="badge badge-warning" style="margin-top:4px;"><i class="fas fa-clock"></i> PENDING</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Receipt Body -->
        <div style="padding:28px;">
            <div style="font-family:var(--font-display); font-size:13px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1.5px; margin-bottom:20px;">
                Receipt Details
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0; border:1px solid var(--border-subtle); border-radius:12px; overflow:hidden;">
                <div style="padding:14px 18px; border-right:1px solid var(--border-subtle); border-bottom:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Receipt No.</div>
                    <div style="font-size:14px; font-weight:600; color:var(--gold); font-family:monospace;">{{ $sale->receipt_number }}</div>
                </div>
                <div style="padding:14px 18px; border-bottom:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Date</div>
                    <div style="font-size:14px; color:var(--text-primary);">{{ $sale->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div style="padding:14px 18px; border-right:1px solid var(--border-subtle); border-bottom:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Member</div>
                    <div style="font-size:14px; color:var(--text-primary);">{{ $sale->member->name ?? 'N/A' }}</div>
                    <div style="font-size:12px; color:var(--text-muted);">{{ $sale->member->email ?? '' }}</div>
                </div>
                <div style="padding:14px 18px; border-bottom:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Plan</div>
                    <div style="font-size:14px; color:var(--text-primary);">{{ $sale->plan->name ?? 'N/A' }}</div>
                    <div style="font-size:12px; color:var(--text-muted);">{{ $sale->plan->duration_months ?? '' }} month(s)</div>
                </div>
                <div style="padding:14px 18px; border-right:1px solid var(--border-subtle); border-bottom:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Payment Method</div>
                    <div style="font-size:14px; color:var(--text-primary);">{{ ucfirst(str_replace('_',' ', $sale->payment_method)) }}</div>
                </div>
                <div style="padding:14px 18px; border-bottom:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Reference</div>
                    <div style="font-size:13px; color:var(--text-primary); font-family:monospace;">{{ $sale->reference ?? '—' }}</div>
                </div>
                @if($sale->membershipCard)
                <div style="padding:14px 18px; border-right:1px solid var(--border-subtle);">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Card Number</div>
                    <div style="font-size:13px; color:var(--gold); font-family:monospace; letter-spacing:2px;">{{ $sale->membershipCard->formatted_number }}</div>
                </div>
                <div style="padding:14px 18px;">
                    <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Card Expires</div>
                    <div style="font-size:14px; color:var(--text-primary);">{{ $sale->membershipCard->expiry_date?->format('M d, Y') ?? 'N/A' }}</div>
                </div>
                @endif
            </div>

            <!-- Total -->
            <div style="margin-top:20px; padding:20px; background:var(--gold-muted); border:1px solid rgba(201,168,76,0.2); border-radius:12px; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:4px;">Total Amount</div>
                    <div style="font-family:var(--font-display); font-size:36px; font-weight:700; color:var(--gold);">
                        ${{ number_format($sale->amount, 2) }}
                    </div>
                </div>
                @if($sale->payment_status === 'paid')
                <div style="width:70px; height:70px; border:3px solid var(--success); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--success); font-size:28px;">
                    <i class="fas fa-check"></i>
                </div>
                @else
                <div style="width:70px; height:70px; border:3px solid var(--warning); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--warning); font-size:28px;">
                    <i class="fas fa-clock"></i>
                </div>
                @endif
            </div>

            @if($sale->notes)
            <div style="margin-top:16px; padding:14px 18px; background:var(--bg-elevated); border-radius:10px;">
                <div style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:6px;">Notes</div>
                <p style="font-size:13.5px; color:var(--text-secondary);">{{ $sale->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div style="padding:18px 28px; border-top:1px solid var(--border-subtle); text-align:center; font-size:12px; color:var(--text-muted);">
            Thank you for your membership. For queries, contact management.
        </div>
    </div>

    <!-- Right Column -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Membership Card Visual -->
        @if($sale->membershipCard)
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Issued Card</div></div>
            <div class="panel-body" style="display:flex; justify-content:center;">
                <div class="membership-card-visual" style="width:100%; max-width:100%;">
                    <div class="card-chip"></div>
                    <div class="card-number">{{ $sale->membershipCard->formatted_number }}</div>
                    <div class="card-bottom">
                        <div>
                            <div class="card-holder-label">Card Holder</div>
                            <div class="card-holder-name">{{ strtoupper($sale->member->name ?? 'MEMBER') }}</div>
                        </div>
                        <div>
                            <div class="card-plan">{{ strtoupper($sale->plan->name ?? '') }}</div>
                            <div class="card-expiry-label">Expires</div>
                            <div class="card-expiry-val">{{ $sale->membershipCard->expiry_date?->format('m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Member Quick Info -->
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Member</div></div>
            <div class="panel-body">
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:18px;">
                    <div style="width:52px; height:52px; background:linear-gradient(135deg,var(--gold-dark),var(--gold)); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; color:var(--bg-dark);">
                        {{ strtoupper(substr($sale->member->name ?? 'M', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:15px; font-weight:500; color:var(--text-primary);">{{ $sale->member->name ?? 'N/A' }}</div>
                        <div style="font-size:12px; color:var(--text-muted);">{{ $sale->member->email ?? '' }}</div>
                    </div>
                </div>
                <a href="{{ route('members.show', $sale->member_id) }}" class="btn btn-secondary btn-sm" style="width:100%; justify-content:center;">
                    <i class="fas fa-user"></i> View Member Profile
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Actions</div></div>
            <div class="panel-body" style="display:flex; flex-direction:column; gap:10px;">
                <button onclick="window.print()" class="btn btn-secondary" style="width:100%; justify-content:center;">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                @if($sale->payment_status === 'pending')
                <form method="POST" action="{{ route('sales.markPaid', $sale) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-success" style="width:100%; justify-content:center;">
                        <i class="fas fa-check-circle"></i> Mark as Paid
                    </button>
                </form>
                @endif
                <a href="{{ route('sales.create') }}" class="btn btn-primary" style="justify-content:center;">
                    <i class="fas fa-plus"></i> New Sale
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .page-header-actions, .btn, form { display: none !important; }
    .main-wrapper { margin-left: 0; }
    #receiptContent { grid-template-columns: 1fr; }
}
</style>
@endpush
@endsection
