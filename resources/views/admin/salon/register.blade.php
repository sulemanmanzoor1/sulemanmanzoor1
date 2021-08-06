@extends('layouts.css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid pt-5  wait">

    <div class="row wait" style="display: none;">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header card-header-primary text-center">
                    <h4 class="card-title"><strong> Salon Register</strong></h4>

                </div>
                <div class="card-body">
                    <form action="{{route('salon.register')}}" method="POSt" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.first_name')}}<small>({{__('file.owner')}})</small> <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('fname') has-danger @enderror ">
                                        <input autocomplete="off" class="form-control @error('fname') is-invalid @enderror" name="fname" type="text" placeholder="{{__('file.enter_first_name')}}" value="{{old('fname')}}" />
                                        @if ($errors->has('fname'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('fname') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.last_name')}}<small>({{__('file.owner')}})</small> <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('lname') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" type="text" placeholder="{{__('file.enter_last_name')}}" value="{{old('lname')}}" />
                                        @if ($errors->has('lname'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('lname') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.salon_name')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('salon_name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="salon_name" type="text" placeholder="{{__('file.enter_salon_name')}}" value="{{old('salon_name')}}" />
                                        @if ($errors->has('salon_name'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('salon_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.email')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" placeholder="{{__('file.enter_email')}}" value="{{old('email')}}" />
                                        @if ($errors->has('email'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.phone')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" type="text" placeholder="{{__('file.enter_phone')}}" value="{{old('phone')}}" />
                                        @if ($errors->has('phone'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.password')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" type="password" placeholder="{{__('file.enter_password')}}" value="{{old('password')}}" />
                                        @if ($errors->has('password'))
                                        <span class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.country')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                        <select class="form-control @error('country') border-bottom border-danger @enderror" name="country" id="country">
                                            <option value=" ">{{__('file.select')}} {{__('file.country')}}</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->country_name}}</option>
                                            @endforeach
                                        </select> @if ($errors->has('country'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('country') }}</span>
                                        @endif
                                        <p class="text-danger country"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.city')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <select class="form-control @error('city') border-bottom border-danger @enderror" name="city" id="city">

                                        </select> @if ($errors->has('city'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.image')}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="profile-img">
                                        <label class="custom-file-label" for="validatedCustomFile">{{__('file.choose_file')}}</label>
                                        @if ($errors->has('image'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('image') }}</span>
                                        @endif
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
@extends('layouts.script')
<script>
    $(document).ready(function() {
        wait();
    });

    function wait() {
        setTimeout(
            function() {
                $('.wait').css('display', '');
                //do something special
            }, 400);
    }

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
        $.aja
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