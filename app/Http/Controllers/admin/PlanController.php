<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use Auth;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        

        if($request->user){
            $plan = Plan::where('parent_id',$request->user)->orderBy('id','desc')->get();
        }else{
            $plan = Plan::where('parent_id',Auth::user()->id)->orderBy('id','desc')->get();
        }


        $reseller = User::where('status',1)->whereHas('roles', function($q){
            $q->where('name','reseller');
        })->get();
      
        return view('admin.plan.index', compact('plan','reseller'));
    }

    public function create()
    {
        return view('admin.plan.create');
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
        return redirect()->route('plan.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $row                =   plan::find($id);
        return view('admin.plan.edit', compact('row'));
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
        session()->flash('success_msg', 'Planw update successfully');
        return redirect()->route('plan.index');

    }

    public function destroy($id)
    {
        //
    }
}
