<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TimeController extends Controller
{
    public function index(Request $request)
    {
        $data['activePage'] = 'time';
        $data['title'] = __('file.time_management');
        $salon_id = Auth::guard('salon')->user()->id;
        $data['salon'] = Salon::where('id', '=', $salon_id)->first();
        return view('salon.time.index', $data);
    }
    public function store(Request $request)
    {
        $final = array();
        if ($request->ssunday || $request->esunday) {
            $rules = [
                'ssunday' => 'required',
                'esunday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['sunday'] = $request->ssunday . ',' . $request->esunday;
        } else {
            $final['sunday'] = "";
        }
        if ($request->smonday || $request->emonday) {
            $rules = [
                'smonday' => 'required',
                'emonday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['monday'] = $request->smonday . ',' . $request->emonday;
        } else {
            $final['monday'] = "";
        }
        if ($request->stuesday || $request->etuesday) {
            $rules = [
                'stuesday' => 'required',
                'etuesday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['tuesday'] = $request->stuesday . ',' . $request->etuesday;
        } else {
            $final['tuesday'] = "";
        }
        if ($request->swednesday || $request->ewednesday) {
            $rules = [
                'swednesday' => 'required',
                'ewednesday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['wednesday'] = $request->swednesday . ',' . $request->ewednesday;
        } else {
            $final['wednesday'] = "";
        }
        if ($request->sthursday || $request->ethursday) {
            $rules = [
                'sthursday' => 'required',
                'ethursday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['thursday'] = $request->sthursday . ',' . $request->ethursday;
        } else {
            $final['thursday'] = "";
        }
        if ($request->sfriday || $request->efriday) {
            $rules = [
                'sfriday' => 'required',
                'efriday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['friday'] = $request->sfriday . ',' . $request->efriday;
        } else {
            $final['friday'] = "";
        }
        if ($request->ssaturday || $request->esaturday) {
            $rules = [
                'ssaturday' => 'required',
                'esaturday' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
            $final['saturday'] = $request->ssaturday . ',' . $request->esaturday;
        } else {
            $final['saturday'] = '';
        }
        $salon_id = Auth::guard('salon')->user()->id;
        $salon = Salon::findorfail($salon_id);
        $salon->timing = $final;
        $salon->save();
        Session::flash('success', 'timings set');
        return 'success';
    }
}
