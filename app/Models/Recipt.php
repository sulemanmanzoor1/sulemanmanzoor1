<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipt extends Model
{
    use HasFactory;
    protected $filable = [
        'city_name',
        'country_name',
        'user_id',
		'salon_id',
		'appointment_date',
		'appointment_time',
		'total_price',
		'payment_method',
    ];
	
	public function appointment(){
		return $this->hasMany(Appointment::class);
	}
	public function salon(){
		return $this->belongsTo(Salon::class);
	}
	public function user(){
		return $this->belongsTo(User::class);
	}
   
}
