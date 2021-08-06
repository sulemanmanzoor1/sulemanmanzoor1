<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use App\Models\Slider;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class SliderController extends Controller
{
    public function index()
    {

        # code...
        $data['activePage'] = 'sliders';
        $data['title'] = __('file.sliders');
        $data['sliders'] = Slider::all();
        return view('admin.sliders.index', $data);
    }
	public function setting(){
		 $data['activePage'] = 'setting';
        $data['title'] = __('file.setting');
		$data['setting']=Setting::where('id','=',1)->first();
        return view('admin.setting.index', $data);
	}
	public function aboutus()
    {

        # code...
        $data['activePage'] = 'aboutus';
        $data['title'] = __('file.aboutus');
		$data['setting']=Setting::where('id','=',1)->first();
        return view('admin.about.index', $data);
    }
	public function settingupdate(Request $request){
		$rules=[
		'commission'=>'required|numeric',
		'name'=>'required',
		'currency'=>'required',
		];
		$validator=validator::make($request->all(),$rules);
		if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
		$setting=Setting::find(1);
		$setting->site_name=$request->name;
		$setting->commission=$request->commission;
		$setting->currency=$request->currency;
		$setting->update();
		 $request->session()->flash('success','content upadeted successfully');
        return back();
	}
	public function aboutusstore(Request $request){
		$rules=[
		'content'=>'required',
		];
		$validator=validator::make($request->all(),$rules);
		if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
		$setting=Setting::find(1);
		$setting->about_us=$request->content;
		$setting->update();
		 $request->session()->flash('success','content upadeted successfully');
        return back();
	}
	public function status(Request $request)
    {

        $slider = Slider::find($request->slider_id);
        if ($slider) {
            $slider->status = $request->status;
            $slider->update();
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
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
        $destinationPath = public_path('uploads/sliders');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        DB::beginTransaction();
        $slider = new Slider();
        $slider->image = $filename;
        $slider->save();
        DB::commit();
        $request->session()->flash('success', __('file.uploaded'));
        return back();
    }
}
