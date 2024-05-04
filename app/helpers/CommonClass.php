<?php

namespace App\helpers;

use App\Models\User;
use App\Models\Provider;
use App\Models\Channel;
use App\Models\Ukey;
use App\Models\CampType;
use Str, Auth, DB, CURLFILE;
use Illuminate\Support\Facades\Http;
class CommonClass
{
    public static function getRole()
    {
        $role = array(
            'admin' => 'Admin',
            'reseller' => 'Reseller',
            'user' => 'User',
            'businessmanager' => 'Business Manager',
            'agentmanager' => 'Agent Manager',
            'agentuser' => 'Agent User',
        );
        return $role;
    }

    public static function getCtsNumber()
    {
        $ctsNumberArray = Channel::where('status',1)->where('is_occupy',0)->pluck('ctsNumber','ctsNumber')->toArray();
        return $ctsNumberArray;
    }

    public static function getAgentCtsNumber()
    {
        $ctsNumberArray = Channel::where('status',1)->where('agent_occupy',0)->pluck('ctsNumber','ctsNumber')->toArray();
        return $ctsNumberArray;
    }

    public static function getCtsNumberOnEdit()
    {
        $ctsNumberArray = Channel::where('status',1)->pluck('ctsNumber','ctsNumber')->toArray();
        return $ctsNumberArray;
    }

    public static function getAgentCtsNumberOnEdit()
    {
        $ctsNumberArray = Channel::where('status',1)->pluck('ctsNumber','ctsNumber')->toArray();
        return $ctsNumberArray;
    }

    public static function getRoleByResller()
    {
        $role = array(
            'user' => 'User',
            'reseller' => 'Reseller',
        );
        return $role;
    }

    public static function getRoleBySubResller()
    {
        $role = array(
            'user' => 'User',
        );
        return $role;
    }

    public static function getRoleByBusinessManager()
    {
        $role = array(
            'agentmanager' => 'Agent Manager',
        );
        return $role;
    }

    public static function getCli($value)
    {
        $cli = Provider::where('status',1)->where('provider',$value)->pluck('cli','cli')->toArray();
        return $cli;
    }


    public static function getApiProvider()
    {
        $apiProvider = Provider::where('status',1)->pluck('provider','provider')->toArray();
        return $apiProvider;
    }

    public static function getSoundsType()
    {
        $list = CampType::where('status',"1")->get();
        $soundType = array();
        foreach($list as $r){
            $soundType[$r->camp] ='OBD '.ucwords($r->camp);
        }
        return $soundType;
    }

    public static function getUserType()
    {
        $userType = array(
            'submission' => 'Submission',
            'delievery' => 'Delievery',
        );
        return $userType;
    }

    public static function getPlanType()
    {
        $planType = array(
            '15' => '15 Sec',
            '30' => '30 Sec',
        );
        return $planType;
    }

    public static function getRetryOption()
    {
        $planType = array(
            '0' => '0 (Disable)',
            '1' => '1 (Enable)',
            '2' => '2 (Enable)',
        );
        return $planType;
    }

    public static function refreshToken($userId)
    {

        $data = bin2hex(openssl_random_pseudo_bytes(33));

        $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
        $encryption_key = base64_decode($key);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);

        $token = base64_encode($encrypted . '::' . $iv);

        $encryp = Str::random(8);

        $tokenNew = substr($token, 0, 10) . $encryp . substr($token, 10, strlen($token));

        User::where('id', $userId)
            ->update([
                'login_token' => $token,
            ]);

