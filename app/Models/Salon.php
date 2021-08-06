<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Salon extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'country_id',
        'city_id',
        'image',
        'status',
        'phone',
        'wallet',
        'role',
        'salon_name',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function gallery()
    {
        return $this->hasMany(Gallery::class)->where('status', '=', 1);
    }
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    public function avgRating()
    {

        return $this->rating()->avg('rating')  ?: 0;
    }
    public function getPhoto()
    {
        $path = "uploads/salons/" . $this->image;
        return url($path);
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
