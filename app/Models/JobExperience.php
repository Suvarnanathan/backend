<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class JobExperience extends Model
{
    use HasFactory;use SoftDeletes;

    protected $table = 'job_experiences';

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'user_id',
        'job_sub_category_id',
        'company',
        'country_id',
        'city',
        'start_date',
        'is_currently_work'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function jobSubCategory()
    {
        return $this->belongsTo(JobSubCategory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
