<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Property;

class PropertyImage extends Model
{
    protected $primaryKey = "PropertyImageId";
    public $timestamps = false;
    public $table="TPropertyImages";

    use HasFactory;

    protected $fillable = [
        'PropertyId',
        'path',
        'isMain'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class,'PropertyId');
    }

}
