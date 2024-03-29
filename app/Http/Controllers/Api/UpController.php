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
	$log = '/www/wwwroot/xiucai_blog/';
	$this->git_pull_exec($log,'xiucai');
    }

    public function wenbin_git_pull()
    {
	    
	$log = '/www/wwwroot/wenbinsite';
	$this->git_pull_exec($log,'wenbin');
    }
    

    public function git_pull_exec($webPath,$name)
    {
        $this->_log(json_encode(shell_exec("whoami")));
    	$this->_log('--------------' . $name . '-------------');
    	//网站根目录绝对路径(以/结尾,如/www/wwwroot/website/)
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
    	$cmd = 'cd ' . $webPath . ' && sudo git pull 2>&1';
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

    public function push_baidu()
    {
	//$urls = array(
    	//	'https://www.ergouphp.com/2021/11/16/0/',
    	//	'https://www.ergouphp.com/2021/09/08/0/',
	//);
	$html = file_get_contents('http://www.ergouphp.com');
 
	$dom = new \DOMDocument();
	@$dom->loadHTML($html);
 
	// grab all the on the page
	$xpath = new \DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");

	$urlss = [];
 
	for ($i = 0; $i < $hrefs->length; $i++) {
       		$href = $hrefs->item($i);
       		$url = $href->getAttribute('href');
       		$urlss[] = $url;
	}
	//print_r($urlss);
	$urlsss = [];
	foreach($urlss as $url){
		if (strpos($url,'https://www.ergouphp.com/') !== false){
			$urlsss[] = $url;
		}
	}
	$c = bcdiv(count($urlsss),20);
	$j = 0;
	for($i = 0; $i < $c; $i++){
		for($j; $j < ($i * 20); $j++){

		}
	}
    }

    private function buid_baidu($urls)
    {

	$api = 'http://data.zz.baidu.com/urls?site=https://www.ergouphp.com&token=FZqnBRdmHO7v1LHp';
	$ch = curl_init();
	$options =  array(
    		CURLOPT_URL => $api,
    		CURLOPT_POST => true,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_POSTFIELDS => implode("\n", $urls),
    		CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	echo $result;

    }


}
