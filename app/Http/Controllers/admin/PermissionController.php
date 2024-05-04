<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('status',1)->whereHas('roles', function($q){
            $q->whereIn('name',['reseller','user']);
        });
        if($request->user){
            $user=$user->where('parent_id', $request->user);
        }
        $user=$user->get();
        $reseller = User::where('status',1)->whereHas('roles', function($q){
            $q->where('name','reseller');
        })->get();
        return view('admin.permission.index', compact('user','reseller'));
    }

  
    public function create()
    {
        return view('admin.permission.create');
    }

  
    public function store(Request $request)
    {
       
    }

  
    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $row                =   User::find($id);
        return view('admin.permission.edit',compact('row'));
        
    }

  
    public function update(Request $request, $id)
    {
        $this->validate($request, [

        ]);
        $user                       =       User::where('id', $id)->first();
        $user->block_view           =       $request->block_view;
        $user->block_download       =       $request->block_download;
        $user->number_permission    =       $request->number_permission;
        $user->save();
        session()->flash('success_msg', 'Permission update successfully');
        return redirect()->route('permission.index');
    }

  
    public function destroy($id)
    {
        //
    }
}
