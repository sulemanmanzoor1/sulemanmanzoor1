@if((session()->get('applocale')=='en') || (session()->has('applocale')==false))
@include('layouts.css')

@else
@include('layouts.css2')

@endif
@if((session()->get('applocale')=='en') || (session()->has('applocale')==false))

<form id="logout-form" action="" method="POST" style="display: none;">
    @csrf
</form>
@include('layouts.page_templates.auth')



@else

@include('layouts.page_templates.auth1')

@endif