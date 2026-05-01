@extends('layouts.public')
@section('title', 'Live Chat — Management Team')

@section('content')
<div style="min-height:calc(100vh - var(--nav-h)); padding:calc(var(--nav-h) + 30px) 24px 40px; display:flex; flex-direction:column;">
    <div style="max-width:1100px; margin:0 auto; width:100%; flex:1; display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

        <!-- CHAT PANEL -->
        <div style="background:var(--ink-2); border:1px solid rgba(255,255,255,0.06); border-radius:20px; overflow:hidden; display:flex; flex-direction:column; height:calc(100vh - var(--nav-h) - 80px); min-height:500px;">

            <!-- Chat Header -->
            <div style="padding:16px 22px; background:var(--ink-3); border-bottom:1px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:14px; flex-shrink:0;">
                <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#8A6820,#C9A84C);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;box-shadow:0 0 20px rgba(201,168,76,0.3);">👑</div>
                <div style="flex:1;">
                    <div style="font-size:15px;font-weight:600;color:var(--white);">VIP Management Team</div>
                    <div style="font-size:12px;color:var(--success);display:flex;align-items:center;gap:6px;">
                        <span style="width:7px;height:7px;border-radius:50%;background:var(--success);display:inline-block;"></span>
                        Online · Here to help you complete your membership
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.2);border-radius:10px;padding:8px 14px;">
                    <i class="fas fa-id-card" style="color:var(--gold);font-size:13px;"></i>
                    <div>
                        <div style="font-size:9px;text-transform:uppercase;letter-spacing:1px;color:var(--white-muted);">Plan</div>
                        <div style="font-size:13px;font-weight:600;color:var(--gold-light);">{{ $application->plan->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div id="chatMessages" style="flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:14px;">

                <!-- Welcome System Message -->
                <div style="text-align:center;padding:10px 20px;">
                    <div style="display:inline-block;background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.15);border-radius:99px;padding:6px 16px;font-size:12px;color:var(--gold);">
                        <i class="fas fa-lock" style="margin-right:5px;font-size:10px;"></i>Chat started · {{ now()->format('M d, Y') }}
                    </div>
                </div>

                <!-- System welcome -->
                <div style="display:flex;gap:10px;">
                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#8A6820,#C9A84C);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;align-self:flex-end;">👑</div>
                    <div style="max-width:78%;">
                        <div style="background:var(--ink-3);border:1px solid rgba(255,255,255,0.06);border-radius:16px 16px 16px 4px;padding:14px 16px;font-size:14px;line-height:1.6;color:var(--white-dim);">
                            <strong style="color:var(--white);">Welcome, {{ $application->first_name }}!</strong> 👋<br><br>
                            Thank you for applying for the <strong style="color:var(--gold);">{{ $application->plan->name }} Membership Card</strong>.<br><br>
                            We've received your application and we're excited to have you join the club! 🌟<br><br>
                            To complete your membership, please send us your <strong>payment of ${{ number_format($application->plan->price, 2) }}</strong> using one of these methods:<br><br>
                            💳 <strong>Bank Transfer</strong> — Account details will be provided on request<br>
                            💵 <strong>Cash Payment</strong> — Arrange with our team<br>
                            📱 <strong>Mobile Money</strong> — Number on request<br><br>
                            Simply let us know your preferred payment method and we'll guide you through the rest!
                        </div>
                        <div style="font-size:11px;color:var(--white-muted);margin-top:4px;margin-left:4px;">Management Team · {{ now()->format('g:i A') }}</div>
                    </div>
                </div>

                <!-- Existing chat messages -->
                @foreach($application->chatMessages as $msg)
                <div style="display:flex; gap:10px; {{ $msg->sender === 'fan' ? 'flex-direction:row-reverse;' : '' }}">
                    @if($msg->sender === 'admin')
                        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#8A6820,#C9A84C);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;align-self:flex-end;">👑</div>
                    @else
                        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#1a3a2a,#2E7D52);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;align-self:flex-end;">{{ strtoupper(substr($application->first_name,0,1)) }}</div>
                    @endif
                    <div style="max-width:78%;">
                        <div style="background:{{ $msg->sender === 'fan' ? 'linear-gradient(135deg,rgba(201,168,76,0.15),rgba(201,168,76,0.08))' : 'var(--ink-3)' }};border:1px solid {{ $msg->sender === 'fan' ? 'rgba(201,168,76,0.2)' : 'rgba(255,255,255,0.06)' }};border-radius:{{ $msg->sender === 'fan' ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }};padding:12px 16px;font-size:14px;line-height:1.6;color:{{ $msg->sender === 'fan' ? 'var(--white)' : 'var(--white-dim)' }};">
                            {!! nl2br(e($msg->message)) !!}
                        </div>
                        <div style="font-size:11px;color:var(--white-muted);margin-top:4px;{{ $msg->sender === 'fan' ? 'text-align:right;margin-right:4px;' : 'margin-left:4px;' }}">
                            {{ $msg->sender === 'admin' ? 'Management' : $application->first_name }} · {{ $msg->created_at->format('g:i A') }}
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Card ID notification if approved -->
                @if($application->status === 'approved' && $application->card_code)
                <div style="text-align:center;padding:10px 0;">
                    <div style="display:inline-block;background:rgba(76,175,124,0.1);border:1px solid rgba(76,175,124,0.25);border-radius:16px;padding:16px 24px;max-width:340px;">
                        <i class="fas fa-check-circle" style="font-size:24px;color:var(--success);margin-bottom:10px;display:block;"></i>
                        <div style="font-size:14px;font-weight:600;color:var(--white);margin-bottom:8px;">Payment Approved! 🎉</div>
                        <div style="font-size:12px;color:var(--white-muted);margin-bottom:12px;">Your VIP Card ID Code:</div>
                        <div style="font-family:monospace;font-size:22px;font-weight:700;color:var(--gold);letter-spacing:3px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:8px;padding:10px 16px;">{{ $application->card_code }}</div>
                        <div style="margin-top:14px;">
                            <a href="{{ route('fan.my-card') }}" style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#8A6820,#C9A84C);color:#0a0a0a;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;">
                                <i class="fas fa-id-card"></i> View My Card Now
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div id="chatEnd"></div>
            </div>

            <!-- Input -->
            @if($application->status !== 'approved' && $application->status !== 'rejected')
            <div style="padding:14px 16px;background:var(--ink-3);border-top:1px solid rgba(255,255,255,0.06);flex-shrink:0;">
                <form action="{{ route('fan.chat.send', $application) }}" method="POST" style="display:flex;gap:10px;">
                    @csrf
                    <input type="text" name="message" placeholder="Type your message…" required autocomplete="off"
                        style="flex:1;background:var(--ink-2);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:12px 16px;color:var(--white);font-family:var(--font-body);font-size:14px;outline:none;transition:var(--transition);"
                        onfocus="this.style.borderColor='var(--gold)';this.style.boxShadow='0 0 0 3px var(--gold-glow)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)';this.style.boxShadow='none'">
                    <button type="submit" style="background:linear-gradient(135deg,#8A6820,#C9A84C);color:#0a0a0a;border:none;border-radius:12px;padding:12px 20px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;font-family:var(--font-body);white-space:nowrap;">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </form>
                <div style="text-align:center;margin-top:8px;font-size:11.5px;color:var(--white-muted);">
                    <i class="fas fa-info-circle" style="margin-right:4px;"></i>
                    Reference: <strong style="color:var(--gold);font-family:monospace;">{{ $application->reference_number }}</strong>
                </div>
            </div>
            @else
            <div style="padding:16px;background:var(--ink-3);border-top:1px solid rgba(255,255,255,0.06);text-align:center;font-size:13.5px;color:var(--white-muted);">
                @if($application->status === 'approved')
                    <i class="fas fa-check-circle" style="color:var(--success);margin-right:6px;"></i>This chat is closed. Your card has been issued!
                    <a href="{{ route('fan.my-card') }}" style="color:var(--gold);text-decoration:none;margin-left:8px;">View My Card →</a>
                @else
                    <i class="fas fa-times-circle" style="color:var(--danger);margin-right:6px;"></i>This application was not approved. <a href="{{ route('public.plans') }}" style="color:var(--gold);text-decoration:none;">Browse plans again</a>
                @endif
            </div>
            @endif
        </div>

        <!-- RIGHT SIDEBAR -->
        <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:calc(var(--nav-h) + 20px);">

            <!-- Status Card -->
            <div style="background:var(--ink-2);border:1px solid rgba(255,255,255,0.06);border-radius:16px;overflow:hidden;">
                <div style="padding:16px 18px;border-bottom:1px solid rgba(255,255,255,0.06);">
                    <div style="font-size:13px;font-weight:600;color:var(--white);">Application Status</div>
                </div>
                <div style="padding:16px 18px;display:flex;flex-direction:column;gap:12px;">
                    @foreach([
                        ['Applicant', $application->first_name . ' ' . $application->last_name],
                        ['Plan', $application->plan->name . ' — $' . number_format($application->plan->price, 2)],
                        ['Reference', $application->reference_number],
                        ['Submitted', $application->created_at->format('M d, Y g:i A')],
                    ] as [$l, $v])
                    <div style="display:flex;flex-direction:column;gap:2px;">
                        <span style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:var(--white-muted);">{{ $l }}</span>
                        <span style="font-size:13px;color:var(--white);font-weight:500;">{{ $v }}</span>
                    </div>
                    @endforeach
                    <div style="padding-top:8px;border-top:1px solid rgba(255,255,255,0.06);">
                        <span style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:var(--white-muted);">Status</span>
                        <div style="margin-top:4px;">
                            @if($application->status === 'pending')
                                <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--warning);background:rgba(240,168,64,0.12);border:1px solid rgba(240,168,64,0.25);padding:4px 10px;border-radius:99px;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:var(--warning);"></span> Pending Approval
                                </span>
                            @elseif($application->status === 'approved')
                                <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--success);background:rgba(76,175,124,0.12);border:1px solid rgba(76,175,124,0.25);padding:4px 10px;border-radius:99px;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:var(--success);"></span> Approved ✓
                                </span>
                            @else
                                <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--danger);background:rgba(224,82,82,0.12);border:1px solid rgba(224,82,82,0.25);padding:4px 10px;border-radius:99px;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:var(--danger);"></span> Not Approved
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.2);border-radius:16px;padding:18px;">
                <div style="font-size:13px;font-weight:600;color:var(--gold-light);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-info-circle"></i> What Happens Next
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach([
                        ['1','Tell us your preferred payment method in the chat'],
                        ['2','Our team will send payment details to you directly'],
                        ['3','Once paid, we issue your unique VIP Card ID code'],
                        ['4','Enter the code in "My Card" to view your digital card'],
                    ] as [$n, $t])
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:22px;height:22px;border-radius:50%;border:1px solid rgba(201,168,76,0.4);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:var(--gold);flex-shrink:0;margin-top:1px;">{{ $n }}</div>
                        <div style="font-size:13px;color:var(--white-muted);line-height:1.55;">{{ $t }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- My Card Link -->
            @if(session('fan_member_id'))
            <a href="{{ route('fan.my-card') }}" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;background:var(--ink-2);border:1px solid rgba(255,255,255,0.06);border-radius:12px;font-size:13.5px;color:var(--white-dim);text-decoration:none;transition:var(--transition);" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)';this.style.color='var(--white-dim)'">
                <i class="fas fa-id-card"></i> Go to My Membership Card
            </a>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
// Auto-scroll to bottom
document.getElementById('chatEnd')?.scrollIntoView();

// Auto-refresh every 8s for new admin messages
@if($application->status === 'pending')
setInterval(()=>location.reload(), 8000);
@endif
</script>
@endpush
@endsection
