<?php

namespace App\Models;

use App\Models\District;
use App\Models\Quartier;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    //
    protected $table = "TCommunes";
    protected $primaryKey = "CommuneId";
    protected $fillable = [
        'name',
        'DistrictId',
    ];
    protected $hidden = [
        'DistrictId',
        'created_at',
        'updated_at'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'DistrictId', 'DistrictId');
    }

    public function quartier()
    {
        return $this->hasMany(Quartier::class, 'QuartierId');
    }
}
