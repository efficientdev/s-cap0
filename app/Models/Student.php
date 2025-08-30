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


    public static function formatCustomCode(
        string $param1,
        string $param2,
        string $param3,
        string $param4,
        string $param5,
        string $param6, // date string (e.g., '2025-08-29')
        string $param7
    ): string {
        // Extract and format each parameter
        $part1 = $param1;//strtoupper(substr($param1, 0, 2));                   // First 2 chars, uppercase
        $part2 = $param2;//strtoupper(substr($param2, 0, 3));                   // First 3 chars, uppercase
        $part3 = str_pad($param3, 3, '0', STR_PAD_LEFT);              // Left pad with zero to length 3
        $part4 = strtoupper(substr($param4, 0, 1));                   // First char, uppercase
        $part5 = strtoupper(substr($param5, 0, 1));                   // First char, uppercase
        $part6 = date('y', strtotime($param6));                      // Double digit year from date
        $part7 = str_pad($param7, 6, '0', STR_PAD_LEFT);              // Left pad with zero to length 6

        $part45=implode('', [$part4, $part5]);

        // Concatenate with slashes
        return implode('/', [$part1, $part2, $part3, $part45, $part6, $part7]);
    }


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $r=$model->meta;
            //if (isset($r['custom_id'])) {

                $sl=StatesAndLgas::get()->keyBy('id');
                $s=$r['state_id'];

                $st=$sl[$s];
                $l=$st['lgas'][$r['lga_id']];

                $s1=StateList::where('name',$st->state_name)->first();
                $s2=LgaList::where('lga_name',$l??'')->first();

                $r['custom_id']=Student::formatCustomCode(
                    $s1->abbreviation??strtoupper(substr($st->state_name, 0, 2))??'',
                    $s2->abbreviations??strtoupper(substr($l, 0, 3))??'',
                    $r['school_id'],
                    $r['last_name'],
                    $r['first_name'],
                    $r['date_of_birth'],
                    $model->id??0
                );
                $model->meta=$r;
            /*}
            if (Auth::check()) {
                if (empty($model->school_id)) {
                    $model->school_id = Auth::user()->school_id;
                }
            }*/
        });
    }



    /**
     * The user who made the capture.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
