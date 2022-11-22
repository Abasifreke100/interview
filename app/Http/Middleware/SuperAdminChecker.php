<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LoanHistory\Modules\Auth\Models\Role;

class SuperAdminChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $superAdmin = Role::where("slug","super_admin")->first();

        if(!$user)
            return response()->json(["status"=>"error", "message"=>"Unauthenticated"],401);

        if($user->role_id != $superAdmin->id){
            return response()->json(["status"=>"error", "message"=>"User is not a superAdmin user"],401);
        }

        return $next($request);
    }
}
