<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    public function index() {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request) {
        $user = auth()->user();

        $data = $request->validate([
            'name'                 => ['required','string','max:255'],
            'email'                => ['required','email',"unique:users,email,{$user->id}"],
            'phone'                => ['nullable','string','max:30'],
            'address'              => ['nullable','string','max:255'],
            'password'             => ['nullable','string','min:8','confirmed'],
            'user_photo'           => ['nullable','image','max:5120'],
        ]);

        if ($request->hasFile('user_photo')) {
            $data['user_photo'] = $request->file('user_photo')->store('user-photos','public');
        } else {
            unset($data['user_photo']);
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return back()->with('success', 'Profile updated successfully!');
    }
}
