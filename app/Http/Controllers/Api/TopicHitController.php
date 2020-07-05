<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\TopicHit;

class TopicHitController extends Controller
{


    /**
     * 点赞 取消点赞
     * @param Request $request
     * @param TopicHit $topicHit
     * @return \Illuminate\Http\JsonResponse
     */
    public function hit(Request $request)
    {
        $user = $request->attributes->get('user_info');
        $topic_id = $request->get('topic_id');
        $is = $request->get('is');
        TopicHit::updateOrCreate([
            'uid' => $user->id,
            'topic_id' => $topic_id,
        ],[
            'is' => $is
        ]);
        return api_success('');
    }


}