<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ='personal_infos';
    
    protected $guarded = [
        'id',
        
    ];
    protected $fillable = [
        'user_id',
        'country_id',
        'first_name',
        'last_name',
        'city',
        'street_name',
        'postal_code',
        'gender',
        'dob',
        'about',
        'has_profile'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function profileImage()
    {
        return $this->hasOne(ProfileImage::class);
    }

}
