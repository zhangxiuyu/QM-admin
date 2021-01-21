<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\UserItems;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class UserController extends Controller
{

    public function login()
    {
        $phone = request('phone');
        $password = request('password');
        $useritems = UserItems::where('phone',$phone)->first();
        if (empty($useritems)) return api_error('登录错误！');

        if ($useritems->password != $password) return api_error('密码错误！');
        try {

            $payload = JWTFactory::customClaims(['sub' => $useritems])->make();

            $token = JWTAuth::encode($payload)->get();
            unset($useritems->password);
            return api_success('登录成功！', [
                'token' => $token,
                'user' => $useritems
            ]);

        } catch (\Exception $e) {
            return api_error('登陆失败！');
        }
    }


    /**
     *  手办项目用户
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCode()
    {
        $code = request('code');
        $username = request('username');
        $avatar = request('avatarUrl');
        if (empty($code)) {
            return api_error('缺少参数！');
        }
        $appId = 'wx67110bd6dbd629e5';
        $appSecret = '4993acd974cc5f7c2c7f5905e2f50afc';


        // 获取 access_token
//        $access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$appSecret}";
//        $access_token_array = get_curl($access_token_url,[]);
//        $access_token = $access_token_array['access_token'];

        // 获取用户openid
        $codeSession_url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appId}&secret={$appSecret}&js_code={$code}&grant_type=authorization_code";
        $codeSession_array = get_curl($codeSession_url, []);
        $openid = !empty($codeSession_array['openid']) ? $codeSession_array['openid'] : '';

        try {
            if (!empty($openid)) {
                // 创建用户
                $useritems = UserItems::firstOrCreate(['openid' => $openid], [
                    'openid' => $openid,
                    'username' => $username,
                    'avatar' => $avatar,
                ]);
                $payload = JWTFactory::customClaims(['sub' => $useritems])->make();

                $token = JWTAuth::encode($payload)->get();
                return api_success('注册成功！', $token);
            }

        } catch (\Exception $e) {
            return api_error('注册失败！');
        }


    }


    /**
     * 日记项目
     * @return \Illuminate\Http\JsonResponse
     */
    public function diaryUserCode()
    {
        $code = request('code');
        $username = request('username');
        $avatar = request('avatarUrl');
        if (empty($code)) {
            return api_error('缺少参数！');
        }
        $appId = 'wxb7b38aed3b5fb574';
        $appSecret = '0baa0fa266819ef7397d1dfab036be75';


        // 获取 access_token
//        $access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$appSecret}";
//        $access_token_array = get_curl($access_token_url,[]);
//        $access_token = $access_token_array['access_token'];

        // 获取用户openid
        $codeSession_url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appId}&secret={$appSecret}&js_code={$code}&grant_type=authorization_code";
        $codeSession_array = get_curl($codeSession_url, []);
        $openid = !empty($codeSession_array['openid']) ? $codeSession_array['openid'] : '';

        try {
            if (!empty($openid)) {
                // 创建用户
                $useritems = UserItems::firstOrCreate(['openid' => $openid], [
                    'openid' => $openid,
                    'username' => $username,
                    'avatar' => $avatar,
                ]);
                $payload = JWTFactory::customClaims(['sub' => $useritems])->make();

                $token = JWTAuth::encode($payload)->get();
                return api_success('注册成功！', [
                    'token' => $token,
                    'user_id' => $useritems->id
                ]);
            }

        } catch (\Exception $e) {
            return api_error('注册失败！');
        }


    }


    public function userCodedata()
    {
        return 111;
    }
}
