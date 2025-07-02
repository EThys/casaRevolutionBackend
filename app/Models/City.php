<?php

namespace App\Models;

use App\Models\User;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = "TCities";
    protected $primaryKey = "CityId";
    protected $fillable = ['name'];
    protected $hidden = [
        'CityId',
        'created_at',
        'updated_at'
    ];
    public function district()
    {
        return $this->hasMany(District::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
