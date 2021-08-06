@extends('slayouts.app')
@section('content')
@php
$time=json_decode($salon->timing,True);


@endphp
<div class="container pt-5 mt-5">

    <div class="row">
        <div class="card">
            <div class="card-header card-header-primary text-center">
                <h4 class="card-title"><strong>{{__('file.salon_timing')}}</strong></h4>

            </div>
            <div class="container">
                <div class="row mt-5 ">
                    <div class="col-md-5">
                        <h4><b>Opening Time</b></h4>
                    </div>
                    <div class="col-md-5">
                        <h4><b>Closing Time</b></h4>
                    </div>
                    <div class="col-md-2">
                        <h4><b> Day Off</b></h4>
                    </div>
                </div>
                <form action="{{route('salon.time')}}" id="ajaxForm" method="POST">
                    @csrf
                    @isset($time['sunday'])
                    @php
                    $sunday=explode(',',$time['sunday']);
                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.sunday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('ssunday') has-danger @enderror ">
                                        <input value="@isset($sunday[0]){{$sunday[0]}}@endisset" @empty($time['sunday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror sunday" name="ssunday" type="time" />
                                        <p id="errssunday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @error('esunday') has-danger @enderror ">
                                <input value="@isset($sunday[1]){{$sunday[1]}}@endisset" @empty($time['sunday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror sunday" name="esunday" type="time" />
                                <p id="erresunday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="sunday" @empty($time['sunday']) checked @endempty type="checkbox" id="sunday" name="sunday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @isset($time['monday'])
                    @php
                    $monday=explode(',',$time['monday']);
                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.monday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('smonday') has-danger @enderror ">
                                        <input value="@isset($monday[0]){{$monday[0]}}@endisset" @empty($time['monday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror monday" name="smonday" type="time" />
                                        <p id="errsmonday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @error('emonday') has-danger @enderror ">
                                <input value="@isset($monday[1]){{$monday[1]}}@endisset" @empty($time['monday']) readonly @endempty autocomplete="off" class="form-control @error('emonday') is-invalid @enderror monday" name="emonday" type="time" />
                                <p id="erremonday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" @empty($time['monday']) checked @endempty type="checkbox" name="monday" id="monday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @isset($time['tuesday'])
                    @php
                    $tuesday=explode(',',$time['tuesday']);
                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.tuesday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('stuesday') has-danger @enderror ">
                                        <input value="@isset($tuesday[0]){{$tuesday[0]}}@endisset" @empty($time['tuesday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror tuesday" name="stuesday" type="time" />
                                        <p id="errstuesday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @error('etuesday') has-danger @enderror ">
                                <input value="@isset($tuesday[1]){{$tuesday[1]}}@endisset" @empty($time['tuesday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror tuesday" name="etuesday" type="time" />
                                <p id="erretuesday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" @empty($time['tuesday']) checked @endempty type="checkbox" name="tuesday" id="tuesday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @isset($time['wednesday'])
                    @php
                    $wednesday=explode(',',$time['wednesday']);
                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.wednesday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('fname') has-danger @enderror ">
                                        <input value="@isset($wednesday[0]){{$wednesday[0]}}@endisset" @empty($time['wednesday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror wednesday" name="swednesday" type="time" />
                                        <p id="errswednesday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @error('fname') has-danger @enderror ">
                                <input value="@isset($wednesday[0]){{$wednesday[0]}}@endisset" @empty($time['wednesday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror wednesday" name="ewednesday" type="time" />
                                <p id="errewednesday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" @empty($time['wednesday']) checked @endempty type="checkbox" name="wednesday" id="wednesday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @isset($time['thursday'])
                    @php
                    $thursday=explode(',',$time['thursday']);
                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.thursday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('fname') has-danger @enderror ">
                                        <input value="@isset($thursday[0]){{$thursday[0]}}@endisset" @empty($time['thursday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror thursday" name="sthursday" type="time"" />
                                        <p id=" errsthursday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-5">
                            <div class="form-group @error('fname') has-danger @enderror ">
                                <input value="@isset($thursday[1]){{$thursday[1]}}@endisset" @empty($time['thursday']) readonly @endempty autocomplete="off" class="form-control @error('fname') is-invalid @enderror thursday" name="ethursday" type="time" />
                                <p id="errethursday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" @empty($time['thursday']) checked @endempty type="checkbox" name="thursday" id="thursday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @isset($time['friday'])
                    @php
                    $saturday=explode(',',$time['friday']);
                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.friday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('fname') has-danger @enderror ">
                                        <input value="@isset($friday[0]){{$firday[0]}}@endisset" autocomplete="off" class="form-control @error('fname') is-invalid @enderror friday" @empty($time['friday']) readonly @endempty name="sfriday" type="time" />
                                        <p id="errsfriday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @error('fname') has-danger @enderror ">
                                <input value="@isset($friday[1]){{$friday[1]}}@endisset" autocomplete="off" class="form-control @error('fname') is-invalid @enderror friday" @empty($time['friday']) readonly @endempty name="efriday" type="time" />
                                <p id="errefriday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="friday" @empty($time['friday']) checked @endempty type="checkbox" name="friday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @isset($time['saturday'])
                    @php
                    $saturday=explode(',',$time['saturday']);

                    @endphp
                    @endisset
                    <div class="row mt-5 ">
                        <div class="col-md-5">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="input-password">{{__('file.saturday')}}</label>
                                <div class="col-sm-9">
                                    <div class="form-group @error('fname') has-danger @enderror ">
                                        <input value="@isset($saturday[0]){{$saturday[0]}}@endisset" autocomplete="off" class="form-control @error('fname') is-invalid @enderror saturday" @empty($time['saturday']) readonly @endempty name="ssaturday" type="time" />
                                        <p id="errssaturday" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @error('fname') has-danger @enderror ">
                                <input autocomplete="off" value="@isset($saturday[1]){{$saturday[1]}}@endisset" class="form-control @error('fname') is-invalid @enderror saturday" @empty($time['saturday']) readonly @endempty name="esaturday" type="time" />
                                <p id="erresaturday" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" @empty($time['saturday']) checked @endempty type="checkbox" id="saturday" name="saturday" autocomplete="off">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="row">
                    <button id="submitBtn" type="submit" class="btn btn-primary ml-2">{{__('file.submit')}}</button>

                </div>

            </div>

        </div>

    </div>
</div>

<script>
    $('#sunday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.sunday').prop('readonly', true);
            $('.sunday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.sunday').prop('readonly', false);
        }

    });
    $('#monday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.monday').prop('readonly', true);
            $('.monday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.monday').prop('readonly', false);
        }

    });
    $('#tuesday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.tuesday').prop('readonly', true);
            $('.tuesday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.tuesday').prop('readonly', false);
        }

    });
    $('#wednesday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.wednesday').prop('readonly', true);
            $('.wednesday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.wednesday').prop('readonly', false);
        }

    });
    $('#thursday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.thursday').prop('readonly', true);
            $('.thursday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.thursday').prop('readonly', false);
        }

    });
    $('#friday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.friday').prop('readonly', true);
            $('.friday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.friday').prop('readonly', false);
        }

    });
    $('#saturday').click(function() {
        if ($(this).prop("checked") == true) {
            $('.saturday').prop('readonly', true);
            $('.saturday').val('');
        } else if ($(this).prop("checked") == false) {
            $('.saturday').prop('readonly', false);
        }

    });
</script>
@endsection