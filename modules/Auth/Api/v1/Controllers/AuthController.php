<?php


namespace LoanHistory\Modules\Auth\Api\v1\Controllers;



use Illuminate\Support\Facades\Auth;
use LoanHistory\Modules\Auth\Api\v1\Repositories\AuthRepository;
use LoanHistory\Modules\BaseController;
use Illuminate\Http\Request;


class AuthController extends BaseController
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');
        $response = $this->authRepository->login($credentials);

        if (!isset($response['status_code'])) {
            return $this->success($response);
        }
        return $this->handleErrorResponse($response);
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


}
