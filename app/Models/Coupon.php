<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'salon_id',
        'code',
        'description',
        'type',
        'max_user',
        'start_date',
        'end_date',
    ];
}
