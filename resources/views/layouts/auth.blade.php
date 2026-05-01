<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>@yield('title','Sign In') — Membership Card</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ secure_asset('css/master.css') }}">
</head>
<body>
<div class="auth-page">
  <div class="auth-left">
    <div class="auth-left-bg"></div>
    <div class="auth-logo-wrap">
      <div class="auth-logo-icon"><i class="fas fa-crown"></i></div>
      <div class="auth-logo-name">Membership<br>Card</div>
      <div class="auth-logo-tag">Premium VIP Management System</div>
    </div>
    <div class="auth-feat">
      <div class="auth-feat-item"><div class="auth-feat-icon"><i class="fas fa-id-card"></i></div><div><div class="auth-feat-title">Official VIP Cards</div><div class="auth-feat-desc">Issue and manage personalised membership cards with celebrity features</div></div></div>
      <div class="auth-feat-item"><div class="auth-feat-icon"><i class="fas fa-comments"></i></div><div><div class="auth-feat-title">Live Chat Approval</div><div class="auth-feat-desc">Real-time chat between fans and management for payment processing</div></div></div>
      <div class="auth-feat-item"><div class="auth-feat-icon"><i class="fas fa-shield-alt"></i></div><div><div class="auth-feat-title">Secure & Verified</div><div class="auth-feat-desc">Unique access codes issued only after admin approval</div></div></div>
    </div>
  </div>
  <div class="auth-right">@yield('content')</div>
</div>
@stack('scripts')
</body>
</html>
