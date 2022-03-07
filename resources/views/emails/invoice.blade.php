@component('mail::message')
# Introduction

Here is the latest invoice

@component('mail::panel')
The invoice has been attached
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
