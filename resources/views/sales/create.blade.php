@extends('layouts.app')
@section('title', 'Sell Membership Card')
@section('breadcrumb-parent', 'Sales')
@section('breadcrumb-current', 'Sell Card')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Sell Membership Card</h1>
        <p>Issue a new membership card to a member</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Sales
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1.5fr 1fr; gap:20px; align-items:start;">

    <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
        @csrf
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Sale Details</div>
            </div>
            <div class="panel-body">
                <div class="form-grid">
                    <!-- Member -->
                    <div class="form-group full">
                        <label>Select Member *</label>
                        <select name="member_id" id="memberSelect" required onchange="updateCard()">
                            <option value="">— Choose a member —</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" data-name="{{ $member->name }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')<div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                        <div class="form-hint">
                            Member not found? <a href="{{ route('members.create') }}" style="color:var(--gold)">Register them first</a>
                        </div>
                    </div>

                    <!-- Plan -->
                    <div class="form-group full">
                        <label>Membership Plan *</label>
                        <select name="plan_id" id="planSelect" required onchange="updatePlanInfo()">
                            <option value="">— Select a plan —</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    data-price="{{ $plan->price }}"
                                    data-duration="{{ $plan->duration_months }}"
                                    data-name="{{ $plan->name }}"
                                    {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} — ${{ number_format($plan->price, 2) }}/{{ $plan->duration_months }}mo
                                </option>
                            @endforeach
                        </select>
                        @error('plan_id')<div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>

                    <!-- Dates -->
                    <div class="form-group">
                        <label>Issue Date *</label>
                        <input type="date" name="issue_date" id="issueDate" value="{{ old('issue_date', now()->format('Y-m-d')) }}" required onchange="updateExpiry()">
                    </div>

                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiryDate" value="{{ old('expiry_date') }}" readonly style="opacity:0.6;">
                        <div class="form-hint">Auto-calculated based on plan duration</div>
                    </div>

                    <!-- Payment -->
                    <div class="form-group">
                        <label>Amount ($) *</label>
                        <input type="number" name="amount" id="amountField" value="{{ old('amount') }}" step="0.01" min="0" required placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label>Payment Method *</label>
                        <select name="payment_method" required>
                            <option value="">— Choose method —</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status">
                            <option value="paid" {{ old('payment_status', 'paid') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reference / Receipt No.</label>
                        <input type="text" name="reference" value="{{ old('reference') }}" placeholder="Optional reference number">
                    </div>

                    <div class="form-group full">
                        <label>Notes</label>
                        <textarea name="notes" placeholder="Any notes about this sale...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <span style="font-size:12px; color:var(--text-muted)">A unique card number will be auto-generated</span>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-credit-card"></i> Issue Card & Complete Sale
                </button>
            </div>
        </div>
    </form>

    <!-- Card Preview -->
    <div style="display:flex; flex-direction:column; gap:16px; position:sticky; top:90px;">
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Card Preview</div></div>
            <div class="panel-body" style="display:flex; justify-content:center; flex-direction:column; align-items:center; gap:20px;">
                <div class="membership-card-visual" style="width:100%; max-width:340px;">
                    <div class="card-chip"></div>
                    <div class="card-number" id="previewCardNumber">•••• •••• •••• ••••</div>
                    <div class="card-bottom">
                        <div>
                            <div class="card-holder-label">Card Holder</div>
                            <div class="card-holder-name" id="previewName">SELECT MEMBER</div>
                        </div>
                        <div>
                            <div class="card-plan" id="previewPlan">PLAN</div>
                            <div class="card-expiry-label">Expires</div>
                            <div class="card-expiry-val" id="previewExpiry">MM/YYYY</div>
                        </div>
                    </div>
                </div>
                <div style="width:100%; font-size:12px; color:var(--text-muted); line-height:1.8;">
                    <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid var(--border-subtle);">
                        <span>Plan</span><span id="summaryPlan" style="color:var(--text-primary)">—</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid var(--border-subtle);">
                        <span>Duration</span><span id="summaryDuration" style="color:var(--text-primary)">—</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid var(--border-subtle);">
                        <span>Price</span><span id="summaryPrice" style="color:var(--gold); font-weight:600;">—</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:6px 0;">
                        <span>Expiry</span><span id="summaryExpiry" style="color:var(--text-primary)">—</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plans Quick Reference -->
        <div class="panel">
            <div class="panel-header"><div class="panel-title">Available Plans</div></div>
            <div class="panel-body" style="padding:12px 20px; display:flex; flex-direction:column; gap:10px;">
                @foreach($plans as $plan)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 12px; background:var(--bg-elevated); border-radius:10px; border:1px solid var(--border-subtle);">
                    <div>
                        <span style="font-weight:500; font-size:13.5px; color:var(--text-primary);">{{ $plan->name }}</span>
                        <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">{{ $plan->duration_months }} month(s)</div>
                    </div>
                    <span style="font-family:var(--font-display); font-size:18px; color:var(--gold); font-weight:600;">${{ number_format($plan->price, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
const plans = @json($plans->keyBy('id'));

function updateCard() {
    const select = document.getElementById('memberSelect');
    const opt = select.options[select.selectedIndex];
    document.getElementById('previewName').textContent = opt.value ? opt.getAttribute('data-name').toUpperCase() : 'SELECT MEMBER';
}

function updatePlanInfo() {
    const select = document.getElementById('planSelect');
    const opt = select.options[select.selectedIndex];
    if (!opt.value) {
        document.getElementById('previewPlan').textContent = 'PLAN';
        document.getElementById('summaryPlan').textContent = '—';
        document.getElementById('summaryDuration').textContent = '—';
        document.getElementById('summaryPrice').textContent = '—';
        return;
    }

    const price = opt.getAttribute('data-price');
    const duration = opt.getAttribute('data-duration');
    const name = opt.getAttribute('data-name');

    document.getElementById('previewPlan').textContent = name.toUpperCase();
    document.getElementById('summaryPlan').textContent = name;
    document.getElementById('summaryDuration').textContent = duration + ' month(s)';
    document.getElementById('summaryPrice').textContent = '$' + parseFloat(price).toFixed(2);
    document.getElementById('amountField').value = parseFloat(price).toFixed(2);
    updateExpiry();
}

function updateExpiry() {
    const issueDate = document.getElementById('issueDate').value;
    const planSelect = document.getElementById('planSelect');
    const opt = planSelect.options[planSelect.selectedIndex];
    const duration = opt.value ? parseInt(opt.getAttribute('data-duration')) : 0;

    if (issueDate && duration) {
        const d = new Date(issueDate);
        d.setMonth(d.getMonth() + duration);
        const expiryStr = d.toISOString().split('T')[0];
        document.getElementById('expiryDate').value = expiryStr;
        document.getElementById('previewExpiry').textContent = d.toLocaleDateString('en-US', { month: '2-digit', year: 'numeric' });
        document.getElementById('summaryExpiry').textContent = d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    }
}

// Animate card number
function randomizePreviewCard() {
    const chars = '0123456789';
    let num = '';
    for (let i = 0; i < 16; i++) {
        num += chars[Math.floor(Math.random() * chars.length)];
        if ((i + 1) % 4 === 0 && i < 15) num += ' ';
    }
    document.getElementById('previewCardNumber').textContent = num;
}
randomizePreviewCard();
</script>
@endpush
@endsection
