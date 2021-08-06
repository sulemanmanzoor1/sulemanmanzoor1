<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;

class UserController extends Controller
{
    //





    public function login(Request $request)
    {
        $validator = Validator(
            [
                'phone' => $request->phone,
                
            ],
            [
                'phone' => 'required',
              
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {

            $token = Str::random(80);
            $check_phone = User::where('phone', '=', $request->phone)->first();
            if ($check_phone) {
                $is_verify = User::where('is_verify', '=', '1')->first();
                if ($is_verify) {
                    $data = ['phone' => $request->phone,'role' => '2'];
                      $user=User::where('phone', '=', $request->phone)->first();              
				   if ($user) {
                       // $user = Auth::user();
                        $user->api_token = $token;
                        $sms_token = rand(1000, 9999);
                        $user->sms_token = $sms_token;
                        $message = "your salon beauty verification code is: $sms_token ";
                        sendMessage($message, $request->phone);
                        $user->save();
                        $user->image = url('uploads/users/') . $user->image;
                        return response()->json(['message' => 'Login Successfull','status' => true,], 200);
                    } else {
                        return response()->json(['message' => 'Unauthorised', 'data' => $data, 'status' => false,], 401);
                    }
                } else {
                    return response()->json(['message' => 'your account is not verified',  'status' => false,], 401);
                }
            } else {
                return response()->json(['message' => 'phone not found in our database',  'status' => false,], 401);
            }
        }
    }
    public function forgetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false,], 400);
        } else {
            $user = User::where('email', '=', $request->email)->first();
            if ($user) {
                $code = rand(1000, 9999);

                $data = array('heading' => 'Forget Password', 'body' => "Your Code is ", 'code' => $code);
                $mail = Mail::to($user->email)->send(new ForgetPassword($data));
                if (count(Mail::failures()) > 0) {
                    $errors = 'Failed to send password reset email, please try again.';
                    return response()->json(['message' => $errors, 'status' => false,], 404);
                } else {
                    return response()->json(['message' => 'check your mailbox', 'status' => true,], 200);
                }
            } else {
                return response()->json(['message' => 'email not found in our record', 'status' => false,], 404);
            }
        }
    }
	public function updateUser(Request $request){
		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
			'user_id'=>'required',
		
          
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false,], 400);
        } else {
        $destinationPath = public_path('uploads/users');
            if($request->image!=""){
            $image = $request->image;
          
            $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
			}
            DB::beginTransaction();
            $user = User::find($request->user_id);
			  if($request->image!=""){
				@unlink('uploads/users'.$user->image);  
				    $user->image = $filename;
			  }
            $user->name = $request->name;
            $user->birth_date = $request->birth_date;
            $user->gender = $request->gender;
            $user->country_id = $request->country_id;
            $user->city_id = $request->city_id;
            $user->sms_token =null;
            $user->save();
            DB::commit(); 
             $user->image = url('uploads/users/'.$user->image);
			 $user->city->city_name;
			 $user->country->country_name;			
            return response()->json(['message' => 'user updated successfully','data'=>$user, 'status' => true,], 200);
        }
	}
    public function signup(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
			'player_id'=>'required',
          
            'image' => 'mimes:jpeg,jpg,png,gif|required|'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false,], 400);
        } else {

            $rules = array('email' => 'unique:users,email');

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['message' => 'That email address is already registered', 'status' => false,], 400);
            }
            $rules = array('phone' => 'unique:users,phone');

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['message' => 'That phone is already registered', 'status' => false,], 400);
            }
            $image = $request->image;
            $destinationPath = public_path('uploads/users');
            $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            DB::beginTransaction();
            $user = new User;
            $user->name = $request->fname . ' ' . $request->lname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role = 2;
            $user->birth_date = $request->birth_date;
            $user->gender = $request->gender;
			$user->player_id=$request->player_id;
            $user->country_id = $request->country_id;
            $user->city_id = $request->city_id;
            $user->password ='12';
            $user->image = $filename;
            $sms_token = rand(1000, 9999);
            $user->sms_token = $sms_token;
            $message = "Deaer user,please use the code  $sms_token   to verify your Beauty Salon account";
            sendMessage($message, $request->phone);
            $user->save();
            DB::commit();  
            return response()->json(['message' => 'user created successfully', 'status' => true,], 200);
        }
    }
	public function verifyLogin(Request $request){
		$rules = [
            'phone' => 'required',
            'sms_token' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
             return response()->json(['message' => 'fileds are required', 'Error'=>$validator->errors(), 'status' => false,], 400);
       }
        $user = User::where('phone', '=', $request->phone)->where('sms_token', '=', $request->sms_token)->first();
		
            $token = Str::random(80);
        if ($user) {
            $user->sms_token = null;
            $user->api_token = $token;
            $user->save();
			 $user->image = url('uploads/users/'.$user->image);
			 $user->city->city_name;
			 $user->country->country_name;
            return response()->json(['message' => 'login  successfully','Token'=>$token,'data'=>$user, 'status' => true,], 200);
        } else {
            return response()->json(['message' => 'otp is incorrect', 'status' => false,], 401);
        }
	}
    public function verifyAccount(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'sms_token' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
             return response()->json(['message' => 'fileds are required', 'Error'=>$validator->errors(), 'status' => false,], 400);
       }
	   
            $token = Str::random(80);
        $user = User::where('phone', '=', $request->phone)->where('sms_token', '=', $request->sms_token)->first();
        if ($user) {
            $user->sms_token = null;
			  $user->api_token = $token;
            $user->is_verify = 1;
            $user->save();
			 $user->image = url('uploads/users/'.$user->image);
			  $user->city->city_name;
			 $user->country->country_name;
            return response()->json(['message' => 'Account verified successfully','Token' => $token,'data'=>$user, 'status' => true,], 200);
        } else {
            return response()->json(['message' => 'otp is incorrect', 'status' => false,], 401);
        }
    }
}
