<?php

namespace LoanHistory\Modules\Loan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LoanHistory\Modules\BaseModel;

class Interest extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "id",
        "type",
        "percentage",
    ];
}
