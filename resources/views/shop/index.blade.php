@extends('layouts.public')
@section('title','VIP Membership Card — Official Fan Store')

@section('content')

{{-- ═══ HERO ═══ --}}
<section class="hero-section">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>
  {{-- Floating orbs --}}
  <div style="position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(201,168,76,.08),transparent);top:-120px;right:-80px;filter:blur(60px);pointer-events:none;"></div>
  <div style="position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(201,168,76,.05),transparent);bottom:100px;left:5%;filter:blur(50px);pointer-events:none;"></div>

  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-eyebrow"><i class="fas fa-crown"></i> Official VIP Membership Programme</div>
      <h1 class="hero-title">Your Exclusive Access<br>Starts <em>Right Here</em></h1>
      <p class="hero-desc">Chat with our management team, complete your application, and get your personalised VIP card featuring your favourite celebrity — issued the moment your payment is approved.</p>
      <div class="hero-cta">
        <a href="#plans" class="btn-hero-primary"><i class="fas fa-id-card"></i> Get My Membership Card</a>
        <a href="#how-it-works" class="btn-hero-ghost"><i class="fas fa-play-circle"></i> How It Works</a>
      </div>
      <div class="hero-trust">
        <div class="trust-stat"><strong>{{ \App\Models\PurchaseTransaction::where('status','completed')->count() + 1200 }}+</strong><span>Cards Issued</span></div>
        <div class="trust-divider"></div>
        <div class="trust-stat"><strong>{{ $plans->count() }}</strong><span>Plan Tiers</span></div>
        <div class="trust-divider"></div>
        <div class="trust-stat"><strong>100%</strong><span>Secure</span></div>
      </div>
    </div>

    {{-- Hero Card Stack --}}
    <div style="position:relative;display:flex;align-items:center;justify-content:center;">
      <div style="position:absolute;width:420px;height:420px;border-radius:50%;border:1px solid rgba(201,168,76,.06);top:50%;left:50%;transform:translate(-50%,-50%);animation:ringPulse 4s ease-in-out infinite;"></div>
      <div style="position:absolute;width:560px;height:560px;border-radius:50%;border:1px solid rgba(201,168,76,.03);top:50%;left:50%;transform:translate(-50%,-50%);animation:ringPulse 4s ease-in-out infinite .8s;"></div>

      {{-- Stacked cards --}}
      <div style="position:relative;width:360px;height:230px;">
        @foreach([['top:40px;left:48px;opacity:.3;z-index:1;'],['top:20px;left:24px;opacity:.6;z-index:2;'],['top:0;left:0;z-index:3;']] as $i=>$style)
        <div style="position:absolute;{{ $style[0] }}width:340px;height:210px;background:#000;border-radius:16px;padding:22px 24px;border:1.5px solid rgba(201,168,76,{{ $i==2?'.5':'.2' }});box-shadow:0 20px 60px rgba(0,0,0,.7),0 0 40px rgba(201,168,76,{{ $i==2?'.1':'0' }});animation:cardFloat {{ 5+$i }}s ease-in-out infinite {{ $i*0.5 }}s;">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
            <div style="display:flex;align-items:center;gap:6px;"><div style="width:24px;height:24px;background:linear-gradient(135deg,#8A6820,#C9A84C);border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:10px;">👑</div><span style="font-family:'Playfair Display',serif;font-size:12px;color:#E8C97A;font-weight:700;letter-spacing:1px;">MEMBERSHIP CARD</span></div>
            <div style="width:38px;height:28px;background:linear-gradient(135deg,#8A6820,#E8C97A);border-radius:5px;"></div>
          </div>
          <div style="font-family:'Playfair Display',serif;font-size:13px;letter-spacing:4px;color:rgba(201,168,76,.7);margin-bottom:14px;">•••• •••• •••• ••••</div>
          <div style="display:flex;justify-content:space-between;align-items:flex-end;">
            <div><div style="font-size:8px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:1.5px;">Card Holder</div><div style="font-size:12px;color:rgba(255,255,255,.7);font-weight:600;letter-spacing:1px;">{{ ['FAN MEMBER','VIP MEMBER','JOHN DOE'][$i] }}</div></div>
            <div style="font-family:'Playfair Display',serif;font-size:17px;color:#FFD700;font-weight:900;">{{ ['BRONZE','SILVER','GOLD'][$i] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ═══ PROOF STRIP ═══ --}}
