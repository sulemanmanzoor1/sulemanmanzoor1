<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $filable = [
        'recipt_id',
        'service_name',
        'service_id',
    ];
	
    public function service(){
		return $this->belongsTo(Service::class);
	}
}
