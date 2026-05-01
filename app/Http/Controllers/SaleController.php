<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Member;
use App\Models\Plan;
use App\Models\MembershipCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function index()
    {
        $sales          = Sale::with(['member', 'plan', 'membershipCard'])->latest()->paginate(20);
        $totalRevenue   = Sale::where('payment_status', 'paid')->sum('amount');
        $monthlyRevenue = Sale::whereMonth('created_at', now()->month)->where('payment_status', 'paid')->sum('amount');
        $totalSales     = Sale::count();
        $pendingPayments = Sale::where('payment_status', 'pending')->count();

        return view('sales.index', compact(
            'sales', 'totalRevenue', 'monthlyRevenue', 'totalSales', 'pendingPayments'
        ));
    }

    public function create()
    {
        $members = Member::where('status', 'active')->orderBy('name')->get();
        $plans   = Plan::orderBy('price')->get();
        return view('sales.create', compact('members', 'plans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id'      => ['required', 'exists:members,id'],
            'plan_id'        => ['required', 'exists:plans,id'],
            'issue_date'     => ['required', 'date'],
            'expiry_date'    => ['required', 'date', 'after:issue_date'],
            'amount'         => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,credit_card,debit_card,bank_transfer,mobile_money'],
            'payment_status' => ['in:paid,pending'],
            'reference'      => ['nullable', 'string'],
            'notes'          => ['nullable', 'string'],
        ]);

        // Generate unique card number
        $cardNumber = $this->generateCardNumber();

        // Create membership card
        $card = MembershipCard::create([
            'member_id'   => $data['member_id'],
            'plan_id'     => $data['plan_id'],
            'card_number' => $cardNumber,
            'issue_date'  => $data['issue_date'],
            'expiry_date' => $data['expiry_date'],
            'status'      => 'active',
        ]);

        // Create sale record
        Sale::create([
            'member_id'          => $data['member_id'],
            'plan_id'            => $data['plan_id'],
            'membership_card_id' => $card->id,
            'amount'             => $data['amount'],
            'payment_method'     => $data['payment_method'],
            'payment_status'     => $data['payment_status'] ?? 'paid',
            'reference'          => $data['reference'],
            'notes'              => $data['notes'],
        ]);

        return redirect()->route('sales.index')
                         ->with('success', "Membership card #{$cardNumber} issued successfully!");
    }

    public function show(Sale $sale)
    {
        $sale->load(['member', 'plan', 'membershipCard']);
        return view('sales.show', compact('sale'));
    }

    public function markPaid(Sale $sale)
    {
        $sale->update(['payment_status' => 'paid']);
        return back()->with('success', 'Sale marked as paid.');
    }

    private function generateCardNumber(): string
    {
        do {
            $number = str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
        } while (MembershipCard::where('card_number', $number)->exists());

        return $number;
    }
}
