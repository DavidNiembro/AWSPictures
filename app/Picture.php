<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','path'
    ];
    public function gallery(){
        return $this->belongsTo('App\Gallery');
    }
}
