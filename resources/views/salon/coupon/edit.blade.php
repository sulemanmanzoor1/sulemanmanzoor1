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
                        <li class="breadcrumb-item "><a href="{{route('coupon')}}">{{__('file.all')}} {{__('file.coupon')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.add')}} {{__('file.coupon')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <form id="ajaxForm" action="{{route('edit.coupon')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="coupon_id" value="{{$coupon->id}}">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.code')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('code') has-danger @enderror ">
                                        <input autocomplete="off" readonly class="form-control @error('fname') is-invalid @enderror" name="code" type="text" placeholder="{{__('file.code')}}" value="{{$coupon->code}}" />
                                        @if ($errors->has('code'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('code') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.description')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" type="text" placeholder="{{__('file.description')}}" value="{{$coupon->description}}" />
                                        @if ($errors->has('description'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.max_use')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('max_use') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('max_use') ? ' is-invalid' : '' }}" name="max_use" type="text" placeholder="{{__('file.max_use')}}" value="{{$coupon->max_use}}" />
                                        @if ($errors->has('max_use'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('max_use') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.type')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input discount_option_no" type="radio" {{$coupon->type== 'p' ? 'checked' : ''}} name="discount_option" id="inlineRadio1" value="p">
                                        <label class="form-check-label" for="inlineRadio1">{{__('file.percentage')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input discount_option_yes  " {{$coupon->type== 'a' ? 'checked' : ''}} type="radio" name="discount_option" id="inlineRadio2" value="a">
                                        <label class="form-check-label" for="inlineRadio2">{{__('file.amount')}}</label>
                                    </div>
                                    @if ($errors->has('discount_option'))
                                    <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('discount_option') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row is_discount">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.discount')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" type="text" placeholder="{{__('file.discount')}}" value="{{$coupon->discount}}" />
                                        @if ($errors->has('discount'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('discount') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.start_date')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" type="date" placeholder="{{__('file.start_date')}}" value="{{$coupon->start_date}}" />
                                        @if ($errors->has('start_date'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.end_date')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" type="date" placeholder="{{__('file.end_date')}}" value="{{$coupon->end_date}}" />
                                        @if ($errors->has('end_date'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>



                    </form>
                    <div class="row">
                        <button type="button" id="submitBtn" class="btn btn-primary ml-2">{{__('file.submit')}}</button>

                    </div>
                </div>


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