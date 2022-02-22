<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftwareType extends Model
{
    //
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    protected $fillable = [
        'name', 'desc'
    ];
}
