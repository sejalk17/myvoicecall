<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\CommonClass;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\Campaignoldata;
use App\Models\CampaignMonthUpload;
use App\Models\Sound;
use App\Models\Transcation;
use App\Models\User;
use App\Models\Ukey;
use App\Models\UserDetail;
use App\Models\Userwiseplan;
use App\Models\UserPlan;
use App\Models\ThirdPartySetting;
use App\Models\Plan;
use App\Models\VipNumber;
use App\Models\Channel;
use Storage, Session, Auth, DB, CURLFILE;
use App\Exports\CampaignExportClass;
use App\Jobs\CampaignJob;
use App\Jobs\CampaignApiCallJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CampaignCreateExcelClass;
class CampaignReplicaController extends Controller
{
    public function index(Request $request)
    { 
        if ($request->paginate) {
            $paginate = $request->paginate;
        } else {
            $paginate = 50;
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
        $campaign = Campaign::select('*')->where('user_id',Auth::user()->id);
        
        if ($search) {
            $campaign = $campaign->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',total_count)"), 'LIKE', '%' . $search . '%');
            });
        }
        $campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('user.campaignreplica.index', compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by'));
    }

    public function create()
    {
     
        $soundType      =   CommonClass::getSoundsType();
        $soundList      =   Sound::select('id', 'name')->where('user_id',Auth::user()->id)->where('status',1)->get();
        return view('user.campaignreplica.create', compact('soundType','soundList'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
      
        if($request->whatsapp_response){
            $user_id        =   Auth::user()->id;
            $row            =   ThirdPartySetting::where('type','whatsapp')->where('user_id',$user_id)->first();
            if(!$row){
                Session::flash('error', 'Please add whatsapp Setting Details first for sending whatsapp message');
                return redirect()->route('usercampaignreplica.index');
            }
            $whatsapp_response  =   1;
        }else{
            $whatsapp_response  =   0;
        }
 
        //dd($whatsapp_response, $request->all());
        $authUserId             =   Auth::user()->id;
        $currentDate            =   Carbon::now();
        $startTime              =   Carbon::parse('09:00:00');
        $endTime                =   Carbon::parse('21:00:00');
        $campaigntype           =   0;
        $userData               =   DB::table('users')->where('id', '=', Auth::user()->id)->first(); 
        $marketMargin           =   100-40;
        
        $userPlanPrice          =   UserPlan::where('user_id', Auth::user()->id)->value('price');
        $userCredit             =   $userData->wallet;
        $parentId               =   $userData->parent_id;
        $userPlanType           =   UserPlan::where('user_id', '=', Auth::user()->id)->value('plan_type');
        $voiceDuration          =   DB::table('sounds')->where('id', '=',$request->voiceclip )->value('duration');

        $planId                 =   User::where('id', Auth::user()->id)->value('user_plan');

        $retry_Count            =  "0";
        $retry_duration         =   "";
        
        if($request->type == 'transactional'){
            $campaigntype           =   4;
        }else if($request->type == 'promotional'){
            $campaigntype           =   3;
        }

        if($request->retry_attempt > 0){
            $retry_Count           =   "1";
        }

        if($request->retry_duration > 0){
            $retry_duration           =   "15";
        }

        if($request->dtmf_response == 'yes'){
            $dtmf_Req       =   'Y'; 
            $dtmf_length    =   '1';
            $dtmf_response  =   1;
        }else{
            $dtmf_Req       =   'N'; 
            $dtmf_length    =   ''; 
            $dtmf_response  =   0;
        }

       

        if($request->schedule == 1){
            $campSchDate        =   date('Y-m-d',strtotime($request->schedule_datetime));
            $campStartTime      =   date('H:i:s',strtotime($request->schedule_datetime));
            $campEndTime        =   $endTime->toTimeString();
            $futureDateTime     =   Carbon::parse($request->schedule_datetime);
            $futureDateTime1     = Carbon::parse($campStartTime);
            

        }else{
            $campSchDate        =   $currentDate->toDateString();
            $campStartTime      =   $startTime->toTimeString();
            $campEndTime        =   $endTime->toTimeString();
            $futureDateTime     =   Carbon::now();
            $futureDateTime1     = Carbon::parse($campStartTime);
        }
        
        $needChargePerRecord                =   ceil($voiceDuration / $userPlanType);
      
       
        // Check if the future date time is between 9 am and 9 pm
        if ($futureDateTime->greaterThanOrEqualTo($currentDate)) {
            if($futureDateTime1->between($startTime, $endTime,true)){
                if ($futureDateTime->isToday()) {
                    if($request->upload_type == 'csv'){
                        $filePath               =   $request->excel_file_upload;
                        $dataCount              =   Excel::toArray([], $filePath)[0];
                        $dataCount              =   array_filter($dataCount, function ($row) {
                                                        return !empty(array_filter($row));
                                                    });
                        $excelrowsLineCount     =   count($dataCount);
                        $pickRowCount              =    $excelrowsLineCount*($marketMargin/100);
                        $destinationPath                =   public_path('uploads/csv');
                        if ($request->hasFile('excel_file_upload')) {
                            $csvFile                    =   $request->file('excel_file_upload');
                            $extension                  =   $csvFile->getClientOriginalExtension();
                            $filename                   =   str_replace('.'.$extension,'',$csvFile->getClientOriginalName()).'_'.time().'_'.$authUserId.'.'.$extension;
                            $csvFile->move($destinationPath, $filename);
                            $file_path                  =   $destinationPath.'/'.$filename;
                            $linecount                  =   $excelrowsLineCount-1  ;
                            
                            $totalChargePerCsv          =   $linecount * $needChargePerRecord;
                            $totalChargePerCsv          =   10   ;
                            if(($userCredit < $totalChargePerCsv) && ($planId == 0)){
                                Session::flash('error', 'Your credit is low so please contact to you reseller');
                                return redirect()->route('usercampaignreplica.index');
                            }else if($userCredit * 2.5 <= $totalChargePerCsv && $planId != 0){
                                Session::flash('error', 'Your credit is low so upload your file 2.5 times of credit');
                                return redirect()->route('usercampaignreplica.index');
                            }else{
                                if($planId != 0){
                                    $remainingBalance       =   $userCredit;
                                }else{
                                    $remainingBalance       =   $userCredit - $totalChargePerCsv;
                                }
                               
                                $campaignName              =   $request->campaign_name.'_'.$currentDate;
                                $schedule_datetime         =    '';
                                $campaign                  =    new Campaign;
                                $campaign->service_no      =    $request->service_no;
                                $campaign->campaign_name   =    $campaignName;
                                $campaign->total_count     =    $linecount;
                                $campaign->user_id         =    $authUserId;
                                $campaign->camp_type       =    $request->type;
                                $campaign->voiceclip       =    $request->voiceclip;
                                $campaign->retry_attempt   =    $request->retry_attempt;
                                $campaign->retry_duration  =    $request->retry_duration;
                                $campaign->schedule        =    $request->schedule;
                                $campaign->dtmf_response   =    $dtmf_response;
                                $campaign->voice_credit    =    $needChargePerRecord;
                                $campaign->whtsapp_response=    $whatsapp_response;
                                
                                if($request->schedule == 1){
                                    $campaign->schedule_datetime          =    date('Y-m-d H:m:s',strtotime($request->schedule_datetime)); 
                                    $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
                                }
                                $campaign->save();
            
                                $campaignNew                        =   Campaign::find($campaign->id);
                                $campaignNew->excel_file_upload     =   "uploads/csv/" . $filename;
                                $campaignNew->save();
                                $file                               =   fopen($file_path, "r");
                                $i                                  =   0;
                                $numbers                            =   array();
                                $insert_data                        =   [];
                                if($request->type == 'transactional'){
                                    $remarks                   =    'Transcational Amount deducted';
                                    $transcation_type          =    2;
                                }else if($request->type == 'promotional'){
                                    $remarks                   =    'Promotional Amount deducted';
                                    $transcation_type          =    1;
                                }
            
                                $transcation                        =   new Transcation();
                                $transcation->user_id               =   Auth::user()->id;
                                $transcation->debit_amount          =   $totalChargePerCsv;
                                $transcation->credit_amount         =   0;
                                $transcation->remaining_amount      =   $remainingBalance;
                                $transcation->transcation_type      =   $transcation_type;
                                $transcation->remarks               =   $remarks;
                                $transcation->save();
                                $updateUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingBalance]);
            
                             
                                ///////////////////Create IdToken
                                $channelserver          =   Channel::where('ctsNumber',$request->service_no)->value('channelserver');
                                $createToken = CommonClass::campaignAuthToken($channelserver); 
                                //$createToken = CommonClass::campaignAuthToken(); 
                                $response   = json_decode($createToken);
                                $idToken    =   $response->idToken;
            
                                ///////////////////Create Campaign
                                $createOBDCampaign  =   CommonClass::createOBDCampaign($campaignName, $request->service_no, $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken);
        
                                $response                   =   json_decode($createOBDCampaign);
                                $capaignNameByApi           =   $response->campaign_ID;
                                $capaignRefIDByApi          =   $response->campaign_Ref_ID;
                                $campaignNew->campaignID    =   $capaignNameByApi;
                                $campaignNew->idToken       =   $idToken;
                                $campaignNew->campaignRefID = $capaignRefIDByApi;
                                $campaignNew->save();
                                $vipNumber = VipNumber::where('user_id', Auth::user()->id)
                                ->value('number');
                                $vipNumber = str_replace('"', '', $vipNumber);
                                $array = json_decode($vipNumber, true);
                                $data = Excel::toArray([], $file_path);
                                
                                $dataArray = $data[0];

                                                                
                                $dataNumbers = array_column(array_slice($dataArray, 1), 0);

                                // Extract numbers from $dataArray excluding the first row
                                $dataNumbers = array_column(array_slice($dataArray, 1), 0);

                                // Find common numbers between $array and $dataNumbers
                                $commonNumbers = array_intersect($array, $dataNumbers);

                                // Find non-common numbers between $dataNumbers and $array
                                $noncommonNumbers = array_diff($dataNumbers, $commonNumbers);

                                // Pick random non-common numbers from $noncommonNumbers
                                $randomKeys = array_rand($noncommonNumbers, $pickRowCount);
                                $ctsNumberArray = array_intersect_key($noncommonNumbers, array_flip($randomKeys));

                                // Find non-CTS numbers from $noncommonNumbers
                                $nonCtsNumbers = array_diff($noncommonNumbers, $ctsNumberArray);

                                
                              
                                dd($array, $commonNumbers, $ctsNumberArray, $nonCtsNumbers);
                                $headers = $data[0][0];
                                $insert_data                        =   [];
                                if($data){
                                    for ($i = 1; $i < count($data[0]); $i++) {
                                        $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                                        $mobileregex91   = "/^91[6-9][0-9]{9}$/";  
                                        $phoneNumber = $data[0][$i][0]; 
                                    
                                        if(preg_match($mobileregex, $phoneNumber) === 1 || preg_match($mobileregex91, $phoneNumber) === 1){
                                            $data1 = [
                                                'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                                                'user_id'                   =>  Auth::user()->id,
                                                'parent_id'                 =>  $parentId,
                                                'campaign_id'               =>  $campaign->id,
                                                'campg_id'                  =>  $capaignRefIDByApi,
                                                'lead_id'                   =>  '', 
                                                'lead_name'                 =>  '', 
                                                'cli'                       =>  $request->service_no,
                                                'mobile_no'                 =>  $phoneNumber,
                                                'retry_attempt'             =>  $request->retry_attempt,
                                                'retry_duration'            =>  $request->retry_duration,
                                                'call_duration'             =>  '',
                                                'call_credit'               =>  $needChargePerRecord,
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
                                }
            
                                $soundList          =   Sound::where('id',$request->voiceclip)->value('voiceclip');
                                $fullSoundFilePath  =   url($soundList);
        
                                $voiceUpload = CommonClass::campaignVoiceUpload($fullSoundFilePath, $idToken, $capaignNameByApi,$idToken); 
                        
                                echo $voiceUpload;
                               
                                ///////////////////Base upload 
                                $xlsFile = $file_path;
                                $baseUploadResponse  = CommonClass::APICampaignBaseLoad($xlsFile, $filename, $idToken, $capaignNameByApi, $request->service_no); 
        
                                echo $baseUploadResponse;
                                
                                if ($baseUploadResponse === false) {
            
                                }else{
                                    ///////////////////Start campaign
                                  // $cli = CommonClass::campaignStartStop($capaignNameByApi,$idToken,'S');
                                   echo $cli;
                                }
                                //dd($fullSoundFilePath, $voiceUpload,$baseUploadResponse, $cli);
                                Session::flash('success', 'Campaign created successfully');
                                return redirect()->route('usercampaignreplica.index');
                            }
                        }else{
                            Session::flash('error', 'Upload file error');
                            return redirect()->route('usercampaignreplica.index');
                        }
                    }elseif($request->upload_type =='manual'){
            
                        $msisdn  = array();
                        $menulaData = $request->input('manual_data');
                        preg_match_all('/\d+/', $menulaData, $matches);
                        $numbers = $matches[0];
                        $count = count($matches[0]);
                        
                        $totalChargePerCsv    =   $count * $needChargePerRecord;
            
                        if($userCredit < $totalChargePerCsv){
                            Session::flash('error', 'Your credit is low so please contact to you reseller');
                            return redirect()->route('usercampaignreplica.index');
                        }
                       
                        $schedule_datetime              =    '';
                        $campaignName                   =    $request->campaign_name.'_'.$currentDate;
                        $campaign                       =    new Campaign;
                        $campaign->service_no           =    $request->service_no;
                        $campaign->campaign_name        =    $campaignName;
                        $campaign->total_count          =    $count;
                        $campaign->user_id              =    Auth::user()->id;
                        $campaign->camp_type            =    $request->type;
                        $campaign->voiceclip            =    $request->voiceclip;
                        $campaign->retry_attempt        =    $request->retry_attempt;
                        $campaign->retry_duration       =    $request->retry_duration;
                        $campaign->voice_credit         =    $needChargePerRecord;
                        $campaign->schedule             =    $request->schedule;
                        $campaign->dtmf_response        =    $dtmf_response;
        
                            /////////////////////////////////
                            $insert_data                        =   [];
                            $excelNumber                        =   [];
                            $excelNumber[][]                    =   'msisdn';
                            foreach ($numbers as $nu) {
                                $mobileregex                    = "/^[6-9][0-9]{9}$/" ;
                                $mobileregex91                  = "/^91[6-9][0-9]{9}$/";  
                                $phoneNumber =  $nu;
                                if(preg_match($mobileregex, $phoneNumber) === 1 || preg_match($mobileregex91, $phoneNumber) === 1){
                                   
                                    $excelNumber[][]              =   $phoneNumber;
                                    }
                                }
                           
                             //   dd($excelNumber);
        
        
        
        
                        
                        
                        if($request->schedule == 1){
                            $campaign->schedule_datetime          =    date('Y-m-d h:m:s',strtotime($request->schedule_datetime)); 
                            $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
                        }
                        $campaign->save();
                        $campaignNew         =   Campaign::find($campaign->id);
                        
                        ///////////////////Create IdToken
                        $channelserver          =   Channel::where('ctsNumber',$request->service_no)->value('channelserver');
                        $createToken = CommonClass::campaignAuthToken($channelserver); 
                        //$createToken    =   CommonClass::campaignAuthToken(); 
                        $response       =   json_decode($createToken);
                        $idToken        =   $response->idToken;
        
                        if($idToken){
                            ////////////Create Campaign
                            $createOBDCampaign  =   CommonClass::createOBDCampaign($campaignName, $request->service_no, $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken);
        
                            $response                       =   json_decode($createOBDCampaign);
                            if($response){
                                $capaignNameByApi           =   $response->campaign_ID;
                                $capaignRefIDByApi          =   $response->campaign_Ref_ID;
                                $campaignNew->campaignID    =   $capaignNameByApi;
                                $campaignNew->idToken       =   $idToken;
                                $campaignNew->campaignRefID =   $capaignRefIDByApi;
                                $campaignNew->save();
                        
                                $insert_data                        =   [];
                                $excelNumber                        =   [];
                                $excelNumber[][]                    =   'msisdn';
                                foreach ($numbers as $nu) {
                                    $mobileregex                    = "/^[6-9][0-9]{9}$/" ;
                                    $mobileregex91                  = "/^91[6-9][0-9]{9}$/";  
                                    $phoneNumber =  $nu;
                                    if(preg_match($mobileregex, $phoneNumber) === 1 || preg_match($mobileregex91, $phoneNumber) === 1){
                                        $data = [
                                            'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                                            'user_id'                   =>  Auth::user()->id,
                                            'parent_id'                 =>  $parentId,
                                            'campaign_id'               =>  $campaign->id,
                                            'campg_id'                  =>  $capaignRefIDByApi,
                                            'lead_id'                   =>  '', 
                                            'lead_name'                 =>  '', 
                                            'cli'                       =>  $request->service_no,
                                            'mobile_no'                 =>  $phoneNumber,
                                            'retry_attempt'             =>  $request->retry_attempt,
                                            'retry_duration'            =>  $request->retry_duration,
                                            'call_duration'             =>  '',
                                            'call_credit'               =>  $needChargePerRecord,
                                            'actual_status'             =>  2,
                                            'status'                    =>  2,
                                            'data_type'                 =>  2,
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
                                        $insert_data[]             =    $data;
                                        $excelNumber[][]              =   $phoneNumber;
                                        }
                                    }
        
                                   // dd($excelNumber);
                                    
                                    $insert_data = collect($insert_data);
                                    $chunks = $insert_data->chunk(500);
                                    $voice_path = str_replace('uploads/soundclip/','',Sound::where('id',$request->voiceclip)->value('voiceclip'));
                                    foreach ($chunks as $chunk)
                                    {
                                        $msisdn                             =   array();
                                        DB::table('campaigndatas')->insert($chunk->toArray());
                                        
                                    }
                                    if($request->type == 'transactional'){
                                        $remarks                   =    'Transcational Amount deducted';
                                        $transcation_type          =    2;
                                    }else if($request->type == 'promotional'){
                                        $remarks                   =    'Promotional Amount deducted';
                                        $transcation_type          =    1;
                                    }
                    
                                    $folder = 'uploads/excel_files/';
                                    
                                    if (!file_exists($folder)) {
                                        mkdir($folder, 0777, true);
                                    }
                    
                                    $filename   =   'example_'.time().'_'.$authUserId.'.xlsx';
                                    
                                    $datanew1 = $folder . ''.$filename;
                                    Excel::store(new CampaignCreateExcelClass($excelNumber), $datanew1);
                    
                                    $remainingBalance                   =   $userCredit - $totalChargePerCsv;
                                    $transcation                        =   new Transcation();
                                    $transcation->user_id               =   Auth::user()->id;
                                    $transcation->debit_amount          =   $totalChargePerCsv;
                                    $transcation->credit_amount         =   0;
                                    $transcation->remaining_amount      =   $remainingBalance;
                                    $transcation->transcation_type      =   $transcation_type;
                                    $transcation->remarks               =   $remarks;
                                    $transcation->save();
                                    $updateUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingBalance]);
                                    // if($request->type == 'transactional'){
                                    //     $updateUserBalance = User::where('id',Auth::user()->id)->update(['transactional_wallet' => $remainingBalance]);
                                    // }else if($request->type == 'promotional'){
                                    //     $updateUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingBalance]);
                                    // }
                    
                                
                                $soundList          =   Sound::where('id',$request->voiceclip)->value('voiceclip');
                                $fullSoundFilePath  =   url($soundList);
                                $voiceUpload        =   CommonClass::campaignVoiceUpload($fullSoundFilePath, $idToken, $capaignNameByApi,$idToken,); 
                                
                                echo $voiceUpload;
            
                                
                                //////Base upload 
                                $xlsFile = storage_path('app').'/'.$datanew1;
                                $baseUploadResponse  = CommonClass::APICampaignBaseLoad($xlsFile, $filename, $idToken, $capaignNameByApi, $request->service_no); 
                                echo $baseUploadResponse;
        
                                if ($response === false) {
                    
                                }else{
                                    //////Start campaign
                                    $cli = CommonClass::campaignStartStop($capaignNameByApi,$idToken,'S');
                                    echo $cli;
                                }
                               
                                 /******/
                                Session::flash('success', 'Campaign created successfully');
                                return redirect()->route('usercampaignreplica.index');
                            }else{
                             return back(); 
                            }
                        }
                        else{
                            return back();
                        }
                    }else{
                        return back();
                    }
                } elseif ($futureDateTime->isFuture()) {
                    if($request->upload_type == 'csv'){
                        $filePath               =   $request->excel_file_upload;
                        $dataCount              =   Excel::toArray([], $filePath)[0];
                        $dataCount              =   array_filter($dataCount, function ($row) {
                                                        return !empty(array_filter($row));
                                                    });
                        $excelrowsLineCount     =   count($dataCount);
                        $destinationPath                =   public_path('uploads/csv');
                        if ($request->hasFile('excel_file_upload')) {
                            $csvFile                    =   $request->file('excel_file_upload');
                            $extension                  =   $csvFile->getClientOriginalExtension();
                            $filename                   =   str_replace('.'.$extension,'',$csvFile->getClientOriginalName()).'_'.time().'_'.$authUserId.'.'.$extension;
                            $csvFile->move($destinationPath, $filename);
                            $file_path                  =   $destinationPath.'/'.$filename;
                            $linecount                  =   $excelrowsLineCount-1  ;
                            
                            $totalChargePerCsv          =   $linecount * $needChargePerRecord;
                            if(($userCredit < $totalChargePerCsv) && ($planId == 0)){
                                Session::flash('error', 'Your credit is low so please contact to you reseller');
                                return redirect()->route('usercampaignreplica.index');
                            }else if($userCredit * 2.5 <= $totalChargePerCsv && $planId != 0){
                                Session::flash('error', 'Your credit is low so upload your file 2.5 times of credit');
                                return redirect()->route('usercampaignreplica.index');
                            }else{
                                if($planId != 0){
                                    $remainingBalance       =   $userCredit;
                                }else{
                                    $remainingBalance       =   $userCredit - $totalChargePerCsv;
                                }
                               
                                $campaignName              =   $request->campaign_name.'_'.$currentDate;
                                $schedule_datetime         =    '';
                                $campaign                  =    new Campaign;
                                $campaign->service_no      =    $request->service_no;
                                $campaign->campaign_name   =    $campaignName;
                                $campaign->total_count     =    $linecount;
                                $campaign->user_id         =    $authUserId;
                                $campaign->camp_type       =    $request->type;
                                $campaign->voiceclip       =    $request->voiceclip;
                                $campaign->retry_attempt   =    $request->retry_attempt;
                                $campaign->retry_duration  =    $request->retry_duration;
                                $campaign->schedule        =    $request->schedule;
                                $campaign->dtmf_response   =    $dtmf_response;
                                $campaign->voice_credit    =    $needChargePerRecord;
                                $campaign->cron_flag        =    1;
                                
                                if($request->schedule == 1){
                                    $campaign->schedule_datetime          =    date('Y-m-d H:m:s',strtotime($request->schedule_datetime)); 
                                    $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
                                }
                                $campaign->save();
            
                                $campaignNew                        =   Campaign::find($campaign->id);
                                $campaignNew->excel_file_upload     =   "uploads/csv/" . $filename;
                                $campaignNew->save();
                                $file                               =   fopen($file_path, "r");
                                $i                                  =   0;
                                $numbers                            =   array();
                                $insert_data                        =   [];
                                if($request->type == 'transactional'){
                                    $remarks                   =    'Transcational Amount deducted';
                                    $transcation_type          =    2;
                                }else if($request->type == 'promotional'){
                                    $remarks                   =    'Promotional Amount deducted';
                                    $transcation_type          =    1;
                                }
            
                                $transcation                        =   new Transcation();
                                $transcation->user_id               =   Auth::user()->id;
                                $transcation->debit_amount          =   $totalChargePerCsv;
                                $transcation->credit_amount         =   0;
                                $transcation->remaining_amount      =   $remainingBalance;
                                $transcation->transcation_type      =   $transcation_type;
                                $transcation->remarks               =   $remarks;
                                $transcation->save();
                                $updateUserBalance = User::where('id',Auth::user()->id)->update(['wallet' => $remainingBalance]);
            
                                Session::flash('success', 'Campaign created successfully');
                                return redirect()->route('usercampaignreplica.index');
                            }
                        }else{
                            Session::flash('error', 'Upload file error');
                            return redirect()->route('usercampaignreplica.index');
                        }
                    }elseif($request->upload_type =='manual'){
            
                        $msisdn  = array();
                        $menulaData = $request->input('manual_data');
                        preg_match_all('/\d+/', $menulaData, $matches);
                        $numbers = $matches[0];
                        $count = count($matches[0]);
                        
                        $totalChargePerCsv    =   $count * $needChargePerRecord;
            
                        if($userCredit < $totalChargePerCsv){
                            Session::flash('error', 'Your credit is low so please contact to you reseller');
                            return redirect()->route('usercampaignreplica.index');
                        }
                       
                        $schedule_datetime              =    '';
                        $campaignName                   =    $request->campaign_name.'_'.$currentDate;
                        $campaign                       =    new Campaign;
                        $campaign->service_no           =    $request->service_no;
                        $campaign->campaign_name        =    $campaignName;
                        $campaign->total_count          =    $count;
                        $campaign->user_id              =    Auth::user()->id;
                        $campaign->camp_type            =    $request->type;
                        $campaign->voiceclip            =    $request->voiceclip;
                        $campaign->retry_attempt        =    $request->retry_attempt;
                        $campaign->retry_duration       =    $request->retry_duration;
                        $campaign->voice_credit         =    $needChargePerRecord;
                        $campaign->schedule             =    $request->schedule;
                        $campaign->dtmf_response        =    $dtmf_response;
        
                        if($request->schedule == 1){
                            $campaign->schedule_datetime          =    date('Y-m-d h:m:s',strtotime($request->schedule_datetime)); 
                            $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
                        }
                        $campaign->save();
                       
                        /******/
                        Session::flash('success', 'Campaign created successfully');
                        return redirect()->route('usercampaignreplica.index');
                    }
                    else{
                        return back(); 
                    }
                }else{
                    Session::flash('error', 'You can not create campaign for previous date. Please try again with new date');
                    return redirect()->route('usercampaignreplica.index');  
                }
            } else {
                Session::flash('error', 'Please create campaign between 9AM to 9PM');
                return redirect()->route('usercampaignreplica.index');
            }
        }
        else {
            Session::flash('error', 'Please create campaign between 9AM to 9PM');
            return redirect()->route('usercampaignreplica.index');
        }
        
    }

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
        
        $campaign = Campaign::where('id',$id)->first();
        $campaignDate   =   $campaign->created_at;
        $campaignDate1days = Carbon::parse($campaign->created_at)->addDays(1);
        if(date('Y-m-d') == date('Y-m-d', strtotime($campaign->created_at))){
            $campaigndata = Campaigndata::where('campaign_id', $id); 
        }else{
            $campaigndata = Campaignoldata::where('campaign_id', $id)->whereDate('created_at', $campaignDate1days); 
        }
        $search = $request->search;
        if(strtolower($search) == 'answered'){
            $campaigndata = $campaigndata->Where('status',"1");
        } elseif(strtolower($search) == 'not answered'){
            $campaigndata = $campaigndata->Where('status',"0");
        }else{
            $campaigndata = $campaigndata->Where('mobile_no', 'LIKE', '%' . $search . '%');
        }
      
        $campaigndata = $campaigndata->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('user.campaignreplica.view', compact('campaigndata', 'paginate', 'search', 'sort_f', 'sort_by','campaignDate'));
    }

   
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function downloadFile($id)
    { 
        $campaign = Campaign::where('id',$id)->first();
        if(date('Y-m-d') == date('Y-m-d', strtotime($campaign->created_at))){
            // $campaigndata = Campaigndata::select('call_uuid','cli','mobile_no','call_remarks','dtmf_response','call_duration')->where('campaign_id', $id)->get();
             $campaigndata = Campaigndata::select('cli', 'mobile_no', 'call_remarks', 
                \DB::raw('CASE WHEN dtmf_response = 0 THEN "" ELSE dtmf_response END AS dtmf_response'), 
                'call_duration')
                ->where('campaign_id', $id)
                ->get();

                
            return Excel::download(new CampaignExportClass($campaigndata->take(200000)), 'report.xlsx');
        }else{
            // $campaigndata = Campaignoldata::select('call_uuid','cli','mobile_no','call_remarks','dtmf_response','call_duration')->where('campaign_id', $id)->get();
             $campaigndata = Campaignoldata::select('call_uuid', 'cli', 'mobile_no', 'call_remarks', 
                \DB::raw('CASE WHEN dtmf_response = 0 THEN "" ELSE dtmf_response END AS dtmf_response'), 
                'call_duration')
                ->where('campaign_id', $id)
                ->get();

            return Excel::download(new CampaignExportClass($campaigndata->take(200000)), 'report.xlsx');
        }
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

        $authUserId             =   Auth::user()->id;
        $newCampaignold         =   $campaign->getAttributes();
        $wallet                 =   DB::table('users')->where('id', '=', $authUserId)->value('wallet'); 
        $userPlanPrice          =   UserPlan::where('user_id', $authUserId)->value('price');
        $userCredit             =   $wallet;
        $userPlanType           =   UserPlan::where('user_id', '=', $authUserId)->value('plan_type');
        $voiceDuration          =   DB::table('sounds')->where('id', '=',$newCampaignold['voiceclip'] )->value('duration');
        $planId                 =   User::where('id', $authUserId)->value('user_plan');
        $needChargePerRecord    =   ceil($voiceDuration / $userPlanType);
        $countOfRows            =   count($campaigndata);
        $totalChargePerCsv      =   $countOfRows * $needChargePerRecord;
        


        if($userCredit < $totalChargePerCsv){
            Session::flash('error', 'Your credit is low so please contact to you reseller');
            return redirect()->route('usercampaignreplica.index');
        }else{
            if ($campaign) {
                $currentDate                        =       Carbon::now();
                $startTime                          =       Carbon::parse('09:00:00');
                $endTime                            =       Carbon::parse('21:00:00');

                $newCampaign                        =       new Campaign;
                
                
                $campaignName                       =       substr($newCampaignold['campaign_name'], 0, -20).'_'.$currentDate;
    
                $newCampaign->user_id               =       $newCampaignold['user_id'];
                $newCampaign->service_no            =       $newCampaignold['service_no'];
                $newCampaign->campaign_name         =       $campaignName;
                $newCampaign->camp_type             =       $newCampaignold['camp_type'];
                $newCampaign->voiceclip             =       $newCampaignold['voiceclip'];
                $newCampaign->total_count           =       $countOfRows;
                $newCampaign->status                =       $newCampaignold['status'];
                $newCampaign->camp_end_datetime     =       $newCampaignold['camp_end_datetime'];
                $newCampaign->retry_attempt         =       0;
                $newCampaign->schedule              =       0;
                $newCampaign->schedule_datetime     =       null;
                $newCampaign->excel_file_upload     =       null;
                $newCampaign->save();

                if($newCampaignold['dtmf_response'] == 1){
                    $dtmf_Req       =   'Y'; 
                    $dtmf_length    =   '1';
                    $dtmf_response  =   1;
                }else{
                    $dtmf_Req       =   'N'; 
                    $dtmf_length    =   ''; 
                    $dtmf_response  =   0;
                }
                $campSchDate        =   $currentDate->toDateString();
                $campStartTime      =   $startTime->toTimeString();
                $campEndTime        =   $endTime->toTimeString();
                $retry_Count            =  "0";
                $retry_duration         =   "";

                ///////////////////Create IdToken
                $channelserver          =   Channel::where('ctsNumber',$request->service_no)->value('channelserver');
                $createToken = CommonClass::campaignAuthToken($channelserver); 
                //$response       =   json_decode($createToken);
                $idToken        =   $response->idToken;
                echo $idToken;
                if($idToken){
                    $createOBDCampaign  =   CommonClass::createOBDCampaign($campaignName, $newCampaignold['service_no'], $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken);
                    $response                       =   json_decode($createOBDCampaign);
                    // dd($response->campaign_ID);
                    if($response){
                       
                        $capaignNameByApi           =   $response->campaign_ID;
                        $capaignRefIDByApi          =   $response->campaign_Ref_ID;
                        $newCampaign->campaignID    =   $capaignNameByApi;
                        $newCampaign->idToken       =   $idToken;
                        $newCampaign->campaignRefID =   $capaignRefIDByApi;
                        $newCampaign->save();

                        $soundList          =   Sound::where('id',$newCampaignold['voiceclip'])->value('voiceclip');
                        $fullSoundFilePath  =   url($soundList);
                        $voiceUpload        =   CommonClass::campaignVoiceUpload($fullSoundFilePath, $idToken, $capaignNameByApi,$idToken); 
                        
                        echo $voiceUpload;

                        $insert_data                        =       [];
                        $excelNumber                        =       [];
                        $excelNumber[][]                    =       'msisdn';
                        foreach ($campaigndata as $item) {
                            $mobileregex                    = "/^[6-9][0-9]{9}$/" ;
                            $mobileregex91                  = "/^91[6-9][0-9]{9}$/";  
                            $phoneNumber                    =  $item->mobile_no;
                            if(preg_match($mobileregex, $phoneNumber) === 1 || preg_match($mobileregex91, $phoneNumber) === 1){
                                $data = [
                                    'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                                    'user_id'                   =>  $authUserId,
                                    'campaign_id'               =>  $campaign->id,
                                    'campg_id'                  =>  $capaignRefIDByApi,
                                    'lead_id'                   =>  '', 
                                    'lead_name'                 =>  '', 
                                    'cli'                       =>  $newCampaignold['service_no'],
                                    'mobile_no'                 =>  $phoneNumber,
                                    'retry_attempt'             =>  $newCampaignold['retry_attempt'],
                                    'retry_duration'            =>  $newCampaignold['retry_duration'],
                                    'call_duration'             =>  '',
                                    'actual_status'             =>  2,
                                    'status'                    =>  2,
                                    'data_type'                 =>  2,
                                    'dtmf_response'             =>  0,
                                    'call_start_ts'             => '',
                                    'call_connect_ts'           => '',
                                    'call_end_ts'               => '',
                                    'body'                      => '',
                                    'call_uuid'                 => 0,
                                    'created_at'                => date('Y-m-d H:i:s'),
                                    'updated_at'                => date('Y-m-d H:i:s'),
                                ];
                                $insert_data[]             =    $data;
                                $excelNumber[][]           =   $phoneNumber;
                                }
                            }
                            

                        $insert_data = collect($insert_data);
                        //$chunks = $insert_data->chunk(500);
                       
                        $chunks = $insert_data->chunk(500);
                        foreach ($chunks as $chunk)
                        {
                            DB::table('campaigndatas')->insert($chunk->toArray());
                        }
                       
                        $voice_path = str_replace('uploads/soundclip/','',Sound::where('id',$newCampaignold['voiceclip'])->value('voiceclip'));   
                        
                       $folder = 'uploads/excel_files/';

                        if (!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                        }
            
                        $filename   =   'example_'.time().'_'.$authUserId.'.xlsx';
                        
                        $datanew1 = $folder . ''.$filename;
                        Excel::store(new CampaignCreateExcelClass($excelNumber), $datanew1);
                        $remarks                   =    'Transcational Amount deducted';
                        $transcation_type          =    2;

                        $remainingBalance                   =   $userCredit - $totalChargePerCsv;
                        $transcation                        =   new Transcation();
                        $transcation->user_id               =   Auth::user()->id;
                        $transcation->debit_amount          =   $totalChargePerCsv;
                        $transcation->credit_amount         =   0;
                        $transcation->remaining_amount      =   $remainingBalance;
                        $transcation->transcation_type      =   $transcation_type;
                        $transcation->remarks               =   $remarks;
                        $transcation->save();
                        $updateUserBalance =  User::where('id',Auth::user()->id)->update(['wallet' => $remainingBalance]);

                        //////Base upload 
                        $xlsFile = storage_path('app').'/'.$datanew1;

                        $baseUploadResponse  = CommonClass::APICampaignBaseLoad($xlsFile, $filename, $idToken, $capaignNameByApi, $newCampaignold['service_no']); 
                        if ($response === false) {
                            echo "hello";
                        }else{
                            //////Start campaign
                            //$cli = CommonClass::campaignStartStop($capaignNameByApi,$idToken,'S');
                            echo $cli;
                        }
                        Session::flash('success', 'Campaign created successfully');
                        //return redirect()->route('usercampaignreplica.index');

                    }else{
                        dd('Else', $response);
                    }
                    dd("hello");
                    
                }
               
              dd("hlell"); 
                
            }else {
                Session::flash('error', 'Upload file error');
                return back(); 
            } 
           
        }

       
    }

    public function campaignMonthData(){
        $soundType      =   CommonClass::getSoundsType();
        $soundList      =   Sound::select('id', 'name')->where('user_id',Auth::user()->id)->where('status',1)->get();
        return view('user.user.campaignreplica.createmonth', compact('soundType','soundList'));
    }

    public function campaignMonthDataStore(Request $request){
        $this->validate($request, [

        ]);

        if($request->whatsapp_response == 'yes'){
            $user_id        =   Auth::user()->id;
            $row            =   ThirdPartySetting::where('type','whatsapp')->where('user_id',$user_id)->first();
            if(!$row){
                Session::flash('error', 'Please add whatsapp Setting Details first for sending whatsapp message');
                return redirect()->route('usercampaignreplica.index');
            }
            $whatsapp_response  =   1;
        }else{
            $whatsapp_response  =   0;
        }

        $dtmf_response  =   0;
        if($request->dtmf_response == 'yes'){
            $dtmf_response  =   1;
        }

        $authUserId             =   Auth::user()->id;
        $campaigntype           =   0;
        $userData               =   DB::table('users')->where('id', '=', Auth::user()->id)->first(); 
        $parentId               =   $userData->parent_id;
        
        $userPlanPrice          =   UserPlan::where('user_id', Auth::user()->id)->value('price');
        $userPlanType           =   UserPlan::where('user_id', '=', Auth::user()->id)->value('plan_type');
	    $voiceDuration          =   DB::table('sounds')->where('id', '=',$request->voiceclip )->value('duration');
        $planId                 =   User::where('id', Auth::user()->id)->value('user_plan');

        $daily_msg              =   Plan::where('id',$planId)->value('daily_msg');
        $userPlan               =   Userwiseplan::where('user_id', Auth::user()->id)->first();
        $startDate              =   $userPlan->start_date;
        $endDate                =   $userPlan->end_date;

        //dd($daily_msg, $planId, $userPlan->start_date, $request->all());
        $needChargePerRecord    =   ceil($voiceDuration / $userPlanType);
        
        $filePath               =   $request->excel_file_upload;
        $destinationPath        =   public_path('uploads/csv');
        if ($request->hasFile('excel_file_upload')) {
            $csvFile                    =   $request->file('excel_file_upload');
            $extension                  =   $csvFile->getClientOriginalExtension();
            $filename                   =   str_replace('.'.$extension,'',$csvFile->getClientOriginalName()).'_'.time().'_'.$authUserId.'.'.$extension;
            $csvFile->move($destinationPath, $filename);
           
            $campaign                   =    new CampaignMonthUpload;
            $campaign->user_id          =    $authUserId;
            $campaign->parent_id        =    $parentId;
            $campaign->campaign_name    =    $request->campaign_name;
            $campaign->service_no       =    $request->service_no;
            $campaign->camp_type        =    $request->type;
            $campaign->voiceclip        =    $request->voiceclip;
            $campaign->retry_attempt    =    $request->retry_attempt;
            $campaign->retry_duration   =    $request->retry_duration;
            $campaign->dtmf_response    =    $dtmf_response;
            $campaign->excel_file_upload     =   "uploads/csv/" . $filename;
            $campaign->voice_credit     =    $needChargePerRecord;
            $campaign->whtsapp_response =    $whatsapp_response;
            $campaign->days             =    0;
            $campaign->daily_limit      =    $daily_msg;
            $campaign->start_date       =    $startDate;
            $campaign->end_date         =    $endDate;
            $campaign->status           =    1;
            $campaign->flag             =    0;
            $campaign->save(); 
        }
        Session::flash('success', 'Campaign proceed successfully');
		return redirect()->route('usercampaignreplica.index');

    }

   

    public function destroy($id)
    {
        //
    }


}