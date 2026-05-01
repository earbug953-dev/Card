<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>My VIP Membership Card — {{ $transaction->user->name }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ secure_asset('css/master.css') }}">
  <style>
    @media print{.no-print{display:none!important;}.card-display-page{background:#000;padding:0;}.vip-card{max-width:100%;box-shadow:none;border:2px solid #9A7A2E;}}
  </style>
</head>
<body style="background:var(--ink);">

{{-- NAV --}}
<nav class="nav solid no-print">
  <div class="nav-inner">
    <a href="{{ route('shop.index') }}" class="nav-logo"><div class="nav-logo-icon"><i class="fas fa-crown"></i></div><div class="nav-logo-text">Membership<strong>Card</strong></div></a>
    <div class="nav-actions">
      @auth
      <a href="{{ route('dashboard') }}" class="nav-btn nav-btn-ghost"><i class="fas fa-th-large"></i> Dashboard</a>
      @else
      <a href="{{ route('shop.index') }}" class="nav-btn nav-btn-ghost"><i class="fas fa-home"></i> Home</a>
      @endauth
    </div>
  </div>
</nav>

<div class="card-display-page" style="padding-top:calc(var(--nav-h) + 40px);">
  <div class="card-display-wrap">

    {{-- Success header --}}
    <div class="no-print" style="text-align:center;margin-bottom:32px;">
      <div style="width:72px;height:72px;border-radius:50%;background:var(--green-bg);border:1px solid rgba(62,207,120,.3);display:flex;align-items:center;justify-content:center;font-size:30px;color:var(--green);margin:0 auto 16px;">✓</div>
      <h1 style="font-family:'Playfair Display',serif;font-size:30px;font-weight:900;color:var(--white);margin-bottom:6px;">Your VIP Card is Ready!</h1>
      <p style="font-size:15px;color:var(--white-40);">Welcome to the club, <strong style="color:var(--white);">{{ $transaction->user->name }}</strong>! 👑 Your official card is below.</p>
    </div>

    {{-- ═══════════════════════════════════
         THE VIP CARD — reference design
         ═══════════════════════════════════ --}}
    <div class="vip-card" id="theCard">
      {{-- Top row: VIP emblem + activation fee --}}
      <div class="vc-top">
        <div class="vc-emblem">
          <div class="vc-emblem-ring">
            <span class="vc-emblem-crown">👑</span>
          </div>
          <div class="vc-vip-text">VIP</div>
        </div>
        <div class="vc-act-fee-top">
          ACTIVATION FEE:<span>{{ number_format($transaction->amount, 0) }}</span>
        </div>
      </div>

      {{-- Title block --}}
      <div class="vc-title-block">
        <span class="vc-title-main">MEMBERSHIP</span>
        <span class="vc-title-sub">CARD</span>
      </div>

      {{-- Details --}}
      <div class="vc-details">
        <div class="vc-detail-row"><strong>ACTIVATION FEE : {{ number_format($transaction->amount, 0) }}</strong></div>
        @if($transaction->user_address)
        <div class="vc-detail-row">ADDRESS : {{ $transaction->user_address }}</div>
        @endif
        @if($card && $card->card_number)
        <div class="vc-detail-row" style="font-family:monospace;letter-spacing:2px;font-size:11px;">{{ implode(' ', str_split($card->card_number, 4)) }}</div>
        @endif
      </div>

      {{-- Photos row - user left, celebrity right --}}
      <div class="vc-photos">
        {{-- User / Member photo --}}
        <div class="vc-photo-wrap">
          <div class="vc-photo-circle">
            @if($transaction->user_photo_path)
              <img src="{{ asset('storage/'.$transaction->user_photo_path) }}" alt="{{ $transaction->user->name }}">
            @else
              <div class="vc-photo-placeholder"><i class="fas fa-user"></i></div>
            @endif
          </div>
          <div class="vc-photo-name">{{ strtoupper($transaction->user->name) }}</div>
        </div>

        <div class="vc-photo-divider"></div>

        {{-- Celebrity photo --}}
        <div class="vc-photo-wrap">
          @if($transaction->plan->celebrity_image)
            <div class="vc-photo-circle">
              <img src="{{ asset('storage/'.$transaction->plan->celebrity_image) }}" alt="{{ $transaction->plan->celebrity_name }}">
            </div>
          @else
            <div class="vc-photo-circle"><div class="vc-photo-placeholder"><i class="fas fa-star"></i></div></div>
          @endif
          <div class="vc-photo-name">{{ strtoupper($transaction->plan->celebrity_name ?? 'VIP ARTIST') }}</div>
        </div>
      </div>

      <div class="vc-footer-bar"></div>
    </div>

    {{-- Card details & actions --}}
    <div class="no-print" style="background:var(--ink-2);border:1px solid var(--white-06);border-radius:var(--r-xl);overflow:hidden;">
      <div style="padding:18px 22px;border-bottom:1px solid var(--white-06);"><div style="font-size:13px;font-weight:700;color:var(--white);">Membership Details</div></div>
      <div style="padding:18px 22px;display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        @foreach([
          ['Member', $transaction->user->name],
          ['Plan', $transaction->plan->name.' Membership'],
          ['Access Code', $transaction->access_code],
          ['Amount Paid', '$'.number_format($transaction->amount,2)],
          ['Valid Until', $card?->expiry_date?->format('M d, Y') ?? 'N/A'],
          ['Status', 'Active & Verified'],
        ] as [$l,$v])
        <div>
          <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:var(--white-40);font-weight:600;margin-bottom:3px;">{{ $l }}</div>
          <div style="font-size:13.5px;color:{{ $l==='Access Code'?'var(--gold)':($l==='Status'?'var(--green)':'var(--white)') }};font-weight:500;{{ $l==='Access Code'?'font-family:monospace;letter-spacing:2px;':'' }}">{{ $v }}</div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Action buttons --}}
    <div class="no-print" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
      @auth
        @if(auth()->id() === $transaction->user_id && $transaction->chatConversation)
          <a href="{{ route('chat.show', $transaction->chatConversation) }}" class="btn btn-primary btn-lg" style="justify-content:center;display:inline-flex;align-items:center;gap:8px;">
            <i class="fas fa-truck"></i> Request Delivery
          </a>
        @else
          <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg" style="justify-content:center;display:inline-flex;align-items:center;gap:8px;">
            <i class="fas fa-comments"></i> Contact Management
          </a>
        @endif
      @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg" style="justify-content:center;display:inline-flex;align-items:center;gap:8px;">
          <i class="fas fa-sign-in-alt"></i> Sign in to Request Delivery
        </a>
      @endauth
      <button onclick="copyCode()" class="btn btn-secondary btn-lg" style="justify-content:center;"><i class="fas fa-copy"></i> Copy Access Code</button>
    </div>

    <div class="no-print" style="text-align:center;font-size:13px;color:var(--white-40);padding:8px 0;">
      Share your access code: <strong style="color:var(--gold);font-family:monospace;letter-spacing:2px;">{{ $transaction->access_code }}</strong><br>
      Anyone with this code can view your card at <span style="color:var(--gold);">{{ url('/card/'.$transaction->access_code) }}</span>
    </div>
  </div>
</div>

<script>
function copyCode(){
  navigator.clipboard.writeText('{{ $transaction->access_code }}')
    .then(()=>{
      const btn=event.target.closest('button');
      const orig=btn.innerHTML;
      btn.innerHTML='<i class="fas fa-check"></i> Copied!';
      btn.style.color='var(--green)';
      setTimeout(()=>{btn.innerHTML=orig;btn.style.color='';},2000);
    });
}
</script>
</body>
</html>
