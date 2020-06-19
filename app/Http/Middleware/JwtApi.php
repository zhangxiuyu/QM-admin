<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
class JwtApi
{
    /**
     * JWT 中间件
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @author zhenhong~
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('authorization');

        try {
            $userInfo = JWTAuth::setToken($token)->getPayload()->get('sub');

            $request->attributes->add(['user_info' => $userInfo]);

            return $next($request);
        } catch (TokenExpiredException $e) {		//	JWT 提供的token时间过期异常类
            return api_response(202, $data = [], '验证失败，token过期');
        } catch (JWTException $e) {		            //	JWT 提供的token无效异常类
            return api_response(202, $data = [], '验证失败, token无效');
        }
    }
}
