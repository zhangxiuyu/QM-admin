<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\UserItems;

class UserController extends Controller
{
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
        $codeSession_array = get_curl($codeSession_url,[]);
        $openid = !empty($codeSession_array['openid'])?$codeSession_array['openid']:'';

//        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
//        $userinfo =get_curl($userinfo_url,[]);
//return  $userinfo;



        // 创建用户
//        $useritem = UserItems::firstOrCreate(['openid' => $userinfo['unionid']], ['openid' => $userinfo['unionid'], 'nickname' => $userinfo['nickname'], 'avatar' => $userinfo['headimgurl'], 'created_at' => time()]);
//        $payload = JWTFactory::customClaims(['sub' => $useritem])->make();
//        try {
        if (!empty($openid)){
            $useritems = UserItems::firstOrCreate(['openid'=> $openid],[
                'openid' => $openid,
                'username' => $username,
                'avatar' => $avatar,
            ]);
//            $token = auth('api')->attempt($useritems);
            return api_success('注册成功！');
        }

//        }catch (\Exception $e){
//            return api_error('注册失败！');
//        }


    }
}