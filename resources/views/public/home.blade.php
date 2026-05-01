@extends('layouts.public')
@section('title', 'Membership Card — Join the Club')
@section('meta-desc', 'Get your official membership card and unlock exclusive benefits, VIP access and premium privileges today.')

@section('content')

<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <div class="hero-inner">
        <div class="hero-content" data-animate="fade-up">
            <div class="hero-eyebrow">
                <i class="fas fa-crown"></i>
                Official Membership Programme
            </div>

            <h1 class="hero-title">
                Your Exclusive<br>
                Access Starts
                <em>Right Here</em>
            </h1>

            <p class="hero-desc">
                Join thousands of members who enjoy VIP access, exclusive benefits and a premium card that opens doors. Choose your plan and get your card today.
            </p>

            <div class="hero-actions">
                <a href="{{ route('public.plans') }}" class="btn-hero-primary">
                    <i class="fas fa-id-card"></i>
                    Get My Membership Card
                </a>
                <a href="#how-it-works" class="btn-hero-ghost">
                    <i class="fas fa-play-circle"></i>
                    How It Works
                </a>
            </div>

            <div class="hero-trust">
                <div class="trust-stat">
                    <strong>{{ number_format(\App\Models\Member::count() + 1200) }}+</strong>
                    <span>Active Members</span>
                </div>
                <div class="trust-divider"></div>
                <div class="trust-stat">
                    <strong>4</strong>
                    <span>Plan Tiers</span>
                </div>
                <div class="trust-divider"></div>
                <div class="trust-stat">
                    <strong>100%</strong>
                    <span>Secure Checkout</span>
                </div>
            </div>
        </div>

        <!-- Hero Card Stack -->
        <div class="hero-visual" data-animate="fade-left">
            <div class="hero-glow-ring"></div>
            <div class="hero-glow-ring-2"></div>
            <div class="hero-card-stack">
                <div class="hero-card hero-card-3">
                    <div class="card-chip-v"></div>
                    <div class="card-number-v">•••• •••• •••• ••••</div>
                    <div class="card-bottom-v">
                        <div><div class="card-holder-label-v">Card Holder</div><div class="card-holder-v">MEMBER NAME</div></div>
                        <div class="card-plan-v">BRONZE</div>
                    </div>
                </div>
                <div class="hero-card hero-card-2">
                    <div class="card-chip-v"></div>
                    <div class="card-number-v">•••• •••• •••• ••••</div>
                    <div class="card-bottom-v">
                        <div><div class="card-holder-label-v">Card Holder</div><div class="card-holder-v">MEMBER NAME</div></div>
                        <div class="card-plan-v">SILVER</div>
                    </div>
                </div>
                <div class="hero-card hero-card-1">
                    <div class="card-chip-v"></div>
                    <div class="card-number-v">5892 •••• •••• 4471</div>
                    <div class="card-bottom-v">
                        <div><div class="card-holder-label-v">Card Holder</div><div class="card-holder-v">JAMES WHITFIELD</div></div>
                        <div class="card-plan-v">GOLD</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     SOCIAL PROOF STRIP
═══════════════════════════════════════════ -->
<div class="proof-strip">
    <div class="proof-inner">
        <span class="proof-label">Trusted & Verified</span>
        <div class="proof-item"><i class="fas fa-shield-alt"></i> Secure Payments</div>
        <div class="proof-item"><i class="fas fa-clock"></i> Instant Card Issuance</div>
        <div class="proof-item"><i class="fas fa-undo"></i> 30-Day Satisfaction</div>
        <div class="proof-item"><i class="fas fa-headset"></i> 24/7 Member Support</div>
        <div class="proof-item"><i class="fas fa-lock"></i> Data Protected</div>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════ -->
