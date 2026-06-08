<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTaskReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reporting_to',
        'reports',
        'status',
        'report_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportingPerson()
    {
        return $this->belongsTo(User::class, 'reporting_to');
    }
    
    // User.php
    public function employeeTaskReports()
    {
        return $this->hasMany(EmployeeTaskReport::class, 'user_id');
    }

    
}

?>