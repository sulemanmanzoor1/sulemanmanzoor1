@extends('slayouts.app')
@section('content')
<style>
/***
Bootstrap4 Card with Tabs by @mdeuerlein
***/

body {
    background-color: #f7f8f9;
}

.card {
    background-color: #ffffff;
    border: 1px solid rgba(0, 34, 51, 0.1);
    box-shadow: 2px 4px 10px 0 rgba(0, 34, 51, 0.05), 2px 4px 10px 0 rgba(0, 34, 51, 0.05);
    border-radius: 0.15rem;
}

/* Tabs Card */

.tab-card {
  border:1px solid #eee;
}

.tab-card-header {
  background:gainsbro;
}
/* Default mode */
.tab-card-header > .nav-tabs {
  border: none;
  margin: 0px;
}
.tab-card-header > .nav-tabs > li {
  margin-right: 2px;
}
.tab-card-header > .nav-tabs > li > a {
  border: 0;
  border-bottom:2px solid transparent;
  margin-right: 0;
  color: #737373;
  padding: 2px 15px;
}

.tab-card-header > .nav-tabs > li > a.show {
    border-bottom:2px solid #007bff;
    color: #007bff;
}
.tab-card-header > .nav-tabs > li > a:hover {
    color: #007bff;
}

.tab-card-header > .tab-content {
  padding-bottom: 0;
}
.card .card-header {
    border-bottom: none;
   
    background: rgb(156 39 176);
}
.nav-tabs .nav-item .nav-link.active {
    background-color: rgb(255 152 0);
    transition: 0.3s background-color 0.2s;
}
</style>

