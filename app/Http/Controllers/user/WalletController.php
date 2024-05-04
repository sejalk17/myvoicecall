<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transcation;
use Auth,DB;
class WalletController extends Controller
{
    public function index(Request $request)
    {
        $userWallet = User::where('id',Auth::user()->id)->value('wallet');
       
      
    $transcation = Transcation::where('user_id', Auth::user()->id)->where('credit_amount','!=',0)->get();
        return view('user.wallet.index', compact('userWallet', 'transcation'));
        
    } 

    public function create()
    {
       
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
