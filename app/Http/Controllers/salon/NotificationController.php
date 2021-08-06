<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipt;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class NotificationController extends Controller
{
	
	
	
	 public function index()
    {
		$salon_id=Auth::guard('salon')->user()->id;
	    $data['activePage'] = 'notification';
        $data['title'] = __('file.notification');
        $data['notifications']=Notification::where('salon_id','=',$salon_id)->get();		
		  return view('salon.notification.index', $data);
		
	}
	public function add(){
		$salon_id=Auth::guard('salon')->user()->id;
	    $data['activePage'] = 'notification';
        $data['title'] = __('file.notification');
			  return view('salon.notification.add', $data);
	}
	public function resend(Request $request){ 
		$notification=Notification::find($request->notification_id);
		if ($notification) {
	
         $check=sendNotification($notification->image,$notification->message,$notification->title,true);
            $message = array('message' => 'notification send successfully', 'status' => 200);
            echo json_encode(($message));
        } else {
            $message = array('message' => __('file.sorry_try_again'), 'status' => 404);
            echo json_encode(($message));
        }
		
        $request->session()->flash('success', __('file.uploaded'));
      
	}
	public function store(Request $request){
		 $rules = [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
           
        ];
        $validator = Validator::make($request->all(), $rules);
		  if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
		 $image = $request->file('image');
		 $destinationPath = public_path('uploads/notification');
        $filename =  rand(1, 999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
      
		DB::beginTransaction();
		$notification= new Notification;
		$notification->title=$request->title;
		$notification->message=$request->description;
		$notification->salon_id = Auth::guard('salon')->user()->id;
		$notification->image=$filename;
		$notification->save();
        DB::commit(); 
	 	$check=sendNotification($filename,$request->description,$request->title,true);
	
        $request->session()->flash('success', __('file.uploaded'));
        return back();
		 
		
	}
	
	
	
	
	
	
}