<!------ Include the above in your HEAD tag ---------->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card mt-3 tab-card">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">{{__('file.upcoming_appointment')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">{{__('file.confrim_appointment')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">{{__('file.completed_appointment')}}</a>
            </li>
			 <li class="nav-item">
                <a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false">{{__('file.cancel_appointment')}}</a>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
            <h5 class="card-title mb-5">{{__('file.upcoming_appointment')}}</h5>
             <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-border table-responsive mt-5 pt-5 myTable text-center" >
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('file.user_name')}}</th>
                                        <th scope="col">{{__('file.user_phone')}}</th>
                                        <th scope="col">{{__('file.user_image')}}</th>
                                        <th scope="col">{{__('file.user_gender')}}</th>
                                        <th scope="col">{{__('file.appointment_date')}}</th>
                                        <th scope="col">{{__('file.appointment_time')}}</th>
                                        <th scope="col">{{__('file.payment_method')}}</th>
										 <th scope="col">{{__('file.total_price')}}</th>
                                        <th scope="col">{{__('file.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomings as $key=>$upcoming)
									<tr>
									
									<td>{{$upcoming->user->name}}</td>
										<td>{{$upcoming->user->phone}}</td>
											<td><img class="rounded" style="width:100px;height:100px;" src="{{url('uploads/users/'.$upcoming->user->image)}}"></td>
												<td>{{$upcoming->user->gender}}</td>
													<td>{{$upcoming->appointment_date}}</td>
													<td>{{$upcoming->appointment_time}}</td>
													<td>{{$upcoming->payment_method}}</td>
													<td>{{$upcoming->total_price}}</td>
													<td><a href="{{route('view.appointment',$upcoming->id)}}"><i class="fa fa-eye fa-2x"></i></a>
															<a class="approvedStatus" data-id="{{$upcoming->id}}" data-toggle="tooltip" data-placement="top" title="Approved Status" href=""><i class="fa fa-exchange fa-2x text-success"></i></a>
													</td>
									</tr>
									@endforeach()
                                </tbody>

                            </table>
                          
                        </div>
                    </div> 
                      
          </div>
          <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
            <h5 class="card-title mb-5">{{__('file.confrim_appointment')}}</h5>
           <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-border table-responsive mt-5 pt-5 myTable" >
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('file.user_name')}}</th>
                                        <th scope="col">{{__('file.user_phone')}}</th>
                                        <th scope="col">{{__('file.user_image')}}</th>
                                        <th scope="col">{{__('file.user_gender')}}</th>
                                        <th scope="col">{{__('file.appointment_date')}}</th>
                                        <th scope="col">{{__('file.appointment_time')}}</th>
                                        <th scope="col">{{__('file.payment_method')}}</th>
										 <th scope="col">{{__('file.total_price')}}</th>
                                        <th scope="col">{{__('file.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($confrims as $key=>$confrim)
									<tr>
									
									<td>{{$confrim->user->name}}</td>
										<td>{{$confrim->user->phone}}</td>
											<td><img class="rounded" style="width:100px;height:100px;" src="{{url('uploads/users/'.$confrim->user->image)}}"></td>
												<td>{{$confrim->user->gender}}</td>
													<td>{{$confrim->appointment_date}}</td>
													<td>{{$confrim->appointment_time}}</td>
													<td>{{$confrim->payment_method}}</td>
													<td>{{$confrim->total_price}}</td>
												<td><a href="{{route('view.appointment',$confrim->id)}}"><i class="fa fa-eye fa-2x"></i></a><a data-id="{{$confrim->id}}" class="completeAppointment" href="#"><i class="fa fa-check-circle text-success fa-2x"></i></a></td>
									</tr>
									@endforeach()
                                </tbody>

                            </table>
                          
                        </div>
                    </div>            
          </div>
          <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
            <h5 class="card-title mb-5">{{__('file.completed_appointment')}}</h5>
             <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-border table-responsive mt-5 pt-5 myTable" >
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('file.user_name')}}</th>
                                        <th scope="col">{{__('file.user_phone')}}</th>
                                        <th scope="col">{{__('file.user_image')}}</th>
                                        <th scope="col">{{__('file.user_gender')}}</th>
                                        <th scope="col">{{__('file.appointment_date')}}</th>
                                        <th scope="col">{{__('file.appointment_time')}}</th>
                                        <th scope="col">{{__('file.payment_method')}}</th>
										 <th scope="col">{{__('file.total_price')}}</th>
                                        <th scope="col">{{__('file.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completes as $key=>$complete)
									<tr>
									
									<td>{{$complete->user->name}}</td>
										<td>{{$complete->user->phone}}</td>
											<td><img class="rounded" style="width:100px;height:100px;" src="{{url('uploads/users/'.$complete->user->image)}}"></td>
												<td>{{$complete->user->gender}}</td>
													<td>{{$complete->appointment_date}}</td>
													<td>{{$complete->appointment_time}}</td>
													<td>{{$complete->payment_method}}</td>
													<td>{{$complete->total_price}}</td>
												<td><a href="{{route('view.appointment',$complete->id)}}"><i class="fa fa-eye fa-2x"></i></a></td>
									</tr>
									@endforeach()
                                </tbody>

                            </table>
                          
                        </div>
                    </div>          
          </div>
		   <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
            <h5 class="card-title mb-5">{{__('file.cancel_appointment')}}</h5>
                <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-border table-responsive mt-5 pt-5 myTable" >
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('file.user_name')}}</th>
                                        <th scope="col">{{__('file.user_phone')}}</th>
                                        <th scope="col">{{__('file.user_image')}}</th>
                                        <th scope="col">{{__('file.user_gender')}}</th>
                                        <th scope="col">{{__('file.appointment_date')}}</th>
                                        <th scope="col">{{__('file.appointment_time')}}</th>
                                        <th scope="col">{{__('file.payment_method')}}</th>
										 <th scope="col">{{__('file.total_price')}}</th>
                                        <th scope="col">{{__('file.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
								
                                    @foreach($canceles as $key=>$cancele)
									<tr>
									
									<td>{{$cancele->user->name}}</td>
										<td>{{$cancele->user->phone}}</td>
											<td><img class="rounded" style="width:100px;height:100px;" src="{{url('uploads/users/'.$cancele->user->image)}}"></td>
												<td>{{$cancele->user->gender}}</td>
													<td>{{$cancele->appointment_date}}</td>
													<td>{{$cancele->appointment_time}}</td>
													<td>{{$cancele->payment_method}}</td>
													<td>{{$cancele->total_price}}</td>
													<td><a href="{{route('view.appointment',$cancele->id)}}"><i class="fa fa-eye fa-2x"></i></a>
											
													</td>
									</tr>
									@endforeach()
                                </tbody>

                            </table>
                          
                        </div>
                    </div>       
          </div>

        </div>
      </div>
    </div>
  </div>
</div>







<script>
$('.completeAppointment').on('click',function(e){
	e.preventDefault();
	swal({
  title: "Are you sure?",
  text: "you want to complete this service!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
     let recipt_id = $(this).data('id');
        var data = {
            'recipt_id': recipt_id,
        }; 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('appointment.complete')}}",
            success: function(res) {
                if (res.status == 200) {

                    var content = {};
                    content.message = res.message;
                    content.title = 'Success';
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'success',
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1031,
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                }
            }
        });
  } 
});
});
$('.approvedStatus').on('click',function(e){
	e.preventDefault();
	swal({
  title: "Are you sure?",
  text: "you want to confrim this services!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
     let recipt_id = $(this).data('id');
        var data = {
            'recipt_id': recipt_id,
        }; 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('appointment.confrim')}}",
            success: function(res) {
                if (res.status == 200) {

                    var content = {};
                    content.message = res.message;
                    content.title = 'Success';
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'success',
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1031,
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                }
            }
        });
  } 
});
});

</script>



@endsection