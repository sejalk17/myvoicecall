<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sound;
use App\Models\UserDetail;
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
    public function index()
    {
        $sound = Sound::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        return view('user.sound.index', compact('sound'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $soundType = CommonClass::getSoundsType();
        return view('user.sound.create', compact('soundType'));
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
        $plantype   =   UserDetail::where('user_id',Auth::user()->id)->value('plan_type');
        $filename   =   $request->name;
        $file       =   $request->voiceclip;
        $text       =   "Submitted Successfully to Provisioning with Voice ID:";
        $pattern    =   '/Voice ID: (\d+)/';
        $voiceId    =   0;
        if(UserDetail::where('user_id',Auth::user()->id)->value('apiProvider') == 'Videocon'){
            $ukey       =   Ukey::where('status',"1")->where('id',Auth::user()->ukey_id)->first();
            if($ukey != null){
                $username = $ukey->username;
                $password = $ukey->ukey;
            }else{
                $username = "amitgoyal";
                $password = "123123";
            }
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
        $sound->name        =   $request->name;
        $sound->type        =   $request->type;
        $sound->status      =   0;
        $sound->voice_id      = $voiceId;
        $sound->user_id     =   $authUserId;
        $sound->provider     =  UserDetail::where('user_id',$authUserId)->value('apiProvider');
        $sound->approved_by =   0;
        $sound->duration    =   '';

//dd($request->hasFile('voiceclip'));
        if ($request->hasFile('voiceclip')) {
            $getID3 = new getID3();
    $fileInfo = $getID3->analyze($request->file('voiceclip'));
//dd($fileInfo);
    // Check if it's a WAV file
    if ($fileInfo['fileformat'] === 'wav' || $fileInfo['fileformat'] === 'mp3') {
        // Get the duration in seconds
        $sound->duration = str_replace('0:','',$fileInfo['playtime_string']);
    }
            $soundClip = $request->file('voiceclip');
            $originalFileName = $soundClip->getClientOriginalName();
            
            $filename = str_replace('.'.$fileInfo['fileformat'], '', $originalFileName);
            $filename = str_replace(' ', '_', $filename); // Removing spaces
            $filename = $filename . '_' . time() . '_' . Auth::user()->id . '.' . $fileInfo['fileformat'];

            $destinationPath = public_path('uploads/soundclip');
            $soundClip->move($destinationPath, $filename);
            $sound->voiceclip = "uploads/soundclip/" . $filename;
        }

        $sound->save();
        session()->flash('success_msg', 'Voice file upload successfully');
        return redirect()->route('usersound.index');
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

    public function approveStatus(Request $request, $id)
    {
        $soundId = $_POST[$id];

        $sound = Sound::find($soundId);

        // Make sure you've got the Page model
        if($sound) {
            $sound->status = 1;
            $sound->approved_by = Auth::user()->id;;
            $sound->save();
            session()->flash('success_msg', 'Voice file approved successfully');
            return redirect()->route('sound.index');
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
