@extends('layouts.public')
@section('title','Get Your '.$plan->name.' Membership Card')

@section('content')
<div class="checkout-page">
  <div style="max-width:1100px;margin:0 auto 22px;"><a href="{{ route('shop.index') }}#plans" style="display:inline-flex;align-items:center;gap:8px;font-size:13.5px;color:var(--white-40);transition:var(--tx);" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--white-40)'"><i class="fas fa-arrow-left"></i> Back to Plans</a></div>

  <div class="checkout-grid">
    {{-- FORM --}}
    <div class="checkout-form-panel">
      <div style="padding:26px 30px;border-bottom:1px solid var(--white-06);">
        <h2 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:var(--white);margin-bottom:4px;">Apply for Your VIP Card</h2>
        <p style="font-size:13.5px;color:var(--white-40);">Fill in your details. Our team will connect with you in live chat to process payment.</p>
        <div class="checkout-steps">
          <div class="cstep active"><div class="cstep-num">1</div><span>Your Info</span></div>
          <div class="cstep-line"></div>
          <div class="cstep"><div class="cstep-num">2</div><span>Live Chat</span></div>
          <div class="cstep-line"></div>
          <div class="cstep"><div class="cstep-num">3</div><span>Payment</span></div>
          <div class="cstep-line"></div>
          <div class="cstep"><div class="cstep-num">4</div><span>Get Card</span></div>
        </div>
      </div>

      <form action="{{ route('checkout.store', $plan) }}" method="POST" enctype="multipart/form-data" style="padding:28px 30px;">
        @csrf
        @if($errors->any())<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i><div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div></div>@endif

        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold);margin-bottom:16px;display:flex;align-items:center;gap:8px;"><i class="fas fa-user"></i> Personal Details</div>

        <div class="form-grid-2">
          <div class="form-group"><label class="form-label">First Name *</label><input class="form-control" name="first_name" value="{{ old('first_name', auth()->user()->name ? explode(' ', auth()->user()->name)[0] : '') }}" placeholder="John" required></div>
          <div class="form-group"><label class="form-label">Last Name *</label><input class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required></div>
        </div>
        <div class="form-group"><label class="form-label">Email Address *</label><input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="you@email.com" required></div>
        <div class="form-grid-2">
          <div class="form-group"><label class="form-label">Phone Number *</label><input class="form-control" type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="+1 (555) 000-0000" required></div>
          <div class="form-group"><label class="form-label">State / City *</label><input class="form-control" name="state" value="{{ old('state') }}" placeholder="e.g. SC, Spartanburg" required></div>
        </div>
        <div class="form-group"><label class="form-label">Full Street Address *</label><input class="form-control" name="address" value="{{ old('address', auth()->user()->address ?? '') }}" placeholder="1424 Denton Rd" required></div>

        {{-- PHOTO UPLOAD --}}
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold);margin:22px 0 12px;display:flex;align-items:center;gap:8px;"><i class="fas fa-camera"></i> Your Photo (Appears on Card) *</div>
        <div class="photo-upload-area" id="photoArea" onclick="document.getElementById('photoInput').click()">
          <div id="photoPreviewWrap" style="display:none;margin-bottom:12px;">
            <img id="photoPreview" src="" alt="" style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--gold);margin:0 auto;display:block;">
          </div>
          <div id="photoPlaceholder">
            <i class="fas fa-user-circle" style="font-size:44px;color:var(--gold);display:block;margin:0 auto 10px;"></i>
            <div style="font-size:14px;color:var(--white-70);margin-bottom:4px;">Click to upload your photo</div>
            <div style="font-size:12px;color:var(--white-40);">JPG, PNG or WEBP · Max 5MB · Will appear on your VIP card</div>
          </div>
          <input type="file" id="photoInput" name="user_photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)" required>
        </div>

        {{-- MESSAGE --}}
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold);margin:22px 0 12px;display:flex;align-items:center;gap:8px;"><i class="fas fa-comment"></i> Message to Management</div>
        <div class="form-group">
          <textarea class="form-control" name="message" rows="3" placeholder="Hi, I'm interested in the {{ $plan->name }} plan. I'd like to know how to pay…" required minlength="10">{{ old('message') }}</textarea>
          <div class="form-hint">This starts the live chat with our management team.</div>
        </div>

        <label style="display:flex;align-items:flex-start;gap:10px;margin-bottom:22px;cursor:pointer;font-size:13px;color:var(--white-40);line-height:1.6;">
          <input type="checkbox" name="terms" required style="margin-top:3px;accent-color:var(--gold);width:15px;height:15px;flex-shrink:0;">
          I agree to the <a href="#" style="color:var(--gold);margin:0 3px;">Terms & Conditions</a> and understand payment is processed via live chat with management.
        </label>

        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
          <i class="fas fa-comments"></i> Submit & Open Live Chat <i class="fas fa-arrow-right"></i>
        </button>
        <div style="text-align:center;margin-top:12px;font-size:12.5px;color:var(--white-40);"><i class="fas fa-lock" style="margin-right:4px;color:var(--gold);"></i>Your info is secure. Payment handled directly by our team.</div>
      </form>
    </div>

    {{-- SUMMARY --}}
    <div class="checkout-summary-panel">
      {{-- Live card preview --}}
      <div class="summary-card-box" style="margin-bottom:16px;">
        <div style="padding:16px 20px;border-bottom:1px solid var(--gold-border);background:linear-gradient(135deg,var(--ink-3),var(--ink-4));">
          <h3 style="font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:var(--white);margin-bottom:2px;">Card Preview</h3>
          <p style="font-size:12px;color:var(--white-40);">Updates as you fill in your details</p>
        </div>
        <div style="padding:18px;">
          <div class="vip-card" style="font-size:12px;">
            <div class="vc-top">
              <div class="vc-emblem">
                <div class="vc-emblem-ring" style="width:58px;height:58px;"><span class="vc-emblem-crown" style="font-size:20px;">👑</span></div>
                <div class="vc-vip-text" style="font-size:11px;">VIP</div>
              </div>
              <div class="vc-act-fee-top" style="font-size:11px;">ACTIVATION FEE:<br><span style="font-size:15px;">${{ number_format($plan->price,0) }}</span></div>
            </div>
            <div class="vc-title-block">
              <span class="vc-title-main" style="font-size:20px;">MEMBERSHIP</span>
              <span class="vc-title-sub" style="font-size:20px;">CARD</span>
            </div>
            <div class="vc-details">
              <div class="vc-detail-row" style="font-size:11px;"><strong>ACTIVATION FEE : {{ number_format($plan->price,0) }}</strong></div>
              <div class="vc-detail-row" id="previewAddress" style="font-size:11px;">ADDRESS : Your City, State</div>
              <div class="vc-detail-row" id="previewStreet" style="font-size:11px;">Your Street Address</div>
            </div>
            <div class="vc-photos" style="gap:8px;">
              <div class="vc-photo-wrap">
                <div class="vc-photo-circle" style="width:80px;height:80px;" id="previewUserPhotoWrap">
                  <div class="vc-photo-placeholder" style="font-size:28px;" id="previewUserIcon"><i class="fas fa-user"></i></div>
                  <img id="previewUserPhoto" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="vc-photo-name" id="previewName" style="font-size:10px;">YOUR NAME</div>
              </div>
              <div class="vc-photo-divider" style="height:60px;"></div>
              <div class="vc-photo-wrap">
                <div class="vc-photo-circle" style="width:80px;height:80px;">
                  @if($plan->celebrity_image)
                    <img src="{{ asset('storage/'.$plan->celebrity_image) }}" alt="{{ $plan->celebrity_name }}" style="width:100%;height:100%;object-fit:cover;object-position:center top;">
                  @else
                    <div class="vc-photo-placeholder" style="font-size:28px;"><i class="fas fa-star"></i></div>
                  @endif
                </div>
                <div class="vc-photo-name" style="font-size:10px;">{{ $plan->celebrity_name ?? 'CELEBRITY' }}</div>
              </div>
            </div>
            <div class="vc-footer-bar"></div>
          </div>
        </div>
        {{-- Order summary rows --}}
        <div style="padding:14px 20px;border-top:1px solid var(--gold-border);display:flex;flex-direction:column;gap:10px;">
          @foreach([['Plan',"<span style='color:var(--gold);font-weight:600;'>{$plan->name}</span> Membership"],['Duration',$plan->duration_months.' month'.($plan->duration_months>1?'s':'')],['Card Issuance',"<span style='color:var(--green);'>Instant after approval</span>"]] as [$l,$v])
          <div style="display:flex;justify-content:space-between;font-size:13px;"><span style="color:var(--white-40);">{{ $l }}</span><span style="color:var(--white);">{!! $v !!}</span></div>
          @endforeach
          <div style="display:flex;justify-content:space-between;padding-top:10px;border-top:1px solid var(--white-06);">
            <span style="font-size:14px;font-weight:600;color:var(--white);">Activation Fee</span>
            <span style="font-family:'Playfair Display',serif;font-size:22px;color:var(--gold);font-weight:900;">${{ number_format($plan->price,2) }}</span>
          </div>
        </div>
      </div>

      {{-- Trust --}}
      <div style="background:var(--ink-2);border:1px solid var(--white-06);border-radius:var(--r-lg);padding:18px 20px;display:flex;flex-direction:column;gap:10px;">
        @foreach([['fas fa-comments','Payment via live chat with our team'],['fas fa-id-card','Unique card ID issued upon approval'],['fas fa-shield-alt','Your details kept confidential'],['fas fa-undo','30-day satisfaction guarantee'],['fas fa-headset','Direct contact with management']] as [$icon,$text])
        <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--white-40);"><i class="{{ $icon }}" style="color:var(--gold);width:16px;text-align:center;flex-shrink:0;"></i>{{ $text }}</div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function previewPhoto(input){
  const file=input.files[0];if(!file)return;
  const r=new FileReader();
  r.onload=e=>{
    document.getElementById('photoPreview').src=e.target.result;
    document.getElementById('photoPreviewWrap').style.display='block';
    document.getElementById('photoPlaceholder').style.display='none';
    document.getElementById('previewUserPhoto').src=e.target.result;
    document.getElementById('previewUserPhoto').style.display='block';
    document.getElementById('previewUserIcon').style.display='none';
  };
  r.readAsDataURL(file);
}
function updateName(){
  const fn=(document.querySelector('[name="first_name"]')?.value||'').toUpperCase();
  const ln=(document.querySelector('[name="last_name"]')?.value||'').toUpperCase();
  document.getElementById('previewName').textContent=(fn+' '+ln).trim()||'YOUR NAME';
}
function updateAddress(){
  const s=document.querySelector('[name="state"]')?.value||'';
  const a=document.querySelector('[name="address"]')?.value||'';
  document.getElementById('previewAddress').textContent='ADDRESS : '+(s||'Your City, State');
  document.getElementById('previewStreet').textContent=a||'Your Street Address';
}
['first_name','last_name'].forEach(n=>document.querySelector(`[name="${n}"]`)?.addEventListener('input',updateName));
['state','address'].forEach(n=>document.querySelector(`[name="${n}"]`)?.addEventListener('input',updateAddress));
</script>
@endpush
@endsection
