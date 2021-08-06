@extends('layouts.app')
@section('content')
<div class="container-fluid pt-5">
 <form action="{{route('admin.setting.save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item "><a href="{{route('salon')}}">{{__('file.all')}} {{__('file.setting')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.add')}} {{__('file.setting')}}</li>
                    </ol>
                </nav>
                <div class="card-body">
				
				 <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.salon_name')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('name') has-danger @enderror ">
                                        <input autocomplete="off" class="form-control @error('fname') is-invalid @enderror" name="name" type="text" placeholder="{{__('file.enter_salon_name')}}" value="{{$setting->site_name}}" />
                                        @if ($errors->has('name'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.commission')}}<small>({{__('file.commission_in_money')}})</small>  <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('name') has-danger @enderror ">
                                        <input autocomplete="off" class="form-control @error('commission') is-invalid @enderror" name="commission" type="text" placeholder="{{__('file.enter_commission')}}" value="{{$setting->commission}}" />
                                        @if ($errors->has('commission'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('commission') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.currency')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('name') has-danger @enderror ">
                                        <input autocomplete="off" class="form-control @error('currency') is-invalid @enderror" name="currency" type="text" placeholder="{{__('file.enter_currency')}}" value="{{$setting->currency}}" />
                                        @if ($errors->has('currency'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('currency') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
							   <div class="row">
                                <button type="submit" class="btn btn-primary ml-2">{{__('file.submit')}}</button>

                            </div>
				
				</div>
				
				</div>
				
				</div>
				</div>

</form>










@endsection