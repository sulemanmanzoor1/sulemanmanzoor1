<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $salon_id = Auth::guard('salon')->user()->id;
        $data['title'] = 'Profile';
        $data['activePage'] = 'profile';
        $data['salon'] = Salon::where('id', '=', $salon_id)->first();
        return view('salon.profile.index', $data);
    }
    public function setting()
    {
        $salon_id = Auth::guard('salon')->user()->id;
        $data['salon'] = Salon::where('id', '=', $salon_id)->first();
        $data['title'] = __('file.setting');
        $data['activePage'] = 'setting';
        return view('salon.profile.setting', $data);
    }
    public function updatesetting(Request $request)
    {
        $rules = [
            'website' => 'required',
            'description' => 'required',
            'lat' => 'required',
            'lng' => 'required',
			'slot_allowed'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $salon_id = Auth::guard('salon')->user()->id;
        DB::transactionLevel();
        $salon = Salon::findorfail($salon_id);
        $salon->description = $request->description;
        $salon->lat = $request->lat;
        $salon->lng = $request->lng;
		$salon->slot_allowed=$request->slot_allowed;
		$salon->give_service=$request->give_service;
		$salon->service_charges=$request->service_charges;
        $salon->website = $request->website;
        $salon->update();
        DB::commit();
        Session::flash('success', 'Salon setting updates');
        return "success";
    }
    public function profile(Request $request)
    {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
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
        $salon->first_name = $request->first_name;
        $salon->last_name = $request->last_name;
        $salon->phone = $request->phone;
        $salon->image = $filename;
        $salon->save();
        DB::commit();
        Session::flash('success', 'profile updated successfully');
        return back();
    }
    public function change(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $salon = Salon::findorfail($request->salon_id);

        if (Hash::check($request->current_password, $salon->password)) {
            $salon->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            Session::flash('success', 'successfully changed password');
            return 'success';
        } else {

            Session::flash('warning', 'Sorry try again');
            return "warning";
        }
    }
}
