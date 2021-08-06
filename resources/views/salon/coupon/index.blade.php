@extends('slayouts.app')
@section('content')

<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.coupon')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <a href="{{route('add.coupon')}}" class="btn btn-warning mb-5"><i class="material-icons mr-2">add</i>{{__('file.add')}}</a>
                    <table class="table table-striped cell-border table-responsive mt-5 pt-5 text-center myTable" id="">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('file.code')}}</th>
                                <th scope="col">{{__('file.description')}}</th>
                                <th scope="col">{{__('file.discount')}}</th>
                                <th scope="col">{{__('file.start_date')}}</th>
                                <th scope="col">{{__('file.end_date')}}</th>
                                <th scope="col">{{__('file.status')}}</th>
                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $key=>$coupon)
                            <tr>
                                @php $key++ @endphp
                                <td>{{$key}}</td>
                                <td>{{$coupon->code}}</td>
                                <td>{{$coupon->description}}</td>
                                @if($coupon->type=='p')
                                <td>{{$coupon->discount}}%</td>
                                @else
                                <td>{{$coupon->discount}}$</td>
                                @endif

                                <td>{{$coupon->start_date}}</td>
                                <td>{{$coupon->end_date}}</td>
                                <td><label class="switch">
                                        <input data-id='{{$coupon->id}}' class="status_checkbox" name="status" type="checkbox" @if($coupon->status==1) checked @endif>
                                        <span class="slider round"></span>
                                    </label></td>

                                <td>
                                    <a href="{{route('edit-coupon',$coupon)}}"><i class="material-icons text-warning fa-1x">mode_edit</i></a>

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
    })
    $(".status_checkbox").change(function() {
        let coupon_id = $(this).data('id');
        let status = 0;

        if (this.checked) {
            status = 1;
        }
        var data = {
            'coupon_id': coupon_id,
            'status': status
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('coupon.status')}}",
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