<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Carbon\Carbon;

class Authorization
{
    /**
     * Handle permission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next, $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $res = new ApiController();

        $token = $request->header('Authorization');
        $user = User::where('api_token', $token)->first();

        // permission checking ...
        if($user->hasRole($role)){
            return $next($request);
        }

        else return $res->respondWithError('Permission Denied!');
    }
}
