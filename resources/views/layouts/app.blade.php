<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Dashboard') — Membership Card Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/master.css') }}">
  @stack('styles')
</head>
<body>
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon"><i class="fas fa-crown"></i></div>
    <div><span class="brand-name">MembershipCard</span><span class="brand-tag">Management Console</span></div>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    @if(auth()->user()->is_admin)
    <a href="{{ route('admin.dashboard') }}" class="s-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-th-large"></i></span><span class="nl">Dashboard</span>
    </a>
    <a href="{{ route('admin.chats') }}" class="s-nav-item {{ request()->routeIs('admin.chats') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-comments"></i></span><span class="nl">Fan Chats</span>
      @php $oc = \App\Models\ChatConversation::where('status','open')->count(); @endphp
      @if($oc > 0)<span class="s-nav-badge">{{ $oc }}</span>@endif
    </a>
    <a href="{{ route('admin.transactions') }}" class="s-nav-item {{ request()->routeIs('admin.transactions*') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-receipt"></i></span><span class="nl">Transactions</span>
    </a>
    <a href="{{ route('admin.stats') }}" class="s-nav-item {{ request()->routeIs('admin.stats') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-chart-line"></i></span><span class="nl">Stats & Revenue</span>
    </a>
    <div class="nav-section" style="margin-top:20px;">Settings</div>
    <a href="{{ route('plans.index') }}" class="s-nav-item {{ request()->routeIs('plans.*') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-layer-group"></i></span><span class="nl">Plans & Celebrities</span>
    </a>
    @else
    <a href="{{ route('dashboard') }}" class="s-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-th-large"></i></span><span class="nl">Dashboard</span>
    </a>
    <a href="{{ route('shop.index') }}" class="s-nav-item {{ request()->routeIs('shop.*') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-id-card"></i></span><span class="nl">Browse Plans</span>
    </a>
    @php $mc = \App\Models\ChatConversation::where('user_id', auth()->id())->latest()->first(); @endphp
    @if($mc)
    <a href="{{ route('chat.show', $mc) }}" class="s-nav-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-comments"></i></span><span class="nl">My Chat</span>
    </a>
    @endif
    @endif
    <div class="nav-section" style="margin-top:20px;">Account</div>
    <a href="{{ route('profile') }}" class="s-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
      <span class="ni"><i class="fas fa-user-circle"></i></span><span class="nl">My Profile</span>
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="sf-avatar">
      @if(auth()->user()->user_photo)
        <img src="{{ asset('storage/'.auth()->user()->user_photo) }}" alt="">
      @else
        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
      @endif
    </div>
    <div class="sf-info">
      <span class="sf-name">{{ auth()->user()->name }}</span>
      <span class="sf-role">{{ auth()->user()->is_admin ? 'Administrator' : 'Member' }}</span>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="sf-logout" title="Sign out"><i class="fas fa-sign-out-alt"></i></button>
    </form>
  </div>
</aside>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
<div class="main-wrapper">
  <header class="topbar">
    <div class="topbar-left">
      <button class="menu-toggle" id="menuToggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <div class="breadcrumb">
        <span>@yield('breadcrumb-parent','Dashboard')</span>
        @hasSection('breadcrumb-current')
          <i class="fas fa-chevron-right sep"></i><span class="current">@yield('breadcrumb-current')</span>
        @endif
      </div>
    </div>
    <div class="topbar-right">
      <div class="tb-search"><i class="fas fa-search"></i><input type="text" placeholder="Search…"></div>
      @php $pending = \App\Models\PurchaseTransaction::where('status','pending')->count(); @endphp
      <div class="tb-icon-btn"><i class="fas fa-bell"></i>@if($pending > 0)<span class="notif-dot"></span>@endif</div>
    </div>
  </header>
  <main class="main-content">
    @if(session('success'))
      <div class="alert alert-success" id="flashAlert"><i class="fas fa-check-circle"></i>{{ session('success') }}<button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger" id="flashAlert"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}<button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>
    @endif
    @yield('content')
  </main>
</div>
<script>
function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('sidebarOverlay').classList.toggle('open');}
function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sidebarOverlay').classList.remove('open');}
setTimeout(()=>{document.getElementById('flashAlert')?.remove()},5000);
</script>
@stack('scripts')
</body>
</html>
