@extends('layouts.public')
@section('title', 'Membership Plans')
@section('meta-desc', 'Browse all VIP membership plans and choose the one that fits you best.')

@section('content')

<div style="padding: calc(var(--nav-h) + 60px) 32px 40px; background: linear-gradient(180deg, var(--ink-2) 0%, var(--ink) 100%); text-align:center;">
    <div class="container">
        <div class="hero-eyebrow" style="display:inline-flex; margin-bottom:20px;">
            <i class="fas fa-layer-group"></i> All Membership Plans
        </div>
        <h1 class="section-title">Choose Your <em>Membership Tier</em></h1>
        <p class="section-subtitle" style="margin: 0 auto;">One payment. Full access. Your exclusive VIP card issued immediately after approval.</p>

        <div style="display:flex; align-items:center; justify-content:center; gap:24px; margin-top:32px; flex-wrap:wrap;">
            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--white-muted);">
                <i class="fas fa-shield-alt" style="color:var(--gold);"></i> 100% Secure
            </div>
            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--white-muted);">
                <i class="fas fa-bolt" style="color:var(--gold);"></i> Instant Card Issuance
            </div>
            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--white-muted);">
                <i class="fas fa-headset" style="color:var(--gold);"></i> Live Chat Support
            </div>
            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--white-muted);">
                <i class="fas fa-undo" style="color:var(--gold);"></i> 30-Day Guarantee
            </div>
        </div>
    </div>
</div>

