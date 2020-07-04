<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Diary;

class HomeDiaryController extends Controller
{

    /**
     * 首页公开的日记
     * @param Diary $diary
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexList(Diary $diary)
    {
        $page = request("page");
        $par_page = request('par_page',5);
        $diary = $diary->where([
            'public' => 1,
            'status' => 1,
        ])->orderBy('created_at','desc')->paginate($par_page);

        $list = $diary->toArray();
        foreach ($list['data']  as $key => &$v){
            $v['avatar'] = $diary[$key]->userItem->avatar;
            $v['username'] = $diary[$key]->userItem->username;
        }

        $lists['lists'] = $list['data'];
        $lists['total'] = ceil($list['total']/$par_page);

        return api_success('',$lists);
    }


    public function getDetail()
    {
        $r_id = request('r_id');
        if (empty($r_id)) return api_error('缺少参数！');
        $diary = Diary::where('id',$r_id)->first();
        $diary['username'] = $diary->userItem->username;
        $diary['avatar'] = $diary->userItem->avatar;
        return  api_success('',$diary);
    }

}
