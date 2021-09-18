<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;
     use SoftDeletes;

    protected $table = 'job_categories';

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'name',
        'slug'
    ];
    public function jobSubCategories()
    {
        return $this->hasMany(JobSubCategory::class);
    }


}