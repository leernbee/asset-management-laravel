<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\File;
use Spatie\Image\Manipulations;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable;
    use HasMediaTrait;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'username', 'birth_date', 'contact_no', 'employee_id', 'job_title', 'location_id', 'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setBirthDateAttribute($date)
    {
        if ($date !== null) {
            $this->attributes['birth_date'] = Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['birth_date'] = null;
        }
    }

    public function getBirthDateAttribute($date)
    {
        return $date == null ? '' : Carbon::parse($date)->format('m-d-Y');
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('avatars')
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg';
            });
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, 200, 200)
            ->background('white')
            ->optimize();
    }

    public function targets()
    {
        return $this->morphMany('App\Check', 'targetable');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
