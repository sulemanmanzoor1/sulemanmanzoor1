<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class CountryController extends Controller
{


    public function index()
    {

        $data['activePage'] = 'countries';
        $data['title'] = __('file.countries');
        $data['countries'] = Country::get();
        return view('admin.country.index', $data);
    }
    public function status(Request $request)
    {

        $country = Country::find($request->country_id);
        if ($country) {
            $country->status = $request->status;
            $country->update();

            $message = array('message' =>  __('file.country_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => 'Sorry try again', 'status' => 404);
            echo json_encode(($message));
        }
    }
    public function store(Request $request)
    {
        $rules = [
            'country' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        DB::beginTransaction();
        $country = new Country;
        $country->country_name = $request->country;
        $country->save();
        DB::commit();
        Session::flash('success', __('file.country_added_sucessfully'));
        return "success";
    }
	
	
    public function edit(Request $request)
    {
        $rules = [
            'country_id' => 'required',
            'country' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        DB::beginTransaction();
        $country = Country::find($request->country_id);
        if ($country) {
            $country->country_name = $request->country;
            $country->update();
            DB::commit();
            $request->session()->flash('success', __('file.country_updated_sucessfully'));
            return 'success';
        } else {
            $request->session()->flash('warning', 'Sorry try again');
            return 'warning';
        }
    }
}
