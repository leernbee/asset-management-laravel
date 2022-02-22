<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    //
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    protected $fillable = [
        'name', 'desc'
    ];
}
