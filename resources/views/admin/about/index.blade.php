@extends('layouts.app')
@section('content')
<style>
body{
	background-color:white;
}

</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<div class="container pt-5">
<div class="row mt-5">
<div class="col-md-12">
<form method="post" action="{{route('admin.aboutus')}}">
@csrf
  <textarea id="summernote" name="content">{{$setting->about_us}}</textarea>
    @if ($errors->has('content'))
		<div class="row">
<span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('content') }}</span>
</div>
@endif
<button type="submit" class="btn btn-primary">Save</button>

</form>

</div>

</div>

</div>
<script>
$(document).ready(function() {
$('#summernote').summernote({
      
        tabsize: 2,
        height: 500,
		
      });
});

</script>



@endsection