<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index()
    {
        # code...
        $data['activePage'] = 'category';
        $data['title'] = __('file.category');
        $data['categories'] = Category::get();
        return view('admin.category.index', $data);
    }
    public function add()
    {
        $data['activePage'] = 'category';
        $data['title'] = __('file.add_category');

        return view('admin.category.add', $data);
    }
    public function store(Request $request)
    {
        $rules = [
            'category' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $image = $request->file('image');
        $fileArray = array('image' => $image);
        $rules = array(
            'image' => 'required|mimes:jpeg,gif,png,jpg' // max 10000kb

        );
        $validator = Validator::make($fileArray, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $destinationPath = public_path('uploads/categories');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        DB::beginTransaction();
        $category = new Category();
        $category->category_name = $request->category;
        $category->image = $filename;
        $category->save();
        DB::commit();
        $request->session()->flash('success', __('file.category_created_successfully'));
        return back();
    }
    public function status(Request $request)
    {

        $category = Category::find($request->category_id);
        if ($category) {
            $category->status = $request->status;
            $category->update();
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
    }
    public function delete(Request $request)
    {
        $category = Category::findorfail($request->category_id);
        @unlink('uploads/categories/' . $category->image);
        $category->delete();
        Session::flash('success', 'Category deleted successfully!');
        return back();
    }
}
