<?php


namespace LoanHistory\Modules\Auth\Api\v1\Repositories;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LoanHistory\Modules\Auth\Models\Role;
use LoanHistory\Modules\Auth\Models\User;
use LoanHistory\Modules\BaseRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;



class AuthRepository extends BaseRepository
{
    protected $jwtAuth;
    protected $userModel;
    protected $roleModel;

    public function __construct(JWTAuth $jwtAuth,
                                User $userModel,
                                Role $roleModel)
    {
        $this->jwtAuth = $jwtAuth;
        $this->userModel = $userModel;
        $this->roleModel = $roleModel;
    }

    public function login($credentials){

        try {
            $token = $this->jwtAuth->attempt($credentials);
            if (!$token){
                return $this->failResponse("Invalid Email or Password",422);
            }
        }catch (JWTException $exception){
            return $this->failResponse("Cannot generate access token",401);
        }

        $user = User::where("email", $credentials['email'])->first();
        // check if user is disabled

        if(auth()->user()->status == 'disable'){
            $this->jwtAuth->setToken($token)->invalidate(true);
            return $this->failResponse("Your account has been disabled",Response::HTTP_FORBIDDEN);
        }
        return [
            "user" => $user->load('wallet'),
            "token" => $token
        ];
    }



}
