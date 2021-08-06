@extends('slayouts.app')
@section('content')
<div class="container-fluid pt-5 mt-5">

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary text-center">
                    <h4 class="card-title"><strong>{{__('file.salon_profile')}}</strong></h4>

                </div>
                <h4 class="mt-3 pl-3"><b>{{__('file.edit_profile')}}</b></h4>


                <p class="mt-5 pl-3">{{__('file.owner_information')}}</p>

                <p class="pl-3"><b>{{__('file.change_profile_photo')}}</b>
                </p>
                <form action="{{route('salon.profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input class="pl-3" type="file" name="image">
                    <p class="pl-3 mt-3">
                        <img class="rounded" style="height:200px ;" src="{{url('uploads/salons')}}/{{$salon->image}}" alt="">
                    </p>
                    <input type="hidden" name="salon_id" value="{{$salon->id}}">
                    <input type="hidden" name="old_image" value="{{$salon->image}}">
                    <div class="row pl-3">
                        <label class="col-sm-3 col-form-label" for="input-password">{{__('file.first_name')}} <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="form-group @error('code') has-danger @enderror ">
                                <input autocomplete="off" class="form-control @error('first_name') is-invalid @enderror" name="first_name" type="text" placeholder="{{__('file.first_name')}}" value="{{$salon->first_name}}" />
                                @if ($errors->has('first_name'))
                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3">
                        <label class="col-sm-3 col-form-label" for="input-password">{{__('file.last_name')}} <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="form-group @error('last_name') has-danger @enderror ">
                                <input autocomplete="off" class="form-control @error('last_name') is-invalid @enderror" name="last_name" type="text" placeholder="{{__('file.last_name')}}" value="{{$salon->last_name}}" />
                                @if ($errors->has('last_name'))
                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3">
                        <label class="col-sm-3 col-form-label" for="input-password">{{__('file.email')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input readonly class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" placeholder="{{__('file.enter_email')}}" value="{{$salon->email}}" />
                                @if ($errors->has('email'))
                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3">
                        <label class="col-sm-3 col-form-label" for="input-password">{{__('file.phone')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" type="text" placeholder="{{__('file.enter_phone')}}" value="{{$salon->phone}}" />
                                @if ($errors->has('phone'))
                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3">
                        <button type="submit" class="btn btn-primary ml-2">{{__('file.submit')}}</button>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <p class="ml-5 pl-3 mt-3">
                    <img class="rounded-circle" style="height:200px ;" src="{{url('uploads/salons')}}/{{$salon->image}}" alt="">
                </p>
                <div class="row ml-2">
                    <div class="col-md-3 text-center">
                        <span class="text-center">{{$salon->wallet}}$</span>
                        <span><b>{{__('file.income')}}</b></span>
                    </div>
                    <div class="col-md-3 text-center">
                        <span class="text-center">{{getSalonServices()}}</span>
                        <span><b>{{__('file.services')}}</b></span>
                    </div>
                </div>
                <div class="row  ml-3">
                    <div class="col-md-12 text-center">
                        <h3 class="text-center"><b>{{$salon->first_name}} {{$salon->last_name}}</b></h3>

                        <p>{{__('file.phone')}}: {{$salon->phone}}</p>
                        <p>{{__('file.email')}}: {{$salon->email}}</p>
                        <hr>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary text-center">
                    <h4 class="card-title"><strong>{{__('file.change_password')}}</strong></h4>

                </div>
                <div class="container mt-5">
                    <form id="ajaxForm" action="{{route('salon.change.password')}}" method="POST">
                        @csrf
                        <input type="hidden" name="salon_id" value="{{$salon->id}}">
                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.current_password')}}<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group{{ $errors->has('current_password') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" type="password" placeholder="{{__('file.current_password')}}" value="{{old('current_password')}}" />
                                    <p id="errcurrent_password" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.new_password')}}<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group{{ $errors->has('new_password') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" type="password" placeholder="{{__('file.new_password')}}" value="{{old('new_password')}}" />
                                    <p id="errnew_password" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.confirm_password')}}<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group{{ $errors->has('confirm_password') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" name="confirm_password" type="password" placeholder="{{__('file.confirm_password')}}" value="{{old('new_password')}}" />
                                    <p id="errconfirm_password" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <button type="button" id="submitBtn" class="btn btn-primary ml-2">{{__('file.update')}}</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection