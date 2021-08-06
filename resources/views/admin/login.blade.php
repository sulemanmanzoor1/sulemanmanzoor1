@extends('layouts.css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<div class="container " style="height: auto; ">
    <div class="row align-items-center wait" style="display:none;">
        <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('admin') }}">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-header card-header-primary text-center">
                        <h4 class="card-title"><strong>Admin Login</strong></h4>

                    </div>
                    <div class="card-body">
                        <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group mt-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>
                                <input type="email" value="{{old('email')}}" name="email" class="form-control" placeholder="Enter Email" required>

                            </div>
                            @if ($errors->has('email'))
                            <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" value="" required>
                            </div>
                            @if ($errors->has('password'))
                            <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-check mr-auto ml-3 mt-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Lets Go') }}</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-light">
                        <small>{{ __('Forgot password?') }}</small>
                    </a>
                    @endif
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin') }}" class="text-light">
                        <small>{{ __('Create new account') }}</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@extends('layouts.script')
<script>
    $(document).ready(function() {
        console.log('one ')
        wait();
    });

    function wait() {
        setTimeout(
            function() {
                $('.wait').css('display', '');
                //do something special
            }, 100);
    }
</script>
@if (session()->has('success'))
<script>
    var content = {};

    content.message = "{{session('success')}}";
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
        type: 'success',
        placement: {
            from: 'top',
            align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        delay: 4000,
    });
</script>
@endif


@if (session()->has('warning'))
<script>
    var content = {};

    content.message = "{{session('warning')}}";
    content.title = 'Warning!';
    content.icon = 'fa fa-bell';

    $.notify(content, {
        type: 'warning',
        placement: {
            from: 'top',
            align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        delay: 4000,
    });
</script>
@endif
</body>

</html>