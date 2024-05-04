<?php

namespace App\Http\Controllers\businessmanager;

use App\helpers\CommonClass;
use App\Http\Controllers\Controller;
use App\Models\AgentCampaign;
use App\Models\AgentData;
use App\Models\Sound;
use App\Models\Ctsnumber;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class BusinessCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $campaign = AgentCampaign::select('*')->where('user_id',Auth::user()->id);
        
        if ($search) {
            $campaign = $campaign->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',totalcount,' ',distributions,' ',dialing_order)"), 'LIKE', '%' . $search . '%');
            });
        }
        $campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('businessmanager.campaign.index',compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userData = User::where('parent_id', Auth::user()->id)->select('id', 'first_name', 'last_name')->get();
        $soundType = CommonClass::getSoundsType();
        $user = User::where('parent_id', Auth::user()->id)->pluck('id')->toArray();
        $user[] = Auth::user()->id;
        $soundList = Sound::select('id', 'name')->whereIn('user_id', $user)->get();
        return view('businessmanager.campaign.create', compact('soundType', 'soundList', 'userData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'campaign_name' => 'required',
            'distribution' => 'required',
            'form' => 'required',
            'order' => 'required',
            'excel_file_upload' => 'required',
        ]);
        $destinationPath = public_path('uploads/agentdata');
        $dni=Ctsnumber::where('user_id',Auth::user()->id)->value('ctsNumber');
        $csvFile = $request->file('excel_file_upload');
        $filename = $csvFile->getClientOriginalName() . '' . time() . '' . Auth::user()->id;
        $csvFile->move($destinationPath, $filename);
        $file_path = $destinationPath . '/' . $filename;
        $linecount = count(file($file_path)) - 1;

        $campaign = new AgentCampaign;
        $campaign->campaign_name = $request->campaign_name;
        $campaign->distributions = $request->distribution;
        $campaign->form = $request->form;
        $campaign->dialing_order = $request->order;
        $campaign->user_id = Auth::user()->id;
        $campaign->status = 1;
        $campaign->totalcount = $linecount;
        $campaign->uploaded_file = $file_path;
        $campaign->save();
        // $totalChargePerCsv              =   $linecount * $needChargePerRecord;

        $file = fopen($file_path, "r");
        $i = 0;
        $msisdn = array();
        $insert_data = [];

        $rows = []; // Array to hold all rows from the CSV

// Open the CSV file
        $file = fopen($file_path, 'r'); // Replace 'your_csv_file.csv' with your actual CSV file path

        if ($file !== false) {
            $i = 0;

            while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                $num = count($filedata);

                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }

                $rowData = []; // Array to hold the data of each row

                for ($c = 0; $c < $num; $c++) {
                    $phoneNumber = $filedata[$c];
                    $rowData[] = $phoneNumber; // Store each column data in $rowData array
                }

                // Store the entire row's data in the $rows array
                $rows[] = $rowData;

                $i++;
            }

            fclose($file); // Close the file after reading

            $agentlist = User::where('parent_id', Auth::user()->id)->where('status','1')->get();

            $agentCount = count($agentlist); // Number of agents
            $chunkSize = (int) ($linecount / $agentCount); // Calculate chunk size for each agent
            $remainder = $linecount % $agentCount; // Calculate remaining data after equal distribution
            $user_id = Auth::user()->id;
            $currentAgentIndex = 0;

            // Accessing each row's data
            foreach ($rows as $index => $row) {
                $agent = $agentlist[$currentAgentIndex];

                $jsonData = [
                    'name' => $row[0],
                    'b_mobile_no' => $row[1],
                    'lead' => $row[2],
                    'description' => $row[3],
                    'disposition' => $row[4],
                    'remark' => $row[5],
                ];
                $jsonBody = json_encode($jsonData);

                $agentData = new AgentData([
                    'agent_id' => $agent->id, // Assigning agent_id based on distribution
                    'campaign_id' => $campaign->id,
                    'user_id' => $user_id,
                    'name' => $row[0],
                    'b_mobile_no' => $row[1],
                    'json'=>$jsonBody,
                    'agent_no' => '8209909552',
                    'dni' => $dni,
                ]);
                $agentData->save();

                // Move to the next agent if the current chunk for the agent is completed
                if ($index + 1 === $chunkSize * ($currentAgentIndex + 1) + min($currentAgentIndex, $remainder)) {
                    $currentAgentIndex++;
                }

                // Break the loop if all chunks have been assigned
                if ($currentAgentIndex >= $agentCount) {
                    break;
                }
                echo "<pre>";
                echo $agentData;
                echo "</pre>";
            }
            $request->session()->flash('alert-success', 'File Inserted Successfully!');
            return redirect()->route('businesscampaign.index');
            
        } else {
            $request->session()->flash('alert-success', 'Something went wrong!');
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        
        $campaign = AgentCampaign::where('id',$id)->first();
            $campaigndata = AgentData::where('campaign_id', $id); 

            
        $search = $request->search;
       
            $campaigndata = $campaigndata->Where('b_mobile_no', 'LIKE', '%' . $search . '%');
        
        $campaigndata = $campaigndata->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
        return view('businessmanager.campaign.view', compact('campaigndata', 'paginate', 'search', 'sort_f', 'sort_by'));
    }

    public function downloadFile($id)
    { 
        $campaign = AgentCampaign::where('id',$id)->first();
       
        
            $campaigndata = AgentData::select('*')
            ->where('campaign_id', $id)
            ->get();

            
        return Excel::download(new CampaignExportClass($campaigndata->take(200000)), 'report.xlsx');
        
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
