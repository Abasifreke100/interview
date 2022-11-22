<?php


namespace LoanHistory\Modules;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


trait DateFilters
{

    public function scopeOfToday(Builder $query){
        return $query->where(DB::raw('DATE(created_at)'), now()->toDateString());
    }


    public function scopeOfWeek(Builder $query){
        $sunday = now()->startOfWeek(0);
        $saturday = now()->endOfWeek(0);


        return $query
            ->whereDate('created_at', '>=',$sunday)
            ->whereDate('created_at','<=',$saturday);
    }

    public function scopeOfMonth(Builder $query){
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();


        return $query
            ->whereDate('created_at', '>=',$startOfMonth)
            ->whereDate('created_at','<=',$endOfMonth);
    }

    public function scopeOfYear(Builder $query){
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        return $query
            ->whereDate('created_at', '>=',$startOfYear)
            ->whereDate('created_at','<=',$endOfYear);
    }


    public function scopeOfDateRange(Builder $query,Carbon $startDate, Carbon $endDate){
        return $query
            ->whereDate('created_at', '>=',$startDate)
            ->whereDate('created_at','<=',$endDate);
    }

    public function scopeToDate(Builder $query, $endDate){
        return $query->whereDate('created_at','<=', $endDate);
    }


    public function scopeFromDate(Builder $query,$startDate){
        return $query->whereDate('created_at','>=', $startDate);

    }


}
