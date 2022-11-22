<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use LoanHistory\Modules\Loan\Models\Loan;
use LoanHistory\Modules\Project\Models\LoanUser;

class SendNewLoanMail extends Mailable
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

//        return $this->to([$this->loan->user->email, $this->loan->loanee->email,'loanit2022@gmail.com'])
//            ->subject('Loan Notification From Loanit')
//            ->markdown('emails.newLoanMail');
    }


}
