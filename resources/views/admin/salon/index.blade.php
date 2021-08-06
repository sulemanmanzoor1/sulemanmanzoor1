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
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.salon')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <a href="{{route('add-salon')}}" class="btn btn-warning mb-5"><i class="material-icons mr-2">add</i>{{__('file.add')}}</a>
                    <table class="table table-striped table-border border mt-5 pt-5 table-responsive myTable" >
                        <thead>
                            <tr>
                                <th scope="col">{{__('file.salon_name')}}</th>
                                <th scope="col">{{__('file.owner_name')}}</th>
                                
                                <th scope="col">{{__('file.email')}}</th>
                                <th scope="col">{{__('file.phone')}}</th>
                                <th scope="col">{{__('file.country')}}</th>
                                <th scope="col">{{__('file.city')}}</th>
                                <th scope="col">{{__('file.status')}}</th>
                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salons as $salon)
                            <tr>

                                <td>{{$salon->salon_name}}</td>
                                <td>{{$salon->first_name}} {{$salon->last_name}}</td>
                             
                                <td>{{$salon->email}}</td>
                                <td>{{$salon->phone}}</td>
                                <td>{{$salon->country->country_name}}</td>
                                <td>{{$salon->city->city_name}}</td>
                                <td><label class="switch">
                                        <input data-id='{{$salon->id}}' class="status_checkbox" name="status" type="checkbox" @if($salon->status==1) checked @endif>
                                        <span class="slider round"></span>
                                    </label></td>
                                <td><a href="{{route('edit.salon',$salon)}}"><i class="material-icons text-warning fa-1x">mode_edit</i></a>
                                    <a href="#" data-salon="{{$salon->id}}" class="deleteSalon"><i class="material-icons fa-1x text-danger ml-2">delete</i></a>
                                    <a href="{{route('salon-detail',$salon)}}"><i class="material-icons text-success fa-1x">remove_red_eye</i></a>
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
 $(document).on('click', '.deleteSalon', function(e) {
        let salon_id = $(this).data('salon');
        let data = {
            'salon_id': salon_id
        };
        swal({
                title: "{{__('file.are_you_sure')}}",
                text: "{{__('file.you_want_delete')}} {{__('file.salon')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        dataType: 'JSON',
                        data: data,
                        url: "{{route('salondelete')}}",
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

                }
            });
    })
    $(".status_checkbox").change(function() {
        let salon_id = $(this).data('id');
        let status = 0;

        if (this.checked) {
            status = 1;
        }
        var data = {
            'salon_id': salon_id,
            'status': status
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('salon-status')}}",
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