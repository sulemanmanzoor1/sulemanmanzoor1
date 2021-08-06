<?php

use App\Models\Service;
use App\Models\Recipt;
use App\Models\Salon;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
require_once('./app/Libraries/twilio/sdk/src/Twilio/autoload.php');
// dd(require_once app_path('Libraries/twilio/sdk/src/Twilio/autoload.php'));
use Twilio\Rest\Client;
if (!function_exists('getSalonServices')) {
    function getSalonServices()
    {
        $salon_id = Auth::guard('salon')->user()->id;
        $services = Service::where('salon_id', '=', $salon_id)->get();
        return $services->count();
    }
}
  if (!function_exists('getMontlyOrder')) {
    function getMontlyOrder()
    {
		

    }
}
  
  if(!function_exists('sendToSpecificNotification')){
	function sendToSpecificNotification($player_id, $message,$title, $method)
    {
	 
		 $destinationpath=url('logo/logo.jpeg');
		 
		 $url = "https://onesignal.com/api/v1/notifications";  
         $access_token = 'Basic NzVhODM3ZWUtZjg0Zi00ZTk1LTkyMWMtYzIwZTg1YTE1Yjcz';
               $fields = '{
                    "app_id":"c92c4082-28fe-4dcf-914a-cfe5a36a49a7",
                    "contents":{"en":"'.$message.'"},
					"headings":{"en":"'.$title.'"},
					"large_icon":"'.$destinationpath.'",
                    "include_player_ids":["'.$player_id.'"]
                }';
				
		$url = "https://onesignal.com/api/v1/notifications"; 
		$access_token = 'Basic Yjg2NjFhZjgtM2JjZi00NGMzLWIyODMtYzgyYTFlNGNjODRi';
		$header = array('Content-Type: application/json', 'Authorization:'.$access_token);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $data = curl_exec($curl);
		
        if ($data === false)
        {
          
        }
        curl_close($curl);
        return $data;

		
		
		
	}
	
  }
    
if(!function_exists('sendNotification')){
	function sendNotification($image, $message,$title, $method)
    {
		
		 $filename = $image; 
		 $destinationpath=url('logo/logo.jpeg');
		
		 $destinationnotification=url('uploads/notification/'.$filename);
		 $url = "https://onesignal.com/api/v1/notifications";  
         $access_token = 'Basic NzVhODM3ZWUtZjg0Zi00ZTk1LTkyMWMtYzIwZTg1YTE1Yjcz';
               $fields = '{
                    "app_id":"c92c4082-28fe-4dcf-914a-cfe5a36a49a7",
                    "contents":{"en":"'.$message.'"},
					"headings":{"en":"'.$title.'"},
					"large_icon":"'.$destinationpath.'",
					"big_picture":"'.$destinationnotification.'",
                    "included_segments":["All"]
                }';
				
		$url = "https://onesignal.com/api/v1/notifications"; 
		$access_token = 'Basic Yjg2NjFhZjgtM2JjZi00NGMzLWIyODMtYzgyYTFlNGNjODRi';
		$header = array('Content-Type: application/json', 'Authorization:'.$access_token);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $data = curl_exec($curl);
        if ($data === false)
        {
          
        }
        curl_close($curl);
        return $data;

    }
}
if(!function_exists('sendMessage')){
	
	 function sendMessage($message, $recipients)
{
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($recipients, 
            ['from' => $twilio_number, 'body' => $message] );
			return true;
}
}
if(!function_exists('getServiceData')){
	
	    function getServiceData($service_id)
		{
			$service=Service::where('id','=',$service_id)->first();
           
			$service['image']=$service->getPhoto();
			return $service;
		}
}
if(!function_exists('getSalongRating')){
	
	function getSalongRating($id){
		$salon=Salon::where('id','=',$id)->first();
		return $salon->avgRating();
		
	}
}
if(!function_exists('getSalonCountry')){
	
	function getSalonCountry($id){
		$salon=Salon::where('id','=',$id)->first();
		return $salon->country;
		
	}
}
if(!function_exists('getSalonCity')){
	
	function getSalonCity($id){
		$salon=Salon::where('id','=',$id)->first();
		return $salon->city;
		
	}
}
if(!function_exists('getAgeYear')){
	
	function getAgeYear($dateOfBirth){
		return Carbon::parse($dateOfBirth)->age;
	}
}
	

