<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

class CouponController extends Controller
{
    //
    public function index()
    {
        $data['activePage'] = 'coupon';
        $data['title'] = __('file.coupon');
        $salon_id = Auth::guard('salon')->user()->id;
        $data['coupons'] = Coupon::where('salon_id', '=', $salon_id)->get();
        return view('salon.coupon.index', $data);
    }
    public function add()
    {
        $data['activePage'] = 'coupon';
        $data['title'] = __('file.add_coupon');

        return view('salon.coupon.add', $data);
    }
    public function edit($id)
    {
        $data['activePage'] = 'coupon';
        $data['title'] = __('file.edit_coupon');
        $salon_id = Auth::guard('salon')->user()->id;
        $data['coupon'] = Coupon::where('id', '=', $id)->first();
        return view('salon.coupon.edit', $data);
    }
    public function update(Request $request)
    {

        $rules = [
            'description' => 'required',
            'discount_option' => 'required',
            'discount' => 'required',
            'start_date' => 'required',
            'max_use' => 'required',
            'end_date' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $coupon = Coupon::findorfail($request->coupon_id);

        $coupon->description = $request->description;
        $coupon->discount = $request->discount;
        $coupon->type = $request->discount_option;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->update();
        $request->session()->flash('success', 'coupon updated successfully');
        return "success";
    }
    public function store(Request $request)
    {
        $rules = [
            'code' => 'required',
            'description' => 'required',
            'discount_option' => 'required',
            'discount' => 'required',
            'start_date' => 'required',
            'max_use' => 'required',
            'end_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $coupon = new Coupon;
        $coupon->salon_id = Auth::guard('salon')->user()->id;
        $coupon->code = $request->code;
        $coupon->description = $request->description;
        $coupon->discount = $request->discount;
        $coupon->type = $request->discount_option;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->save();
        $request->session()->flash('success', 'coupon created successfully');
        return redirect()->route('coupon');
    }
    public function status(Request $request)
    {

        $coupon = Coupon::find($request->coupon_id);
        if ($coupon) {
            $coupon->status = $request->status;
            $coupon->update();
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
    }
}
