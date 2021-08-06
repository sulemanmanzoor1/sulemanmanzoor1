<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Notification extends Authenticatable
{
    use HasFactory, Notifiable;
	
	
	  protected $fillable = [
        'title',
		'message',
		'image',
		'salon_id'
    ];
	
	 public function getPhoto()
    {
        $path = "uploads/notification/" . $this->image;
        return url($path);
    }
	
	
	
	
	
	
}