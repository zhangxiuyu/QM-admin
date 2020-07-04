<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Support\Facades\Cache;

class GoodsController extends Controller
{

    private $cache_time = 10; // 缓存时间

    private $add_prices = 45; // 加的金额

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
            )->limit(60)->get();
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

    /**
     * 首页商品-有分页
     * @param Goods $goods
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGoodsPage(Goods $goods)
    {
        $lists = Cache::remember('getHomeGoods_'. request('page'),$this->cache_time,function () use ($goods){
            $per_page = request('per_page',6);
            $list = $goods->where([
                'top'=>1,
            ])->select(
                'id',
                'name',
                'prices',
                'pictures'
            )->paginate($per_page)->toArray();
            foreach ($list['data'] as &$value){
                $pictures=[];
                foreach ($value['pictures'] as $ke => $v){
                    $pictures[$ke] = getenv('APP_URL').'/upload/'.$v;
                }
                unset($value['pictures']);
                $value['img'] = empty($pictures[0])?'':$pictures[0];
//                $value['slogan'] = '指导价：'.($value['prices'] + $this->add_prices);
                $value['slogan'] = '';
            }
            $lists['lists'] = $list['data'];
            $lists['total'] = ceil($list['total'] / $per_page);
            return $lists;
        });

        return api_success('',$lists);
    }

    public function getOne(Goods $goods)
    {
        $goods_id = request('goods_id');
        $data = Cache::remember('getOne_'.$goods_id,$this->cache_time,function () use ($goods,$goods_id){
            $data = $goods->find($goods_id);
            $img = [];
            foreach ($data['pictures'] as $ke => $va){
                $img[] = [
                    'id' => $ke,
                    'img' => getImg($va),
                ];
            }
            $data['img'] = $img;
            $data['div'] = "<span style='color: orange'> 想要这个手办吗？ 请点击 《我的》->《联系秀秀》".$data['div'];
            return $data;
        });

        return api_success('',$data);
    }


    public function getGoodsListPage(Goods $goods)
    {
        $type_id = request('type_id');
        $fid = request('fid');
        $per_page = request('per_page',6);

        if (!empty($fid)){
            $lists = Cache::remember('getGoodsList_'.$fid.'_'.request('page'),$this->cache_time,function () use ($goods,$fid,$per_page){

                $data = $goods->where([
                    'ftype' => $fid,
                    'status' => 1,
                ])->paginate($per_page)->toArray();
                $list = [];
                foreach ($data['data'] as $var){
                    $list[] = [
                        'goods_id' => $var['id'],
                        'name' => $var['name'],
                        'price' => $var['prices'],
//                        'slogan' => '',
                        'slogan' => '指导价：'.($var->prices + $this->add_prices),
                        'img' => !empty($var['pictures'][0])?getImg($var['pictures'][0]):'',
                    ];
                }
                $lists['lists'] = $list;
                $lists['total'] = ceil($data['total'] / $per_page);
                return $lists;
            });

        }else{
            $lists = Cache::remember('getGoodsList_type_'.$type_id.'_'.request('page'),$this->cache_time,function () use ($goods,$type_id,$per_page){
                $data = $goods->where([
                    'type' => $type_id,
                    'status' => 1,
                ])->paginate($per_page)->toArray();
                $list = [];
                foreach ($data['data'] as $var){
                    $list[] = [
                        'goods_id' => $var['id'],
                        'name' => $var['name'],
                        'price' => $var['prices'],
//                        'slogan' => '',
                        'slogan' => '指导价：'.($var->prices + $this->add_prices),
                        'img' => !empty($var['pictures'][0])?getImg($var['pictures'][0]):'',
                    ];
                }
                $lists['lists'] = $list;
                $lists['total'] = ceil($data['total'] / $per_page);
                return $lists;
            });
        }

        return api_success('',$lists);
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
//                        'slogan' => '',
                        'slogan' => '指导价：'.($var->prices + $this->add_prices),
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
//                        'slogan' => '',
                        'slogan' => '指导价：'.($var->prices + $this->add_prices),
                        'img' => !empty($var->pictures[0])?getImg($var->pictures[0]):'',
                    ];
                }
                return $list;
            });
        }

        return api_success('',$list);
    }


    /**
     * 商品搜索
     * @param Goods $goods
     * @return \Illuminate\Http\JsonResponse
     */
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
//                'slogan' => '',
                'slogan' => '指导价：'.($var->prices + $this->add_prices),
                'img' => !empty($var->pictures[0])?getImg($var->pictures[0]):'',
            ];
        }
        return api_success('',$list);
    }


}
