@extends('layouts.app')
@section('title', 'Card Details')
@section('breadcrumb-parent', 'Membership Cards')
@section('breadcrumb-current', $card->formatted_number)

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Card Details</h1>
        <p>Membership card #{{ $card->formatted_number }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('cards.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
        @if($card->status === 'active')
        <form method="POST" action="{{ route('cards.suspend', $card) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button class="btn btn-secondary"><i class="fas fa-pause"></i> Suspend</button>
        </form>
        @endif
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1.5fr; gap:20px;">

    <div style="display:flex; flex-direction:column; gap:16px;">
        <!-- Card Visual -->
        <div class="panel">
            <div class="panel-body" style="display:flex; justify-content:center;">
                <div class="membership-card-visual" style="width:100%; max-width:100%;">
                    <div class="card-chip"></div>
                    <div class="card-number">{{ $card->formatted_number }}</div>
                    <div class="card-bottom">
                        <div>
                            <div class="card-holder-label">Card Holder</div>
                            <div class="card-holder-name">{{ strtoupper($card->member->name ?? 'MEMBER') }}</div>
                        </div>
                        <div>
                            <div class="card-plan">{{ strtoupper($card->plan->name ?? '') }}</div>
                            <div class="card-expiry-label">Expires</div>
                            <div class="card-expiry-val">{{ $card->expiry_date?->format('m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Info -->
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Card Info</div></div>
            <div class="panel-body" style="display:flex; flex-direction:column; gap:12px;">
                @foreach([
                    ['Status',      ucfirst($card->status),                        'fa-circle'],
                    ['Plan',        $card->plan->name ?? 'N/A',                    'fa-layer-group'],
                    ['Issue Date',  $card->issue_date?->format('M d, Y'),          'fa-calendar-check'],
                    ['Expiry Date', $card->expiry_date?->format('M d, Y'),         'fa-calendar-times'],
                    ['Days Left',   ($card->days_until_expiry ?? 0) . ' days',     'fa-clock'],
                ] as [$label, $value, $icon])
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; background:var(--bg-elevated); border-radius:8px;">
                    <div style="display:flex; align-items:center; gap:9px; font-size:13px; color:var(--text-muted);">
                        <i class="fas {{ $icon }}" style="width:16px; color:var(--gold); font-size:12px;"></i>
                        {{ $label }}
                    </div>
                    <span style="font-size:13.5px; color:var(--text-primary); font-weight:500;">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Member + Sale Info -->
    <div style="display:flex; flex-direction:column; gap:16px;">
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Card Holder</div></div>
            <div class="panel-body">
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:20px;">
                    <div class="member-avatar" style="width:52px; height:52px; font-size:18px;">{{ strtoupper(substr($card->member->name ?? 'M', 0, 1)) }}</div>
                    <div>
                        <div style="font-size:16px; font-weight:500; color:var(--text-primary);">{{ $card->member->name }}</div>
                        <div style="font-size:13px; color:var(--text-muted);">{{ $card->member->email }}</div>
                    </div>
                </div>
                <a href="{{ route('members.show', $card->member_id) }}" class="btn btn-secondary btn-sm" style="width:100%; justify-content:center;">
                    <i class="fas fa-user"></i> View Member Profile
                </a>
            </div>
        </div>

        @if($card->sale)
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Purchase Info</div></div>
            <div class="panel-body">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:14px; background:var(--gold-muted); border:1px solid rgba(201,168,76,0.2); border-radius:10px; margin-bottom:14px;">
                    <span style="font-size:14px; color:var(--text-muted);">Amount Paid</span>
                    <span style="font-family:var(--font-display); font-size:28px; font-weight:700; color:var(--gold);">${{ number_format($card->sale->amount, 2) }}</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:10px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted);">Receipt No.</span>
                        <a href="{{ route('sales.show', $card->sale) }}" style="color:var(--gold); font-family:monospace;">{{ $card->sale->receipt_number }}</a>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted);">Payment Method</span>
                        <span style="color:var(--text-primary);">{{ ucfirst(str_replace('_',' ',$card->sale->payment_method)) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted);">Payment Status</span>
                        @if($card->sale->payment_status === 'paid')
                            <span class="badge badge-success"><span class="badge-dot"></span>Paid</span>
                        @else
                            <span class="badge badge-warning"><span class="badge-dot"></span>Pending</span>
                        @endif
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted);">Sale Date</span>
                        <span style="color:var(--text-primary);">{{ $card->sale->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="panel">
            <div class="panel-header"><div class="panel-title">Danger Zone</div></div>
            <div class="panel-body">
                <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('Permanently delete this card? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" style="width:100%; justify-content:center;">
                        <i class="fas fa-trash"></i> Delete This Card
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
