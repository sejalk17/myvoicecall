<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Limit;
use App\Models\User;
use App\Models\Provider;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Provider::where('status',1)->get();
        return view('admin.provider.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.provider.create');
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
            'provider' => 'required|max:200',
            'cli' => 'required|max:200',
        ]);
        $limit=new Provider;
        $limit->provider=$request->provider;
        $limit->cli=$request->cli;
        $limit->number=$request->number;
        $limit->landline=$request->landline;
        $limit->api_url=$request->apiurl;
        $limit->unique_id= uniqid();
        $limit->status=1;
        $limit->save();

         session()->flash('success_msg', 'Provider set successfully');
         return redirect()->route('provider.index');
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
        $row=Provider::where('unique_id',$id)->first();
      
        return view('admin.provider.edit',compact('row'));
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
        $limit=Provider::findorfail($id);
        $this->validate($request, [
            'provider' => 'required|max:200',
            'cli' => 'required|max:200',
        ]);
        $limit->provider=$request->provider;
        $limit->cli=$request->cli;
        $limit->number=$request->number;
        $limit->landline=$request->landline;
        $limit->api_url=$request->apiurl;
        $limit->save();

         session()->flash('success_msg', 'Provider updated successfully');
         return redirect()->route('provider.index');
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
