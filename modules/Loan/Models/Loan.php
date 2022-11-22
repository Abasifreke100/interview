<?php

namespace LoanHistory\Modules\Loan\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LoanHistory\Modules\Auth\Models\User;
use LoanHistory\Modules\BaseModel;
use LoanHistory\Modules\DateFilters;

class Loan extends BaseModel
{
    use HasFactory, DateFilters;

    public $incrementing = false;

    protected $fillable = [
        "id",
        "user_id",
        "loan_category_id",
        "penalty_id",
        "interest_id",
        "amount",
        "interest",
        "status",
    ];

    public function penalty(){
        return $this->belongsTo(Penalty::class,'penalty_id');
    }

    public function interest(){
        return $this->belongsTo(Interest::class,'interest_id');
    }

    public function loanCategory(){
        return $this->belongsTo(LoanCategory::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeOfUser($query){

        if(auth()->user()->role->slug == "super_admin")
            return $query;

        return $query->where("user_id", auth()->user()->id);
    }


    public function scopeStatus($query, $status){
        return $query->where('status', 'LIKE', '%' . $status);
    }


    public function scopeDateRange(Builder $query, $startDate, $endDate)
    {
        return $query->whereBetween(DB::raw('created_at'), [$startDate, $endDate]);
    }

    public function scopeToDate(Builder $query, $endDate)
    {
        return $query->whereDate('created_at', '<=', $endDate);
    }


    public function scopeFromDate(Builder $query, $startDate)
    {
        return $query->whereDate('created_at', '>=', $startDate);
    }

    public function loanees() {
        return $this->hasMany(LoanUser::class, 'loan_id', 'id');
    }




}
