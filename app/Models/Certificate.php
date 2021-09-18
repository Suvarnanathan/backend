<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;  
    protected $table = 'certificates';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'user_id',            
        'name',              
        'issued_organization',
        'start_date',        
        'end_date',          
    
    ];
     /**
     * Get all of the certificateImages for the Certificate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificateImage()
    {
        return $this->hasMany(CertificateImage::class,'certificate_id','id');
        
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
