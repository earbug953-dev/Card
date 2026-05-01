@extends('layouts.app')
@section('title','Admin Dashboard')
@section('breadcrumb-parent','Admin Dashboard')

@section('content')
<div class="page-header">
  <div>
    <div class="ph-title">Admin Dashboard 👑</div>
    <div class="ph-sub">Welcome back, {{ auth()->user()->name }}. Here's your overview.</div>
  </div>
  <div class="ph-actions">
    <a href="{{ route('admin.chats') }}" class="btn btn-primary"><i class="fas fa-comments"></i> View All Chats</a>
  </div>
</div>

{{-- Stats --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="sc-header"><span class="sc-label">Pending Payments</span><div class="sc-icon a"><i class="fas fa-clock"></i></div></div>
    <div class="sc-value">{{ $pendingTransactions }}</div>
    <div class="sc-change dn"><i class="fas fa-exclamation-circle"></i> <span>Awaiting approval</span></div>
  </div>
  <div class="stat-card">
    <div class="sc-header"><span class="sc-label">Cards Issued</span><div class="sc-icon gr"><i class="fas fa-id-card"></i></div></div>
    <div class="sc-value">{{ $completedTransactions }}</div>
    <div class="sc-change up"><i class="fas fa-arrow-up"></i> <span>All time</span></div>
  </div>
  <div class="stat-card">
    <div class="sc-header"><span class="sc-label">Open Chats</span><div class="sc-icon b"><i class="fas fa-comments"></i></div></div>
    <div class="sc-value">{{ $openChats }}</div>
    <div class="sc-change {{ $openChats>0?'dn':'up' }}"><i class="fas fa-circle"></i> <span>Active now</span></div>
  </div>
  <div class="stat-card">
    <div class="sc-header"><span class="sc-label">Total Revenue</span><div class="sc-icon g"><i class="fas fa-dollar-sign"></i></div></div>
    <div class="sc-value">${{ number_format($totalRevenue,0) }}</div>
    <div class="sc-change up"><i class="fas fa-arrow-up"></i> <span>All time</span></div>
  </div>
</div>

{{-- Open chats --}}
<div class="panel">
  <div class="panel-header">
    <div><div class="panel-title">Open Fan Chats</div><div class="panel-subtitle">Fans waiting for payment approval — click to open chat</div></div>
    <a href="{{ route('admin.chats') }}" class="btn btn-sm btn-secondary">View All</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Fan</th><th>Plan</th><th>Fee</th><th>Submitted</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($conversations as $conv)
        @php $t=$conv->purchaseTransaction; @endphp
        <tr>
          <td>
            <div class="member-row">
              <div class="avatar">{{ strtoupper(substr($conv->user->name,0,1)) }}</div>
              <div><span class="member-name">{{ $conv->user->name }}</span><span class="member-email">{{ $conv->user->email }}</span></div>
            </div>
          </td>
          <td><span class="badge badge-gold">{{ $t->plan->name ?? '—' }}</span></td>
          <td style="font-family:'Playfair Display',serif;font-size:18px;color:var(--gold);">${{ number_format($t->amount,2) }}</td>
          <td class="td-muted">{{ $conv->created_at->diffForHumans() }}</td>
          <td>
            @if($t->status==='pending')<span class="badge badge-warning"><span class="badge-dot"></span>Pending</span>
            @elseif($t->status==='completed')<span class="badge badge-success"><span class="badge-dot"></span>Approved</span>
            @else<span class="badge badge-muted">{{ ucfirst($t->status) }}</span>@endif
          </td>
          <td><a href="{{ route('chat.show',$conv) }}" class="btn btn-sm btn-primary"><i class="fas fa-comments"></i> Open Chat</a></td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="fas fa-comments"></i></div><div class="empty-title">No Open Chats</div><p class="empty-desc">All fan chats are resolved. Great work!</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
