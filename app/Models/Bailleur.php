<?php

namespace App\Models;

use App\Models\User;
use App\Models\TypeCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bailleur extends Model
{
    protected $table = "TBailleurs";
    protected $primaryKey = "BailleurId";
    protected $fillable = [
        'first_name',
        'last_name',
        'fullname',
        'phone',
        'email',
        'address',
        'images',
        'ParrainId',
        'UserId',
        'TypeCardId',
        'number_card',
        'note'
    ];
    public function parrain(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ParrainId', 'UserId');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }
    public function type_card(): BelongsTo
    {
        return $this->belongsTo(TypeCard::class, 'TypeCardId', 'TypeCardId');
    }
}
