<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\UserDetail;
use App\Models\Userwiseplan;
use App\Models\BillDetail;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Notification;
use Yajra\DataTables\DataTables;
use Auth;
use Hash;
use DB;
use Session;
use Carbon\Carbon;
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
            
                    $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
                    $user[] = Auth::user()->id;     
                    $campaign = Campaign::whereIn('user_id',$user)->orderBy('id','DESC')->take(5)->get();
                    return redirect('reseller/home');
            }
            else{
                $new_date=date('Y-m-d');       
                $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
                $user[] = Auth::user()->id;     
                $campaign = Campaign::whereIn('user_id',$user)->orderBy('id','DESC')->take(5)->get();
                return view('reseller.home', compact('campaign'));
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
                    $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
                $user[] = Auth::user()->id;     
                $campaign = Campaign::whereIn('user_id',$user)->orderBy('id','DESC')->take(5)->get();
                return redirect('reseller/home');
            }else{
                $new_date=date('Y-m-d');       
                $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
                $user[] = Auth::user()->id;     
                $campaign = Campaign::whereIn('user_id',$user)->orderBy('id','DESC')->take(5)->get();
            return view('reseller.home', compact('campaign'));
            }
        }else{
            $new_date=date('Y-m-d');  
            $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
            $user[] = Auth::user()->id;     
            $campaign = Campaign::whereIn('user_id',$user)->orderBy('id','DESC')->take(5)->get();
            
            return view('reseller.home', compact('campaign'));
        }
        

    //     $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
    //     $user[] = Auth::user()->id;
    //     $campaign = Campaign::whereIn('user_id',$user)->select('*', \DB::raw('
    //      (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 1) AS deliverCount,
    //      (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 0) AS notDeliverCount
    //  '))->orderBy('id','desc')->take(5)->get();
    //     return view('reseller.home',compact('campaign'));
    }

    public function walletView()
    {
        // $user->user_id=Auth::user()->id;
        $user = User::whereHas('roles', function ($q) {
            $q->where('name', 'superdistributor');
        })->get();
        foreach ($user as $r) {
            $uid[] = $r->id;
        }
        $amount = WalletRequest::join('users', 'users.id', 'wallet_requests.user_id')->select([
            DB::raw('wallet_requests.id AS id'),
            ('users.name AS name'),
            ('users.email AS email'), 
            ('wallet_requests.unique_id AS unique_id'),
            ('wallet_requests.amount AS amount'),
            ('wallet_requests.remark_of_rejection AS remark_of_rejection'),
            ('wallet_requests.status AS status'),
            ('wallet_requests.created_at AS created_at'),
        ])->whereIn('user_id', $uid)->get();
        return view('admin.wallet/walletview', compact('amount'));
    }
   

    public function resellerprofile()
    {
        return view('reseller.profile'); 
    }

    public function resellerupdateprofile(Request $request)
    {
        $input = $request->all();
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
 
          session()->flash('success', 'Updated Successfully ');
        return redirect('reseller/resellerprofile');
    }

    public function resellerpassword()
    {
        return view('reseller.passwordchange');
    }

    public function resellerupdatepassword(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = Auth::user();
        $oldpassword = $user->password;
        if (Hash::check($request->oldpassword, $oldpassword)) {
            $user->fill([
                'password' => bcrypt($request->password)
            ])->save();
            session()->flash('success', 'Password has been Updated');
            return back();
        } else {
            session()->flash('error', 'Please Enter correct Old Password');
            return back();
        }
    }

  

    public function uploadprocessed()
    {
        return view('reseller.uploadprocessed');
    }

   


    public function filterDateBase(Request $request){
    

    $startDate = date('Y-m-d',strtotime($request->start));
$endDate = date('Y-m-d',strtotime($request->end));
    $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        $user[] = Auth::user()->id;
        //$campaign = Campaign::whereIn('user_id',$user)->get();
        
        $data = Campaign::whereIn('user_id',$user)->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->orderBy('id','desc')->get();
        $answered = $data->sum('success_count');
        $notanswered = $data->sum('failed_count');
        return response()->json([
            'campaign'=>$data->count(),
            'answered' =>$answered,
            'notanswered'=>$notanswered
        ]);
}

}
