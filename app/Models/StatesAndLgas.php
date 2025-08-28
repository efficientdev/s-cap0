<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatesAndLgas extends Model
{
    //

    protected $fillable = [
        'state_name',
        'lgas', 
    ];

    protected $casts = [  
        'lgas' => 'array', 
    ];
}
