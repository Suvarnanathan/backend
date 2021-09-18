<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'job_sub_categories';

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'job_category_id',
        'name',
        'slug'
    ];

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function jobExperience()
    {
        return $this->hasMany(JobExperience::class);
    }
}
