<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Topic;
use App\Model\TopicHit;
use Illuminate\Http\Request;


class TopicController extends Controller
{


    /**
     * 评论列表
     * @param Request $request
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviewList(Request $request,Topic $topic)
    {
        $per_page = request('per_page',6);
        $r_id = $request->get('r_id');
        $user_id = $request->get('user_id');
        $topicList = $topic->where([
            'r_id' => $r_id,
            'huid' => null,
            'p_id' => null,
        ])->paginate($per_page);
        $list = [];
//        $user = $request->attributes->get('user_info');


        // 关联用户 对象
        foreach ($topicList as $value){
            $list[] = [
              'post_id' => $value->id,
              'uid' => $value->uid,
              'username' => $value->userItem->username,
              'header_image' => $value->userItem->avatar,
              'content' => [
                  'text' => $value->top_con,
                  'images' => []
              ],
                'islike' => empty($user_id)?0:$this->islike($user_id,$value->id), //自己是否点赞
                'like' => $this->hit($value->id), // 获取点赞人
                'comments' => [
                    'total' => 0,
                    'comment' => $this->pComment($value->id),
                ],
                'timestamp' => tranTime(strtotime($value->created_at))

            ];
        }
        $lists['lists'] = $list;
        $lists['total'] = ceil($topicList->total() / $per_page);

        return api_success('',$lists);
    }

    /**
     * 评论 评论的数据
     * @param $pid int 评论id
     * @return array
     */
    public function pComment($pid)
    {
        $topic = new Topic();
        $data = $topic->where('p_id',$pid)->get();
        $list = [];
        foreach ($data as $va){
            $list[] = [
                'uid' => $va->uid,
                'username' => $va->userItem->username,
                'content' => $va->top_con
            ];
        }
        return $list;
    }

    /**
     * 是否点赞过评论
     * @param $user_id int 用户id
     * @param $topic_id int 评论id
     * @return int
     */
    public function islike($user_id,$topic_id)
    {
        $TopicHit = new  TopicHit();
        $data = $TopicHit->where([
            'topic_id' => $topic_id,
            'is' => 1,
            'uid' => $user_id,
        ])->first();
        return empty($data)?0:1;

    }

    /**
     * 获取点赞的人
     * @param $topic_id int 评论的id  为评论点赞
     * @param TopicHitController $topicHit
     * @return array
     */
    public function hit($topic_id)
    {
        $topicHit = new TopicHit();
        $list = $topicHit->where([
            'topic_id' => $topic_id,
            'is' => 1
        ])->select('uid')->get();
        $lists = [];
        foreach ($list as $value){
            $lists[] = [
                'uid' => $value->uid,
                'username' => $value->userItem->username
            ];
        }
        return $lists;
    }


    /**
     * 添加评论
     * @param Request $request
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviewAdd(Request $request,Topic $topic)
    {
        $user = $request->attributes->get('user_info');

        try {
            $topic->r_id = $request->get('r_id');
            $topic->p_id = $request->get('p_id');
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