<div style="background:var(--ink-2);border-top:1px solid var(--white-06);border-bottom:1px solid var(--white-06);padding:24px 28px;">
  <div class="container" style="display:flex;align-items:center;justify-content:center;gap:32px;flex-wrap:wrap;">
    <span style="font-size:11px;text-transform:uppercase;letter-spacing:2px;color:var(--white-40);">Trusted & Verified</span>
    @foreach([['fas fa-shield-alt','Secure Payments'],['fas fa-bolt','Instant Card Issuance'],['fas fa-comments','Live Chat Support'],['fas fa-lock','Data Protected'],['fas fa-undo','30-Day Guarantee']] as [$icon,$label])
    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--white-40);"><i class="{{ $icon }}" style="color:var(--gold);font-size:14px;"></i>{{ $label }}</div>
    @endforeach
  </div>
</div>

{{-- ═══ HOW IT WORKS ═══ --}}
<section class="section" style="background:var(--ink-2);" id="how-it-works">
  <div class="container">
    <div class="text-center" style="margin-bottom:56px;">
      <div class="section-eyebrow" style="justify-content:center;">Simple Process</div>
      <h2 class="section-title">Get Your Card in <em>4 Easy Steps</em></h2>
      <p class="section-subtitle">From sign-up to card in hand — the entire process takes under 5 minutes.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;position:relative;">
      <div style="position:absolute;top:34px;left:calc(12.5% + 12px);right:calc(12.5% + 12px);height:1px;background:linear-gradient(90deg,transparent,var(--gold-border),var(--gold-border),transparent);"></div>
      @foreach([['01','fas fa-layer-group','Choose Your Plan','Browse Bronze, Silver, Gold and Platinum plans. Each unlocks a different level of benefits and celebrity access.'],['02','fas fa-user-plus','Register & Fill Form','Create your account, fill in your details and upload your photo to personalise your VIP card.'],['03','fas fa-comments','Chat & Pay','Our management team will connect with you in live chat to process your payment securely.'],['04','fas fa-id-card','Get Your Card','Receive your unique access code, enter it and view your personalised VIP membership card instantly.']] as [$num,$icon,$title,$desc])
      <div style="text-align:center;position:relative;z-index:1;">
        <div style="width:68px;height:68px;border-radius:50%;border:1px solid var(--gold-border);background:var(--ink-3);display:flex;align-items:center;justify-content:center;margin:0 auto 22px;font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--gold);box-shadow:0 0 30px rgba(201,168,76,.1);">{{ $num }}</div>
        <div style="width:42px;height:42px;background:var(--gold-glow);border:1px solid var(--gold-border);border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;color:var(--gold);font-size:17px;"><i class="{{ $icon }}"></i></div>
        <h3 style="font-family:'Playfair Display',serif;font-size:19px;font-weight:700;color:var(--white);margin-bottom:8px;">{{ $title }}</h3>
        <p style="font-size:13.5px;color:var(--white-40);line-height:1.7;">{{ $desc }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ BENEFITS ═══ --}}
<section class="section" id="benefits">
  <div class="container">
    <div style="margin-bottom:56px;">
      <div class="section-eyebrow">Why Join</div>
      <h2 class="section-title">Everything You Get<br>as a <em>VIP Member</em></h2>
      <p class="section-subtitle">Your membership card is more than a card — it's your key to an exclusive world of privileges.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
      @foreach([['fas fa-star','VIP Priority Access','Skip the queue at events, get early access to releases and enjoy front-of-line priority treatment every time.'],['fas fa-user-friends','Personalised VIP Card','Your card features your photo and your chosen celebrity alongside the VIP emblem. Truly one of a kind.'],['fas fa-comments','Direct Admin Chat','Chat directly with our management team in real time. Payment, support and approvals — all in one place.'],['fas fa-percent','Exclusive Discounts','Enjoy member-only pricing, seasonal promotions and partner discounts unavailable to the general public.'],['fas fa-gift','Member-Only Events','Get invited to exclusive events, meet-and-greets, behind-the-scenes experiences and private gatherings.'],['fas fa-shield-alt','Secure & Guaranteed','Memberships come with a 30-day satisfaction guarantee. Your payment is 100% secure and protected.']] as [$icon,$title,$desc])
      <div style="background:var(--ink-3);border:1px solid var(--white-06);border-radius:var(--r-xl);padding:30px;transition:var(--tx);cursor:default;" onmouseover="this.style.borderColor='var(--gold-border)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 20px 60px rgba(0,0,0,.4)'" onmouseout="this.style.borderColor='var(--white-06)';this.style.transform='none';this.style.boxShadow='none'">
        <div style="width:50px;height:50px;background:var(--gold-glow);border:1px solid var(--gold-border);border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--gold);margin-bottom:20px;"><i class="{{ $icon }}"></i></div>
        <h3 style="font-family:'Playfair Display',serif;font-size:19px;font-weight:700;color:var(--white);margin-bottom:9px;">{{ $title }}</h3>
        <p style="font-size:14px;color:var(--white-40);line-height:1.75;">{{ $desc }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ PLANS ═══ --}}
