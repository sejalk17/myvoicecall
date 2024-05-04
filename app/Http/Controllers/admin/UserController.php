<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\helpers\CommonClass;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Transcation;
use App\Models\Ctsnumber;
use App\Models\UserPlan;
use App\Models\Plan;
use App\Models\Channel;
use App\Models\Userwiseplan;
use Illuminate\Support\Carbon;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('status',1)->whereHas('roles', function($q){
            $q->whereIn('name',['superdistributor','distributor','reseller','user','businessmanager','agentmanager','agentuser']);
        });
        if($request->user){
            $user=$user->where('parent_id', $request->user);
        }
        $user=$user->get();
        $reseller = User::where('status',1)->whereHas('roles', function($q){
            $q->where('name','reseller');
        })->get();
        return view('admin.user.index', compact('user','reseller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $soundType              =   CommonClass::getSoundsType();
        $role                   =   CommonClass::getRole();
        $ctsNumberArray         =   CommonClass::getCtsNumber();
        $ctsAgentNumberArray    =   CommonClass::getAgentCtsNumber();
        $apiProvider            =   CommonClass::getApiProvider();
        $userType               =   CommonClass::getUserType();
        $planType               =   CommonClass::getPlanType();
        $retryOption            =   CommonClass::getRetryOption();
        $plan                   =   Plan::where('parent_id',Auth::user()->id)->orderBy('id','asc')->get();
      
        return view('admin.user.create', compact('role', 'ctsNumberArray', 'apiProvider', 'userType', 'planType', 'retryOption','soundType','plan','ctsAgentNumberArray'));
    }

    public function store(Request $request)
    {
       //dd($request->all());
        $this->validate($request, [
            'username' => 'required|unique:users,username'
        ]);

      
        if ($request->role == 'user') {
            $parent_id = Auth::user()->id;
        } else {
            $parent_id = 0;
        }
        $user                   =   new User;
        $userDetail             =   new UserDetail;
        $user->status           =   1;
        $user->first_name       =   $request->first_name;
        $user->last_name        =   $request->last_name;
        $user->username         =   $request->username;
        $user->parent_id        =   $parent_id;
        $user->email            =   $request->email;
        $user->mobile           =   $request->mobile;
        $user->password         =   bcrypt($request->password);
        $user->actual_password  =   $request->password;
        if($request->role == 'reseller'){
            $user->reseller_wallet  =   $request->wallet;
        }else{
            $user->wallet           =   $request->wallet;  
        }
        
       
        $user->camp_type        =   $request->camp_type;
        $user->user_plan        =   $request->user_plan;
        $user->obd              =   $request->obd;
        $user->dtmf             =   $request->dtmf;
        $user->whtsapp_msg      =   $request->whtsapp_msg;
        $user->call_patching    =   $request->call_patching;
        $user->ibd              =   $request->ibd;
        $user->obd_schedule     =   $request->obd_schedule;
        $user->active_agent     =   $request->active_agent;
        
       
        $user->assignrole($request->role);
        $user->save();
        $user->id;

        $userDetail->user_id = $user->id;
        if ($request->hasFile('logo_image')) {
            $image              =   $request->file('logo_image');
            $filename           =   $image->getClientOriginalName();
            $destinationPath    =   public_path('uploads/user_image');
            $image->move($destinationPath, $filename);
            $userDetail->logo_image = "uploads/user_image/" . $filename;
        }

        $userDetail->address            =   $request->address;
        $userDetail->company_name       =   $request->company_name;
        $userDetail->user_type          =   $request->user_type;
        $userDetail->retry_option       =   $request->retry_option;
        $userDetail->api_status         =   $request->api_status;
        $userDetail->dnd_status         =   $request->dnd_status;
        $userDetail->market_margin      =   $request->market_margin;
        $userDetail->plan_start_date    =   $request->plan_start_date . ' 00:00:00';
        $userDetail->plan_end_date      =   $request->plan_end_date . ' 23:55:59';

        $userDetail->save();

        $newtranscation                          =   new Transcation();
        $newtranscation->user_id                 =   $user->id;
        $newtranscation->debit_amount            =   0;
        $newtranscation->credit_amount           =   $request->wallet;
        $newtranscation->remaining_amount        =   $request->wallet;
        $newtranscation->save();
        $countPlanType                          =   count($request->plan_type);

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

        if($request->ctsNumber){
            foreach ($request->ctsNumber as $singlectsNumber)
            {
                $ctsNumber                  =   new Ctsnumber();
                $channel                    =   Channel::where('ctsNumber', $singlectsNumber)->first();
                $channel->is_occupy         =   1;
                $ctsNumber->ctsNumber       =   $singlectsNumber;
                $ctsNumber->user_id         =   $user->id;
                $ctsNumber->status          =   1;
                $ctsNumber->type            =   'obd';
                $ctsNumber->save();
                $channel->save();
            }
        }
       
        if($request->plan_type){
            foreach ($request->plan_type as $singlePlanType)
            {
                if($singlePlanType[1]){
                    $userPlan                   =   new UserPlan();
                    $userPlan->user_id          =   $user->id;
                    $userPlan->plan_type        =   $singlePlanType[0];
                    $userPlan->price            =   $singlePlanType[1];
                     $userPlan->status          = 1;
                    $userPlan->save();
                }
                
            }
        }

        if($request->agentCtsNumber){
            foreach ($request->agentCtsNumber as $singlectsNumber)
            {
                $ctsNumber                  =   new Ctsnumber();
                $channel                    =   Channel::where('ctsNumber', $singlectsNumber)->first();
                $channel->agent_occupy      =   1;
                $ctsNumber->ctsNumber       =   $singlectsNumber;
                $ctsNumber->user_id         =   $user->id;
                $ctsNumber->type            =   'agent';
                $ctsNumber->status          =   1;
                $ctsNumber->save();
                $channel->save();
            }
        }
        

        session()->flash('success_msg', 'User created successfully');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $soundType          =   CommonClass::getSoundsType();
        $role               =   CommonClass::getRole();
        $cli                =   CommonClass::getCli(null);
        $ctsNumberArray     =   CommonClass::getCtsNumberOnEdit();
        $ctsAgentNumberArray=   CommonClass::getAgentCtsNumberOnEdit();
        $apiProvider        =   CommonClass::getApiProvider();
        $userType           =   CommonClass::getUserType();
        $planType           =   CommonClass::getPlanType();
        $retryOption        =   CommonClass::getRetryOption();
        $plan               =   Plan::where('parent_id',Auth::user()->id)->orderBy('id','asc')->get();
        $CtsNumbers         =   Ctsnumber::where('user_id', $id)->where('status', 1)->where('type', 'obd')->pluck('ctsNumber')->toArray();
        $agentCtsNumbers         =   Ctsnumber::where('user_id', $id)->where('status', 1)->where('type', 'agent')->pluck('ctsNumber')->toArray();
        //dd($agentCtsNumbers);
        $userPlan         =   UserPlan::where('user_id', $id)->get();
      //  dd($userPlan);

        $row                =   User::find($id);

      
        return view('admin.user.edit', compact('row', 'role', 'cli', 'apiProvider', 'userType', 'planType', 'retryOption','soundType','ctsNumberArray','CtsNumbers','userPlan','ctsAgentNumberArray','agentCtsNumbers','plan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

        ]);

       // dd($request->all());

        if ($request->role == 'user') {
            $parent_id          =   Auth::user()->id;
        } else {
            $parent_id          =   0;
        }
        $user                   =       User::where('id', $id)->first();
        $userDetail             =       UserDetail::where('user_id', $id)->first();
        $user->status           =       1;
        $user->first_name       =       $request->first_name;
        $user->last_name        =       $request->last_name;
        $user->email            =       $request->email;
        $user->ukey_id          =       ($request->ukey != null) ? $request->ukey : 0;
        $user->mobile           =       $request->mobile;
        $user->camp_type        =       $request->camp_type;
        $user->obd              =       $request->obd;
        $user->dtmf             =       $request->dtmf;
        $user->whtsapp_msg      =       $request->whtsapp_msg;
        $user->call_patching    =       $request->call_patching;
        $user->ibd              =       $request->ibd;
        $user->obd_schedule     =       $request->obd_schedule;
        $user->active_agent     =       $request->active_agent;
        $user->assignrole($request->role);
        $user->save();
 
        $userDetail->user_id = $id;
        if ($request->hasFile('logo_image')) {
            $image              =   $request->file('logo_image');
            $filename           =   $image->getClientOriginalName();
            $destinationPath    =   public_path('uploads/user_image');
            $image->move($destinationPath, $filename);
            $userDetail->logo_image = "uploads/user_image/" . $filename;
        }

        $userDetail->address                =       $request->address;
        $userDetail->company_name           =       $request->company_name;
        $userDetail->user_type              =       $request->user_type;
        $userDetail->retry_option           =       $request->retry_option;
        $userDetail->api_status             =       $request->api_status;
        $userDetail->dnd_status             =       $request->dnd_status;
        $userDetail->plan_start_date        =       $request->plan_start_date . ' 00:00:00';
        $userDetail->plan_end_date          =       $request->plan_end_date . ' 23:55:59';
    
        $userDetail->save();

        $CtsNumbers         =   Ctsnumber::where('user_id', $id)->pluck('ctsNumber')->toArray();
       
     
        // if($request->ctsNumber){
        //     foreach ($request->ctsNumber as $singlectsNumber)
        //     {
        //         $ctsNumber                  =   new Ctsnumber();
        //         $channel                    =   Channel::where('ctsNumber', $singlectsNumber)->first();
        //         $channel->is_occupy         =   1;
        //         $ctsNumber->ctsNumber       =   $singlectsNumber;
        //         $ctsNumber->user_id         =   $id;
        //         $ctsNumber->type            =   'obd';
        //         $ctsNumber->status          =   1;
        //         $ctsNumber->save();
        //         $channel->save();
        //     }
        // } 

        if($request->agentCtsNumber){
            Ctsnumber::where('user_id',$id)->whereNotIn('ctsNumber',$request->agentCtsNumber)->delete();
            foreach ($request->agentCtsNumber as $singlectsNumber)
            {
                $hasCts = Ctsnumber::where('user_id',$id)->where('ctsNumber',$singlectsNumber)->first();
                if(is_null($hasCts)){
                    $ctsNumber                  =   new Ctsnumber();
                    $channel                    =   Channel::where('ctsNumber', $singlectsNumber)->first();
                    $channel->agent_occupy      =   1;
                    $ctsNumber->ctsNumber       =   $singlectsNumber;
                    $ctsNumber->user_id         =   $id;
                    $ctsNumber->type            =   'agent';
                    $ctsNumber->status          =   1;
                    $ctsNumber->save();
                    $channel->save();
                }
            }
        }

        if($request->user_plan){

            $userWisePlans              =   Userwiseplan::where('user_id', $id)->first();
            if($userWisePlans){
                $plan                       =   Plan::where('id', $request->user_plan)->first();
                $dailymsg                   =   $plan->daily_msg;
                $userWisePlans->user_id     =   $id;
               // $userWisePlans->parent_id   =   Auth::user()->id;
                $userWisePlans->plan_id     =   $request->user_plan;
                $userWisePlans->usasage     =   0;
                $userWisePlans->start_date  =   $request->user_plan_start_date . ' 00:00:00';
                $userWisePlans->end_date    =   $request->user_plan_end_date . ' 23:55:59';
                $userWisePlans->flag        =   0;
                $userWisePlans->status      =   0;
                $userWisePlans->save();
                $da=User::where('id',$id)->update(['wallet'=>$dailymsg]);
            }else{
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
            
        }
        

        
        $userId                             =       User::where('parent_id',$id)->get(); 
        foreach($userId as $r){ 
            $userDetail                     =       UserDetail::where('user_id', $r->id)->first();
            $userDetail->cli                =       $request->cli;
            $userDetail->apiProvider        =       $request->apiProvider;
            $userDetail->save();
        }
        session()->flash('success_msg', 'User update successfully');
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
       
    }


    public function getcli(Request $request){
        $cli = CommonClass::getCli($request->provider);
        if($request->selectvalue){
            $output = '';
        }else{
            $output = '<option value="">Choose...</option>';
        }
        foreach($cli as $r){
            if($request->selectvalue == $r){
                $selected = 'selected';
            }else{
                $selected = ' ';
            }
            $output .= '<option '.$selected.' value="'.$r.'">'.$r.'</option>';
        }
        return response()->json($output);
    }


    public function getServiceNo(Request $request){
        $serviceno = CommonClass::getServiceNo($request->cli,$request->provider);
        if($request->selectvalue){
            $output = '';
        }else{
        $output = '<option value="">Choose...</option>';
        }
        foreach($serviceno as $key => $r){
            $selected = ' ';
            if($request->selectvalue != null){
                $serviceNos = json_decode(str_replace('&#039;','"',str_replace('&quot;','"',$request->selectvalue)));
                if($key == @$serviceNos->l_no && $r == @$serviceNos->n_no){
                    $selected = 'selected';
                }           
            }
            $output .= '<option '.$selected.' value="'.str_replace('"',"'",json_encode(['l_no' => $key,'n_no'=>$r])).'">'.$r.'</option>';
        }
        return response()->json($output);
    }


    public function getUkey(Request $request){
        $cli = CommonClass::getUkey($request->cli,$request->provider);
        if($request->selectvalue){
            $output = '';
        }else{
        $output = '<option value="">Choose...</option>';
        }
        foreach($cli as $r){
            if($request->selectvalue == $r->id){
                $selected = 'selected';
            }else{
                $selected = ' ';
            }
            $output .= '<option '.$selected.' value="'.$r->id.'">'.$r->username.'</option>';
        }
        return response()->json($output);
    }



    public function updateWallet(Request $request){
       
        $user = User::findorfail($request->id);
        $user->wallet += $request->amount;
        $user->reseller_wallet += $request->reseller_wallet; 
        $user->save();
        
        /**Promotional Balance added **/
        if($request->amount){
            $newtranscation                          =   new Transcation();
            $newtranscation->user_id                 =   $user->id;
            $newtranscation->debit_amount            =   0;
            $newtranscation->credit_amount           =   $request->amount;
            $newtranscation->remaining_amount        =   $user->wallet;
            $newtranscation->transcation_type        =   1;
            $newtranscation->Remarks                =    "Promotional balance added";
            $newtranscation->save();
        }
        
        /**Transactional Balance added **/
        if($request->transactional_wallet){
            $newtranscation                          =   new Transcation();
            $newtranscation->user_id                 =   $user->id;
            $newtranscation->debit_amount            =   0;
            $newtranscation->credit_amount           =   $request->transactional_wallet;
            $newtranscation->remaining_amount        =   $user->transactional_wallet;
            $newtranscation->transcation_type        =   2;
            $newtranscation->Remarks                 =    "Transactional balance added";
            $newtranscation->save();
        }
        
                
       session()->flash('success_msg', 'Wallet update successfully');
       return back();
    }
}
