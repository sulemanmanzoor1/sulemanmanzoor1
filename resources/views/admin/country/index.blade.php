@extends('layouts.app')
@section('content')

<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.countries')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <button class="btn btn-warning mb-5" data-toggle="modal" data-target="#exampleModal"><i class="material-icons mr-2">add</i>{{__('file.add')}}</button>
                    <table class="table table-striped border mt-5 pt-5 myTable" >
                        <thead>
                            <tr>

                                <th scope="col">{{__('file.country')}}</th>
                                <th scope="col">{{__('file.status')}}</th>
                                <th scope="col">{{__('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($countries as $country)
                            <tr>

                                <td>{{$country->country_name}}</td>
                                <td><label class="switch">
                                        <input data-id='{{$country->id}}' class="status_checkbox" name="status" type="checkbox" @if($country->status==1) checked @endif>
                                        <span class="slider round"></span>
                                    </label></td>
                                <td><a href="#" class="editCountry" data-id="{{$country->id}}" data-country="{{$country->country_name}}"><i class="material-icons text-warning fa-1x">mode_edit</i></a>
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
                <h5 class="modal-title" id="exampleModalLabel">{{__('file.add_country')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxForm" class="modal-form create" action="{{route('country')}}" method="POST">
                    @csrf
                    <div class="row"> <label class="col-sm-2 col-form-label">{{__('file.country')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" id="input-name" type="text" placeholder="{{ __('file.country') }}" value="{{ old('country') }}" required="true" aria-required="true" />

                                <span id="errcountry" class="error text-danger" for="input-name"></span>

                            </div>
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
<!--Edit Modal -->
<div class="modal fade" id="editCountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('file.update')}} {{__('file.country')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxEditForm" class="modal-form create" action="{{route('updatecountry')}}" method="POST">
                    @csrf
                    <div class="row"> <label class="col-sm-2 col-form-label">{{__('file.country')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" id="country" type="text" placeholder="{{ __('file.country') }}" value="{{ old('country') }}" required="true" aria-required="true" />

                                <span id="eerrcountry" class="error text-danger" for="input-name"></span>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="country_id" id="country_id">


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
    $(document).on('click', '.editCountry', function() {
        $('#country_id').val($(this).data('id'));
        $('#country').val($(this).data('country'));
        $('#editCountry').modal('show');
    })


    $(".status_checkbox").change(function() {
        let country_id = $(this).data('id');
        let status = 0;

        if (this.checked) {
            status = 1;
        }
        var data = {
            'country_id': country_id,
            'status': status
        };


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('country_status')}}",
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