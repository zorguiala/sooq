@component('mail::message')
# Alert found

A new search alert has been found

@component('mail::button', ['url' => $url, 'color' => 'red'])
View ad
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent