<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipt;
use App\Models\Salon;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Artisan;
class AppointmentController extends Controller
{
    //
    public function index()
    {

        # code...
		 $salon_id = Auth::guard('salon')->user()->id;
        $data['activePage'] = 'appointment';
        $data['title'] = __('file.appointment');
		$data['upcomings']=Recipt::where('salon_id','=',$salon_id)->where('is_completed','=',0)->where('is_canceled','=',0)->where('is_approved','=',0)->get();
		$data['confrims']=Recipt::where('salon_id','=',$salon_id)->where('is_completed','=',0)->where('is_canceled','=',0)->where('is_approved','=',1)->get();
		$data['completes']=Recipt::where('salon_id','=',$salon_id)->where('is_completed','=',1)->get();
		$data['canceles']=Recipt::where('salon_id','=',$salon_id)->where('is_canceled','=',1)->get();
	
        return view('salon.appointment.index', $data);
    }
	
	public function view($id,Request $request){
		$data['activePage'] = 'appointment';
        $data['title'] = __('file.appointment');
		$data['appointment']=Recipt::where('id','=',$id)->first();
		return view('salon.appointment.detail', $data);
	}
	public function confirm(Request $request){
		$recipt = Recipt::find($request->recipt_id);
        if ($recipt){
            $recipt->is_approved =1;
            $recipt->update();
		$salon=Salon::find($recipt->salon_id);
		$notification=new Notification;
		$notification->user_id=$recipt->user_id;
		$title="Appointment Confirmed";
		$salon_name=$salon->salon_name;
		$appointment_date=$recipt->appointment_date;
		$myDate=date('m/d/Y',strtotime($appointment_date));
		$day= Carbon::createFromFormat('m/d/Y', $myDate)->format('l');
		$message="Thank you, your appointment has been confirmed with $salon_name, on $appointment_date $day.";
		$notification->title=$title;
		$notification->message=$message;
		$notification->save();
		$user=User::find($recipt->user_id);
		$player_id=$user->player_id;
		
		 sendToSpecificNotification($player_id,$message,$title,true);
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
	}
	public function complete(Request $request){
		$recipt=Recipt::find($request->recipt_id);
        if ($recipt){
            $recipt->is_completed =1;
            $recipt->update();
			
		$salon=Salon::find($recipt->salon_id);
		$notification=new Notification;
		$notification->user_id=$recipt->user_id;
		$title="Appointment Completed";
		$salon_name=$salon->salon_name;
		$appointment_date=$recipt->appointment_date;
		$myDate=date('m/d/Y',strtotime($appointment_date));
		$day= Carbon::createFromFormat('m/d/Y', $myDate)->format('l');
		$message="Thank you, your appointment has been completed with $salon_name, on $appointment_date $day.";  
		$notification->title=$title;
		$notification->message=$message;
		$notification->save();
		$user=User::find($recipt->user_id);
		$player_id=$user->player_id;
		
		 sendToSpecificNotification($player_id,$message,$title,true);
            $message = array('message' =>  __('file.status_updated_sucessfully'), 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
	}
}
