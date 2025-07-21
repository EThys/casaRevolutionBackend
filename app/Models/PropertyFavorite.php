<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Property;
use App\Models\User;

class PropertyFavorite extends Model
{
    protected $primaryKey = "PropertyFavoriteId";
    public $timestamps = false;
    public $table="TPropertyFavorites";

    use HasFactory;

    protected $fillable = [
        'UserId',
        'PropertyId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'PropertyId', 'PropertyId');
    }

}
