<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','VIP Membership Card')</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/master.css') }}">
  @stack('styles')
</head>
<body>
<nav class="nav solid" id="mainNav">
  <div class="nav-inner">
    <a href="{{ route('shop.index') }}" class="nav-logo">
      <div class="nav-logo-icon"><i class="fas fa-crown"></i></div>
      <div class="nav-logo-text">Membership<strong>Card</strong></div>
    </a>
    <div class="nav-links">
      <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}">Home</a>
      <a href="{{ route('shop.index') }}#plans" class="nav-link">Plans</a>
      <a href="{{ route('shop.index') }}#how-it-works" class="nav-link">How It Works</a>
      <a href="{{ route('shop.index') }}#benefits" class="nav-link">Benefits</a>
    </div>
    <div class="nav-actions">
      @auth
        <a href="{{ route('dashboard') }}" class="nav-btn nav-btn-ghost"><i class="fas fa-th-large"></i> Dashboard</a>
        @if(auth()->user()->is_admin)
          <a href="{{ route('admin.chats') }}" class="nav-btn nav-btn-gold"><i class="fas fa-headset"></i> Admin Panel</a>
        @else
          @php $myChat = \App\Models\ChatConversation::where('user_id', auth()->id())->latest()->first(); @endphp
          @if($myChat)
            <a href="{{ route('chat.show', $myChat) }}" class="nav-btn nav-btn-gold"><i class="fas fa-comments"></i> My Chat</a>
          @else
            <a href="{{ route('shop.index') }}#plans" class="nav-btn nav-btn-gold"><i class="fas fa-id-card"></i> Get Your Card</a>
          @endif
        @endif
      @else
        <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Sign In</a>
        <a href="{{ route('register') }}" class="nav-btn nav-btn-gold"><i class="fas fa-id-card"></i> Get Your Card</a>
      @endauth
    </div>
    <button class="nav-hamburger" id="hamburger" onclick="toggleMobileNav()">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
<div class="mobile-nav" id="mobileNav">
  <a href="{{ route('shop.index') }}" class="nav-link">Home</a>
  <a href="{{ route('shop.index') }}#plans" class="nav-link">Plans</a>
  <a href="{{ route('shop.index') }}#how-it-works" class="nav-link">How It Works</a>
  <div class="mobile-nav-divider"></div>
  @auth
    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
  @else
    <a href="{{ route('login') }}" class="nav-link">Sign In</a>
    <a href="{{ route('register') }}" class="nav-link active">Get Your Card</a>
  @endauth
</div>
<main class="public-page">
  @if(session('success'))
  <div class="toast toast-success" id="toast"><i class="fas fa-check-circle"></i> {{ session('success') }}<button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>
  @endif
  @if(session('error'))
  <div class="toast toast-error" id="toast"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}<button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>
  @endif
  @yield('content')
</main>
<footer class="footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="footer-brand-logo">
        <div class="nav-logo-icon" style="width:32px;height:32px;font-size:13px;"><i class="fas fa-crown"></i></div>
        <span>Membership<strong>Card</strong></span>
      </div>
      <p>Your gateway to VIP access, exclusive benefits and a premium membership experience.</p>
      <div class="footer-social">
        <a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-facebook"></i></a><a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Membership</h4>
      <a href="{{ route('shop.index') }}#plans">All Plans</a>
      <a href="{{ route('shop.index') }}#benefits">Benefits</a>
      <a href="{{ route('login') }}">Member Login</a>
    </div>
    <div class="footer-col">
      <h4>Support</h4>
      <a href="#">FAQ</a><a href="#">Contact Us</a><a href="#">Terms &amp; Conditions</a>
    </div>
    <div class="footer-col">
      <h4>Account</h4>
      <a href="{{ route('login') }}">Sign In</a>
      <a href="{{ route('register') }}">Join Now</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} Membership Card. All rights reserved.</span>
    <span><a href="#">Privacy</a> · <a href="#">Terms</a></span>
  </div>
</footer>
<script>
function toggleMobileNav(){ document.getElementById('mobileNav').classList.toggle('open'); }
setTimeout(()=>document.getElementById('toast')?.remove(), 5000);
</script>
@stack('scripts')
</body>
</html>
