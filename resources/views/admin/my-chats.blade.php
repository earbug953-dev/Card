@extends('layouts.app')

@section('title', 'My Chats')
@section('breadcrumb-parent', 'Admin')
@section('breadcrumb-current', 'My Chats')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-slate-900">My Active Chats</h1>
        <p class="text-slate-600 mt-2">Conversations you're handling</p>
    </div>

    @if($conversations->isEmpty())
        <div class="rounded-[32px] border border-slate-200 bg-white p-12 text-center shadow-sm">
            <div class="text-6xl mb-4">💬</div>
            <p class="text-2xl font-semibold text-slate-900 mb-2">No active chats</p>
            <p class="text-slate-600">You haven't been assigned any chat conversations yet.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($conversations as $conversation)
                <div class="rounded-[24px] border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-lg font-bold text-amber-900">
                                    {{ strtoupper(substr($conversation->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $conversation->user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $conversation->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center rounded-full {{ $conversation->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} px-3 py-1 text-sm font-semibold">
                                {{ ucfirst($conversation->status) }}
                            </span>
                            @if($conversation->purchaseTransaction)
                                <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-sm font-semibold">
                                    ${{ number_format($conversation->purchaseTransaction->amount, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-4 mb-4 text-sm text-slate-700">
                        @if($conversation->purchaseTransaction)
                            <p><strong>Plan:</strong> {{ $conversation->purchaseTransaction->plan->name }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($conversation->purchaseTransaction->status) }}</p>
                        @else
                            <p class="text-slate-500">No transaction details available</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-xs text-slate-500">Last updated {{ $conversation->updated_at->diffForHumans() }}</p>
                        <a href="{{ route('chat.show', $conversation) }}" class="inline-flex items-center rounded-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm font-semibold transition">
                            Open Chat →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $conversations->links() }}
        </div>
    @endif
</div>
@endsection
