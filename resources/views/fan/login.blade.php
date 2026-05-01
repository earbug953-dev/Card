{{-- fan/login.blade.php --}}
@extends('layouts.public')
@section('title', 'Member Sign In')

@section('content')
<div class="fan-auth">
    <div class="fan-auth-box">
        <div class="fan-auth-logo">
            <div class="nav-logo-icon"><i class="fas fa-crown"></i></div>
            <h1>Member Portal</h1>
            <p>Sign in to access your VIP membership card</p>
        </div>

        @if($errors->any())
        <div style="background:rgba(224,82,82,0.1);border:1px solid rgba(224,82,82,0.25);border-radius:12px;padding:14px 16px;margin-bottom:20px;font-size:13.5px;color:#E05252;display:flex;align-items:center;gap:10px;">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        </div>
        @endif

        <div class="fan-auth-form">
            <form method="POST" action="{{ route('fan.login.post') }}" style="display:flex;flex-direction:column;gap:18px;">
                @csrf

                <div class="pub-form-group">
                    <label class="pub-label"><i class="fas fa-envelope" style="color:var(--gold);margin-right:5px;"></i>Email Address</label>
                    <input class="pub-input" type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required>
                </div>

                <div class="pub-form-group">
                    <label class="pub-label"><i class="fas fa-lock" style="color:var(--gold);margin-right:5px;"></i>Password</label>
                    <input class="pub-input" type="password" name="password" placeholder="••••••••" required>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;color:var(--white-muted);">
                        <input type="checkbox" name="remember" style="accent-color:var(--gold);"> Remember me
                    </label>
                    <a href="#" style="color:var(--gold);text-decoration:none;">Forgot password?</a>
                </div>

                <button type="submit" class="checkout-submit">
                    <i class="fas fa-sign-in-alt"></i> Sign In to Portal
                </button>
            </form>
        </div>

        <div class="fan-auth-footer">
            Don't have an account yet?
            <a href="{{ route('public.plans') }}">Get a Membership Card</a>
            <br><br>
            Already have a Card ID?
            <a href="{{ route('fan.my-card') }}">View My Card</a>
        </div>
    </div>
</div>
@endsection
