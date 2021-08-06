@extends('slayouts.app')
@section('content')
<div class="container-fluid pt-5">
    <div class="row">
	
	<div class="col-md-10 offset-md-1">
            <div class="card">
			  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons text-danger">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('file.notification')}}</li>
                    </ol>
                </nav>
                 <div class="card-body">
				 
				 
				  <form action="{{route('send.notification')}}" method="POSt" enctype="multipart/form-data">
                        @csrf  
				  <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.title')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('title') has-danger @enderror ">
                                        <input autocomplete="off" class="form-control @error('fname') is-invalid @enderror" name="title" type="text" placeholder="{{__('file.title')}}" value="{{old('title')}}" />
                                        @if ($errors->has('title'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.description')}} <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="5" name="description" type="text" placeholder="{{__('file.description')}}" value="{{old('description')}}" ></textarea>
                                        @if ($errors->has('description'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('description') }}</span>
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

                            </div>
                            <img id="profile-img-tag" src="" style="display: none;">
                        </div>
                    </div>
                           
                        
                       
                     



                            <div class="row">
                                <button type="submit" class="btn btn-primary ml-2">{{__('file.submit')}}</button>

                            </div>
                       


                    </form>
				 
				 
				 
				 
				 
				 
				 
				 
				 </div>
				 </div>
				 </div>
				 </div>
				 </div>
				 
				 
				 @endsection
				 
				 
				 
				 
				 
				 
				 