<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringSubmission extends Model
{
    use HasFactory;

    protected $table = 'hiring_submissions';

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'email',
        'joining_date',
        'designation',
        'department',
        'senior_manager_name',
        'senior_manager_mobile',
        'hiring_work_details',
        'txnid',
        'amount',
        'terms_accepted',
        'payment_status',
        'payu_response',
        'submitted_at',
        'paid_at',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'payu_response' => 'array',
        'hiring_work_details' => 'array',
        'submitted_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}