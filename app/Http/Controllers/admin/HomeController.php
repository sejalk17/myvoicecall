<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletRequest;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Wallet;
use App\Models\UserDetail;
use App\Models\BillDetail;
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
         $from = Carbon::now()->startOfMonth();
        $to = Carbon::now();
        $new_date = date('Y-m-d');

        $superdistributors = $user = User::whereHas('roles', function ($q) {
            $q->where('name', 'superdistributor');
        })->get();

        $distributors = $user = User::whereHas('roles', function ($q) {
            $q->where('name', 'distributor');
        })->get();

        $retailers = $user = User::whereHas('roles', function ($q) {
            $q->where('name', 'retailer');
        })->get();

           
        //     $campaign = Campaign::select('*', \DB::raw('
        //     (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 1) AS deliverCount,
        //     (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 0) AS notDeliverCount
        // '))->orderBy('id','DESC')->take(5)->get();
        
        $campaign = Campaign::select('*')->orderBy('id','DESC')->take(5)->get();
 
        return view('admin.home', compact('campaign'));
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
    public function approve($uid)
    {
        $amount = WalletRequest::join('users', 'users.id', 'wallet_requests.user_id')->select([
            DB::raw('wallet_requests.id AS id'),
            ('users.name AS name'),
            ('users.email AS email'),
            ('wallet_requests.unique_id AS unique_id'),
            ('wallet_requests.amount AS amount'),
            ('wallet_requests.status AS status'),
            ('wallet_requests.created_at AS created_at'),
        ])->where('unique_id', $uid)->first();
        return view('admin.wallet/approve', compact('amount'));
    }
    public function requestUpdate(Request $request)
    {
        $input = $request->all();

        $uid = WalletRequest::where('unique_id', $request->uid)->value('id');
        $status = WalletRequest::where('unique_id', $request->uid)->value('status');
        $walletstore = WalletRequest::find($uid);


        $user_id = $walletstore->user_id;
        $amount = $walletstore->amount;
        if ($status != '1') {
            $request->session()->flash('alert-danger', 'The request you updating is already updated please check the same!');
            return back();
        } else {
            if ($request->submit == 'Approve') {

                $userid = Wallet::where('user_id', $user_id)->first();
                if ($userid == NULL) {

                    $wallet = new Wallet;
                    $wallet->company_id = Auth::user()->company_id;
                    $wallet->user_id = $user_id;
                    $wallet->amount = $amount;
                    $wallet->last_approved_by = Auth::user()->id;
                    $wallet->last_transaction_number = $walletstore->unique_id;
                    $wallet->save();
                    $notification = new Notification;
                    $notification->user_id = $user_id;
                    $notification->description = "Amount request is approved of Rs- " . $amount;
                    $notification->created_by = Auth::user()->id;
                    $notification->status = 1;
                    $notification->save();
                } else {
                    $wallet = Wallet::where('user_id', $user_id)->where('company_id', Auth::user()->company_id)->first();
                    $wallet->amount = $userid->amount + $amount;
                    $wallet->last_approved_by = Auth::user()->id;
                    $wallet->last_transaction_number = $walletstore->unique_id;
                    $wallet->save();
                    $notification = new Notification;
                    $notification->user_id = $user_id;
                    $notification->description = "Amount request is approved of Rs- " . $amount;
                    $notification->created_by = Auth::user()->id;
                    $notification->status = 1;
                    $notification->save();
                }
                $walletstore->approver_id = Auth::user()->id;
                $walletstore->status = 2;
                $walletstore->save();
                $request->session()->flash('alert-success', 'Thank you for your Intrest!');
                return redirect('admin/walletview');
            }
            if ($request->submit == "Reject") {
                $this->validate($request, [
                    'remark' => 'required',
                ]);
                $walletstore = WalletRequest::find($uid);
                $walletstore->approver_id = Auth::user()->id;
                $walletstore->status = 3;
                $walletstore->remark_of_rejection = $request->remark;
                $walletstore->save();
                $notification = new Notification;
                $notification->user_id = $user_id;
                $notification->description = "Amount request is rejected of Rs. " . $amount . " because of the remark - " . $request->remark;
                $notification->created_by = Auth::user()->id;
                $notification->status = 1;
                $notification->save();

                $request->session()->flash('alert-success', 'Thank you for your Intrest!');
                return redirect('admin/walletview');
            }
        }
    }

    public function adminprofile()
    {
        return view('admin.profile');
    }

    public function adminupdateprofile(Request $request)
    {
        $input = $request->all();
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
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->save();

        $userdetails_id = UserDetail::where('user_id', $user->id)->value('id');
        $user_detail = UserDetail::find($userdetails_id);
        $user_detail->user_id = $user->id;
        $user_detail->phone_no = $request->phone_no;
        $user_detail->dob = $request->dob;
        $user_detail->address = $request->address;
        $user_detail->city = $request->city;
        $user_detail->state = $request->state;
        $user_detail->pincode = $request->pincode;
        $user_detail->pan_no = $request->pan_no;
        $user_detail->bank_name = $request->bank_name;
        $user_detail->account_holder_name = $request->account_holder_name;
        $user_detail->ifsc_code = $request->ifsc_code;
        $user_detail->aadhar_no = $request->aadhar_no;
        if ($request->hasFile('cheque')) {
            $image = $request->file('cheque');
            $filename = $image->getClientOriginalName();
            $destinationPath = public_path('uploads/cheque');
            $image->move($destinationPath, $filename);
            $user_detail->cheque = "uploads/cheque/" . $filename;
        }
        $user_detail->save();

        session()->flash('success_msg', 'Updated Successfully ');
        return redirect('admin/adminprofile');
    }

    public function adminpassword()
    {
        return view('admin.passwordchange');
    }

    public function adminupdatepassword(Request $request)
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
            session()->flash('success_msg', 'Password has been Updated');
            return back();
        } else {
            session()->flash('danger_msg', 'Please Enter correct Old Password');
            return back();
        }
    }
 
    public function reports()
    {
        return view('admin.report.allreports');
    }

    public function reportdata()
    {
        $retailer = User::whereHas('roles', function ($q) {
            $q->where('name', 'retailer');
        })->where('company_id', Auth::user()->company_id)
            ->pluck('name', 'id')->toArray();

        return view('admin.report.billreport', compact('retailer'));
    }


   

}
