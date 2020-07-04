<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Topic;
use Illuminate\Http\Request;


class TopicController extends Controller
{


    public function reviewList(Request $request,Topic $topic)
    {
        $per_page = request('per_page',6);
        $r_id = $request->get('r_id');
        $topicList = $topic->where([
            'r_id' => $r_id,
            'huid' => null
        ])->paginate($per_page);
        $list = [];


        // 关联用户 对象
        foreach ($topicList as $value){
            $list[] = [
              'post_id' => $value->id
            ];
        }
        $lists['lists'] = $list;
        $lists['total'] = ceil($topicList->total() / $per_page);

        return api_success('',$lists);
    }


    public function reviewAdd(Request $request,Topic $topic)
    {
        $user = $request->attributes->get('user_info');

        try {
            $topic->r_id = $request->get('r_id');
            $topic->huid = $request->get('huid'); // 回复人的用户id
            $topic->top_con = $request->get('top_con');
            $topic->uid = $user->id;
            $topic->save();
            return api_success('评论成功！');
        }catch (\Exception $e){
            return  api_error('评论失败！');
        }
    }



}
