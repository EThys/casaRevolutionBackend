<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Property;
use App\Models\User;

class propertyVisit extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = "PropertyVisitId";
    public $timestamps = false;
    public $table="TPropertyVisits";

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
        'status',
        'ipAddress',
        'cancellation_reason'

    ];

    public function property()
    {
        return $this->belongsTo(Property::class,'PropertyId');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'UserId');
    }
}
