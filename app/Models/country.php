<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
       'name',
       'slug',
       'code'
    
    ];

    public function jobExperience()
    {
        return $this->hasMany(JobExperience::class);
    }
    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class);
    }
}
