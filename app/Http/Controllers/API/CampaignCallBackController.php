<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\APIBaseController as APIBaseController;
use Illuminate\Http\Request;
use App\Models\Campaigndata;
use App\Models\Campaign;
use App\Models\AgentData;
use App\Models\LoginLog;
use App\Models\SipLog;
use App\Models\ThirdPartySetting;
use App\Models\ApiLog;
//use Illuminate\Support\Facades\DB;
use Validator;

class CampaignCallBackController extends APIBaseController
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function obdcallback(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'mobile_no'         => 'required',
            'lead_name'         => 'required',
            'refno'             => 'required',
            'cli'               => 'required',
            'call_status'       => 'required',
            'call_uuid'         => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data is InComplete');
        }

        $campaign = Campaigndata::where('mobile_no',$request->mobile_no)->where('refno',$request->refno)->value('id');
        if(isset($campaign)){
            $campaignData = Campaigndata::findorfail($campaign);

            $campaignData->lead_name        =   $request->lead_name;
            $campaignData->call_start_ts    =   $request->call_start_ts;
            $campaignData->call_connect_ts  =   $request->call_connect_ts;
            $campaignData->call_end_ts      =   $request->call_end_ts;
            $campaignData->call_duration    =   $request->bill_duration;
            $campaignData->call_remarks     =   $request->call_remarks;
            $campaignData->call_uuid        =   $request->call_uuid;
            $campaignData->actual_status    =   $request->call_status;
            $campaignData->status           =   $request->call_status;
            $campaignData->body             =   $request->all();
            $campaignData->save();
            
            $response = [
                 'success' => '1',
                'message' => 'Data Updated Successfully',
            ];
            return response()->json($response, 200); 
        }else{
            $response = [
                'success' => '0',
               'message' => 'No Data found',
           ];
           return response()->json($response, 200); 
        }
        
    }

    public function obdVideoConCallback(Request $request)
    {
        
        $input = $request->all();
        $validator = Validator::make($input, [
            'campaign_id'         => 'required',    //in DB its refno
            'service_type'        => 'required',    
            'call_id'             => 'required',
            'a_dial_status'       => 'required',
        ]);
        
        $response = [
                'success' => '0',
               'message' => 'No Data found',
           ];
           return response()->json($response, 200); 

        // if ($validator->fails()) {
        //     return $this->sendError('Data is InComplete');
        // }

        // $campaign = Campaigndata::where('mobile_no',$request->mobile_no)->where('refno',$request->refno)->value('id');
        // if(isset($campaign)){
        //     $campaignData = Campaigndata::findorfail($campaign);

        //     $campaignData->lead_name        =   $request->lead_name;
        //     $campaignData->call_start_ts    =   $request->call_start_ts;
        //     $campaignData->call_connect_ts  =   $request->call_connect_ts;
        //     $campaignData->call_end_ts      =   $request->call_end_ts;
        //     $campaignData->call_duration    =   $request->bill_duration;
        //     $campaignData->call_remarks     =   $request->call_remarks;
        //     $campaignData->call_uuid        =   $request->call_uuid;
        //     $campaignData->actual_status    =   $request->call_status;
        //     $campaignData->status           =   $request->call_status;
        //     $campaignData->body             =   $request->all();
        //     $campaignData->save();
            
        //     $response = [
        //          'success' => '1',
        //         'message' => 'Data Updated Successfully',
        //     ];
        //     return response()->json($response, 200); 
        // }else{
        //     $response = [
        //         'success' => '0',
        //        'message' => 'No Data found',
        //    ];
        //    return response()->json($response, 200); 
        // }
        
    }
    
    
    public function obdVodaCallBack(Request $request)
    {
        $input = $request->all();
        $loginLog = new LoginLog;
        $loginLog->user_id = 15555;
        $loginLog->login_date = date("Y-m-d");
        $loginLog->login_time = date("H:i:s");
        $loginLog->login_mode = "API_application";
        $loginLog->login_type = "2";
        $loginLog->phone_model = json_encode($input);
        $loginLog->created_at = date("Y-m-d H:i:s");
        $loginLog->updated_at = date("Y-m-d H:i:s");
        $loginLog->save();


       
        $validator = Validator::make($input, [
            'A_PARTY_NO'        => 'required',
            'CAMPAIGN_REF_ID'       => 'required',
         ]);

        if ($validator->fails()) {
            return $this->sendError('Data is InComplete');
        }

         $campaign = Campaigndata::where('mobile_no',$request->A_PARTY_NO)->where('campg_id',$request->CAMPAIGN_REF_ID)->first();
        if ($campaign) {
            $callStatus                    =  0;
            if($request->A_DIAL_STATUS == 'Connected'){
              $callStatus                    =  1;
            }
            // Record exists, update the values
            $campaign->update([
                'lead_name'         =>      '',
                'call_start_ts'     =>      $request->CALL_START_TIME,
                'call_connect_ts'   =>      $request->A_PARTY_CONNECTED_TIME,
                'call_end_ts'       =>      $request->A_PARTY_END_TIME,
                'call_duration'     =>      $request->OG_DURATION,
                'call_remarks'      =>      $request->A_DIAL_STATUS,
                'call_uuid'         =>      $request->CALL_ID,
                'dtmf_response'     =>      $request->DTMF,
                'actual_status'     =>      $callStatus,
                'status'            =>      $callStatus,
                'body'              =>      $request->all(),
            ]);

            $response = [
                'success' => '1',
               'message' => 'Data Updated Successfully',
           ];
           
            if($request->DTMF != null){
                $campaignData = Campaigndata::findorfail($campaign->id);
                $whstapp=   $campaignData->whtsapp_response;
                $userId        =    $campaignData->user_id;
                if($whstapp == 1){
                    $row                =   ThirdPartySetting::where('type','whatsapp')->where('user_id',$userId)->first();
                    $curl = curl_init();
                    $mobileNo   =   '91'.$request->A_PARTY_NO;
                    //$mobileNo   =   '917014204712';
                    $apiPath    =   $row->api_path;
        
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $apiPath,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "type": "template",
                        "templateId": "'.$row->temp_id.'",
                        "templateLanguage": "'.$row->temp_ln.'",
                        "templateArgs": [],
                        "sender_phone": "'.$mobileNo.'"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    echo $response;

                }

                if($userId == 127){
                    $curl = curl_init();
                    $mobileNo   =   '91'.$request->A_PARTY_NO;
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.dakshinfosoft.com/api/sendhttp.php?authkey=9655Aw45mI9N6602bf36P11&mobiles='.$mobileNo.'&message=Thanks%20for%20support%0AJOIN%20MODI%20PARIVAR%0AABKI%20BAR%20400%20PAAR%0AMANJU%20SHARMA%20JAIPUR%0AWHATSAPP%20CHANEL%20https://whatsapp.com/channel/0029Va7IiKM5vKA8gEXjFI1H&&sender=MANJU&route=4&country=91&DLT_TE_ID=1707171152951612923',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                      'Cookie: PHPSESSID=h35f052a3ipbaric5gp3t44190'
                    ),
                  ));
                  
                  $response = curl_exec($curl);
                  echo 'Chalo';
                  print_r($response);
                  curl_close($curl);
                }


                if($userId == 233){
                    $curl = curl_init();
                    $mobileNo   =   '91'.$request->A_PARTY_NO;
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.dakshinfosoft.com/api/sendhttp.php?authkey=9655Aw45mI9N6602bf36P11&mobiles='.$mobileNo.'&message=Thanks%20for%20support%0AJOIN%20MODI%20PARIVAR%0AABKI%20BAR%20400%20PAAR%0AMANJU%20SHARMA%20JAIPUR%0AWHATSAPP%20CHANEL%20https://whatsapp.com/channel/0029Va7IiKM5vKA8gEXjFI1H&&sender=MANJU&route=4&country=91&DLT_TE_ID=1707171152951612923',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                      'Cookie: PHPSESSID=h35f052a3ipbaric5gp3t44190'
                    ),
                  ));
                  
                  $response = curl_exec($curl);
                  curl_close($curl);
                }
            }
           return response()->json($response, 200); 
        } else{
            $response = [
                'success' => '0',
               'message' => 'No Data found',
           ];
           return response()->json($response, 200); 
        }
        
    }
    
    public function agentCallingCallback(Request $request)
    {
        $input = $request->all();
        $loginLog = new ApiLog;
        $loginLog->date = date("Y-m-d");
        $loginLog->time = date("H:i:s");
        $loginLog->mode = "API_Agent_application";
        $loginLog->body = json_encode($input);
        $loginLog->save();

        if(strtoLower($input['EVENT_TYPE'])=="a party initiated"){
            $agent=AgentData::where('ref_id',$input['REF_ID'])->update(['call_start_time'=>$input['CALL_START_TIME'],'body'=>json_encode($input),'flag'=>'1']);
            $response = [
                'success' => '1',
                'stage'=>'1',
               'message' => 'Data Added Successfully',
           ];
           return response()->json($response, 200); 

        }
        
        else if(strtoLower($input['EVENT_TYPE'])=="a party connected/notconnected"){
            $agent=AgentData::where('ref_id',$input['REF_ID'])->update(['a_dial_start_time'=>$input['A_PARTY_DIAL_START_TIME'],'a_dial_end_time'=>$input['A_PARTY_DIAL_END_TIME'],'a_connected_time'=>$input['A_PARTY_CONNECTED_TIME'],'a_connected_status'=>$input['A_DIAL_STATUS'],'body'=>json_encode($input),'flag'=>'2']);
            $response = [
                'success' => '1',
                'stage'=>'2',
               'message' => 'Data Added Successfully',
           ];
           return response()->json($response, 200); 

        }
        
        else if(strtoLower($input['EVENT_TYPE'])=="b party initiated"){
            $agent=AgentData::where('ref_id',$input['REF_ID'])->update(['flag'=>'3','body'=>json_encode($input)]);
            $response = [
                'success' => '1',
                'stage'=>'3',
               'message' => 'Data Added Successfully',
           ];
           return response()->json($response, 200); 

        }

        else if(strtoLower($input['EVENT_TYPE'])=="b party connected/notconnected"){
            $agent=AgentData::where('ref_id',$input['REF_ID'])->update(['b_dial_start_time'=>$input['B_PARTY_DIAL_START_TIME'],'b_dial_end_time'=>$input['B_PARTY_DIAL_END_TIME'],'body'=>json_encode($input),'b_connected_time'=>$input['B_PARTY_CONNECTED_TIME'],'B_connected_status'=>$input['B_DIAL_STATUS'],'flag'=>'4']);
            $response = [
                'success' => '1',
                'stage'=>'4',
                'message' => 'Data Added Successfully',
           ];
           return response()->json($response, 200); 

        }

        else if(strtoLower($input['EVENT_TYPE'])=="call end"){
            $agent=AgentData::where('ref_id',$input['REF_ID'])->update(['call_start_time'=>$input['CALL_START_TIME'],'a_dial_start_time'=>$input['A_PARTY_DIAL_START_TIME'],'a_dial_end_time'=>$input['A_PARTY_DIAL_END_TIME'],'a_connected_time'=>$input['A_PARTY_CONNECTED_TIME'],'a_connected_status'=>$input['A_DIAL_STATUS'],'a_end_time'=>$input['A_PARTY_END_TIME'],'b_dial_start_time'=>$input['B_PARTY_DIAL_START_TIME'],'b_dial_end_time'=>$input['B_PARTY_DIAL_END_TIME'],'body'=>json_encode($input),'b_connected_time'=>$input['B_PARTY_CONNECTED_TIME'],'B_connected_status'=>$input['B_DIAL_STATUS'],'b_end_time'=>$input['B_PARTY_END_TIME'],'record_voice'=>$input['RecordVoice'],'disconnect_by'=>$input['DISCONNECTED_BY'],'flag'=>'5']);
            $response = [
                'success' => '1',
                'stage'=>'5',
               'message' => 'Data Added Successfully',
           ];
           return response()->json($response, 200); 

        }

        else{
            $response = [
                'success' => '0',
               'message' => 'Invalid Response',
           ];
           return response()->json($response, 400); 

        }

    }
    
    
    public function obdSipReportCallBack(Request $request){

        $input = $request->all();
        $loginLog = new SipLog;
        $loginLog->user_id = 55555;
        $loginLog->login_date = date("Y-m-d");
        $loginLog->login_time = date("H:i:s");
        $loginLog->login_mode = "SIP_application";
        $loginLog->login_type = "3";
        $loginLog->phone_model = json_encode($input);
        $loginLog->created_at = date("Y-m-d H:i:s");
        $loginLog->updated_at = date("Y-m-d H:i:s");
        $loginLog->save();

        // $validator = Validator::make($input, [
        //     'A_PARTY_NO'        => 'required',
        //     'CAMPAIGN_REF_ID'       => 'required',
        //  ]);

        // if ($validator->fails()) {
        //     return $this->sendError('Data is InComplete');
        // }

        //  $campaign = Campaigndata::where('mobile_no',$request->caller)->where('campg_id',$request->campaignID)->first();
        // if ($campaign) {
        //     $callStatus                    =  0;
        //     if($request->callStatus == 'ANSWER'){
        //       $callStatus                    =  1;
        //     }
        //     // Record exists, update the values
        //     $campaign->update([
        //         'lead_name'         =>      '',
        //         'call_start_ts'     =>      $request->callDialedTime,
        //         'call_connect_ts'   =>      $request->callStartTime,
        //         'call_end_ts'       =>      $request->callEndTime,
        //         'call_duration'     =>      $request->duration,
        //         'call_remarks'      =>      $request->callStatus,
        //         'call_uuid'         =>      $request->leadID,
        //         'dtmf_response'     =>      $request->dtmf,
        //         'actual_status'     =>      $callStatus,
        //         'status'            =>      $callStatus,
        //         'body'              =>      $request->all(),
        //     ]);

        //     $response = [
        //         'success' => '1',
        //        'message' => 'Data Updated Successfully',
        //    ];
           
           
        //    return response()->json($response, 200); 
        // } else{
        //     $response = [
        //         'success' => '0',
        //        'message' => 'No Data found',
        //    ];
        //    return response()->json($response, 200); 
        // }

    }
    
}
