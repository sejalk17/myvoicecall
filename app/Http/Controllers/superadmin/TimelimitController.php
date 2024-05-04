<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeFreeze;
class TimelimitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        $time_limit=TimeFreeze::where('status',1)->get();
        return view('superadmin.time_limit.index',compact('time_limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   
        return view('superadmin.time_limit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'time_limit' => 'required',
            'date_limit' => 'required',
            // 'upto_time' => 'required',
            // 'upto_date' => 'required',
           
        ]);
        $timelimit=new TimeFreeze;
        $timelimit->time_limit=$request->time_limit;
        $timelimit->date_limit=date('Y-m-d',strtotime($request->date_limit));
        $timelimit->upto_time=$request->upto_time;
        $timelimit->upto_date=date('Y-m-d',strtotime($request->upto_date));
        $timelimit->status=1;
        $timelimit->unique_id=uniqid();
       
        
        $timelimit->save();

         session()->flash('success_msg', 'time_limt set successfully');
         return redirect()->route('time_limit.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row=TimeFreeze::where('unique_id',$id)->first();
      
        return view('superadmin.time_limit.edit',compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'time_limit' => 'required',
            'date_limit' => 'required',
            // 'upto_time' => 'required',
            // 'upto_date' => 'required',
           
        ]);
        $timelimit=TimeFreeze::find($id);
        $timelimit->time_limit=$request->time_limit;
        $timelimit->date_limit=date('Y-m-d',strtotime($request->date_limit));
        $timelimit->upto_time=$request->upto_time;
        $timelimit->upto_date=date('Y-m-d',strtotime($request->upto_date));
        $timelimit->status=1;
        $timelimit->unique_id=uniqid();
       
        
        $timelimit->save();

         session()->flash('success_msg', 'time_limt updated successfully');
         return redirect()->route('time_limit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
