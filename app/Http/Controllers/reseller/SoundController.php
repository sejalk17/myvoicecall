<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sound;
use App\Models\User;
use App\helpers\CommonClass;
use Auth;
use getID3;

class SoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->user){
            $userIDArray = User::where('parent_id', $request->user)->pluck('id')->toArray();
        }else{
            $userIDArray = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        }

    
        $reseller = User::where('status',1)->where('parent_id',Auth::user()->id)->whereHas('roles', function($q){
            $q->where('name','reseller');
        })->get();
        $sound = Sound::whereIn('user_id',$userIDArray)->orderBy('id','desc')->get();
       // dd($userIDArray, $sound   );

        // $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        // $user[] = Auth::user()->id;
        // $sound = Sound::whereIn('user_id',$user)->orderBy('id','desc')->get();
       
        return view('reseller.sound.index', compact('sound','reseller'));
    }

    public function create()
    {
        $soundType = CommonClass::getSoundsType();
        return view('reseller.sound.create', compact('soundType'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'voiceclip'=> 'required|mimes:wav'
        ]);
        $authUserId         =   Auth::user()->id;
        $sound              =   new Sound;
        $sound->type        =   $request->type;
        $sound->name        =   $request->name;
        $sound->status      =   0;
        $sound->user_id     =   $authUserId;
        $sound->approved_by =   0;
        $sound->duration    =   '';

        if ($request->hasFile('voiceclip')) {
        $getID3 = new getID3();
    $fileInfo = $getID3->analyze($request->file('voiceclip'));
    // Check if it's a WAV file
    if ($fileInfo['fileformat'] === 'wav' || $fileInfo['fileformat'] === 'mp3') {
        // Get the duration in seconds
        $sound->duration = str_replace('0:','',$fileInfo['playtime_string']);
    }
            $soundClip = $request->file('voiceclip');
            $filename = str_replace('.'.$fileInfo['fileformat'],'',$soundClip->getClientOriginalName()).'_'.time().'_'.Auth::user()->id.'.'.$fileInfo['fileformat'];
            $destinationPath = public_path('uploads/soundclip');
            $soundClip->move($destinationPath, $filename);
            $sound->voiceclip = "uploads/soundclip/" . $filename;
        }

        $sound->save();
        session()->flash('success_msg', 'Voice file upload successfully');
        return redirect()->route('resellersound.index');
    }

    public function show($id)
    {
        

    }

    public function edit($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
