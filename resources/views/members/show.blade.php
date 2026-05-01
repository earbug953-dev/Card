@extends('layouts.app')
@section('title', $member->name)
@section('breadcrumb-parent', 'Members')
@section('breadcrumb-current', $member->name)

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $member->name }}</h1>
        <p>Member since {{ $member->created_at->format('F Y') }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('members.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <a href="{{ route('members.edit', $member) }}" class="btn btn-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('sales.create') }}?member={{ $member->id }}" class="btn btn-primary">
            <i class="fas fa-credit-card"></i> Sell Card
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1.6fr; gap:20px; align-items:start;">

    <!-- Left Column -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Member Profile Card -->
        <div class="panel">
            <div class="panel-body" style="text-align:center; padding:32px 24px;">
                <div style="width:80px; height:80px; background: linear-gradient(135deg, var(--gold-dark), var(--gold)); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:700; color:var(--bg-dark); margin:0 auto 16px; box-shadow: 0 8px 24px rgba(201,168,76,0.3);">
                    {{ $member->initials }}
                </div>
                <h2 style="font-family:var(--font-display); font-size:26px; color:var(--text-primary); margin-bottom:4px;">{{ $member->name }}</h2>
                <p style="font-size:13px; color:var(--text-muted); margin-bottom:16px;">{{ $member->email }}</p>

                @if($member->status === 'active')
                    <span class="badge badge-success" style="font-size:13px; padding:6px 16px;"><span class="badge-dot"></span> Active Member</span>
                @elseif($member->status === 'suspended')
                    <span class="badge badge-warning" style="font-size:13px; padding:6px 16px;"><span class="badge-dot"></span> Suspended</span>
                @else
                    <span class="badge badge-muted" style="font-size:13px; padding:6px 16px;"><span class="badge-dot"></span> Inactive</span>
                @endif
            </div>

            <div style="border-top:1px solid var(--border-subtle); padding:20px 24px; display:flex; flex-direction:column; gap:13px;">
                @if($member->phone)
                <div style="display:flex; align-items:center; gap:12px; font-size:13.5px;">
                    <div style="width:32px; height:32px; background:var(--gold-muted); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:13px; flex-shrink:0;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted);">Phone</div>
                        <div style="color:var(--text-primary);">{{ $member->phone }}</div>
                    </div>
                </div>
                @endif

                @if($member->date_of_birth)
                <div style="display:flex; align-items:center; gap:12px; font-size:13.5px;">
                    <div style="width:32px; height:32px; background:var(--info-bg); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--info); font-size:13px; flex-shrink:0;">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted);">Date of Birth</div>
                        <div style="color:var(--text-primary);">{{ $member->date_of_birth->format('M d, Y') }} <span style="color:var(--text-muted);">({{ $member->age }} yrs)</span></div>
                    </div>
                </div>
                @endif

                @if($member->gender)
                <div style="display:flex; align-items:center; gap:12px; font-size:13.5px;">
                    <div style="width:32px; height:32px; background:var(--success-bg); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--success); font-size:13px; flex-shrink:0;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted);">Gender</div>
                        <div style="color:var(--text-primary);">{{ ucfirst($member->gender) }}</div>
                    </div>
                </div>
                @endif

                @if($member->address)
                <div style="display:flex; align-items:center; gap:12px; font-size:13.5px;">
                    <div style="width:32px; height:32px; background:var(--warning-bg); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--warning); font-size:13px; flex-shrink:0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-muted);">Address</div>
                        <div style="color:var(--text-primary);">{{ $member->address }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Active Membership Card Visual -->
        @if($member->activeCard)
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Active Card</div>
                <span class="badge badge-success"><span class="badge-dot"></span>Valid</span>
            </div>
            <div class="panel-body" style="display:flex; flex-direction:column; align-items:center; gap:16px;">
                <div class="membership-card-visual" style="width:100%; max-width:100%;">
                    <div class="card-chip"></div>
                    <div class="card-number">{{ $member->activeCard->formatted_number }}</div>
                    <div class="card-bottom">
                        <div>
                            <div class="card-holder-label">Card Holder</div>
                            <div class="card-holder-name">{{ strtoupper($member->name) }}</div>
                        </div>
                        <div>
                            <div class="card-plan">{{ strtoupper($member->activeCard->plan->name ?? '') }}</div>
                            <div class="card-expiry-label">Expires</div>
                            <div class="card-expiry-val">{{ $member->activeCard->expiry_date?->format('m/Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Expiry Countdown -->
                @php $daysLeft = $member->activeCard->days_until_expiry; @endphp
                @if($daysLeft !== null)
                <div style="width:100%; background:var(--bg-elevated); border-radius:10px; padding:14px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:12px;">
                        <span style="color:var(--text-muted);">Card validity</span>
                        <span style="color: {{ $daysLeft < 30 ? 'var(--warning)' : 'var(--success)' }}; font-weight:600;">
                            {{ $daysLeft > 0 ? "{$daysLeft} days left" : 'Expired' }}
                        </span>
                    </div>
                    @php
                        $totalDays = $member->activeCard->issue_date->diffInDays($member->activeCard->expiry_date);
                        $usedDays  = $member->activeCard->issue_date->diffInDays(now());
                        $pct       = min(100, round(($usedDays / max($totalDays, 1)) * 100));
                    @endphp
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-fill" style="width:{{ $pct }}%; background: {{ $pct > 85 ? 'linear-gradient(90deg, var(--danger), #ff6b6b)' : ($pct > 60 ? 'linear-gradient(90deg, var(--warning), #ffcc00)' : '') }};"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="panel" style="background:var(--gold-muted); border-color:rgba(201,168,76,0.2);">
            <div class="panel-body" style="text-align:center; padding:28px;">
                <i class="fas fa-id-card" style="font-size:32px; color:var(--gold); margin-bottom:12px;"></i>
                <p style="font-size:14px; color:var(--text-secondary); margin-bottom:16px;">No active card for this member</p>
                <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-credit-card"></i> Issue a Card
                </a>
            </div>
        </div>
        @endif

    </div>

    <!-- Right Column -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Stats -->
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label">Total Spent</span>
                    <div class="stat-icon gold"><i class="fas fa-dollar-sign"></i></div>
                </div>
                <div class="stat-value" style="font-size:26px;">${{ number_format($member->sales->where('payment_status','paid')->sum('amount'), 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label">Cards Issued</span>
                    <div class="stat-icon info"><i class="fas fa-id-card"></i></div>
                </div>
                <div class="stat-value" style="font-size:26px;">{{ $member->membershipCards->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label">Transactions</span>
                    <div class="stat-icon success"><i class="fas fa-receipt"></i></div>
                </div>
                <div class="stat-value" style="font-size:26px;">{{ $member->sales->count() }}</div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Transaction History</div>
                    <div class="panel-subtitle">All purchases by this member</div>
                </div>
                <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> New Sale
                </a>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Receipt</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($member->sales->sortByDesc('created_at') as $sale)
                        <tr>
                            <td>
                                <span style="font-family:monospace; font-size:12px; color:var(--gold);">
                                    {{ $sale->receipt_number }}
                                </span>
                            </td>
                            <td><span class="badge badge-gold">{{ $sale->plan->name ?? 'N/A' }}</span></td>
                            <td>
                                <span style="font-family:var(--font-display); font-size:17px; color:var(--text-primary); font-weight:600;">
                                    ${{ number_format($sale->amount, 2) }}
                                </span>
                            </td>
                            <td class="td-muted">{{ ucfirst(str_replace('_',' ',$sale->payment_method)) }}</td>
                            <td>
                                @if($sale->payment_status === 'paid')
                                    <span class="badge badge-success"><span class="badge-dot"></span>Paid</span>
                                @else
                                    <span class="badge badge-warning"><span class="badge-dot"></span>Pending</span>
                                @endif
                            </td>
                            <td class="td-muted">{{ $sale->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:24px; color:var(--text-muted);">
                                No transactions yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- All Cards History -->
        @if($member->membershipCards->count() > 1)
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Card History</div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Card Number</th>
                            <th>Plan</th>
                            <th>Issued</th>
                            <th>Expires</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member->membershipCards->sortByDesc('created_at') as $card)
                        <tr>
                            <td>
                                <span style="font-family:monospace; font-size:12px; letter-spacing:2px; color:var(--gold);">
                                    {{ $card->formatted_number }}
                                </span>
                            </td>
                            <td><span class="badge badge-gold">{{ $card->plan->name ?? 'N/A' }}</span></td>
                            <td class="td-muted">{{ $card->issue_date?->format('M d, Y') }}</td>
                            <td class="td-muted">{{ $card->expiry_date?->format('M d, Y') }}</td>
                            <td>
                                @if($card->status === 'active')
                                    <span class="badge badge-success"><span class="badge-dot"></span>Active</span>
                                @elseif($card->status === 'expired')
                                    <span class="badge badge-warning"><span class="badge-dot"></span>Expired</span>
                                @else
                                    <span class="badge badge-muted"><span class="badge-dot"></span>{{ ucfirst($card->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($member->notes)
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Notes</div></div>
            <div class="panel-body">
                <p style="font-size:13.5px; color:var(--text-secondary); line-height:1.7;">{{ $member->notes }}</p>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
