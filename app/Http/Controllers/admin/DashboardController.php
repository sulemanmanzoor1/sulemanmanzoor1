<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use App\Models\Recipt;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        # code...
        $data['activePage'] = 'dashboard';
        $data['title'] = __('file.dashboard');
        $data['salons'] = Salon::all();
        $data['services'] = Salon::all();
        $data['setting'] = Setting::where('id', '=', 1)->first();
		  $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
		    $yearly_total_price = [];
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
			  $recipt=Recipt::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('total_price');
			   array_push($yearly_total_price,$recipt);
			   $start = strtotime("+1 month", $start);
			
			
		}
		$data['yearly_total_price']=$yearly_total_price;
		  $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
		    $yearly_order_data = [];
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
			  $recipt=Recipt::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->count();
			   array_push($yearly_order_data,$recipt);
			   $start = strtotime("+1 month", $start);
			
			
		}
		$data['yearly_order_data']=$yearly_order_data;
			$previous_week = strtotime("-1 week +1 day");

$start_week = strtotime("last sunday midnight",$previous_week);
$end_week = strtotime("next saturday",$start_week);
            $weekly_data=[];
		while($start_week <= $end_week){
			$start_wee1k = date("Y-m-d",$start_week);
			$recipt=Recipt::whereDate('created_at', '=' , $start_wee1k)->count();
			$weekly_data[]=$recipt;
			$start_week=strtotime("+1 day", $start_week);
		}
$data['weekly_data']=$weekly_data;
        return view('admin.index', $data);
    }
}
