<?php

namespace App\Models;

use App\Models\Commune;
use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    //
    protected $table = "TQuartiers";
    protected $primaryKey = "QuartierId";
    protected $fillable = [
        'name',
        'CommuneId'
    ];
    public $timestamps = false;
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'CommuneId', 'CommuneId');
    }
}
