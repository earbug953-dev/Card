@extends('layouts.app')
@section('title','My Dashboard')
@section('breadcrumb-parent','My Dashboard')

@section('content')
<div class="page-header">
  <div>
    <div class="ph-title">Welcome, {{ auth()->user()->name }}! 👋</div>
    <div class="ph-sub">Your membership overview and VIP card access</div>
  </div>
  <div class="ph-actions">
    <a href="{{ route('shop.index') }}" class="btn btn-primary"><i class="fas fa-id-card"></i> Browse Plans</a>
  </div>
</div>

@php
  $transactions = $user->purchaseTransactions ?? collect();
  $activeCard = $transactions->where('status','completed')->first();
@endphp

@if($activeCard)
{{-- Active card --}}
<div style="display:grid;grid-template-columns:auto 1fr;gap:24px;align-items:start;margin-bottom:28px;">
  <div style="max-width:400px;">
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold);margin-bottom:14px;"><i class="fas fa-id-card" style="margin-right:6px;"></i>Your VIP Card</div>
    {{-- Render the VIP card --}}
    <div style="background:#000;border-radius:14px;padding:20px;position:relative;overflow:hidden;border:1.5px solid #9A7A2E;box-shadow:0 20px 60px rgba(0,0,0,.7),0 0 40px rgba(201,168,76,.1);">
      <div style="position:absolute;inset:0;border-radius:14px;padding:1.5px;background:linear-gradient(135deg,#9A7A2E,#E8C97A,#C9A84C,#9A7A2E);-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none;"></div>
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;position:relative;z-index:1;">
        <div style="display:flex;flex-direction:column;align-items:center;">
          <div style="width:56px;height:56px;border-radius:50%;border:2px solid #9A7A2E;background:radial-gradient(circle,#1a1200,#0a0900);display:flex;align-items:center;justify-content:center;"><span style="font-size:20px;">👑</span></div>
          <div style="font-size:11px;font-weight:900;color:#FFD700;letter-spacing:3px;margin-top:2px;">VIP</div>
        </div>
        <div style="text-align:right;font-size:11px;color:#FFD700;font-weight:700;">ACTIVATION FEE:<br><span style="font-size:15px;">${{ number_format($activeCard->amount,0) }}</span></div>
      </div>
      <div style="margin-bottom:8px;position:relative;z-index:1;"><span style="font-size:18px;font-weight:900;color:#FFD700;letter-spacing:2px;display:block;">MEMBERSHIP</span><span style="font-size:18px;font-weight:900;color:#FFD700;letter-spacing:2px;display:block;">CARD</span></div>
      <div style="font-size:10px;color:rgba(255,215,0,.7);margin-bottom:6px;position:relative;z-index:1;">ACTIVATION FEE : {{ number_format($activeCard->amount,0) }}</div>
      <div style="font-size:10px;color:rgba(255,215,0,.7);margin-bottom:10px;position:relative;z-index:1;">{{ auth()->user()->address ?? 'Your Address' }}</div>
      <div style="display:flex;justify-content:space-between;align-items:flex-end;position:relative;z-index:1;">
        <div style="display:flex;flex-direction:column;align-items:center;">
          <div style="width:70px;height:70px;border-radius:50%;border:2px solid #9A7A2E;overflow:hidden;background:#1a1200;display:flex;align-items:center;justify-content:center;">
            @if($activeCard->user_photo_path)<img src="{{ asset('storage/'.$activeCard->user_photo_path) }}" style="width:100%;height:100%;object-fit:cover;object-position:center top;">
            @else<i class="fas fa-user" style="font-size:28px;color:rgba(201,168,76,.3);"></i>@endif
          </div>
          <div style="font-size:9px;color:#FFD700;font-weight:700;margin-top:4px;letter-spacing:1px;text-transform:uppercase;">{{ strtoupper(auth()->user()->name) }}</div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:center;">
          <div style="width:70px;height:70px;border-radius:50%;border:2px solid #9A7A2E;overflow:hidden;background:#1a1200;display:flex;align-items:center;justify-content:center;">
            @if($activeCard->plan->celebrity_image)<img src="{{ asset('storage/'.$activeCard->plan->celebrity_image) }}" style="width:100%;height:100%;object-fit:cover;object-position:center top;">
            @else<i class="fas fa-star" style="font-size:28px;color:rgba(201,168,76,.3);"></i>@endif
          </div>
          <div style="font-size:9px;color:#FFD700;font-weight:700;margin-top:4px;letter-spacing:1px;text-transform:uppercase;">{{ strtoupper($activeCard->plan->celebrity_name ?? 'CELEBRITY') }}</div>
        </div>
      </div>
      <div style="height:3px;background:linear-gradient(90deg,transparent,#9A7A2E,#FFD700,#9A7A2E,transparent);border-radius:2px;margin-top:14px;position:relative;z-index:1;"></div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px;">
      <a href="{{ route('card.view', $activeCard->access_code) }}" class="btn btn-primary" style="justify-content:center;"><i class="fas fa-id-card"></i> Full Card</a>
      <button onclick="navigator.clipboard.writeText('{{ $activeCard->access_code }}').then(()=>alert('Copied!'))" class="btn btn-secondary" style="justify-content:center;"><i class="fas fa-copy"></i> Copy Code</button>
    </div>
  </div>

  <div style="display:flex;flex-direction:column;gap:16px;">
    <div class="panel">
      <div class="panel-header"><div class="panel-title">Membership Details</div><span class="badge badge-success"><span class="badge-dot"></span>Active</span></div>
      <div class="panel-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        @foreach([['Plan',$activeCard->plan->name.' Membership'],['Access Code',$activeCard->access_code],['Amount Paid','$'.number_format($activeCard->amount,2)],['Celebrity',$activeCard->plan->celebrity_name??'—']] as [$l,$v])
        <div><div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:var(--white-40);font-weight:600;margin-bottom:3px;">{{ $l }}</div><div style="font-size:13.5px;color:{{ $l==='Access Code'?'var(--gold)':'var(--white)' }};font-weight:500;{{ $l==='Access Code'?'font-family:monospace;letter-spacing:1.5px;':'' }}">{{ $v }}</div></div>
        @endforeach
      </div>
    </div>
    <div class="panel">
      <div class="panel-header"><div class="panel-title">Quick Actions</div></div>
      <div class="panel-body" style="padding:12px;">
        @foreach([[route('card.view',$activeCard->access_code),'fas fa-id-card','View Full VIP Card','See your complete digital membership card'],[route('chat.show',$activeCard->chatConversation??'#'),'fas fa-comments','My Chat History','View your conversation with management'],[route('shop.index'),'fas fa-arrow-up','Upgrade My Plan','Move to a higher membership tier']] as [$href,$icon,$label,$desc])
        <a href="{{ $href }}" style="display:flex;align-items:center;gap:12px;padding:12px;border-radius:10px;margin-bottom:8px;background:var(--ink-4);border:1px solid var(--white-06);transition:var(--tx);" onmouseover="this.style.borderColor='var(--gold-border)'" onmouseout="this.style.borderColor='var(--white-06)'">
          <div style="width:36px;height:36px;border-radius:9px;background:var(--gold-glow);border:1px solid var(--gold-border);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:15px;flex-shrink:0;"><i class="{{ $icon }}"></i></div>
          <div><div style="font-size:13.5px;font-weight:600;color:var(--white);">{{ $label }}</div><div style="font-size:12px;color:var(--white-40);">{{ $desc }}</div></div>
          <i class="fas fa-chevron-right" style="color:var(--white-40);font-size:11px;margin-left:auto;"></i>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>

