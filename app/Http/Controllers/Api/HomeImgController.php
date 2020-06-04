<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\ConfigImg;

class HomeImgController extends Controller
{

    public function banner(ConfigImg $configImg)
    {
        $data = $configImg->where([
            'status' => 1,
            'type' => 1,
        ])->orderBy('sort','desc')->select('img')->get();
        foreach ($data as &$va){
            $va['img'] =  getenv('APP_URL').'/upload/'.$va['img'];
        }
        return api_success('',$data);
    }


    public function getXiao(ConfigImg $configImg)
    {
        $data = $configImg->where([
            'status' => 1,
            'type' => 2,
        ])->orderBy('sort','desc')->select('img','name')->get();
        foreach ($data as &$va){
            $va['img'] = getenv('APP_URL').'/upload/'.$va['img'];
        }
        return api_success('',$data);
    }

}
