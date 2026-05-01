@extends('layouts.app')
@section('title', 'Members')
@section('breadcrumb-parent', 'Members')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Members</h1>
        <p>Manage all registered members in the system</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add Member
        </a>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">All Members</div>
            <div class="panel-subtitle">{{ $members->total() }} members registered</div>
        </div>
    </div>

    <div class="panel-body" style="padding-bottom:0;">
        <div class="filter-bar">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search by name or email..." id="searchInput" onkeyup="filterTable()">
            </div>
            <select style="width:auto;" onchange="filterStatus(this.value)">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
            </select>
            <a href="{{ route('members.export') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </div>

    <div class="table-container">
        <table id="membersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Phone</th>
                    <th>Plan</th>
                    <th>Card Number</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td class="td-muted">{{ $member->id }}</td>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                            <div class="member-name-wrap">
                                <div class="member-name">{{ $member->name }}</div>
                                <div class="member-email">{{ $member->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="td-muted">{{ $member->phone ?? '—' }}</td>
                    <td>
                        @if($member->activeCard)
                            <span class="badge badge-gold">{{ $member->activeCard->plan->name ?? 'N/A' }}</span>
                        @else
                            <span class="badge badge-muted">No Plan</span>
                        @endif
                    </td>
                    <td class="td-muted" style="font-family: monospace; letter-spacing:2px; font-size:12px;">
                        {{ $member->activeCard->card_number ?? '—' }}
                    </td>
                    <td>
                        @if($member->status === 'active')
                            <span class="badge badge-success"><span class="badge-dot"></span>Active</span>
                        @elseif($member->status === 'suspended')
                            <span class="badge badge-warning"><span class="badge-dot"></span>Suspended</span>
                        @else
                            <span class="badge badge-muted"><span class="badge-dot"></span>Inactive</span>
                        @endif
                    </td>
                    <td class="td-muted">{{ $member->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-secondary btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-secondary btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Delete this member?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-users"></i></div>
                            <div class="empty-title">No Members Yet</div>
                            <p class="empty-desc">Start by adding your first member to the system</p>
                            <a href="{{ route('members.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Add First Member
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($members->hasPages())
    <div class="panel-footer">
        <span style="font-size:12px; color:var(--text-muted)">
            Showing {{ $members->firstItem() }}–{{ $members->lastItem() }} of {{ $members->total() }}
        </span>
        <div class="pagination">
            @if($members->onFirstPage())
                <span><i class="fas fa-chevron-left" style="font-size:11px;"></i></span>
            @else
                <a href="{{ $members->previousPageUrl() }}"><i class="fas fa-chevron-left" style="font-size:11px;"></i></a>
            @endif

            @foreach($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                @if($page == $members->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($members->hasMorePages())
                <a href="{{ $members->nextPageUrl() }}"><i class="fas fa-chevron-right" style="font-size:11px;"></i></a>
            @else
                <span><i class="fas fa-chevron-right" style="font-size:11px;"></i></span>
            @endif
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#membersTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
@endpush
@endsection