<section class="section" style="background:var(--ink-2);" id="plans">
  <div class="container">
    <div class="text-center" style="margin-bottom:56px;">
      <div class="section-eyebrow" style="justify-content:center;">Membership Plans</div>
      <h2 class="section-title">Choose Your <em>Level</em></h2>
      <p class="section-subtitle">From entry-level access to platinum elite — there's a plan for every fan.</p>
    </div>
    <div class="plan-grid">
      @forelse($plans as $plan)
      @php
        $tm=['Bronze'=>'bronze','Silver'=>'silver','Gold'=>'gold','Platinum'=>'platinum'];
        $im=['Bronze'=>'medal','Silver'=>'award','Gold'=>'crown','Platinum'=>'gem'];
        $tier=$tm[$plan->name]??'gold'; $icon=$im[$plan->name]??'crown';
        $featured=$plan->name==='Gold';
        $feats=array_filter(array_map('trim',explode("\n",$plan->features??'')));
        if(empty($feats))$feats=['Official VIP Membership Card',$plan->duration_months.'-Month Validity','Member Portal Access','Priority Support'];
      @endphp
      <div class="plan-card-pub {{ $featured?'featured':'' }}">
        @if($featured)<div class="plan-pop-badge">⭐ Most Popular</div>@endif
        <div class="plan-tier-icon {{ $tier }}"><i class="fas fa-{{ $icon }}"></i></div>
        <div class="plan-name-pub">{{ $plan->name }}</div>
        <div class="plan-desc-pub">{{ $plan->description }}</div>
        <div class="plan-price-pub"><span class="cur">$</span><span class="amt">{{ number_format($plan->price,0) }}</span><span class="per">/one-time</span></div>
        <div class="plan-dur-badge"><i class="fas fa-calendar-alt"></i> {{ $plan->duration_months }} month{{ $plan->duration_months>1?'s':'' }} validity</div>
        @if($plan->celebrity_name)<div style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:var(--gold-glow);border:1px solid var(--gold-border);border-radius:8px;margin-bottom:14px;font-size:12.5px;color:var(--gold-lt);"><i class="fas fa-star" style="color:var(--gold);font-size:11px;"></i> Features: <strong>{{ $plan->celebrity_name }}</strong></div>@endif
        <div class="plan-divider"></div>
        <ul class="plan-feats">
          @foreach(array_slice($feats,0,5) as $f)<li><span class="chk"><i class="fas fa-check"></i></span>{{ $f }}</li>@endforeach
        </ul>
        <a href="{{ route('checkout.form', $plan) }}" class="btn-get-card {{ $featured?'btn-get-card-gold':'btn-get-card-outline' }}">
          <i class="fas fa-comments"></i> Chat & Get This Card <i class="fas fa-arrow-right"></i>
        </a>
        <div style="text-align:center;margin-top:9px;font-size:12px;color:var(--white-40);"><i class="fas fa-lock" style="margin-right:4px;"></i>Payment via live chat with management</div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--white-40);"><i class="fas fa-layer-group" style="font-size:40px;margin-bottom:16px;display:block;color:var(--gold);opacity:.5;"></i><p>No plans available yet.</p></div>
      @endforelse
    </div>
  </div>
</section>

