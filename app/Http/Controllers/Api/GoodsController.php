<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Goods;

class GoodsController extends Controller
{

    public function getHomeGoods(Goods $goods)
    {
        $list = $goods->where([
            'top'=>1,
        ])->select(
            'id',
            'name',
            'prices',
            'pictures'
        )->limit(40)->get();
        foreach ($list as &$value){
            $pictures=[];
            foreach ($value->pictures as $ke => $v){
                $pictures[$ke] = getenv('APP_URL').'/upload/'.$v;
            }
            unset($value['pictures']);
            $value['img'] = empty($pictures[0])?'':$pictures[0];
        }
        return api_success('',$list);
    }

}
