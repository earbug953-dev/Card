@extends('layouts.public')
@section('title', 'My Membership Card')

@section('content')
<div class="fan-portal">

    @if(!isset($member))
    {{-- Code entry screen --}}
    <div style="max-width:500px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:48px;">
            <div style="width:72px;height:72px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.25);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 20px;">
                <i class="fas fa-id-card" style="color:var(--gold);"></i>
            </div>
            <h1 style="font-family:var(--font-display);font-size:32px;font-weight:700;color:var(--white);margin-bottom:8px;">Your Membership Card</h1>
            <p style="color:var(--white-muted);font-size:15px;line-height:1.65;">Enter your VIP Card ID code — issued by management after payment approval — to view your official digital card.</p>
        </div>

        @if(session('fan_member_id'))
        {{-- Logged in fan - show their card directly --}}
        <div style="text-align:center;padding:20px;background:rgba(201,168,76,0.06);border:1px solid rgba(201,168,76,0.15);border-radius:14px;margin-bottom:24px;">
            <i class="fas fa-user-circle" style="font-size:20px;color:var(--gold);margin-right:8px;"></i>
            Signed in as <strong style="color:var(--white);">{{ session('fan_name') }}</strong> ·
            <a href="{{ route('fan.dashboard') }}" style="color:var(--gold);text-decoration:none;">View My Dashboard →</a>
        </div>
        @endif

        <form action="{{ route('fan.my-card.lookup') }}" method="POST" style="background:var(--ink-2);border:1px solid rgba(255,255,255,0.06);border-radius:20px;padding:32px;">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:var(--white-muted);display:block;margin-bottom:8px;">
                    <i class="fas fa-key" style="color:var(--gold);margin-right:5px;"></i>VIP Card ID Code
                </label>
                <input type="text" name="card_code" value="{{ old('card_code') }}"
                    placeholder="e.g. VIP-2024-XXXX-XXXX"
                    style="width:100%;background:var(--ink-3);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px 18px;color:var(--white);font-family:monospace;font-size:16px;letter-spacing:3px;outline:none;box-sizing:border-box;transition:var(--transition);text-transform:uppercase;"
                    onfocus="this.style.borderColor='var(--gold)';this.style.boxShadow='0 0 0 3px var(--gold-glow)'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.08)';this.style.boxShadow='none'"
                    required>
                @error('card_code')
                    <div style="font-size:13px;color:var(--danger);margin-top:8px;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" style="width:100%;padding:16px;background:linear-gradient(135deg,#8A6820,#C9A84C);color:#0a0a0a;border:none;border-radius:12px;font-family:var(--font-body);font-size:15px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;">
                <i class="fas fa-id-card"></i> View My VIP Card
            </button>
        </form>

        <div style="text-align:center;margin-top:24px;font-size:13.5px;color:var(--white-muted);line-height:1.7;">
            Don't have a code yet?
            <a href="{{ route('public.plans') }}" style="color:var(--gold);text-decoration:none;margin:0 4px;">Buy a Membership Card</a> and chat with our team.<br>
            Already signed up?
            <a href="{{ route('fan.login') }}" style="color:var(--gold);text-decoration:none;margin:0 4px;">Sign in to your portal</a>
        </div>
    </div>

    @else
    {{-- Show the actual card --}}
    <div class="fan-portal-header">
        <div>
            <h1>Your VIP Membership Card</h1>
            <p>Welcome to the club, {{ $member->first_name }}! 👑 Your official card is below.</p>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('fan.dashboard') }}" style="display:flex;align-items:center;gap:8px;padding:10px 18px;background:var(--ink-2);border:1px solid rgba(255,255,255,0.08);border-radius:10px;font-size:13.5px;color:var(--white-dim);text-decoration:none;">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('public.plans') }}" style="display:flex;align-items:center;gap:8px;padding:10px 18px;background:linear-gradient(135deg,#8A6820,#C9A84C);border-radius:10px;font-size:13.5px;color:#0a0a0a;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-up"></i> Upgrade
            </a>
        </div>
    </div>

    <div class="fan-portal-inner">

        <!-- Digital Card + Status -->
        <div class="digital-card-wrap">

            <div class="digital-card" id="memberCard">
                <!-- Top row -->
                <div class="dc-top">
                    <div class="dc-brand">
                        <div class="dc-brand-icon">👑</div>
                        <div>
                            <div class="dc-brand-name">MEMBERSHIP CARD</div>
                            <div style="font-size:9px;color:rgba(255,255,255,0.3);letter-spacing:1px;text-transform:uppercase;">Official · Verified</div>
                        </div>
                    </div>
                    <div class="dc-chip"></div>
                </div>

                <!-- Member photo + name -->
                <div style="display:flex;align-items:center;gap:16px;position:relative;z-index:1;">
                    @if($member->photo_path)
                        <img src="{{ asset('storage/'.$member->photo_path) }}" alt="{{ $member->first_name }}"
                             style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid var(--gold);flex-shrink:0;">
                    @else
                        <div style="width:72px;height:72px;border-radius:50%;background:rgba(201,168,76,0.15);border:3px solid rgba(201,168,76,0.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:var(--font-display);font-size:28px;color:var(--gold);">
                            {{ strtoupper(substr($member->first_name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <div style="font-size:9px;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35);margin-bottom:3px;">Member</div>
                        <div style="font-size:18px;font-weight:700;color:var(--white);letter-spacing:1px;text-transform:uppercase;">{{ $member->first_name }} {{ $member->last_name }}</div>
                        <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:2px;">{{ $member->address }}</div>
                    </div>
                </div>

                <!-- Card number -->
                <div class="dc-number">{{ implode(' ', str_split($member->activeCard->card_number ?? '0000000000000000', 4)) }}</div>

                <!-- Bottom -->
                <div class="dc-bottom">
                    <div>
                        <div class="dc-holder-label">Activation Fee Paid</div>
                        <div class="dc-holder-name" style="color:var(--gold);font-size:16px;font-family:var(--font-display);">${{ number_format($member->activeCard->plan->price ?? 0, 2) }}</div>
                    </div>
                    <div class="dc-right">
                        <div class="dc-plan">{{ strtoupper($member->activeCard->plan->name ?? 'VIP') }}</div>
                        <div class="dc-expiry-label">Valid Until</div>
                        <div class="dc-expiry-val">{{ $member->activeCard->expiry_date?->format('m / Y') ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Gold bar -->
                <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:linear-gradient(90deg,transparent,#9A7A2E,#FFD700,#9A7A2E,transparent);z-index:5;"></div>
            </div>

            <!-- Validity bar -->
            <div class="card-status-bar">
                @php
                    $days = $member->activeCard?->expiry_date?->diffInDays(now(), false) ?? 0;
                    $total = $member->activeCard?->plan?->duration_months * 30 ?? 365;
                    $elapsed = max(0, min(100, 100 - round($days / $total * 100)));
                    $daysLeft = max(0, $member->activeCard?->expiry_date?->diffInDays(now()) ?? 0);
                @endphp
                <div class="card-status-row">
                    <span class="l">Card Validity</span>
                    <span class="r" style="color:{{ $daysLeft < 30 ? 'var(--warning)' : 'var(--success)' }};">
                        {{ $daysLeft }} days remaining
                    </span>
                </div>
                <div class="validity-bar">
                    <div class="validity-fill" style="width:{{ 100 - $elapsed }}%;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--white-muted);margin-top:8px;">
                    <span>{{ $member->activeCard?->issue_date?->format('M d, Y') ?? 'Issue date' }}</span>
                    <span>Expires {{ $member->activeCard?->expiry_date?->format('M d, Y') ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Download/Share -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <button onclick="printCard()" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:var(--ink-2);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:var(--white-dim);font-family:var(--font-body);font-size:13.5px;cursor:pointer;transition:var(--transition);" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)';this.style.color='var(--white-dim)'">
                    <i class="fas fa-print"></i> Print Card
                </button>
                <button onclick="copyCode()" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:var(--ink-2);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:var(--white-dim);font-family:var(--font-body);font-size:13.5px;cursor:pointer;transition:var(--transition);" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)';this.style.color='var(--white-dim)'">
                    <i class="fas fa-copy"></i> Copy Card ID
                </button>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="fan-info-panel">

            <!-- Membership Details -->
            <div class="fan-panel">
                <div class="fan-panel-header">
                    <h3>Membership Details</h3>
                    <span class="fan-badge fan-badge-active"><i class="fas fa-circle" style="font-size:7px;"></i> Active</span>
                </div>
                <div class="fan-panel-body">
                    <div class="fan-info-grid">
                        <div class="fan-info-item">
                            <div class="fan-info-label">Full Name</div>
                            <div class="fan-info-value">{{ $member->first_name }} {{ $member->last_name }}</div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Plan</div>
                            <div class="fan-info-value"><span class="fan-badge fan-badge-gold">{{ $member->activeCard->plan->name ?? 'N/A' }}</span></div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Card Number</div>
                            <div class="fan-info-value" style="font-family:monospace;font-size:13px;letter-spacing:2px;">
                                {{ implode(' ', str_split($member->activeCard->card_number ?? '0000000000000000', 4)) }}
                            </div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Card ID Code</div>
                            <div class="fan-info-value" style="font-family:monospace;font-size:13px;letter-spacing:1.5px;color:var(--gold);">{{ $member->activeCard->card_code ?? 'N/A' }}</div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Issue Date</div>
                            <div class="fan-info-value">{{ $member->activeCard?->issue_date?->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Expiry Date</div>
                            <div class="fan-info-value">{{ $member->activeCard?->expiry_date?->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Email</div>
                            <div class="fan-info-value" style="font-size:13px;">{{ $member->email }}</div>
                        </div>
                        <div class="fan-info-item">
                            <div class="fan-info-label">Phone</div>
                            <div class="fan-info-value">{{ $member->phone }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="fan-panel">
                <div class="fan-panel-header">
                    <h3>Your Member Benefits</h3>
                    <span class="fan-badge fan-badge-gold">{{ $member->activeCard->plan->name ?? 'VIP' }}</span>
                </div>
                <div class="fan-panel-body">
                    <div class="benefit-tiles">
                        <div class="benefit-tile"><i class="fas fa-star"></i><span>VIP Priority Access</span></div>
                        <div class="benefit-tile"><i class="fas fa-percent"></i><span>Member Discounts</span></div>
                        <div class="benefit-tile"><i class="fas fa-gift"></i><span>Exclusive Events</span></div>
                        <div class="benefit-tile"><i class="fas fa-headset"></i><span>Priority Support</span></div>
                        <div class="benefit-tile"><i class="fas fa-id-card"></i><span>Digital Card Access</span></div>
                        <div class="benefit-tile"><i class="fas fa-shield-alt"></i><span>Verified Member Status</span></div>
                    </div>
                </div>
            </div>

            <!-- Renewal CTA -->
            @if($daysLeft < 60)
            <div style="background:linear-gradient(135deg,rgba(201,168,76,0.1),rgba(201,168,76,0.05));border:1px solid rgba(201,168,76,0.25);border-radius:16px;padding:22px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                    <i class="fas fa-clock" style="color:var(--warning);font-size:18px;"></i>
                    <strong style="color:var(--white);font-size:15px;">Your card expires soon</strong>
                </div>
                <p style="font-size:13.5px;color:var(--white-muted);line-height:1.65;margin-bottom:16px;">
                    Renew your membership to keep enjoying all your exclusive benefits and VIP access.
                </p>
                <a href="{{ route('public.plans') }}" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px 20px;background:linear-gradient(135deg,#8A6820,#C9A84C);border-radius:10px;font-size:14px;font-weight:700;color:#0a0a0a;text-decoration:none;">
                    <i class="fas fa-redo"></i> Renew Membership
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function printCard(){
    const c=document.getElementById('memberCard');
    if(!c)return;
    const w=window.open('','_blank');
    w.document.write(`<html><head><title>My VIP Card</title><style>body{margin:0;background:#0a0a0a;display:flex;align-items:center;justify-content:center;min-height:100vh;}@media print{@page{margin:0;}}</style></head><body>${c.outerHTML}<script>window.onload=()=>window.print();<\/script></body></html>`);
    w.document.close();
}
function copyCode(){
    const code='{{ $member->activeCard->card_code ?? "" }}';
    navigator.clipboard.writeText(code).then(()=>{alert('Card ID copied: '+code);});
}
</script>
@endpush
@endsection
