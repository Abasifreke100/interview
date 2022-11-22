<?php

namespace LoanHistory\Modules\Loan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LoanHistory\Modules\DateFilters;

class LoanCategory extends Model
{
    use HasFactory, DateFilters;

    protected $fillable = [
        "id",
        "name",
        "slug"
    ];

    public $incrementing = false;

}
