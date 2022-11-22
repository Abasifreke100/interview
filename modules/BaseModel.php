<?php

namespace LoanHistory\Modules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected $casts = [
        "created_at" => 'datetime:d-m-Y H:i:s',
        "updated_at" => 'datetime:d-m-Y H:i:s',
    ];

}
