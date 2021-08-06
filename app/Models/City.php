<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $filable = [
        'city_name',
        'country_id',
        'status',


    ];
    public function Country()
    {
        return $this->belongsTo(Country::class);
    }
	 public function salon()
    {
        return $this->hasOne(Salon::class);
    }
}
