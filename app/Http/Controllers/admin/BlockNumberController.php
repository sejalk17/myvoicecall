<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockNumber;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class BlockNumberController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->paginate) {
            $paginate = $request->paginate;
        } else {
            $paginate = 10;
        } 
       
        $search = $request->search;
        $blocknumber = BlockNumber::select('*');
        if ($search) {
            $blocknumber = $blocknumber->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT(number)"), 'LIKE', '%' . $search . '%');
            });
        }
        $blocknumber = $blocknumber->orderBy('id', 'desc')->paginate($paginate)->onEachSide(0);

        //$blocknumber    =   BlockNumber::orderBy('id','desc')->get();
        return view('admin.blocknumber.index', compact('blocknumber','paginate','search'));
    }

    public function create()
    {
        return view('admin.blocknumber.create');
    }

    public function store(Request $request)
    {
        $menulaData = $request->input('manual_data');
        preg_match_all('/\d+/', $menulaData, $matches);
        $numbers = $matches[0];
        if($numbers){
            foreach($numbers as $singleNumber){
                $primaryKeyValue = $singleNumber; // Replace with the actual primary key value
                $data = [
                    'number' => $singleNumber,
                    'status' => '1',
                ];
                BlockNumber::updateOrInsert(['number' => $primaryKeyValue], $data);
            }
        }
       
      if ($request->hasFile('excel_file_upload')) {
            $destinationPath        =   public_path('uploads/csv');
            
            $csvFile                    =   $request->file('excel_file_upload');
           
            $extension                  =   $csvFile->getClientOriginalExtension();
            $filename                   =   str_replace('.'.$extension,'',$csvFile->getClientOriginalName()).'_'.time().'.'.$extension;
            $csvFile->move($destinationPath, $filename);
            $file_path                  =   $destinationPath.'/'.$filename;
            $file                               =   fopen($file_path, "r");
            $numbers                            =   array();
            $insert_data                        =   [];
                                    
            $data = Excel::toArray([], $file_path);
            if($data){
                for ($i = 0; $i < count($data[0]); $i++) {
                    $phoneNumber = $data[0][$i][0]; 
                    $data1 = [
                        'number' => $phoneNumber,
                        'status' => '1',
                    ];
                    BlockNumber::updateOrInsert(['number' => $phoneNumber], $data1);
                }
            }

      }
       

        
        return redirect()->route('blocknumber.index');
       
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
}
