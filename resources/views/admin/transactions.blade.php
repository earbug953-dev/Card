@extends('layouts.app')
@section('title','Transactions')
@section('breadcrumb-parent','Transactions')

@section('content')
<div class="page-header">
  <div><div class="ph-title">All Transactions</div><div class="ph-sub">Every purchase transaction and card issuance</div></div>
</div>
<div class="panel">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Fan</th><th>Plan</th><th>Amount</th><th>Status</th><th>Access Code</th><th>Date</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($transactions as $t)
        <tr>
          <td>
            <div class="member-row">
              @if($t->user_photo_path)<img src="{{ asset('storage/'.$t->user_photo_path) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);flex-shrink:0;">
              @else<div class="avatar">{{ strtoupper(substr($t->user->name,0,1)) }}</div>@endif
              <div><span class="member-name">{{ $t->user->name }}</span><span class="member-email">{{ $t->user->email }}</span></div>
            </div>
          </td>
          <td><span class="badge badge-gold">{{ $t->plan->name }}</span></td>
          <td style="font-family:'Playfair Display',serif;font-size:17px;color:var(--gold);">${{ number_format($t->amount,2) }}</td>
          <td>
            @if($t->status==='pending')<span class="badge badge-warning"><span class="badge-dot"></span>Pending</span>
            @elseif($t->status==='completed')<span class="badge badge-success"><span class="badge-dot"></span>Completed</span>
            @elseif($t->status==='rejected')<span class="badge badge-danger"><span class="badge-dot"></span>Rejected</span>
            @else<span class="badge badge-muted">{{ ucfirst($t->status) }}</span>@endif
          </td>
          <td><span style="font-family:monospace;font-size:12px;color:var(--gold);letter-spacing:1.5px;">{{ $t->access_code ?? '—' }}</span></td>
          <td class="td-muted">{{ $t->created_at->format('M d, Y') }}</td>
          <td>
            <div class="action-btns">
              @if($t->chatConversation)<a href="{{ route('chat.show',$t->chatConversation) }}" class="btn btn-sm btn-primary"><i class="fas fa-comments"></i></a>@endif
              @if($t->access_code)<a href="{{ route('card.view',$t->access_code) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="fas fa-id-card"></i></a>@endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="fas fa-receipt"></i></div><div class="empty-title">No Transactions</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($transactions->hasPages())
  <div class="panel-footer"><span class="td-muted">{{ $transactions->total() }} transactions</span>{{ $transactions->links() }}</div>
  @endif
</div>
@endsection
