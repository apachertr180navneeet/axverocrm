<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringSubmission extends Model
{
    use HasFactory;

    protected $table = 'advance_income_applications'; // use new table

    protected $fillable = [
        //'user_id',
        'name',
        'mobile',
        'email',
        'address',
        'pancard_number',
        'pancard_image',
        'referred_executive_name',
        'referred_executive_mobile',
        'relationship_manager_name',
        'relationship_manager_mobile',
        'txnid',
        'amount',
        'terms_accepted',
        'payment_status',
        'payu_response',
        'submitted_at',
        'paid_at'
    ];

    protected $casts = [
        'hiring_work_details' => 'array',
        'payu_response' => 'array',
        'terms_accepted' => 'boolean',
        'submitted_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}