<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'status',
        'image',
    ];
	public function service(){
		return $this->hasMany(Service::class);
	}
    public function getPhoto()
    {
        $path = "uploads/categories/" . $this->image;
        return url($path);
    }
}
