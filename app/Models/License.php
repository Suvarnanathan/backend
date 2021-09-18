<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $table = 'licenses';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'title',
        'user_id'
    ];
    public function licenseImage()
    {
        return $this->hasMany(licenseImage::class,'license_id','id');
        
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
