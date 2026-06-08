<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyReport extends BaseModel
{
    use HasFactory;
    
    
        protected $table = 'daily_reports';
        
      protected $fillable = [
        'report_date',
        'portal_email',
        'user_id',
        'name',
        'mobile',
        'total_joined_retainer',
        'selected_persons',
        'retainers',
        'team_details'
    ];

   
    
    
}
