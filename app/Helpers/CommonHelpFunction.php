<?php
/*
 *  api 数据返回方法
 *  @author zhenhong~
 *  @param string/int code 状态
 *  @param array  data 数据
 *  @param String message 文字
 *
 */
if (!function_exists('api_response')) {
    function api_response($code = 200, $data = [], $message = '')
    {
        return response()->json([
            'code' => $code,
            'data' => $data ?: [],
            'message' => $message ?: ''
        ]);
    }
}

if (!function_exists('api_success')) {
    function api_success($message = '成功！', $data = [], $code = 200)
    {
        return api_response($code, $data, $message);
    }
}

if (!function_exists('api_error')) {
    function api_error($message = '失败！', $data = [], $code = 201)
    {
        return api_response($code, $data, $message);
    }
}




if (!function_exists('objectToArray')) {
    function objectToArray($e)
    {
        $e = (array) $e;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'resource') return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = (array) objectToArray($v);
        }
        return $e;
    }
}

if (!function_exists('delCache')) {
    function delCache($category_id)
    {
        if (empty($category_id)) return;
        $redis = app('redis.connection');
        $redis->del('data_page_' . $category_id, null);
    }
}

/**
 * 半路径 返回 全路径
 */
if (!function_exists('getImg')) {
    function getImg($img){
        if (empty($img)) return '';
        if (substr($img, 0,1) == '/'){
            return getenv('APP_URL').'/upload' . $img;
        }else{
            return getenv('APP_URL').'/upload/' . $img;
        }
    }
}

/**
 *  生成缩略图
 */
if (!function_exists('slImg')) {
    function slImg($img){
        if (empty($img)) return '';
        // 生成订单



    }
}


if (!function_exists('tranTime')){
    function tranTime($time) {
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);

        $time = time() - $time;

        if ($time < 60) {
            $str = '刚刚';
        }elseif ($time < 60 * 60) {
            $min = floor($time/60);
            $str = $min.'分钟前';
        }elseif ($time < 60 * 60 * 24) {
            $h = floor($time/(60*60));
            $str = $h.'小时前 '.$htime;
        }elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time/(60*60*24));
            if($d==1)
                $str = '昨天 '.$rtime;
            else
                $str = '前天 '.$rtime;
        }else {
            $str = $rtime;
        }
        return $str;
    }
}



/*
 *  写入日志数据
 *  @author zhenhong~
 *  @param string file_name 文件名称
 *  @param string directory 文件夹名称
 *  @param array/string data 数据
 *
 */
if (!function_exists('write_log')) {
    function write_log($data, String $file_name, String $directory = '')
    {
        $basePath = './../storage/logs/';

        $path = $directory ? $basePath . $directory : $basePath;

        $content = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;

        $name = $file_name ? $file_name : date('Y_m_d_H_i_s') . '.txt';

        $file = $path . $name;

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        file_put_contents($file, $content);

        return true;
    }
}

/**
 *  发送 curl 请求
 *  @author zhenhong~
 *  @param  string  url     请求地址
 *  @param  array   data    数组
 *  @param  string  type    类型 （GET,POST）
 *  @param  string  header  请求头
 */
if (!function_exists('get_curl_request')) {
    function get_curl($url, $data, $type = 'GET', $header = '')
    {
        $curl = curl_init();
        //  抓取url
        curl_setopt($curl, CURLOPT_URL, $url);

        //  设置请求头数据格式
        if (!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        //  设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // 禁用后cURL将终止从服务端进行验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // 检查服务器SSL证书中是否存在一个公用名,检查公用名是否存在，并且是否与提供的主机名匹配
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        //  设置请求的最长时间
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        // 判断请求是否是post请求
        if ($type == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        //  发送curl 请求
        $outPut = curl_exec($curl);
        //  返回最后一次的错误号
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        //  关闭url请求
        curl_close($curl);

        return json_decode($outPut, true);
    }
}

/**
 * 获取时间
 */
if (!function_exists('myDate')) {
    function myDate()
    {
       return date("Y-m-d H:i:s",time());
    }
}

/**
 * 创建订单号
 */
if (!function_exists('trade_no')) {
    function trade_no()
    {
        list($usec, $sec) = explode(" ", microtime());
        $str = rand(1000, 9999);
        return date("YmdHis") . $str;
    }
}
/**
 * 时间戳转换**分钟前
 */
if (!function_exists('time_ago')) {
    function time_ago($posttimes)
    {
        //当前时间的时间戳
        $nowtimes = strtotime(date('Y-m-d H:i:s'), time());
        //之前时间参数的时间戳
        $posttime = date('Y-m-d', $posttimes);
        //相差时间戳
        $counttime = $nowtimes - $posttimes;

        //进行时间转换
        if ($counttime <= 60) {

            return '刚刚';

        } else if ($counttime > 60 && $counttime < 3600) {

            return intval(($counttime / 60)) . '分钟前';

        } else if ($counttime >= 3600 && $counttime < 3600 * 24) {

            return intval(($counttime / 3600)) . '小时前';

        } else {

            return $posttime;

        }
    }
}
/**
 * 上传图片 返回路径
 */
if (!function_exists('uploadFile')) {
    function uploadFile($file,$file_path='public') {
        $fileextension=$file->getClientOriginalExtension();
        $file_name=sp_random_string(10).'.'.$fileextension;
        $path=$file->move(public_path('upload').'/'.$file_path.'/'.date('Ymd'),$file_name);
        return ''.$file_path.'/'.date('Ymd').'/'.$file_name;
    }
}
/**
 * 获取随机字符
 */
if (!function_exists('sp_random_string')) {
    function sp_random_string($len = 6) {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);    // 将数组打乱
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }
}

if (!function_exists('imgAllUrl')) {
    function imgAllUrl($img_url=''){
        if (empty($img_url)) return '';
        if (substr($img_url, 0,4) == 'http'){
            return $img_url;
        }else if (substr($img_url, 0,1) == '/'){
            return env('APP_URL') . '/upload'. $img_url;
        }else{
            return env('APP_URL') .'/upload/'. $img_url;
        }
    }
}
