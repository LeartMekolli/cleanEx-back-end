@component('mail::message')
# Mirëseerdhët në familjen e CleanEx

Familja më të madhe për vetëpunësim. 

@component('mail::panel',['message'=>$message])
# {{$message['title']}}
    {{$message['content']}} {{$message['code']}}
@endcomponent



Faleminderit, që jeni pjesë e 
{{ config('app.name') }}


@endcomponent

