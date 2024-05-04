<?php

namespace App\Http\Controllers\admin;

use App\helpers\CommonClass;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\Campaignoldata;
use App\Models\Transcation;
use App\Models\Sound;
use App\Models\Ukey;
use App\Models\Channel;
use App\Models\SpeedData;
use App\Models\VipNumber;
use App\Models\User;
use App\Models\CampaignMonthUpload;
use Illuminate\Http\Request;
use App\Exports\CampaignExportClass;
use Auth,DB,Session;
use App\Jobs\CampaignJob;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Sheet;
use App\Imports\YourImport;
use Illuminate\Support\Carbon;
use App\Exports\CampaignCreateExcelClass;

class CampaignController extends Controller
{
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
            $sort_by = 'DESC';
        }
        $search = $request->search;
        $campaign = Campaign::select('*', \DB::raw('
        (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id) AS created_by' ));
   
        if ($search) {
            $campaign = $campaign->where(function ($query) use ($search) {
            $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',total_count)"), 'LIKE', '%' . $search . '%')
                ->orWhere(DB::raw('(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id)'), 'LIKE', '%' . $search . '%');
            });
        }
        $campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('admin.campaign.index', compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by'));
    }

    public function create()
    {
        $planType = CommonClass::getPlanType();
        $soundType = CommonClass::getSoundsType();
        $soundList = Sound::select('id', 'name')->get();
        $ukey = Ukey::where('status', "1")->get();
        return view('admin.campaign.create', compact('soundType', 'soundList','ukey','planType'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
        $serivceNo = Ukey::where('id',$request->ukey)->value('landline');
        if($request->upload_type == 'csv'){
        $userPlanType = $request->plan_type;
        $voiceDuration   = DB::table('sounds')->where('id', '=',$request->voiceclip)->value('duration');
        $needChargePerRecord                =   ceil($voiceDuration / $userPlanType);
        $destinationPath                    =   public_path('uploads/csv');
        if ($request->hasFile('excel_file_upload')) {
            $csvFile                        =   $request->file('excel_file_upload');
            $filename                       =   $csvFile->getClientOriginalName().'_'.time().'_'.Auth::user()->id;
            $csvFile->move($destinationPath, $filename);
            $file_path                      =   $destinationPath.'/'.$filename;
            $linecount                      =   count(file($file_path))-1  ;
            $totalChargePerCsv              =   $linecount * $needChargePerRecord;
           
            $campaigntype                   =    0;
            $schedule_datetime              =    '';
            $campaign                       =    new Campaign;
            $campaign->service_no           =    $serivceNo;
            $campaign->campaign_name        =    $request->campaign_name;
            $campaign->total_count          =    $linecount;
            $campaign->voice_credit         =    $needChargePerRecord;
            $campaign->user_id              =    Auth::user()->id;
            $campaign->camp_type            =    $request->type;
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
                $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
            }
            $campaign->save();
            $campaignNew                        =   Campaign::find($campaign->id);
            $campaignNew->excel_file_upload     =   "uploads/csv/" . $filename;
            $campaignNew->save();
            $file                               =   fopen($file_path, "r");
            $i                                  =   0;
            //$msisdn                             =   array();
            $insert_data                        =   [];

            $transcation                        =   new Transcation();
            $transcation->user_id               =   Auth::user()->id;
            $transcation->debit_amount          =   $totalChargePerCsv;
            $transcation->credit_amount         =   0;
            $transcation->remaining_amount      =   0;
            $transcation->save();
                
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num                            =   count($filedata);

                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                    $phoneNumber =  $filedata[$c];
                    if(preg_match($mobileregex, $phoneNumber) === 1){
                        //$msisdn[]               = ''.$phoneNumber.'';

                        $data = [
                            'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                            'user_id'                   =>  Auth::user()->id,
                            'campaign_id'               =>  $campaign->id,
                            'lead_id'                   =>  '', 
                            'lead_name'                 =>  '', 
                            'cli'                       =>  $serivceNo,
                            'mobile_no'                 =>  $phoneNumber,
                            'retry_attempt'             =>  $request->retry_attempt,
                            'retry_duration'            =>  $request->retry_duration,
                            'call_duration'             => '',
                            'call_credit'               =>  $needChargePerRecord,
                            'actual_status'             => 0,
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

            $voice_path = str_replace('uploads/soundclip/','',Sound::where('id',$request->voiceclip)->value('voiceclip'));
            foreach ($chunks as $chunk)
            {
                DB::table('campaigndatas')->insert($chunk->toArray());
                $msisdn                             =   array();
                foreach($chunk as $singleData){
                    $msisdn[]               = ''.$singleData["mobile_no"].'';
                }
                
                if($request->apiProvider == 'Videocon'){
                    $numberData = implode(",",$msisdn);
                    $ukey = Ukey::find($request->ukey);
                    if($ukey != null){
                        $username   = $ukey->username;
                        $password   = $ukey->ukey;
                    }else{
                        $username = "amitgoyal";
                        $password = "123123";
                    }
                    $dataValue = [
                                "UserName"          => $username,
                                "Password"          => $password,
                                "TransitionId"      => "12345",
                                "VoiceId"           => Sound::where('id',$request->voiceclip)->value('voice_id'),
                                "CampaignData"      => $numberData,
                                "OBD_TYPE"          => "SINGLE_VOICE",
                                "DTMF"              => "0",
                                "CALL_PATCH_NO"     => "0",
                                "RETRY_COUNT"       => $request->retry_attempt,
                                "RETRY_INTERVAL"    => 0,
                            ];
                    $connn = new CampaignApiCallJob($dataValue,$msisdn,$campaign->id);
                    dispatch($connn)->delay(Carbon::now()->addSeconds(30));
                }
               
                $job = new CampaignJob($serivceNo,$campaigntype,$request->retry_attempt,$request->retry_duration, $request->schedule, $schedule_datetime, $msisdn, $voice_path,$campaign->id,$request->ukey);
                dispatch($job);
            }
            fclose($file);
            Session::flash('success', 'Campaign created successfully');
            return redirect()->route('campaign.index');
        }
        else{
            Session::flash('error', 'Upload file error');
            return redirect()->route('campaign.index');
        }
    }elseif($request->upload_type =='manual'){
        
        $msisdn         = array();
        $manualData     = $request->input('manual_data');
        preg_match_all('/\d+/', $manualData, $matches);
        $numbers        = $matches[0];
        $count          = count($matches[0]);
       
        $userPlanType   = DB::table('user_details')->where('user_id', '=', Auth::user()->id)->value('plan_type');
        $voiceDuration  = DB::table('sounds')->where('id', '=',$request->voiceclip)->value('duration');
        $needChargePerRecord                =   ceil((int)$voiceDuration / 15);

        $totalChargePerCsv                  =   $count * $needChargePerRecord;


        $campaigntype                   =    0;
        $schedule_datetime              =    '';
        $campaign                       =    new Campaign;
        $campaign->service_no           =    $serivceNo;
        $campaign->campaign_name        =    $request->campaign_name;
        $campaign->total_count          =    $count;
        $campaign->user_id              =    Auth::user()->id;
        $campaign->camp_type            =    $request->type;
        if($request->type == 'transactional'){
            $campaigntype           =   4;
        }else if($request->type == 'promotional'){
        $campaigntype               =   3;
        }
        $campaign->voiceclip        =    $request->voiceclip;
        $campaign->retry_attempt    =    $request->retry_attempt;
        $campaign->retry_duration   =    $request->retry_duration;
        $campaign->schedule         =    $request->schedule;
        $campaign->voice_credit     =    $needChargePerRecord;
            
            
        if($request->schedule == 1){
            $campaign->schedule_datetime          =    date('Y-m-d h:m:s',strtotime($request->schedule_datetime)); 
            $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
        }
        $campaign->save();

        $msisdn                             =   array();
        $insert_data                        =   [];

        foreach ($numbers as $nu) {
          
            $mobileregex = "/^[6-9][0-9]{9}$/" ;  
            $phoneNumber =  $nu;
            if(preg_match($mobileregex, $phoneNumber) === 1){
                $msisdn[]               = ''.$phoneNumber.'';

                $data = [
                    'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                    'user_id'                   =>  Auth::user()->id,
                    'campaign_id'               =>  $campaign->id,
                    'lead_id'                   =>  '', 
                    'lead_name'                 =>  '', 
                    'cli'                       =>  $serivceNo,
                    'mobile_no'                 =>  $phoneNumber,
                    'retry_attempt'             =>  $request->retry_attempt,
                    'retry_duration'            =>  $request->retry_duration,
                    'call_duration'             => '',
                    'call_credit'               =>  $needChargePerRecord,
                    'actual_status'             => 0,
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
        
        $insert_data = collect($insert_data); // Make a collection to use the chunk method
        $chunks = $insert_data->chunk(500);
            // dd($insert_data);
        foreach ($chunks as $chunk)
        {
            // dd($chunk);
            DB::table('campaigndatas')->insert($chunk->toArray());
        }
                $transcation                        =   new Transcation();
            $transcation->user_id               =   Auth::user()->id;
            $transcation->debit_amount          =   $totalChargePerCsv;
            $transcation->credit_amount         =   0;
            $transcation->remaining_amount      =   0;
            $transcation->save();
            $msisdn                             =   array();
                foreach($chunk as $singleData){
                    $msisdn[]               = ''.$singleData["mobile_no"].'';
                }
                if($request->apiProvider == 'Videocon'){
                    $numberData = implode(",",$msisdn);
                    $ukey = Ukey::find($request->ukey);
                    if($ukey != null){
                        $username = $ukey->username;
                        $password = $ukey->ukey;
                    }else{
                        $username = "amitgoyal";
                        $password = "123123";
                    }
                    $dataValue = [
            "UserName" => $username,
            "Password" => $password,
            "TransitionId" => "12345",
            "VoiceId" => Sound::where('id',$request->voiceclip)->value('voice_id'),
            "CampaignData" => $numberData,
            "OBD_TYPE" => "SINGLE_VOICE",
            "DTMF" => "0",
            "CALL_PATCH_NO" => "0",
            "RETRY_COUNT" => $request->retry_attempt,
            "RETRY_INTERVAL" => 0,
        ];
             $connn = new CampaignApiCallJob($dataValue,$msisdn,$campaign->id);
                dispatch($connn)->delay(Carbon::now()->addSeconds(30));
                }
            Session::flash('success', 'Campaign created successfully');
                return redirect()->route('campaign.index');
    }else{
        return back();
    }


    }

    public function show(Request $request,$id)
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

        $campaigndata = Campaigndata::where('campaign_id', $id); 
        $search = $request->search;
        if(strtolower($search) == 'answered'){
            $campaigndata = $campaigndata->Where('status',"1");
        } elseif(strtolower($search) == 'not answered'){
            $campaigndata = $campaigndata->Where('status',"0");
        }else{
            $campaigndata = $campaigndata->Where('mobile_no', 'LIKE', '%' . $search . '%');
            // if ($search) {
            //     $campaigndata = $campaigndata->where(function ($query) use ($search) {
            //          $query->where(DB::raw("CONCAT(created_at,' ',mobile_no,' ',cli,' ',call_duration,' ',call_remarks)"), 'LIKE', '%' . $search . '%');
            //     });
            //     //dd($campaigndata->get());
            // }
        }
       
       // dd($campaigndata->get());

        $campaigndata = $campaigndata->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('admin.campaign.view', compact('campaigndata', 'paginate', 'search', 'sort_f', 'sort_by'));

    }

    public function edit($id)
    {
        //
    }

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

    public function downloadFile($id)
    { 
        $campaigndata = Campaigndata::select('cli','mobile_no','status','call_duration')->where('campaign_id', $id)->get();
        return Excel::download(new CampaignExportClass($campaigndata->take(200000)), 'voter.csv');
    
    }

    public function retryCampaign($type, $id){
        $campaign = Campaign::where('id',$id)->first();
        if($type == 'all'){
            $campaigndata = Campaigndata::select('cli','mobile_no')->where('campaign_id',$id)->get();
        }elseif($type == 'answered'){
            $campaigndata = Campaigndata::select('cli','mobile_no')->where('campaign_id',$id)->where('status',1)->get();
        }elseif($type == 'notanswered'){
            $campaigndata = Campaigndata::select('cli','mobile_no')->where('campaign_id',$id)->where('status',0)->get();
        }
        $countOfRows                =   count($campaigndata);
        if ($campaign) {
            if ($campaign) {
            $newCampaign                        =       new Campaign;
            $newCampaignold                     =       $campaign->getAttributes();
            $newCampaign->user_id               =       $newCampaignold['user_id'];
            $newCampaign->service_no            =       $newCampaignold['service_no'];
            $newCampaign->campaign_name         =       $newCampaignold['campaign_name'];
            $newCampaign->camp_type             =       $newCampaignold['camp_type'];
            $newCampaign->voiceclip             =       $newCampaignold['voiceclip'];
            $newCampaign->total_count           =       $newCampaignold['total_count'];
            $newCampaign->status                =       $newCampaignold['status'];
            $newCampaign->camp_end_datetime     =       $newCampaignold['camp_end_datetime'];
            $newCampaign->retry_attempt         =       0;
            $newCampaign->schedule              =       0;
            $newCampaign->schedule_datetime     =       null;
            $newCampaign->excel_file_upload     =       null;
            $newCampaign->save();

            $insert_data                        =       [];
            $msisdn                             =       array();
            foreach($campaigndata as $item){
                    $mobileregex                = "/^[6-9][0-9]{9}$/" ;  
                    $phoneNumber                =  $item->mobile_no;
                    if(preg_match($mobileregex, $phoneNumber) === 1){
                        $msisdn[]               = ''.$phoneNumber.'';

                        $data = [
                                    'user_id'                 =>    Auth::user()->id,
                                    'campaign_id'             =>    $newCampaign->id,
                                    'lead_id'                 =>    '', 
                                    'lead_name'               =>    '', 
                                    'cli'                     =>    $newCampaign->service_no,
                                    'mobile_no'               =>    $phoneNumber,
                                    'retry_attempt'           =>    "0",
                                    'retry_duration'          =>    "0",
                                    'call_duration'           =>    '',
                                    'actual_status'           =>    "0",
                                    'status'                  =>    "0",
                                    'call_start_ts'           =>    '',
                                    'call_connect_ts'         =>    '',
                                    'call_end_ts'             =>    '',
                                    'body'                    =>    '',
                                    'call_uuid'               =>    0,
                                    'created_at'              =>    date('Y-m-d H:i:s'),
                                    'updated_at'              =>    date('Y-m-d H:i:s'),
                                ];
                        $insert_data[]             =    $data;
                        }
                }

                $insert_data = collect($insert_data); // Make a collection to use the chunk method
            $chunks = $insert_data->chunk(500);

            
            foreach ($chunks as $chunk)
            {
                DB::table('campaigndatas')->insert($chunk->toArray());
            }
            $campaigntype                   =    0;
            if($newCampaign->camp_type == 'transactional'){
                $campaigntype           =   4;
            }else if($newCampaign->camp_type == 'promotional'){
            $campaigntype               =   3;
            }

            $voice_path = str_replace('uploads/soundclip/','',Sound::where('id',$newCampaign->voiceclip)->value('voiceclip'));
            $callResponse = CommonClass::sendVoiceCall($request->service_no,$campaigntype,$request->retry_attempt,$request->retry_duration, $request->schedule, $schedule_datetime, $msisdn, $voice_path);
                $callResponseDecode = json_decode($callResponse,true);
                if(isset($callResponseDecode) && $callResponseDecode['leadid'] && $callResponseDecode['refno']){
                    $campainData = Campaigndata::where('campaign_id',$campaign->id)->update(['lead_id' => $callResponseDecode['leadid']]);
                    if($callResponseDecode['refno']){
                        foreach($callResponseDecode['refno'] as $data){
                            foreach($data as $key => $value){
                                $campainData = Campaigndata::where('campaign_id',$campaign->id)->where('mobile_no',$key)->update(['refno' => $value]);
                            }
                        }
                    }
                }
                Session::flash('success', 'Campaign recreated successfully');
                return 1;
        } 
        } else {
            Session::flash('error', 'Upload file error');
            return 0;
    }

    }

    public function resendCampaign($id){
        $campaigndata = Campaigndata::where('id',$id)->first();
        if ($campaigndata) {
            $campaign           =   Campaign::select('voiceclip','camp_type')->where('id',$campaigndata->campaign_id)->first();
            $campaigntype                   =    0;
            if($campaign->camp_type == 'transactional'){
                $campaigntype           =   4;
            }else if($campaign->camp_type == 'promotional'){
             $campaigntype               =   3;
            }
            
            $msisdn                             =   array();
            $msisdn[]                           = ''.$campaigndata->mobile_no.'';
            $voice_path = str_replace('uploads/soundclip/','',Sound::where('id',$campaign->voiceclip)->value('voiceclip'));

            $callResponse = CommonClass::sendVoiceCall($campaigndata->cli,$campaigntype,$campaigndata->retry_attempt,$campaigndata->retry_duration, 0, '', $msisdn, $voice_path);

            $callResponseDecode = json_decode($callResponse,true);
         
            if (isset($callResponseDecode) && isset($callResponseDecode['leadid']) && isset($callResponseDecode['refno'])) {
                if ($callResponseDecode['refno']) {
                    foreach ($callResponseDecode['refno'] as $data) {
                        foreach ($data as $key => $value) {
                            $campaignData = Campaigndata::where('campaignId_mobileno', $this->campaign_id.'-'.$key)->update(
                            [
                                'refno' => $value,
                                'lead_id' => $callResponseDecode['leadid']
                            ]
                        );
                        }
                    }
                }
            }

            


          
        } else {
            Session::flash('error', 'Upload file error');
            return 0;
        }

    }

    public function databasecopy(){
        // $dataToInsert = CampaignData::whereDate('created_at', '!=', Carbon::today())->get();
        // $copyStatus = true;
        // foreach ($dataToInsert as $data) {
        //     $result = Campaignoldata::create($data->toArray());
        //     if (!$result) {
        //         $copyStatus = false;
        //         break; 
        //     }
        // }

        // if ($copyStatus) {
        //    // $deletedRows = CampaignData::whereDate('created_at', '!=', Carbon::today())->delete();
        // } else {
        //     echo "Error: Some records failed to copy.";
        // }
        ini_set('memory_limit', '512M');

        // Increase execution time limit
        ini_set('max_execution_time', 300);  // Set to 5 minutes (300 seconds)

        // Define the batch size
        $batchSize = 5000;  // You can adjust this value based on your needs

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Initialize copy status
            $copyStatus = true;

            // Fetch records from campaigndatas excluding today's date using cursor-based pagination and process in batches
            CampaignData::whereDate('created_at', '!=', Carbon::today())
                ->orderBy('id')
                ->cursor()
                ->chunk($batchSize, function ($dataToInsert) use (&$copyStatus) {
                    
                    // Process each record in the current batch
                    foreach ($dataToInsert as $data) {
                        // Attempt to create a new record in campaignoldatas
                        $result = Campaignoldata::create($data->toArray());

                        // Check if the create operation was successful
                        if (!$result) {
                            // Set the copy status to false if any record fails to copy
                            $copyStatus = false;
                            return false; // Stop processing further records
                        }

                        // Delete the current record from campaigndatas
                        $deleted = $data->delete();

                        // Check if the delete operation was successful
                        if (!$deleted) {
                            // Set the copy status to false if any delete operation fails
                            $copyStatus = false;
                            return false; // Stop processing further records
                        }
                    }
                });

            // Commit the transaction if all operations were successful
            if ($copyStatus) {
                DB::commit();
                echo "Records moved and deleted successfully!";
            } else {
                throw new \Exception("Error: Some records failed to copy or delete.");
            }

        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();

            echo $e->getMessage();
        }
    }

    public function campaignStartStop($status, $id){
        
        $campaign=Campaign::where('id',$id)->first();

        if($status == 'start'){
            $s  =   'S';
        }else if($status == 'stop'){
            $s  =   'P';
        }

        $message        =   'Campaign '.$status.' successfully';

        $cli = CommonClass::campaignStartStop($campaign->campaignID,$campaign->idToken,$s);
        Session::flash('success', $message);
        return redirect()->route('campaign.index');


    }

    public function refundCredit($id){
        
        $campaign=Campaign::where('id',$id)->where('returncreditflag',0)->first();
        $refundCredit = ($campaign->failed_count) * ($campaign->voice_credit);
        $user = User::where('user_plan', 0)->where('id',$campaign->user_id)->first();
        $user->wallet += $refundCredit;
        $user->save();

        $campaign->returncreditflag =   1;
        $campaign->save();
        
        
        if($refundCredit){
            $newtranscation                          =   new Transcation();
            $newtranscation->user_id                 =   $campaign->user_id;
            $newtranscation->debit_amount            =   0;
            $newtranscation->credit_amount           =   $refundCredit;
            $newtranscation->remaining_amount        =   $user->wallet;
            $newtranscation->transcation_type        =   1;
            $newtranscation->Remarks                =    "Promotional balance added by using ".$campaign->id . "campaign method ";
            $newtranscation->save();
        }
       // dd($refundCredit, $user);
        
       session()->flash('success_msg', 'Wallet update successfully');
       return back();

    }


    public function refundCreditByFunction(){
        $fullcampaign=Campaign::where('returncreditflag',0)->get();
       
        foreach($fullcampaign as $campaign){
           $totalData      =   $campaign->total_count;
          $successCount   =   $campaign->success_count;
          $failedCount    =   $campaign->failed_count;
          $campaignID     =   $campaign->id;
        
          $totalCountDataHitByUs  =   $successCount + $failedCount + 25;

            if($totalCountDataHitByUs >= $totalData){
                $refundCredit = ($campaign->failed_count) * ($campaign->voice_credit);
                $user = User::where('user_plan', '0')->where('id',$campaign->user_id)->first();
               
                if(!$refundCredit){
                    $refundCredit   =   0;
                }
    
                if($user){
                    $user->wallet += $refundCredit;
                    $user->save();
                    
                    if($refundCredit){
                        $newtranscation                          =   new Transcation();
                        $newtranscation->user_id                 =   $campaign->user_id;
                        $newtranscation->debit_amount            =   0;
                        $newtranscation->credit_amount           =   $refundCredit;
                        $newtranscation->remaining_amount        =   $user->wallet;
                        $newtranscation->transcation_type        =   1;
                        $newtranscation->Remarks                =    "Promotional balance added by using ".$campaignID." campaign method ";
                        $newtranscation->save();
                    }
                }
                $campaign->returncreditflag =   1;
                $campaign->save();
            }else if($successCount == 0 && $failedCount == 0 ){
                $refundCredit = ($totalData) * ($campaign->voice_credit);
                $user = User::where('user_plan', '0')->where('id',$campaign->user_id)->first();
              
                if(!$refundCredit){
                    $refundCredit   =   0;
                }
                if($user){
                    $user->wallet += $refundCredit;
                    $user->save();
                    
                    if($refundCredit){
                        $newtranscation                          =   new Transcation();
                        $newtranscation->user_id                 =   $campaign->user_id;
                        $newtranscation->debit_amount            =   0;
                        $newtranscation->credit_amount           =   $refundCredit;
                        $newtranscation->remaining_amount        =   $user->wallet;
                        $newtranscation->transcation_type        =   1;
                        $newtranscation->Remarks                =    "Promotional balance added by using ".$campaignID." campaign method ";
                        $newtranscation->save();
                    }
                }
                $campaign->returncreditflag =   1;
                $campaign->save();
            }
        }
    }

    public function startScheduleCampaign(){
        $today = Carbon::today();
        $todayDate  =   date('Y-m-d',strtotime($today));

        // Add +1 day
        $tomorrow = $today->addDays(1);
        $tomorrowDate  =   date('Y-m-d',strtotime($today));
        $endTime                =   Carbon::parse('21:00:00');
        $campEndTime        =   $endTime->toTimeString();
        $destinationPath                =   public_path('uploads/csv');

        $campaignData =  Campaign::where('cron_flag',1)->where('schedule_datetime', 'like', '%'.$todayDate.'%')->get();
        
        foreach($campaignData as $singleCampaignData){
            $campaignID         =   $singleCampaignData->id;
            $campaign_name      =   $singleCampaignData->campaign_name;
            $service_no         =   $singleCampaignData->service_no;
            $retry_duration     =   $singleCampaignData->retry_duration;
            $retry_Count        =   $singleCampaignData->retry_attempt;
            $dtmf_Req           =   $singleCampaignData->dtmf_Req;
            $voiceclip          =   $singleCampaignData->voiceclip;
            $voice_credit       =   $singleCampaignData->voice_credit;
            $user_id            =   $singleCampaignData->user_id;
            $whatsapp_response  =   $singleCampaignData->whtsapp_response;
            $file_path          =   public_path($singleCampaignData->excel_file_upload);
            $filename           =   basename($file_path);
            
            if($dtmf_Req == 1){
                $dtmf_Req       =   'Y'; 
                $dtmf_length    =   '1';
                $dtmf_response  =   1;
            }else{
                $dtmf_Req       =   'N'; 
                $dtmf_length    =   ''; 
                $dtmf_response  =   0;
            }

            if($retry_Count ==  1){
                $retry_Count           =   "1";
            }else{
                $retry_Count           =   "0"; 
            }


            $campSchDate        =   date('Y-m-d',strtotime($singleCampaignData->schedule_datetime));
            $campStartTime      =   date('H:i:s',strtotime($singleCampaignData->schedule_datetime));

            ///////////////////Create IdToken
            $createToken = CommonClass::campaignAuthToken(); 
            $response   = json_decode($createToken);
            $idToken    =   $response->idToken;

             ///////////////////Create Campaign
             $createOBDCampaign  =   CommonClass::createOBDCampaign($campaign_name, $service_no, $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken);

            
            $campaignNew                =   Campaign::find($campaignID);
            $response1                  =   json_decode($createOBDCampaign);
            echo '<pre>';
            print_r($response1);
            echo '</pre>';
            $capaignNameByApi           =   $response1->campaign_ID;
            $capaignRefIDByApi          =   $response1->campaign_Ref_ID;
            $campaignNew->campaignID    =   $capaignNameByApi;
            $campaignNew->cron_flag     =   2;
            $campaignNew->idToken       =   $idToken;
            $campaignNew->campaignRefID =   $capaignRefIDByApi;
            $campaignNew->save();

            $userData               =   DB::table('users')->where('id', '=', $user_id)->first(); 
            $parentId               =   $userData->parent_id;

            $data = Excel::toArray([], $file_path);
            $headers = $data[0][0];
            $insert_data                        =   [];
            if($data){
                for ($i = 1; $i < count($data[0]); $i++) {
                    $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                    $mobileregex91   = "/^91[6-9][0-9]{9}$/";  
                    $phoneNumber = $data[0][$i][0]; 
                
                    if(preg_match($mobileregex, $phoneNumber) === 1 || preg_match($mobileregex91, $phoneNumber) === 1){
                        $data1 = [
                            'campaignId_mobileno'       =>  $campaignID.'-'.$phoneNumber,
                            'user_id'                   =>  $user_id,
                            'parent_id'                 =>  $parentId,
                            'campaign_id'               =>  $campaignID,
                            'campg_id'                  =>  $capaignRefIDByApi,
                            'lead_id'                   =>  '', 
                            'lead_name'                 =>  '', 
                            'cli'                       =>  $service_no,
                            'mobile_no'                 =>  $phoneNumber,
                            'retry_attempt'             =>  $singleCampaignData->retry_attempt,
                            'retry_duration'            =>  $retry_duration,
                            'call_duration'             =>  '',
                            'call_credit'               =>  $voice_credit,
                            'actual_status'             =>  2,
                            'status'                    =>  2,
                            'data_type'                 =>  1,
                            'dtmf_response'             =>  0,
                            'whtsapp_response'          =>  $whatsapp_response,
                            'call_start_ts'             => '',
                            'call_connect_ts'           => '',
                            'call_end_ts'               => '',
                            'body'                      => '',
                            'call_uuid'                 => 0,
                            'created_at'                => date('Y-m-d H:i:s'),
                            'updated_at'                => date('Y-m-d H:i:s'),
                        ];
                        $insert_data[]             =    $data1;
                    }
                }
                $insert_data    = collect($insert_data);
                $chunkCound     = 1000;
                $chunks         = $insert_data->chunk($chunkCound);
                foreach ($chunks as $chunk)
                {
                    DB::table('campaigndatas')->insert($chunk->toArray());
                }

                $soundList          =   Sound::where('id',$voiceclip)->value('voiceclip');
                $fullSoundFilePath  =   url($soundList);

                $voiceUpload = CommonClass::campaignVoiceUpload($fullSoundFilePath, $idToken, $capaignNameByApi,$idToken); 
        
                echo $voiceUpload;

                ///////////////////Base upload 
                $xlsFile = $file_path;
                $baseUploadResponse  = CommonClass::APICampaignBaseLoad($xlsFile, $filename, $idToken, $capaignNameByApi, $service_no); 

                echo $baseUploadResponse;
                
                if ($baseUploadResponse === false) {

                }else{
                    ///////////////////Start campaign
                   $cli = CommonClass::campaignStartStop($capaignNameByApi,$idToken,'S');
                   echo $cli;
                }
            }
        }
    }

    public function startDailyScheduleCampaign(){
        $CampaignMonthUpload    =   CampaignMonthUpload::where('status',1)->where('flag',0)->get();
        $currentDate            =   Carbon::now();
        $startTime              =   Carbon::parse('09:00:00');
        $endTime                =   Carbon::parse('21:00:00');
        $campStartTime          =   $startTime->toTimeString();
        $campEndTime            =   $endTime->toTimeString();
        $campSchDate            =   $currentDate->toDateString();
        $schedule_datetime      =   date('Y-m-d') . ' 09:10:00';
        if($CampaignMonthUpload){
            foreach($CampaignMonthUpload as $val){
                
                $user_id                        =    $val->user_id;
                $parent_id                      =    $val->parent_id;
                $campaign_name                  =    $val->campaign_name.'_'.$currentDate;
                $service_no                     =    $val->service_no;
                $camp_type                      =    $val->camp_type;
                $voiceclip                      =    $val->voiceclip;
                $retry_attempt                  =    $val->retry_attempt;
                $retry_duration                 =    $val->retry_duration;
                $dtmf_response                  =    $val->dtmf_response;
                $excel_file_upload              =    $val->excel_file_upload;
                $voice_credit                   =    $val->voice_credit;
                $whtsapp_response               =    $val->whtsapp_response;
                $daily_limit                    =    $val->daily_limit;
                $days                           =    $val->days;
                $file_path                      =    public_path($val->excel_file_upload);

                $campaign                       =    new Campaign;
                $campaign->service_no           =    $service_no;
                $campaign->campaign_name        =    $campaign_name;
                $campaign->total_count          =    $daily_limit;
                $campaign->user_id              =    $user_id;
                $campaign->camp_type            =    $camp_type;
                $campaign->voiceclip            =    $voiceclip;
                $campaign->retry_attempt        =    $retry_attempt;
                $campaign->retry_duration       =    $retry_duration;
                $campaign->schedule             =    1;
                $campaign->schedule_datetime    =    $schedule_datetime; 
                $campaign->dtmf_response        =    $dtmf_response;
                $campaign->voice_credit         =    $voice_credit;
                $campaign->whtsapp_response     =    $whtsapp_response;

                $campaign->save();
                $campaignNew                        =   Campaign::find($campaign->id);

                $retry_Count                    =  "0";
                if($retry_attempt > 0){
                    $retry_Count                =   "1";
                }

                if($dtmf_response == 1){
                    $dtmf_Req                   =   'Y'; 
                    $dtmf_length                =   '1';
                    $dtmf_response              =   1;
                }else{
                    $dtmf_Req                   =   'N'; 
                    $dtmf_length                =   ''; 
                    $dtmf_response              =   0;
                }

                $data = Excel::toArray([], $file_path);
                $first_sheet_data = $data[0];
                
                if($days == 1){
                    $start = 0;
                }else{
                    $start = ($days-1)*$daily_limit*2.5;
                }
                $end = $daily_limit*2.5;
                $specific_cells_data = array_slice($first_sheet_data, $start, $end);
                
                $unique_values = array();

                foreach ($specific_cells_data as $value) {
                    if (!in_array($value, $unique_values)) {
                        $unique_values[] = $value;
                    }
                }

                ///////////////////Create IdToken
                $channelserver          =   Channel::where('ctsNumber',$service_no)->value('channelserver');
                $createToken    = CommonClass::campaignAuthToken($channelserver); 
                $response   = json_decode($createToken);
                $idToken    =   $response->idToken;

                 ///////////////////Create Campaign
                 $createOBDCampaign  =   CommonClass::createOBDCampaign($campaign_name, $service_no, $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken);
               // dd($createOBDCampaign);
                $response                   =   json_decode($createOBDCampaign);
                $capaignNameByApi           =   $response->campaign_ID;
                $capaignRefIDByApi          =   $response->campaign_Ref_ID;
                $campaignNew->campaignID    =   $capaignNameByApi;
                $campaignNew->idToken       =   $idToken;
                $campaignNew->campaignRefID = $capaignRefIDByApi;
                $campaignNew->save();
                
                $headers = $data[0][0];
                $insert_data                        =   [];
                $excelNumber                        =   [];
                $excelNumber[][]                    =   'msisdn';
                if($unique_values){
                    for ($i = 0; $i < count($unique_values); $i++) {
                        $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                        $mobileregex91   = "/^91[6-9][0-9]{9}$/";  
                        $phoneNumber = $data[0][$i][0]; 
                    
                        if(preg_match($mobileregex, $phoneNumber) === 1 || preg_match($mobileregex91, $phoneNumber) === 1){
                            $data1 = [
                                'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                                'user_id'                   =>  $user_id,
                                'parent_id'                 =>  $parent_id,
                                'campaign_id'               =>  $campaign->id,
                                'campg_id'                  =>  $capaignRefIDByApi,
                                'lead_id'                   =>  '', 
                                'lead_name'                 =>  '', 
                                'cli'                       =>  $service_no,
                                'mobile_no'                 =>  $phoneNumber,
                                'retry_attempt'             =>  $retry_attempt,
                                'retry_duration'            =>  $retry_duration,
                                'call_duration'             =>  '',
                                'call_credit'               =>  $voice_credit,
                                'actual_status'             =>  2,
                                'status'                    =>  2,
                                'data_type'                 =>  1,
                                'dtmf_response'             =>  0,
                                'whtsapp_response'          =>  $whtsapp_response,
                                'call_start_ts'             => '',
                                'call_connect_ts'           => '',
                                'call_end_ts'               => '',
                                'body'                      => '',
                                'call_uuid'                 => 0,
                                'created_at'                => date('Y-m-d H:i:s'),
                                'updated_at'                => date('Y-m-d H:i:s'),
                            ];
                           $insert_data[]             =    $data1;
                           $excelNumber[][]              =   $phoneNumber;
                        }
                    }
                }

                $insert_data = collect($insert_data);
                $chunks = $insert_data->chunk(500);
                $voice_path = str_replace('uploads/soundclip/','',Sound::where('id',$voiceclip)->value('voiceclip'));
                foreach ($chunks as $chunk)
                {
                    $msisdn                             =   array();
                    DB::table('campaigndatas')->insert($chunk->toArray());
                    
                }

                $folder = 'uploads/excel_files/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $filename   =   'example_'.time().'_'.$user_id.'.xlsx';
                $datanew1 = $folder . ''.$filename;
                Excel::store(new CampaignCreateExcelClass($excelNumber), $datanew1);
                $xlsFile = storage_path('app').'/'.$datanew1;

                $soundList          =   Sound::where('id',$voiceclip)->value('voiceclip');
                $fullSoundFilePath  =   url($soundList);
                $voiceUpload        =   CommonClass::campaignVoiceUpload($fullSoundFilePath, $idToken, $capaignNameByApi,$idToken); 

                echo $voiceUpload;

                //////Base upload 
                echo $xlsFile = storage_path('app').'/'.$datanew1;
                $baseUploadResponse  = CommonClass::APICampaignBaseLoad($xlsFile, $filename, $idToken, $capaignNameByApi, $service_no); 
                echo $baseUploadResponse;

                if ($response === false) {
    
                }else{
                    //////Start campaign
                    //$cli = CommonClass::campaignStartStop($capaignNameByApi,$idToken,'P');
                    //echo $cli;
                }
               
                //dd($insert_data, $specific_cells_data, $unique_values,$data);

            }
        }
    }

    public function changeStatusForCampaign(){
        Campaigndata::where('actual_status', 2)
           ->where('status', 2)
           ->update(['status' => 0]);
    }

    public function checkMobileNumberLast5status(){
        $chunkSize = 100; // You can adjust this based on your specific requirements

        // Get total count of records
        $totalRecords = Campaigndata::count();

        // Calculate total chunks
        $totalChunks = ceil($totalRecords / $chunkSize);

        // Process data in chunks
        for ($chunk = 0; $chunk < $totalChunks; $chunk++) {
            // Retrieve data for the current chunk
            $offset = $chunk * $chunkSize;
            $campaignDatas = Campaigndata::offset($offset)->limit($chunkSize)->get();

            // Iterate through each record
            foreach ($campaignDatas as $campaignData) {
                echo $mobileNo = $campaignData->mobile_no;
              
                $actualStatus = $campaignData->actual_status;

                // Check if there is an existing record with the same mobile number
                $existingRecord = SpeedData::where('mobile_no', $mobileNo)->first();

                if ($existingRecord) {
                    // If an existing record is found, update the last_5_status column
                    $last5Status = json_decode($existingRecord->last_5_status, true);
                    $last5Status[] = $actualStatus;
                    // Keep only the last 5 status
                    $last5Status = array_slice($last5Status, -5);
                    $existingRecord->last_5_status = json_encode($last5Status);
                    $existingRecord->save();
                } else {
                    // If no existing record is found, create a new record
                    $newRecord = new SpeedData();
                    $newRecord->mobile_no = $mobileNo;
                    $newRecord->last_5_status = json_encode([$actualStatus]);
                    $newRecord->save();
                }
            }
        }

    }


    public function updateVipNumbers(){
        $chunkSize = 100; // You can adjust this based on your specific requirements

        // Get total count of records
        $totalRecords = Campaigndata::where('data_type',2)->count();

        // Calculate total chunks
        $totalChunks = ceil($totalRecords / $chunkSize);

        // Process data in chunks
        for ($chunk = 0; $chunk < $totalChunks; $chunk++) {
            // Retrieve data for the current chunk
            $offset = $chunk * $chunkSize;
            $campaignDatas = Campaigndata::where('data_type',2)->offset($offset)->limit($chunkSize)->get();

            // Iterate through each record
            foreach ($campaignDatas as $campaignData) {
                echo $mobileNo = $campaignData->mobile_no;
                echo '<br/>';
                $user_id = $campaignData->user_id;

                // Check if there is an existing record with the same mobile number
                $existingRecord = VipNumber::where('user_id', $user_id)->first();

                if ($existingRecord) {
                    $existingNumbers = json_decode($existingRecord->number, true);
                    if (!in_array($mobileNo, $existingNumbers)) {
                        // Add the number to the list if it's not already present
                        $existingNumbers[] = $mobileNo;
                        $existingRecord->number = json_encode($existingNumbers);
                        $existingRecord->save();
                    }
                } else {
                    // If no existing record is found, create a new record
                    $newRecord = new VipNumber();
                    $newRecord->user_id = $user_id;
                    $newRecord->number = json_encode([$mobileNo]);
                    $newRecord->save();
                }
            }
        }

    }



    public function speedDataForCampaign(){
        // Fetch 20% of random data from the Campaigndata table
        $campaignIds = [1228];

        $campaignDatas = Campaigndata::whereIn('campaign_id', $campaignIds)->where('status',0)
        ->inRandomOrder()
        ->take(Campaigndata::whereIn('campaign_id', $campaignIds)->where('status',0)->count() * 0.50)
        ->get();

        
        foreach ($campaignDatas as $campaignData) {
            $userId        =   $campaignData->user_id;
            $mobileNo        =   $campaignData->mobile_no;
            $campaignIdMobileno         =   $campaignData->campaignId_mobileno ;
            // Check if the number exists in the vip_number table
            $vipNumber = VipNumber::whereJsonContains('number', [$mobileNo])
                        ->where('user_id', $userId)
                        ->first();
            echo '<pre>';
            print_r($mobileNo);
            
            if ($vipNumber) {
                echo 'Tu h sach m vip';
            }else{
                $last_5_status = SpeedData::where('mobile_no', $mobileNo)->value('last_5_status');
                $last_5_status_array = json_decode($last_5_status, true);
                $countOfOnes = count(array_filter($last_5_status_array, function ($value) {
                    return $value == 1;
                }));

                if($countOfOnes > 2){
                    $randomNumber = rand(1, 7);
                    $campaignDataUpdate = Campaigndata::where('campaignId_mobileno', $campaignIdMobileno)
                    ->update([
                        'status' => 1,
                        'call_remarks' => 'Connected',
                        'call_duration' => $randomNumber,
                    ]);
                }
                
                
            }
            echo '</pre>';
        }

    }


    public function simentensolySpeedData(){
        $chunkSize = 100; // You can adjust this based on your specific requirements
        $today = Carbon::today();
        $todayCampaigns = Campaign::whereDate('created_at', $today)->get();
        foreach ($todayCampaigns as $campaign) {
           
            $userId         =   $campaign->user_id;
            $campaignId     =   $campaign->id;
            $total_count    =   $campaign->total_count;
            $user = User::find($userId, ['margin_market']);
            if ($user) {
                $campaignSuccessData = Campaigndata::where('id', $campaignId)
                                ->where('actual_status', 1)
                                ->where('status', 1)
                                ->where('crone_flag', 1)
                                ->get();

                $countOfSuccessData = $campaignSuccessData->count();

                $campaignFailedData = Campaigndata::where('id', $campaignId)
                                ->where('actual_status', 0)
                                ->where('status', 0)
                                ->where('crone_flag', 1)
                                ->get();
                $countOfFailedData = $campaignFailedData->count();

                $sucessPercantage       =   ($countOfSuccessData / $total_count ) * 100;
                $failedPercantage       =   ($countOfFailedData / $total_count ) * 100;


                $campaignDatas = Campaigndata::whereIn('campaign_id', $campaignId)->where('status',2)->where('actual_status',2)->where('cut_flag',1)->where('crone_flag', 1)
                ->inRandomOrder()
                ->take(Campaigndata::whereIn('campaign_id', $campaignId)->where('status',2)->where('actual_status',2)->where('cut_flag',1)->where('crone_flag', 1)->count() * $sucessPercantage)
                ->get();

                foreach ($campaignDatas as $campaignData) {
                    $mobileNo        =   $campaignData->mobile_no;
                    $campaignIdMobileno         =   $campaignData->campaignId_mobileno ;
                    print_r($mobileNo);
                 
                    $randomNumber = rand(1, 7);
                    $campaignDataUpdate = Campaigndata::where('campaignId_mobileno', $campaignIdMobileno)
                    ->update([
                        'status' => 1,
                        'call_remarks' => 'Connected',
                        'call_duration' => $randomNumber,
                        'crone_flag' => 2,
                    ]);
                }

                $campaignSuccessData->chunk(100, function ($campaigns) {
                    foreach ($campaigns as $campaign) {
                        $campaign->crone_flag = 2;
                        $campaign->save();
                    }
                });

                $campaignFailedData->chunk(100, function ($campaigns) {
                    foreach ($campaigns as $campaign) {
                        $campaign->crone_flag = 2;
                        $campaign->save();
                    }
                });


                $campaignFailDatas = Campaigndata::whereIn('campaign_id', $campaignId)->where('status',2)->where('actual_status',2)->where('cut_flag',1)->where('crone_flag', 1)
                ->inRandomOrder()
                ->take(Campaigndata::whereIn('campaign_id', $campaignId)->where('status',2)->where('actual_status',2)->where('cut_flag',1)->where('crone_flag', 1)->count() * $failedPercantage)
                ->get();

                foreach ($campaignFailDatas as $campaignData) {
                    $mobileNo        =   $campaignData->mobile_no;
                    $campaignIdMobileno         =   $campaignData->campaignId_mobileno ;
               
                    $randomNumber = rand(1, 7);
                    $callRemarks  = rand('User Not Responding', 'User Timeout');
                    $campaignDataUpdate = Campaigndata::where('campaignId_mobileno', $campaignIdMobileno)
                    ->update([
                        'status' => 0,
                        'call_remarks' => $callRemarks,
                        'call_duration' => NULL,
                        'crone_flag' => 2,
                    ]);
                }
            }

        }
    }

}
