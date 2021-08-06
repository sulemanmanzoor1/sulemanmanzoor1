@extends('slayouts.app')
@section('content')
<div class="container pt-5">
<div class="row">
<div class="col-md-12">
 <div class="card">
 <div class="col-md-5 offset-md-4 pt-5">
 @if($appointment->is_canceled==1)
 <h3> <span class="badge badge-primary">Canceled</span></h3>
@elseif($appointment->is_completed==1)
 <h3> <span class="badge badge-primary">Completed</span></h3>	
@else
	 <h3 class="ml-5"> <span class="badge badge-primary ml-5">Upcoming</span></h3>
@endif



<img class="rounded-circle justify-content-center d-flex ml-4" style="width:250px;height:250px;" src="{{url('uploads/users/'.$appointment->user->image)}}">
<h1 ></h1>
<h3> <span class="badge badge-primary">{{$appointment->user->name}}</span>  <span class="badge badge-success">{{$appointment->user->phone}}</span></h3>
<h3> <span class="badge badge-danger">{{$appointment->appointment_date}}</span>  <span class="badge badge-warning ml-4">{{date('h:i A',strtotime($appointment->appointment_time))}}</span></h3>
 
</div>
</div>
</div>

</div>

<div class="row">
@foreach($appointment->appointment as $key=>$app)
<div class="col-md-6">
<div class="card">
<div class="row">
<div class="col-md-4">

				
				@php
				
				$service=getServiceData($app['service_id']);
				
				@endphp
				  <img class="rounded m-4" style="width:100px;height:100px;" src="{{$service->image}}">
			

</div>
<div class="col-md-8">
<h3>Service Name <span class="badge badge-danger"> {{$service->service_name}}</span> </h3>
<h3>Price <span class="badge badge-warning ml-4">{{$service->service_price}}</span></h3>	
<h3>Minutes<span class="badge badge-success">{{$service->service_time}}</span> </h3>
</div>
</div>
</div>
</div>

@endforeach
</div>

</div>


@endsection