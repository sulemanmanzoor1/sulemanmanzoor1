@extends('layouts.app');
@section('content')
<style>
@media screen and (max-width:468px) {


            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
            }
			
        

</style>
<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.cities')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <button class="btn btn-warning mb-5" data-toggle="modal" data-target="#exampleModal"><i class="material-icons mr-2">add</i>{{__('file.add')}}</button>
                    <table class="table table-striped table-border border mt-5 pt-5 table-responsive myTable" >
                        <thead>
                            <tr>
                                <th scope="col">{{__('file.city')}}</th>
                                <th scope="col">{{__('file.country')}}</th>
                                <th scope="col">{{__('file.status')}}</th>
                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                            <tr>

                                <td>{{$city->city_name}}</td>
                                <td>{{$city->Country->country_name}}</td>
                                <td><label class="switch">
                                        <input data-id='{{$city->id}}' class="status_checkbox" name="status" type="checkbox" @if($city->status==1) checked @endif>
                                        <span class="slider round"></span>
                                    </label></td>
                                <td><a href="#" class="editCity" data-id="{{$city->id}}" data-city="{{$city->city_name}}" data-country="{{$city->country_id}}"><i class="material-icons text-warning fa-1x">mode_edit</i></a>
                                    <a href="#" data-city="{{$city->id}}" class="deleteCity"><i class="material-icons fa-1x text-danger ml-2">delete</i></a>
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
<!--Add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('file.add_city')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxForm" class="modal-form create" action="{{route('city')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('file.city')}} <span class="text-danger em">*</span></label>
                        <input type="text" name="city" class="form-control" placeholder="{{__('file.enter')}} {{__('file.city')}}">
                        <p id="errcity" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">{{__('file.select')}} {{__('file.country')}}<span class="text-danger em">*</span></label>
                        <select class="form-control" name="country">
                            <option value="">{{__('file.select')}} {{__('file.country')}}</option>
                            @foreach($countries as $county)
                            <option value="{{$county->id}}">{{$county->country_name}}</option>
                            @endforeach
                        </select>
                        <p id="errcountry" class="mb-0 text-danger em"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('file.close')}}</button>
                <button id="submitBtn" type="button" class="btn btn-primary">{{__('file.submit')}}</button>
            </div>
        </div>
    </div>
</div>
<!--------------------End of Add Modal------------------->
<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('file.update')}} {{__('file.city')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxEditForm" class="modal-form create" action="{{route('editcity')}}" method="POST">
                    @csrf
                    <input type="hidden" name="city_id" id="city_id">
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('file.city')}} <span class="text-danger em">*</span></label>
                        <input type="text" id="ecity" name="city" class="form-control" placeholder="{{__('file.enter')}} {{__('file.city')}}">
                        <p id="eerrcity" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">{{__('file.select')}} {{__('file.country')}}<span class="text-danger em">*</span></label>
                        <select class="form-control" id="ecountry" name="country">
                            <option value="">{{__('file.select')}} {{__('file.country')}}</option>
                            @foreach($countries as $county)
                            <option value="{{$county->id}}">{{$county->country_name}}</option>
                            @endforeach
                        </select>
                        <p id="eerrcountry" class="mb-0 text-danger em"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('file.close')}}</button>
                <button id="updateBtn" type="button" class="btn btn-primary">{{__('file.update')}}</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '.deleteCity', function(e) {
        let city_id = $(this).data('city');
        let data = {
            'city_id': city_id
        };
        swal({
                title: "{{__('file.are_you_sure')}}",
                text: "{{__('file.you_want_delete')}} {{__('file.city')}}",
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
                        url: "{{route('citydelete')}}",
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
    $(document).on('click', '.editCity', function() {

        $('#city_id').val($(this).data('id'));
        $('#ecity').val($(this).data('city'));
        $('#ecountry').val($(this).data('country'));
        $('#editModal').modal('show');
    })
    $(".status_checkbox").change(function() {
        let city_id = $(this).data('id');
        let status = 0;

        if (this.checked) {
            status = 1;
        }
        var data = {
            'city_id': city_id,
            'status': status
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('city_status')}}",
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

@if (session()->has('success'))
<script>
    var content = {};

    content.message = "{{session('success')}}";
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
        type: 'success',
        placement: {
            from: 'top',
            align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        delay: 4000,
    });
</script>
@endif


@if (session()->has('warning'))
<script>
    var content = {};

    content.message = "{{session('warning')}}";
    content.title = 'Warning!';
    content.icon = 'fa fa-bell';

    $.notify(content, {
        type: 'warning',
        placement: {
            from: 'top',
            align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        delay: 4000,
    });
</script>
@endif
@endsection