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
