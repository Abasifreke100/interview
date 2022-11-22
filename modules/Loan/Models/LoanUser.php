<?php

namespace LoanHistory\Modules\Loan\Models;

use LoanHistory\Modules\BaseModel;
use LoanHistory\Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanUser extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'loan_id',
        'amount_paid',
        'balance',
        'total_due',
        'amount',
        "start_date",
        "end_date",
        'overdue_charge',
        'final_due',
        'status',
    ];

    public function loan() {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionable() {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

}
