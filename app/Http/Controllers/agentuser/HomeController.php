<?php

namespace App\Http\Controllers\agentuser;

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
       
        return view('agentuser.home');
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

    public function agentuserprofile(){
        return view('agentuser.profile');
    }
    
    public function agentuserupdateprofile(Request $request){
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
        return redirect('agentuser/agentuserprofile');
   }


   public function agentuserpassword(){
    return view('agentuser.passwordchange');
}

public function agentuserupdatepassword(Request $request){
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

     $answered = $data->sum('success_count');
     $notanswered = $data->sum('failed_count');
    return response()->json([
        'campaign'=>$data->count(),
        'answered' =>$answered,
        'notanswered'=>$notanswered
    ]);
}
}

