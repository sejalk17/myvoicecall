<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaignoldata extends Model
{
    protected $table = 'campaignoldatas';
    protected $fillable = [
        'id',
        'campaignId_mobileno',
        'user_id',
        'campg_id',
        'campaign_id',
        'lead_id', 
        'refno', 
        'cli',
        'mobile_no',
        'retry_attempt',
        'retry_duration',
        'call_duration',
        'actual_status',
        'status',
        'dtmf_response',
        'cut_flag',
        'data_type',
        'call_start_ts',
        'call_connect_ts',
        'call_end_ts',
        'body',
        'call_uuid',
        'lead_name',
        'call_remarks',
        'call_credit',
        'lead_name',
        // ...
    ];
}
