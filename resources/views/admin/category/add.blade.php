@extends('layouts.app')
@section('content')

<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item "><a href="{{route('category')}}">{{__('file.all')}} {{__('file.category')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.add')}} {{__('file.category')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <form action="{{route('add-category')}}" method="POSt" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{__('file.category_name')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" id="input-name" type="text" placeholder="{{ __('file.category') }}" value="{{ old('category') }}" required="true" aria-required="true" />
                                        <span id="errcategory" class="error text-danger" for="input-name"></span>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label" for="input-password">{{__('file.image')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="profile-img">
                                        <label class="custom-file-label" for="validatedCustomFile">{{__('file.choose_file')}}</label>

                                    </div>
                                    <img id="profile-img-tag" src="" style="display: none;">
                                </div>
                            </div>

                            <div class="row">
                                <button type="submit" class="btn btn-primary ml-2">{{__('file.submit')}}</button>

                            </div>
                        </div>


                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                console.log(e);
                $('#profile-img-tag').css('display', '');
                $('#profile-img-tag').css('width', '100px', 'height', '100px');
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function() {
        readURL(this);
    });
    $('#country').on('change', function() {
        let country_id = $(this).val();

        if (country_id == " ") {
            console.log(country_id);
            $('.country').html('please select country');
            return false;
        } else {
            $('.country').html('');
        }

        let data = {
            'country_id': country_id
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: "{{route('search-city')}}",
            success: function(res) {
                if (res.status == 200) {
                    $("#city option").each(function() {
                        $(this).remove();
                    });
                    let option1 = '<option value="">Select City</option>';
                    $('#city').append(option1);
                    for (var i = 0; i < res.data.length; i++) {
                        var option = "<option value=" + res.data[i]['id'] + ">" + res.data[i]['city_name'] + "</option>";
                        $('#city').append(option);
                    }
                }
                if (res.status == 401) {
                    $("#city option").each(function() {
                        $(this).remove();
                    });
                    var option1 = '<option value="">' + res.message + '</option>';
                    $('#city').append(option1);
                }
            }
        });
    })
</script>
@endsection