<section style="padding:60px 32px 100px;">
    <div class="container">

        <!-- Plans Grid -->
        <div class="plans-grid" style="align-items:stretch;">
            @forelse($plans as $plan)
            @php
                $tierMap = ['Bronze'=>'bronze','Silver'=>'silver','Gold'=>'gold','Platinum'=>'platinum'];
                $iconMap  = ['Bronze'=>'medal','Silver'=>'award','Gold'=>'crown','Platinum'=>'gem'];
                $colorMap = [
                    'Bronze'   => ['border'=>'#C87941','glow'=>'rgba(200,121,65,0.15)','text'=>'#E89060'],
                    'Silver'   => ['border'=>'rgba(160,168,192,0.4)','glow'=>'rgba(160,168,192,0.08)','text'=>'#A0A8C0'],
                    'Gold'     => ['border'=>'var(--gold)','glow'=>'var(--gold-glow)','text'=>'var(--gold-light)'],
                    'Platinum' => ['border'=>'rgba(200,220,255,0.4)','glow'=>'rgba(200,220,255,0.06)','text'=>'#C0D4F0'],
                ];
                $tier     = $tierMap[$plan->name] ?? 'gold';
                $icon     = $iconMap[$plan->name] ?? 'crown';
                $colors   = $colorMap[$plan->name] ?? $colorMap['Gold'];
                $isFeatured = $plan->name === 'Gold';
                $features = array_filter(array_map('trim', explode("\n", $plan->features ?? '')));
                if(empty($features)) {
                    $features = [
                        'Official VIP Membership Card',
                        $plan->duration_months.'-Month Full Access',
                        'Member Portal Access',
                        'Exclusive Digital Card',
                        'Priority Member Support',
                    ];
                }
            @endphp
            <div class="plan-card-pub {{ $isFeatured ? 'featured' : '' }}" data-animate="fade-up" data-delay="{{ $loop->index * 100 }}"
                 style="{{ $isFeatured ? "border-color:{$colors['border']}; box-shadow:0 0 60px {$colors['glow']}, 0 30px 80px rgba(0,0,0,0.5);" : '' }}">

                @if($isFeatured)
                    <div class="plan-popular-badge">⭐ Most Popular</div>
                @endif

                <div class="plan-tier-icon {{ $tier }}">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>

                <div class="plan-name-pub" style="{{ $isFeatured ? "color:{$colors['text']};" : '' }}">{{ $plan->name }}</div>
                <div class="plan-desc-pub">{{ $plan->description ?? 'Premium membership access and benefits' }}</div>

                <div class="plan-price-pub">
                    <span class="currency">$</span>
                    <span class="amount">{{ number_format($plan->price, 0) }}</span>
                    <span class="period">/one-time</span>
                </div>

                <div class="plan-duration-badge">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }} membership
                </div>

                <div class="plan-divider"></div>

                <ul class="plan-features-pub">
                    @foreach($features as $feature)
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>

                <!-- Card Preview -->
                <div style="margin-bottom:24px; border-radius:12px; overflow:hidden;">
                    <div style="background:linear-gradient(135deg,#1a1b23 0%,#0c0d10 60%,#1a1506 100%); border:1px solid {{ $colors['border'] }}; border-radius:12px; padding:18px; position:relative; overflow:hidden;">
                        <div style="position:absolute;top:-30px;right:-30px;width:100px;height:100px;background:radial-gradient(circle,{{ $colors['glow'] }},transparent);border-radius:50%;"></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;position:relative;z-index:1;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <div style="width:20px;height:20px;background:linear-gradient(135deg,#8A6820,#C9A84C);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:9px;">👑</div>
                                <span style="font-size:10px;color:var(--gold-light);font-family:var(--font-display);font-weight:600;letter-spacing:1px;">MEMBERSHIP CARD</span>
                            </div>
                            <span style="font-family:var(--font-display);font-size:14px;color:{{ $colors['text'] }};font-weight:700;">{{ strtoupper($plan->name) }}</span>
                        </div>
                        <div style="font-family:var(--font-display);font-size:12px;letter-spacing:3px;color:rgba(201,168,76,0.7);margin-bottom:8px;position:relative;z-index:1;">•••• •••• •••• ••••</div>
                        <div style="display:flex;justify-content:space-between;position:relative;z-index:1;">
                            <div><div style="font-size:8px;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;">Card Holder</div><div style="font-size:11px;color:var(--white-dim);">YOUR NAME</div></div>
                            <div style="text-align:right;"><div style="font-size:8px;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;">Valid Thru</div><div style="font-size:11px;color:var(--white-dim);">{{ now()->addMonths($plan->duration_months)->format('m/Y') }}</div></div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('public.checkout', $plan) }}" class="btn-get-card {{ $isFeatured ? 'btn-get-card-gold' : 'btn-get-card-outline' }}" style="margin-top:auto;">
                    <i class="fas fa-comments"></i>
                    Chat & Get This Card
                    <i class="fas fa-arrow-right"></i>
                </a>

                <div style="text-align:center; margin-top:10px; font-size:12px; color:var(--white-muted);">
                    <i class="fas fa-lock" style="margin-right:4px;"></i>Secure · Chat with management to pay
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:80px 20px; color:var(--white-muted);">
                <i class="fas fa-layer-group" style="font-size:40px; margin-bottom:16px; display:block; color:var(--gold);"></i>
                <p style="font-size:18px;">No plans available yet. Check back soon!</p>
            </div>
            @endforelse
        </div>

        <!-- FAQ -->
        <div style="margin-top:80px; max-width:780px; margin-left:auto; margin-right:auto;">
            <div class="text-center" style="margin-bottom:48px;">
                <div class="section-eyebrow">FAQ</div>
                <h2 class="section-title" style="font-size:32px;">Common Questions</h2>
            </div>

            <div style="display:flex; flex-direction:column; gap:12px;">
                @foreach([
                    ['How do I pay?', 'After selecting your plan, you\'ll be taken to a live chat where you fill in your details. Our management team will provide payment instructions (bank transfer, cash, mobile money) and approve your application.'],
                    ['How long until I get my card?', 'Once your payment is confirmed by our team, you\'ll receive a unique VIP Card ID code in the chat immediately. Enter it in the "My Card" section to view your digital card.'],
                    ['Can I add my photo to the card?', 'Yes! During the chat process you can upload a photo which will appear on your personalised VIP membership card.'],
                    ['What if I need help?', 'Our management team is available via the live chat on every plan page. You can also use the chat to ask questions before purchasing.'],
                    ['Is my payment secure?', 'All payments are handled directly with our management team. No payment details are stored on this website.'],
                ] as [$q, $a])
                <div class="faq-item" style="background:var(--ink-3); border:1px solid rgba(255,255,255,0.06); border-radius:14px; overflow:hidden;">
                    <button onclick="toggleFaq(this)" style="width:100%; text-align:left; padding:20px 24px; background:none; border:none; color:var(--white); font-family:var(--font-body); font-size:15px; font-weight:500; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:16px;">
                        <span>{{ $q }}</span>
                        <i class="fas fa-chevron-down" style="font-size:13px; color:var(--gold); flex-shrink:0; transition:transform 0.3s;"></i>
                    </button>
                    <div class="faq-answer" style="display:none; padding:0 24px 20px; font-size:14px; color:var(--white-dim); line-height:1.75;">{{ $a }}</div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
function toggleFaq(btn) {
    const ans = btn.nextElementSibling;
    const icon = btn.querySelector('.fa-chevron-down');
    const open = ans.style.display !== 'none';
    ans.style.display = open ? 'none' : 'block';
    icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
}
document.querySelectorAll('[data-animate]').forEach(el => {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting) { setTimeout(()=>e.target.classList.add('animated'), +e.target.dataset.delay||0); io.unobserve(e.target); } });
    }, {threshold:.12});
    io.observe(el);
});
</script>
@endpush

@push('styles')
<style>
[data-animate]{opacity:0;transform:translateY(20px);transition:opacity .6s cubic-bezier(.4,0,.2,1),transform .6s cubic-bezier(.4,0,.2,1);}
[data-animate].animated{opacity:1;transform:none;}
</style>
@endpush
@endsection
