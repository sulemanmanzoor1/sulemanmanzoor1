@extends('slayouts.app')
@section('content')
<div class="container-fluid pt-5">
    <div class="row">
	
	<div class="col-md-10 offset-md-1">
            <div class="card">
			  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.notification')}}</li>
                    </ol>
                </nav>
                 <div class="card-body">
				 <a href="{{route('add.notification')}}" class="btn btn-warning mb-5" ><i class="material-icons mr-2">add</i>{{__('file.add')}}</a>
                   
                        <div class="card-body">
						<table class="table table-striped border mt-5 pt-5 text-center myTable" id="">
                        <thead>
                            <tr>

                                <th scope="col">{{__('file.image')}}</th>
                                <th scope="col">{{__('file.title')}}</th>
								 <th scope="col">{{__('file.description')}}</th>
								  <th scope="col">{{__('file.action')}}</th>
                                <!-- <th scope="col">{{__('file.action')}}</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                            <tr>

                                <td><img class="rounded" src="{{url('uploads/notification')}}/{{$notification->image}}" style="width: 100px; height:100px" alt=""></td>
                              <td>{{$notification->title}}</td>
							  <td>{{$notification->message}}</td>
                             <td><a href="#" class="sendNotification" data-id="{{$notification->id}}"><i class="material-icons text-warning fa-1x">autorenew</i></a>
                                </td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                          
			    </div>
			</div>
	</div>		
	</div>
</div>
<script>
 $(".sendNotification").on('click',function() {
        let notification_id = $(this).data('id');
      

     console.log(notification_id);
        var data = {
            'notification_id': notification_id,
            
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,  
            url: "{{route('resend.notification')}}",
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
    });


</script>
@endsection