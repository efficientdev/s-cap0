<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaptureLog extends Model
{
    //
    protected $fillable = [
        'subject_id',
        'capture_path',
        'status','notes','user_id'
    ];

    protected $casts = [ 
        //'status' => 'array', 
        'notes' => 'array', 
    ];

    /*
            $table->text('subject_id');
            $table->text('capture_path');
            $table->text('status')->nullable()->default('pending');*/
}
