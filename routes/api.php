<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::Post('obdcallback',[App\Http\Controllers\API\CampaignCallBackController::class, 'obdcallback']);
Route::Post('obdVodaCallBack',[App\Http\Controllers\API\CampaignCallBackController::class, 'obdVodaCallBack']);
Route::Post('obdSipReportCallBack',[App\Http\Controllers\API\CampaignCallBackController::class, 'obdSipReportCallBack']);
Route::get('jugad/{jugad_id}',[App\Http\Controllers\API\CampaignCallBackController::class, 'jugad']);
Route::Post('obdVideoConCallback',[App\Http\Controllers\API\CampaignCallBackController::class, 'obdVideoConCallback']);
Route::Post('agentCallingCallback',[App\Http\Controllers\API\CampaignCallBackController::class, 'agentCallingCallback']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
