<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $guarded = [];
    //

    public function scopeSearch($query , $s){
        return $query -> where('title' , 'like' , '%' .$s.'%');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
