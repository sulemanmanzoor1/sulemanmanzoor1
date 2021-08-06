@extends('layouts.app')
@section('content')

<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.service')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <table class="table table-striped table-responsive border mt-5 pt-5 myTable" >
                        <thead>
                            <tr>
                                <th scope="col">{{__('file.image')}}</th>
                                <th scope="col">{{__('file.service_name')}}</th>
                                <th scope="col">{{__('file.category')}}</th>
                                <th scope="col">{{__('file.service_price')}}</th>
                                <th scope="col">{{__('file.service_time')}}</th>
                                <th scope="col">{{__('file.discount')}}</th>

                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td><img class="rounded" src="{{url('uploads/services')}}/{{$service->image}} " style="width:80px;height:80px;" alt=""></td>
                                <td>{{$service->service_name}}</td>
                                <td>{{$service->category->category_name}}</td>
                                <td>{{$service->service_price}}</td>

                                <td>{{$service->service_time}}</td>
                                @if($service->is_discount==1)
                                <td>{{$service->discount}}%</td>
                                @else
                                <td class="text-danger"><span class="badge badge-danger">no discount</span></td>
                                @endif

                                <td>
                                    <a href="#" data-image="{{$service->image}}" data-service="{{$service->service_name}}" data-category="{{$service->category->category_name}}" class="viewService" data-toggle="modal" data-target="#exampleModal"><i class="material-icons text-success">remove_red_eye</i></a>
                                    @if($service->block==1)
                                    <a href="#"><i data-id="{{$service->id}}" data-block="0" class="material-icons text-danger fa-1x blockService">lock</i></a>
                                    @else
                                    <a href="#"><i data-id="{{$service->id}}" data-block="1" class="material-icons text-info fa-1x blockService">lock_open</i></a>

                                    @endif
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
    $(".blockService").click(function(e) {
        console.log('ddddd');
        e.preventDefault();

        let service_id = $(this).data('id');
        let block = $(this).data('block');


        var data = {
            'service_id': service_id,
            'block': block
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('service.block')}}",
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