<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Property;
use App\Models\User;

class propertyVisit extends Model
{

    use HasFactory;

    protected $primaryKey = "PropertyVisitId";
    public $timestamps = false;
    public $table="propertyVisits";

    protected $fillable = [
        'PropertyId',
        'UserId',
        'name',
        'secondName',
        'email',
        'phone',
        'message',
        'adress',
        'visitDate',
        'visitHour',
        'ipAddress'

    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