<section class="how-it-works" id="how-it-works">
    <div class="container">
        <div class="text-center" data-animate="fade-up">
            <div class="section-eyebrow">Simple Process</div>
            <h2 class="section-title">Get Your Card in <em>4 Easy Steps</em></h2>
            <p class="section-subtitle">From sign-up to card in hand — the entire process takes less than 5 minutes.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card" data-animate="fade-up" data-delay="0">
                <div class="step-number">01</div>
                <div class="step-icon-wrap"><i class="fas fa-layer-group"></i></div>
                <h3 class="step-title">Choose Your Plan</h3>
                <p class="step-desc">Browse Bronze, Silver, Gold and Platinum plans. Each tier unlocks a different level of exclusive benefits and access.</p>
            </div>

            <div class="step-card" data-animate="fade-up" data-delay="100">
                <div class="step-number">02</div>
                <div class="step-icon-wrap"><i class="fas fa-user-plus"></i></div>
                <h3 class="step-title">Create Your Account</h3>
                <p class="step-desc">Fill in your details quickly and securely. Your member profile is created instantly with zero hassle.</p>
            </div>

            <div class="step-card" data-animate="fade-up" data-delay="200">
                <div class="step-number">03</div>
                <div class="step-icon-wrap"><i class="fas fa-credit-card"></i></div>
                <h3 class="step-title">Complete Payment</h3>
                <p class="step-desc">Pay securely with cash, card or mobile money. All transactions are encrypted and fully protected.</p>
            </div>

            <div class="step-card" data-animate="fade-up" data-delay="300">
                <div class="step-number">04</div>
                <div class="step-icon-wrap"><i class="fas fa-id-card"></i></div>
                <h3 class="step-title">Receive Your Card</h3>
                <p class="step-desc">Your digital membership card is issued immediately. Access your card, benefits and member portal right away.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     BENEFITS
═══════════════════════════════════════════ -->
<section id="benefits">
    <div class="container">
        <div data-animate="fade-up">
            <div class="section-eyebrow">Why Join</div>
            <h2 class="section-title">Everything You Get as a <em>Member</em></h2>
            <p class="section-subtitle">Your membership card is more than a card — it's your key to a world of exclusive privileges.</p>
        </div>

        <div class="benefits-grid" style="margin-top:64px;">
            <div class="benefit-card" data-animate="fade-up" data-delay="0">
                <div class="benefit-icon"><i class="fas fa-star"></i></div>
                <h3 class="benefit-title">VIP Access & Priority</h3>
                <p class="benefit-desc">Skip the queue at events, get early access to new releases and enjoy front-of-line priority treatment every time.</p>
            </div>

            <div class="benefit-card" data-animate="fade-up" data-delay="80">
                <div class="benefit-icon"><i class="fas fa-percent"></i></div>
                <h3 class="benefit-title">Exclusive Discounts</h3>
                <p class="benefit-desc">Enjoy member-only pricing, seasonal promotions and partner discounts that are not available to the general public.</p>
            </div>

            <div class="benefit-card" data-animate="fade-up" data-delay="160">
                <div class="benefit-icon"><i class="fas fa-id-card"></i></div>
                <h3 class="benefit-title">Digital Membership Card</h3>
                <p class="benefit-desc">Your card is available instantly in your member portal. Access it anytime, anywhere on any device — always at hand.</p>
            </div>

            <div class="benefit-card" data-animate="fade-up" data-delay="0">
                <div class="benefit-icon"><i class="fas fa-gift"></i></div>
                <h3 class="benefit-title">Member-Only Events</h3>
                <p class="benefit-desc">Get invited to exclusive events, meet-and-greets, behind-the-scenes experiences and private gatherings.</p>
            </div>

            <div class="benefit-card" data-animate="fade-up" data-delay="80">
                <div class="benefit-icon"><i class="fas fa-headset"></i></div>
                <h3 class="benefit-title">Dedicated Support</h3>
                <p class="benefit-desc">Members get priority customer support via a dedicated hotline and live chat. Your issues are resolved first, always.</p>
            </div>

            <div class="benefit-card" data-animate="fade-up" data-delay="160">
                <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                <h3 class="benefit-title">Secure & Guaranteed</h3>
                <p class="benefit-desc">All memberships come with a 30-day satisfaction guarantee. Your payment is 100% secure with full data protection.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     PLANS PREVIEW
