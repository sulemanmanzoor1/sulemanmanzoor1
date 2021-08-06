@extends('slayouts.app')
@section('content')
<style>
.form-check .form-check-input {
    opacity: 3;
    height: 19px;
    width: 30px;
    overflow: hidden;
}
.form-check .form-check-input {
   
    position: absolute;
   
    z-index: 12; 

    overflow: hidden;
    /* left: 0; */
    /* pointer-events: none; */
}

</style>

<script src='https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css' rel='stylesheet' />
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">
<div class="container-fluid mt-5 pt-5 ">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">

                <div class="card-header card-header-primary text-center">
                    <h4 class="card-title"><strong>{{__('file.salon_setting')}}</strong></h4>

                </div>
                <form id="ajaxForm" action="{{route('salon.setting')}}" method="POST">
                    @csrf
                    <div class="container mt-4">
                        <div class="row ">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.description')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group @error('code') has-danger @enderror ">
                                    <textarea class="form-control" placeholder="{{__('file.description')}}" name="description" rows="5">{{$salon->description ? : ''}}</textarea>
                                    <p id="errdescription" class="mb-0 text-danger em"></p>

                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.website')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group @error('code') has-danger @enderror ">
                                    <input autocomplete="off" class="form-control @error('first_name') is-invalid @enderror" name="website" value="{{$salon->website ? : ''}}" type="text" placeholder="{{__('file.website')}}" />
                                    <p id="errwebsite" class="mb-0 text-danger em"></p>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div id='map' style='width: 400px; height: 300px;'></div>

                            </div>

                        </div>

                        <div class="row ">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.latitude')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group @error('code') has-danger @enderror ">
                                    <input autocomplete="off" readonly class="form-control @error('first_name') is-invalid @enderror" value="{{$salon->lat ? : ''}}" name="lat" id="lat" type="text" />
                                    <p id="errlat" class="mb-0 text-danger em"></p>

                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.longitude')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group @error('code') has-danger @enderror ">
                                    <input autocomplete="off" readonly class="form-control @error('lng') is-invalid @enderror" value="{{$salon->lng ? : ''}}" name="lng" id="lng" type="text" />
                                    <p id="errlng" class="mb-0 text-danger em"></p>

                                </div>
                            </div>
                        </div>
						 <div class="row ">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.give_service')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-check">
  <input class="form-check-input give_service" type="radio" value="2" name="give_service" id="exampleRadios1" 
   @if($salon->give_service==2)  checked @endif  >
  <label class="form-check-label" for="exampleRadios1">
   {{__('file.salon')}} 
  </label>
</div>
<div class="form-check">
  <input class="form-check-input give_service" type="radio" value="1" name="give_service" id="exampleRadios2"
  @if($salon->give_service==1) checked @endif>
  <label class="form-check-label" for="exampleRadios2">
   {{__('file.home')}} 
  </label>
</div>
<div class="form-check disabled">
  <input class="form-check-input give_service" type="radio" value="0" name="give_service" id="exampleRadios3"
   @if($salon->give_service==0)  checked @endif>
  <label class="form-check-label" for="exampleRadios3">
  {{__('file.both')}} 
  </label>
</div>
                            </div>
                        </div>
						 <div class="row hidorshowcharges"  style="display:none;">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.service_charges')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group @error('code') has-danger @enderror ">
                                    <input autocomplete="off"  class="form-control @error('lng') is-invalid @enderror" value="{{$salon->service_charges}}" name="service_charges" id="service_charges" type="text" />
                                    <p id="errservice_charges" class="mb-0 text-danger em"></p>

                                </div>
                            </div>
                        </div>
						 <div class="row ">
                            <label class="col-sm-3 col-form-label" for="input-password">{{__('file.slotallowed')}} <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-group @error('slot_allowed') has-danger @enderror ">
                                    <input autocomplete="off"  class="form-control @error('slot_allowed') is-invalid @enderror" value="{{$salon->slot_allowed ? : ''}}" name="slot_allowed" id="slot_allowed" type="text" />
                                    <p id="errslot_allowed" class="mb-0 text-danger em"></p>

                                </div>
                            </div>
                        </div>
                </form>
                <div class="row mb-3">
                    <button type="button" id="submitBtn" class="btn btn-primary ml-2">{{__('file.update')}}</button>

                </div>
            </div>


        </div>

    </div>

</div>


</div>

<script>

$('.give_service').on('click',function(){
	var status=$(this).val();
	if(status==0){
		console.log(status);
		$('.hidorshowcharges').css('display','');
	}else if(status==1){
		$('.hidorshowcharges').css('display','');
	}else if(status==2){
		$('.hidorshowcharges').css('display','none');
	}
});

$(document).ready(function(){

	if("{{$salon->give_service}}"==0){
		$('.hidorshowcharges').css('display','');
	}else if("{{$salon->give_service}}"==1){
		$('.hidorshowcharges').css('display','');
	}else if("{{$salon->give_service}}"==2) {
		
		$('.hidorshowcharges').css('display','none');
	}
})
    $(document).ready(function() {

       
        mapboxgl.accessToken = 'pk.eyJ1IjoibXVoYW1tYWRhcnNsYW4wMDAyNiIsImEiOiJja245NmQxaWUwejM3Mm9uem9oeGFkZ3ZzIn0.2NI3WI59D2HQIKWc7kIfTA';
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11',
            center: ["{{$salon->lng ? : '-96'}}", "{{$salon->lat ? : '37.8'}}"], // starting position
            zoom: 10 // starting zoom
        });

        // Add geolocate control to the map.
        map.addControl(
            new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true
            })
        );
        map.addControl(
            new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl
            })
        );
        console.log(map);
        map.on('click', function(e) {

            let lat = e.lngLat.wrap().lat;
            let lng = e.lngLat.wrap().lng;
            $('#lat').val(lat);
            $('#lng').val(lng);

        });

    })
</script>
@endsection