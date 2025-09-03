<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PropertyType;
use App\Models\User;
use App\Models\PropertyFeature;
use App\Models\PropertyImage;
use App\Models\PropertyFavorite;
use App\Models\PropertyVisit;

class Property extends Model
{
    use HasFactory;

    protected $primaryKey = "PropertyId";
    public $timestamps = false;
    public $table="TProperties";


    protected $fillable = [
        'title',
        'description',
        'price',
        'surface',
        'rooms',
        'bedrooms',
        'kitchen',
        'living_room',
        'bathroom',
        'floor',
        'address',
        'city',
        'postalCode',
        'district',
        'commune',
        'quartier',
        'sold',
        'transactionType',
        'PropertyTypeId',
        'UserId',
        'latitude',
        'longitude',
        'isAvailable'
    ];
    public function propertyType(){
        return $this->belongsTo(PropertyType::class, 'PropertyTypeId', 'PropertyTypeId');
    }

    public function user(){
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }

    public function features()
{
    return $this->belongsToMany(
        PropertyFeature::class,       // Modèle cible
        'TpropertyFeature',           // Nom de la table pivot
        'PropertyId',                // Clé étrangère du modèle actuel dans la pivot
        'PropertyFeatureId'                  // Clé étrangère du modèle cible dans la pivot
    );
}

    public function images()
    {
        return $this->hasMany(PropertyImage::class,'PropertyId');
    }

    public function favorites()
    {
        return $this->hasMany(PropertyFavorite::class);
    }

    public function visits()
    {
        return $this->hasMany(PropertyVisit::class);
    }
}
