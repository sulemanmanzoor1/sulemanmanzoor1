@if((session()->get('applocale')=='en') || (session()->has('applocale')==false))
@include('slayouts.css')

@else
@include('slayouts.css2')

@endif
@if((session()->get('applocale')=='en') || (session()->has('applocale')==false))

<form id="logout-form" action="" method="POST" style="display: none;">
    @csrf
</form>
@include('slayouts.page_templates.auth')



@else

@include('slayouts.page_templates.auth1')

@endif