<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plan = Plan::where('parent_id',Auth::user()->id)->orderBy('id','desc')->get();
      
        return view('reseller.plan.index', compact('plan'));
    }

    public function create()
    {
        return view('reseller.plan.create');
    }

    public function store(Request $request)
    {
       
        $this->validate($request, [
        
        ]);
        $plan                   =   new Plan;
        $plan->parent_id        =   Auth::user()->id;
        $plan->title            =   $request->title;
        $plan->amount           =   $request->amount;
        $plan->plan_type        =   $request->plan_type;
        $plan->daily_msg        =   $request->daily_msg;
        $plan->obd              =   $request->obd;
        $plan->dtmf             =   $request->dtmf;
        $plan->call_patching    =   $request->call_patching;
        $plan->ibd              =   $request->ibd;
        $plan->status           =   1;
        $plan->save();

        session()->flash('success_msg', 'Plane update successfully');
        return redirect()->route('resellerplan.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $row                =   Plan::find($id);
        return view('reseller.plan.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

        ]);

        $plan                   =   Plan::where('id', $id)->first();
        $plan->title            =   $request->title;
        $plan->amount           =   $request->amount;
        $plan->plan_type        =   $request->plan_type;
        $plan->daily_msg        =   $request->daily_msg;
        $plan->obd              =   $request->obd;
        $plan->dtmf             =   $request->dtmf;
        $plan->call_patching    =   $request->call_patching;
        $plan->ibd              =   $request->ibd;
        $plan->status           =   1;
        $plan->save();
        session()->flash('success_msg', 'Plan update successfully');
        return redirect()->route('resellerplan.index');

    }

    public function destroy($id)
    {
        //
    }
}
