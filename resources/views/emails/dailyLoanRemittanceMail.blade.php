@component('mail::message')

    Hello <br>

    This email is from :{{config('app.name') }}
    This is to notify you of the daily payment transaction that just occurred
    Below are there transaction details:

    Loanee: {{ $loan->loanUser->fullName() }}
    Amount Paid Today: {{ $loan->top->amount }}
    Amount Borrowed: {{ $loan->amount }}
    Interest: {{ $loan->interest }}
    Daily Payment: {{ $loan->daily_payment }}
    Total Payment: {{ $loan->total_payment}}
    Start Date: {{ $loan->start_date }}
    End Date: {{ $loan->end_date}}
    Status: {{ $loan->status }}
    Loanee Balance {{ $loan->wallet->balance }}


    The above transaction was carried out by
    Admin: {{ $loan->user->fullName() }}
    Date: {{ $loan->top->created_at }}


    Sincerely,
    {{ config('app.name') }}
@endcomponent