═══════════════════════════════════════════ -->
<section class="plans-section" id="plans">
    <div class="container">
        <div class="text-center" data-animate="fade-up">
            <div class="section-eyebrow">Membership Plans</div>
            <h2 class="section-title">Choose Your <em>Level</em></h2>
            <p class="section-subtitle">From entry-level access to platinum elite privileges — there's a plan for every fan.</p>
        </div>

        <div class="plans-grid">
            @foreach($plans as $plan)
            @php
                $tierMap = ['Bronze'=>'bronze','Silver'=>'silver','Gold'=>'gold','Platinum'=>'platinum'];
                $iconMap  = ['Bronze'=>'medal','Silver'=>'award','Gold'=>'crown','Platinum'=>'gem'];
                $tier = $tierMap[$plan->name] ?? 'gold';
                $icon = $iconMap[$plan->name] ?? 'crown';
                $isFeatured = $plan->name === 'Gold';
                $features = array_filter(array_map('trim', explode("\n", $plan->features ?? '')));
            @endphp

            <div class="plan-card-pub {{ $isFeatured ? 'featured' : '' }}" data-animate="fade-up" data-delay="{{ $loop->index * 80 }}">
                @if($isFeatured)
                    <div class="plan-popular-badge">Most Popular</div>
                @endif

                <div class="plan-tier-icon {{ $tier }}">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>

                <div class="plan-name-pub">{{ $plan->name }}</div>
                <div class="plan-desc-pub">{{ $plan->description }}</div>

                <div class="plan-price-pub">
                    <span class="currency">$</span>
                    <span class="amount">{{ number_format($plan->price, 0) }}</span>
                    <span class="period">/plan</span>
                </div>

                <div class="plan-duration-badge">
                    <i class="fas fa-calendar"></i>
                    {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }} validity
                </div>

                <div class="plan-divider"></div>

                <ul class="plan-features-pub">
                    @foreach(array_slice($features, 0, 5) as $feature)
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        {{ $feature }}
                    </li>
                    @endforeach
                    @if(count($features) === 0)
                        <li><span class="check"><i class="fas fa-check"></i></span> Member card access</li>
                        <li><span class="check"><i class="fas fa-check"></i></span> {{ $plan->duration_months }}-month validity</li>
                        <li><span class="check"><i class="fas fa-check"></i></span> All member benefits</li>
                    @endif
                </ul>

                <a href="{{ route('public.checkout', $plan) }}" class="btn-get-card {{ $isFeatured ? 'btn-get-card-gold' : 'btn-get-card-outline' }}">
                    <i class="fas fa-id-card"></i>
                    Get This Card
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endforeach
        </div>

        <p style="text-align:center; margin-top:40px; font-size:13.5px; color:var(--white-muted);">
            All prices are one-time payments per membership period. No hidden fees. <a href="{{ route('public.plans') }}" style="color:var(--gold);">Compare all plans →</a>
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════ -->
<section class="testimonials">
    <div class="container">
        <div class="text-center" data-animate="fade-up">
            <div class="section-eyebrow">Member Stories</div>
            <h2 class="section-title">What Our Members <em>Say</em></h2>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card" data-animate="fade-up" data-delay="0">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Getting my Gold membership was the best decision I made. The VIP access alone is worth every penny. My card arrived instantly in my portal."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">A</div>
                    <div>
                        <div class="testimonial-name">Alexandra R.</div>
                        <div class="testimonial-plan">Gold Member</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-animate="fade-up" data-delay="100">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"The Platinum plan is incredible. Exclusive events, dedicated support and a card that genuinely opens doors. Absolutely worth it."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">M</div>
                    <div>
                        <div class="testimonial-name">Marcus T.</div>
                        <div class="testimonial-plan">Platinum Member</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-animate="fade-up" data-delay="200">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"I started with Silver and loved it so much I upgraded to Gold within a month. The process was smooth and the benefits are real."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">S</div>
                    <div>
                        <div class="testimonial-name">Sophia C.</div>
                        <div class="testimonial-plan">Gold Member</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     CTA
═══════════════════════════════════════════ -->
<section class="cta-section">
    <div class="container">
        <div class="cta-box" data-animate="fade-up">
            <div class="hero-eyebrow" style="display:inline-flex; margin-bottom:24px;">
                <i class="fas fa-fire"></i> Limited Time Offer
            </div>
            <h2 class="cta-title">
                Ready to Join the<br>
                <em>Inner Circle?</em>
            </h2>
            <p class="cta-desc">Thousands of fans already have their cards. Claim yours today and start enjoying the benefits that come with being a true member.</p>

            <div class="cta-actions">
                <a href="{{ route('public.plans') }}" class="btn-hero-primary">
                    <i class="fas fa-id-card"></i>
                    Choose My Plan
                </a>
                <a href="{{ route('fan.login') }}" class="btn-hero-ghost">
                    Already a member? Sign In
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Scroll-triggered animation
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            const delay = entry.target.dataset.delay || 0;
            setTimeout(() => {
                entry.target.classList.add('animated');
            }, parseInt(delay));
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.15 });

document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));
</script>
@endpush

@push('styles')
<style>
[data-animate] {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.65s cubic-bezier(0.4,0,0.2,1), transform 0.65s cubic-bezier(0.4,0,0.2,1);
}
[data-animate="fade-left"] { transform: translateX(30px); }
[data-animate].animated { opacity: 1; transform: none; }
</style>
@endpush
