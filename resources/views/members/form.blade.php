@extends('layouts.app')
@section('title', isset($member) ? 'Edit Member' : 'Add Member')
@section('breadcrumb-parent', 'Members')
@section('breadcrumb-current', isset($member) ? 'Edit Member' : 'New Member')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>{{ isset($member) ? 'Edit Member' : 'Add New Member' }}</h1>
        <p>{{ isset($member) ? 'Update member information' : 'Register a new member in the system' }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('members.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Members
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; align-items:start;">

    <form method="POST" action="{{ isset($member) ? route('members.update', $member) : route('members.store') }}">
        @csrf
        @if(isset($member)) @method('PUT') @endif

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Personal Information</div>
            </div>
            <div class="panel-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}" placeholder="John Doe" required>
                        @error('name')<div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}" placeholder="john@example.com" required>
                        @error('email')<div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone', $member->phone ?? '') }}" placeholder="+1 (555) 000-0000">
                    </div>

                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($member) ? $member->date_of_birth?->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender', $member->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $member->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $member->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" {{ old('status', $member->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $member->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $member->status ?? '') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ old('address', $member->address ?? '') }}" placeholder="123 Main Street, City, Country">
                    </div>

                    <div class="form-group full">
                        <label>Notes</label>
                        <textarea name="notes" placeholder="Any additional notes about this member...">{{ old('notes', $member->notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span style="font-size:12px; color:var(--text-muted)">* Required fields</span>
                <div style="display:flex; gap:10px;">
                    <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ isset($member) ? 'Update Member' : 'Create Member' }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Sidebar info -->
    <div style="display:flex; flex-direction:column; gap:16px;">
        @if(isset($member) && $member->activeCard)
        <!-- Current Card -->
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Active Card</div></div>
            <div class="panel-body">
                <div class="membership-card-visual" style="width:100%; max-width:100%;">
                    <div class="card-chip"></div>
                    <div class="card-number">{{ chunk_split($member->activeCard->card_number ?? '0000000000000000', 4, ' ') }}</div>
                    <div class="card-bottom">
                        <div>
                            <div class="card-holder-label">Card Holder</div>
                            <div class="card-holder-name">{{ strtoupper($member->name) }}</div>
                        </div>
                        <div>
                            <div class="card-plan">{{ $member->activeCard->plan->name ?? 'Plan' }}</div>
                            <div class="card-expiry-label">Expires</div>
                            <div class="card-expiry-val">{{ $member->activeCard->expiry_date?->format('m/Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:16px; display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-muted)">Plan</span>
                        <span class="badge badge-gold">{{ $member->activeCard->plan->name ?? 'N/A' }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-muted)">Status</span>
                        <span class="badge badge-success"><span class="badge-dot"></span>{{ ucfirst($member->activeCard->status) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-muted)">Expires</span>
                        <span style="color:var(--text-primary);">{{ $member->activeCard->expiry_date?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Help Box -->
        <div class="panel" style="background:var(--gold-muted); border-color:rgba(201,168,76,0.2);">
            <div class="panel-body">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                    <div style="color:var(--gold); font-size:18px;"><i class="fas fa-info-circle"></i></div>
                    <strong style="font-size:14px;">Member Tip</strong>
                </div>
                <p style="font-size:12.5px; color:var(--text-muted); line-height:1.7;">
                    After creating a member, you can sell them a membership card from the <strong style="color:var(--gold)">Sales</strong> section to issue an active card with a selected plan.
                </p>
                <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm" style="margin-top:14px;">
                    <i class="fas fa-credit-card"></i> Sell a Card
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
