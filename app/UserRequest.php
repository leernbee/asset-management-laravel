<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserRequest extends Model
{
    public function worker()
    {
        return $this->belongsTo('App\User');
    }

    public function requester()
    {
        return $this->belongsTo('App\User');
    }
}
