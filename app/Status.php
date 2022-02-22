<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    protected $fillable = [
        'name', 'desc', 'type'
    ];
}
