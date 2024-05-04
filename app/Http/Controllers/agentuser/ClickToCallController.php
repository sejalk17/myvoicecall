<?php

namespace App\Http\Controllers\agentuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentData;
use Auth, DB, CURLFILE, Session;

class ClickToCallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $agentData = AgentData::orderBy('id','desc')->get();
        return view('agentuser.clicktocall.index', compact('agentData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agentuser.clicktocall.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $agent      =   new AgentData;

        $this->validate($request, [
			'agent_no'=>'required|min:10|max:10',
			'b_mobile_no'=>'required|min:10|max:10'
        ]);
        $dni            =   '7414047779';

        $agent_no       =   $request->agent_no;
        $b_mobile_no    =   $request->b_mobile_no;
        $user_id        =   Auth::user()->id;

        $agent->agent_no    =   $agent_no;
        $agent->b_mobile_no    =   $b_mobile_no;
        $agent->b_mobile_no    =   $b_mobile_no;
        $agent->dni         =   $dni;
        $agent->user_id    =   $user_id;
        $agent->save();
        $agentId            =   $agent->id;
        $agentNew         =   AgentData::find($agentId);
        ///////////////////Create IdToken
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
        echo $idToken    =   $response->idToken;
        
        echo '<br/>';

        if($idToken){
            $curl = curl_init();

            $apiPathClicktocall = "https://cts.myvi.in:8443/Cpaas/api/clicktocall/initiate-call";
                                    
            $fieldsclicktocall  =array(
                'cli'               => $dni,
                'apartyno'          => $agent_no,
                'bpartyno'          => $b_mobile_no,
                'reference_id'      => '123',
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
            echo $response->requestid;
            $agentNew->call_id = $response->requestid;
            $agentNew->save();
            Session::flash('success', 'Agent calliing initiate Shortly');
            return redirect()->route('clicktocall.index');
        }else{
            Session::flash('error', 'Something went worng');
            return redirect()->route('clicktocall.index');
        }



       

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
