<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyPropertyFeature extends Pivot
{
    protected $table = 'TPropertyPropertyFeature';
    protected $primaryKey = 'PropertyPropertyFeatureId';
    public $timestamps = false;
}
