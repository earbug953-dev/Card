php

@extends('layouts.public')
@section('title', 'Live Chat — Management Team')

@push('styles')
<style>
.chat-wrap{min-height:calc(100vh - var(--nav-h));padding:calc(var(--nav-h) + 0px) 0 0;display:flex;flex-direction:column;}
.chat-layout{flex:1;max-width:1280px;margin:0 auto;width:100%;padding:20px 24px 24px;display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;min-height:calc(100vh - var(--nav-h) - 20px);}
.cp{background:#111118;border:1px solid rgba(255,255,255,.07);border-radius:18px;display:flex;flex-direction:column;height:calc(100vh - var(--nav-h) - 44px);min-height:500px;overflow:hidden;}
.cp-header{display:flex;align-items:center;gap:14px;padding:16px 20px;background:#16161f;border-bottom:1px solid rgba(255,255,255,.06);flex-shrink:0;}
.cp-avatar{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#8A6820,#C9A84C);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;box-shadow:0 0 20px rgba(201,168,76,.25);}
.cp-name{font-size:15px;font-weight:600;color:#F2EFE8;}
.cp-status{font-size:12px;color:#3ecf78;display:flex;align-items:center;gap:6px;margin-top:2px;}
.cp-status-dot{width:7px;height:7px;border-radius:50%;background:#3ecf78;display:inline-block;}
.cp-badges{display:flex;align-items:center;gap:8px;margin-left:auto;}
.cp-badge{background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.25);border-radius:10px;padding:6px 14px;text-align:center;}
.cp-badge-label{font-size:9px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.35);display:block;margin-bottom:2px;}
.cp-badge-value{font-size:14px;font-weight:700;color:#C9A84C;display:block;}
.cp-messages{flex:1;overflow-y:auto;padding:20px 20px 8px;display:flex;flex-direction:column;gap:16px;background:#0e0e16;}
.sys-tag{text-align:center;}
.sys-tag span{display:inline-block;background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.18);border-radius:99px;padding:5px 16px;font-size:11.5px;color:#C9A84C;}
.msg-row{display:flex;gap:10px;align-items:flex-end;}
.msg-row.own{flex-direction:row-reverse;}
.msg-avatar{width:32px;height:32px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;}
.msg-avatar.admin-av{background:linear-gradient(135deg,#8A6820,#C9A84C);color:#0a0a0a;font-size:15px;}
.msg-avatar.fan-av{background:#1e2030;border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.55);font-size:14px;}
.msg-body{max-width:74%;display:flex;flex-direction:column;gap:4px;}
.msg-bubble{padding:12px 16px;border-radius:16px;font-size:13.5px;line-height:1.65;color:#E8E5DC;}
.admin-b{background:#1a1a26;border:1px solid rgba(255,255,255,.07);border-radius:16px 16px 16px 4px;}
.admin-label{display:block;font-size:10px;font-weight:700;color:#C9A84C;margin-bottom:5px;text-transform:uppercase;letter-spacing:.8px;}
.fan-b{background:#1a2035;border:1px solid rgba(91,156,246,.15);border-radius:16px 16px 4px 16px;color:#dde4f0;}
.pay-method{display:flex;align-items:center;gap:9px;margin:5px 0;font-size:13px;}
.msg-time{font-size:10.5px;color:rgba(255,255,255,.25);padding:0 2px;}
.msg-row.own .msg-time{text-align:right;}
.access-box{background:rgba(62,207,120,.07);border:1px solid rgba(62,207,120,.2);border-radius:16px;padding:22px 26px;max-width:380px;text-align:center;margin:0 auto;}
.access-code-val{font-family:monospace;font-size:26px;font-weight:700;color:#C9A84C;letter-spacing:4px;display:block;background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.25);border-radius:10px;padding:12px 20px;margin:10px 0 16px;}
.cp-input-area{padding:14px 16px;background:#16161f;border-top:1px solid rgba(255,255,255,.06);flex-shrink:0;}
.cp-input-row{display:flex;gap:10px;align-items:center;}
.cp-input{flex:1;background:#0e0e16;border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:12px 16px;color:#E8E5DC;font-family:'Inter',sans-serif;font-size:14px;outline:none;resize:none;transition:border-color .2s;}
.cp-input:focus{border-color:#C9A84C;box-shadow:0 0 0 3px rgba(201,168,76,.12);}
.cp-input::placeholder{color:rgba(255,255,255,.25);}
.cp-send{width:44px;height:44px;background:linear-gradient(135deg,#8A6820,#C9A84C);border:none;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#0a0a0a;font-size:16px;cursor:pointer;flex-shrink:0;transition:all .2s;}
.cp-send:hover{filter:brightness(1.1);transform:scale(1.05);}
.cp-ref{text-align:center;margin-top:8px;font-size:12px;color:rgba(255,255,255,.3);}
.cp-ref strong{color:#C9A84C;font-family:monospace;letter-spacing:1px;}
.quick-replies{display:flex;gap:6px;flex-wrap:wrap;margin-top:10px;}
.qr-btn{font-size:11.5px;padding:4px 11px;border-radius:99px;border:1px solid rgba(255,255,255,.08);background:#1a1a26;color:rgba(255,255,255,.45);cursor:pointer;transition:all .2s;font-family:'Inter',sans-serif;}
.qr-btn:hover{border-color:rgba(201,168,76,.35);color:#C9A84C;}
.admin-bar{padding:12px 16px;background:#16161f;border-top:1px solid rgba(255,255,255,.06);display:flex;gap:8px;flex-shrink:0;}
/* Right sidebar */
.rs{display:flex;flex-direction:column;gap:14px;position:sticky;top:calc(var(--nav-h) + 20px);}
.rs-card{background:#111118;border:1px solid rgba(255,255,255,.07);border-radius:16px;overflow:hidden;}
.rs-card-header{padding:14px 18px;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;color:#E8E5DC;}
.rs-card-header i{color:#C9A84C;}
.rs-body{padding:16px 18px;display:flex;flex-direction:column;gap:14px;}
.rs-label{font-size:10px;text-transform:uppercase;letter-spacing:1.2px;color:rgba(255,255,255,.35);margin-bottom:5px;font-weight:600;}
.rs-value{font-size:14px;color:#E8E5DC;font-weight:500;}
.rs-value.big{font-family:'Playfair Display',serif;font-size:24px;font-weight:900;color:#C9A84C;}
.rs-divider{height:1px;background:rgba(255,255,255,.06);margin:2px 0;}
.sp{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:99px;font-size:12px;font-weight:600;}
.sp-dot{width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;}
.sp-pending{background:rgba(240,168,64,.1);color:#f0a840;border:1px solid rgba(240,168,64,.2);}
.sp-completed{background:rgba(62,207,120,.1);color:#3ecf78;border:1px solid rgba(62,207,120,.2);}
.sp-rejected{background:rgba(224,82,82,.1);color:#e05252;border:1px solid rgba(224,82,82,.2);}
.whn-box{background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.18);border-radius:14px;padding:16px 18px;}
.whn-title{font-size:13px;font-weight:700;color:#C9A84C;margin-bottom:14px;display:flex;align-items:center;gap:7px;}
.whn-steps{display:flex;flex-direction:column;gap:11px;}
.whn-step{display:flex;gap:10px;align-items:flex-start;}
.whn-num{width:22px;height:22px;border-radius:50%;border:1px solid rgba(201,168,76,.4);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#C9A84C;flex-shrink:0;margin-top:1px;}
.whn-text{font-size:13px;color:rgba(255,255,255,.45);line-height:1.5;}
.rs-links{display:flex;gap:8px;padding:14px 18px;border-top:1px solid rgba(255,255,255,.06);}
.rs-link-btn{flex:1;text-align:center;padding:8px 12px;border-radius:9px;font-size:12.5px;font-weight:600;text-decoration:none;transition:all .2s;}
.rs-link-ghost{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);color:rgba(255,255,255,.5);}
.rs-link-ghost:hover{border-color:rgba(255,255,255,.2);color:#E8E5DC;}
.rs-link-gold{background:linear-gradient(135deg,#8A6820,#C9A84C);color:#0a0a0a;}
.rs-link-gold:hover{filter:brightness(1.07);}
.modal-backdrop{display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);backdrop-filter:blur(6px);z-index:500;align-items:center;justify-content:center;padding:20px;}
.modal-backdrop.open{display:flex;}
.modal{background:#111118;border:1px solid rgba(201,168,76,.25);border-radius:20px;width:100%;max-width:520px;animation:modalIn .3s ease;}
@keyframes modalIn{from{transform:scale(.94) translateY(12px);opacity:0}to{transform:scale(1) translateY(0);opacity:1}}
.modal-header{display:flex;align-items:center;justify-content:space-between;padding:20px 24px;border-bottom:1px solid rgba(255,255,255,.06);}
.modal-title{font-family:'Playfair Display',serif;font-size:21px;font-weight:700;color:#E8E5DC;}
.modal-close{background:none;border:none;color:rgba(255,255,255,.4);width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:15px;transition:all .2s;}
.modal-close:hover{background:rgba(255,255,255,.06);color:#E8E5DC;}
.modal-body{padding:22px 24px;}
.modal-footer{padding:16px 24px;border-top:1px solid rgba(255,255,255,.06);display:flex;gap:10px;justify-content:flex-end;}
@media(max-width:900px){.chat-layout{grid-template-columns:1fr;padding:12px;}.rs{display:none;}.cp{height:calc(100vh - var(--nav-h) - 24px);}}
@media(max-width:480px){.cp-badges{display:none;}}
</style>
@endpush

@section('content')
<div class="chat-wrap">
  <div class="chat-layout">

    {{-- ══════ CHAT PANEL ══════ --}}
    <div class="cp">

      {{-- Header --}}
      <div class="cp-header">
        <div class="cp-avatar">👑</div>
        <div style="flex:1;">
          <div class="cp-name">VIP Management Team</div>
          <div class="cp-status">
            <span class="cp-status-dot"></span>
            @if($conversation->status==='open') Online — here to help you complete your membership
            @elseif($transaction->status==='completed') Chat closed · Payment approved ✓
            @else Chat closed @endif
          </div>
        </div>
        <div class="cp-badges">
          <div class="cp-badge">
            <span class="cp-badge-label">Plan</span>
            <span class="cp-badge-value">{{ $transaction->plan->name ?? '—' }}</span>
          </div>
          <div class="cp-badge">
            <span class="cp-badge-label">Amount</span>
            <span class="cp-badge-value">${{ number_format($transaction->amount,2) }}</span>
          </div>
          @if($transaction->status==='pending') <span class="sp sp-pending"><span class="sp-dot"></span>Pending</span>
          @elseif($transaction->status==='completed') <span class="sp sp-completed"><span class="sp-dot"></span>Approved</span>
          @elseif($transaction->status==='rejected') <span class="sp sp-rejected"><span class="sp-dot"></span>Rejected</span>
          @endif
        </div>
      </div>

      {{-- Messages --}}
      <div class="cp-messages" id="chatMessages">

        <div class="sys-tag">
          <span><i class="fas fa-lock" style="font-size:10px;margin-right:5px;"></i>Chat started · {{ $conversation->created_at->format('M d, Y') }}</span>
        </div>

        {{-- Auto welcome --}}
        <div class="msg-row">
          <div class="msg-avatar admin-av">👑</div>
          <div class="msg-body">
            <div class="msg-bubble admin-b">
              <span class="admin-label">Management Team</span>
              <strong style="color:#E8E5DC;">Welcome, {{ $transaction->user->name }}!</strong><br><br>
              To complete your membership, please let us know your preferred payment method:
              <div style="margin:12px 0 4px;">
                <div class="pay-method"><span style="font-size:15px;">💳</span><div><strong style="color:#E8E5DC;">Bank Transfer</strong> — Account details sent on request</div></div>
                <div class="pay-method"><span style="font-size:15px;">💵</span><div><strong style="color:#E8E5DC;">Cash Payment</strong> — Arrange with our team</div></div>
                <div class="pay-method"><span style="font-size:15px;">📱</span><div><strong style="color:#E8E5DC;">Mobile Money</strong> — Number sent on request</div></div>
              </div>
              Simply reply below and we'll guide you through the rest!
            </div>
            <div class="msg-time">Management Team · {{ $conversation->created_at->format('g:i A') }}</div>
          </div>
        </div>

        {{-- All messages --}}
        @foreach($messages as $msg)
          @php
            $isAdmin = $msg->user->is_admin;
            $isOwn   = $msg->user_id === auth()->id() && !auth()->user()->is_admin;
          @endphp
          <div class="msg-row {{ $isOwn ? 'own' : '' }}">
            <div class="msg-avatar {{ $isAdmin ? 'admin-av' : 'fan-av' }}">
              @if($isAdmin) 👑 @else {{ strtoupper(substr($msg->user->name,0,1)) }} @endif
            </div>
            <div class="msg-body">
              <div class="msg-bubble {{ $isAdmin ? 'admin-b' : 'fan-b' }}">
                @if($isAdmin)<span class="admin-label">Management Team</span>@endif
                @php echo nl2br(e($msg->message)); @endphp
              </div>
              <div class="msg-time">{{ $isAdmin ? 'Management Team' : $msg->user->name }} · {{ $msg->created_at->format('g:i A') }}</div>
            </div>
          </div>
        @endforeach

        {{-- Access code --}}
        @if($transaction->status==='completed' && $transaction->access_code)
          <div class="sys-tag">
            <div class="access-box">
              <i class="fas fa-check-circle" style="font-size:30px;color:#3ecf78;margin-bottom:12px;display:block;"></i>
              <div style="font-size:15px;font-weight:700;color:#E8E5DC;margin-bottom:4px;">Payment Approved! 🎉</div>
              <div style="font-size:12.5px;color:rgba(255,255,255,.4);margin-bottom:4px;">Your VIP Card Access Code:</div>
              <span class="access-code-val">{{ $transaction->access_code }}</span>
              @if($transaction->membershipCard)
              <div style="font-size:12.5px;color:rgba(255,255,255,.4);margin-top:10px;">Membership Card Number:</div>
              <span class="access-code-val" style="letter-spacing:2px;">{{ $transaction->membershipCard->formatted_number }}</span>
              @endif
              <a href="{{ route('card.view',$transaction->access_code) }}"
                 style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px 20px;background:linear-gradient(135deg,#8A6820,#C9A84C);color:#0a0a0a;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;">
                <i class="fas fa-id-card"></i> View My VIP Card
              </a>
            </div>
          </div>
        @endif

        <div id="chatEnd"></div>
      </div>

      {{-- Admin action bar --}}
      @if(auth()->user()->is_admin && $transaction->status==='pending')
      <div class="admin-bar">
        <button onclick="approvePayment()" class="btn btn-success" style="flex:1;justify-content:center;">
          <i class="fas fa-check-circle"></i> Approve & Issue Card
        </button>
        <button onclick="document.getElementById('rejectModal').classList.add('open')" class="btn btn-danger" style="flex:1;justify-content:center;">
          <i class="fas fa-times-circle"></i> Reject
        </button>
        <button onclick="closeChat()" class="btn btn-secondary" style="padding:10px 14px;" title="Close chat">
          <i class="fas fa-times"></i>
        </button>
      </div>
      @endif

      {{-- Input --}}
      @if($conversation->status==='open')
      <div class="cp-input-area">
        <div class="cp-input-row">
          <input type="text" class="cp-input" id="msgInput"
            placeholder="Type a message…"
            onkeydown="if(event.key==='Enter'){event.preventDefault();sendMsg();}">
          <button class="cp-send" onclick="sendMsg()"><i class="fas fa-paper-plane"></i></button>
        </div>
        @if(auth()->user()->is_admin)
        <div class="quick-replies">
          @foreach(['Payment received — issuing your card now! 🎉','What payment method works best for you?','Please share your payment reference number.','Could you send a screenshot of the transfer?','Your card will be issued shortly — thank you!'] as $qr)
          <button class="qr-btn" onclick="document.getElementById('msgInput').value='{{ $qr }}'">{{ Str::limit($qr,36) }}</button>
          @endforeach
        </div>
        @endif
        <div class="cp-ref">
          <i class="fas fa-info-circle" style="margin-right:4px;"></i>
          Reference: <strong>TXN-{{ str_pad($transaction->id,6,'0',STR_PAD_LEFT) }}</strong>
        </div>
      </div>
      @else
      <div style="padding:16px;background:#16161f;border-top:1px solid rgba(255,255,255,.06);text-align:center;font-size:13.5px;color:rgba(255,255,255,.4);">
        @if($transaction->status==='completed')
          <i class="fas fa-check-circle" style="color:#3ecf78;margin-right:6px;"></i> Chat closed — your card has been issued!
          <a href="{{ route('card.view',$transaction->access_code) }}" style="color:#C9A84C;margin-left:8px;">View My Card →</a>
        @else
          <i class="fas fa-times-circle" style="color:#e05252;margin-right:6px;"></i> This chat has been closed.
        @endif
      </div>
      @endif

    </div>{{-- end .cp --}}

    {{-- ══════ RIGHT SIDEBAR ══════ --}}
    <div class="rs">

      {{-- Plan & Payment --}}
      <div class="rs-card">
        <div class="rs-card-header"><i class="fas fa-layer-group"></i> Plan &amp; Payment</div>
        <div class="rs-body">
          <div>
            <div class="rs-label">Plan</div>
            <span style="background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.25);color:#C9A84C;padding:4px 12px;border-radius:99px;font-size:12.5px;font-weight:700;">{{ $transaction->plan->name ?? '—' }}</span>
          </div>
          <div class="rs-divider"></div>
          <div>
            <div class="rs-label">Amount</div>
            <div class="rs-value big">${{ number_format($transaction->amount,2) }}</div>
          </div>
          <div class="rs-divider"></div>
          <div>
            <div class="rs-label">Duration</div>
            <div class="rs-value">{{ $transaction->plan->duration_months ?? '—' }} month{{ ($transaction->plan->duration_months??1)>1?'s':'' }}</div>
          </div>
          <div class="rs-divider"></div>
          <div>
            <div class="rs-label">Status</div>
            @if($transaction->status==='pending') <span class="sp sp-pending"><span class="sp-dot"></span>Pending</span>
            @elseif($transaction->status==='completed') <span class="sp sp-completed"><span class="sp-dot"></span>Approved</span>
            @elseif($transaction->status==='rejected') <span class="sp sp-rejected"><span class="sp-dot"></span>Rejected</span>
            @endif
          </div>
          @if($transaction->access_code)
          <div class="rs-divider"></div>
          <div>
            <div class="rs-label">Card Code</div>
            <div style="font-family:monospace;font-size:15px;font-weight:700;color:#C9A84C;letter-spacing:2px;">{{ $transaction->access_code }}</div>
          </div>
          @endif
          @if($transaction->membershipCard)
          <div class="rs-divider"></div>
          <div>
            <div class="rs-label">Card Number</div>
            <div style="font-family:monospace;font-size:15px;font-weight:700;color:#E8E5DC;letter-spacing:2px;">{{ $transaction->membershipCard->formatted_number }}</div>
          </div>
          @endif
        </div>
        @if($transaction->status==='completed' && $transaction->access_code)
        <div class="rs-links">
          <a href="{{ route('card.view',$transaction->access_code) }}" class="rs-link-btn rs-link-gold" style="text-align:center;"><i class="fas fa-id-card"></i> View My Card</a>
        </div>
        @elseif($transaction->status==='pending')
        <div class="rs-links">
          <a href="{{ route('login') }}" class="rs-link-btn rs-link-ghost">Sign In</a>
          <a href="{{ route('register') }}" class="rs-link-btn rs-link-gold">Join Now</a>
        </div>
        @endif
      </div>

      {{-- Applicant info (admin only) --}}
      @if(auth()->user()->is_admin)
      <div class="rs-card">
        <div class="rs-card-header"><i class="fas fa-user"></i> Applicant</div>
        <div style="padding:14px 18px;display:flex;align-items:center;gap:12px;">
          <div style="width:52px;height:52px;border-radius:50%;overflow:hidden;border:2px solid #C9A84C;flex-shrink:0;background:#1a1a26;display:flex;align-items:center;justify-content:center;">
            @if($transaction->user_photo_path)
              <img src="{{ asset('storage/'.$transaction->user_photo_path) }}" alt="" style="width:100%;height:100%;object-fit:cover;object-position:center top;">
            @else
              <span style="font-size:20px;font-weight:700;color:#C9A84C;">{{ strtoupper(substr($transaction->user->name,0,1)) }}</span>
            @endif
          </div>
          <div style="min-width:0;">
            <div style="font-size:14px;font-weight:600;color:#E8E5DC;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $transaction->user->name }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,.4);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $transaction->user->email }}</div>
            @if($transaction->user_phone)
            <div style="font-size:12px;color:rgba(255,255,255,.35);margin-top:2px;">{{ $transaction->user_phone }}</div>
            @endif
            @if($transaction->user_address)
            <div style="font-size:12px;color:rgba(255,255,255,.3);margin-top:1px;">{{ $transaction->user_address }}</div>
            @endif
          </div>
        </div>
      </div>
      @endif

      {{-- What Happens Next --}}
      <div class="whn-box">
        <div class="whn-title"><i class="fas fa-info-circle"></i> What Happens Next</div>
        <div class="whn-steps">
          @foreach(['Tell us your preferred payment method','Management sends payment details','Pay and share your reference','Admin approves &amp; issues your card','Enter code to view your VIP card'] as $i=>$s)
          <div class="whn-step">
            <div class="whn-num">{{ $i+1 }}</div>
            <div class="whn-text">{!! $s !!}</div>
          </div>
          @endforeach
        </div>
      </div>

    </div>{{-- end .rs --}}

  </div>
</div>

{{-- Reject Modal --}}
<div class="modal-backdrop" id="rejectModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Reject Payment</div>
      <button class="modal-close" onclick="document.getElementById('rejectModal').classList.remove('open')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div style="margin-bottom:7px;font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.8px;color:rgba(255,255,255,.4);">Reason for Rejection *</div>
      <textarea id="rejectReason" rows="3" placeholder="Please explain why the payment is being rejected…"
        style="width:100%;background:#0e0e16;border:1px solid rgba(255,255,255,.08);border-radius:10px;padding:12px 14px;color:#E8E5DC;font-family:'Inter',sans-serif;font-size:14px;outline:none;resize:vertical;"></textarea>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="document.getElementById('rejectModal').classList.remove('open')">Cancel</button>
      <button class="btn btn-danger" onclick="confirmReject()"><i class="fas fa-times-circle"></i> Confirm Rejection</button>
    </div>
  </div>
</div>

@push('scripts')
<script>
const CSRF=document.querySelector('meta[name="csrf-token"]').content;
const DRAFT_KEY = 'chatDraft_{{ $conversation->id }}';
const msgInput = document.getElementById('msgInput');

if(msgInput){
  const savedDraft = localStorage.getItem(DRAFT_KEY);
  if(savedDraft){
    msgInput.value = savedDraft;
  } else {
    @if(!auth()->user()->is_admin)
      msgInput.value = @json('Hello, I would like to request delivery of my VIP card. Please send me the delivery details and tracking information.');
    @endif
  }
  msgInput.addEventListener('input', () => {
    localStorage.setItem(DRAFT_KEY, msgInput.value);
  });
}

async function sendMsg(){
  const inp=document.getElementById('msgInput');
  if(!inp) return;
  const msg=inp.value.trim();if(!msg)return;
  inp.disabled=true;
  try{
    const res=await fetch("{{ route('chat.message.send',$conversation) }}",{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({message:msg})});
    if(res.ok){
      localStorage.removeItem(DRAFT_KEY);
      location.reload();
    } else {
      inp.disabled=false;
    }
  }catch(e){inp.disabled=false;}
}

async function approvePayment(){
  if(!confirm('Approve this payment and issue a VIP Card access code?'))return;
  const btn=event.target.closest('button');
  btn.disabled=true;btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Processing…';
  try{
    const res=await fetch("{{ route('chat.approve',$conversation) }}",{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF}});
    const data=await res.json();
    if(data.success)location.reload();else{btn.disabled=false;btn.innerHTML='<i class="fas fa-check-circle"></i> Approve & Issue Card';}
  }catch(e){btn.disabled=false;}
}

async function confirmReject(){
  const reason=document.getElementById('rejectReason').value.trim();
  if(!reason){alert('Please enter a reason for rejection.');return;}
  const res=await fetch("{{ route('chat.reject',$conversation) }}",{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({reason})});
  const data=await res.json();
  if(data.success){document.getElementById('rejectModal').classList.remove('open');location.reload();}
}

async function closeChat(){
  if(!confirm('Close this conversation?'))return;
  const res=await fetch("{{ route('chat.close',$conversation) }}",{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF}});
  const data=await res.json();
  if(data.success)location.reload();
}

document.getElementById('chatEnd')?.scrollIntoView({behavior:'smooth'});

@if($conversation->status==='open' && $transaction->status==='pending')
setInterval(()=>location.reload(),10000);
@endif

document.getElementById('rejectModal')?.addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});
</script>
@endpush
@endsection
