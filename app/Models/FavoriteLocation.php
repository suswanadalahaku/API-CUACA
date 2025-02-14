<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteLocation extends Model
{
    protected $fillable = [
        'name',
        'city',
        'country',
        'latitude',
        'longitude',
        'notes'
    ];
}
