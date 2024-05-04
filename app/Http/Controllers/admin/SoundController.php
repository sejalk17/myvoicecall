<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sound;
use App\Models\Ukey;
use App\helpers\CommonClass;
use Auth;
use Illuminate\Support\Facades\Http;
use getID3,DB;

class SoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->paginate) {
            $paginate = $request->paginate;
        } else {
            $paginate = 10;
        }
        if ($request->sort_f) {
            $sort_f = $request->sort_f;
        } else {
            $sort_f = 'id';
        }
        if ($request->sort_by) {
            $sort_by = $request->sort_by;
        } else {
            $sort_by = 'DESC';
        }

        $sound = Sound::orderBy('id','desc');
        $sound = $sound->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);

        return view('admin.sound.index', compact('sound','paginate', 'sort_f', 'sort_by'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ukey = Ukey::where('status', "1")->get();
        $soundType = CommonClass::getSoundsType();
        $apiProvider = CommonClass::getApiProvider();
        return view('admin.sound.create', compact('soundType','apiProvider','ukey'));
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
          'voiceclip'=> 'required|mimes:wav'
        ]);
        $ukey = Ukey::find($request->ukey);
                    if($ukey != null){
                        $username = $ukey->username;
                        $password = $ukey->ukey;
                    }else{
                        $username = "amitgoyal";
                        $password = "123123";
                    }
    $plantype = 30;
    $filename = $request->name;
    $file = $request->voiceclip;
    $text = "Submitted Successfully to Provisioning with Voice ID:";
$pattern = '/Voice ID: (\d+)/';
$voiceId = 0;
   if($request->apiProvider == 'Videocon'){
    try {
    $response = Http::attach('uploadedfile', file_get_contents($file), 'uploadedfile.wav')
        ->post('http://103.132.146.183/VoxUpload/api/Values/upload', [
            'password' => $password,
            'username' => $username,
            'plantype' => $plantype,
            'filename' => $filename,
        ]);

        if($response->successful()) {
            if (strpos($response->body(), $text) !== false) {
                if (preg_match($pattern, $response->body(), $matches)) {
    $voiceId = (int)$matches[1];
} else {
    session()->flash('error', 'Voice ID not found');
       return back()->withInput();
}
} else {
    session()->flash('error', $response->body());
       return back()->withInput();
}
   
    } else {
        session()->flash('error', $response->body());
       return back()->withInput();
    }
} catch (RequestException $e) {
    session()->flash('error', $e->getMessage());
       return back()->withInput();
}
   }

        $authUserId         =   Auth::user()->id;
        $sound              =   new Sound;
        $sound->type        =   $request->type;
        $sound->name        =   $request->name;
        $sound->status      =   0;
        $sound->voice_id      = $voiceId;
        $sound->user_id     =   $authUserId;
        $sound->provider     =   $request->apiProvider;
        $sound->approved_by =   0;
        $sound->duration    =   '';

        if ($request->hasFile('voiceclip')) {
        $getID3 = new getID3();
    $fileInfo = $getID3->analyze($request->file('voiceclip'));
    // Check if it's a WAV file
    if ($fileInfo['fileformat'] === 'wav') {
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
        return redirect()->route('sound.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

    }

    public function approveStatus($id)
    {
        $sound = Sound::find($id);
        if($sound) {
            $sound->status = 1;
            $sound->approved_by = Auth::user()->id;
            $sound->save();
            session()->flash('success_msg', 'Voice file approved successfully');
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
