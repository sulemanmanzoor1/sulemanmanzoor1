@extends('slayouts.app')
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
                    <a href="{{route('add.service')}}" class="btn btn-warning mb-5"><i class="material-icons mr-2">add</i>{{__('file.add')}}</a>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-border table-responsive mt-5 pt-5 text-center myTable" id="">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('file.image')}}</th>
                                        <th scope="col">{{__('file.service_name')}}</th>
                                        <th scope="col">{{__('file.category')}}</th>
                                        <th scope="col">{{__('file.service_price')}}</th>
                                        <th scope="col">{{__('file.service_time')}}</th>
                                        <th scope="col">{{__('file.discount')}}</th>
                                        <th scope="col">{{__('file.status')}}</th>
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
                                        <td><label class="switch">
                                                <input data-id='{{$service->id}}' class="status_checkbox" name="status" type="checkbox" @if($service->status==1) checked @endif>
                                                <span class="slider round"></span>
                                            </label></td>
                                        <td>
                                            <a href="#" data-image="{{$service->image}}" data-service="{{$service->service_name}}" data-category="{{$service->category->category_name}}" class="viewService" data-toggle="modal" data-target="#exampleModal"><i class="material-icons text-success">remove_red_eye</i></a>
                                            @if($service->block==0)
                                            <a href="{{route('edit.service',$service)}}"><i class="material-icons text-warning fa-1x">mode_edit</i></a>
                                            <form class="deleteform d-inline-block" action="{{route('service.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{$service->id}}">

                                                <button type="submit" class="btn btn-danger rounded deletebtn">Delete</i></a>
                                                </button>
                                            </form>
                                            @else
                                            <span class="badge badge-danger p-2" data-toggle="tooltip" data-placement="top" title="Admin block your service">{{__('file.block')}}</span>
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
    $(".status_checkbox").change(function() {
        let service_id = $(this).data('id');
        let status = 0;

        if (this.checked) {
            status = 1;
        }
        var data = {
            'service_id': service_id,
            'status': status
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('service.status')}}",
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