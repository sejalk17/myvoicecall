<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Plan;
use App\Models\Userwiseplan;
use App\Models\Campaigndata;
use App\Models\Campaign;
use App\Models\UserDetail;
use App\Models\TimeFreeze;
use App\Models\AmountLimit;
use Illuminate\Support\Carbon;
use Auth;
use Hash;
use DB;
class HomeController extends Controller
{
    public function index()
    {
        $currentDate        =   Carbon::now();
        $timestamp          =   $currentDate->timestamp;
        $planId             =   User::where('id', Auth::user()->id)->value('user_plan');
        if($planId != 0){
            $userdate = Userwiseplan::select('id', 'end_date','status')
            ->where('user_id', Auth::user()->id)
            ->first();
            if ($userdate && $userdate->end_date < now() && $userdate->status=="0") {
                    $userupdate = Userwiseplan::where('user_id', Auth::user()->id)->update(['status' => '1', 'usasage' => '0']);         
                    $userupdate = User::where('id', Auth::user()->id)->update(['wallet' => '0']);         
            
                    $campaign = Campaign::where('user_id',Auth::user()->id)->orderBy('id','DESC')->take(5)->get();
                    return redirect('user/home');
            }
            else{
                $new_date=date('Y-m-d');       
                $campaign = Campaign::where('user_id',Auth::user()->id)->take(5)->get();
                return view('user.home', compact('campaign'));
            }
            
            $plan                       =       Plan::where('id', $planId)->first();
            $dailymsg                   =       $plan->daily_msg;
            $updateTime = Userwiseplan::select('id', 'user_id', 'usasage', 'updated_at')
            ->where('user_id', Auth::user()->id)
            ->first();
            if ($updateTime && !$currentDate->isSameDay($updateTime->updated_at)) {
                $newUsage = $dailymsg;
                Userwiseplan::where('id', $updateTime->id)
                    ->update([
                        'usasage' => $newUsage,
                        'updated_at' => $currentDate,
                    ]); 
                $da =  User::where('id',Auth::user()->id)
                    ->update([
                        'wallet'=>$dailymsg
                    ]);
                    $new_date=date('Y-m-d');       
                    $campaign = Campaign::where('user_id',Auth::user()->id)->orderBy('id','DESC')->take(5)->get();
                return redirect('user/home');
            }else{
                $new_date=date('Y-m-d');       
            $campaign = Campaign::where('user_id',Auth::user()->id)->take(5)->get();
            return view('user.home', compact('campaign'));
            }
        }else{
            $new_date=date('Y-m-d');       
            $campaign = Campaign::where('user_id',Auth::user()->id)->take(5)->get();
            return view('user.home', compact('campaign'));
        }
    }
    public function wallet_request()
    {
        $amount=WalletRequest::orderBy('id','DESC')->where('user_id',Auth::user()->id)->get();
        return view('user/wallet/wallet_request',compact('amount'));
    }
    public function walletstore(Request $request)
    {
        $this->validate($request, [
			'amount'=>'required|lt:10001',
        ]);
            $walletstore = new WalletRequest;
            $walletstore->amount = $request->amount;
            $walletstore->user_id=Auth::user()->id;
            $walletstore->company_id=Auth::user()->company_id;
            $walletstore->status =1;
            $walletstore->remark_of_rejection = $request->remark_of_rejection;
            $walletstore->unique_id=uniqid();
            $walletstore->save();      
            $request->session()->flash('alert-success', 'Thank you for your Intrest!');
            return back();
    }

    public function userprofile(){
        return view('user.profile');
    }
    
    public function userupdateprofile(Request $request){
   // dd($request->all());
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
           /* 'dob' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'pan_no' => 'required',
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'ifsc_code' => 'required',
            'cheque' => 'required',
            'aadhar_no' => 'required', */
 
        ]);
        $id=Auth::user()->id;
        $user=User::find($id);
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
    $user->mobile=$request->mobile;
        $user->save();
 
        $userdetails_id=UserDetail::where('user_id',$id)->value('id');
        $user_detail =UserDetail::find($userdetails_id);
    $user_detail->address=$request->address;
    $user_detail->company_name=$request->company_name;
    if ($request->hasFile('logo_image')) {
     $image = $request->file('logo_image');
     $filename = $image->getClientOriginalName();
     $destinationPath = public_path('uploads/cheque');
     $image->move($destinationPath, $filename);
     $user_detail->logo_image= "uploads/cheque/" . $filename;
 }
    $user_detail->save(); 
 
          session()->flash('success_msg', 'Updated Successfully ');
        return redirect('user/userprofile');
   }


   public function userpassword(){
    return view('user.passwordchange');
}

public function userupdatepassword(Request $request){
  $this->validate($request, [
      'oldpassword'=>'required',
      'password'=>'required|min:6|confirmed',
  ]);
  $user=Auth::user();
  $oldpassword=$user->password;
  if(Hash::check($request->oldpassword,$oldpassword)){
      $user->fill([
          'password'=>bcrypt($request->password),
          'actual_password' => $request->password,
      ])->save();
      session()->flash('success_msg','Password has been Updated');
      return back();
  }
  else{
      session()->flash('danger_msg','Please Enter correct Old Password');
      return back();
  }
}



public function filterDateBase(Request $request){
    $startDate      =   date('Y-m-d',strtotime($request->start));
    $endDate        =   date('Y-m-d',strtotime($request->end));
  
    $data = Campaign::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->where('user_id', auth()->user()->id)->get();
    $dataCount = Campaign::selectRaw('(success_count * voice_credit) as multiplied_value')
                 ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
                 ->where('user_id', auth()->user()->id)
                 ->get()
                 ->sum('multiplied_value');

     $answered = $data->sum('success_count');
     $notanswered = $data->sum('failed_count');
    return response()->json([
        'campaign'=>$data->count(),
        'answered' =>$answered,
        'notanswered'=>$notanswered,
        'answeredCreditCount'=>$dataCount
    ]);
}
}

