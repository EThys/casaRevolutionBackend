<?php

namespace App\Models;

use App\Models\Bailleur;
use Illuminate\Database\Eloquent\Model;

class TypeCard extends Model
{
    //
    protected $table = "TTypeCards";
    protected $primaryKey = "TypeCardId";
    protected $fillable = ['name'];

    public function bailleur()
    {
        return $this->hasMany(Bailleur::class, 'TypeCardId');
    }
}
