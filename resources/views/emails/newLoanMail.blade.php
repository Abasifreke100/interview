@component('mail::message')

    Hello <br>

    This is a loan notification request from:{{config('app.name') }}
    Below are there transaction details:

    Loanee: {{ $loan->loanee->fullName() }}
    Amount: {{ $loan->amount }}
    Interest: {{ $loan->interest }}%
    Total Payment: {{ $loan->total_payment}}
    Start Date: {{ $loan->start_date }}
    End Date: {{ $loan->end_date}}
    Status: {{ $loan->status }}

    The above transaction was carried out by:

    Admin: {{ $loan->user->fullName() }}
    Date: {{ $loan->created_at }}


    Sincerely,
    {{ config('app.name') }}
@endcomponent
