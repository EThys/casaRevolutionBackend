<?php

namespace App\Models;

use App\Models\User;
use App\Models\TypeCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commissionnaire extends Model
{
    //
    protected $table = "TCommissionnaires";
    protected $primaryKey = "CommissionnaireId";
    protected $fillable = [
        'first_name',
        'last_name',
        'fullname',
        'phone',
        'email',
        'address',
        'images',
        'UserId',
        'TypeCardId',
        'number_card',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }

    public function type_card(): BelongsTo
    {
        return $this->belongsTo(TypeCard::class, 'TypeCardId', 'TypeCardId');
    }
}
