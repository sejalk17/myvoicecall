<?php

namespace App\Http\Controllers\reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\CommonClass;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\Campaignoldata;
use App\Models\User;
use App\Models\Sound;
use Illuminate\Support\Carbon;
use Auth,DB;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $reseller = User::where('status',1)->where('parent_id',Auth::user()->id)->whereHas('roles', function($q){
            $q->where('name','reseller');
        })->get();

       


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
            $sort_by = 'DESC';
        }
        $search = $request->search;
        if($request->user){
             $user = User::where('parent_id', $request->user)->pluck('id')->toArray();
        }else{
            $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        }

        
        $user[] = Auth::user()->id;
        $campaign = $campaign = Campaign::whereIn('user_id',$user)->select('*', \DB::raw('
    (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 1) AS deliverCount,
    (SELECT COUNT(*) FROM campaigndatas WHERE campaign_id = campaigns.id AND status = 0) AS notDeliverCount,(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id) AS created_by'));
    if ($search) {
        $campaign = $campaign->where(function ($query) use ($search) {
        $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',total_count)"), 'LIKE', '%' . $search . '%')
            ->orWhere(DB::raw('(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id)'), 'LIKE', '%' . $search . '%');
    });
}
$campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('reseller.campaign.index', compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by', 'reseller'));
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userData = User::where('parent_id', Auth::user()->id)->select('id','first_name','last_name')->get();

        $soundType = CommonClass::getSoundsType();
        
        $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        $user[] = Auth::user()->id;
        $soundList = Sound::select('id', 'name')->whereIn('user_id',$user)->get();
        //return view('reseller.campaign.create', compact('soundType','soundList','userData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $userCredit   = DB::table('users')->where('id', '=', $request->user_id)->value('wallet');
        $userPlanType = DB::table('user_details')->where('user_id', '=', $request->user_id)->value('plan_type');
        $voiceDuration   = DB::table('sounds')->where('id', '=',$request->voiceclip )->value('duration');
        $needChargePerRecord                =   ceil($voiceDuration / $userPlanType);
        $destinationPath                    =   public_path('uploads/csv');
        if ($request->hasFile('excel_file_upload')) {
            $csvFile                        =   $request->file('excel_file_upload');
            $filename                       =   $csvFile->getClientOriginalName().'_'.time().'_'.Auth::user()->id;
            $csvFile->move($destinationPath, $filename);
            $file_path                      =   $destinationPath.'/'.$filename;
            $linecount                      =   count(file($file_path))-1  ;
            $totalChargePerCsv              =   $linecount * $needChargePerRecord;
            if($userCredit < $totalChargePerCsv){
                Session::flash('error', 'Your credit is low so please contact to you reseller');
                return redirect()->route('resellercampaign.index');
            }else{
                $remainingBalance           =   $userCredit - $totalChargePerCsv;
                $campaigntype               =    0;
                $schedule_datetime          =    '';
                $campaign                   =    new Campaign;
                $campaign->service_no       =    $request->service_no;
                $campaign->campaign_name    =    $request->campaign_name;
                $campaign->total_count      =    $request->linecount;
                $campaign->user_id          =    Auth::user()->id;
                $campaign->camp_type        =    $request->type;
                if($request->type == 'transactional'){
                    $campaigntype           =   4;
                }else if($request->type == 'promotional'){
                $campaigntype               =   3;
                }
                $campaign->voiceclip        =    $request->voiceclip;
                $campaign->retry_attempt    =    $request->retry_attempt;
                $campaign->retry_duration   =    $request->retry_duration;
                $campaign->schedule         =    $request->schedule;
                
                if($request->schedule == 1){
                    $campaign->schedule_datetime          =    date('Y-m-d h:m:s',strtotime($request->schedule_datetime)); 

                    $schedule_datetime                    =     date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
                }
                $campaign->save();
                

                $campaignNew                        =   Campaign::find($campaign->id);
                $campaignNew->excel_file_upload     =   "uploads/csv/" . $filename;
                $campaignNew->save();
                $file                               =   fopen($file_path, "r");
                $i                                  =   0;
                $msisdn                             =   array();
                $insert_data                        =   [];

                $transcation                        =   new Transcation();
                $transcation->user_id               =   Auth::user()->id;
                $transcation->debit_amount          =   $totalChargePerCsv;
                $transcation->credit_amount         =   0;
                $transcation->remaining_amount      =   $remainingBalance;
                $transcation->save();
                $updateUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingBalance]);
                    
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num                            =   count($filedata);
    
                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                        $phoneNumber =  $filedata[$c];
                        if(preg_match($mobileregex, $phoneNumber) === 1){
                            $msisdn[]               = ''.$phoneNumber.'';
    
                            $data = [
                                'user_id'                   =>  Auth::user()->id,
                                'campaign_id'               =>  $campaign->id,
                                'lead_id'                   =>  '', 
                                'lead_name'                 =>  '', 
                                'cli'                       =>  $request->service_no,
                                'mobile_no'                 =>  $phoneNumber,
                                'retry_attempt'             =>  $request->retry_attempt,
                                'retry_duration'            =>  $request->retry_duration,
                                'call_duration'             => '',
                                'status'                    => 0,
                                'call_start_ts'             => '',
                                'call_connect_ts'           => '',
                                'call_end_ts'               => '',
                                'body'                      => '',
                                'call_uuid'                 => 0,
                                'created_at'                => date('Y-m-d H:i:s'),
                                'updated_at'                => date('Y-m-d H:i:s'),
                            ];
                            $insert_data[]             =    $data;
                            }
                    }
                    $i++;
                }
        
                $insert_data = collect($insert_data); // Make a collection to use the chunk method
                $chunks = $insert_data->chunk(500);
    
                
                foreach ($chunks as $chunk)
                {
                    DB::table('campaigndatas')->insert($chunk->toArray());
                }
                    
                // $callResponse = CommonClass::sendVoiceCall($request->service_no,$campaigntype,$request->retry_attempt,$request->retry_duration, $request->schedule, $schedule_datetime, $msisdn);
                // $callResponseDecode = json_decode($callResponse,true);
                // if(isset($callResponseDecode) && $callResponseDecode['leadid'] && $callResponseDecode['refno']){
                //     $campainData = Campaigndata::where('campaign_id',$campaign->id)->update(['lead_id' => $callResponseDecode['leadid']]);
                //     if($callResponseDecode['refno']){
                //         foreach($callResponseDecode['refno'] as $data){
                //             foreach($data as $key => $value){
                //                 $campainData = Campaigndata::where('campaign_id',$campaign->id)->where('mobile_no',$key)->update(['refno' => $value]);
                //             }
                //         }
                //     }
                // } 
                fclose($file);
                Session::flash('success', 'Campaign created successfully');
                return redirect()->route('resellercampaign.index');
                
            }
            
        }else{
            Session::flash('error', 'Upload file error');
            return redirect()->route('resellercampaign.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
        //$campaigndata = Campaigndata::where('campaign_id', $id);
        $campaign = Campaign::where('id',$id)->first();
        $campaignDate   =   $campaign->created_at;
        $campaignDate1days = Carbon::parse($campaign->created_at)->addDays(1);
        if(date('Y-m-d') == date('Y-m-d', strtotime($campaign->created_at))){
            $campaigndata = Campaigndata::where('campaign_id', $id); 
        }else{
            $campaigndata = Campaignoldata::where('campaign_id', $id)->whereDate('created_at', $campaignDate1days); 
        }

        $search = $request->search;
        if($search == 'answered'){
            $campaigndata = $campaigndata->Where('status',"1");
        } elseif($search == 'not answered'){
            $campaigndata = $campaigndata->orWhere('status', '=', 0);
        }
        
        if ($search) {
            $campaigndata = $campaigndata->where(function ($query) use ($search) {
        $query->where(DB::raw("CONCAT(created_at,' ',mobile_no,' ',cli,' ',call_duration,' ',call_remarks)"), 'LIKE', '%' . $search . '%');
    });
}
       

        $campaigndata = $campaigndata->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('reseller.campaign.view', compact('campaigndata', 'paginate', 'search', 'sort_f', 'sort_by'));
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
