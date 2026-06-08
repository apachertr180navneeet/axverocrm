<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrExecutiveReport extends Model
{
    protected $fillable = [
         'user_id',
        'report_date',
        'portal_email',
        'name',
        'mobile',
        'hr_manager_mobile',
        'hr_manager_name',
        'selected_persons',
        'follow_up_candidates',
        'referred_retainers',
        'total_joined_details',
    ];

    protected $casts = [
        'selected_persons'      => 'array',
        'follow_up_candidates'  => 'array',
        'referred_retainers'    => 'array',
        'total_joined_details'  => 'array',
        'report_date'           => 'date',
    ];
}