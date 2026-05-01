<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\PurchaseTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                abort(403, 'Unauthorized - Admin only');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $pendingTransactions = PurchaseTransaction::where('status', 'pending')->count();
        $approvedTransactions = PurchaseTransaction::where('status', 'approved')->count();
        $completedTransactions = PurchaseTransaction::where('status', 'completed')->count();
        $totalRevenue = PurchaseTransaction::where('status', 'completed')->sum('amount');

        $openChats = ChatConversation::where('status', 'open')->count();
        $conversations = ChatConversation::where('status', 'open')
                                        ->with('purchaseTransaction', 'user')
                                        ->orderByDesc('updated_at')
                                        ->paginate(10);

        return view('admin.dashboard', compact(
            'pendingTransactions',
            'approvedTransactions',
            'completedTransactions',
            'totalRevenue',
            'openChats',
            'conversations'
        ));
    }

    public function transactions()
    {
        $transactions = PurchaseTransaction::with('user', 'plan', 'approvedBy')
                                          ->orderByDesc('created_at')
                                          ->paginate(20);

        return view('admin.transactions', compact('transactions'));
    }

    public function transactionDetail(PurchaseTransaction $transaction)
    {
        $transaction->load('user', 'plan', 'approvedBy', 'chatConversation');
        return view('admin.transaction-detail', compact('transaction'));
    }

    public function myChats()
    {
        $conversations = ChatConversation::where('admin_id', Auth::id())
                                        ->with('purchaseTransaction', 'user')
                                        ->orderByDesc('updated_at')
                                        ->paginate(10);

        return view('admin.my-chats', compact('conversations'));
    }

    public function allChats()
    {
        $filter = request('status', 'open');
        $conversations = ChatConversation::with('purchaseTransaction', 'user', 'admin')
                                        ->where('status', $filter)
                                        ->orderByDesc('updated_at')
                                        ->paginate(20);

        return view('admin.all-chats', compact('conversations', 'filter'));
    }

    public function stats()
    {
        $totalRevenue = PurchaseTransaction::where('status', 'completed')->sum('amount');
        $totalTransactions = PurchaseTransaction::count();
        $completedCards = PurchaseTransaction::where('status', 'completed')->count();
        $totalCustomers = User::where('is_admin', false)->count();

        $transactionsByStatus = PurchaseTransaction::selectRaw('status, COUNT(*) as count')
                                                    ->groupBy('status')
                                                    ->get();

        $topPlans = PurchaseTransaction::with('plan')
                                       ->selectRaw('plan_id, COUNT(*) as total, SUM(amount) as revenue')
                                       ->groupBy('plan_id')
                                       ->orderByDesc('total')
                                       ->limit(5)
                                       ->get();

        return view('admin.stats', compact(
            'totalRevenue',
            'totalTransactions',
            'completedCards',
            'totalCustomers',
            'transactionsByStatus',
            'topPlans'
        ));
    }
}
