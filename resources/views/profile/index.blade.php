@extends('layouts.app')
@section('title','My Profile')
@section('breadcrumb-parent','Profile')
@section('content')
<div class="page-header">
  <div><div class="ph-title">My Profile</div><div class="ph-sub">Update your account information and photo</div></div>
</div>
<div style="max-width:640px;">
  <div class="panel">
    <div class="panel-header"><div class="panel-title">Account Details</div></div>
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
      @csrf
      @if(session('success'))<div class="alert alert-success" style="margin:16px 16px 0;"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif
      @if($errors->any())<div class="alert alert-danger" style="margin:16px 16px 0;"><i class="fas fa-exclamation-circle"></i>{{ $errors->first() }}</div>@endif
      <div class="panel-body">
        <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;padding:18px;background:var(--ink-4);border-radius:12px;border:1px solid var(--white-06);">
          <div style="width:80px;height:80px;border-radius:50%;border:3px solid var(--gold);overflow:hidden;background:var(--ink-3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @if(auth()->user()->user_photo)<img src="{{ asset('storage/'.auth()->user()->user_photo) }}" style="width:100%;height:100%;object-fit:cover;">
            @else<span style="font-family:'Playfair Display',serif;font-size:28px;color:var(--gold);">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>@endif
          </div>
          <div style="flex:1;">
            <div style="font-size:15px;font-weight:600;color:var(--white);margin-bottom:4px;">{{ auth()->user()->name }}</div>
            <div style="font-size:13px;color:var(--white-40);margin-bottom:10px;">{{ auth()->user()->is_admin ? 'Administrator' : 'Fan Member' }}</div>
            <label style="display:inline-flex;align-items:center;gap:7px;padding:7px 14px;background:var(--gold-glow);border:1px solid var(--gold-border);border-radius:8px;cursor:pointer;font-size:12.5px;color:var(--gold-lt);">
              <i class="fas fa-upload"></i> Upload Photo
              <input type="file" name="user_photo" accept="image/*" style="display:none;">
            </label>
          </div>
        </div>
        <div class="form-grid-2">
          <div class="form-group form-full"><label class="form-label">Full Name *</label><input class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}" required></div>
          <div class="form-group"><label class="form-label">Email Address *</label><input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required></div>
          <div class="form-group"><label class="form-label">Phone Number</label><input class="form-control" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+1 555-000-0000"></div>
          <div class="form-group form-full"><label class="form-label">Address</label><input class="form-control" name="address" value="{{ old('address', auth()->user()->address) }}" placeholder="SC, Spartanburg, 1424 Denton Rd"></div>
        </div>
        <div style="border-top:1px solid var(--white-06);padding-top:20px;margin-top:4px;">
          <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--white-40);margin-bottom:14px;">Change Password (leave blank to keep current)</div>
          <div class="form-grid-2">
            <div class="form-group"><label class="form-label">New Password</label><input class="form-control" type="password" name="password" placeholder="Min 8 characters" minlength="8"></div>
            <div class="form-group"><label class="form-label">Confirm New Password</label><input class="form-control" type="password" name="password_confirmation" placeholder="Repeat new password"></div>
          </div>
        </div>
      </div>
      <div class="panel-footer"><span class="td-muted">* Required fields</span><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button></div>
    </form>
  </div>
</div>
@endsection
