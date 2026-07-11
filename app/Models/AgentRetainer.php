<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRetainer extends Model
{
    use HasFactory;

    protected $table = 'agent_retainers';

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'gender',
        'date_of_birth',
        'marital_status',
        'recommended_name',
        'recommended_mobile'
    ];
}