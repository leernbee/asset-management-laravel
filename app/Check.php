<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    //
    public function checkable()
    {
        return $this->morphTo();
    }

    public function targetable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected $dates = ['action_date'];
}
