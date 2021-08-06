<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Gallery;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\CreateSalon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgetPassword;
class ReviewController extends Controller
{
  
  
  public function addSalonReview(Request $request){
	  $rules=[
		   'salon_id'=>'required',
		   'user_id'=>'required',
		   'rating'=>'required',
		   'description'=>'required',
		];
		$validator=Validator::make($request->all(),$rules);
		if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
			
			$rating=new Rating;
			$rating->salon_id=$request->salon_id;
			$rating->user_id=$request->user_id;
			$rating->rating=$request->rating;
			$rating->description=$request->description;
			$rating->save();
			 return response()->json(['message' => 'review added successfully', 'status' => true,], 201);
		}
  }
  public function getSalonReview(Request $request){
		$rules=[
		   'salon_id'=>'required',
		];
		$validator=Validator::make($request->all(),$rules);
		if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
			$ratings=Rating::where('salon_id','=',$request->salon_id)->get();
			
			if($ratings->isNotEmpty()){
				foreach($ratings as $key=>$rating){
				$ratings[$key]['user_name']=$rating->user->name;
				 $ratings[$key]['user']['image']=url("uploads/users/". $ratings[$key]['user']['image']);
			}
				return response()->json(['message' => 'ratings', 'status' => true, 'data' => $ratings], 200);
			}else{
				 return response()->json(['message' => 'not found', 'status' => false,], 404);
     
			}
		}
	}
  
  
  
  
}


?>