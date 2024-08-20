<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'COD_PERSONAS', 
        'COD_ROL', 
        'name', 
        'email', 
        'password', 
        'is_superuser',
        'IND_USER', 
        'USR_ADD'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_superuser' => 'boolean',
    ];

    /**
     * Relationship with Roles.
     * 
     * A user belongs to a role.
     */
    public function role()
    {
        return $this->belongsTo(Roles::class, 'COD_ROL', 'COD_ROL');
    }

    /**
     * Relationship with Permisos.
     * 
     * A user has many permissions through their role.
     */
    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'COD_ROL', 'COD_ROL');
    }

    /**
     * Get the user's email address.
     * 
     * Example of accessor if needed.
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Set the user's password.
     * 
     * Example of mutator to hash the password automatically.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
