<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
class User extends Authenticatable
{
  
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }
    
    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withTimestamps();
    }
    public function jobExperience()
    {
        return $this->hasMany(JobExperience::class);
    }
    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class);
    }
    public function education()
    {
        return $this->hasMany(Education::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function licences()
    {
        return $this->hasMany(License::class);
    }
}
