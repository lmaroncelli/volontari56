@component('mail::message')

- **{{$url}}**
- file: {{$file}} 
- line: {{$line}}
- exception: {{$msg}} 

@component('mail::button', ['url' => ''])
Vai
@endcomponent

Grazie,<br>
{{ config('app.name') }}
@endcomponent
