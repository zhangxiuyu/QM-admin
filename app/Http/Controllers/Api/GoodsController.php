<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Support\Facades\Cache;

class GoodsController extends Controller
{

    private $cache_time = 10; //缓存时间

    public function getHomeGoods(Goods $goods)
    {
        $list = Cache::remember('getHomeGoods',$this->cache_time,function () use ($goods){
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
            return $list;
        });

        return api_success('',$list);
    }

    public function getOne(Goods $goods)
    {
        $goods_id = request('goods_id');
        $data = Cache::remember('getOne_'.$goods_id,$this->cache_time,function () use ($goods,$goods_id){
            $data = $goods->find($goods_id);
            $img = [];
            foreach ($data['pictures'] as $ke => $va){
                // 这里生成缩略图

                $img[] = [
                    'id' => $ke,
                    'img' => getImg($va),
                ];
            }
            $data['img'] = $img;
            return $data;
        });

        return api_success('',$data);
    }


    public function getGoodsList(Goods $goods)
    {
        $type_id = request('type_id');
        $fid = request('fid');
        if (!empty($fid)){
            $list = Cache::remember('getGoodsList_'.$fid,$this->cache_time,function () use ($goods,$fid){
                $data = $goods->where([
                    'ftype' => $fid,
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
                return $list;
            });

        }else{
            $list = Cache::remember('getGoodsList_type_'.$type_id,$this->cache_time,function () use ($goods,$type_id){
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
                return $list;
            });
        }

        return api_success('',$list);
    }


    public function getSearchGoods(Goods $goods)
    {
        $s_name = request('s_name');
        $data = $goods->where('name','like' , "%".$s_name."%")->where(['status' => 1])->limit(100)->get();
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
