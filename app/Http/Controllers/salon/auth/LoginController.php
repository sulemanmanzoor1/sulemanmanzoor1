<?php

namespace App\Http\Controllers\salon\auth;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        $data['title'] = __('file.salon_login');
        return view('salon.login', $data);
    }
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('salon')->attempt(array('email' => $request->email, 'password' => $request->password, 'role' => 3), $request->remember)) {
            $data['activePage'] = 'dashboard';
            $data['title'] = __('file.dashboard');
            return redirect()->route('salon.dashboard')->with($data);
        } else {
            $request->session()->flash('warning', 'Your email or password is incorrect');
            return back()->withInput();;
        }
    }
	public function forgetPassword(Request $request){
		$validator = Validator(
            [


                'email' => $request->email,

            ],
            [
                'email' => 'required',

            ]
        );
		  if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
			$user=User::find($request->email);
			if($user){
				
			}else{
				return response()->json(['message' => "email does not exsit", 'status' => false,], 404);
        
			}
			
		}
	}
    public function logout()
    {
        Auth::guard('salon')->logout();
        return redirect()->route('salon');
    }
}
