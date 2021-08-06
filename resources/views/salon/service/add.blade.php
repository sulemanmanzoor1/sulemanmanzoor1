@extends('slayouts.app')
@section('content')
<style>
    .form-check .form-check-input {
        opacity: 2;
        height: 33px;
        width: 18px;
        overflow: hidden;

        z-index: 10;

    }
</style>
<div class="container-fluid pt-5">

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item "><a href="{{route('salon')}}">{{__('file.all')}} {{__('file.services')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.add')}} {{__('file.service')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <form action="{{route('add.service')}}" method="POSt" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.service_name')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('service_name') has-danger @enderror ">
                                        <input autocomplete="off" class="form-control @error('fname') is-invalid @enderror" name="service_name" type="text" placeholder="{{__('file.enter_service_name')}}" value="{{old('fname')}}" />
                                        @if ($errors->has('service_name'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('service_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.service_price')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('service_price') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('service_price') ? ' is-invalid' : '' }}" name="service_price" type="text" placeholder="{{__('file.enter_service_price')}}" value="{{old('service_price')}}" />
                                        @if ($errors->has('service_price'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('service_price') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.discount')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input discount_option_no" type="radio" checked name="discount_option" id="inlineRadio1" value="0">
                                        <label class="form-check-label" for="inlineRadio1">{{__('file.no_discount')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input discount_option_yes  " {{old('discount_option') == '1' ? 'checked' : ''}} type="radio" name="discount_option" id="inlineRadio2" value="1">
                                        <label class="form-check-label" for="inlineRadio2">{{__('file.discount')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row is_discount" style="display:none;">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.discount')}} <small>(in percentage)</small> <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" type="text" placeholder="{{__('file.discount')}}" value="{{old('discount')}}" />
                                        @if ($errors->has('discount'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('discount') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.service_time')}}<small>({{__('file.minutes')}})</small> <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('service_time') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('service_time') ? ' is-invalid' : '' }}" name="service_time" type="text" placeholder="{{__('file.enter_service_time')}}" value="{{old('lname')}}" />
                                        @if ($errors->has('service_time'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('service_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.category')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                                        <select class="form-control @error('category') border-bottom border-danger @enderror" name="category" id="category">
                                            <option value=" ">{{__('file.select')}} {{__('file.category')}}</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select> @if ($errors->has('category'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('category') }}</span>
                                        @endif
                                        <p class="text-danger country"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.image')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
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
    $(document).ready(function() {
        if ($('.discount_option_yes').prop('checked')) {
            $('.is_discount').css('display', '');
        }
    })
    $('.discount_option_no').click(function() {
        $('.is_discount').css('display', 'none');

    });
    $('.discount_option_yes').click(function() {
        $('.is_discount').css('display', '');

    });

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