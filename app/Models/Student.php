<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //meta

    protected $fillable = [
        'subject_id',
        'meta',
        'user_id',
        'photo'
        //,'class_list_id','school_id'
    ];

    protected $casts = [  
        'meta' => 'array', 
    ];

    /*public $with=['studentClass','school']; 
    public function studentClass()
    {
        return $this->belongsTo(ClassList::class);
    } 
    public function school()
    {
        return $this->belongsTo(School::class);
    }*/


    /**
     * The user who made the capture.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
