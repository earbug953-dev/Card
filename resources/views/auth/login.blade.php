@extends('layouts.auth')
@section('title','Sign In')
@section('content')
<div class="auth-form-wrap">
  <div class="auth-form-title">Welcome back</div>
  <div class="auth-form-sub">Sign in to your Membership Card account to continue</div>
  @if($errors->any())<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>@endif
  <form method="POST" action="{{ route('login.post') }}" class="auth-form">
    @csrf
    <div class="form-group"><label class="form-label"><i class="fas fa-envelope" style="color:var(--gold);margin-right:5px;"></i>Email Address</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="admin@demo.com" required autofocus></div>
    <div class="form-group"><label class="form-label"><i class="fas fa-lock" style="color:var(--gold);margin-right:5px;"></i>Password</label>
      <div style="position:relative;"><input class="form-control" type="password" name="password" id="pw" placeholder="••••••••" required style="padding-right:44px;">
      <button type="button" onclick="togglePw()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--white-40);cursor:pointer;font-size:14px;" id="pwEye"><i class="fas fa-eye"></i></button></div>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
      <label style="display:flex;align-items:center;gap:7px;cursor:pointer;color:var(--white-40);"><input type="checkbox" name="remember" style="accent-color:var(--gold);"> Remember me</label>
      <a href="#" style="color:var(--gold);">Forgot password?</a>
    </div>
    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;"><i class="fas fa-sign-in-alt"></i> Sign In</button>
  </form>
  <div class="auth-demo-box">
    <div class="label">Demo Credentials</div>
    <p>Email: <strong>admin@demo.com</strong> &nbsp;|&nbsp; Password: <strong>password</strong></p>
  </div>
  <div class="auth-footer">Don't have an account? <a href="{{ route('register') }}">Create one here</a></div>
</div>
@push('scripts')
<script>function togglePw(){const i=document.getElementById('pw');const e=document.getElementById('pwEye');if(i.type==='password'){i.type='text';e.innerHTML='<i class="fas fa-eye-slash"></i>';}else{i.type='password';e.innerHTML='<i class="fas fa-eye"></i>';}}</script>
@endpush
@endsection
