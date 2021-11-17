<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Versions;

class UpController extends Controller
{


    public function upImage()
    {
        $image = request()->file('file');
        if (empty($image)) return api_error('缺少参数');
        try {
            $image_url = uploadFile($image);
            return  imgAllUrl($image_url);
        }catch (\Exception $e){
            return api_error("上传错误",$e->getMessage());
        }

    }


    public function version()
    {
        $version=Versions::select('version_num','url','content')->find(1);

//        if (!empty($version->url)){
//            Cache::remember('version_code_img', 240 , function() use ($version) {
////                QrCode::format('png')->size(100)->generate($version->url,public_path('/upload/qrcode.png'));
//                QrCode::format('png')->size(100)->generate("http://admin.zhongkehongtai.cc/IPFS.html",public_path('/upload/qrcode.png'));
//            });
//        }

        $version['code_url'] = imgAllUrl('/qrcode.png');
        return api_success('',$version);
    }

    public function git_pull()
    {
	$this->_log('--------------');
	//网站根目录绝对路径(以/结尾,如/www/wwwroot/website/)
	$webPath = '/www/wwwroot/xiucai_blog/';
	//WebHook密钥信息
	$webHookSecret = '666666';
	 //以流的方式读取传输过来的json
	$body = file_get_contents("php://input");

	if (empty($body)) {
    		$this->_log('无输入');
		die;
	}
	//$this->_log($body);
	//json转换为array
	$body = json_decode($body, true);
	if ($webHookSecret !== $body['password']) {
    		$this->_log('签名签名错误');
		die;
	}
	//获取推送分支
	$branch = str_replace('refs/heads/', '', $body['ref']);
	//执行更新
	$cmd = 'cd ' . $webPath . ' && git pull 2>&1';
	$this->_log($cmd);
	// 执行命令
	$output = shell_exec($cmd);
	//输出执行结果
	$this->_log('执行结果:' . json_encode($output));
    }

    private function _log($str)
    {
	$str .= "\r\n";
	file_put_contents('/www/wwwroot/ergouphp.com/storage/logs/webhook.log', $str, FILE_APPEND | LOCK_EX);
    }


}
