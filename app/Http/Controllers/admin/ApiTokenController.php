<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiToken;
use App\helpers\CommonClass;
use Illuminate\Support\Facades\Http;
class ApiTokenController extends Controller
{
    public function store(Request $request){
        dd($request->all());
        $has = ApiToken::whereBetween('created_at', [date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59'])->first();

        if(is_null($has)){
            $apiUrl = 'https://cts.myvi.in:8443/Cpaas/api/obdcampaignapi/AuthToken';
            $data = [
                'username' => 'Daksh',
                'password' => 'Daksh@123',
            ];

            $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($apiUrl, $data);
            if ($response->successful()) {
                $token              =   $response->json();
                $tokenv             =   new ApiToken;
                $tokenv->provider   =   'voda';
                $tokenv->token      =   @$token['idToken'];
                $tokenv->expiresIn  =   @$token['expiresIn'];
                $tokenv->save();
                return back()->with('meg','Token has been Generated successfully');
            } else {
                return back()->with('meg','Failed to obtain authentication token.');
            }
        }else{
            return back()->with('meg','token already generated');
        }
    }
}

