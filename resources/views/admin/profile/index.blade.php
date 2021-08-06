@extends('layouts.app')
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
                <form action="{{route('admin.profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="admin_id" value="{{$admin->id}}">

                    <div class="row pl-3">
                        <label class="col-sm-3 col-form-label" for="input-password">{{__('file.name')}} <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="form-group @error('code') has-danger @enderror ">
                                <input autocomplete="off" class="form-control @error('first_name') is-invalid @enderror" name="name" type="text" placeholder="{{__('file.name')}}" value="{{$admin->name}}" />
                                @if ($errors->has('name'))
                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row pl-3">
                        <label class="col-sm-3 col-form-label" for="input-password">{{__('file.email')}}<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input readonly class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" placeholder="{{__('file.enter_email')}}" value="{{$admin->email}}" />
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
                                <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" type="text" placeholder="{{__('file.enter_phone')}}" value="{{$admin->phone}}" />
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

    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary text-center">
                    <h4 class="card-title"><strong>{{__('file.change_password')}}</strong></h4>

                </div>
                <div class="container mt-5">
                    <form id="ajaxForm" action="{{route('admin.change.password')}}" method="POST">
                        @csrf
                        <input type="hidden" name="admin_id" value="{{$admin->id}}">
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