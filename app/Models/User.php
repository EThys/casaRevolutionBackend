<?php

namespace App\Models;

use App\Models\Bailleur;
use App\Models\Property;
use App\Models\PropertyVisit;
use App\Models\PropertyFavorite;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = "UserId";
    public $timestamps = false;
    public $table = "TUsers";


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'date_of_birth',
        'gender',
        'profile_picture',
        'bio',
        'is_agent',
        'is_admin',
        'email_verified_at',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_agent' => 'boolean',
        'is_admin' => 'boolean',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relations
    public function properties()
    {
        return $this->hasMany(Property::class, 'UserId');
    }

    public function favorites()
    {
        return $this->hasMany(PropertyFavorite::class, 'UserId');
    }

    public function visits()
    {
        return $this->hasMany(PropertyVisit::class, 'UserId');
    }

    public function bailleur()
    {
        return $this->hasMany(Bailleur::class);
    }
    // Accessor pour le nom complet
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
