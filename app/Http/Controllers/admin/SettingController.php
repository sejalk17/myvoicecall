<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\helpers\CommonClass;
use App\Models\Setting;
class SettingController extends Controller
{
    public function index(){
    $apiProvider = CommonClass::getApiProvider();
    return view('admin.setting.index',compact('apiProvider'));
    }


    public function store(Request $request){
        $formType = $request->input('form_type');

        if ($formType === 'demoUkey') {

            if(empty(getSiteSettings('demo_apiProvider'))){
                $data['_key']='demo_apiProvider';
                $data['_value']=$request->demo_apiProvider;
                $save=Setting::create($data);
            }else{
                $data['_value']=$request->demo_apiProvider;
                $save=Setting::where('_key','=','demo_apiProvider')->update($data);
            }

            if(empty(getSiteSettings('demo_cli'))){
                $data['_key']='demo_cli';
                $data['_value']=$request->demo_cli;
                $save=Setting::create($data);
            }else{
                $data['_value']=$request->demo_cli;
                $save=Setting::where('_key','=','demo_cli')->update($data);
            }


            if(empty(getSiteSettings('demo_service_no'))){
                $data['_key']='demo_service_no';
                $data['_value']=$request->demo_service_no;
                $save=Setting::create($data);
            }else{
                $data['_value']=$request->demo_service_no;
                $save=Setting::where('_key','=','demo_service_no')->update($data);
            }

            if(empty(getSiteSettings('demo_username'))){
                $data['_key']='demo_username';
                $data['_value']=$request->demo_username;
                $save=Setting::create($data);
            }else{
                $data['_value']=$request->demo_username;
                $save=Setting::where('_key','=','demo_username')->update($data);
            }


            if(empty(getSiteSettings('demo_key'))){
                $data['_key']='demo_key';
                $data['_value']=$request->demo_key;
                $save=Setting::create($data);
            }else{
                $data['_value']=$request->demo_key;
                $save=Setting::where('_key','=','demo_key')->update($data);
            }
            if(empty(getSiteSettings('demo_url'))){
                $data['_key']='demo_url';
                $data['_value']=$request->demo_url;
                $save=Setting::create($data);
            }else{
                $data['_value']=$request->demo_url;
                $save=Setting::where('_key','=','demo_url')->update($data);
            }

         return back()->with('msg','Demo ukey Updated Successfully!');
        }
    }
}
