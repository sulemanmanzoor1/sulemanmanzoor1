@extends('layouts.app')
@section('content')
<div class="container-fluid pt-5 mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header card-header-primary text-center">
                    <h4 class="card-title"><strong>{{__('file.salon_detail')}}</strong></h4>

                </div>
                <div class="row mt-5 mb-5">
                    <div class="col-md-4 ml-5 mr-5">
                        <img class="rounded" src="{{url('uploads/salons')}}/{{$salon->image}}" alt="">
                    </div>
                    <div class="col-md-5 ml-5">
                        <p>{{__('file.first_name')}}: <span class="mr-4"><b>{{$salon->first_name}}</b></span> {{__('file.last_name')}}: <span><b>{{$salon->last_name}}</b></span> </p>
                        <p>{{__('file.salon_name')}}: <span class="mr-4"><b>{{$salon->salon_name}}</b></span> {{__('file.email')}}: <span><b>{{$salon->email}}</b></span> </p>
                        <p>{{__('file.country')}}: <span class="mr-4"><b>{{$salon->country->country_name}}</b></span> {{__('file.city')}}: <span><b>{{$salon->city->city_name}}</b></span> </p>
                        <p>{{__('file.phone')}}: <span class="mr-4"><b>{{$salon->phone}}</b></span> <span><b>@if($salon->status==1)<h3><span class="badge badge-success">Active</span></h3> @else <h3><span class="badge badge-danger">Deactive</span></h3> @endif</b></span> </p>
                    </div>

                </div>
            </div>
        </div>


        @endsection