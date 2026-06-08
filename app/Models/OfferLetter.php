<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    use HasFactory;

    protected $table = 'offer_letters';

    protected $fillable = [
        'user_id',
        'gender',
        'full_name',
        'email',
        'designation',
        'employment_type',
        'salary',
        'joining_date',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary'       => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */
    const GENDER_MALE   = 'Male';
    const GENDER_FEMALE = 'Female';
    const GENDER_OTHER  = 'Other';

    const STATUS_PENDING = 'pending';
    const STATUS_SENT    = 'sent';

    public static function getGenderOptions(): array
    {
        return [self::GENDER_MALE, self::GENDER_FEMALE, self::GENDER_OTHER];
    }

    public static function getStatusOptions(): array
    {
        return [self::STATUS_PENDING, self::STATUS_SENT];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getFullNameAttribute($value)
    {
        return ucwords($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}