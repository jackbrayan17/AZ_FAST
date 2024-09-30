@component('mail::message')
# New Agent Created

A new agent has been created.

**Name:** {{ $agent->name }}  
**Email:** {{ $agent->email }}  
**Role:** {{ $agent->role }}

Thanks,  
{{ config('app.name') }}
@endcomponent
