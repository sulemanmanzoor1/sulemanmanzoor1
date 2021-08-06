<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    //
    public function index()
    {

        $data['activePage'] = 'cities';
        $data['title'] = __('file.cities');
        $data['countries'] = Country::where('status', '=', 1)->get();
        $data['cities'] = City::get();
        return view('admin.city.index', $data);
    }
    public function status(Request $request)
    {
        $city = City::find($request->city_id);
        if ($city) {
            $city->status = $request->status;
            $city->update();
            $message = array('message' => __('file.city') . ' ' . __('file.status_added_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
    }
    public function store(Request $request)
    {
        $rules = [
            'city' => 'required',
            'country' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        DB::beginTransaction();
        $city = new City;
        $city->city_name = $request->city;
        $city->country_id = $request->country;
        $city->save();
        DB::commit();
        $request->session()->flash('success', 'city added successfully');
        return 'success';
    }
    public function edit(Request $request)
    {
        $rules = [
            'city_id' => 'required',
            'country' => 'required',
            'city' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        DB::beginTransaction();
        $city = City::find($request->city_id);
        if ($city) {
            $city->city_name = $request->city;
            $city->country_id = $request->country;
            $city->update();
            DB::commit();
            $request->session()->flash('success', 'city updated successfully');
            return 'success';
        } else {
            $request->session()->flash('warning', 'Sorry try again');
            return 'warning';
        }
    }
    public function search(Request $request)
    {
        $cities = City::where('status', '=', 1)->where('country_id', '=', $request->country_id)->get();
 
        if ($cities->isNotEmpty()) {
            $message = array('status' => 200, 'data' => $cities);
            echo json_encode($message);
            die;
        } else {
            $message = array('status' => 401, 'message' => 'no city found');
            echo json_encode($message);
            die;
        }
    }
    public function delete(Request $request)
    {
        $city = City::findorfail($request->city_id);

        $city->delete();
        $message = array('message' => __('file.city') . ' ' . __('file.deleted_successfully'), 'status' => 200);
        echo json_encode(($message));
        die;
    }
}
