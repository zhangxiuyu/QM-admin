<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return '测试中， 请稍后访问！ QQ联系：1292460369';
        $url =  'http://qqsmfz.com/index.php';
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $refer = 'http://qqsmfz.com/index.php';
        //伪造来源refer
        curl_setopt($ch, CURLOPT_REFERER, $refer);
        $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";//模拟windows用户正常访问
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array());

        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Cookie:' . 'sec_defend=0130543bdcf52edefe2dadd241f85ae1056f9f99fe09c3df44313bab723fac44;',
        //     'Accept:*/*',
        //     'Host: qqsmfz.com',
        //     'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
        //     'X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()
        // ]);
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cookie: PHPSESSID=5i9665483po0q8a136qrrlqvkl; mysid=a29f7f87f004998d9b94bd6e298c6446; sec_defend=0130543bdcf52edefe2dadd241f85ae14684d86282cf224d89d3d1fd269c5330; counter=12',
            'Host: qqsmfz.com',
            'Referer: http://qqsmfz.com/index.php',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
            'X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()
        ]);
        $lines_string = curl_exec($ch);
        curl_close($ch);
        $str = substr($lines_string,strpos($lines_string,"<剩余料子：") + strlen('<剩余料子：'),3);
        $str = str_replace('>','',$str);
        return $str;
});

     function Rand_IP()
    {
        $ip2id= round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
        $ip3id= round(rand(600000, 2550000) / 10000);
        $ip4id= round(rand(600000, 2550000) / 10000);
        //下面是第二种方法，在以下数据中随机抽取
        $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
        $randarr= mt_rand(0,count($arr_1)-1);
        $ip1id = $arr_1[$randarr];
        return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
    }
