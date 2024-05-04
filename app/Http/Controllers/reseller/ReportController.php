<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\User;
use App\Models\Sound;
use Auth,DB;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        if ($request->paginate) {
            $paginate = $request->paginate;
        } else {
            $paginate = 10;
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
        $search = $request->search;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $userIds = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        $userIds[] = Auth::user()->id;
        $campaign = $campaign = Campaign::whereIn('user_id',$userIds)->select('*', \DB::raw('
    (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 1) AS deliverCount,
    (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 0) AS notDeliverCount,(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id) AS created_by'));
    if ($startDate != null && $endDate != null) {
        $campaign = $campaign->where(function ($query) use ($startDate,$endDate) {
        $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
    });
}
    if ($search) {
        $campaign = $campaign->where(function ($query) use ($search) {
        $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',total_count)"), 'LIKE', '%' . $search . '%')
            ->orWhere(DB::raw('(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id)'), 'LIKE', '%' . $search . '%');
    });
}
    if ($request->user != null) {
        $userid =$request->user;
        if(is_null(User::where('parent_id', Auth::user()->id)->where('id',$userid)->first())){
            $userid = 0;
        }
        $campaign = $campaign->where(function ($query) use ($userid) {
        $query->where('user_id', $userid);
    });
}
$campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
$user = User::where('parent_id', Auth::user()->id)->get();
return view('reseller.report.allcampaign', compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by','startDate','endDate','user'));
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
