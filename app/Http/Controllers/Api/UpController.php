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

}
