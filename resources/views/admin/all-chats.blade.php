@extends('layouts.app')
@section('title','All Fan Chats')
@section('breadcrumb-parent','Fan Chats')

@section('content')
<div class="page-header">
  <div><div class="ph-title">Fan Chats</div><div class="ph-sub">All conversations between fans and management</div></div>
  <div class="ph-actions">
    <a href="{{ route('admin.chats') }}?status=open" class="btn {{ $filter==='open'?'btn-primary':'btn-secondary' }}">Open</a>
    <a href="{{ route('admin.chats') }}?status=closed" class="btn {{ $filter==='closed'?'btn-primary':'btn-secondary' }}">Closed</a>
  </div>
</div>

<div class="panel">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Fan</th><th>Plan</th><th>Amount</th><th>Status</th><th>Admin</th><th>Started</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($conversations as $conv)
        @php $t=$conv->purchaseTransaction; @endphp
        <tr>
          <td>
            <div class="member-row">
              @if($t->user_photo_path)<img src="{{ asset('storage/'.$t->user_photo_path) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);flex-shrink:0;">
              @else<div class="avatar">{{ strtoupper(substr($conv->user->name,0,1)) }}</div>@endif
              <div><span class="member-name">{{ $conv->user->name }}</span><span class="member-email">{{ $conv->user->email }}</span></div>
            </div>
          </td>
          <td><span class="badge badge-gold">{{ $t->plan->name ?? '—' }}</span></td>
          <td style="font-family:'Playfair Display',serif;font-size:17px;color:var(--gold);">${{ number_format($t->amount,2) }}</td>
          <td>
            @if($t->status==='pending')<span class="badge badge-warning"><span class="badge-dot"></span>Pending</span>
            @elseif($t->status==='completed')<span class="badge badge-success"><span class="badge-dot"></span>Approved</span>
            @elseif($t->status==='rejected')<span class="badge badge-danger"><span class="badge-dot"></span>Rejected</span>
            @else<span class="badge badge-muted">{{ ucfirst($t->status) }}</span>@endif
          </td>
          <td class="td-muted">{{ $conv->admin->name ?? '—' }}</td>
          <td class="td-muted">{{ $conv->created_at->format('M d, Y g:i A') }}</td>
          <td>
            <div class="action-btns">
              <a href="{{ route('chat.show',$conv) }}" class="btn btn-sm btn-primary"><i class="fas fa-comments"></i> Chat</a>
              @if($t->access_code)<a href="{{ route('card.view',$t->access_code) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="fas fa-id-card"></i> Card</a>@endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="fas fa-comments"></i></div><div class="empty-title">No Chats Found</div><p class="empty-desc">No {{ $filter }} conversations yet.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($conversations->hasPages())
  <div class="panel-footer"><span class="td-muted">{{ $conversations->total() }} total</span>{{ $conversations->links() }}</div>
  @endif
</div>
@endsection
