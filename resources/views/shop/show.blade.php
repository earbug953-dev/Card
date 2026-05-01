@extends('layouts.public')
@section('title', $plan->name . ' Membership Plan')
@section('content')
<div style="padding:calc(var(--nav-h) + 60px) 28px 80px; max-width:800px; margin:0 auto;">
  <a href="{{ route('shop.index') }}#plans" style="display:inline-flex;align-items:center;gap:8px;font-size:13.5px;color:var(--white-40);margin-bottom:24px;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--white-40)'"><i class="fas fa-arrow-left"></i> Back to Plans</a>
  <h1 style="font-family:'Playfair Display',serif;font-size:36px;font-weight:900;color:var(--white);margin-bottom:12px;">{{ $plan->name }} Membership</h1>
  <p style="color:var(--white-40);font-size:16px;margin-bottom:28px;">{{ $plan->description }}</p>
  <a href="{{ route('checkout.form', $plan) }}" class="btn-hero-primary" style="display:inline-flex;"><i class="fas fa-comments"></i> Chat & Get This Card</a>
</div>
@endsection
