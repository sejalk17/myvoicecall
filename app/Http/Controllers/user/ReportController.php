<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Campaigndata;
use App\Models\User;
use App\Models\Sound;
use App\Models\BlockNumber;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourImportClass;
use App\Exports\CampaignCreateExcelClass;
use Auth,DB;
class ReportController extends Controller
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
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $userId = Auth::user()->id;
        $campaign = $campaign = Campaign::where('user_id',$userId);

        if ($startDate != null && $endDate != null) {
            $campaign = $campaign->where(function ($query) use ($startDate,$endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        });
    }
        if ($search) {
            $campaign = $campaign->where(function ($query) use ($search) {
            $query->where(DB::raw("CONCAT(created_at,' ',campaign_name,' ',total_count)"), 'LIKE', '%' . $search . '%')
                ->orWhere(DB::raw('(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = campaigns.user_id)'), 'LIKE', '%' . $search . '%');
        });
}
 
$campaign = $campaign->orderBy($sort_f, $sort_by)->paginate($paginate)->onEachSide(0);
return view('user.report.allcampaign', compact('campaign', 'paginate', 'search', 'sort_f', 'sort_by','startDate','endDate'));
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

    public function checkxlsx()
    {
        return view('user.report.checkxlsx');
    }

    public function xlsxstore(Request $request)
    {
        // $authUserId             =   Auth::user()->id;
        // $filePath               =   $request->excel_file_upload;
        // $dataCount              =   Excel::toArray([], $filePath)[0];
        // $dataCount              =   array_filter($dataCount, function ($row) {
        //                                 return !empty(array_filter($row));
        //                             });
        // $i =1;
        // $arraynumber[]  =   'msisdn';
        // foreach ($dataCount as  $r) {
        //     $arraynumber[]=$r['0'];

        //     $i++;
        //     // if($i == 5000){
        //     //     break;
        //     // }
        // }

        // $existingNumbers = BlockNumber::whereIn('number',$arraynumber)->pluck('number')->toArray();
        // $finalArray =   array_diff($arraynumber,$existingNumbers);
        // $array1_converted = array_map(function($value) {
        //     return [$value];
        // }, $finalArray);
        // $excelNumber             =   $array1_converted;
        // $folder = 'uploads/excel_files/';
        // $filename   =   'example_'.time().'_'.$authUserId.'.xlsx';
        // $datanew1 = $folder . ''.$filename;
        // Excel::store(new CampaignCreateExcelClass($excelNumber), $datanew1);
        // dd($existingNumbers, $excelNumber);
                  
        
        

        $existingNumbers = BlockNumber::pluck('number')->toArray();
        $excelFile = $request->file('excel_file_upload');
        $excelData = Excel::toCollection(new YourImportClass, $excelFile)->first();

        $uniqueRows = $excelData->reject(function ($row) use ($existingNumbers) {
             return in_array($row[0], $existingNumbers);
        });
     
        if ($uniqueRows->isNotEmpty()) {
            foreach ($uniqueRows as  $r) {
                $arraynumber[][]=$r['0'];
            }
            $folder = 'uploads/excel_files/';
            $filename   =   'example_'.time().'_'.'.xlsx';
            $datanew1 = $folder . ''.$filename;
            $storagePath = storage_path('app/excel-files'); // Adjust the storage path as needed
            Excel::store(new CampaignCreateExcelClass($arraynumber), $datanew1);
        }
        dd('Hello',$existingNumbers, $uniqueRows,$datanew1);
        return view('user.report.checkxlsx');
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
}
