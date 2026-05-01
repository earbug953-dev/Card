@extends('layouts.public')
@section('title', 'Get Your ' . $plan->name . ' Membership Card')

@section('content')
<div class="checkout-page">
    <div style="max-width:1100px; margin:0 auto 28px;">
        <a href="{{ route('public.plans') }}" style="display:inline-flex; align-items:center; gap:8px; font-size:13.5px; color:var(--white-muted); text-decoration:none; transition:var(--transition);" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--white-muted)'">
            <i class="fas fa-arrow-left"></i> Back to Plans
        </a>
    </div>

    <div class="checkout-inner">

        <!-- LEFT: Form -->
        <div class="checkout-form-panel">
            <div class="checkout-form-header">
                <h2>Apply for Your VIP Card</h2>
                <p>Fill in your details below. Our team will review and contact you via the live chat to process your payment.</p>

                <div class="checkout-steps" style="margin-top:20px;">
                    <div class="checkout-step active">
                        <div class="checkout-step-num">1</div>
                        <span>Your Info</span>
                    </div>
                    <div class="checkout-step-line"></div>
                    <div class="checkout-step">
                        <div class="checkout-step-num">2</div>
                        <span>Chat & Pay</span>
                    </div>
                    <div class="checkout-step-line"></div>
                    <div class="checkout-step">
                        <div class="checkout-step-num">3</div>
                        <span>Get Card ID</span>
                    </div>
                    <div class="checkout-step-line"></div>
                    <div class="checkout-step">
                        <div class="checkout-step-num">4</div>
                        <span>View Card</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('public.checkout.post', $plan) }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf
                <div class="checkout-form-body">
                    @if($errors->any())
                    <div style="background:rgba(224,82,82,0.1); border:1px solid rgba(224,82,82,0.25); border-radius:10px; padding:14px 16px; margin-bottom:24px; font-size:13.5px; color:#E05252; display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
                        <div>
                            @foreach($errors->all() as $e)
                                <div>{{ $e }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Personal -->
                    <div style="margin-bottom:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:var(--gold); display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-user"></i> Personal Details
                    </div>

                    <div class="pub-form-row" style="margin-bottom:0;">
                        <div class="pub-form-group">
                            <label class="pub-label">First Name *</label>
                            <input class="pub-input" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                        </div>
                        <div class="pub-form-group">
                            <label class="pub-label">Last Name *</label>
                            <input class="pub-input" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                        </div>
                    </div>

                    <div class="pub-form-group" style="margin-top:14px;">
                        <label class="pub-label">Email Address *</label>
                        <input class="pub-input" type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required>
                    </div>

                    <div class="pub-form-row" style="margin-top:14px;">
                        <div class="pub-form-group">
                            <label class="pub-label">Phone Number *</label>
                            <input class="pub-input" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000" required>
                        </div>
                        <div class="pub-form-group">
                            <label class="pub-label">Date of Birth</label>
                            <input class="pub-input" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>
                    </div>

                    <div class="pub-form-group" style="margin-top:14px;">
                        <label class="pub-label">Full Address *</label>
                        <input class="pub-input" type="text" name="address" value="{{ old('address') }}" placeholder="123 Main St, City, State, ZIP" required>
                    </div>

                    <!-- Photo upload -->
                    <div style="margin-top:24px; margin-bottom:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:var(--gold); display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-camera"></i> Your Photo (for the card)
                    </div>

                    <div id="photoUploadArea" style="border:1px dashed rgba(201,168,76,0.3); border-radius:12px; padding:24px; text-align:center; cursor:pointer; transition:var(--transition);" onclick="document.getElementById('photoInput').click()" onmouseover="this.style.borderColor='var(--gold)'; this.style.background='var(--gold-glow)'" onmouseout="this.style.borderColor='rgba(201,168,76,0.3)'; this.style.background='transparent'">
                        <div id="photoPreviewWrap" style="display:none; margin-bottom:12px;">
                            <img id="photoPreview" src="" alt="" style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid var(--gold); margin:0 auto;">
                        </div>
                        <div id="photoPlaceholder">
                            <i class="fas fa-user-circle" style="font-size:40px; color:var(--gold); margin-bottom:10px; display:block;"></i>
                            <div style="font-size:14px; color:var(--white-dim); margin-bottom:4px;">Click to upload your photo</div>
                            <div style="font-size:12px; color:var(--white-muted);">JPG, PNG or WEBP · Max 5MB · Appears on your card</div>
                        </div>
                        <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
                    </div>

                    <!-- Artist selection -->
                    @if($featuredArtists ?? false)
                    <div style="margin-top:24px; margin-bottom:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:var(--gold); display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-star"></i> Featured Artist on Card
                    </div>
                    <select class="pub-input" name="featured_artist">
                        <option value="">No featured artist (just my photo)</option>
                        @foreach($featuredArtists as $artist)
                            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                        @endforeach
                    </select>
                    @endif

                    <!-- Password -->
                    <div style="margin-top:24px; margin-bottom:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:var(--gold); display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-lock"></i> Create Portal Password
                    </div>
                    <div style="font-size:12.5px; color:var(--white-muted); margin-bottom:12px;">Set a password to log in to your member portal and view your card later.</div>
                    <div class="pub-form-row">
                        <div class="pub-form-group">
                            <label class="pub-label">Password *</label>
                            <input class="pub-input" type="password" name="password" placeholder="Min 8 characters" required minlength="8">
                        </div>
                        <div class="pub-form-group">
                            <label class="pub-label">Confirm Password *</label>
                            <input class="pub-input" type="password" name="password_confirmation" placeholder="Repeat password" required>
                        </div>
                    </div>

                    <!-- Terms -->
                    <label style="display:flex; align-items:flex-start; gap:10px; margin-top:20px; cursor:pointer; font-size:13px; color:var(--white-muted); line-height:1.6;">
                        <input type="checkbox" name="terms" required style="margin-top:3px; accent-color:var(--gold); width:16px; height:16px; flex-shrink:0;">
                        I agree to the <a href="#" style="color:var(--gold); text-decoration:none; margin:0 3px;">Terms & Conditions</a> and understand that payment is processed manually by the management team via live chat.
                    </label>

                    <button type="submit" class="checkout-submit" style="margin-top:24px;">
                        <i class="fas fa-comments"></i>
                        Submit Application & Open Live Chat
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <div style="text-align:center; margin-top:14px; font-size:12.5px; color:var(--white-muted);">
                        <i class="fas fa-lock" style="margin-right:5px; color:var(--gold);"></i>Your information is secure. Payment is handled directly with our team.
                    </div>
                </div>
            </form>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="checkout-summary">

            <!-- Card Preview -->
            <div class="summary-card">
                <div class="summary-header">
                    <h3>Your Membership Card</h3>
                    <p>Preview of your personalised VIP card</p>
                </div>
                <div class="summary-card-visual">
                    <div class="mini-card" style="width:100%; max-width:100%;">
                        <div style="position:absolute;top:-50px;right:-50px;width:160px;height:160px;background:radial-gradient(circle,rgba(201,168,76,0.12),transparent);border-radius:50%;pointer-events:none;"></div>

                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;position:relative;z-index:1;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <div style="width:28px;height:28px;background:linear-gradient(135deg,#8A6820,#C9A84C);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:12px;">👑</div>
                                <div>
                                    <div style="font-family:var(--font-display);font-size:13px;color:var(--gold-light);font-weight:600;line-height:1;">MEMBERSHIP</div>
                                    <div style="font-size:9px;color:var(--white-muted);letter-spacing:1.5px;text-transform:uppercase;">CARD</div>
                                </div>
                            </div>
                            <!-- Photo placeholder -->
                            <div id="summaryPhoto" style="width:60px;height:60px;border-radius:50%;border:2px solid var(--gold);overflow:hidden;background:rgba(201,168,76,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-user" style="font-size:22px;color:var(--gold);opacity:0.5;"></i>
                            </div>
                        </div>

                        <div style="font-family:var(--font-display);font-size:14px;letter-spacing:4px;color:var(--gold-light);margin-bottom:16px;position:relative;z-index:1;">•••• •••• •••• ••••</div>

                        <div style="display:flex;justify-content:space-between;align-items:flex-end;position:relative;z-index:1;">
                            <div>
                                <div style="font-size:8px;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35);margin-bottom:3px;">Card Holder</div>
                                <div id="summaryName" style="font-size:13px;font-weight:600;color:var(--white-dim);letter-spacing:1px;">YOUR NAME</div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-family:var(--font-display);font-size:18px;color:var(--gold);font-weight:700;">{{ strtoupper($plan->name) }}</div>
                                <div style="font-size:8px;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35);">Activation Fee</div>
                                <div style="font-size:14px;color:var(--gold-light);font-weight:600;">${{ number_format($plan->price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="summary-body">
                    <div class="summary-row">
                        <span class="label">Plan</span>
                        <span class="value"><span style="color:var(--gold);">{{ $plan->name }}</span> Membership</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Duration</span>
                        <span class="value">{{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Card Issuance</span>
                        <span class="value" style="color:var(--success);">Instant after approval</span>
                    </div>
                    <div class="summary-row total">
                        <span class="label">Activation Fee</span>
                        <span class="value">${{ number_format($plan->price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Trust -->
            <div class="summary-card">
                <div class="summary-body">
                    <div class="summary-trust">
                        <div class="trust-item"><i class="fas fa-comments"></i> Payment via live chat with our team</div>
                        <div class="trust-item"><i class="fas fa-id-card"></i> Unique card ID issued upon approval</div>
                        <div class="trust-item"><i class="fas fa-shield-alt"></i> Your details kept confidential</div>
                        <div class="trust-item"><i class="fas fa-undo"></i> 30-day satisfaction guarantee</div>
                        <div class="trust-item"><i class="fas fa-headset"></i> Direct contact with management</div>
                    </div>
                </div>
            </div>

            <!-- Plan features -->
            <div class="summary-card">
                <div class="summary-header" style="padding:16px 20px;">
                    <h3 style="font-size:16px;">What's Included</h3>
                </div>
                <div class="summary-body" style="padding:16px 20px;">
                    @php $features = array_filter(array_map('trim', explode("\n", $plan->features ?? ''))); @endphp
                    @forelse($features as $f)
                    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--white-dim);margin-bottom:10px;">
                        <i class="fas fa-check" style="color:var(--gold);font-size:11px;width:16px;text-align:center;flex-shrink:0;"></i>{{ $f }}
                    </div>
                    @empty
                    @foreach(['VIP Membership Card', $plan->duration_months.'-Month Access', 'Member Portal', 'Priority Support', 'Exclusive Benefits'] as $f)
                    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--white-dim);margin-bottom:10px;">
                        <i class="fas fa-check" style="color:var(--gold);font-size:11px;width:16px;text-align:center;flex-shrink:0;"></i>{{ $f }}
                    </div>
                    @endforeach
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
// Live name update in card preview
['first_name','last_name'].forEach(n=>{
    const el=document.querySelector(`[name="${n}"]`);
    if(el) el.addEventListener('input',()=>{
        const fn=document.querySelector('[name="first_name"]')?.value||'';
        const ln=document.querySelector('[name="last_name"]')?.value||'';
        document.getElementById('summaryName').textContent=(fn+' '+ln).trim().toUpperCase()||'YOUR NAME';
    });
});

// Photo preview
function previewPhoto(input){
    const file=input.files[0];if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        document.getElementById('photoPreview').src=e.target.result;
        document.getElementById('photoPreviewWrap').style.display='block';
        document.getElementById('photoPlaceholder').style.display='none';
        // Also update summary card photo
        document.getElementById('summaryPhoto').innerHTML=`<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
