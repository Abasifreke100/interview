@component('mail::message')

    Hello SuperAdmin, <br>

    This email is from : {{config('app.name') }}
    This is to notify you of the latest part payment transaction that just occurred
    Below are there transaction details:

    Loan Channel: {{ $top->channel }}
    Loanee: {{ $loanUser->fullName() }}
    Amount Part Paid Today: {{ $top->amount }}
    Current Daily Payment: {{ $loan->daily_payment }}
    Current Total Payment: {{ $loan->total_payment}}
    Start Date: {{ $loan->start_date }}
    End Date: {{ $loan->end_date}}
    Interval: {{ $loan->interval }} weekdays
    Loanee Balance {{ $wallet->balance }}


    The above transaction was carried out by:

    Admin: {{ $loan->user->fullName() }}
    Date: {{ $loan->created_at }}


    Sincerely,
    {{ config('app.name') }}
@endcomponent
