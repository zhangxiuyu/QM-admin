<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\GoodsType;

class GoodsTypeController extends Controller
{

    public function getGoodsType(GoodsType $goodsType)
    {
        $goodsType = $goodsType->where([
            'pid' => null,
            'status' => 1,
        ])->get();
        $list = [];

        foreach ($goodsType as $good){
            $list[] = [
                'id' => $good->id,
                'title' => $good->name,
                'banner' => '',
                'list' => $this->getXGoodsType($good->id),
            ];
        }

        return api_success('',$list);
    }

    protected function getXGoodsType($pid)
    {
        $goodsType = new GoodsType();
        $lists = $goodsType->where('pid',$pid)->get();
        $list = [];
        foreach ($lists as $va){
            $list[] = [
              'id' => $va->id,
              'name' => $va->name,
              'img' => getImg($va->img),
            ];
        }
        return $list;
    }
}
