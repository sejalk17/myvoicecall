<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPlan;
use App\Models\Wallet;
use App\Models\Contact;
use Illuminate\Support\Carbon;
use Session;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
        // return view('undermaintainance');
    }
      public function registeruser(){
        return view('registeruser');
    }

    public function storeregister(Request $request){
	    $input=$request->all();
        $this->validate($request, [
            'name' => 'required',
            'first_name' => 'required',
            'email'=>'required',
            'username'=>'required|unique:users',
            'mobile'=>'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
       // dd($request);

        $user                   =   new User;
        $userDetail             =   new UserDetail;
        $user->status           =   1;
        $user->first_name       =   $request->first_name;
        $user->last_name        =   $request->last_name;
        $user->username         =   $request->username;
        $user->parent_id        =   0;
        $user->email            =   $request->email;
        $user->mobile           =   $request->mobile;
        $user->password         =   bcrypt($request->password);
        $user->actual_password  =   $request->password;
        $user->by_name          =   $request->name;
        $user->wallet           =   0; 
        
        $user->camp_type        =   "transactional";
        $user->user_plan        =   0;
        $user->obd              =   0;
        $user->dtmf             =   0;
        $user->whtsapp_msg      =   0;
        $user->call_patching    =   0;
        $user->ibd              =   0;
        $user->obd_schedule     =   0;
        $user->assignrole('user');
        $user->save();
        $user->id;
        $userDetail->user_id            =   $user->id;
        $userDetail->address            =   $request->address;
        $userDetail->company_name       =   $request->company_name;
        $userDetail->user_type          =   "submission";
        $userDetail->retry_option       =   "2";
        $userDetail->api_status         =   0;
        $userDetail->dnd_status         =   0;
        $userDetail->plan_start_date    =   Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $userDetail->plan_end_date      =   Carbon::now()->addMonths(3)->format('Y-m-d') . ' 23:55:59';

        $userPlan                   =   new UserPlan();
        $userPlan->user_id          =   $user->id;
        $userPlan->plan_type        =   30;
        $userPlan->price            =   30;
        $userPlan->status          = 1;
        $userPlan->save();
        

        $userDetail->save();

        Session::flash('message', 'Thank You for Registration now you can login with the portal'); 
        Session::flash('alert-class', 'alert-danger'); 
        return back();

    }

    public function undermaintainance()
    {
        return view('undermaintainance');
    }

    public function contact_store(Request $request)
    {
        $input=$request->all();
        $this->validate($request, [
	        'contact_name' => 'required',
			'contact_email' => 'required',
            'contact_subject'=>'required',
			'contact_message'=>'required',
        ]);


        $contact=new Contact;
        $contact->contact_name=$request->contact_name;
        $contact->contact_email=$request->contact_email;
        $contact->contact_subject=$request->contact_subject;
        $contact->contact_message=$request->contact_message;
        $contact->save();

        Session::flash('message', 'Thank You for contacting us We will contact you shortly'); 
        Session::flash('alert-class', 'alert-danger'); 
        return back();

    }
}
