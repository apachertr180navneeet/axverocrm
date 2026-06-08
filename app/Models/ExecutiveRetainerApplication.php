<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExecutiveRetainerApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'executive_retainer_applications';

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'post',
        'date_of_joining',
        'hired_executives',
        'hired_retainers',
        'retainer_detail',
        'txnid',
        'amount',
        'payment_status',
        'payu_response',
        'paid_at'
    ];

    protected $casts = [
        'hired_executives' => 'array',
        'hired_retainers' => 'array',
        'retainer_detail' => 'array',
        'payu_response' => 'array',
        'date_of_joining' => 'date',
        'paid_at' => 'datetime',
    ];
}