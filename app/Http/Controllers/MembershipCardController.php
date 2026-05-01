<?php

namespace App\Http\Controllers;

use App\Models\MembershipCard;
use App\Models\Plan;
use Illuminate\Http\Request;

class MembershipCardController extends Controller
{
    public function index()
    {
        $cards          = MembershipCard::with(['member', 'plan'])->latest()->paginate(20);
        $plans          = Plan::all();
        $totalCards     = MembershipCard::count();
        $activeCards    = MembershipCard::where('status', 'active')->count();
        $expiredCards   = MembershipCard::where('status', 'expired')->count();
        $suspendedCards = MembershipCard::where('status', 'suspended')->count();

        return view('cards.index', compact(
            'cards', 'plans', 'totalCards', 'activeCards', 'expiredCards', 'suspendedCards'
        ));
    }

    public function show(MembershipCard $card)
    {
        $card->load(['member', 'plan']);
        return view('cards.show', compact('card'));
    }

    public function suspend(MembershipCard $card)
    {
        $card->update(['status' => 'suspended']);
        return back()->with('success', 'Card suspended successfully.');
    }

    public function destroy(MembershipCard $card)
    {
        $card->delete();
        return redirect()->route('cards.index')->with('success', 'Card deleted.');
    }
}
