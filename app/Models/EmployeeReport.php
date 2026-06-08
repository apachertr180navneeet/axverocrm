<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reporting_to',
        'file',
        'report_date',
        'report_description',

        // Sales Report Fields
        'full_name',
        'today_sale',
        'today_team',
        'overall_total_sale',
        'overall_total_team',
        'marketing_work_done',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportingPerson()
    {
        return $this->belongsTo(User::class, 'reporting_to');
    }
}
