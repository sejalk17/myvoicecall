<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\helpers\CommonClass;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaigndata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import the DB facade

class CampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service_no;
    public $campaigntype;
    protected $retry_attempt; 
    protected $retry_duration; 
    protected $schedule; 
    protected $schedule_datetime; 
    protected $msisdn; 
    protected $voice_path; 
    protected $campaign_id; 
    protected $ukey; 

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($service_no, $campaigntype, $retry_attempt, $retry_duration, $schedule, $schedule_datetime, $msisdn, $voice_path, $campaign_id, $ukey)
    {
        $this->service_no = $service_no;
        $this->campaigntype = $campaigntype;
        $this->retry_attempt = $retry_attempt;
        $this->retry_duration = $retry_duration;
        $this->schedule = $schedule;
        $this->schedule_datetime = $schedule_datetime;
        $this->msisdn = $msisdn;
        $this->voice_path = $voice_path;
        $this->campaign_id = $campaign_id;
        $this->ukey = $ukey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '6400M');
        ini_set('max_execution_time', '300');

        // Original code here
        DB::beginTransaction(); // Start a database transaction

        try {
            $callResponse = CommonClass::sendVoiceCall($this->service_no, $this->campaigntype, $this->retry_attempt, $this->retry_duration, $this->schedule, $this->schedule_datetime, $this->msisdn, $this->voice_path, $this->ukey);
            $callResponseDecode = json_decode($callResponse, true);

            if (isset($callResponseDecode) && isset($callResponseDecode['leadid']) && isset($callResponseDecode['refno'])) {
                // Perform upsert operation for 'refno' data
                if ($callResponseDecode['refno']) {
                    foreach ($callResponseDecode['refno'] as $data) {
                        foreach ($data as $key => $value) {
                            $campaignData = Campaigndata::where('campaignId_mobileno', $this->campaign_id.'-'.$key)->update(
                            [
                                'refno' => $value,
                                'lead_id' => $callResponseDecode['leadid']
                            ]
                        );
                        }
                    }
                }

                // Commit the transaction if everything is successful
                DB::commit();
            }
        } catch (\Exception $e) {
            // Handle any exceptions and roll back the transaction if an error occurs
            DB::rollBack();
        }
    }
}