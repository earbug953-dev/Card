@extends('layouts.app')
@section('title', 'Membership Cards')
@section('breadcrumb-parent', 'Membership Cards')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Membership Cards</h1>
        <p>All issued membership cards and their current status</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Issue New Card
        </a>
    </div>
</div>

<!-- Stats Row -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Total Cards</span>
            <div class="stat-icon gold"><i class="fas fa-id-card"></i></div>
        </div>
        <div class="stat-value">{{ $totalCards }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Active</span>
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-value">{{ $activeCards }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Expired</span>
            <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-value">{{ $expiredCards }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Suspended</span>
            <div class="stat-icon" style="background:var(--danger-bg);color:var(--danger);"><i class="fas fa-ban"></i></div>
        </div>
        <div class="stat-value">{{ $suspendedCards }}</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">All Cards</div>
            <div class="panel-subtitle">{{ $cards->total() }} cards issued</div>
        </div>
    </div>

    <div class="panel-body" style="padding-bottom:0">
        <div class="filter-bar">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search by card number or member..." id="searchInput" onkeyup="filterTable()">
            </div>
            <select style="width:auto;">
                <option value="">All Plans</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                @endforeach
            </select>
            <select style="width:auto;">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="expired">Expired</option>
                <option value="suspended">Suspended</option>
            </select>
        </div>
    </div>

    <div class="table-container">
        <table id="cardsTable">
            <thead>
                <tr>
                    <th>Card Number</th>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Issue Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cards as $card)
                <tr>
                    <td>
                        <span style="font-family:monospace; font-size:13px; letter-spacing:2px; color:var(--gold);">
                            {{ implode(' ', str_split($card->card_number, 4)) }}
                        </span>
                    </td>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">{{ strtoupper(substr($card->member->name ?? 'M', 0, 1)) }}</div>
                            <div>
                                <div class="member-name">{{ $card->member->name ?? 'Unknown' }}</div>
                                <div class="member-email">{{ $card->member->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-gold">{{ $card->plan->name ?? 'N/A' }}</span></td>
                    <td class="td-muted">{{ $card->issue_date?->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        @if($card->expiry_date?->isPast())
                            <span style="color:var(--danger);">{{ $card->expiry_date->format('M d, Y') }}</span>
                        @elseif($card->expiry_date?->diffInDays(now()) < 30)
                            <span style="color:var(--warning);">{{ $card->expiry_date->format('M d, Y') }}</span>
                        @else
                            <span class="td-muted">{{ $card->expiry_date?->format('M d, Y') ?? 'N/A' }}</span>
                        @endif
                    </td>
                    <td>
                        @if($card->status === 'active')
                            <span class="badge badge-success"><span class="badge-dot"></span>Active</span>
                        @elseif($card->status === 'expired')
                            <span class="badge badge-warning"><span class="badge-dot"></span>Expired</span>
                        @elseif($card->status === 'suspended')
                            <span class="badge badge-danger"><span class="badge-dot"></span>Suspended</span>
                        @else
                            <span class="badge badge-muted"><span class="badge-dot"></span>{{ ucfirst($card->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('cards.show', $card) }}" class="btn btn-sm btn-secondary btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($card->status === 'active')
                            <form method="POST" action="{{ route('cards.suspend', $card) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-warning btn-icon" title="Suspend" style="background:var(--warning-bg);color:var(--warning);border:1px solid rgba(240,168,64,0.2);">
                                    <i class="fas fa-pause"></i>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('Delete this card?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-icon" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-id-card"></i></div>
                            <div class="empty-title">No Cards Issued</div>
                            <p class="empty-desc">Sell a membership card to get started</p>
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Issue First Card
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($cards->hasPages())
    <div class="panel-footer">
        <span style="font-size:12px; color:var(--text-muted)">Showing {{ $cards->firstItem() }}–{{ $cards->lastItem() }} of {{ $cards->total() }}</span>
        {{ $cards->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
function filterTable() {
    const v = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#cardsTable tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(v) ? '' : 'none';
    });
}
</script>
@endpush
@endsection
