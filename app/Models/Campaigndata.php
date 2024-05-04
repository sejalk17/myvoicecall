<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigndata extends Model
{
    protected $fillable = [
        'lead_name',
        // Add other fields that can be mass-assigned here
        'call_start_ts',
        'call_connect_ts',
        'call_end_ts',
        'call_duration',
        'call_remarks',
        'call_uuid',
        'dtmf_response',
        'actual_status',
        'status',
        'body',
        // ...
    ];
}
