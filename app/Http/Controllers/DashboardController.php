<?php
namespace App\Http\Controllers;
use App\Models\PurchaseTransaction;
use App\Models\ChatConversation;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();

        if ($user->is_admin) {
            // Admin dashboard
            $pendingTransactions  = PurchaseTransaction::where('status','pending')->count();
            $approvedTransactions = PurchaseTransaction::where('status','approved')->count();
            $completedTransactions= PurchaseTransaction::where('status','completed')->count();
            $totalRevenue         = PurchaseTransaction::where('status','completed')->sum('amount');
            $openChats            = ChatConversation::where('status','open')->count();

            $conversations = ChatConversation::where('status','open')
                ->with(['purchaseTransaction.plan','user'])
                ->orderByDesc('updated_at')
                ->paginate(10);

            return view('admin.dashboard', compact(
                'pendingTransactions','approvedTransactions',
                'completedTransactions','totalRevenue',
                'openChats','conversations'
            ));
        }

        // Fan dashboard
        $user->load(['purchaseTransactions.plan','purchaseTransactions.chatConversation',
                     'purchaseTransactions.membershipCard']);

        return view('dashboard.user', compact('user'));
    }
}
