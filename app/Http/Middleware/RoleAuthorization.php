<?php

namespace App\Http\Middleware;

use App\Utils\ResponseCode;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
{
    try {
        //Access token from the request        
        $token = JWTAuth::parseToken();
        //Try authenticating user       
        $user = $token->authenticate();
    } catch (TokenExpiredException $e) {
        //Thrown if token has expired        
        return $this->unauthorized('Your token has expired. Please, login again.');
    } catch (TokenInvalidException $e) {
        //Thrown if token invalid
        return $this->unauthorized('Your token is invalid. Please, login again.');
    }catch (JWTException $e) {
        //Thrown if token was not found in the request.
        return $this->unauthorized('Please, attach a Bearer Token to your request');
    }
    //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
    if ($user && in_array($user->role, $roles)) {
        // dd($user->role);
        return $next($request);
    }

    return $this->unauthorized();
}

private function unauthorized($message = null){
    return ResponseCode::unauthorized($message);
}
}
