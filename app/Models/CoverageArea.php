<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CoverageArea extends Eloquent
{
    protected $fillable = ['type', 'coordinates'];

    protected $casts = [
        'coordinates' => 'array'
    ];
}