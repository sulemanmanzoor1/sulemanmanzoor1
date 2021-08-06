<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    //
    public function index(Request $request)
    {
        $salon_id = Auth::guard('salon')->user()->id;
        $data['activePage'] = 'gallery';
        $data['title'] = __('file.gallery');
        $data['galleries'] = Gallery::where('salon_id', '=', $salon_id)->get();
        return view('salon.gallery.index', $data);
    }
    public function store(Request $request)
    {
        # code...
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
        $destinationPath = public_path('uploads/galleries');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        DB::beginTransaction();
        $gallery = new Gallery();
        $gallery->image = $filename;
        $gallery->salon_id = Auth::guard('salon')->user()->id;
        $gallery->save();
        DB::commit();
        $request->session()->flash('success', __('file.uploaded'));
        return back();
    }
    public function status(Request $request)
    {

        $gallery = Gallery::find($request->gallery_id);
        if ($gallery) {
            $gallery->status = $request->status;
            $gallery->update();
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
    }
}
