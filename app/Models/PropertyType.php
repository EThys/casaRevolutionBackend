<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Property;

class PropertyType extends Model
{
    use HasFactory;

    protected $primaryKey = "PropertyTypeId";
    public $timestamps = false;
    public $table="TPropertyTypes";

    protected $fillable = [
        'name',
        'description'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
