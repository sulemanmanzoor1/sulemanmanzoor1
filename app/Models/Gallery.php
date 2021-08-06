<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'salon_id',
        'status',
    ];
    public function getPhoto()
    {
        $path = "uploads/galleries/" . $this->image;
        return url($path);
    }
}
