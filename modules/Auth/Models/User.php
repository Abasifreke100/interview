<?php

namespace LoanHistory\Modules\Auth\Models;

use App\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LoanHistory\Modules\DateFilters;
use LoanHistory\Modules\Loan\Models\Loan;
use LoanHistory\Modules\Loan\Models\LoanUser;
use LoanHistory\Modules\Project\Models\Loanee;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, DateFilters;

    public $incrementing = false;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function wallet() {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    public function loans() {
        return $this->hasMany(LoanUser::class, 'user_id', 'id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }
}
