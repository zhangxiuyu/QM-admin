<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\ConfigImg;
use App\Model\GoodsType;
use Illuminate\Support\Facades\Cache;

class HomeImgController extends Controller
{
    private $cache_time = 2024; //缓存时间

    public function banner(ConfigImg $configImg)
    {
        $data = Cache::remember('banner',$this->cache_time,function () use ($configImg) {
            $data = $configImg->where([
                'status' => 1,
                'type' => 1,
            ])->orderBy('sort','desc')->select('img')->get();
            foreach ($data as &$va){
                $va['img'] =  getenv('APP_URL').'/upload/'.$va['img'];
            }
            return $data;
        });

        return api_success('',$data);
    }


    public function getXiao(GoodsType $goodsType)
    {
        $data = Cache::remember('getXiao',$this->cache_time,function () use ($goodsType) {
            $data = $goodsType->where([
                'status' => 1,
                'pid' => null,
            ])->orderBy('sort','desc')->select('id','img','name')->get();
            foreach ($data as &$va){
                $va['img'] = getenv('APP_URL').'/upload/'.$va['img'];
            }
            return $data;
        });

        return api_success('',$data);
    }

}
