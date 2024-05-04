<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\UserDetail;
use Auth;
use Hash;
use DB;

class HomeController extends Controller

{
    public function index()
    {
        $new_date=date('Y-m-d');

        $superdistributors=$user=User::whereHas('roles', function($q){
            $q->where('name', 'superdistributor');
        })->get();

        $distributors=$user=User::whereHas('roles', function($q){
            $q->where('name', 'distributor');
        })->get();

        $retailers=$user=User::whereHas('roles', function($q){
            $q->where('name', 'retailer');
        })->get();
        $wallet_balance=Wallet::where('user_id',Auth::user()->id)->value('amount');
        $todays=WalletRequest::where('approver_id',Auth::user()->id)->where('status','2')->where('created_at', 'like', '%' . $new_date . '%')->sum('amount');
        return view('superadmin.home',compact('wallet_balance','todays','superdistributors','distributors','retailers'));
   
    }
   
    public function walletView()
    {
        // $user->user_id=Auth::user()->id;
        $user=User::whereHas('roles', function($q){
            $q->where('name', 'superdistributor');
        })->get();
        foreach($user as $r){
            $uid[]=$r->id;
        }
       $amount=WalletRequest::join('users','users.id','wallet_requests.user_id')->select([
        DB::raw('wallet_requests.id AS id'),
        ('users.name AS name'),
        ('users.email AS email'),
        ('wallet_requests.unique_id AS unique_id'),
        ('wallet_requests.amount AS amount'),
        ('wallet_requests.remark_of_rejection AS remark_of_rejection'),
        ('wallet_requests.status AS status'),
        ('wallet_requests.created_at AS created_at'),
    ])->whereIn('user_id', $uid)->get();
        return view('superadmin.wallet/walletview',compact('amount'));        
    }
        public function approve($uid)
        {
           
            $amount = WalletRequest::join('users','users.id','wallet_requests.user_id')->select([
                DB::raw('wallet_requests.id AS id'),
                ('users.name AS name'),
                ('users.email AS email'),
                ('wallet_requests.unique_id AS unique_id'),
                ('wallet_requests.amount AS amount'),
                ('wallet_requests.status AS status'),
                ('wallet_requests.created_at AS created_at'),
            ])->where('unique_id', $uid)->first();
            return view('superadmin.wallet/approve', compact('amount'));
        }
        public function requestUpdate(Request $request)
        {
            $uid=WalletRequest::where('unique_id',$request->uid)->value('id');
            $status=WalletRequest::where('unique_id',$request->uid)->value('status');
        if($status!='1'){
            $request->session()->flash('alert-danger', 'The request you upodating is already updated please check the same!');
            return back();
           }
        else
        {
            if($request->submit=='Approve'){
                $walletstore = WalletRequest::find($uid);
               

                $user_id=$walletstore->user_id;
                $amount=$walletstore->amount;
                $userid=Wallet::where('user_id',$user_id)->first();
                if($userid==NULL){
                    $wallet= new Wallet;
                    $wallet->company_id=Auth::user()->company_id;
                    $wallet->user_id=$user_id;
                    $wallet->amount=$amount;
                    $wallet->last_approved_by=Auth::user()->id;
                    $wallet->last_transaction_number=$walletstore->unique_id;
                    $wallet->save();
                }
                else{
                    $wallet= Wallet::where('user_id',$user_id)->where('company_id',Auth::user()->company_id)->first();
                    $wallet->amount=$userid->amount+$amount;
                    $wallet->last_approved_by=Auth::user()->id;
                    $wallet->last_transaction_number=$walletstore->unique_id;
                    $wallet->save();
                }
                $walletstore->approver_id=Auth::user()->id;
                $walletstore->status=2;
                $walletstore->save();
                $request->session()->flash('alert-success', 'Thank you for your Intrest!');
                return redirect('superadmin/walletview');
              }
              if($request->submit=="Reject")
              {
                $this->validate($request, [
                    'remark'=>'required',
                ]);
                $walletstore = WalletRequest::find($uid);
                $walletstore->approver_id=Auth::user()->id;
                $walletstore->status =3;
                $walletstore->remark_of_rejection = $request->remark;
                $walletstore->save();      
                $request->session()->flash('alert-success', 'Thank you for your Intrest!');
                return redirect('superadmin/walletview');
              }
        }
        
        }

        public function user_maping(Type $var = null)
        {
            return view('superadmin.user_maping.user_maping');
        }
    
        
    public function superadminprofile(){
        return view('superadmin.profile');
    }
    
    public function superadminupdateprofile(Request $request){
        $this->validate($request, [
           'name' => 'required',
           'last_name' => 'required',
           'phone_no' => 'required',
           'dob' => 'required',
           'address' => 'required',
           'city' => 'required',
           'state' => 'required',
           'pincode' => 'required',
           'pan_no' => 'required',
           'bank_name' => 'required',
           'account_holder_name' => 'required',
           'ifsc_code' => 'required',
           'cheque' => 'required',
           'aadhar_no' => 'required',

       ]);
       $id=Auth::user()->id;
       $user=User::find($id);
       $user->name=$request->name;
       $user->last_name=$request->last_name;
       $user->reference_id=referenceid();
       $user->save();

       $userdetails_id=UserDetail::where('user_id',$user->id)->value('id');
       $user_detail =UserDetail::find($userdetails_id);
   $user_detail->user_id=$user->id;
   $user_detail->phone_no=$request->phone_no;
   $user_detail->dob=$request->dob;
   $user_detail->address=$request->address;
   $user_detail->city=$request->city;
   $user_detail->state=$request->state;
   $user_detail->pincode=$request->pincode;
   $user_detail->pan_no=$request->pan_no;
   $user_detail->bank_name=$request->bank_name;
   $user_detail->account_holder_name=$request->account_holder_name;
   $user_detail->ifsc_code=$request->ifsc_code;
   $user_detail->aadhar_no=$request->aadhar_no;
   if ($request->hasFile('cheque')) {
    $image = $request->file('cheque');
    $filename = $image->getClientOriginalName();
    $destinationPath = public_path('uploads/cheque');
    $image->move($destinationPath, $filename);
    $user_detail->cheque= "uploads/cheque/" . $filename;
}
   $user_detail->save(); 

         session()->flash('success_msg', 'Updated Successfully ');
       return redirect('superadmin/superadminprofile');
   }

   public function superadminpassword(){
    return view('superadmin.passwordchange');
}

public function superadminupdatepassword(Request $request){
  $this->validate($request, [
      'oldpassword'=>'required',
      'password'=>'required|min:6|confirmed',
  ]);
  $user=Auth::user();
  $oldpassword=$user->password;
  if(Hash::check($request->oldpassword,$oldpassword)){
      $user->fill([
          'password'=>bcrypt($request->password)
      ])->save();
      session()->flash('success_msg','Password has been Updated');
      return back();
  }
  else{
      session()->flash('danger_msg','Please Enter correct Old Password');
      return back();
  }
}
}
