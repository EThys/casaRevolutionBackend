<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TypeAccount extends Model
{
    //
    protected $table = "TTypeAccounts";
    protected $primaryKey = "TypeAccountId";
    protected $fillable = ['name'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