{{-- ═══ CARD PREVIEW ═══ --}}
<section class="section">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <div class="section-eyebrow">The Card</div>
        <h2 class="section-title">Your Own Personalised<br><em>VIP Card</em></h2>
        <p style="font-size:16px;color:var(--white-70);line-height:1.75;margin-bottom:24px;">Every card is unique to you. It features your photo, the celebrity on your chosen plan, the VIP emblem, your name, address and activation fee — all on a premium black-and-gold design.</p>
        @foreach(['Your personal photo on the card','Celebrity photo & name included','Unique card number & VIP seal','Activation fee & address listed','Available digitally & for print'] as $f)
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;font-size:14px;color:var(--white-70);"><div style="width:22px;height:22px;border-radius:50%;background:var(--gold-glow);border:1px solid var(--gold-border);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:9px;color:var(--gold);"><i class="fas fa-check"></i></div>{{ $f }}</div>
        @endforeach
        <a href="#plans" class="btn btn-primary btn-lg" style="margin-top:24px;display:inline-flex;"><i class="fas fa-id-card"></i> Get My Card</a>
      </div>
      {{-- Sample card --}}
      <div style="display:flex;justify-content:center;">
        @php $samplePlan = $plans->where('celebrity_name','!=',null)->first() ?? $plans->first(); @endphp
        @if($samplePlan)
        <div class="vip-card" style="max-width:400px;">
          <div class="vc-top">
            <div class="vc-emblem">
              <div class="vc-emblem-ring"><span class="vc-emblem-crown">👑</span></div>
              <div class="vc-vip-text">VIP</div>
            </div>
            <div class="vc-act-fee-top">ACTIVATION FEE:<br><span>${{ number_format($samplePlan->price,0) }}</span></div>
          </div>
          <div class="vc-title-block">
            <span class="vc-title-main">MEMBERSHIP</span>
            <span class="vc-title-sub">CARD</span>
          </div>
          <div class="vc-details">
            <div class="vc-detail-row"><strong>ACTIVATION FEE : {{ number_format($samplePlan->price,0) }}</strong></div>
            <div class="vc-detail-row">ADDRESS : Your City, State</div>
            <div class="vc-detail-row">Your Street Address</div>
          </div>
          <div class="vc-photos">
            <div class="vc-photo-wrap">
              <div class="vc-photo-circle"><div class="vc-photo-placeholder"><i class="fas fa-user"></i></div></div>
              <div class="vc-photo-name">YOUR NAME</div>
            </div>
            <div class="vc-photo-divider"></div>
            <div class="vc-photo-wrap">
              @if($samplePlan->celebrity_image)
              <div class="vc-photo-circle"><img src="{{ asset('storage/'.$samplePlan->celebrity_image) }}" alt="{{ $samplePlan->celebrity_name }}"></div>
              @else
              <div class="vc-photo-circle"><div class="vc-photo-placeholder"><i class="fas fa-star"></i></div></div>
              @endif
              <div class="vc-photo-name">{{ $samplePlan->celebrity_name ?? 'CELEBRITY NAME' }}</div>
            </div>
          </div>
          <div class="vc-footer-bar"></div>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ═══ TESTIMONIALS ═══ --}}
<section class="section" style="background:var(--ink-2);">
  <div class="container">
    <div class="text-center" style="margin-bottom:48px;"><div class="section-eyebrow" style="justify-content:center;">Member Stories</div><h2 class="section-title">What Our Members <em>Say</em></h2></div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
      @foreach([['A','Alexandra R.','Gold Member','The card looks amazing — my photo next to the celebrity makes it feel so personal. The admin approved my payment within an hour!'],['M','Marcus T.','Platinum Member','I love how the live chat works. The management team was so helpful and my card was issued the same day.'],['S','Sophia C.','Silver Member','I upgraded to Gold within a month. The process is smooth and the VIP card design is gorgeous.']] as [$init,$name,$plan,$quote])
      <div style="background:var(--ink-3);border:1px solid var(--white-06);border-radius:var(--r-xl);padding:26px;transition:var(--tx);" onmouseover="this.style.borderColor='var(--gold-border)';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--white-06)';this.style.transform='none'">
        <div style="color:var(--gold);font-size:13px;letter-spacing:2px;margin-bottom:14px;">★★★★★</div>
        <p style="font-family:'Playfair Display',serif;font-size:15px;font-style:italic;color:var(--white-70);line-height:1.7;margin-bottom:20px;">"{{ $quote }}"</p>
        <div style="display:flex;align-items:center;gap:11px;"><div class="avatar">{{ $init }}</div><div><div style="font-size:14px;font-weight:600;color:var(--white);">{{ $name }}</div><div style="font-size:12px;color:var(--gold);">{{ $plan }}</div></div></div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ CTA ═══ --}}
<section class="section">
  <div class="container">
    <div style="max-width:880px;margin:0 auto;background:linear-gradient(135deg,var(--ink-3) 0%,var(--ink-4) 100%);border:1px solid var(--gold-border);border-radius:28px;padding:64px 56px;text-align:center;position:relative;overflow:hidden;box-shadow:0 0 80px rgba(201,168,76,.08);">
      <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:radial-gradient(ellipse 80% 50% at 50% -20%,rgba(201,168,76,.1),transparent);pointer-events:none;"></div>
      <div class="hero-eyebrow" style="display:inline-flex;margin-bottom:20px;position:relative;"><i class="fas fa-fire"></i> Limited — Join Today</div>
      <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,46px);font-weight:900;color:var(--white);line-height:1.15;margin-bottom:14px;position:relative;">Ready to Join the <em style="font-style:italic;color:var(--gold-lt);">Inner Circle?</em></h2>
      <p style="font-size:16px;color:var(--white-70);margin-bottom:36px;position:relative;">Thousands of fans already have their cards. Claim yours today and start enjoying the exclusive benefits.</p>
      <div style="display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;position:relative;">
        <a href="#plans" class="btn-hero-primary"><i class="fas fa-id-card"></i> Choose My Plan</a>
        <a href="{{ route('login') }}" class="btn-hero-ghost">Already a member? Sign In</a>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
@keyframes cardFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
@keyframes ringPulse{0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.6}50%{transform:translate(-50%,-50%) scale(1.04);opacity:.3}}
</style>
@endpush
@endsection
