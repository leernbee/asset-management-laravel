<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class License extends Model
{
    //
    protected $fillable = [
        'name', 'manufacturer', 'software_type_id', 'version', 'vendor', 'product_key', 'seats', 'license_name', 'license_email', 'purchase_date', 'expiration_date', 'notes'
    ];

    public function software_type()
    {
        return $this->belongsTo('App\SoftwareType');
    }

    public function setPurchaseDateAttribute($date)
    {
        if ($date !== null) {
            $this->attributes['purchase_date'] = Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['purchase_date'] = null;
        }
    }

    public function getPurchaseDateAttribute($date)
    {
        return $date == null ? '' : Carbon::parse($date)->format('m-d-Y');
    }

    public function setExpirationDateAttribute($date)
    {
        if ($date !== null) {
            $this->attributes['expiration_date'] = Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['expiration_date'] = null;
        }
    }

    public function getExpirationDateAttribute($date)
    {
        return $date == null ? '' : Carbon::parse($date)->format('m-d-Y');
    }

    public function checks()
    {
        return $this->morphMany('App\Check', 'checkable');
    }
}
