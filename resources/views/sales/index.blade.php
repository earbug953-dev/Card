@extends('layouts.app')
@section('title', 'Sales')
@section('breadcrumb-parent', 'Sales')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Sales</h1>
        <p>All membership card transactions and revenue</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Sale
        </a>
    </div>
</div>

<!-- Revenue Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Total Revenue</span>
            <div class="stat-icon gold"><i class="fas fa-dollar-sign"></i></div>
        </div>
        <div class="stat-value">${{ number_format($totalRevenue, 0) }}</div>
        <div class="stat-change up"><i class="fas fa-arrow-up"></i> All time</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">This Month</span>
            <div class="stat-icon success"><i class="fas fa-calendar"></i></div>
        </div>
        <div class="stat-value">${{ number_format($monthlyRevenue, 0) }}</div>
        <div class="stat-change up"><i class="fas fa-arrow-up"></i> {{ now()->format('F Y') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Total Sales</span>
            <div class="stat-icon info"><i class="fas fa-receipt"></i></div>
        </div>
        <div class="stat-value">{{ $totalSales }}</div>
        <div class="stat-change up"><i class="fas fa-arrow-up"></i> All transactions</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Pending</span>
            <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-value">{{ $pendingPayments }}</div>
        <div class="stat-change down"><i class="fas fa-exclamation-circle"></i> Awaiting payment</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">Transaction History</div>
            <div class="panel-subtitle">{{ $sales->total() }} total transactions</div>
        </div>
    </div>

    <div class="panel-body" style="padding-bottom:0;">
        <div class="filter-bar">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search member or card..." id="searchInput" onkeyup="filterTable()">
            </div>
            <select style="width:auto;">
                <option value="">All Payments</option>
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
            </select>
            <input type="date" style="width:auto;" placeholder="From date">
            <input type="date" style="width:auto;" placeholder="To date">
        </div>
    </div>

    <div class="table-container">
        <table id="salesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Card Number</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="td-muted">#{{ $sale->id }}</td>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">{{ strtoupper(substr($sale->member->name ?? 'M', 0, 1)) }}</div>
                            <div>
                                <div class="member-name">{{ $sale->member->name ?? 'Unknown' }}</div>
                                <div class="member-email">{{ $sale->member->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-gold">{{ $sale->plan->name ?? 'N/A' }}</span></td>
                    <td>
                        <span style="font-family:monospace; font-size:12px; letter-spacing:2px; color:var(--text-secondary);">
                            {{ $sale->membershipCard ? implode(' ', str_split($sale->membershipCard->card_number, 4)) : '—' }}
                        </span>
                    </td>
                    <td>
                        <span style="font-family:var(--font-display); font-size:18px; color:var(--gold); font-weight:600;">
                            ${{ number_format($sale->amount, 2) }}
                        </span>
                    </td>
                    <td class="td-muted">{{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}</td>
                    <td>
                        @if($sale->payment_status === 'paid')
                            <span class="badge badge-success"><span class="badge-dot"></span>Paid</span>
                        @else
                            <span class="badge badge-warning"><span class="badge-dot"></span>Pending</span>
                        @endif
                    </td>
                    <td class="td-muted">{{ $sale->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-secondary btn-icon" title="View Receipt">
                                <i class="fas fa-receipt"></i>
                            </a>
                            @if($sale->payment_status === 'pending')
                            <form method="POST" action="{{ route('sales.markPaid', $sale) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success btn-icon" title="Mark as Paid">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-chart-line"></i></div>
                            <div class="empty-title">No Sales Yet</div>
                            <p class="empty-desc">Start by selling your first membership card</p>
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Make First Sale
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sales->hasPages())
    <div class="panel-footer">
        <span style="font-size:12px; color:var(--text-muted)">Showing {{ $sales->firstItem() }}–{{ $sales->lastItem() }} of {{ $sales->total() }}</span>
        {{ $sales->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
function filterTable() {
    const v = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#salesTable tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(v) ? '' : 'none';
    });
}
</script>
@endpush
@endsection
