<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\VipNumber;
use App\Models\SpeedData;

class SpeedDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.speeddata.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaign = Campaign::select('campaign_name', 'campaigns.id', 'campaigns.user_id', 'total_count', 'users.username')
        ->join('users', 'campaigns.user_id', '=', 'users.id')
        ->orderBy('campaigns.id', 'DESC')
        ->take(50)
        ->get();
        return view('admin.speeddata.create', compact('campaign'));
    }

    public function createdirect()
    {
        $campaign = Campaign::select('campaign_name', 'campaigns.id', 'campaigns.user_id', 'total_count')
       // ->join('users', 'campaigns.user_id', '=', 'users.id')
        ->orderBy('campaigns.id', 'DESC')
        ->get();
        return view('admin.speeddata.createdirect', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
        // Fetch 20% of random data from the Campaigndata table
        $campaignIds = json_encode($request->campaigns);
       
        $inputArray = $request->campaigns;
        $outputArray = [];

        foreach ($inputArray as $element) {
            $outputArray[] = (int) $element;
        }
       
        $campaignDatas = Campaigndata::whereIn('campaign_id', $outputArray)
        ->inRandomOrder()
        ->take(Campaigndata::whereIn('campaign_id', $outputArray)->where('status',0)->count() * 0.50)
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
                if($last_5_status){
                    $last_5_status_array = json_decode($last_5_status, true);
                    if(count($last_5_status_array) > 0){
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
                    }else{
                        
                    }
                }else{

                }
                
                
                
                
            }
            echo '</pre>';
        }
    }

    public function storedirect(Request $request){

        $campaignIds = json_encode($request->campaigns);
       
        $inputArray = $request->campaigns;
        $outputArray = [];

        foreach ($inputArray as $element) {
            $outputArray[] = (int) $element;
        }
    
        // Fetch 20% of random data from the Campaigndata table
        //$campaignIds = [1400]; 

        $campaignDatas = Campaigndata::whereIn('campaign_id', $outputArray)->where('status',0)
        ->inRandomOrder()
        ->take(Campaigndata::whereIn('campaign_id', $outputArray)->where('status',0)->count() * 0.02)
        ->get();

        //dd($campaignDatas);
        foreach ($campaignDatas as $campaignData) {
            $userId        =   $campaignData->user_id;
            $mobileNo        =   $campaignData->mobile_no;
            $vipNumber = VipNumber::whereJsonContains('number', [$mobileNo])
            ->where('user_id', $userId)
            ->first();

            if ($vipNumber) {
                echo 'Tu h sach m vip';
            }else{
            //if($mobileNo != '9413600418'){
              $campaignIdMobileno         =   $campaignData->campaignId_mobileno ;
              $randomNumber = rand(1, 8);
                    $campaignDataUpdate = Campaigndata::where('campaignId_mobileno', $campaignIdMobileno)
                    ->update([
                        'status' => 1,
                        'call_remarks' => 'Connected',
                        'call_duration' => $randomNumber,
                    ]);
            }  //endif
            
                    
          echo '</pre>';
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
