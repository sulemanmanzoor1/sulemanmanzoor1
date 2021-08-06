<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_name',
        'service_price',
        'service_time',
        'category_id',
        'salon_id',
        'image',
        'status',
        'is_discount',
        'discount',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }
    public function getPhoto()
    {
        $path = "uploads/services/" . $this->image;
        return url($path);
    }
}
