<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'status',
    ];
    public function getPhoto()
    {
        $path = "uploads/sliders/" . $this->image;
        return url($path);
    }
}
