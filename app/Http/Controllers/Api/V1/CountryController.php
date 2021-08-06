<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //

    public function index()
    {
        $countries = Country::where('status', '=', 1)->get();
        if ($countries->isNotEmpty()) {

            foreach ($countries as $country) {
                $country->city;
            }
            return response()->json(['message' => 'All Countries', 'status' => true, 'data' => $countries], 200);
        } else {
            return response()->json(['message' => 'no country found', 'status' => false,], 404);
        }
    }
}
