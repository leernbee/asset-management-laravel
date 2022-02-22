<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $fillable = [
        'name', 'parent_id', 'manager_id', 'address1', 'address2', 'city', 'state', 'country', 'zip'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Location');
    }

    public function manager()
    {
        return $this->belongsTo('App\User');
    }

    public function locations()
    {
        return $this->hasMany('App\Location');
    }
}
