@extends('layouts.app')
@section('title','Stats & Revenue')
@section('breadcrumb-parent','Stats & Revenue')

@section('content')
<div class="page-header">
  <div><div class="ph-title">Stats & Revenue</div><div class="ph-sub">Business overview and analytics</div></div>
</div>
<div class="stats-grid">
  <div class="stat-card"><div class="sc-header"><span class="sc-label">Total Revenue</span><div class="sc-icon g"><i class="fas fa-dollar-sign"></i></div></div><div class="sc-value">${{ number_format($totalRevenue,0) }}</div></div>
  <div class="stat-card"><div class="sc-header"><span class="sc-label">Total Transactions</span><div class="sc-icon b"><i class="fas fa-receipt"></i></div></div><div class="sc-value">{{ $totalTransactions }}</div></div>
  <div class="stat-card"><div class="sc-header"><span class="sc-label">Cards Issued</span><div class="sc-icon gr"><i class="fas fa-id-card"></i></div></div><div class="sc-value">{{ $completedCards }}</div></div>
  <div class="stat-card"><div class="sc-header"><span class="sc-label">Total Fans</span><div class="sc-icon a"><i class="fas fa-users"></i></div></div><div class="sc-value">{{ $totalCustomers }}</div></div>
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
  <div class="panel">
    <div class="panel-header"><div class="panel-title">Transaction Breakdown</div></div>
    <div class="panel-body">
      @foreach($transactionsByStatus as $ts)
      <div style="margin-bottom:16px;">
        <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:13px;"><span style="color:var(--white-40);text-transform:capitalize;">{{ $ts->status }}</span><span style="color:var(--white);font-weight:600;">{{ $ts->count }}</span></div>
        <div style="background:var(--ink-4);border-radius:99px;height:6px;"><div style="height:100%;border-radius:99px;background:linear-gradient(90deg,var(--gold-dk),var(--gold));width:{{ $totalTransactions>0?round($ts->count/$totalTransactions*100):0 }}%;"></div></div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="panel">
    <div class="panel-header"><div class="panel-title">Top Plans by Sales</div></div>
    <div class="panel-body">
      @foreach($topPlans as $tp)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--white-06);">
        <div><div style="font-size:14px;font-weight:600;color:var(--white);">{{ $tp->plan->name ?? 'Unknown' }}</div><div class="td-muted">{{ $tp->total }} sales</div></div>
        <div style="font-family:'Playfair Display',serif;font-size:20px;color:var(--gold);">${{ number_format($tp->revenue,0) }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
