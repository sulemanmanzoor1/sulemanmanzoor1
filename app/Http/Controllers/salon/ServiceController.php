<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Salon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $data['title'] =  __('file.services');
        $data['activePage'] = 'service';
        $data['salons'] = Salon::all();
        $salon_id = Auth::guard('salon')->user()->id;
        $data['services'] = Service::where('salon_id', '=', $salon_id)->get();

        return view('salon.service.index', $data);
    }
    public function add()
    {
        $data['title'] = __('file.add') . ' ' . __('file.service');
        $data['activePage'] = 'service';
        $data['categories'] = Category::where('status', '=', '1')->get();
        return view('salon.service.add', $data);
    }
    public function store(Request $request)
    {

        $rules = [
            'service_name' => 'required',
            'service_price' => 'required',
            'service_time' => 'required',
            'category' => 'required',
        ];
        if ($request->discount_option == 1) {
            $rule['discount'] = 'required';
            $rules = array_merge($rules, $rule);
        }

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
        $salon_id = Auth::guard('salon')->user()->id;
        $destinationPath = public_path('uploads/services');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        DB::beginTransaction();
        $service = new Service();
        $service->service_name = $request->service_name;
        $service->service_price = $request->service_price;
        $service->service_time = $request->service_time;
        $service->category_id = $request->category;
        $service->salon_id = $salon_id;
        $service->is_discount = $request->discount_option;
        if ($request->discount_option == 1) {
            $service->discount = $request->discount;
        } else {
            $service->discount = 0;
        }

        $service->image = $filename;
        $service->save();
        DB::commit();
        $request->session()->flash('success', __('file.salon_register_successfully'));
        return back();
    }
    public function status(Request $request)
    {

        $service = Service::find($request->service_id);
        if ($service) {
            $service->status = $request->status;
            $service->update();
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
    }
    public function delete(Request $request)
    {

        $Service = Service::findorfail($request->service_id);
        @unlink('uploads/services/' . $Service->image);
        $Service->delete();
        Session::flash('success', 'service deleted successfully!');
        return back();
    }
    public function edit($id)
    {

        $service = Service::findorfail($id);

        if ($service) {
            $data['service'] = $service;
            $data['title'] = __('file.edit') . ' ' . __('file.service');
            $data['categories'] = Category::where('status', '=', '1')->get();
            $data['activePage'] = 'service';
            return view('salon.service.edit', $data);
        }
    }
    public function update(Request $request)
    {
        $rules = [
            'service_name' => 'required',
            'service_price' => 'required',
            'service_time' => 'required',
            'category' => 'required',
        ];
        if ($request->discount_option == 1) {
            $rule['discount'] = 'required';
            $rules = array_merge($rules, $rule);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('uploads/services/');
            $filename = rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            @unlink('uploads/services/' . $request->old_image);
        } else {
            $filename = $request->old_image;
        }

        DB::beginTransaction();
        $service = Service::findorfail($request->service_id);

        $service->service_name = $request->service_name;
        $service->service_price = $request->service_price;
        $service->service_time = $request->service_time;
        $service->category_id = $request->category;
        $service->is_discount = $request->discount_option;
        if ($request->discount_option == 1) {
            $service->discount = $request->discount;
        } else {
            $service->discount = 0;
        }
        $service->image = $filename;
        $service->save();
        DB::commit();

        $request->session()->flash('success', __('file.updated_successfully'));
        return back();
    }
}
