<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use App\helpers\CommonClass;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transcation;
use App\Models\UserDetail;
use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\Userwiseplan;
use Auth, DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->user){
            $userIDArray = User::where('parent_id', $request->user)->pluck('id')->toArray();
        }else{
            $userIDArray = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        }
        $user = User::whereIn('id',$userIDArray);
        $user=$user->get();
        $reseller = User::where('status',1)->where('parent_id',Auth::user()->id)->whereHas('roles', function($q){
            $q->where('name','reseller');
        })->get();
        return view('reseller.user.index', compact('user','reseller'));
    }

    public function create()
    {
        $parent_id   = DB::table('users')->where('id', '=', Auth::user()->id)->value('parent_id');
        if($parent_id){
            $role           =   CommonClass::getRoleBySubResller();
        }else{
            $role           =   CommonClass::getRoleByResller();
        }
        
        $soundType      =   CommonClass::getSoundsType();
        $apiProvider    =   CommonClass::getApiProvider();
        $userType       =   CommonClass::getUserType();
        $planType       =   CommonClass::getPlanType();
        $retryOption    =   CommonClass::getRetryOption();
        $plan           =   Plan::where('parent_id',Auth::user()->id)->orderBy('id','asc')->get();
        return view('reseller.user.create', compact('role', 'apiProvider', 'userType', 'planType', 'retryOption','plan','soundType'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username'
        ]);
       
        if($request->user_plan && $request->user_plan != 0){
            $userWisePlan = Userwiseplan::select('plan_id')->where('parent_id', Auth::user()->id)->get();
            $planIds = $userWisePlan->pluck('plan_id')->toArray();
            $planLimits = Plan::whereIn('id', $planIds)->pluck('daily_msg', 'id');
            $dailyMsgLimit  =   0;
            foreach ($planIds as $planId) {
                $dailyMsgLimit += $planLimits[$planId];
            }

            $prentWisePlan = Userwiseplan::select('plan_id')->where('user_id', Auth::user()->id)->get();

            // Extract plan IDs from the result
            $parentPlanId = $prentWisePlan->pluck('plan_id')->toArray();
            $totalParentDailyMsgLimit = Plan::whereIn('id', $parentPlanId)->sum('daily_msg');
            $totalAllowLimitParentWise = (int)$totalParentDailyMsgLimit*8;
            if($dailyMsgLimit >= $totalAllowLimitParentWise){
                $message = "Sorry, you have exceeded the limit for creating new users. If you need to increase your limit, please contact your admin.";
                session()->flash('error', $message);
                return redirect()->route('reselleruser.index');
            }
        }
      
        $userCredit   = DB::table('users')->where('id', '=', Auth::user()->id)->value('reseller_wallet');

        if($userCredit < $request->wallet){
            session()->flash('error', 'Your credit is low so please contact to you reseller');
            return redirect()->route('reselleruser.index');
        }else{
            $parent_id                  =   Auth::user()->id;
            $remainingBalance           =   $userCredit - $request->wallet;
            $user                       =   new User;
            $userDetail                 =   new UserDetail;
            $user->status               =   1;
            $user->first_name           =   $request->first_name;
            $user->last_name            =   $request->last_name;
            $user->username             =   $request->username;
            $user->parent_id            =   $parent_id;
            $user->email                =   $request->email;
            $user->user_plan            =   $request->user_plan;
            $user->mobile               =   $request->mobile;
            $user->camp_type            =   $request->camp_type;
            $user->password             =   bcrypt($request->password);
            $user->actual_password      =   $request->password;
            if ($request->role == 'reseller'){
                $user->reseller_wallet  =   $request->wallet;
            }else{
                $user->wallet           =   $request->wallet;
            }
            
            $user->assignrole($request->role);
            $user->save();
            $user->id;
            $updateUserBalance          =   User::where('id',Auth::user()->id)->update(['reseller_wallet' => $remainingBalance]);
            
            
                
            $userDetail->user_id = $user->id;
            if ($request->hasFile('logo_image')) {
                $image = $request->file('logo_image');
                $filename = $image->getClientOriginalName();
                $destinationPath = public_path('uploads/user_image');
                $image->move($destinationPath, $filename);
                $userDetail->logo_image = "uploads/user_image/" . $filename;
            }
    
            $userDetail->address             =   $request->address;
            $userDetail->company_name        =   $request->company_name;
            $userDetail->user_type           =   $request->user_type;
            $userDetail->plan_type           =   $request->plan_type;
            $userDetail->retry_option        =   $request->retry_option;
            $userDetail->api_status          =   $request->api_status;
            $userDetail->dnd_status          =   $request->dnd_status;
            $userDetail->market_margin       =   $request->market_margin;
            $userDetail->plan_start_date     =   $request->plan_start_date . ' 00:00:00';
            $userDetail->plan_end_date       =   $request->plan_end_date . ' 23:55:59';
            $userDetail->cli                 =   UserDetail::where('user_id',Auth::user()->id)->value('cli');
            $userDetail->apiProvider         =   UserDetail::where('user_id',Auth::user()->id)->value('apiProvider');
            $userDetail->save();

            if($request->user_plan){
                $userWisePlans              =   new Userwiseplan();
                $plan                       =   Plan::where('id', $request->user_plan)->first();
                $dailymsg                   =   $plan->daily_msg;
                $userWisePlans->user_id     =   $user->id;
                $userWisePlans->parent_id   =   Auth::user()->id;
                $userWisePlans->plan_id     =   $request->user_plan;
                $userWisePlans->usasage     =   0;
                $userWisePlans->start_date  =   $request->user_plan_start_date . ' 00:00:00';
                $userWisePlans->end_date    =   $request->user_plan_end_date . ' 23:55:59';
                $userWisePlans->flag        =   0;
                $userWisePlans->status      =   0;
                $userWisePlans->save();
                $da=User::where('id',$user->id)->update(['wallet'=>$dailymsg]);
            }

            if($request->plan_type){
                $userPlan                   =   new UserPlan();
                $userPlan->user_id          =   $user->id;
                $userPlan->plan_type        =   $request->plan_type;
                $userPlan->price            =   '30';
                $userPlan->status          =    1;
                $userPlan->save();
                
            }else{
                $resellertranscation                        =   new Transcation();
                $resellertranscation->user_id               =   Auth::user()->id;
                $resellertranscation->debit_amount          =   $request->wallet;
                $resellertranscation->credit_amount         =   0;
                $resellertranscation->remaining_amount      =   $remainingBalance;
                $resellertranscation->save();
                
                $newtranscation                          =   new Transcation();
                $newtranscation->user_id                 =   $user->id;
                $newtranscation->debit_amount            =   0;
                $newtranscation->credit_amount           =   $request->wallet;
                $newtranscation->remaining_amount        =   $request->wallet;
                $newtranscation->save();
            }
            session()->flash('success', 'User created successfully');
            return redirect()->route('reselleruser.index');
        }

        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $id             =   User::where('id', $id)->value('id');
        $row            =   User::find($id);
        $role           =   CommonClass::getRoleByResller();
        $apiProvider    =   CommonClass::getApiProvider();
        $userType       =   CommonClass::getUserType();
        $planType       =   CommonClass::getPlanType();
        $retryOption    =   CommonClass::getRetryOption();
        $plan           =   Plan::where('parent_id',Auth::user()->id)->orderBy('id','asc')->get();
        return view('reseller.user.edit', compact('row', 'role', 'apiProvider', 'userType', 'planType', 'retryOption','plan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

        ]);

        if($request->user_plan && $request->user_plan != 0){
            $userWisePlan = Userwiseplan::select('plan_id')->where('parent_id', Auth::user()->id)->get();
            $planIds = $userWisePlan->pluck('plan_id')->toArray();
            $planLimits = Plan::whereIn('id', $planIds)->pluck('daily_msg', 'id');
            $dailyMsgLimit  =   0;
            foreach ($planIds as $planId) {
                $dailyMsgLimit += $planLimits[$planId];
            }

            $prentWisePlan = Userwiseplan::select('plan_id')->where('user_id', Auth::user()->id)->get();

            // Extract plan IDs from the result
            $parentPlanId = $prentWisePlan->pluck('plan_id')->toArray();
            $totalParentDailyMsgLimit = Plan::whereIn('id', $parentPlanId)->sum('daily_msg');
            $totalAllowLimitParentWise = (int)$totalParentDailyMsgLimit*8;
            if($dailyMsgLimit >= $totalAllowLimitParentWise){
                $message = "Sorry, you have exceeded the limit for creating new users. If you need to increase your limit, please contact your admin.";
                session()->flash('error', $message);
                return redirect()->route('reselleruser.index');
            }
        }

        $AuthUserCredit   =     DB::table('users')->where('id', '=', Auth::user()->id)->value('wallet');
        $userCredit       =     DB::table('users')->where('id', '=', $id)->value('wallet');
        if($AuthUserCredit <= $request->wallet){
            session()->flash('error', 'Your credit is low so please contact to you reseller');
            return redirect()->route('reselleruser.index');
        }else{
            //dd($request);
            $remainingAuthBalance           =   $AuthUserCredit - $request->wallet;
            $newUserBalance                 =   $userCredit + $request->wallet;
            if ($request->role == 'user') {
                $parent_id = Auth::user()->id;
            } else {
                $parent_id = 0;
            }
            $user = User::where('id', $id)->first();
            $userDetail = UserDetail::where('user_id', $id)->first();
            $user->status = 1;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->parent_id = $parent_id;
            $user->email = $request->email;
            $user->user_plan        =   $request->user_plan;
            $user->camp_type = Auth()->user()->camp_type;
            $user->mobile = $request->mobile;
            $user->assignrole($request->role);
            $user->save();
            $user->id;

            $updateAuthUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingAuthBalance]);
            $updateuserBalance = User::where('id',$id)->update(['wallet' => $newUserBalance]);

            $userDetail->user_id = $user->id;
            if ($request->hasFile('logo_image')) {
                $image = $request->file('logo_image');
                $filename = $image->getClientOriginalName();
                $destinationPath = public_path('uploads/user_image');
                $image->move($destinationPath, $filename);
                $userDetail->logo_image = "uploads/user_image/" . $filename;
            }

            if($request->user_plan){
                $conditions = [
                    'user_id' => $id,
                    'parent_id' => Auth::user()->id,
                ];
                $data1 = [
                    'user_id' => $user->id,
                    'parent_id' => Auth::user()->id,
                    'plan_id' => $request->user_plan,
                    'usasage' => 0,
                    'start_date' => $request->user_plan_start_date . ' 00:00:00',
                    'end_date' => $request->user_plan_end_date . ' 23:55:59',
                    'flag' => 0,
                    'status' => 0,
                ];

                Userwiseplan::updateOrInsert($conditions,$data1);
                $plan                       =   Plan::where('id', $request->user_plan)->first();
                $dailymsg                   =   $plan->daily_msg;
             
                $da=User::where('id',$user->id)->update(['wallet'=>$dailymsg]);
            }

            $userDetail->address = $request->address;
            $userDetail->company_name = $request->company_name;
            // $userDetail->cli = $request->cli;
            // $userDetail->apiProvider = $request->apiProvider;
            // $userDetail->user_type = $request->user_type;
            // $userDetail->plan_type = $request->plan_type;
            // $userDetail->retry_option = $request->retry_option;
            // $userDetail->api_status = $request->api_status;
            // $userDetail->dnd_status = $request->dnd_status;
            // $userDetail->market_margin = $request->market_margin;
            // $userDetail->plan_start_date = $request->plan_start_date . ' 00:00:00';
            // $userDetail->plan_end_date = $request->plan_end_date . ' 23:55:59';
            $userDetail->cli = UserDetail::where('user_id',Auth::user()->id)->value('cli');
            $userDetail->apiProvider = UserDetail::where('user_id',Auth::user()->id)->value('apiProvider');
            $userDetail->save();
            session()->flash('success', 'User update successfully');
            return redirect()->route('reselleruser.index');
        }

        
    }

    public function destroy($id)
    {
        //
    }

    public function updateWallet(Request $request){

      
       $user = User::findorfail($request->id);
      
        $transAuthUserCredit    =    DB::table('users')->where('id', '=', Auth::user()->id)->value('reseller_wallet');
        if($transAuthUserCredit < $request->amount){
            session()->flash('error', 'Your credit is low');
            return back();
        }else if($request->amount != 0){ 
            $remainingAuthBalance           =   $transAuthUserCredit - $request->amount;
            $user->wallet += $request->amount;
            $user->save();
            $updateAuthUserBalance = User::where('id',Auth::user()->id)->update(['reseller_wallet' => $remainingAuthBalance]);
            $resellertranscation                        =   new Transcation();
            $resellertranscation->user_id               =   Auth::user()->id;
            $resellertranscation->debit_amount          =   $request->amount;
            $resellertranscation->credit_amount         =   0;
            $resellertranscation->remaining_amount      =   $remainingAuthBalance;
            $resellertranscation->save();
            
            $newtranscation                          =   new Transcation();
            $newtranscation->user_id                 =   $user->id;
            $newtranscation->debit_amount            =   0;
            $newtranscation->credit_amount           =   $request->amount;
            $newtranscation->remaining_amount        =   $user->wallet;
            $newtranscation->Remarks                 =   "Promotional balance added";
            $newtranscation->save();
                
            session()->flash('success', 'Wallet update successfully');
            return back();
            
        }

       
    }
}
