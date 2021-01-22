<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

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

}