@else
{{-- No card yet --}}
<div class="panel" style="margin-bottom:24px;">
  <div class="panel-body" style="text-align:center;padding:60px 20px;">
    <i class="fas fa-id-card" style="font-size:48px;color:var(--gold);opacity:.4;margin-bottom:16px;display:block;"></i>
    <h2 style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--white);margin-bottom:10px;">No Active Membership Card</h2>
    <p style="color:var(--white-40);font-size:15px;margin-bottom:28px;line-height:1.7;">You haven't purchased a membership card yet. Browse our plans and chat with management to get yours!</p>
    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-id-card"></i> Browse Membership Plans</a>
  </div>
</div>

@if($transactions->where('status','pending')->isNotEmpty())
<div class="panel">
  <div class="panel-header"><div class="panel-title">Pending Applications</div></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Plan</th><th>Amount</th><th>Status</th><th>Submitted</th><th>Action</th></tr></thead>
      <tbody>
        @foreach($transactions->where('status','pending') as $t)
        <tr>
          <td><span class="badge badge-gold">{{ $t->plan->name }}</span></td>
          <td style="font-family:'Playfair Display',serif;font-size:18px;color:var(--gold);">${{ number_format($t->amount,2) }}</td>
          <td><span class="badge badge-warning"><span class="badge-dot"></span>Awaiting Approval</span></td>
          <td class="td-muted">{{ $t->created_at->diffForHumans() }}</td>
          <td>@if($t->chatConversation)<a href="{{ route('chat.show',$t->chatConversation) }}" class="btn btn-sm btn-primary"><i class="fas fa-comments"></i> Open Chat</a>@endif</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
@endif
@endsection
