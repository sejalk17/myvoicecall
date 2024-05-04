<?php

namespace App\Http\Controllers\agentmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentData;
use App\Models\AgentCampaign;
use Auth,DB,Session;
class HomeController extends Controller
{
    public function index(){

        $uniqueCampaigns = AgentData::where('agent_id', Auth::user()->id)
        ->groupBy('campaign_id')
        ->pluck('campaign_id')
        ->count();
    
        $count = AgentData::where('agent_id', Auth::user()->id)->count();
       
        return view('agentmanager.home',compact('count','uniqueCampaigns'));
    } 

    public function campaigndata(){
        $uniqueCampaigns = AgentData::select('agent_campaigns.id','agent_campaigns.campaign_name','agent_campaigns.created_at','agent_campaigns.totalcount','agent_campaigns.distributions','agent_campaigns.form','agent_campaigns.dialing_order', DB::raw('COUNT(agent_data.campaign_id) as count'))
        ->join('agent_campaigns', 'agent_data.campaign_id', '=', 'agent_campaigns.id')
        ->where('agent_data.agent_id', Auth::user()->id)
        ->groupBy('agent_campaigns.id')
        ->get();
    
        return view('agentmanager.campaign.index',compact('uniqueCampaigns'));

        dd($uniqueCampaigns);
    }

    public function campaignagentdata($id){
        $data=AgentData::where('campaign_id',$id)->where('agent_id',Auth::user()->id)->get();
        return view('agentmanager.campaign.view',compact('data','id'));

    }

    public function clicktocall($id){
       $data=AgentCampaign::findorfail($id);
          
       
       if($data->dialing_order=="Ascending"){
            $data="ASC";
       }
       else{
            $data="DESC";
       }
        $agentdata=AgentData::where('campaign_id',$id)->where('agent_id',Auth::user()->id)->where('call_flag','1')->orderBy('id',$data)->first();

        $ref_id=Auth::user()->id . '' . time();
        $agenttoken=AgentData::where('id',$agentdata->id)->update(['ref_id'=>$ref_id]);

                $apiPath = "https://cts.myvi.in:8443/Cpaas/api/clicktocall/AuthToken";
                                            
                $fields  =array(
                    'username' => '9610013634',
                    'password' => 'Admin123$4',
                );

                $payload = json_encode($fields);
            
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
                CURLOPT_POSTFIELDS =>$payload,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                
                $response   = json_decode($response);
                $idToken    =   $response->idToken;
                echo $idToken;
                echo '<br/>';
                $agenttoken=AgentData::where('id',$agentdata->id)->update(['idToken'=>$idToken]);
                
                if($idToken){
                    $curl = curl_init();
        
                    $apiPathClicktocall = "https://cts.myvi.in:8443/Cpaas/api/clicktocall/initiate-call";
                                            
                    $fieldsclicktocall  =array(
                        'cli'               => $agentdata->dni,
                        'apartyno'          => $agentdata->agent_no,
                        'bpartyno'          => $agentdata->b_mobile_no,
                        'reference_id'      => $ref_id,
                    );
                    $payloadclicktocall = json_encode($fieldsclicktocall);
        
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $apiPathClicktocall,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payloadclicktocall,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$idToken
                    ),
                    ));
        
                    $response = curl_exec($curl);
        
                    curl_close($curl);
                    $response   = json_decode($response);
                    print_r($response);

                    if($response->requestid)
                    {
                        $agenttoken=AgentData::where('id',$agentdata->id)->update(['call_flag'=>'2']);
                    }
                    Session::flash('success', 'Agent calliing initiate Shortly');
                    return back();
                }else{
                    Session::flash('error', 'Something went worng');
                    return back();
                }
                dd('fone');
    }
    
}