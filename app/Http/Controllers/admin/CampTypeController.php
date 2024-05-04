<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampType;
use App\Models\Campaignoldata;
class CampTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = CampType::orderBy('id')->get();
        return view('admin.camptype.index', compact('lists'));
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

    public function statusUpdate(Request $request){
      
        $data = Camptype::findorfail($request->id);
        $data->status = $request->status;
        $data->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function uploadFile(Request $request){
     
        return view('admin.camptype.upload');
    }

    public function uploadFileStore(Request $request){
       
        $this->validate($request, [

        ]);

        $destinationPath                =   public_path('uploads/csv');
        if ($request->hasFile('excel_file_upload')) {
            $csvFile                    =   $request->file('excel_file_upload');
            echo $filename                   =   time().''.$csvFile->getClientOriginalName();
            $csvFile->move($destinationPath, $filename);
            $file_path                  =   $destinationPath.'/'.$filename;
            $file                               =   fopen($file_path, "r");
            $i                                  =   0;
         

            while (($filedata = fgetcsv($file)) !== FALSE) {
                $num = count($filedata);
                if ($i == 0) {
                    $i++;
                    continue;
                }

                // $connected_status         =   $filedata[15];
                // $dni                      =   $filedata[1];
                // $userNumber               =   $filedata[6];
                // $refNo                    =   $filedata[35];
                // $call_duration            =   $filedata[18];
                // $call_uuid                =   $filedata[0];
                // $call_start_ts            =   $filedata[4];
                // $call_connect_ts          =   $filedata[8];
                // $call_end_ts              =   $filedata[14];

                $connected_status         =   $filedata[3];
                $dni                      =   $filedata[1];
                echo $userNumber               =   $filedata[0];
                echo '<br/ >';
                echo $refNo                    =   $filedata[5];
                $call_duration            =   $filedata[4];
                $call_uuid                =   $filedata[1];
                $call_start_ts            =   '';
                $call_connect_ts          =   '';
                $call_end_ts              =   '';

                if(strtolower($connected_status) == 'connected'){
                    $actual_status  =   1;
                    $status  =   1;
                }else{
                    $actual_status  =   0;
                    $status  =   0;
                }

                $campaign = Campaignoldata::where('mobile_no',$userNumber)->where('campg_id',$refNo)->where('status','!=',1)->first();

                echo '<pre>';
                print_r($campaign);
                echo '</pre>';

                if ($campaign) {
                    $campaign->update([
                        'lead_name'         =>      '',
                        'call_start_ts'     =>      $call_start_ts,
                        'call_connect_ts'   =>      $call_connect_ts,
                        'call_end_ts'       =>      $call_end_ts,
                        'call_duration'     =>      $call_duration,
                        'call_remarks'      =>      $status,
                        'call_uuid'         =>      $call_uuid,
                        'dtmf_response'     =>      0,
                        'actual_status'     =>      $actual_status,
                        'status'            =>      $actual_status,
                        'body'              =>      json_encode($filedata),
                    ]);
        
                   
                }
            }
            fclose($file);
        }
    }

   

    
}
