<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\CommonClass;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\Campaignoldata;
use App\Models\Sound;
use App\Models\Transcation;
use App\Models\User;
use App\Models\Ukey;
use App\Models\UserDetail;
use App\Models\UserPlan;
use App\Models\Plan;
use Session;
use Storage;
use Auth, DB, CURLFILE;
use App\Exports\CampaignExportClass;
use App\Jobs\CampaignJob;
use App\Jobs\CampaignApiCallJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
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
        //$campaign = Campaign::where('user_id',Auth::user()->id)->get();
        $campaign = Campaign::select('*')->where('user_id',Auth::user()->id);
        
        if ($search) {
            $campaign = $campaign->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',total_count)"), 'LIKE', '%' . $search . '%');
            });
        }
        $campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('user.campaign.index', compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by'));
    }

    public function create()
    {
     
        $soundType      =   CommonClass::getSoundsType();
        $soundList      =   Sound::select('id', 'name')->where('user_id',Auth::user()->id)->where('status',1)->get();
        return view('user.campaign.create', compact('soundType','soundList'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
      
        $authUserId             =   Auth::user()->id;
        $currentDate            =   Carbon::now();
        $startTime              =   Carbon::parse('09:00:00');
        $endTime                =   Carbon::parse('21:00:00');
        $campaigntype           =   0;
        $wallet                 =   DB::table('users')->where('id', '=', Auth::user()->id)->value('wallet'); 
        $userPlanPrice          =   UserPlan::where('user_id', Auth::user()->id)->value('price');
        $userCredit             =   $wallet;
        $userPlanType           =   UserPlan::where('user_id', '=', Auth::user()->id)->value('plan_type');
        $voiceDuration          =   DB::table('sounds')->where('id', '=',$request->voiceclip )->value('duration');

        $planId                 =   User::where('id', Auth::user()->id)->value('user_plan');
        
        
        
      
        if($request->type == 'transactional'){
            $campaigntype           =   4;
        }else if($request->type == 'promotional'){
            $campaigntype           =   3;
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
            $futureDateTime     = Carbon::parse($request->schedule_datetime);
        }else{
            $campSchDate        =   $currentDate->toDateString();
            $campStartTime      =   $startTime->toTimeString();
            $campEndTime        =   $endTime->toTimeString();
            $futureDateTime     =   Carbon::now();
        }
        
        $needChargePerRecord                =   ceil($voiceDuration / $userPlanType);
        // Check if the future date time is between 9 am and 9 pm
        if ($futureDateTime->greaterThanOrEqualTo($currentDate) && $futureDateTime->between($startTime, $endTime)) {
            if($request->upload_type == 'csv'){
                $filePath               =   $request->excel_file_upload;
                $dataCount              =   Excel::toArray([], $filePath)[0];
                $dataCount              =   array_filter($dataCount, function ($row) {
                                                return !empty(array_filter($row));
                                            });
                $excelrowsLineCount     =   count($dataCount);
                dd($dataCount, $excelrowsLineCount);
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
                        return redirect()->route('usercampaign.index');
                    }else if($userCredit * 2.5 <= $totalChargePerCsv && $planId != 0){
                        Session::flash('error', 'Your credit is low so upload your file 2.5 times of credit');
                        return redirect()->route('usercampaign.index');
                    }else{
                        if($planId != 0){
                            if($totalChargePerCsv > $userCredit){
                                $remainingBalance       =   0;
                            }else{
                                $remainingBalance       =   $userCredit - $totalChargePerCsv; 
                            }
                        }else{
                            $remainingBalance          =   $userCredit - $totalChargePerCsv;
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
                        $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/AuthToken";
                                    
                        $fields  =array(
                            'username' => 'Daksh',
                            'password' => 'Daksh@123',
                        );
                    
                        $payload = json_encode($fields);
                        $headers = array('Content-Type: application/json');
                        $curl_session = curl_init();
                        curl_setopt($curl_session, CURLOPT_URL, $apiPath);
                        curl_setopt($curl_session, CURLOPT_POST, true);
                        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl_session, CURLOPT_ENCODING, '');
                        curl_setopt($curl_session, CURLOPT_MAXREDIRS, 10);
                        curl_setopt($curl_session, CURLOPT_TIMEOUT, 0);
                        curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
                        $response = curl_exec($curl_session);
                        curl_close($curl_session);
                        $response   = json_decode($response);
                        $idToken    =   $response->idToken;
    
                        ////////////Create Campaign
                        $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/createOBDCampaign";
                
                        $fields  =array(
                            'campaign_Name'                 =>  $campaignName,
                            'description'                   =>  $campaignName,
                            'campaign_Type'                 =>  '3',
                            'dni'                           =>   $request->service_no,
                            'from_Date'                     =>  $campSchDate,
                            'to_Date'                       =>  $campSchDate,
                            'from_Time'                     =>  $campStartTime,
                            'to_Time'                       =>  $campEndTime,
                            'dial_Timeout'                  =>  '30',
                            'retry_Interval_Type'           =>  '0',
                            'retry_Interval_Value'          =>  '',
                            'retry_Count'                   =>  '0',
                            'api_Req'                       =>  'Y',
                            'pingback_URL'                  =>  'https://myvoicecall.com/api/obdVodaCallBack',
                            'welcome_Prompt'                =>  'N',
                            'dtmf_Req'                      =>  $dtmf_Req,
                            'dtmf_Length'                   =>  $dtmf_length,
                            'dtmf_Retry'                    =>  '0',
                            'retry_Limit_Exceeded_Prompt'   =>  'N',
                            'thanks_Prompt'                 =>  'N',
                        );  
    
                        $payload = json_encode($fields);
                        $headers = array(
                            'Content-Type: application/json',
                            'Authorization: Bearer '.$idToken
                        );
    
                        $curl_session = curl_init();
                        curl_setopt($curl_session, CURLOPT_URL, $apiPath);
                        curl_setopt($curl_session, CURLOPT_POST, true);
                        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl_session, CURLOPT_ENCODING, '');
                        curl_setopt($curl_session, CURLOPT_MAXREDIRS, 10);
                        curl_setopt($curl_session, CURLOPT_TIMEOUT, 0);
                        curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
                        $response = curl_exec($curl_session);
                        $response  = json_decode($response);
                        curl_close($curl_session);
                        $capaignNameByApi       =   $response->campaign_ID;
                        $capaignRefIDByApi      =   $response->campaign_Ref_ID;
                        $campaignNew->campaignID  =   $capaignNameByApi;
                        $campaignNew->idToken   =   $idToken;
                        $campaignNew->campaignRefID = $capaignRefIDByApi;
                        $campaignNew->save();
    
                        $data = Excel::toArray([], $file_path);
                        $headers = $data[0][0];
                        $insert_data                        =   [];
                        if($data){
                            for ($i = 1; $i < count($data[0]); $i++) {
                                $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                                $phoneNumber = $data[0][$i][0]; 
                            
                                if(preg_match($mobileregex, $phoneNumber) === 1){
                                    $data1 = [
                                        'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                                        'user_id'                   =>  Auth::user()->id,
                                        'campaign_id'               =>  $campaign->id,
                                        'campg_id'                  =>  $capaignRefIDByApi,
                                        'lead_id'                   =>  '', 
                                        'lead_name'                 =>  '', 
                                        'cli'                       =>  $request->service_no,
                                        'mobile_no'                 =>  $phoneNumber,
                                        'retry_attempt'             =>  $request->retry_attempt,
                                        'retry_duration'            =>  $request->retry_duration,
                                        'call_duration'             =>  '',
                                        'actual_status'             =>  2,
                                        'status'                    =>  2,
                                        'data_type'                 =>  1,
                                        'dtmf_response'             =>  0,
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
                             $insert_data = collect($insert_data);
                            $chunkCound = 1000;
                            $chunks = $insert_data->chunk($chunkCound);
                            foreach ($chunks as $chunk)
                            {
                                DB::table('campaigndatas')->insert($chunk->toArray());
                            }
                        }
    
                        
                        $soundList      =   Sound::where('id',$request->voiceclip)->value('voiceclip');
                        $fullSoundFilePath  =   url($soundList);
                        
                        $curl = curl_init();
    
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/voiceUpload?campaign_ID=' . $capaignNameByApi . '&voice_File_Type=C',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($fullSoundFilePath, 'audio/wav', 'file')),
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$idToken
                        ),
                        ));
                    
                        $response = curl_exec($curl);
                    
                        curl_close($curl);
                    
                        //////Base upload 
                         //$xlsFile = 'https://dakshgroup.in/digitalmarketing/public/uploads/soundclip/newfile/sample.xlsx';
                        $curl = curl_init();
                        $xlsFile = $file_path;
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/APICampaignBaseLoad',
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => '',
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => 'POST',
                          CURLOPT_POSTFIELDS => array('campaign_ID' => $capaignNameByApi,'dni' => $request->service_no,'file'=> new CURLFILE($xlsFile, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $filename)),
                          CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$idToken
                          ),
                        ));
                        
                        $response = curl_exec($curl);
                        
                        curl_close($curl);
                        echo $response;
                        if ($response === false) {
    
                        }else{
                            //////Start campaign
                            $curl = curl_init();
    
                            curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/StartorStop',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS =>'{
                                "campaign_ID": "'.$capaignNameByApi.'", 
                                "status":"S"	
                            }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json',
                                'Authorization: Bearer '.$idToken
                                ),
                            ));
    
                            $response = curl_exec($curl);
    
                            curl_close($curl);
                            echo $response;
                           
                        }
                        
                        Session::flash('success', 'Campaign created successfully');
                        return redirect()->route('usercampaign.index');
                    }
                }else{
                    Session::flash('error', 'Upload file error');
                    return redirect()->route('usercampaign.index');
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
                    return redirect()->route('usercampaign.index');
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
                $campaign->schedule             =    $request->schedule;
                $campaign->dtmf_response        =    $dtmf_response;
                
                
                if($request->schedule == 1){
                    $campaign->schedule_datetime          =    date('Y-m-d h:m:s',strtotime($request->schedule_datetime)); 
                    $schedule_datetime                    =    date('d-M-Y h:m:s',strtotime($request->schedule_datetime));
                }
                $campaign->save();
                $campaignNew                        =   Campaign::find($campaign->id);
                
                
                /******/
                ///////////////////Create IdToken
                $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/AuthToken";
                                    
                $fields  =array(
                    'username' => 'Daksh',
                    'password' => 'Daksh@123',
                );
            
                $payload = json_encode($fields);
                $headers = array('Content-Type: application/json');
                $curl_session = curl_init();
                curl_setopt($curl_session, CURLOPT_URL, $apiPath);
                curl_setopt($curl_session, CURLOPT_POST, true);
                curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl_session, CURLOPT_ENCODING, '');
                curl_setopt($curl_session, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl_session, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
                $response = curl_exec($curl_session);
                curl_close($curl_session);
                $response   = json_decode($response);
                $idToken    =   $response->idToken;
    
                ////////////Create Campaign
                $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/createOBDCampaign";
                
                $fields  =array(
                    'campaign_Name'                 =>  $campaignName,
                    'description'                   =>  $campaignName,
                    'campaign_Type'                 =>  '3',
                    'dni'                           =>   $request->service_no,
                    'from_Date'                     =>  $campSchDate,
                    'to_Date'                       =>  $campSchDate,
                    'from_Time'                     =>  $campStartTime,
                    'to_Time'                       =>  $campEndTime,
                    'dial_Timeout'                  =>  '22',
                    'retry_Interval_Type'           =>  '0',
                    'retry_Interval_Value'          =>  '',
                    'retry_Count'                   =>  '0',
                    'api_Req'                       =>  'Y',
                    'pingback_URL'                  =>  'https://myvoicecall.com/api/obdVodaCallBack',
                    'welcome_Prompt'                =>  'N',
                    'dtmf_Req'                      =>  $dtmf_Req,
                    'dtmf_Length'                   =>  $dtmf_length,
                    'dtmf_Retry'                    =>  '0',
                    'retry_Limit_Exceeded_Prompt'   =>  'N',
                    'thanks_Prompt'                 =>  'N',
                );  
    
             
                if($idToken){
                    $payload = json_encode($fields);
                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$idToken
                );
    
                $curl_session = curl_init();
                curl_setopt($curl_session, CURLOPT_URL, $apiPath);
                curl_setopt($curl_session, CURLOPT_POST, true);
                curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl_session, CURLOPT_ENCODING, '');
                curl_setopt($curl_session, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl_session, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
                $response = curl_exec($curl_session);
               
                
              //  dd($fields, $response);
                $response  = json_decode($response);
                curl_close($curl_session);
                if($response){
                    
                
                $capaignNameByApi       =   $response->campaign_ID;
                $capaignRefIDByApi      =   $response->campaign_Ref_ID;
                $campaignNew->campaignID  =   $capaignNameByApi;
                $campaignNew->idToken   =   $idToken;
                $campaignNew->campaignRefID = $capaignRefIDByApi;
                $campaignNew->save();
                
                $insert_data                        =   [];
                $excelNumber                        =   [];
                $excelNumber[][]                    =   'msisdn';
                foreach ($numbers as $nu) {
                    $mobileregex = "/^[6-9][0-9]{9}$/" ;  
                    $phoneNumber =  $nu;
                    if(preg_match($mobileregex, $phoneNumber) === 1){
                        $data = [
                            'campaignId_mobileno'       =>  $campaign->id.'-'.$phoneNumber,
                            'user_id'                   =>  Auth::user()->id,
                            'campaign_id'               =>  $campaign->id,
                            'campg_id'                  =>  $capaignRefIDByApi,
                            'lead_id'                   =>  '', 
                            'lead_name'                 =>  '', 
                            'cli'                       =>  $request->service_no,
                            'mobile_no'                 =>  $phoneNumber,
                            'retry_attempt'             =>  $request->retry_attempt,
                            'retry_duration'            =>  $request->retry_duration,
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
                        $excelNumber[][]              =   $phoneNumber;
                        }
                    }
                    
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
    
                
                $soundList      =   Sound::where('id',$request->voiceclip)->value('voiceclip');
                $fullSoundFilePath  =   url($soundList);
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/voiceUpload?campaign_ID=' . $capaignNameByApi . '&voice_File_Type=C',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($fullSoundFilePath, 'audio/wav', 'file')),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$idToken
                ),
                ));
            
                $response = curl_exec($curl);
            
                curl_close($curl);
                echo $response;
    
    
                //////Base upload 
                 //$xlsFile = 'https://dakshgroup.in/digitalmarketing/public/uploads/soundclip/newfile/sample.xlsx';
                $curl = curl_init();
                $xlsFile = storage_path('app').'/'.$datanew1;
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/APICampaignBaseLoad',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => array('campaign_ID' => $capaignNameByApi,'dni' => $request->service_no,'file'=> new CURLFILE($xlsFile, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $filename)),
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$idToken
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                if ($response === false) {
    
                }else{
                    //////Start campaign
                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/StartorStop',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "campaign_ID": "'.$capaignNameByApi.'", 
                        "status":"S"	
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$idToken
                        ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
                    echo $response;
                }
                /******/
                    Session::flash('success', 'Campaign created successfully');
                    return redirect()->route('usercampaign.index');
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
        } else {
            Session::flash('error', 'Please create campaign between 9AM to 9PM');
            return redirect()->route('usercampaign.index');
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
        if(date('Y-m-d') == date('Y-m-d', strtotime($campaign->created_at))){
            $campaigndata = Campaigndata::where('campaign_id', $id); 
        }else{
            $campaigndata = Campaignoldata::where('campaign_id', $id); 
        }
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
        
      
        $campaigndata = $campaigndata->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('user.campaign.view', compact('campaigndata', 'paginate', 'search', 'sort_f', 'sort_by'));
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
             $campaigndata = Campaigndata::select('call_uuid','cli','mobile_no','call_remarks','dtmf_response','call_duration')->where('campaign_id', $id)->get();
        return Excel::download(new CampaignExportClass($campaigndata->take(200000)), 'report.xlsx');
        }else{
             $campaigndata = Campaignoldata::select('call_uuid','cli','mobile_no','call_remarks','dtmf_response','call_duration')->where('campaign_id', $id)->get();
        return Excel::download(new CampaignExportClass($campaigndata->take(200000)), 'report.xlsx');
        }
        
    
    }

    public function destroy($id)
    {
        //
    }


}