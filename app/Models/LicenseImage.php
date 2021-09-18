<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseImage extends Model
{
    use HasFactory;
    protected $table = 'license_images';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'license_id',
        'image_name',
        'public_path',        
        'thumb_path',
    ];
}
