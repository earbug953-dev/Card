<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\FanApplication;
use App\Models\FanMember;
use App\Models\MembershipCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    // ─── Home ─────────────────────────────────────────────────

    public function home()
    {
        $plans = Plan::orderBy('price')->limit(4)->get();
        return view('public.home', compact('plans'));
    }

    // ─── Plans Page ───────────────────────────────────────────

    public function plans()
    {
        $plans = Plan::orderBy('price')->get();
        return view('public.plans', compact('plans'));
    }

    // ─── Checkout Form ────────────────────────────────────────

    public function checkout(Plan $plan)
    {
        return view('public.checkout', compact('plan'));
    }

    public function checkoutPost(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email'],
            'phone'         => ['required', 'string'],
            'address'       => ['required', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'photo'         => ['nullable', 'image', 'max:5120'],
            'terms'         => ['required', 'accepted'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('fan-photos', 'public');
        }

        // Create or update fan member account
        $fanMember = FanMember::firstOrCreate(
            ['email' => $data['email']],
            [
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'],
                'phone'         => $data['phone'],
                'address'       => $data['address'],
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'password'      => Hash::make($data['password']),
                'photo_path'    => $photoPath,
            ]
        );

        // Create fan application
        $application = FanApplication::create([
            'fan_member_id'    => $fanMember->id,
            'plan_id'          => $plan->id,
            'first_name'       => $data['first_name'],
            'last_name'        => $data['last_name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'address'          => $data['address'],
            'photo_path'       => $photoPath,
            'reference_number' => 'APP-' . strtoupper(Str::random(8)),
            'status'           => 'pending',
        ]);

        // Log the fan into session
        session([
            'fan_member_id'  => $fanMember->id,
            'fan_name'       => $fanMember->first_name,
            'fan_application_id' => $application->id,
        ]);

        return redirect()->route('fan.chat', $application)
                         ->with('success', 'Application submitted! Chat with our team to complete your payment.');
    }
}
