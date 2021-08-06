@component('mail::message')
# {{ $data['heading'] }}

{{ $data['body'] }}

@component('mail::button', ['url' => $data['base_url']])
{{ $data['button_name'] }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent