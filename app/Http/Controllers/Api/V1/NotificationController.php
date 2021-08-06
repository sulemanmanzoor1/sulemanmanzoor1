<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipt;
use App\Models\Salon;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
	
	
	
	public function index(){
		$notification=Notification::all();
		if($notification->isNotEmpty()){
			foreach($notification as $key=>$not){
				$notification[$key]['image']=$not->getPhoto();
			}
		return response()->json(['message' => 'All notifications', 'data'=>$notification, 'status' => true], 200);

		}else{
		  return response()->json(['message' => 'no notification found', 'status' => false,], 404);	
		}
	}
	public function specific(Request $request){
		 $validator = Validator::make($request->all(), [
            'user_id' => 'required',   
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false,], 400);
        }
		$notification=Notification::where('user_id','=',$request->user_id)->get();
		if($notification->isNotEmpty()){
			
		return response()->json(['message' => 'All notifications', 'data'=>$notification, 'status' => true], 200);

		}else{
		  return response()->json(['message' => 'no notification found', 'status' => false,], 404);	
		}
	}
	
	
	
	
	
	
	
	
	
	
}