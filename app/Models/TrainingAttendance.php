<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAttendance extends Model
{
    use HasFactory;

    protected $table = 'training_attendances';

    protected $fillable = [
        'company_id',
        'user_id',
        'company_email',
        'senior_id',
        'training_date',
        'training_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senior()
    {
        return $this->belongsTo(User::class, 'senior_id');
    }
}
