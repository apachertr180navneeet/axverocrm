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
        'address',
        'gender',
        'date_of_birth',
        'marital_status',
        'person_name',
        'person_mobile'
    ];
}