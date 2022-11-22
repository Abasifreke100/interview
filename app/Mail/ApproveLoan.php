<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use LoanHistory\Modules\Loan\Models\Loan;

class ApproveLoan extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

        return $this->to([$this->loan->user->email, $this->loan->loanUser->email])
            ->subject('Approve Loan')
            ->markdown('emails.approveLoan');
    }

}
