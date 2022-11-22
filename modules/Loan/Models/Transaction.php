<?php

namespace LoanHistory\Modules\Loan\Models;

use LoanHistory\Modules\BaseModel;
use LoanHistory\Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'loan_id',
        'wallet_id',
        'transactionable_type',
        'transactionable_id',
        'amount',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionable() {
        return $this->morphTo();
    }
}
