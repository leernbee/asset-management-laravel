<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Metable;
use Carbon\Carbon;

class Machine extends Model
{
    //
    use Metable;

    protected $metaTable = 'machines_meta';

    protected $fillable = [
        'machine_tag', 'name', 'serial', 'manufacturer', 'model', 'notes', 'machine_type_id', 'operating_system_id', 'status_id', 'support_link', 'service_date', 'location_id'
    ];

    public function setServiceDateAttribute($date)
    {
        if ($date !== null) {
            $this->attributes['service_date'] = Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['service_date'] = null;
        }
    }

    public function getServiceDateAttribute($date)
    {
        return $date == null ? '' : Carbon::parse($date)->format('m-d-Y');
    }

    public function machine_type()
    {
        return $this->belongsTo('App\MachineType');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function operating_system()
    {
        return $this->belongsTo('App\OperatingSystem');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function checks()
    {
        return $this->morphMany('App\Check', 'checkable');
    }
}
