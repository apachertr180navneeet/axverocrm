<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesExecutiveReport extends Model
{
      protected $table = 'sales_executive_reports';
    protected $fillable = [
        'user_id',
        'report_date',
        'name',
        'mobile',
        'portal_id',
        'manager_name',
        'manager_mobile',
        'today_sales_number',
        'today_sales_amount',
        'followups',
        'total_sales_number',
        'total_sales_amount',
    ];

    protected $casts = [
        'followups' => 'array',
        'report_date' => 'date',
        'today_sales_amount' => 'decimal:2',
        'total_sales_amount' => 'decimal:2',
    ];
}