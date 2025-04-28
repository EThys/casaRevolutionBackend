<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Property;

class PropertyFeature extends Model
{
    protected $primaryKey = "PropertyFeatureId";
    public $timestamps = false;
    public $table="TPropertyFeatures";

    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function properties()
{
    return $this->belongsToMany(
        Property::class,
        'TpropertyFeature',
        'PropertyId',
        'PropertyFeatureId'
    );
}
}
