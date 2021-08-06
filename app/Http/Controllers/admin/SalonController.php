<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\CreateSalon;
use App\Models\City;
use App\Models\Country;
use App\Models\Salon;
use App\Models\Coupon;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SalonController extends Controller
{
    //
    public function registershow()
    {
        $data['title'] = 'Salon Register';
        $data['countries'] = Country::where('status', '=', '1')->get();
        return view('admin.salon.register', $data);
    }
	public function delete(Request $request)
    {

		
		
        $salon=Salon::find($request->salon_id);
         @unlink(public_path('uploads/salons'.$salon->image));
		$galleries=Gallery::where('salon_id','=',$request->salon_id)->get();
		if($galleries->isNotEmpty()){
			foreach($galleries as $gallery){
			   @unlink(public_path('uploads/galleries/'.$gallery->image));
                Gallery::find($gallery->id)->delete();			   
			}
		}
		$services=Service::where('salon_id','=',$request->salon_id)->get();
		if($services->isNotEmpty()){
			foreach($services as $service){
			   @unlink(public_path('uploads/services/'.$service->image));
                Service::find($gallery->id)->delete();			   
			}
		}
		$coupons=Coupon::where('salon_id','=',$request->salon_id)->get();
		if($coupons->isNotEmpty()){
			foreach($coupons as $coupon){
				Coupon::find($coupon->id)->delete();
			}
			
		}
		$ratings=Rating::where('salon_id','=',$request->salon_id)->get();
		if($ratings->isNotEmpty()){
			foreach($ratings as $rating){
				Rating::find($rating->id)->delete();
			}	
		}
        $salon->delete();
        $message = array('message' => __('file.salon') . ' ' . __('file.deleted_successfully'), 'status' => 200);
        echo json_encode(($message));
        die;
    }
    public function index()
    {
        $data['title'] =  __('file.salon');
        $data['activePage'] = 'salon';
        $data['title'] = __('file.salon');
        $data['salons'] = Salon::get();
        return view('admin.salon.index', $data);
    }
    public function detail($id)
    {
        $data['title'] =  __('file.salon');
        $data['activePage'] = 'salon';
        $data['title'] = __('file.salon');

        $data['salon'] = Salon::where('id', '=', $id)->first();

        return view('admin.salon.detail', $data);
    }
    public function salon()
    {
        $data['title'] = __('file.add') . ' ' . __('file.salon');
        $data['activePage'] = 'salon';

        $data['countries'] = Country::where('status', '=', '1')->get();
        return view('admin.salon.add', $data);
    }
    public function store(Request $request)
    {
        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'password' => 'required',
            'salon_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
		$name=$request->fname.' '.$request->lname;
		$email=$request->email;
		$password=$request->password;
        

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
		
		
        $final = array();
        $final['sunday'] = "";
        $final['monday'] = "";
        $final['tuesday'] = "";
        $final['wednesday'] = "";
        $final['thursday'] = "";
        $final['friday'] = "";
        $final['saturday'] = '';
	
		$data = array('heading' => 'Salon Registered', 'body' => "Hi $name salon is registered against your email your credentials email:$email password:$password", 'base_url' => '{{route("salon")}}', 'button_name' => 'Login');
        $mail = Mail::to($request->email)->send(new CreateSalon($data));
        if (count(Mail::failures()) > 0) {
            $errors = 'Failed to send password reset email, please try again.';
        }
		
        $destinationPath = public_path('uploads/salons');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        DB::beginTransaction();
        $salon = new Salon;
        $salon->first_name = $request->fname;
        $salon->last_name = $request->lname;
        $salon->email = $request->email;
        $salon->phone = $request->phone;
        $salon->city_id = $request->city;
        $salon->salon_name = $request->salon_name;
        $salon->country_id = $request->country;
        $salon->password = Hash::make($request->password);
        $salon->image = $filename;
        $salon->timing =json_encode($final);
        $salon->status = 1;
		$salon->service_charges=0;
        $salon->save();
        DB::commit();
        $request->session()->flash('success', __('file.salon_register_successfully'));
        return back();
    }
    public function status(Request $request)
    {

        $salon = Salon::find($request->salon_id);
        if ($salon) {
            $salon->status = $request->status;
            $salon->update();
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
    }
    public function edit($id)
    {

        $salon = Salon::findorfail($id);

        if ($salon) {
            $data['salon'] = $salon;
            $data['title'] = __('file.edit') . ' ' . __('file.salon');
            $data['countries'] = Country::where('status', '=', '1')->get();
            $data['cities'] = City::where('status', '=', '1')->get();
            $data['activePage'] = 'salon';
            return view('admin.salon.edit', $data);
        }
    }
    public function update(Request $request)
    {
        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'salon_name' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('uploads/salons/');
            $filename = rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            @unlink('uploads/salons/' . $request->old_image);
        } else {
            $filename = $request->old_image;
        }

        DB::beginTransaction();
        $salon = Salon::findorfail($request->salon_id);

        $salon->first_name = $request->fname;
        $salon->last_name = $request->lname;
        $salon->email = $request->email;
        $salon->phone = $request->phone;
        $salon->city_id = $request->city;
        $salon->country_id = $request->country;
        $salon->salon_name = $request->salon_name;
        $salon->image = $filename;
        $salon->save();
        DB::commit();

        $request->session()->flash('success', __('file.salon_register_successfully'));
        return back();
    }
    public function salonregister(Request $request)
    {

     
        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:salons,email',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'password' => 'required',
            'salon_name' => 'required',
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
        $destinationPath = public_path('uploads/salons');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        $final = array();
        $final['sunday'] = "";
        $final['monday'] = "";
        $final['tuesday'] = "";
        $final['wednesday'] = "";
        $final['thursday'] = "";
        $final['friday'] = "";
        $final['saturday'] = '';
        DB::beginTransaction();
        $salon = new Salon;
        $salon->first_name = $request->fname;
        $salon->last_name = $request->lname;
        $salon->email = $request->email;
        $salon->phone = $request->phone;
        $salon->city_id = $request->city;
        $salon->salon_name = $request->salon_name;
        $salon->country_id = $request->country;
        $salon->timing = $final;
        $salon->password = Hash::make($request->password);
        $salon->image = $filename;
        $salon->status = 0;
        $salon->save();
        DB::commit();

        $request->session()->flash('success', __('file.salon_register_successfully'));
        return back();
    }
}
