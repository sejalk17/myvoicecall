<?php

namespace App\Http\Controllers\businessmanager;

use App\Http\Controllers\Controller;
use App\helpers\CommonClass;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transcation;
use App\Models\UserDetail;
use Auth, DB;

class UserController extends Controller
{
    public function index()
    {
        $userIDArray = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        $user = User::whereIn('id',$userIDArray)->get();
        return view('businessmanager.user.index', compact('user'));
    }

    public function create()
    {
         $role = CommonClass::getRoleByBusinessManager();
        return view('businessmanager.user.create', compact('role'    ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'mobile' => 'required|unique:users,mobile'
        ]);


        $active_agent = User::where('id', Auth::user()->id)->value('active_agent');
        $user = User::where('parent_id', Auth::user()->id)->where('status','1')->count();
        if($active_agent > $user){
            if ($request->role == 'agentmanager') {
                $parent_id = Auth::user()->id;
            } else {
                $parent_id = 0;
            }
            $user                   =       new User;
            $userDetail             =       new UserDetail;
            $user->status           =       1;
            $user->first_name       =       $request->first_name;
            $user->last_name        =       $request->last_name;
            $user->username         =       $request->username;
            $user->parent_id        =       $parent_id;
            $user->email            =       $request->email;
            $user->mobile           =       $request->mobile;
            $user->password         =       bcrypt($request->password);
            $user->actual_password  =       $request->password;
            $user->assignrole($request->role);
            $user->save();
            $user->id;
                
            $userDetail->user_id    =       $user->id;
            $userDetail->address    =       $request->address;
            $userDetail->company_name = $request->company_name;
            $userDetail->save();
            session()->flash('success', 'Agent created successfully');
            return redirect()->route('bmuser.index');
        }else{
            session()->flash('error', 'You have not permission to create user more than limit');
            return redirect()->route('bmuser.index');
        }
        
       
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $id = User::where('id', $id)->value('id');
        $row = User::find($id);
        $role = CommonClass::getRoleByBusinessManager();
        return view('businessmanager.user.edit', compact('row', 'role'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

        ]);
   
        $user = User::where('id', $id)->first();
        $userDetail = UserDetail::where('user_id', $id)->first();
        $user->status = 1;

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->assignrole($request->role);
        $user->save();
        $user->id;
        $userDetail->address = $request->address;
        $userDetail->company_name = $request->company_name;
        $userDetail->save();
        session()->flash('success', 'User update successfully');
        return redirect()->route('bmuser.index');
        
    }

    public function destroy($id)
    {
        //
    }

    public function updateWallet(Request $request){

      
       $user = User::findorfail($request->id);
      

        $AuthUserCredit         =    DB::table('users')->where('id', '=', Auth::user()->id)->value('wallet');
        $transAuthUserCredit    =    DB::table('users')->where('id', '=', Auth::user()->id)->value('transactional_wallet');
        if($AuthUserCredit < $request->amount){
            session()->flash('error', 'Your credit is low');
            return back();
        }else if($request->amount != 0){ 
            $remainingAuthBalance           =   $AuthUserCredit - $request->amount;
            $user->wallet += $request->amount;
            $user->save();
            $updateAuthUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingAuthBalance]);
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

        if($transAuthUserCredit < $request->transactional_wallet){
            session()->flash('error', 'Your credit is low');
            return back();
        }else if($request->transactional_wallet != 0){ 
            $remainingtransAuthBalance           =   $transAuthUserCredit - $request->transactional_wallet;
            $user->transactional_wallet += $request->transactional_wallet;
            $user->save();
            $updateAuthUserBalance = User::where('id',Auth::user()->id)->update(['transactional_wallet' => $remainingtransAuthBalance]);
            $resellertranscation                        =   new Transcation();
            $resellertranscation->user_id               =   Auth::user()->id;
            $resellertranscation->debit_amount          =   $request->transactional_wallet;
            $resellertranscation->credit_amount         =   0;
            $resellertranscation->remaining_amount      =   $remainingtransAuthBalance;
            $resellertranscation->save();
            
            $newtranscation                          =   new Transcation();
            $newtranscation->user_id                 =   $user->id;
            $newtranscation->debit_amount            =   0;
            $newtranscation->credit_amount           =   $request->transactional_wallet;
            $newtranscation->remaining_amount        =   $user->transactional_wallet;
            $newtranscation->Remarks                 =   "Transactional balance added";
            $newtranscation->save();
                
            session()->flash('success', 'Wallet update successfully');
            return back();
            
        }
    }

    public function statusUpdate(Request $request){
        $active_agent = User::where('id', Auth::user()->id)->value('active_agent');
        $user = User::where('parent_id', Auth::user()->id)->where('status','1')->count();
        //dd($request->id, $request->status, $active_agent, $user);
        if($request->status == 1){
            if($active_agent > $user){
                $user = User::findorfail($request->id);
                $user->status = $request->status;
                $user->save();
                return response()->json(['message' => 'Status updated successfully.']);
            }else{
                return response()->json(array('error'=> "You have not permission to create user more than limit"));
            }
        }else{
            $user = User::findorfail($request->id);
            $user->status = $request->status;
            $user->save();
            return response()->json(['message' => 'Status updated successfully.']);
        }
        
       
    }
}
