<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\Channel;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(ChatConversation $conversation)
    {
        // Check if user is authorized
        if (Auth::id() !== $conversation->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        // If admin is opening this for the first time, assign them
        if (Auth::user()->is_admin && !$conversation->admin_id) {
            $conversation->update(['admin_id' => Auth::id()]);
        }

        $messages = $conversation->messages()->with('user')->orderBy('created_at')->get();
        $transaction = $conversation->purchaseTransaction;

        return view('chat.show', compact('conversation', 'messages', 'transaction'));
    }

    public function sendMessage(Request $request, ChatConversation $conversation)
    {
        // Check authorization
        if (Auth::id() !== $conversation->user_id && Auth::id() !== $conversation->admin_id && !Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'user' => $message->user,
        ]);
    }

    public function approvePayment(Request $request, ChatConversation $conversation)
    {
        // Only admin can approve
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $transaction = $conversation->purchaseTransaction;

        $notes = $request->input('notes', 'Payment approved by admin');
        $transaction->approve(Auth::id(), $notes);
        $membershipCard = $transaction->complete();

        // Notify in chat
        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'message' => "🎉 Payment approved! Your access code is: **{$transaction->access_code}**. Your membership card number is: **{$membershipCard->formatted_number}**.",
        ]);

        return response()->json([
            'success' => true,
            'access_code' => $transaction->access_code,
            'card_number' => $membershipCard->formatted_number,
        ]);
    }

    public function rejectPayment(Request $request, ChatConversation $conversation)
    {
        // Only admin can reject
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'reason' => 'required|string|min:5|max:500',
        ]);

        $transaction = $conversation->purchaseTransaction;
        $transaction->reject($validated['reason']);

        // Notify in chat
        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'message' => "❌ Payment request declined. Reason: {$validated['reason']}",
        ]);

        return response()->json(['success' => true]);
    }

    public function closeConversation(ChatConversation $conversation)
    {
        // Only admin can close
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $conversation->close();
        return response()->json(['success' => true]);
    }
}
