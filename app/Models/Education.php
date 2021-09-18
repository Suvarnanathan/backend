<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table ='educations';
    
    protected $guarded = [
        'id',
        
    ];
    protected $fillable = [
        'user_id',
        'school',
        'course_name',
        'field_of_study',
        'grade',
        'activity_and_society',
        'description',
        'start_date',
        'end_date',
        'is_currently_study',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
