<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoiningKit extends Model
{
    protected $table = 'joining_kits';

    protected $fillable = [
        'designation','joining_date',
        'first_name','last_name',
        'email','mobile','emergency_mobile',
        'gender','dob','marital_status',

        'perm_street','perm_line2','perm_city','perm_state','perm_zip','perm_country',
        'curr_street','curr_line2','curr_city','curr_state','curr_zip','curr_country',

        'aadhar_number','pan_number',

        'photo_full','photo_passport','aadhar_front','aadhar_back','pan_image',

        'bank_name','acc_holder','acc_number','ifsc','passbook',

        'exp_type',

        'tenth_data','graduation_data','experience_data','certificates',

        'exp_certificate','relieving_letter',
        'tnc_accepted'
    ];

    protected $casts = [
        'tenth_data' => 'array',
        'graduation_data' => 'array',
        'experience_data' => 'array',
        'certificates' => 'array',
         'tnc_accepted' => 'boolean',
    ];
}