<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiaryController extends Controller
{

    public function diaryList(Request $request,Diary $diary)
    {
        $page = request('page',1);
        $last_page = request('last_page',2); // 获取两天的
        $user = $request->attributes->get('user_info');

        // 这里要分页，先获取时间列表
        $diaryList = DB::select("SELECT DATE_FORMAT(created_at,'%Y-%m-%d') as date from  diary where user_id = {$user->id} AND deleted_at IS NULL GROUP BY DATE_FORMAT(created_at,'%Y-%m-%d')");
        // 总页数
        $total = ceil(count($diaryList) / $last_page);
        if ($page > $total) $page = $total;

        // 开始数
        $s_page = ($page-1) * $last_page;
        // 结束数
        $e_page = $page * $last_page;

        $list = [];
        for ($i=$s_page;$i<$e_page;$i++){
            $list[] = [
              'diary_date' => $diaryList[$i]->date,
              'list' => Db::select("SELECT DATE_FORMAT(created_at,'%H:%i:%s') as created_at,id,title FROM diary WHERE ( datediff ( created_at ,'{$diaryList[$i]->date}') = 0 ) AND user_id = {$user->id} AND deleted_at IS NULL")
            ];
        }

        return api_success('',$list);
    }




    /**
     * 获取日记详情
     * @param Diary $diary
     * @return \Illuminate\Http\JsonResponse
     */
    public function diaryGet(Diary $diary)
    {
        $diary = $diary->where('id',request('diary_id'))->first();
        return api_success('',$diary);
    }

    /**
     * 添加日记
     * @param Request $request
     * @param Diary $diary
     * @return \Illuminate\Http\JsonResponse
     */
    public function diaryAdd(Request $request, Diary $diary)
    {
        try {
            $user = $request->attributes->get('user_info');
            $diary->user_id = $user->id;
            $diary->html = request('html');
            $diary->title = request('title');
            $diary->save();
            return api_success();
        } catch (\Exception $e) {
            return api_error('添加失败！');
        }
    }

    /**
     * 修改日记
     * @param Request $request
     * @param Diary $diary
     */
    public function diaryEdit(Request $request, Diary $diary)
    {
        try {

            $user = $request->attributes->get('user_info');
            $diary_id = request('diary_id');
            $diary = $diary->where([
                'id' => $diary_id,
                'user_id' => $user->id
            ])->first();
            if (empty($diary)) return api_error('修改失败，未找到您的日记');
            $diary->html = request('html');
            $diary->title = request('title');
            $diary->update();
            return api_success('修改成功!！');
        } catch (\Exception $e) {
            return api_error('修改失败！');
        }
    }

    public function diaryDel(Request $request, Diary $diary)
    {

        try {
            $diary_id = request('diary_id');
            $user = $request->attributes->get('user_info');
            $diary = $diary->where([
                'id' => $diary_id,
                'user_id' => $user->id
            ])->first();
            if (empty($diary)) return api_error('删除失败，未找到您的日记');

            $diary->where([
                'id' => $diary_id,
                'user_id' => $user->id
            ])->delete();
            return api_success('删除成功');
        } catch (\Exception $e) {
            return api_error('删除失败！');
        }

    }

}
