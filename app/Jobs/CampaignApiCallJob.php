<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\helpers\CommonClass;
use App\Models\Campaigndata;
use Illuminate\Support\Facades\DB; // Import the DB facade


class CampaignApiCallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $dataValue;
    protected $msisdn;
    protected $campaignId;
   
    public function __construct($dataValue,$msisdn,$campaignId)
    {
        $this->dataValue = $dataValue;
        $this->msisdn = $msisdn;
        $this->campaignId = $campaignId;
    }

    public function handle()
    {
        ini_set('memory_limit', '6400M');
        ini_set('max_execution_time', '300');

        DB::beginTransaction(); // Start a database transaction

        try {
            $campgId = 0;
            $response = CommonClass::callCampiaignApi($this->dataValue);
            if(isset($response['ERR_CODE'])){
                if($response['ERR_CODE'] == "0"){
                    $campgId = $response['CAMPG_ID'];
                    foreach ($this->msisdn as $num) {
                        $campaignData = Campaigndata::where('campaignId_mobileno', $this->campaignId.'-'.$num)->update(['campg_id' => $campgId]);
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
