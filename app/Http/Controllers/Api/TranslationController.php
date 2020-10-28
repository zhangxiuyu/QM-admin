<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Yan\Translate\TranslateManager;

class TranslationController extends Controller
{

    public function tranTest()
    {
// vendor/mouyong/translate/src/Providers/JinShanProvider.php
// 'dst' => $response['content']['out'] ?? '',



//        $sl = 'zh-CN';
//        $tl = $to;
//        $tl = $to;
//        try {
//            $GoogleClient = $client->request('GET','https://translate.google.cn/translate_a/single',[
//                'query' => [
//                    'client'=> 'webapp',
//                    'sl'=> 'zh-CN',
//                    'tl'=> $to,
//                    'hl'=> 'zh-CN',
//                    'dt'=> 't',
//                    'ssel'=> 5,
//                    'tsel'=> 5,
//                    'kc'=> 1,
//                    'tk'=> 552358.960117,
//                    'q'=> urlencode('天马之星')
//                ],
//                'allow_redirects' => false
//            ]);

        $endata = [
            0 => 'zh',
            1 => 'en',
            2 => 'ru',
        ];
        $text = request('text');
        $th = request('th');
        $to = request('to');
        $th = empty($endata[$th])?$endata[0]:$endata[$th];
        $to = empty($endata[$to])?$endata[0]:$endata[$to];
        if (empty($text)) return
            api_success('',[
                'google' => '',
                'baidu' => '',
                'youdao' => '',
                'qianci' => '',
                'jinshan' => '',
            ]);
        $config = [
            'default' => 'google',

            'drivers' => [
                // 留空
                'google' => [
                    'app_id' => '',
                    'app_key' => '',
                ],

                'baidu' => [
                    'ssl' => true,
                    'app_id' => '20201028000600594',
                    'app_key' => '2zUYeH3JEkOlxrIQoxtM',
                ],

                'youdao' => [
                    'ssl' => false,
                    'app_id' => '6400a5d76ce4b2f4',
                    'app_key' => 'TkUyJjRIf8OkFapU7umm8ufIC5qAtdNk',
                ],

                // 留空
                'jinshan' => [
                    'app_id' => '',
                    'app_key' => '',
                ]
            ],
        ];
//        return [
//            $text,$th,$to
//        ];

        $translate = new TranslateManager($config);

        $googleresult = $translate->driver('google')->translate($text, $th, $to);
        $baiduresult = $translate->driver('baidu')->translate($text, $th, $to);
        $youdaoresult = $translate->driver('youdao')->translate($text, $th, $to);
        $jinshanresult = $translate->driver('jinshan')->translate($text, $th, $to);


        $client = new Client(['base_uri' => 'https://w.qianyix.com/']);
        $client = $client->request('POST', 'index.php?r=site/translate',[
            'form_params' => [
                'src' => "$text",
                'f' => 'autozhru',
                't' => 'autozhru',
            ]
        ]);
        return api_success('',[
            'google' => $googleresult->getDst(),
            'baidu' => $baiduresult->getDst(),
            'youdao' => empty($youdaoresult->getDst()[0])?'':$youdaoresult->getDst()[0],
            'jinshan' => $jinshanresult->getDst(),
            'qianci' => $client->getBody()->getContents(),
        ]);
//        var_dump($result->getSrc());
//        var_dump($result->getDst());
//        var_dump($result->getOriginal());




//        $googleTrans = new GoogleTranslate();
//
////This message can capture package `translate.google.com ` get
////这些信息都可以抓 `translate.google.com ` 获取
//        $source = 'zh-CN';//Source language, 源语言
//        $target = $to;//Target language, 目标语言
//
//        $text = '好的，谷歌！';
//
////if $type='cn' use 'translate.google.cn' API elseif $type='intl' use 'translate.google.com' API
////default use 'translate.google.com' API
//        $result = $googleTrans->translate($source, $target, $text, $type='cn');
//
//        return $result;

//        $data = [];
//        $client = new Client();
//        $sl = 'zh-CN';
//        $tl = $to;
//        $tl = $to;
//        try {
//            $GoogleClient = $client->request('GET','https://translate.google.cn/translate_a/single',[
//                'query' => [
//                    'client'=> 'webapp',
//                    'sl'=> 'zh-CN',
//                    'tl'=> $to,
//                    'hl'=> 'zh-CN',
//                    'dt'=> 't',
//                    'ssel'=> 5,
//                    'tsel'=> 5,
//                    'kc'=> 1,
//                    'tk'=> 552358.960117,
//                    'q'=> urlencode('天马之星')
//                ],
//                'allow_redirects' => false
//            ]);
//            if (!empty(json_decode($GoogleClient->getBody(),true)[0][0][0])){
//                $data['google_str'] = json_decode($GoogleClient->getBody(),true)[0][0][0];
//            }else{
//                $data['google_str'] = '';
//            }
//        }catch (\Exception $exception){
//            $data['google_str'] = ''.$exception->getMessage();
//        }
//
//        return $data;

    }
}
