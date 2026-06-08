<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refference extends Model
{
    use HasFactory;

    protected $table = 'refferences';

   protected $fillable = [
    'user_id',
    'portal_id',
    'senior_name',
    'senior_mobile',
    'candidates',
];
    protected $casts = [
        'candidates' => 'array',
    ];
        // Relationship (optional but useful)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}