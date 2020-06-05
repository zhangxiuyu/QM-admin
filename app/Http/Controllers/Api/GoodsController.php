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

    public function getOne(Goods $goods)
    {
        $goods_id = request('goods_id');
        $data = $goods->find($goods_id);
        $img = [];
        foreach ($data['pictures'] as $ke => $va){
            $img[] = [
                'id' => $ke,
                'img' => getImg($va),
            ];
        }
        $data['img'] = $img;
        return api_success('',$data);
    }


    public function getGoodsList(Goods $goods)
    {
        $type_id = request('type_id');
        $data = $goods->where([
            'type' => $type_id,
            'status' => 1,
        ])->limit(100)->get();
        $list = [];
        foreach ($data as $var){
            $list[] = [
              'goods_id' => $var->id,
              'name' => $var->name,
              'price' => $var->prices,
              'slogan' => '',
              'img' => !empty($var->pictures[0])?getImg($var->pictures[0]):'',
            ];
        }

        return api_success('',$list);
    }


}
