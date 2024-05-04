<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThirdPartySetting;
use Auth;
class WhatsappSettingsController extends Controller
{
    public function index()
    {
        $user_id        =   Auth::user()->id;
        $row                =   ThirdPartySetting::where('type','whatsapp')->where('user_id',$user_id)->first();

        return view('user.whatsapp.index',compact('row'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'template_id' => 'required',
            'api_path' => 'required',
            'temp_lang' => 'required',
        ]);

        $user_id        =   Auth::user()->id;
        $data = [
            'api_path'=> trim($request->api_path),
            'temp_id' => trim($request->template_id),
            'temp_ln' => trim($request->temp_lang),
            'type'    => 'whatsapp',

        ];
        ThirdPartySetting::updateOrInsert(['user_id' => $user_id], $data);

        session()->flash('success_msg', 'Information saved successfully');
        return back();
    }

    public function show($id)
    {
        //
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
