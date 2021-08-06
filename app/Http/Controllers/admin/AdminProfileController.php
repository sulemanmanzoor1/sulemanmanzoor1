<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    //
    public function index()
    {

        $salon_id = Auth::guard('user')->user()->id;
        $data['title'] = 'Profile';
        $data['activePage'] = 'profile';
        $data['admin'] = User::where('id', '=', $salon_id)->first();

        return view('admin.profile.index', $data);
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
        $user = User::findorfail($request->admin_id);

        if (Hash::check($request->current_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            Session::flash('success', 'successfully changed password');
            return 'success';
        } else {

            Session::flash('warning', 'Sorry try again');
            return "warning";
        }
    }
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $admin = User::findorfail($request->admin_id);
        $admin->phone = $request->phone;
        $admin->name = $request->name;
        $admin->update();
        Session::flash('success', 'profile updated');
        return back();
    }
}
