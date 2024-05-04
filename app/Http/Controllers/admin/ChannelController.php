<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\User;
use App\Models\Ctsnumber;

class ChannelController extends Controller
{
    public function index()
    {
        $channel = Channel::orderBy('id','desc')->get();
        
        $channel = Channel::leftJoin('ctsnumbers', 'channels.ctsNumber', '=', 'ctsnumbers.ctsNumber')
        ->leftJoin('users', 'ctsnumbers.user_id', '=', 'users.id')
        ->select('channels.*', 'users.first_name', 'users.last_name')
        ->get();
        return view('admin.channel.index', compact('channel'));
    }

    public function create()
    {
        return view('admin.channel.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'ctsNumber'=> 'required|unique:channels'
        ]);

        $channel               =   new Channel;
        $channel->ctsNumber    =   $request->ctsNumber;
        $channel->channelserver=   $request->channelserver;
        $channel->status       =   1;
        $channel->save();
        session()->flash('success_msg', 'CTS Number succcessfully added');
        return redirect()->route('channel.index');
     }

    public function show($id)
    {
       
    }

    public function edit($id)
    {
        $row         =   Channel::where('id', $id)->first();
        return view('admin.channel.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

        ]);
        $channel                   =       Channel::where('id', $id)->first();
        $channel->inactive          =   $request->inactive;
        $channel->reason          =   $request->reason;
        $channel->save();
        session()->flash('success_msg', 'Channel Information update successfully');
        return redirect()->route('channel.index');
    }

    public function destroy($id)
    {
       
    }

    public function statusUpdate(Request $request){
        $data = Channel::findorfail($request->id);
        $data->status = $request->status;
        $data->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function addctsnumberuser(){
        $user = User::where('status',1)->whereHas('roles', function($q){
            $q->where('name','user');
        })->pluck('username','id')->toArray();
        $channel = Channel::where('inactive','0')->where('status','1')->pluck('ctsNumber','ctsNumber')->toArray();
        return view('admin.channel.addctsnumber', compact('channel','user'));
        //dd($channel, $user);
    }

    public function addctsnumbersave(Request $request){
        $this->validate($request, [
            'users'=> 'required',
            'ctsNumber'=> 'required'
        ]);

        $ctsNumber                  =   new Ctsnumber();
        $channel                    =   Channel::where('ctsNumber', $request->ctsNumber)->first();
        $channel->is_occupy         =   1;
        $ctsNumber->ctsNumber       =   $request->ctsNumber;
        $ctsNumber->user_id         =   $request->users;
        $ctsNumber->status          =   1;
        $ctsNumber->type            =   'obd';
        $ctsNumber->save();
        $channel->save();
        session()->flash('success_msg', 'CTS Number succcessfully added');
        return redirect()->route('channel.index');
        dd($request);
    }
}
