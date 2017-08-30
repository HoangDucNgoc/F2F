<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Carbon\Carbon;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if($token)
        {
            $user = User::where('api_token', $token)->first();
            if($user)
            {
                $currentDate = Carbon::now('Asia/Ho_Chi_Minh');
                $expiredDate = $user->expired_date;

                if($expiredDate->gte($currentDate))
                {
                    return $next($request);
                }
                
                else return response()->json(['message' => 'Authorization failed! Your token is out of date!'], 404);
            }           
            else return response()->json(['message' => 'Authorization failed! Your token is not match!'], 404);
        }
        else return respondWithError('Unauthenticated!');


    }
}
