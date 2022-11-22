<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LoanHistory\Modules\Auth\Models\Role;

class AdminChecker
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

        $admin = Role::where("slug","admin")->first();

        if(!$user)
            return response()->json(["status"=>"error", "message"=>"Unauthenticated"],401);


        if($user->role_id != $admin->id){
            return response()->json(["status"=>"error", "message"=>"User is not an admin user"],403);
        }

        return $next($request);

    }
}
