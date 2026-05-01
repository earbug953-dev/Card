<?php

namespace App\Http\Controllers;

use App\Models\FanApplication;
use App\Models\FanMember;
use App\Models\MembershipCard;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FanController extends Controller
{
    // ─── Auth ─────────────────────────────────────────────────

    public function loginForm()
    {
        return view('fan.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $fan = FanMember::where('email', $data['email'])->first();

        if (!$fan || !Hash::check($data['password'], $fan->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        session([
            'fan_member_id' => $fan->id,
            'fan_name'      => $fan->first_name,
        ]);

        return redirect()->route('fan.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['fan_member_id', 'fan_name', 'fan_application_id']);
        return redirect()->route('home');
    }

    // ─── Dashboard ────────────────────────────────────────────

    public function dashboard()
    {
        $fanId = session('fan_member_id');
        $member = null;

        if ($fanId) {
            $member = FanMember::with('activeCard.plan')->find($fanId);
        }

        return view('fan.dashboard', compact('member'));
    }

    // ─── Chat ─────────────────────────────────────────────────

    public function chat(FanApplication $application)
    {
        $application->load(['plan', 'chatMessages']);
        return view('fan.chat', compact('application'));
    }

    public function chatIndex()
    {
        $fanId = session('fan_member_id');
        if (!$fanId) {
            return redirect()->route('fan.login');
        }

        $applications = FanApplication::where('fan_member_id', $fanId)
                                      ->with(['plan', 'chatMessages'])
                                      ->latest()
                                      ->get();

        if ($applications->count() === 1) {
            return redirect()->route('fan.chat', $applications->first());
        }

        return view('fan.chat-list', compact('applications'));
    }

    public function chatSend(Request $request, FanApplication $application)
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:2000']]);

        ChatMessage::create([
            'fan_application_id' => $application->id,
            'sender'             => 'fan',
            'message'            => $data['message'],
        ]);

        return redirect()->route('fan.chat', $application);
    }

    // ─── My Card ──────────────────────────────────────────────

    public function myCard()
    {
        $fanId = session('fan_member_id');
        $member = null;

        if ($fanId) {
            $member = FanMember::with('activeCard.plan')->find($fanId);
            if ($member && $member->activeCard) {
                return view('fan.my-card', compact('member'));
            }
        }

        return view('fan.my-card');
    }

    public function myCardLookup(Request $request)
    {
        $data = $request->validate([
            'card_code' => ['required', 'string'],
        ]);

        $card = MembershipCard::where('card_code', strtoupper(trim($data['card_code'])))
                              ->where('status', 'active')
                              ->first();

        if (!$card) {
            return back()
                ->withErrors(['card_code' => 'That Card ID was not found or has not been approved yet. Please check and try again.'])
                ->withInput();
        }

        $member = FanMember::with('activeCard.plan')->find($card->fan_member_id);

        if (!$member) {
            return back()->withErrors(['card_code' => 'No member found for this card.'])->withInput();
        }

        return view('fan.my-card', compact('member'));
    }
}
