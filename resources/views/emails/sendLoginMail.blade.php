@component('mail::message')
    Hello {{$user->firstName()}}, <br>

    This email is from : {{config('app.name') }}
    Below are your login credentials:

    Email: {{ $user->email }}
    Password: {{ $password }}

    Sincerely,
    {{ config('app.name') }}
@endcomponent
