<?php

namespace LoanHistory\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
      "id",
      "name",
      "slug"
    ];
}
