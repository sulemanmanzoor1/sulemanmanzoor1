@extends('layouts.app')
@section('content')
<style>
    @media screen and (max-width:1024px) {


            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
            }
			
        }
	</style>
	
<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.users')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <table class="table table-striped mt-5 pt-5 table-responsive myTable" >
                        <thead>
                            <tr>
							    <th scope="col">{{__('file.image')}}</th> 
                                
                                <th scope="col">{{__('file.name')}}</th>
                                <th scope="col">{{__('file.email')}}</th>
                                <th scope="col">{{__('file.phone')}}</th>
                                <th scope="col">{{__('file.country')}}</th>
                                <th scope="col">{{__('file.city')}}</th>
								<th scope="col">{{__('file.gender')}}</th>
								
                                <th scope="col">{{__('file.age')}}</th>
                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><img class="rounded" src="{{url('uploads/users')}}/{{$user->image}} " style="width:80px;height:80px;" alt=""></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>

                                <td>{{$user->country->country_name}}</td>
								 <td>{{$user->city->city_name}}</td>
                                <td>{{$user->gender}}</td>
                                <td>{{getAgeYear($user->birth_date)}} Year</td>
                              

                                <td>
                                   
                                   
                                    <a href="#"><i data-id="{{$user->id}}" data-block="1" class="material-icons text-info fa-1x deleteuser">lock_open</i></a>

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
<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('file.view_service')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <img src="" class="service-image rounded">
                            <h3 class="text-center"> <span class="badge badge-info eservicename"></span></h3>
                            <h3 class="text-center"> <span class="badge badge-success ecategoryname"></span></h3>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<script>

    $('.viewService').on('click', function() {
        $('.service-image').attr('src', '{{url("uploads/services")}}/' + $(this).data('image'));
        $('.eservicename').text($(this).data('service'));
        $('.ecategoryname').text($(this).data('category'));
    })
    $(".deleteuser").click(function(e) {
        console.log('ddddd');
        e.preventDefault();

        let user_id = $(this).data('id');
     
        var data = {
            'user_id': user_id,
         
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('user.delete')}}",
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
                    window.location.reload();
                }
            }
        });
    });
</script>
@endsection