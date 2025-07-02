<?php

namespace App\Models;

use App\Models\User;
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
        'phone',
        'email',
        'address',
        'images',
        'UserId',
        'TypeAccountId',
        'password',
        'date_of_birth',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }
}