        return $tokenNew;

    }

    public static function send_notification($key, $title, $message)
    {
        // echo $key."--------------------".$title."-------------------".$message;
        $path_to_fcm = "https://fcm.googleapis.com/fcm/send";
        $SERVER_KEY = "AAAAl8bSX_o:APA91bFs_pK3AdsiDRoJL1EXsUDO08gbcn3dCU1918Bb7Gny0-aXITQsaDICyCp4fc6KrMc0hYIRZSC6buc1RMSc_XeeG6S0TPPTLMDbDz1RZks0Bz19N3AsPy16e-KvQ0JsZEggDVbZ";
        $headers = array('Authorization:key=' . $SERVER_KEY, 'content-Type:application/json');
        $fields = array('to' => $key, 'notification' => array('title' => $title, 'body' => $message), 'priority' => 'high');
        $payload = json_encode($fields);
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        $resp = curl_exec($curl_session);
    }


    public static function sendVoiceCall($serviceNo, $campaigntype, $retryAttempt, $retryDuration, $schedule, $schedule_datetime, $msisdn,$voice_path,$ukeyId)
    {
        
            $ukeydata = Ukey::find($ukeyId);
        if($ukeydata != null){
            $apiPath = Provider::where('provider',$ukeydata->provider)->where('cli',$ukeydata->cli)->value('api_url');
            $ukey = $ukeydata->ukey;
        }else{
            if($serviceNo == '7316819122'){
            $apiPath = 'https://api.voicensms.in/OBDAPI/webresources/CreateOBDCampaignPost';
            $ukey   =   'YsESSqs37eqCRQrX4ownGbUOd';
            //$voicefile  =   'maan1.wav';
            $voicefile  =   'tb.wav';
        }elseif($serviceNo == '8040758908'){
            $apiPath = 'https://bapi.mishtel.net/OBDAPI/webresources/CreateOBDCampaignPost';
            $ukey   =   'wnUBQgQnGBS3mAwZ6UUF4V3E9';
            $voicefile  =   'deemoo0.wav';
        }elseif($serviceNo == '2450054'){
            $apiPath = 'https://api.mishtel.net/OBDAPI/webresources/CreateOBDCampaignPost';
            $ukey   =   'yeWbSU5LZXZ1cZRvGHKUrXFNA';
            $voicefile  =   'deemoo0.wav';
        }
        }
       
	                $voicefile  =   $voice_path;
                    $msisdnlist[] = array(
                    "phoneno"   => '9772977271',
                    "callid"    => "65",
                    "altno1"    =>  "",
                    "altno2"    =>  "",
                    "text1"     =>  "",
                    "text2"     =>  "",
                    "text3"     =>  "",
                    "text4"     =>  "",
                    "text5"     =>  "",
                    "text6"     =>  "",
                    "text7"     =>  "",
                    "text8"     =>  "",
                    "text9"     =>  "",
                    "text10"    =>  ""    
                );
        

            $fields = array(
            'sourcetype' => '0',
            'campaigntype' => $campaigntype,
            'filetype' => '2',
            'voicefile' => $voicefile,
            'ukey' => $ukey,
            'serviceno' => $serviceNo,
            'ivrtemplateid' => '1',
            'retryatmpt' => $retryAttempt,
            'retryduration' => $retryDuration,
            'sendnow' => $schedule,
            'schddate' => $schedule_datetime,
            "isrefno" => true,
            'msisdn' => $msisdn,
            'msisdnlist' => $msisdnlist,
        );

     
        $payload = json_encode($fields);
        $headers = array('Content-Type: text/plain');
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
        return $response;
    }


    public static function callCampiaignApi($data){
        $url = 'http://103.132.146.183/OBD_REST_API/api/OBD_Rest/Campaign_Creation';

        // $data = [
        //     "UserName" => "amitgoyal",
        //     "Password" => "123123",
        //     "TransitionId" => "1234",
        //     "VoiceId" => "22176",
        //     "CampaignData" => "7877770790,7014204712",
        //     "OBD_TYPE" => "SINGLE_VOICE",
        //     "DTMF" => "0",
        //     "CALL_PATCH_NO" => "0",
        //     "RETRY_COUNT" => "0",
        //     "RETRY_INTERVAL" => 0,
        // ];

        $response = Http::post($url, $data);

        return $response->json();
    }


    public static function getUkey($cli,$provider){
        $data = Ukey::where('status',"1")->where('provider',$provider)->where('cli',$cli)->get();
        return $data;
    }

    
    public static function getServiceNo($cli,$provider)
    {
      
        $service = Provider::where('status',"1")->where('provider',$provider)->where('cli',$cli)->pluck('number','landline')->toArray();
        return $service;
    }

    public static function campaignAuthToken($channelserver = 'daksh')
    {
        $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/AuthToken";

        if($channelserver == 'obdivr'){
            $fields  =array(
                'username' => 'OBDIVR',
                'password' => 'OBDIVR@123',
            );
        }else{
            $fields  =array(
                'username' => 'Daksh',
                'password' => 'Daksh@123',
            );
        }
      
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
        return $response;
    }
    
    public static function createOBDCampaign($campaignName, $service_no, $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken)
    {
        
        $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/createOBDCampaign";
        $fields  =array(
            'campaign_Name'                 =>  $campaignName,
            'description'                   =>  $campaignName,
            'campaign_Type'                 =>  '3',
            'dni'                           =>  $service_no,
            'from_Date'                     =>  $campSchDate,
            'to_Date'                       =>  $campSchDate,
            'from_Time'                     =>  $campStartTime,
            'to_Time'                       =>  $campEndTime,
            'dial_Timeout'                  =>  '23',
            'retry_Interval_Type'           =>  '0',
            'retry_Interval_Value'          =>  $retry_duration,
            'retry_Count'                   =>  $retry_Count,
            'api_Req'                       =>  'Y',
            'pingback_URL'                  =>  'https://myvoicecall.com/api/obdVodaCallBack',
            'welcome_Prompt'                =>  'N',
            'dtmf_Req'                      =>  $dtmf_Req,
            'dtmf_Length'                   =>  $dtmf_length,
            'dtmf_Retry'                    =>  '0',
            'retry_Limit_Exceeded_Prompt'   =>  'N',
            'thanks_Prompt'                 =>  'N',
        );

        //dd($fields);

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
        curl_close($curl_session);
        return $response;
    }

    public static function createOBDCampaignTTS($campaignName, $service_no, $campSchDate, $campStartTime, $campEndTime, $retry_duration, $retry_Count, $dtmf_Req, $dtmf_length, $idToken)
    {
        
        $apiPath = "https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/createOBDCampaign";
        $fields  =array(
            'campaign_Name'                 =>  $campaignName,
            'description'                   =>  $campaignName,
            'campaign_Type'                 =>  '3',
            'dni'                           =>  $service_no,
            'from_Date'                     =>  $campSchDate,
            'to_Date'                       =>  $campSchDate,
            'from_Time'                     =>  $campStartTime,
            'to_Time'                       =>  $campEndTime,
            'dial_Timeout'                  =>  '23',
            'retry_Interval_Type'           =>  '0',
            'retry_Interval_Value'          =>  $retry_duration,
            'retry_Count'                   =>  $retry_Count,
            'api_Req'                       =>  'Y',
            'pingback_URL'                  =>  'https://myvoicecall.com/api/obdVodaCallBack',
            'welcome_Prompt'                =>  'N',
            'dtmf_Req'                      =>  $dtmf_Req,
            'dtmf_Length'                   =>  $dtmf_length,
            'dtmf_Retry'                    =>  '0',
            'retry_Limit_Exceeded_Prompt'   =>  'N',
            'thanks_Prompt'                 =>  'N',
            'IsWelcomeWithDynamicVoice'     =>  'n',
            'IsCampaignWithDynamicVoice'    =>  'y',
            'invalid_input_prompt'          =>  'n',
            'no_input_prompt'               =>  'n'
        );

       echo '<pre>';
       print_r($fields);
       echo '</pre>';

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
        curl_close($curl_session);
        return $response;
    }

    public static function campaignVoiceUpload($fullSoundFilePath, $idToken, $capaignNameByApi)
    {
        
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
        return $response;
    }

    public static function campaignVoiceUploadTTS($fullSoundFilePath, $idToken, $capaignNameByApi)
    {
        echo $fullSoundFilePath;
       /* $curl = curl_init();
       
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/voiceUploadDynamic?campaign_ID=' . $capaignNameByApi . '&voice_File_Type=C',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file_1'=> new CURLFILE('https://www.myvoicecall.com/uploads/soundclip/dear.wav', 'audio/wav', 'file'),'variable_1' => 'name','file_2'=> new CURLFILE($fullSoundFilePath, 'audio/wav', 'file')),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$idToken
        ),
        ));
    

        $response = curl_exec($curl);
        curl_close($curl); */
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$idToken
        ])
        ->attach('file_1', file_get_contents('https://www.myvoicecall.com/uploads/soundclip/dear.wav'), 'dear.wav')
        ->attach('file_2', file_get_contents($fullSoundFilePath), 'welcome.wav')
        ->post('https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/voiceUploadDynamic?voice_File_Type=C&campaign_ID=' . $capaignNameByApi , [
            'variable_1' => 'name',
        ]);
        
       
        
        echo $response->body();
        return $response;
    }

    public static function APICampaignBaseLoad($xlsFile, $filename, $idToken, $capaignNameByApi, $service_no)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/APICampaignBaseLoad',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('campaign_ID' => $capaignNameByApi,'dni' => $service_no,'file'=> new CURLFILE($xlsFile, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $filename)),
            CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer '.$idToken
            ),
          ));
          
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }


    public static function campaignStartStop($campaignId, $idToken, $status)
    {
        
        $apiPath    =   'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/StartorStop';
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
            "campaign_ID": "'.$campaignId.'", 
            "status":"'.$status.'"	
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$idToken
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
