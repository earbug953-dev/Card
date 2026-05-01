<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('activeCard.plan')
                         ->latest()
                         ->paginate(15);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:members'],
            'phone'         => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'address'       => ['nullable', 'string'],
            'notes'         => ['nullable', 'string'],
            'status'        => ['in:active,inactive,suspended'],
        ]);

        $member = Member::create($data);

        return redirect()->route('members.show', $member)
                         ->with('success', 'Member created successfully!');
    }

    public function show(Member $member)
    {
        $member->load(['activeCard.plan', 'sales.plan']);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.form', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', "unique:members,email,{$member->id}"],
            'phone'         => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'address'       => ['nullable', 'string'],
            'notes'         => ['nullable', 'string'],
            'status'        => ['in:active,inactive,suspended'],
        ]);

        $member->update($data);

        return redirect()->route('members.show', $member)
                         ->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')
                         ->with('success', 'Member deleted.');
    }

    public function export()
    {
        $members = Member::with('activeCard.plan')->get();
        $csv = "ID,Name,Email,Phone,Plan,Status,Joined\n";
        foreach ($members as $m) {
            $csv .= "{$m->id},{$m->name},{$m->email},{$m->phone},"
                  . ($m->activeCard?->plan?->name ?? 'None') . ","
                  . $m->status . ","
                  . $m->created_at->format('Y-m-d') . "\n";
        }
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="members.csv"',
        ]);
    }
}
