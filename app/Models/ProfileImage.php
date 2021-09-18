<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    use HasFactory;
    protected $table = 'profile_images';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'personal_info_id',                      
        'image_name',
        'public_path',        
        'thumb_path',          
    ];
    public function personalInfo()
    {
        return $this->belongsTo(personalInfo::class);
    }
}
