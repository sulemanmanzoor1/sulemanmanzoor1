<?php

namespace App\Http\Controllers\salon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use App\Models\Service;
use App\Models\Recipt;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    //
    public function index()
    {

        # code...
        $data['activePage'] = 'dashboard';
        $data['title'] = __('file.dashboard');
		    $salon_id = Auth::guard('salon')->user()->id;
         $data['services'] = Service::where('salon_id', '=', $salon_id)->get();
		 $data['unapprovedorder']=Recipt::where('salon_id','=',$salon_id)->where('is_approved','=','0')->where('is_completed','=',0)->get();
		 $data['approvedorder']=Recipt::where('salon_id','=',$salon_id)->where('is_approved','=','1')->where('is_completed','=',0)->get(); 
		  $data['completedorder']=Recipt::where('salon_id','=',$salon_id)->where('is_approved','=','1')->where('is_completed','=',1)->get();
		   $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
		    $yearly_order_data = [];
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
			  $recipt=Recipt::whereDate('created_at', '>=' , $start_date)->where('salon_id', $salon_id)->whereDate('created_at', '<=' , $end_date)->count();
			   array_push($yearly_order_data,$recipt);
			   $start = strtotime("+1 month", $start);
			
			
		}
		   	$previous_week = strtotime("-1 week +1 day");

$start_week = strtotime("last sunday midnight",$previous_week);
$end_week = strtotime("next saturday",$start_week);
            $weekly_data=[];
		while($start_week <= $end_week){
			$start_wee1k = date("Y-m-d",$start_week);
			$recipt=Recipt::whereDate('created_at', '=' , $start_wee1k)->where('salon_id', $salon_id)->count();
			$weekly_data[]=$recipt;
			$start_week=strtotime("+1 day", $start_week);
		}
$data['weekly_data']=$weekly_data;
		$data['yearly_order_data']=$yearly_order_data;
		
        return view('salon.index', $data);
    }
	
	public function clear_cache(){
		Artisan::call('cache:clear');
      Artisan::call('config:clear');
      Artisan::call('route:clear');
      Artisan::call('view:clear');
	  
	  dd('clear');
	}
}
