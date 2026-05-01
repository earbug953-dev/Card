@extends('layouts.public')
@section('title', 'My Membership Dashboard')

@section('content')
<div class="fan-portal">

    <div class="fan-portal-header">
        <div>
            <div style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:2px;color:var(--gold);margin-bottom:8px;">
                <i class="fas fa-crown"></i> VIP Member Portal
            </div>
            <h1>Welcome back, {{ session('fan_name', 'Member') }}! 👋</h1>
            <p>Manage your VIP membership and access your exclusive benefits.</p>
        </div>
        <div style="display:flex;gap:10px;flex-shrink:0;">
            <a href="{{ route('fan.my-card') }}" style="display:flex;align-items:center;gap:8px;padding:10px 18px;background:linear-gradient(135deg,#8A6820,#C9A84C);border-radius:10px;font-size:13.5px;color:#0a0a0a;font-weight:600;text-decoration:none;">
                <i class="fas fa-id-card"></i> View My Card
            </a>
            <form method="POST" action="{{ route('fan.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:var(--ink-2);border:1px solid rgba(255,255,255,0.08);border-radius:10px;font-size:13.5px;color:var(--white-muted);cursor:pointer;font-family:var(--font-body);">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>
    </div>

    @if($member && $member->activeCard)
    <div class="fan-portal-inner">

        <!-- Left: Mini Card Preview -->
        <div class="digital-card-wrap">
            <!-- Mini digital card -->
            <div class="digital-card">
                <div class="dc-top">
                    <div class="dc-brand">
                        <div class="dc-brand-icon">👑</div>
                        <div><div class="dc-brand-name">MEMBERSHIP CARD</div></div>
                    </div>
                    <div class="dc-chip"></div>
                </div>

                <div style="display:flex;align-items:center;gap:12px;position:relative;z-index:1;">
                    @if($member->photo_path)
                        <img src="{{ asset('storage/'.$member->photo_path) }}" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);flex-shrink:0;">
                    @else
                        <div style="width:56px;height:56px;border-radius:50%;background:rgba(201,168,76,0.15);border:2px solid rgba(201,168,76,0.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:var(--font-display);font-size:22px;color:var(--gold);">
                            {{ strtoupper(substr($member->first_name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <div style="font-size:9px;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1.5px;">Member</div>
                        <div style="font-size:14px;font-weight:700;color:var(--white);letter-spacing:1px;text-transform:uppercase;">{{ $member->first_name }} {{ $member->last_name }}</div>
                    </div>
                </div>

                <div class="dc-number" style="font-size:16px;letter-spacing:4px;">{{ implode(' ', str_split($member->activeCard->card_number ?? '0000000000000000', 4)) }}</div>

                <div class="dc-bottom">
                    <div>
                        <div class="dc-holder-label">Address</div>
                        <div class="dc-holder-name" style="font-size:11px;letter-spacing:0.5px;">{{ Str::limit($member->address, 30) }}</div>
                    </div>
                    <div class="dc-right">
                        <div class="dc-plan">{{ strtoupper($member->activeCard->plan->name ?? 'VIP') }}</div>
                        <div class="dc-expiry-label">Expires</div>
                        <div class="dc-expiry-val">{{ $member->activeCard->expiry_date?->format('m/Y') }}</div>
                    </div>
                </div>
                <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:linear-gradient(90deg,transparent,#9A7A2E,#FFD700,#9A7A2E,transparent);z-index:5;"></div>
            </div>

            <!-- Status bar -->
            @php
                $daysLeft = max(0, $member->activeCard->expiry_date?->diffInDays(now()) ?? 0);
                $totalDays = ($member->activeCard->plan->duration_months ?? 12) * 30;
                $pct = min(100, max(0, round(($daysLeft / $totalDays) * 100)));
            @endphp
            <div class="card-status-bar">
                <div class="card-status-row"><span class="l">Days Remaining</span><span class="r" style="color:{{ $daysLeft<30?'var(--warning)':'var(--success)' }};">{{ $daysLeft }} days</span></div>
                <div class="validity-bar"><div class="validity-fill" style="width:{{ $pct }}%;"></div></div>
                <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--white-muted);margin-top:8px;">
                    <span>{{ $member->activeCard->issue_date?->format('M d, Y') }}</span>
                    <span>{{ $member->activeCard->expiry_date?->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Right: Info -->
        <div class="fan-info-panel">

            <!-- Quick actions -->
            <div class="fan-panel">
                <div class="fan-panel-header"><h3>Quick Actions</h3></div>
                <div class="fan-panel-body" style="padding:12px;">
                    @foreach([
                        [route('fan.my-card'), 'fas fa-id-card', 'View My Full Card', 'See your digital VIP card'],
                        [route('fan.chat.index'), 'fas fa-comments', 'Chat with Management', 'Ask questions or get support'],
                        [route('public.plans'), 'fas fa-arrow-up', 'Upgrade My Plan', 'Move to a higher membership tier'],
                    ] as [$href, $icon, $label, $desc])
                    <a href="{{ $href }}" style="display:flex;align-items:center;gap:12px;padding:14px;border-radius:12px;text-decoration:none;margin-bottom:8px;background:var(--ink-3);border:1px solid rgba(255,255,255,0.05);transition:var(--transition);" onmouseover="this.style.borderColor='var(--gold)';this.style.background='var(--gold-glow)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)';this.style.background='var(--ink-3)'">
                        <div style="width:38px;height:38px;border-radius:10px;background:var(--gold-glow);border:1px solid var(--gold-border);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:15px;flex-shrink:0;"><i class="{{ $icon }}"></i></div>
                        <div>
                            <div style="font-size:13.5px;font-weight:500;color:var(--white);">{{ $label }}</div>
                            <div style="font-size:12px;color:var(--white-muted);">{{ $desc }}</div>
                        </div>
                        <i class="fas fa-chevron-right" style="color:var(--white-muted);font-size:12px;margin-left:auto;"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Plan Summary -->
            <div class="fan-panel">
                <div class="fan-panel-header"><h3>Plan Summary</h3><span class="fan-badge fan-badge-gold">{{ $member->activeCard->plan->name }}</span></div>
                <div class="fan-panel-body">
                    <div class="fan-info-grid">
                        <div class="fan-info-item"><div class="fan-info-label">Card Number</div><div class="fan-info-value" style="font-family:monospace;font-size:12px;letter-spacing:1.5px;">{{ implode(' ', str_split($member->activeCard->card_number ?? '----------------', 4)) }}</div></div>
                        <div class="fan-info-item"><div class="fan-info-label">Card ID Code</div><div class="fan-info-value" style="font-family:monospace;font-size:12px;color:var(--gold);letter-spacing:1px;">{{ $member->activeCard->card_code }}</div></div>
                        <div class="fan-info-item"><div class="fan-info-label">Amount Paid</div><div class="fan-info-value" style="color:var(--gold);font-family:var(--font-display);font-size:18px;">${{ number_format($member->activeCard->plan->price, 2) }}</div></div>
                        <div class="fan-info-item"><div class="fan-info-label">Duration</div><div class="fan-info-value">{{ $member->activeCard->plan->duration_months }} Month{{ $member->activeCard->plan->duration_months > 1 ? 's' : '' }}</div></div>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="fan-panel">
                <div class="fan-panel-header"><h3>Active Benefits</h3></div>
                <div class="fan-panel-body">
                    <div class="benefit-tiles">
                        <div class="benefit-tile"><i class="fas fa-star"></i><span>VIP Priority Access</span></div>
                        <div class="benefit-tile"><i class="fas fa-percent"></i><span>Exclusive Discounts</span></div>
                        <div class="benefit-tile"><i class="fas fa-gift"></i><span>Member Events</span></div>
                        <div class="benefit-tile"><i class="fas fa-headset"></i><span>Priority Support</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div style="text-align:center;padding:80px 20px;">
        <i class="fas fa-id-card" style="font-size:48px;color:var(--gold);margin-bottom:20px;display:block;opacity:0.5;"></i>
        <h2 style="font-family:var(--font-display);font-size:28px;font-weight:600;color:var(--white);margin-bottom:12px;">No Active Membership</h2>
        <p style="color:var(--white-muted);font-size:15px;margin-bottom:28px;max-width:400px;margin-left:auto;margin-right:auto;line-height:1.7;">You don't have an active membership card yet. Browse our plans and chat with management to get yours!</p>
        <a href="{{ route('public.plans') }}" class="btn-hero-primary" style="display:inline-flex;">
            <i class="fas fa-id-card"></i> Browse Membership Plans
        </a>
    </div>
    @endif
</div>
@endsection
