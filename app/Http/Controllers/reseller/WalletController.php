<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transcation;
use Auth,DB;
class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $opening =0;
        $cloesing =0;
        if ($request->paginate) {
            $paginate = $request->paginate;
        } else {
            $paginate = 20;
        }
        if ($request->sort_f) {
            $sort_f = $request->sort_f;
        } else {
            $sort_f = 'id';
        }
        if ($request->sort_by) {
            $sort_by = $request->sort_by;
        } else {
            $sort_by = 'ASC';
        }
        $search                 =   $request->search;
        $user                   =   User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        $user[]                 =   Auth::user()->id;
        $wallet                 =   User::where('id',Auth::user()->id)->value('wallet');
       // $transactional_wallet   =   User::where('id',Auth::user()->id)->value('transactional_wallet');

        //$transcation            =   Transcation::whereIn('user_id',$user)->select('*',\DB::raw('(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = transcations.user_id) AS created_by'));

        $transcation = Transcation::where('user_id', Auth::user()->id)->where('credit_amount','!=',0)->get();


        $startDate = $request->start_date;
        $endDate = $request->end_date;
       
    if ($startDate != null && $endDate != null) {
        $transcation = $transcation->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
}


if ($request->user != null) {
        $userid =$request->user;
        if(is_null(User::where('parent_id', Auth::user()->id)->where('id',$userid)->first()) && $userid != Auth::user()->id){
            $userid = 0;
        }
       
        $transcation = $transcation->where(function ($query) use ($userid) {
        $query->where('user_id', $userid);
    });
       $data = $transcation;
        if($data->first()){
           $data = $data->first();
        if($data->debit_amount != 0){
        $opening = $data->debit_amount+$data->remaining_amount;
        }else{
            $opening = $data->remaining_amount;
        }
        $cloesing = $data->orderBy('id','desc')->value('remaining_amount');
    }
}

        if(strpos(strtolower($search), 'promotional') !== false){
            $transcation = $transcation->where('transcation_type',1);
        } elseif(strpos(strtolower($search), 'transactional') !== false){
            $transcation = $transcation->where('transcation_type', 2);
        }else{
        
        if ($search) {
            $transcation = $transcation->where(function ($query) use ($search) {
        $query->orWhere(DB::raw('(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = transcations.user_id)'), 'LIKE', '%' . $search . '%');
    });
}
        }
if ($request->user != null) {
        $userid =$request->user;
        if(is_null(User::where('parent_id', Auth::user()->id)->where('id',$userid)->first())){
            $userid = 0;
        }
        $transcation = $transcation->where(function ($query) use ($userid) {
        $query->where('user_id', $userid);
    });
}
        $transcation = $transcation->orderBy($sort_f, $sort_by)->paginate($paginate);
        if ($request->ajax()) {
       
  
        $view = view('reseller.wallet.scroll_data', compact('transcation'))->render();
             return response()->json(['html' => $view]);
        }
        $user = User::where('parent_id', Auth::user()->id)->get();
        return view('reseller.wallet.index', compact('wallet', 'transcation', 'paginate', 'search', 'sort_f', 'sort_by','user','startDate','endDate','cloesing','opening'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
