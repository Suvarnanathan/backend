<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateImage extends Model
{
    use HasFactory;
    protected $table = 'certificate_images';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'certificate_id',                      
        'image_name',
        'public_path',        
        'thumb_path',          
    ];
}
