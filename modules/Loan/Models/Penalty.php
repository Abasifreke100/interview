<?php

namespace LoanHistory\Modules\Loan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LoanHistory\Modules\BaseModel;

class Penalty extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "percentage"
    ];
}
