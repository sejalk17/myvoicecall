<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use App\Models\Ukey;
use App\helpers\CommonClass;
use Auth;

class UkeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $items=Ukey::all();
        return view('admin.ukey.index',compact('items'));
    }


       /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $apiProvider = CommonClass::getApiProvider();
        return view('admin.ukey.create', compact('apiProvider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'apiProvider' => 'required',
            'cli' => 'required',
            'username' => 'required',
            'key' => 'required',
            'service_no' => 'required',
        ]);
        // dd($request->all());
        $ukey=new Ukey;
        $ukey->provider=$request->apiProvider;
        $ukey->cli=$request->cli;
        $ukey->username=$request->username;
        $ukey->ukey=$request->key;
        $ukey->status=1;
        if($request->service_no != null){
            $serviceNos = json_decode(str_replace("'",'"',$request->service_no));
            $ukey->landline = @$serviceNos->l_no;
            $ukey->number = @$serviceNos->n_no;
        }
        $ukey->save();

         session()->flash('success', 'ukey set successfully');
         return redirect()->route('ukey.index');
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
        $row=Ukey::findorfail($id);
        $apiProvider = CommonClass::getApiProvider();
        return view('admin.ukey.edit',compact('row','apiProvider'));
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
        // dd($request->all());
        $ukey=Ukey::findorfail($id);
        $this->validate($request, [
            'apiProvider' => 'required',
            'cli' => 'required',
            'username' => 'required',
            'key' => 'required',
            'service_no' => 'required',
        ]);
        $ukey->provider=$request->apiProvider;
        $ukey->cli=$request->cli;
        $ukey->username=$request->username;
        $ukey->ukey=$request->key;
        if($request->service_no != null){
            $serviceNos = json_decode(str_replace("'",'"',$request->service_no));
            $ukey->landline = @$serviceNos->l_no;
            $ukey->number = @$serviceNos->n_no;
        }
        $ukey->save();

         session()->flash('success', 'Ukey updated successfully');
         return redirect()->route('ukey.index');
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
      
      $data = Ukey::findorfail($request->id);
      $data->status = $request->status;
      $data->save();
      return response()->json(['message' => 'Status updated successfully.']);
  }
}
