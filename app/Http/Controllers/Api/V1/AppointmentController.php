<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipt;
use App\Models\Salon;
use App\Models\User;
use App\Models\Setting;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AppointmentController extends Controller
{
    //
	
	public function g(){
		 $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
		    $yearly_sale_amount = [];
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
			  $recipt=Recipt::whereDate('created_at', '>=' , $start_date)->where('salon_id', 1)->whereDate('created_at', '<=' , $end_date)->count();
			   $yearly_sale_amount[]=$recipt;
			   $start = strtotime("+1 month", $start);
			
			
		}
	
		  var_dump($yearly_sale_amount);

	}
	public function check(Request $request){
			$rules=[
		'salon_id'=>'required',
		'appointment_time'=>'required',
		'appointment_date'=>'required',
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		$appointment=Recipt::where('salon_id','=',$request->salon_id)->where('appointment_date',$request->appointment_date)->where('appointment_time','=',$request->appointment_time)->get();
		 $salon=Salon::where('id','=',$request->salon_id)->first();
		 $slot_allowed=$salon->slot_allowed;
		 $countslot_allowed=$appointment->count();
		  
		 if($countslot_allowed<=$slot_allowed){
			 return response()->json(['message' => 'you can book this slot', 'status' => true], 200);

		 }else{
			 return response()->json(['message' => 'sorry this slot is already book', 'status' => false,], 404);	 
		 }
	}   
		
	
	public function index(Request $request){
		$rules=[
		'user_id'=>'required'
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		$recipts=Recipt::where('user_id','=',$request->user_id)->where('is_completed','=',0)->where('is_canceled','=',0)->get();
		
		if($recipts->isNotEmpty()){
			foreach($recipts as $key=>$recipt){
				$recipts[$key]['salon']=$recipt->salon;
				$recipt['salon']['image']=url("uploads/salons/". $recipt['salon']['image']);
				$recipt['salon']['rating']=getSalongRating($recipt['salon']['id']);
				$services=$recipts[$key]['appointment']=$recipt->appointment;
				
				foreach($services as $key2=>$service){
				   $services[$key2]['service']=getServiceData($service['service_id']);
					
				}
			
			}
			return response()->json(['message' => 'All appointment', 'data'=>$recipts, 'status' => true], 200);

		}else{
		  return response()->json(['message' => 'no appointment found', 'status' => false,], 404);	
		}
	}
	public function cancel(Request $request){
		$rules=[
		'user_id'=>'required'
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		$recipts=Recipt::where('user_id','=',$request->user_id)->where('is_canceled','=',1)->get();
		if($recipts->isNotEmpty()){
			foreach($recipts as $key=>$recipt){
				$recipts[$key]['salon']=$recipt->salon;
				$recipt['salon']['image']=url("uploads/salons/". $recipt['salon']['image']);
				$recipt['salon']['rating']=getSalongRating($recipt['salon']['id']);
				$services=$recipts[$key]['appointment']=$recipt->appointment;
				foreach($services as $key2=>$service){
				   $services[$key2]['service']=getServiceData($service['service_id']);
					
				}
			
			}
			return response()->json(['message' => 'All appointment', 'data'=>$recipts, 'status' => true], 200);

		}else{
		  return response()->json(['message' => 'no appointment found', 'status' => false,], 404);	
		}
	}
	public function complete(Request $request){
		$rules=[
		'user_id'=>'required'
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		$recipts=Recipt::where('user_id','=',$request->user_id)->where('is_completed','=',1)->get();
		if($recipts->isNotEmpty()){
				foreach($recipts as $key=>$recipt){
				$recipts[$key]['salon']=$recipt->salon;  
				$recipt['salon']['rating']=getSalongRating($recipt['salon']['id']);
				$recipt['salon']['image']=url("uploads/salons/". $recipt['salon']['image']);
				$services=$recipts[$key]['appointment']=$recipt->appointment;
				
				foreach($services as $key2=>$service){
				   $services[$key2]['service']=getServiceData($service['service_id']);
					
				}
			}
			return response()->json(['message' => 'All appointment', 'data'=>$recipts, 'status' => true], 200);

		}else{
		  return response()->json(['message' => 'no appointment found', 'status' => false,], 404);	
		}
	}
	public function update(Request $request){
		$rules=[
		'recipt_id'=>'required'
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		$recipt=Recipt::find($request->recipt_id);
		if($recipt){
		DB::beginTransaction();
		$salon=Salon::find($recipt->salon_id);
		$wallet=$salon->wallet;  
		$salon->wallet=$wallet-$recipt->total_price;
		$salon->update();
		$setting=Setting::find(1);
		$amount=$setting->amount;
		$setting->amount=$amount-$recipt->total_price;
		$setting->update();
		$recipt->is_canceled=1;
		$recipt->update();
		DB::commit();
			return response()->json(['message' => 'Appointment canceled successfully', 'status' => true], 200);
		}else{
		return response()->json(['message' => 'no appointment found', 'status' => false,], 404);
		}
	}
	
    public function store(Request $request){
		$rules=[
		'city_name'=>'required',
		'country_name'=>'required',
		'user_id'=>'required',
		'salon_id'=>'required',
		'appointment_date'=>'required', 
		'appointment_time'=>'required',
		'total_price'=>'required',
		'payment_method'=>'required',  
		'services'=>'required',
		'given_at'=>'required',
		'transactionreference'=>'required',
		
		];
	
		$services=json_decode($request->services,TRUE);
	
		
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		DB::beginTransaction();
		$salon=Salon::find($request->salon_id);
		$wallet=$salon->wallet;
		$salon->wallet=$wallet+$request->total_price;
		$salon->update();
		$setting=Setting::find(1);
		
		$amount=$setting->amount;
		$setting->amount=$amount+$request->total_price;
		$setting->update();
		$recipt=new Recipt;
		$recipt->city_name=$request->city_name;
		$recipt->country_name=$request->country_name;
		$recipt->user_id=$request->user_id;
		if($request->has('address')){
		$recipt->address=$request->address;
		}
		$recipt->salon_id=$request->salon_id;
		$recipt->transactionreference=$request->transactionreference;
		$recipt->appointment_date=$request->appointment_date;
		$recipt->appointment_time=$request->appointment_time;
		$recipt->given_at=$request->given_at;
		if($request->has('service_charges')){
		$recipt->service_charges=$request->service_charges;
		}
		$recipt->total_price=$request->total_price;
		$recipt->payment_method=$request->payment_method;
		$recipt->save();
		$recipt_id=$recipt->id; 
		$notification=new Notification;
		$notification->user_id=$request->user_id;
		$title="Appointment Request";
		$salon_name=$salon->salon_name;
		$appointment_date=$request->appointment_date;
		$myDate=date('m/d/Y',strtotime($appointment_date));
		$day= Carbon::createFromFormat('m/d/Y', $myDate)->format('l');
		$message="Thank you, your appointment has been scheduled with $salon_name, on $appointment_date $day.";
		$notification->title=$title;
		$notification->message=$message;
		$notification->save();
		$services=json_decode($request->services,TRUE);
	
		foreach($services as $service){
		$appointment=new Appointment;
		$appointment->recipt_id=$recipt_id;  
		$appointment->service_id=$service['service_id'];
		$appointment->service_name=$service['service_name'];
		$appointment->service_price=$service['price'];
		$appointment->save();
		}
		$user=User::find($request->user_id);
		$player_id=$user->player_id;
		 DB::commit();
		 sendToSpecificNotification($player_id,$message,$title,true);
		return response()->json(['message' => 'Appointment created successfully', 'status' => true], 200);
	}
}
