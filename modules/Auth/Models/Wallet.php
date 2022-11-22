<?php

namespace LoanHistory\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LoanHistory\Modules\DateFilters;

class Wallet extends Model
{
    use HasFactory, DateFilters;

    public $incrementing = false;

    protected $fillable = [
        "id",
        "user_id",
        "balance",
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
