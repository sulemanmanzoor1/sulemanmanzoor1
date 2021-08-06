@component('mail::message')
# {{ $data['heading'] }}

{{ $data['body'] }}

# {{ $data['code'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent