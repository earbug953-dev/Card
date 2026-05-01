<?php

namespace App\Http\Controllers;

use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;

class CardViewController extends Controller
{
    public function viewByCode($code)
    {
        $transaction = PurchaseTransaction::where('access_code', $code)
                                          ->whereIn('status', ['approved', 'completed'])
                                          ->with('user', 'plan', 'membershipCard', 'chatConversation')
                                          ->firstOrFail();

        if ($transaction->status === 'approved' && !$transaction->membershipCard) {
            $transaction->complete();
            $transaction->load('membershipCard');
        }

        $card = $transaction->membershipCard;
        return view('card.display', compact('transaction', 'card'));
    }

    public function printCard($code)
    {
        $transaction = PurchaseTransaction::where('access_code', $code)
                                          ->whereIn('status', ['approved', 'completed'])
                                          ->with('user', 'plan', 'membershipCard', 'chatConversation')
                                          ->firstOrFail();

        if ($transaction->status === 'approved' && !$transaction->membershipCard) {
            $transaction->complete();
            $transaction->load('membershipCard');
        }

        $card = $transaction->membershipCard;
        return view('card.print', compact('transaction', 'card'));
    }
}
