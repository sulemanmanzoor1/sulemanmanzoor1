<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Gallery;
use App\Models\Salon;
use App\Models\Category;
use App\Models\Service;
use App\Models\Rating;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\CreateSalon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgetPassword;
class SalonController extends Controller
{
    //
	
	public function about_us(Request $request){
		$data=Setting::where('id','=',1)->first();
		 return response()->json(['message' => 'All settings', 'status' => true, 'data' => $data], 200);
	}
	public function slider(Request $request){
		$sliders=Slider::where('status','=','1')->get();
		if($sliders->isNotEmpty()){
			foreach($sliders as $slider){
				$slider['image']=$slider->getPhoto();
			}
		 return response()->json(['message' => 'All sliders', 'status' => true, 'data' => $sliders], 200);
		  
		}else{
		 return response()->json(['message' => 'no slider found', 'status' => false,], 404);	
		}
		
	}
	public function searchSalonByName(Request $request){
		$rules=[
		'search'=>'required',
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }else{
			$salons=Salon::query()
		   ->where('salon_name','LIKE', "%{$request->search}%")
		   ->get();
		   if($salons->isNotEmpty()){ 
		   	 foreach ($salons as $key => $salon) {
                $salons[$key]['city'] = $salon->city->city_name;
                $salons[$key]['country'] = $salon->country->country_name;
                $salons[$key]['image'] = $salon->getPhoto();
                $salons[$key]['ratings'] = $salon->avgRating();
            }
		   return response()->json(['message' => 'All salons', 'status' => true, 'data' => $salons], 200);
		   }else{
			 	 return response()->json(['message' => 'no salon found', 'status' => false,], 404);  
		   }
		}
		
	}
	public function getSalonsByCountryCityAndServiceType(Request $request){
		$rules=[
		    'city_id'=>'required',
			'country_id'=>'required',
			'service_type'=>'required',
		];
		$validator=Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		 // $services=Service::join('salons','salons.id','=','services.salon_id')
		// ->where('salons.country_id',$request->country_id)
		// ->where('salons.city_id',$request->city_id)
		 // ->where('salons.give_service',$request->service_type)
		 // ->get(['salons.*','services.*']);
	     if($request->has('startPrice') || $request->has('endPrice')){
			 $min_price=(int)$request->startPrice;
			 $max_price=(int)$request->endPrice;
			 $salons=Salon::join('services', 'salons.id', '=', 'services.salon_id')
	
			->where('salons.country_id','=',$request->country_id)
		  ->where('salons.city_id','=',$request->city_id) 
			->whereBetween('services.service_price',[$min_price,$max_price]) 
		  ->where(function ($query) use ($request) {
         return $query->where('salons.give_service','=',$request->service_type)->orwhere('salons.give_service','=','0');
           })->get(['salons.*', 'services.service_price']);
		   $salons = $salons->unique('id');
$salons = array_slice($salons->values()->all(), 0, 5, true);
			 if($salons){ 
		 foreach ($salons as $key => $salon) {
                $salons[$key]['city'] = $salon->city->city_name;
                $salons[$key]['country'] = $salon->country->country_name;
                $salons[$key]['image'] = $salon->getPhoto();
                $salons[$key]['ratings'] = $salon->avgRating();
            }
			
			return response()->json(['message' => 'All salons', 'status' => true, 'data' => $salons], 200);
		}else{
			 return response()->json(['message' => 'no salon found', 'status' => false,], 404);
		}
		 }else{
		 $salons=Salon::where('country_id','=',$request->country_id)
		  ->where('city_id','=',$request->city_id) 
		 
		  ->where(function ($query) use ($request) {
         return $query->where('give_service','=',$request->service_type)->orwhere('give_service','=','0');
           })->get();
		  if($salons->isNotEmpty()){ 
		 foreach ($salons as $key => $salon) {
                $salons[$key]['city'] = $salon->city->city_name;
                $salons[$key]['country'] = $salon->country->country_name;
                $salons[$key]['image'] = $salon->getPhoto();
                $salons[$key]['ratings'] = $salon->avgRating();
            }
			return response()->json(['message' => 'All salons', 'status' => true, 'data' => $salons], 200);
		}else{
			 return response()->json(['message' => 'no salon found', 'status' => false,], 404);
		} 
		 }
		 //->where(function($query){
		//	 return $query->where('give_service','=',$request->service_type)->orwhere('give_service','=','0');
		// })
		 //->get();
		
		
		
	   	
	}
    public function index()
    {
        $salons = Salon::where('status', '=', 1)->get();
        if ($salons->isNotEmpty()) {
            foreach ($salons as $key => $salon) {
                $salons[$key]['city'] = $salon->city->city_name;
                $salons[$key]['country'] = $salon->country->country_name;
                $salons[$key]['image'] = $salon->getPhoto();
                $salons[$key]['ratings'] = $salon->avgRating();
            }
            return response()->json(['message' => 'All Salons', 'status' => true, 'data' => $salons], 200);
        } else {
            return response()->json(['message' => 'no salon found', 'status' => false,], 404);
        }
    }
	public function salonByGivenService(Request $request){
		$validator = Validator(
            [


                'given_service' => $request->given_service,

            ],
            [
                'given_service' => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        }
		$salons = Salon::where('status', '=', 1)->where('give_service','=',$request->given_service)->get();
        if ($salons->isNotEmpty()) {
            foreach ($salons as $key => $salon) {
                $salons[$key]['city'] = $salon->city->city_name;
                $salons[$key]['country'] = $salon->country->country_name;
                $salons[$key]['image'] = $salon->getPhoto();
                $salons[$key]['ratings'] = $salon->avgRating();
            }
            return response()->json(['message' => 'All Salons', 'status' => true, 'data' => $salons], 200);
        } else {
            return response()->json(['message' => 'no salon found', 'status' => false,], 404);
        }
	}
    public function service(Request $request)
    {

        $validator = Validator(
            [


                'salon_id' => $request->salon_id,

            ],
            [
                'salon_id' => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
            $salon_id = $request->salon_id;
            $services = Service::where('salon_id', '=', $salon_id)->where('status', '=', 1)->where('block', '=', 0)->get();
            if ($services->isNotEmpty()) {
                foreach ($services as $key => $service) {
                    $services[$key]['image'] = $service->getPhoto();
                    $services[$key]['category_name'] = $service->category->category_name;
					$services[$key]['category']['image']=url('uploads/categories/').$services[$key]['category']['image'];
					// $services[$key]['salon']['image']=url('uploads/salons/').$services[$key]['salon']['image'];
					// $services[$key]['salon_name']=$service->salon->salon_name;
                }
                return response()->json(['message' => 'All services', 'status' => true, 'data' => $services], 200);
            } else {
                return response()->json(['message' => 'no service found', 'status' => false,], 404);
            }
        }
    }
	
	public function sendEmail(Request $request){
		$code=rand(1000,9999);
		dd($code);
		$data = array('heading' => 'Forget Password', 'body' => "Your Code is \n\n '$code'", 'base_url' => '{{route("salon")}}', 'button_name' => 'Login');
        $mail = Mail::to($request->email)->send(new ForgetPassword($data));
	
        if (count(Mail::failures()) > 0) {
            $errors = 'Failed to send password reset email, please try again.';
			echo $errors;
        }else{
			echo 'yes';
		}
	}
	public function getSalonByCity(Request $request)
    {
        $validator = Validator(
            [


                'city_id' => $request->city_id,

            ],
            [
                'city_id' => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
            $city = City::find($request->city_id);
			
            if ($city) {
				$city['salon']=$city->salon;
				
			     $city['salon']['image']=url("uploads/salons/". $city['salon']['image']);
                return response()->json(['message' => 'Salons', 'status' => true, 'data' => $city], 200);
            } else {
                return response()->json(['message' => 'no salon found in this city', 'status' => false,], 404);
            }
        }
    }
    public function gallery(Request $request)
    {

        $validator = Validator(
            [


                'salon_id' => $request->salon_id,

            ],
            [
                'salon_id' => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
            $salon_id = $request->salon_id;
            $galleries = Gallery::where('salon_id', '=', $salon_id)->where('status', '=', 1)->get();
            if ($galleries->isNotEmpty()) {
                foreach ($galleries as $key => $gallery) {
                    $galleries[$key]['image'] = $gallery->getPhoto();
                    // $galleries[$key]['category_name'] = $service->category->category_name;
                }
                return response()->json(['message' => 'Salon galleries', 'status' => true, 'data' => $galleries], 200);
            } else {
                return response()->json(['message' => 'no gallery found', 'status' => false,], 404);
            }
        }
    }
	
    public function getCouponBySalon(Request $request)
    {
        $validator = Validator(
            [


                'salon_id' => $request->salon_id,

            ],
            [
                'salon_id' => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
            $coupons = Coupon::where('salon_id', '=', $request->salon_id)->where('status', '=', 1)->get();
            if ($coupons->isNotEmpty()) {
                return response()->json(['message' => 'All coupons', 'status' => true, 'data' => $coupons], 200);
            } else {
                return response()->json(['message' => 'no coupon found', 'status' => false,], 404);
            }
        }
    }
    public function getServiceByCategory(Request $request)
    {
        $validator = Validator(
            [


                'category_id' => $request->category_id,
				   'country_id' => $request->country_id,
                   'city_id' => $request->city_id,
            ],
            [
                'category_id' => 'required',
				 'country_id' => 'required',
				  'city_id' => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'status' => false, 'Error' => $validator->errors(),], 400);
        } else {
			
            // $services = Service::where('category_id', '=', $request->category_id)->where('status', '=', 1)->where('block', '=', 0)->get();
			 // $users = User::join('posts', 'users.id', '=', 'posts.user_id')
               // ->get(['users.*', 'posts.descrption']);
			   $services=Service::join('salons','salons.id','=','services.salon_id')
			  ->where('services.category_id',$request->category_id)
			    ->where('services.status','1')
				->where('services.block','0')
			  ->where('salons.city_id',$request->city_id)
			   ->where('salons.status','1')
			   ->where('salons.country_id',$request->country_id)
			   ->get(['services.*']);
			   
            if ($services->isNotEmpty()) {
                foreach ($services as $key => $service) {
                    $services[$key]['image'] = $service->getPhoto();
                    $services[$key]['category_name'] = $service->category->category_name;
                    $services[$key]['salon'] = $service->salon;
					$services[$key]['salon']['image']=$service->salon->getPhoto();
                   $services[$key]['salon']['ratings'] =getSalongRating($services[$key]['salon']['id']);
				   $services[$key]['salon']['country'] =getSalonCountry($services[$key]['salon']['id']);
				      $services[$key]['salon']['city'] =getSalonCity($services[$key]['salon']['id']);
					$services[$key]['category']['image']=url('uploads/categories/').$services[$key]['category']['image'];
					
					 
                }
                
                return response()->json(['message' => 'All services', 'status' => true, 'data' => $services], 200);
            } else {
                return response()->json(['message' => 'no service found', 'status' => false,], 404);
            }
        }
    }
}
