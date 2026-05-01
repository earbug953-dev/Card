<?php
namespace App\Http\Controllers;
use App\Models\Plan;

class ShopController extends Controller {
    public function index() {
        $plans = Plan::orderBy('price')->get();
        return view('shop.index', compact('plans'));
    }
    public function show(Plan $plan) {
        return view('shop.show', compact('plan'));
    }
}
