<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userCode()
    {
        $code = request('code','011v9ZCr1IgRei0kvZCr1mhZCr1v9ZCF');
        if (empty($code)) {
            return api_error('缺少参数！');
        }
        $appId = 'wx67110bd6dbd629e5';
        $appSecret = '4993acd974cc5f7c2c7f5905e2f50afc';

        //oauth2的方式获得openid
        //https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code
//        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appId."&secret=".$appSecret."&code=$code&grant_type=authorization_code";
        $access_token_url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appId."&secret=".$appSecret."&js_code=".$code."&grant_type=authorization_code";
        $access_token_array =get_curl($access_token_url,[]);
        return $access_token_array;
        $openid = $access_token_array['openid'];
        $access_token= $access_token_array['session_key'];
        //全局access token获得用户基本信息
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo =get_curl($userinfo_url,[]);

        return $userinfo;
        // 创建用户
//        $useritem = UserItems::firstOrCreate(['openid' => $userinfo['unionid']], ['openid' => $userinfo['unionid'], 'nickname' => $userinfo['nickname'], 'avatar' => $userinfo['headimgurl'], 'created_at' => time()]);
//        $payload = JWTFactory::customClaims(['sub' => $useritem])->make();

    }
}
