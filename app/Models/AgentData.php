<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentData extends Model
{
    protected $fillable = [
        'agent_id', // Add other fields that can be mass assigned here
        'name',
        'campaign_id',
        'user_id',
        'b_mobile_no',
        'lead',
        'description',
        'disposition',
        'remark',
        'json',
        'ref_id',
        'agent_no',
        'dni',
        // Add other fields as needed
    ];
    use HasFactory;
}
