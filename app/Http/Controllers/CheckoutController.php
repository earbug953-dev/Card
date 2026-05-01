<?php
namespace App\Http\Controllers;
use App\Models\Plan;
use App\Models\PurchaseTransaction;
use App\Models\ChatConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller {
    public function __construct(){$this->middleware('auth');}

    public function form(Plan $plan){
        return view('checkout.form', compact('plan'));
    }

    public function store(Request $request, Plan $plan){
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:30',
            'state'      => 'required|string|max:100',
            'address'    => 'required|string|max:255',
            'message'    => 'required|string|min:10|max:1000',
            'user_photo' => 'required|image|max:5120',
            'terms'      => 'required|accepted',
        ]);

        $photoPath = null;
        if($request->hasFile('user_photo')){
            $photoPath = $request->file('user_photo')->store('user-photos','public');
        }

        // Update user profile fields
        $user = Auth::user();
        $user->update([
            'phone'   => $validated['phone'],
            'address' => $validated['address'].', '.$validated['state'],
        ]);

        $fullName = $validated['first_name'].' '.$validated['last_name'];
        $fullAddress = $validated['state'].', '.$validated['address'];

        $transaction = PurchaseTransaction::create([
            'user_id'         => Auth::id(),
            'plan_id'         => $plan->id,
            'amount'          => $plan->price,
            'status'          => 'pending',
            'payment_notes'   => $validated['message'],
            'user_photo_path' => $photoPath,
            'user_address'    => $fullAddress,
            'user_phone'      => $validated['phone'],
        ]);

        $conversation = ChatConversation::create([
            'purchase_transaction_id' => $transaction->id,
            'user_id' => Auth::id(),
            'status'  => 'open',
        ]);

        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'message' => "Hi! My name is {$fullName}.\nAddress: {$fullAddress}\nPhone: {$validated['phone']}\n\n".$validated['message'],
        ]);

        return redirect()->route('chat.show', $conversation->id)
                         ->with('success', 'Application submitted! Our management team will connect with you shortly.');
    }
}
