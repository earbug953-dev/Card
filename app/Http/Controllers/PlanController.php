<?php
namespace App\Http\Controllers;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller {
    public function index(){
        $plans = Plan::withCount('memberships')->orderBy('price')->get();
        return view('plans.index', compact('plans'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name'=>['required','string','max:100'],
            'price'=>['required','numeric','min:0'],
            'duration_months'=>['required','integer','min:1'],
            'description'=>['nullable','string'],
            'color'=>['nullable','string'],
            'features'=>['nullable','string'],
            'celebrity_name'=>['nullable','string','max:200'],
            'celebrity_image'=>['nullable','image','max:5120'],
        ]);
        if($request->hasFile('celebrity_image')){
            $data['celebrity_image'] = $request->file('celebrity_image')->store('celebrities','public');
        }
        Plan::create($data);
        return back()->with('success', "Plan \"{$data['name']}\" created!");
    }

    public function update(Request $request, Plan $plan){
        $data = $request->validate([
            'name'=>['required','string','max:100'],
            'price'=>['required','numeric','min:0'],
            'duration_months'=>['required','integer','min:1'],
            'description'=>['nullable','string'],
            'features'=>['nullable','string'],
            'celebrity_name'=>['nullable','string','max:200'],
            'celebrity_image'=>['nullable','image','max:5120'],
        ]);
        if($request->hasFile('celebrity_image')){
            $data['celebrity_image'] = $request->file('celebrity_image')->store('celebrities','public');
        }
        $plan->update($data);
        return back()->with('success', "Plan \"{$plan->name}\" updated!");
    }

    public function updateCelebrity(Request $request, Plan $plan){
        $data = $request->validate([
            'celebrity_name'=>['nullable','string','max:200'],
            'celebrity_image'=>['nullable','image','max:5120'],
        ]);
        if($request->hasFile('celebrity_image')){
            $data['celebrity_image'] = $request->file('celebrity_image')->store('celebrities','public');
        }
        $plan->update($data);
        return back()->with('success', "Celebrity updated for {$plan->name} plan!");
    }

    public function destroy(Plan $plan){
        $plan->delete();
        return back()->with('success', "Plan deleted.");
    }
}
