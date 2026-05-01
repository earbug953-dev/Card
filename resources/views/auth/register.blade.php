@extends('layouts.auth')
@section('title','Create Account')
@section('content')
<div class="auth-form-wrap">
  <div class="auth-form-title">Create Account</div>
  <div class="auth-form-sub">Register to buy your VIP Membership Card and access the member portal</div>
  @if($errors->any())<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>@endif
  <form method="POST" action="{{ route('register.post') }}" class="auth-form">
    @csrf
    <div class="form-group"><label class="form-label">Full Name *</label><input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required></div>
    <div class="form-group"><label class="form-label">Email Address *</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required></div>
    <div class="form-group"><label class="form-label">Password *</label><input class="form-control" type="password" name="password" placeholder="Min 8 characters" required minlength="8"></div>
    <div class="form-group"><label class="form-label">Confirm Password *</label><input class="form-control" type="password" name="password_confirmation" placeholder="Repeat password" required></div>
    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;"><i class="fas fa-user-plus"></i> Create Account</button>
  </form>
  <div class="auth-footer">Already have an account? <a href="{{ route('login') }}">Sign in here</a></div>
</div>
@endsection
