<?php

namespace App\Models;

use App\Models\City;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = "TDistricts";
    protected $primaryKey = "DistrictId";
    protected $fillable = [
        'name',
        'CityId',
    ];

    protected $hidden = [
        'CityId',
        'created_at',
        'updated_at'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'CityId', 'CityId');
    }

    public function commune()
    {
        return $this->hasMany(Commune::class);
    }
}
