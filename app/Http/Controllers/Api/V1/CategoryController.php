<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::where('status', '=', 1)->get();
        if ($categories->isNotEmpty()) {
            foreach ($categories as $key => $category) {
                $categories[$key]['image'] = $category->getPhoto();
            }
            return response()->json(['message' => 'all categories', 'status' => true, 'data' => $categories], 200);
        } else {
            return response()->json(['message' => 'no category found', 'status' => false,], 404);
        }
    }
}
