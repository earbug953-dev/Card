<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CardViewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Public card view (no auth needed)
Route::get('/card/{code}', [CardViewController::class, 'viewByCode'])->name('card.view');
Route::get('/card/{code}/print', [CardViewController::class, 'printCard'])->name('card.print');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (admin gets admin view, fan gets fan view)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Shop (public-facing for logged in users)
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{plan}', [ShopController::class, 'show'])->name('shop.show');

    // Checkout
    Route::get('/checkout/{plan}', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout/{plan}', [CheckoutController::class, 'store'])->name('checkout.store');

    // Live chat
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
        Route::post('/{conversation}/message', [ChatController::class, 'sendMessage'])->name('message.send');
        Route::post('/{conversation}/approve', [ChatController::class, 'approvePayment'])->name('approve');
        Route::post('/{conversation}/reject', [ChatController::class, 'rejectPayment'])->name('reject');
        Route::post('/{conversation}/close', [ChatController::class, 'closeConversation'])->name('close');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Plans (admin manages these)
    Route::resource('plans', PlanController::class)->only(['index','store','update','destroy']);
    Route::post('/plans/{plan}/celebrity', [PlanController::class, 'updateCelebrity'])->name('plans.celebrity');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
        Route::get('/transactions/{transaction}', [AdminController::class, 'transactionDetail'])->name('transaction.detail');
        Route::get('/chats', [AdminController::class, 'allChats'])->name('chats');
        Route::get('/my-chats', [AdminController::class, 'myChats'])->name('my-chats');
        Route::get('/stats', [AdminController::class, 'stats'])->name('stats');
    });
});
