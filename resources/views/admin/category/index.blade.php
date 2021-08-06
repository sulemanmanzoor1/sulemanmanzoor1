@extends('layouts.app')
@section('content')

<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.category')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <a href="{{route('add-category')}}" class="btn btn-warning mb-5"><i class="material-icons mr-2">add</i>{{__('file.add')}}</a>
                    <table class="table table-striped border table-responsive mt-5 pt-5 myTable" >
                        <thead>
                            <tr>
                                <th scope="col">{{__('file.category_name')}}</th>
                                <th scope="col">{{__('file.image')}}</th>
                                <th scope="col">{{__('file.status')}}</th>
                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>

                                <td>{{$category->category_name}}</td>
                                <td><img class="rounded" src="{{url('uploads/categories')}}/{{$category->image}}" style="width: 90px; height:90px;" alt=""></td>
                                <td><label class="switch">
                                        <input data-id='{{$category->id}}' class="status_checkbox" name="status" type="checkbox" @if($category->status==1) checked @endif>
                                        <span class="slider round"></span>
                                    </label></td>
                                <td><a href="#"><i class="material-icons text-warning fa-1x">mode_edit</i></a>
                                    <form class="deleteform d-inline-block" action="{{route('category.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{$category->id}}">

                                        <button type="submit" class="btn btn-danger deletebtn">Delete</i></a>
                                        </button>
                                    </form>
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
                <h5 class="modal-title" id="exampleModalLabel">{{__('file.add_category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form create" action="{{route('category')}}" method="POST">
                    @csrf
                    <div class="row">
                        <label class="col-sm-4 col-form-label">{{__('file.category_name')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" id="input-name" type="text" placeholder="{{ __('file.category') }}" value="{{ old('category') }}" required="true" aria-required="true" />
                                <span id="errcategory" class="error text-danger" for="input-name"></span>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label">{{__('file.image')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="profile-img">
                                <label class="custom-file-label" for="validatedCustomFile">{{__('file.choose_file')}}</label>

                            </div>
                            <img id="profile-img-tag" src="" style="display: none;">
                        </div>
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
        let category_id = $(this).data('id');
        let status = 0;

        if (this.checked) {
            status = 1;
        }
        var data = {
            'category_id': category_id,
            'status': status
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('category-status')}}",
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